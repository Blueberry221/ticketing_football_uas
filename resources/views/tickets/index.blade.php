<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pembelian Tiket</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .navbar {
                background-color: #1a2b4a;
            }

            .navbar a {
                color: #d4a017;
            }

            .navbar a:hover,
            .navbar a.active {
                color: #fff;
                background-color: #d4a017;
                border-radius: 0.25rem;
            }

            .form-select,
            .form-button {
                transition: all 0.3s ease;
            }

            .form-button:hover {
                background-color: #b88c14;
            }
        </style>
    </head>

    <body class="bg-gray-100 font-sans">
        <!-- Navbar -->
        <nav class="navbar py-4 px-6 shadow-md">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-yellow-400">Tiketing Football</a>

            </div>
        </nav>

        <!-- Ticket Purchase Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pembelian Tiket: {{ $Matches->home_team_id->name }} vs
                {{ $Matches->away_team_id->name }}</h2>
            <p class="text-gray-600 mb-2">Tanggal: {{ $Matches->match_date->format('d M Y, H:i') }}</p>
            <p class="text-gray-600 mb-6">Stadion: {{ $Matches->stadium }}</p>

            @if (session('success'))
                <div class="bg-green-100 text-green-900 p-4 rounded-md mb-6">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-900 p-4 rounded-md mb-6">{{ session('error') }}</div>
            @endif
            @if (session('info'))
                <div class="bg-blue-100 text-blue-900 p-4 rounded-md mb-6">{{ session('info') }}</div>
            @endif

            <form action="{{ route('tickets.purchase') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                @csrf
                <input type="hidden" name="match_id" value="{{ $Matches->id }}">
                <div class="mb-4">
                    <label for="seat_id" class="block text-gray-700 font-semibold mb-2">Pilih Kursi</label>
                    <select name="seat_id" id="seat_id"
                        class="form-select w-full p-2 border border-gray-300 rounded-md" required>
                        <option value="">Pilih kursi</option>
                        @foreach ($seats as $seat)
                            <option value="{{ $seat->id }}">{{ $seat->area->name }} - {{ $seat->number }} (Rp
                                {{ number_format($seat->area->price, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 font-semibold mb-2">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method"
                        class="form-select w-full p-2 border border-gray-300 rounded-md" required>
                        <option value="">Pilih metode pembayaran</option>
                        @foreach ($payment_methods as $method)
                            <option value="{{ $method }}">{{ $method }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="form-button bg-yellow-400 text-gray-900 px-6 py-2 rounded-md font-semibold hover:bg-yellow-500">Pesan
                    Tiket</button>
            </form>

            <h3 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Informasi Harga</h3>
            <ul class="list-disc pl-6 text-gray-600">
                <li>Utara/Selatan: Rp 100,000</li>
                <li>Timur/Barat: Rp 250,000</li>
            </ul>

            <a href="{{ route('schedule') }}"
                class="inline-block mt-6 bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700">Kembali ke
                Jadwal</a>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        </footer>
    </body>

    </html>
</x-app-layout>
