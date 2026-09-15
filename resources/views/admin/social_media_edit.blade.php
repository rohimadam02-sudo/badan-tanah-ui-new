@extends('layouts.admin')

@section('title', 'Edit Social Media')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Social Media</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi social media.</p>
        </div>
        <a href="{{ route('admin.social-media.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.social-media.update', $socialMedia->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $socialMedia->nama) }}"
                           placeholder="Contoh: YouTube, Instagram"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                           required>
                    @error('nama')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Icon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="icon" value="{{ old('icon', $socialMedia->icon) }}"
                           placeholder="Contoh: fab fa-youtube"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                           required>
                    <p class="text-xs text-gray-400 mt-1.5">Gunakan class Font Awesome. Contoh: <code>fab fa-youtube</code></p>
                    @error('icon')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        URL <span class="text-red-500">*</span>
                    </label>
                    <input type="url" name="url" value="{{ old('url', $socialMedia->url) }}"
                           placeholder="https://youtube.com/@..."
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                           required>
                    @error('url')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warna -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Warna (Opsional)
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="warna" id="warnaPicker" value="{{ old('warna', $socialMedia->warna ?? '#6b7280') }}"
                               class="w-14 h-14 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" name="warna" id="warnaText" value="{{ old('warna', $socialMedia->warna ?? '#6b7280') }}"
                               placeholder="#6b7280"
                               class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">Warna background icon social media.</p>
                    @error('warna')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Aktif -->
            <div class="mt-6 flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $socialMedia->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                <label for="is_active" class="text-sm font-medium text-gray-700">Aktif</label>
            </div>

            <!-- Tombol -->
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.social-media.index') }}" 
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