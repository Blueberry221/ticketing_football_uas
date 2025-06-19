{{-- <!DOCTYPE html>
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
</html> --}}
<x-app-layout>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pertandingan dan Seat</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #1c1c2d);
                min-height: 100vh;

            }

            .container {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(15px);
                border-radius: 25px;
                padding: 40px;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
                width: 100%;
                max-width: 800px;
                /* Keep the existing max-width */
                margin: 0 auto;
                /* Center horizontally */
                margin-top: 20px;
                /* Optional: Add some top margin for spacing */
            }


            @keyframes rainbow {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }
            }

            .header {
                text-align: center;
                margin-bottom: 40px;
            }

            .ticket-icon {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
                animation: bounce 2s infinite;
            }

            @keyframes bounce {

                0%,
                20%,
                50%,
                80%,
                100% {
                    transform: translateY(0);
                }

                40% {
                    transform: translateY(-10px);
                }

                60% {
                    transform: translateY(-5px);
                }
            }

            .ticket-icon::before {
                content: '🎫';
                font-size: 40px;
            }

            h1 {
                color: #333;
                font-size: 32px;
                font-weight: 800;
                margin-bottom: 10px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .subtitle {
                color: #666;
                font-size: 16px;
                margin-bottom: 20px;
            }

            .error-message {
                background: linear-gradient(135deg, #ff6b6b, #ee5a24);
                color: white;
                padding: 15px 20px;
                border-radius: 15px;
                margin-bottom: 30px;
                display: flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
                animation: shake 0.5s ease-in-out;
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                25% {
                    transform: translateX(-5px);
                }

                75% {
                    transform: translateX(5px);
                }
            }

            .error-message::before {
                content: '⚠';
                font-size: 20px;
            }

            .form-group {
                margin-bottom: 30px;
                position: relative;
            }

            label {
                display: block;
                font-weight: 600;
                color: #333;
                margin-bottom: 12px;
                font-size: 16px;
                position: relative;
            }

            label::before {
                content: '';
                position: absolute;
                left: -25px;
                top: 50%;
                transform: translateY(-50%);
                width: 4px;
                height: 20px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                border-radius: 2px;
            }

            .match-label::before {
                background: linear-gradient(135deg, #4ecdc4, #44a08d);
            }

            .seat-label::before {
                background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            }

            select {
                width: 100%;
                padding: 18px 20px;
                border: 2px solid #e1e8ed;
                border-radius: 15px;
                font-size: 16px;
                background: #f8f9ff;
                color: #333;
                transition: all 0.3s ease;
                cursor: pointer;
                appearance: none;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 15px center;
                background-repeat: no-repeat;
                background-size: 16px;
            }

            select:focus {
                outline: none;
                border-color: #667eea;
                background: #fff;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                transform: translateY(-2px);
            }

            select:hover {
                border-color: #b8c5f0;
                background: #fff;
            }

            #match_id {
                border-color: #4ecdc4;
            }

            #match_id:focus {
                border-color: #4ecdc4;
                box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.1);
            }

            #seat_id {
                border-color: #ff6b6b;
            }

            #seat_id:focus {
                border-color: #ff6b6b;
                box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
            }

            .select-wrapper {
                position: relative;
            }

            .select-wrapper::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(45deg, transparent 48%, rgba(102, 126, 234, 0.1) 49%, rgba(102, 126, 234, 0.1) 51%, transparent 52%);
                border-radius: 15px;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .select-wrapper:hover::after {
                opacity: 1;
            }

            .submit-btn {
                width: 100%;
                padding: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 15px;
                font-size: 18px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 1px;
                position: relative;
                overflow: hidden;
                margin-top: 20px;
            }

            .submit-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .submit-btn:hover::before {
                left: 100%;
            }

            .submit-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            }

            .submit-btn:active {
                transform: translateY(-1px);
            }

            .info-cards {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                margin-top: 30px;
            }

            .info-card {
                background: linear-gradient(135deg, #f8f9ff, #e8ecff);
                padding: 20px;
                border-radius: 15px;
                text-align: center;
                border: 2px solid #e1e8ed;
                transition: all 0.3s ease;
            }

            .info-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .info-card-icon {
                font-size: 30px;
                margin-bottom: 10px;
                display: block;
            }

            .info-card-title {
                font-weight: 600;
                color: #333;
                margin-bottom: 5px;
            }

            .info-card-desc {
                font-size: 14px;
                color: #666;
            }

            .step-indicator {
                display: flex;
                justify-content: space-between;
                margin-bottom: 40px;
                position: relative;
            }

            .step-indicator::before {
                content: '';
                position: absolute;
                top: 20px;
                left: 0;
                right: 0;
                height: 2px;
                background: #e1e8ed;
                z-index: 1;
            }

            .step {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #e1e8ed;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                color: #666;
                position: relative;
                z-index: 2;
                transition: all 0.3s ease;
            }

            .step.active {
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                transform: scale(1.1);
            }

            .step.completed {
                background: #4ecdc4;
                color: white;
            }

            @media (max-width: 768px) {
                .container {
                    padding: 30px 20px;
                    margin: 10px;
                }

                h1 {
                    font-size: 28px;
                }

                .info-cards {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }

                .step-indicator {
                    margin-bottom: 30px;
                }
            }

            /* Loading state */
            .loading {
                opacity: 0.7;
                pointer-events: none;
            }

            .loading .submit-btn {
                background: linear-gradient(135deg, #ccc, #999);
                cursor: not-allowed;
            }

            /* Success animation */
            @keyframes success {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            .success-animation {
                animation: success 0.6s ease-in-out;
            }
        </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="ticket-icon"></div>
            <h1>Order Tiket</h1>
            <p class="subtitle">Pilih pertandingan dan kursi favorit Anda</p>
        </div>

        <div class="step-indicator">
            <div class="step active">1</div>
            <div class="step">2</div>
            <div class="step">3</div>
        </div>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('order.checkout') }}" method="POST" id="orderForm">
            @csrf

            <div class="form-group">
                <label for="match_id" class="match-label">🏆 Pilih Pertandingan:</label>
                <div class="select-wrapper">
                    <select name="match_id" id="match_id" required>
                        @foreach ($matches as $match)
                            <option value="{{ $match->id }}">
                                {{ $match->homeTeam->name ?? 'N/A' }} vs {{ $match->awayTeam->name ?? 'N/A' }}
                                ({{ \Carbon\Carbon::parse($match->match_date)->translatedFormat('d F Y H:i') }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="seat_id" class="seat-label">🪑 Pilih Kursi:</label>
                <div class="select-wrapper">
                    <select name="seat_id" id="seat_id" required>
                        @foreach ($seats as $seat)
                            <option value="{{ $seat->id }}">
                                Kursi {{ $seat->number }} - Tribun {{ $seat->area->placement }} ({{ $seat->area->status }})
                                - Rp{{ number_format($seat->area->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                💳 Bayar Sekarang
            </button>
        </form>

        <div class="info-cards">
            <div class="info-card">
                <span class="info-card-icon">🔒</span>
                <div class="info-card-title">Pembayaran Aman</div>
                <div class="info-card-desc">Transaksi dilindungi enkripsi bank</div>
            </div>
            <div class="info-card">
                <span class="info-card-icon">⚡</span>
                <div class="info-card-title">Proses Cepat</div>
                <div class="info-card-desc">Konfirmasi tiket dalam hitungan detik</div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('orderForm');
            const submitBtn = document.getElementById('submitBtn');
            const matchSelect = document.getElementById('match_id');
            const seatSelect = document.getElementById('seat_id');
            const steps = document.querySelectorAll('.step');

            // Update step indicator based on form progress
            function updateStepIndicator() {
                if (matchSelect.value && seatSelect.value) {
                    steps[0].classList.add('completed');
                    steps[0].classList.remove('active');
                    steps[1].classList.add('active');
                } else if (matchSelect.value) {
                    steps[0].classList.add('active');
                    steps[1].classList.remove('active');
                }
            }

            // Add event listeners for form validation
            matchSelect.addEventListener('change', function() {
                updateStepIndicator();
                this.parentElement.classList.add('success-animation');
                setTimeout(() => {
                    this.parentElement.classList.remove('success-animation');
                }, 600);
            });

            seatSelect.addEventListener('change', function() {
                updateStepIndicator();
                this.parentElement.classList.add('success-animation');
                setTimeout(() => {
                    this.parentElement.classList.remove('success-animation');
                }, 600);
            });

            // Form submission with loading state
            form.addEventListener('submit', function(e) {
                // Show loading state
                document.body.classList.add('loading');
                submitBtn.innerHTML = '⏳ Memproses...';

                // Update step indicator
                steps[1].classList.add('completed');
                steps[1].classList.remove('active');
                steps[2].classList.add('active');

                // Note: Don't prevent default - let the form submit normally
                // The loading state will be visible until the page redirects
            });

            // Add hover effects for better UX
            const selectWrappers = document.querySelectorAll('.select-wrapper');
            selectWrappers.forEach(wrapper => {
                const select = wrapper.querySelector('select');

                select.addEventListener('focus', function() {
                    wrapper.style.transform = 'translateY(-2px)';
                });

                select.addEventListener('blur', function() {
                    wrapper.style.transform = 'translateY(0)';
                });
            });

            // Initial step indicator update
            updateStepIndicator();
        });

        // Add some interactive animations
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', function() {
                // Add a subtle success feedback
                this.style.borderColor = '#4ecdc4';
                setTimeout(() => {
                    this.style.borderColor = '';
                }, 1000);
            });
        });
    </script>
</body>
</html>
</x-app-layout>