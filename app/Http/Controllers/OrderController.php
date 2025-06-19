<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\Seats;
use App\Models\Tickets;
use App\Models\Order;
use App\Models\User;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $matches = Matches::with(['homeTeam', 'awayTeam'])->get();
        $seats = Seats::with('area')->where('status', 'available')->get(); // hanya seat tersedia
        return view('order.index', compact('matches', 'seats'));
    }
    public function order(Request $request)
    {
        $request->validate([
            'match_id' => 'required|exists:matches,id',
            'seat_id' => 'required|exists:seats,id',
        ]);

        DB::beginTransaction(); 
        try {
            $seat = Seats::with('area')->lockForUpdate()->findOrFail($request->seat_id);
            if ($seat->status !== 'available') {
                DB::rollBack();
                return redirect()->back()->with('error', 'Seat sudah dipesan.');
            }

            $user = Auth::user() ?? User::where('role', 'user')->first();
            $orderNumber = 'ORDER-' . Str::uuid();

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'total_price' => $seat->area->price,
                'status' => 'pending',
                'payment_method' => 'midtrans',
            ]);

            $ticket = Tickets::create([
                'order_id' => $order->id,
                'match_id' => $request->match_id,
                'seat_id' => $seat->id,
                'status' => 'pending',
                'user_id' => $user->id,
                'booked_at' => now(),
                'payment_method' => 'midtrans',
            ]);

            $seat->update(['status' => 'booked']);

            DB::commit();

            // Midtrans config
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => $seat->area->price,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => [
                    [
                        'id' => $ticket->id,
                        'price' => $seat->area->price,
                        'quantity' => 1,
                        'name' => 'Tiket pertandingan #' . $request->match_id,
                    ],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return view('order.checkout', compact('snapToken', 'ticket'));
        } catch (\Exception $e) {
            DB::rollBack();
            // \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memesan tiket.');
        }
    }
    // public function order(Request $request)
    // {
    //     $request->validate([
    //         'match_id' => 'required|exists:matches,id',
    //         'seat_id' => 'required|exists:seats,id',
    //     ]);

    //     $seat = Seats::with('area')->findOrFail($request->seat_id);
    //     if ($seat->status !== 'available') {
    //         return redirect()->back()->with('error', 'Seat sudah dipesan.');
    //     }

    //     $user = Auth::user() ?? User::where('role', 'user')->first();

    //     // Generate order_number (order_id untuk midtrans)
    //     $orderNumber = 'ORDER-' . Str::uuid();

    //     // 1. Buat Order
    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'order_number' => $orderNumber, // <--- Tambah ini
    //         'total_price' => $seat->area->price,
    //         'status' => 'pending',
    //         'payment_method' => 'midtrans',
    //     ]);

    //     // 2. Buat Tiket
    //     $ticket = Tickets::create([
    //         'order_id' => $order->id,
    //         'match_id' => $request->match_id,
    //         'seat_id' => $seat->id,
    //         'status' => 'pending',
    //         'user_id' => $user->id,
    //         'booked_at' => now(),
    //         'payment_method' => 'midtrans',
    //     ]);

    //     // Midtrans config
    //     Config::$serverKey = config('midtrans.server_key');
    //     Config::$isProduction = false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => $orderNumber,
    //             'gross_amount' => $seat->area->price,
    //         ],
    //         'customer_details' => [
    //             'first_name' => $user->name,
    //             'email' => $user->email,
    //         ],
    //         'item_details' => [
    //             [
    //                 'id' => $ticket->id,
    //                 'price' => $seat->area->price,
    //                 'quantity' => 1,
    //                 'name' => 'Tiket pertandingan #' . $request->match_id,
    //             ],
    //         ],
    //     ];

    //     $snapToken = Snap::getSnapToken($params);

    //     return view('order.checkout', compact('snapToken', 'ticket'));
    // }

    //Note : Untuk yg ngerjain view order/transaksi nanti, untuk bagian callback seharusnya udah bisa, kalau udah ditest pembayaran make midtrans tolong dicek db-nya ya
    //Frathol Pro palhem
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {
            $order = Order::where('order_number', $request->order_id)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $transaction = $request->transaction_status;

            if (in_array($transaction, ['capture', 'settlement'])) {
                $order->update(['status' => 'paid']);

                $tickets = Tickets::where('order_id', $order->id)->get();
                foreach ($tickets as $ticket) {
                    $ticket->update(['status' => 'paid']);
                    $ticket->seat->update(['status' => 'booked']);
                }
            } elseif (in_array($transaction, ['cancel', 'deny', 'expire'])) {
                $order->update(['status' => 'failed']);

                $tickets = Tickets::where('order_id', $order->id)->get();
                foreach ($tickets as $ticket) {
                    $ticket->update(['status' => 'cancelled']);
                    $ticket->seat->update(['status' => 'available']);
                }
            } elseif ($transaction === 'pending') {
                $order->update(['status' => 'pending']);

                $tickets = Tickets::where('order_id', $order->id)->get();
                foreach ($tickets as $ticket) {
                    $ticket->update(['status' => 'pending']);
                    if ($ticket->seat) {
                        $ticket->seat->update(['status' => 'booked']);
                    } // sementara dianggap dibooking
                }
            }

            return response()->json(['message' => 'Callback success']);
        }

        return response()->json(['message' => 'Invalid signature'], 403);
    }

    // public function manualConfirm(Order $order)
    // {
    //     if ($order->status === 'paid') {
    //         return back()->with('info', 'Pembayaran sudah dikonfirmasi sebelumnya.');
    //     }

    //     // Update status order dan tiket
    //     $order->update(['status' => 'paid']);

    //     $tickets = Tickets::where('order_id', $order->id)->get();

    //     foreach ($tickets as $ticket) {
    //         $ticket->update(['status' => 'paid']);
    //         if ($ticket->seat) {
    //             $ticket->seat->update(['status' => 'booked']);
    //         }
    //     }

    //     return back()->with('info', 'Pembayaran berhasil dikonfirmasi secara manual.');
    // }

    public function manualConfirm(Order $order)
{
    Log::info('Manual Confirm Started', [
        'order_id' => $order->id,
        'current_status' => $order->status,
    ]);

    if ($order->status === 'paid') {
        Log::info('Order already paid, skipping update', ['order_id' => $order->id]);
        return back()->with('info', 'Pembayaran sudah dikonfirmasi sebelumnya.');
    }

    Log::info('Updating order status to paid', ['order_id' => $order->id]);
    $orderUpdated = $order->update(['status' => 'paid']);

    $tickets = Tickets::where('order_id', $order->id)->get();
    Log::info('Found tickets', ['order_id' => $order->id, 'ticket_count' => $tickets->count()]);

    foreach ($tickets as $ticket) {
        Log::info('Updating ticket', [
            'ticket_id' => $ticket->id,
            'seat_id' => $ticket->seat_id,
            'current_status' => $ticket->status,
        ]);

        $ticketUpdated = $ticket->update(['status' => 'paid']);
        if ($ticket->seat) {
            $ticket->seat->update(['status' => 'booked']);
        } else {
            Log::error('Seat not found for ticket', ['ticket_id' => $ticket->id]);
        }
    }

    Log::info('Manual Confirm Completed', ['order_id' => $order->id]);
    return back()->with('info', 'Pembayaran berhasil dikonfirmasi secara manual.');
}
}
