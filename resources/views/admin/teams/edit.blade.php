@extends('layouts.admin')

@section('title', 'Edit Tim - ' . $team->name)
@section('page-title', 'Edit Tim')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Tim: {{ $team->name }}</h1>
            <p class="mt-1 text-sm text-gray-600">Perbarui informasi tim dalam sistem</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.teams') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Team Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-futbol text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pertandingan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $team->homeMatches->count() + $team->awayMatches->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pertandingan Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $team->homeMatches->where('status', 'finished')->count() + $team->awayMatches->where('status', 'finished')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pertandingan Mendatang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $team->homeMatches->where('status', 'scheduled')->count() + $team->awayMatches->where('status', 'scheduled')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-calendar text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Bergabung</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $team->created_at->format('Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($team->homeMatches->count() > 0 || $team->awayMatches->count() > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Tim ini memiliki {{ $team->homeMatches->count() + $team->awayMatches->count() }} pertandingan. Beberapa perubahan mungkin dibatasi untuk menjaga konsistensi data.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Team Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Tim</h3>
            <p class="text-sm text-gray-600">Perbarui informasi tim dengan benar</p>
        </div>
        
        <form action="{{ route('admin.teams.update', $team) }}" method="POST" class="p-6 space-y-6" id="teamForm">
            @csrf
            @method('PUT')
            
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
                        <input type="text" id="name" name="name" value="{{ old('name', $team->name) }}" 
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
                        <input type="text" id="city" name="city" value="{{ old('city', $team->city) }}" 
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
                        <input type="text" id="stadium" name="stadium" value="{{ old('stadium', $team->stadium) }}" 
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
                        <input type="number" id="founded_year" name="founded_year" value="{{ old('founded_year', $team->founded_year) }}" 
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
                        <option value="active" {{ old('status', $team->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $team->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                        <input type="text" id="coach" name="coach" value="{{ old('coach', $team->coach) }}" 
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
                          class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $team->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Team Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Preview Tim</h4>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center" id="teamLogo">
                        <span class="text-white font-bold text-xl" id="teamInitials">{{ strtoupper(substr($team->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-900" id="previewName">{{ $team->name }}</div>
                        <div class="text-sm text-gray-600" id="previewLocation">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span id="previewCity">{{ $team->city }}</span>
                            <span id="previewStadium">{{ $team->stadium ? ' • ' . $team->stadium : '' }}</span>
                        </div>
                        <div class="text-sm text-gray-600" id="previewDetails">
                            @if($team->founded_year)
                                <span id="previewYear">Est. {{ $team->founded_year }}</span>
                            @endif
                            @if($team->coach)
                                <span id="previewCoach">{{ $team->founded_year ? ' • ' : '' }}Pelatih: {{ $team->coach }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Terakhir diperbarui: {{ $team->updated_at->format('d M Y H:i') }}
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.teams') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Tim
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.teams') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-list text-blue-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-blue-900">Lihat Semua Tim</div>
                    <div class="text-sm text-blue-600">Kelola tim lainnya</div>
                </div>
            </a>
            
            <button onclick="toggleTeamStatus('{{ $team->id }}', '{{ $team->status }}')" class="flex items-center p-4 {{ $team->status === 'active' ? 'bg-yellow-50 hover:bg-yellow-100' : 'bg-green-50 hover:bg-green-100' }} rounded-lg transition-colors">
                <i class="fas fa-{{ $team->status === 'active' ? 'pause' : 'play' }} {{ $team->status === 'active' ? 'text-yellow-600' : 'text-green-600' }} text-xl mr-3"></i>
                <div>
                    <div class="font-medium {{ $team->status === 'active' ? 'text-yellow-900' : 'text-green-900' }}">{{ $team->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} Tim</div>
                    <div class="text-sm {{ $team->status === 'active' ? 'text-yellow-600' : 'text-green-600' }}">Ubah status tim</div>
                </div>
            </button>
            
            <a href="{{ route('admin.matches.create') }}?team={{ $team->id }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-plus-circle text-green-600 text-xl mr-3"></i>
                <div>
                    <div class="font-medium text-green-900">Buat Pertandingan</div>
                    <div class="text-sm text-green-600">Jadwalkan dengan tim ini</div>
                </div>
            </a>
            
            @if($team->homeMatches->count() === 0 && $team->awayMatches->count() === 0)
                <button onclick="deleteTeam('{{ $team->id }}')" class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                    <i class="fas fa-trash text-red-600 text-xl mr-3"></i>
                    <div>
                        <div class="font-medium text-red-900">Hapus Tim</div>
                        <div class="text-sm text-red-600">Hapus permanen</div>
                    </div>
                </button>
            @else
                <div class="flex items-center p-4 bg-gray-50 rounded-lg opacity-50">
                    <i class="fas fa-lock text-gray-400 text-xl mr-3"></i>
                    <div>
                        <div class="font-medium text-gray-500">Tidak Dapat Dihapus</div>
                        <div class="text-sm text-gray-400">Tim memiliki pertandingan</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal for Status Update -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Perubahan Status</h3>
        <p class="text-sm text-gray-600 mb-6" id="statusMessage">Apakah Anda yakin ingin mengubah status tim ini?</p>
        
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
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus tim "{{ $team->name }}"? Tindakan ini tidak dapat dibatalkan.</p>
        
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
let currentTeamId = null;
let currentStatus = null;

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

// Status modal functions
function toggleTeamStatus(teamId, currentStatus) {
    currentTeamId = teamId;
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    currentStatus = newStatus;
    
    const message = newStatus === 'active' 
        ? 'Apakah Anda yakin ingin mengaktifkan tim ini?' 
        : 'Apakah Anda yakin ingin menonaktifkan tim ini?';
    
    document.getElementById('statusMessage').textContent = message;
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('statusModal').classList.add('flex');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('statusModal').classList.remove('flex');
    currentTeamId = null;
    currentStatus = null;
}

// Delete modal functions
function deleteTeam(teamId) {
    currentTeamId = teamId;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    currentTeamId = null;
}

// Confirm actions
document.getElementById('confirmStatusBtn').addEventListener('click', function() {
    if (currentTeamId && currentStatus) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/teams/${currentTeamId}/status`;
        
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
    if (currentTeamId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/teams/${currentTeamId}`;
        
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
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';
    submitBtn.disabled = true;
});
</script>
@endsection