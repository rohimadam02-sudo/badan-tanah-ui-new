<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-7xl mx-auto space-y-6">

    <?php
        $user = auth()->user();
        $role = $user->role;
        $roleLabel = [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'editor' => 'Editor',
            'publisher' => 'Publisher',
        ][$role] ?? ucfirst($role);

        // =========================================================
        // STATISTIK REAL DARI DATABASE
        // =========================================================
        $totalAset = \App\Models\AsetTanah::count();
        $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
        $totalBerita = \App\Models\Berita::count();
        $totalPengunjung = 124530; // Placeholder
        $draftCount = \App\Models\Berita::where('status_approval', 'Draft')->count();
        $pendingCount = \App\Models\Berita::where('status_approval', 'Menunggu Approval')->count();
        $publishedCount = \App\Models\Berita::where('status', 'Dipublikasikan')->count();
        $unreadCount = \App\Models\Kontak::where('is_read', 0)->count();
        $asets = \App\Models\AsetTanah::latest()->take(5)->get();
    ?>

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
                        <?php if($role == 'super_admin'): ?>
                            Kelola dan pantau seluruh aktivitas sistem Badan Bank Tanah.
                        <?php elseif($role == 'admin'): ?>
                            Kelola dan pantau aktivitas konten website Badan Bank Tanah.
                        <?php elseif($role == 'editor'): ?>
                            Buat dan kelola draft konten publikasi Badan Bank Tanah.
                        <?php elseif($role == 'publisher'): ?>
                            Review, approve, dan publish konten publikasi Badan Bank Tanah.
                        <?php else: ?>
                            Kelola dan pantau aktivitas Badan Bank Tanah.
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3 text-sm">
            <span class="text-gray-400">
                <i class="far fa-calendar-alt mr-1.5"></i>
                <?php echo e(now()->format('l, d M Y')); ?>

            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[10px] font-bold">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                <?php echo e($roleLabel); ?>

            </span>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- QUICK ACTION BUTTONS - SESUAI ROLE -->
    <!-- ========================================================= -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

        
        <?php if(in_array($role, ['super_admin', 'admin'])): ?>
        <a href="<?php echo e(route('admin.aset.create')); ?>" 
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#006400] transition group">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-[#006400] flex items-center justify-center group-hover:bg-[#006400] group-hover:text-white transition">
                <i class="fas fa-plus"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Tambah Aset</p>
                <p class="text-[10px] text-gray-400">Aset Persediaan Tanah</p>
            </div>
        </a>
        <?php endif; ?>

        
        <?php if(in_array($role, ['super_admin', 'admin', 'editor'])): ?>
        <a href="<?php echo e(route('admin.berita.create')); ?>" 
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#006400] transition group">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-[#006400] group-hover:text-white transition">
                <i class="fas fa-plus"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Tambah Berita</p>
                <p class="text-[10px] text-gray-400">Publikasi</p>
            </div>
        </a>
        <?php endif; ?>

        
        <?php if(in_array($role, ['super_admin'])): ?>
        <a href="<?php echo e(route('admin.user.create')); ?>" 
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#006400] transition group">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-[#006400] group-hover:text-white transition">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Tambah User</p>
                <p class="text-[10px] text-gray-400">Manajemen Pengguna</p>
            </div>
        </a>
        <?php endif; ?>

        
        <?php if(in_array($role, ['super_admin', 'admin'])): ?>
        <a href="<?php echo e(route('admin.microsite.create')); ?>" 
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#006400] transition group">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center group-hover:bg-[#006400] group-hover:text-white transition">
                <i class="fas fa-file-lines"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Buat Microsite</p>
                <p class="text-[10px] text-gray-400">Event / Campaign</p>
            </div>
        </a>
        <?php endif; ?>

        
        <?php if($role == 'publisher'): ?>
        <a href="<?php echo e(route('admin.berita.index')); ?>" 
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#006400] transition group">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-[#006400] flex items-center justify-center group-hover:bg-[#006400] group-hover:text-white transition">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Review Berita</p>
                <p class="text-[10px] text-gray-400">
                    <?php if($pendingCount > 0): ?>
                        <span class="text-orange-600 font-bold"><?php echo e($pendingCount); ?> menunggu</span>
                    <?php else: ?>
                        Tidak ada pending
                    <?php endif; ?>
                </p>
            </div>
        </a>

        <a href="<?php echo e(route('admin.kontak.index')); ?>" 
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#006400] transition group">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-[#006400] group-hover:text-white transition">
                <i class="fas fa-envelope"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Kontak Masuk</p>
                <p class="text-[10px] text-gray-400">
                    <?php if($unreadCount > 0): ?>
                        <span class="text-red-600 font-bold"><?php echo e($unreadCount); ?> belum dibaca</span>
                    <?php else: ?>
                        Semua sudah dibaca
                    <?php endif; ?>
                </p>
            </div>
        </a>
        <?php endif; ?>

        
        <?php if($role == 'editor'): ?>
        <a href="<?php echo e(route('admin.berita.create')); ?>" 
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#006400] transition group">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-[#006400] group-hover:text-white transition">
                <i class="fas fa-pen"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Buat Berita</p>
                <p class="text-[10px] text-gray-400">Publikasi baru</p>
            </div>
        </a>

        <a href="<?php echo e(route('admin.berita.index')); ?>" 
           class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#006400] transition group">
            <div class="w-10 h-10 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center group-hover:bg-[#006400] group-hover:text-white transition">
                <i class="fas fa-file-pen"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Draft Saya</p>
                <p class="text-[10px] text-gray-400">
                    <?php
                        $myDrafts = \App\Models\Berita::where('penulis', auth()->user()->name)
                                    ->where('status_approval', 'Draft')
                                    ->count();
                    ?>
                    <?php if($myDrafts > 0): ?>
                        <span class="text-yellow-600 font-bold"><?php echo e($myDrafts); ?> draft</span>
                    <?php else: ?>
                        Tidak ada draft
                    <?php endif; ?>
                </p>
            </div>
        </a>
        <?php endif; ?>
    </div>

    <!-- PROFIL ADMIN CARD -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <?php if($user->foto): ?>
                <img src="<?php echo e(asset('storage/' . $user->foto)); ?>"
                    class="w-16 h-16 rounded-full object-cover border-2 border-gray-200 flex-shrink-0"
                    alt="<?php echo e($user->name); ?>">
            <?php else: ?>
                <div class="w-16 h-16 bg-[#006400] rounded-full flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                </div>
            <?php endif; ?>

            <div class="flex-1">
                <h2 class="text-lg font-bold text-gray-900"><?php echo e($user->name); ?></h2>
                <div class="flex flex-wrap items-center gap-2 mt-0.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold
                        <?php echo e($user->role == 'super_admin' ? 'bg-purple-50 text-purple-700' :
                           ($user->role == 'admin' ? 'bg-blue-50 text-blue-700' :
                           ($user->role == 'editor' ? 'bg-yellow-50 text-yellow-700' :
                           ($user->role == 'publisher' ? 'bg-green-50 text-green-700' :
                           'bg-gray-50 text-gray-500')))); ?>">
                        <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                    </span>
                    <span class="text-xs text-gray-400"><?php echo e($user->email); ?></span>
                </div>
                <p class="text-sm text-gray-500 mt-1.5">
                    <?php if($role == 'super_admin'): ?>
                        Anda memiliki akses penuh ke semua fitur.
                    <?php elseif($role == 'admin'): ?>
                        Anda dapat mengelola konten website.
                    <?php elseif($role == 'editor'): ?>
                        Anda dapat membuat dan mengedit draft konten.
                    <?php elseif($role == 'publisher'): ?>
                        Anda dapat mereview dan mempublikasikan konten.
                    <?php endif; ?>
                </p>
            </div>

            <a href="<?php echo e(route('profile.edit')); ?>" class="text-sm text-[#006400] hover:underline font-semibold">
                <i class="fas fa-pen mr-1"></i> Edit Profil
            </a>
        </div>
    </div>

    <!-- PESAN ROLE WELCOME -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-100 rounded-2xl px-5 py-4 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fas fa-shield-halved text-green-700 text-lg"></i>
            </div>
            <div class="text-sm text-green-800 leading-relaxed">
                <?php if($role == 'super_admin'): ?>
                    <strong class="text-base">Selamat datang, Super Admin! 🚀</strong><br>
                    Anda memiliki akses penuh ke semua fitur termasuk <strong>Manajemen Pengguna</strong>,
                    <strong>Konfigurasi Sistem</strong>, dan <strong>Integrasi</strong>.
                <?php elseif($role == 'admin'): ?>
                    <strong class="text-base">Selamat datang, Admin! 📋</strong><br>
                    Anda dapat mengelola <strong>Aset</strong>, <strong>Halaman Statis</strong>,
                    <strong>Menu Navigasi</strong>, <strong>Footer</strong>, <strong>FAQ</strong>,
                    <strong>Karier</strong>, dan <strong>Kontak</strong>.
                <?php elseif($role == 'editor'): ?>
                    <strong class="text-base">Selamat datang, Editor! ✍️</strong><br>
                    Anda dapat membuat dan mengedit draft <strong>Berita</strong>, <strong>Siaran Pers</strong>,
                    dan <strong>Pengumuman</strong>. Konten yang sudah siap harus
                    <strong>disubmit</strong> untuk approval ke Publisher.
                <?php elseif($role == 'publisher'): ?>
                    <strong class="text-base">Selamat datang, Publisher! ✅</strong><br>
                    Anda dapat <strong>mereview</strong>, <strong>menyetujui</strong>, dan
                    <strong>mempublikasikan</strong> konten Publikasi yang sudah disubmit oleh Editor.
                    <?php if($pendingCount > 0): ?>
                        <br><span class="text-orange-600 font-bold">🔔 <?php echo e($pendingCount); ?> berita menunggu approval!</span>
                    <?php endif; ?>
                <?php else: ?>
                    <strong class="text-base">Selamat datang!</strong><br>
                    Anda hanya dapat mengakses beberapa fitur terbatas.
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Total Aset</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5"><?php echo e(number_format($totalAset, 0, ',', '.')); ?></h3>
                    <p class="text-[10px] text-green-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>Data real</p>
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
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5"><?php echo e(number_format($totalBerita, 0, ',', '.')); ?></h3>
                    <p class="text-[10px] text-blue-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>Data real</p>
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
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5"><?php echo e(number_format($totalPengunjung, 0, ',', '.')); ?></h3>
                    <p class="text-[10px] text-purple-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>Google Analytics</p>
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
                    <h3 class="text-2xl font-bold text-gray-900 mt-1.5"><?php echo e(number_format($totalLuas, 0, ',', '.')); ?></h3>
                    <p class="text-[10px] text-orange-600 mt-0.5">Hektar</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center">
                    <i class="fas fa-ruler-combined text-orange-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFIK + PUBLIKASI -->
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
                <a href="<?php echo e(route('admin.berita.index')); ?>" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            <?php
                $publikasiTerbaru = \App\Models\Berita::where('status', 'Dipublikasikan')->latest()->take(4)->get();
            ?>

            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $publikasiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('admin.berita.index')); ?>" class="flex items-center gap-3 group hover:bg-gray-50 rounded-xl p-2 -mx-2 transition">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                            <?php if($item->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" class="w-full h-full object-cover" alt="<?php echo e($item->judul); ?>">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B2A4A] to-[#163F66]">
                                    <i class="fas fa-newspaper text-white/30 text-lg"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[8px] font-bold uppercase px-1.5 py-0.5 rounded-full
                                    <?php echo e($item->kategori == 'Siaran Pers' ? 'bg-blue-50 text-blue-600' :
                                       ($item->kategori == 'Pengumuman' ? 'bg-orange-50 text-orange-600' :
                                       'bg-green-50 text-green-600')); ?>">
                                    <?php echo e($item->kategori); ?>

                                </span>
                            </div>
                            <h4 class="text-[11px] font-semibold text-gray-900 truncate mt-1 group-hover:text-blue-600 transition">
                                <?php echo e($item->judul); ?>

                            </h4>
                            <p class="text-[9px] text-gray-400 mt-0.5">
                                <i class="far fa-calendar-alt mr-1"></i>
                                <?php echo e($item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') : $item->created_at?->format('d M Y')); ?>

                                <span class="mx-1">•</span>
                                <i class="far fa-eye mr-1"></i>
                                <?php echo e(number_format($item->views ?? 0, 0, ',', '.')); ?>

                            </p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-400 text-xs">
                        <i class="fas fa-newspaper text-2xl block mb-2 text-gray-300"></i>
                        Belum ada publikasi.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- AKTIVITAS TERBARU -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Aktivitas Terbaru</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Aktivitas pengelolaan sistem</p>
            </div>
            <a href="<?php echo e(route('admin.activity-log')); ?>" class="text-[10px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            <?php
                $activities = \Spatie\Activitylog\Models\Activity::with('causer')->latest()->take(5)->get();
            ?>
            
            <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
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
                ?>
                <div class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition">
                    <div class="w-8 h-8 rounded-lg <?php echo e($bg); ?> flex items-center justify-center flex-shrink-0">
                        <i class="fas <?php echo e($icon); ?> text-<?php echo e($color); ?>-600 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-800"><?php echo e(ucfirst($activity->description)); ?></p>
                        <p class="text-[10px] text-gray-400 mt-0.5">
                            <?php echo e($subjectType); ?> • oleh <?php echo e($causerName); ?>

                        </p>
                    </div>
                    <span class="text-[9px] text-gray-400 flex-shrink-0"><?php echo e($activity->created_at->diffForHumans()); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-5 py-8 text-center text-xs text-gray-400">
                    <i class="fas fa-inbox text-2xl block mb-2 text-gray-300"></i>
                    Belum ada aktivitas.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ASET TERBARU -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Aset Terbaru</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Data aset tanah yang terakhir ditambahkan</p>
            </div>
            <a href="<?php echo e(route('admin.aset.index')); ?>" class="text-[11px] font-semibold text-blue-600 hover:underline">Lihat Semua</a>
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
                    <?php $__empty_1 = true; $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                        <?php if($aset->gambar): ?>
                                            <img src="<?php echo e(asset('storage/' . $aset->gambar)); ?>" class="w-full h-full object-cover" alt="<?php echo e($aset->nama_lokasi); ?>">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center bg-[#0B2A4A]/10">
                                                <i class="fas fa-map-pin text-gray-400 text-xs"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-900 truncate max-w-[120px]"><?php echo e($aset->nama_lokasi); ?></p>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-gray-500"><?php echo e($aset->provinsi); ?></td>
                            <td class="px-5 py-3.5 text-xs font-semibold text-gray-700"><?php echo e(number_format($aset->luas_hektar, 2, ',', '.')); ?> Ha</td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-bold
                                    <?php echo e($aset->status == 'Tersedia' ? 'bg-green-50 text-green-700' :
                                       ($aset->status == 'Dalam Pengembangan' ? 'bg-blue-50 text-blue-700' :
                                       'bg-orange-50 text-orange-700')); ?>">
                                    <?php echo e($aset->status); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-xs text-gray-400">
                                <i class="fas fa-database text-2xl block mb-2 text-gray-300"></i>
                                Belum ada data aset.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FOOTER DASHBOARD -->
    <div class="text-center text-[10px] text-gray-400 py-4 border-t border-gray-200/50">
        <p>
            &copy; <?php echo e(date('Y')); ?> Badan Bank Tanah - Indonesia Land Bank Authority.
            <span class="hidden sm:inline">Dikelola melalui CMS Admin Panel.</span>
        </p>
        <p class="mt-0.5">
            <span class="inline-flex items-center gap-1">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-500"></span>
                Sistem berjalan dengan baik
            </span>
            <span class="mx-1">•</span>
            Laravel v<?php echo e(app()->version()); ?>

        </p>
    </div>

</div>

<!-- CHART.JS -->
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
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>