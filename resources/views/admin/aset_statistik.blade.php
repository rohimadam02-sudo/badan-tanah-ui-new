@extends('layouts.admin')

@section('title', 'Statistik')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="mb-5">

        <h1 class="text-2xl font-bold text-gray-900">
            Aset Persediaan Tanah
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Kelola dan pantau informasi persediaan tanah.
        </p>

    </div>


    {{-- =====================================================
        NAVIGASI ASET
    ====================================================== --}}

    <div class="overflow-x-auto">
        @include('admin.aset._navigation')
    </div>


    {{-- =====================================================
        HEADER STATISTIK
    ====================================================== --}}

    <div class="bg-white rounded-xl border border-gray-200
                shadow-sm p-6 mb-5">

        <div class="flex items-start gap-4">

            <div class="w-12 h-12
                        rounded-xl
                        bg-green-50
                        text-[#006400]
                        flex items-center
                        justify-center
                        flex-shrink-0">

                <i class="fas fa-chart-column text-xl"></i>

            </div>

            <div class="flex-1">

                <h2 class="text-lg font-bold text-gray-900">
                    Statistik Aset
                </h2>

                <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                    Ringkasan statistik persediaan tanah berdasarkan
                    lokasi, luas, peruntukan, dan skema pemanfaatan.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
        RINGKASAN UTAMA
    ====================================================== --}}

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-5">

        {{-- TOTAL ASET --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[10px] font-semibold
                              uppercase tracking-wide
                              text-gray-400">

                        Total Aset

                    </p>

                    <h3 class="text-2xl font-bold
                               text-gray-900 mt-2">

                        24

                    </h3>

                    <p class="text-[10px] text-gray-500 mt-1">
                        Persediaan tanah
                    </p>

                </div>

                <div class="w-10 h-10 rounded-lg
                            bg-green-50
                            text-[#006400]
                            flex items-center justify-center">

                    <i class="fas fa-database"></i>

                </div>

            </div>

        </div>


        {{-- TOTAL LUAS --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[10px] font-semibold
                              uppercase tracking-wide
                              text-gray-400">

                        Total Luas

                    </p>

                    <h3 class="text-2xl font-bold
                               text-gray-900 mt-2">

                        1.250,75

                    </h3>

                    <p class="text-[10px] text-gray-500 mt-1">
                        Hektare
                    </p>

                </div>

                <div class="w-10 h-10 rounded-lg
                            bg-blue-50
                            text-blue-600
                            flex items-center justify-center">

                    <i class="fas fa-vector-square"></i>

                </div>

            </div>

        </div>


        {{-- WILAYAH --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[10px] font-semibold
                              uppercase tracking-wide
                              text-gray-400">

                        Wilayah

                    </p>

                    <h3 class="text-2xl font-bold
                               text-gray-900 mt-2">

                        8

                    </h3>

                    <p class="text-[10px] text-gray-500 mt-1">
                        Provinsi
                    </p>

                </div>

                <div class="w-10 h-10 rounded-lg
                            bg-orange-50
                            text-orange-500
                            flex items-center justify-center">

                    <i class="fas fa-map-location-dot"></i>

                </div>

            </div>

        </div>


        {{-- PERUNTUKAN --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[10px] font-semibold
                              uppercase tracking-wide
                              text-gray-400">

                        Peruntukan

                    </p>

                    <h3 class="text-2xl font-bold
                               text-gray-900 mt-2">

                        3

                    </h3>

                    <p class="text-[10px] text-gray-500 mt-1">
                        Kategori utama
                    </p>

                </div>

                <div class="w-10 h-10 rounded-lg
                            bg-purple-50
                            text-purple-600
                            flex items-center justify-center">

                    <i class="fas fa-layer-group"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        ANALISIS DATA
    ====================================================== --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">


        {{-- =================================================
            BERDASARKAN PERUNTUKAN
        ================================================== --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm overflow-hidden">

            <div class="px-5 py-4
                        border-b border-gray-100">

                <h2 class="text-sm font-bold text-gray-900">
                    Sebaran Berdasarkan Peruntukan
                </h2>

                <p class="text-[9px] text-gray-400 mt-1">
                    Distribusi aset berdasarkan peruntukan tanah.
                </p>

            </div>


            <div class="p-5 space-y-5">


                {{-- INDUSTRI --}}

                <div>

                    <div class="flex items-center
                                justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-7 h-7
                                         rounded-lg
                                         bg-blue-50
                                         text-blue-600
                                         flex items-center
                                         justify-center">

                                <i class="fas fa-industry text-[10px]"></i>

                            </span>

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-700">

                                Industri

                            </span>

                        </div>

                        <span class="text-[10px]
                                     font-bold
                                     text-gray-900">

                            10 aset

                        </span>

                    </div>


                    <div class="w-full h-2
                                rounded-full
                                bg-gray-100
                                overflow-hidden">

                        <div class="h-full
                                    rounded-full
                                    bg-blue-500"
                             style="width: 42%">
                        </div>

                    </div>

                    <p class="text-[8px] text-gray-400 mt-1">
                        42% dari total aset
                    </p>

                </div>


                {{-- PERTANIAN --}}

                <div>

                    <div class="flex items-center
                                justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-7 h-7
                                         rounded-lg
                                         bg-green-50
                                         text-green-600
                                         flex items-center
                                         justify-center">

                                <i class="fas fa-wheat-awn text-[10px]"></i>

                            </span>

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-700">

                                Pertanian

                            </span>

                        </div>

                        <span class="text-[10px]
                                     font-bold
                                     text-gray-900">

                            8 aset

                        </span>

                    </div>


                    <div class="w-full h-2
                                rounded-full
                                bg-gray-100
                                overflow-hidden">

                        <div class="h-full
                                    rounded-full
                                    bg-green-500"
                             style="width: 33%">
                        </div>

                    </div>

                    <p class="text-[8px] text-gray-400 mt-1">
                        33% dari total aset
                    </p>

                </div>


                {{-- PERUMAHAN --}}

                <div>

                    <div class="flex items-center
                                justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-7 h-7
                                         rounded-lg
                                         bg-orange-50
                                         text-orange-500
                                         flex items-center
                                         justify-center">

                                <i class="fas fa-house text-[10px]"></i>

                            </span>

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-700">

                                Perumahan

                            </span>

                        </div>

                        <span class="text-[10px]
                                     font-bold
                                     text-gray-900">

                            6 aset

                        </span>

                    </div>


                    <div class="w-full h-2
                                rounded-full
                                bg-gray-100
                                overflow-hidden">

                        <div class="h-full
                                    rounded-full
                                    bg-orange-500"
                             style="width: 25%">
                        </div>

                    </div>

                    <p class="text-[8px] text-gray-400 mt-1">
                        25% dari total aset
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
            BERDASARKAN SKEMA
        ================================================== --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm overflow-hidden">

            <div class="px-5 py-4
                        border-b border-gray-100">

                <h2 class="text-sm font-bold text-gray-900">
                    Sebaran Berdasarkan Skema
                </h2>

                <p class="text-[9px] text-gray-400 mt-1">
                    Distribusi aset berdasarkan skema pemanfaatan.
                </p>

            </div>


            <div class="p-5 space-y-5">


                {{-- SEWA --}}

                <div>

                    <div class="flex items-center
                                justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-7 h-7
                                         rounded-lg
                                         bg-blue-50
                                         text-blue-600
                                         flex items-center
                                         justify-center">

                                <i class="fas fa-file-contract text-[10px]"></i>

                            </span>

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-700">

                                Sewa

                            </span>

                        </div>

                        <span class="text-[10px]
                                     font-bold
                                     text-gray-900">

                            9 aset

                        </span>

                    </div>


                    <div class="w-full h-2
                                rounded-full
                                bg-gray-100
                                overflow-hidden">

                        <div class="h-full
                                    rounded-full
                                    bg-blue-500"
                             style="width: 38%">
                        </div>

                    </div>

                    <p class="text-[8px] text-gray-400 mt-1">
                        38% dari total aset
                    </p>

                </div>


                {{-- KERJASAMA --}}

                <div>

                    <div class="flex items-center
                                justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-7 h-7
                                         rounded-lg
                                         bg-green-50
                                         text-green-600
                                         flex items-center
                                         justify-center">

                                <i class="fas fa-handshake text-[10px]"></i>

                            </span>

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-700">

                                Kerjasama

                            </span>

                        </div>

                        <span class="text-[10px]
                                     font-bold
                                     text-gray-900">

                            8 aset

                        </span>

                    </div>


                    <div class="w-full h-2
                                rounded-full
                                bg-gray-100
                                overflow-hidden">

                        <div class="h-full
                                    rounded-full
                                    bg-green-500"
                             style="width: 33%">
                        </div>

                    </div>

                    <p class="text-[8px] text-gray-400 mt-1">
                        33% dari total aset
                    </p>

                </div>


                {{-- PEMANFAATAN --}}

                <div>

                    <div class="flex items-center
                                justify-between mb-2">

                        <div class="flex items-center gap-2">

                            <span class="w-7 h-7
                                         rounded-lg
                                         bg-orange-50
                                         text-orange-500
                                         flex items-center
                                         justify-center">

                                <i class="fas fa-building text-[10px]"></i>

                            </span>

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-700">

                                Pemanfaatan

                            </span>

                        </div>

                        <span class="text-[10px]
                                     font-bold
                                     text-gray-900">

                            7 aset

                        </span>

                    </div>


                    <div class="w-full h-2
                                rounded-full
                                bg-gray-100
                                overflow-hidden">

                        <div class="h-full
                                    rounded-full
                                    bg-orange-500"
                             style="width: 29%">
                        </div>

                    </div>

                    <p class="text-[8px] text-gray-400 mt-1">
                        29% dari total aset
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        RINGKASAN WILAYAH
    ====================================================== --}}

    <div class="bg-white rounded-xl
                border border-gray-200
                shadow-sm overflow-hidden">

        <div class="px-5 py-4
                    border-b border-gray-100
                    flex items-center
                    justify-between">

            <div>

                <h2 class="text-sm font-bold text-gray-900">
                    Ringkasan Sebaran Wilayah
                </h2>

                <p class="text-[9px] text-gray-400 mt-1">
                    Ringkasan jumlah aset berdasarkan wilayah.
                </p>

            </div>

            <a href="{{ route('admin.aset.wilayah') }}"
               class="text-[9px]
                      font-semibold
                      text-[#006400]
                      hover:underline">

                Lihat Wilayah

                <i class="fas fa-arrow-right ml-1"></i>

            </a>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50
                              border-b border-gray-200">

                    <tr>

                        <th class="px-5 py-3
                                   text-[9px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-gray-500">

                            Provinsi

                        </th>

                        <th class="px-5 py-3
                                   text-[9px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-gray-500">

                            Jumlah Aset

                        </th>

                        <th class="px-5 py-3
                                   text-[9px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-gray-500">

                            Total Luas

                        </th>

                        <th class="px-5 py-3
                                   text-[9px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-gray-500">

                            Persentase

                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-800">

                                Jawa Tengah

                            </span>

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            10 aset

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            580,75 Ha

                        </td>

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">

                                <div class="w-24 h-1.5
                                            bg-gray-100
                                            rounded-full
                                            overflow-hidden">

                                    <div class="h-full
                                                bg-[#006400]
                                                rounded-full"
                                         style="width:42%">
                                    </div>

                                </div>

                                <span class="text-[9px]
                                             font-semibold
                                             text-gray-600">

                                    42%

                                </span>

                            </div>

                        </td>

                    </tr>


                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-800">

                                Sumatera Selatan

                            </span>

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            6 aset

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            320,50 Ha

                        </td>

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">

                                <div class="w-24 h-1.5
                                            bg-gray-100
                                            rounded-full
                                            overflow-hidden">

                                    <div class="h-full
                                                bg-[#006400]
                                                rounded-full"
                                         style="width:25%">
                                    </div>

                                </div>

                                <span class="text-[9px]
                                             font-semibold
                                             text-gray-600">

                                    25%

                                </span>

                            </div>

                        </td>

                    </tr>


                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-800">

                                Papua Selatan

                            </span>

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            4 aset

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            225,00 Ha

                        </td>

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">

                                <div class="w-24 h-1.5
                                            bg-gray-100
                                            rounded-full
                                            overflow-hidden">

                                    <div class="h-full
                                                bg-[#006400]
                                                rounded-full"
                                         style="width:17%">
                                    </div>

                                </div>

                                <span class="text-[9px]
                                             font-semibold
                                             text-gray-600">

                                    17%

                                </span>

                            </div>

                        </td>

                    </tr>


                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            <span class="text-[10px]
                                         font-semibold
                                         text-gray-800">

                                Wilayah Lainnya

                            </span>

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            4 aset

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            124,50 Ha

                        </td>

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">

                                <div class="w-24 h-1.5
                                            bg-gray-100
                                            rounded-full
                                            overflow-hidden">

                                    <div class="h-full
                                                bg-[#006400]
                                                rounded-full"
                                         style="width:16%">
                                    </div>

                                </div>

                                <span class="text-[9px]
                                             font-semibold
                                             text-gray-600">

                                    16%

                                </span>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- FOOTER --}}

        <div class="px-5 py-3
                    border-t border-gray-100
                    flex items-center
                    justify-between">

            <p class="text-[8px] text-gray-400">

                Data statistik menggunakan data dummy
                untuk kebutuhan antarmuka.

            </p>

            <a href="{{ route('admin.aset.index') }}"
               class="text-[9px]
                      font-semibold
                      text-[#006400]
                      hover:underline">

                Kelola seluruh aset

                <i class="fas fa-arrow-right ml-1"></i>

            </a>

        </div>

    </div>

</div>

@endsection