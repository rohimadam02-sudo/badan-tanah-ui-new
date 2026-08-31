<?php
    $items = [
        ['route' => 'admin.aset.index', 'icon' => 'fa-database', 'label' => 'Data Aset'],
        ['route' => 'admin.aset.peta', 'icon' => 'fa-map-location-dot', 'label' => 'Peta Interaktif'],
        ['route' => 'admin.aset.profil', 'icon' => 'fa-layer-group', 'label' => 'Profil Persediaan Tanah'],
        ['route' => 'admin.aset.pengelolaan', 'icon' => 'fa-gear', 'label' => 'Pengelolaan Tanah'],
        ['route' => 'admin.aset.pengembangan', 'icon' => 'fa-chart-line', 'label' => 'Pengembangan Tanah'],
        ['route' => 'admin.aset.wilayah', 'icon' => 'fa-map', 'label' => 'Wilayah'],
        ['route' => 'admin.aset.status', 'icon' => 'fa-circle-check', 'label' => 'Status Tanah'],
        ['route' => 'admin.aset.dokumen', 'icon' => 'fa-file-lines', 'label' => 'Dokumen'],
        ['route' => 'admin.aset.statistik', 'icon' => 'fa-chart-pie', 'label' => 'Statistik'],
    ];
?>


<div style="display: flex !important; flex-wrap: wrap !important; align-items: center !important; gap: 6px !important; border-bottom: 1px solid #e5e7eb !important; padding-bottom: 12px !important; margin-bottom: 20px !important;">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $active = request()->routeIs($item['route']);
        ?>

        <a href="<?php echo e(route($item['route'])); ?>"
            style="display: flex !important; align-items: center !important; gap: 8px !important; padding: 8px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important; transition: all 0.2s !important; text-decoration: none !important; white-space: nowrap !important;
            <?php echo e($active
                ? 'background-color: #006400 !important; color: #ffffff !important; box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;'
                : 'color: #4b5563 !important; background-color: transparent !important;'); ?>">
            <i class="fas <?php echo e($item['icon']); ?>" style="font-size: 14px !important;"></i>
            <span><?php echo e($item['label']); ?></span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/aset/_navigation.blade.php ENDPATH**/ ?>