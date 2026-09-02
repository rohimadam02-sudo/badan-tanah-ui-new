@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')

@php
    $role = auth()->user()->role;
    $isEditor = $role == 'editor';
    $isPublisher = $role == 'publisher';
    $isAdmin = in_array($role, ['super_admin', 'admin']);
    $isSuperAdmin = $role == 'super_admin';

    $canEdit = false;
    if ($isAdmin || $isSuperAdmin) {
        $canEdit = true;
    } elseif ($isPublisher) {
        $canEdit = true;
    } elseif ($isEditor && $berita->penulis == auth()->user()->name) {
        $canEdit = true;
    }

    $canDelete = $isAdmin || $isSuperAdmin;

    $isDraft = $berita->status_approval == 'Draft';
    $isPending = $berita->status_approval == 'Menunggu Approval';
    $isApproved = $berita->status_approval == 'Disetujui';
    $isPublished = $berita->status == 'Dipublikasikan';
    $isArchived = $berita->status == 'Arsip';
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

    /* =========================================================
       EXISTING IMAGE
    ========================================================= */
    .existing-image-wrapper {
        position: relative;
        display: inline-block;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        width: 100%;
        margin-bottom: 1rem;
    }
    .existing-image-wrapper img {
        max-height: 200px;
        width: 100%;
        object-fit: cover;
        display: block;
    }
    .existing-image-wrapper .existing-label {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.7rem;
        backdrop-filter: blur(4px);
    }
</style>

<form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" id="beritaForm">
    @csrf
    @method('PUT')

    @if (!$canEdit)
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-ban text-red-600"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Akses Ditolak</p>
                    <p class="text-sm">Anda tidak memiliki akses untuk mengedit berita ini.</p>
                    <a href="{{ route('admin.berita.index') }}" class="text-sm font-semibold text-red-600 hover:underline mt-1 inline-block">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    @endif

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Berita</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi berita.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($canEdit)
                <!-- SIMPAN DRAFT -->
                <button type="submit" name="status" value="Draft"
                    class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                    <span class="btn-text"><i class="fas fa-file-pen mr-1.5"></i> Simpan Draft</span>
                    <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                </button>

                <!-- SUBMIT UNTUK APPROVAL (HANYA EDITOR) -->
                @if ($isEditor && $isDraft)
                    <button type="submit" name="status" value="Menunggu Approval"
                        class="bg-orange-500 hover:bg-orange-600 text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                        <span class="btn-text"><i class="fas fa-paper-plane mr-1.5"></i> Submit untuk Approval</span>
                        <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                    </button>
                @endif

                <!-- APPROVE (HANYA PUBLISHER, ADMIN, SUPER ADMIN) -->
                @if (($isPublisher || $isAdmin || $isSuperAdmin) && $isPending)
                    <button type="submit" name="status" value="Approve"
                        formaction="{{ route('admin.berita.approve', $berita->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                        <span class="btn-text"><i class="fas fa-check-circle mr-1.5"></i> Approve</span>
                        <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                    </button>
                @endif

                <!-- PUBLISH (HANYA PUBLISHER, ADMIN, SUPER ADMIN) -->
                @if (($isPublisher || $isAdmin || $isSuperAdmin) && ($isApproved || $isArchived))
                    <button type="submit" name="status" value="Terbit"
                        formaction="{{ route('admin.berita.publish', $berita->id) }}"
                        class="bg-[#006400] hover:bg-[#005500] text-white rounded-lg px-5 py-2 text-sm font-bold transition" id="submitBtn">
                        <span class="btn-text"><i class="fas fa-check-circle mr-1.5"></i> {{ $isArchived ? 'Publikasikan Kembali' : 'Publish' }}</span>
                        <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                    </button>
                @endif

                <!-- TERBITKAN LANGSUNG (HANYA ADMIN & SUPER ADMIN) -->
                @if ($isAdmin || $isSuperAdmin)
                    <button type="submit" name="status" value="Terbit"
                        class="bg-[#006400] hover:bg-[#005500] text-white rounded-lg px-5 py-2 text-sm font-bold transition" id="submitBtnDirect">
                        <span class="btn-text"><i class="fas fa-check-circle mr-1.5"></i> Terbitkan</span>
                        <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                    </button>
                @endif

                <!-- UNPUBLISH / ARSIPKAN (HANYA PUBLISHER, ADMIN, SUPER ADMIN) -->
                @if (($isPublisher || $isAdmin || $isSuperAdmin) && $isPublished)
                    <button type="submit" name="status" value="Arsip"
                        formaction="{{ route('admin.berita.unpublish', $berita->id) }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                        <span class="btn-text"><i class="fas fa-archive mr-1.5"></i> Arsipkan</span>
                        <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                    </button>
                @endif

                <!-- HAPUS (HANYA ADMIN & SUPER ADMIN) -->
                @if ($canDelete)
                    <button type="submit" name="status" value="Hapus"
                        formaction="{{ route('admin.berita.destroy', $berita->id) }}"
                        formmethod="POST"
                        onclick="return confirm('Apakah Anda yakin ingin Hapus berita ini?')"
                        class="border border-red-300 text-red-600 hover:bg-red-50 rounded-lg px-4 py-2 text-sm font-medium transition">
                        <span class="btn-text"><i class="fas fa-trash mr-1.5"></i> Hapus</span>
                        <span class="btn-spinner"><i class="fas fa-spinner"></i> Menyimpan...</span>
                    </button>
                @endif
            @endif

            <!-- BATAL -->
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

    <!-- BADGE STATUS -->
    <div class="flex flex-wrap items-center gap-3 mb-6">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold
            @if($isPublished) bg-green-100 text-green-700
            @elseif($isApproved) bg-blue-100 text-blue-700
            @elseif($isPending) bg-orange-100 text-orange-700
            @elseif($isArchived) bg-gray-100 text-gray-500 line-through
            @else bg-yellow-100 text-yellow-700 @endif">
            <span class="w-1.5 h-1.5 rounded-full
                @if($isPublished) bg-green-500
                @elseif($isApproved) bg-blue-500
                @elseif($isPending) bg-orange-500
                @elseif($isArchived) bg-gray-400
                @else bg-yellow-500 @endif">
            </span>
            Status: {{ $berita->status_approval ?? 'Draft' }}
            @if($isPublished)
                <span class="ml-1 text-[8px] bg-green-200 px-1.5 py-0.5 rounded">Published</span>
            @endif
            @if($isArchived)
                <span class="ml-1 text-[8px] bg-gray-200 px-1.5 py-0.5 rounded">Archived</span>
            @endif
        </span>

        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">
            <i class="far fa-eye"></i>
            {{ number_format($berita->views ?? 0, 0, ',', '.') }} Dilihat
        </span>

        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">
            <i class="far fa-calendar-alt"></i>
            {{ $berita->created_at ? $berita->created_at->format('d M Y H:i') : '-' }}
        </span>

        @if($berita->tanggal_publikasi)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">
                <i class="far fa-calendar-check"></i>
                Publikasi: {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') }}
            </span>
        @endif
    </div>

    <!-- MAIN CONTENT -->
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
                        <p class="text-xs text-gray-500">Perbarui informasi utama berita.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- JUDUL -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul', $berita->judul) }}"
                            placeholder="Masukkan judul berita"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                            {{ !$canEdit ? 'bg-gray-50 text-gray-500' : '' }}
                            {{ $errors->has('judul') ? 'input-error shake' : '' }}"
                            {{ !$canEdit ? 'disabled' : '' }}
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
                            placeholder="Masukkan ringkasan singkat berita"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                            {{ !$canEdit ? 'bg-gray-50 text-gray-500' : '' }}
                            {{ $errors->has('ringkasan') ? 'input-error shake' : '' }}"
                            {{ !$canEdit ? 'disabled' : '' }}>{{ old('ringkasan', $berita->ringkasan) }}</textarea>
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
                                {{ !$canEdit ? 'bg-gray-50 text-gray-500' : '' }}
                                {{ $errors->has('kategori') ? 'input-error shake' : '' }}"
                                {{ !$canEdit ? 'disabled' : '' }}>
                                <option value="Berita" {{ old('kategori', $berita->kategori) == 'Berita' ? 'selected' : '' }}>Berita</option>
                                <option value="Siaran Pers" {{ old('kategori', $berita->kategori) == 'Siaran Pers' ? 'selected' : '' }}>Siaran Pers</option>
                                <option value="Pengumuman" {{ old('kategori', $berita->kategori) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
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
                                value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi ? date('Y-m-d', strtotime($berita->tanggal_publikasi)) : '') }}"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                                {{ !$canEdit ? 'bg-gray-50 text-gray-500' : '' }}
                                {{ $errors->has('tanggal_publikasi') ? 'input-error shake' : '' }}"
                                {{ !$canEdit ? 'disabled' : '' }}>
                            <div class="field-error {{ $errors->has('tanggal_publikasi') ? 'show' : '' }}" id="tanggal_publikasiError">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $errors->first('tanggal_publikasi') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KONTEN BERITA -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                        <i class="fas fa-file-lines text-purple-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Konten Berita</h2>
                        <p class="text-xs text-gray-500">Perbarui konten berita di sini.</p>
                    </div>
                </div>

                <!-- Existing Image -->
                @if ($berita->gambar)
                    <div class="existing-image-wrapper">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                        <span class="existing-label">Gambar Saat Ini</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-3">{{ basename($berita->gambar) }}</p>
                @endif

                <!-- GAMBAR UTAMA (Drag & Drop) -->
                <div class="drop-zone-editor" id="dropZoneEditor">
                    <div class="icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <p class="text">Drag & drop gambar baru di sini</p>
                    <p class="hint">atau klik untuk memilih file</p>
                    <p class="hint" style="margin-top:0.25rem;color:#9ca3af;">
                        Rekomendasi: 1200 x 675 px (16:9) • JPG, PNG (Max 2MB)
                        <br>
                        <span class="text-yellow-600">* Kosongkan jika tidak ingin mengubah gambar</span>
                    </p>
                    <input type="file" id="gambarInput" name="gambar" 
                           accept="image/jpeg,image/png,image/jpg"
                           style="display:none;"
                           {{ !$canEdit ? 'disabled' : '' }}>
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

                <!-- ========================================================= -->
                <!-- AUTO-TRANSLATE BUTTON -->
                <!-- ========================================================= -->
                <div class="flex flex-wrap items-center gap-3 mb-3">
                    <button type="button" id="translateBeritaBtn" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-language"></i>
                        <span id="translateBeritaText">Terjemahkan ke Inggris</span>
                        <span id="translateBeritaLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                    <span id="translateBeritaStatus" class="text-xs text-gray-500"></span>
                </div>

                <!-- Hasil terjemahan -->
                <div id="translationResult" class="hidden mt-3 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Hasil Terjemahan (Inggris)</span>
                        <button type="button" onclick="applyTranslation()" class="text-xs font-semibold text-green-600 hover:text-green-800 transition">
                            <i class="fas fa-check mr-1"></i> Gunakan Terjemahan
                        </button>
                    </div>
                    <div id="translatedContent" class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed"></div>
                </div>

                <!-- TEXTAREA BIASA -->
                <textarea name="konten" id="editor" rows="12" required
                    placeholder="Tulis konten berita di sini..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition resize-y
                    {{ !$canEdit ? 'bg-gray-50 text-gray-500' : '' }}
                    {{ $errors->has('konten') ? 'input-error shake' : '' }}"
                    {{ !$canEdit ? 'disabled' : '' }}>{{ old('konten', $berita->konten) }}</textarea>
                <div class="field-error {{ $errors->has('konten') ? 'show' : '' }}" id="kontenError">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $errors->first('konten') ?: 'Konten berita wajib diisi.' }}
                </div>
                <div class="char-counter" id="editorCounter">0 kata</div>

                @if (!$canEdit)
                    <div class="mt-3 bg-gray-50 border border-gray-200 rounded-xl p-4 text-center text-sm text-gray-500">
                        <i class="fas fa-lock mr-1.5"></i>
                        Anda tidak memiliki akses untuk mengedit konten.
                    </div>
                @endif
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
                            {{ !$canEdit ? 'bg-gray-50 text-gray-500' : '' }}
                            {{ $errors->has('meta_title') ? 'input-error shake' : '' }}"
                            {{ !$canEdit ? 'disabled' : '' }}
                            value="{{ old('meta_title', $berita->meta_title ?? '') }}">
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
                            {{ !$canEdit ? 'bg-gray-50 text-gray-500' : '' }}
                            {{ $errors->has('meta_description') ? 'input-error shake' : '' }}"
                            {{ !$canEdit ? 'disabled' : '' }}
                            value="{{ old('meta_description', $berita->meta_description ?? '') }}">
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
                                value="{{ old('slug', $berita->slug ?? '') }}"
                                class="w-full border border-gray-300 rounded-xl pl-7 pr-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                                {{ !$canEdit ? 'bg-gray-50 text-gray-500' : '' }}
                                {{ $errors->has('slug') ? 'input-error shake' : '' }}"
                                {{ !$canEdit ? 'disabled' : '' }}>
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

                        @if ($canEdit)
                            <select name="status" id="statusSelect"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition
                                {{ $errors->has('status') ? 'input-error shake' : '' }}">

                                @if ($isAdmin || $isSuperAdmin)
                                    <option value="Draft" {{ old('status', $berita->status) == 'Draft' || $berita->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Menunggu Approval" {{ old('status', $berita->status) == 'Menunggu Approval' || $berita->status == 'Menunggu Approval' ? 'selected' : '' }}>Menunggu Approval</option>
                                    <option value="Terbit" {{ old('status', $berita->status) == 'Terbit' || $berita->status == 'Dipublikasikan' ? 'selected' : '' }}>Terbit</option>
                                @elseif ($isEditor)
                                    <option value="Draft" selected>Draft</option>
                                @elseif ($isPublisher)
                                    <option value="Draft" {{ old('status', $berita->status) == 'Draft' || $berita->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Terbit" {{ old('status', $berita->status) == 'Terbit' || $berita->status == 'Dipublikasikan' ? 'selected' : '' }}>Terbit</option>
                                @else
                                    <option value="Draft" selected>Draft</option>
                                @endif

                            </select>
                        @else
                            <input type="text" value="{{ $berita->status }}" readonly
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600">
                        @endif
                        <div class="field-error {{ $errors->has('status') ? 'show' : '' }}" id="statusError">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('status') }}
                        </div>

                        @if ($isEditor)
                            <div class="mt-2 bg-blue-50 border border-blue-100 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-blue-500 text-sm mt-0.5"></i>
                                    <p class="text-xs text-blue-700 leading-relaxed">
                                        Sebagai <strong>Editor</strong>, Anda hanya dapat mengubah ke <strong>Draft</strong>.
                                        Klik tombol <strong>"Submit untuk Approval"</strong> untuk mengirim ke Publisher.
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($isPublisher)
                            <div class="mt-2 bg-green-50 border border-green-100 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-green-500 text-sm mt-0.5"></i>
                                    <p class="text-xs text-green-700 leading-relaxed">
                                        Sebagai <strong>Publisher</strong>, Anda dapat mengubah status ke <strong>Draft</strong>
                                        atau <strong>Terbit</strong>.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penulis</label>
                        <input type="text" value="{{ $berita->penulis }}" readonly
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Slug</label>
                        <input type="text" value="{{ $berita->slug }}" readonly
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
                        <div class="w-8 h-8 rounded-full
                            @if($isPublished) bg-green-100 text-green-600
                            @elseif($isApproved) bg-blue-100 text-blue-600
                            @elseif($isPending) bg-orange-100 text-orange-600
                            @else bg-gray-100 text-gray-500 @endif
                            flex items-center justify-center flex-shrink-0">
                            <i class="fas
                                @if($isPublished) fa-check-circle
                                @elseif($isApproved) fa-check-circle
                                @elseif($isPending) fa-clock
                                @else fa-file-lines @endif">
                            </i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Status Approval</p>
                            <p class="text-xs font-semibold
                                @if($isPublished) text-green-600
                                @elseif($isApproved) text-blue-600
                                @elseif($isPending) text-orange-600
                                @else text-gray-500 @endif">
                                {{ $berita->status_approval ?? 'Draft' }}
                            </p>
                            @if($isPublished)
                                <p class="text-[10px] text-gray-400 mt-0.5">
                                    Dipublikasikan pada {{ $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y H:i') : '-' }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-3">Timeline Approval</p>

                        @php
                            $history = $berita->getApprovalHistory();
                        @endphp

                        @if(count($history) > 0)
                            <div class="relative pl-6 space-y-4 before:absolute before:left-1.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-200">
                                @foreach($history as $item)
                                    <div class="relative">
                                        <div class="absolute -left-5 top-1.5 w-3 h-3 rounded-full
                                            {{ $item['action'] == 'created' ? 'bg-gray-400' :
                                               ($item['action'] == 'submit' ? 'bg-orange-500' :
                                               ($item['action'] == 'approve' ? 'bg-green-500' :
                                               ($item['action'] == 'publish' ? 'bg-blue-500' :
                                               ($item['action'] == 'unpublish' ? 'bg-red-500' :
                                               ($item['action'] == 'updated' ? 'bg-yellow-500' :
                                               'bg-gray-500'))))) }}">
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                            <div>
                                                <span class="text-xs font-medium text-gray-800">
                                                    {{ ucfirst($item['action']) }}
                                                </span>
                                                <span class="text-[10px] text-gray-500">
                                                    oleh {{ $item['user'] }}
                                                </span>
                                                <span class="text-[9px] text-gray-400 ml-1">
                                                    ({{ $item['role'] }})
                                                </span>
                                                @if($item['note'] ?? false)
                                                    <p class="text-[10px] text-gray-500 italic">{{ $item['note'] }}</p>
                                                @endif
                                            </div>
                                            <span class="text-[9px] text-gray-400 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($item['timestamp'])->format('d M Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic">Belum ada riwayat approval.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TIPS -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 p-5">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-blue-800">
                            @if ($isEditor)
                                Tips untuk Editor
                            @elseif ($isPublisher)
                                Tips untuk Publisher
                            @elseif ($isAdmin || $isSuperAdmin)
                                Tips untuk Admin
                            @else
                                Informasi
                            @endif
                        </p>
                        <ul class="text-xs text-blue-700 space-y-1 mt-1.5">
                            @if ($isEditor)
                                <li>• Pastikan konten sudah lengkap sebelum Submit</li>
                                <li>• Klik <strong>"Submit untuk Approval"</strong> untuk mengirim ke Publisher</li>
                                <li>• Anda hanya bisa mengedit berita milik sendiri</li>
                                <li>• Status akan berubah menjadi <strong>Menunggu Approval</strong> setelah submit</li>
                            @elseif ($isPublisher)
                                <li>• Review konten dengan teliti sebelum Approve</li>
                                <li>• Setelah Approve, Anda bisa langsung Publish</li>
                                <li>• Anda bisa mengedit semua konten</li>
                            @elseif ($isAdmin || $isSuperAdmin)
                                <li>• Anda memiliki akses penuh ke semua berita</li>
                                <li>• Dapat langsung menerbitkan tanpa approval</li>
                                <li>• Hati-hati saat menghapus berita</li>
                            @else
                                <li>• Hubungi admin jika ada masalah</li>
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

    // Real-time validation on blur (hanya jika bisa edit)
    @if($canEdit)
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
    @endif

    // =========================================================
    // 2. FORM SUBMIT - VALIDATION + LOADING STATE
    // =========================================================
    if (form) {
        form.addEventListener('submit', function(e) {
            @if($canEdit)
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

            // Validasi gambar
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
            @endif

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
    @if($canEdit)
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
                textEl.textContent = 'Drag & drop gambar baru di sini';
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
    @endif

    // =========================================================
    // AUTO-TRANSLATE
    // =========================================================
    const translateBtn = document.getElementById('translateBeritaBtn');
    const translateText = document.getElementById('translateBeritaText');
    const translateLoading = document.getElementById('translateBeritaLoading');
    const translateStatus = document.getElementById('translateBeritaStatus');
    const translationResult = document.getElementById('translationResult');
    const translatedContent = document.getElementById('translatedContent');

    let currentTranslation = '';

    if (translateBtn) {
        translateBtn.addEventListener('click', function() {
            const content = editor ? editor.value : '';

            if (!content || content.trim() === '') {
                translateStatus.textContent = '⚠️ Konten kosong, tidak bisa diterjemahkan';
                translateStatus.className = 'text-xs text-yellow-600';
                return;
            }

            // Show loading
            translateBtn.disabled = true;
            translateText.textContent = 'Menerjemahkan...';
            translateLoading.classList.remove('hidden');
            translateStatus.textContent = '';
            translationResult.classList.add('hidden');

            fetch('{{ route("admin.translate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    text: content,
                    type: 'berita'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentTranslation = data.translated;
                    translatedContent.textContent = data.translated;
                    translationResult.classList.remove('hidden');
                    translateStatus.textContent = '✅ ' + data.message;
                    translateStatus.className = 'text-xs text-green-600';
                } else {
                    translateStatus.textContent = '❌ ' + data.message;
                    translateStatus.className = 'text-xs text-red-600';
                }
            })
            .catch(error => {
                translateStatus.textContent = '❌ Terjadi kesalahan: ' + error.message;
                translateStatus.className = 'text-xs text-red-600';
            })
            .finally(() => {
                translateBtn.disabled = false;
                translateText.textContent = 'Terjemahkan ke Inggris';
                translateLoading.classList.add('hidden');
            });
        });
    }

    // Fungsi untuk apply terjemahan ke editor
    window.applyTranslation = function() {
        if (currentTranslation && editor) {
            editor.value = currentTranslation;
            translationResult.classList.add('hidden');
            translateStatus.textContent = '✅ Terjemahan berhasil diterapkan!';
            translateStatus.className = 'text-xs text-green-600';
            
            // Trigger change event
            editor.dispatchEvent(new Event('input'));
        }
    };

    // =========================================================
    // CEK STATUS API KEY
    // =========================================================
    fetch('{{ route("admin.translate.status") }}')
        .then(response => response.json())
        .then(data => {
            if (!data.configured) {
                const status = document.getElementById('translateBeritaStatus');
                if (status) {
                    status.textContent = '⚠️ Kimi API Key belum dikonfigurasi. Tambahkan KIMI_API_KEY di .env';
                    status.className = 'text-xs text-yellow-600';
                }
                const btn = document.getElementById('translateBeritaBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        })
        .catch(() => {});

    // =========================================================
    // Sembunyikan error container setelah 5 detik
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