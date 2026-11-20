<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Data Nasabah</title>

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
                <!-- Dashboard -->
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
                </a>

                <!-- Data Nasabah (Active) -->
                <a href="{{ route('petugas.nasabah') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
                    <i class="fa-solid fa-users w-5"></i>
                    Data Nasabah
                </a>

                <!-- Setor Tunai -->
                <a href="{{ route('petugas.setortunai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-money-bill-transfer w-5"></i>
                    Setor Tunai
                </a>

                <!-- Tarik Tunai -->
                <a href="{{ route('petugas.tariktunai') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-wallet w-5"></i>
                    Tarik Tunai
                </a>

                <!-- Riwayat Transaksi -->
                <a href="{{ route('petugas.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
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

        <!-- Card Putih Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1 flex flex-col justify-between">
            
            <div>
                <!-- Header Title & Tombol Tambah Nasabah -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-[#0c235b]">Data Nasabah</h2>
                        <p class="text-slate-500 font-medium text-sm mt-0.5">Kelola data nasabah bank</p>
                    </div>
                    <a href="{{ route('register') }}" class="bg-[#1E75D8] hover:bg-[#165eb0] text-white font-bold px-5 py-2.5 rounded-xl shadow transition text-sm flex items-center gap-2">
                        <span>+ Tambah Nasabah</span>
                    </a>
                </div>

                <!-- Input Search -->
                <form action="{{ route('petugas.nasabah') }}" method="GET" class="mb-6">
                    <div class="relative w-full max-w-md">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#0c235b] font-bold"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau username" 
                               class="w-full pl-11 pr-10 py-2.5 border-2 border-[#0c235b] rounded-2xl text-sm font-medium text-slate-700 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @if($search)
                            <a href="{{ route('petugas.nasabah') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Tabel Data Nasabah -->
                <div class="overflow-x-auto border border-gray-200 rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#dbe7f6] text-[#0c235b] font-bold text-sm border-b border-gray-200">
                                <th class="p-4 border-r border-gray-200 w-16 text-center">No</th>
                                <th class="p-4 border-r border-gray-200">Nama</th>
                                <th class="p-4 border-r border-gray-200">Username</th>
                                <th class="p-4 border-r border-gray-200">E-mail</th>
                                <th class="p-4 border-r border-gray-200 text-center w-32">Status</th>
                                <th class="p-4 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm font-medium text-slate-700">
                            @forelse($nasabah as $index => $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 border-r border-gray-200 text-center text-slate-500">
                                        {{ method_exists($nasabah, 'firstItem') ? $nasabah->firstItem() + $index : $index + 1 }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 font-semibold text-[#0c235b]">
                                        {{ $item->nama ?? $item->name ?? '-' }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-slate-700">
                                        {{ $item->username ?? '-' }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-slate-700">
                                        {{ $item->email ?? '-' }}
                                    </td>
                                    <td class="p-4 border-r border-gray-200 text-center">
                                        <span class="inline-block px-4 py-1 border-2 border-emerald-500 text-emerald-600 bg-emerald-50 rounded-xl text-xs font-semibold">
                                            Aktif
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <form action="{{ route('petugas.nasabah.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nasabah ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition text-lg">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
                                        Data nasabah belum tersedia atau tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Custom Pagination -->
            <div class="flex justify-center items-center pt-2">
                @if (method_exists($nasabah, 'links'))
                    {{ $nasabah->links() }}
                @endif
            </div>

        </div>

    </main>

</body>
</html>