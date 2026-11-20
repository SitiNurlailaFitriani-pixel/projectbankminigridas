@php
    $username = $username ?? session('username', 'Nasabah');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Riwayat Transaksi</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome (Icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#DCE8FA] min-h-screen flex text-[#0A2558] overflow-x-hidden">

    <!-- Sidebar Left Nasabah -->
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

            <!-- Menu Sidebar khusus NASABAH -->
            <nav class="space-y-2">
                <a href="{{ route('homenasabah') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-user w-5"></i>
                    Profil Rekening
                </a>
                <a href="{{ route('tariktunai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-wallet w-5"></i>
                    Tarik Tunai
                </a>
                <!-- Riwayat Transaksi (Active) -->
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
                    <i class="fa-solid fa-receipt w-5"></i>
                    Riwayat Transaksi
                </a>
            </nav>
        </div>

        <!-- Tombol Logout -->
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

    <!-- Konten Utama -->
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
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-[#0c235b]">Riwayat Transaksi</h2>
                        <p class="text-slate-500 font-medium text-sm">Lihat semua transaksi anda</p>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <form action="{{ route('nasabah.riwayat') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center justify-between gap-3">
                    <!-- Search Input -->
                    <div class="relative flex-1 w-full">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#0c235b] font-bold"></i>
                        <input 
                            type="text" 
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari transaksi..." 
                            class="w-full pl-11 pr-4 py-2.5 rounded-2xl border-2 border-[#0c235b] text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-gray-400 font-medium"
                        >
                    </div>

                    <!-- Input Filter Tanggal & Tombol Aksi -->
                    <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                        <div class="relative w-full sm:w-56">
                            <input 
                                type="date" 
                                name="tanggal"
                                value="{{ request('tanggal') }}"
                                class="w-full px-4 py-2.5 rounded-2xl border-2 border-[#0c235b] text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white cursor-pointer"
                                onchange="this.form.submit()"
                            >
                        </div>

                        <button type="submit" class="px-4 py-2.5 bg-[#1E75D8] hover:bg-[#165eb0] text-white rounded-xl text-sm font-semibold transition shrink-0 shadow-sm">
                            Cari
                        </button>
                        
                        <!-- Tombol Reset Filter jika sedang memfilter -->
                        @if(request('search') || request('tanggal'))
                            <a href="{{ route('nasabah.riwayat') }}" class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-300 transition shrink-0">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Tabel Transaksi -->
                <div class="overflow-x-auto border border-gray-200 rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#dbe7f6] text-[#0c235b] font-bold border-b border-gray-200 text-sm">
                                <th class="p-4 border-r border-gray-200">Tanggal</th>
                                <th class="p-4 border-r border-gray-200">No. Rekening</th>
                                <th class="p-4 border-r border-gray-200">Username</th>
                                <th class="p-4 border-r border-gray-200">Tipe</th>
                                <th class="p-4 border-r border-gray-200">Nominal</th>
                                <th class="p-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-200 text-slate-700 font-medium">
                            @forelse ($transaksi as $item)
                                @php
                                    $tipe = strtolower($item->jenis_transaksi ?? '');
                                    $isSetor = ($tipe == 'setor' || $tipe == 'setor tunai');
                                    $status = strtolower($item->status ?? 'pending');
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 border-r border-gray-200 text-slate-500 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 font-bold text-[#0c235b] whitespace-nowrap">
                                        {{ $item->no_rekening ?? '-' }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-slate-700 whitespace-nowrap">
                                        {{ $username }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-slate-700 whitespace-nowrap">
                                        {{ $isSetor ? 'Setor Tunai' : 'Tarik Tunai' }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 font-bold whitespace-nowrap {{ $isSetor ? 'text-emerald-600' : 'text-red-500' }}">
                                        {{ $isSetor ? '+ ' : '- ' }}Rp {{ number_format($item->nominal ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center whitespace-nowrap">
                                        @if($status == 'pending')
                                            <span class="inline-block px-4 py-1 border-2 border-amber-500 text-amber-600 bg-amber-50 rounded-xl text-xs font-semibold">
                                                Pending
                                            </span>
                                        @elseif($status == 'ditolak' || $status == 'gagal')
                                            <span class="inline-block px-4 py-1 border-2 border-red-500 text-red-600 bg-red-50 rounded-xl text-xs font-semibold">
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="inline-block px-4 py-1 border-2 border-emerald-500 text-emerald-600 bg-emerald-50 rounded-xl text-xs font-semibold">
                                                Berhasil
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
                                        Belum ada riwayat transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer & Navigasi Paginasi Dinamis -->
            <div class="flex items-center justify-between pt-2 text-sm">
                <p class="text-gray-500 font-medium">
                    Menampilkan Halaman <span class="font-bold text-[#0c235b]">{{ $transaksi->currentPage() }}</span> 
                    dari <span class="font-bold text-[#0c235b]">{{ $transaksi->lastPage() }}</span>
                </p>
                <div class="flex items-center gap-2">
                    <!-- Tombol Sebelumnya -->
                    @if ($transaksi->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-gray-400 font-medium bg-gray-100 cursor-not-allowed text-xs">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                        </span>
                    @else
                        <a href="{{ $transaksi->previousPageUrl() }}" class="px-3.5 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                        </a>
                    @endif

                    <!-- Tombol Selanjutnya -->
                    @if ($transaksi->hasMorePages())
                        <a href="{{ $transaksi->nextPageUrl() }}" class="px-3.5 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center gap-1">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </a>
                    @else
                        <span class="px-3.5 py-1.5 rounded-lg text-gray-400 font-medium bg-gray-100 cursor-not-allowed text-xs flex items-center gap-1">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </span>
                    @endif
                </div>
            </div>

        </div>

    </main>

</body>
</html>