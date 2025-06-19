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
                background-position: -60px;
                background-repeat: no-repeat;
            }

            .hero-bgr {
                background-image: url('https://www.itl.cat/pngfile/big/261-2613391_wallpaper-sepak-bola.jpg');
                background-size: 670px;
                background-position: center;
                background-repeat: no-repeat;
            }

            .highlight-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .highlight-card:hover {
                transform: scale(1.02);
            }

            .arrow {
                transition: color 0.3s ease;
            }

            .arrow:hover {
                color: #facc15;
            }
            
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
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

        <div class="bg-gray-900 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-yellow-400 mb-6">HIGHLIGHT</h2>
                <div class="flex items-center space-x-4">
                    <!-- Tombol kiri -->

                    <button id="prevBtn"
                        class="arrow text-4xl text-yellow-400 cursor-pointer select-none">&lt;</button>

                    <!-- Container scroll -->
                    <div class="overflow-hidden w-full">
                        <div id="carousel" class="flex space-x-4 overflow-x-auto scroll-smooth no-scrollbar">
                            <!-- Card 1 -->
                            <div
                                class="highlight-card bg-white rounded-lg p-4 min-w-[300px] max-w-xs shadow-md flex-shrink-0">
                                <img src="https://images.ps-aws.com/c?url=https%3A%2F%2Fimages.teamtalk.com%2Fcontent%2Fuploads%2F2025%2F06%2F13135215%2FTT-Bryan-Mbeumo-with-Man-utd-Spurs-badges-1-1-1320x742.jpg"
                                    class="w-full rounded-md" />
                                <p class="mt-3 text-sm"><strong>Bryan Mbeumo</strong> wants to join Manchester United...
                                </p>
                            </div>
                            <!-- Card 2 -->
                            <div
                                class="highlight-card bg-white rounded-lg p-4 min-w-[300px] max-w-xs shadow-md flex-shrink-0">
                                <img src="https://s.yimg.com/ny/api/res/1.2/aLQxDJRbybt4pxtMzw256g--/YXBwaWQ9aGlnaGxhbmRlcjt3PTY0MDtoPTQyNztjZj13ZWJw/https://media.zenfs.com/en/football_italia_articles_132/31d50a2d86d2d18067077d100d4193d0"
                                    class="w-full rounded-md" />
                                <p class="mt-3 text-sm">Not everyone at <strong>Inter</strong> wants Inzaghi to
                                    resist...</p>
                            </div>
                            <!-- Card 3 -->
                            <div
                                class="highlight-card bg-white rounded-lg p-4 min-w-[300px] max-w-xs shadow-md flex-shrink-0">
                                <img src="https://resources.premierleague.pulselive.com/photo-resources/2025/06/19/92949437-de9c-4bb8-8195-fdab906ad321/Summer-F.jpg?width=1400&height=800"
                                    class="w-full rounded-md" />
                                <p class="mt-3 text-sm"><strong>Premier League</strong> pre-season friendlies 2025/26...
                                </p>
                            </div>
                            <!-- Tambahan Card 4 dan 5 -->
                            <div
                                class="highlight-card bg-white rounded-lg p-4 min-w-[300px] max-w-xs shadow-md flex-shrink-0">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUZjJM8YSAICbhkz7TnWTaKOb6zgV0FbF_vQ&s class="w-full
                                    rounded-md" />
                                <p class="mt-3 text-sm"><strong>Jude Bellingham</strong> voted UCL Player of the Season
                                </p>
                            </div>
                            <div
                                class="highlight-card bg-white rounded-lg p-4 min-w-[300px] max-w-xs shadow-md flex-shrink-0">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWWfNpxzmL-dotb6ZtKHgZ8UfDfig3VXefAA&s"
                                    class="w-full rounded-md" />
                                <p class="mt-3 text-sm"><strong>Messi</strong> confirms Copa América will be his last
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol kanan -->
                    <button id="nextBtn"
                        class="arrow text-4xl text-yellow-400 cursor-pointer select-none">&gt;</button>
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
        <script>
            const carousel = document.getElementById('carousel');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const cardWidth = 270; // px, termasuk margin

            nextBtn.addEventListener('click', () => {
                carousel.scrollBy({
                    left: cardWidth,
                    behavior: 'smooth'
                });
            });

            prevBtn.addEventListener('click', () => {
                carousel.scrollBy({
                    left: -cardWidth,
                    behavior: 'smooth'
                });
            });
        </script>
    </body>

    </html>
</x-app-layout>
