<?php $__env->startSection('title', $halaman->judul . ' - Badan Bank Tanah'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $proyekInvestasi = \App\Models\ProyekInvestasi::where('is_active', true)->orderBy('urutan')->get();
    $dokumenKerjasama = \App\Models\DokumenKerjasama::where('is_active', true)->orderBy('urutan')->get();

    // Ambil data dari halaman dengan fallback ke array kosong
    $skemaList = $halaman->skema_pemanfaatan ?? [];
    $kerjasamaList = $halaman->bentuk_kerjasama ?? [];
    $prosedurList = $halaman->prosedur_tahapan ?? [];
    $persyaratanList = $halaman->persyaratan ?? [];
    $dokumenList = $halaman->dokumen_pendukung ?? [];
    $faqList = $halaman->faq_pemanfaatan ?? [];
?>


<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">

        <div class="max-w-3xl">

            <div
                class="inline-flex items-center gap-2
                        bg-white/10 border border-white/10
                        text-blue-200 text-xs font-semibold
                        px-4 py-2 rounded-full mb-5">

                <i class="fas fa-handshake"></i>

                Pemanfaatan & Kerjasama Usaha

            </div>

            <h1
                class="text-3xl md:text-4xl lg:text-5xl
                       font-extrabold text-white leading-tight">

                Pemanfaatan dan Kerjasama
                <span class="text-blue-300">
                    Aset Tanah
                </span>

            </h1>

            <p class="text-blue-100 text-base md:text-lg
                      leading-relaxed mt-5 max-w-2xl">

                <?php echo e($halaman->isi); ?>


            </p>

            <div class="flex flex-col sm:flex-row gap-3 mt-8">

                <a href="<?php echo e(route('assets')); ?>"
                    class="btn-primary inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-bold transition">

                    <i class="fas fa-map-location-dot"></i>

                    Lihat Aset Persediaan

                </a>

                <a href="<?php echo e(route('kontak')); ?>"
                    class="btn-primary inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-bold transition">

                    <i class="fas fa-comments"></i>

                    Hubungi Kami

                </a>

            </div>

        </div>

    </div>
</section>



<section class="bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

        <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_0.8fr]
                    gap-10 items-center">

            <div>

                <span class="text-xs font-bold uppercase
                             tracking-wider text-blue-700">
                    Tentang Pemanfaatan
                </span>

                <h2 class="text-2xl md:text-3xl
                           font-extrabold text-gray-900 mt-2">

                    Membuka peluang pemanfaatan
                    aset tanah secara profesional

                </h2>

                <p class="text-gray-600 leading-relaxed mt-5">

                    Badan Bank Tanah menyediakan informasi mengenai
                    pemanfaatan dan kerja sama usaha atas aset tanah
                    yang tersedia. Informasi ini membantu calon mitra
                    memahami pilihan skema dan tahapan sebelum
                    melanjutkan proses kerja sama.

                </p>

                <p class="text-gray-600 leading-relaxed mt-4">

                    Pengunjung dapat terlebih dahulu melihat aset
                    persediaan tanah, memahami karakteristik aset,
                    kemudian mempelajari skema pemanfaatan atau
                    kerja sama yang sesuai dengan kebutuhan.

                </p>

            </div>


            

            <div class="bg-[#0B2A4A] rounded-2xl p-7 text-white">

                <div
                    class="w-12 h-12 rounded-xl
                            bg-white/10
                            flex items-center justify-center mb-5">
                    <i class="fas fa-layer-group
                            text-xl text-blue-200"></i>

                </div>

                <h3 class="text-xl font-bold">
                    Informasi Terintegrasi
                </h3>

                <p class="text-blue-100 text-sm leading-relaxed mt-3">

                    Mulai dari menemukan aset, memahami skema,
                    mempelajari persyaratan hingga menghubungi
                    Badan Bank Tanah.

                </p>

                <div class="mt-6 space-y-3">

                    <div class="flex items-center gap-3 text-sm">
                        <i class="fas fa-check text-green-400"></i>
                        Informasi skema pemanfaatan
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <i class="fas fa-check text-green-400"></i>
                        Informasi bentuk kerja sama
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <i class="fas fa-check text-green-400"></i>
                        Prosedur dan tahapan
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <i class="fas fa-check text-green-400"></i>
                        Persyaratan dan dokumen
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<section class="bg-gray-50 border-y border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="text-center max-w-2xl mx-auto mb-10">

            <span class="text-xs font-bold uppercase
                         tracking-wider text-blue-700">

                Skema Pemanfaatan

            </span>

            <h2 class="text-2xl md:text-3xl
                       font-extrabold text-gray-900 mt-2">

                Pilihan pemanfaatan aset

            </h2>

            <p class="text-gray-500 text-sm leading-relaxed mt-3">

                Informasi skema yang dapat dikelola melalui CMS.

            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <?php $__empty_1 = true; $__currentLoopData = $skemaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $skema): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div
                    id="skema-<?php echo e($index); ?>"
                    class="bg-white rounded-2xl
                            border border-gray-200
                            shadow-sm
                            p-7
                            hover:shadow-md
                            transition group
                            scroll-mt-24">

                    <div
                        class="w-12 h-12 rounded-xl
                                bg-[#0B2A4A]/10
                                text-[#0B2A4A]
                                flex items-center justify-center">

                        <i class="fas <?php echo e($skema['icon'] ?? 'fa-circle'); ?> text-xl"></i>

                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mt-5">

                        <?php echo e($skema['title'] ?? ''); ?>


                    </h3>

                    <p class="text-sm text-gray-500
                              leading-relaxed mt-3">

                        <?php echo e($skema['description'] ?? ''); ?>


                    </p>

                    <div class="mt-5 pt-4 border-t border-gray-100">

                        <a href="#skema-<?php echo e($index); ?>"
                           class="text-xs font-semibold link-secondary hover:underline inline-flex items-center gap-1 transition group">

                            Informasi skema

                            <i class="fas fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>

                        </a>

                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center text-gray-500 py-8">
                    <p>Belum ada skema pemanfaatan yang tersedia.</p>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>



<section class="bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="flex flex-col md:flex-row
                    md:items-end md:justify-between gap-5 mb-8">

            <div>

                <span class="text-xs font-bold uppercase
                             tracking-wider text-blue-700">

                    Bentuk Kerja Sama

                </span>

                <h2 class="text-2xl md:text-3xl
                           font-extrabold text-gray-900 mt-2">

                    Pilihan bentuk kerja sama usaha

                </h2>

            </div>

            <p class="text-sm text-gray-500 max-w-md">

                Data yang dapat dikelola melalui CMS.

            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <?php $__empty_1 = true; $__currentLoopData = $kerjasamaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div
                    id="kerjasama-<?php echo e($index); ?>"
                    class="rounded-2xl
                            border border-gray-200
                            p-6
                            bg-gray-50
                            scroll-mt-24">

                    <div class="flex items-center justify-between">

                        <span
                            class="text-3xl font-extrabold
                                     text-[#0B2A4A]/20">

                            <?php echo e($item['number'] ?? ''); ?>


                        </span>

                        <i class="fas fa-handshake
                                    text-[#0B2A4A]/40"></i>

                    </div>

                    <h3 class="font-bold text-lg text-gray-900 mt-5">

                        <?php echo e($item['title'] ?? ''); ?>


                    </h3>

                    <p class="text-sm text-gray-500
                              leading-relaxed mt-3">

                        <?php echo e($item['description'] ?? ''); ?>


                    </p>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center text-gray-500 py-8">
                    <p>Belum ada bentuk kerjasama yang tersedia.</p>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>



<section class="bg-gray-50 border-y border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="text-center max-w-2xl mx-auto mb-10">

            <span class="text-xs font-bold uppercase
                         tracking-wider text-green-700">

                Proyek Investasi

            </span>

            <h2 class="text-2xl md:text-3xl
                       font-extrabold text-gray-900 mt-2">

                Proyek Investasi Badan Bank Tanah

            </h2>

            <p class="text-gray-500 text-sm leading-relaxed mt-3">

                Daftar proyek investasi yang sedang berjalan dan dikelola
                oleh Badan Bank Tanah.

            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php $__empty_1 = true; $__currentLoopData = $proyekInvestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg transition group">

                    <?php if($item->gambar): ?>
                        <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" 
                             class="w-full h-44 object-cover rounded-xl mb-4">
                    <?php else: ?>
                        <div class="w-full h-44 bg-gray-100 rounded-xl mb-4 flex items-center justify-center">
                            <i class="fas fa-building text-4xl text-gray-300"></i>
                        </div>
                    <?php endif; ?>

                    <h4 class="font-bold text-gray-900 text-lg group-hover:text-[var(--color-secondary)] transition">
                        <?php echo e($item->judul); ?>

                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-location-dot text-[var(--color-secondary)] mr-1"></i>
                        <?php echo e($item->lokasi); ?>

                    </p>

                    <div class="flex items-center gap-2 mt-3">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full
                            <?php echo e($item->status == 'Aktif' ? 'bg-green-50 text-green-700' :
                               ($item->status == 'Dalam Proses' ? 'bg-orange-50 text-orange-700' :
                               'bg-blue-50 text-blue-700')); ?>">
                            <?php echo e($item->status); ?>

                        </span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">
                            <?php echo e($item->sektor); ?>

                        </span>
                    </div>

                    <?php if($item->nilai_investasi): ?>
                        <p class="text-sm font-bold text-[#006400] mt-3">
                            Rp <?php echo e(number_format($item->nilai_investasi, 0, ',', '.')); ?>

                        </p>
                    <?php endif; ?>

                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                        <?php echo e($item->deskripsi); ?>

                    </p>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center text-gray-500 py-12">
                    <i class="fas fa-chart-line text-4xl text-gray-300 block mb-3"></i>
                    <p class="text-sm">Belum ada proyek investasi yang tersedia.</p>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>



<section class="bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="text-center max-w-2xl mx-auto mb-10">

            <span class="text-xs font-bold uppercase
                         tracking-wider text-purple-700">

                Dokumen & Booklet

            </span>

            <h2 class="text-2xl md:text-3xl
                       font-extrabold text-gray-900 mt-2">

                Dokumen & Booklet Kerjasama

            </h2>

            <p class="text-gray-500 text-sm leading-relaxed mt-3">

                Unduh dokumen dan booklet informasi kerjasama
                Badan Bank Tanah.

            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl mx-auto">

            <?php $__empty_1 = true; $__currentLoopData = $dokumenKerjasama; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('dokumen.download', $item->id)); ?>" 
                   class="flex items-center gap-4 p-4 bg-gray-50 border border-gray-100 rounded-xl hover:shadow-md hover:bg-white transition group">

                    <div class="w-14 h-14 rounded-xl bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-pdf text-2xl"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 group-hover:text-[var(--color-secondary)] transition truncate">
                            <?php echo e($item->judul); ?>

                        </p>
                        <p class="text-xs text-gray-400">
                            <?php echo e($item->ukuran ?? 'PDF'); ?> • <?php echo e(ucfirst($item->kategori)); ?>

                        </p>
                    </div>

                    <i class="fas fa-download text-gray-400 group-hover:text-[var(--color-secondary)] transition text-sm"></i>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-2 text-center text-gray-500 py-12">
                    <i class="fas fa-file-pdf text-4xl text-gray-300 block mb-3"></i>
                    <p class="text-sm">Belum ada dokumen yang tersedia.</p>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>



<section class="bg-gray-50 border-y border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="text-center max-w-2xl mx-auto mb-12">

            <span class="text-xs font-bold uppercase
                         tracking-wider text-blue-700">

                Prosedur & Tahapan

            </span>

            <h2 class="text-2xl md:text-3xl
                       font-extrabold text-gray-900 mt-2">

                Bagaimana prosesnya?

            </h2>

            <p class="text-gray-500 text-sm mt-3">

                Gambaran alur informasi pemanfaatan dan kerja sama
                dari pencarian aset hingga komunikasi lebih lanjut.

            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <?php $__empty_1 = true; $__currentLoopData = $prosedurList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div
                    id="prosedur-<?php echo e($index); ?>"
                    class="relative scroll-mt-24">

                    <div
                        class="bg-white rounded-2xl
                                border border-gray-200
                                shadow-sm p-6 h-full">
                        <div
                            class="w-11 h-11 rounded-xl
                                    bg-[#0B2A4A]
                                    text-white
                                    flex items-center justify-center">

                            <i class="fas <?php echo e($step['icon'] ?? 'fa-circle'); ?> text-sm"></i>

                        </div>

                        <span
                            class="absolute top-3 right-4
                                text-[10px] font-bold
                                text-[#0B2A4A]/30">

                            <?php echo e($step['number'] ?? ''); ?>


                        </span>

                        <h3 class="font-bold text-gray-900 mt-5">

                            <?php echo e($step['title'] ?? ''); ?>


                        </h3>

                        <p class="text-sm text-gray-500
                                  leading-relaxed mt-3">

                            <?php echo e($step['description'] ?? ''); ?>


                        </p>

                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-4 text-center text-gray-500 py-8">
                    <p>Belum ada prosedur dan tahapan yang tersedia.</p>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>



<section class="bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">


            

            <div
                class="bg-white rounded-2xl
                        border border-gray-200
                        shadow-sm p-7">

                <div class="flex items-center gap-4 mb-6">

                    <div
                        class="w-11 h-11 rounded-xl
                                bg-green-50
                                text-green-700
                                flex items-center justify-center">

                        <i class="fas fa-clipboard-check"></i>

                    </div>

                    <div>

                        <h2 class="text-xl font-bold text-gray-900">
                            Persyaratan
                        </h2>

                        <p class="text-sm text-gray-500">
                            Persyaratan yang diperlukan
                        </p>

                    </div>

                </div>

                <div class="space-y-4">

                    <?php $__empty_1 = true; $__currentLoopData = $persyaratanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-start gap-3">

                            <div
                                class="w-5 h-5 rounded-full
                                        bg-green-100
                                        text-green-700
                                        flex items-center justify-center
                                        shrink-0 mt-0.5">

                                <i class="fas fa-check text-[9px]"></i>

                            </div>

                            <p class="text-sm text-gray-600">
                                <?php echo e($item); ?>

                            </p>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500">Belum ada persyaratan yang tersedia.</p>
                    <?php endif; ?>

                </div>

            </div>



            

            <div
                class="bg-white rounded-2xl
                        border border-gray-200
                        shadow-sm p-7">

                <div class="flex items-center gap-4 mb-6">

                    <div
                        class="w-11 h-11 rounded-xl
                                bg-blue-50
                                text-blue-700
                                flex items-center justify-center">

                        <i class="fas fa-file-lines"></i>

                    </div>

                    <div>

                        <h2 class="text-xl font-bold text-gray-900">
                            Dokumen
                        </h2>

                        <p class="text-sm text-gray-500">
                            Dokumen pendukung yang diperlukan
                        </p>

                    </div>

                </div>

                <div class="space-y-4">

                    <?php $__empty_1 = true; $__currentLoopData = $dokumenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div
                            class="flex items-center gap-3
                                    p-3 rounded-lg
                                    bg-gray-50">

                            <i class="fas fa-file-pdf
                                      text-red-500"></i>

                            <span class="text-sm text-gray-600">

                                <?php echo e($item); ?>


                            </span>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500">Belum ada dokumen pendukung yang tersedia.</p>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</section>



<section class="bg-gray-50 border-y border-gray-100">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="text-center mb-10">

            <span class="text-xs font-bold uppercase
                         tracking-wider text-blue-700">

                FAQ

            </span>

            <h2 class="text-2xl md:text-3xl
                       font-extrabold text-gray-900 mt-2">

                Pertanyaan yang sering diajukan

            </h2>

        </div>

        <div class="space-y-4">

            <?php $__empty_1 = true; $__currentLoopData = $faqList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <details
                    class="group bg-white rounded-xl
                            border border-gray-200
                            shadow-sm">

                    <summary
                        class="cursor-pointer
                                    list-none
                                    p-5
                                    flex items-center
                                    justify-between
                                    font-semibold
                                    text-gray-900">

                        <?php echo e($item['question'] ?? ''); ?>


                        <i
                            class="fas fa-chevron-down
                                  text-gray-400
                                  group-open:rotate-180
                                  transition"></i>

                    </summary>

                    <div
                        class="px-5 pb-5
                                text-sm text-gray-500
                                leading-relaxed">

                        <?php echo e($item['answer'] ?? ''); ?>


                    </div>

                </details>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-gray-500 py-8">
                    <p>Belum ada FAQ yang tersedia.</p>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>



<section class="bg-[#0B2A4A]">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

        <div
            class="rounded-2xl
                    bg-white/5
                    border border-white/10
                    p-8 md:p-10
                    flex flex-col lg:flex-row
                    lg:items-center
                    lg:justify-between
                    gap-8">

            <div>

                <span
                    class="text-xs font-bold uppercase
                             tracking-wider text-blue-300">

                    Mulai dari sini

                </span>

                <h2 class="text-2xl md:text-3xl
                           font-extrabold text-white mt-2">

                    Temukan peluang pemanfaatan aset

                </h2>

                <p class="text-blue-100 text-sm
                          leading-relaxed mt-3 max-w-2xl">

                    Lihat aset persediaan tanah, pelajari
                    informasi pemanfaatan dan kerja sama,
                    kemudian hubungi Badan Bank Tanah untuk
                    informasi lebih lanjut.

                </p>

            </div>


            <div class="flex flex-col sm:flex-row gap-3 shrink-0">

                <a href="<?php echo e(route('assets')); ?>"
                    class="btn-primary inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-bold transition">

                    <i class="fas fa-map-location-dot"></i>

                    Lihat Aset

                </a>

                <a href="<?php echo e(route('kontak')); ?>"
                    class="btn-primary inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-bold transition">

                    <i class="fas fa-phone"></i>

                    Kontak

                </a>

            </div>

        </div>

    </div>

</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/frontend/partnership.blade.php ENDPATH**/ ?>