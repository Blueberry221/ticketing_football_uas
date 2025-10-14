@extends('layouts.admin')

@section('title', 'Edit Area Stadion')
@section('page-title', 'Edit Area Stadion')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Area Stadion</h1>
            <p class="mt-1 text-sm text-gray-600">Perbarui informasi area "{{ $area->name }}"</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.areas') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Area Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-chair text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kursi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $area->seats->count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $area->seats->whereHas('tickets')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-calendar text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dibuat</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $area->created_at->format('Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($area->seats->whereHas('tickets')->count() * $area->price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($area->seats->whereHas('tickets')->count() > 0)
    <!-- Warning for areas with sold tickets -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                    Peringatan: Area ini memiliki tiket yang sudah terjual
                </h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Beberapa perubahan mungkin dibatasi karena area ini sudah memiliki {{ $area->seats->whereHas('tickets')->count() }} tiket yang terjual. Hati-hati saat mengubah harga atau konfigurasi kursi.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Area Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Area</h3>
            <p class="text-sm text-gray-600">Perbarui informasi area dengan benar</p>
        </div>
        
        <form action="{{ route('admin.areas.update', $area) }}" method="POST" class="p-6 space-y-6" id="areaForm">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Area Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Area <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name', $area->name) }}" 
                               placeholder="Contoh: Tribun Utara" 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               required>
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category" name="category" 
                            class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        <option value="VIP" {{ old('category', $area->category) === 'VIP' ? 'selected' : '' }}>VIP</option>
                        <option value="Premium" {{ old('category', $area->category) === 'Premium' ? 'selected' : '' }}>Premium</option>
                        <option value="Regular" {{ old('category', $area->category) === 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Economy" {{ old('category', $area->category) === 'Economy' ? 'selected' : '' }}>Economy</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga per Kursi <span class="text-red-500">*</span>
                        @if($area->seats->whereHas('tickets')->count() > 0)
                            <span class="text-yellow-600 text-xs">(Hati-hati: Ada tiket terjual)</span>
                        @endif
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400">Rp</span>
                        </div>
                        <input type="number" id="price" name="price" value="{{ old('price', $area->price) }}" 
                               placeholder="150000" 
                               min="0" step="1000"
                               class="block w-full pl-12 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror"
                               required>
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" 
                            class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Status</option>
                        <option value="active" {{ old('status', $area->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $area->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Area
                </label>
                <textarea id="description" name="description" rows="3" 
                          placeholder="Deskripsi singkat tentang area ini..." 
                          class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $area->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Area Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Preview Area</h4>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-lg flex items-center justify-center" id="areaLogo">
                        <i class="fas fa-map-marker-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900" id="previewName">{{ $area->name }}</div>
                        <div class="text-sm text-gray-600" id="previewCategory">
                            <span id="previewCategoryText">{{ $area->category }}</span>
                        </div>
                        <div class="text-sm text-gray-600" id="previewDetails">
                            <span id="previewPrice">Rp {{ number_format($area->price, 0, ',', '.') }}</span> • 
                            <span id="previewCapacity">{{ $area->seats->count() }} kursi</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Field dengan tanda <span class="text-red-500">*</span> wajib diisi
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.areas') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Area
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.areas') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-list text-blue-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-blue-900">Semua Area</div>
                    <div class="text-sm text-blue-600">Lihat daftar area</div>
                </div>
            </a>
            
            <button onclick="toggleStatus()" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                <i class="fas fa-toggle-{{ $area->status === 'active' ? 'on' : 'off' }} text-yellow-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-yellow-900">{{ $area->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}</div>
                    <div class="text-sm text-yellow-600">Ubah status area</div>
                </div>
            </button>
            
            <a href="#" onclick="manageSeats()" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-chair text-green-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-green-900">Kelola Kursi</div>
                    <div class="text-sm text-green-600">{{ $area->seats->count() }} kursi</div>
                </div>
            </a>
            
            @if($area->seats->whereHas('tickets')->count() === 0)
            <button onclick="confirmDelete()" class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                <i class="fas fa-trash text-red-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-red-900">Hapus Area</div>
                    <div class="text-sm text-red-600">Hapus permanen</div>
                </div>
            </button>
            @else
            <div class="flex items-center p-4 bg-gray-50 rounded-lg opacity-50">
                <i class="fas fa-trash text-gray-400 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-gray-500">Tidak Dapat Dihapus</div>
                    <div class="text-sm text-gray-400">Ada tiket terjual</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Confirmation Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                <i class="fas fa-exclamation-triangle text-yellow-600"></i>
            </div>
        </div>
        <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Perubahan Status</h3>
            <p class="text-sm text-gray-500 mb-4" id="statusMessage"></p>
            <div class="flex justify-center space-x-3">
                <button onclick="closeStatusModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Batal
                </button>
                <form id="statusForm" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        Ya, Ubah Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
        </div>
        <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus Area</h3>
            <p class="text-sm text-gray-500 mb-4">
                Apakah Anda yakin ingin menghapus area "{{ $area->name }}"? 
                Tindakan ini tidak dapat dibatalkan dan akan menghapus semua kursi yang terkait.
            </p>
            <div class="flex justify-center space-x-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Batal
                </button>
                <form action="{{ route('admin.areas.destroy', $area) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Ya, Hapus Area
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Seat Management Modal -->
<div id="seatModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Kelola Kursi - {{ $area->name }}</h3>
            <button onclick="closeSeatModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $area->seats->count() }}</div>
                    <div class="text-gray-600">Total Kursi</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $area->seats->whereDoesntHave('tickets')->count() }}</div>
                    <div class="text-gray-600">Tersedia</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $area->seats->whereHas('tickets')->count() }}</div>
                    <div class="text-gray-600">Terjual</div>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <h4 class="font-medium text-gray-900 mb-2">Daftar Kursi</h4>
                <div class="max-h-48 overflow-y-auto">
                    <div class="grid grid-cols-8 gap-1 text-xs">
                        @foreach($area->seats->take(64) as $seat)
                            <div class="p-2 text-center rounded {{ $seat->tickets->count() > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}" 
                                 title="{{ $seat->seat_number }} - {{ $seat->tickets->count() > 0 ? 'Terjual' : 'Tersedia' }}">
                                {{ $seat->seat_number }}
                            </div>
                        @endforeach
                        @if($area->seats->count() > 64)
                            <div class="p-2 text-center text-gray-500 col-span-8">
                                +{{ $area->seats->count() - 64 }} kursi lainnya
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button onclick="closeSeatModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Tutup
                </button>
                @if($area->seats->whereHas('tickets')->count() === 0)
                <button onclick="regenerateSeats()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-sync mr-2"></i>
                    Regenerate Kursi
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Category colors
const categoryColors = {
    'VIP': 'bg-gradient-to-br from-yellow-400 to-orange-500',
    'Premium': 'bg-gradient-to-br from-purple-500 to-pink-500',
    'Regular': 'bg-gradient-to-br from-blue-500 to-cyan-500',
    'Economy': 'bg-gradient-to-br from-green-500 to-teal-500'
};

// Real-time preview update
function updatePreview() {
    const name = document.getElementById('name').value || 'Nama Area';
    const category = document.getElementById('category').value || 'Kategori';
    const price = document.getElementById('price').value || 0;
    
    // Update area name
    document.getElementById('previewName').textContent = name;
    
    // Update category
    document.getElementById('previewCategoryText').textContent = category;
    
    // Update area logo
    const areaLogo = document.getElementById('areaLogo');
    areaLogo.className = `w-16 h-16 rounded-lg flex items-center justify-center ${categoryColors[category] || 'bg-gray-400'}`;
    
    // Update price
    document.getElementById('previewPrice').textContent = `Rp ${parseInt(price).toLocaleString('id-ID')}`;
}

// Toggle status function
function toggleStatus() {
    const currentStatus = '{{ $area->status }}';
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const statusMessage = currentStatus === 'active' 
        ? 'Area akan dinonaktifkan dan tidak dapat digunakan untuk penjualan tiket baru.'
        : 'Area akan diaktifkan dan dapat digunakan untuk penjualan tiket.';
    
    document.getElementById('statusMessage').textContent = statusMessage;
    document.getElementById('statusForm').action = `{{ route('admin.areas.toggle-status', $area) }}`;
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusModal').classList.add('flex');
}

// Manage seats function
function manageSeats() {
    document.getElementById('seatModal').classList.remove('hidden');
    document.getElementById('seatModal').classList.add('flex');
}

// Confirm delete function
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

// Close modals
function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('statusModal').classList.remove('flex');
}

function closeSeatModal() {
    document.getElementById('seatModal').classList.add('hidden');
    document.getElementById('seatModal').classList.remove('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// Regenerate seats function
function regenerateSeats() {
    if (confirm('Apakah Anda yakin ingin me-regenerate semua kursi? Ini akan menghapus konfigurasi kursi yang ada.')) {
        // This would typically be a separate route
        window.location.href = `{{ route('admin.areas.regenerate-seats', $area) }}`;
    }
}

// Add event listeners
document.getElementById('name').addEventListener('input', updatePreview);
document.getElementById('category').addEventListener('change', updatePreview);
document.getElementById('price').addEventListener('input', updatePreview);

// Form validation
document.getElementById('areaForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const category = document.getElementById('category').value;
    const price = document.getElementById('price').value;
    const status = document.getElementById('status').value;
    
    let errors = [];
    
    if (!name) {
        errors.push('Nama area harus diisi');
    }
    
    if (!category) {
        errors.push('Kategori harus dipilih');
    }
    
    if (!price || price < 0) {
        errors.push('Harga harus diisi dan tidak boleh negatif');
    }
    
    if (!status) {
        errors.push('Status harus dipilih');
    }
    
    if (errors.length > 0) {
        e.preventDefault();
        alert('Terdapat kesalahan:\n' + errors.join('\n'));
        return false;
    }
    
    // Show loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';
    submitBtn.disabled = true;
});

// Initialize preview
updatePreview();
</script>
@endsection