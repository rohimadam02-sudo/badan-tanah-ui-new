@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    @php
        $role = auth()->user()->role;
        $roleLabel = [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'editor' => 'Editor',
            'publisher' => 'Publisher',
        ][$role] ?? ucfirst($role);

        // Statistik
        $totalAset = \App\Models\AsetTanah::count();
        $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
        $totalBerita = \App\Models\Berita::count();
        $totalPengunjung = 124530;
        $draftCount = \App\Models\Berita::where('status_approval', 'Draft')->count();
        $pendingCount = \App\Models\Berita::where('status_approval', 'Menunggu Approval')->count();
        $publishedCount = \App\Models\Berita::where('status', 'Dipublikasikan')->count();
        $unreadCount = \App\Models\Kontak::where('is_read', 0)->count();
        $asets = \App\Models\AsetTanah::latest()->take(5)->get();
    @endphp

    <!-- HEADER DASHBOARD -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-[#006400] flex items-center justify-center shadow-sm">
                    <i class="fas fa-chart-pie text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-sm text-gray-500 mt-0.5">
                        @if ($role == 'super_admin')
                            Kelola dan pantau seluruh aktivitas sistem Badan Bank Tanah.
                        @elseif ($role == 'admin')
                            Kelola dan pantau aktivitas konten website Badan Bank Tanah.
                        @elseif ($role == 'editor')
                            Buat dan kelola draft konten publikasi Badan Bank Tanah.
                        @elseif ($role == 'publisher')
                            Review, approve, dan publish konten publikasi Badan Bank Tanah.
                        @else
                            Kelola dan pantau aktivitas Badan Bank Tanah.
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3 text-sm">
            <span class="text-gray-400">
                <i class="far fa-calendar-alt mr-1.5"></i>
                {{ now()->format('l, d M Y') }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[10px] font-bold">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                {{ $roleLabel }}
            </span>
        </div>
    </div>

    <!-- PESAN ROLE WELCOME -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-100 rounded-2xl px-5 py-4 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fas fa-shield-halved text-green-700 text-lg"></i>
            </div>
            <div class="text-sm text-green-800 leading-relaxed">
                @if ($role == 'super_admin')
                    <strong class="text-base">Selamat datang, Super Admin! 🚀</strong><br>
                    Anda memiliki akses penuh ke semua fitur termasuk <strong>Manajemen Pengguna</strong>,
                    <strong>Konfigurasi Sistem</strong>, dan <strong>Integrasi</strong>.
                @elseif ($role == 'admin')
                    <strong class="text-base">Selamat datang, Admin! 📋</strong><br>
                    Anda dapat mengelola <strong>Aset</strong>, <strong>Halaman Statis</strong>,
                    <strong>Menu Navigasi</strong>, <strong>Footer</strong>, <strong>FAQ</strong>,
                    <strong>Karier</strong>, dan <strong>Kontak</strong>.
                @elseif ($role == 'editor')
                    <strong class="text-base">Selamat datang, Editor! ✍️</strong><br>
                    Anda dapat membuat dan mengedit draft <strong>Berita</strong>, <strong>Siaran Pers</strong>,
                    dan <strong>Pengumuman</strong>. Konten yang sudah siap harus
                    <strong>disubmit</strong> untuk approval ke Publisher.
                @elseif ($role == 'publisher')
                    <strong class="text-base">Selamat datang, Publisher! ✅</strong><br>
                    Anda dapat <strong>mereview</strong>, <strong>menyetujui</strong>, dan
                    <strong>mempublikasikan</strong> konten Publikasi yang sudah disubmit oleh Editor.
                @else
                    <strong class="text-base">Selamat datang!</strong><br>
                    Anda hanya dapat mengakses beberapa fitur terbatas.
                @endif
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- STATISTIK (Sesuai Role) -->
    <!-- ========================================================= -->

    @if (in_array($role, ['super_admin', 'admin']))
    <!-- STATISTIK LENGKAP UNTUK SUPER ADMIN & ADMIN -->
    <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Total Aset</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5">{{ number_format($totalAset, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-green-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>12% dari bulan lalu</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                    <i class="fas fa-map-location-dot text-green-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Total Berita</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5">{{ number_format($totalBerita, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-blue-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>14% dari bulan lalu</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-newspaper text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Total Pengunjung</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5">{{ number_format($totalPengunjung, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-purple-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>23% dari bulan lalu</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Total Luas</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5">{{ number_format($totalLuas, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-orange-600 mt-0.5">Hektar</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center">
                    <i class="fas fa-ruler-combined text-orange-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- STATISTIK TERBATAS UNTUK EDITOR & PUBLISHER -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Total Berita</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5">{{ number_format($totalBerita, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-blue-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>14% dari bulan lalu</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-newspaper text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>

        @if ($role == 'editor')
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Draft Saya</p>
                    <h3 class="text-2xl font-bold text-yellow-600 mt-1.5">
                        {{ \App\Models\Berita::where('penulis', auth()->user()->name)->where('status_approval', 'Draft')->count() }}
                    </h3>
                    <p class="text-[10px] text-yellow-600 mt-0.5">Menunggu disubmit</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-yellow-50 flex items-center justify-center">
                    <i class="fas fa-pen-to-square text-yellow-600 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Disubmit</p>
                    <h3 class="text-2xl font-bold text-orange-600 mt-1.5">
                        {{ \App\Models\Berita::where('penulis', auth()->user()->name)->where('status_approval', 'Menunggu Approval')->count() }}
                    </h3>
                    <p class="text-[10px] text-orange-600 mt-0.5">Menunggu approval</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Dipublikasi</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1.5">
                        {{ \App\Models\Berita::where('penulis', auth()->user()->name)->where('status', 'Dipublikasikan')->count() }}
                    </h3>
                    <p class="text-[10px] text-green-600 mt-0.5">Sudah tayang</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                    <i class="fas fa-circle-check text-green-600 text-lg"></i>
                </div>
            </div>
        </div>
        @elseif ($role == 'publisher')
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Menunggu Approval</p>
                    <h3 class="text-2xl font-bold text-orange-600 mt-1.5">{{ $pendingCount }}</h3>
                    <p class="text-[10px] text-orange-600 mt-0.5">Perlu review</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Disetujui</p>
                    <h3 class="text-2xl font-bold text-blue-600 mt-1.5">
                        {{ \App\Models\Berita::where('status_approval', 'Disetujui')->count() }}
                    </h3>
                    <p class="text-[10px] text-blue-600 mt-0.5">Siap publish</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-check-circle text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Dipublikasi</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1.5">{{ $publishedCount }}</h3>
                    <p class="text-[10px] text-green-600 mt-0.5">Sudah tayang</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                    <i class="fas fa-circle-check text-green-600 text-lg"></i>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- ========================================================= -->
    <!-- GRAFIK + PUBLIKASI (Hanya Super Admin & Admin) -->
    <!-- ========================================================= -->

    @if (in_array($role, ['super_admin', 'admin']))
    <div class="grid grid-cols-1 xl:grid-cols-[1.7fr_1fr] gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Statistik Pengunjung</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Perkembangan jumlah pengunjung website</p>
                </div>
                <select class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 text-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-[#006400]/30">
                    <option selected>Bulanan</option>
                    <option>Mingguan</option>
                    <option>Tahunan</option>
                </select>
            </div>
            <div class="h-[260px]">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Publikasi Terbaru</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Konten yang baru diterbitkan</p>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            @php
                $publikasiTerbaru = \App\Models\Berita::where('status', 'Dipublikasikan')->latest()->take(4)->get();
            @endphp

            <div class="space-y-3">
                @forelse($publikasiTerbaru as $item)
                    <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 group hover:bg-gray-50 rounded-xl p-2 -mx-2 transition">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover" alt="{{ $item->judul }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B2A4A] to-[#163F66]">
                                    <i class="fas fa-newspaper text-white/30 text-lg"></i>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[8px] font-bold uppercase px-1.5 py-0.5 rounded-full
                                    {{ $item->kategori == 'Siaran Pers' ? 'bg-blue-50 text-blue-600' :
                                       ($item->kategori == 'Pengumuman' ? 'bg-orange-50 text-orange-600' :
                                       'bg-green-50 text-green-600') }}">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                            <h4 class="text-[11px] font-semibold text-gray-900 truncate mt-1 group-hover:text-blue-600 transition">
                                {{ $item->judul }}
                            </h4>
                            <p class="text-[9px] text-gray-400 mt-0.5">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') : $item->created_at?->format('d M Y') }}
                                <span class="mx-1">•</span>
                                <i class="far fa-eye mr-1"></i>
                                {{ number_format($item->views ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-8 text-gray-400 text-xs">
                        <i class="fas fa-newspaper text-2xl block mb-2 text-gray-300"></i>
                        Belum ada publikasi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- ========================================================= -->
    <!-- BAGIAN BAWAH (Sesuai Role) -->
    <!-- ========================================================= -->

    @if (in_array($role, ['super_admin', 'admin']))
    <!-- FULL DASHBOARD UNTUK SUPER ADMIN & ADMIN -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Aktivitas Terbaru</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Aktivitas pengelolaan sistem</p>
                </div>
                <a href="{{ route('admin.activity-log') }}" class="text-[10px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $activities = \Spatie\Activitylog\Models\Activity::with('causer')->latest()->take(5)->get();
                @endphp
                
                @forelse($activities as $activity)
                    @php
                        $icon = 'fa-pen';
                        $color = 'blue';
                        $bg = 'blue-50';
                        
                        if (str_contains($activity->description, 'menambahkan') || $activity->event == 'created') {
                            $icon = 'fa-plus';
                            $color = 'green';
                            $bg = 'green-50';
                        } elseif (str_contains($activity->description, 'mengubah') || $activity->event == 'updated') {
                            $icon = 'fa-pen';
                            $color = 'blue';
                            $bg = 'blue-50';
                        } elseif (str_contains($activity->description, 'menghapus') || $activity->event == 'deleted') {
                            $icon = 'fa-trash';
                            $color = 'red';
                            $bg = 'red-50';
                        } elseif (str_contains($activity->description, 'mempublikasikan') || $activity->event == 'published') {
                            $icon = 'fa-check-circle';
                            $color = 'green';
                            $bg = 'green-50';
                        } elseif (str_contains($activity->description, 'menyetujui') || $activity->event == 'approved') {
                            $icon = 'fa-check';
                            $color = 'blue';
                            $bg = 'blue-50';
                        } elseif (str_contains($activity->description, 'mensubmit') || $activity->event == 'submitted') {
                            $icon = 'fa-paper-plane';
                            $color = 'orange';
                            $bg = 'orange-50';
                        } elseif (str_contains($activity->description, 'mengarsipkan') || $activity->event == 'unpublished') {
                            $icon = 'fa-archive';
                            $color = 'gray';
                            $bg = 'gray-50';
                        }
                        
                        $subjectType = class_basename($activity->subject_type ?? '');
                        $causerName = $activity->causer?->name ?? 'Sistem';
                    @endphp
                    <div class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition">
                        <div class="w-8 h-8 rounded-lg {{ $bg }} flex items-center justify-center flex-shrink-0">
                            <i class="fas {{ $icon }} text-{{ $color }}-600 text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-medium text-gray-800">{{ ucfirst($activity->description) }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">
                                {{ $subjectType }} • oleh {{ $causerName }}
                            </p>
                        </div>
                        <span class="text-[9px] text-gray-400 flex-shrink-0">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-xs text-gray-400">
                        <i class="fas fa-inbox text-2xl block mb-2 text-gray-300"></i>
                        Belum ada aktivitas.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="mb-3">
                <h3 class="text-sm font-bold text-gray-900">Distribusi Pengunjung</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Sumber kunjungan website</p>
            </div>
            <div class="h-[170px] flex items-center justify-center">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-y-1.5 mt-2 pt-3 border-t border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#006400]"></span>
                    <span class="text-[10px] text-gray-500">Langsung</span>
                    <span class="text-[10px] font-semibold text-gray-700 ml-auto">45%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                    <span class="text-[10px] text-gray-500">Mesin Pencari</span>
                    <span class="text-[10px] font-semibold text-gray-700 ml-auto">32%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-[10px] text-gray-500">Media Sosial</span>
                    <span class="text-[10px] font-semibold text-gray-700 ml-auto">12%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-[10px] text-gray-500">Referensi</span>
                    <span class="text-[10px] font-semibold text-gray-700 ml-auto">11%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Aset Terbaru -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Aset Terbaru</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Data aset tanah yang terakhir ditambahkan</p>
            </div>
            <a href="{{ route('admin.aset.index') }}" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Nama Lokasi</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Provinsi</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Luas</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($asets as $aset)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                        @if($aset->gambar)
                                            <img src="{{ asset('storage/' . $aset->gambar) }}" class="w-full h-full object-cover" alt="{{ $aset->nama_lokasi }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-[#0B2A4A]/10">
                                                <i class="fas fa-map-pin text-gray-400 text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-xs font-semibold text-gray-900 truncate max-w-[120px]">{{ $aset->nama_lokasi }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-gray-500">{{ $aset->provinsi }}</td>
                            <td class="px-5 py-3.5 text-xs font-semibold text-gray-700">{{ number_format($aset->luas_hektar, 2, ',', '.') }} Ha</td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-bold
                                    {{ $aset->status == 'Tersedia' ? 'bg-green-50 text-green-700' :
                                       ($aset->status == 'Dalam Pengembangan' ? 'bg-blue-50 text-blue-700' :
                                       'bg-orange-50 text-orange-700') }}">
                                    {{ $aset->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-xs text-gray-400">
                                <i class="fas fa-database text-2xl block mb-2 text-gray-300"></i>
                                Belum ada data aset.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- ========================================================= -->
    <!-- DASHBOARD KHUSUS EDITOR -->
    <!-- ========================================================= -->
    @if ($role == 'editor')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Draft Saya</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Konten yang belum disubmit</p>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $drafts = \App\Models\Berita::where('penulis', auth()->user()->name)->where('status_approval', 'Draft')->latest()->take(5)->get();
                @endphp
                @forelse ($drafts as $draft)
                    <div class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $draft->judul }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[9px] text-gray-400">{{ $draft->kategori }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-[9px] text-gray-400">{{ $draft->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0 ml-3">
                            <form action="{{ route('admin.berita.submit', $draft->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Submit konten ini untuk approval?')"
                                    class="text-[9px] font-semibold text-orange-600 hover:underline">Submit</button>
                            </form>
                            <a href="{{ route('admin.berita.edit', $draft->id) }}" class="text-[9px] font-semibold text-blue-600 hover:underline">Edit</a>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-xs text-gray-400">
                        <i class="fas fa-pen-to-square text-2xl block mb-2 text-gray-300"></i>
                        Belum ada draft.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Konten Saya</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Konten yang sudah disubmit/dipublikasi</p>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $myContent = \App\Models\Berita::where('penulis', auth()->user()->name)->where('status_approval', '!=', 'Draft')->latest()->take(5)->get();
                @endphp
                @forelse ($myContent as $item)
                    <div class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $item->judul }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[9px] text-gray-400">{{ $item->kategori }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-[9px] font-medium
                                    {{ $item->status_approval == 'Menunggu Approval' ? 'text-orange-600' :
                                       ($item->status_approval == 'Disetujui' ? 'text-blue-600' :
                                       ($item->status_approval == 'Dipublikasikan' ? 'text-green-600' :
                                       'text-gray-400')) }}">
                                    {{ $item->status_approval }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-[9px] font-semibold text-blue-600 hover:underline flex-shrink-0 ml-3">Lihat</a>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-xs text-gray-400">
                        <i class="fas fa-file-lines text-2xl block mb-2 text-gray-300"></i>
                        Belum ada konten.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- ========================================================= -->
    <!-- DASHBOARD KHUSUS PUBLISHER -->
    <!-- ========================================================= -->
    @if ($role == 'publisher')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                        Menunggu Approval
                    </h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Konten yang perlu direview</p>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $pending = \App\Models\Berita::where('status_approval', 'Menunggu Approval')->latest()->take(5)->get();
                @endphp
                @forelse ($pending as $item)
                    <div class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $item->judul }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[9px] text-gray-400">{{ $item->kategori }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-[9px] text-gray-400">oleh {{ $item->penulis }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0 ml-3">
                            <form action="{{ route('admin.berita.approve', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Setujui konten ini?')"
                                    class="text-[9px] font-semibold text-green-600 hover:underline">Approve</button>
                            </form>
                            <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-[9px] font-semibold text-blue-600 hover:underline">Review</a>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-xs text-gray-400">
                        <i class="fas fa-check-circle text-2xl block mb-2 text-green-300"></i>
                        Tidak ada konten yang menunggu approval.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        Siap Publish
                    </h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Konten yang sudah disetujui</p>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $ready = \App\Models\Berita::where('status_approval', 'Disetujui')->latest()->take(5)->get();
                @endphp
                @forelse ($ready as $item)
                    <div class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-gray-800 truncate">{{ $item->judul }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[9px] text-gray-400">{{ $item->kategori }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-[9px] text-gray-400">oleh {{ $item->penulis }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0 ml-3">
                            <form action="{{ route('admin.berita.publish', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Publikasikan konten ini?')"
                                    class="text-[9px] font-semibold text-blue-600 hover:underline">Publish</button>
                            </form>
                            <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-[9px] font-semibold text-gray-400 hover:text-blue-600">Lihat</a>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-xs text-gray-400">
                        <i class="fas fa-clock text-2xl block mb-2 text-gray-300"></i>
                        Tidak ada konten yang siap publish.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Konten Terbaru (Publisher) -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Konten Terbaru</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Semua konten yang tersedia</p>
            </div>
            <a href="{{ route('admin.berita.index') }}" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        $allContent = \App\Models\Berita::latest()->take(5)->get();
                    @endphp
                    @forelse ($allContent as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5 text-xs font-medium text-gray-800 max-w-[200px] truncate">{{ $item->judul }}</td>
                            <td class="px-5 py-3.5 text-xs text-gray-500">{{ $item->kategori }}</td>
                            <td class="px-5 py-3.5 text-xs text-gray-500">{{ $item->penulis }}</td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-bold
                                    {{ $item->status_approval == 'Menunggu Approval' ? 'bg-orange-50 text-orange-700' :
                                       ($item->status_approval == 'Disetujui' ? 'bg-blue-50 text-blue-700' :
                                       ($item->status_approval == 'Dipublikasikan' ? 'bg-green-50 text-green-700' :
                                       'bg-gray-50 text-gray-500')) }}">
                                    {{ $item->status_approval }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($item->status_approval == 'Menunggu Approval')
                                        <form action="{{ route('admin.berita.approve', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-[9px] font-semibold text-green-600 hover:underline">Approve</button>
                                        </form>
                                    @endif
                                    @if ($item->status_approval == 'Disetujui')
                                        <form action="{{ route('admin.berita.publish', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-[9px] font-semibold text-blue-600 hover:underline">Publish</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-[9px] font-semibold text-gray-400 hover:text-blue-600">Lihat</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-xs text-gray-400">
                                <i class="fas fa-newspaper text-2xl block mb-2 text-gray-300"></i>
                                Belum ada konten.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- ========================================================= -->
    <!-- FOOTER DASHBOARD -->
    <!-- ========================================================= -->
    <div class="text-center text-[10px] text-gray-400 py-4 border-t border-gray-200/50">
        <p>
            &copy; {{ date('Y') }} Badan Bank Tanah - Indonesia Land Bank Authority.
            <span class="hidden sm:inline">Dikelola melalui CMS Admin Panel.</span>
        </p>
        <p class="mt-0.5">
            <span class="inline-flex items-center gap-1">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-500"></span>
                Sistem berjalan dengan baik
            </span>
            <span class="mx-1">•</span>
            Laravel v{{ app()->version() }}
        </p>
    </div>

</div>

<!-- ============================================================= -->
<!-- CHART.JS (Hanya untuk Super Admin & Admin) -->
<!-- ============================================================= -->

@if (in_array($role, ['super_admin', 'admin']))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Line Chart
        const visitorCanvas = document.getElementById('visitorChart');
        if (visitorCanvas) {
            const ctx = visitorCanvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 260);
            gradient.addColorStop(0, 'rgba(0, 100, 0, 0.20)');
            gradient.addColorStop(0.6, 'rgba(0, 100, 0, 0.05)');
            gradient.addColorStop(1, 'rgba(0, 100, 0, 0.00)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1 Mei', '8 Mei', '15 Mei', '22 Mei', '29 Mei', '5 Jun', '12 Jun'],
                    datasets: [{
                        label: 'Pengunjung',
                        data: [12000, 19000, 15000, 27000, 22000, 32000, 28500],
                        borderColor: '#006400',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: '#006400',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(255,255,255,0.95)',
                            titleColor: '#1f2937',
                            bodyColor: '#374151',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            cornerRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return 'Pengunjung: ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 9 }, color: '#9CA3AF' }
                        },
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                            ticks: {
                                font: { size: 9 },
                                color: '#9CA3AF',
                                callback: function(value) {
                                    if (value >= 1000) return (value / 1000) + 'K';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Doughnut Chart
        const pieCanvas = document.getElementById('pieChart');
        if (pieCanvas) {
            const pieCtx = pieCanvas.getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Langsung', 'Mesin Pencari', 'Media Sosial', 'Referensi'],
                    datasets: [{
                        data: [45, 32, 12, 11],
                        backgroundColor: ['#006400', '#F97316', '#3B82F6', '#10B981'],
                        borderWidth: 0,
                        cutout: '68%',
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(255,255,255,0.95)',
                            titleColor: '#1f2937',
                            bodyColor: '#374151',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            cornerRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    return label + ': ' + value + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endif

@endsection