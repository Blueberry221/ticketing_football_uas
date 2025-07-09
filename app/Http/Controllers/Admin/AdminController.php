<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Matches;
use App\Models\Team;
use App\Models\Area;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // Get dashboard statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalOrders = Order::count();
        $totalMatches = Matches::count();
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');
        $totalTicketsSold = Ticket::where('status', 'sold')->count();

        // Get monthly revenue data for chart
        $monthlyRevenue = Order::where('status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get daily orders for the last 7 days
        $dailyOrders = Order::whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get recent orders
        $recentOrders = Order::with(['user', 'tickets.match.homeTeam', 'tickets.match.awayTeam'])
            ->latest()
            ->take(10)
            ->get();

        // Get upcoming matches
        $upcomingMatches = Matches::with(['homeTeam', 'awayTeam'])
            ->where('match_date', '>', Carbon::now())
            ->orderBy('match_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalMatches',
            'totalRevenue',
            'totalTicketsSold',
            'monthlyRevenue',
            'dailyOrders',
            'recentOrders',
            'upcomingMatches'
        ));
    }

    /**
     * Display users management
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15);

        // User statistics
        $userStats = [
            'total' => User::count(),
            'regular' => User::where('role', 'user')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'userStats'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user)
    {
        $userStats = [
            'join_date' => $user->created_at->format('d M Y'),
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->where('status', 'paid')->sum('total_price'),
        ];

        return view('admin.users.edit', compact('user', 'userStats'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Check if user has orders
        if ($user->orders()->count() > 0) {
            return redirect()->back()
                ->with('error', 'User tidak dapat dihapus karena memiliki order!');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Display orders management
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'tickets.match']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->latest()->paginate(15);

        // Order statistics
        $orderStats = [
            'total' => Order::count(),
            'paid' => Order::where('status', 'paid')->count(),
            'pending' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_price'),
        ];

        return view('admin.orders.index', compact('orders', 'orderStats'));
    }

    /**
     * Show order details
     */
    public function showOrder(Order $order)
    {
        $order->load(['user', 'tickets.match.homeTeam', 'tickets.match.awayTeam', 'tickets.area']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,paid,cancelled,refunded',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $order->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        // Update ticket status based on order status
        if ($request->status === 'paid') {
            $order->tickets()->update(['status' => 'sold']);
        } elseif (in_array($request->status, ['cancelled', 'refunded'])) {
            $order->tickets()->update(['status' => 'available']);
        }

        return redirect()->back()
            ->with('success', 'Status order berhasil diupdate!');
    }

    /**
     * Display matches management
     */
    public function matches(Request $request)
    {
        $query = Matches::with(['homeTeam', 'awayTeam']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('homeTeam', function($teamQuery) use ($search) {
                    $teamQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('awayTeam', function($teamQuery) use ($search) {
                    $teamQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('match_date', $request->date);
        }

        $matches = $query->latest('match_date')->paginate(15);

        // Match statistics
        $matchStats = [
            'total' => Matches::count(),
            'scheduled' => Matches::where('status', 'scheduled')->count(),
            'ongoing' => Matches::where('status', 'ongoing')->count(),
            'finished' => Matches::where('status', 'finished')->count(),
        ];

        return view('admin.matches.index', compact('matches', 'matchStats'));
    }

    /**
     * Show create match form
     */
    public function createMatch()
    {
        $teams = Team::where('status', 'active')->get();
        return view('admin.matches.create', compact('teams'));
    }

    /**
     * Store new match
     */
    public function storeMatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date|after:now',
            'status' => 'required|in:scheduled,ongoing,finished',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Matches::create($request->all());

        return redirect()->route('admin.matches')
            ->with('success', 'Match berhasil ditambahkan!');
    }

    /**
     * Show edit match form
     */
    public function editMatch(Matches $match)
    {
        $teams = Team::where('status', 'active')->get();
        $ticketsSold = $match->tickets()->where('status', 'sold')->count();
        
        return view('admin.matches.edit', compact('match', 'teams', 'ticketsSold'));
    }

    /**
     * Update match
     */
    public function updateMatch(Request $request, Matches $match)
    {
        $validator = Validator::make($request->all(), [
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date' => 'required|date',
            'status' => 'required|in:scheduled,ongoing,finished',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $match->update($request->all());

        return redirect()->route('admin.matches')
            ->with('success', 'Match berhasil diupdate!');
    }

    /**
     * Delete match
     */
    public function deleteMatch(Matches $match)
    {
        // Check if match has sold tickets
        if ($match->tickets()->where('status', 'sold')->count() > 0) {
            return redirect()->back()
                ->with('error', 'Match tidak dapat dihapus karena sudah ada tiket yang terjual!');
        }

        $match->delete();

        return redirect()->route('admin.matches')
            ->with('success', 'Match berhasil dihapus!');
    }

    /**
     * Display teams management
     */
    public function teams(Request $request)
    {
        $query = Team::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $teams = $query->latest()->paginate(15);

        // Team statistics
        $teamStats = [
            'total' => Team::count(),
            'active' => Team::where('status', 'active')->count(),
            'total_matches' => Matches::count(),
            'unique_cities' => Team::distinct('city')->count(),
        ];

        return view('admin.teams.index', compact('teams', 'teamStats'));
    }

    /**
     * Show create team form
     */
    public function createTeam()
    {
        return view('admin.teams.create');
    }

    /**
     * Store new team
     */
    public function storeTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:teams',
            'city' => 'required|string|max:255',
            'stadium' => 'required|string|max:255',
            'founded_year' => 'required|integer|min:1800|max:' . date('Y'),
            'status' => 'required|in:active,inactive',
            'coach' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Team::create($request->all());

        return redirect()->route('admin.teams')
            ->with('success', 'Team berhasil ditambahkan!');
    }

    /**
     * Show edit team form
     */
    public function editTeam(Team $team)
    {
        $teamStats = [
            'total_matches' => $team->homeMatches()->count() + $team->awayMatches()->count(),
            'finished_matches' => $team->homeMatches()->where('status', 'finished')->count() + 
                                 $team->awayMatches()->where('status', 'finished')->count(),
            'upcoming_matches' => $team->homeMatches()->where('status', 'scheduled')->count() + 
                                 $team->awayMatches()->where('status', 'scheduled')->count(),
            'joined_year' => $team->created_at->year,
        ];

        return view('admin.teams.edit', compact('team', 'teamStats'));
    }

    /**
     * Update team
     */
    public function updateTeam(Request $request, Team $team)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'city' => 'required|string|max:255',
            'stadium' => 'required|string|max:255',
            'founded_year' => 'required|integer|min:1800|max:' . date('Y'),
            'status' => 'required|in:active,inactive',
            'coach' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $team->update($request->all());

        return redirect()->route('admin.teams')
            ->with('success', 'Team berhasil diupdate!');
    }

    /**
     * Delete team
     */
    public function deleteTeam(Team $team)
    {
        // Check if team has matches
        $totalMatches = $team->homeMatches()->count() + $team->awayMatches()->count();
        if ($totalMatches > 0) {
            return redirect()->back()
                ->with('error', 'Team tidak dapat dihapus karena memiliki match!');
        }

        $team->delete();

        return redirect()->route('admin.teams')
            ->with('success', 'Team berhasil dihapus!');
    }

    /**
     * Display areas management
     */
    public function areas(Request $request)
    {
        $query = Area::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price_per_seat', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_seat', '<=', $request->max_price);
        }

        $areas = $query->latest()->paginate(15);

        // Area statistics
        $areaStats = [
            'total_areas' => Area::count(),
            'total_seats' => Area::sum('capacity'),
            'average_price' => Area::avg('price_per_seat'),
            'vip_areas' => Area::where('category', 'VIP')->count(),
        ];

        return view('admin.areas.index', compact('areas', 'areaStats'));
    }

    /**
     * Show create area form
     */
    public function createArea()
    {
        return view('admin.areas.create');
    }

    /**
     * Store new area
     */
    public function storeArea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:areas',
            'category' => 'required|in:Regular,Premium,VIP',
            'price_per_seat' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'rows' => 'required|integer|min:1|max:50',
            'seats_per_row' => 'required|integer|min:1|max:100',
            'row_prefix' => 'required|string|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calculate capacity
        $capacity = $request->rows * $request->seats_per_row;

        $area = Area::create([
            'name' => $request->name,
            'category' => $request->category,
            'capacity' => $capacity,
            'price_per_seat' => $request->price_per_seat,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        // Generate seats for the area
        $this->generateSeats($area, $request->rows, $request->seats_per_row, $request->row_prefix);

        return redirect()->route('admin.areas')
            ->with('success', 'Area berhasil ditambahkan!');
    }

    /**
     * Show edit area form
     */
    public function editArea(Area $area)
    {
        $areaStats = [
            'total_seats' => $area->capacity,
            'tickets_sold' => $area->tickets()->where('status', 'sold')->count(),
            'creation_year' => $area->created_at->year,
            'total_revenue' => $area->tickets()->whereHas('order', function($q) {
                $q->where('status', 'paid');
            })->sum('price'),
        ];

        return view('admin.areas.edit', compact('area', 'areaStats'));
    }

    /**
     * Update area
     */
    public function updateArea(Request $request, Area $area)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:areas,name,' . $area->id,
            'category' => 'required|in:Regular,Premium,VIP',
            'price_per_seat' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $area->update($request->all());

        return redirect()->route('admin.areas')
            ->with('success', 'Area berhasil diupdate!');
    }

    /**
     * Delete area
     */
    public function deleteArea(Area $area)
    {
        // Check if area has sold tickets
        if ($area->tickets()->where('status', 'sold')->count() > 0) {
            return redirect()->back()
                ->with('error', 'Area tidak dapat dihapus karena sudah ada tiket yang terjual!');
        }

        $area->delete();

        return redirect()->route('admin.areas')
            ->with('success', 'Area berhasil dihapus!');
    }

    /**
     * Display reports
     */
    public function reports(Request $request)
    {
        $dateFrom = $request->get('date_from', Carbon::now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->format('Y-m-d'));

        // Key metrics
        $metrics = [
            'total_revenue' => Order::where('status', 'paid')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->sum('total_price'),
            'tickets_sold' => Ticket::where('status', 'sold')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->count(),
            'total_users' => User::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'total_matches' => Matches::whereBetween('match_date', [$dateFrom, $dateTo])->count(),
        ];

        // Chart data
        $monthlyRevenue = Order::where('status', 'paid')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->get();

        $dailyTickets = Ticket::where('status', 'sold')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as tickets')
            ->groupBy('date')
            ->get();

        // Top selling matches
        $topMatches = Matches::withCount(['tickets' => function($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'sold')
                      ->whereBetween('created_at', [$dateFrom, $dateTo]);
            }])
            ->with(['homeTeam', 'awayTeam'])
            ->orderBy('tickets_count', 'desc')
            ->limit(10)
            ->get();

        // System performance
        $systemInfo = [
            'db_size' => $this->getDatabaseSize(),
            'total_records' => $this->getTotalRecords(),
            'active_sessions' => $this->getActiveSessions(),
            'server_uptime' => $this->getServerUptime(),
            'last_backup' => Cache::get('last_backup_date', 'Never'),
        ];

        return view('admin.reports.index', compact(
            'metrics',
            'monthlyRevenue',
            'dailyTickets',
            'topMatches',
            'systemInfo',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Display settings
     */
    public function settings()
    {
        $settings = Cache::get('app_settings', []);
        $systemInfo = [
            'db_size' => $this->getDatabaseSize(),
            'storage_used' => $this->getStorageUsed(),
        ];

        return view('admin.settings.index', compact('settings', 'systemInfo'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $section = $request->input('section');
        $settings = Cache::get('app_settings', []);

        switch ($section) {
            case 'general':
                $settings = array_merge($settings, $request->only([
                    'site_name', 'site_description', 'contact_email', 'contact_phone',
                    'timezone', 'currency', 'max_tickets_per_order', 'booking_expiry_minutes',
                    'refund_deadline_hours'
                ]));
                break;

            case 'payment':
                $settings = array_merge($settings, $request->only([
                    'payment_methods', 'midtrans_server_key', 'midtrans_client_key',
                    'payment_environment', 'payment_fee_percentage'
                ]));
                break;

            case 'email':
                $settings = array_merge($settings, $request->only([
                    'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password',
                    'smtp_encryption', 'mail_from_address', 'email_notifications'
                ]));
                break;

            case 'security':
                $settings = array_merge($settings, $request->only([
                    'session_lifetime', 'max_login_attempts', 'lockout_duration',
                    'password_min_length', 'security_features'
                ]));
                break;
        }

        Cache::put('app_settings', $settings, now()->addDays(30));

        return redirect()->back()
            ->with('success', 'Pengaturan berhasil disimpan!');
    }

    /**
     * Generate seats for area
     */
    private function generateSeats(Area $area, $rows, $seatsPerRow, $rowPrefix)
    {
        $seats = [];
        
        for ($row = 1; $row <= $rows; $row++) {
            for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                $seats[] = [
                    'area_id' => $area->id,
                    'row_number' => $rowPrefix . $row,
                    'seat_number' => $seat,
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('seats')->insert($seats);
    }

    /**
     * Get database size
     */
    private function getDatabaseSize()
    {
        try {
            $size = DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'size' FROM information_schema.tables WHERE table_schema = DATABASE()")[0]->size ?? 0;
            return $size . ' MB';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get storage used
     */
    private function getStorageUsed()
    {
        try {
            $bytes = disk_total_space(storage_path()) - disk_free_space(storage_path());
            return round($bytes / 1024 / 1024, 1) . ' MB';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get total records
     */
    private function getTotalRecords()
    {
        return User::count() + Order::count() + Matches::count() + Team::count() + Area::count();
    }

    /**
     * Get active sessions
     */
    private function getActiveSessions()
    {
        return User::where('last_activity', '>', Carbon::now()->subMinutes(30))->count();
    }

    /**
     * Get server uptime
     */
    private function getServerUptime()
    {
        try {
            $uptime = shell_exec('uptime -p');
            return $uptime ?: 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
}