@extends('layouts.admin')

@section('title', 'Tambah Proyek Investasi')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Proyek Investasi</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi proyek investasi Badan Bank Tanah.</p>
        </div>
        <a href="{{ route('admin.proyek-investasi.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">Kembali ke Daftar</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.proyek-investasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Judul Proyek <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}" 
                        placeholder="Masukkan judul proyek"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" 
                        required>
                    @error('judul')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" 
                        placeholder="Contoh: Batang, Jawa Tengah"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" 
                        required>
                    @error('lokasi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sektor -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Sektor <span class="text-red-500">*</span>
                    </label>
                    <select name="sektor" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" required>
                        <option value="">Pilih Sektor</option>
                        <option value="Industri" {{ old('sektor') == 'Industri' ? 'selected' : '' }}>Industri</option>
                        <option value="Pariwisata" {{ old('sektor') == 'Pariwisata' ? 'selected' : '' }}>Pariwisata</option>
                        <option value="Pertanian" {{ old('sektor') == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="Perumahan" {{ old('sektor') == 'Perumahan' ? 'selected' : '' }}>Perumahan</option>
                        <option value="Logistik" {{ old('sektor') == 'Logistik' ? 'selected' : '' }}>Logistik</option>
                        <option value="Energi" {{ old('sektor') == 'Energi' ? 'selected' : '' }}>Energi</option>
                    </select>
                    @error('sektor')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nilai Investasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nilai Investasi</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">Rp</span>
                        <input type="number" name="nilai_investasi" value="{{ old('nilai_investasi') }}" 
                            placeholder="0"
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ada</p>
                    @error('nilai_investasi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" required>
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Dalam Proses" {{ old('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Aktif -->
                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Aktif</label>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="5" placeholder="Tulis deskripsi proyek..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('deskripsi') }}</textarea>
                    <p class="text-right text-xs text-gray-400 mt-1"><span id="wordCount">0</span> kata</p>
                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gambar</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-[#006400] transition cursor-pointer" 
                         onclick="document.getElementById('gambarInput').click()">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="text-sm text-gray-600">Upload gambar proyek</p>
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max 2MB)</p>
                        <input type="file" id="gambarInput" name="gambar" accept="image/jpeg,image/png,image/jpg" 
                            class="hidden" onchange="document.getElementById('fileName').textContent = this.files[0]?.name || 'Belum ada file'">
                        <p id="fileName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                    </div>
                    @error('gambar')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol -->
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.proyek-investasi.index') }}" 
                    class="border border-gray-300 rounded-xl px-6 py-3 text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" 
                    class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-1.5"></i>
                    Simpan Proyek
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="deskripsi"]');
        const wordCount = document.getElementById('wordCount');
        if (textarea && wordCount) {
            textarea.addEventListener('input', function() {
                const text = this.value.trim();
                const words = text.length === 0 ? 0 : text.split(/\s+/).length;
                wordCount.textContent = words;
            });
        }
    });
</script>
@endsection