<?php $__env->startSection('title', 'Aktivitas Sistem'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-7xl mx-auto">

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Aktivitas Sistem</h1>
            <p class="text-sm text-gray-500 mt-1">Riwayat aktivitas pengelolaan sistem Badan Bank Tanah.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-400">
                Total: <?php echo e($activities->total()); ?> aktivitas
            </span>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-sm text-gray-600 hover:text-[#006400] transition">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <form action="<?php echo e(route('admin.activity-log.filter')); ?>" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-[10px] font-semibold text-gray-500 mb-1">Event</label>
                <select name="event" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Event</option>
                    <option value="created" <?php echo e(request('event') == 'created' ? 'selected' : ''); ?>>Dibuat</option>
                    <option value="updated" <?php echo e(request('event') == 'updated' ? 'selected' : ''); ?>>Diubah</option>
                    <option value="deleted" <?php echo e(request('event') == 'deleted' ? 'selected' : ''); ?>>Dihapus</option>
                    <option value="published" <?php echo e(request('event') == 'published' ? 'selected' : ''); ?>>Dipublikasi</option>
                    <option value="approved" <?php echo e(request('event') == 'approved' ? 'selected' : ''); ?>>Disetujui</option>
                    <option value="submitted" <?php echo e(request('event') == 'submitted' ? 'selected' : ''); ?>>Disubmit</option>
                    <option value="unpublished" <?php echo e(request('event') == 'unpublished' ? 'selected' : ''); ?>>Diarsipkan</option>
                </select>
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="block text-[10px] font-semibold text-gray-500 mb-1">Modul</label>
                <select name="log_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Modul</option>
                    <option value="default" <?php echo e(request('log_name') == 'default' ? 'selected' : ''); ?>>Default</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    <i class="fas fa-filter mr-1"></i>
                    Filter
                </button>
                <a href="<?php echo e(route('admin.activity-log')); ?>" class="border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition">
                    <i class="fas fa-rotate-right mr-1"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-900">Riwayat Aktivitas</h2>
        </div>

        <div class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $icon = 'fa-pen';
                    $color = 'blue';
                    $bg = 'blue-50';
                    
                    if ($activity->event == 'created') {
                        $icon = 'fa-plus';
                        $color = 'green';
                        $bg = 'green-50';
                    } elseif ($activity->event == 'updated') {
                        $icon = 'fa-pen';
                        $color = 'blue';
                        $bg = 'blue-50';
                    } elseif ($activity->event == 'deleted') {
                        $icon = 'fa-trash';
                        $color = 'red';
                        $bg = 'red-50';
                    } elseif ($activity->event == 'published') {
                        $icon = 'fa-check-circle';
                        $color = 'green';
                        $bg = 'green-50';
                    } elseif ($activity->event == 'approved') {
                        $icon = 'fa-check';
                        $color = 'blue';
                        $bg = 'blue-50';
                    } elseif ($activity->event == 'submitted') {
                        $icon = 'fa-paper-plane';
                        $color = 'orange';
                        $bg = 'orange-50';
                    } elseif ($activity->event == 'unpublished') {
                        $icon = 'fa-archive';
                        $color = 'gray';
                        $bg = 'gray-50';
                    }
                    
                    $subjectType = class_basename($activity->subject_type ?? '');
                    $causerName = $activity->causer?->name ?? 'Sistem';
                ?>
                <div class="flex items-start gap-4 px-5 py-4 hover:bg-gray-50 transition">
                    <div class="w-10 h-10 rounded-xl <?php echo e($bg); ?> flex items-center justify-center flex-shrink-0">
                        <i class="fas <?php echo e($icon); ?> text-<?php echo e($color); ?>-600 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <p class="text-sm font-medium text-gray-800"><?php echo e(ucfirst($activity->description)); ?></p>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">
                                <?php echo e($subjectType); ?>

                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-500">
                            <span>
                                <i class="fas fa-user mr-1"></i>
                                <?php echo e($causerName); ?>

                            </span>
                            <span>
                                <i class="fas fa-calendar-alt mr-1"></i>
                                <?php echo e($activity->created_at->format('d M Y H:i')); ?>

                            </span>
                            <span>
                                <i class="fas fa-clock mr-1"></i>
                                <?php echo e($activity->created_at->diffForHumans()); ?>

                            </span>
                        </div>
                    </div>
                    <span class="text-[10px] font-semibold uppercase tracking-wider
                        <?php echo e($activity->event == 'created' ? 'text-green-600' :
                           ($activity->event == 'deleted' ? 'text-red-600' :
                           ($activity->event == 'published' ? 'text-green-600' :
                           ($activity->event == 'approved' ? 'text-blue-600' :
                           ($activity->event == 'submitted' ? 'text-orange-600' :
                           'text-gray-400'))))); ?>">
                        <?php echo e($activity->event ?? 'action'); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-5 py-12 text-center text-gray-500">
                    <i class="fas fa-inbox text-3xl text-gray-300 block mb-3"></i>
                    <p class="text-sm">Belum ada aktivitas sistem.</p>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="px-5 py-4 border-t border-gray-100">
            <?php echo e($activities->links()); ?>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/activity_log.blade.php ENDPATH**/ ?>