<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Bank Mini Gridas</title>
    
    <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS (Vite / CDN) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Opsi Fallback CDN jika belum setup Vite: -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #03153b;
        }
        /* Background Foto diperluas ke kiri (mengambil 82% layar) */
        .right-photo-bg {
            background-image: url('{{ asset('storage/image/bankmini.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center 48%;
        }
        /* Titik lebur gradasi ditarik lebih ke kiri agar area foto mendominasi */
        .blend-gradient {
            background: linear-gradient(90deg, #03153b 0%, #03153b 20%, rgba(3,21,59,0.92) 35%, rgba(3,21,59,0.5) 55%, rgba(3,21,59,0.1) 100%);
        }
        /* Custom Gradient untuk Tombol Purple/Pink Gradient */
        .btn-gradient-purple {
            background: linear-gradient(135deg, #a78bfa 0%, #c084fc 50%, #e879f9 100%);
        }
        .btn-gradient-purple:hover {
            opacity: 0.95;
        }
        /* Gradient Teks Gridas */
        .text-gradient-purple {
            background: linear-gradient(135deg, #a78bfa 0%, #e879f9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Keyframes untuk Animasi Masuk (Fade In Down & Up) */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .animation-delay-200 {
            animation-delay: 0.2s;
        }
        .animation-delay-400 {
            animation-delay: 0.4s;
        }
    </style>
</head>
<body class="text-white min-h-screen flex flex-col justify-between selection:bg-purple-500 selection:text-white bg-[#03153b] relative overflow-x-hidden">

    <!-- Area Foto diperluas dengan efek masuk halus -->
    <div class="absolute top-0 right-0 w-full lg:w-[82%] h-full right-photo-bg z-0 opacity-0 animate-fade-in-down">
        <div class="absolute inset-0 blend-gradient"></div>
    </div>

    <!-- NAVBAR dengan Transisi Masuk -->
    <nav class="relative z-10 bg-[#0a2357]/80 backdrop-blur-md px-6 py-4 flex items-center justify-between border-b border-blue-900/50 shadow-md animate-fade-in-down">
        <!-- Logo & Brand Name -->
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#0a2357] shadow transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                <i class="fa-solid fa-building-columns text-xl"></i>
            </div>
            <span class="text-xl md:text-2xl font-bold tracking-wide text-white transition-colors duration-300 group-hover:text-purple-300">GRIDAS BANK</span>
        </div>

        <!-- Auth Buttons Right -->
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="px-5 py-1.5 rounded-full border border-blue-400/80 text-white font-medium hover:bg-blue-600/30 transition-all duration-300 hover:scale-105 text-sm md:text-base">
                Login
            </a>
            <a href="{{ route('register') }}" class="btn-gradient-purple px-5 py-1.5 rounded-full text-white font-medium shadow transition-all duration-300 hover:scale-105 text-sm md:text-base">
                Register
            </a>
        </div>
    </nav>

    <!-- HERO / MAIN CONTENT -->
    <main class="relative z-10 max-w-7xl mx-auto px-6 py-8 md:py-12 w-full flex-1 flex flex-col justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Side: Information & Action (Animasi Fade In Up) -->
            <div class="lg:col-span-7 space-y-6 opacity-0 animate-fade-in-up animation-delay-200">
                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight">
                    Bank Mini <span class="text-gradient-purple">Gridas</span>
                </h1>
                
                <!-- Description -->
                <div class="text-blue-200/90 text-base sm:text-lg leading-relaxed max-w-xl font-normal space-y-1">
                    <p>Selamat datang di project</p>
                    <p>Bank mini gridas by kelompok 2 edutipa</p>
                    <p class="font-semibold text-white">SMKN 2 SUMEDANG</p>
                </div>

                <!-- Call to Action Buttons -->
                <div class="flex items-center gap-4 pt-2">
                    <a href="{{ route('login') }}" class="btn-gradient-purple px-7 py-2.5 rounded-full text-white font-semibold shadow-lg hover:shadow-purple-500/40 transition-all duration-300 hover:scale-105 active:scale-95">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-7 py-2.5 rounded-full border border-pink-400 text-white font-semibold hover:bg-pink-500/20 transition-all duration-300 hover:scale-105 active:scale-95">
                        Register
                    </a>
                </div>
            </div>

            <!-- Right Side Spacer -->
            <div class="lg:col-span-5 hidden lg:block"></div>

        </div>

        <!-- LAYANAN KAMI SECTION (Animasi Masuk Bertahap) -->
        <div class="mt-12 md:mt-16 opacity-0 animate-fade-in-up animation-delay-400">
            <h2 class="text-lg font-bold text-white mb-4 tracking-wide">Layanan kami :</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                
                <!-- Card 1: Setor Tunai -->
                <div class="bg-[#051c4a]/90 border border-blue-500/40 rounded-xl p-4 flex items-center gap-4 hover:border-purple-400 hover:bg-[#08245e]/90 transition-all duration-300 hover:-translate-y-1.5 cursor-pointer shadow-lg backdrop-blur-sm group">
                    <div class="w-12 h-12 rounded-full bg-sky-500 flex items-center justify-center text-white shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <i class="fa-solid fa-money-bill-transfer text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm sm:text-base group-hover:text-purple-300 transition-colors">Setor tunai</h3>
                        <p class="text-xs text-blue-300">Mudah dan cepat</p>
                    </div>
                </div>

                <!-- Card 2: Tarik Tunai -->
                <div class="bg-[#051c4a]/90 border border-blue-500/40 rounded-xl p-4 flex items-center gap-4 hover:border-purple-400 hover:bg-[#08245e]/90 transition-all duration-300 hover:-translate-y-1.5 cursor-pointer shadow-lg backdrop-blur-sm group">
                    <div class="w-12 h-12 rounded-full bg-sky-500 flex items-center justify-center text-white shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <i class="fa-solid fa-credit-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm sm:text-base group-hover:text-purple-300 transition-colors">Tarik tunai</h3>
                        <p class="text-xs text-blue-300">Akses dana kapan saja</p>
                    </div>
                </div>

                <!-- Card 3: Riwayat Transaksi -->
                <div class="bg-[#051c4a]/90 border border-blue-500/40 rounded-xl p-4 flex items-center gap-4 hover:border-purple-400 hover:bg-[#08245e]/90 transition-all duration-300 hover:-translate-y-1.5 cursor-pointer shadow-lg backdrop-blur-sm group">
                    <div class="w-12 h-12 rounded-full bg-sky-500 flex items-center justify-center text-white shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                        <i class="fa-solid fa-receipt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm sm:text-base group-hover:text-purple-300 transition-colors">Riwayat transaksi</h3>
                        <p class="text-xs text-blue-300">Pantau semua transaksi</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="relative z-10 text-center py-4 text-xs text-blue-300 border-t border-blue-900/40 bg-[#03153b]/90 backdrop-blur-sm">
        &copy; {{ date('Y') }} Kelompok 2 Edutipa - SMKN 2 Sumedang. All Rights Reserved.
    </footer>

</body>
</html>