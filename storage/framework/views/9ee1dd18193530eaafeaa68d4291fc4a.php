<?php $__env->startSection('title', 'Aset Persediaan Tanah'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto">
        <!-- Header Halaman -->
        <div class="flex items-start gap-4 mb-6">
            <div class="w-14 h-14 bg-green-100 text-[#006400] rounded-full flex items-center justify-center">
                <i class="fas fa-map-marked-alt text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Aset Persediaan Tanah</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data aset persediaan tanah Badan Bank Tanah.</p>
            </div>
        </div>

        <!-- TAB NAVIGASI ASET - RESPONSIVE -->
        <div class="flex flex-wrap items-center gap-1.5 border-b border-gray-200 pb-3 mb-6">
            <a href="<?php echo e(route('admin.aset.index')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.index') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-database text-sm"></i>
                <span>Data Aset</span>
            </a>

            <a href="<?php echo e(route('admin.aset.peta')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.peta') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-map-location-dot text-sm"></i>
                <span>Peta Interaktif</span>
            </a>

            <a href="<?php echo e(route('admin.aset.profil')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.profil') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-layer-group text-sm"></i>
                <span>Profil Persediaan Tanah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.pengelolaan')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.pengelolaan') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-gear text-sm"></i>
                <span>Pengelolaan Tanah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.pengembangan')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.pengembangan') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-chart-line text-sm"></i>
                <span>Pengembangan Tanah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.wilayah')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.wilayah') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-map text-sm"></i>
                <span>Wilayah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.status')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.status') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-circle-check text-sm"></i>
                <span>Status Tanah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.dokumen')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.dokumen') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-file-lines text-sm"></i>
                <span>Dokumen</span>
            </a>

            <a href="<?php echo e(route('admin.aset.statistik')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                <?php echo e(request()->routeIs('admin.aset.statistik') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-chart-pie text-sm"></i>
                <span>Statistik</span>
            </a>
        </div>

        <!-- KARTU STATISTIK ASET - DATA REAL -->
        <?php
            $totalAset = \App\Models\AsetTanah::count();
            $totalLokasi = \App\Models\AsetTanah::count();
            $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
            $totalKabupaten = \App\Models\AsetTanah::distinct('kabupaten')->count('kabupaten');
            $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
            $totalNilai = 68450000000000; // Rp 68,45 T (bisa diambil dari setting nanti)
        ?>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-6">

            <!-- TOTAL ASET -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-layer-group text-green-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Total Aset</p>
                        <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($totalAset)); ?></p>
                        <p class="text-[8px] text-green-600 truncate">Data aset terdaftar</p>
                    </div>
                </div>
            </div>

            <!-- LOKASI ASET -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-location-dot text-blue-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Lokasi Aset</p>
                        <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($totalLokasi)); ?></p>
                        <p class="text-[8px] text-blue-600 truncate">Lokasi terdata</p>
                    </div>
                </div>
            </div>

            <!-- WILAYAH -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-yellow-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-map text-yellow-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Wilayah</p>
                        <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($totalProvinsi)); ?></p>
                        <p class="text-[8px] text-yellow-600 truncate">Wilayah terdata</p>
                    </div>
                </div>
            </div>

            <!-- KABUPATEN / KOTA -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-city text-purple-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Kabupaten/Kota</p>
                        <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($totalKabupaten)); ?></p>
                        <p class="text-[8px] text-purple-600 truncate">Daerah terdata</p>
                    </div>
                </div>
            </div>

            <!-- NILAI INDIKATIF -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-money-bill-trend-up text-teal-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Nilai Indikatif</p>
                        <p class="text-sm font-bold text-gray-900 whitespace-nowrap">Rp 68,45 T</p>
                        <p class="text-[8px] text-teal-600 truncate">Nilai estimasi aset</p>
                    </div>
                </div>
            </div>

        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Daftar Aset Tabel -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Daftar Aset Persediaan Tanah</h3>
                <a href="<?php echo e(route('admin.aset.create')); ?>"
                    class="bg-[#006400] hover:bg-[#005500] text-white px-4 py-2 rounded text-sm font-bold">+ Tambah Aset</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-600">Kode Aset</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Nama Lokasi</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Provinsi</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Kabupaten</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Luas (Ha)</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-gray-100">
                        <?php $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">BT-2025-<?php echo e(sprintf('%04d', $aset->id)); ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <?php if($aset->gambar): ?>
                                            <img src="<?php echo e(asset('storage/' . $aset->gambar)); ?>"
                                                class="w-10 h-10 rounded object-cover">
                                        <?php else: ?>
                                            <img src="https://picsum.photos/50/50?random=<?php echo e($loop->index); ?>"
                                                class="w-10 h-10 rounded object-cover">
                                        <?php endif; ?>
                                        <span class="font-medium"><?php echo e($aset->nama_lokasi); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><?php echo e($aset->provinsi); ?></td>
                                <td class="px-6 py-4"><?php echo e($aset->kabupaten); ?></td>
                                <td class="px-6 py-4"><?php echo e(number_format($aset->luas_hektar, 2, ',', '.')); ?></td>
                                <td class="px-6 py-4">
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold"><?php echo e($aset->status); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 text-gray-500">
                                        <a href="<?php echo e(route('admin.aset.edit', $aset->id)); ?>" class="hover:text-[#006400]"><i class="fas fa-pen"></i></a>
                                        <form action="<?php echo e(route('admin.aset.destroy', $aset->id)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="hover:text-red-600"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/aset_index.blade.php ENDPATH**/ ?>