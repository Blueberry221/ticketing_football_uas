@extends('layouts.admin')

@section('title', 'Tambah Pertandingan')
@section('page-title', 'Tambah Pertandingan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.matches') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Pertandingan Baru</h1>
            <p class="mt-1 text-sm text-gray-600">Buat pertandingan sepak bola baru</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Pertandingan</h3>
        </div>
        
        <form action="{{ route('admin.matches.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Team Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="home_team_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tim Tuan Rumah <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="home_team_id" name="home_team_id" required 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('home_team_id') border-red-500 @enderror">
                            <option value="">Pilih Tim Tuan Rumah</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('home_team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->city }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('home_team_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="away_team_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tim Tamu <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="away_team_id" name="away_team_id" required 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('away_team_id') border-red-500 @enderror">
                            <option value="">Pilih Tim Tamu</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('away_team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->city }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('away_team_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Match Preview -->
            <div id="matchPreview" class="hidden bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-center space-x-4">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-home text-blue-600 text-xl"></i>
                        </div>
                        <p id="homeTeamName" class="font-medium text-gray-900">-</p>
                        <p id="homeTeamCity" class="text-sm text-gray-600">-</p>
                    </div>
                    <div class="text-2xl font-bold text-gray-400">VS</div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-plane text-red-600 text-xl"></i>
                        </div>
                        <p id="awayTeamName" class="font-medium text-gray-900">-</p>
                        <p id="awayTeamCity" class="text-sm text-gray-600">-</p>
                    </div>
                </div>
            </div>

            <!-- Date and Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="match_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Pertandingan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="date" id="match_date" name="match_date" required 
                               value="{{ old('match_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('match_date') border-red-500 @enderror">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                    </div>
                    @error('match_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="match_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Waktu Pertandingan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="time" id="match_time" name="match_time" required 
                               value="{{ old('match_time', '19:00') }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('match_time') border-red-500 @enderror">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-clock text-gray-400"></i>
                        </div>
                    </div>
                    @error('match_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status Pertandingan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="status" name="status" required 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                        <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="finished" {{ old('status') === 'finished' ? 'selected' : '' }}>Finished</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-600">Status default adalah "Scheduled" untuk pertandingan yang akan datang</p>
            </div>

            <!-- Additional Information -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900 mb-1">Informasi Penting</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Pastikan kedua tim berbeda</li>
                            <li>• Tanggal pertandingan tidak boleh di masa lalu</li>
                            <li>• Setelah pertandingan dibuat, tiket akan otomatis tersedia untuk dijual</li>
                            <li>• Status dapat diubah nanti melalui halaman manajemen pertandingan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.matches') }}" 
                   class="inline-flex items-center justify-center px-6 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pertandingan
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.teams.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900">Tambah Tim Baru</p>
                    <p class="text-sm text-gray-600">Buat tim sepak bola baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.matches') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900">Lihat Semua Pertandingan</p>
                    <p class="text-sm text-gray-600">Kelola pertandingan yang ada</p>
                </div>
            </a>
            
            <a href="{{ route('admin.areas') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map text-purple-600"></i>
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900">Kelola Area Stadion</p>
                    <p class="text-sm text-gray-600">Atur kursi dan harga tiket</p>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
const teams = @json($teams);
const homeTeamSelect = document.getElementById('home_team_id');
const awayTeamSelect = document.getElementById('away_team_id');
const matchPreview = document.getElementById('matchPreview');

function updateMatchPreview() {
    const homeTeamId = homeTeamSelect.value;
    const awayTeamId = awayTeamSelect.value;
    
    if (homeTeamId && awayTeamId && homeTeamId !== awayTeamId) {
        const homeTeam = teams.find(team => team.id == homeTeamId);
        const awayTeam = teams.find(team => team.id == awayTeamId);
        
        if (homeTeam && awayTeam) {
            document.getElementById('homeTeamName').textContent = homeTeam.name;
            document.getElementById('homeTeamCity').textContent = homeTeam.city;
            document.getElementById('awayTeamName').textContent = awayTeam.name;
            document.getElementById('awayTeamCity').textContent = awayTeam.city;
            
            matchPreview.classList.remove('hidden');
        }
    } else {
        matchPreview.classList.add('hidden');
    }
}

function validateTeamSelection() {
    const homeTeamId = homeTeamSelect.value;
    const awayTeamId = awayTeamSelect.value;
    
    if (homeTeamId && awayTeamId && homeTeamId === awayTeamId) {
        alert('Tim tuan rumah dan tim tamu tidak boleh sama!');
        awayTeamSelect.value = '';
        updateMatchPreview();
    }
}

homeTeamSelect.addEventListener('change', function() {
    updateMatchPreview();
    validateTeamSelection();
});

awayTeamSelect.addEventListener('change', function() {
    updateMatchPreview();
    validateTeamSelection();
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const homeTeamId = homeTeamSelect.value;
    const awayTeamId = awayTeamSelect.value;
    const matchDate = document.getElementById('match_date').value;
    const matchTime = document.getElementById('match_time').value;
    
    if (!homeTeamId || !awayTeamId) {
        e.preventDefault();
        alert('Silakan pilih tim tuan rumah dan tim tamu!');
        return;
    }
    
    if (homeTeamId === awayTeamId) {
        e.preventDefault();
        alert('Tim tuan rumah dan tim tamu tidak boleh sama!');
        return;
    }
    
    if (!matchDate || !matchTime) {
        e.preventDefault();
        alert('Silakan isi tanggal dan waktu pertandingan!');
        return;
    }
    
    // Check if date is not in the past
    const selectedDateTime = new Date(matchDate + 'T' + matchTime);
    const now = new Date();
    
    if (selectedDateTime <= now) {
        e.preventDefault();
        alert('Tanggal dan waktu pertandingan tidak boleh di masa lalu!');
        return;
    }
});

// Initialize preview if values are already selected (for old input)
if (homeTeamSelect.value || awayTeamSelect.value) {
    updateMatchPreview();
}
</script>
@endsection