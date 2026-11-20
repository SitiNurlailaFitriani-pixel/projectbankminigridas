<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nasabah - GRIDAS BANK</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#0A2558] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-5xl flex flex-col md:flex-row items-center justify-between gap-8 py-8 px-4">
        
        <!-- Sisi Kiri (Branding & Ilustrasi) -->
        <div class="w-full md:w-1/2 text-white flex flex-col justify-between space-y-6">
            
            <!-- Logo & Nama Bank -->
            <div class="flex items-center gap-3">
                <div class="bg-white text-[#0A2558] p-2 rounded-full w-10 h-10 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-building-columns text-lg"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight tracking-wider">GRIDAS</h1>
                    <h2 class="font-bold text-lg leading-tight tracking-wider">BANK</h2>
                </div>
            </div>

            <!-- Judul & Deskripsi -->
            <div class="space-y-3 pt-4">
                <h1 class="text-3xl md:text-4xl font-bold leading-tight">Buat Akun Nasabah</h1>
                <p class="text-slate-200 text-sm md:text-base font-medium leading-relaxed max-w-md">
                    Mari bergabung dengan kami dan nikmati kemudahan transaksi bersama Bank Mini Gridas
                </p>
            </div>

            <!-- Ilustrasi Kartu & Koin -->
            <div class="pt-6 flex justify-start">
                <img 
                    src="{{ asset('storage/image/login.png') }}" 
                    alt="Ilustrasi Perbankan" 
                    class="w-80 h-auto object-contain drop-shadow-2xl"
                >
            </div>

        </div>

        <!-- Sisi Kanan (Form Pendaftaran) -->
        <div class="w-full md:w-[460px] bg-white rounded-3xl p-8 shadow-2xl text-[#0A2558]">
            <h2 class="text-2xl md:text-3xl font-bold mb-6">Daftar Nasabah</h2>

            <!-- Alert Pesan Error Validasi (jika ada) -->
            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-100 border border-red-300 text-red-800 text-sm rounded-2xl font-semibold">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Pendaftaran -->
            <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Input Nama Lengkap -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-[#0A2558]">Nama Lengkap</label>
                    <input 
                        type="text" 
                        name="nama_rekening"
                        value="{{ old('nama_rekening') }}"
                        placeholder="Masukan nama lengkap" 
                        required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-[#0A2558] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm font-medium transition"
                    >
                </div>

                <!-- Input Username -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-[#0A2558]">Username</label>
                    <input 
                        type="text" 
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Buat username" 
                        required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-[#0A2558] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm font-medium transition"
                    >
                </div>

                <!-- Input E-mail -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-[#0A2558]">E-mail</label>
                    <input 
                        type="email" 
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@gmail.com" 
                        required
                        class="w-full px-4 py-3 rounded-2xl border-2 border-[#0A2558] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm font-medium transition"
                    >
                </div>

                <!-- Input Password dengan Fitur Show/Hide -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-[#0A2558]">Password</label>
                    <div class="relative flex items-center">
                        <input 
                            id="passwordInput"
                            type="password" 
                            name="password"
                            placeholder="Minimal 6 karakter" 
                            required
                            class="w-full px-4 py-3 pr-11 rounded-2xl border-2 border-[#0A2558] text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm font-medium transition"
                        >
                        <!-- Tombol Toggle Eye -->
                        <button 
                            type="button" 
                            id="togglePassword"
                            class="absolute right-4 text-slate-400 hover:text-[#0A2558] focus:outline-none"
                        >
                            <!-- Icon Mata Terbuka -->
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Icon Mata Tertutup -->
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.038 10.038 0 013.682-.863c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tombol Daftar -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3.5 rounded-2xl bg-[#1E75D8] hover:bg-[#165eb0] text-white font-bold text-center transition-all duration-200 shadow-md text-base"
                    >
                        Daftar
                    </button>
                </div>

                <!-- Text Footer Link ke Halaman Login -->
                <div class="text-center pt-2">
                    <p class="text-sm font-semibold text-slate-600">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-[#1E75D8] hover:underline font-bold">Login</a>
                    </p>
                </div>

            </form>
        </div>

    </div>

    <!-- JavaScript Toggle Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            togglePasswordBtn.addEventListener('click', function (e) {
                e.preventDefault();
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            });
        });
    </script>

</body>
</html>