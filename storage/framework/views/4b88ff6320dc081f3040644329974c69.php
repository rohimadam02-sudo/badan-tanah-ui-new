<?php $__env->startSection('title', 'Menu Navigasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Menu Navigasi</h1>
        <p class="text-sm text-gray-500 mt-1">Atur menu navigasi yang tampil di website.</p>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <form action="<?php echo e(route('admin.menu_navigasi.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center gap-4 border border-gray-200 rounded-lg p-4">
                <i class="fas fa-grip-vertical text-gray-400"></i>
                <div>
                    <p class="font-bold text-sm"><?php echo e($item->nama); ?></p>
                    <p class="text-xs text-gray-500"><?php echo e($item->link); ?></p>
                </div>
                <div class="ml-auto flex items-center gap-2">
                    <span class="text-xs text-gray-400">Status:</span>
                    <select name="menu[<?php echo e($item->id); ?>][status]" class="border border-gray-300 rounded p-2 text-sm">
                        <option value="Aktif" <?php echo e($item->status == 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                        <option value="Tidak Aktif" <?php echo e($item->status == 'Tidak Aktif' ? 'selected' : ''); ?>>Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-bold text-sm">Simpan Menu</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u250369146/laravel-app/resources/views/admin/menu_navigasi.blade.php ENDPATH**/ ?>