<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

    @php
        $metaTitle = $metaTitle ?? 'Badan Bank Tanah - Mengelola Tanah, Memajukan Negeri';
        $metaDescription =
            $metaDescription ??
            'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.';
        $isEnglish = session('locale', 'id') === 'en';
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- ========================================================= --}}
    {{-- GOOGLE ANALYTICS --}}
    {{-- ========================================================= --}}
    @if (isset($pengaturan) && $pengaturan->google_analytics)
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $pengaturan->google_analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $pengaturan->google_analytics }}');
        </script>
    @endif

    <style>
        /* =========================================================
           BASE
        ========================================================= */
        * {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .leaflet-container {
            z-index: 0;
        }

        /* =========================================================
           SCROLLBAR
        ========================================================= */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #006400;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #005500;
        }

        /* =========================================================
           DINAMIC COLORS - DARI PENGATURAN
        ========================================================= */
        :root {
            --color-primary: {{ $pengaturan->warna_utama ?? '#0B2A4A' }};
            --color-secondary: {{ $pengaturan->warna_sekunder ?? '#1D4ED8' }};
            --color-secondary-hover: {{ $pengaturan->warna_utama ?? '#0B2A4A' }};
        }

        /* NAVBAR - Active link menggunakan warna sekunder */
        .active-nav {
            color: var(--color-secondary) !important;
        }

        .active-nav::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--color-secondary) !important;
            border-radius: 10px;
        }

        /* Link hover menggunakan warna sekunder */
        nav a:not(.active-nav):hover {
            color: var(--color-secondary) !important;
        }

        /* Tombol utama menggunakan warna sekunder */
        .btn-primary {
            background-color: var(--color-secondary) !important;
            color: white !important;
        }

        .btn-primary:hover {
            background-color: var(--color-secondary-hover) !important;
        }

        /* Link warna sekunder */
        .link-secondary {
            color: var(--color-secondary) !important;
        }

        .link-secondary:hover {
            color: var(--color-secondary-hover) !important;
            text-decoration: underline;
        }

        /* Border warna sekunder */
        .border-secondary {
            border-color: var(--color-secondary) !important;
        }

        /* =========================================================
           NAVBAR IMPROVEMENTS
        ========================================================= */
        nav a {
            position: relative;
            padding: 6px 4px;
            letter-spacing: 0.5px;
            font-size: 0.95rem;
        }

        /* Dropdown menu items spacing */
        .dropdown-desktop .dropdown-menu a {
            padding: 12px 20px;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
        }

        /* =========================================================
           MOBILE NAV
        ========================================================= */
        .mobile-nav {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 300px;
            max-width: 85vw;
            background: #ffffff;
            z-index: 99999;
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            padding: 24px 20px 30px;
            display: flex;
            flex-direction: column;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.15);
        }

        .mobile-nav.open {
            transform: translateX(0);
        }

        .mobile-nav-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 16px;
            border-bottom: 1px solid #f3f4f6;
            margin-bottom: 8px;
        }

        .mobile-nav-header .logo-text {
            font-size: 1rem;
            font-weight: 700;
            color: #0B2A4A;
        }

        .mobile-nav-header .logo-text span {
            color: var(--color-secondary);
        }

        .mobile-nav-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f3f4f6;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #374151;
            font-size: 1rem;
        }

        .mobile-nav-close:hover,
        .mobile-nav-close:active {
            background: #e5e7eb;
            transform: rotate(90deg);
        }

        .mobile-nav .nav-list {
            flex: 1;
            padding: 8px 0;
        }

        .mobile-nav .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: #374151;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            margin-bottom: 2px;
            position: relative;
        }

        .mobile-nav .nav-item:active,
        .mobile-nav .nav-item.active {
            background: #f0fdf4;
            color: var(--color-secondary) !important;
        }

        .mobile-nav .nav-item i {
            width: 20px;
            text-align: center;
            color: #9ca3af;
            font-size: 1rem;
            transition: color 0.2s ease;
        }

        .mobile-nav .nav-item:active i,
        .mobile-nav .nav-item.active i {
            color: var(--color-secondary) !important;
        }

        .mobile-nav .nav-item .nav-badge {
            margin-left: auto;
            font-size: 0.6rem;
            background: #f3f4f6;
            color: #9ca3af;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .mobile-nav .nav-item:active .nav-badge,
        .mobile-nav .nav-item.active .nav-badge {
            background: #dcfce7;
            color: var(--color-secondary);
        }

        .mobile-nav .nav-divider {
            height: 1px;
            background: #f3f4f6;
            margin: 8px 14px;
        }

        .mobile-nav .nav-section-title {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9ca3af;
            font-weight: 600;
            padding: 12px 14px 6px;
        }

        .mobile-nav .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 8px;
            bottom: 8px;
            width: 3px;
            background: var(--color-secondary) !important;
            border-radius: 0 4px 4px 0;
        }

        .mobile-nav-footer {
            border-top: 1px solid #f3f4f6;
            padding-top: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mobile-nav-footer .btn-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .mobile-nav-footer .btn-nav-login {
            background: #f3f4f6;
            color: #374151;
        }

        .mobile-nav-footer .btn-nav-login:active {
            background: #e5e7eb;
        }

        .mobile-nav-footer .btn-nav-register {
            background: var(--color-secondary) !important;
            color: white;
        }

        .mobile-nav-footer .btn-nav-register:active {
            background: var(--color-primary) !important;
        }

        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 99998;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.35s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        /* =========================================================
           HAMBURGER MENU BUTTON
        ========================================================= */
        .hamburger {
            width: 28px;
            height: 20px;
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 0;
            border: none;
            background: transparent;
            z-index: 99999;
        }

        .hamburger span {
            display: block;
            height: 2.5px;
            background: #ffffff !important;
            border-radius: 10px;
            transition: all 0.3s ease;
            transform-origin: center;
        }

        .hamburger.active span:nth-child(1) {
            transform: translateY(8.5px) rotate(45deg);
            background: var(--color-secondary) !important;
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }

        .hamburger.active span:nth-child(3) {
            transform: translateY(-8.5px) rotate(-45deg);
            background: var(--color-secondary) !important;
        }

        @media (min-width: 1024px) {
            .hamburger {
                display: none !important;
            }
        }

        @media (max-width: 640px) {
            .text-hero-mobile {
                font-size: 2rem !important;
                line-height: 1.2 !important;
            }
        }

        /* =========================================================
           LOGO RESPONSIVE
        ========================================================= */
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border-radius: 8px;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        @media (max-width: 480px) {
            .logo-container {
                width: 60px;
                height: 54px;
            }

            .logo-container img {
                max-width: 58px;
                max-height: 52px;
            }
        }

        @media (min-width: 481px) and (max-width: 767px) {
            .logo-container {
                width: 70px;
                height: 62px;
            }

            .logo-container img {
                max-width: 68px;
                max-height: 60px;
            }
        }

        @media (min-width: 768px) and (max-width: 1023px) {
            .logo-container {
                width: 80px;
                height: 72px;
            }

            .logo-container img {
                max-width: 78px;
                max-height: 70px;
            }
        }

        @media (min-width: 1024px) {
            .logo-container {
                width: 90px;
                height: 80px;
            }

            .logo-container img {
                max-width: 88px;
                max-height: 78px;
            }
        }

        /* =========================================================
           SCROLL REVEAL ANIMATION
        ========================================================= */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-scale {
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-scale.active {
            opacity: 1;
            transform: scale(1);
        }

        /* Delay classes */
        .delay-1 {
            transition-delay: 0.1s;
        }

        .delay-2 {
            transition-delay: 0.2s;
        }

        .delay-3 {
            transition-delay: 0.3s;
        }

        .delay-4 {
            transition-delay: 0.4s;
        }

        .delay-5 {
            transition-delay: 0.5s;
        }

        /* =========================================================
   FRONTEND DARK MODE
========================================================= */
        body.dark {
            background-color: #111827 !important;
            color: #e5e7eb !important;
        }

        body.dark .bg-white {
            background-color: #1f2937 !important;
            color: #e5e7eb !important;
        }

        body.dark .bg-gray-50 {
            background-color: #111827 !important;
        }

        body.dark .bg-gray-100 {
            background-color: #1f2937 !important;
        }

        body.dark .text-gray-900 {
            color: #f9fafb !important;
        }

        body.dark .text-gray-700 {
            color: #e5e7eb !important;
        }

        body.dark .text-gray-600 {
            color: #d1d5db !important;
        }

        body.dark .text-gray-500 {
            color: #9ca3af !important;
        }

        body.dark .border-gray-200 {
            border-color: #374151 !important;
        }

        body.dark .border-gray-100 {
            border-color: #374151 !important;
        }

        body.dark .shadow-sm,
        body.dark .shadow-md,
        body.dark .shadow-lg {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3) !important;
        }

        /* Dark Mode Toggle Button */
        #darkModeToggle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: transparent;
            border: none;
            color: #4b5563;
        }

        #darkModeToggle:hover {
            background: #f3f4f6;
        }

        body.dark #darkModeToggle {
            color: #facc15;
        }

        body.dark #darkModeToggle:hover {
            background: #374151;
        }

        @media (max-width: 1100px) {
            #hamburgerBtn {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                width: 40px !important;
                height: 40px !important;
                position: relative !important;
                z-index: 9999 !important;
                flex-shrink: 0 !important;
            }

            #hamburgerBtn span {
                color: #ffffff !important;
                background: #ffffff !important;

                display: block !important;
                width: 24px !important;
                height: 3px !important;
                margin: 4px auto !important;
                background: #ffffff !important;
            }
        }

        @media (max-width: 1023px) {
            #hamburgerBtn span {
                background: #1f2937 !important;
            }

            body.dark #hamburgerBtn span {
                background: #ffffff !important;
            }
        }

        @media (max-width: 1023px) {
            #hamburgerBtn {
                width: 42px !important;
                height: 42px !important;
                padding: 9px !important;
                border: 0 !important;
                border-radius: 10px !important;
                background: transparent !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 5px !important;
                transition: background 0.2s ease, transform 0.2s ease !important;
            }

            #hamburgerBtn span {
                width: 23px !important;
                height: 2px !important;
                margin: 0 !important;
                border-radius: 999px !important;
                transition: transform 0.25s ease, opacity 0.2s ease, background 0.2s ease !important;
            }

            #hamburgerBtn:hover {
                background: rgba(15, 23, 42, 0.08) !important;
            }

            body.dark #hamburgerBtn:hover {
                background: rgba(255, 255, 255, 0.12) !important;
            }

            #hamburgerBtn:active {
                transform: scale(0.94) !important;
            }
        }


        /* =========================================================
           DARK MODE - SKEMA CARD FIX
        ========================================================= */
        body.dark-mode .bg-white.rounded-2xl {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }

        body.dark-mode .bg-white.rounded-2xl .text-gray-900 {
            color: #f9fafb !important;
        }

        body.dark-mode .bg-white.rounded-2xl .text-gray-500 {
            color: #9ca3af !important;
        }

        body.dark-mode .bg-white.rounded-2xl .text-gray-600 {
            color: #d1d5db !important;
        }

        body.dark-mode .bg-white.rounded-2xl .border-gray-200 {
            border-color: #374151 !important;
        }

        body.dark-mode .bg-white.rounded-2xl .link-secondary {
            color: #60a5fa !important;
        }

        body.dark-mode .bg-white.rounded-2xl .link-secondary:hover {
            color: #93bbfc !important;
        }


        /* =========================================================
           DARK MODE - PARTNERSHIP CARDS FIX
        ========================================================= */
        body.dark-mode .bg-white.rounded-2xl {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }

        body.dark-mode .bg-gray-50.rounded-2xl {
            background-color: #111827 !important;
            border-color: #374151 !important;
        }

        body.dark-mode .bg-white.rounded-2xl .text-gray-900 {
            color: #f9fafb !important;
        }

        body.dark-mode .bg-white.rounded-2xl .text-gray-500 {
            color: #9ca3af !important;
        }

        body.dark-mode .bg-white.rounded-2xl .text-gray-600 {
            color: #d1d5db !important;
        }

        body.dark-mode .bg-white.rounded-2xl .border-gray-200 {
            border-color: #374151 !important;
        }

        body.dark-mode .bg-white.rounded-2xl .border-gray-100 {
            border-color: #374151 !important;
        }

        body.dark-mode .bg-white.rounded-2xl .link-secondary {
            color: #60a5fa !important;
        }

        body.dark-mode .bg-white.rounded-2xl .link-secondary:hover {
            color: #93bbfc !important;
        }

        body.dark-mode .bg-white.rounded-2xl .bg-[#0B2A4A]/10 {
            background-color: rgba(59, 130, 246, 0.2) !important;
        }

        body.dark-mode .bg-white.rounded-2xl .text-[#0B2A4A] {
            color: #60a5fa !important;
        }

        body.dark-mode .border-gray-200 {
            border-color: #374151 !important;
        }

        body.dark-mode .bg-gray-50 {
            background-color: #111827 !important;
        }

        @stack('styles') </head>
       <body class="bg-white text-gray-800 antialiased">

    @php
        $activePages = \App\Models\Halaman::where('is_active', true)->get();
        $activePageTitles = $activePages->pluck('judul')->map(fn($t) => strtolower($t))->toArray();

        $mainMenus = $menuNavigasi->filter(function ($menu) use ($activePageTitles) {
            if ($menu->status != 'Aktif') return false;
            $menuName = strtolower($menu->nama);
            $pageMapping = [
                'tentang' => 'tentang',
                'pemanfaatan & kerjasama' => 'pemanfaatan',
                'publikasi' => 'publikasi',
            ];
            foreach ($pageMapping as $key => $value) {
                if (str_contains($menuName, $key)) {
                    return \App\Models\Halaman::where('judul', 'like', '%' . $value . '%')
                        ->where('is_active', true)->exists();
                }
            }
            return in_array($menuName, ['faq', 'karier', 'kontak', 'beranda', 'aset persediaan tanah']);
        });

        $otherMenus = $menuNavigasi->filter(function ($menu) {
            return $menu->status == 'Aktif' && in_array(strtolower($menu->nama), ['faq', 'karier', 'kontak']);
        });

        $footer = \App\Models\FooterSetting::getSettings();

        $menuLabels = [
            'home' => $isEnglish ? 'Home' : 'Beranda',
            'about' => $isEnglish ? 'About' : 'Tentang',
            'assets' => $isEnglish ? 'Land Assets' : 'Aset Persediaan Tanah',
            'partnership' => $isEnglish ? 'Utilization & Partnership' : 'Pemanfaatan & Kerjasama',
            'publications' => $isEnglish ? 'Publications' : 'Publikasi',
            'faq' => 'FAQ',
            'career' => $isEnglish ? 'Career' : 'Karier',
            'contact' => $isEnglish ? 'Contact' : 'Kontak',
            'others' => $isEnglish ? 'Others' : 'Lainnya',
            'login' => $isEnglish ? 'Admin Login' : 'Masuk Admin',
            'search' => $isEnglish ? 'Search' : 'Pencarian',
            'quick_links' => $isEnglish ? 'Quick Links' : 'Tautan Cepat',
            'contact_info' => $isEnglish ? 'Contact' : 'Kontak',
            'newsletter' => $isEnglish ? 'Newsletter' : 'Newsletter',
            'privacy' => $isEnglish ? 'Privacy Policy' : 'Kebijakan Privasi',
            'terms' => $isEnglish ? 'Terms & Conditions' : 'Syarat & Ketentuan',
            'accessibility' => $isEnglish ? 'Accessibility' : 'Aksesibilitas',
        ];

        $megaTentang = [
            'label' => $isEnglish ? 'ABOUT US' : 'TENTANG KAMI',
            'title' => $isEnglish ? 'Get to Know Badan Bank Tanah' : 'Mengenal Badan Bank Tanah',
            'description' => $isEnglish
                ? 'Badan Bank Tanah is present as a strategic instrument of the state in managing land for the greater benefit and sustainability.'
                : 'Badan Bank Tanah hadir sebagai instrumen strategis negara dalam menata dan mengelola tanah untuk kepentingan yang lebih luas dan berkelanjutan.',
            'submenus' => [
                ['icon' => 'fa-building-columns', 'title' => $isEnglish ? 'Profile' : 'Profil', 'description' => $isEnglish ? 'General information about Badan Bank Tanah' : 'Informasi umum tentang Badan Bank Tanah'],
                ['icon' => 'fa-eye', 'title' => $isEnglish ? 'Vision & Mission' : 'Visi & Misi', 'description' => $isEnglish ? 'Vision, mission, and values that become the foundation' : 'Visi, misi, dan nilai-nilai yang menjadi landasan'],
                ['icon' => 'fa-sitemap', 'title' => $isEnglish ? 'Organizational Structure' : 'Struktur Organisasi', 'description' => $isEnglish ? 'Organizational structure and role division' : 'Struktur organisasi dan pembagian peran'],
                ['icon' => 'fa-clipboard-list', 'title' => $isEnglish ? 'Functions & Duties' : 'Fungsi & Tugas', 'description' => $isEnglish ? 'Duties and functions in carrying out the mandate' : 'Tugas dan fungsi dalam pelaksanaan mandat'],
                ['icon' => 'fa-users', 'title' => $isEnglish ? 'Leadership Profile' : 'Profil Pimpinan', 'description' => $isEnglish ? 'Information on leadership and management' : 'Informasi pimpinan dan jajaran manajemen'],
            ],
            'banner' => [
                'label' => $isEnglish ? 'ABOUT US' : 'TENTANG KAMI',
                'title' => $isEnglish ? 'Land Managed, Nation Empowered' : 'Tanah Dikelola, Negara Berdaya',
                'description' => $isEnglish ? 'Together managing land for the welfare of Indonesian society.' : 'Bersama mengelola tanah untuk kesejahteraan masyarakat Indonesia.',
            ],
        ];
    @endphp

    <!-- MOBILE OVERLAY -->
    <div class="mobile-overlay" id="mobileOverlay" aria-hidden="true"></div>

    <!-- MOBILE NAV -->
    <nav class="mobile-nav" id="mobileNav" role="navigation" aria-label="Mobile Navigation">
        <div class="mobile-nav-header">
            <span class="logo-text">Badan <span>Bank Tanah</span></span>
            <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close navigation menu">
                <i class="fas fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="nav-list">
            <div class="nav-section-title">{{ $menuLabels['home'] }}</div>

            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-house" aria-hidden="true"></i>
                {{ $menuLabels['home'] }}
            </a>

            @php
                $menuItems = [
                    ['route' => 'about', 'icon' => 'fa-circle-info', 'label' => $menuLabels['about'], 'check' => 'tentang'],
                    ['route' => 'assets', 'icon' => 'fa-map-pin', 'label' => $menuLabels['assets'], 'check' => 'aset'],
                    ['route' => 'partnership', 'icon' => 'fa-handshake', 'label' => $menuLabels['partnership'], 'check' => 'pemanfaatan'],
                    ['route' => 'halaman.publikasi', 'icon' => 'fa-newspaper', 'label' => $menuLabels['publications'], 'check' => 'publikasi'],
                ];
            @endphp

            @foreach ($menuItems as $item)
                @php
                    $isActive = false;
                    if ($item['check'] == 'tentang') {
                        $isActive = \App\Models\Halaman::where('judul', 'like', '%Tentang%')->where('is_active', true)->exists();
                    } elseif ($item['check'] == 'pemanfaatan') {
                        $isActive = \App\Models\Halaman::where('judul', 'like', '%Pemanfaatan%')->where('is_active', true)->exists();
                    } elseif ($item['check'] == 'publikasi') {
                        $isActive = \App\Models\Halaman::where('judul', 'like', '%Publikasi%')->where('is_active', true)->exists();
                    } else {
                        $isActive = true;
                    }
                @endphp
                @if ($isActive)
                    <a href="{{ route($item['route']) }}" class="nav-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <i class="fas {{ $item['icon'] }}" aria-hidden="true"></i>
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach

            <div class="nav-divider"></div>
            <div class="nav-section-title">{{ $menuLabels['others'] }}</div>

            <a href="{{ route('faq') }}" class="nav-item">
                <i class="fas fa-circle-question" aria-hidden="true"></i>
                {{ $menuLabels['faq'] }}
            </a>
            <a href="{{ route('karier') }}" class="nav-item">
                <i class="fas fa-briefcase" aria-hidden="true"></i>
                {{ $menuLabels['career'] }}
            </a>
            <a href="{{ route('kontak') }}" class="nav-item">
                <i class="fas fa-envelope" aria-hidden="true"></i>
                {{ $menuLabels['contact'] }}
            </a>
        </div>
    </nav>

    <!-- TOP BAR -->
    <div class="text-white text-xs hidden sm:block" style="background-color: {{ $pengaturan->warna_utama ?? '#0B2A4A' }};">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-2">
            <div class="flex items-center gap-2">
                <i class="fas fa-globe text-blue-300"></i>
                <span class="truncate">{{ $isEnglish ? 'Advancing Productive, Transparent, and Sustainable Land Management' : 'Memajukan Pengelolaan Tanah yang Produktif, Transparan, dan Berkelanjutan' }}</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('kontak') }}" class="hover:text-blue-300 transition">{{ $menuLabels['contact'] }}</a>
                <a href="{{ route('search') }}" class="hover:text-blue-300 transition">{{ $menuLabels['search'] }}</a>
            </div>
        </div>
    </div>

    <!-- NAVBAR UTAMA -->
    <header class="bg-white sticky top-0 z-[9999] shadow-sm" role="banner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">

                {{-- LOGO --}}
                <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
                    <div class="logo-container">
                        <img src="{{ asset('images/Logo-badan-bank-tanah.png') }}" alt="Logo Badan Bank Tanah" class="w-full h-full object-contain">
                    </div>
                </a>

                {{-- DESKTOP NAVIGATION --}}
                <nav class="hidden lg:flex items-center space-x-8 xl:space-x-10 text-gray-700" aria-label="Main Navigation">

                    {{-- ===== MENU TENTANG + MEGA MENU ===== --}}
                    <div class="relative group" id="megaTentangWrapper">
                        <a href="{{ route('about') }}" class="hover:text-[var(--color-secondary)] transition font-medium flex items-center gap-1.5 py-2">
                            {{ $menuLabels['about'] }}
                            <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 group-hover:rotate-180"></i>
                        </a>

                        <div id="megaTentangPanel"
                            class="absolute left-0 top-full pt-3 w-[1100px] max-w-[95vw]
                                   opacity-0 invisible translate-y-2
                                   group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                                   transition-all duration-300 ease-out z-[9999]">
                            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                                <div class="grid grid-cols-12 gap-0">

                                    {{-- KIRI: INFO UTAMA --}}
                                    <div class="col-span-3 p-6 border-r border-gray-100 bg-gray-50/50">
                                        <span class="text-[10px] font-bold text-[var(--color-secondary)] uppercase tracking-widest">
                                            {{ $megaTentang['label'] }}
                                        </span>
                                        <h3 class="text-lg font-bold text-gray-900 mt-2 mb-3 leading-snug">
                                            {{ $megaTentang['title'] }}
                                        </h3>
                                        <p class="text-xs text-gray-600 leading-relaxed mb-4">
                                            {{ $megaTentang['description'] }}
                                        </p>
                                        <div class="rounded-lg overflow-hidden h-24 bg-gradient-to-b from-blue-50 via-white to-blue-50 relative">
                                            <svg viewBox="0 0 200 100" class="w-full h-full" preserveAspectRatio="none">
                                                <path d="M0,80 Q50,60 100,75 T200,70 L200,100 L0,100 Z" fill="#dbeafe" opacity="0.6" />
                                                <path d="M0,90 Q50,75 100,85 T200,80 L200,100 L0,100 Z" fill="#bfdbfe" opacity="0.5" />
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- TENGAH: SUBMENU --}}
                                    <div class="col-span-5 p-4">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3">SUBMENU</span>
                                        <div class="space-y-0.5 mt-2">
                                            @foreach ($megaTentang['submenus'] as $sub)
                                                <a href="#" class="flex items-start gap-3 p-3 rounded-lg hover:bg-blue-50 transition group/item">
                                                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-[var(--color-secondary)] flex items-center justify-center flex-shrink-0 group-hover/item:bg-[var(--color-secondary)] group-hover/item:text-white transition">
                                                        <i class="fas {{ $sub['icon'] }} text-sm"></i>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <h4 class="font-semibold text-gray-900 text-sm leading-tight group-hover/item:text-[var(--color-secondary)] transition">
                                                            {{ $sub['title'] }}
                                                        </h4>
                                                        <p class="text-[11px] text-gray-500 leading-snug mt-0.5">
                                                            {{ $sub['description'] }}
                                                        </p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- KANAN: BANNER --}}
                                    <div class="col-span-4 p-4">
                                        <div class="relative rounded-xl overflow-hidden h-full min-h-[280px]" style="background: linear-gradient(160deg, #0B2A4A 0%, #1D4ED8 100%);">
                                            <svg viewBox="0 0 400 400" class="absolute inset-0 w-full h-full opacity-30" preserveAspectRatio="xMidYMid slice">
                                                <path d="M0,300 Q100,250 200,280 T400,270 L400,400 L0,400 Z" fill="#22c55e" opacity="0.3" />
                                                <path d="M0,340 Q120,300 220,320 T400,310 L400,400 L0,400 Z" fill="#15803d" opacity="0.4" />
                                            </svg>
                                            <div class="absolute inset-0 bg-gradient-to-t from-[#0B2A4A] via-[#0B2A4A]/60 to-transparent"></div>
                                            <div class="relative p-5 h-full flex flex-col justify-end">
                                                <span class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest">
                                                    {{ $megaTentang['banner']['label'] }}
                                                </span>
                                                <h3 class="text-base font-bold text-white mt-1 mb-2 leading-snug">
                                                    {{ $megaTentang['banner']['title'] }}
                                                </h3>
                                                <p class="text-[11px] text-white/80 leading-snug mb-3">
                                                    {{ $megaTentang['banner']['description'] }}
                                                </p>
                                                <a href="#" class="inline-flex items-center gap-1.5 bg-yellow-400 hover:bg-yellow-500 text-[#0B2A4A] font-bold px-4 py-2 rounded-lg text-xs transition w-fit">
                                                    {{ $isEnglish ? 'Learn More' : 'Selengkapnya' }}
                                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MENU LAIN --}}
                    <a href="{{ route('assets') }}" class="hover:text-[var(--color-secondary)] transition font-medium">{{ $menuLabels['assets'] }}</a>
                    <a href="{{ route('partnership') }}" class="hover:text-[var(--color-secondary)] transition font-medium">{{ $menuLabels['partnership'] }}</a>
                    <a href="{{ route('halaman.publikasi') }}" class="hover:text-[var(--color-secondary)] transition font-medium">{{ $menuLabels['publications'] }}</a>

                    {{-- DROPDOWN LAINNYA --}}
                    @if ($otherMenus->count() > 0)
                        <div class="relative inline-block">
                            <button id="dropdownLainnyaBtn" onclick="toggleDropdownLainnya()" aria-expanded="false"
                                class="flex items-center gap-1.5 py-2 px-1 text-sm font-medium text-gray-700 hover:text-[var(--color-secondary)] transition">
                                {{ $menuLabels['others'] ?? 'Lainnya' }}
                                <i id="dropdownLainnyaIcon" class="fas fa-chevron-down text-[10px] transition-transform duration-200"></i>
                            </button>
                            <div id="dropdownLainnyaMenu" role="menu" style="min-width: 200px;"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50 hidden">
                                @foreach ($otherMenus as $menu)
                                    @php
                                        $nama = strtolower($menu->nama);
                                        $icon = match ($nama) {
                                            'faq' => 'fa-circle-question',
                                            'karier' => 'fa-briefcase',
                                            'kontak' => 'fa-envelope',
                                            default => 'fa-circle',
                                        };
                                        $routeName = match ($nama) {
                                            'faq' => 'faq',
                                            'karier' => 'karier',
                                            'kontak' => 'kontak',
                                            default => 'home',
                                        };
                                        $label = match ($nama) {
                                            'faq' => $menuLabels['faq'] ?? 'FAQ',
                                            'karier' => $menuLabels['career'] ?? 'Karier',
                                            'kontak' => $menuLabels['contact'] ?? 'Kontak',
                                            default => $menu->nama,
                                        };
                                    @endphp
                                    <a href="{{ route($routeName) }}" role="menuitem" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[var(--color-secondary)] transition">
                                        <i class="fas {{ $icon }} w-5 text-center text-gray-400"></i>
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </nav>

                {{-- RIGHT SIDE --}}
                <div class="flex items-center gap-2 md:gap-3">
                    <button onclick="toggleLanguage()" id="langToggle" title="Ganti Bahasa"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium border border-gray-200 hover:border-[var(--color-secondary)] hover:text-[var(--color-secondary)] transition">
                        <i class="fas fa-globe text-xs"></i>
                        <span id="langText">{{ $isEnglish ? 'EN' : 'ID' }}</span>
                    </button>

                    <button id="darkModeToggle" aria-label="Toggle dark mode">
                        <i id="darkModeIconFrontend" class="fas fa-moon text-sm"></i>
                    </button>

                    <button class="hamburger" id="hamburgerBtn" aria-label="Toggle navigation menu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main role="main">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="text-white mt-20" style="background-color: {{ $pengaturan->warna_utama ?? '#0B2A4A' }};" role="contentinfo">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10 border-b border-white/10">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-13 h-12 rounded">
                        <img src="{{ asset('images/Logo-badan-bank-tanah.png') }}" alt="Logo Badan Bank Tanah" class="w-full h-full object-contain">
                    </div>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed">
                    {{ $footer->deskripsi ?? ($isEnglish ? 'Managing state land professionally, transparently, and sustainably for the benefit of the people.' : 'Mengelola tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.') }}
                </p>
            </div>

            <div>
                <h4 class="font-bold text-white mb-4 uppercase text-xs tracking-wider">{{ $menuLabels['quick_links'] }}</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    @foreach ($footer->quick_links ?? [] as $link)
                        <li><a href="{{ $link['url'] ?? '#' }}" class="hover:text-white transition">{{ $link['label'] ?? 'Link' }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white mb-4 uppercase text-xs tracking-wider">{{ $menuLabels['contact_info'] }}</h4>
                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-blue-400 mt-0.5"></i>
                        <span>{{ $footer->alamat ?? 'Jl. H. Juanda No. 15, Jakarta Pusat' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-blue-400"></i>
                        <a href="mailto:{{ $footer->email ?? 'info@bantah.go.id' }}" class="hover:text-white transition">{{ $footer->email ?? 'info@bantah.go.id' }}</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-blue-400"></i>
                        <a href="tel:{{ $footer->telepon ?? '02134567890' }}" class="hover:text-white transition">{{ $footer->telepon ?? '(021) 3456-7890' }}</a>
                    </li>
                </ul>

                @php
                    $socialMedias = \App\Models\SocialMedia::active()->ordered()->get();
                @endphp

                @if ($socialMedias->count() > 0)
                    <div class="flex flex-wrap gap-3 mt-4">
                        @foreach ($socialMedias as $social)
                            <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                                class="w-9 h-9 rounded-full flex items-center justify-center hover:scale-110 transition group"
                                style="background-color: {{ $social->warna ?? '#ffffff' }}; color: white;"
                                title="{{ $social->nama }}">
                                <i class="{{ $social->icon }} text-sm"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($footer->show_newsletter)
                <div>
                    <h4 class="font-bold text-white mb-4 uppercase text-xs tracking-wider">{{ $menuLabels['newsletter'] }}</h4>
                    <p class="text-sm text-gray-300 mb-3">
                        {{ $isEnglish ? 'Get the latest information from the Land Bank Agency.' : 'Dapatkan informasi terbaru dari Badan Bank Tanah.' }}
                    </p>
                    <div class="flex">
                        <input type="email" placeholder="{{ $isEnglish ? 'Your Email' : 'Email Anda' }}"
                            class="flex-1 bg-white/10 text-white px-4 py-3 rounded-l-lg border border-white/20 focus:outline-none focus:border-blue-400 text-sm placeholder-gray-400">
                        <button class="px-4 rounded-r-lg transition hover:opacity-90" style="background-color: {{ $pengaturan->warna_sekunder ?? '#1D4ED8' }};">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto px-4 py-5 flex flex-col md:flex-row justify-between items-center gap-2 text-[10px] md:text-xs text-gray-400">
            <p>{!! str_replace('{year}', date('Y'), $footer->footer_text ?? '&copy; {year} Badan Bank Tanah. Hak Cipta Dilindungi.') !!}</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-white transition">{{ $menuLabels['privacy'] }}</a>
                <a href="#" class="hover:text-white transition">{{ $menuLabels['terms'] }}</a>
                <a href="#" class="hover:text-white transition">{{ $menuLabels['accessibility'] }}</a>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @stack('scripts')

    <script>
        // Mobile nav
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburgerBtn');
            const mobileNav = document.getElementById('mobileNav');
            const overlay = document.getElementById('mobileOverlay');
            const closeBtn = document.getElementById('mobileNavClose');

            function openMobileNav() {
                mobileNav.classList.add('open');
                overlay.classList.add('active');
                hamburger.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            function closeMobileNav() {
                mobileNav.classList.remove('open');
                overlay.classList.remove('active');
                hamburger.classList.remove('active');
                document.body.style.overflow = '';
            }
            function toggleMobileNav() {
                mobileNav.classList.contains('open') ? closeMobileNav() : openMobileNav();
            }
            if (hamburger) hamburger.addEventListener('click', toggleMobileNav);
            if (closeBtn) closeBtn.addEventListener('click', closeMobileNav);
            if (overlay) overlay.addEventListener('click', closeMobileNav);
            if (mobileNav) mobileNav.querySelectorAll('.nav-item').forEach(l => l.addEventListener('click', closeMobileNav));
        });
    </script>

    <script>
        // Dropdown Lainnya
        function toggleDropdownLainnya() {
            const menu = document.getElementById('dropdownLainnyaMenu');
            const btn = document.getElementById('dropdownLainnyaBtn');
            if (!menu) return;
            menu.classList.toggle('hidden');
            if (btn) btn.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');
        }
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('dropdownLainnyaMenu');
            const btn = document.getElementById('dropdownLainnyaBtn');
            if (!menu || !btn) return;
            if (!menu.contains(e.target) && !btn.contains(e.target)) menu.classList.add('hidden');
        });
    </script>

    <script>
        // Dark Mode
        document.addEventListener('DOMContentLoaded', function() {
            const t = document.getElementById('darkModeToggle');
            const i = document.getElementById('darkModeIconFrontend');
            if (!t) return;
            if (localStorage.getItem('frontendDarkMode') === 'true') {
                document.body.classList.add('dark');
                if (i) { i.classList.remove('fa-moon'); i.classList.add('fa-sun'); }
            }
            t.addEventListener('click', function() {
                document.body.classList.toggle('dark');
                const active = document.body.classList.contains('dark');
                localStorage.setItem('frontendDarkMode', active);
                if (i) {
                    i.classList.toggle('fa-moon', !active);
                    i.classList.toggle('fa-sun', active);
                }
            });
        });
    </script>

    <script>
        // Language toggle
        function toggleLanguage() {
            const lang = document.getElementById('langText').textContent.trim();
            const url = new URL(window.location.href);
            url.searchParams.set('lang', lang === 'ID' ? 'en' : 'id');
            window.location.href = url.toString();
        }
    </script>

    @include('components.chatbot')
</body>
</html>
                                </html>
