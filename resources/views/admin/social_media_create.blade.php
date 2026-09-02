@extends('layouts.admin')

@section('title', 'Tambah Social Media')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Social Media</h1>
            <p class="text-sm text-gray-500 mt-1">Tambahkan social media baru untuk footer website.</p>
        </div>
        <a href="{{ route('admin.social-media.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.social-media.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
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
                    <input type="text" name="icon" value="{{ old('icon') }}"
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
                    <input type="url" name="url" value="{{ old('url') }}"
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
                        <input type="color" name="warna" id="warnaPicker" value="{{ old('warna', '#6b7280') }}"
                               class="w-14 h-14 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" name="warna" id="warnaText" value="{{ old('warna', '#6b7280') }}"
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
                <input type="checkbox" name="is_active" id="is_active" value="1" checked
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
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- Daftar Icon Font Awesome -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-sm font-semibold text-gray-700 mb-2">Icon yang umum digunakan:</p>
        <div class="flex flex-wrap gap-3 text-sm">
            <span class="bg-gray-100 px-3 py-1 rounded-full"><code>fab fa-youtube</code></span>
            <span class="bg-gray-100 px-3 py-1 rounded-full"><code>fab fa-instagram</code></span>
            <span class="bg-gray-100 px-3 py-1 rounded-full"><code>fab fa-tiktok</code></span>
            <span class="bg-gray-100 px-3 py-1 rounded-full"><code>fab fa-linkedin-in</code></span>
            <span class="bg-gray-100 px-3 py-1 rounded-full"><code>fab fa-twitter</code></span>
            <span class="bg-gray-100 px-3 py-1 rounded-full"><code>fab fa-facebook-f</code></span>
            <span class="bg-gray-100 px-3 py-1 rounded-full"><code>fab fa-whatsapp</code></span>
            <span class="bg-gray-100 px-3 py-1 rounded-full"><code>fab fa-telegram</code></span>
        </div>
        <p class="text-xs text-gray-400 mt-2">Lihat semua icon di <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600 hover:underline">Font Awesome</a></p>
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