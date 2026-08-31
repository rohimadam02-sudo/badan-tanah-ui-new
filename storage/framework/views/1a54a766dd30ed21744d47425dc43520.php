<?php $__env->startSection('title', 'Profil Persediaan Tanah'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-7xl mx-auto">

    
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Profil Persediaan Tanah</h1>
            <p class="text-[10px] text-gray-500 mt-1">Ringkasan profil persediaan tanah Badan Bank Tanah.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="window.print()" class="px-3 py-1.5 text-[9px] font-semibold bg-[#006400] text-white rounded-md hover:bg-[#005500] transition">
                <i class="fas fa-print mr-1"></i> Cetak
            </button>
        </div>
    </div>

    
    <div class="overflow-x-auto">
        <?php echo $__env->make('admin.aset._navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <?php
        $totalAset = \App\Models\AsetTanah::count();
        $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
        $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
        $totalKabupaten = \App\Models\AsetTanah::distinct('kabupaten')->count('kabupaten');
        $totalTersedia = \App\Models\AsetTanah::where('status', 'Tersedia')->count();
        $totalPengembangan = \App\Models\AsetTanah::where('status', 'Dalam Pengembangan')->count();
        $totalProses = \App\Models\AsetTanah::where('status', 'Dalam Proses')->count();
        $totalTerikat = \App\Models\AsetTanah::where('status', 'Terikat')->count();
    ?>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-5">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-[8px] text-gray-500">Total Aset</p>
            <p class="text-xl font-bold text-gray-900"><?php echo e(number_format($totalAset)); ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-[8px] text-gray-500">Total Luas</p>
            <p class="text-xl font-bold text-green-600"><?php echo e(number_format($totalLuas, 2, ',', '.')); ?> Ha</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-[8px] text-gray-500">Provinsi</p>
            <p class="text-xl font-bold text-blue-600"><?php echo e(number_format($totalProvinsi)); ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-[8px] text-gray-500">Kabupaten/Kota</p>
            <p class="text-xl font-bold text-purple-600"><?php echo e(number_format($totalKabupaten)); ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-[8px] text-gray-500">Nilai Indikatif</p>
            <p class="text-xl font-bold text-teal-600">Rp 68,45 T</p>
        </div>
    </div>

    
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
            <p class="text-[8px] text-green-600">Tersedia</p>
            <p class="text-xl font-bold text-green-700"><?php echo e(number_format($totalTersedia)); ?></p>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
            <p class="text-[8px] text-blue-600">Dalam Pengembangan</p>
            <p class="text-xl font-bold text-blue-700"><?php echo e(number_format($totalPengembangan)); ?></p>
        </div>
        <div class="bg-orange-50 border border-orange-100 rounded-xl p-4">
            <p class="text-[8px] text-orange-600">Dalam Proses</p>
            <p class="text-xl font-bold text-orange-700"><?php echo e(number_format($totalProses)); ?></p>
        </div>
        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
            <p class="text-[8px] text-gray-600">Terikat</p>
            <p class="text-xl font-bold text-gray-700"><?php echo e(number_format($totalTerikat)); ?></p>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Sebaran Aset Per Provinsi</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Provinsi</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Jumlah Aset</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Total Luas (Ha)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                        $provinsiData = \App\Models\AsetTanah::select('provinsi', \DB::raw('count(*) as total'), \DB::raw('sum(luas_hektar) as total_luas'))
                            ->groupBy('provinsi')
                            ->orderBy('total', 'desc')
                            ->get();
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $provinsiData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-800"><?php echo e($item->provinsi); ?></td>
                            <td class="px-5 py-3"><?php echo e(number_format($item->total)); ?></td>
                            <td class="px-5 py-3"><?php echo e(number_format($item->total_luas, 2, ',', '.')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-gray-400">Belum ada data.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/aset_profil.blade.php ENDPATH**/ ?>