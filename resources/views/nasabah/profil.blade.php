@php
    /* Ambil data nasabah dari session atau variabel controller */
    $username   = $username ?? session('username', 'Nasabah');
    $namaLengkap = $nasabah->nama ?? session('nama_rekening', $username);
    $noRekening  = $nasabah->no_rekening ?? session('no_rekening', '-');
    $email       = $nasabah->email ?? session('email', '-');
    $noHp        = $nasabah->no_hp ?? session('no_hp', '-');
    $saldoAnda   = $nasabah->saldo ?? $saldo_anda ?? 0;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Profil Rekening</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#DCE8FA] min-h-screen flex text-[#0A2558] overflow-x-hidden">

    <!-- Sidebar / Navigasi Kiri -->
    <aside class="w-64 bg-[#0A2558] text-white flex flex-col justify-between p-4 min-h-screen shrink-0">
        <div>
            <!-- Logo & Brand Name -->
            <div class="flex items-center gap-3 px-2 py-4 mb-4">
                <div class="bg-white text-[#0A2558] p-2 rounded-full w-10 h-10 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-building-columns text-lg"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight tracking-wider">GRIDAS</h1>
                    <h2 class="font-bold text-lg leading-tight tracking-wider">BANK</h2>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('homenasabah') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
                </a>

                <!-- Profil Rekening (Active) -->
                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
                    <i class="fa-solid fa-user w-5"></i>
                    Profil Rekening
                </a>
                
                <!-- Tarik Tunai -->
                <a href="{{ route('tariktunai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-wallet w-5"></i>
                    Tarik Tunai
                </a>

                <!-- Riwayat Transaksi -->
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-receipt w-5"></i>
                    Riwayat Transaksi
                </a>
            </nav>
        </div>

        <!-- Section Logout -->
        <div class="pt-2">
            <hr class="border-white/20 mb-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-white/90 hover:text-red-300 px-3 py-1.5 font-semibold transition w-full text-left">
                    <i class="fa-solid fa-right-from-bracket text-xl rotate-180"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama (Kanan) -->
    <main class="flex-1 p-6 flex flex-col h-screen overflow-y-auto">
        
        <!-- Top Bar Profil Header -->
        <div class="flex justify-end items-center gap-6 mb-4">
            <a href="{{ route('profil') }}" class="flex items-center gap-3 text-[#0c235b] font-bold text-base hover:opacity-80 transition pl-4">
                <i class="fa-solid fa-circle-user text-3xl"></i>
                <span>{{ $username }}</span>
            </a>
        </div>

        <!-- Card Putih Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1 flex flex-col justify-between">
            
            <div class="space-y-6">
                <!-- Header Profil -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-[#1E75D8] text-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-[#0c235b]">Profil Rekening</h2>
                        <p class="text-slate-500 font-medium text-sm">Informasi detail akun nasabah Anda</p>
                    </div>
                </div>

                <!-- Card Info Saldo Utama -->
                <div class="bg-gradient-to-r from-[#0c235b] to-[#1E75D8] text-white rounded-2xl p-6 shadow-sm flex justify-between items-center">
                    <div>
                        <p class="text-xs uppercase font-semibold tracking-wider opacity-80">Total Saldo Aktif</p>
                        <p class="text-3xl font-extrabold mt-1">
                            Rp {{ number_format($saldoAnda, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="fa-solid fa-wallet text-2xl text-white"></i>
                    </div>
                </div>

                <!-- Detail Informasi Nasabah -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Nama Pemilik Rekening -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <span class="text-xs font-semibold text-gray-400 uppercase block mb-1">Nama Pemilik Rekening</span>
                        <span class="font-bold text-[#0c235b] text-base">{{ $namaLengkap }}</span>
                    </div>

                    <!-- Nomor Rekening -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <span class="text-xs font-semibold text-gray-400 uppercase block mb-1">Nomor Rekening</span>
                        <span class="font-bold text-[#0c235b] text-base tracking-wide">{{ $noRekening }}</span>
                    </div>

                    <!-- Alamat Email -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <span class="text-xs font-semibold text-gray-400 uppercase block mb-1">Alamat Email</span>
                        <span class="font-bold text-[#0c235b] text-base">{{ $email }}</span>
                    </div>

                    <!-- Nomor HP / Telepon -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <span class="text-xs font-semibold text-gray-400 uppercase block mb-1">Nomor Telepon / HP</span>
                        <span class="font-bold text-[#0c235b] text-base">{{ $noHp }}</span>
                    </div>
                
                </div>
            </div>

            <!-- Tombol Kembali ke Dashboard -->
            <div class="pt-2 flex justify-end">
                <a href="{{ route('homenasabah') }}" class="bg-[#1E75D8] hover:bg-[#165eb0] text-white font-bold py-2.5 px-6 rounded-xl transition duration-200 text-sm shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>

        </div>

    </main>

</body>
</html>