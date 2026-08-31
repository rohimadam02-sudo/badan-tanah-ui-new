@extends('layouts.admin')

@section('title', 'Status Tanah')

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
        HEADER STATUS
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

                <i class="fas fa-circle-info text-xl"></i>

            </div>

            <div class="flex-1">

                <h2 class="text-lg font-bold text-gray-900">
                    Status Tanah
                </h2>

                <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                    Informasi status aset persediaan tanah
                    berdasarkan kondisi dan tahap pengelolaannya.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
        RINGKASAN STATUS
    ====================================================== --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">

        {{-- TERSEDIA --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[10px] font-semibold
                              uppercase tracking-wide
                              text-gray-400">

                        Tersedia

                    </p>

                    <h3 class="text-2xl font-bold
                               text-gray-900 mt-2">

                        12

                    </h3>

                    <p class="text-[10px] text-gray-500 mt-1">
                        Aset siap dimanfaatkan
                    </p>

                </div>

                <div class="w-10 h-10 rounded-lg
                            bg-green-50
                            text-green-600
                            flex items-center justify-center">

                    <i class="fas fa-circle-check"></i>

                </div>

            </div>

        </div>


        {{-- DALAM PENGEMBANGAN --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[10px] font-semibold
                              uppercase tracking-wide
                              text-gray-400">

                        Dalam Pengembangan

                    </p>

                    <h3 class="text-2xl font-bold
                               text-gray-900 mt-2">

                        7

                    </h3>

                    <p class="text-[10px] text-gray-500 mt-1">
                        Aset dalam tahap pengembangan
                    </p>

                </div>

                <div class="w-10 h-10 rounded-lg
                            bg-blue-50
                            text-blue-600
                            flex items-center justify-center">

                    <i class="fas fa-chart-line"></i>

                </div>

            </div>

        </div>


        {{-- DALAM PROSES --}}

        <div class="bg-white rounded-xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[10px] font-semibold
                              uppercase tracking-wide
                              text-gray-400">

                        Dalam Proses

                    </p>

                    <h3 class="text-2xl font-bold
                               text-gray-900 mt-2">

                        5

                    </h3>

                    <p class="text-[10px] text-gray-500 mt-1">
                        Aset dalam proses pengelolaan
                    </p>

                </div>

                <div class="w-10 h-10 rounded-lg
                            bg-orange-50
                            text-orange-500
                            flex items-center justify-center">

                    <i class="fas fa-clock"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        DAFTAR STATUS ASET
    ====================================================== --}}

    <div class="bg-white rounded-xl
                border border-gray-200
                shadow-sm overflow-hidden">

        {{-- HEADER TABLE --}}

        <div class="px-5 py-4
                    border-b border-gray-100
                    flex items-center justify-between">

            <div>

                <h2 class="text-sm font-bold text-gray-900">
                    Daftar Status Aset
                </h2>

                <p class="text-[9px] text-gray-400 mt-1">
                    Ringkasan status aset persediaan tanah.
                </p>

            </div>

            <a href="{{ route('admin.aset.index') }}"
               class="px-3 py-1.5
                      bg-[#006400]
                      hover:bg-[#005500]
                      text-white
                      rounded-md
                      text-[9px]
                      font-semibold
                      transition">

                <i class="fas fa-database mr-1"></i>

                Lihat Data Aset

            </a>

        </div>


        {{-- TABLE --}}

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

                            Lokasi Aset

                        </th>

                        <th class="px-5 py-3
                                   text-[9px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-gray-500">

                            Luas

                        </th>

                        <th class="px-5 py-3
                                   text-[9px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-gray-500">

                            Peruntukan

                        </th>

                        <th class="px-5 py-3
                                   text-[9px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-gray-500">

                            Skema

                        </th>

                        <th class="px-5 py-3
                                   text-[9px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-gray-500">

                            Status

                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">


                    {{-- =================================================
                        DATA DUMMY 1
                    ================================================== --}}

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            <p class="text-[10px]
                                      font-semibold
                                      text-gray-800">

                                Kawasan Industri Kendal

                            </p>

                            <p class="text-[9px]
                                      text-gray-400 mt-1">

                                Jawa Tengah

                            </p>

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            250,00 Ha

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            Industri

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            Kerjasama

                        </td>

                        <td class="px-5 py-4">

                            <span class="inline-flex
                                         items-center
                                         gap-1
                                         px-2 py-1
                                         rounded-full
                                         bg-green-50
                                         text-green-700
                                         text-[8px]
                                         font-semibold">

                                <span class="w-1.5 h-1.5
                                             rounded-full
                                             bg-green-500"></span>

                                Tersedia

                            </span>

                        </td>

                    </tr>


                    {{-- =================================================
                        DATA DUMMY 2
                    ================================================== --}}

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            <p class="text-[10px]
                                      font-semibold
                                      text-gray-800">

                                Kawasan Pertanian Demak

                            </p>

                            <p class="text-[9px]
                                      text-gray-400 mt-1">

                                Jawa Tengah

                            </p>

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            180,50 Ha

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            Pertanian

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            Pemanfaatan

                        </td>

                        <td class="px-5 py-4">

                            <span class="inline-flex
                                         items-center
                                         gap-1
                                         px-2 py-1
                                         rounded-full
                                         bg-blue-50
                                         text-blue-600
                                         text-[8px]
                                         font-semibold">

                                <span class="w-1.5 h-1.5
                                             rounded-full
                                             bg-blue-500"></span>

                                Dalam Pengembangan

                            </span>

                        </td>

                    </tr>


                    {{-- =================================================
                        DATA DUMMY 3
                    ================================================== --}}

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-5 py-4">

                            <p class="text-[10px]
                                      font-semibold
                                      text-gray-800">

                                Kawasan Perumahan
                                Sumatera Selatan

                            </p>

                            <p class="text-[9px]
                                      text-gray-400 mt-1">

                                Sumatera Selatan

                            </p>

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            125,75 Ha

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            Perumahan

                        </td>

                        <td class="px-5 py-4
                                   text-[10px]
                                   text-gray-600">

                            Sewa

                        </td>

                        <td class="px-5 py-4">

                            <span class="inline-flex
                                         items-center
                                         gap-1
                                         px-2 py-1
                                         rounded-full
                                         bg-orange-50
                                         text-orange-600
                                         text-[8px]
                                         font-semibold">

                                <span class="w-1.5 h-1.5
                                             rounded-full
                                             bg-orange-500"></span>

                                Dalam Proses

                            </span>

                        </td>

                    </tr>


                </tbody>

            </table>

        </div>


        {{-- =====================================================
            FOOTER
        ====================================================== --}}

        <div class="px-5 py-3
                    border-t border-gray-100
                    flex items-center
                    justify-between">

            <p class="text-[8px] text-gray-400">

                Data status menggunakan data dummy
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