@php
    // Ambil data dari variabel controller atau fallback ke session/default
    $username = $username ?? session('username', 'afina');
    $namaRekening = $nama_rekening ?? session('nama_rekening', $username);
    $noRekening = $no_rekening ?? session('no_rekening', '777202609167343');
    $saldoAnda = $saldo_anda ?? 0;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Dashboard Nasabah</title>
    
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
                <!-- Dashboard (Active) -->
                <a href="{{ route('homenasabah') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
                </a>

                <!-- Profil Rekening -->
                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
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
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1">
            
            <!-- Alert Notifikasi Berhasil -->
            @if (session('success'))
                <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl text-sm font-semibold flex items-center justify-between">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-600"></i> {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="font-bold ml-4">&times;</button>
                </div>
            @endif

            <!-- Alert Notifikasi Gagal/Error -->
            @if (session('error'))
                <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded-2xl text-sm font-semibold flex items-center justify-between">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-circle-xmark text-red-600"></i> {{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="font-bold ml-4">&times;</button>
                </div>
            @endif

            <!-- Header Menyapa Nasabah -->
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-[#0c235b]">
                    Selamat datang, {{ $namaRekening }} 👋
                </h2>
                <p class="text-slate-500 font-medium text-sm mt-1">
                    No Rekening : <span class="text-[#0c235b] font-bold">{{ $noRekening }}</span>
                </p>
            </div>

            <!-- Grid Saldo & Transaksi Terakhir -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Box Saldo Anda -->
                <div class="bg-[#0c235b] text-white rounded-2xl p-6 flex flex-col justify-center min-h-[160px] shadow-sm">
                    <p class="text-sm font-medium opacity-90 mb-1">Saldo Anda</p>
                    <p class="text-3xl font-extrabold tracking-wide">
                        Rp {{ number_format($saldoAnda, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Box Transaksi Terakhir -->
                <div class="border-2 border-[#0c235b] rounded-2xl p-6 flex flex-col justify-between min-h-[160px]">
                    <h3 class="text-sm font-bold text-[#0c235b] mb-2">Transaksi Terakhir</h3>

                    <div class="flex-1 flex flex-col justify-center py-1">
                        @if (isset($transaksi_terakhir) && count($transaksi_terakhir) > 0)
                            <div class="w-full space-y-2 overflow-y-auto max-h-[120px] pr-1">
                                @foreach ($transaksi_terakhir as $tx)
                                    @php
                                        // Pengecekan jenis transaksi
                                        $tipe = strtoupper($tx->tipe ?? $tx->jenis_transaksi ?? '');
                                        $isTarik = str_contains($tipe, 'TARIK');
                                        
                                        // Normalisasi teks status transaksi
                                        $rawStatus = strtolower($tx->status ?? 'pending');

                                        // Pengecekan Kategori Status
                                        $isPending  = in_array($rawStatus, ['pending', '0', 'menunggu', 'process', 'proses']);
                                        $isGagal    = in_array($rawStatus, ['gagal', 'ditolak', 'reject', 'canceled', '2']);
                                        $isBerhasil = in_array($rawStatus, ['berhasil', 'sukses', 'success', 'approved', '1']);
                                    @endphp

                                    <div class="flex items-center justify-between w-full text-xs py-2 border-b border-gray-100 last:border-0">
                                        <div class="flex items-center gap-2.5">
                                            <!-- Icon Transaksi -->
                                            <div class="w-7 h-7 {{ $isTarik ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-700' }} rounded-full flex items-center justify-center shrink-0">
                                                <i class="fa-solid {{ $isTarik ? 'fa-arrow-up' : 'fa-arrow-down' }} text-xs"></i>
                                            </div>

                                            <div>
                                                <span class="font-bold text-[#0c235b] uppercase block leading-tight">{{ $tx->tipe ?? 'TRANSAKSI' }}</span>
                                                
                                                <!-- TAMPILAN LABEL STATUS -->
                                                @if ($isPending)
                                                    <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-800 text-[9px] font-bold px-2 py-0.5 rounded-md mt-0.5 border border-amber-300">
                                                        <i class="fa-solid fa-clock text-[8px]"></i> PENDING
                                                    </span>
                                                @elseif ($isGagal)
                                                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-[9px] font-bold px-2 py-0.5 rounded-md mt-0.5 border border-red-300">
                                                        <i class="fa-solid fa-xmark text-[8px]"></i> DITOLAK
                                                    </span>
                                                @elseif ($isBerhasil)
                                                    <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-[9px] font-bold px-2 py-0.5 rounded-md mt-0.5 border border-emerald-300">
                                                        <i class="fa-solid fa-check text-[8px]"></i> BERHASIL
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-[9px] font-bold px-2 py-0.5 rounded-md mt-0.5 border border-gray-300">
                                                        {{ strtoupper($rawStatus) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Nominal & Detail Teks -->
                                        <div class="text-right">
                                            <span class="font-bold {{ $isPending ? 'text-amber-600' : ($isGagal ? 'text-gray-400 line-through' : ($isTarik ? 'text-red-600' : 'text-emerald-600')) }}">
                                                {{ $isTarik ? '-' : '+' }}Rp {{ number_format($tx->nominal ?? 0, 0, ',', '.') }}
                                            </span>
                                            
                                            @if ($isPending)
                                                <span class="block text-[9px] text-amber-700 font-medium mt-0.5">(Menunggu Persetujuan)</span>
                                            @elseif ($isGagal)
                                                <span class="block text-[9px] text-red-500 font-medium mt-0.5">(Transaksi Dibatalkan)</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-2">
                                <i class="fa-regular fa-folder-open text-3xl text-gray-400 mb-1"></i>
                                <p class="text-center text-gray-400 text-xs font-medium">Belum ada riwayat transaksi</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Menu Cepat Bawah -->
            <div>
                <h3 class="text-lg font-bold text-[#0c235b] mb-4">Menu cepat</h3>
                
                <div class="flex flex-wrap gap-4">
                    <!-- Tarik Tunai Button -->
                    <a href="{{ route('tariktunai') }}" class="w-28 h-28 bg-[#fef2e8] border-2 border-[#fb8c00] rounded-2xl flex flex-col items-center justify-center p-2 hover:scale-105 transition group shadow-sm">
                        <div class="w-11 h-11 bg-[#fb8c00] text-white rounded-full flex items-center justify-center mb-1">
                            <i class="fa-solid fa-wallet text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-[#e65100] text-center leading-tight">Tarik Tunai</span>
                    </a>

                    <!-- Riwayat Transaksi Button -->
                    <a href="{{ route('nasabah.riwayat') }}" class="w-28 h-28 bg-[#e8f1fb] border-2 border-[#1e88e5] rounded-2xl flex flex-col items-center justify-center p-2 hover:scale-105 transition group shadow-sm">
                        <div class="w-11 h-11 bg-[#1e88e5] text-white rounded-full flex items-center justify-center mb-1">
                            <i class="fa-solid fa-receipt text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-[#1565c0] text-center leading-tight">Riwayat<br>Transaksi</span>
                    </a>
                </div>
            </div>

        </div>

    </main>

</body>
</html>