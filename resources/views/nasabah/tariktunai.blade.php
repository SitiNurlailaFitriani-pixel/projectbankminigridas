@php
    /* Mengambil nama user dari variabel controller atau session */
    $username = $username ?? session('username', 'Nasabah');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Tarik Tunai</title>

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
                <a href="{{ route('homenasabah') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
                </a>

                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-user w-5"></i>
                    Profil Rekening
                </a>

                <!-- Tarik Tunai (Active) -->
                <a href="{{ route('tariktunai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
                    <i class="fa-solid fa-wallet w-5"></i>
                    Tarik Tunai
                </a>

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

        <!-- Card Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1 flex flex-col justify-between">
            
            <div class="space-y-6">
                <!-- Header Halaman -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-[#1E75D8] text-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-[#0c235b]">Tarik Tunai</h2>
                        <p class="text-slate-500 font-medium text-sm">Ambil dana dari rekening Anda</p>
                    </div>
                </div>

                <!-- Alert Informasi Konfirmasi Petugas -->
                <div class="bg-amber-50 border border-amber-300 p-4 rounded-2xl flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-info text-amber-600 text-lg mt-0.5 shrink-0"></i>
                    <div class="text-xs text-amber-900 font-medium">
                        <p class="font-bold text-amber-950">Informasi Transaksi:</p>
                        <p class="mt-0.5 leading-relaxed">
                            Setelah melakukan pengajuan tarik tunai, silakan datangi teller/petugas Bank Gridas untuk melakukan konfirmasi dan pengambilan uang tunai secara langsung.
                        </p>
                    </div>
                </div>

                <!-- Notifikasi Berhasil -->
                @if(session('success'))
                    <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl text-sm font-semibold flex items-center justify-between">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-600"></i> {{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="font-bold ml-4">&times;</button>
                    </div>
                @endif

                <!-- Notifikasi Error/Gagal -->
                @if(session('error'))
                    <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded-2xl text-sm font-semibold flex items-center justify-between">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-xmark text-red-600"></i> {{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="font-bold ml-4">&times;</button>
                    </div>
                @endif

                <form action="{{ route('tariktunai.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Kotak Saldo Tersedia -->
                    <div class="bg-[#e8f1fb] border-2 border-[#1E75D8] rounded-2xl p-6 text-[#0c235b] shadow-sm">
                        <p class="text-xs font-semibold text-slate-500 mb-1">Saldo Tersedia</p>
                        <p class="text-3xl font-extrabold">
                            Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Input Jumlah Penarikan -->
                    <div>
                        <label for="nominal" class="block text-sm font-bold text-[#0c235b] mb-1.5">Jumlah Penarikan</label>
                        <div class="flex rounded-xl border-2 border-[#0c235b] overflow-hidden focus-within:ring-2 focus-within:ring-blue-400">
                            <span class="px-5 py-3 text-[#0c235b] font-bold border-r-2 border-[#0c235b] bg-[#e8f1fb] flex items-center justify-center text-sm">
                                Rp
                            </span>
                            <input 
                                type="number" 
                                name="nominal" 
                                id="nominal" 
                                placeholder="0" 
                                min="10000"
                                value="{{ old('nominal') }}"
                                class="w-full px-4 py-3 text-slate-800 focus:outline-none font-medium text-sm"
                                required
                            >
                        </div>
                        @error('nominal')
                            <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input Keterangan -->
                    <div>
                        <label for="keterangan" class="block text-sm font-bold text-[#0c235b] mb-1.5">Keterangan</label>
                        <input 
                            type="text" 
                            name="keterangan" 
                            id="keterangan" 
                            placeholder="Tuliskan keterangan (opsional)"
                            value="{{ old('keterangan') }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-[#0c235b] text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-slate-400 font-medium text-sm"
                        >
                        @error('keterangan')
                            <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-2 flex justify-center">
                        <button type="submit" class="w-full max-w-sm py-3.5 bg-[#1E75D8] hover:bg-[#165eb0] text-white font-bold text-base rounded-2xl transition shadow-md">
                            Tarik Sekarang
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </main>

</body>
</html>