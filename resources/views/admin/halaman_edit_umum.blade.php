@extends('layouts.admin')

@section('title', 'Edit Halaman')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Halaman</h1>
    <a href="{{ route('admin.halaman.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
    </a>
</div>

@if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-6">
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

@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
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

<form action="{{ route('admin.halaman.update', $halaman->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI (2/3) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- INFORMASI DASAR --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-circle-info text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Informasi Dasar</h2>
                        <p class="text-xs text-gray-500">Informasi utama halaman.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Judul Halaman <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $halaman->judul) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Isi / Konten Halaman <span class="text-red-500">*</span>
                        </label>
                        <textarea name="isi" rows="8"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                            required>{{ old('isi', $halaman->isi) }}</textarea>
                    </div>

                    {{-- Visi (khusus halaman Tentang) --}}
                    @if (str_contains($halaman->judul, 'Tentang'))
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Visi</label>
                        <textarea name="visi" rows="4"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('visi', $halaman->visi) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Misi</label>
                        <textarea name="misi" rows="6"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('misi', $halaman->misi) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Struktur Organisasi</label>
                        <textarea name="struktur_organisasi" rows="8"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('struktur_organisasi', $halaman->struktur_organisasi) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Dasar Hukum</label>
                        <textarea name="dasar_hukum" rows="6"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('dasar_hukum', $halaman->dasar_hukum) }}</textarea>
                    </div>
                    @else
                        {{-- Hidden fields for non-Tentang pages --}}
                        <input type="hidden" name="visi" value="{{ $halaman->visi }}">
                        <input type="hidden" name="misi" value="{{ $halaman->misi }}">
                        <input type="hidden" name="struktur_organisasi" value="{{ $halaman->struktur_organisasi }}">
                        <input type="hidden" name="dasar_hukum" value="{{ $halaman->dasar_hukum }}">
                    @endif
                </div>
            </div>

            {{-- SEO --}}
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

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $halaman->meta_title) }}"
                            placeholder="Masukkan meta title"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        <p class="text-right text-xs text-gray-400 mt-1">0/60</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description</label>
                        <textarea name="meta_description" rows="3"
                            placeholder="Masukkan meta description"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('meta_description', $halaman->meta_description) }}</textarea>
                        <p class="text-right text-xs text-gray-400 mt-1">0/160</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Slug</label>
                        <div class="relative">
                            <span class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 text-sm">/</span>
                            <input type="text" name="slug" value="{{ old('slug', $halaman->slug ?? $halaman->judul) }}"
                                placeholder="url-slug"
                                class="w-full border border-gray-300 rounded-xl pl-7 pr-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5">
                            <i class="fas fa-info-circle mr-1"></i>
                            Akan digenerate otomatis dari judul jika dikosongkan.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- KOLOM KANAN (1/3) --}}
        <div class="space-y-6">

            {{-- STATUS --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                        <i class="fas fa-toggle-on text-green-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Status</h2>
                        <p class="text-xs text-gray-500">Atur status halaman.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $halaman->is_active) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#006400]/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#006400]"></div>
                        <span class="ms-3 text-sm font-medium text-gray-700">
                            <span class="{{ $halaman->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $halaman->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </span>
                    </label>
                </div>
                <p class="text-xs text-gray-400 mt-2">Halaman yang tidak aktif tidak akan ditampilkan di frontend.</p>
            </div>

            {{-- GAMBAR HERO --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                        <i class="fas fa-image text-green-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Gambar Hero</h2>
                        <p class="text-xs text-gray-500">Gambar utama halaman.</p>
                    </div>
                </div>

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#006400] transition cursor-pointer"
                     onclick="document.getElementById('gambarInput').click()">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">Upload gambar hero</p>
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

            {{-- FOTO TAMBAHAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                        <i class="fas fa-photo-film text-purple-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Foto Tambahan</h2>
                        <p class="text-xs text-gray-500">Foto tambahan untuk halaman.</p>
                    </div>
                </div>

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#006400] transition cursor-pointer"
                     onclick="document.getElementById('fotoInput').click()">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">Upload foto tambahan</p>
                    <p class="text-xs text-gray-400">Format: JPG, PNG (Max 2MB)</p>
                    <input type="file" id="fotoInput" name="foto" accept="image/jpeg,image/png,image/jpg"
                        class="hidden" onchange="document.getElementById('fotoName').textContent = this.files[0]?.name || 'Belum ada file'">
                    <p id="fotoName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                </div>

                @if ($halaman->foto)
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $halaman->foto) }}" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-400 mt-1">{{ basename($halaman->foto) }}</p>
                    </div>
                @endif
            </div>

            {{-- TOMBOL SIMPAN --}}
            <button type="submit" class="w-full bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                <i class="fas fa-save mr-1.5"></i>
                Simpan Perubahan
            </button>

        </div>

    </div>

</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle status checkbox
        const statusCheckbox = document.querySelector('input[name="is_active"]');
        const statusLabel = document.querySelector('input[name="is_active"] + div + span');

        if (statusCheckbox && statusLabel) {
            statusCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    statusLabel.textContent = 'Aktif';
                    statusLabel.className = 'ms-3 text-sm font-medium text-green-600';
                } else {
                    statusLabel.textContent = 'Tidak Aktif';
                    statusLabel.className = 'ms-3 text-sm font-medium text-gray-400';
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

        // SEO Character Counter
        const metaTitle = document.querySelector('input[name="meta_title"]');
        const metaDesc = document.querySelector('textarea[name="meta_description"]');

        if (metaTitle) {
            const titleCounter = metaTitle.closest('div').querySelector('.text-gray-400');
            if (titleCounter) {
                metaTitle.addEventListener('input', function() {
                    titleCounter.textContent = this.value.length + '/60';
                });
            }
        }

        if (metaDesc) {
            const descCounter = metaDesc.closest('div').querySelector('.text-gray-400');
            if (descCounter) {
                metaDesc.addEventListener('input', function() {
                    descCounter.textContent = this.value.length + '/160';
                });
            }
        }
    });
</script>
@endsection