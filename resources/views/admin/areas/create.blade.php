@extends('layouts.admin')

@section('title', 'Tambah Area Stadion')
@section('page-title', 'Tambah Area Stadion')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Area Stadion</h1>
            <p class="mt-1 text-sm text-gray-600">Buat area baru untuk stadion dengan tempat duduk</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.areas') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-map text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Area</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Areas::count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Seats::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-crown text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Area VIP</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Areas::where('category', 'VIP')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Harga Rata-rata</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format(\App\Models\Areas::avg('price') ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Area</h3>
            <p class="text-sm text-gray-600">Lengkapi semua informasi area dengan benar</p>
        </div>
        
        <form action="{{ route('admin.areas.store') }}" method="POST" class="p-6 space-y-6" id="areaForm">
            @csrf
            
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
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
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
                        <option value="VIP" {{ old('category') === 'VIP' ? 'selected' : '' }}>VIP</option>
                        <option value="Premium" {{ old('category') === 'Premium' ? 'selected' : '' }}>Premium</option>
                        <option value="Regular" {{ old('category') === 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Economy" {{ old('category') === 'Economy' ? 'selected' : '' }}>Economy</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga per Kursi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400">Rp</span>
                        </div>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" 
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
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                          class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Seat Configuration -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Konfigurasi Tempat Duduk</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Number of Rows -->
                    <div>
                        <label for="rows" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Baris <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-list text-gray-400"></i>
                            </div>
                            <input type="number" id="rows" name="rows" value="{{ old('rows', 10) }}" 
                                   placeholder="10" 
                                   min="1" max="50"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('rows') border-red-500 @enderror"
                                   required>
                        </div>
                        @error('rows')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Seats per Row -->
                    <div>
                        <label for="seats_per_row" class="block text-sm font-medium text-gray-700 mb-2">
                            Kursi per Baris <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-chair text-gray-400"></i>
                            </div>
                            <input type="number" id="seats_per_row" name="seats_per_row" value="{{ old('seats_per_row', 20) }}" 
                                   placeholder="20" 
                                   min="1" max="100"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('seats_per_row') border-red-500 @enderror"
                                   required>
                        </div>
                        @error('seats_per_row')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Row Prefix -->
                    <div>
                        <label for="row_prefix" class="block text-sm font-medium text-gray-700 mb-2">
                            Prefix Baris
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-font text-gray-400"></i>
                            </div>
                            <input type="text" id="row_prefix" name="row_prefix" value="{{ old('row_prefix', 'A') }}" 
                                   placeholder="A" 
                                   maxlength="3"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('row_prefix') border-red-500 @enderror">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Contoh: A, B, C atau VIP, PREM</p>
                        @error('row_prefix')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Seat Preview -->
                <div class="mt-6">
                    <h5 class="text-sm font-medium text-gray-700 mb-3">Preview Tempat Duduk</h5>
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="text-center mb-4">
                            <div class="inline-block bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-tv mr-2"></i>LAPANGAN
                            </div>
                        </div>
                        <div id="seatPreview" class="space-y-2 max-h-40 overflow-y-auto">
                            <!-- Seat preview will be generated here -->
                        </div>
                        <div class="mt-4 text-center">
                            <div class="inline-flex items-center space-x-4 text-sm">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                                    <span>Tersedia</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-gray-300 rounded mr-2"></div>
                                    <span>Tidak Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Area Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Preview Area</h4>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-lg flex items-center justify-center" id="areaLogo">
                        <i class="fas fa-map-marker-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900" id="previewName">Nama Area</div>
                        <div class="text-sm text-gray-600" id="previewCategory">
                            <span id="previewCategoryText">Kategori</span>
                        </div>
                        <div class="text-sm text-gray-600" id="previewDetails">
                            <span id="previewPrice">Rp 0</span> • 
                            <span id="previewCapacity">0 kursi</span>
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
                        Simpan Area
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.areas') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-list text-blue-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-blue-900">Lihat Semua Area</div>
                    <div class="text-sm text-blue-600">Kelola area yang ada</div>
                </div>
            </a>
            
            <a href="{{ route('admin.matches.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-plus-circle text-green-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-green-900">Buat Pertandingan</div>
                    <div class="text-sm text-green-600">Jadwalkan pertandingan baru</div>
                </div>
            </a>
            
            <a href="{{ route('admin.teams') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <i class="fas fa-users text-purple-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-purple-900">Kelola Tim</div>
                    <div class="text-sm text-purple-600">Manajemen tim sepak bola</div>
                </div>
            </a>
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

const categoryIcons = {
    'VIP': 'fas fa-crown',
    'Premium': 'fas fa-star',
    'Regular': 'fas fa-circle',
    'Economy': 'fas fa-dot-circle'
};

// Real-time preview update
function updatePreview() {
    const name = document.getElementById('name').value || 'Nama Area';
    const category = document.getElementById('category').value || 'Kategori';
    const price = document.getElementById('price').value || 0;
    const rows = parseInt(document.getElementById('rows').value) || 0;
    const seatsPerRow = parseInt(document.getElementById('seats_per_row').value) || 0;
    const totalSeats = rows * seatsPerRow;
    
    // Update area name
    document.getElementById('previewName').textContent = name;
    
    // Update category
    document.getElementById('previewCategoryText').textContent = category;
    
    // Update area logo
    const areaLogo = document.getElementById('areaLogo');
    areaLogo.className = `w-16 h-16 rounded-lg flex items-center justify-center ${categoryColors[category] || 'bg-gray-400'}`;
    
    // Update details
    document.getElementById('previewPrice').textContent = `Rp ${parseInt(price).toLocaleString('id-ID')}`;
    document.getElementById('previewCapacity').textContent = `${totalSeats} kursi`;
    
    // Update seat preview
    updateSeatPreview();
}

function updateSeatPreview() {
    const rows = parseInt(document.getElementById('rows').value) || 0;
    const seatsPerRow = parseInt(document.getElementById('seats_per_row').value) || 0;
    const rowPrefix = document.getElementById('row_prefix').value || 'A';
    
    const seatPreview = document.getElementById('seatPreview');
    seatPreview.innerHTML = '';
    
    if (rows > 0 && seatsPerRow > 0) {
        const maxPreviewRows = Math.min(rows, 5); // Show max 5 rows in preview
        
        for (let i = 0; i < maxPreviewRows; i++) {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'flex items-center justify-center space-x-1';
            
            // Row label
            const rowLabel = document.createElement('div');
            rowLabel.className = 'w-8 text-center text-sm font-medium text-gray-600';
            rowLabel.textContent = rowPrefix + (i + 1);
            rowDiv.appendChild(rowLabel);
            
            // Seats
            const maxPreviewSeats = Math.min(seatsPerRow, 20); // Show max 20 seats per row
            for (let j = 0; j < maxPreviewSeats; j++) {
                const seat = document.createElement('div');
                seat.className = 'w-4 h-4 bg-green-500 rounded';
                seat.title = `${rowPrefix}${i + 1}-${j + 1}`;
                rowDiv.appendChild(seat);
            }
            
            if (seatsPerRow > 20) {
                const moreSeats = document.createElement('div');
                moreSeats.className = 'text-xs text-gray-500';
                moreSeats.textContent = `+${seatsPerRow - 20}`;
                rowDiv.appendChild(moreSeats);
            }
            
            seatPreview.appendChild(rowDiv);
        }
        
        if (rows > 5) {
            const moreRows = document.createElement('div');
            moreRows.className = 'text-center text-xs text-gray-500';
            moreRows.textContent = `+${rows - 5} baris lainnya`;
            seatPreview.appendChild(moreRows);
        }
    } else {
        seatPreview.innerHTML = '<div class="text-center text-gray-500 text-sm">Masukkan jumlah baris dan kursi per baris</div>';
    }
}

// Add event listeners
document.getElementById('name').addEventListener('input', updatePreview);
document.getElementById('category').addEventListener('change', updatePreview);
document.getElementById('price').addEventListener('input', updatePreview);
document.getElementById('rows').addEventListener('input', updatePreview);
document.getElementById('seats_per_row').addEventListener('input', updatePreview);
document.getElementById('row_prefix').addEventListener('input', updatePreview);

// Form validation
document.getElementById('areaForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const category = document.getElementById('category').value;
    const price = document.getElementById('price').value;
    const status = document.getElementById('status').value;
    const rows = document.getElementById('rows').value;
    const seatsPerRow = document.getElementById('seats_per_row').value;
    
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
    
    if (!rows || rows < 1 || rows > 50) {
        errors.push('Jumlah baris harus antara 1-50');
    }
    
    if (!seatsPerRow || seatsPerRow < 1 || seatsPerRow > 100) {
        errors.push('Kursi per baris harus antara 1-100');
    }
    
    if (errors.length > 0) {
        e.preventDefault();
        alert('Terdapat kesalahan:\n' + errors.join('\n'));
        return false;
    }
    
    // Show loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    submitBtn.disabled = true;
});

// Initialize preview
updatePreview();
</script>
@endsection