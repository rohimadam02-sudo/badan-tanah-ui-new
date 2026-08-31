@extends('layouts.admin')

@section('title', 'Daftar Kontak')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <div class="flex flex-col lg:flex-row
                lg:items-center lg:justify-between
                gap-5 mb-8">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl
                        bg-[#0B2A4A]
                        flex items-center justify-center
                        shadow-sm">

                <i class="fas fa-envelope text-white text-lg"></i>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Daftar Kontak
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola pesan dan pertanyaan yang masuk
                    dari pengunjung website.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
        SUCCESS MESSAGE
    ====================================================== --}}
    @if (session('success'))

        <div class="mb-6 flex items-start gap-3
                    bg-green-50
                    border border-green-200
                    text-green-800
                    px-5 py-4
                    rounded-xl">

            <div class="w-8 h-8 rounded-lg
                        bg-green-100
                        flex items-center justify-center
                        flex-shrink-0">

                <i class="fas fa-check
                          text-green-700 text-sm"></i>

            </div>

            <div>

                <p class="text-sm font-bold">
                    Berhasil
                </p>

                <p class="text-xs text-green-700 mt-0.5">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- =====================================================
        STATISTIK
    ====================================================== --}}
    <div class="grid grid-cols-1
                sm:grid-cols-2
                lg:grid-cols-3
                gap-5 mb-8">

        {{-- TOTAL --}}
        <div class="bg-white rounded-2xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center
                        justify-between">

                <div>

                    <p class="text-xs font-semibold
                              uppercase tracking-wide
                              text-gray-500">

                        Total Pesan

                    </p>

                    <p class="text-2xl font-bold
                              text-gray-900 mt-2">

                        {{ $kontaks->count() }}

                    </p>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-blue-50
                            flex items-center
                            justify-center">

                    <i class="fas fa-envelope
                              text-[#0B2A4A]"></i>

                </div>

            </div>

        </div>


        {{-- BELUM DIBACA --}}
        <div class="bg-white rounded-2xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center
                        justify-between">

                <div>

                    <p class="text-xs font-semibold
                              uppercase tracking-wide
                              text-gray-500">

                        Belum Dibaca

                    </p>

                    <p class="text-2xl font-bold
                              text-orange-600 mt-2">

                        {{ $kontaks->where('is_read', 0)->count() }}

                    </p>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-orange-50
                            flex items-center
                            justify-center">

                    <i class="fas fa-envelope-open-text
                              text-orange-600"></i>

                </div>

            </div>

        </div>


        {{-- SUDAH DIBACA --}}
        <div class="bg-white rounded-2xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center
                        justify-between">

                <div>

                    <p class="text-xs font-semibold
                              uppercase tracking-wide
                              text-gray-500">

                        Sudah Dibaca

                    </p>

                    <p class="text-2xl font-bold
                              text-[#006400] mt-2">

                        {{ $kontaks->where('is_read', 1)->count() }}

                    </p>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-green-50
                            flex items-center
                            justify-center">

                    <i class="fas fa-envelope-circle-check
                              text-[#006400]"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        TABLE CARD
    ====================================================== --}}
    <div class="bg-white rounded-2xl
                border border-gray-200
                shadow-sm overflow-hidden">


        {{-- TABLE HEADER --}}
        <div class="px-6 py-5
                    border-b border-gray-200
                    flex flex-col sm:flex-row
                    sm:items-center
                    sm:justify-between
                    gap-3">

            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Pesan Masuk
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Daftar pesan yang dikirimkan pengunjung
                    melalui halaman kontak.
                </p>

            </div>

            <div class="text-xs text-gray-500">

                {{ $kontaks->count() }} pesan

            </div>

        </div>


        {{-- =================================================
            TABLE
        ================================================== --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-gray-50
                              border-b border-gray-200">

                    <tr>

                        <th class="px-6 py-4
                                   font-bold text-gray-600">

                            Pengirim

                        </th>

                        <th class="px-6 py-4
                                   font-bold text-gray-600">

                            Kontak

                        </th>

                        <th class="px-6 py-4
                                   font-bold text-gray-600">

                            Status

                        </th>

                        <th class="px-6 py-4
                                   font-bold text-gray-600">

                            Aksi

                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($kontaks as $kontak)

                        <tr class="hover:bg-gray-50
                                   transition">


                            {{-- =================================
                                PENGIRIM
                            ================================== --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10
                                                rounded-xl
                                                bg-blue-50
                                                flex items-center
                                                justify-center
                                                flex-shrink-0">

                                        <i class="fas fa-user
                                                  text-[#0B2A4A]"></i>

                                    </div>

                                    <div>

                                        <p class="font-bold
                                                  text-gray-900">

                                            {{ $kontak->nama }}

                                        </p>

                                        <p class="text-xs
                                                  text-gray-400 mt-1">

                                            Pesan dari pengunjung

                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- =================================
                                KONTAK
                            ================================== --}}
                            <td class="px-6 py-5">

                                <div class="space-y-1">

                                    <div class="flex items-center
                                                gap-2
                                                text-gray-600">

                                        <i class="fas fa-envelope
                                                  text-gray-400
                                                  text-xs"></i>

                                        <span>
                                            {{ $kontak->email }}
                                        </span>

                                    </div>


                                    @if ($kontak->telepon)

                                        <div class="flex items-center
                                                    gap-2
                                                    text-gray-500">

                                            <i class="fas fa-phone
                                                      text-gray-400
                                                      text-xs"></i>

                                            <span>
                                                {{ $kontak->telepon }}
                                            </span>

                                        </div>

                                    @endif

                                </div>

                            </td>


                            {{-- =================================
                                STATUS
                            ================================== --}}
                            <td class="px-6 py-5">

                                @if ($kontak->is_read == 1)

                                    <span class="inline-flex
                                                 items-center
                                                 gap-1.5
                                                 px-3 py-1.5
                                                 rounded-full
                                                 bg-green-50
                                                 text-[#006400]
                                                 text-xs
                                                 font-bold">

                                        <span class="w-1.5 h-1.5
                                                     rounded-full
                                                     bg-[#006400]"></span>

                                        Dibaca

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 items-center
                                                 gap-1.5
                                                 px-3 py-1.5
                                                 rounded-full
                                                 bg-orange-50
                                                 text-orange-700
                                                 text-xs
                                                 font-bold">

                                        <span class="w-1.5 h-1.5
                                                     rounded-full
                                                     bg-orange-500"></span>

                                        Belum Dibaca

                                    </span>

                                @endif

                            </td>


                            {{-- =================================
                                AKSI
                            ================================== --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2">


                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('admin.kontak.show', $kontak->id) }}"
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               gap-2
                                               px-3.5 py-2
                                               rounded-lg
                                               bg-blue-50
                                               text-blue-700
                                               hover:bg-blue-100
                                               text-xs
                                               font-bold
                                               transition">

                                        <i class="fas fa-eye text-xs"></i>

                                        Detail

                                    </a>


                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('admin.kontak.destroy', $kontak->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex
                                                   items-center
                                                   justify-center
                                                   w-9 h-9
                                                   rounded-lg
                                                   bg-red-50
                                                   text-red-600
                                                   hover:bg-red-100
                                                   transition"
                                            title="Hapus">

                                            <i class="fas fa-trash
                                                      text-xs"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        {{-- =================================
                            EMPTY STATE
                        ================================== --}}
                        <tr>

                            <td colspan="4"
                                class="px-6 py-16">

                                <div class="flex flex-col
                                            items-center
                                            justify-center
                                            text-center">

                                    <div class="w-16 h-16
                                                rounded-2xl
                                                bg-gray-100
                                                flex items-center
                                                justify-center
                                                mb-4">

                                        <i class="fas fa-inbox
                                                  text-gray-400
                                                  text-xl"></i>

                                    </div>

                                    <h3 class="text-base
                                               font-bold
                                               text-gray-900">

                                        Belum Ada Pesan

                                    </h3>

                                    <p class="text-sm
                                              text-gray-500
                                              mt-1
                                              max-w-md">

                                        Belum terdapat pesan yang masuk
                                        dari pengunjung website.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
        FOOTNOTE
    ====================================================== --}}
    <div class="mt-5 flex items-start gap-2 px-1">

        <i class="fas fa-circle-info
                  text-gray-400
                  text-xs
                  mt-0.5"></i>

        <p class="text-xs text-gray-400 leading-relaxed">

            Pesan yang belum dibaca ditandai dengan status
            <strong>Belum Dibaca</strong>. Buka detail pesan
            untuk melihat informasi lengkap dari pengunjung.

        </p>

    </div>

</div>

@endsection