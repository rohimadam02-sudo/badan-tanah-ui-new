@extends('layouts.frontend')

@section('title', 'Kontak')

@section('content')

{{-- =========================================================
    HERO / HEADER
========================================================= --}}
<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="max-w-3xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full
                         bg-white/10 text-blue-200 text-xs font-semibold
                         uppercase tracking-wider mb-5">
                Hubungi Kami
            </span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                Kontak
            </h1>
            <div class="h-1 w-20 mt-5 mb-5 rounded-full"></div>
            <p class="text-blue-100 text-sm md:text-base leading-relaxed max-w-2xl">
                Hubungi kami untuk informasi lebih lanjut mengenai
                Badan Bank Tanah dan pengelolaan aset tanah.
            </p>
        </div>
    </div>
</section>

{{-- =========================================================
    MAIN CONTENT
========================================================= --}}
<section class="bg-gray-50 py-12 md:py-16">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI (2/3) - FORM KONTAK --}}
            <div class="lg:col-span-2">

                {{-- =================================================
                    KIRIM PESAN
                ================================================== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">

                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-envelope text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Kirim Pesan</h2>
                            <p class="text-sm text-gray-500">Isi formulir di bawah untuk menghubungi kami.</p>
                        </div>
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

                    <form action="{{ route('kontak.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" value="{{ old('nama') }}"
                                    placeholder="Masukkan nama Anda"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm text-black placeholder:text-black focus:ring-2 focus:ring-black focus:border-black transition"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="Masukkan email Anda"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm text-black placeholder:text-black focus:ring-2 focus:ring-black focus:border-black transition"
                                    required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}"
                                placeholder="Masukkan nomor telepon Anda"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm text-black placeholder:text-black focus:ring-2 focus:ring-black focus:border-black transition"
                                required>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Pesan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="pesan" rows="5"
                                placeholder="Tulis pesan Anda di sini..."
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm text-black placeholder:text-black focus:ring-2 focus:ring-black focus:border-black transition"
                                required>{{ old('pesan') }}</textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm text-black placeholder:text-black focus:ring-2 focus:ring-black focus:border-black transition"
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>

                </div>

            </div>

            {{-- KOLOM KANAN (1/3) - INFORMASI KONTAK --}}
            <div class="space-y-6">

                {{-- =================================================
                    INFORMASI KONTAK
                ================================================== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <i class="fas fa-address-book text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Informasi Kontak</h3>
                            <p class="text-xs text-gray-500">Hubungi kami melalui:</p>
                        </div>
                    </div>

                    @php
                        $footer = \App\Models\FooterSetting::getSettings();
                    @endphp

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</p>
                                <p class="text-sm text-gray-700 mt-0.5">{{ $footer->alamat ?? 'Jl. H. Juanda No. 15, Jakarta Pusat' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Telepon</p>
                                <p class="text-sm text-gray-700 mt-0.5">{{ $footer->telepon ?? '(021) 3456-7890' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</p>
                                <p class="text-sm text-gray-700 mt-0.5">{{ $footer->email ?? 'info@bantah.go.id' }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- =================================================
                    JAM KERJA
                ================================================== --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                            <i class="fas fa-clock text-purple-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-900">Jam Kerja</h3>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Senin - Kamis</span>
                            <span class="font-medium text-gray-900">08.00 - 16.00</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Jumat</span>
                            <span class="font-medium text-gray-900">08.00 - 15.30</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Sabtu - Minggu</span>
                            <span class="font-medium text-red-500">Tutup</span>
                        </div>
                    </div>

                </div>

                {{-- =================================================
                    SOSIAL MEDIA
                ================================================== --}}
                @php
                    $socialMedias = \App\Models\SocialMedia::active()->ordered()->get();
                @endphp

                @if($socialMedias->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-share-alt text-blue-600"></i>
                            </div>
                            <h3 class="font-bold text-gray-900">Ikuti Kami</h3>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            @foreach($socialMedias as $social)
                                <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                                   class="w-12 h-12 rounded-full flex items-center justify-center hover:scale-110 transition group"
                                   style="background-color: {{ $social->warna ?? '#6b7280' }}; color: white;"
                                   title="{{ $social->nama }}"
                                   aria-label="{{ $social->nama }}">
                                    <i class="{{ $social->icon }} text-lg group-hover:scale-110 transition" aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>

       {{-- =========================================================
    PETA LOKASI KANTOR - MULTIPLE CABANG
========================================================= --}}
@php
    $lokasiKantor = \App\Models\LokasiKantor::active()->ordered()->get();
@endphp

@if($lokasiKantor->count() > 0)
<div class="mt-12">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                    <i class="fas fa-map-location-dot text-red-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">Lokasi Kantor</h3>
                    <p class="text-xs text-gray-500">
                        {{ $lokasiKantor->count() }} lokasi
                        @if($lokasiKantor->where('is_utama', true)->count() > 0)
                            • {{ $lokasiKantor->where('is_utama', true)->first()->nama }} (Kantor Utama)
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div id="officeMap" class="w-full h-[350px] sm:h-[450px] bg-gray-100"></div>

        <div class="p-4 border-t border-gray-100">
            <div class="flex flex-wrap gap-3">
                @foreach($lokasiKantor as $lokasi)
                    <div class="flex items-center gap-2 text-xs">
                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $lokasi->warna ?? '#006400' }};"></span>
                        <span class="text-gray-600">{{ $lokasi->nama }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var lokasiData = @json($lokasiKantor);
    
    if (lokasiData.length === 0) return;
    
    // Gunakan lokasi pertama sebagai center (atau yang utama)
    var centerLat = lokasiData[0]?.lat || -6.1754;
    var centerLng = lokasiData[0]?.lng || 106.8272;
    
    // Cari lokasi utama
    var utama = lokasiData.find(l => l.is_utama);
    if (utama) {
        centerLat = utama.lat;
        centerLng = utama.lng;
    }
    
    var map = L.map('officeMap').setView([centerLat, centerLng], 12);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    
    // Buat marker untuk setiap lokasi
    lokasiData.forEach(function(lokasi) {
        var isUtama = lokasi.is_utama;
        var size = isUtama ? 44 : 36;
        var fontSize = isUtama ? 18 : 14;
        var borderWidth = isUtama ? 4 : 3;
        
        var customIcon = L.divIcon({
            className: 'custom-marker',
            html: `
                <div style="
                    width: ${size}px;
                    height: ${size}px;
                    background: ${lokasi.warna || '#006400'};
                    border: ${borderWidth}px solid white;
                    border-radius: 50%;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: ${fontSize}px;
                    color: white;
                    ${isUtama ? 'box-shadow: 0 2px 15px rgba(0,100,0,0.5);' : ''}
                ">
                    <i class="fas ${lokasi.icon || 'fa-building'}"></i>
                </div>
            `,
            iconSize: [size, size],
            iconAnchor: [size/2, size],
            popupAnchor: [0, -(size/2 + 5)]
        });
        
        L.marker([lokasi.lat, lokasi.lng], { icon: customIcon }).addTo(map)
            .bindPopup(`
                <div style="min-width:220px;font-family:Inter,sans-serif;padding:4px 0;">
                    <div style="font-weight:700;font-size:15px;color:#111827;margin-bottom:4px;display:flex;align-items:center;gap:6px;">
                        <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:${lokasi.warna || '#006400'};"></span>
                        ${lokasi.nama}
                        ${lokasi.is_utama ? '<span style="font-size:9px;background:#fbbf24;color:#78350f;padding:1px 8px;border-radius:12px;">Utama</span>' : ''}
                    </div>
                    <div style="font-size:12px;color:#6b7280;line-height:1.6;">
                        <i class="fas fa-map-pin" style="color:#006400;width:18px;"></i>
                        ${lokasi.alamat}
                    </div>
                    ${lokasi.telepon ? `<div style="font-size:12px;color:#6b7280;margin-top:2px;"><i class="fas fa-phone" style="color:#006400;width:18px;"></i> ${lokasi.telepon}</div>` : ''}
                    ${lokasi.email ? `<div style="font-size:12px;color:#6b7280;margin-top:2px;"><i class="fas fa-envelope" style="color:#006400;width:18px;"></i> ${lokasi.email}</div>` : ''}
                    ${lokasi.jam_kerja ? `<div style="margin-top:6px;padding-top:6px;border-top:1px solid #e5e7eb;font-size:11px;color:#9ca3af;"><i class="fas fa-clock" style="width:18px;"></i> ${lokasi.jam_kerja}</div>` : ''}
                    ${lokasi.deskripsi ? `<div style="margin-top:4px;font-size:11px;color:#9ca3af;">${lokasi.deskripsi}</div>` : ''}
                </div>
            `);
        
        // Buka popup untuk lokasi utama
        if (isUtama) {
            setTimeout(function() {
                // Popup akan terbuka otomatis
            }, 500);
        }
    });
    
    // Fit bounds ke semua marker
    var group = new L.featureGroup();
    lokasiData.forEach(function(lokasi) {
        group.addLayer(L.marker([lokasi.lat, lokasi.lng]));
    });
    map.fitBounds(group.getBounds().pad(0.1));
    
    // Resize map
    window.addEventListener('resize', function() {
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
    });
});
</script>
@endpush

@endsection