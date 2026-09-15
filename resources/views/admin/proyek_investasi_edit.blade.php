@extends('layouts.admin')

@section('title', 'Edit Proyek Investasi')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Proyek Investasi</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi proyek investasi.</p>
        </div>
        <a href="{{ route('admin.proyek-investasi.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">Kembali ke Daftar</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.proyek-investasi.update', $proyek->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Judul Proyek <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $proyek->judul) }}" 
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
                    <input type="text" name="lokasi" value="{{ old('lokasi', $proyek->lokasi) }}" 
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
                        <option value="Industri" {{ old('sektor', $proyek->sektor) == 'Industri' ? 'selected' : '' }}>Industri</option>
                        <option value="Pariwisata" {{ old('sektor', $proyek->sektor) == 'Pariwisata' ? 'selected' : '' }}>Pariwisata</option>
                        <option value="Pertanian" {{ old('sektor', $proyek->sektor) == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="Perumahan" {{ old('sektor', $proyek->sektor) == 'Perumahan' ? 'selected' : '' }}>Perumahan</option>
                        <option value="Logistik" {{ old('sektor', $proyek->sektor) == 'Logistik' ? 'selected' : '' }}>Logistik</option>
                        <option value="Energi" {{ old('sektor', $proyek->sektor) == 'Energi' ? 'selected' : '' }}>Energi</option>
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
                        <input type="number" name="nilai_investasi" value="{{ old('nilai_investasi', $proyek->nilai_investasi) }}" 
                            placeholder="0"
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>
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
                        <option value="Aktif" {{ old('status', $proyek->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Dalam Proses" {{ old('status', $proyek->status) == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="Selesai" {{ old('status', $proyek->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Aktif -->
                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                        {{ old('is_active', $proyek->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Aktif</label>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="5" placeholder="Tulis deskripsi proyek..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('deskripsi', $proyek->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gambar</label>
                    @if ($proyek->gambar)
                        <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-gray-200 flex items-center gap-3">
                            <img src="{{ asset('storage/' . $proyek->gambar) }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                            <div>
                                <p class="text-xs font-medium text-gray-700">Gambar saat ini</p>
                                <a href="{{ asset('storage/' . $proyek->gambar) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat gambar</a>
                            </div>
                        </div>
                    @endif
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-[#006400] transition cursor-pointer" 
                         onclick="document.getElementById('gambarInput').click()">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="text-sm text-gray-600">Upload gambar baru (kosongkan jika tidak diubah)</p>
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
                    Update Proyek
                </button>
            </div>
        </form>
    </div>
</div>
@endsection