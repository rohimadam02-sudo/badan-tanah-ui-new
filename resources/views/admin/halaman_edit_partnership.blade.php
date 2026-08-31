@extends('layouts.admin')

@section('title', 'Edit Pemanfaatan & Kerjasama')

@section('content')

<style>
    .partnership-container {
        max-width: 100%;
    }

    .partnership-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .partnership-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .partnership-header a {
        font-size: 0.875rem;
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
    }

    .partnership-header a:hover {
        color: #006400;
    }

    .partnership-alert {
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    .partnership-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .partnership-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .partnership-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .partnership-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .partnership-card-subtitle {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 1.25rem;
    }

    .partnership-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.375rem;
    }

    .partnership-input,
    .partnership-textarea {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        background: #ffffff;
        color: #111827;
    }

    .partnership-input:focus,
    .partnership-textarea:focus {
        outline: none;
        border-color: #006400;
        box-shadow: 0 0 0 3px rgba(0, 100, 0, 0.1);
    }

    .partnership-textarea {
        resize: vertical;
        min-height: 80px;
    }

    .partnership-help-text {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.375rem;
    }

    .partnership-submit {
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

    .partnership-submit:hover {
        background: #005500;
        box-shadow: 0 4px 12px rgba(0, 100, 0, 0.3);
    }

    .partnership-submit i {
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

    .btn-add-item {
        background: #f3f4f6;
        border: 1px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #4b5563;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        text-align: center;
    }

    .btn-add-item:hover {
        background: #e5e7eb;
        border-color: #006400;
        color: #006400;
    }

    .btn-remove-item {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        transition: color 0.2s;
    }

    .btn-remove-item:hover {
        color: #dc2626;
    }

    .item-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        position: relative;
    }

    .item-card .btn-remove-item {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .grid-2,
        .grid-3 {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="partnership-container">

    {{-- HEADER --}}
    <div class="partnership-header">
        <h1>Edit Pemanfaatan & Kerjasama</h1>
        <a href="{{ route('partnership') }}" target="_blank">
            <i class="fas fa-external-link-alt mr-1"></i> Lihat Halaman
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="partnership-alert partnership-alert-success">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600"></i>
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
        <div class="partnership-alert partnership-alert-error">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
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
    <form action="{{ route('admin.halaman.update.partnership') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI (2/3) --}}
            <div class="lg:col-span-2">

                {{-- INFORMASI DASAR --}}
                <div class="partnership-card">
                    <h2 class="partnership-card-title">Informasi Dasar</h2>
                    <p class="partnership-card-subtitle">Informasi utama halaman Pemanfaatan & Kerjasama.</p>

                    <div class="space-y-4">
                        <div>
                            <label class="partnership-label">Judul Halaman <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul', $halaman->judul) }}"
                                class="partnership-input" required>
                        </div>

                        <div>
                            <label class="partnership-label">Deskripsi Halaman <span class="text-red-500">*</span></label>
                            <textarea name="isi" rows="4" class="partnership-textarea" required>{{ old('isi', $halaman->isi) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SKEMA PEMANFAATAN --}}
                <div class="partnership-card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="partnership-card-title">Skema Pemanfaatan</h2>
                            <p class="partnership-card-subtitle">Kelola skema pemanfaatan yang ditampilkan.</p>
                        </div>
                        <button type="button" onclick="addItem('skema')" class="btn-add-item" style="width:auto;padding:0.5rem 1rem;">
                            <i class="fas fa-plus mr-1"></i> Tambah Skema
                        </button>
                    </div>

                    <div id="skema-container">
                        @php
                            $skema = old('skema_pemanfaatan', $halaman->skema_pemanfaatan ?? []);
                            if (empty($skema)) {
                                $skema = [
                                    ['icon' => 'fa-city', 'title' => 'Pemanfaatan untuk Kegiatan Usaha', 'description' => 'Pemanfaatan aset tanah untuk mendukung kegiatan usaha dan pengembangan kawasan sesuai ketentuan yang berlaku.'],
                                    ['icon' => 'fa-handshake-angle', 'title' => 'Kerja Sama Pemanfaatan Aset', 'description' => 'Bentuk kerja sama antara Badan Bank Tanah dengan mitra untuk mengoptimalkan pemanfaatan aset tanah.'],
                                    ['icon' => 'fa-chart-line', 'title' => 'Kemitraan Investasi', 'description' => 'Peluang kerja sama dengan mitra dalam pengembangan aset untuk kegiatan yang produktif dan berkelanjutan.'],
                                ];
                            }
                        @endphp

                        @foreach ($skema as $index => $item)
                            <div class="item-card skema-item">
                                <button type="button" onclick="removeItem(this, 'skema')" class="btn-remove-item">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="grid-2">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Icon (Font Awesome)</label>
                                        <input type="text" name="skema_pemanfaatan[{{ $index }}][icon]"
                                            value="{{ $item['icon'] ?? 'fa-city' }}"
                                            placeholder="fa-city"
                                            class="partnership-input text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                                        <input type="text" name="skema_pemanfaatan[{{ $index }}][title]"
                                            value="{{ $item['title'] ?? '' }}"
                                            placeholder="Judul skema"
                                            class="partnership-input text-sm">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                                    <textarea name="skema_pemanfaatan[{{ $index }}][description]" rows="2"
                                        class="partnership-textarea text-sm">{{ $item['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- BENTUK KERJASAMA --}}
                <div class="partnership-card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="partnership-card-title">Bentuk Kerjasama</h2>
                            <p class="partnership-card-subtitle">Kelola bentuk kerjasama yang ditampilkan.</p>
                        </div>
                        <button type="button" onclick="addItem('kerjasama')" class="btn-add-item" style="width:auto;padding:0.5rem 1rem;">
                            <i class="fas fa-plus mr-1"></i> Tambah Bentuk
                        </button>
                    </div>

                    <div id="kerjasama-container">
                        @php
                            $kerjasama = old('bentuk_kerjasama', $halaman->bentuk_kerjasama ?? []);
                            if (empty($kerjasama)) {
                                $kerjasama = [
                                    ['number' => '01', 'title' => 'Kerja Sama Pengembangan', 'description' => 'Kerja sama dalam pengembangan aset tanah menjadi kawasan atau kegiatan produktif.'],
                                    ['number' => '02', 'title' => 'Kerja Sama Operasional', 'description' => 'Kerja sama untuk mendukung pengelolaan dan operasional pemanfaatan aset.'],
                                    ['number' => '03', 'title' => 'Kemitraan Strategis', 'description' => 'Kemitraan dengan pihak yang memiliki kompetensi, sumber daya, atau investasi yang relevan.'],
                                ];
                            }
                        @endphp

                        @foreach ($kerjasama as $index => $item)
                            <div class="item-card kerjasama-item">
                                <button type="button" onclick="removeItem(this, 'kerjasama')" class="btn-remove-item">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="grid-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor</label>
                                        <input type="text" name="bentuk_kerjasama[{{ $index }}][number]"
                                            value="{{ $item['number'] ?? '' }}"
                                            placeholder="01"
                                            class="partnership-input text-sm">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                                        <input type="text" name="bentuk_kerjasama[{{ $index }}][title]"
                                            value="{{ $item['title'] ?? '' }}"
                                            placeholder="Judul bentuk kerjasama"
                                            class="partnership-input text-sm">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                                    <textarea name="bentuk_kerjasama[{{ $index }}][description]" rows="2"
                                        class="partnership-textarea text-sm">{{ $item['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- PROSEDUR & TAHAPAN --}}
                <div class="partnership-card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="partnership-card-title">Prosedur & Tahapan</h2>
                            <p class="partnership-card-subtitle">Kelola prosedur dan tahapan yang ditampilkan.</p>
                        </div>
                        <button type="button" onclick="addItem('prosedur')" class="btn-add-item" style="width:auto;padding:0.5rem 1rem;">
                            <i class="fas fa-plus mr-1"></i> Tambah Tahapan
                        </button>
                    </div>

                    <div id="prosedur-container">
                        @php
                            $prosedur = old('prosedur_tahapan', $halaman->prosedur_tahapan ?? []);
                            if (empty($prosedur)) {
                                $prosedur = [
                                    ['number' => '01', 'icon' => 'fa-map-location-dot', 'title' => 'Temukan Aset', 'description' => 'Cari dan lihat informasi aset persediaan tanah yang sesuai dengan kebutuhan.'],
                                    ['number' => '02', 'icon' => 'fa-book-open', 'title' => 'Pelajari Skema', 'description' => 'Pahami pilihan pemanfaatan dan bentuk kerja sama yang tersedia.'],
                                    ['number' => '03', 'icon' => 'fa-file-circle-check', 'title' => 'Siapkan Persyaratan', 'description' => 'Pelajari persyaratan dan dokumen yang diperlukan untuk proses selanjutnya.'],
                                    ['number' => '04', 'icon' => 'fa-headset', 'title' => 'Hubungi Badan Bank Tanah', 'description' => 'Sampaikan kebutuhan dan lanjutkan komunikasi melalui kanal kontak yang tersedia.'],
                                ];
                            }
                        @endphp

                        @foreach ($prosedur as $index => $item)
                            <div class="item-card prosedur-item">
                                <button type="button" onclick="removeItem(this, 'prosedur')" class="btn-remove-item">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="grid-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor</label>
                                        <input type="text" name="prosedur_tahapan[{{ $index }}][number]"
                                            value="{{ $item['number'] ?? '' }}"
                                            placeholder="01"
                                            class="partnership-input text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Icon</label>
                                        <input type="text" name="prosedur_tahapan[{{ $index }}][icon]"
                                            value="{{ $item['icon'] ?? 'fa-circle' }}"
                                            placeholder="fa-map-location-dot"
                                            class="partnership-input text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                                        <input type="text" name="prosedur_tahapan[{{ $index }}][title]"
                                            value="{{ $item['title'] ?? '' }}"
                                            placeholder="Judul tahapan"
                                            class="partnership-input text-sm">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                                    <textarea name="prosedur_tahapan[{{ $index }}][description]" rows="2"
                                        class="partnership-textarea text-sm">{{ $item['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- PERSYARATAN --}}
                <div class="partnership-card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="partnership-card-title">Persyaratan</h2>
                            <p class="partnership-card-subtitle">Kelola daftar persyaratan.</p>
                        </div>
                        <button type="button" onclick="addItem('persyaratan')" class="btn-add-item" style="width:auto;padding:0.5rem 1rem;">
                            <i class="fas fa-plus mr-1"></i> Tambah Persyaratan
                        </button>
                    </div>

                    <div id="persyaratan-container">
                        @php
                            $persyaratan = old('persyaratan', $halaman->persyaratan ?? []);
                            if (empty($persyaratan)) {
                                $persyaratan = [
                                    'Identitas atau profil calon mitra.',
                                    'Penjelasan tujuan pemanfaatan aset.',
                                    'Rencana kegiatan atau usaha.',
                                    'Informasi kebutuhan lokasi dan luas tanah.',
                                    'Dokumen pendukung sesuai jenis kerja sama.',
                                ];
                            }
                        @endphp

                        @foreach ($persyaratan as $index => $item)
                            <div class="item-card persyaratan-item">
                                <button type="button" onclick="removeItem(this, 'persyaratan')" class="btn-remove-item">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Persyaratan</label>
                                    <input type="text" name="persyaratan[{{ $index }}]"
                                        value="{{ $item }}"
                                        placeholder="Masukkan persyaratan"
                                        class="partnership-input text-sm">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- DOKUMEN PENDUKUNG --}}
                <div class="partnership-card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="partnership-card-title">Dokumen Pendukung</h2>
                            <p class="partnership-card-subtitle">Kelola daftar dokumen pendukung.</p>
                        </div>
                        <button type="button" onclick="addItem('dokumen')" class="btn-add-item" style="width:auto;padding:0.5rem 1rem;">
                            <i class="fas fa-plus mr-1"></i> Tambah Dokumen
                        </button>
                    </div>

                    <div id="dokumen-container">
                        @php
                            $dokumen = old('dokumen_pendukung', $halaman->dokumen_pendukung ?? []);
                            if (empty($dokumen)) {
                                $dokumen = [
                                    'Profil calon mitra atau badan usaha.',
                                    'Proposal pemanfaatan atau rencana kegiatan.',
                                    'Dokumen legalitas yang relevan.',
                                    'Dokumen teknis pendukung.',
                                    'Dokumen lain sesuai skema kerja sama.',
                                ];
                            }
                        @endphp

                        @foreach ($dokumen as $index => $item)
                            <div class="item-card dokumen-item">
                                <button type="button" onclick="removeItem(this, 'dokumen')" class="btn-remove-item">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Dokumen</label>
                                    <input type="text" name="dokumen_pendukung[{{ $index }}]"
                                        value="{{ $item }}"
                                        placeholder="Masukkan dokumen pendukung"
                                        class="partnership-input text-sm">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- FAQ PEMANFAATAN --}}
                <div class="partnership-card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="partnership-card-title">FAQ Pemanfaatan</h2>
                            <p class="partnership-card-subtitle">Kelola pertanyaan dan jawaban FAQ.</p>
                        </div>
                        <button type="button" onclick="addItem('faq')" class="btn-add-item" style="width:auto;padding:0.5rem 1rem;">
                            <i class="fas fa-plus mr-1"></i> Tambah FAQ
                        </button>
                    </div>

                    <div id="faq-container">
                        @php
                            $faq = old('faq_pemanfaatan', $halaman->faq_pemanfaatan ?? []);
                            if (empty($faq)) {
                                $faq = [
                                    ['question' => 'Bagaimana cara melihat aset yang tersedia?', 'answer' => 'Pengunjung dapat membuka halaman Aset Persediaan Tanah untuk melihat daftar aset dan informasi lokasi, luas, peruntukan, skema, serta status aset.'],
                                    ['question' => 'Bagaimana mengetahui skema yang sesuai?', 'answer' => 'Pelajari informasi skema pemanfaatan dan bentuk kerja sama pada halaman ini, kemudian sesuaikan dengan kebutuhan pemanfaatan aset yang dipilih.'],
                                    ['question' => 'Apa saja dokumen yang diperlukan?', 'answer' => 'Persyaratan dan dokumen dapat berbeda berdasarkan kebutuhan dan bentuk kerja sama. Informasi pada halaman ini merupakan contoh data dummy dan perlu disesuaikan dengan ketentuan resmi.'],
                                    ['question' => 'Bagaimana cara melanjutkan proses?', 'answer' => 'Setelah memahami aset dan skema yang dibutuhkan, calon mitra dapat menghubungi Badan Bank Tanah melalui kanal kontak yang tersedia untuk memperoleh informasi lebih lanjut.'],
                                ];
                            }
                        @endphp

                        @foreach ($faq as $index => $item)
                            <div class="item-card faq-item">
                                <button type="button" onclick="removeItem(this, 'faq')" class="btn-remove-item">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="space-y-2">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pertanyaan</label>
                                        <input type="text" name="faq_pemanfaatan[{{ $index }}][question]"
                                            value="{{ $item['question'] ?? '' }}"
                                            placeholder="Masukkan pertanyaan"
                                            class="partnership-input text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jawaban</label>
                                        <textarea name="faq_pemanfaatan[{{ $index }}][answer]" rows="2"
                                            class="partnership-textarea text-sm">{{ $item['answer'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN (1/3) --}}
            <div class="space-y-6">

                {{-- STATUS --}}
                <div class="partnership-card">
                    <h2 class="partnership-card-title">Status Halaman</h2>
                    <p class="partnership-card-subtitle">Aktifkan atau nonaktifkan halaman.</p>

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
                    <p class="partnership-help-text mt-2">Halaman yang tidak aktif tidak akan ditampilkan di frontend.</p>
                </div>

                {{-- GAMBAR --}}
                <div class="partnership-card">
                    <h2 class="partnership-card-title">Gambar Halaman</h2>
                    <p class="partnership-card-subtitle">Upload gambar untuk halaman.</p>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#006400] transition cursor-pointer"
                         onclick="document.getElementById('gambarInput').click()">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600">Upload gambar</p>
                        <p class="text-xs text-gray-400">Format: JPG, PNG (Max 2MB)</p>
                        <input type="file" id="gambarInput" name="gambar" accept="image/jpeg,image/png,image/jpg"
                            class="hidden" onchange="document.getElementById('gambarName').textContent = this.files[0]?.name || 'Belum ada file'">
                        <p id="gambarName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                    </div>

                    @if ($halaman->gambar)
                        <div class="mt-4">
                            <p class="text-xs text-gray-500 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $halaman->gambar) }}" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-400 mt-1">{{ basename($halaman->gambar) }}</p>
                        </div>
                    @endif
                </div>

                {{-- TOMBOL SIMPAN --}}
                <button type="submit" class="partnership-submit">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>

</div>

<script>
    let skemaIndex = {{ count(old('skema_pemanfaatan', $halaman->skema_pemanfaatan ?? [])) }};
    let kerjasamaIndex = {{ count(old('bentuk_kerjasama', $halaman->bentuk_kerjasama ?? [])) }};
    let prosedurIndex = {{ count(old('prosedur_tahapan', $halaman->prosedur_tahapan ?? [])) }};
    let persyaratanIndex = {{ count(old('persyaratan', $halaman->persyaratan ?? [])) }};
    let dokumenIndex = {{ count(old('dokumen_pendukung', $halaman->dokumen_pendukung ?? [])) }};
    let faqIndex = {{ count(old('faq_pemanfaatan', $halaman->faq_pemanfaatan ?? [])) }};

    function addItem(type) {
        const container = document.getElementById(type + '-container');
        if (!container) return;

        const index = getIndex(type);
        const div = document.createElement('div');
        div.className = 'item-card ' + type + '-item';

        let html = '';
        html += `<button type="button" onclick="removeItem(this, '${type}')" class="btn-remove-item"><i class="fas fa-times"></i></button>`;

        if (type === 'skema') {
            html += `
                <div class="grid-2">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Icon (Font Awesome)</label>
                        <input type="text" name="skema_pemanfaatan[${index}][icon]" placeholder="fa-city" class="partnership-input text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                        <input type="text" name="skema_pemanfaatan[${index}][title]" placeholder="Judul skema" class="partnership-input text-sm">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                    <textarea name="skema_pemanfaatan[${index}][description]" rows="2" class="partnership-textarea text-sm"></textarea>
                </div>
            `;
        } else if (type === 'kerjasama') {
            html += `
                <div class="grid-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor</label>
                        <input type="text" name="bentuk_kerjasama[${index}][number]" placeholder="01" class="partnership-input text-sm">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                        <input type="text" name="bentuk_kerjasama[${index}][title]" placeholder="Judul bentuk kerjasama" class="partnership-input text-sm">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                    <textarea name="bentuk_kerjasama[${index}][description]" rows="2" class="partnership-textarea text-sm"></textarea>
                </div>
            `;
        } else if (type === 'prosedur') {
            html += `
                <div class="grid-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor</label>
                        <input type="text" name="prosedur_tahapan[${index}][number]" placeholder="01" class="partnership-input text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Icon</label>
                        <input type="text" name="prosedur_tahapan[${index}][icon]" placeholder="fa-map-location-dot" class="partnership-input text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                        <input type="text" name="prosedur_tahapan[${index}][title]" placeholder="Judul tahapan" class="partnership-input text-sm">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                    <textarea name="prosedur_tahapan[${index}][description]" rows="2" class="partnership-textarea text-sm"></textarea>
                </div>
            `;
        } else if (type === 'persyaratan') {
            html += `
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Persyaratan</label>
                    <input type="text" name="persyaratan[${index}]" placeholder="Masukkan persyaratan" class="partnership-input text-sm">
                </div>
            `;
        } else if (type === 'dokumen') {
            html += `
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Dokumen</label>
                    <input type="text" name="dokumen_pendukung[${index}]" placeholder="Masukkan dokumen pendukung" class="partnership-input text-sm">
                </div>
            `;
        } else if (type === 'faq') {
            html += `
                <div class="space-y-2">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pertanyaan</label>
                        <input type="text" name="faq_pemanfaatan[${index}][question]" placeholder="Masukkan pertanyaan" class="partnership-input text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jawaban</label>
                        <textarea name="faq_pemanfaatan[${index}][answer]" rows="2" class="partnership-textarea text-sm"></textarea>
                    </div>
                </div>
            `;
        }

        div.innerHTML = html;
        container.appendChild(div);
    }

    function removeItem(button, type) {
        const item = button.closest('.item-card');
        const container = document.getElementById(type + '-container');
        if (item && container && container.children.length > 1) {
            item.remove();
        } else {
            alert('Minimal harus ada 1 item.');
        }
    }

    function getIndex(type) {
        let index = 0;
        if (type === 'skema') index = skemaIndex++;
        else if (type === 'kerjasama') index = kerjasamaIndex++;
        else if (type === 'prosedur') index = prosedurIndex++;
        else if (type === 'persyaratan') index = persyaratanIndex++;
        else if (type === 'dokumen') index = dokumenIndex++;
        else if (type === 'faq') index = faqIndex++;
        return index;
    }

    // Toggle status checkbox
    document.querySelector('input[name="is_active"]')?.addEventListener('change', function() {
        const label = this.parentElement.nextElementSibling;
        if (label) {
            const span = label.querySelector('span');
            if (span) {
                span.textContent = this.checked ? 'Aktif' : 'Tidak Aktif';
                span.className = this.checked ? 'text-green-600' : 'text-gray-400';
            }
        }
    });

    // File name display
    document.getElementById('gambarInput')?.addEventListener('change', function() {
        document.getElementById('gambarName').textContent = this.files[0]?.name || 'Belum ada file';
    });
</script>

@endsection