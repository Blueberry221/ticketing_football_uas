<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pertandingan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .navbar {
            background-color: #1a2b4a;
        }
        .navbar a {
            color: #d4a017;
        }
        .navbar a:hover, .navbar a.active {
            color: #fff;
            background-color: #d4a017;
            border-radius: 0.25rem;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <nav class="navbar py-4 px-6 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-yellow-400">Tiketing Football</a>
            <div class="space-x-4">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }} px-3 py-2">Home</a>
                <a href="{{ route('schedule') }}" class="{{ request()->routeIs('schedule') ? 'active' : '' }} px-3 py-2">Schedule</a>
                <a href="{{ route('schedule') }}" class="{{ request()->routeIs('schedule') ? 'active' : '' }} px-3 py-2">Tickets</a>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }} px-3 py-2">Profile</a>
            </div>
        </div>
    </nav>

    <!-- Schedule Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Jadwal Pertandingan</h2>
        @if (session('info'))
            <div class="bg-blue-100 text-blue-900 p-4 rounded-md mb-6">{{ session('info') }}</div>
        @endif
        @if ($matches->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($matches as $match)
                    <div class="card bg-white rounded-lg p-6 shadow-md">
                        <h3 class="text-xl font-semibold mb-2">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h3>
                        <p class="text-gray-600 mb-1">Tanggal: {{ $match->match_date->format('d M Y, H:i') }}</p>
                        <p class="text-gray-600 mb-4">Stadion: Maguwoharjo</p>
                        <a href="{{ route('tickets', $match->id) }}" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-md font-semibold hover:bg-yellow-500 transition">Beli Tiket</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-600">Tidak ada pertandingan tersedia saat ini.</p>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="space-x-4">
                <a href="{{ route('home') }}" class="text-yellow-400 hover:underline">Home</a>
                <a href="{{ route('schedule') }}" class="text-yellow-400 hover:underline">Schedule</a>
                <a href="{{ route('schedule') }}" class="text-yellow-400 hover:underline">Tickets</a>
            </div>
            <p class="mt-4 text-sm">&copy; 2025 Tiketing Football. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
</x-app-layout>
