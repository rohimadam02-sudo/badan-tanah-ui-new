<?php $__env->startSection('title', 'Footer'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $footer = \App\Models\FooterSetting::getSettings();
?>

<div class="max-w-5xl mx-auto">

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-[#0B2A4A] flex items-center justify-center shadow-sm">
                    <i class="fas fa-shoe-prints text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Footer</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola informasi footer website.</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-400">
            <i class="fas fa-info-circle"></i>
            <span>Terakhir diperbarui: <?php echo e($footer->updated_at ? $footer->updated_at->format('d M Y H:i') : 'Belum pernah'); ?></span>
        </div>
    </div>

    
    <?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div>
                    <p class="font-bold text-green-800 text-sm">Berhasil!</p>
                    <p class="text-sm text-green-700"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div>
                    <p class="font-bold text-red-800 text-sm">Terjadi kesalahan:</p>
                    <ul class="list-disc ml-4 text-sm text-red-700 mt-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <form action="<?php echo e(route('admin.footer.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            
            <div class="lg:col-span-2 space-y-6">

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-circle-info text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg text-gray-900">Informasi Dasar</h2>
                            <p class="text-xs text-gray-500">Informasi utama yang ditampilkan di footer.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Website</label>
                            <input type="text" name="nama_website" 
                                   value="<?php echo e(old('nama_website', $footer->nama_website)); ?>"
                                   placeholder="Masukkan nama website"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                            <p class="text-xs text-gray-400 mt-1.5">Akan ditampilkan di footer sebagai nama institusi.</p>
                        </div>

                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                placeholder="Masukkan deskripsi singkat"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"><?php echo e(old('deskripsi', $footer->deskripsi)); ?></textarea>
                            <p class="text-xs text-gray-400 mt-1.5">Deskripsi singkat tentang Badan Bank Tanah.</p>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                            <i class="fas fa-address-book text-green-600"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg text-gray-900">Kontak</h2>
                            <p class="text-xs text-gray-500">Informasi kontak yang ditampilkan di footer.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                            <input type="text" name="alamat" 
                                   value="<?php echo e(old('alamat', $footer->alamat)); ?>"
                                   placeholder="Jl. H. Juanda No. 15, Jakarta Pusat"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        </div>

                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                                <input type="email" name="email" 
                                       value="<?php echo e(old('email', $footer->email)); ?>"
                                       placeholder="info@bantah.go.id"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Telepon</label>
                                <input type="text" name="telepon" 
                                       value="<?php echo e(old('telepon', $footer->telepon)); ?>"
                                       placeholder="(021) 3456-7890"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                            <i class="fas fa-link text-purple-600"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg text-gray-900">Tautan Cepat</h2>
                            <p class="text-xs text-gray-500">Daftar tautan yang ditampilkan di footer.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">Kelola tautan cepat footer</span>
                        <button type="button" onclick="addQuickLink()" 
                                class="text-sm font-semibold text-[#006400] hover:underline transition">
                            <i class="fas fa-plus mr-1"></i> Tambah Tautan
                        </button>
                    </div>

                    <div id="quickLinksContainer" class="space-y-3">
                        <?php
                            $quickLinks = old('quick_links', $footer->quick_links ?? []);
                            if (empty($quickLinks)) {
                                $quickLinks = [
                                    ['label' => 'Tentang Kami', 'url' => '/tentang'],
                                    ['label' => 'Aset Persediaan', 'url' => '/aset'],
                                    ['label' => 'Pemanfaatan & Kerjasama', 'url' => '/pemanfaatan'],
                                    ['label' => 'Publikasi', 'url' => '/publikasi'],
                                ];
                            }
                        ?>

                        <?php $__currentLoopData = $quickLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="quick-link-item flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-gray-200 transition">
                                <i class="fas fa-grip-vertical text-gray-400 cursor-move"></i>
                                <input type="text" name="quick_links[<?php echo e($index); ?>][label]" 
                                    value="<?php echo e($link['label'] ?? ''); ?>"
                                    placeholder="Label tautan"
                                    class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition bg-white">
                                <input type="text" name="quick_links[<?php echo e($index); ?>][url]" 
                                    value="<?php echo e($link['url'] ?? ''); ?>"
                                    placeholder="/url-tautan"
                                    class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition bg-white">
                                <button type="button" onclick="removeQuickLink(this)" 
                                        class="text-red-500 hover:text-red-700 transition p-1.5">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <p class="text-xs text-gray-400 mt-3">
                        <i class="fas fa-arrows-alt mr-1"></i> 
                        Seret icon <i class="fas fa-grip-vertical"></i> untuk mengatur ulang urutan tautan.
                    </p>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                            <i class="fas fa-paragraph text-amber-600"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg text-gray-900">Teks Footer</h2>
                            <p class="text-xs text-gray-500">Teks copyright yang ditampilkan di footer.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Teks Footer</label>
                        <textarea name="footer_text" rows="3"
                            placeholder="&copy; {year} Badan Bank Tanah. Hak Cipta Dilindungi."
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"><?php echo e(old('footer_text', $footer->footer_text)); ?></textarea>
                        <p class="text-xs text-gray-400 mt-1.5">
                            <i class="fas fa-info-circle mr-1"></i> 
                            Gunakan <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[#006400]">{year}</code> untuk menampilkan tahun otomatis.
                        </p>
                    </div>
                </div>

            </div>

            
            <div class="space-y-6">

                
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-share-alt text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Kelola Sosial Media</p>
                            <p class="text-xs text-blue-700 mt-1 leading-relaxed">
                                Sosial media sekarang dikelola di halaman terpisah.
                            </p>
                            <a href="<?php echo e(route('admin.social-media.index')); ?>" 
                               class="inline-flex items-center gap-1.5 mt-3 text-sm font-semibold text-blue-700 hover:text-blue-900 transition">
                                Buka Kelola Sosial Media
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                            <i class="fas fa-toggle-on text-green-600"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg text-gray-900">Tampilkan</h2>
                            <p class="text-xs text-gray-500">Atur tampilan elemen footer.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Sosial Media</p>
                                <p class="text-xs text-gray-400">Tampilkan sosial media di footer</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_social_media" value="1"
                                    <?php echo e(old('show_social_media', $footer->show_social_media) ? 'checked' : ''); ?>

                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#006400]/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#006400]"></div>
                            </label>
                        </div>

                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Newsletter</p>
                                <p class="text-xs text-gray-400">Tampilkan form newsletter di footer</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_newsletter" value="1"
                                    <?php echo e(old('show_newsletter', $footer->show_newsletter) ? 'checked' : ''); ?>

                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#006400]/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#006400]"></div>
                            </label>
                        </div>
                    </div>
                </div>

                
                <div class="bg-gradient-to-br from-[#0B2A4A] to-[#1a3a5a] rounded-2xl p-5 text-white">
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-300">Preview Footer</p>
                    <div class="mt-3 space-y-2 text-sm text-gray-300">
                        <div><i class="fas fa-building text-blue-400 w-5"></i> <?php echo e(old('nama_website', $footer->nama_website ?? 'Badan Bank Tanah')); ?></div>
                        <div><i class="fas fa-map-marker-alt text-blue-400 w-5"></i> <?php echo e(old('alamat', $footer->alamat ?? 'Jl. H. Juanda No. 15')); ?></div>
                        <div><i class="fas fa-envelope text-blue-400 w-5"></i> <?php echo e(old('email', $footer->email ?? 'info@bantah.go.id')); ?></div>
                        <div><i class="fas fa-phone text-blue-400 w-5"></i> <?php echo e(old('telepon', $footer->telepon ?? '(021) 3456-7890')); ?></div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-white/10 text-xs text-gray-400">
                        <?php echo e(old('footer_text', $footer->footer_text ?? '&copy; {year} Badan Bank Tanah. Hak Cipta Dilindungi.')); ?>

                    </div>
                </div>

                
                <button type="submit" 
                        class="w-full bg-[#006400] hover:bg-[#005500] text-white px-6 py-3.5 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Footer
                </button>

            </div>

        </div>

    </form>

</div>


<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // =========================================================
    // DRAG & DROP SORTING
    // =========================================================
    const container = document.getElementById('quickLinksContainer');
    
    if (container) {
        new Sortable(container, {
            handle: '.fa-grip-vertical',
            animation: 150,
            ghostClass: 'bg-blue-50',
        });
    }

    // =========================================================
    // TOGGLE STATUS CHECKBOX
    // =========================================================
    document.querySelectorAll('input[type="checkbox"][name="show_social_media"], input[type="checkbox"][name="show_newsletter"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const label = this.parentElement.nextElementSibling;
            if (label) {
                label.textContent = this.checked ? 'Tampilkan' : 'Sembunyikan';
            }
        });
    });
});

// =========================================================
// QUICK LINKS - ADD / REMOVE
// =========================================================
let linkIndex = <?php echo e(count(old('quick_links', $footer->quick_links ?? []))); ?>;

function addQuickLink() {
    const container = document.getElementById('quickLinksContainer');
    const index = linkIndex++;

    const div = document.createElement('div');
    div.className = 'quick-link-item flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-gray-200 transition';
    div.innerHTML = `
        <i class="fas fa-grip-vertical text-gray-400 cursor-move"></i>
        <input type="text" name="quick_links[${index}][label]" placeholder="Label tautan"
            class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition bg-white">
        <input type="text" name="quick_links[${index}][url]" placeholder="/url-tautan"
            class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition bg-white">
        <button type="button" onclick="removeQuickLink(this)" 
                class="text-red-500 hover:text-red-700 transition p-1.5">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(div);
}

function removeQuickLink(button) {
    const item = button.closest('.quick-link-item');
    const container = document.getElementById('quickLinksContainer');
    
    if (container.children.length > 1) {
        item.remove();
    } else {
        showToast('Minimal harus ada 1 tautan.', 'warning');
    }
}

// =========================================================
// TOAST NOTIFICATION
// =========================================================
function showToast(message, type = 'success') {
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'fixed top-20 right-4 z-[99999] space-y-3 max-w-sm w-full';
        document.body.appendChild(container);
    }

    const colors = {
        success: 'bg-green-50 border-green-400 text-green-800',
        error: 'bg-red-50 border-red-400 text-red-800',
        warning: 'bg-yellow-50 border-yellow-400 text-yellow-800',
        info: 'bg-blue-50 border-blue-400 text-blue-800'
    };
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-triangle-exclamation',
        info: 'fa-circle-info'
    };

    const toast = document.createElement('div');
    toast.className = `flex items-start gap-3 p-4 border rounded-xl shadow-lg ${colors[type] || colors.success} animate-slide-in`;
    toast.innerHTML = `
        <i class="fas ${icons[type] || icons.success} text-lg mt-0.5"></i>
        <div class="flex-1 text-sm font-medium">${message}</div>
        <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u250369146/laravel-app/resources/views/admin/footer.blade.php ENDPATH**/ ?>