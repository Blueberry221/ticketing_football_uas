<!DOCTYPE html>
<html>
<head>
    <title>Pilih Pertandingan dan Seat</title>
</head>
<body>
    <h1>Order Tiket</h1>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form action="{{ route('order.checkout') }}" method="POST">
        @csrf

        <label for="match_id">Pilih Pertandingan:</label>
        <select name="match_id" id="match_id" required>
            @foreach ($matches as $match)
                <option value="{{ $match->id }}">
                    {{ $match->homeTeam->name ?? 'N/A' }} vs {{ $match->awayTeam->name ?? 'N/A' }} 
                    ({{ \Carbon\Carbon::parse($match->match_date)->translatedFormat('d F Y H:i') }})
                </option>
            @endforeach
        </select>
        <br><br>

        
        <label for="seat_id">Pilih Kursi:</label>
        <select name="seat_id" id="seat_id" required>
            @foreach ($seats as $seat)
                <option value="{{ $seat->id }}">
                     Kursi {{ $seat->number }} - Tribun {{ $seat->area->placement }} ({{ $seat->area->status }}) 
                    - Rp{{ number_format($seat->area->price, 0, ',', '.') }}
                </option>
            @endforeach
        </select>
        <br><br>

        <button type="submit">Bayar Sekarang</button>
    </form>
</body>
</html>
