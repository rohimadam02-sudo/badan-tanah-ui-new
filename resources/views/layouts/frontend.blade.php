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

    @if (isset($pengaturan) && $pengaturan->google_analytics)
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
            overflow-x: clip;
        }

        @supports not (overflow: clip) {
            body {
                overflow-x: hidden;
            }
        }

        .leaflet-container {
            z-index: 0;
        }

        /* SCROLLBAR */
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
           DINAMIC COLORS
        ========================================================= */
        :root {
            --color-primary: {{ $pengaturan->warna_utama ?? '#0B2A4A' }};
            --color-secondary: {{ $pengaturan->warna_sekunder ?? '#1D4ED8' }};
            --color-secondary-hover: {{ $pengaturan->warna_utama ?? '#0B2A4A' }};
        }

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

        nav a:not(.active-nav):hover {
            color: var(--color-secondary) !important;
        }

        .btn-primary {
            background-color: var(--color-secondary) !important;
            color: white !important;
        }

        .btn-primary:hover {
            background-color: var(--color-secondary-hover) !important;
        }

        .link-secondary {
            color: var(--color-secondary) !important;
        }

        .link-secondary:hover {
            color: var(--color-secondary-hover) !important;
            text-decoration: underline;
        }

        .border-secondary {
            border-color: var(--color-secondary) !important;
        }

        /* =========================================================
           ✅ MEGA MENU — POSITIONING PER MENU
        ========================================================= */
        header[role="banner"] {
            overflow: visible !important;
            z-index: 9999 !important;
        }

        .dropdown-wrapper {
            position: relative;
        }

        .dropdown-wrapper > .dropdown-panel {
            z-index: 99999 !important;
            pointer-events: none;
        }

        .dropdown-wrapper:hover > .dropdown-panel {
            pointer-events: auto;
        }

        /* PANEL DEFAULT (fallback) */
        .dropdown-panel {
            width: 720px;
            max-width: calc(100vw - 40px);
            left: 50%;
            transform: translateX(-50%) translateY(8px);
        }

        .dropdown-wrapper:hover > .dropdown-panel {
            transform: translateX(-50%) translateY(0);
        }

        /* ✅ MENU 1 & 2 (Tentang, Pemanfaatan) — geser ke kanan */
        .dropdown-wrapper:nth-child(1) > .dropdown-panel,
        .dropdown-wrapper:nth-child(2) > .dropdown-panel {
            left: 0;
            right: auto;
            transform: translateX(80px) translateY(8px);
        }

        .dropdown-wrapper:nth-child(1):hover > .dropdown-panel,
        .dropdown-wrapper:nth-child(2):hover > .dropdown-panel {
            transform: translateX(80px) translateY(0);
        }

        /* ✅ MENU 3 & 4 (Aset, Publikasi) — center */
        .dropdown-wrapper:nth-child(3) > .dropdown-panel,
        .dropdown-wrapper:nth-child(4) > .dropdown-panel {
            left: 50%;
            right: auto;
            transform: translateX(-50%) translateY(8px);
        }

        .dropdown-wrapper:nth-child(3):hover > .dropdown-panel,
        .dropdown-wrapper:nth-child(4):hover > .dropdown-panel {
            transform: translateX(-50%) translateY(0);
        }

        /* ✅ MENU 5 (Lainnya) — rata kanan */
        .dropdown-wrapper:last-child > .dropdown-panel {
            left: auto;
            right: 0;
            transform: translateY(8px);
        }

        .dropdown-wrapper:last-child:hover > .dropdown-panel {
            transform: translateY(0);
        }

        /* TABLET / VIEWPORT 1024-1400px */
        @media (min-width: 1024px) and (max-width: 1400px) {

            /* Menu 1 & 2 tetap geser kanan */
            .dropdown-wrapper:nth-child(1) > .dropdown-panel,
            .dropdown-wrapper:nth-child(2) > .dropdown-panel {
                left: 0 !important;
                right: auto !important;
                transform: translateX(60px) translateY(8px) !important;
            }

            .dropdown-wrapper:nth-child(1):hover > .dropdown-panel,
            .dropdown-wrapper:nth-child(2):hover > .dropdown-panel {
                transform: translateX(60px) translateY(0) !important;
            }

            /* Menu 3 & 4 jadi rata kanan */
            .dropdown-wrapper:nth-child(3) > .dropdown-panel,
            .dropdown-wrapper:nth-child(4) > .dropdown-panel {
                left: auto !important;
                right: 0 !important;
                transform: translateY(8px) !important;
            }

            .dropdown-wrapper:nth-child(3):hover > .dropdown-panel,
            .dropdown-wrapper:nth-child(4):hover > .dropdown-panel {
                transform: translateY(0) !important;
            }
        }

        @media (max-width: 1024px) {
            .dropdown-wrapper > .dropdown-panel {
                display: none !important;
            }
        }

        /* Panel content wrapper */
        .mega-panel-inner {
            display: grid;
            grid-template-columns: 240px 1fr;
            min-height: 260px;
        }

        .mega-panel-left {
            background: linear-gradient(160deg, #f8fafc 0%, #eff6ff 100%);
            padding: 24px 22px;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
        }

        .mega-panel-left .mega-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            color: #d97706;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .mega-panel-left .mega-title {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
            margin-bottom: 10px;
        }

        .mega-panel-left .mega-desc {
            font-size: 12px;
            color: #64748b;
            line-height: 1.55;
            flex-grow: 1;
        }

        .mega-panel-left .mega-wave {
            margin-top: 16px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
        }

        .mega-panel-right {
            padding: 16px;
            background: #ffffff;
        }

        .mega-panel-right .submenu-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2px;
        }

        .submenu-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            transition: background 0.15s ease;
            text-decoration: none;
        }

        .submenu-item:hover {
            background: #eff6ff;
        }

        .submenu-item .submenu-icon {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #eff6ff;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: background 0.15s ease;
        }

        .submenu-item:hover .submenu-icon {
            background: #dbeafe;
        }

        .submenu-item .submenu-text {
            min-width: 0;
            padding-top: 2px;
        }

        .submenu-item .submenu-title {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.3;
            margin-bottom: 2px;
            transition: color 0.15s ease;
        }

        .submenu-item:hover .submenu-title {
            color: var(--color-secondary);
        }

        .submenu-item .submenu-desc {
            display: block;
            font-size: 11.5px;
            color: #64748b;
            line-height: 1.45;
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

        /* HAMBURGER */
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
            background: #1f2937;
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

        /* LOGO */
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

        /* SCROLL REVEAL */
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

        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }

        /* DARK MODE */
        body.dark {
            background-color: #111827 !important;
            color: #e5e7eb !important;
        }

        body.dark .bg-white { background-color: #1f2937 !important; color: #e5e7eb !important; }
        body.dark .bg-gray-50 { background-color: #111827 !important; }
        body.dark .bg-gray-100 { background-color: #1f2937 !important; }
        body.dark .text-gray-900 { color: #f9fafb !important; }
        body.dark .text-gray-700 { color: #e5e7eb !important; }
        body.dark .text-gray-600 { color: #d1d5db !important; }
        body.dark .text-gray-500 { color: #9ca3af !important; }
        body.dark .border-gray-200 { border-color: #374151 !important; }
        body.dark .border-gray-100 { border-color: #374151 !important; }
        body.dark .shadow-sm, body.dark .shadow-md, body.dark .shadow-lg {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3) !important;
        }

        body.dark .mega-panel-left {
            background: linear-gradient(160deg, #1f2937 0%, #111827 100%) !important;
            border-color: #374151 !important;
        }
        body.dark .mega-panel-left .mega-title { color: #f9fafb !important; }
        body.dark .mega-panel-left .mega-desc { color: #9ca3af !important; }
        body.dark .mega-panel-right { background: #1f2937 !important; }
        body.dark .submenu-item:hover { background: #374151 !important; }
        body.dark .submenu-item .submenu-title { color: #f9fafb !important; }
        body.dark .submenu-item .submenu-desc { color: #9ca3af !important; }
        body.dark .submenu-item .submenu-icon { background: #374151 !important; color: #93c5fd !important; }

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

        #darkModeToggle:hover { background: #f3f4f6; }
        body.dark #darkModeToggle { color: #facc15; }
        body.dark #darkModeToggle:hover { background: #374151; }
    </style>

    @stack('styles')

</head>

<body class="bg-white text-gray-800 antialiased">

    @php
        $activePages = \App\Models\Halaman::where('is_active', true)->get();
        $activePageTitles = $activePages
            ->pluck('judul')
            ->map(function ($title) {
                return strtolower($title);
            })
            ->toArray();

        $mainMenus = $menuNavigasi->filter(function ($menu) use ($activePageTitles) {
            if ($menu->status != 'Aktif') {
                return false;
            }
            $menuName = strtolower($menu->nama);
            $pageMapping = [
                'tentang' => 'tentang',
                'pemanfaatan & kerjasama' => 'pemanfaatan',
                'publikasi' => 'publikasi',
            ];
            foreach ($pageMapping as $key => $value) {
                if (str_contains($menuName, $key)) {
                    $exists = \App\Models\Halaman::where('judul', 'like', '%' . $value . '%')
                        ->where('is_active', true)
                        ->exists();
                    return $exists;
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

        $megaMenus = [
            'tentang' => [
                'label' => $isEnglish ? 'ABOUT US' : 'TENTANG KAMI',
                'title' => $isEnglish ? 'Get to Know Badan Bank Tanah' : 'Mengenal Badan Bank Tanah',
                'description' => $isEnglish
                    ? 'Badan Bank Tanah is present as a strategic instrument of the state in managing land for broader and sustainable interests.'
                    : 'Badan Bank Tanah hadir sebagai instrumen strategis negara dalam menata dan mengelola tanah untuk kepentingan yang lebih luas dan berkelanjutan.',
                'submenus' => [
                    ['icon' => 'fa-building-columns', 'title' => $isEnglish ? 'Profile' : 'Profil', 'description' => $isEnglish ? 'General information about Badan Bank Tanah' : 'Informasi umum tentang Badan Bank Tanah', 'route' => 'about'],
                    ['icon' => 'fa-bullseye', 'title' => $isEnglish ? 'Vision & Mission' : 'Visi & Misi', 'description' => $isEnglish ? 'Vision, mission, and values that guide us' : 'Visi, misi dan nilai-nilai yang menjadi landasan kami.', 'route' => 'about.visi-misi'],
                    ['icon' => 'fa-sitemap', 'title' => $isEnglish ? 'Organizational Structure' : 'Struktur Organisasi', 'description' => $isEnglish ? 'Organizational structure and role distribution' : 'Struktur organisasi dan pembagian peran di lingkungan Badan Bank Tanah.', 'route' => 'about.struktur'],
                    ['icon' => 'fa-list-check', 'title' => $isEnglish ? 'Functions & Duties' : 'Fungsi & Tugas', 'description' => $isEnglish ? 'Duties and functions in carrying out the mandate' : 'Tugas dan fungsi dalam pelaksanaan mandat dan pengelolaan tanah.', 'route' => 'about.fungsi'],
                    ['icon' => 'fa-users', 'title' => $isEnglish ? 'Leadership Profile' : 'Profil Pimpinan', 'description' => $isEnglish ? 'Leadership and management information' : 'Informasi pimpinan dan jajaran manajemen Badan Bank Tanah.', 'route' => 'about.pimpinan'],
                ],
            ],
            'pemanfaatan' => [
                'label' => $isEnglish ? 'UTILIZATION & PARTNERSHIP' : 'PEMANFAATAN & KERJA SAMA',
                'title' => $isEnglish ? 'Towards Collaboration and Sustainability' : 'Menuju Kolaborasi dan Keberlanjutan',
                'description' => $isEnglish
                    ? 'Land utilization is carried out through utilization cooperation with other parties; Badan Bank Tanah still considers the principles of benefit and priority.'
                    : 'Pemanfaatan tanah dilakukan melalui kerja sama pemanfaatan dengan pihak lain, dalam melaksanakan pemanfaatan tanah, Bank Tanah tetap memperhatikan asas kemanfaatan dan asas prioritas.',
                'submenus' => [
                    ['icon' => 'fa-briefcase', 'title' => $isEnglish ? 'Portfolio' : 'Portofolio', 'description' => $isEnglish ? 'Utilization and distribution of land already partnered' : 'Pemanfaatan dan pendistribusian tanah yang sudah dikerjasamakan oleh Badan Bank Tanah dengan mitra', 'route' => 'partnership'],
                    ['icon' => 'fa-file-signature', 'title' => $isEnglish ? 'Land Rights' : 'Hak Atas Tanah', 'description' => $isEnglish ? 'Badan Bank Tanah as the holder of Management Rights' : 'Badan Bank Tanah sebagai pemegang Hak Pengelolaan dalam hal kerja sama pemanfaatan dapat memberikan Hak Atas Tanah', 'route' => 'partnership'],
                    ['icon' => 'fa-diagram-project', 'title' => $isEnglish ? 'Utilization Scheme' : 'Skema Pemanfaatan', 'description' => $isEnglish ? 'Considering the principles of benefit and priority' : 'dalam melaksanakan pemanfaatan tanah, Bank Tanah tetap memperhatikan asas kemanfaatan dan asas prioritas', 'route' => 'partnership'],
                ],
            ],
            'aset' => [
                'label' => $isEnglish ? 'LAND ASSET INVENTORY' : 'ASET PERSEDIAAN TANAH',
                'title' => $isEnglish ? 'Managing Land for Sustainable Growth' : 'Mengelola Tanah Untuk Pertumbuhan Berkelanjutan',
                'description' => $isEnglish
                    ? 'The purpose of Badan Bank Tanah is to support agrarian reform, ensure land availability for public interest, and encourage economic equity and national development.'
                    : 'Tujuan Badan Bank Tanah adalah mendukung reforma agraria, menjamin ketersediaan tanah untuk kepentingan umum, serta mendorong pemerataan ekonomi dan pembangunan nasional.',
                'submenus' => [
                    ['icon' => 'fa-layer-group', 'title' => $isEnglish ? 'Land Inventory' : 'Aset Persediaan', 'description' => $isEnglish ? 'Utilization and distribution of land already partnered' : 'Pemanfaatan dan pendistribusian tanah yang sudah dikerjasamakan oleh Badan Bank Tanah dengan mitra', 'route' => 'assets'],
                    ['icon' => 'fa-book', 'title' => $isEnglish ? 'Booklet' : 'Booklet', 'description' => $isEnglish ? 'Badan Bank Tanah as the holder of Management Rights' : 'Badan Bank Tanah sebagai pemegang Hak Pengelolaan dalam hal kerja sama pemanfaatan dapat memberikan Hak Atas Tanah', 'route' => 'assets'],
                ],
            ],
            'publikasi' => [
                'label' => $isEnglish ? 'PUBLICATION' : 'PUBLIKASI',
                'title' => $isEnglish ? 'Open Information for Transparency and Accountability' : 'Informasi Terbuka Untuk Transparansi dan Akuntabilitas',
                'description' => $isEnglish
                    ? 'Find various official information and publications of Badan Bank Tanah as our commitment to transparency and public information disclosure.'
                    : 'Temukan berbagai informasi dan publikasi resmi Badan Bank Tanah sebagai komitmen kami terhadap transparansi dan keterbukaan informasi publik.',
                'submenus' => [
                    ['icon' => 'fa-images', 'title' => $isEnglish ? 'Gallery' : 'Galeri', 'description' => $isEnglish ? 'Utilization and distribution of land already partnered' : 'Pemanfaatan dan pendistribusian tanah yang sudah dikerjasamakan oleh Badan Bank Tanah dengan mitra', 'route' => 'halaman.publikasi'],
                    ['icon' => 'fa-newspaper', 'title' => $isEnglish ? 'Press Release' : 'Siaran Pers', 'description' => $isEnglish ? 'Badan Bank Tanah as the holder of Management Rights' : 'Badan Bank Tanah sebagai pemegang Hak Pengelolaan dalam hal kerja sama pemanfaatan dapat memberikan Hak Atas Tanah', 'route' => 'halaman.publikasi'],
                    ['icon' => 'fa-file-lines', 'title' => $isEnglish ? 'Latest Articles' : 'Artikel Terkini', 'description' => $isEnglish ? 'Badan Bank Tanah as the holder of Management Rights' : 'Badan Bank Tanah sebagai pemegang Hak Pengelolaan dalam hal kerja sama pemanfaatan dapat memberikan Hak Atas Tanah', 'route' => 'halaman.publikasi'],
                ],
            ],
            'lainnya' => [
                'label' => $isEnglish ? 'OTHERS' : 'LAINNYA',
                'title' => $isEnglish ? 'Other Information from Badan Bank Tanah' : 'Informasi Lainnya Dari Badan Bank Tanah',
                'description' => $isEnglish
                    ? 'Find various other information ranging from job vacancies, procurement, official announcements, frequently asked questions, and how to contact us.'
                    : 'Temukan berbagai informasi lainnya mulai dari informasi lowongan pekerjaan, pengadaan, pengumuman resmi, pertanyaan yang sering ditanyakan, dan cara menghubungi kami.',
                'submenus' => [
                    ['icon' => 'fa-briefcase', 'title' => $isEnglish ? 'Career' : 'Karir', 'description' => $isEnglish ? 'Utilization and distribution of land already partnered' : 'Pemanfaatan dan pendistribusian tanah yang sudah dikerjasamakan oleh Badan Bank Tanah dengan mitra', 'route' => 'karier'],
                    ['icon' => 'fa-bullhorn', 'title' => $isEnglish ? 'Announcement' : 'Pengumuman', 'description' => $isEnglish ? 'Badan Bank Tanah as the holder of Management Rights' : 'Badan Bank Tanah sebagai pemegang Hak Pengelolaan dalam hal kerja sama pemanfaatan dapat memberikan Hak Atas Tanah', 'route' => 'kontak'],
                    ['icon' => 'fa-circle-question', 'title' => 'FAQ', 'description' => $isEnglish ? 'Badan Bank Tanah as the holder of Management Rights' : 'Badan Bank Tanah sebagai pemegang Hak Pengelolaan dalam hal kerja sama pemanfaatan dapat memberikan Hak Atas Tanah', 'route' => 'faq'],
                    ['icon' => 'fa-cart-shopping', 'title' => $isEnglish ? 'Procurement' : 'Pengadaan', 'description' => $isEnglish ? 'Badan Bank Tanah as the holder of Management Rights' : 'Badan Bank Tanah sebagai pemegang Hak Pengelolaan dalam hal kerja sama pemanfaatan dapat memberikan Hak Atas Tanah', 'route' => 'kontak'],
                    ['icon' => 'fa-shield-halved', 'title' => $isEnglish ? 'Corporate Governance' : 'Tata Kelola Perusahaan', 'description' => $isEnglish ? 'Badan Bank Tanah as the holder of Management Rights' : 'Badan Bank Tanah sebagai pemegang Hak Pengelolaan dalam hal kerja sama pemanfaatan dapat memberikan Hak Atas Tanah', 'route' => 'kontak'],
                ],
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
                    ['route' => 'about', 'icon' => 'fa-circle-info', 'label' => $menuLabels['about']],
                    ['route' => 'assets', 'icon' => 'fa-map-pin', 'label' => $menuLabels['assets']],
                    ['route' => 'partnership', 'icon' => 'fa-handshake', 'label' => $menuLabels['partnership']],
                    ['route' => 'halaman.publikasi', 'icon' => 'fa-newspaper', 'label' => $menuLabels['publications']],
                ];
            @endphp

            @foreach ($menuItems as $item)
                <a href="{{ route($item['route']) }}"
                    class="nav-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    <i class="fas {{ $item['icon'] }}" aria-hidden="true"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="nav-divider"></div>

            <div class="nav-section-title">{{ $menuLabels['others'] }}</div>

            <a href="{{ route('faq') }}" class="nav-item {{ request()->routeIs('faq') ? 'active' : '' }}">
                <i class="fas fa-circle-question" aria-hidden="true"></i>
                {{ $menuLabels['faq'] }}
                <span class="nav-badge">FAQ</span>
            </a>

            <a href="{{ route('karier') }}" class="nav-item {{ request()->routeIs('karier') ? 'active' : '' }}">
                <i class="fas fa-briefcase" aria-hidden="true"></i>
                {{ $menuLabels['career'] }}
                <span class="nav-badge">{{ $isEnglish ? 'Career' : 'Karir' }}</span>
            </a>

            <a href="{{ route('kontak') }}" class="nav-item {{ request()->routeIs('kontak') ? 'active' : '' }}">
                <i class="fas fa-envelope" aria-hidden="true"></i>
                {{ $menuLabels['contact'] }}
                <span class="nav-badge">{{ $isEnglish ? 'Contact' : 'Hubungi' }}</span>
            </a>
        </div>
    </nav>

    <!-- TOP BAR -->
    <div class="text-white text-xs hidden sm:block"
        style="background-color: {{ $pengaturan->warna_utama ?? '#0B2A4A' }};">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-2">
            <div class="flex items-center gap-2">
                <i class="fas fa-globe text-blue-300" aria-hidden="true"></i>
                <span class="truncate">{{ $isEnglish ? 'Advancing Productive, Transparent, and Sustainable Land Management' : 'Memajukan Pengelolaan Tanah yang Produktif, Transparan, dan Berkelanjutan' }}</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('kontak') }}" class="hover:text-blue-300 transition">{{ $menuLabels['contact'] }}</a>
                <a href="{{ route('search') }}" class="hover:text-blue-300 transition">{{ $menuLabels['search'] }}</a>
                <i class="fas fa-search cursor-pointer hover:text-blue-300 transition" aria-hidden="true"></i>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header class="bg-white sticky top-0 z-[9999] shadow-sm" role="banner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">

                <!-- LOGO -->
                <a href="{{ route('home') }}" class="flex items-center flex-shrink-0" aria-label="Badan Bank Tanah - Home">
                    <div class="logo-container">
                        <img src="{{ asset('images/Logo-badan-bank-tanah.png') }}" alt="Logo Badan Bank Tanah"
                            class="w-full h-full object-contain"
                            onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%230B2A4A%22/%3E%3Ctext x=%2250%22 y=%2255%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22 font-weight=%22bold%22%3EBT%3C/text%3E%3C/svg%3E'">
                    </div>
                </a>

                <!-- DESKTOP NAVIGATION -->
                <nav class="hidden lg:flex items-center gap-6 xl:gap-10 text-gray-700" aria-label="Main Navigation">

                    @php
                        $navItems = [
                            ['key' => 'tentang', 'route' => 'about', 'label' => $menuLabels['about']],
                            ['key' => 'pemanfaatan', 'route' => 'partnership', 'label' => $menuLabels['partnership']],
                            ['key' => 'aset', 'route' => 'assets', 'label' => $menuLabels['assets']],
                            ['key' => 'publikasi', 'route' => 'halaman.publikasi', 'label' => $menuLabels['publications']],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        @php
                            $mega = $megaMenus[$item['key']];
                            $isActive = request()->routeIs($item['route']);
                        @endphp

                        <div class="relative group dropdown-wrapper">
                            <a href="{{ route($item['route']) }}"
                                class="hover:text-[var(--color-secondary)] transition font-medium flex items-center gap-1.5 py-2
                                {{ $isActive ? 'text-[var(--color-secondary)] font-semibold active-nav' : '' }}">
                                {{ $item['label'] }}
                                <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 group-hover:rotate-180"></i>
                            </a>

                            {{-- PANEL MEGA MENU --}}
                            <div class="dropdown-panel absolute top-full pt-3 opacity-0 invisible
                                group-hover:opacity-100 group-hover:visible
                                transition-all duration-300 ease-out">
                                <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                                    <div class="mega-panel-inner">
                                        <div class="mega-panel-left">
                                            <div class="mega-label">{{ $mega['label'] }}</div>
                                            <div class="mega-title">{{ $mega['title'] }}</div>
                                            <div class="mega-desc">{{ $mega['description'] }}</div>
                                            <div class="mega-wave">
                                                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200"></div>
                                                <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 400 100" preserveAspectRatio="none">
                                                    <path d="M0,60 C80,90 160,30 240,55 C320,80 380,40 400,50 L400,100 L0,100 Z" fill="#93c5fd" opacity="0.55" />
                                                    <path d="M0,75 C100,95 180,55 260,72 C330,88 380,65 400,72 L400,100 L0,100 Z" fill="#3b82f6" opacity="0.45" />
                                                    <path d="M0,88 C90,100 200,78 300,88 C360,94 390,86 400,88 L400,100 L0,100 Z" fill="#1d4ed8" opacity="0.35" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="mega-panel-right">
                                            <div class="submenu-grid">
                                                @foreach ($mega['submenus'] as $sub)
                                                    <a href="{{ route($sub['route']) }}" class="submenu-item">
                                                        <span class="submenu-icon">
                                                            <i class="fas {{ $sub['icon'] }}"></i>
                                                        </span>
                                                        <span class="submenu-text">
                                                            <span class="submenu-title">{{ $sub['title'] }}</span>
                                                            <span class="submenu-desc">{{ $sub['description'] }}</span>
                                                        </span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Dropdown Lainnya --}}
                    <div class="relative group dropdown-wrapper">
                        <a href="#"
                            class="hover:text-[var(--color-secondary)] transition font-medium flex items-center gap-1.5 py-2
                            {{ request()->routeIs('faq') || request()->routeIs('karier') || request()->routeIs('kontak') ? 'text-[var(--color-secondary)] font-semibold active-nav' : '' }}">
                            {{ $menuLabels['others'] ?? 'Lainnya' }}
                            <i class="fas fa-chevron-down text-[10px] transition-transform duration-200 group-hover:rotate-180"></i>
                        </a>

                        @php $mega = $megaMenus['lainnya']; @endphp
                        <div class="dropdown-panel absolute top-full pt-3 opacity-0 invisible
                            group-hover:opacity-100 group-hover:visible
                            transition-all duration-300 ease-out">
                            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                                <div class="mega-panel-inner">
                                    <div class="mega-panel-left">
                                        <div class="mega-label">{{ $mega['label'] }}</div>
                                        <div class="mega-title">{{ $mega['title'] }}</div>
                                        <div class="mega-desc">{{ $mega['description'] }}</div>
                                        <div class="mega-wave">
                                            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200"></div>
                                            <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 400 100" preserveAspectRatio="none">
                                                <path d="M0,60 C80,90 160,30 240,55 C320,80 380,40 400,50 L400,100 L0,100 Z" fill="#93c5fd" opacity="0.55" />
                                                <path d="M0,75 C100,95 180,55 260,72 C330,88 380,65 400,72 L400,100 L0,100 Z" fill="#3b82f6" opacity="0.45" />
                                                <path d="M0,88 C90,100 200,78 300,88 C360,94 390,86 400,88 L400,100 L0,100 Z" fill="#1d4ed8" opacity="0.35" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="mega-panel-right">
                                        <div class="submenu-grid">
                                            @foreach ($mega['submenus'] as $sub)
                                                <a href="{{ route($sub['route']) }}" class="submenu-item">
                                                    <span class="submenu-icon">
                                                        <i class="fas {{ $sub['icon'] }}"></i>
                                                    </span>
                                                    <span class="submenu-text">
                                                        <span class="submenu-title">{{ $sub['title'] }}</span>
                                                        <span class="submenu-desc">{{ $sub['description'] }}</span>
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- RIGHT SIDE -->
                <div class="flex items-center gap-2 md:gap-3">
                    <button onclick="toggleLanguage()"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium border border-gray-200 hover:border-[var(--color-secondary)] hover:text-[var(--color-secondary)] transition"
                        id="langToggle" title="Ganti Bahasa">
                        <i class="fas fa-globe text-xs"></i>
                        <span id="langText">{{ $isEnglish ? 'EN' : 'ID' }}</span>
                    </button>

                    <button id="darkModeToggle" aria-label="Toggle dark mode" title="Toggle Dark Mode">
                        <i id="darkModeIconFrontend" class="fas fa-moon text-sm" aria-hidden="true"></i>
                    </button>

                    <button class="lg:hidden hamburger" id="hamburgerBtn" aria-label="Toggle navigation menu" aria-expanded="false">
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
                        <img src="{{ asset('images/Logo-badan-bank-tanah.png') }}" alt="Logo Badan Bank Tanah"
                            class="w-full h-full object-contain"
                            onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%230B2A4A%22/%3E%3Ctext x=%2250%22 y=%2255%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22 font-weight=%22bold%22%3EBT%3C/text%3E%3C/svg%3E'">
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
                        <i class="fas fa-map-marker-alt text-blue-400 mt-0.5" aria-hidden="true"></i>
                        <span>{{ $footer->alamat ?? 'Jl. H. Juanda No. 15, Jakarta Pusat' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-blue-400" aria-hidden="true"></i>
                        <a href="mailto:{{ $footer->email ?? 'info@bantah.go.id' }}" class="hover:text-white transition">{{ $footer->email ?? 'info@bantah.go.id' }}</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-blue-400" aria-hidden="true"></i>
                        <a href="tel:{{ $footer->telepon ?? '02134567890' }}" class="hover:text-white transition">{{ $footer->telepon ?? '(021) 3456-7890' }}</a>
                    </li>
                </ul>

                @php $socialMedias = \App\Models\SocialMedia::active()->ordered()->get(); @endphp

                @if ($socialMedias->count() > 0)
                    <div class="flex flex-wrap gap-3 mt-4">
                        @foreach ($socialMedias as $social)
                            <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                                class="w-9 h-9 rounded-full flex items-center justify-center hover:scale-110 transition group"
                                style="background-color: {{ $social->warna ?? '#ffffff' }}; color: white;"
                                title="{{ $social->nama }}" aria-label="{{ $social->nama }}">
                                <i class="{{ $social->icon }} text-sm group-hover:scale-110 transition" aria-hidden="true"></i>
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
                            class="flex-1 bg-white/10 text-white px-4 py-3 rounded-l-lg border border-white/20 focus:outline-none focus:border-blue-400 text-sm placeholder-gray-400"
                            aria-label="Email address for newsletter">
                        <button class="px-4 rounded-r-lg transition hover:opacity-90"
                            style="background-color: {{ $pengaturan->warna_sekunder ?? '#1D4ED8' }};"
                            aria-label="Subscribe to newsletter">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
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

    <!-- SCRIPTS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburgerBtn');
            const mobileNav = document.getElementById('mobileNav');
            const overlay = document.getElementById('mobileOverlay');
            const closeBtn = document.getElementById('mobileNavClose');
            const body = document.body;

            function openMobileNav() {
                mobileNav.classList.add('open');
                overlay.classList.add('active');
                hamburger.classList.add('active');
                hamburger.setAttribute('aria-expanded', 'true');
                body.style.overflow = 'hidden';
            }

            function closeMobileNav() {
                mobileNav.classList.remove('open');
                overlay.classList.remove('active');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
                body.style.overflow = '';
            }

            function toggleMobileNav() {
                if (mobileNav.classList.contains('open')) closeMobileNav();
                else openMobileNav();
            }

            if (hamburger) hamburger.addEventListener('click', toggleMobileNav);
            if (closeBtn) closeBtn.addEventListener('click', closeMobileNav);
            if (overlay) overlay.addEventListener('click', closeMobileNav);

            if (mobileNav) {
                mobileNav.querySelectorAll('.nav-item').forEach(link => {
                    link.addEventListener('click', function() {
                        if (mobileNav.classList.contains('open')) closeMobileNav();
                    });
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileNav && mobileNav.classList.contains('open')) closeMobileNav();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('active');
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            revealElements.forEach(el => revealObserver.observe(el));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkToggle = document.getElementById('darkModeToggle');
            const darkIcon = document.getElementById('darkModeIconFrontend');
            if (!darkToggle) return;

            const savedMode = localStorage.getItem('frontendDarkMode');
            if (savedMode === 'true') {
                document.body.classList.add('dark');
                if (darkIcon) {
                    darkIcon.classList.remove('fa-moon');
                    darkIcon.classList.add('fa-sun');
                }
            }

            darkToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark');
                const active = document.body.classList.contains('dark');
                localStorage.setItem('frontendDarkMode', active);
                if (darkIcon) {
                    if (active) {
                        darkIcon.classList.remove('fa-moon');
                        darkIcon.classList.add('fa-sun');
                    } else {
                        darkIcon.classList.remove('fa-sun');
                        darkIcon.classList.add('fa-moon');
                    }
                }
            });
        });
    </script>

    <script>
        function toggleLanguage() {
            const langText = document.getElementById('langText');
            const currentLang = langText.textContent.trim();
            const newLang = currentLang === 'ID' ? 'en' : 'id';
            const url = new URL(window.location.href);
            url.searchParams.set('lang', newLang);
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const langText = document.getElementById('langText');
            if (langText) {
                const currentLang = '{{ session('locale', 'id') }}';
                langText.textContent = currentLang === 'en' ? 'EN' : 'ID';
            }
        });
    </script>

    @include('components.chatbot')

</body>

</html>