<?php $__env->startSection('title', 'Wilayah'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-7xl mx-auto">

    
    <div class="mb-5">
        <h1 class="text-xl font-bold text-gray-900">Aset Persediaan Tanah</h1>
        <p class="text-[10px] text-gray-500 mt-1">Kelola dan pantau informasi persediaan tanah.</p>
    </div>

    
    <div class="overflow-x-auto">
        <?php echo $__env->make('admin.aset._navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-5">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-[#006400] flex items-center justify-center flex-shrink-0">
                <i class="fas fa-map-location-dot text-xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-bold text-gray-900">Wilayah</h2>
                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Informasi sebaran wilayah aset persediaan tanah.</p>
            </div>
        </div>
    </div>

    
    <?php
        $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
        $totalKabupaten = \App\Models\AsetTanah::distinct('kabupaten')->count('kabupaten');
        $totalAset = \App\Models\AsetTanah::count();
        $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
    ?>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Provinsi</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-2"><?php echo e(number_format($totalProvinsi)); ?></h3>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Kabupaten/Kota</p>
            <h3 class="text-2xl font-bold text-blue-600 mt-2"><?php echo e(number_format($totalKabupaten)); ?></h3>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Total Aset</p>
            <h3 class="text-2xl font-bold text-green-600 mt-2"><?php echo e(number_format($totalAset)); ?></h3>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Total Luas</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-2"><?php echo e(number_format($totalLuas, 0, ',', '.')); ?> Ha</h3>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Sebaran Aset Berdasarkan Wilayah</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Provinsi</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Kabupaten/Kota</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Jumlah Aset</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Total Luas</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                        $wilayahData = \App\Models\AsetTanah::select('provinsi', 'kabupaten', \DB::raw('count(*) as total'), \DB::raw('sum(luas_hektar) as total_luas'))
                            ->groupBy('provinsi', 'kabupaten')
                            ->orderBy('total', 'desc')
                            ->get();
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $wilayahData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                <p class="text-[10px] font-semibold text-gray-800"><?php echo e($item->provinsi); ?></p>
                            </td>
                            <td class="px-5 py-4 text-[10px] text-gray-600"><?php echo e($item->kabupaten); ?></td>
                            <td class="px-5 py-4 text-[10px] font-semibold text-gray-800"><?php echo e(number_format($item->total)); ?></td>
                            <td class="px-5 py-4 text-[10px] text-gray-600"><?php echo e(number_format($item->total_luas, 2, ',', '.')); ?> Ha</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[8px] font-semibold bg-green-50 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Aktif
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada data wilayah.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[8px] text-gray-400">Menampilkan semua data wilayah</p>
            <a href="<?php echo e(route('admin.aset.index')); ?>" class="text-[9px] font-semibold text-[#006400] hover:underline">
                Kelola seluruh aset <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/aset_wilayah.blade.php ENDPATH**/ ?>