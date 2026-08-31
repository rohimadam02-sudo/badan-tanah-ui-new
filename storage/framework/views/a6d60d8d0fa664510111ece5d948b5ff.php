<?php $__env->startSection('title', $aset->nama_lokasi . ' - Badan Bank Tanah'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="max-w-3xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full
                         bg-white/10 text-blue-200 text-xs font-semibold
                         uppercase tracking-wider mb-5">
                <i class="fas fa-map-pin mr-2"></i>
                Detail Aset Persediaan Tanah
            </span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                <?php echo e($aset->nama_lokasi); ?>

            </h1>
            <div class="h-1 w-20 bg-blue-500 mt-5 mb-5 rounded-full"></div>
            <p class="text-blue-100 text-sm md:text-base leading-relaxed max-w-2xl">
                <?php echo e($aset->provinsi); ?>, <?php echo e($aset->kabupaten); ?>

            </p>
        </div>
    </div>
</section>


<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            
            <div class="lg:col-span-2 space-y-6">

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-80 bg-gray-200 relative">
                        <?php if($aset->gambar): ?>
                            <img src="<?php echo e(asset('storage/' . $aset->gambar)); ?>"
                                class="w-full h-full object-cover"
                                alt="<?php echo e($aset->nama_lokasi); ?>">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B2A4A] to-[#163F66]">
                                <div class="text-center text-white/50">
                                    <i class="fas fa-image text-6xl mb-3"></i>
                                    <p class="text-sm">Belum ada gambar</p>
                                </div>
                            </div>
                        <?php endif; ?>

                        
                        <span class="absolute top-4 left-4 text-white text-xs px-3 py-1.5 rounded-md font-bold uppercase
                            <?php echo e($aset->status == 'Tersedia' ? 'bg-[#006400]' :
                               ($aset->status == 'Dalam Pengembangan' ? 'bg-blue-600' :
                               'bg-orange-500')); ?>">
                            <?php echo e($aset->status); ?>

                        </span>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <i class="fas fa-circle-info text-green-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Informasi Aset</h2>
                            <p class="text-sm text-gray-500">Detail lengkap aset persediaan tanah</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Lokasi</p>
                            <p class="text-base font-bold text-gray-900 mt-1"><?php echo e($aset->nama_lokasi); ?></p>
                        </div>

                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</p>
                            <p class="text-base font-bold mt-1
                                <?php echo e($aset->status == 'Tersedia' ? 'text-[#006400]' :
                                   ($aset->status == 'Dalam Pengembangan' ? 'text-blue-600' :
                                   'text-orange-500')); ?>">
                                <?php echo e($aset->status); ?>

                            </p>
                        </div>

                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Provinsi</p>
                            <p class="text-base font-bold text-gray-900 mt-1"><?php echo e($aset->provinsi); ?></p>
                        </div>

                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kabupaten / Kota</p>
                            <p class="text-base font-bold text-gray-900 mt-1"><?php echo e($aset->kabupaten); ?></p>
                        </div>

                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Luas Tanah</p>
                            <p class="text-2xl font-extrabold text-[#006400] mt-1">
                                <?php echo e(number_format($aset->luas_hektar, 2, ',', '.')); ?> <span class="text-sm font-normal text-gray-500">Ha</span>
                            </p>
                        </div>

                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Peruntukan</p>
                            <p class="text-base font-bold text-gray-900 mt-1"><?php echo e($aset->peruntukan ?? '-'); ?></p>
                        </div>

                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Skema Pemanfaatan</p>
                            <p class="text-base font-bold text-gray-900 mt-1"><?php echo e($aset->skema ?? '-'); ?></p>
                        </div>

                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kode Aset</p>
                            <p class="text-base font-bold text-gray-900 mt-1">BT-2025-<?php echo e(sprintf('%04d', $aset->id)); ?></p>
                        </div>
                    </div>

                    
                    <?php if($aset->deskripsi): ?>
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Deskripsi</p>
                        <p class="text-sm text-gray-600 leading-relaxed"><?php echo e($aset->deskripsi); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

            </div>

            
            <div class="space-y-6">

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-location-dot text-[#006400]"></i>
                            <h3 class="font-bold text-sm text-gray-900">Lokasi Peta</h3>
                        </div>
                    </div>

                    <?php
                        $hasValidCoordinates = $aset->lat && $aset->lng &&
                                               is_numeric($aset->lat) && is_numeric($aset->lng) &&
                                               $aset->lat != 0 && $aset->lng != 0;
                    ?>

                    <?php if($hasValidCoordinates): ?>
                        <div id="assetMap" class="h-64 w-full bg-gray-100"></div>
                        <div class="p-3 text-center text-xs text-gray-400 border-t border-gray-100">
                            <i class="fas fa-info-circle mr-1"></i>
                            Klik marker untuk detail lokasi
                        </div>
                    <?php else: ?>
                        <div class="h-64 w-full bg-gray-100 flex items-center justify-center">
                            <div class="text-center text-gray-400">
                                <i class="fas fa-map-pin text-4xl mb-3 text-gray-300"></i>
                                <p class="text-sm font-medium text-gray-500">Koordinat Belum Diisi</p>
                                <p class="text-xs text-gray-400 mt-1">Lokasi aset akan ditampilkan di sini</p>
                            </div>
                        </div>
                        <div class="p-3 text-center text-xs text-gray-400 border-t border-gray-100">
                            <i class="fas fa-info-circle mr-1"></i>
                            Koordinat aset belum tersedia
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-file-lines text-[#006400]"></i>
                        <h3 class="font-bold text-sm text-gray-900">Dokumen Aset</h3>
                    </div>

                    <?php
                        // Ambil dokumen dari kolom dokumen_files (yang baru) atau dokumen (yang lama)
                        $dokumenList = $aset->dokumen_files ?? [];
                        $dokumenLama = $aset->dokumen ?? [];
                    ?>

                    <?php if(count($dokumenList) > 0 || count($dokumenLama) > 0): ?>
                        <div class="space-y-2">
                            
                            <?php $__currentLoopData = $dokumenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dokumen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition group">
                                    <div class="w-9 h-9 rounded-lg bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                                        <i class="fas <?php echo e(str_contains($dokumen['type'] ?? '', 'pdf') ? 'fa-file-pdf' : 
                                                        (str_contains($dokumen['type'] ?? '', 'word') || str_contains($dokumen['type'] ?? '', 'doc') ? 'fa-file-word' : 
                                                        (str_contains($dokumen['type'] ?? '', 'excel') || str_contains($dokumen['type'] ?? '', 'sheet') ? 'fa-file-excel' : 
                                                        (str_contains($dokumen['type'] ?? '', 'ppt') || str_contains($dokumen['type'] ?? '', 'powerpoint') ? 'fa-file-powerpoint' : 
                                                        'fa-file-lines')))); ?>"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-gray-800 truncate"><?php echo e($dokumen['nama'] ?? 'Dokumen'); ?></p>
                                        <p class="text-[10px] text-gray-400">
                                            <?php echo e($dokumen['size'] ?? ''); ?>

                                            <?php if($dokumen['file'] ?? false): ?>
                                                <span class="ml-2 text-green-600">✓ Terupload</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <?php if($dokumen['file'] ?? false): ?>
                                        <a href="<?php echo e(asset('storage/' . $dokumen['file'])); ?>" 
                                           target="_blank"
                                           class="text-xs font-semibold text-blue-600 hover:underline flex-shrink-0 group-hover:translate-x-0.5 transition">
                                            <i class="fas fa-download mr-1"></i>
                                            Unduh
                                        </a>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400 flex-shrink-0">Belum ada file</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            
                            <?php $__currentLoopData = $dokumenLama; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($nama)): ?>
                                    <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                        <div class="w-9 h-9 rounded-lg bg-gray-50 text-gray-500 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-file-lines"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-gray-800 truncate"><?php echo e($nama); ?></p>
                                            <p class="text-[10px] text-gray-400">Dokumen pendukung</p>
                                        </div>
                                        <span class="text-xs text-gray-400 flex-shrink-0">Belum ada file</span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">Belum ada dokumen untuk aset ini.</p>
                    <?php endif; ?>
                </div>

                
                <a href="<?php echo e(route('assets')); ?>"
                    class="w-full inline-flex items-center justify-center gap-2 bg-[#0B2A4A] hover:bg-[#12395f] text-white rounded-xl px-5 py-3 text-sm font-bold transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar Aset
                </a>

            </div>

        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if($hasValidCoordinates): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapElement = document.getElementById('assetMap');

        if (mapElement) {
            var lat = <?php echo e($aset->lat); ?>;
            var lng = <?php echo e($aset->lng); ?>;

            var map = L.map('assetMap').setView([lat, lng], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([lat, lng]).addTo(map)
                .bindPopup(`
                    <div style="min-width:180px">
                        <strong><?php echo e($aset->nama_lokasi); ?></strong>
                        <br>
                        <span><?php echo e($aset->provinsi); ?>, <?php echo e($aset->kabupaten); ?></span>
                        <br>
                        <span class="text-[#006400] font-bold"><?php echo e(number_format($aset->luas_hektar, 2, ',', '.')); ?> Ha</span>
                    </div>
                `);

            setTimeout(function() {
                map.setView([lat, lng], 14);
            }, 300);
        }
    });
</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/frontend/aset_detail.blade.php ENDPATH**/ ?>