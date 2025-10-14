@extends('layouts.admin')

@section('title', 'Tambah Tim Baru')
@section('page-title', 'Tambah Tim Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Tim Baru</h1>
            <p class="mt-1 text-sm text-gray-600">Buat tim sepak bola baru dalam sistem</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.teams') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tim</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Teams::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-futbol text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tim Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Teams::where('status', 'active')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-map-marker-alt text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kota Berbeda</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Teams::distinct('city')->count('city') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Tim</h3>
            <p class="text-sm text-gray-600">Lengkapi semua informasi tim dengan benar</p>
        </div>
        
        <form action="{{ route('admin.teams.store') }}" method="POST" class="p-6 space-y-6" id="teamForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Team Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Tim <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-users text-gray-400"></i>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Contoh: Arsenal FC" 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               required>
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                        Kota <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" 
                               placeholder="Contoh: Jakarta" 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror"
                               required>
                    </div>
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Stadium -->
                <div>
                    <label for="stadium" class="block text-sm font-medium text-gray-700 mb-2">
                        Stadion
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-building text-gray-400"></i>
                        </div>
                        <input type="text" id="stadium" name="stadium" value="{{ old('stadium') }}" 
                               placeholder="Contoh: Stadion Gelora Bung Karno" 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('stadium') border-red-500 @enderror">
                    </div>
                    @error('stadium')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Founded Year -->
                <div>
                    <label for="founded_year" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Berdiri
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                        <input type="number" id="founded_year" name="founded_year" value="{{ old('founded_year') }}" 
                               placeholder="Contoh: 1950" 
                               min="1800" max="{{ date('Y') }}"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('founded_year') border-red-500 @enderror">
                    </div>
                    @error('founded_year')
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
                
                <!-- Coach -->
                <div>
                    <label for="coach" class="block text-sm font-medium text-gray-700 mb-2">
                        Pelatih
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user-tie text-gray-400"></i>
                        </div>
                        <input type="text" id="coach" name="coach" value="{{ old('coach') }}" 
                               placeholder="Contoh: Shin Tae-yong" 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('coach') border-red-500 @enderror">
                    </div>
                    @error('coach')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Tim
                </label>
                <textarea id="description" name="description" rows="4" 
                          placeholder="Deskripsi singkat tentang tim..." 
                          class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Team Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Preview Tim</h4>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center" id="teamLogo">
                        <span class="text-white font-bold text-xl" id="teamInitials">??</span>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900" id="previewName">Nama Tim</div>
                        <div class="text-sm text-gray-600" id="previewLocation">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span id="previewCity">Kota</span>
                            <span id="previewStadium"></span>
                        </div>
                        <div class="text-sm text-gray-600" id="previewDetails">
                            <span id="previewYear"></span>
                            <span id="previewCoach"></span>
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
                    <a href="{{ route('admin.teams') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Tim
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.teams') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-list text-blue-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-blue-900">Lihat Semua Tim</div>
                    <div class="text-sm text-blue-600">Kelola tim yang ada</div>
                </div>
            </a>
            
            <a href="{{ route('admin.matches.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-plus-circle text-green-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-green-900">Buat Pertandingan</div>
                    <div class="text-sm text-green-600">Jadwalkan pertandingan baru</div>
                </div>
            </a>
            
            <a href="{{ route('admin.areas') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <i class="fas fa-map text-purple-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-purple-900">Kelola Area Stadion</div>
                    <div class="text-sm text-purple-600">Atur tempat duduk</div>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
// Real-time preview update
function updatePreview() {
    const name = document.getElementById('name').value || 'Nama Tim';
    const city = document.getElementById('city').value || 'Kota';
    const stadium = document.getElementById('stadium').value;
    const foundedYear = document.getElementById('founded_year').value;
    const coach = document.getElementById('coach').value;
    
    // Update team name
    document.getElementById('previewName').textContent = name;
    
    // Update initials
    const initials = name.split(' ').map(word => word.charAt(0)).join('').substring(0, 2).toUpperCase();
    document.getElementById('teamInitials').textContent = initials || '??';
    
    // Update location
    document.getElementById('previewCity').textContent = city;
    const stadiumText = stadium ? ` • ${stadium}` : '';
    document.getElementById('previewStadium').textContent = stadiumText;
    
    // Update details
    let details = [];
    if (foundedYear) details.push(`Est. ${foundedYear}`);
    if (coach) details.push(`Pelatih: ${coach}`);
    document.getElementById('previewDetails').textContent = details.join(' • ');
}

// Add event listeners
document.getElementById('name').addEventListener('input', updatePreview);
document.getElementById('city').addEventListener('input', updatePreview);
document.getElementById('stadium').addEventListener('input', updatePreview);
document.getElementById('founded_year').addEventListener('input', updatePreview);
document.getElementById('coach').addEventListener('input', updatePreview);

// Form validation
document.getElementById('teamForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const city = document.getElementById('city').value.trim();
    const status = document.getElementById('status').value;
    const foundedYear = document.getElementById('founded_year').value;
    
    let errors = [];
    
    if (!name) {
        errors.push('Nama tim harus diisi');
    }
    
    if (!city) {
        errors.push('Kota harus diisi');
    }
    
    if (!status) {
        errors.push('Status harus dipilih');
    }
    
    if (foundedYear && (foundedYear < 1800 || foundedYear > new Date().getFullYear())) {
        errors.push('Tahun berdiri tidak valid');
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