@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 text-white shadow-lg glass-effect">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2 animate-fade-in">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100">Kelola sistem tiket sepak bola dengan mudah dan efisien</p>
            </div>
            <div class="text-right">
                <p class="text-blue-100">{{ now()->format('l, d F Y') }}</p>
                <p class="text-xl font-semibold animate-pulse">{{ now()->format('H:i') }} WIB</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border border-gray-100 glass-effect hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg animate-bounce">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                </div>
            </div>
        </div>
        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border border-gray-100 glass-effect hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg animate-bounce">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
                </div>
            </div>
        </div>
        <!-- Total Matches -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border border-gray-100 glass-effect hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg animate-bounce">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pertandingan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalMatches) }}</p>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border border-gray-100 glass-effect hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg animate-bounce">
                    <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue) }}</p>
                </div>
            </div>
        </div>
        <!-- Tickets Sold -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border border-gray-100 glass-effect hover:scale-105 transition-transform duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg animate-bounce">
                    <i class="fas fa-ticket-alt text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tiket Terjual</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalTicketsSold) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Revenue Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 glass-effect">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Bulanan ({{ date('Y') }})</h3>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-line mr-1"></i>
                    Dalam Rupiah
                </div>
            </div>
            <canvas id="revenueChart" height="300"></canvas>
        </div>
        <!-- Daily Orders Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 glass-effect">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Order Harian (7 Hari Terakhir)</h3>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Jumlah Order
                </div>
            </div>
            <canvas id="ordersChart" height="300"></canvas>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 glass-effect">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Order Terbaru</h3>
                    <a href="{{ route('admin.orders') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders->take(5) as $order)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors duration-150">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-receipt text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->user->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price) }}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($order->status === 'paid') bg-green-100 text-green-800
                                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">Belum ada order</p>
                    </div>
                @endif
            </div>
        </div>
        <!-- Upcoming Matches -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 glass-effect">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Pertandingan Mendatang</h3>
                    <a href="{{ route('admin.matches') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($upcomingMatches->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingMatches as $match)
                            <div class="p-3 bg-gray-50 rounded-lg hover:bg-green-50 transition-colors duration-150">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-futbol text-green-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $match->match_date->format('d M Y, H:i') }} WIB
                                            </p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($match->status === 'scheduled') bg-blue-100 text-blue-800
                                        @elseif($match->status === 'ongoing') bg-yellow-100 text-yellow-800
                                        @elseif($match->status === 'finished') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($match->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">Belum ada pertandingan mendatang</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.create') }}" class="flex items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                <div class="text-center">
                    <i class="fas fa-user-plus text-blue-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm font-medium text-blue-600">Tambah User</p>
                </div>
            </a>
            
            <a href="{{ route('admin.matches.create') }}" class="flex items-center justify-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                <div class="text-center">
                    <i class="fas fa-calendar-plus text-green-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm font-medium text-green-600">Tambah Pertandingan</p>
                </div>
            </a>
            
            <a href="{{ route('admin.teams.create') }}" class="flex items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                <div class="text-center">
                    <i class="fas fa-shield-alt text-purple-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm font-medium text-purple-600">Tambah Tim</p>
                </div>
            </a>
            
            <a href="{{ route('admin.reports') }}" class="flex items-center justify-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
                <div class="text-center">
                    <i class="fas fa-chart-bar text-yellow-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm font-medium text-yellow-600">Lihat Laporan</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Monthly Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRevenue->pluck('month')->map(fn($m) => DateTime::createFromFormat('!m', $m)->format('M'))) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyRevenue->pluck('revenue')) !!},
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                borderColor: '#667eea',
                borderWidth: 3,
                pointBackgroundColor: '#764ba2',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Daily Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyOrders->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($dailyOrders->pluck('orders')) !!},
                backgroundColor: 'rgba(118, 75, 162, 0.7)',
                borderColor: '#764ba2',
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush