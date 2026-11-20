<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nasabah - GRIDAS BANK</title>

    <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js untuk Notifikasi/Dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
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
                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
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
                <a href="{{ route('admin.laporan_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
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
                <button type="submit" class="flex items-center gap-3 text-white/90 hover:text-red-300 px-3 py-1.5 font-semibold transition w-full text-left">
                    <i class="fa-solid fa-right-from-bracket text-xl rotate-180"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-6 flex flex-col h-screen overflow-y-auto">
        
        <!-- Header Top Bar -->
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

        <!-- Kotak Putih Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1">

            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="mb-6 bg-[#d1fadf] border border-[#a6f4c5] text-[#027a48] px-5 py-3.5 rounded-2xl flex items-center gap-3 text-sm font-semibold shadow-sm">
                    <div class="w-5 h-5 rounded-full bg-[#12b76a] text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-[#fee4e2] border border-[#fecdca] text-[#b42318] px-5 py-3.5 rounded-2xl flex items-center gap-3 text-sm font-semibold shadow-sm">
                    <div class="w-5 h-5 rounded-full bg-[#f04438] text-white flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </div>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Header Title Section & Tombol Tambah Nasabah -->
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#0c235b]">Data Nasabah</h1>
                    <p class="text-sm text-gray-500 font-medium">Kelola data nasabah bank</p>
                </div>
                <button type="button" onclick="openModal()" class="bg-[#1E75D8] hover:bg-[#155ebd] text-white font-semibold px-5 py-2.5 rounded-xl shadow transition text-sm flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Nasabah</span>
                </button>
            </div>

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('admin.nasabah.index') }}" class="mb-4">
                <div class="relative w-full max-w-md">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#0c235b] font-bold"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama atau username" 
                        class="w-full pl-11 pr-10 py-2.5 border-2 border-[#0c235b] rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm font-medium text-gray-700 placeholder-gray-400"
                    >
                    @if(request('search'))
                        <a href="{{ route('admin.nasabah.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table Data Nasabah -->
            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#dbe7f6] text-[#0c235b] font-bold border-b border-gray-200">
                            <th class="p-4 text-center border-r border-gray-200 w-16">No</th>
                            <th class="p-4 border-r border-gray-200">Nama</th>
                            <th class="p-4 border-r border-gray-200">Username</th>
                            <th class="p-4 border-r border-gray-200">E-mail</th>
                            <th class="p-4 text-center border-r border-gray-200 w-32">Status</th>
                            <th class="p-4 text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($nasabah as $index => $item)
                            <tr class="hover:bg-gray-50 text-center">
                                <td class="p-4 border-r border-gray-200 text-gray-700 font-medium">
                                    {{ $nasabah->firstItem() ? $nasabah->firstItem() + $index : $index + 1 }}
                                </td>
                                <td class="p-4 border-r border-gray-200 text-gray-800 font-semibold text-left">
                                    {{ $item->nama ?? $item->name ?? '-' }}
                                </td>
                                <td class="p-4 border-r border-gray-200 text-gray-800 font-medium text-left">
                                    {{ $item->username ?? '-' }}
                                </td>
                                <td class="p-4 border-r border-gray-200 text-gray-700 text-left">
                                    {{ $item->email ?? '-' }}
                                </td>
                                <td class="p-4 text-center border-r border-gray-200">
                                    <span class="inline-block px-4 py-1 border-2 border-emerald-500 text-emerald-600 bg-emerald-50 rounded-xl text-xs font-semibold">
                                        Aktif
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('admin.nasabah.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nasabah ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-lg transition">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-500">
                                    Data nasabah belum tersedia atau tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center pt-2">
                @if (method_exists($nasabah, 'links'))
                    {{ $nasabah->links() }}
                @endif
            </div>

        </div>
    </main>

    <!-- MODAL / POPUP TAMBAH NASABAH -->
    <div id="modalTambah" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-[#0c235b]">Tambah Nasabah Baru</h3>
                    <p class="text-slate-500 text-xs mt-0.5">Silakan isi formulir data nasabah di bawah ini</p>
                </div>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-red-500 text-lg transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Form Input Tambah Nasabah -->
            <form action="{{ route('admin.nasabah.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#0c235b] mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Masukkan nama lengkap" 
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm font-medium text-[#0c235b] focus:outline-none focus:border-[#1E75D8]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0c235b] mb-1">Username</label>
                    <input type="text" name="username" required placeholder="Masukkan username" 
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm font-medium text-[#0c235b] focus:outline-none focus:border-[#1E75D8]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0c235b] mb-1">E-mail</label>
                    <input type="email" name="email" required placeholder="Masukkan alamat email" 
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm font-medium text-[#0c235b] focus:outline-none focus:border-[#1E75D8]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0c235b] mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password" 
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm font-medium text-[#0c235b] focus:outline-none focus:border-[#1E75D8]">
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#1E75D8] hover:bg-[#155ebd] text-white font-semibold text-sm shadow transition">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JavaScript untuk Toggle Modal -->
    <script>
        const modal = document.getElementById('modalTambah');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        // Tutup modal jika user klik di luar kotak putih modal
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>