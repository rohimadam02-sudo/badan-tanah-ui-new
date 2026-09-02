<?php $__env->startSection('title', $berita->judul . ' - Badan Bank Tanah'); ?>

<?php
    $metaTitle = $berita->meta_title ?? $berita->judul . ' - Badan Bank Tanah';
    $metaDescription = $berita->meta_description ?? strip_tags($berita->ringkasan ?? $berita->konten ?? '');
?>

<?php $__env->startSection('content'); ?>


<section class="relative bg-[#0B2A4A] overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-green-500 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20">
        <div class="max-w-3xl">
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="inline-flex items-center gap-1.5 bg-white/10 border border-white/10 text-blue-200 text-[10px] sm:text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fas fa-newspaper"></i>
                    <?php echo e($berita->kategori); ?>

                </span>
                <span class="text-blue-300/50 text-xs">•</span>
                <span class="text-blue-300/70 text-xs flex items-center gap-1.5">
                    <i class="far fa-calendar-alt"></i>
                    <?php echo e($berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') : $berita->created_at->format('d M Y')); ?>

                </span>
                <span class="text-blue-300/50 text-xs">•</span>
                <span class="text-blue-300/70 text-xs flex items-center gap-1.5">
                    <i class="far fa-eye"></i>
                    <?php echo e(number_format($berita->views ?? 0, 0, ',', '.')); ?> Dilihat
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                <?php echo e($berita->judul); ?>

            </h1>
            <div class="flex items-center gap-3 mt-4">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/10 flex items-center justify-center text-white font-bold text-xs sm:text-sm">
                    <?php echo e(strtoupper(substr($berita->penulis, 0, 1))); ?>

                </div>
                <div>
                    <p class="text-white text-sm font-medium"><?php echo e($berita->penulis); ?></p>
                    <p class="text-blue-300/60 text-xs">Penulis</p>
                </div>
            </div>
            <div class="h-1 w-16 bg-blue-500 mt-6 rounded-full"></div>
        </div>
    </div>
</section>


<section class="bg-gray-50 py-8 sm:py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="relative">
                <?php if($berita->gambar): ?>
                    <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>"
                        class="w-full h-[200px] sm:h-[300px] md:h-[400px] object-cover"
                        alt="<?php echo e($berita->judul); ?>">
                <?php else: ?>
                    <div class="w-full h-[200px] sm:h-[300px] md:h-[400px] bg-gradient-to-br from-[#0B2A4A] to-[#163F66] flex items-center justify-center">
                        <div class="text-center text-white/30">
                            <i class="fas fa-newspaper text-5xl sm:text-6xl md:text-7xl mb-3"></i>
                            <p class="text-sm">Gambar tidak tersedia</p>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center gap-1.5 bg-white/95 backdrop-blur-sm text-[#0B2A4A] text-[10px] sm:text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                        <i class="fas
                            <?php echo e($berita->kategori == 'Siaran Pers' ? 'fa-bullhorn' :
                               ($berita->kategori == 'Pengumuman' ? 'fa-circle-info' :
                               'fa-newspaper')); ?>">
                        </i>
                        <?php echo e($berita->kategori); ?>

                    </span>
                </div>

                
                <div class="absolute bottom-4 right-4 flex gap-2">
                    <button onclick="shareArticle()" class="bg-white/95 backdrop-blur-sm hover:bg-white text-[#0B2A4A] w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shadow-md transition hover:scale-110">
                        <i class="fas fa-share-alt text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        
        <?php if($berita->qr_code): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-qrcode text-2xl text-[#006400]"></i>
                    <div>
                        <h4 class="font-bold text-gray-900">QR Code Publikasi</h4>
                        <p class="text-xs text-gray-500">Scan untuk membagikan artikel ini</p>
                    </div>
                </div>
                <div class="flex-1 flex justify-center sm:justify-end">
                    <?php echo $berita->qr_code; ?>

                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 md:p-10 mb-8">
            <div class="prose prose-sm sm:prose-base md:prose-lg max-w-none">
                <?php echo nl2br(e($berita->konten)); ?>

            </div>

            
            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-calendar-alt"></i>
                        <?php echo e($berita->created_at->format('d F Y H:i')); ?>

                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-user"></i>
                        <?php echo e($berita->penulis); ?>

                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-eye"></i>
                        <?php echo e(number_format($berita->views ?? 0, 0, ',', '.')); ?>

                    </span>
                </div>

                
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-400 mr-1">Bagikan:</span>
                    <button onclick="shareTo('facebook')" class="w-8 h-8 rounded-full bg-[#1877F2]/10 text-[#1877F2] hover:bg-[#1877F2] hover:text-white transition flex items-center justify-center">
                        <i class="fab fa-facebook-f text-xs"></i>
                    </button>
                    <button onclick="shareTo('twitter')" class="w-8 h-8 rounded-full bg-[#000000]/10 text-[#000000] hover:bg-[#000000] hover:text-white transition flex items-center justify-center">
                        <i class="fab fa-x-twitter text-xs"></i>
                    </button>
                    <button onclick="shareTo('linkedin')" class="w-8 h-8 rounded-full bg-[#0A66C2]/10 text-[#0A66C2] hover:bg-[#0A66C2] hover:text-white transition flex items-center justify-center">
                        <i class="fab fa-linkedin-in text-xs"></i>
                    </button>
                    <button onclick="shareTo('whatsapp')" class="w-8 h-8 rounded-full bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white transition flex items-center justify-center">
                        <i class="fab fa-whatsapp text-xs"></i>
                    </button>
                    <button onclick="copyLink()" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-[#006400] hover:text-white transition flex items-center justify-center">
                        <i class="fas fa-link text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php
                $prev = \App\Models\Berita::where('id', '<', $berita->id)
                        ->where('status', 'Dipublikasikan')
                        ->orderBy('id', 'desc')
                        ->first();
                $next = \App\Models\Berita::where('id', '>', $berita->id)
                        ->where('status', 'Dipublikasikan')
                        ->orderBy('id', 'asc')
                        ->first();
            ?>

            <?php if($prev): ?>
            <a href="<?php echo e(route('publications.show', $prev->id)); ?>"
                class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:border-[#006400] hover:shadow-md transition">
                <i class="fas fa-arrow-left text-[#006400] text-sm group-hover:-translate-x-1 transition"></i>
                <div class="min-w-0 flex-1">
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider">Sebelumnya</p>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 group-hover:text-[#006400] transition truncate"><?php echo e($prev->judul); ?></p>
                </div>
            </a>
            <?php else: ?>
            <div></div>
            <?php endif; ?>

            <?php if($next): ?>
            <a href="<?php echo e(route('publications.show', $next->id)); ?>"
                class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:border-[#006400] hover:shadow-md transition sm:justify-end">
                <div class="min-w-0 flex-1 text-right">
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider">Selanjutnya</p>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 group-hover:text-[#006400] transition truncate"><?php echo e($next->judul); ?></p>
                </div>
                <i class="fas fa-arrow-right text-[#006400] text-sm group-hover:translate-x-1 transition"></i>
            </a>
            <?php else: ?>
            <div></div>
            <?php endif; ?>
        </div>

        
        <div class="mt-8 text-center">
            <a href="<?php echo e(route('publications')); ?>"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#006400] transition">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Publikasi
            </a>
        </div>

        
        <?php
            $related = \App\Models\Berita::where('kategori', $berita->kategori)
                        ->where('id', '!=', $berita->id)
                        ->where('status', 'Dipublikasikan')
                        ->latest()
                        ->take(3)
                        ->get();
        ?>

        <?php if($related->count() > 0): ?>
        <div class="mt-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-6 bg-[#006400] rounded-full"></div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900">Publikasi Terkait</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('publications.show', $item->id)); ?>"
                    class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-lg transition">
                    <div class="h-36 sm:h-40 bg-gray-200 relative overflow-hidden">
                        <?php if($item->gambar): ?>
                            <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                alt="<?php echo e($item->judul); ?>">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B2A4A] to-[#163F66]">
                                <i class="fas fa-newspaper text-white/20 text-3xl"></i>
                            </div>
                        <?php endif; ?>
                        <div class="absolute top-3 left-3">
                            <span class="text-[8px] font-bold uppercase px-2 py-0.5 rounded-full bg-white/95 text-[#0B2A4A]">
                                <?php echo e($item->kategori); ?>

                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="text-xs sm:text-sm font-bold text-gray-900 line-clamp-2 group-hover:text-[#006400] transition">
                            <?php echo e($item->judul); ?>

                        </h4>
                        <p class="text-[10px] text-gray-400 mt-1.5 flex items-center gap-2">
                            <i class="far fa-calendar-alt"></i>
                            <?php echo e($item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') : $item->created_at->format('d M Y')); ?>

                        </p>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Share Functions
    function shareArticle() {
        if (navigator.share) {
            navigator.share({
                title: '<?php echo e($berita->judul); ?>',
                text: '<?php echo e(Str::limit(strip_tags($berita->konten), 150)); ?>',
                url: window.location.href
            }).catch(() => {});
        } else {
            copyLink();
        }
    }

    function shareTo(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('<?php echo e($berita->judul); ?>');
        let shareUrl = '';

        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                break;
            default:
                return;
        }

        window.open(shareUrl, '_blank', 'width=600,height=500');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-24 left-1/2 -translate-x-1/2 bg-[#006400] text-white px-6 py-3 rounded-xl shadow-lg text-sm font-medium z-50 animate-fade-up';
            toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Link berhasil disalin!';
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }).catch(() => {
            const input = document.createElement('input');
            input.value = window.location.href;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            input.remove();
            alert('Link berhasil disalin!');
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/frontend/berita_detail.blade.php ENDPATH**/ ?>