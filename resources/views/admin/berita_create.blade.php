@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')

@php
    $role = auth()->user()->role;
@endphp

<style>
    /* =========================================================
       SMOOTH VALIDATION
    ========================================================= */
    .field-error {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 0.25rem;
        opacity: 0;
        transform: translateY(-5px);
        transition: all 0.3s ease;
        display: none;
    }
    .field-error.show {
        opacity: 1;
        transform: translateY(0);
        display: block;
    }
    .field-error.hidden {
        display: none;
    }
    
    .input-error {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }
    .input-error:focus {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
    }
    
    .input-success {
        border-color: #22c55e !important;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1) !important;
    }
    
    /* Shake animation for error */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
        20%, 40%, 60%, 80% { transform: translateX(4px); }
    }
    .shake {
        animation: shake 0.5s ease;
    }

    /* =========================================================
       SUCCESS BANNER IN FORM
    ========================================================= */
    .success-banner {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.5s ease;
    }
    .success-banner.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
    .success-banner .flex {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .success-banner .icon {
        width: 2rem;
        height: 2rem;
        background: #dcfce7;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .success-banner .icon i {
        color: #16a34a;
    }
    .success-banner .title {
        font-weight: 700;
        font-size: 0.875rem;
    }
    .success-banner .message {
        font-size: 0.875rem;
        margin-top: 0.125rem;
    }
    .success-banner .close-btn {
        color: #9ca3af;
        cursor: pointer;
        background: none;
        border: none;
        font-size: 0.875rem;
        transition: color 0.2s;
        flex-shrink: 0;
        margin-left: auto;
    }
    .success-banner .close-btn:hover {
        color: #6b7280;
    }

    /* =========================================================
       LOADING STATE
    ========================================================= */
    .btn-loading {
        opacity: 0.7;
        cursor: not-allowed;
        pointer-events: none;
        position: relative;
    }
    .btn-loading .btn-text {
        visibility: hidden;
    }
    .btn-loading .btn-spinner {
        display: inline-flex !important;
    }
    .btn-spinner {
        display: none !important;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-spinner i {
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* =========================================================
       CHARACTER COUNTER
    ========================================================= */
    .char-counter {
        font-size: 0.75rem;
        color: #9ca3af;
        text-align: right;
        margin-top: 0.5rem;
    }
    .char-counter.warning {
        color: #f59e0b;
    }
    .char-counter.danger {
        color: #ef4444;
    }

    /* =========================================================
       DRAG & DROP UPLOAD FOR IMAGES
    ========================================================= */
    .drop-zone-editor {
        border: 2px dashed #d1d5db;
        border-radius: 0.75rem;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f9fafb;
        margin-bottom: 1rem;
    }
    .drop-zone-editor:hover {
        border-color: #006400;
        background: #f0fdf4;
    }
    .drop-zone-editor.dragover {
        border-color: #006400;
        background: #dcfce7;
        transform: scale(1.01);
    }
    .drop-zone-editor .icon {
        font-size: 2.5rem;
        color: #9ca3af;
        margin-bottom: 0.5rem;
    }
    .drop-zone-editor .text {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
    }
    .drop-zone-editor .hint {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    /* =========================================================
       PREVIEW IMAGE
    ========================================================= */
    .image-preview-container {
        display: none;
        margin-bottom: 1rem;
    }
    .image-preview-container.active {
        display: block;
    }
    .image-preview-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }
    .image-preview-wrapper img {
        max-height: 200px;
        width: 100%;
        object-fit: cover;
        display: block;
    }
    .image-preview-wrapper .btn-remove-image {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        z-index: 10;
    }
    .image-preview-wrapper .btn-remove-image:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
    .image-preview-wrapper .file-name {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        text-align: center;
        backdrop-filter: blur(4px);
    }
</style>

<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="beritaForm">
    @csrf

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Berita</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi berita untuk dipublikasikan.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if (in_array($role, ['super_admin', 'admin', 'editor']))
                <button type="submit" name="status" value="Draft"
                    class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                    <span class="btn-text"><i class="fas fa-file-pen mr-1.5"></i> Simpan Draft</span>
                    <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                </button>
            @endif

            @if ($role == 'editor')
                <button type="submit" name="status" value="Menunggu Approval"
                    class="bg-orange-500 hover:bg-orange-600 text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                    <span class="btn-text"><i class="fas fa-paper-plane mr-1.5"></i> Submit untuk Approval</span>
                    <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                </button>
            @endif

            @if (in_array($role, ['super_admin', 'admin']))
                <button type="submit" name="status" value="Terbit" id="submitBtn"
                    class="bg-[#006400] hover:bg-[#005500] text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                    <span class="btn-text"><i class="fas fa-check-circle mr-1.5"></i> Terbitkan</span>
                    <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                </button>
            @endif

            <a href="{{ route('admin.berita.index') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                <i class="fas fa-times mr-1.5"></i>
                Batal
            </a>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- SUCCESS BANNER (DI DALAM FORM) -->
    <!-- ========================================================= -->
    <div id="successBanner" class="success-banner {{ session('success') ? 'show' : '' }}">
        <div class="flex">
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="flex-1">
                <p class="title">Berhasil!</p>
                <p class="message" id="successMessage">{{ session('success') ?? 'Data berhasil disimpan!' }}</p>
            </div>
            <button type="button" class="close-btn" onclick="closeSuccessBanner()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- PESAN ERROR -->
    <div id="errorContainer" class="{{ $errors->any() ? '' : 'hidden' }}">
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Terjadi kesalahan:</p>
                    <ul class="list-disc ml-4 text-sm mt-1" id="errorList">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- KOLOM KIRI (2/3) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- INFORMASI DASAR -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-circle-info text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Informasi Dasar</h2>
                        <p class="text-xs text-gray-500">Lengkapi informasi utama berita.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- JUDUL -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                            placeholder="Masukkan judul berita"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                            {{ $errors->has('judul') ? 'input-error shake' : '' }}"
                            required>
                        <div class="field-error {{ $errors->has('judul') ? 'show' : '' }}" id="judulError">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('judul') ?: 'Judul berita wajib diisi.' }}
                        </div>
                    </div>

                    <!-- RINGKASAN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Ringkasan / Lead
                        </label>
                        <textarea name="ringkasan" id="ringkasan" rows="3"
                            placeholder="Masukkan ringkasan singkat berita (akan ditampilkan di listing berita)"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                            {{ $errors->has('ringkasan') ? 'input-error shake' : '' }}">{{ old('ringkasan') }}</textarea>
                        <div class="field-error {{ $errors->has('ringkasan') ? 'show' : '' }}" id="ringkasanError">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('ringkasan') }}
                        </div>
                        <div class="char-counter" id="ringkasanCounter">0/160 karakter</div>
                    </div>

                    <!-- KATEGORI & TANGGAL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="kategori" id="kategori" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                                {{ $errors->has('kategori') ? 'input-error shake' : '' }}">
                                <option value="">Pilih Kategori</option>
                                <option value="Berita" {{ old('kategori') == 'Berita' ? 'selected' : '' }}>Berita</option>
                                <option value="Siaran Pers" {{ old('kategori') == 'Siaran Pers' ? 'selected' : '' }}>Siaran Pers</option>
                                <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            </select>
                            <div class="field-error {{ $errors->has('kategori') ? 'show' : '' }}" id="kategoriError">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $errors->first('kategori') ?: 'Kategori wajib dipilih.' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Tanggal Publikasi
                            </label>
                            <input type="date" name="tanggal_publikasi"
                                value="{{ old('tanggal_publikasi', date('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                                {{ $errors->has('tanggal_publikasi') ? 'input-error shake' : '' }}">
                            <div class="field-error {{ $errors->has('tanggal_publikasi') ? 'show' : '' }}" id="tanggal_publikasiError">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $errors->first('tanggal_publikasi') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KONTEN BERITA (Textarea Biasa) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                        <i class="fas fa-file-lines text-purple-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Konten Berita</h2>
                        <p class="text-xs text-gray-500">Tulis konten berita di sini.</p>
                    </div>
                </div>

                <!-- GAMBAR UTAMA (Drag & Drop) -->
                <div class="drop-zone-editor" id="dropZoneEditor">
                    <div class="icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <p class="text">Drag & drop gambar utama di sini</p>
                    <p class="hint">atau klik untuk memilih file</p>
                    <p class="hint" style="margin-top:0.25rem;color:#9ca3af;">
                        Rekomendasi: 1200 x 675 px (16:9) • JPG, PNG (Max 2MB)
                    </p>
                    <input type="file" id="gambarInput" name="gambar" 
                           accept="image/jpeg,image/png,image/jpg"
                           style="display:none;">
                </div>

                <!-- Preview Gambar -->
                <div class="image-preview-container" id="imagePreviewContainer">
                    <div class="image-preview-wrapper">
                        <img id="previewImg" src="#" alt="Preview">
                        <button type="button" class="btn-remove-image" id="removeImageEditor">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="file-name">
                            <span id="fileNameDisplay">Belum ada file</span>
                        </div>
                    </div>
                </div>

                <!-- TEXTAREA BIASA -->
                <textarea name="konten" id="editor" rows="12" required
                    placeholder="Tulis konten berita di sini..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition resize-y
                    {{ $errors->has('konten') ? 'input-error shake' : '' }}">{{ old('konten') }}</textarea>
                <div class="field-error {{ $errors->has('konten') ? 'show' : '' }}" id="kontenError">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $errors->first('konten') ?: 'Konten berita wajib diisi.' }}
                </div>
                <div class="char-counter" id="editorCounter">0 kata</div>
            </div>

            <!-- SEO -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                        <i class="fas fa-magnifying-glass-chart text-amber-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">SEO (Opsional)</h2>
                        <p class="text-xs text-gray-500">Optimasi untuk mesin pencari.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Title</label>
                        <input type="text" name="meta_title" id="metaTitle" placeholder="Masukkan meta title"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                            {{ $errors->has('meta_title') ? 'input-error shake' : '' }}"
                            value="{{ old('meta_title') }}">
                        <div class="field-error {{ $errors->has('meta_title') ? 'show' : '' }}" id="meta_titleError">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('meta_title') }}
                        </div>
                        <div class="char-counter" id="metaTitleCounter">0/60 karakter</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description</label>
                        <input type="text" name="meta_description" id="metaDescription" placeholder="Masukkan meta description"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                            {{ $errors->has('meta_description') ? 'input-error shake' : '' }}"
                            value="{{ old('meta_description') }}">
                        <div class="field-error {{ $errors->has('meta_description') ? 'show' : '' }}" id="meta_descriptionError">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('meta_description') }}
                        </div>
                        <div class="char-counter" id="metaDescCounter">0/160 karakter</div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Slug</label>
                        <div class="relative">
                            <span class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 text-sm">/</span>
                            <input type="text" name="slug" id="slug" placeholder="berita/..." 
                                class="w-full border border-gray-300 rounded-xl pl-7 pr-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                                {{ $errors->has('slug') ? 'input-error shake' : '' }}"
                                value="{{ old('slug') }}">
                        </div>
                        <div class="field-error {{ $errors->has('slug') ? 'show' : '' }}" id="slugError">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('slug') }}
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5">
                            <i class="fas fa-info-circle mr-1"></i>
                            Akan digenerate otomatis dari judul jika dikosongkan.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN (1/3) -->
        <div class="space-y-6">

            <!-- STATUS & AKSES -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                        <i class="fas fa-toggle-on text-green-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Status & Akses</h2>
                        <p class="text-xs text-gray-500">Atur status publikasi berita.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                        <select name="status" id="statusSelect"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                            {{ $errors->has('status') ? 'input-error shake' : '' }}">

                            @if (in_array($role, ['super_admin', 'admin']))
                                <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Menunggu Approval" {{ old('status') == 'Menunggu Approval' ? 'selected' : '' }}>Menunggu Approval</option>
                                <option value="Terbit" {{ old('status') == 'Terbit' ? 'selected' : '' }}>Terbit</option>
                            @elseif ($role == 'editor')
                                <option value="Draft" selected>Draft</option>
                            @else
                                <option value="Draft" selected>Draft</option>
                            @endif

                        </select>
                        <div class="field-error {{ $errors->has('status') ? 'show' : '' }}" id="statusError">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('status') }}
                        </div>

                        @if ($role == 'editor')
                            <div class="mt-2 bg-blue-50 border border-blue-100 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-blue-500 text-sm mt-0.5"></i>
                                    <p class="text-xs text-blue-700 leading-relaxed">
                                        Sebagai <strong>Editor</strong>, Anda hanya dapat membuat <strong>Draft</strong>.
                                        Submit untuk approval setelah selesai.
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if (in_array($role, ['super_admin', 'admin']))
                            <div class="mt-2 bg-green-50 border border-green-100 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-green-500 text-sm mt-0.5"></i>
                                    <p class="text-xs text-green-700 leading-relaxed">
                                        Sebagai <strong>{{ $role == 'super_admin' ? 'Super Admin' : 'Admin' }}</strong>,
                                        Anda dapat langsung <strong>menerbitkan</strong> berita.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penulis</label>
                        <input type="text" name="penulis" value="{{ auth()->user()->name }}" readonly
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600">
                    </div>
                </div>
            </div>

            <!-- RIWAYAT APPROVAL -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center">
                        <i class="fas fa-clock-rotate-left text-orange-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Riwayat Approval</h2>
                        <p class="text-xs text-gray-500">Informasi status approval berita.</p>
                    </div>
                </div>

                <div class="space-y-4 text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Dibuat oleh</p>
                            <p class="text-gray-500 text-xs">{{ auth()->user()->name }}</p>
                            <p class="text-gray-400 text-[10px]">{{ now()->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($role == 'editor')
                    <div class="mt-3 bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Alur Approval</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs font-medium text-gray-700">Draft</span>
                            <span class="text-gray-400">→</span>
                            <span class="text-xs font-medium text-orange-600">Submit</span>
                            <span class="text-gray-400">→</span>
                            <span class="text-xs font-medium text-blue-600">Review Publisher</span>
                            <span class="text-gray-400">→</span>
                            <span class="text-xs font-medium text-green-600">Published</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- TIPS -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 p-5">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-blue-800">Tips</p>
                        <ul class="text-xs text-blue-700 space-y-1 mt-1.5">
                            <li>• Gunakan judul yang menarik dan informatif</li>
                            <li>• Sertakan gambar pendukung untuk meningkatkan visual</li>
                            <li>• Pastikan konten sesuai dengan fakta dan data</li>
                            @if ($role == 'editor')
                            <li>• Submit ke Publisher setelah konten selesai</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // =========================================================
    // 1. SMOOTH VALIDATION - REAL TIME
    // =========================================================
    const form = document.getElementById('beritaForm');
    const requiredFields = document.querySelectorAll('[required]');
    const errorContainer = document.getElementById('errorContainer');
    const errorList = document.getElementById('errorList');

    // Fungsi untuk menampilkan error per field
    function showFieldError(field, message) {
        const errorEl = document.getElementById(field.id + 'Error');
        if (errorEl) {
            errorEl.textContent = message || 'Field ini wajib diisi.';
            errorEl.classList.add('show');
            errorEl.classList.remove('hidden');
        }
        field.classList.add('input-error', 'shake');
        field.classList.remove('input-success');
        setTimeout(() => field.classList.remove('shake'), 500);
    }

    function hideFieldError(field) {
        const errorEl = document.getElementById(field.id + 'Error');
        if (errorEl) {
            errorEl.classList.remove('show');
            errorEl.classList.add('hidden');
        }
        field.classList.remove('input-error');
        field.classList.add('input-success');
    }

    function validateField(field) {
        if (!field.value.trim()) {
            showFieldError(field, 'Field ini wajib diisi.');
            return false;
        }
        hideFieldError(field);
        return true;
    }

    // Real-time validation on blur
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });

        field.addEventListener('input', function() {
            if (this.value.trim()) {
                hideFieldError(this);
                const allValid = Array.from(requiredFields).every(f => f.value.trim());
                if (allValid && errorContainer) {
                    errorContainer.style.transition = 'opacity 0.5s ease';
                    errorContainer.style.opacity = '0';
                    setTimeout(() => {
                        errorContainer.classList.add('hidden');
                        errorContainer.style.opacity = '1';
                    }, 500);
                }
            }
        });
    });

    // =========================================================
    // 2. FORM SUBMIT - VALIDATION + LOADING STATE
    // =========================================================
    if (form) {
        form.addEventListener('submit', function(e) {
            let hasError = false;
            const errors = [];

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    showFieldError(field, 'Field ini wajib diisi.');
                    hasError = true;
                    const label = field.getAttribute('name') || 'Field';
                    errors.push(label.replace(/_/g, ' ') + ' harus diisi.');
                }
            });

            // Validasi khusus: gambar (tidak required)
            const fileInput = document.getElementById('gambarInput');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    hasError = true;
                    errors.push('Ukuran gambar terlalu besar. Maksimal 2MB.');
                    showToast('Ukuran gambar terlalu besar. Maksimal 2MB.', 'error');
                }
            }

            if (hasError) {
                e.preventDefault();
                
                if (errorContainer && errorList) {
                    errorContainer.classList.remove('hidden');
                    errorContainer.style.opacity = '1';
                    errorList.innerHTML = errors.map(err => `<li>${err}</li>`).join('');
                }
                
                const firstError = document.querySelector('.input-error');
                if (firstError) {
                    firstError.focus();
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            // =========================================================
            // 3. LOADING STATE
            // =========================================================
            const submitBtns = document.querySelectorAll('[type="submit"]');
            submitBtns.forEach(btn => {
                btn.classList.add('btn-loading');
                const textEl = btn.querySelector('.btn-text');
                const spinnerEl = btn.querySelector('.btn-spinner');
                if (textEl) textEl.style.visibility = 'hidden';
                if (spinnerEl) spinnerEl.style.display = 'inline-flex';
                btn.disabled = true;
            });
        });
    }

    // =========================================================
    // 4. SUCCESS BANNER - AUTO CLOSE
    // =========================================================
    const successBanner = document.getElementById('successBanner');
    if (successBanner && successBanner.classList.contains('show')) {
        setTimeout(() => {
            closeSuccessBanner();
        }, 5000);
    }

    // =========================================================
    // 5. CHARACTER COUNTERS
    // =========================================================
    function setupCounter(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        if (input && counter) {
            const update = () => {
                const length = input.value.length;
                counter.textContent = length + '/' + maxLength + ' karakter';
                counter.className = 'char-counter';
                if (length > maxLength) {
                    counter.classList.add('danger');
                } else if (length > maxLength * 0.8) {
                    counter.classList.add('warning');
                }
            };
            input.addEventListener('input', update);
            update();
        }
    }

    setupCounter('ringkasan', 'ringkasanCounter', 160);
    setupCounter('metaTitle', 'metaTitleCounter', 60);
    setupCounter('metaDescription', 'metaDescCounter', 160);

    // =========================================================
    // 6. WORD COUNTER
    // =========================================================
    const editor = document.getElementById('editor');
    const editorCounter = document.getElementById('editorCounter');
    if (editor && editorCounter) {
        const updateWordCount = () => {
            const text = editor.value.trim();
            const words = text.length === 0 ? 0 : text.split(/\s+/).length;
            editorCounter.textContent = words + ' kata';
        };
        editor.addEventListener('input', updateWordCount);
        updateWordCount();
    }

    // =========================================================
    // 7. AUTO GENERATE SLUG
    // =========================================================
    const judulInput = document.getElementById('judul');
    const slugInput = document.getElementById('slug');

    if (judulInput && slugInput) {
        judulInput.addEventListener('keyup', function() {
            if (!slugInput.value || slugInput.dataset.autoGenerated !== 'false') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                slugInput.value = slug;
                slugInput.dataset.autoGenerated = 'true';
            }
        });
    }

    // =========================================================
    // 8. TOAST NOTIFICATION
    // =========================================================
    function showToast(message, type = 'success') {
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'fixed top-20 right-4 z-[99999] space-y-3 max-w-sm w-full';
            document.body.appendChild(container);
        }

        const colors = {
            success: 'bg-green-50 border-green-400 text-green-800',
            error: 'bg-red-50 border-red-400 text-red-800',
            warning: 'bg-yellow-50 border-yellow-400 text-yellow-800',
            info: 'bg-blue-50 border-blue-400 text-blue-800'
        };
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-triangle-exclamation',
            info: 'fa-circle-info'
        };

        const toast = document.createElement('div');
        toast.className = `flex items-start gap-3 p-4 border rounded-xl shadow-lg ${colors[type] || colors.success} animate-slide-in`;
        toast.innerHTML = `
            <i class="fas ${icons[type] || icons.success} text-lg mt-0.5"></i>
            <div class="flex-1 text-sm font-medium">${message}</div>
            <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    // =========================================================
    // 9. DRAG & DROP UPLOAD GAMBAR
    // =========================================================
    const dropZone = document.getElementById('dropZoneEditor');
    const fileInput = document.getElementById('gambarInput');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImg = document.getElementById('previewImg');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const removeBtn = document.getElementById('removeImageEditor');

    if (dropZone) {
        dropZone.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                handleFile(e.dataTransfer.files[0]);
            }
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFile(this.files[0]);
            }
        });
    }

    function handleFile(file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            showToast('Format file tidak didukung. Gunakan JPG atau PNG.', 'error');
            fileInput.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            showToast('Ukuran file terlalu besar. Maksimal 2MB.', 'error');
            fileInput.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.classList.add('active');
            previewContainer.style.display = 'block';
            fileNameDisplay.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
            
            const textEl = dropZone.querySelector('.text');
            const iconEl = dropZone.querySelector('.icon i');
            if (textEl) {
                textEl.textContent = 'File siap diupload';
                textEl.style.color = '#006400';
            }
            if (iconEl) {
                iconEl.className = 'fas fa-check-circle';
                iconEl.style.color = '#006400';
            }
        };
        reader.readAsDataURL(file);
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            fileInput.value = '';
            previewContainer.classList.remove('active');
            previewContainer.style.display = 'none';
            previewImg.src = '#';
            fileNameDisplay.textContent = 'Belum ada file';
            
            const textEl = dropZone.querySelector('.text');
            const iconEl = dropZone.querySelector('.icon i');
            if (textEl) {
                textEl.textContent = 'Drag & drop gambar utama di sini';
                textEl.style.color = '#6b7280';
            }
            if (iconEl) {
                iconEl.className = 'fas fa-cloud-upload-alt';
                iconEl.style.color = '#9ca3af';
            }
        });
    }

    function formatFileSize(bytes) {
        if (bytes >= 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
        if (bytes >= 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return bytes + ' B';
    }

    // =========================================================
    // Sembunyikan error container setelah 5 detik jika ada
    // =========================================================
    if (errorContainer && !errorContainer.classList.contains('hidden')) {
        setTimeout(() => {
            errorContainer.style.transition = 'opacity 0.5s ease';
            errorContainer.style.opacity = '0';
            setTimeout(() => {
                errorContainer.classList.add('hidden');
                errorContainer.style.opacity = '1';
            }, 500);
        }, 5000);
    }
});

// =========================================================
// GLOBAL FUNCTIONS
// =========================================================
function closeSuccessBanner() {
    const banner = document.getElementById('successBanner');
    if (banner) {
        banner.style.transition = 'all 0.5s ease';
        banner.style.opacity = '0';
        banner.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            banner.classList.remove('show');
            banner.style.display = 'none';
        }, 500);
    }
}
</script>

@endsection