<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\Seats;
use App\Models\Tickets;
use App\Models\Order;
use App\Models\Users;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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

        $seat = Seats::with('area')->findOrFail($request->seat_id);
        if ($seat->status !== 'available') {
            return redirect()->back()->with('error', 'Seat sudah dipesan.');
        }

        $user = Auth::user() ?? Users::where('role', 'user')->first();

        // Generate order_number (order_id untuk midtrans)
        $orderNumber = 'ORDER-' . Str::uuid();

        // 1. Buat Order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => $orderNumber, // <--- Tambah ini
            'total_price' => $seat->area->price,
            'status' => 'pending',
            'payment_method' => 'midtrans',
        ]);

        // 2. Buat Tiket
        $ticket = Tickets::create([
            'order_id' => $order->id,
            'match_id' => $request->match_id,
            'seat_id' => $seat->id,
            'status' => 'pending',
            'user_id' => $user->id,
            'booked_at' => now(),
            'payment_method' => 'midtrans',
        ]);

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
    }

    //Note : Untuk yg ngerjain view order/transaksi nanti, untuk bagian callback seharusnya udah bisa, kalau udah ditest pembayaran make midtrans tolong dicek db-nya ya
    //Frathol Pro palhem
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            $order = Order::where('order_number', $request->order_id)->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }
            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $order->update(['status' => 'paid']);
            } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                $order->update(['status' => 'failed']);
            } elseif ($request->transaction_status === 'pending') {
                $order->update(['status' => 'pending']);
            }

            return response()->json(['message' => 'Callback success']);
        }
        return response()->json(['message' => 'Invalid signature'], 403);
    }
}
