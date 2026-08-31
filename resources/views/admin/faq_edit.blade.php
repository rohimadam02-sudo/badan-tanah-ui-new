@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <div class="mb-8">

        <div class="flex flex-col sm:flex-row
                    sm:items-center sm:justify-between gap-4">

            <div class="flex items-center gap-3">

                {{-- ICON --}}
                <div class="w-11 h-11 rounded-xl
                            bg-[#0B2A4A]
                            flex items-center justify-center
                            shadow-sm">

                    <i class="fas fa-circle-question
                              text-white text-lg"></i>

                </div>

                <div>

                    <h1 class="text-2xl font-bold text-gray-900">
                        Edit FAQ
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui pertanyaan dan jawaban FAQ Badan Bank Tanah.
                    </p>

                </div>

            </div>


            {{-- KEMBALI --}}
            <a href="{{ route('admin.faq.index') }}"
               class="inline-flex items-center justify-center gap-2
                      px-4 py-2.5 rounded-xl
                      border border-gray-200
                      bg-white
                      text-sm font-semibold text-gray-600
                      hover:text-[#0B2A4A]
                      hover:bg-gray-50
                      transition">

                <i class="fas fa-arrow-left text-xs"></i>

                <span>
                    Kembali ke Daftar
                </span>

            </a>

        </div>

    </div>


    {{-- =====================================================
        INFO FAQ
    ====================================================== --}}
    <div class="bg-white rounded-2xl
                border border-gray-200
                shadow-sm p-5 mb-6">

        <div class="flex items-start gap-4">

            <div class="w-10 h-10 rounded-xl
                        bg-green-50
                        flex items-center justify-center
                        flex-shrink-0">

                <i class="fas fa-comments
                          text-[#006400]"></i>

            </div>

            <div>

                <h2 class="text-sm font-bold text-gray-900">
                    FAQ Badan Bank Tanah
                </h2>

                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                    FAQ digunakan sebagai sumber informasi umum pada
                    layanan chatbot Badan Bank Tanah. Pastikan pertanyaan
                    dan jawaban ditulis secara jelas, informatif, dan mudah
                    dipahami oleh pengunjung.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
        FORM EDIT
    ====================================================== --}}
    <div class="bg-white rounded-2xl
                border border-gray-200
                shadow-sm overflow-hidden">

        {{-- HEADER CARD --}}
        <div class="px-6 py-5
                    border-b border-gray-200">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Informasi FAQ
                    </h2>

                    <p class="text-xs text-gray-500 mt-1">
                        Ubah informasi FAQ pada formulir berikut.
                    </p>

                </div>

                {{-- STATUS --}}
                <span class="inline-flex items-center gap-1.5
                             px-3 py-1.5
                             rounded-full
                             bg-green-50
                             text-[#006400]
                             text-[11px]
                             font-bold">

                    <span class="w-1.5 h-1.5 rounded-full
                                 bg-[#006400]"></span>

                    Aktif

                </span>

            </div>

        </div>


        {{-- FORM --}}
        <form action="{{ route('admin.faq.update', $faq->id) }}"
              method="POST">

            @csrf
            @method('PUT')


            <div class="p-6 space-y-6">


                {{-- =================================================
                    PERTANYAAN
                ================================================== --}}
                <div>

                    <label for="pertanyaan"
                           class="block text-sm font-bold
                                  text-gray-800 mb-2">

                        Pertanyaan

                        <span class="text-red-500">
                            *
                        </span>

                    </label>


                    <div class="relative">

                        <div class="absolute left-0 top-0
                                    h-full w-11
                                    flex items-center justify-center
                                    text-gray-400
                                    pointer-events-none">

                            <i class="fas fa-question text-sm"></i>

                        </div>


                        <input
                            type="text"
                            id="pertanyaan"
                            name="pertanyaan"
                            value="{{ old('pertanyaan', $faq->pertanyaan) }}"
                            placeholder="Masukkan pertanyaan FAQ"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   pl-11 pr-4 py-3
                                   text-sm text-gray-900
                                   placeholder-gray-400
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-[#0B2A4A]/20
                                   focus:border-[#0B2A4A]
                                   transition"
                            required>

                    </div>


                    @error('pertanyaan')

                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>

                    @enderror


                    <p class="text-xs text-gray-400 mt-2">
                        Gunakan pertanyaan yang singkat, jelas, dan sesuai
                        dengan informasi yang dibutuhkan pengunjung.
                    </p>

                </div>



                {{-- =================================================
                    JAWABAN
                ================================================== --}}
                <div>

                    <label for="jawaban"
                           class="block text-sm font-bold
                                  text-gray-800 mb-2">

                        Jawaban

                        <span class="text-red-500">
                            *
                        </span>

                    </label>


                    <div class="relative">

                        <div class="absolute left-0 top-0
                                    h-12 w-11
                                    flex items-center justify-center
                                    text-gray-400
                                    pointer-events-none">

                            <i class="fas fa-message text-sm"></i>

                        </div>


                        <textarea
                            id="jawaban"
                            name="jawaban"
                            rows="8"
                            placeholder="Masukkan jawaban FAQ"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   pl-11 pr-4 py-3
                                   text-sm text-gray-900
                                   placeholder-gray-400
                                   resize-y
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-[#0B2A4A]/20
                                   focus:border-[#0B2A4A]
                                   transition"
                            required>{{ old('jawaban', $faq->jawaban) }}</textarea>

                    </div>


                    @error('jawaban')

                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>

                    @enderror


                    <p class="text-xs text-gray-400 mt-2">
                        Berikan jawaban yang informatif dan mudah dipahami
                        oleh masyarakat.
                    </p>

                </div>

            </div>


            {{-- =================================================
                FOOTER FORM
            ================================================== --}}
            <div class="px-6 py-5
                        bg-gray-50
                        border-t border-gray-200">

                <div class="flex flex-col-reverse
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                            gap-3">

                    {{-- CANCEL --}}
                    <a href="{{ route('admin.faq.index') }}"
                       class="inline-flex items-center
                              justify-center gap-2
                              px-5 py-2.5
                              rounded-xl
                              border border-gray-200
                              bg-white
                              text-sm font-semibold
                              text-gray-600
                              hover:bg-gray-100
                              transition">

                        <i class="fas fa-xmark text-xs"></i>

                        Batal

                    </a>


                    {{-- UPDATE --}}
                    <button type="submit"
                            class="inline-flex items-center
                                   justify-center gap-2
                                   px-6 py-2.5
                                   rounded-xl
                                   bg-[#006400]
                                   hover:bg-[#005500]
                                   text-white
                                   text-sm font-bold
                                   shadow-sm
                                   hover:shadow-md
                                   transition">

                        <i class="fas fa-floppy-disk text-xs"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- =====================================================
        FOOTNOTE
    ====================================================== --}}
    <div class="mt-5 flex items-start gap-2">

        <i class="fas fa-circle-info
                  text-gray-400 text-xs mt-0.5"></i>

        <p class="text-xs text-gray-400 leading-relaxed">
            Pastikan informasi yang diperbarui tetap sesuai dengan
            informasi resmi Badan Bank Tanah sebelum disimpan.
        </p>

    </div>

</div>

@endsection