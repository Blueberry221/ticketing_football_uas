@extends('layouts.admin')

@section('title', 'Manajemen Area Stadion')
@section('page-title', 'Manajemen Area Stadion')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Area Stadion</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola area dan tempat duduk di stadion</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.areas.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah Area
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-map text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Area</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $areas->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-chair text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kursi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSeats }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Harga Rata-rata</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($averagePrice, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Area VIP</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $areas->where('category', 'VIP')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Area</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nama area..." 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Kategori</option>
                    <option value="VIP" {{ request('category') === 'VIP' ? 'selected' : '' }}>VIP</option>
                    <option value="Premium" {{ request('category') === 'Premium' ? 'selected' : '' }}>Premium</option>
                    <option value="Regular" {{ request('category') === 'Regular' ? 'selected' : '' }}>Regular</option>
                    <option value="Economy" {{ request('category') === 'Economy' ? 'selected' : '' }}>Economy</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Harga</label>
                <select name="price_range" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Harga</option>
                    <option value="0-100000" {{ request('price_range') === '0-100000' ? 'selected' : '' }}>< Rp 100.000</option>
                    <option value="100000-300000" {{ request('price_range') === '100000-300000' ? 'selected' : '' }}>Rp 100.000 - 300.000</option>
                    <option value="300000-500000" {{ request('price_range') === '300000-500000' ? 'selected' : '' }}>Rp 300.000 - 500.000</option>
                    <option value="500000-999999999" {{ request('price_range') === '500000-999999999' ? 'selected' : '' }}>> Rp 500.000</option>
                </select>
            </div>
            
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.areas') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Areas Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Area Stadion</h3>
        </div>
        
        @if($areas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($areas as $area)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                            {{ $area->category === 'VIP' ? 'bg-gradient-to-br from-yellow-400 to-orange-500' : 
                                               ($area->category === 'Premium' ? 'bg-gradient-to-br from-purple-500 to-pink-500' : 
                                               ($area->category === 'Regular' ? 'bg-gradient-to-br from-blue-500 to-cyan-500' : 
                                               'bg-gradient-to-br from-green-500 to-teal-500')) }}">
                                            <i class="fas fa-map-marker-alt text-white text-lg"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $area->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $area->description ?? 'Tidak ada deskripsi' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $area->category === 'VIP' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($area->category === 'Premium' ? 'bg-purple-100 text-purple-800' : 
                                           ($area->category === 'Regular' ? 'bg-blue-100 text-blue-800' : 
                                           'bg-green-100 text-green-800')) }}">
                                        @if($area->category === 'VIP')
                                            <i class="fas fa-crown mr-1"></i>
                                        @elseif($area->category === 'Premium')
                                            <i class="fas fa-star mr-1"></i>
                                        @elseif($area->category === 'Regular')
                                            <i class="fas fa-circle mr-1"></i>
                                        @else
                                            <i class="fas fa-dot-circle mr-1"></i>
                                        @endif
                                        {{ $area->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div class="flex items-center space-x-4">
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-blue-600">{{ $area->seats->count() }}</div>
                                                <div class="text-xs text-gray-500">Total</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-green-600">{{ $area->seats->where('status', 'available')->count() }}</div>
                                                <div class="text-xs text-gray-500">Tersedia</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-red-600">{{ $area->seats->where('status', 'booked')->count() }}</div>
                                                <div class="text-xs text-gray-500">Terpesan</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Rp {{ number_format($area->price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500">per kursi</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $area->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        @if($area->status === 'active')
                                            <i class="fas fa-check-circle mr-1"></i>
                                        @else
                                            <i class="fas fa-times-circle mr-1"></i>
                                        @endif
                                        {{ ucfirst($area->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $area->created_at->format('d M Y') }}
                                    <div class="text-xs text-gray-400">{{ $area->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.areas.edit', $area) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <button onclick="viewAreaDetails({{ $area->id }})" 
                                                class="text-green-600 hover:text-green-900 transition-colors" 
                                                title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <button onclick="manageSeats({{ $area->id }})" 
                                                class="text-purple-600 hover:text-purple-900 transition-colors" 
                                                title="Kelola Kursi">
                                            <i class="fas fa-chair"></i>
                                        </button>
                                        
                                        <button onclick="toggleAreaStatus({{ $area->id }}, '{{ $area->status }}')" 
                                                class="{{ $area->status === 'active' ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }} transition-colors" 
                                                title="{{ $area->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $area->status === 'active' ? 'pause' : 'play' }}"></i>
                                        </button>
                                        
                                        @if($area->seats->count() === 0)
                                            <button onclick="deleteArea({{ $area->id }})" 
                                                    class="text-red-600 hover:text-red-900 transition-colors" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <span class="text-gray-400" title="Tidak dapat dihapus karena memiliki kursi">
                                                <i class="fas fa-lock"></i>
                                            </span>
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
                {{ $areas->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-map text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada area ditemukan</h3>
                <p class="text-gray-500 mb-4">Belum ada area stadion yang dibuat dalam sistem.</p>
                <a href="{{ route('admin.areas.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Area Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal for Area Details -->
<div id="areaDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Detail Area</h3>
            <button onclick="closeAreaDetailsModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="areaDetailsContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Modal for Seat Management -->
<div id="seatManagementModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-6xl w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Kelola Kursi</h3>
            <button onclick="closeSeatManagementModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="seatManagementContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Modal for Status Update -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Perubahan Status</h3>
        <p class="text-sm text-gray-600 mb-6" id="statusMessage">Apakah Anda yakin ingin mengubah status area ini?</p>
        
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
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus area ini? Tindakan ini tidak dapat dibatalkan.</p>
        
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
let currentAreaId = null;
let currentStatus = null;

function viewAreaDetails(areaId) {
    document.getElementById('areaDetailsContent').innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-gray-400"></i> Loading...</div>';
    document.getElementById('areaDetailsModal').classList.remove('hidden');
    document.getElementById('areaDetailsModal').classList.add('flex');
    
    // Simulasi loading data
    setTimeout(() => {
        document.getElementById('areaDetailsContent').innerHTML = `
            <div class="space-y-4">
                <div class="text-center">
                    <h4 class="text-lg font-semibold">Detail area akan ditampilkan di sini</h4>
                    <p class="text-gray-600">Fitur ini akan segera tersedia</p>
                </div>
            </div>
        `;
    }, 1000);
}

function closeAreaDetailsModal() {
    document.getElementById('areaDetailsModal').classList.add('hidden');
    document.getElementById('areaDetailsModal').classList.remove('flex');
}

function manageSeats(areaId) {
    document.getElementById('seatManagementContent').innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-gray-400"></i> Loading...</div>';
    document.getElementById('seatManagementModal').classList.remove('hidden');
    document.getElementById('seatManagementModal').classList.add('flex');
    
    // Simulasi loading data
    setTimeout(() => {
        document.getElementById('seatManagementContent').innerHTML = `
            <div class="space-y-4">
                <div class="text-center">
                    <h4 class="text-lg font-semibold">Manajemen kursi akan ditampilkan di sini</h4>
                    <p class="text-gray-600">Fitur ini akan segera tersedia</p>
                </div>
            </div>
        `;
    }, 1000);
}

function closeSeatManagementModal() {
    document.getElementById('seatManagementModal').classList.add('hidden');
    document.getElementById('seatManagementModal').classList.remove('flex');
}

function toggleAreaStatus(areaId, currentStatus) {
    currentAreaId = areaId;
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    currentStatus = newStatus;
    
    const message = newStatus === 'active' 
        ? 'Apakah Anda yakin ingin mengaktifkan area ini?' 
        : 'Apakah Anda yakin ingin menonaktifkan area ini?';
    
    document.getElementById('statusMessage').textContent = message;
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusModal').classList.add('flex');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('statusModal').classList.remove('flex');
    currentAreaId = null;
    currentStatus = null;
}

function deleteArea(areaId) {
    currentAreaId = areaId;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    currentAreaId = null;
}

document.getElementById('confirmStatusBtn').addEventListener('click', function() {
    if (currentAreaId && currentStatus) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/areas/${currentAreaId}/status`;
        
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
    if (currentAreaId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/areas/${currentAreaId}`;
        
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