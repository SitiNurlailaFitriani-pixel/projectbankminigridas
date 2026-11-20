<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setor Tunai - GRIDAS BANK</title>

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
                <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-address-card w-5"></i>
                    Data Nasabah
                </a>
                <a href="{{ route('admin.rekening.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition font-medium">
                    <i class="fa-solid fa-id-card w-5"></i>
                    Data Rekening
                </a>
                <a href="{{ route('admin.setor_tunai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
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
        
        <!-- Header Top Bar (Lonceng Notifikasi + Profil) -->
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

        <!-- Kotak Putih Utama (Form Setor Tunai) -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full max-w-3xl mx-auto my-auto space-y-6">
            
            <!-- Alert Session / Validation Errors -->
            @if(session('success'))
                <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl text-sm font-semibold">
                    <i class="fa-solid fa-circle-check mr-2 text-emerald-600"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-red-100 border border-red-300 text-red-800 rounded-2xl text-sm font-semibold">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Header Title dengan Icon Bulat -->
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-[#1E75D8] text-white flex items-center justify-center text-2xl shrink-0 shadow-sm">
                    <i class="fa-solid fa-vault"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#0c235b]">Setor Tunai</h1>
                    <p class="text-slate-500 font-medium text-sm">Lakukan setoran tunai ke rekening anda</p>
                </div>
            </div>

            <!-- Form Setor Tunai -->
            <form action="{{ route('admin.setor_tunai.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Input Rekening -->
                <div>
                    <label for="no_rekening" class="block text-[#0c235b] font-bold mb-1.5 text-sm">Rekening</label>
                    <input type="text" id="no_rekening" name="no_rekening" value="{{ old('no_rekening') }}" placeholder="Masukan Rekening" required
                           class="w-full px-4 py-3 rounded-xl border-2 border-[#0c235b] text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-slate-400 font-medium text-sm">
                </div>

                <!-- Input Jumlah Setor -->
                <div>
                    <label for="jumlah_setor" class="block text-[#0c235b] font-bold mb-1.5 text-sm">Jumlah Setor</label>
                    <div class="flex rounded-xl border-2 border-[#0c235b] overflow-hidden focus-within:ring-2 focus-within:ring-blue-400">
                        <span class="px-5 py-3 text-[#0c235b] font-bold border-r-2 border-[#0c235b] bg-[#e8f1fb] flex items-center justify-center text-sm">Rp</span>
                        <input type="number" id="jumlah_setor" name="jumlah_setor" value="{{ old('jumlah_setor') }}" min="10000" placeholder="" required
                               class="w-full px-4 py-3 text-slate-800 focus:outline-none font-medium text-sm">
                    </div>
                </div>

                <!-- Input Keterangan -->
                <div>
                    <label for="keterangan" class="block text-[#0c235b] font-bold mb-1.5 text-sm">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Tuliskan keterangan"
                           class="w-full px-4 py-3 rounded-xl border-2 border-[#0c235b] text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-slate-400 font-medium text-sm">
                </div>

                <!-- Tombol Submit Capsule -->
                <div class="pt-4 flex justify-center">
                    <button type="submit" class="w-full max-w-sm py-3.5 bg-[#1E75D8] hover:bg-[#165eb0] text-white font-bold text-base rounded-2xl transition shadow-md">
                        Setor Sekarang
                    </button>
                </div>
            </form>

        </div>
    </main>

</body>
</html>