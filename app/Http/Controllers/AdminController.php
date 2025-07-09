<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Matches;
use App\Models\Teams;
use App\Models\Areas;
use App\Models\Seats;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard utama admin
     */
    public function dashboard()
    {
        // Statistik umum
        $totalUsers = User::where('role', 'user')->count();
        $totalOrders = Order::count();
        $totalMatches = Matches::count();
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');
        $totalTicketsSold = Tickets::where('status', 'booked')->count();
        
        // Data untuk chart
        $monthlyRevenue = Order::where('status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        $dailyOrders = Order::whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Recent orders
        $recentOrders = Order::with(['user', 'tickets.match.homeTeam', 'tickets.match.awayTeam'])
            ->latest()
            ->take(10)
            ->get();
            
        // Upcoming matches
        $upcomingMatches = Matches::with(['homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->orderBy('match_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalOrders', 'totalMatches', 'totalRevenue', 
            'totalTicketsSold', 'monthlyRevenue', 'dailyOrders', 
            'recentOrders', 'upcomingMatches'
        ));
    }

    /**
     * Manajemen Users
     */
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,admin'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'role' => 'required|in:user,admin'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate!');
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus admin terakhir!');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Manajemen Orders
     */
    public function orders()
    {
        $orders = Order::with(['user', 'tickets'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'tickets.match.homeTeam', 'tickets.match.awayTeam', 'tickets.seat.area']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled,refunded'
        ]);

        $order->update(['status' => $request->status]);
        
        // Update ticket status jika order dibatalkan
        if ($request->status === 'cancelled') {
            $order->tickets()->update(['status' => 'cancelled']);
        }

        return back()->with('success', 'Status order berhasil diupdate!');
    }

    /**
     * Manajemen Matches
     */
    public function matches()
    {
        $matches = Matches::with(['homeTeam', 'awayTeam'])->latest()->paginate(15);
        return view('admin.matches.index', compact('matches'));
    }

    public function createMatch()
    {
        $teams = Teams::all();
        return view('admin.matches.create', compact('teams'));
    }

    public function storeMatch(Request $request)
    {
        $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date|after:now',
            'status' => 'required|in:scheduled,ongoing,finished,cancelled'
        ]);

        Matches::create($request->all());
        return redirect()->route('admin.matches')->with('success', 'Pertandingan berhasil ditambahkan!');
    }

    public function editMatch(Matches $match)
    {
        $teams = Teams::all();
        return view('admin.matches.edit', compact('match', 'teams'));
    }

    public function updateMatch(Request $request, Matches $match)
    {
        $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date',
            'status' => 'required|in:scheduled,ongoing,finished,cancelled'
        ]);

        $match->update($request->all());
        return redirect()->route('admin.matches')->with('success', 'Pertandingan berhasil diupdate!');
    }

    public function deleteMatch(Matches $match)
    {
        // Cek apakah ada tiket yang sudah dibeli
        if ($match->tickets()->where('status', 'booked')->exists()) {
            return back()->with('error', 'Tidak dapat menghapus pertandingan yang sudah memiliki tiket terjual!');
        }

        $match->delete();
        return redirect()->route('admin.matches')->with('success', 'Pertandingan berhasil dihapus!');
    }

    /**
     * Manajemen Teams
     */
    public function teams()
    {
        $teams = Teams::paginate(15);
        return view('admin.teams.index', compact('teams'));
    }

    public function createTeam()
    {
        return view('admin.teams.create');
    }

    public function storeTeam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'city' => 'required|string|max:255'
        ]);

        Teams::create($request->all());
        return redirect()->route('admin.teams')->with('success', 'Tim berhasil ditambahkan!');
    }

    public function editTeam(Teams $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function updateTeam(Request $request, Teams $team)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'city' => 'required|string|max:255'
        ]);

        $team->update($request->all());
        return redirect()->route('admin.teams')->with('success', 'Tim berhasil diupdate!');
    }

    public function deleteTeam(Teams $team)
    {
        // Cek apakah tim sedang digunakan dalam pertandingan
        if ($team->homeMatches()->exists() || $team->awayMatches()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus tim yang sedang digunakan dalam pertandingan!');
        }

        $team->delete();
        return redirect()->route('admin.teams')->with('success', 'Tim berhasil dihapus!');
    }

    /**
     * Laporan dan Analytics
     */
    public function reports()
    {
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');
        $totalTicketsSold = Tickets::where('status', 'booked')->count();
        $totalUsers = User::where('role', 'user')->count();
        
        // Revenue per bulan
        $monthlyRevenue = Order::where('status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue, COUNT(*) as orders')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Top selling matches
        $topMatches = Matches::withCount(['tickets' => function($query) {
                $query->where('status', 'booked');
            }])
            ->with(['homeTeam', 'awayTeam'])
            ->orderBy('tickets_count', 'desc')
            ->take(10)
            ->get();
            
        // User registration trend
        $userRegistrations = User::where('role', 'user')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as users')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports', compact(
            'totalRevenue', 'totalTicketsSold', 'totalUsers',
            'monthlyRevenue', 'topMatches', 'userRegistrations'
        ));
    }

    /**
     * Settings
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Manajemen Areas dan Seats
     */
    public function areas()
    {
        $areas = Areas::withCount('seats')->paginate(15);
        return view('admin.areas.index', compact('areas'));
    }

    public function createArea()
    {
        return view('admin.areas.create');
    }

    public function storeArea(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        Areas::create($request->all());
        return redirect()->route('admin.areas')->with('success', 'Area berhasil ditambahkan!');
    }

    public function editArea(Areas $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function updateArea(Request $request, Areas $area)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        $area->update($request->all());
        return redirect()->route('admin.areas')->with('success', 'Area berhasil diupdate!');
    }

    public function deleteArea(Areas $area)
    {
        if ($area->seats()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus area yang memiliki kursi!');
        }

        $area->delete();
        return redirect()->route('admin.areas')->with('success', 'Area berhasil dihapus!');
    }
}