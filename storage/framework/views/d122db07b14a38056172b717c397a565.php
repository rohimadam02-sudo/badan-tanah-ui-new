<?php $__env->startSection('title', 'Kelola Halaman'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $role = auth()->user()->role;
    $isAdmin = in_array($role, ['super_admin', 'admin']);
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Halaman</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua halaman website Badan Bank Tanah.</p>
    </div>
    <?php if($isAdmin): ?>
        <a href="<?php echo e(route('admin.halaman.create')); ?>" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i>
            Tambah Halaman
        </a>
    <?php endif; ?>
</div>


<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total Halaman</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($halamans->count()); ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-file-lines text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Aktif</p>
                <p class="text-2xl font-bold text-green-600"><?php echo e($halamans->where('is_active', true)->count()); ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                <i class="fas fa-circle-check text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Tidak Aktif</p>
                <p class="text-2xl font-bold text-gray-400"><?php echo e($halamans->where('is_active', false)->count()); ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-gray-50 flex items-center justify-center">
                <i class="fas fa-circle-xmark text-gray-400"></i>
            </div>
        </div>
    </div>
</div>


<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Daftar Halaman</h2>
            <p class="text-[10px] text-gray-400 mt-0.5">Kelola semua halaman website.</p>
        </div>
        <div class="text-xs text-gray-400">
            <?php echo e($halamans->count()); ?> halaman
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $halamans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($loop->iteration); ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <?php if($item->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" class="w-10 h-10 rounded-lg object-cover" alt="<?php echo e($item->judul); ?>">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-file-lines text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                            <span class="font-medium text-gray-900"><?php echo e($item->judul); ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            <?php echo e($item->type_label == 'Halaman Tentang' ? 'bg-blue-50 text-blue-700' :
                               ($item->type_label == 'Halaman Pemanfaatan' ? 'bg-green-50 text-green-700' :
                               'bg-gray-50 text-gray-500')); ?>">
                            <?php echo e($item->type_label); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            <?php echo e($item->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-500'); ?>">
                            <?php echo e($item->is_active ? 'Aktif' : 'Tidak Aktif'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            
                            <button type="button"
                                onclick="toggleStatus(<?php echo e($item->id); ?>, <?php echo e($item->is_active ? 'true' : 'false'); ?>)"
                                class="text-sm font-bold <?php echo e($item->is_active ? 'text-green-600 hover:text-green-800' : 'text-gray-400 hover:text-gray-600'); ?>"
                                title="<?php echo e($item->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                <i class="fas <?php echo e($item->is_active ? 'fa-toggle-on' : 'fa-toggle-off'); ?> text-lg"></i>
                            </button>

                            
                            <?php if($isAdmin): ?>
                                <a href="<?php echo e(route('admin.halaman.edit', $item->id)); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-bold" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                            <?php endif; ?>

                            
                            <a href="<?php echo e(route('about')); ?>" target="_blank" class="text-gray-400 hover:text-blue-600 text-sm font-bold" title="Lihat di Frontend">
                                <i class="fas fa-external-link-alt"></i>
                            </a>

                            
                            <?php if($isAdmin && $item->id > 2): ?>
                                <form action="<?php echo e(route('admin.halaman.destroy', $item->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
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
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-file-lines text-3xl text-gray-300 block mb-3"></i>
                        <p class="text-sm">Belum ada halaman.</p>
                        <?php if($isAdmin): ?>
                            <a href="<?php echo e(route('admin.halaman.create')); ?>" class="text-[#006400] hover:underline text-sm font-semibold">Tambah halaman</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    function toggleStatus(id, currentStatus) {
        const newStatus = !currentStatus;
        const statusText = newStatus ? 'aktif' : 'nonaktif';
        const confirmMessage = `Apakah Anda yakin ingin mengubah status halaman ini menjadi ${statusText}?`;

        if (!confirm(confirmMessage)) {
            return;
        }

        fetch(`/admin/halaman/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status halaman.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status halaman.');
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u250369146/laravel-app/resources/views/admin/halaman_index.blade.php ENDPATH**/ ?>