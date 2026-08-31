@extends('layouts.admin')

@section('title', 'Edit Halaman Tentang')

@section('content')

<style>
    .tentang-container {
        max-width: 100%;
    }

    .tentang-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .tentang-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .tentang-header a {
        font-size: 0.875rem;
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
    }

    .tentang-header a:hover {
        color: #006400;
    }

    .tentang-alert {
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    .tentang-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .tentang-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .tentang-alert-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .tentang-alert-icon-success {
        background: #dcfce7;
        color: #16a34a;
    }

    .tentang-alert-icon-error {
        background: #fee2e2;
        color: #dc2626;
    }

    .tentang-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .tentang-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .tentang-card:last-child {
        margin-bottom: 0;
    }

    .tentang-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .tentang-card-subtitle {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 1.25rem;
    }

    .tentang-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.375rem;
    }

    .tentang-label-required {
        color: #ef4444;
    }

    .tentang-input,
    .tentang-textarea {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        background: #ffffff;
        color: #111827;
    }

    .tentang-input:focus,
    .tentang-textarea:focus {
        outline: none;
        border-color: #006400;
        box-shadow: 0 0 0 3px rgba(0, 100, 0, 0.1);
    }

    .tentang-textarea {
        resize: vertical;
        min-height: 80px;
    }

    .tentang-help-text {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.375rem;
    }

    .tentang-upload {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .tentang-upload:hover {
        border-color: #006400;
        background: #f8fafc;
    }

    .tentang-upload-icon {
        font-size: 2.5rem;
        color: #9ca3af;
        margin-bottom: 0.5rem;
    }

    .tentang-upload-text {
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
    }

    .tentang-upload-hint {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.25rem;
    }

    .tentang-upload-filename {
        font-size: 0.75rem;
        color: #006400;
        margin-top: 0.5rem;
    }

    .tentang-image-preview {
        margin-top: 1rem;
    }

    .tentang-image-preview-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.375rem;
    }

    .tentang-image-preview img {
        width: 100%;
        height: 8rem;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
    }

    .tentang-image-preview-name {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.25rem;
    }

    .tentang-submit {
        width: 100%;
        background: #006400;
        color: #ffffff;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .tentang-submit:hover {
        background: #005500;
        box-shadow: 0 4px 12px rgba(0, 100, 0, 0.3);
    }

    .tentang-submit i {
        margin-right: 0.375rem;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .3s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    .toggle-switch input:checked+.toggle-slider {
        background-color: #006400;
    }

    .toggle-switch input:checked+.toggle-slider:before {
        transform: translateX(24px);
    }

    @media (max-width: 1024px) {
        .tentang-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

    @media (max-width: 640px) {
        .tentang-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .tentang-card {
            padding: 1rem;
        }

        .tentang-upload {
            padding: 1rem;
        }
    }
</style>

<div class="tentang-container">

    {{-- HEADER --}}
    <div class="tentang-header">
        <h1>Edit Halaman Tentang</h1>
        <a href="{{ route('about') }}" target="_blank">
            <i class="fas fa-external-link-alt mr-1"></i> Lihat Halaman
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="tentang-alert tentang-alert-success">
            <div class="flex items-start gap-3">
                <div class="tentang-alert-icon tentang-alert-icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="tentang-alert tentang-alert-error">
            <div class="flex items-start gap-3">
                <div class="tentang-alert-icon tentang-alert-icon-error">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Terjadi kesalahan:</p>
                    <ul class="list-disc ml-4 text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('admin.halaman.update.tentang') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="tentang-grid">

            {{-- KOLOM KIRI --}}
            <div>

                {{-- INFORMASI DASAR --}}
                <div class="tentang-card">
                    <h2 class="tentang-card-title">Informasi Dasar</h2>
                    <p class="tentang-card-subtitle">Informasi utama halaman Tentang.</p>

                    <div style="margin-bottom:1rem;">
                        <label class="tentang-label">
                            Judul Halaman <span class="tentang-label-required">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $halaman->judul) }}"
                               class="tentang-input" required>
                    </div>

                    <div>
                        <label class="tentang-label">
                            Profil / Deskripsi Lembaga <span class="tentang-label-required">*</span>
                        </label>
                        <textarea name="isi" rows="6" class="tentang-textarea" required>{{ old('isi', $halaman->isi) }}</textarea>
                        <p class="tentang-help-text">Deskripsi singkat tentang Badan Bank Tanah.</p>
                    </div>
                </div>

                {{-- VISI & MISI --}}
                <div class="tentang-card">
                    <h2 class="tentang-card-title">Visi & Misi</h2>
                    <p class="tentang-card-subtitle">Visi dan misi Badan Bank Tanah.</p>

                    <div style="margin-bottom:1rem;">
                        <label class="tentang-label">Visi</label>
                        <textarea name="visi" rows="4" class="tentang-textarea">{{ old('visi', $halaman->visi) }}</textarea>
                    </div>

                    <div>
                        <label class="tentang-label">Misi</label>
                        <textarea name="misi" rows="6" class="tentang-textarea">{{ old('misi', $halaman->misi) }}</textarea>
                    </div>
                </div>

                {{-- STRUKTUR ORGANISASI --}}
                <div class="tentang-card">
                    <h2 class="tentang-card-title">Struktur Organisasi</h2>
                    <p class="tentang-card-subtitle">Struktur organisasi Badan Bank Tanah.</p>

                    <div>
                        <label class="tentang-label">Struktur Organisasi</label>
                        <textarea name="struktur_organisasi" rows="8" class="tentang-textarea">{{ old('struktur_organisasi', $halaman->struktur_organisasi) }}</textarea>
                    </div>
                </div>

                {{-- DASAR HUKUM --}}
                <div class="tentang-card">
                    <h2 class="tentang-card-title">Dasar Hukum</h2>
                    <p class="tentang-card-subtitle">Landasan hukum Badan Bank Tanah.</p>

                    <div>
                        <label class="tentang-label">Dasar Hukum</label>
                        <textarea name="dasar_hukum" rows="6" class="tentang-textarea">{{ old('dasar_hukum', $halaman->dasar_hukum) }}</textarea>
                    </div>
                </div>

                {{-- STATUS HALAMAN --}}
                <div class="tentang-card">
                    <h2 class="tentang-card-title">Status Halaman</h2>
                    <p class="tentang-card-subtitle">Aktifkan atau nonaktifkan halaman ini.</p>

                    <div class="flex items-center gap-3">
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $halaman->is_active) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="text-sm font-medium text-gray-700">
                            <span class="{{ $halaman->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $halaman->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </span>
                    </div>
                    <p class="tentang-help-text mt-2">Halaman yang tidak aktif tidak akan ditampilkan di frontend.</p>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div>

                {{-- GAMBAR HERO --}}
                <div class="tentang-card">
                    <h2 class="tentang-card-title">Gambar Hero</h2>
                    <p class="tentang-card-subtitle">Gambar utama halaman Tentang.</p>

                    <div class="tentang-upload" onclick="document.getElementById('gambarInput').click()">
                        <div class="tentang-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <p class="tentang-upload-text">Upload gambar hero</p>
                        <p class="tentang-upload-hint">Format: JPG, PNG (Max 2MB)</p>
                        <input type="file" id="gambarInput" name="gambar"
                               accept="image/jpeg,image/png,image/jpg"
                               class="hidden"
                               onchange="document.getElementById('gambarName').textContent = this.files[0]?.name || 'Belum ada file'">
                        <p id="gambarName" class="tentang-upload-filename">Belum ada file</p>
                    </div>

                    @if ($halaman->gambar)
                        <div class="tentang-image-preview">
                            <p class="tentang-image-preview-label">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $halaman->gambar) }}" alt="Gambar Hero">
                            <p class="tentang-image-preview-name">{{ basename($halaman->gambar) }}</p>
                        </div>
                    @endif
                </div>

                {{-- FOTO TAMBAHAN --}}
                <div class="tentang-card">
                    <h2 class="tentang-card-title">Foto Tambahan</h2>
                    <p class="tentang-card-subtitle">Foto tambahan untuk halaman.</p>

                    <div class="tentang-upload" onclick="document.getElementById('fotoInput').click()">
                        <div class="tentang-upload-icon">
                            <i class="fas fa-photo-film"></i>
                        </div>
                        <p class="tentang-upload-text">Upload foto tambahan</p>
                        <p class="tentang-upload-hint">Format: JPG, PNG (Max 2MB)</p>
                        <input type="file" id="fotoInput" name="foto"
                               accept="image/jpeg,image/png,image/jpg"
                               class="hidden"
                               onchange="document.getElementById('fotoName').textContent = this.files[0]?.name || 'Belum ada file'">
                        <p id="fotoName" class="tentang-upload-filename">Belum ada file</p>
                    </div>

                    @if ($halaman->foto)
                        <div class="tentang-image-preview">
                            <p class="tentang-image-preview-label">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $halaman->foto) }}" alt="Foto Tambahan">
                            <p class="tentang-image-preview-name">{{ basename($halaman->foto) }}</p>
                        </div>
                    @endif
                </div>

                {{-- TOMBOL SIMPAN --}}
                <button type="submit" class="tentang-submit">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle status checkbox
        const statusCheckbox = document.querySelector('input[name="is_active"]');
        const statusLabel = document.querySelector('.toggle-switch + span span');

        if (statusCheckbox && statusLabel) {
            statusCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    statusLabel.textContent = 'Aktif';
                    statusLabel.className = 'text-green-600';
                } else {
                    statusLabel.textContent = 'Tidak Aktif';
                    statusLabel.className = 'text-gray-400';
                }
            });
        }

        // File name display
        const gambarInput = document.getElementById('gambarInput');
        const gambarName = document.getElementById('gambarName');
        if (gambarInput && gambarName) {
            gambarInput.addEventListener('change', function() {
                gambarName.textContent = this.files[0]?.name || 'Belum ada file';
            });
        }

        const fotoInput = document.getElementById('fotoInput');
        const fotoName = document.getElementById('fotoName');
        if (fotoInput && fotoName) {
            fotoInput.addEventListener('change', function() {
                fotoName.textContent = this.files[0]?.name || 'Belum ada file';
            });
        }
    });
</script>

@endsection