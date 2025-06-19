{{-- <!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <h1>Processing Payment for Ticket #{{ $ticket->id }}</h1>

    <script type="text/javascript">
        window.onload = function() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Pembayaran sukses!");
                    console.log(result);
                },
                onPending: function(result){
                    alert("Pembayaran masih pending");
                    console.log(result);
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    console.log(result);
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };
    </script>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Memproses Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        /* Animated background particles */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 20px; height: 20px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 30px; height: 30px; left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 15px; height: 15px; left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 25px; height: 25px; left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 35px; height: 35px; left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { width: 20px; height: 20px; left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { width: 28px; height: 28px; left: 70%; animation-delay: 0.5s; }
        .particle:nth-child(8) { width: 18px; height: 18px; left: 80%; animation-delay: 1.5s; }
        .particle:nth-child(9) { width: 32px; height: 32px; left: 90%; animation-delay: 2.5s; }

        @keyframes float {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        .payment-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .payment-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ff6b6b);
            background-size: 300% 100%;
            animation: rainbow-flow 3s linear infinite;
            border-radius: 30px 30px 0 0;
        }

        @keyframes rainbow-flow {
            0% { background-position: 0% 50%; }
            100% { background-position: 300% 50%; }
        }

        .payment-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            position: relative;
            animation: pulse-glow 2s ease-in-out infinite;
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
        }

        @keyframes pulse-glow {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 20px rgba(102, 126, 234, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }

        .payment-icon::before {
            content: '💳';
            font-size: 50px;
            animation: bounce-icon 1.5s ease-in-out infinite;
        }

        @keyframes bounce-icon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        h1 {
            color: #333;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: title-glow 3s ease-in-out infinite;
        }

        @keyframes title-glow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2); }
        }

        .processing-text {
            color: #666;
            font-size: 18px;
            margin-bottom: 40px;
            line-height: 1.6;
            animation: fade-in-up 1s ease-out;
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading-container {
            margin: 30px 0;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid #e8ecff;
            border-top: 4px solid transparent;
            border-radius: 50%;
            margin: 0 auto 20px;
            position: relative;
            animation: spin 1s linear infinite;
            background: linear-gradient(45deg, #667eea, #764ba2);
            background-clip: border-box;
        }

        .loading-spinner::before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border-radius: 50%;
            border: 4px solid transparent;
            border-top: 4px solid #667eea;
            animation: spin 2s linear infinite reverse;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .dot {
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            animation: loading-dots 1.4s ease-in-out infinite;
        }

        .dot:nth-child(1) { animation-delay: 0s; }
        .dot:nth-child(2) { animation-delay: 0.2s; }
        .dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes loading-dots {
            0%, 80%, 100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            40% {
                transform: scale(1.2);
                opacity: 1;
            }
        }

        .status-message {
            background: linear-gradient(135deg, #e8f4fd, #f0f9ff);
            border: 2px solid #bee5eb;
            color: #0c5460;
            padding: 20px;
            border-radius: 15px;
            margin: 30px 0;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            animation: slide-in 0.8s ease-out;
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .status-message::before {
            content: '💡';
            font-size: 24px;
            margin-right: 10px;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e8ecff;
            border-radius: 10px;
            overflow: hidden;
            margin: 25px 0;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            background-size: 200% 100%;
            border-radius: 10px;
            animation: progress-flow 2s ease-in-out infinite, progress-width 3s ease-out;
            width: 0%;
        }

        @keyframes progress-flow {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        @keyframes progress-width {
            0% { width: 0%; }
            30% { width: 40%; }
            60% { width: 70%; }
            100% { width: 85%; }
        }

        .security-badges {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .security-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            color: #0369a1;
            padding: 10px 15px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #bae6fd;
            animation: fade-in 1s ease-out;
        }

        .security-badge:nth-child(1) { animation-delay: 0.2s; }
        .security-badge:nth-child(2) { animation-delay: 0.4s; }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .footer-text {
            margin-top: 30px;
            color: #888;
            font-size: 14px;
            line-height: 1.6;
            animation: fade-in 1.2s ease-out;
        }

        /* Custom alert styles */
        .custom-alert {
            position: fixed;
            top: 30px;
            right: 30px;
            max-width: 400px;
            padding: 20px 25px;
            border-radius: 15px;
            font-weight: 500;
            z-index: 1000;
            animation: slide-in-right 0.5s ease-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border: 2px solid #b8dabc;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border: 2px solid #f1b0b7;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            border: 2px solid #ffd93d;
        }

        .alert-pending {
            background: linear-gradient(135deg, #cce7ff, #b3d9ff);
            color: #004085;
            border: 2px solid #9ecaed;
        }

        @media (max-width: 768px) {
            .payment-container {
                padding: 30px 20px;
                margin: 10px;
                border-radius: 20px;
            }
            
            .payment-icon {
                width: 100px;
                height: 100px;
            }
            
            .payment-icon::before {
                font-size: 40px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .processing-text {
                font-size: 16px;
            }
            
            .custom-alert {
                top: 20px;
                right: 20px;
                left: 20px;
                max-width: none;
            }
            
            .security-badges {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="payment-container">
        <div class="payment-icon"></div>
        
        <h1>Processing Payment...</h1>
        
        <p class="processing-text">
            Kami sedang menyiapkan gateway pembayaran yang aman untuk Anda.<br>
            Mohon tunggu sebentar, proses ini tidak akan lama.
        </p>
        
        <div class="loading-container">
            <div class="loading-spinner"></div>
            <div class="loading-dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
        
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        
        <div class="status-message" id="statusMessage">
            <strong>Inisialisasi sistem pembayaran...</strong><br>
            Menghubungkan dengan server yang aman.
        </div>
        
        <div class="security-badges">
            <div class="security-badge">
                🔒 SSL Encrypted
            </div>
            <div class="security-badge">
                🛡️ Midtrans Secure
            </div>
        </div>
        
        <div class="footer-text">
            Powered by <strong>Midtrans Payment Gateway</strong><br>
            Transaksi Anda dilindungi dengan enkripsi tingkat perbankan
        </div>
        @if ($ticket->order && $ticket->order->status === 'pending')
    <form action="{{ route('manual.confirm', $ticket->order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin sudah membayar?');" style="margin-top: 20px;">
        @csrf
        <button type="submit" style="
            background: linear-gradient(135deg, #38a169, #2f855a);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        " onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
            ✅ Saya Sudah Membayar
        </button>
    </form>
@endif

    </div>

    <script type="text/javascript">
        // Enhanced alert system
        function showCustomAlert(message, type = 'info', duration = 5000) {
            // Remove existing alert
            const existingAlert = document.querySelector('.custom-alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            const alertDiv = document.createElement('div');
            alertDiv.className = `custom-alert alert-${type}`;
            
            // Add appropriate icon based on type
            let icon = '';
            switch(type) {
                case 'success': icon = '✅ '; break;
                case 'error': icon = '❌ '; break;
                case 'warning': icon = '⚠️ '; break;
                case 'pending': icon = '⏳ '; break;
                default: icon = 'ℹ️ '; break;
            }
            
            alertDiv.innerHTML = icon + message;
            document.body.appendChild(alertDiv);
            
            // Auto remove
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.style.animation = 'slide-in-right 0.3s ease-out reverse';
                    setTimeout(() => alertDiv.remove(), 300);
                }
            }, duration);
        }

        // Status message updater
        function updateStatus(message, icon = '💡') {
            const statusElement = document.getElementById('statusMessage');
            statusElement.innerHTML = `${icon} ${message}`;
        }

        // Progress simulation
        function simulateProgress() {
            const messages = [
                { text: 'Inisialisasi sistem pembayaran...', icon: '🔄' },
                { text: 'Menghubungkan dengan server aman...', icon: '🔗' },
                { text: 'Memvalidasi sesi pembayaran...', icon: '✓' },
                { text: 'Menyiapkan gateway pembayaran...', icon: '💳' }
            ];
            
            let currentStep = 0;
            const interval = setInterval(() => {
                if (currentStep < messages.length) {
                    updateStatus(messages[currentStep].text, messages[currentStep].icon);
                    currentStep++;
                } else {
                    clearInterval(interval);
                    updateStatus('Siap! Membuka jendela pembayaran...', '🚀');
                }
            }, 800);
        }

        // Start simulation when page loads
        window.addEventListener('load', function() {
            simulateProgress();
            
            // Initialize Midtrans Snap with delay for better UX
            setTimeout(() => {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){
                        console.log('Payment success:', result);
                        updateStatus('Pembayaran berhasil! Mengalihkan...', '🎉');
                        showCustomAlert('🎉 Selamat! Pembayaran Anda telah berhasil diproses. Tiket akan segera dikirim ke email Anda.', 'success', 8000);
                        
                        // Optional: Redirect after success
                        setTimeout(() => {
                            window.location.href = '/tickets'; // Uncomment if you have success page
                        }, 3000);
                    },
                    onPending: function(result){
                        console.log('Payment pending:', result);
                        updateStatus('Pembayaran sedang diproses...', '⏳');
                        showCustomAlert('⏳ Pembayaran Anda sedang diproses. Kami akan mengirim notifikasi setelah pembayaran dikonfirmasi.', 'pending', 8000);
                    },
                    onError: function(result){
                        console.log('Payment error:', result);
                        updateStatus('Terjadi kesalahan pembayaran.', '❌');
                        showCustomAlert('😔 Maaf, terjadi kesalahan dalam memproses pembayaran. Silakan coba lagi atau hubungi customer service jika masalah berlanjut.', 'error', 10000);
                    },
                    onClose: function(){
                        console.log('Payment popup closed');
                        updateStatus('Pembayaran dibatalkan.', '⚠️');
                        showCustomAlert('⚠️ Jendela pembayaran ditutup. Jika Anda mengalami kesulitan, silakan coba lagi atau hubungi customer service untuk bantuan.', 'warning', 8000);
                    }
                });
            }, 3000); // 3 second delay for better user experience
        });

        // Add some interactive feedback
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                updateStatus('Menunggu Anda kembali...', '👀');
            } else {
                updateStatus('Selamat datang kembali!', '👋');
            }
        });

        // Prevent accidental page refresh during payment
        window.addEventListener('beforeunload', function(e) {
            // Only show warning if payment is in progress
            const message = 'Pembayaran sedang berlangsung. Yakin ingin meninggalkan halaman?';
            e.returnValue = message;
            return message;
        });
    </script>
</body>
</html>