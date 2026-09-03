<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>

<!-- ========================================================= -->
<!-- HERO SINGLE BACKGROUND -->
<div id="heroSlider"
     class="relative h-[400px] sm:h-[500px] md:h-[600px] lg:h-[650px] overflow-hidden select-none"
     style="background-image: url('/background-awal.jpg'); background-size: cover; background-position: center;">

    <!-- Animated cloud overlay -->
    <div class="hero-clouds" aria-hidden="true"></div>

    <!-- Overlay agar teks tetap terbaca -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#0B2A4A]/85 via-[#0B2A4A]/45 to-transparent z-10"></div>

    <!-- Konten hero -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
        <span class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-widest mb-2 sm:mb-4">
            Badan Bank Tanah
        </span>

        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight max-w-2xl">
            <?php if($isEnglish && !empty($pengaturan->judul_hero_en)): ?>
                <?php echo e($pengaturan->judul_hero_en); ?>

            <?php else: ?>
                <?php echo e($pengaturan->judul_hero ?? 'Mengelola Tanah, Memajukan Negeri'); ?>

            <?php endif; ?>
        </h1>

        <p class="text-white/90 text-sm sm:text-base md:text-lg mt-3 sm:mt-4 mb-6 sm:mb-8 max-w-xl leading-relaxed">
            <?php if($isEnglish && !empty($pengaturan->subjudul_hero_en)): ?>
                <?php echo e($pengaturan->subjudul_hero_en); ?>

            <?php else: ?>
                <?php echo e($pengaturan->subjudul_hero ?? 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.'); ?>

            <?php endif; ?>
        </p>

        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
            <a href="<?php echo e($pengaturan->tombol_link ?? '/aset'); ?>"
               class="btn-primary px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-bold text-sm sm:text-base transition inline-block">
                <?php echo e($pengaturan->tombol_text ?? ($isEnglish ? 'Learn More' : 'Selengkapnya')); ?>

            </a>
        </div>
    </div>
</div>
<!-- STATISTIK - DATA REAL DARI DATABASE -->
<!-- ========================================================= -->
<?php
    $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
    $totalAset = \App\Models\AsetTanah::count();
    $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
    $totalKerjasama = \App\Models\ProyekInvestasi::where('is_active', true)->count();
    $nilaiAset = 68450000000000;

    // Translation labels
    $statLabels = [
        'total_luas' => $isEnglish ? 'Total Land Area' : 'Total Luas Aset',
        'total_asets' => $isEnglish ? 'Total Assets' : 'Lokasi Aset',
        'wilayah' => $isEnglish ? 'Regions' : 'Wilayah',
        'kerjasama' => $isEnglish ? 'Active Partnerships' : 'Kerja Sama Aktif',
        'nilai_aset' => $isEnglish ? 'Asset Value' : 'Nilai Aset',
        'estimasi' => $isEnglish ? 'Estimated Value' : 'Estimasi Nilai',
    ];
?>

<div class="w-full px-3 sm:px-4 -mt-10 sm:-mt-16 relative z-10">
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-lg px-4 sm:px-6 md:px-10 py-4 sm:py-6">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 md:gap-6">

            <!-- Total Luas Aset -->
            <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-layer-group text-base sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate"><?php echo e($statLabels['total_luas']); ?></p>
                    <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900"><?php echo e(number_format($totalLuas, 0, ',', '.')); ?> Ha</p>
                    <p class="text-[7px] sm:text-[8px] text-green-600"><?php echo e($isEnglish ? 'Real data' : 'Data real dari database'); ?></p>
                </div>
            </div>

            <!-- Lokasi Aset -->
            <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-location-dot text-base sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate"><?php echo e($statLabels['total_asets']); ?></p>
                    <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900"><?php echo e(number_format($totalAset)); ?></p>
                    <p class="text-[7px] sm:text-[8px] text-gray-400 truncate"><?php echo e($isEnglish ? 'Land Plots' : 'Bidang Tanah'); ?></p>
                </div>
            </div>

            <!-- Wilayah -->
            <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-building text-base sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate"><?php echo e($statLabels['wilayah']); ?></p>
                    <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900"><?php echo e(number_format($totalProvinsi)); ?></p>
                    <p class="text-[7px] sm:text-[8px] text-gray-400 truncate"><?php echo e($isEnglish ? 'Provinces' : 'Provinsi'); ?></p>
                </div>
            </div>

            <!-- Kerja Sama Aktif -->
            <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-green-50 text-green-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-handshake text-base sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate"><?php echo e($statLabels['kerjasama']); ?></p>
                    <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900"><?php echo e($totalKerjasama > 0 ? number_format($totalKerjasama) : '0'); ?></p>
                    <p class="text-[7px] sm:text-[8px] text-gray-400 truncate"><?php echo e($isEnglish ? 'Strategic Partners' : 'Mitra Strategis'); ?></p>
                </div>
            </div>

            <!-- Nilai Aset -->
            <div class="hidden sm:flex items-center gap-3 px-3 py-3 col-span-2 sm:col-span-1">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] text-gray-500 font-medium truncate"><?php echo e($statLabels['nilai_aset']); ?></p>
                    <p class="text-base md:text-xl font-extrabold text-blue-700">Rp 68,45 T</p>
                    <p class="text-[8px] text-gray-400 truncate"><?php echo e($statLabels['estimasi']); ?></p>
                </div>
            </div>

            <!-- Nilai Aset (Mobile) -->
            <div class="sm:hidden col-span-2 flex items-center justify-center gap-3 px-3 py-2 border-t border-gray-100 pt-3 mt-1">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-line text-base"></i>
                </div>
                <div>
                    <p class="text-[8px] text-gray-500 font-medium"><?php echo e($statLabels['nilai_aset']); ?></p>
                    <p class="text-sm font-extrabold text-blue-700">Rp 68,45 T</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- ASET & PETA SECTION -->
<!-- ========================================================= -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 lg:py-20">
    <div class="grid grid-cols-1 lg:grid-cols-[1.35fr_0.85fr] gap-6 sm:gap-8 lg:gap-10">

        <!-- ASET PERSEDIAAN TANAH -->
        <div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
            <div class="flex items-end justify-between mb-4 sm:mb-5">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900"><?php echo e($isEnglish ? 'Land Asset Inventory' : 'Aset Persediaan Tanah'); ?></h2>
                </div>
                <a href="<?php echo e(route('assets')); ?>" class="text-[10px] font-semibold link-secondary">
                    <?php echo e($isEnglish ? 'View All →' : 'Lihat Semua'); ?>

                </a>
            </div>

            <!-- Asset Slider -->
            <div class="relative overflow-hidden">
                <div id="assetSlider" class="flex transition-transform duration-500 ease-in-out gap-3 sm:gap-4">
                    <?php $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="asset-card min-w-[85%] sm:min-w-[60%] md:min-w-[50%] lg:min-w-[33.33%] flex-shrink-0">
                        <div class="bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                            <div class="relative h-36 sm:h-40 md:h-48 bg-gray-200">
                                <img src="<?php echo e($aset->gambar ? asset('storage/' . $aset->gambar) : 'https://picsum.photos/600/400?random=' . $aset->id); ?>"
                                    class="w-full h-full object-cover"
                                    alt="<?php echo e($aset->nama_lokasi); ?>"
                                    loading="lazy">
                                <span class="absolute top-2 sm:top-3 left-2 sm:left-3 text-white text-[8px] sm:text-[10px] px-2 sm:px-3 py-0.5 sm:py-1 rounded font-bold uppercase
                                    <?php echo e($aset->status == 'Tersedia' ? 'bg-green-700' : 'bg-blue-700'); ?>">
                                    <?php echo e($aset->status); ?>

                                </span>
                            </div>
                            <div class="p-3 sm:p-4">
                                <h3 class="text-xs sm:text-sm font-bold text-gray-900 leading-snug line-clamp-2">
                                    <?php if($isEnglish && !empty($aset->nama_lokasi_en)): ?>
                                        <?php echo e($aset->nama_lokasi_en); ?>

                                    <?php else: ?>
                                        <?php echo e($aset->nama_lokasi); ?>

                                    <?php endif; ?>
                                </h3>
                                <p class="text-[10px] sm:text-xs text-gray-500 mt-0.5 sm:mt-1">
                                    <?php echo e($aset->provinsi); ?>, <?php echo e($aset->kabupaten); ?>

                                </p>
                                <p class="text-xs sm:text-sm font-bold text-green-600 mt-1 sm:mt-2">
                                    <?php echo e(number_format($aset->luas_hektar, 2, ',', '.')); ?> Ha
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Dots -->
            <div id="assetDots" class="flex justify-center items-center gap-1.5 sm:gap-2 mt-3 sm:mt-4">
                <?php $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button"
                    class="asset-dot w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full transition-all duration-300
                    <?php echo e($index === 0 ? 'bg-blue-700' : 'bg-gray-300'); ?>"
                    data-slide="<?php echo e($index); ?>">
                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- PETA INTERAKTIF -->
        <div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
            <div class="flex items-end justify-between mb-3 sm:mb-4">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900"><?php echo e($isEnglish ? 'Interactive Map' : 'Peta Interaktif'); ?></h2>
                </div>
                <a href="<?php echo e(route('assets')); ?>" class="text-[10px] font-semibold link-secondary">
                    <?php echo e($isEnglish ? 'View Map →' : 'Lihat Peta'); ?>

                </a>
            </div>

            <div id="map" class="w-full h-[220px] sm:h-[280px] md:h-[320px] rounded-xl shadow-md border border-gray-200 bg-blue-50">
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-3 sm:mt-4 text-[8px] sm:text-[10px] text-gray-600">
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-700"></span>
                    <?php echo e($isEnglish ? 'Available' : 'Tersedia'); ?>

                </div>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <?php echo e($isEnglish ? 'In Development' : 'Dalam Pengembangan'); ?>

                </div>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    <?php echo e($isEnglish ? 'In Process' : 'Dalam Proses'); ?>

                </div>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                    <?php echo e($isEnglish ? 'Committed' : 'Terikat'); ?>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- ========================================================= -->
<!-- PEMANFAATAN & KERJA SAMA + PUBLIKASI -->
<!-- ========================================================= -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-10">

        <!-- PEMANFAATAN & KERJA SAMA -->
        <div class="lg:col-span-3">
            <div class="flex items-end justify-between mb-5 sm:mb-7">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900"><?php echo e($isEnglish ? 'Utilization & Partnerships' : 'Pemanfaatan & Kerja Sama'); ?></h2>
                <a href="<?php echo e(route('partnership')); ?>" class="text-xs font-semibold link-secondary">
                    <?php echo e($isEnglish ? 'View All →' : 'Lihat Semua'); ?>

                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 md:gap-6">

                <!-- Investasi -->
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-full bg-blue-50 flex items-center justify-center mb-2 sm:mb-3">
                        <i class="fas fa-chart-line text-blue-600 text-lg sm:text-2xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900"><?php echo e($isEnglish ? 'Investment' : 'Investasi'); ?></h3>
                    <p class="text-[8px] sm:text-[10px] text-gray-500 leading-relaxed mt-0.5 sm:mt-1 hidden sm:block">
                        <?php echo e($isEnglish ? 'Productive land utilization' : 'Pemanfaatan tanah untuk investasi produktif.'); ?>

                    </p>
                    <a href="<?php echo e(route('partnership')); ?>" class="text-[9px] sm:text-xs link-secondary font-semibold">
                        <?php echo e($isEnglish ? 'Learn More →' : 'Selengkapnya'); ?>

                    </a>
                </div>

                <!-- Reforma Agraria -->
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-full bg-green-50 flex items-center justify-center mb-2 sm:mb-3">
                        <i class="fas fa-leaf text-green-600 text-lg sm:text-2xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900"><?php echo e($isEnglish ? 'Agrarian Reform' : 'Reforma Agraria'); ?></h3>
                    <p class="text-[8px] sm:text-[10px] text-gray-500 leading-relaxed mt-0.5 sm:mt-1 hidden sm:block">
                        <?php echo e($isEnglish ? 'Supporting equitable land access' : 'Mendukung pemerataan akses tanah.'); ?>

                    </p>
                    <a href="<?php echo e(route('partnership')); ?>" class="text-[9px] sm:text-xs link-secondary font-semibold">
                        <?php echo e($isEnglish ? 'Learn More →' : 'Selengkapnya'); ?>

                    </a>
                </div>

                <!-- Kerja Sama -->
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-full bg-yellow-50 flex items-center justify-center mb-2 sm:mb-3">
                        <i class="fas fa-handshake text-yellow-600 text-lg sm:text-2xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900"><?php echo e($isEnglish ? 'Partnership' : 'Kerja Sama'); ?></h3>
                    <p class="text-[8px] sm:text-[10px] text-gray-500 leading-relaxed mt-0.5 sm:mt-1 hidden sm:block">
                        <?php echo e($isEnglish ? 'Strategic collaboration' : 'Kolaborasi strategis pengelolaan tanah.'); ?>

                    </p>
                    <a href="<?php echo e(route('partnership')); ?>" class="text-[9px] sm:text-xs link-secondary font-semibold">
                        <?php echo e($isEnglish ? 'Learn More →' : 'Selengkapnya'); ?>

                    </a>
                </div>

                <!-- Dokumen -->
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-full bg-purple-50 flex items-center justify-center mb-2 sm:mb-3">
                        <i class="fas fa-file-lines text-purple-600 text-lg sm:text-2xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900"><?php echo e($isEnglish ? 'Documents' : 'Dokumen'); ?></h3>
                    <p class="text-[8px] sm:text-[10px] text-gray-500 leading-relaxed mt-0.5 sm:mt-1 hidden sm:block">
                        <?php echo e($isEnglish ? 'Related information and documents' : 'Informasi dan dokumen terkait.'); ?>

                    </p>
                    <a href="<?php echo e(route('publications')); ?>" class="text-[9px] sm:text-xs link-secondary font-semibold">
                        <?php echo e($isEnglish ? 'Learn More →' : 'Selengkapnya'); ?>

                    </a>
                </div>

            </div>
        </div>

        <!-- PUBLIKASI TERBARU -->
        <div class="lg:col-span-2">
            <div class="flex items-end justify-between mb-5 sm:mb-7">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900"><?php echo e($isEnglish ? 'Latest Publications' : 'Publikasi Terbaru'); ?></h2>
                <a href="<?php echo e(route('publications')); ?>" class="text-xs font-semibold link-secondary">
                    <?php echo e($isEnglish ? 'View All →' : 'Lihat Semua'); ?>

                </a>
            </div>

            <div class="space-y-2 sm:space-y-3">
                <?php $__currentLoopData = $berita->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('publications.show', $item->id)); ?>"
                    class="group flex items-center gap-3 sm:gap-4 bg-white rounded-lg overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-2 sm:p-3">

                    <div class="w-14 h-14 sm:w-20 sm:h-20 flex-shrink-0 overflow-hidden bg-gray-100 rounded-lg">
                        <?php if($item->gambar): ?>
                            <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" alt="<?php echo e($item->judul); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy">
                        <?php else: ?>
                            <img src="https://picsum.photos/300/200?random=<?php echo e($item->id); ?>"
                                alt="<?php echo e($item->judul); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy">
                        <?php endif; ?>
                    </div>

                    <div class="flex-1 min-w-0">
                        <span class="text-[7px] sm:text-[8px] font-bold uppercase px-1.5 py-0.5 rounded-full
                            <?php echo e($item->kategori == 'Siaran Pers' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700'); ?>">
                            <?php echo e($item->kategori); ?>

                        </span>
                        <h3 class="text-[10px] sm:text-xs font-bold text-gray-900 leading-tight mt-0.5 line-clamp-2 group-hover:text-[var(--color-secondary)] transition-colors">
                            <?php if($isEnglish && !empty($item->judul_en)): ?>
                                <?php echo e($item->judul_en); ?>

                            <?php else: ?>
                                <?php echo e($item->judul); ?>

                            <?php endif; ?>
                        </h3>
                        <p class="text-[8px] sm:text-[9px] text-gray-400 mt-0.5">
                            <?php echo e($item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') : $item->created_at?->format('d M Y')); ?>

                        </p>
                    </div>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================= -->
<!-- CTA SECTION -->
<!-- ========================================================= -->
<div class="bg-[#0B2A4A] relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=1600&auto=format&fit=crop')] bg-cover bg-center opacity-20">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20 flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-8">
        <div class="text-center sm:text-left">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">
                <?php echo e($isEnglish ? 'Together Managing Land' : 'Bersama Mengelola Tanah'); ?>

            </h2>
            <p class="text-blue-200 text-sm sm:text-base lg:text-lg">
                <?php echo e($isEnglish ? 'for a better future of Indonesia.' : 'untuk Masa Depan Indonesia yang lebih baik.'); ?>

            </p>
        </div>
        <a href="<?php echo e(route('partnership')); ?>"
            class="btn-primary px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-bold text-sm sm:text-base transition shrink-0 inline-block">
            <?php echo e($isEnglish ? 'Learn More →' : 'Pelajari Lebih Lanjut'); ?>

        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<style>
#heroSlider {
    position: relative;
    overflow: hidden;
}

#heroSlider .hero-clouds {
    position: absolute;
    inset: 0;
    z-index: 10;
    pointer-events: none;
    opacity: 0.42;
    background-image: url('/background_awan.png');
    background-repeat: repeat-x;
    background-position: 0 15%;
    background-size: auto 48%;
    animation: moveHeroClouds 110s linear infinite;
}

@keyframes moveHeroClouds {
    from {
        background-position: 0 15%;
    }

    to {
        background-position: -2200px 15%;
    }
}

@media (max-width: 640px) {
    #heroSlider .hero-clouds {
        background-size: auto 38%;
        opacity: 0.32;
        animation-duration: 130s;
    }
}

@media (prefers-reduced-motion: reduce) {
    #heroSlider .hero-clouds {
        animation: none;
    }
}
</style>

<?php $__env->startPush("scripts"); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    console.log("🚀 Memulai inisialisasi peta...");

    // Cek apakah Leaflet tersedia
    if (typeof L === "undefined") {
        console.error("❌ Leaflet tidak ditemukan! Pastikan leaflet.js sudah dimuat.");
        return;
    }

    // Ambil elemen map
    var mapElement = document.getElementById("map");
    if (!mapElement) {
        console.error("❌ Element #map tidak ditemukan!");
        return;
    }

    console.log("✅ Element map ditemukan, lebar: " + mapElement.offsetWidth + "px");

    try {
        // Inisialisasi peta
        var map = L.map("map").setView([-2.5, 118.0], 5);

        // Tambahkan tile layer
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; OpenStreetMap contributors",
            maxZoom: 19
        }).addTo(map);

        // Data markers dari database
        var markers = <?php echo json_encode($markers ?? [], 15, 512) ?>;

        console.log("📌 Jumlah marker: " + markers.length);

        // Jika ada marker, tambahkan ke peta
        if (markers.length > 0) {
            markers.forEach(function(marker, index) {
                if (marker.lat && marker.lng) {
                    var color = marker.status === "Tersedia" ? "#16a34a" :
                               (marker.status === "Dalam Pengembangan" ? "#3b82f6" :
                               (marker.status === "Dalam Proses" ? "#f97316" : "#6b7280"));

                    var popupContent = `
                        <div style="min-width:200px;font-family:Inter,sans-serif;padding:4px 0;">
                            <div style="font-weight:700;font-size:15px;color:#111827;margin-bottom:4px;">
                                ${marker.nama_lokasi || "Aset Tanah"}
                            </div>
                            <div style="font-size:12px;color:#6B7280;margin-bottom:8px;">
                                📍 ${marker.provinsi || ""}${marker.kabupaten ? ", " + marker.kabupaten : ""}
                            </div>
                            <div style="background:#f0fdf4;padding:10px;border-radius:8px;margin-bottom:8px;">
                                <div style="font-size:9px;color:#6B7280;text-transform:uppercase;">Total Luas</div>
                                <div style="font-size:16px;font-weight:700;color:#006400;">
                                    ${Number(marker.luas_hektar).toLocaleString("id-ID")} Ha
                                </div>
                            </div>
                            <div style="font-size:12px;color:#4B5563;line-height:1.8;">
                                <strong>Status:</strong> <span style="color:${color};font-weight:600;">${marker.status || "-"}</span><br>
                                <strong>Peruntukan:</strong> ${marker.peruntukan || "-"}<br>
                                <strong>Skema:</strong> ${marker.skema || "-"}
                            </div>
                        </div>
                    `;

                    L.circleMarker([marker.lat, marker.lng], {
                        color: color,
                        fillColor: color,
                        fillOpacity: 0.7,
                        radius: 8,
                        weight: 2,
                        opacity: 1
                    }).addTo(map).bindPopup(popupContent);

                    console.log("✅ Marker added: " + (marker.nama_lokasi || "Unknown"));
                }
            });

            // Fit bounds ke semua marker
            var bounds = markers.filter(m => m.lat && m.lng).map(m => [m.lat, m.lng]);
            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [30, 30], maxZoom: 6 });
                console.log("✅ Peta di-zoom ke semua marker");
            }
        } else {
            console.log("ℹ️ Tidak ada marker untuk ditampilkan");
        }

        // Resize map setelah 500ms
        setTimeout(function() {
            map.invalidateSize();
            console.log("✅ Peta di-resize");
        }, 500);

        console.log("✅ Peta berhasil diinisialisasi!");
    } catch (e) {
        console.error("❌ Error inisialisasi peta:", e);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const hero = document.getElementById('heroSlider');
    if (hero) {
        hero.classList.add('hero-single-background');
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u250369146/laravel-app/resources/views/frontend/home.blade.php ENDPATH**/ ?>