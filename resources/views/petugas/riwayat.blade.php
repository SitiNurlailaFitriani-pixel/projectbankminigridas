<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Riwayat Transaksi Petugas</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js untuk Notifikasi/Dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#DCE8FA] min-h-screen flex text-[#0A2558] overflow-x-hidden">

    <!-- Sidebar Navigasi Kiri -->
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
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
                </a>

                <a href="{{ route('petugas.nasabah') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-users w-5"></i>
                    Data Nasabah
                </a>

                <a href="{{ route('petugas.setortunai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-money-bill-transfer w-5"></i>
                    Setor Tunai
                </a>

                <a href="{{ route('petugas.tariktunai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-wallet w-5"></i>
                    Tarik Tunai
                </a>

                <!-- Navigasi Aktif: Riwayat Transaksi -->
                <a href="{{ route('petugas.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
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
        
        <!-- Top Bar Profil Header Petugas & Lonceng Notifikasi -->
        <div class="flex justify-end items-center gap-6 mb-4">
            
            @php
                $pendingCount = isset($pendingList) ? count($pendingList) : 0;
            @endphp
            
            <div class="relative" x-data="{ open: false }">
                <!-- Tombol Lonceng dengan Badge Bulat Merah -->
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
                        @forelse($pendingList ?? [] as $item)
                            <div class="border-b border-gray-100 pb-3 last:border-b-0 last:pb-0">
                                <div class="flex items-start gap-3">
                                    <div class="w-11 h-11 bg-[#f5a623] text-white rounded-full flex items-center justify-center shrink-0 shadow-sm">
                                        <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                                    </div>

                                    <div class="flex-1 text-xs">
                                        <div class="flex items-center justify-between font-bold text-[#0A2558]">
                                            <span>{{ $item->nama }}</span>
                                            <span class="text-[11px] text-gray-400 font-medium">{{ $item->waktu }}</span>
                                        </div>

                                        <p class="text-gray-600 mt-0.5">
                                            Pengajuan <span class="font-semibold text-gray-800">{{ $item->jenis }}</span> sebesar 
                                            <span class="text-emerald-600 font-bold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                                        </p>

                                        <p class="text-[11px] text-gray-400 italic mt-0.5">
                                            Rekening: {{ $item->rekening }}
                                        </p>

                                        <div class="flex items-center gap-2 mt-3">
                                            <form action="{{ route('petugas.tariktunai.setujui', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#009661] hover:bg-[#007d51] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm">
                                                    <i class="fa-solid fa-check text-xs"></i> Setujui
                                                </button>
                                            </form>

                                            <form action="{{ route('petugas.tariktunai.tolak', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#dc2626] hover:bg-[#b91c1c] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm">
                                                    <i class="fa-solid fa-xmark text-xs"></i> Tolak
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
                <span>Petugas</span>
            </div>
        </div>

        <!-- Card Putih Utama Riwayat Transaksi -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1 flex flex-col justify-between">
            
            <div class="space-y-6">
                <!-- Header Card -->
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
                <form action="{{ route('petugas.riwayat') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center justify-between gap-3">
                    
                    <!-- Input Search -->
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
                    
                    <!-- Input Tanggal & Tombol Reset -->
                    <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                        <div class="relative w-full sm:w-56">
                            <input 
                                type="date" 
                                name="tanggal" 
                                value="{{ request('tanggal') }}"
                                onchange="this.form.submit()" 
                                class="w-full px-4 py-2.5 rounded-2xl border-2 border-[#0c235b] text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white cursor-pointer"
                            >
                        </div>

                        @if(request('search') || request('tanggal'))
                            <a href="{{ route('petugas.riwayat') }}" class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-300 transition shrink-0">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Container Slide Tabel -->
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full border-collapse text-left text-sm">
                        <!-- Header Tabel -->
                        <thead>
                            <tr class="bg-[#dbe7f6] text-[#0c235b] font-bold border-b border-gray-200">
                                <th class="p-4 border-r border-gray-200">Tanggal</th>
                                <th class="p-4 border-r border-gray-200">No. Rekening</th>
                                <th class="p-4 border-r border-gray-200">Username</th>
                                <th class="p-4 border-r border-gray-200">Tipe</th>
                                <th class="p-4 border-r border-gray-200">Nominal</th>
                                <th class="p-4 text-center">Status</th>
                            </tr>
                        </thead>

                        <!-- Body Tabel Dinamis -->
                        <tbody class="divide-y divide-gray-200 text-slate-700 font-medium">
                            @forelse ($riwayatChunks ?? [] as $index => $chunk)
                                @foreach ($chunk as $item)
                                    <tr class="slide-group slide-page-{{ $index }} hover:bg-gray-50 transition {{ $index !== 0 ? 'hidden' : '' }}">
                                        <!-- Tanggal Transaksi -->
                                        <td class="p-4 border-r border-gray-200 whitespace-nowrap text-slate-500">
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y, H:i') }}
                                        </td>
                                        
                                        <!-- Nomor Rekening -->
                                        <td class="p-4 border-r border-gray-200 font-bold text-[#0c235b] whitespace-nowrap">
                                            {{ $item->no_rekening ?? '-' }}
                                        </td>
                                        
                                        <!-- Username / Nama Lengkap -->
                                        <td class="p-4 border-r border-gray-200 text-slate-700 whitespace-nowrap">
                                            {{ $item->username ?? $item->nama_lengkap ?? '-' }}
                                        </td>
                                        
                                        <!-- Tipe Transaksi -->
                                        <td class="p-4 border-r border-gray-200 text-slate-700 whitespace-nowrap">
                                            {{ $item->tipe }}
                                        </td>
                                        
                                        <!-- Nominal -->
                                        <td class="p-4 border-r border-gray-200 font-bold whitespace-nowrap {{ $item->tipe == 'Setor Tunai' ? 'text-emerald-600' : 'text-red-500' }}">
                                            {{ $item->tipe == 'Setor Tunai' ? '+ ' : '- ' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                        </td>
                                        
                                        <!-- Status Transaksi -->
                                        <td class="p-4 text-center whitespace-nowrap">
                                            @php
                                                $status = strtolower(trim($item->status ?? 'berhasil'));
                                            @endphp

                                            @if(in_array($status, ['pending', 'menunggu']))
                                                <span class="inline-block px-4 py-1 border-2 border-amber-500 text-amber-600 bg-amber-50 rounded-xl text-xs font-semibold">
                                                    Pending
                                                </span>
                                            @elseif(in_array($status, ['ditolak', 'rejected', 'failed', 'gagal', 'batal', 'cancel', 'cancelled']))
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
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
                                        Tidak ada data riwayat transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Control Navigasi Tombol Slide -->
            @if (isset($riwayatChunks) && count($riwayatChunks) > 0)
                <div class="flex items-center justify-between pt-2 text-sm">
                    <p class="text-gray-500 font-medium">
                        Menampilkan Halaman <span id="currentSlideNum" class="font-bold text-[#0c235b]">1</span> dari <span id="totalSlideNum" class="font-bold text-[#0c235b]">{{ count($riwayatChunks) }}</span>
                    </p>

                    <div class="flex items-center gap-2">
                        <button id="btnPrev" onclick="changeSlide(-1)" class="px-3.5 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center disabled:opacity-40 disabled:hover:bg-blue-50 disabled:cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                        </button>

                        <button id="btnNext" onclick="changeSlide(1)" class="px-3.5 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center gap-1 disabled:opacity-40 disabled:hover:bg-blue-50 disabled:cursor-not-allowed">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </button>
                    </div>
                </div>
            @endif

        </div>

    </main>

    <!-- JavaScript Slide / Paging Client-Side -->
    <script>
        let currentSlide = 0;
        const totalSlides = {{ isset($riwayatChunks) ? count($riwayatChunks) : 0 }};

        function updateSlideDisplay() {
            document.querySelectorAll('.slide-group').forEach(row => {
                row.classList.add('hidden');
            });

            document.querySelectorAll('.slide-page-' + currentSlide).forEach(row => {
                row.classList.remove('hidden');
            });

            const currentNumEl = document.getElementById('currentSlideNum');
            if (currentNumEl) {
                currentNumEl.textContent = currentSlide + 1;
            }

            const btnPrev = document.getElementById('btnPrev');
            const btnNext = document.getElementById('btnNext');

            if (btnPrev) btnPrev.disabled = (currentSlide === 0);
            if (btnNext) btnNext.disabled = (currentSlide === totalSlides - 1 || totalSlides === 0);
        }

        function changeSlide(direction) {
            const newSlide = currentSlide + direction;
            if (newSlide >= 0 && newSlide < totalSlides) {
                currentSlide = newSlide;
                updateSlideDisplay();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (totalSlides > 0) {
                updateSlideDisplay();
            }
        });
    </script>

</body>
</html>