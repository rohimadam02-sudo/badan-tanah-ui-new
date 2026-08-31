<?php $__env->startSection('title', 'Status Tanah'); ?>

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
                <i class="fas fa-circle-info text-xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-bold text-gray-900">Status Tanah</h2>
                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Informasi status aset persediaan tanah.</p>
            </div>
        </div>
    </div>

    
    <?php
        $totalTersedia = \App\Models\AsetTanah::where('status', 'Tersedia')->count();
        $totalPengembangan = \App\Models\AsetTanah::where('status', 'Dalam Pengembangan')->count();
        $totalProses = \App\Models\AsetTanah::where('status', 'Dalam Proses')->count();
        $totalTerikat = \App\Models\AsetTanah::where('status', 'Terikat')->count();
        $totalAset = \App\Models\AsetTanah::count();
    ?>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        <div class="bg-green-50 border border-green-100 rounded-xl p-5">
            <p class="text-[10px] text-green-600 font-semibold">Tersedia</p>
            <p class="text-2xl font-bold text-green-700"><?php echo e(number_format($totalTersedia)); ?></p>
            <p class="text-[8px] text-green-500 mt-1"><?php echo e($totalAset > 0 ? round(($totalTersedia / $totalAset) * 100) : 0); ?>% dari total</p>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
            <p class="text-[10px] text-blue-600 font-semibold">Dalam Pengembangan</p>
            <p class="text-2xl font-bold text-blue-700"><?php echo e(number_format($totalPengembangan)); ?></p>
            <p class="text-[8px] text-blue-500 mt-1"><?php echo e($totalAset > 0 ? round(($totalPengembangan / $totalAset) * 100) : 0); ?>% dari total</p>
        </div>
        <div class="bg-orange-50 border border-orange-100 rounded-xl p-5">
            <p class="text-[10px] text-orange-600 font-semibold">Dalam Proses</p>
            <p class="text-2xl font-bold text-orange-700"><?php echo e(number_format($totalProses)); ?></p>
            <p class="text-[8px] text-orange-500 mt-1"><?php echo e($totalAset > 0 ? round(($totalProses / $totalAset) * 100) : 0); ?>% dari total</p>
        </div>
        <div class="bg-gray-50 border border-gray-100 rounded-xl p-5">
            <p class="text-[10px] text-gray-600 font-semibold">Terikat</p>
            <p class="text-2xl font-bold text-gray-700"><?php echo e(number_format($totalTerikat)); ?></p>
            <p class="text-[8px] text-gray-500 mt-1"><?php echo e($totalAset > 0 ? round(($totalTerikat / $totalAset) * 100) : 0); ?>% dari total</p>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Daftar Status Aset</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Lokasi Aset</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Luas</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Peruntukan</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Skema</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                        $asets = \App\Models\AsetTanah::latest()->get();
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                <p class="text-[10px] font-semibold text-gray-800"><?php echo e($aset->nama_lokasi); ?></p>
                                <p class="text-[9px] text-gray-400 mt-1"><?php echo e($aset->provinsi); ?></p>
                            </td>
                            <td class="px-5 py-4 text-[10px] text-gray-600"><?php echo e(number_format($aset->luas_hektar, 2, ',', '.')); ?> Ha</td>
                            <td class="px-5 py-4 text-[10px] text-gray-600"><?php echo e($aset->peruntukan ?? '-'); ?></td>
                            <td class="px-5 py-4 text-[10px] text-gray-600"><?php echo e($aset->skema ?? '-'); ?></td>
                            <td class="px-5 py-4">
                                <?php
                                    $statusColors = [
                                        'Tersedia' => 'bg-green-50 text-green-700',
                                        'Dalam Pengembangan' => 'bg-blue-50 text-blue-700',
                                        'Dalam Proses' => 'bg-orange-50 text-orange-700',
                                        'Terikat' => 'bg-gray-50 text-gray-700'
                                    ];
                                ?>
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[8px] font-semibold <?php echo e($statusColors[$aset->status] ?? 'bg-gray-50 text-gray-500'); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    <?php echo e($aset->status); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada data aset.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[8px] text-gray-400">Menampilkan semua aset</p>
            <a href="<?php echo e(route('admin.aset.index')); ?>" class="text-[9px] font-semibold text-[#006400] hover:underline">
                Kelola seluruh aset <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/aset_status.blade.php ENDPATH**/ ?>