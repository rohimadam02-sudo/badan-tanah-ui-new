@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center">
            <i class="fas fa-gear text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola pengaturan tampilan dan konfigurasi website.</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 mb-6">
        <button type="button" onclick="showTab('umum')" class="tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-[#006400] text-[#006400" id="tab-umum">
            <i class="fas fa-sliders-h mr-1.5"></i> Umum
        </button>
        <button type="button" onclick="showTab('tampilan')" class="tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700" id="tab-tampilan">
            <i class="fas fa-palette mr-1.5"></i> Tampilan
        </button>
        <button type="button" onclick="showTab('seo')" class="tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700" id="tab-seo">
            <i class="fas fa-magnifying-glass mr-1.5"></i> SEO
        </button>
    </div>

    <!-- Tab Content -->
    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- TAB 1: UMUM -->
        <div id="tab-content-umum" class="tab-section bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="font-bold text-lg text-gray-900 mb-5">Pengaturan Umum</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Website</label>
                    <input type="text" name="nama_website" value="{{ old('nama_website', $pengaturan->nama_website ?? 'Badan Bank Tanah') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Website</label>
                    <textarea name="deskripsi_website" rows="3"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('deskripsi_website', $pengaturan->deskripsi_website ?? 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Timezone</label>
                        <select name="timezone" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                            <option value="Asia/Jakarta" selected>Asia/Jakarta (WIB)</option>
                            <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                            <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bahasa</label>
                        <select name="bahasa" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                            <option value="id" selected>Bahasa Indonesia</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1"
                        {{ old('maintenance_mode', $pengaturan->maintenance_mode ?? false) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    <label for="maintenance_mode" class="text-sm font-medium text-gray-700">Mode Pemeliharaan</label>
                </div>
                <p class="text-xs text-gray-400 -mt-1 pl-7">Jika diaktifkan, website hanya bisa diakses oleh admin</p>
            </div>
        </div>

        <!-- TAB 2: TAMPILAN -->
        <div id="tab-content-tampilan" class="tab-section bg-white rounded-xl shadow-sm border border-gray-200 p-6 hidden">
            <h2 class="font-bold text-lg text-gray-900 mb-5">Pengaturan Tampilan</h2>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Warna Utama</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="warna_utama" value="{{ old('warna_utama', $pengaturan->warna_utama ?? '#0B2A4A') }}"
                                class="w-14 h-14 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" name="warna_utama_text" value="{{ old('warna_utama', $pengaturan->warna_utama ?? '#0B2A4A') }}"
                                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Warna Sekunder</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="warna_sekunder" value="{{ old('warna_sekunder', $pengaturan->warna_sekunder ?? '#1D4ED8') }}"
                                class="w-14 h-14 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" name="warna_sekunder_text" value="{{ old('warna_sekunder', $pengaturan->warna_sekunder ?? '#1D4ED8') }}"
                                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Logo Website</label>
                    <div class="flex items-center gap-4">
                        @if ($pengaturan->logo ?? false)
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" class="w-16 h-16 object-contain border border-gray-200 rounded-lg">
                        @endif
                        <div class="flex-1">
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#006400] transition cursor-pointer"
                                 onclick="document.getElementById('logoInput').click()">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Upload logo baru</p>
                                <p class="text-xs text-gray-400">Format: JPG, PNG, SVG (Max 2MB)</p>
                                <input type="file" id="logoInput" name="logo" accept="image/jpeg,image/png,image/svg+xml" class="hidden"
                                       onchange="document.getElementById('logoName').textContent = this.files[0]?.name || 'Belum ada file'">
                                <p id="logoName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: SEO -->
        <div id="tab-content-seo" class="tab-section bg-white rounded-xl shadow-sm border border-gray-200 p-6 hidden">
            <h2 class="font-bold text-lg text-gray-900 mb-5">Pengaturan SEO</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Title Default</label>
                    <input type="text" name="meta_title_default" value="{{ old('meta_title_default', $pengaturan->meta_title_default ?? 'Badan Bank Tanah - Mengelola Tanah, Memajukan Negeri') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    <p class="text-right text-xs text-gray-400 mt-1"><span id="metaTitleCount">0</span>/60</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description Default</label>
                    <textarea name="meta_description_default" rows="3"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('meta_description_default', $pengaturan->meta_description_default ?? 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.') }}</textarea>
                    <p class="text-right text-xs text-gray-400 mt-1"><span id="metaDescCount">0</span>/160</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keywords</label>
                    <input type="text" name="keywords" value="{{ old('keywords', $pengaturan->keywords ?? 'Badan Bank Tanah, Aset Tanah, Pemanfaatan Tanah, Investasi Tanah, Reforma Agraria') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                        placeholder="Pisahkan dengan koma">
                    <p class="text-xs text-gray-400 mt-1">Pisahkan setiap keyword dengan tanda koma (,)</p>
                </div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                <i class="fas fa-save mr-1.5"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
    // Tab Switcher
    function showTab(tabName) {
        // Sembunyikan semua tab content
        document.querySelectorAll('.tab-section').forEach(el => {
            el.classList.add('hidden');
        });

        // Tampilkan tab yang dipilih
        document.getElementById('tab-content-' + tabName).classList.remove('hidden');

        // Update button active
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('border-[#006400]', 'text-[#006400]');
            el.classList.add('border-transparent', 'text-gray-500');
        });
        document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tab-' + tabName).classList.add('border-[#006400]', 'text-[#006400]');
    }

    // SEO Character Counter
    document.addEventListener('DOMContentLoaded', function() {
        const metaTitle = document.querySelector('input[name="meta_title_default"]');
        const metaDesc = document.querySelector('textarea[name="meta_description_default"]');
        const titleCount = document.getElementById('metaTitleCount');
        const descCount = document.getElementById('metaDescCount');

        if (metaTitle && titleCount) {
            titleCount.textContent = metaTitle.value.length;
            metaTitle.addEventListener('input', function() {
                titleCount.textContent = this.value.length;
            });
        }

        if (metaDesc && descCount) {
            descCount.textContent = metaDesc.value.length;
            metaDesc.addEventListener('input', function() {
                descCount.textContent = this.value.length;
            });
        }

        // Warna sync
        const warnaUtama = document.querySelector('input[name="warna_utama"]');
        const warnaUtamaText = document.querySelector('input[name="warna_utama_text"]');
        if (warnaUtama && warnaUtamaText) {
            warnaUtama.addEventListener('input', function() {
                warnaUtamaText.value = this.value;
            });
            warnaUtamaText.addEventListener('input', function() {
                warnaUtama.value = this.value;
            });
        }

        const warnaSekunder = document.querySelector('input[name="warna_sekunder"]');
        const warnaSekunderText = document.querySelector('input[name="warna_sekunder_text"]');
        if (warnaSekunder && warnaSekunderText) {
            warnaSekunder.addEventListener('input', function() {
                warnaSekunderText.value = this.value;
            });
            warnaSekunderText.addEventListener('input', function() {
                warnaSekunder.value = this.value;
            });
        }
    });
</script>

@endsection