@extends('layouts.admin')

@section('title', 'Edit Lokasi Kantor')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Lokasi Kantor</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi lokasi kantor.</p>
        </div>
        <a href="{{ route('admin.lokasi-kantor.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
    </div>

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
        <form action="{{ route('admin.lokasi-kantor.update', $lokasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $lokasi->nama) }}"
                           placeholder="Contoh: Kantor Pusat"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                           required>
                    @error('nama')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="alamat" value="{{ old('alamat', $lokasi->alamat) }}"
                           placeholder="Jl. H. Juanda No. 15, Jakarta Pusat"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                           required>
                    @error('alamat')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Latitude -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Latitude <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.0000001" name="lat" value="{{ old('lat', $lokasi->lat) }}"
                           placeholder="-6.1754"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                           required>
                    @error('lat')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Longitude -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Longitude <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.0000001" name="lng" value="{{ old('lng', $lokasi->lng) }}"
                           placeholder="106.8272"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                           required>
                    @error('lng')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $lokasi->telepon) }}"
                           placeholder="(021) 3456-7890"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    @error('telepon')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $lokasi->email) }}"
                           placeholder="info@bantah.go.id"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat lokasi..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('deskripsi', $lokasi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Kerja -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Kerja</label>
                    <input type="text" name="jam_kerja" value="{{ old('jam_kerja', $lokasi->jam_kerja) }}"
                           placeholder="Senin-Jumat: 08:00 - 16:00"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    @error('jam_kerja')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Icon</label>
                    <input type="text" name="icon" value="{{ old('icon', $lokasi->icon) }}"
                           placeholder="fa-building"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    <p class="text-xs text-gray-400 mt-1.5">Gunakan class Font Awesome. Contoh: <code>fa-building</code></p>
                    @error('icon')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Warna</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="warna" id="warnaPicker" value="{{ old('warna', $lokasi->warna ?? '#006400') }}"
                               class="w-14 h-14 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" name="warna" id="warnaText" value="{{ old('warna', $lokasi->warna ?? '#006400') }}"
                               placeholder="#006400"
                               class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">Warna marker di peta.</p>
                    @error('warna')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Checkboxes -->
            <div class="mt-6 flex flex-wrap items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $lokasi->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    <span class="text-sm font-medium text-gray-700">Aktif</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_utama" value="1"
                           {{ old('is_utama', $lokasi->is_utama) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    <span class="text-sm font-medium text-gray-700">Kantor Utama</span>
                </label>
            </div>

            <!-- Tombol -->
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.lokasi-kantor.index') }}" 
                   class="border border-gray-300 rounded-xl px-6 py-3 text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" 
                        class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-1.5"></i>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const picker = document.getElementById('warnaPicker');
    const text = document.getElementById('warnaText');
    
    if (picker && text) {
        picker.addEventListener('input', function() {
            text.value = this.value;
        });
        text.addEventListener('input', function() {
            picker.value = this.value;
        });
    }
});
</script>

@endsection