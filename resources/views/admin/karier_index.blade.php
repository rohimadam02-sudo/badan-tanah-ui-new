@extends('layouts.admin')

@section('title', 'Karier')

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

                <i class="fas fa-briefcase text-white text-lg"></i>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Karier
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola informasi peluang karier dan lowongan kerja
                    Badan Bank Tanah.
                </p>

            </div>

        </div>


        <a href="{{ route('admin.karier.create') }}"
           class="inline-flex items-center justify-center
                  gap-2
                  bg-[#006400]
                  hover:bg-[#005500]
                  text-white
                  px-5 py-2.5
                  rounded-xl
                  text-sm font-bold
                  shadow-sm
                  hover:shadow-md
                  transition">

            <i class="fas fa-plus text-xs"></i>

            Tambah Lowongan

        </a>

    </div>


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

                        Total Lowongan

                    </p>

                    <p class="text-2xl font-bold
                              text-gray-900 mt-2">

                        {{ $kariers->count() }}

                    </p>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-blue-50
                            flex items-center justify-center">

                    <i class="fas fa-briefcase
                              text-[#0B2A4A]"></i>

                </div>

            </div>

        </div>


        {{-- AKTIF --}}
        <div class="bg-white rounded-2xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center
                        justify-between">

                <div>

                    <p class="text-xs font-semibold
                              uppercase tracking-wide
                              text-gray-500">

                        Lowongan Aktif

                    </p>

                    <p class="text-2xl font-bold
                              text-[#006400] mt-2">

                        {{ $kariers->where('status', 'Aktif')->count() }}

                    </p>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-green-50
                            flex items-center justify-center">

                    <i class="fas fa-circle-check
                              text-[#006400]"></i>

                </div>

            </div>

        </div>


        {{-- LOKASI --}}
        <div class="bg-white rounded-2xl
                    border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center
                        justify-between">

                <div>

                    <p class="text-xs font-semibold
                              uppercase tracking-wide
                              text-gray-500">

                        Lokasi

                    </p>

                    <p class="text-2xl font-bold
                              text-gray-900 mt-2">

                        {{ $kariers->pluck('lokasi')->filter()->unique()->count() }}

                    </p>

                </div>

                <div class="w-11 h-11 rounded-xl
                            bg-gray-100
                            flex items-center justify-center">

                    <i class="fas fa-location-dot
                              text-gray-600"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        TABLE
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
                    Daftar Lowongan
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Informasi peluang karier yang tersedia
                    pada Badan Bank Tanah.
                </p>

            </div>

            <div class="text-xs text-gray-500">

                {{ $kariers->count() }} lowongan

            </div>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-gray-50
                              border-b border-gray-200">

                    <tr>

                        <th class="px-6 py-4
                                   font-bold
                                   text-gray-600">

                            Posisi

                        </th>

                        <th class="px-6 py-4
                                   font-bold
                                   text-gray-600">

                            Lokasi

                        </th>

                        <th class="px-6 py-4
                                   font-bold
                                   text-gray-600">

                            Status

                        </th>

                        <th class="px-6 py-4
                                   font-bold
                                   text-gray-600">

                            Aksi

                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($kariers as $karier)

                        <tr class="hover:bg-gray-50
                                   transition">

                            {{-- POSISI --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10
                                                rounded-xl
                                                bg-blue-50
                                                flex items-center
                                                justify-center
                                                flex-shrink-0">

                                        <i class="fas fa-user-tie
                                                  text-[#0B2A4A]"></i>

                                    </div>

                                    <div>

                                        <p class="font-bold
                                                  text-gray-900">

                                            {{ $karier->judul }}

                                        </p>

                                        <p class="text-xs
                                                  text-gray-400 mt-1">

                                            Lowongan Badan Bank Tanah

                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- LOKASI --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2
                                            text-gray-600">

                                    <i class="fas fa-location-dot
                                              text-gray-400 text-xs"></i>

                                    <span>

                                        {{ $karier->lokasi ?: 'Tidak ditentukan' }}

                                    </span>

                                </div>

                            </td>


                            {{-- STATUS --}}
                            <td class="px-6 py-5">

                                @if ($karier->status === 'Aktif')

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

                                        Aktif

                                    </span>

                                @elseif ($karier->status === 'Tidak Aktif')

                                    <span class="inline-flex
                                                 items-center
                                                 gap-1.5
                                                 px-3 py-1.5
                                                 rounded-full
                                                 bg-gray-100
                                                 text-gray-600
                                                 text-xs
                                                 font-bold">

                                        <span class="w-1.5 h-1.5
                                                     rounded-full
                                                     bg-gray-400"></span>

                                        Tidak Aktif

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 items-center
                                                 gap-1.5
                                                 px-3 py-1.5
                                                 rounded-full
                                                 bg-blue-50
                                                 text-blue-700
                                                 text-xs
                                                 font-bold">

                                        {{ $karier->status }}

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2">

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.karier.edit', $karier->id) }}"
                                       class="inline-flex items-center
                                              justify-center
                                              w-9 h-9
                                              rounded-lg
                                              bg-blue-50
                                              text-blue-700
                                              hover:bg-blue-100
                                              transition"
                                       title="Edit">

                                        <i class="fas fa-pen text-xs"></i>

                                    </a>


                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('admin.karier.destroy', $karier->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center
                                                   justify-center
                                                   w-9 h-9
                                                   rounded-lg
                                                   bg-red-50
                                                   text-red-600
                                                   hover:bg-red-100
                                                   transition"
                                            title="Hapus">

                                            <i class="fas fa-trash text-xs"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        {{-- EMPTY STATE --}}
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

                                        <i class="fas fa-briefcase
                                                  text-gray-400
                                                  text-xl"></i>

                                    </div>

                                    <h3 class="text-base
                                               font-bold
                                               text-gray-900">

                                        Belum Ada Lowongan

                                    </h3>

                                    <p class="text-sm
                                              text-gray-500
                                              mt-1
                                              max-w-md">

                                        Belum terdapat informasi lowongan
                                        kerja yang tersedia.
                                        Tambahkan lowongan untuk mulai
                                        menampilkan informasi karier.

                                    </p>

                                    <a href="{{ route('admin.karier.create') }}"
                                       class="mt-5
                                              inline-flex
                                              items-center
                                              gap-2
                                              bg-[#006400]
                                              hover:bg-[#005500]
                                              text-white
                                              px-5 py-2.5
                                              rounded-xl
                                              text-sm font-bold
                                              transition">

                                        <i class="fas fa-plus text-xs"></i>

                                        Tambah Lowongan

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- FOOTNOTE --}}
    <div class="mt-5 flex items-start gap-2">

        <i class="fas fa-circle-info
                  text-gray-400 text-xs mt-0.5"></i>

        <p class="text-xs text-gray-400">

            Kelola informasi lowongan secara terstruktur agar
            informasi peluang karier Badan Bank Tanah mudah
            dipahami dan diperbarui melalui CMS.

        </p>

    </div>

</div>

@endsection