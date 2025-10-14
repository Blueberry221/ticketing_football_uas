@extends('layouts.admin')

@section('title', 'Manajemen Pertandingan')
@section('page-title', 'Manajemen Pertandingan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Pertandingan</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola semua pertandingan sepak bola</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.matches.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah Pertandingan
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-futbol text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pertandingan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $matches->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Akan Datang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $matches->where('status', 'scheduled')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-play text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sedang Berlangsung</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $matches->where('status', 'ongoing')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-flag-checkered text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $matches->where('status', 'finished')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pertandingan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nama tim..." 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="finished" {{ request('status') === 'finished' ? 'selected' : '' }}>Finished</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.matches') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Matches Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Pertandingan</h3>
        </div>
        
        @if($matches->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertandingan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiket Terjual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($matches as $match)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-futbol text-green-600 text-xl"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $match->homeTeam->city }} vs {{ $match->awayTeam->city }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $match->match_date->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $match->match_date->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($match->status === 'scheduled') bg-blue-100 text-blue-800
                                        @elseif($match->status === 'ongoing') bg-yellow-100 text-yellow-800
                                        @elseif($match->status === 'finished') bg-green-100 text-green-800
                                        @elseif($match->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($match->status === 'scheduled')
                                            <i class="fas fa-calendar mr-1"></i>
                                        @elseif($match->status === 'ongoing')
                                            <i class="fas fa-play mr-1"></i>
                                        @elseif($match->status === 'finished')
                                            <i class="fas fa-flag-checkered mr-1"></i>
                                        @elseif($match->status === 'cancelled')
                                            <i class="fas fa-times mr-1"></i>
                                        @endif
                                        {{ ucfirst($match->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $match->tickets->where('status', 'booked')->count() }}</div>
                                    <div class="text-sm text-gray-500">dari {{ $match->tickets->count() }} kursi</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($match->tickets->where('status', 'booked')->sum(function($ticket) { return $ticket->seat->price; })) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.matches.edit', $match) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <button onclick="viewMatchDetails({{ $match->id }})" 
                                                class="text-green-600 hover:text-green-900 transition-colors" 
                                                title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        @if($match->tickets->where('status', 'booked')->count() === 0)
                                            <button onclick="deleteMatch({{ $match->id }})" 
                                                    class="text-red-600 hover:text-red-900 transition-colors" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                        
                                        @if($match->status === 'scheduled')
                                            <button onclick="updateMatchStatus({{ $match->id }}, 'ongoing')" 
                                                    class="text-yellow-600 hover:text-yellow-900 transition-colors" 
                                                    title="Mulai Pertandingan">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        @endif
                                        
                                        @if($match->status === 'ongoing')
                                            <button onclick="updateMatchStatus({{ $match->id }}, 'finished')" 
                                                    class="text-purple-600 hover:text-purple-900 transition-colors" 
                                                    title="Selesaikan Pertandingan">
                                                <i class="fas fa-flag-checkered"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $matches->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-futbol text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pertandingan ditemukan</h3>
                <p class="text-gray-500 mb-4">Belum ada pertandingan yang dibuat dalam sistem.</p>
                <a href="{{ route('admin.matches.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Pertandingan Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal for Match Details -->
<div id="matchDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Detail Pertandingan</h3>
            <button onclick="closeMatchDetailsModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="matchDetailsContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Modal for Status Update -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Perubahan Status</h3>
        <p class="text-sm text-gray-600 mb-6" id="statusMessage">Apakah Anda yakin ingin mengubah status pertandingan ini?</p>
        
        <div class="flex justify-end space-x-3">
            <button onclick="closeStatusModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </button>
            <button id="confirmStatusBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Hapus</h3>
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus pertandingan ini? Tindakan ini tidak dapat dibatalkan.</p>
        
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </button>
            <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
let currentMatchId = null;
let currentStatus = null;

function viewMatchDetails(matchId) {
    // Implementasi untuk menampilkan detail pertandingan
    document.getElementById('matchDetailsContent').innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-gray-400"></i> Loading...</div>';
    document.getElementById('matchDetailsModal').classList.remove('hidden');
    document.getElementById('matchDetailsModal').classList.add('flex');
    
    // Simulasi loading data
    setTimeout(() => {
        document.getElementById('matchDetailsContent').innerHTML = `
            <div class="space-y-4">
                <div class="text-center">
                    <h4 class="text-lg font-semibold">Detail akan ditampilkan di sini</h4>
                    <p class="text-gray-600">Fitur ini akan segera tersedia</p>
                </div>
            </div>
        `;
    }, 1000);
}

function closeMatchDetailsModal() {
    document.getElementById('matchDetailsModal').classList.add('hidden');
    document.getElementById('matchDetailsModal').classList.remove('flex');
}

function updateMatchStatus(matchId, status) {
    currentMatchId = matchId;
    currentStatus = status;
    
    let message = '';
    switch(status) {
        case 'ongoing':
            message = 'Apakah Anda yakin ingin memulai pertandingan ini?';
            break;
        case 'finished':
            message = 'Apakah Anda yakin ingin menyelesaikan pertandingan ini?';
            break;
        case 'cancelled':
            message = 'Apakah Anda yakin ingin membatalkan pertandingan ini?';
            break;
    }
    
    document.getElementById('statusMessage').textContent = message;
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusModal').classList.add('flex');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('statusModal').classList.remove('flex');
    currentMatchId = null;
    currentStatus = null;
}

function deleteMatch(matchId) {
    currentMatchId = matchId;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    currentMatchId = null;
}

document.getElementById('confirmStatusBtn').addEventListener('click', function() {
    if (currentMatchId && currentStatus) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/matches/${currentMatchId}/status`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = currentStatus;
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(statusField);
        
        document.body.appendChild(form);
        form.submit();
    }
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (currentMatchId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/matches/${currentMatchId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
});
</script>
@endsection