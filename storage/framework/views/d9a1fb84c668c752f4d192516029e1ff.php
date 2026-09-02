<?php $__env->startSection('title', 'Detail Kontak'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-5xl mx-auto">

    
    <div class="flex flex-col sm:flex-row
                sm:items-center sm:justify-between
                gap-4 mb-8">

        <div class="flex items-center gap-4">

            
            <div class="w-12 h-12 rounded-2xl
                        bg-[#0B2A4A]
                        flex items-center justify-center
                        shadow-sm">

                <i class="fas fa-envelope-open-text
                          text-white text-lg"></i>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Detail Pesan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Informasi lengkap pesan yang dikirimkan
                    oleh pengunjung.
                </p>

            </div>

        </div>


        
        <a
            href="<?php echo e(route('admin.kontak.index')); ?>"
            class="inline-flex items-center
                   justify-center gap-2
                   px-4 py-2.5
                   rounded-xl
                   border border-gray-200
                   bg-white
                   text-sm font-semibold
                   text-gray-600
                   hover:text-[#0B2A4A]
                   hover:border-gray-300
                   hover:bg-gray-50
                   transition">

            <i class="fas fa-arrow-left text-xs"></i>

            Kembali ke Daftar

        </a>

    </div>


    
    <div class="bg-green-50
                border border-green-200
                rounded-2xl
                p-5 mb-6">

        <div class="flex items-center gap-4">

            <div class="w-10 h-10
                        rounded-xl
                        bg-green-100
                        flex items-center
                        justify-center">

                <i class="fas fa-circle-check
                          text-[#006400]"></i>

            </div>

            <div>

                <p class="text-sm font-bold
                          text-green-900">

                    Pesan telah dibaca

                </p>

                <p class="text-xs text-green-700 mt-1">

                    Informasi pesan dapat ditinjau
                    pada halaman ini.

                </p>

            </div>

        </div>

    </div>


    
    <div class="bg-white rounded-2xl
                border border-gray-200
                shadow-sm overflow-hidden mb-6">


        
        <div class="px-6 py-5
                    bg-gray-50
                    border-b border-gray-200">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10
                            rounded-xl
                            bg-blue-50
                            flex items-center
                            justify-center">

                    <i class="fas fa-user
                              text-[#0B2A4A]"></i>

                </div>

                <div>

                    <h2 class="text-base font-bold
                               text-gray-900">

                        Informasi Pengirim

                    </h2>

                    <p class="text-xs text-gray-500 mt-1">

                        Informasi kontak pengunjung.

                    </p>

                </div>

            </div>

        </div>


        
        <div class="p-6">

            <div class="grid grid-cols-1
                        md:grid-cols-2
                        gap-6">


                
                <div class="flex items-start gap-3">

                    <div class="w-9 h-9
                                rounded-lg
                                bg-gray-100
                                flex items-center
                                justify-center
                                flex-shrink-0">

                        <i class="fas fa-user
                                  text-gray-500
                                  text-xs"></i>

                    </div>

                    <div>

                        <p class="text-xs
                                  font-semibold
                                  text-gray-500
                                  uppercase
                                  tracking-wide">

                            Nama

                        </p>

                        <p class="text-sm
                                  font-bold
                                  text-gray-900
                                  mt-1">

                            <?php echo e($kontak->nama); ?>


                        </p>

                    </div>

                </div>


                
                <div class="flex items-start gap-3">

                    <div class="w-9 h-9
                                rounded-lg
                                bg-gray-100
                                flex items-center
                                justify-center
                                flex-shrink-0">

                        <i class="fas fa-envelope
                                  text-gray-500
                                  text-xs"></i>

                    </div>

                    <div>

                        <p class="text-xs
                                  font-semibold
                                  text-gray-500
                                  uppercase
                                  tracking-wide">

                            Email

                        </p>

                        <p class="text-sm
                                  font-bold
                                  text-gray-900
                                  mt-1
                                  break-all">

                            <?php echo e($kontak->email); ?>


                        </p>

                    </div>

                </div>


                
                <div class="flex items-start gap-3">

                    <div class="w-9 h-9
                                rounded-lg
                                bg-gray-100
                                flex items-center
                                justify-center
                                flex-shrink-0">

                        <i class="fas fa-phone
                                  text-gray-500
                                  text-xs"></i>

                    </div>

                    <div>

                        <p class="text-xs
                                  font-semibold
                                  text-gray-500
                                  uppercase
                                  tracking-wide">

                            Telepon

                        </p>

                        <p class="text-sm
                                  font-bold
                                  text-gray-900
                                  mt-1">

                            <?php echo e($kontak->telepon ?: 'Tidak tersedia'); ?>


                        </p>

                    </div>

                </div>


                
                <div class="flex items-start gap-3">

                    <div class="w-9 h-9
                                rounded-lg
                                bg-green-50
                                flex items-center
                                justify-center
                                flex-shrink-0">

                        <i class="fas fa-circle-check
                                  text-[#006400]
                                  text-xs"></i>

                    </div>

                    <div>

                        <p class="text-xs
                                  font-semibold
                                  text-gray-500
                                  uppercase
                                  tracking-wide">

                            Status

                        </p>

                        <?php if($kontak->is_read == 1): ?>

                            <span class="inline-flex
                                         items-center
                                         gap-1.5
                                         px-3 py-1.5
                                         rounded-full
                                         bg-green-50
                                         text-[#006400]
                                         text-xs
                                         font-bold
                                         mt-2">

                                <span class="w-1.5 h-1.5
                                             rounded-full
                                             bg-[#006400]"></span>

                                Dibaca

                            </span>

                        <?php else: ?>

                            <span class="inline-flex
                                         items-center
                                         gap-1.5
                                         px-3 py-1.5
                                         rounded-full
                                         bg-orange-50
                                         text-orange-700
                                         text-xs
                                         font-bold
                                         mt-2">

                                <span class="w-1.5 h-1.5
                                             rounded-full
                                             bg-orange-500"></span>

                                Belum Dibaca

                            </span>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>


    
    <div class="bg-white rounded-2xl
                border border-gray-200
                shadow-sm overflow-hidden">


        
        <div class="px-6 py-5
                    bg-gray-50
                    border-b border-gray-200">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10
                            rounded-xl
                            bg-blue-50
                            flex items-center
                            justify-center">

                    <i class="fas fa-message
                              text-[#0B2A4A]"></i>

                </div>

                <div>

                    <h2 class="text-base font-bold
                               text-gray-900">

                        Isi Pesan

                    </h2>

                    <p class="text-xs text-gray-500 mt-1">

                        Pesan yang dikirimkan oleh pengunjung.

                    </p>

                </div>

            </div>

        </div>


        
        <div class="p-6">

            <div class="bg-gray-50
                        border border-gray-100
                        rounded-xl
                        p-5">

                <p class="text-sm
                          text-gray-700
                          leading-relaxed
                          whitespace-pre-line">

                    <?php echo e($kontak->pesan); ?>


                </p>

            </div>

        </div>

    </div>


    
    <div class="mt-6
                flex flex-col-reverse
                sm:flex-row
                sm:justify-between
                sm:items-center
                gap-3">


        
        <a
            href="<?php echo e(route('admin.kontak.index')); ?>"
            class="inline-flex
                   items-center
                   justify-center
                   gap-2
                   px-5 py-2.5
                   rounded-xl
                   border border-gray-300
                   bg-white
                   text-sm font-semibold
                   text-gray-600
                   hover:bg-gray-100
                   transition">

            <i class="fas fa-arrow-left text-xs"></i>

            Kembali ke Daftar

        </a>


        
        <form
            action="<?php echo e(route('admin.kontak.destroy', $kontak->id)); ?>"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">

            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <button
                type="submit"
                class="inline-flex
                       items-center
                       justify-center
                       gap-2
                       px-5 py-2.5
                       rounded-xl
                       bg-red-50
                       text-red-600
                       border border-red-100
                       hover:bg-red-100
                       text-sm font-bold
                       transition">

                <i class="fas fa-trash text-xs"></i>

                Hapus Pesan

            </button>

        </form>

    </div>


    
    <div class="mt-5 flex items-start gap-2 px-1">

        <i class="fas fa-circle-info
                  text-gray-400
                  text-xs
                  mt-0.5"></i>

        <p class="text-xs text-gray-400 leading-relaxed">

            Informasi pada halaman ini berasal dari pesan
            yang dikirimkan pengunjung melalui halaman kontak
            website.

        </p>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/kontak_show.blade.php ENDPATH**/ ?>