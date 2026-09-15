<?php $__env->startSection('title', 'Proyek Investasi'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $role = auth()->user()->role;
    $isAdmin = in_array($role, ['super_admin', 'admin']);
?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Proyek Investasi</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola data proyek investasi Badan Bank Tanah.</p>
    </div>
    <?php if($isAdmin): ?>
        <a href="<?php echo e(route('admin.proyek-investasi.create')); ?>" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i>
            Tambah Proyek
        </a>
    <?php endif; ?>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total Proyek</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($proyek->count()); ?></p>
                <p class="text-[10px] text-green-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>12% dari bulan lalu</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-chart-line text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Aktif</p>
                <p class="text-2xl font-bold text-green-600"><?php echo e($proyek->where('is_active', true)->count()); ?></p>
                <p class="text-[10px] text-green-600 mt-0.5"><i class="fas fa-check-circle text-[8px] mr-1"></i>Berjalan</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                <i class="fas fa-circle-check text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Dalam Proses</p>
                <p class="text-2xl font-bold text-orange-500"><?php echo e($proyek->where('status', 'Dalam Proses')->count()); ?></p>
                <p class="text-[10px] text-orange-500 mt-0.5"><i class="fas fa-clock text-[8px] mr-1"></i>Pengembangan</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center">
                <i class="fas fa-clock text-orange-500"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Selesai</p>
                <p class="text-2xl font-bold text-blue-600"><?php echo e($proyek->where('status', 'Selesai')->count()); ?></p>
                <p class="text-[10px] text-blue-600 mt-0.5"><i class="fas fa-check-double text-[8px] mr-1"></i>Komplit</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-check-double text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Daftar Proyek Investasi</h2>
            <p class="text-[10px] text-gray-400 mt-0.5">Kelola dan pantau proyek investasi Badan Bank Tanah.</p>
        </div>
        <div class="text-xs text-gray-400">
            <?php echo e($proyek->count()); ?> data
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Sektor</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Nilai</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $proyek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($loop->iteration); ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <?php if($item->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" class="w-10 h-10 rounded-lg object-cover" alt="<?php echo e($item->judul); ?>">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                            <span class="font-medium text-gray-900"><?php echo e($item->judul); ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($item->lokasi); ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            <?php echo e($item->sektor == 'Industri' ? 'bg-blue-50 text-blue-700' :
                               ($item->sektor == 'Pariwisata' ? 'bg-green-50 text-green-700' :
                               ($item->sektor == 'Pertanian' ? 'bg-yellow-50 text-yellow-700' :
                               'bg-purple-50 text-purple-700'))); ?>">
                            <?php echo e($item->sektor); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        <?php if($item->nilai_investasi): ?>
                            Rp <?php echo e(number_format($item->nilai_investasi, 0, ',', '.')); ?>

                        <?php else: ?>
                            <span class="text-gray-400 text-xs">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            <?php echo e($item->status == 'Aktif' ? 'bg-green-50 text-green-700' :
                               ($item->status == 'Dalam Proses' ? 'bg-orange-50 text-orange-700' :
                               ($item->status == 'Selesai' ? 'bg-blue-50 text-blue-700' :
                               'bg-gray-50 text-gray-500'))); ?>">
                            <?php echo e($item->status); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <?php if($isAdmin): ?>
                                <a href="<?php echo e(route('admin.proyek-investasi.edit', $item->id)); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-bold" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="<?php echo e(route('admin.proyek-investasi.destroy', $item->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <a href="<?php echo e(route('assets.show', $item->id)); ?>" target="_blank" class="text-gray-400 hover:text-blue-600 text-sm font-bold" title="Lihat di Frontend">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-chart-line text-3xl text-gray-300 block mb-3"></i>
                        <p class="text-sm">Belum ada proyek investasi.</p>
                        <?php if($isAdmin): ?>
                            <a href="<?php echo e(route('admin.proyek-investasi.create')); ?>" class="text-[#006400] hover:underline text-sm font-semibold">Tambah proyek</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-[10px] text-gray-400">Menampilkan <?php echo e($proyek->count()); ?> proyek</p>
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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u250369146/laravel-app/resources/views/admin/proyek_investasi_index.blade.php ENDPATH**/ ?>