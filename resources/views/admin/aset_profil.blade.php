@extends('layouts.admin')

@section('title', 'Profil Persediaan Tanah')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="flex items-center justify-between mb-5">

        <div>
            <h1 class="text-xl font-bold text-gray-900">
                Profil Persediaan Tanah
            </h1>

            <p class="text-[10px] text-gray-500 mt-1">
                Lihat profil dan ringkasan persediaan tanah.
            </p>
        </div>

        <div class="flex items-center gap-2">

            <button type="button"
                class="px-3 py-1.5 text-[9px] font-semibold
                       border border-gray-200 rounded-md
                       text-gray-600 hover:bg-gray-50">

                <i class="fas fa-download mr-1"></i>
                Ekspor

            </button>

            <button type="button"
                class="px-3 py-1.5 text-[9px] font-semibold
                       bg-[#006400] text-white rounded-md
                       hover:bg-[#005500]">

                <i class="fas fa-print mr-1"></i>
                Cetak

            </button>

        </div>

    </div>


    {{-- =====================================================
        NAVIGASI ASET
    ====================================================== --}}

    <div class="overflow-x-auto">
        @include('admin.aset._navigation')
    </div>


    {{-- =====================================================
        KONTEN UTAMA
    ====================================================== --}}

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-4">


        {{-- =================================================
            INFORMASI PROFIL
        ================================================== --}}

        <div class="bg-white rounded-xl border border-gray-200
                    shadow-sm overflow-hidden">

            {{-- HEADER CARD --}}

            <div class="px-5 py-4 border-b border-gray-100">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-sm font-bold text-gray-900">
                            Informasi Dasar
                        </h2>

                        <p class="text-[9px] text-gray-400 mt-1">
                            Informasi profil persediaan tanah.
                        </p>

                    </div>

                    <span class="px-2 py-1 rounded
                                 bg-green-50 text-green-700
                                 text-[8px] font-semibold">

                        DATA PROFIL

                    </span>

                </div>

            </div>


            {{-- ISI --}}

            <div class="p-5">

                <div class="grid grid-cols-2 gap-x-8 gap-y-5">


                    {{-- NAMA --}}

                    <div>

                        <label class="block text-[9px]
                                      font-semibold text-gray-500 mb-1">

                            Nama Profil

                        </label>

                        <div class="flex items-center justify-between
                                    border-b border-gray-200 pb-2">

                            <span class="text-xs text-gray-800">
                                Persediaan Tanah
                            </span>

                            <i class="fas fa-chevron-down
                                      text-[8px] text-gray-400"></i>

                        </div>

                    </div>


                    {{-- STATUS --}}

                    <div>

                        <label class="block text-[9px]
                                      font-semibold text-gray-500 mb-1">

                            Status Profil

                        </label>

                        <div class="flex items-center justify-between
                                    border-b border-gray-200 pb-2">

                            <span class="text-xs text-gray-800">
                                Aktif
                            </span>

                            <span class="w-2 h-2 rounded-full bg-green-500"></span>

                        </div>

                    </div>


                    {{-- DESKRIPSI --}}

                    <div class="col-span-2">

                        <label class="block text-[9px]
                                      font-semibold text-gray-500 mb-1">

                            Deskripsi

                        </label>

                        <div class="border-b border-gray-200 pb-2">

                            <p class="text-xs text-gray-600 leading-relaxed">
                                Profil persediaan tanah Badan Bank Tanah
                                digunakan untuk memberikan gambaran umum
                                mengenai aset tanah yang tersedia dan
                                dikelola oleh sistem.
                            </p>

                        </div>

                    </div>


                    {{-- DATA ASET --}}

                    <div>

                        <label class="block text-[9px]
                                      font-semibold text-gray-500 mb-1">

                            Data Aset

                        </label>

                        <div class="flex items-center justify-between
                                    border-b border-gray-200 pb-2">

                            <span class="text-xs text-gray-800">
                                Data Persediaan Tanah
                            </span>

                            <i class="fas fa-chevron-down
                                      text-[8px] text-gray-400"></i>

                        </div>

                    </div>


                    {{-- PEMANFAATAN --}}

                    <div>

                        <label class="block text-[9px]
                                      font-semibold text-gray-500 mb-1">

                            Pemanfaatan Tanah

                        </label>

                        <div class="flex items-center justify-between
                                    border-b border-gray-200 pb-2">

                            <span class="text-xs text-gray-800">
                                Sesuai peruntukan
                            </span>

                            <i class="fas fa-chevron-down
                                      text-[8px] text-gray-400"></i>

                        </div>

                    </div>


                    {{-- WILAYAH --}}

                    <div>

                        <label class="block text-[9px]
                                      font-semibold text-gray-500 mb-1">

                            Wilayah Cakupan

                        </label>

                        <div class="flex items-center justify-between
                                    border-b border-gray-200 pb-2">

                            <span class="text-xs text-gray-800">
                                Indonesia
                            </span>

                            <i class="fas fa-chevron-down
                                      text-[8px] text-gray-400"></i>

                        </div>

                    </div>


                    {{-- SUMBER DATA --}}

                    <div>

                        <label class="block text-[9px]
                                      font-semibold text-gray-500 mb-1">

                            Sumber Data

                        </label>

                        <div class="flex items-center justify-between
                                    border-b border-gray-200 pb-2">

                            <span class="text-xs text-gray-800">
                                Sistem Informasi Aset
                            </span>

                            <i class="fas fa-chevron-down
                                      text-[8px] text-gray-400"></i>

                        </div>

                    </div>


                    {{-- KETERANGAN --}}

                    <div class="col-span-2">

                        <label class="block text-[9px]
                                      font-semibold text-gray-500 mb-1">

                            Keterangan

                        </label>

                        <div class="border-b border-gray-200 pb-2">

                            <p class="text-xs text-gray-500">
                                Informasi detail persediaan tanah
                                tersedia melalui menu Data Aset,
                                Wilayah, Status Tanah, dan Statistik.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FOOTER CARD --}}

            <div class="px-5 py-3 border-t border-gray-100
                        flex items-center justify-between">

                <span class="text-[8px] text-gray-400">
                    Informasi profil persediaan tanah
                </span>

                <a href="{{ route('admin.aset.index') }}"
                    class="px-3 py-1.5 bg-[#006400]
                           text-white rounded-md
                           text-[9px] font-semibold
                           hover:bg-[#005500]">

                    Lihat Data Aset

                </a>

            </div>

        </div>


        {{-- =================================================
            SIDEBAR
        ================================================== --}}

        <div class="space-y-4">


            {{-- RINGKASAN PROFIL --}}

            <div class="bg-white rounded-xl border border-gray-200
                        shadow-sm overflow-hidden">

                <div class="px-4 py-3 border-b border-gray-100">

                    <h2 class="text-xs font-bold text-gray-900">
                        Ringkasan Profil
                    </h2>

                </div>


                <div class="p-4 space-y-4">


                    <div>

                        <p class="text-[8px] text-gray-400">
                            Jenis Informasi
                        </p>

                        <p class="text-[10px] font-semibold text-gray-800 mt-1">
                            Profil Persediaan Tanah
                        </p>

                    </div>


                    <div>

                        <p class="text-[8px] text-gray-400">
                            Cakupan
                        </p>

                        <p class="text-[10px] font-semibold text-gray-800 mt-1">
                            Nasional
                        </p>

                    </div>


                    <div>

                        <p class="text-[8px] text-gray-400">
                            Status
                        </p>

                        <div class="flex items-center gap-1.5 mt-1">

                            <span class="w-2 h-2 rounded-full bg-green-500"></span>

                            <span class="text-[10px]
                                         font-semibold text-green-700">
                                Aktif
                            </span>

                        </div>

                    </div>


                    <div>

                        <p class="text-[8px] text-gray-400">
                            Ketersediaan Data
                        </p>

                        <p class="text-[10px] font-semibold text-gray-800 mt-1">
                            Tersedia
                        </p>

                    </div>

                </div>

            </div>


            {{-- MENU TERKAIT --}}

            <div class="bg-white rounded-xl border border-gray-200
                        shadow-sm overflow-hidden">

                <div class="px-4 py-3 border-b border-gray-100">

                    <h2 class="text-xs font-bold text-gray-900">
                        Menu Terkait
                    </h2>

                </div>


                <div class="p-3 space-y-1">


                    <a href="{{ route('admin.aset.index') }}"
                        class="flex items-center gap-2 px-2.5 py-2
                               rounded-md hover:bg-gray-50
                               transition">

                        <i class="fas fa-database
                                  text-[10px] text-green-600"></i>

                        <span class="text-[9px] text-gray-600">
                            Data Aset
                        </span>

                    </a>


                    <a href="{{ route('admin.aset.peta') }}"
                        class="flex items-center gap-2 px-2.5 py-2
                               rounded-md hover:bg-gray-50
                               transition">

                        <i class="fas fa-map
                                  text-[10px] text-blue-600"></i>

                        <span class="text-[9px] text-gray-600">
                            Peta Interaktif
                        </span>

                    </a>


                    <a href="{{ route('admin.aset.wilayah') }}"
                        class="flex items-center gap-2 px-2.5 py-2
                               rounded-md hover:bg-gray-50
                               transition">

                        <i class="fas fa-location-dot
                                  text-[10px] text-purple-600"></i>

                        <span class="text-[9px] text-gray-600">
                            Wilayah
                        </span>

                    </a>


                    <a href="{{ route('admin.aset.status') }}"
                        class="flex items-center gap-2 px-2.5 py-2
                               rounded-md hover:bg-gray-50
                               transition">

                        <i class="fas fa-circle-check
                                  text-[10px] text-orange-600"></i>

                        <span class="text-[9px] text-gray-600">
                            Status Tanah
                        </span>

                    </a>


                    <a href="{{ route('admin.aset.statistik') }}"
                        class="flex items-center gap-2 px-2.5 py-2
                               rounded-md hover:bg-gray-50
                               transition">

                        <i class="fas fa-chart-pie
                                  text-[10px] text-teal-600"></i>

                        <span class="text-[9px] text-gray-600">
                            Statistik
                        </span>

                    </a>

                </div>

            </div>


            {{-- INFORMASI --}}

            <div class="bg-green-50 border border-green-100
                        rounded-xl p-4">

                <div class="flex items-start gap-2">

                    <i class="fas fa-circle-info
                              text-green-600 text-xs mt-0.5"></i>

                    <div>

                        <p class="text-[9px] font-semibold text-green-800">
                            Informasi
                        </p>

                        <p class="text-[8px] text-green-700 mt-1 leading-relaxed">
                            Halaman ini berisi informasi umum mengenai
                            profil persediaan tanah.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection