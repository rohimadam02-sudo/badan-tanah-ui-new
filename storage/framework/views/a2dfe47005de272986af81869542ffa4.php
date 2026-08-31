<?php $__env->startSection('title', 'Aset Persediaan Tanah'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="max-w-3xl">

            <span class="inline-flex items-center gap-2
                         text-xs font-semibold text-blue-200
                         uppercase tracking-wider mb-4">
                <i class="fas fa-layer-group"></i>
                Aset Persediaan Tanah
            </span>

            <h1 class="text-3xl md:text-4xl font-bold text-white">
                Aset Persediaan Tanah
            </h1>

            <p class="text-blue-100 mt-4 leading-relaxed">
                Temukan informasi aset persediaan tanah Badan Bank Tanah
                berdasarkan lokasi, luas tanah, peruntukan, dan skema
                pemanfaatannya.
            </p>

            <div class="h-1 w-16 bg-blue-500 mt-6"></div>

        </div>

    </div>
</section>



<section class="bg-gray-50 py-12">

    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
        x-data="asetPage()"
        x-init="init()"
    >

        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">

            <div class="flex flex-col lg:flex-row lg:items-center
                        lg:justify-between gap-4 mb-6">

                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Cari Aset Tanah
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Gunakan filter untuk menemukan aset yang sesuai
                        dengan kebutuhan Anda.
                    </p>

                </div>

                <div class="text-sm text-gray-500">

                    <span
                        x-text="asets.length">
                    </span>

                    aset ditemukan

                </div>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                
                <div>

                    <label class="block text-xs font-semibold
                                  text-gray-600 mb-2">
                        Lokasi
                    </label>

                    <select
                        x-model="filters.provinsi"
                        class="w-full h-11 border border-gray-300
                               rounded-lg text-sm px-3
                               focus:ring-2 focus:ring-[#0B2A4A]
                               focus:border-[#0B2A4A]">

                        <option value="">
                            Semua Provinsi
                        </option>

                        <option value="Jawa Tengah">
                            Jawa Tengah
                        </option>

                        <option value="Sumatera Selatan">
                            Sumatera Selatan
                        </option>

                        <option value="Papua Selatan">
                            Papua Selatan
                        </option>

                    </select>

                </div>


                
                <div>

                    <label class="block text-xs font-semibold
                                  text-gray-600 mb-2">
                        Luas Minimum
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            min="0"
                            step="0.01"
                            x-model="filters.luas_min"
                            placeholder="Contoh: 1"
                            class="w-full h-11 border border-gray-300
                                   rounded-lg text-sm px-3 pr-12
                                   focus:ring-2 focus:ring-[#0B2A4A]
                                   focus:border-[#0B2A4A]">

                        <span class="absolute right-3 top-3
                                     text-xs text-gray-400">
                            Ha
                        </span>

                    </div>

                </div>


                
                <div>

                    <label class="block text-xs font-semibold
                                  text-gray-600 mb-2">
                        Luas Maksimum
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            min="0"
                            step="0.01"
                            x-model="filters.luas_max"
                            placeholder="Contoh: 5"
                            class="w-full h-11 border border-gray-300
                                   rounded-lg text-sm px-3 pr-12
                                   focus:ring-2 focus:ring-[#0B2A4A]
                                   focus:border-[#0B2A4A]">

                        <span class="absolute right-3 top-3
                                     text-xs text-gray-400">
                            Ha
                        </span>

                    </div>

                </div>


                
                <div>

                    <label class="block text-xs font-semibold
                                  text-gray-600 mb-2">
                        Peruntukan
                    </label>

                    <select
                        x-model="filters.peruntukan"
                        class="w-full h-11 border border-gray-300
                               rounded-lg text-sm px-3
                               focus:ring-2 focus:ring-[#0B2A4A]
                               focus:border-[#0B2A4A]">

                        <option value="">
                            Semua Peruntukan
                        </option>

                        <option value="Industri">
                            Industri
                        </option>

                        <option value="Pertanian">
                            Pertanian
                        </option>

                        <option value="Perumahan">
                            Perumahan
                        </option>

                    </select>

                </div>

            </div>


            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4
                        gap-4 mt-4">

                
                <div>

                    <label class="block text-xs font-semibold
                                  text-gray-600 mb-2">
                        Skema
                    </label>

                    <select
                        x-model="filters.skema"
                        class="w-full h-11 border border-gray-300
                               rounded-lg text-sm px-3
                               focus:ring-2 focus:ring-[#0B2A4A]
                               focus:border-[#0B2A4A]">

                        <option value="">
                            Semua Skema
                        </option>

                        <option value="Sewa">
                            Sewa
                        </option>

                        <option value="Kerjasama">
                            Kerjasama
                        </option>

                    </select>

                </div>


                <div class="sm:col-span-1 lg:col-span-3
                            flex flex-col sm:flex-row
                            justify-end items-stretch sm:items-end gap-3">

                    <button
                        type="button"
                        @click="resetFilter()"
                        class="h-11 px-6 rounded-lg border
                               border-gray-300 text-sm font-semibold
                               text-gray-600 hover:bg-gray-50
                               transition">

                        <i class="fas fa-rotate-left mr-2"></i>
                        Reset Filter

                    </button>


                    <button
                        type="button"
                        @click="applyFilter()"
                        class="h-11 px-7 rounded-lg
                               bg-[#0B2A4A] text-white
                               text-sm font-semibold
                               hover:bg-[#12395f]
                               transition">

                        <i class="fas fa-filter mr-2"></i>
                        Terapkan Filter

                    </button>

                </div>

            </div>

        </div>


        
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm overflow-hidden mb-8">

            <div class="p-6 border-b border-gray-100">

                <div class="flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-3">

                    <div>

                        <h2 class="text-lg font-bold text-gray-900">
                            Peta Sebaran Aset
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Lokasi aset persediaan tanah Badan Bank Tanah.
                        </p>

                    </div>

                    <span
                        class="text-xs text-gray-500">
                        <i class="fas fa-location-dot text-[#006400] mr-1"></i>
                        Marker aset
                    </span>

                </div>

            </div>


            <div
                id="assetMap"
                class="w-full h-[420px] bg-blue-50">
            </div>

        </div>


        
        <div class="flex items-center justify-between mb-5">

            <div>

                <h2 class="text-xl font-bold text-gray-900">
                    Daftar Aset
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Informasi aset persediaan tanah yang tersedia.
                </p>

            </div>

        </div>


        
        <div
            x-show="loading"
            x-cloak
            class="bg-white rounded-2xl border border-gray-200
                   p-12 text-center">

            <i class="fas fa-spinner fa-spin text-2xl
                     text-[#0B2A4A]"></i>

            <p class="text-sm text-gray-500 mt-3">
                Memuat data aset...
            </p>

        </div>


        
        <div
            x-show="!loading && asets.length === 0"
            x-cloak
            class="bg-white rounded-2xl border border-gray-200
                   p-12 text-center">

            <div class="w-14 h-14 mx-auto rounded-full
                        bg-gray-100 flex items-center
                        justify-center">

                <i class="fas fa-map-location-dot
                         text-gray-400 text-xl"></i>

            </div>

            <h3 class="font-bold text-gray-800 mt-4">
                Aset tidak ditemukan
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Tidak ada aset yang sesuai dengan filter yang dipilih.
            </p>

            <button
                type="button"
                @click="resetFilter()"
                class="mt-5 text-sm font-semibold
                       text-[#0B2A4A] hover:underline">

                Reset Filter

            </button>

        </div>


        
        <div
            x-show="!loading && asets.length > 0"
            x-cloak
            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3
                   gap-6">

            <template
                x-for="item in asets"
                :key="item.id">

                <article
                    class="bg-white rounded-2xl overflow-hidden
                           border border-gray-200 shadow-sm
                           hover:shadow-lg transition">

                    
                    <div class="relative h-52 bg-gray-100">

                        <img
                            :src="item.gambar
                                ? '<?php echo e(asset('storage')); ?>/' + item.gambar
                                : 'https://picsum.photos/600/400?random=' + item.id"
                            :alt="item.nama_lokasi"
                            class="w-full h-full object-cover">


                        
                        <span
                            class="absolute top-4 left-4
                                   text-white text-[10px]
                                   px-3 py-1.5 rounded-md
                                   font-bold uppercase tracking-wide"
                            :class="
                                item.status === 'Tersedia'
                                    ? 'bg-[#006400]'
                                    : (
                                        item.status === 'Dalam Pengembangan'
                                            ? 'bg-blue-600'
                                            : 'bg-orange-500'
                                      )
                            "
                            x-text="item.status">
                        </span>

                    </div>


                    
                    <div class="p-5">

                        <h3
                            class="font-bold text-base text-gray-900
                                   leading-snug"
                            x-text="item.nama_lokasi">
                        </h3>


                        <div class="flex items-start gap-2 mt-2">

                            <i class="fas fa-location-dot
                                     text-gray-400 text-xs mt-1"></i>

                            <p
                                class="text-xs text-gray-500 leading-relaxed"
                                x-text="
                                    item.provinsi +
                                    (item.kabupaten
                                        ? ', ' + item.kabupaten
                                        : '') +
                                    (item.kecamatan
                                        ? ', ' + item.kecamatan
                                        : '')
                                ">
                            </p>

                        </div>


                        
                        <div class="mt-4 pt-4
                                    border-t border-gray-100">

                            <p class="text-[10px] text-gray-400 uppercase
                                      tracking-wide">
                                Luas Tanah
                            </p>

                            <p
                                class="text-lg font-extrabold
                                       text-[#006400] mt-1"
                                x-text="
                                    formatNumber(item.luas_hektar) + ' Ha'
                                ">
                            </p>

                        </div>


                        
                        <div class="grid grid-cols-2 gap-3 mt-4">

                            <div class="bg-gray-50 rounded-lg p-3">

                                <p class="text-[9px] text-gray-400 uppercase">
                                    Peruntukan
                                </p>

                                <p
                                    class="text-xs font-semibold
                                           text-gray-700 mt-1"
                                    x-text="item.peruntukan || '-'">
                                </p>

                            </div>


                            <div class="bg-gray-50 rounded-lg p-3">

                                <p class="text-[9px] text-gray-400 uppercase">
                                    Skema
                                </p>

                                <p
                                    class="text-xs font-semibold
                                           text-gray-700 mt-1"
                                    x-text="item.skema || '-'">
                                </p>

                            </div>

                        </div>


                        
                        <a
                            :href="'/aset/' + item.id"
                            class="mt-5 w-full h-10
                                   inline-flex items-center
                                   justify-center gap-2
                                   rounded-lg
                                   bg-[#0B2A4A]
                                   text-white text-xs font-semibold
                                   hover:bg-[#12395f]
                                   transition">

                            Lihat Detail Aset

                            <i class="fas fa-arrow-right"></i>

                        </a>

                    </div>

                </article>

            </template>

        </div>

    </div>

</section>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/frontend/assets.blade.php ENDPATH**/ ?>