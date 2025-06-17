<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tiketing Football - Home</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .hero-overlay {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
            }

            .hero-bg {
                background-image: url('https://e0.pxfuel.com/wallpapers/21/905/desktop-wallpaper-football-legend-soccer-legends.jpg');
                background-size: 740px;
                background-position: 990px;
                background-repeat: no-repeat;
            }

            .hero-bgl {
                background-image: url('https://cdn0-production-images-kly.akamaized.net/iMdHePP0xZAeRQAobtSMZ7a62Mw=/1200x1200/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4223187/original/050095800_1668161921-Ilustrasi_-_Lionel_Messi__Harry_Kane__Kylian_Mbappe__Neymar__Cristiano_Ronaldo_Piala_Dunia_2022.jpg');
                background-size: 540px;
                background-position: -160px;
                background-repeat: no-repeat;
            }

            .hero-bgr {
                background-image: url('https://www.itl.cat/pngfile/big/261-2613391_wallpaper-sepak-bola.jpg');
                background-size: 640px;
                background-position: center;
                background-repeat: no-repeat;
            }
            .highlight-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .highlight-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            .arrow {
                transition: color 0.3s ease;
            }

            .arrow:hover {
                color: #facc15;
            }
        </style>
    </head>

    <body class="bg-gray-100">
        <!-- Hero Section -->
        <div class="relative w-full h-[400px]">
            <div class="absolute inset-0 hero-bg hero-overlay"></div>
            <div class="absolute inset-0 hero-bgl hero-overlay"></div>
            <div class="absolute inset-0 hero-bgr hero-overlay"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Football Ticketing</h1>
                    <p class="text-lg md:text-xl">Get your tickets for the most exciting football matches!</p>
                </div>
            </div>
        </div>

        <!-- Highlight Section -->
        <div class="bg-gray-900 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-yellow-400 mb-6">HIGHLIGHT</h2>
                <div class="flex items-center justify-between overflow-x-auto space-x-4 py-4">
                    <div class="arrow text-4xl text-yellow-400 cursor-pointer select-none">&lt;</div>
                    <div class="flex space-x-4">
                        <div class="highlight-card bg-white rounded-lg p-4 max-w-xs shadow-md">
                            <img src="https://via.placeholder.com/250x150" alt="Transfer News"
                                class="w-full rounded-md" />
                            <p class="mt-3 text-sm"><strong>Bryan Mbeumo</strong> wants to join Manchester United as
                                Ineos prepare talks to sign Brentford star</p>
                        </div>
                        <div class="highlight-card bg-white rounded-lg p-4 max-w-xs shadow-md">
                            <img src="https://via.placeholder.com/250x150" alt="Inzaghi News"
                                class="w-full rounded-md" />
                            <p class="mt-3 text-sm">Not everyone at <strong>Inter</strong> wants Inzaghi to resist
                                Al-Hilal offer</p>
                        </div>
                        <div class="highlight-card bg-white rounded-lg p-4 max-w-xs shadow-md">
                            <img src="https://via.placeholder.com/250x150" alt="Preseason News"
                                class="w-full rounded-md" />
                            <p class="mt-3 text-sm"><strong>Premier League</strong> pre-season friendlies 2025/26:
                                Fixtures, results, UK kick-off times</p>
                        </div>
                    </div>
                    <div class="arrow text-4xl text-yellow-400 cursor-pointer select-none">&gt;</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-2">
            <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8 text-center">
                <div class="mt-2">
                    <a href="{{ route('home') }}" class="text-yellow-400 hover:underline mx-2">Home</a>
                    <a href="{{ route('schedule') }}" class="text-yellow-400 hover:underline mx-2">Schedule</a>
                    <a href="{{ route('ticket') }}" class="text-yellow-400 hover:underline mx-2">Ticket</a>
                </div>
            </div>
        </footer>
    </body>

    </html>
</x-app-layout>
