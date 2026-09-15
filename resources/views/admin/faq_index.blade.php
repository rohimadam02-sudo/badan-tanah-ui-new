@extends('layouts.admin')

@section('title', 'FAQ')

@section('content')

{{-- =========================================================
    HEADER
========================================================= --}}
<div class="mb-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-[#0B2A4A]
                            flex items-center justify-center shadow-sm">
                    <i class="fas fa-circle-question text-white text-lg"></i>
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        FAQ
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Kelola pertanyaan dan jawaban yang digunakan pada informasi FAQ Badan Bank Tanah.
                    </p>
                </div>

            </div>
        </div>

        {{-- TAMBAH FAQ --}}
        <a href="{{ route('admin.faq.create') }}"
           class="inline-flex items-center justify-center gap-2
                  bg-[#006400] hover:bg-[#005500]
                  text-white px-5 py-2.5 rounded-xl
                  font-semibold text-sm shadow-sm
                  hover:shadow-md transition">

            <i class="fas fa-plus text-xs"></i>

            <span>
                Tambah FAQ
            </span>

        </a>

    </div>

</div>


{{-- =========================================================
    INFO CARD
========================================================= --}}
<div class="bg-white rounded-2xl border border-gray-200
            shadow-sm p-5 mb-6">

    <div class="flex items-start gap-4">

        <div class="w-10 h-10 rounded-xl
                    bg-green-50 flex items-center justify-center
                    flex-shrink-0">

            <i class="fas fa-comments text-[#006400]"></i>

        </div>

        <div>

            <h2 class="text-sm font-bold text-gray-900">
                FAQ Badan Bank Tanah
            </h2>

            <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                Pertanyaan yang dikelola di sini dapat digunakan sebagai
                basis informasi FAQ pada layanan chatbot umum Badan Bank Tanah.
            </p>

        </div>

    </div>

</div>


{{-- =========================================================
    STATISTIK
========================================================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">

    {{-- TOTAL FAQ --}}
    <div class="bg-white rounded-2xl border border-gray-200
                shadow-sm p-5">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Total FAQ
                </p>

                <p class="text-2xl font-bold text-gray-900 mt-2">
                    {{ $faqs->count() }}
                </p>

            </div>

            <div class="w-11 h-11 rounded-xl bg-blue-50
                        flex items-center justify-center">

                <i class="fas fa-list-check text-[#0B2A4A]"></i>

            </div>

        </div>

    </div>


    {{-- STATUS --}}
    <div class="bg-white rounded-2xl border border-gray-200
                shadow-sm p-5">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Status
                </p>

                <p class="text-sm font-bold text-[#006400] mt-3">
                    Aktif
                </p>

            </div>

            <div class="w-11 h-11 rounded-xl bg-green-50
                        flex items-center justify-center">

                <i class="fas fa-circle-check text-[#006400]"></i>

            </div>

        </div>

    </div>


    {{-- INFORMASI --}}
    <div class="bg-white rounded-2xl border border-gray-200
                shadow-sm p-5">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Modul
                </p>

                <p class="text-sm font-bold text-gray-900 mt-3">
                    Chatbot Umum
                </p>

            </div>

            <div class="w-11 h-11 rounded-xl bg-gray-100
                        flex items-center justify-center">

                <i class="fas fa-robot text-[#0B2A4A]"></i>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    DAFTAR FAQ
========================================================= --}}
<div class="bg-white rounded-2xl border border-gray-200
            shadow-sm overflow-hidden">

    {{-- HEADER TABLE --}}
    <div class="px-6 py-5 border-b border-gray-200">

        <div class="flex flex-col sm:flex-row
                    sm:items-center sm:justify-between gap-3">

            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Daftar FAQ
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Daftar pertanyaan dan jawaban yang tersedia.
                </p>

            </div>

            <div class="text-xs text-gray-500">
                {{ $faqs->count() }} data
            </div>

        </div>

    </div>


    {{-- TABLE --}}
    @if ($faqs->count())

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>

                        <th class="px-6 py-4 text-xs font-bold
                                   text-gray-500 uppercase tracking-wide">
                            #
                        </th>

                        <th class="px-6 py-4 text-xs font-bold
                                   text-gray-500 uppercase tracking-wide">
                            Pertanyaan
                        </th>

                        <th class="px-6 py-4 text-xs font-bold
                                   text-gray-500 uppercase tracking-wide">
                            Jawaban
                        </th>

                        <th class="px-6 py-4 text-xs font-bold
                                   text-gray-500 uppercase tracking-wide
                                   text-center">
                            Status
                        </th>

                        <th class="px-6 py-4 text-xs font-bold
                                   text-gray-500 uppercase tracking-wide
                                   text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach ($faqs as $faq)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- NOMOR --}}
                            <td class="px-6 py-5 align-top">

                                <span class="text-xs font-semibold text-gray-400">
                                    {{ $loop->iteration }}
                                </span>

                            </td>


                            {{-- PERTANYAAN --}}
                            <td class="px-6 py-5 align-top">

                                <div class="max-w-sm">

                                    <p class="font-semibold text-gray-900
                                              leading-relaxed">

                                        {{ $faq->pertanyaan }}

                                    </p>

                                </div>

                            </td>


                            {{-- JAWABAN --}}
                            <td class="px-6 py-5 align-top">

                                <div class="max-w-xl">

                                    <p class="text-sm text-gray-500
                                              leading-relaxed">

                                        {{ Str::limit($faq->jawaban, 120) }}

                                    </p>

                                </div>

                            </td>


                            {{-- STATUS --}}
                            <td class="px-6 py-5 align-top text-center">

                                <span class="inline-flex items-center gap-1.5
                                             px-2.5 py-1 rounded-full
                                             bg-green-50 text-[#006400]
                                             text-[11px] font-bold">

                                    <span class="w-1.5 h-1.5 rounded-full
                                                 bg-[#006400]"></span>

                                    Aktif

                                </span>

                            </td>


                            {{-- AKSI --}}
                            <td class="px-6 py-5 align-top">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                       class="w-9 h-9 rounded-lg
                                              border border-gray-200
                                              bg-white
                                              flex items-center justify-center
                                              text-[#0B2A4A]
                                              hover:bg-blue-50
                                              hover:border-blue-200
                                              transition"
                                       title="Edit FAQ">

                                        <i class="fas fa-pen text-xs"></i>

                                    </a>


                                    {{-- HAPUS --}}
                                    <form action="{{ route('admin.faq.destroy', $faq->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="w-9 h-9 rounded-lg
                                                       border border-gray-200
                                                       bg-white
                                                       flex items-center justify-center
                                                       text-red-600
                                                       hover:bg-red-50
                                                       hover:border-red-200
                                                       transition"
                                                title="Hapus FAQ">

                                            <i class="fas fa-trash-can text-xs"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        {{-- EMPTY STATE --}}
        <div class="py-20 px-6 text-center">

            <div class="w-16 h-16 mx-auto rounded-2xl
                        bg-gray-100 flex items-center justify-center">

                <i class="fas fa-circle-question
                          text-2xl text-gray-400"></i>

            </div>

            <h3 class="text-base font-bold text-gray-900 mt-5">
                Belum ada FAQ
            </h3>

            <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">
                Belum terdapat pertanyaan dan jawaban yang tersimpan.
                Tambahkan FAQ untuk mengisi informasi chatbot umum.
            </p>

            <a href="{{ route('admin.faq.create') }}"
               class="inline-flex items-center gap-2
                      mt-6 bg-[#006400]
                      hover:bg-[#005500]
                      text-white px-5 py-2.5
                      rounded-xl text-sm font-semibold
                      transition">

                <i class="fas fa-plus text-xs"></i>

                Tambah FAQ

            </a>

        </div>

    @endif

</div>

@endsection