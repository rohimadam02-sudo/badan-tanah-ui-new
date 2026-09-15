<?php $__env->startSection('title', 'Dokumen Kerjasama'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $role = auth()->user()->role;
    $isAdmin = in_array($role, ['super_admin', 'admin']);
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dokumen Kerjasama</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola dokumen booklet dan informasi kerjasama.</p>
    </div>
    <?php if($isAdmin): ?>
        <a href="<?php echo e(route('admin.dokumen-kerjasama.create')); ?>" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i>
            Upload Dokumen
        </a>
    <?php endif; ?>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total Dokumen</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($dokumen->count()); ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-file-pdf text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Booklet</p>
                <p class="text-2xl font-bold text-blue-600"><?php echo e($dokumen->where('kategori', 'booklet')->count()); ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-book text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Aktif</p>
                <p class="text-2xl font-bold text-green-600"><?php echo e($dokumen->where('is_active', true)->count()); ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                <i class="fas fa-circle-check text-green-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Daftar Dokumen</h2>
            <p class="text-[10px] text-gray-400 mt-0.5">Kelola dokumen booklet dan informasi kerjasama.</p>
        </div>
        <div class="text-xs text-gray-400">
            <?php echo e($dokumen->count()); ?> dokumen
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Ukuran</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $dokumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($loop->iteration); ?></td>
                    <td class="px-6 py-4 font-medium text-gray-900"><?php echo e($item->judul); ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            <?php echo e($item->kategori == 'booklet' ? 'bg-blue-50 text-blue-700' :
                               ($item->kategori == 'panduan' ? 'bg-green-50 text-green-700' :
                               ($item->kategori == 'brosur' ? 'bg-purple-50 text-purple-700' :
                               'bg-gray-50 text-gray-500'))); ?>">
                            <?php echo e(ucfirst($item->kategori)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($item->ukuran ?? '-'); ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            <?php echo e($item->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-500'); ?>">
                            <?php echo e($item->is_active ? 'Aktif' : 'Tidak Aktif'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('admin.dokumen-kerjasama.download', $item->id)); ?>" 
                               class="text-green-600 hover:text-green-800 text-sm font-bold" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                            <?php if($isAdmin): ?>
                                <a href="<?php echo e(route('admin.dokumen-kerjasama.edit', $item->id)); ?>" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-bold" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="<?php echo e(route('admin.dokumen-kerjasama.destroy', $item->id)); ?>" method="POST" 
                                      class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-file-pdf text-3xl text-gray-300 block mb-3"></i>
                        <p class="text-sm">Belum ada dokumen.</p>
                        <?php if($isAdmin): ?>
                            <a href="<?php echo e(route('admin.dokumen-kerjasama.create')); ?>" class="text-[#006400] hover:underline text-sm font-semibold">Upload dokumen</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-[10px] text-gray-400">Menampilkan <?php echo e($dokumen->count()); ?> dokumen</p>
        <div class="flex items-center gap-2">
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition disabled:opacity-50" disabled>
                <i class="fas fa-chevron-left text-xs"></i>
            </button>
            <span class="text-xs font-medium text-gray-700">1</span>
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition disabled:opacity-50" disabled>
                <i class="fas fa-chevron-right text-xs"></i>
            </button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u250369146/laravel-app/resources/views/admin/dokumen_kerjasama_index.blade.php ENDPATH**/ ?>