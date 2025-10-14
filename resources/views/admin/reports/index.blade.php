@extends('layouts.admin')

@section('title', 'Laporan & Analitik')
@section('page-title', 'Laporan & Analitik')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan & Analitik</h1>
            <p class="mt-1 text-sm text-gray-600">Dashboard analitik dan laporan komprehensif sistem tiket</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="exportData()" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i>
                Export Data
            </button>
            <button onclick="refreshData()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-sync mr-2"></i>
                Refresh
            </button>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" id="date_from" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" id="date_to" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button onclick="applyDateFilter()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors text-sm">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
            </div>
            <div class="flex items-end space-x-2">
                <button onclick="setDateRange('today')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm transition-colors">Hari Ini</button>
                <button onclick="setDateRange('week')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm transition-colors">Minggu Ini</button>
                <button onclick="setDateRange('month')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm transition-colors">Bulan Ini</button>
                <button onclick="setDateRange('year')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm transition-colors">Tahun Ini</button>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalRevenue">Rp {{ number_format($analytics['total_revenue'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-green-600"><i class="fas fa-arrow-up"></i> +12.5% dari bulan lalu</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-ticket-alt text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tiket Terjual</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalTickets">{{ number_format($analytics['total_tickets'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-green-600"><i class="fas fa-arrow-up"></i> +8.3% dari bulan lalu</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-users text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalUsers">{{ number_format($analytics['total_users'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-green-600"><i class="fas fa-arrow-up"></i> +15.2% dari bulan lalu</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-futbol text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pertandingan</p>
                    <p class="text-2xl font-bold text-gray-900" id="totalMatches">{{ number_format($analytics['total_matches'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-blue-600"><i class="fas fa-calendar"></i> {{ $analytics['upcoming_matches'] ?? 0 }} mendatang</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Bulanan</h3>
                <p class="text-sm text-gray-600">Tren pendapatan 12 bulan terakhir</p>
            </div>
            <div class="p-6">
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>
        
        <!-- Ticket Sales Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Penjualan Tiket Harian</h3>
                <p class="text-sm text-gray-600">Penjualan tiket 30 hari terakhir</p>
            </div>
            <div class="p-6">
                <canvas id="ticketChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Additional Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Selling Matches -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Pertandingan Terlaris</h3>
                <p class="text-sm text-gray-600">Top 5 pertandingan dengan penjualan tertinggi</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($analytics['top_matches'] ?? [] as $index => $match)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold text-sm mr-3">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $match['home_team'] }} vs {{ $match['away_team'] }}</div>
                                <div class="text-sm text-gray-600">{{ $match['date'] }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">{{ $match['tickets_sold'] }}</div>
                            <div class="text-sm text-gray-600">tiket</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-chart-bar text-4xl mb-4"></i>
                        <p>Belum ada data pertandingan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- User Registration Trends -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Tren Registrasi User</h3>
                <p class="text-sm text-gray-600">Registrasi user 7 hari terakhir</p>
            </div>
            <div class="p-6">
                <canvas id="userRegistrationChart" width="300" height="200"></canvas>
            </div>
        </div>
        
        <!-- Revenue by Category -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Revenue by Kategori</h3>
                <p class="text-sm text-gray-600">Distribusi pendapatan per kategori area</p>
            </div>
            <div class="p-6">
                <canvas id="categoryRevenueChart" width="300" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Order Terbaru</h3>
                <p class="text-sm text-gray-600">10 order terbaru dalam sistem</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($analytics['recent_orders'] ?? [] as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $order['order_number'] }}</div>
                                <div class="text-sm text-gray-500">{{ $order['date'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order['customer_name'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($order['total'], 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $order['status'] === 'paid' ? 'bg-green-100 text-green-800' : 
                                       ($order['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Belum ada order
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- System Performance -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Performa Sistem</h3>
                <p class="text-sm text-gray-600">Statistik performa dan penggunaan sistem</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Database Size</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $analytics['db_size'] ?? '0 MB' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Total Records</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($analytics['total_records'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Active Sessions</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $analytics['active_sessions'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Server Uptime</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $analytics['server_uptime'] ?? '0 days' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Last Backup</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $analytics['last_backup'] ?? 'Never' }}</span>
                </div>
                
                <!-- System Health Indicators -->
                <div class="pt-4 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">System Health</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Database</span>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-sm text-green-600">Healthy</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Storage</span>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-sm text-green-600">85% Available</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Memory</span>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-sm text-yellow-600">75% Used</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">CPU</span>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-sm text-green-600">45% Load</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Export Options</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button onclick="exportReport('revenue')" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-chart-line text-blue-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-blue-900">Revenue Report</div>
                    <div class="text-sm text-blue-600">Export laporan pendapatan</div>
                </div>
            </button>
            
            <button onclick="exportReport('tickets')" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-ticket-alt text-green-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-green-900">Ticket Sales</div>
                    <div class="text-sm text-green-600">Export data penjualan tiket</div>
                </div>
            </button>
            
            <button onclick="exportReport('users')" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                <i class="fas fa-users text-yellow-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-yellow-900">User Data</div>
                    <div class="text-sm text-yellow-600">Export data pengguna</div>
                </div>
            </button>
            
            <button onclick="exportReport('complete')" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <i class="fas fa-file-export text-purple-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-purple-900">Complete Report</div>
                    <div class="text-sm text-purple-600">Export laporan lengkap</div>
                </div>
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sample data - in real implementation, this would come from the backend
const monthlyRevenue = @json($analytics['monthly_revenue'] ?? []);
const dailyTickets = @json($analytics['daily_tickets'] ?? []);
const userRegistrations = @json($analytics['user_registrations'] ?? []);
const categoryRevenue = @json($analytics['category_revenue'] ?? []);

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Revenue (Rp)',
            data: monthlyRevenue,
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
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

// Ticket Sales Chart
const ticketCtx = document.getElementById('ticketChart').getContext('2d');
const ticketChart = new Chart(ticketCtx, {
    type: 'bar',
    data: {
        labels: Array.from({length: 30}, (_, i) => `Day ${i + 1}`),
        datasets: [{
            label: 'Tickets Sold',
            data: dailyTickets,
            backgroundColor: 'rgba(34, 197, 94, 0.8)',
            borderColor: 'rgb(34, 197, 94)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// User Registration Chart
const userCtx = document.getElementById('userRegistrationChart').getContext('2d');
const userChart = new Chart(userCtx, {
    type: 'doughnut',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            data: userRegistrations,
            backgroundColor: [
                '#3B82F6', '#10B981', '#F59E0B', '#EF4444',
                '#8B5CF6', '#06B6D4', '#84CC16'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Category Revenue Chart
const categoryCtx = document.getElementById('categoryRevenueChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'pie',
    data: {
        labels: ['VIP', 'Premium', 'Regular', 'Economy'],
        datasets: [{
            data: categoryRevenue,
            backgroundColor: [
                '#F59E0B', '#8B5CF6', '#3B82F6', '#10B981'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Date range functions
function setDateRange(range) {
    const today = new Date();
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    
    dateTo.value = today.toISOString().split('T')[0];
    
    switch(range) {
        case 'today':
            dateFrom.value = today.toISOString().split('T')[0];
            break;
        case 'week':
            const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
            dateFrom.value = weekAgo.toISOString().split('T')[0];
            break;
        case 'month':
            const monthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            dateFrom.value = monthAgo.toISOString().split('T')[0];
            break;
        case 'year':
            const yearAgo = new Date(today.getFullYear() - 1, today.getMonth(), today.getDate());
            dateFrom.value = yearAgo.toISOString().split('T')[0];
            break;
    }
    
    applyDateFilter();
}

function applyDateFilter() {
    const dateFrom = document.getElementById('date_from').value;
    const dateTo = document.getElementById('date_to').value;
    
    if (dateFrom && dateTo) {
        // In real implementation, this would make an AJAX call to filter data
        console.log('Filtering data from', dateFrom, 'to', dateTo);
        // Refresh charts with filtered data
        refreshData();
    }
}

function refreshData() {
    // Show loading state
    const refreshBtn = document.querySelector('button[onclick="refreshData()"]');
    const originalText = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // In real implementation, this would fetch new data from the server
        location.reload();
    }, 1000);
}

function exportData() {
    // Show export options or directly download
    alert('Export functionality would be implemented here');
}

function exportReport(type) {
    // In real implementation, this would generate and download the report
    console.log('Exporting', type, 'report');
    alert(`Exporting ${type} report...`);
}

// Initialize date range to current month
setDateRange('month');
</script>
@endsection