@extends('layouts.admin')

@section('title', 'Tambah Lowongan')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row
                sm:items-center sm:justify-between
                gap-4 mb-8">

        <div class="flex items-center gap-4">

            {{-- ICON --}}
            <div class="w-12 h-12 rounded-2xl
                        bg-[#0B2A4A]
                        flex items-center justify-center
                        shadow-sm">

                <i class="fas fa-briefcase
                          text-white text-lg"></i>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Tambah Lowongan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Tambahkan informasi peluang karier
                    Badan Bank Tanah.
                </p>

            </div>

        </div>


        {{-- KEMBALI --}}
        <a href="{{ route('admin.karier.index') }}"
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


    {{-- =====================================================
        INFORMATION CARD
    ====================================================== --}}
    <div class="bg-white rounded-2xl
                border border-gray-200
                shadow-sm p-5 mb-6">

        <div class="flex items-start gap-4">

            <div class="w-10 h-10 rounded-xl
                        bg-blue-50
                        flex items-center justify-center
                        flex-shrink-0">

                <i class="fas fa-briefcase
                          text-[#0B2A4A]"></i>

            </div>

            <div>

                <h2 class="text-sm font-bold text-gray-900">
                    Informasi Karier
                </h2>

                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                    Tambahkan informasi lowongan secara jelas dan
                    terstruktur agar informasi peluang karier
                    Badan Bank Tanah dapat dikelola dengan baik
                    melalui CMS.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
        FORM CARD
    ====================================================== --}}
    <div class="bg-white rounded-2xl
                border border-gray-200
                shadow-sm overflow-hidden">


        {{-- CARD HEADER --}}
        <div class="px-6 py-5
                    border-b border-gray-200
                    bg-gray-50">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl
                            bg-green-50
                            flex items-center justify-center">

                    <i class="fas fa-plus
                              text-[#006400]"></i>

                </div>

                <div>

                    <h2 class="text-base font-bold text-gray-900">
                        Informasi Lowongan
                    </h2>

                    <p class="text-xs text-gray-500 mt-1">
                        Lengkapi seluruh informasi lowongan berikut.
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
            FORM
        ================================================== --}}
        <form
            action="{{ route('admin.karier.store') }}"
            method="POST">

            @csrf

            <div class="p-6 space-y-6">


                {{-- =================================================
                    JUDUL
                ================================================== --}}
                <div>

                    <label
                        for="judul"
                        class="block text-sm
                               font-bold text-gray-800 mb-2">

                        Judul Lowongan

                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        id="judul"
                        type="text"
                        name="judul"
                        value="{{ old('judul') }}"
                        placeholder="Contoh: Analis Pertanahan"
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4 py-3
                               text-sm text-gray-900
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#0B2A4A]/20
                               focus:border-[#0B2A4A]
                               transition"
                        required>

                    @error('judul')
                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-xs text-gray-400 mt-2">
                        Masukkan nama atau posisi lowongan
                        yang akan ditampilkan.
                    </p>

                </div>


                {{-- =================================================
                    LOKASI
                ================================================== --}}
                <div>

                    <label
                        for="lokasi"
                        class="block text-sm
                               font-bold text-gray-800 mb-2">

                        Lokasi

                        <span class="text-red-500">*</span>

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0
                                    flex items-center
                                    pl-4
                                    pointer-events-none">

                            <i class="fas fa-location-dot
                                      text-gray-400 text-sm"></i>

                        </div>

                        <input
                            id="lokasi"
                            type="text"
                            name="lokasi"
                            value="{{ old('lokasi') }}"
                            placeholder="Contoh: Jakarta"
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

                    @error('lokasi')
                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                    STATUS
                ================================================== --}}
                <div>

                    <label
                        for="status"
                        class="block text-sm
                               font-bold text-gray-800 mb-2">

                        Status Lowongan

                        <span class="text-red-500">*</span>

                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4 py-3
                               text-sm text-gray-900
                               bg-white
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#0B2A4A]/20
                               focus:border-[#0B2A4A]
                               transition"
                        required>

                        <option value="Buka"
                            {{ old('status', 'Buka') === 'Buka' ? 'selected' : '' }}>
                            Buka
                        </option>

                        <option value="Tutup"
                            {{ old('status') === 'Tutup' ? 'selected' : '' }}>
                            Tutup
                        </option>

                    </select>

                    <p class="text-xs text-gray-400 mt-2">
                        Pilih <strong>Buka</strong> apabila lowongan
                        masih tersedia untuk pelamar.
                    </p>

                    @error('status')
                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                    DESKRIPSI
                ================================================== --}}
                <div>

                    <label
                        for="deskripsi"
                        class="block text-sm
                               font-bold text-gray-800 mb-2">

                        Deskripsi

                        <span class="text-red-500">*</span>

                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="7"
                        placeholder="Jelaskan informasi mengenai posisi atau lowongan yang tersedia..."
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4 py-3
                               text-sm text-gray-900
                               placeholder-gray-400
                               resize-y
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#0B2A4A]/20
                               focus:border-[#0B2A4A]
                               transition"
                        required>{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-xs text-gray-400 mt-2">
                        Tuliskan deskripsi secara jelas dan informatif.
                    </p>

                </div>


                {{-- =================================================
                    KUALIFIKASI
                ================================================== --}}
                <div>

                    <label
                        for="kualifikasi"
                        class="block text-sm
                               font-bold text-gray-800 mb-2">

                        Kualifikasi

                        <span class="text-red-500">*</span>

                    </label>

                    <textarea
                        id="kualifikasi"
                        name="kualifikasi"
                        rows="6"
                        placeholder="Tuliskan kualifikasi atau persyaratan yang dibutuhkan..."
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4 py-3
                               text-sm text-gray-900
                               placeholder-gray-400
                               resize-y
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#0B2A4A]/20
                               focus:border-[#0B2A4A]
                               transition"
                        required>{{ old('kualifikasi') }}</textarea>

                    @error('kualifikasi')
                        <p class="text-xs text-red-600 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-xs text-gray-400 mt-2">
                        Masukkan kualifikasi yang dibutuhkan
                        untuk posisi tersebut.
                    </p>

                </div>

            </div>


            {{-- =================================================
                FOOTER FORM
            ================================================== --}}
            <div class="px-6 py-5
                        border-t border-gray-200
                        bg-gray-50
                        flex flex-col-reverse
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                        gap-3">

                {{-- BATAL --}}
                <a
                    href="{{ route('admin.karier.index') }}"
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

                    <i class="fas fa-xmark text-xs"></i>

                    Batal

                </a>


                {{-- SIMPAN --}}
                <button
                    type="submit"
                    class="inline-flex
                           items-center
                           justify-center
                           gap-2
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

                    Simpan Lowongan

                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
        INFORMATION FOOTNOTE
    ====================================================== --}}
    <div class="mt-5
                flex items-start gap-2
                px-1">

        <i class="fas fa-circle-info
                  text-gray-400
                  text-xs
                  mt-0.5"></i>

        <p class="text-xs text-gray-400 leading-relaxed">
            Pastikan informasi lowongan yang dimasukkan sudah benar
            dan sesuai dengan informasi resmi Badan Bank Tanah.
        </p>

    </div>

</div>

@endsection