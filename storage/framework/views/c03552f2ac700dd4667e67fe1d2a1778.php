<?php $__env->startSection('title', 'Dokumen'); ?>

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
                <i class="fas fa-folder-open text-xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-bold text-gray-900">Dokumen</h2>
                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Kelola dokumen pendukung aset persediaan tanah.</p>
            </div>
        </div>
    </div>

    
    <?php
        $totalDokumen = \App\Models\AsetTanah::whereNotNull('dokumen')->where('dokumen', '!=', '[]')->count();
        $totalAset = \App\Models\AsetTanah::count();
        $totalTersedia = \App\Models\AsetTanah::where('status', 'Tersedia')->count();
    ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Total Dokumen</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2"><?php echo e(number_format($totalDokumen)); ?></h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-green-50 text-[#006400] flex items-center justify-center">
                    <i class="fas fa-folder"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Total Aset</p>
                    <h3 class="text-2xl font-bold text-blue-600 mt-2"><?php echo e(number_format($totalAset)); ?></h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="fas fa-database"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Aset Tersedia</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-2"><?php echo e(number_format($totalTersedia)); ?></h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                    <i class="fas fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-gray-900">Daftar Dokumen Aset</h2>
            </div>
            <a href="<?php echo e(route('admin.aset.index')); ?>" class="px-3 py-1.5 bg-[#006400] hover:bg-[#005500] text-white rounded-md text-[9px] font-semibold transition">
                <i class="fas fa-database mr-1"></i> Lihat Data Aset
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Dokumen</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Lokasi Aset</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Status</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                        $asets = \App\Models\AsetTanah::whereNotNull('dokumen')->where('dokumen', '!=', '[]')->get();
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $__currentLoopData = $aset->dokumen ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-red-50 text-red-500 flex items-center justify-center">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-semibold text-gray-800"><?php echo e($dokumen); ?></p>
                                            <p class="text-[8px] text-gray-400">PDF</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-[10px] text-gray-600"><?php echo e($aset->nama_lokasi); ?></p>
                                    <p class="text-[8px] text-gray-400 mt-1"><?php echo e($aset->provinsi); ?></p>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[8px] font-semibold bg-green-50 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Tersedia
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <button class="text-[9px] font-semibold text-[#006400] hover:underline">
                                        <i class="fas fa-eye mr-1"></i> Lihat
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400">Belum ada dokumen yang diupload.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[8px] text-gray-400">Menampilkan aset yang memiliki dokumen</p>
            <a href="<?php echo e(route('admin.aset.index')); ?>" class="text-[9px] font-semibold text-[#006400] hover:underline">
                Kelola seluruh aset <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/aset_dokumen.blade.php ENDPATH**/ ?>