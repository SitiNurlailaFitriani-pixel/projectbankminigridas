<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - GRIDAS BANK</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js untuk Notifikasi/Dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#DCE8FA] min-h-screen flex text-[#0A2558] overflow-x-hidden">

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
                <a href="{{ route('admin.homeadmin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-address-card w-5"></i>
                    Data Nasabah
                </a>
                <a href="{{ route('admin.rekening.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-id-card w-5"></i>
                    Data Rekening
                </a>
                <a href="{{ route('admin.setor_tunai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-money-bill-transfer w-5"></i>
                    Setor Tunai
                </a>
                <a href="{{ route('admin.tarik_tunai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-hand-holding-dollar w-5"></i>
                    Tarik Tunai
                </a>
                <a href="{{ route('admin.riwayat_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-list-check w-5"></i>
                    Riwayat Transaksi
                </a>
                <a href="{{ route('admin.laporan_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
                    <i class="fa-solid fa-chart-line w-5"></i>
                    Laporan Transaksi
                </a>
            </nav>
        </div>

        <!-- Logout Button -->
        <div class="pt-2">
            <hr class="border-white/20 mb-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 text-white/90 hover:text-red-300 px-3 py-1.5 font-semibold transition text-left">
                    <i class="fa-solid fa-right-from-bracket text-xl rotate-180"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama (Kanan) -->
    <main class="flex-1 p-6 flex flex-col h-screen overflow-y-auto">
        
        <!-- Top Bar Profil Header Admin & Lonceng Notifikasi -->
        <div class="flex justify-end items-center gap-6 mb-4">
            
            <!-- Lonceng Notifikasi Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-12 h-12 bg-[#e8f1fb] text-[#0c235b] rounded-full flex items-center justify-center hover:bg-[#d5e4f7] transition relative focus:outline-none" 
                        title="Konfirmasi Transaksi">
                    <i class="fa-solid fa-bell text-xl"></i>
                    
                    @if(isset($totalPendingCount) && $totalPendingCount > 0)
                        <span class="absolute top-0 right-0 bg-[#f05252] text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                            {{ $totalPendingCount > 99 ? '99+' : $totalPendingCount }}
                        </span>
                    @endif
                </button>

                <!-- Menu Dropdown Notifikasi -->
                <div x-show="open" 
                     @click.outside="open = false" 
                     x-transition
                     class="absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl overflow-hidden z-50 text-left border border-gray-100"
                     style="display: none;">
                    
                    <div class="bg-[#0b235a] text-white px-5 py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-rotate-left text-lg"></i>
                            <h4 class="text-base font-bold tracking-wide">Konfirmasi Transaksi</h4>
                        </div>
                        <span class="bg-[#f2b705] text-[#0b235a] text-xs font-extrabold px-3 py-1 rounded-full shadow-sm">
                            {{ $totalPendingCount ?? 0 }} Pending
                        </span>
                    </div>

                    <div class="p-4 space-y-4 max-h-80 overflow-y-auto">
                        @forelse($notifikasiPending ?? [] as $notif)
                            <div class="border-b border-gray-100 pb-3 last:border-b-0 last:pb-0">
                                <div class="flex items-start gap-3">
                                    <div class="w-11 h-11 bg-[#f5a623] text-white rounded-full flex items-center justify-center shrink-0 shadow-sm">
                                        <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                                    </div>
                                    <div class="flex-1 text-xs">
                                        <div class="flex items-center justify-between font-bold text-[#0A2558]">
                                            <span>{{ $notif->nama_nasabah }}</span>
                                            <span class="text-[11px] text-gray-400 font-medium">
                                                {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mt-0.5">
                                            Pengajuan <span class="font-semibold text-gray-800">{{ $notif->jenis }}</span> 
                                            sebesar <span class="font-bold text-emerald-600">Rp {{ number_format($notif->jumlah, 0, ',', '.') }}</span>
                                        </p>
                                        <p class="text-[11px] text-gray-400 italic mt-0.5">
                                            Rekening: {{ $notif->no_rekening }}
                                        </p>
                                        
                                        <div class="flex items-center gap-2 mt-3">
                                            <form action="{{ route('admin.tarik_tunai.setujui', $notif->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#009661] hover:bg-[#007d51] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm">
                                                    <i class="fa-solid fa-check text-xs"></i> Setujui
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.tarik_tunai.tolak', $notif->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#dc2626] hover:bg-[#b91c1c] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                    <i class="fa-solid fa-xmark text-xs"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-gray-400 text-xs">
                                Tidak ada pengajuan transaksi yang perlu dikonfirmasi saat ini.
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
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col space-y-6">
            
            <!-- Card Summary / Statistik Ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#e8f1fb] text-[#1E75D8] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Transaksi Filtered</p>
                        <h3 class="text-2xl font-bold text-[#0c235b]">{{ method_exists($transaksi, 'total') ? $transaksi->total() : $transaksi->count() }} Data</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Nominal Filtered</p>
                        <h3 class="text-2xl font-bold text-emerald-600">
                            Rp {{ number_format($totalNominal ?? 0, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Main Card Container -->
            <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1">
                
                <!-- Header Title -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-[#1E75D8] text-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-[#0c235b]">Laporan Transaksi</h1>
                        <p class="text-slate-500 font-medium text-sm">Rekapitulasi dan pembukuan seluruh transaksi nasabah.</p>
                    </div>
                </div>

                <!-- Filter & Search Form -->
                <form action="{{ route('admin.laporan_transaksi.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="relative md:col-span-2">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#0c235b] font-bold"></i>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari no. rekening / username..."
                                   class="w-full pl-11 pr-4 py-2.5 rounded-2xl border-2 border-[#0c235b] text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-gray-400">
                        </div>

                        <!-- Filter Jenis Transaksi -->
                        <div>
                            <select name="jenis" class="w-full px-4 py-2.5 rounded-2xl border-2 border-[#0c235b] text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
                                <option value="">Semua Jenis Transaksi</option>
                                <option value="Setor Tunai" {{ request('jenis') == 'Setor Tunai' || request('jenis') == 'setor' ? 'selected' : '' }}>Setor Tunai</option>
                                <option value="Tarik Tunai" {{ request('jenis') == 'Tarik Tunai' || request('jenis') == 'tarik' ? 'selected' : '' }}>Tarik Tunai</option>
                            </select>
                        </div>

                        <!-- Filter Tanggal -->
                        <div>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                                   class="w-full px-4 py-2.5 rounded-2xl border-2 border-[#0c235b] text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between gap-3 pt-2">
                        <div class="flex items-center gap-2">
                            <button type="submit" class="px-5 py-2.5 bg-[#1E75D8] text-white rounded-xl text-sm font-bold hover:bg-[#165eb0] transition flex items-center gap-2 shadow-sm">
                                <i class="fa-solid fa-filter"></i> Terapkan Filter
                            </button>

                            @if(request('search') || request('jenis') || request('tanggal'))
                                <a href="{{ route('admin.laporan_transaksi.index') }}" class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-300 transition">
                                    Reset
                                </a>
                            @endif
                        </div>

                        <!-- Tombol Cetak -->
                        <button type="submit" 
                                formaction="{{ route('admin.laporan_transaksi.cetak') }}" 
                                formtarget="_blank" 
                                class="px-5 py-2.5 bg-[#009661] text-white rounded-xl text-sm font-bold hover:bg-[#007d51] transition flex items-center gap-2 shadow-sm">
                            <i class="fa-solid fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                </form>

                <!-- Data Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-[#dbe7f6] text-[#0c235b] font-bold border-b border-gray-200">
                                <th class="p-4 border-r border-gray-200 w-16 text-center">#</th>
                                <th class="p-4 border-r border-gray-200">Tanggal & Waktu</th>
                                <th class="p-4 border-r border-gray-200">No. Rekening</th>
                                <th class="p-4 border-r border-gray-200">Nasabah</th>
                                <th class="p-4 border-r border-gray-200 text-center">Jenis Transaksi</th>
                                <th class="p-4 border-r border-gray-200 text-center">Status</th>
                                <th class="p-4 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-slate-700 font-medium">
                            @forelse($transaksi as $index => $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 border-r border-gray-200 text-slate-400 text-center">
                                        {{ method_exists($transaksi, 'firstItem') ? $transaksi->firstItem() + $index : $index + 1 }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 whitespace-nowrap text-slate-500">
                                        {{ \Carbon\Carbon::parse($item->created_at ?? $item->tanggal)->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 font-bold text-[#0c235b] whitespace-nowrap">
                                        {{ $item->no_rekening }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 whitespace-nowrap text-slate-700">
                                        {{ $item->username ?? $item->nama_nasabah ?? '-' }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-center whitespace-nowrap">
                                        @if(in_array(strtolower($item->jenis_transaksi ?? $item->jenis ?? ''), ['setor', 'setor_tunai', 'setor tunai']))
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-300">
                                                <i class="fa-solid fa-arrow-up text-[10px]"></i> Setor Tunai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-300">
                                                <i class="fa-solid fa-arrow-down text-[10px]"></i> Tarik Tunai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-center whitespace-nowrap">
                                        @if(strtolower($item->status ?? '') == 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-300">
                                                <i class="fa-solid fa-clock text-[10px]"></i> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-300">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i> Berhasil
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right font-bold text-slate-900 whitespace-nowrap">
                                        Rp {{ number_format($item->nominal ?? $item->jumlah ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400 font-medium">
                                        <i class="fa-regular fa-folder-open text-4xl mb-3 block"></i>
                                        Tidak ada data laporan transaksi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination Footer -->
                @if(method_exists($transaksi, 'currentPage'))
                <div class="flex items-center justify-between pt-2 text-sm">
                    <p class="text-gray-500 font-medium">
                        Menampilkan Halaman <span class="font-bold text-[#0c235b]">{{ $transaksi->currentPage() }}</span> dari <span class="font-bold text-[#0c235b]">{{ $transaksi->lastPage() }}</span>
                    </p>

                    <div class="flex items-center gap-2">
                        @if ($transaksi->onFirstPage())
                            <button class="px-3 py-1.5 rounded-lg text-gray-400 font-medium bg-gray-100 cursor-not-allowed text-xs flex items-center">
                                <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                            </button>
                        @else
                            <a href="{{ $transaksi->appends(request()->query())->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center">
                                <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                            </a>
                        @endif

                        @if ($transaksi->hasMorePages())
                            <a href="{{ $transaksi->appends(request()->query())->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center gap-1">
                                Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                            </a>
                        @else
                            <button class="px-3 py-1.5 rounded-lg text-gray-400 font-medium bg-gray-100 cursor-not-allowed text-xs flex items-center gap-1">
                                Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                            </button>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>
    </main>

</body>
</html>