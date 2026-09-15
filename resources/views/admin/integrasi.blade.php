@extends('layouts.admin')

@section('title', 'Integrasi')

@section('content')

<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
            <i class="fas fa-plug text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Integrasi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola integrasi dengan sistem dan layanan pihak ketiga.</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.integrasi.update') }}" method="POST">
            @csrf

            <div class="space-y-6">

                <!-- Google Analytics -->
                <div class="border-b border-gray-100 pb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-google"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">Google Analytics</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Masukkan Tracking ID Google Analytics untuk memantau traffic website.</p>
                            <div class="mt-3">
                                <input type="text" name="google_analytics" value="{{ old('google_analytics', $pengaturan->google_analytics ?? '') }}"
                                    placeholder="G-XXXXXXXXXX"
                                    class="w-full max-w-md border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                                <p class="text-xs text-gray-400 mt-1.5">Contoh: G-1234567890</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kimi K2.5 API -->
                <div class="border-b border-gray-100 pb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">Kimi K2.5 API</h3>
                            <p class="text-sm text-gray-500 mt-0.5">API Key untuk fitur auto-translate konten publikasi.</p>
                            <div class="mt-3">
                                <input type="text" name="kimi_api_key" value="{{ old('kimi_api_key', $pengaturan->kimi_api_key ?? '') }}"
                                    placeholder="Masukkan API Key Kimi K2.5"
                                    class="w-full max-w-md border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold
                                        {{ ($pengaturan->kimi_api_key ?? '') ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ ($pengaturan->kimi_api_key ?? '') ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                        {{ ($pengaturan->kimi_api_key ?? '') ? 'Terhubung' : 'Belum Terhubung' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code Generator -->
                <div class="border-b border-gray-100 pb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">QR Code Generator</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Aktifkan fitur generate QR Code untuk aset dan publikasi.</p>
                            <div class="mt-3 flex items-center gap-3">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="qr_enabled" value="1"
                                        {{ old('qr_enabled', $pengaturan->qr_enabled ?? false) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#006400]/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#006400]"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-700">
                                        <span x-data="{ checked: {{ old('qr_enabled', $pengaturan->qr_enabled ?? false) ? 'true' : 'false' }}}">
                                            <span x-show="checked" class="text-green-600">Aktif</span>
                                            <span x-show="!checked" class="text-gray-400">Nonaktif</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Jika diaktifkan, QR Code akan muncul di setiap detail aset dan publikasi.</p>
                        </div>
                    </div>
                </div>

                <!-- Status Integrasi -->
                <div>
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-500 flex items-center justify-center">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Status Semua Integrasi</p>
                            <div class="flex flex-wrap items-center gap-3 mt-1">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Google Analytics: {{ ($pengaturan->google_analytics ?? '') ? 'Terkonfigurasi' : 'Belum' }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ ($pengaturan->kimi_api_key ?? '') ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ ($pengaturan->kimi_api_key ?? '') ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                    Kimi K2.5: {{ ($pengaturan->kimi_api_key ?? '') ? 'Terkonfigurasi' : 'Belum' }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ ($pengaturan->qr_enabled ?? false) ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-500' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ ($pengaturan->qr_enabled ?? false) ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                    QR Code: {{ ($pengaturan->qr_enabled ?? false) ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-1.5"></i>
                    Simpan Pengaturan Integrasi
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi -->
    <div class="mt-6 bg-blue-50 border border-blue-100 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <i class="fas fa-circle-info text-blue-500 text-sm mt-0.5"></i>
            <div>
                <p class="text-sm font-medium text-blue-800">Informasi Integrasi</p>
                <p class="text-xs text-blue-700 mt-1 leading-relaxed">
                    Konfigurasi integrasi akan mempengaruhi fitur-fitur yang tersedia di website.
                    Pastikan API Key dan Tracking ID yang dimasukkan sudah benar.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection