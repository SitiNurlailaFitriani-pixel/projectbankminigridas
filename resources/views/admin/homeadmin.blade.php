<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Admin - GRIDAS BANK</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js untuk interaksi Dropdown Lonceng Notifikasi -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#dbe7f6] h-screen flex text-[#122e6f] overflow-hidden">

    <!-- Sidebar Left -->
    <aside class="w-64 bg-[#0A2558] text-white flex flex-col justify-between p-4 min-h-screen shrink-0">
        <div>
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3 px-2 py-4 mb-4">
                <div class="bg-white text-[#0A2558] p-2 rounded-full w-10 h-10 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-building-columns text-lg"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight tracking-wider">GRIDAS</h1>
                    <h2 class="font-bold text-lg leading-tight tracking-wider">BANK</h2>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-2">
                <a href="{{ route('admin.homeadmin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#2582ce] text-white font-medium text-sm">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition text-sm">
                    <i class="fa-solid fa-address-card w-5"></i>
                    Data Nasabah
                </a>
                <a href="{{ route('admin.rekening.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition text-sm">
                    <i class="fa-solid fa-id-card w-5"></i>
                    Data Rekening
                </a>
                <a href="{{ route('admin.setor_tunai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition text-sm">
                    <i class="fa-solid fa-money-bill-transfer w-5"></i>
                    Setor Tunai
                </a>
                <a href="{{ route('admin.tarik_tunai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition text-sm">
                    <i class="fa-solid fa-hand-holding-dollar w-5"></i>
                    Tarik Tunai
                </a>
                <a href="{{ route('admin.riwayat_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition text-sm">
                    <i class="fa-solid fa-list-check w-5"></i>
                    Riwayat Transaksi
                </a>
                <a href="{{ route('admin.laporan_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition text-sm">
                    <i class="fa-solid fa-chart-line w-5"></i>
                    Laporan Transaksi
                </a>
            </nav>
        </div>

        <!-- Section Logout -->
        <div class="pt-2">
            <hr class="border-white/20 mb-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-white/90 hover:text-red-300 px-3 py-1.5 font-semibold transition w-full text-left text-sm">
                    <i class="fa-solid fa-right-from-bracket text-xl rotate-180"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-8 flex flex-col justify-start h-screen overflow-y-auto">
        
        <!-- HEADER TOP BAR (SAMA PERSIS DENGAN KODE PETUGAS) -->
        <div class="flex justify-end items-center gap-6 mb-4">
            
            @php
                $pendingCount = isset($totalPendingCount) ? $totalPendingCount : 0;
            @endphp
            
            <div class="relative" x-data="{ open: false }">
                <!-- Tombol Lonceng (Background Solid #e8f1fb & hover #d5e4f7 persis Petugas) -->
                <button 
                    @click="open = !open" 
                    class="w-12 h-12 bg-[#e8f1fb] text-[#0c235b] rounded-full flex items-center justify-center hover:bg-[#d5e4f7] transition relative focus:outline-none"
                    title="Konfirmasi Transaksi"
                >
                    <i class="fa-solid fa-bell text-xl"></i>
                    
                    @if($pendingCount > 0)
                        <span class="absolute top-0 right-0 bg-[#f05252] text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                            {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                        </span>
                    @endif
                </button>

                <!-- Card Dropdown Notifikasi -->
                <div 
                    x-show="open" 
                    @click.outside="open = false" 
                    x-transition
                    class="absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl overflow-hidden z-50 text-left border border-gray-100"
                    style="display: none;"
                >
                    <!-- Header Warna Biru Gelap -->
                    <div class="bg-[#0b235a] text-white px-5 py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-rotate-left text-lg"></i>
                            <h4 class="text-base font-bold tracking-wide">Konfirmasi Transaksi</h4>
                        </div>
                        <span class="bg-[#f2b705] text-[#0b235a] text-xs font-extrabold px-3 py-1 rounded-full shadow-sm">
                            {{ $pendingCount }} Pending
                        </span>
                    </div>

                    <!-- Isi / List Item Notifikasi -->
                    <div class="p-4 space-y-4 max-h-80 overflow-y-auto">
                        @forelse($notifikasiPending ?? [] as $item)
                            <div class="border-b border-gray-100 pb-3 last:border-b-0 last:pb-0">
                                <div class="flex items-start gap-3">
                                    <div class="w-11 h-11 bg-[#f5a623] text-white rounded-full flex items-center justify-center shrink-0 shadow-sm">
                                        <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h5 class="font-bold text-[#0b235a] text-sm">{{ $item->nama_nasabah }}</h5>
                                            <span class="text-[11px] text-gray-400 font-medium">
                                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                            </span>
                                        </div>

                                        <p class="text-xs text-gray-600 mt-0.5">
                                            Pengajuan <span class="font-bold text-gray-800">{{ $item->jenis }}</span> sebesar 
                                            <span class="text-[#00a86b] font-bold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                                        </p>

                                        <p class="text-[11px] text-gray-400 italic mt-0.5">
                                            Rekening: {{ $item->no_rekening }}
                                        </p>

                                        <!-- Tombol Setujui dan Tolak -->
                                        <div class="flex items-center gap-2 mt-3">
                                            <form action="{{ route('admin.tarik_tunai.setujui', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#009661] hover:bg-[#007d51] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                    <span>Setujui</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.tarik_tunai.tolak', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#dc2626] hover:bg-[#b91c1c] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                    <span>Tolak</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-gray-400 text-xs">
                                Tidak ada permintaan transaksi yang pending.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="flex items-center gap-3 text-[#0c235b] font-bold text-base border-l border-gray-300 pl-4">
                <i class="fa-solid fa-circle-user text-3xl"></i>
                <span>Admin</span>
            </div>
        </div>

        <!-- Card Putih Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-8 flex-1">

            <!-- Alert Sukses -->
            @if(session('success'))
                <div class="mb-6 bg-[#d1fadf] border border-[#a6f4c5] text-[#027a48] px-5 py-3.5 rounded-2xl flex items-center gap-3 text-sm font-semibold shadow-sm">
                    <div class="w-5 h-5 rounded-full bg-[#12b76a] text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Alert Ditolak / Error -->
            @if(session('error'))
                <div class="mb-6 bg-[#fee4e2] border border-[#fecdca] text-[#b42318] px-5 py-3.5 rounded-2xl flex items-center gap-3 text-sm font-semibold shadow-sm">
                    <div class="w-5 h-5 rounded-full bg-[#f04438] text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </div>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Header Dashboard Admin -->
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-[#0c235b]">
                    Dashboard Admin
                </h2>
            </div>

            <!-- Statistics Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Card 1: Total Nasabah -->
                <div class="border-2 border-[#0c235b] rounded-2xl p-6 flex items-center gap-5">
                    <div class="w-16 h-16 bg-[#0c235b] text-white rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#0c235b]">Total Nasabah</p>
                        <p class="text-3xl font-extrabold text-[#0c235b] mt-1">{{ $totalNasabah }}</p>
                    </div>
                </div>

                <!-- Card 2: Total Rekening -->
                <div class="border-2 border-[#0c235b] rounded-2xl p-6 flex items-center gap-5">
                    <div class="w-16 h-16 bg-[#0c235b] text-white rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-id-card text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#0c235b]">Total Rekening</p>
                        <p class="text-3xl font-extrabold text-[#0c235b] mt-1">{{ $totalRekening }}</p>
                    </div>
                </div>

                <!-- Card 3: Total Transaksi -->
                <div class="border-2 border-[#0c235b] rounded-2xl p-6 flex items-center gap-5">
                    <div class="w-16 h-16 bg-[#0c235b] text-white rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-list-ol text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#0c235b]">Total Transaksi</p>
                        <p class="text-3xl font-extrabold text-[#0c235b] mt-1">{{ $totalTransaksi }}</p>
                    </div>
                </div>

            </div>

            <!-- Table Section: Transaksi Terbaru -->
            <div>
                <h3 class="text-lg font-bold text-[#0c235b] mb-4">Transaksi hari ini</h3>

                <div class="overflow-x-auto border border-gray-200 rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#dbe7f6] text-[#0c235b] font-bold border-b border-gray-200">
                                <th class="p-4 text-center border-r border-gray-200 w-1/4">Tanggal</th>
                                <th class="p-4 text-center border-r border-gray-200 w-1/4">Jenis</th>
                                <th class="p-4 text-center border-r border-gray-200 w-1/4">Jumlah</th>
                                <th class="p-4 text-center w-1/4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($transaksiHariIni as $transaksi)
                                @php
                                    $statusLower = strtolower($transaksi->status ?? '');
                                    $isPending   = in_array($statusLower, ['pending', '0', 'menunggu', 'process', 'proses']);
                                    $isDitolak   = in_array($statusLower, ['ditolak', 'gagal', 'reject', 'canceled', '2']);
                                @endphp
                                <tr class="hover:bg-gray-50 text-center">
                                    <td class="p-4 border-r border-gray-200 text-gray-700">
                                        {{ $transaksi->created_at ? \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-gray-700 font-medium">
                                        {{ $transaksi->jenis }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-gray-700 font-semibold">
                                        Rp {{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($isPending)
                                            <span class="inline-block px-4 py-1 border-2 border-amber-500 text-amber-600 bg-amber-50 rounded-xl text-xs font-semibold">
                                                Pending
                                            </span>
                                        @elseif($isDitolak)
                                            <span class="inline-block px-4 py-1 border-2 border-red-500 text-red-600 bg-red-50 rounded-xl text-xs font-semibold">
                                                {{ $transaksi->status }}
                                            </span>
                                        @else
                                            <span class="inline-block px-4 py-1 border-2 border-emerald-500 text-emerald-600 bg-emerald-50 rounded-xl text-xs font-semibold">
                                                {{ $transaksi->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-gray-500">
                                        Belum ada data transaksi hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>