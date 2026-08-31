@extends('layouts.admin')

@section('title', 'Edit Lowongan')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <div class="flex flex-col sm:flex-row
                sm:items-center sm:justify-between
                gap-4 mb-8">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl
                        bg-[#0B2A4A]
                        flex items-center justify-center
                        shadow-sm">

                <i class="fas fa-briefcase
                          text-white text-lg"></i>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Edit Lowongan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Perbarui informasi peluang karier
                    Badan Bank Tanah.
                </p>

            </div>

        </div>


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
                            bg-blue-50
                            flex items-center
                            justify-center">

                    <i class="fas fa-pen-to-square
                              text-[#0B2A4A]"></i>

                </div>

                <div>

                    <h2 class="text-base font-bold
                               text-gray-900">

                        Informasi Lowongan

                    </h2>

                    <p class="text-xs text-gray-500 mt-1">

                        Pastikan informasi yang diperbarui
                        sudah sesuai sebelum disimpan.

                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
            FORM
        ================================================== --}}
        <form
            action="{{ route('admin.karier.update', $karier->id) }}"
            method="POST">

            @csrf
            @method('PUT')


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
                        value="{{ old('judul', $karier->judul) }}"
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4 py-3
                               text-sm
                               text-gray-900
                               placeholder-gray-400
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#0B2A4A]/20
                               focus:border-[#0B2A4A]
                               transition"
                        placeholder="Contoh: Analis Pertanahan"
                        required>

                    @error('judul')
                        <p class="text-xs
                                  text-red-600
                                  mt-2">

                            {{ $message }}

                        </p>
                    @enderror

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
                            value="{{ old('lokasi', $karier->lokasi) }}"
                            class="w-full
                                   border border-gray-300
                                   rounded-xl
                                   pl-11 pr-4 py-3
                                   text-sm
                                   text-gray-900
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-[#0B2A4A]/20
                                   focus:border-[#0B2A4A]
                                   transition"
                            placeholder="Contoh: Jakarta"
                            required>

                    </div>

                    @error('lokasi')
                        <p class="text-xs
                                  text-red-600
                                  mt-2">

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
                               text-sm
                               text-gray-900
                               bg-white
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#0B2A4A]/20
                               focus:border-[#0B2A4A]
                               transition"
                        required>

                        <option value="Buka"
                            {{ old('status', $karier->status) === 'Buka' ? 'selected' : '' }}>

                            Buka

                        </option>

                        <option value="Tutup"
                            {{ old('status', $karier->status) === 'Tutup' ? 'selected' : '' }}>

                            Tutup

                        </option>

                    </select>

                    <p class="text-xs text-gray-500 mt-2">

                        Gunakan status <strong>Buka</strong>
                        untuk lowongan yang masih menerima pelamar.

                    </p>

                    @error('status')
                        <p class="text-xs
                                  text-red-600
                                  mt-2">

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
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4 py-3
                               text-sm
                               text-gray-900
                               resize-y
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#0B2A4A]/20
                               focus:border-[#0B2A4A]
                               transition"
                        placeholder="Masukkan deskripsi lowongan..."
                        required>{{ old('deskripsi', $karier->deskripsi) }}</textarea>

                    @error('deskripsi')
                        <p class="text-xs
                                  text-red-600
                                  mt-2">

                            {{ $message }}

                        </p>
                    @enderror

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
                        class="w-full
                               border border-gray-300
                               rounded-xl
                               px-4 py-3
                               text-sm
                               text-gray-900
                               resize-y
                               focus:outline-none
                               focus:ring-2
                               focus:ring-[#0B2A4A]/20
                               focus:border-[#0B2A4A]
                               transition"
                        placeholder="Masukkan kualifikasi yang dibutuhkan..."
                        required>{{ old('kualifikasi', $karier->kualifikasi) }}</textarea>

                    @error('kualifikasi')
                        <p class="text-xs
                                  text-red-600
                                  mt-2">

                            {{ $message }}

                        </p>
                    @enderror

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

                    Batal

                </a>


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

                    <i class="fas fa-save text-xs"></i>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
        INFORMATION
    ====================================================== --}}
    <div class="mt-5
                flex items-start gap-2
                px-1">

        <i class="fas fa-circle-info
                  text-gray-400
                  text-xs
                  mt-0.5"></i>

        <p class="text-xs text-gray-400">

            Perubahan informasi lowongan akan diperbarui
            pada data karier yang dikelola melalui CMS.

        </p>

    </div>

</div>

@endsection