@extends('layouts.admin')

@section('title', 'Edit Microsite')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Microsite</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi microsite.</p>
        </div>
        <a href="{{ route('admin.microsite.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">
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

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.microsite.update', $microsite->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $microsite->judul) }}"
                        placeholder="Masukkan judul microsite"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                        required>
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $microsite->slug) }}"
                        placeholder="url-slug"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk generate otomatis dari judul.</p>
                </div>

                <!-- Konten -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea name="konten" rows="8"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                        required>{{ old('konten', $microsite->konten) }}</textarea>
                </div>

                <!-- Gambar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gambar</label>
                    @if ($microsite->gambar)
                        <div class="mb-3 p-3 bg-gray-50 rounded-xl border border-gray-200 flex items-center gap-3">
                            <img src="{{ asset('storage/' . $microsite->gambar) }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                            <div>
                                <p class="text-xs font-medium text-gray-700">Gambar saat ini</p>
                                <a href="{{ asset('storage/' . $microsite->gambar) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat gambar</a>
                            </div>
                        </div>
                    @endif
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#006400] transition cursor-pointer"
                         onclick="document.getElementById('gambarInput').click()">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600">Upload gambar baru</p>
                        <p class="text-xs text-gray-400">Format: JPG, PNG (Max 2MB)</p>
                        <input type="file" id="gambarInput" name="gambar" accept="image/jpeg,image/png,image/jpg"
                            class="hidden" onchange="document.getElementById('gambarName').textContent = this.files[0]?.name || 'Belum ada file'">
                        <p id="gambarName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">* Kosongkan jika tidak ingin mengubah gambar</p>
                </div>

                <!-- Meta Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $microsite->meta_title) }}"
                        placeholder="Meta title untuk SEO"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>

                <!-- Meta Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description</label>
                    <input type="text" name="meta_description" value="{{ old('meta_description', $microsite->meta_description) }}"
                        placeholder="Meta description untuk SEO"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>

                <!-- SEO Keywords -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">SEO Keywords</label>
                    <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $microsite->seo_keywords) }}"
                        placeholder="keyword1, keyword2, keyword3"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>

                <!-- Layout -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Layout</label>
                    <select name="layout" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        <option value="default" {{ old('layout', $microsite->layout) == 'default' ? 'selected' : '' }}>Default</option>
                        <option value="full-width" {{ old('layout', $microsite->layout) == 'full-width' ? 'selected' : '' }}>Full Width</option>
                        <option value="centered" {{ old('layout', $microsite->layout) == 'centered' ? 'selected' : '' }}>Centered</option>
                    </select>
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $microsite->tanggal_mulai ? date('Y-m-d', strtotime($microsite->tanggal_mulai)) : '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $microsite->tanggal_selesai ? date('Y-m-d', strtotime($microsite->tanggal_selesai)) : '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>

                <!-- Custom CSS -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Custom CSS</label>
                    <textarea name="custom_css" rows="3" placeholder="Tambahkan custom CSS untuk microsite ini..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('custom_css', $microsite->custom_css) }}</textarea>
                </div>

                <!-- Custom JS -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Custom JavaScript</label>
                    <textarea name="custom_js" rows="3" placeholder="Tambahkan custom JavaScript untuk microsite ini..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('custom_js', $microsite->custom_js) }}</textarea>
                </div>
            </div>

            <!-- Checkboxes -->
            <div class="mt-6 flex flex-wrap items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $microsite->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    <span class="text-sm font-medium text-gray-700">Aktif</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1"
                        {{ old('is_featured', $microsite->is_featured) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    <span class="text-sm font-medium text-gray-700">Featured</span>
                </label>
            </div>

            <!-- Tombol -->
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.microsite.index') }}" 
                    class="border border-gray-300 rounded-xl px-6 py-3 text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" 
                    class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-1.5"></i>
                    Update Microsite
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
