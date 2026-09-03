<?php $__env->startSection('title', 'Website'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-full">
    <!-- Header Halaman -->
    <div class="flex items-start gap-4 mb-6">
        <div class="w-14 h-14 bg-green-100 text-[#006400] rounded-full flex items-center justify-center">
            <i class="fas fa-globe text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Website</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola seluruh konten statis dan struktur website.</p>
        </div>
    </div>

    <!-- Tab Navigasi -->
    <div class="flex items-center gap-6 border-b border-gray-200 mb-8">
        <a href="<?php echo e(route('admin.website')); ?>" class="pb-4 border-b-2 border-[#006400] text-[#006400] font-medium text-sm">Homepage</a>
        <a href="<?php echo e(route('admin.halaman.edit.tentang')); ?>" class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Tentang</a>
        <a href="<?php echo e(route('admin.halaman.index')); ?>" class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Halaman</a>
        <a href="<?php echo e(route('admin.menu_navigasi')); ?>" class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Menu Navigasi</a>
        <a href="<?php echo e(route('admin.footer.index')); ?>" class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Footer</a>
        <a href="<?php echo e(route('admin.faq.index')); ?>" class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">FAQ</a>
        <a href="<?php echo e(route('admin.karier.index')); ?>" class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Karier</a>
        <a href="<?php echo e(route('admin.kontak.index')); ?>" class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Kontak Kami</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- KOLOM KIRI: Form Hero Banner -->
        <div>
            <form action="<?php echo e(route('admin.website.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-bold text-lg mb-4">Hero Banner</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Judul Utama</label>
                            <input type="text" name="judul_hero" value="<?php echo e($pengaturan->judul_hero ?? 'Mengelola Tanah, Memajukan Negeri'); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold mb-1">Subjudul</label>
                            <textarea name="subjudul_hero" rows="3" class="w-full border-gray-300 rounded-lg p-3 text-sm"><?php echo e($pengaturan->subjudul_hero ?? 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.'); ?></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Tombol Text</label>
                                <input type="text" name="tombol_text" value="<?php echo e($pengaturan->tombol_text ?? 'Selengkapnya'); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Tombol Link</label>
                                <input type="text" name="tombol_link" value="<?php echo e($pengaturan->tombol_link ?? '/aset'); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Warna Utama</label>
                                <input type="color" name="warna_utama" value="<?php echo e($pengaturan->warna_utama ?? '#0B2A4A'); ?>" class="w-full h-12 border border-gray-300 rounded-lg cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Warna Sekunder</label>
                                <input type="color" name="warna_sekunder" value="<?php echo e($pengaturan->warna_sekunder ?? '#1D4ED8'); ?>" class="w-full h-12 border border-gray-300 rounded-lg cursor-pointer">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded font-bold text-sm">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- KOLOM KANAN: Preview -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="font-bold text-sm text-gray-700">Pratinjau Hero Banner</h3>
                </div>
                
                <!-- Preview UI -->
                <div class="relative h-[400px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2000&auto=format&fit=crop');">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0B2A4A]/90 via-[#0B2A4A]/50 to-transparent"></div>
                    <div class="relative h-full flex flex-col justify-center px-10">
                        <h2 class="text-4xl font-bold text-white mb-2"><?php echo e($pengaturan->judul_hero ?? 'Mengelola Tanah, Memajukan Negeri'); ?></h2>
                        <p class="text-white/90 text-sm max-w-md mb-6"><?php echo e($pengaturan->subjudul_hero ?? 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.'); ?></p>
                        <a href="<?php echo e($pengaturan->tombol_link ?? '/aset'); ?>" class="text-white px-6 py-2 rounded font-bold text-sm" style="background-color: <?php echo e($pengaturan->warna_sekunder ?? '#1D4ED8'); ?>;"><?php echo e($pengaturan->tombol_text ?? 'Selengkapnya'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u250369146/laravel-app/resources/views/admin/website.blade.php ENDPATH**/ ?>