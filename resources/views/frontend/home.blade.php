@extends('layouts.frontend')

@section('title', 'Beranda')

@section('content')

<!-- ========================================================= -->
<!-- HERO SLIDER -->
<!-- ========================================================= -->
<div id="heroSlider" class="relative h-[400px] sm:h-[500px] md:h-[600px] lg:h-[650px] overflow-hidden">

    <!-- Slide 1 -->
    <div class="hero-slide absolute inset-0 bg-cover bg-center opacity-100 transition-opacity duration-1000"
        style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2000&auto=format&fit=crop');">
    </div>

    <!-- Slide 2 -->
    <div class="hero-slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000"
        style="background-image: url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=2000&auto=format&fit=crop');">
    </div>

    <!-- Slide 3 -->
    <div class="hero-slide absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000"
        style="background-image: url('https://images.unsplash.com/photo-1500534623283-312aade485b7?q=80&w=2000&auto=format&fit=crop');">
    </div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#0B2A4A]/90 via-[#0B2A4A]/60 to-transparent z-10">
    </div>

    <!-- Konten Hero -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
        <span class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-widest mb-2 sm:mb-4">
            Badan Bank Tanah
        </span>

        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight max-w-2xl">
            {{ $pengaturan->judul_hero ?? 'Mengelola Tanah, Memajukan Negeri' }}
        </h1>

        <p class="text-white/90 text-sm sm:text-base md:text-lg mt-3 sm:mt-4 mb-6 sm:mb-8 max-w-xl leading-relaxed">
            {{ $pengaturan->subjudul_hero ??
                'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.' }}
        </p>

        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
            <a href="{{ $pengaturan->tombol_link ?? '/aset' }}"
                class="btn-primary px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-bold text-sm sm:text-base transition inline-block">
                {{ $pengaturan->tombol_text ?? 'Selengkapnya' }}
            </a>
        </div>

        <!-- Dots -->
        <div class="flex items-center gap-2 mt-6 sm:mt-8">
            <button type="button" class="hero-dot w-2.5 h-2.5 rounded-full bg-white transition-all duration-300" data-slide="0"></button>
            <button type="button" class="hero-dot w-2.5 h-2.5 rounded-full bg-white/50 transition-all duration-300" data-slide="1"></button>
            <button type="button" class="hero-dot w-2.5 h-2.5 rounded-full bg-white/50 transition-all duration-300" data-slide="2"></button>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- STATISTIK - DATA REAL DARI DATABASE -->
<!-- ========================================================= -->
@php
    $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
    $totalAset = \App\Models\AsetTanah::count();
    $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
    $totalKerjasama = \App\Models\ProyekInvestasi::where('is_active', true)->count();
    // Nilai Aset - fallback ke 68,45 T
    $nilaiAset = 68450000000000;
@endphp

<div class="w-full px-3 sm:px-4 -mt-10 sm:-mt-16 relative z-10">
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-lg px-4 sm:px-6 md:px-10 py-4 sm:py-6">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 md:gap-6">

            <!-- Total Luas Aset -->
            <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-layer-group text-base sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate">Total Luas Aset</p>
                    <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900">{{ number_format($totalLuas, 0, ',', '.') }} Ha</p>
                    <p class="text-[7px] sm:text-[8px] text-green-600">Data real dari database</p>
                </div>
            </div>

            <!-- Lokasi Aset -->
            <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-location-dot text-base sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate">Lokasi Aset</p>
                    <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900">{{ number_format($totalAset) }}</p>
                    <p class="text-[7px] sm:text-[8px] text-gray-400 truncate">Bidang Tanah</p>
                </div>
            </div>

            <!-- Wilayah -->
            <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-building text-base sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate">Wilayah</p>
                    <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900">{{ number_format($totalProvinsi) }}</p>
                    <p class="text-[7px] sm:text-[8px] text-gray-400 truncate">Provinsi</p>
                </div>
            </div>

            <!-- Kerja Sama Aktif -->
            <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-green-50 text-green-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-handshake text-base sm:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate">Kerja Sama Aktif</p>
                    <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900">{{ $totalKerjasama > 0 ? number_format($totalKerjasama) : '0' }}</p>
                    <p class="text-[7px] sm:text-[8px] text-gray-400 truncate">Mitra Strategis</p>
                </div>
            </div>

            <!-- Nilai Aset -->
            <div class="hidden sm:flex items-center gap-3 px-3 py-3 col-span-2 sm:col-span-1">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] text-gray-500 font-medium truncate">Nilai Aset</p>
                    <p class="text-base md:text-xl font-extrabold text-blue-700">Rp 68,45 T</p>
                    <p class="text-[8px] text-gray-400 truncate">Estimasi Nilai</p>
                </div>
            </div>

            <!-- Nilai Aset (Mobile) -->
            <div class="sm:hidden col-span-2 flex items-center justify-center gap-3 px-3 py-2 border-t border-gray-100 pt-3 mt-1">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-line text-base"></i>
                </div>
                <div>
                    <p class="text-[8px] text-gray-500 font-medium">Nilai Aset</p>
                    <p class="text-sm font-extrabold text-blue-700">Rp 68,45 T</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- ASET & PETA SECTION -->
<!-- ========================================================= -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 lg:py-20">
    <div class="grid grid-cols-1 lg:grid-cols-[1.35fr_0.85fr] gap-6 sm:gap-8 lg:gap-10">

        <!-- ASET PERSEDIAAN TANAH -->
        <div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
            <div class="flex items-end justify-between mb-4 sm:mb-5">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900">Aset Persediaan Tanah</h2>
                </div>
                <a href="{{ route('assets') }}" class="text-[10px] font-semibold link-secondary">
                    Lihat Semua →
                </a>
            </div>

            <!-- Asset Slider -->
            <div class="relative overflow-hidden">
                <div id="assetSlider" class="flex transition-transform duration-500 ease-in-out gap-3 sm:gap-4">
                    @foreach ($asets as $aset)
                    <div class="asset-card min-w-[85%] sm:min-w-[60%] md:min-w-[50%] lg:min-w-[33.33%] flex-shrink-0">
                        <div class="bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                            <div class="relative h-36 sm:h-40 md:h-48 bg-gray-200">
                                <img src="{{ $aset->gambar ? asset('storage/' . $aset->gambar) : 'https://picsum.photos/600/400?random=' . $aset->id }}"
                                    class="w-full h-full object-cover"
                                    alt="{{ $aset->nama_lokasi }}">
                                <span class="absolute top-2 sm:top-3 left-2 sm:left-3 text-white text-[8px] sm:text-[10px] px-2 sm:px-3 py-0.5 sm:py-1 rounded font-bold uppercase
                                    {{ $aset->status == 'Tersedia' ? 'bg-green-700' : 'bg-blue-700' }}">
                                    {{ $aset->status }}
                                </span>
                            </div>
                            <div class="p-3 sm:p-4">
                                <h3 class="text-xs sm:text-sm font-bold text-gray-900 leading-snug line-clamp-2">
                                    {{ $aset->nama_lokasi }}
                                </h3>
                                <p class="text-[10px] sm:text-xs text-gray-500 mt-0.5 sm:mt-1">
                                    {{ $aset->provinsi }}, {{ $aset->kabupaten }}
                                </p>
                                <p class="text-xs sm:text-sm font-bold text-green-600 mt-1 sm:mt-2">
                                    {{ number_format($aset->luas_hektar, 2, ',', '.') }} Ha
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Dots -->
            <div id="assetDots" class="flex justify-center items-center gap-1.5 sm:gap-2 mt-3 sm:mt-4">
                @foreach ($asets as $index => $aset)
                <button type="button"
                    class="asset-dot w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full transition-all duration-300
                    {{ $index === 0 ? 'bg-blue-700' : 'bg-gray-300' }}"
                    data-slide="{{ $index }}">
                </button>
                @endforeach
            </div>
        </div>

        <!-- PETA INTERAKTIF -->
        <div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
            <div class="flex items-end justify-between mb-3 sm:mb-4">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900">Peta Interaktif</h2>
                </div>
                <a href="{{ route('assets') }}" class="text-[10px] font-semibold link-secondary">
                    Lihat Peta →
                </a>
            </div>

            <div id="map" class="w-full h-[220px] sm:h-[280px] md:h-[320px] rounded-xl shadow-md border border-gray-200 bg-blue-50">
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-3 sm:mt-4 text-[8px] sm:text-[10px] text-gray-600">
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-700"></span>
                    Tersedia
                </div>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    Dalam Pengembangan
                </div>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    Dalam Proses
                </div>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                    Terikat
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ========================================================= -->
<!-- PEMANFAATAN & KERJA SAMA + PUBLIKASI -->
<!-- ========================================================= -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-10">

        <!-- PEMANFAATAN & KERJA SAMA -->
        <div class="lg:col-span-3">
            <div class="flex items-end justify-between mb-5 sm:mb-7">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Pemanfaatan & Kerja Sama</h2>
                <a href="{{ route('partnership') }}" class="text-xs font-semibold link-secondary">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 md:gap-6">

                <!-- Investasi -->
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-full bg-blue-50 flex items-center justify-center mb-2 sm:mb-3">
                        <i class="fas fa-chart-line text-blue-600 text-lg sm:text-2xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900">Investasi</h3>
                    <p class="text-[8px] sm:text-[10px] text-gray-500 leading-relaxed mt-0.5 sm:mt-1 hidden sm:block">
                        Pemanfaatan tanah untuk investasi produktif.
                    </p>
                    <a href="{{ route('partnership') }}" class="text-[9px] sm:text-xs link-secondary font-semibold">
                        Selengkapnya →
                    </a>
                </div>

                <!-- Reforma Agraria -->
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-full bg-green-50 flex items-center justify-center mb-2 sm:mb-3">
                        <i class="fas fa-leaf text-green-600 text-lg sm:text-2xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900">Reforma Agraria</h3>
                    <p class="text-[8px] sm:text-[10px] text-gray-500 leading-relaxed mt-0.5 sm:mt-1 hidden sm:block">
                        Mendukung pemerataan akses tanah.
                    </p>
                    <a href="{{ route('partnership') }}" class="text-[9px] sm:text-xs link-secondary font-semibold">
                        Selengkapnya →
                    </a>
                </div>

                <!-- Kerja Sama -->
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-full bg-yellow-50 flex items-center justify-center mb-2 sm:mb-3">
                        <i class="fas fa-handshake text-yellow-600 text-lg sm:text-2xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900">Kerja Sama</h3>
                    <p class="text-[8px] sm:text-[10px] text-gray-500 leading-relaxed mt-0.5 sm:mt-1 hidden sm:block">
                        Kolaborasi strategis pengelolaan tanah.
                    </p>
                    <a href="{{ route('partnership') }}" class="text-[9px] sm:text-xs link-secondary font-semibold">
                        Selengkapnya →
                    </a>
                </div>

                <!-- Dokumen -->
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto rounded-full bg-purple-50 flex items-center justify-center mb-2 sm:mb-3">
                        <i class="fas fa-file-lines text-purple-600 text-lg sm:text-2xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900">Dokumen</h3>
                    <p class="text-[8px] sm:text-[10px] text-gray-500 leading-relaxed mt-0.5 sm:mt-1 hidden sm:block">
                        Informasi dan dokumen terkait.
                    </p>
                    <a href="{{ route('publications') }}" class="text-[9px] sm:text-xs link-secondary font-semibold">
                        Selengkapnya →
                    </a>
                </div>

            </div>
        </div>

        <!-- PUBLIKASI TERBARU -->
        <div class="lg:col-span-2">
            <div class="flex items-end justify-between mb-5 sm:mb-7">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Publikasi Terbaru</h2>
                <a href="{{ route('publications') }}" class="text-xs font-semibold link-secondary">
                    Lihat Semua →
                </a>
            </div>

            <div class="space-y-2 sm:space-y-3">
                @foreach ($berita->take(3) as $item)
                <a href="{{ route('publications.show', $item->id) }}"
                    class="group flex items-center gap-3 sm:gap-4 bg-white rounded-lg overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-2 sm:p-3">

                    <div class="w-14 h-14 sm:w-20 sm:h-20 flex-shrink-0 overflow-hidden bg-gray-100 rounded-lg">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <img src="https://picsum.photos/300/200?random={{ $item->id }}"
                                alt="{{ $item->judul }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <span class="text-[7px] sm:text-[8px] font-bold uppercase px-1.5 py-0.5 rounded-full
                            {{ $item->kategori == 'Siaran Pers' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700' }}">
                            {{ $item->kategori }}
                        </span>
                        <h3 class="text-[10px] sm:text-xs font-bold text-gray-900 leading-tight mt-0.5 line-clamp-2 group-hover:text-[var(--color-secondary)] transition-colors">
                            {{ $item->judul }}
                        </h3>
                        <p class="text-[8px] sm:text-[9px] text-gray-400 mt-0.5">
                            {{ $item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') : $item->created_at?->format('d M Y') }}
                        </p>
                    </div>

                </a>
                @endforeach
            </div>
        </div>

    </div>
</section>

<!-- ========================================================= -->
<!-- CTA SECTION -->
<!-- ========================================================= -->
<div class="bg-[#0B2A4A] relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=1600&auto=format&fit=crop')] bg-cover bg-center opacity-20">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20 flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-8">
        <div class="text-center sm:text-left">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Bersama Mengelola Tanah</h2>
            <p class="text-blue-200 text-sm sm:text-base lg:text-lg">untuk Masa Depan Indonesia yang lebih baik.</p>
        </div>
        <a href="{{ route('partnership') }}"
            class="btn-primary px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-bold text-sm sm:text-base transition shrink-0 inline-block">
            Pelajari Lebih Lanjut →
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // =========================================================
        // INIT MAP
        // =========================================================
        var map = L.map('map').setView([-2.5, 118.0], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // =========================================================
        // MARKER DARI DATABASE
        // =========================================================
        @php
            $markers = \App\Models\AsetTanah::whereNotNull('lat')->whereNotNull('lng')->get();
        @endphp

        var markers = [
            @foreach ($markers as $marker)
                {
                    lat: {{ $marker->lat }},
                    lng: {{ $marker->lng }},
                    status: '{{ $marker->status }}',
                    nama: '{{ $marker->nama_lokasi }}',
                    provinsi: '{{ $marker->provinsi }}',
                    luas: {{ $marker->luas_hektar }}
                },
            @endforeach
        ];

        markers.forEach(function(marker) {
            var color = marker.status === 'Tersedia' ? '#16a34a' :
                       (marker.status === 'Dalam Pengembangan' ? '#3b82f6' :
                       (marker.status === 'Dalam Proses' ? '#f97316' : '#6b7280'));
            L.circleMarker([marker.lat, marker.lng], {
                color: color,
                fillColor: color,
                fillOpacity: 0.6,
                radius: 8
            }).addTo(map).bindPopup(`
                <b>${marker.nama}</b><br>
                ${marker.provinsi}<br>
                <strong>${Number(marker.luas).toLocaleString('id-ID')} Ha</strong><br>
                <span style="color:${color};font-weight:600">${marker.status}</span>
            `);
        });

        // =========================================================
        // HERO SLIDER
        // =========================================================
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.hero-dot');

        if (slides.length) {
            let currentSlide = 0;
            let slideInterval;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.style.opacity = i === index ? '1' : '0';
                });
                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.remove('bg-white/50');
                        dot.classList.add('bg-white');
                    } else {
                        dot.classList.remove('bg-white');
                        dot.classList.add('bg-white/50');
                    }
                });
                currentSlide = index;
            }

            function nextSlide() {
                let next = currentSlide + 1;
                if (next >= slides.length) next = 0;
                showSlide(next);
            }

            function startSlider() {
                slideInterval = setInterval(nextSlide, 5000);
            }

            function resetSlider() {
                clearInterval(slideInterval);
                startSlider();
            }

            dots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    showSlide(index);
                    resetSlider();
                });
            });

            showSlide(0);
            startSlider();
        }

        // =========================================================
        // ASSET SLIDER - AUTO SLIDE + DRAG + HOVER PAUSE
        // =========================================================
        const slider = document.getElementById('assetSlider');
        const assetDots = document.querySelectorAll('.asset-dot');
        const cards = document.querySelectorAll('.asset-card');

        if (slider && cards.length && assetDots.length) {
            let currentIndex = 0;
            const totalSlides = cards.length;
            let assetInterval;

            function slideAssets(index) {
                if (index < 0) index = 0;
                if (index >= totalSlides) index = totalSlides - 1;
                const cardWidth = cards[0].offsetWidth + 12;
                const offset = cardWidth * index;
                slider.style.transform = `translateX(-${offset}px)`;
                assetDots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.remove('bg-gray-300');
                        dot.classList.add('bg-blue-700');
                    } else {
                        dot.classList.remove('bg-blue-700');
                        dot.classList.add('bg-gray-300');
                    }
                });
                currentIndex = index;
            }

            function nextAssetSlide() {
                let next = currentIndex + 1;
                if (next >= totalSlides) next = 0;
                slideAssets(next);
            }

            function startAssetSlider() {
                clearInterval(assetInterval);
                assetInterval = setInterval(nextAssetSlide, 3000);
            }

            function stopAssetSlider() {
                clearInterval(assetInterval);
            }

            assetDots.forEach((dot) => {
                dot.addEventListener('click', function() {
                    const index = Number(this.dataset.slide);
                    slideAssets(index);
                    startAssetSlider();
                });
            });

            const assetContainer = slider.closest('.relative');
            if (assetContainer) {
                assetContainer.addEventListener('mouseenter', stopAssetSlider);
                assetContainer.addEventListener('mouseleave', startAssetSlider);
            }

            // Drag support
            let startX = 0;
            let currentX = 0;
            let isDragging = false;

            slider.addEventListener('mousedown', (e) => {
                startX = e.clientX;
                isDragging = true;
                stopAssetSlider();
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                currentX = e.clientX;
            });

            slider.addEventListener('mouseup', (e) => {
                if (!isDragging) return;
                isDragging = false;
                const diff = startX - currentX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        nextAssetSlide();
                    } else {
                        slideAssets(currentIndex - 1);
                    }
                }
                startAssetSlider();
            });

            slider.addEventListener('mouseleave', () => {
                if (isDragging) {
                    isDragging = false;
                    startAssetSlider();
                }
            });

            // Touch support
            let touchStartX = 0;
            slider.addEventListener('touchstart', (e) => {
                touchStartX = e.touches[0].clientX;
                stopAssetSlider();
            });

            slider.addEventListener('touchend', (e) => {
                const touchEndX = e.changedTouches[0].clientX;
                const diff = touchStartX - touchEndX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        nextAssetSlide();
                    } else {
                        slideAssets(currentIndex - 1);
                    }
                }
                startAssetSlider();
            });

            slideAssets(0);
            startAssetSlider();

            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    slideAssets(currentIndex);
                }, 200);
            });
        }
    });
</script>
@endpush