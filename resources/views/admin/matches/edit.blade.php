@extends('layouts.admin')

@section('title', 'Edit Pertandingan')
@section('page-title', 'Edit Pertandingan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.matches') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Pertandingan</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</p>
        </div>
    </div>

    <!-- Current Match Info -->
    <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-futbol text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $match->match_date->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($match->status === 'scheduled') bg-blue-100 text-blue-800
                    @elseif($match->status === 'ongoing') bg-yellow-100 text-yellow-800
                    @elseif($match->status === 'finished') bg-green-100 text-green-800
                    @elseif($match->status === 'cancelled') bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($match->status) }}
                </span>
                <div class="text-sm text-gray-600 mt-1">{{ $match->tickets->where('status', 'booked')->count() }} tiket terjual</div>
            </div>
        </div>
    </div>

    @if($match->tickets->where('status', 'booked')->count() > 0)
        <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-yellow-900 mb-1">Peringatan</h4>
                    <p class="text-sm text-yellow-800">
                        Pertandingan ini sudah memiliki {{ $match->tickets->where('status', 'booked')->count() }} tiket yang terjual. 
                        Perubahan tertentu mungkin akan mempengaruhi tiket yang sudah dibeli.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Edit Informasi Pertandingan</h3>
        </div>
        
        <form action="{{ route('admin.matches.update', $match) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Team Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="home_team_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tim Tuan Rumah <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="home_team_id" name="home_team_id" required 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('home_team_id') border-red-500 @enderror"
                                {{ $match->tickets->where('status', 'booked')->count() > 0 ? 'disabled' : '' }}>
                            <option value="">Pilih Tim Tuan Rumah</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ (old('home_team_id', $match->home_team_id) == $team->id) ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->city }})
                                </option>
                            @endforeach
                        </select>
                        @if($match->tickets->where('status', 'booked')->count() > 0)
                            <input type="hidden" name="home_team_id" value="{{ $match->home_team_id }}">
                        @endif
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @if($match->tickets->where('status', 'booked')->count() > 0)
                        <p class="mt-1 text-sm text-yellow-600">Tim tidak dapat diubah karena sudah ada tiket yang terjual</p>
                    @endif
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
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('away_team_id') border-red-500 @enderror"
                                {{ $match->tickets->where('status', 'booked')->count() > 0 ? 'disabled' : '' }}>
                            <option value="">Pilih Tim Tamu</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ (old('away_team_id', $match->away_team_id) == $team->id) ? 'selected' : '' }}>
                                    {{ $team->name }} ({{ $team->city }})
                                </option>
                            @endforeach
                        </select>
                        @if($match->tickets->where('status', 'booked')->count() > 0)
                            <input type="hidden" name="away_team_id" value="{{ $match->away_team_id }}">
                        @endif
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @if($match->tickets->where('status', 'booked')->count() > 0)
                        <p class="mt-1 text-sm text-yellow-600">Tim tidak dapat diubah karena sudah ada tiket yang terjual</p>
                    @endif
                    @error('away_team_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Match Preview -->
            <div id="matchPreview" class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-center space-x-4">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-home text-blue-600 text-xl"></i>
                        </div>
                        <p id="homeTeamName" class="font-medium text-gray-900">{{ $match->homeTeam->name }}</p>
                        <p id="homeTeamCity" class="text-sm text-gray-600">{{ $match->homeTeam->city }}</p>
                    </div>
                    <div class="text-2xl font-bold text-gray-400">VS</div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-plane text-red-600 text-xl"></i>
                        </div>
                        <p id="awayTeamName" class="font-medium text-gray-900">{{ $match->awayTeam->name }}</p>
                        <p id="awayTeamCity" class="text-sm text-gray-600">{{ $match->awayTeam->city }}</p>
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
                               value="{{ old('match_date', $match->match_date->format('Y-m-d')) }}"
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
                               value="{{ old('match_time', $match->match_date->format('H:i')) }}"
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
                        <option value="scheduled" {{ old('status', $match->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="ongoing" {{ old('status', $match->status) === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="finished" {{ old('status', $match->status) === 'finished' ? 'selected' : '' }}>Finished</option>
                        <option value="cancelled" {{ old('status', $match->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-600">Perubahan status akan mempengaruhi ketersediaan tiket</p>
            </div>

            <!-- Match Statistics -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Statistik Pertandingan</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $match->tickets->count() }}</div>
                        <div class="text-sm text-gray-600">Total Kursi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $match->tickets->where('status', 'booked')->count() }}</div>
                        <div class="text-sm text-gray-600">Tiket Terjual</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $match->tickets->where('status', 'pending')->count() }}</div>
                        <div class="text-sm text-gray-600">Pending</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">
                            Rp {{ number_format($match->tickets->where('status', 'booked')->sum(function($ticket) { return $ticket->seat->price; })) }}
                        </div>
                        <div class="text-sm text-gray-600">Revenue</div>
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
                    Update Pertandingan
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button onclick="viewTickets()" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900">Lihat Tiket</p>
                    <p class="text-sm text-gray-600">Kelola tiket pertandingan ini</p>
                </div>
            </button>
            
            @if($match->status === 'scheduled')
                <button onclick="startMatch()" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-play text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">Mulai Pertandingan</p>
                        <p class="text-sm text-gray-600">Ubah status ke ongoing</p>
                    </div>
                </button>
            @endif
            
            @if($match->status === 'ongoing')
                <button onclick="finishMatch()" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-flag-checkered text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">Selesaikan Pertandingan</p>
                        <p class="text-sm text-gray-600">Ubah status ke finished</p>
                    </div>
                </button>
            @endif
            
            @if($match->tickets->where('status', 'booked')->count() === 0)
                <button onclick="deleteMatch()" class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-trash text-red-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">Hapus Pertandingan</p>
                        <p class="text-sm text-gray-600">Hapus pertandingan ini</p>
                    </div>
                </button>
            @endif
        </div>
    </div>
</div>

<script>
const teams = @json($teams);
const homeTeamSelect = document.getElementById('home_team_id');
const awayTeamSelect = document.getElementById('away_team_id');

function updateMatchPreview() {
    const homeTeamId = homeTeamSelect.value;
    const awayTeamId = awayTeamSelect.value;
    
    if (homeTeamId && awayTeamId) {
        const homeTeam = teams.find(team => team.id == homeTeamId);
        const awayTeam = teams.find(team => team.id == awayTeamId);
        
        if (homeTeam && awayTeam) {
            document.getElementById('homeTeamName').textContent = homeTeam.name;
            document.getElementById('homeTeamCity').textContent = homeTeam.city;
            document.getElementById('awayTeamName').textContent = awayTeam.name;
            document.getElementById('awayTeamCity').textContent = awayTeam.city;
        }
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

if (!homeTeamSelect.disabled) {
    homeTeamSelect.addEventListener('change', function() {
        updateMatchPreview();
        validateTeamSelection();
    });
}

if (!awayTeamSelect.disabled) {
    awayTeamSelect.addEventListener('change', function() {
        updateMatchPreview();
        validateTeamSelection();
    });
}

function viewTickets() {
    // Implementasi untuk melihat tiket
    alert('Fitur lihat tiket akan segera tersedia!');
}

function startMatch() {
    if (confirm('Apakah Anda yakin ingin memulai pertandingan ini?')) {
        updateStatus('ongoing');
    }
}

function finishMatch() {
    if (confirm('Apakah Anda yakin ingin menyelesaikan pertandingan ini?')) {
        updateStatus('finished');
    }
}

function deleteMatch() {
    if (confirm('Apakah Anda yakin ingin menghapus pertandingan ini? Tindakan ini tidak dapat dibatalkan.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.matches.destroy", $match) }}';
        
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
}

function updateStatus(status) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.matches.updateStatus", $match) }}';
    
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
    statusField.value = status;
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    form.appendChild(statusField);
    
    document.body.appendChild(form);
    form.submit();
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const homeTeamId = homeTeamSelect.value;
    const awayTeamId = awayTeamSelect.value;
    
    if (homeTeamId === awayTeamId) {
        e.preventDefault();
        alert('Tim tuan rumah dan tim tamu tidak boleh sama!');
        return;
    }
});
</script>
@endsection