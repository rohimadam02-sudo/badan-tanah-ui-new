@extends('layouts.admin')

@section('title', 'Edit Dokumen')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Dokumen</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi dokumen.</p>
        </div>
        <a href="{{ route('admin.dokumen-kerjasama.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">Kembali ke Daftar</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.dokumen-kerjasama.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <!-- Judul -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Judul Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $dokumen->judul) }}" 
                        placeholder="Masukkan judul dokumen"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" 
                        required>
                    @error('judul')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" required>
                        <option value="booklet" {{ old('kategori', $dokumen->kategori) == 'booklet' ? 'selected' : '' }}>Booklet</option>
                        <option value="panduan" {{ old('kategori', $dokumen->kategori) == 'panduan' ? 'selected' : '' }}>Panduan</option>
                        <option value="brosur" {{ old('kategori', $dokumen->kategori) == 'brosur' ? 'selected' : '' }}>Brosur</option>
                        <option value="lainnya" {{ old('kategori', $dokumen->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">File PDF</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-[#006400] transition cursor-pointer" 
                         onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-file-pdf text-4xl text-red-500 mb-3"></i>
                        <p class="text-sm text-gray-600">Upload file PDF baru (kosongkan jika tidak diubah)</p>
                        <p class="text-xs text-gray-400 mt-1">Maksimal 10MB</p>
                        <input type="file" id="fileInput" name="file" accept=".pdf" 
                            class="hidden" onchange="document.getElementById('fileName').textContent = this.files[0]?.name || 'Belum ada file'">
                        <p id="fileName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                    </div>
                    @if ($dokumen->file_path)
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-file-pdf text-red-500 mr-1"></i>
                            File saat ini: <a href="{{ route('admin.dokumen-kerjasama.download', $dokumen->id) }}" 
                                              class="text-blue-600 hover:underline">{{ basename($dokumen->file_path) }}</a>
                            ({{ $dokumen->ukuran ?? 'Unknown' }})
                        </p>
                    @endif
                    @error('file')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Aktif -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                        {{ old('is_active', $dokumen->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Aktif</label>
                </div>
            </div>

            <!-- Tombol -->
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.dokumen-kerjasama.index') }}" 
                    class="border border-gray-300 rounded-xl px-6 py-3 text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" 
                    class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-1.5"></i>
                    Update Dokumen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection