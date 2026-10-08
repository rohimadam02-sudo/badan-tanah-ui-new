@extends('layouts.frontend')

@section('title', 'Beranda')

@section('content')

    <!-- ========================================================= -->
    <!-- HERO SINGLE BACKGROUND -->
    <!-- ========================================================= -->
    <div id="heroSlider" class="relative h-[400px] sm:h-[500px] md:h-[600px] lg:h-[650px] overflow-hidden select-none"
        style="background-image: url('/images/header.jpeg'); background-size: cover; background-position: center;">

        <!-- Animated cloud overlay -->
        <div class="hero-clouds" aria-hidden="true"></div>

        <!-- Overlay agar teks tetap terbaca -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#0B2A4A]/85 via-[#0B2A4A]/45 to-transparent z-5"></div>

        <!-- Konten hero -->
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
            <span class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-widest mb-2 sm:mb-4">
                Badan Bank Tanah
            </span>

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight max-w-2xl">
                @if ($isEnglish && !empty($pengaturan->judul_hero_en))
                    {{ $pengaturan->judul_hero_en }}
                @else
                    {{ $pengaturan->judul_hero ?? 'Mengelola Tanah, Memajukan Negeri' }}
                @endif
            </h1>

            <p class="text-white/90 text-sm sm:text-base md:text-lg mt-3 sm:mt-4 mb-6 sm:mb-8 max-w-xl leading-relaxed">
                @if ($isEnglish && !empty($pengaturan->subjudul_hero_en))
                    {{ $pengaturan->subjudul_hero_en }}
                @else
                    {{ $pengaturan->subjudul_hero ?? 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.' }}
                @endif
            </p>

            <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                <a href="{{ $pengaturan->tombol_link ?? '/aset' }}"
                    class="btn-primary px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-bold text-sm sm:text-base transition inline-block">
                    {{ $pengaturan->tombol_text ?? ($isEnglish ? 'Learn More' : 'Selengkapnya') }}
                </a>
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
        $nilaiAset = 68450000000000;

        $statLabels = [
            'total_luas' => $isEnglish ? 'Total Land Area' : 'Total Luas Aset',
            'total_asets' => $isEnglish ? 'Total Assets' : 'Lokasi Aset',
            'wilayah' => $isEnglish ? 'Regions' : 'Wilayah',
            'kerjasama' => $isEnglish ? 'Active Partnerships' : 'Kerja Sama Aktif',
            'nilai_aset' => $isEnglish ? 'Asset Value' : 'Nilai Aset',
            'estimasi' => $isEnglish ? 'Estimated Value' : 'Estimasi Nilai',
        ];
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
                        <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate">{{ $statLabels['total_luas'] }}</p>
                        <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900">{{ number_format($totalLuas, 0, ',', '.') }} Ha</p>
                        <p class="text-[7px] sm:text-[8px] text-green-600">{{ $isEnglish ? 'Real data' : 'Data real dari database' }}</p>
                    </div>
                </div>

                <!-- Lokasi Aset -->
                <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-location-dot text-base sm:text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate">{{ $statLabels['total_asets'] }}</p>
                        <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900">{{ number_format($totalAset) }}</p>
                        <p class="text-[7px] sm:text-[8px] text-gray-400 truncate">{{ $isEnglish ? 'Land Plots' : 'Bidang Tanah' }}</p>
                    </div>
                </div>

                <!-- Wilayah -->
                <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-building text-base sm:text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate">{{ $statLabels['wilayah'] }}</p>
                        <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900">{{ number_format($totalProvinsi) }}</p>
                        <p class="text-[7px] sm:text-[8px] text-gray-400 truncate">{{ $isEnglish ? 'Provinces' : 'Provinsi' }}</p>
                    </div>
                </div>

                <!-- Kerja Sama Aktif -->
                <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-3 py-2 sm:py-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-green-50 text-green-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-handshake text-base sm:text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium truncate">{{ $statLabels['kerjasama'] }}</p>
                        <p class="text-sm sm:text-base md:text-xl font-extrabold text-gray-900">{{ $totalKerjasama > 0 ? number_format($totalKerjasama) : '0' }}</p>
                        <p class="text-[7px] sm:text-[8px] text-gray-400 truncate">{{ $isEnglish ? 'Strategic Partners' : 'Mitra Strategis' }}</p>
                    </div>
                </div>

                <!-- Nilai Aset -->
                <div class="hidden sm:flex items-center gap-3 px-3 py-3 col-span-2 sm:col-span-1">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] text-gray-500 font-medium truncate">{{ $statLabels['nilai_aset'] }}</p>
                        <p class="text-base md:text-xl font-extrabold text-blue-700">Rp 68,45 T</p>
                        <p class="text-[8px] text-gray-400 truncate">{{ $statLabels['estimasi'] }}</p>
                    </div>
                </div>

                <!-- Nilai Aset (Mobile) -->
                <div class="sm:hidden col-span-2 flex items-center justify-center gap-3 px-3 py-2 border-t border-gray-100 pt-3 mt-1">
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-line text-base"></i>
                    </div>
                    <div>
                        <p class="text-[8px] text-gray-500 font-medium">{{ $statLabels['nilai_aset'] }}</p>
                        <p class="text-sm font-extrabold text-blue-700">Rp 68,45 T</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- JELAJAHI PERSEBARAN ASET TANAH -->
    <!-- ========================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16">
        <div class="max-w-3xl mb-6 sm:mb-8">
            <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-amber-600">
                {{ $isEnglish ? 'LAND ASSET INVENTORY' : 'ASET PERSEDIAAN TANAH' }}
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 mt-2 leading-tight">
                {{ $isEnglish ? 'Explore Land Asset Distribution in Indonesia' : 'Jelajahi Persebaran Aset Tanah di Indonesia' }}
            </h2>
            <p class="text-sm sm:text-base text-gray-500 leading-relaxed mt-3">
                {{ $isEnglish
                    ? 'Badan Bank Tanah is present across various provinces in Indonesia with various land asset statuses to support national development.'
                    : 'Badan Bank Tanah hadir di berbagai provinsi di Indonesia dengan beragam status aset tanah untuk mendukung pembangunan nasional.' }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 sm:p-3">
            <div id="petaPersebaran" class="rounded-lg overflow-hidden"></div>
        </div>

        <div class="mt-6 sm:mt-8">
            <a href="{{ route('assets') }}"
                class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-[#0B2A4A] font-bold px-6 py-3 rounded-lg text-sm transition">
                {{ $isEnglish ? 'Explore Assets' : 'Jelajahi Aset' }}
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 4 PILAR — TANAH UNTUK KESEJAHTERAAN -->
    <!-- ========================================================= -->
    <section class="relative overflow-hidden bg-white">
        {{-- Header --}}
        <div class="max-w-4xl mx-auto text-center px-4 pt-14 sm:pt-20 pb-8 sm:pb-12">
            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.2em] text-amber-600">
                {{ $isEnglish ? 'THE ROLE OF LAND BANK FOR SUSTAINABLE ECONOMIC GROWTH' : 'PERAN BANK TANAH UNTUK PERTUMBUHAN EKONOMI BERKELANJUTAN' }}
            </span>
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 mt-3 leading-tight">
                {{ $isEnglish
                    ? 'Land for improvement, empowerment, and creation of economic welfare throughout the country'
                    : 'Tanah untuk peningkatan, pemberdayaan, dan penciptaan kesejahteraan ekonomi di seluruh penjuru negeri' }}
            </h2>
        </div>

        {{-- 4 Kartu --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

                <div class="relative rounded-2xl overflow-hidden h-[380px] sm:h-[420px] group">
                    <img src="https://picsum.photos/600/800?random=1" alt="Mendukung Pemerataan Ekonomi"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0B2A4A] via-[#0B2A4A]/70 to-transparent"></div>
                    <div class="relative h-full flex flex-col justify-end p-5 sm:p-6 text-white">
                        <h3 class="text-base sm:text-lg font-bold mb-2 leading-snug">
                            {{ $isEnglish ? 'Supporting Economic Equality' : 'Mendukung Pemerataan Ekonomi' }}
                        </h3>
                        <p class="text-[11px] sm:text-xs leading-relaxed opacity-90">
                            {{ $isEnglish
                                ? 'Badan Bank Tanah supports the agrarian reform program to promote economic equality and community welfare.'
                                : 'Badan Bank Tanah hadir mendukung program reforma agraria untuk mendukung pemerataan ekonomi masyarakat.' }}
                        </p>
                    </div>
                </div>

                <div class="relative rounded-2xl overflow-hidden h-[380px] sm:h-[420px] group">
                    <img src="https://picsum.photos/600/800?random=2" alt="Solusi Untuk Kebutuhan Lahan"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#166534] via-[#166534]/70 to-transparent"></div>
                    <div class="relative h-full flex flex-col justify-end p-5 sm:p-6 text-white">
                        <h3 class="text-base sm:text-lg font-bold mb-2 leading-snug">
                            {{ $isEnglish ? 'Solution for Land Needs' : 'Solusi Untuk Kebutuhan Lahan' }}
                        </h3>
                        <p class="text-[11px] sm:text-xs leading-relaxed opacity-90">
                            {{ $isEnglish
                                ? 'Terutama bagi Badan Bank Tanah yang mengemban misi untuk menyediakan lahan bagi kepentingan umum.'
                                : 'Terutama bagi Badan Bank Tanah yang mengemban misi untuk menyediakan lahan bagi kepentingan umum.' }}
                        </p>
                    </div>
                </div>

                <div class="relative rounded-2xl overflow-hidden h-[380px] sm:h-[420px] group">
                    <img src="https://picsum.photos/600/800?random=3" alt="Memberikan Kepastian Hukum"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0B2A4A] via-[#0B2A4A]/70 to-transparent"></div>
                    <div class="relative h-full flex flex-col justify-end p-5 sm:p-6 text-white">
                        <h3 class="text-base sm:text-lg font-bold mb-2 leading-snug">
                            {{ $isEnglish ? 'Providing Legal Certainty' : 'Memberikan Kepastian Hukum' }}
                        </h3>
                        <p class="text-[11px] sm:text-xs leading-relaxed opacity-90">
                            {{ $isEnglish
                                ? 'Badan Bank Tanah berperan sebagai pemegang Hak Pengelolaan dalam penyediaan tanah untuk kepentingan umum.'
                                : 'Badan Bank Tanah berperan sebagai pemegang Hak Pengelolaan dalam penyediaan tanah untuk kepentingan umum.' }}
                        </p>
                    </div>
                </div>

                <div class="relative rounded-2xl overflow-hidden h-[380px] sm:h-[420px] group">
                    <img src="https://picsum.photos/600/800?random=4" alt="Transparan, Akuntabel dan Nonprofit"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#166534] via-[#166534]/70 to-transparent"></div>
                    <div class="relative h-full flex flex-col justify-end p-5 sm:p-6 text-white">
                        <h3 class="text-base sm:text-lg font-bold mb-2 leading-snug">
                            {{ $isEnglish ? 'Transparent, Accountable, and Nonprofit' : 'Transparan, Akuntabel dan Nonprofit' }}
                        </h3>
                        <p class="text-[11px] sm:text-xs leading-relaxed opacity-90">
                            {{ $isEnglish
                                ? 'Badan Bank Tanah mengedepankan tata kelola yang transparan, akuntabel, dan berorientasi pada kepentingan publik.'
                                : 'Badan Bank Tanah mengedepankan tata kelola yang transparan, akuntabel, dan berorientasi pada kepentingan publik.' }}
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Ornamen siluet gedung Indonesia --}}
        <div class="relative w-full overflow-hidden leading-none -mt-8 sm:-mt-12 lg:-mt-16">
            <img src="{{ asset('images/slinking.jpg') }}" alt=""
                class="w-full h-auto block select-none pointer-events-none relative z-0">
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- KERJA SAMA PEMANFAATAN TANAH -->
    <!-- ========================================================= -->
    <section class="relative overflow-hidden py-14 sm:py-20">

        {{-- Background foto pemandangan --}}
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://picsum.photos/1920/800?random=99');">
        </div>

        {{-- Konten --}}
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Kartu frosted glass --}}
            <div class="rounded-xl p-6 sm:p-8 lg:p-10
                        bg-white/60 backdrop-blur-lg
                        border border-white/50 shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-center">

                    {{-- KIRI: Header --}}
                    <div class="lg:col-span-4">
                        <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.15em] text-[#1D4ED8]">
                            {{ $isEnglish ? 'UTILIZATION & PARTNERSHIP' : 'PEMANFAATAN & KERJA SAMA' }}
                        </span>
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-[#0B2A4A] mt-2 leading-tight">
                            {{ $isEnglish ? 'Land Utilization Partnership' : 'Kerja Sama Pemanfaatan Tanah' }}
                        </h2>
                        <p class="text-[11px] sm:text-xs text-[#0B2A4A]/80 leading-relaxed mt-3">
                            {{ $isEnglish
                                ? 'Badan Bank Tanah offers various partnership schemes in land utilization. Choose the scheme that best suits your needs.'
                                : 'Badan Bank Tanah menawarkan berbagai skema kerja sama dalam pemanfaatan tanah. Pilih skema yang paling sesuai dengan kebutuhan Anda.' }}
                        </p>
                    </div>

                    {{-- KANAN: 6 Kotak (2 baris × 3 kolom) --}}
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6">

                            {{-- 1. Jual Beli --}}
                            <div class="flex items-center gap-3 cursor-pointer group">
                                <div class="flex-shrink-0 w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-[#0B2A4A] flex items-center justify-center shadow-md group-hover:bg-[#1D4ED8] transition">
                                    <i class="fas fa-dollar-sign text-white text-sm sm:text-base"></i>
                                </div>
                                <h3 class="text-[11px] sm:text-sm font-bold text-[#0B2A4A] leading-tight">
                                    {{ $isEnglish ? 'Buy & Sell' : 'Jual Beli' }}
                                </h3>
                            </div>

                            {{-- 2. Sewa --}}
                            <div class="flex items-center gap-3 cursor-pointer group">
                                <div class="flex-shrink-0 w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-[#0B2A4A] flex items-center justify-center shadow-md group-hover:bg-[#1D4ED8] transition">
                                    <i class="fas fa-couch text-white text-sm sm:text-base"></i>
                                </div>
                                <h3 class="text-[11px] sm:text-sm font-bold text-[#0B2A4A] leading-tight">
                                    {{ $isEnglish ? 'Rent' : 'Sewa' }}
                                </h3>
                            </div>

                            {{-- 3. Ventura Bersama --}}
                            <div class="flex items-center gap-3 cursor-pointer group">
                                <div class="flex-shrink-0 w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-[#0B2A4A] flex items-center justify-center shadow-md group-hover:bg-[#1D4ED8] transition">
                                    <i class="fas fa-handshake text-white text-sm sm:text-base"></i>
                                </div>
                                <h3 class="text-[11px] sm:text-sm font-bold text-[#0B2A4A] leading-tight">
                                    {{ $isEnglish ? 'Joint Venture' : 'Ventura Bersama' }}
                                </h3>
                            </div>

                            {{-- 4. Kerja Sama Operasi --}}
                            <div class="flex items-center gap-3 cursor-pointer group">
                                <div class="flex-shrink-0 w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-[#0B2A4A] flex items-center justify-center shadow-md group-hover:bg-[#1D4ED8] transition">
                                    <i class="fas fa-people-group text-white text-sm sm:text-base"></i>
                                </div>
                                <h3 class="text-[11px] sm:text-sm font-bold text-[#0B2A4A] leading-tight">
                                    {{ $isEnglish ? 'Operation Cooperation' : 'Kerja Sama Operasi' }}
                                </h3>
                            </div>

                            {{-- 5. Hibah --}}
                            <div class="flex items-center gap-3 cursor-pointer group">
                                <div class="flex-shrink-0 w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-[#0B2A4A] flex items-center justify-center shadow-md group-hover:bg-[#1D4ED8] transition">
                                    <i class="fas fa-gift text-white text-sm sm:text-base"></i>
                                </div>
                                <h3 class="text-[11px] sm:text-sm font-bold text-[#0B2A4A] leading-tight">
                                    {{ $isEnglish ? 'Grant' : 'Hibah' }}
                                </h3>
                            </div>

                            {{-- 6. Tukar Menukar --}}
                            <div class="flex items-center gap-3 cursor-pointer group">
                                <div class="flex-shrink-0 w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-[#0B2A4A] flex items-center justify-center shadow-md group-hover:bg-[#1D4ED8] transition">
                                    <i class="fas fa-right-left text-white text-sm sm:text-base"></i>
                                </div>
                                <h3 class="text-[11px] sm:text-sm font-bold text-[#0B2A4A] leading-tight">
                                    {{ $isEnglish ? 'Land Swap' : 'Tukar Menukar' }}
                                </h3>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================= -->
    <!-- INFORMASI TERKINI + GALERI TERKINI -->
    <!-- ========================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">

            {{-- ===================================================== --}}
            {{-- KOLOM KIRI: INFORMASI TERKINI                        --}}
            {{-- ===================================================== --}}
            <div class="flex flex-col h-full">
                <div class="flex items-end justify-between mb-4 sm:mb-5">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.18em] text-[var(--color-secondary)] block">
                            {{ $isEnglish ? 'PUBLICATION' : 'PUBLIKASI' }}
                        </span>
                        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mt-0.5">
                            {{ $isEnglish ? 'Latest Information' : 'Informasi Terkini' }}
                        </h2>
                    </div>
                    <a href="{{ route('publications') }}"
                        class="text-[10px] sm:text-xs font-semibold text-[var(--color-secondary)] hover:underline">
                        {{ $isEnglish ? 'More News →' : 'Lihat Berita Lainnya →' }}
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 flex-1">

                    @php $beritaUtama = $berita->first(); @endphp
                    @if ($beritaUtama)
                        <a href="{{ route('publications.show', $beritaUtama->id) }}"
                            class="relative rounded-xl overflow-hidden group block min-h-[320px] sm:min-h-0 shadow-md">

                            <div class="absolute top-0 left-0 right-0 h-[55%] overflow-hidden bg-gray-100">
                                @if ($beritaUtama->gambar)
                                    <img src="{{ asset('storage/' . $beritaUtama->gambar) }}"
                                        alt="{{ $beritaUtama->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="https://picsum.photos/800/600?random={{ $beritaUtama->id }}"
                                        alt="{{ $beritaUtama->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @endif
                            </div>

                            <span class="absolute top-3 left-3 z-10 text-[9px] font-bold uppercase tracking-wider bg-amber-400 text-[#0B2A4A] px-2 py-1 rounded">
                                {{ $isEnglish ? 'HEADLINE' : 'BERITA UTAMA' }}
                            </span>

                            <div class="absolute bottom-0 left-0 right-0 h-[45%] bg-[#1D4ED8] p-4 sm:p-5 flex flex-col justify-between text-white">
                                <div>
                                    <p class="text-[10px] opacity-80 mb-2">
                                        {{ $beritaUtama->tanggal_publikasi ? \Carbon\Carbon::parse($beritaUtama->tanggal_publikasi)->format('d M Y') : $beritaUtama->created_at?->format('d M Y') }}
                                    </p>
                                    <h3 class="text-sm sm:text-base font-bold leading-snug line-clamp-3">
                                        @if ($isEnglish && !empty($beritaUtama->judul_en))
                                            {{ $beritaUtama->judul_en }}
                                        @else
                                            {{ $beritaUtama->judul }}
                                        @endif
                                    </h3>
                                </div>
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-400">
                                    {{ $isEnglish ? 'Read More' : 'Baca Selengkapnya' }} →
                                </span>
                            </div>
                        </a>
                    @endif

                    <div class="flex flex-col gap-2.5 sm:gap-3">
                        @foreach ($berita->skip(1)->take(3) as $item)
                            <a href="{{ route('publications.show', $item->id) }}"
                                class="flex gap-2.5 rounded-xl overflow-hidden bg-white border border-gray-100 shadow-sm hover:shadow-md transition group flex-1 min-h-0">

                                <div class="w-20 sm:w-24 flex-shrink-0 overflow-hidden bg-gray-100">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}"
                                            alt="{{ $item->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <img src="https://picsum.photos/200/200?random={{ $item->id }}"
                                            alt="{{ $item->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0 py-2 pr-2.5 flex flex-col justify-center">
                                    <span class="inline-block self-start text-[8px] font-bold uppercase tracking-wider bg-amber-400 text-[#0B2A4A] px-1.5 py-0.5 rounded mb-1">
                                        {{ $item->kategori ?? 'Berita' }}
                                    </span>
                                    <h3 class="text-[10px] sm:text-[11px] font-bold text-gray-900 leading-snug line-clamp-3 group-hover:text-[var(--color-secondary)] transition-colors">
                                        @if ($isEnglish && !empty($item->judul_en))
                                            {{ $item->judul_en }}
                                        @else
                                            {{ $item->judul }}
                                        @endif
                                    </h3>
                                    <p class="text-[9px] text-gray-400 mt-1">
                                        {{ $item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') : $item->created_at?->format('d M Y') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach

                        @for ($i = $berita->skip(1)->take(3)->count(); $i < 3; $i++)
                            <div class="flex-1 rounded-xl bg-gray-50 border border-dashed border-gray-200 flex items-center justify-center min-h-[80px]">
                                <i class="fas fa-newspaper text-gray-300"></i>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- ===================================================== --}}
            {{-- KOLOM KANAN: GALERI TERKINI                          --}}
            {{-- ===================================================== --}}
            <div class="flex flex-col h-full">
                <div class="flex items-end justify-between mb-4 sm:mb-5">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.18em] text-[var(--color-secondary)] block">
                            {{ $isEnglish ? 'PUBLICATION' : 'PUBLIKASI' }}
                        </span>
                        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mt-0.5">
                            {{ $isEnglish ? 'Latest Gallery' : 'Galeri Terkini' }}
                        </h2>
                    </div>
                    <a href="{{ route('halaman.publikasi') }}"
                        class="text-[10px] sm:text-xs font-semibold text-[var(--color-secondary)] hover:underline">
                        {{ $isEnglish ? 'View All Gallery →' : 'Lihat Semua Galeri →' }}
                    </a>
                </div>

                @php
                    $galeriItems = $berita->take(6);
                    $galeriCount = $galeriItems->count();
                @endphp

                <div class="grid grid-cols-2 gap-2 sm:gap-2.5 flex-1">
                    @foreach ($galeriItems as $item)
                        <a href="{{ route('publications.show', $item->id) }}"
                            class="relative rounded-lg overflow-hidden group block bg-gray-100 aspect-[4/3]">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                    alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="https://picsum.photos/400/300?random={{ $item->id + 100 }}"
                                    alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif
                        </a>
                    @endforeach

                    @for ($i = $galeriCount; $i < 6; $i++)
                        <div class="relative rounded-lg overflow-hidden bg-gray-100 aspect-[4/3] flex items-center justify-center">
                            <i class="fas fa-image text-gray-300 text-xl"></i>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- SOCIAL MEDIA (FULL WIDTH) -->
    <!-- ========================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        {{-- Header --}}
        <div class="mb-5 sm:mb-6">
            <span class="text-[10px] font-bold uppercase tracking-[0.18em] text-[var(--color-secondary)] block">
                {{ $isEnglish ? 'PUBLICATION' : 'PUBLIKASI' }}
            </span>
            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mt-0.5">
                Social Media
            </h2>
        </div>

        {{-- 4 Card Social Media sejajar --}}
        @php
            $socials = [
                [
                    'icon'  => 'fa-instagram',
                    'color' => 'text-pink-500',
                    'name'  => 'Instagram',
                    'desc'  => $isEnglish ? 'Official profile updates of Badan Bank Tanah.' : 'Pembaruan profil resmi Badan Bank Tanah.',
                    'url'   => 'https://www.instagram.com/badanbanktanah.official/',
                    'thumb' => 'https://picsum.photos/100/100?random=201',
                ],
                [
                    'icon'  => 'fa-tiktok',
                    'color' => 'text-black',
                    'name'  => 'TikTok',
                    'desc'  => $isEnglish ? 'Official TikTok profile of Badan Bank Tanah.' : 'Profil TikTok resmi Badan Bank Tanah.',
                    'url'   => 'https://www.tiktok.com/@badanbanktanah',
                    'thumb' => 'https://picsum.photos/100/100?random=202',
                ],
                [
                    'icon'  => 'fa-facebook',
                    'color' => 'text-blue-600',
                    'name'  => 'Facebook',
                    'desc'  => $isEnglish ? 'Strategic assets for sustainable development.' : 'Aset Strategis untuk Pembangunan Berkelanjutan.',
                    'url'   => 'https://web.facebook.com/profile.php?id=61563009502369',
                    'thumb' => 'https://picsum.photos/100/100?random=203',
                ],
                [
                    'icon'  => 'fa-youtube',
                    'color' => 'text-red-600',
                    'name'  => 'YouTube',
                    'desc'  => $isEnglish ? 'Strategic assets for sustainable development.' : 'Aset Strategis untuk Pembangunan Berkelanjutan.',
                    'url'   => 'https://www.youtube.com/@BadanBankTanahRI',
                    'thumb' => 'https://picsum.photos/100/100?random=204',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach ($socials as $social)
                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                    class="group flex items-center gap-3 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-3">

                    <div class="w-12 h-12 sm:w-14 sm:h-14 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                        <img src="{{ $social['thumb'] }}"
                            alt="{{ $social['name'] }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5 mb-1">
                            <i class="fab {{ $social['icon'] }} {{ $social['color'] }} text-[12px]"></i>
                            <span class="text-[10px] sm:text-[11px] font-semibold text-gray-700">
                                {{ $social['name'] }}
                            </span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 leading-snug line-clamp-2">
                            {{ $social['desc'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

       <!-- ========================================================= -->
    <!-- CTA SECTION (FULL WIDTH) -->
    <!-- ========================================================= -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16">
        <div class="relative rounded-xl overflow-hidden shadow-lg">

            {{-- Background foto pemandangan + daun --}}
            <div class="absolute inset-0 bg-cover bg-no-repeat"
                style="background-image: url('{{ asset('images/footer.png') }}');
                       background-position: right center;">
            </div>

            {{-- Overlay biru navy — solid di kiri, memudar ke kanan --}}
            <div class="absolute inset-0"
                style="background: linear-gradient(to right, 
                        #0B2A4A 0%, 
                        #0B2A4A 35%, 
                        rgba(11, 42, 74, 0.85) 55%, 
                        rgba(11, 42, 74, 0.3) 80%, 
                        transparent 100%);">
            </div>

            {{-- Konten --}}
            <div class="relative z-10 max-w-2xl px-6 sm:px-8 lg:px-10 py-8 sm:py-10 lg:py-12">

                {{-- Ikon headphone + judul kuning --}}
                <div class="flex items-start gap-3 sm:gap-4 mb-4">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             style="width: 32px; height: 32px; color: #FBBF24;"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 18v-6a9 9 0 0118 0v6M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z" />
                        </svg>
                    </div>
                    <h2 style="color: #FBBF24; font-size: 20px; font-weight: 700; line-height: 1.3; max-width: 420px; margin: 0;">
                        {{ $isEnglish ? 'Together Managing Land for a Better Future of Indonesia' : 'Bersama Mengelola Tanah untuk Masa Depan Indonesia' }}
                    </h2>
                </div>

                {{-- Deskripsi 2 baris --}}
                <div style="margin-bottom: 24px; max-width: 480px;">
                    <p style="color: #FFFFFF; font-size: 12px; line-height: 1.6; margin: 0 0 4px 0;">
                        {{ $isEnglish
                            ? 'Do you have questions or want to work together? Our team is ready to help.'
                            : 'Anda memiliki pertanyaan atau ingin bekerja sama? Tim kami siap membantu.' }}
                    </p>
                    <p style="color: rgba(255, 255, 255, 0.7); font-size: 11px; line-height: 1.6; margin: 0;">
                        {{ $isEnglish
                            ? 'Badan Bank Tanah is committed to becoming a professional, transparent, and sustainable land management institution.'
                            : 'Badan Bank Tanah berkomitmen menjadi lembaga pengelola tanah yang profesional, transparan, dan berkelanjutan.' }}
                    </p>
                </div>

                {{-- Tombol Hubungi Kami --}}
                <a href="{{ route('partnership') }}"
                   style="display: inline-flex; align-items: center; gap: 8px; 
                          background-color: #FBBF24; color: #0B2A4A; 
                          font-weight: 700; font-size: 12px; 
                          padding: 10px 20px; border-radius: 6px; 
                          text-decoration: none; transition: background-color 0.2s;">
                    {{ $isEnglish ? 'Contact Us' : 'Hubungi Kami' }}
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         style="width: 14px; height: 14px;" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>

            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        #heroSlider {
            position: relative;
            overflow: hidden;
        }

        #heroSlider .hero-clouds {
            position: absolute;
            inset: 0;
            z-index: 5;
            pointer-events: none;
            opacity: 1;
            background-image: url('/backgroundawanbaru.png');
            background-repeat: no-repeat;
            background-position: right top;
            background-size: 100% auto;
            transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }

        @media (max-width: 1024px) {
            #heroSlider .hero-clouds {
                background-size: 100% auto;
                background-position: right bottom;
                opacity: 0.9;
            }
        }

        @media (max-width: 768px) {
            #heroSlider .hero-clouds {
                background-size: 130% auto;
                background-position: right bottom -20px;
                opacity: 0.85;
            }
        }

        @media (max-width: 640px) {
            #heroSlider .hero-clouds {
                background-size: 150% auto;
                background-position: right bottom -30px;
                opacity: 0.8;
            }
        }

        @media (max-width: 480px) {
            #heroSlider .hero-clouds {
                background-size: 170% auto;
                background-position: right bottom -40px;
                opacity: 0.75;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #heroSlider .hero-clouds {
                transition: none;
            }
        }

        #petaPersebaran {
            width: 100%;
            height: 380px;
            background: #ffffff;
            border-radius: 12px;
            z-index: 0;
        }

        @media (min-width: 640px) {
            #petaPersebaran { height: 460px; }
        }

        @media (min-width: 1024px) {
            #petaPersebaran { height: 520px; }
        }

        #petaPersebaran .leaflet-container {
            background: #ffffff !important;
            font-family: 'Inter', sans-serif !important;
        }

        #petaPersebaran .leaflet-control-attribution {
            font-size: 9px;
            background: rgba(255, 255, 255, 0.75);
            color: #9ca3af;
            padding: 1px 6px;
            border-radius: 4px;
        }

        #petaPersebaran .leaflet-control-zoom a {
            color: #4b5563;
            border-color: #e5e7eb;
            width: 30px;
            height: 30px;
            line-height: 28px;
            font-size: 16px;
        }

        #petaPersebaran .leaflet-control-zoom a:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .aset-marker {
            width: 12px;
            height: 12px;
            background: #16a34a;
            border: 2px solid #ffffff;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.35);
            transition: transform 0.18s ease, background 0.18s ease;
            cursor: pointer;
        }

        .aset-marker:hover {
            transform: scale(1.5);
            background: #15803d;
        }

        #petaPersebaran .leaflet-popup-content-wrapper {
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            padding: 2px;
        }

        #petaPersebaran .leaflet-popup-content {
            margin: 10px 12px;
            font-family: 'Inter', sans-serif;
            line-height: 1.4;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof L === "undefined") {
                console.error("❌ Leaflet tidak ditemukan!");
                return;
            }

            var mapElement = document.getElementById("map");
            if (!mapElement) return;

            try {
                var map = L.map("map").setView([-2.5, 118.0], 5);

                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: "&copy; OpenStreetMap contributors",
                    maxZoom: 19
                }).addTo(map);

                var markers = @json($markers ?? []);

                if (markers.length > 0) {
                    markers.forEach(function(marker) {
                        if (marker.lat && marker.lng) {
                            var color = marker.status === "Tersedia" ? "#16a34a" :
                                (marker.status === "Dalam Pengembangan" ? "#3b82f6" :
                                    (marker.status === "Dalam Proses" ? "#f97316" : "#6b7280"));

                            var popupContent = `
                                <div style="min-width:200px;font-family:Inter,sans-serif;padding:4px 0;">
                                    <div style="font-weight:700;font-size:15px;color:#111827;margin-bottom:4px;">
                                        ${marker.nama_lokasi || "Aset Tanah"}
                                    </div>
                                    <div style="font-size:12px;color:#6B7280;margin-bottom:8px;">
                                        📍 ${marker.provinsi || ""}${marker.kabupaten ? ", " + marker.kabupaten : ""}
                                    </div>
                                    <div style="background:#f0fdf4;padding:10px;border-radius:8px;margin-bottom:8px;">
                                        <div style="font-size:9px;color:#6B7280;text-transform:uppercase;">Total Luas</div>
                                        <div style="font-size:16px;font-weight:700;color:#006400;">
                                            ${Number(marker.luas_hektar).toLocaleString("id-ID")} Ha
                                        </div>
                                    </div>
                                    <div style="font-size:12px;color:#4B5563;line-height:1.8;">
                                        <strong>Status:</strong> <span style="color:${color};font-weight:600;">${marker.status || "-"}</span><br>
                                        <strong>Peruntukan:</strong> ${marker.peruntukan || "-"}<br>
                                        <strong>Skema:</strong> ${marker.skema || "-"}
                                    </div>
                                </div>
                            `;

                            L.circleMarker([marker.lat, marker.lng], {
                                color: color,
                                fillColor: color,
                                fillOpacity: 0.7,
                                radius: 8,
                                weight: 2,
                                opacity: 1
                            }).addTo(map).bindPopup(popupContent);
                        }
                    });

                    var bounds = markers.filter(m => m.lat && m.lng).map(m => [m.lat, m.lng]);
                    if (bounds.length > 0) {
                        map.fitBounds(bounds, {
                            padding: [30, 30],
                            maxZoom: 6
                        });
                    }
                }

                setTimeout(function() {
                    map.invalidateSize();
                }, 500);
            } catch (e) {
                console.error("❌ Error inisialisasi peta:", e);
            }
        });
    </script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hero = document.getElementById('heroSlider');
            const clouds = hero ? hero.querySelector('.hero-clouds') : null;

            if (!hero || !clouds) return;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            const MAX_X = 25;
            const MAX_Y = 12;
            const EASE = 0.10;
            const RETURN_TO_ORIGIN = true;

            let targetX = 0, targetY = 0;
            let currentX = 0, currentY = 0;
            let rafId = null;
            let isInside = false;

            function tick() {
                currentX += (targetX - currentX) * EASE;
                currentY += (targetY - currentY) * EASE;

                clouds.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;

                const dx = Math.abs(targetX - currentX);
                const dy = Math.abs(targetY - currentY);

                if (dx < 0.1 && dy < 0.1) {
                    currentX = targetX;
                    currentY = targetY;
                    clouds.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;
                    rafId = null;
                    return;
                }

                rafId = requestAnimationFrame(tick);
            }

            function startLoop() {
                if (!rafId) rafId = requestAnimationFrame(tick);
            }

            hero.addEventListener('mouseenter', function() {
                isInside = true;
            });

            hero.addEventListener('mousemove', function(e) {
                if (!isInside) return;
                const rect = hero.getBoundingClientRect();
                const relX = ((e.clientX - rect.left) / rect.width) * 2 - 1;
                const relY = ((e.clientY - rect.top) / rect.height) * 2 - 1;

                targetX = relX * MAX_X;
                targetY = relY * MAX_Y;

                startLoop();
            });

            hero.addEventListener('mouseleave', function() {
                isInside = false;
                if (RETURN_TO_ORIGIN) {
                    targetX = 0;
                    targetY = 0;
                    startLoop();
                }
            });
        });
    </script>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof L === "undefined") {
            console.error("❌ Leaflet tidak ditemukan!");
            return;
        }

        const mapEl = document.getElementById("petaPersebaran");
        if (!mapEl) {
            console.warn("⚠️ #petaPersebaran tidak ditemukan di DOM.");
            return;
        }

        const map = L.map("petaPersebaran", {
            zoomControl: true,
            scrollWheelZoom: false,
            minZoom: 4,
            maxZoom: 9,
            zoomSnap: 0.25,
            maxBounds: [[-15, 88], [10, 148]],
            maxBoundsViscosity: 0.8,
        }).setView([-2.2, 118.0], 5);

        map.getContainer().style.background = "#ffffff";

        fetch("{{ asset('geojson/indonesia.geojson') }}")
            .then(res => {
                if (!res.ok) throw new Error("HTTP " + res.status);
                return res.json();
            })
            .then(geojson => {
                L.geoJSON(geojson, {
                    style: function () {
                        return {
                            color: "#9ca3af",
                            weight: 0.7,
                            opacity: 1,
                            fillColor: "#e5e7eb",
                            fillOpacity: 1,
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        layer.options.interactive = false;
                    }
                }).addTo(map);
            })
            .catch(err => {
                console.error("❌ Gagal load GeoJSON:", err);
            });

        const markers = @json($markers ?? []);
        console.log("📍 Marker count:", markers.length);

        markers.forEach(function (m) {
            if (!m.lat || !m.lng) return;

            const greenIcon = L.divIcon({
                className: "",
                html: '<div class="aset-marker"></div>',
                iconSize: [12, 12],
                iconAnchor: [6, 6],
                popupAnchor: [0, -8],
            });

            const popupContent = `
                <div style="min-width:180px;">
                    <div style="font-weight:700;font-size:14px;color:#111827;margin-bottom:3px;">
                        ${m.nama_lokasi || "Aset Tanah"}
                    </div>
                    <div style="font-size:11px;color:#6B7280;margin-bottom:6px;">
                        📍 ${m.provinsi || ""}${m.kabupaten ? ", " + m.kabupaten : ""}
                    </div>
                    <div style="background:#f0fdf4;padding:8px 10px;border-radius:6px;">
                        <div style="font-size:9px;color:#6B7280;text-transform:uppercase;letter-spacing:0.5px;">Luas</div>
                        <div style="font-size:14px;font-weight:700;color:#15803d;">
                            ${Number(m.luas_hektar || 0).toLocaleString("id-ID")} Ha
                        </div>
                    </div>
                </div>
            `;

            L.marker([m.lat, m.lng], { icon: greenIcon })
                .addTo(map)
                .bindPopup(popupContent);
        });

        setTimeout(() => map.invalidateSize(), 250);
        window.addEventListener("resize", () => map.invalidateSize());
    });
</script>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ [PETA] Script jalan");

    if (typeof L === "undefined") {
        console.error("❌ [PETA] Leaflet tidak ditemukan!");
        return;
    }

    const mapEl = document.getElementById("petaPersebaran");
    if (!mapEl) {
        console.warn("⚠️ [PETA] #petaPersebaran tidak ada di DOM");
        return;
    }
    console.log("✅ [PETA] #petaPersebaran ditemukan");

    const map = L.map("petaPersebaran", {
        zoomControl: true,
        scrollWheelZoom: false,
        minZoom: 4,
        maxZoom: 9,
        zoomSnap: 0.25,
        maxBounds: [[-15, 88], [10, 148]],
        maxBoundsViscosity: 0.8,
    }).setView([-2.2, 118.0], 5);

    map.getContainer().style.background = "#ffffff";
    console.log("✅ [PETA] Leaflet map dibuat");

    fetch("{{ asset('geojson/indonesia.geojson') }}")
        .then(res => {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.json();
        })
        .then(geojson => {
            console.log("✅ [PETA] GeoJSON loaded");
            L.geoJSON(geojson, {
                style: () => ({
                    color: "#9ca3af",
                    weight: 0.7,
                    opacity: 1,
                    fillColor: "#e5e7eb",
                    fillOpacity: 1,
                }),
                onEachFeature: (f, layer) => { layer.options.interactive = false; }
            }).addTo(map);
        })
        .catch(err => console.error("❌ [PETA] Gagal load GeoJSON:", err));

    const markers = @json($markers ?? []);
    console.log("📍 [PETA] Marker count:", markers.length);
    markers.forEach(function (m) {
        if (!m.lat || !m.lng) return;
        const greenIcon = L.divIcon({
            className: "",
            html: '<div class="aset-marker"></div>',
            iconSize: [12, 12],
            iconAnchor: [6, 6],
            popupAnchor: [0, -8],
        });
        L.marker([m.lat, m.lng], { icon: greenIcon }).addTo(map);
    });

    setTimeout(() => map.invalidateSize(), 250);
    window.addEventListener("resize", () => map.invalidateSize());
});
</script>
@endpush