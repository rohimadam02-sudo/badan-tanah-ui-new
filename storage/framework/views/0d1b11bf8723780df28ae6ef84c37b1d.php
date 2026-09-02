<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    
    <?php
        $metaTitle = $metaTitle ?? 'Badan Bank Tanah - Mengelola Tanah, Memajukan Negeri';
        $metaDescription = $metaDescription ?? 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.';
        $isEnglish = session('locale', 'id') === 'en';
    ?>
    
    <title><?php echo e($metaTitle); ?></title>
    <meta name="description" content="<?php echo e($metaDescription); ?>">
    <meta property="og:title" content="<?php echo e($metaTitle); ?>">
    <meta property="og:description" content="<?php echo e($metaDescription); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    
    
    
    <?php if(isset($pengaturan) && $pengaturan->google_analytics): ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($pengaturan->google_analytics); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo e($pengaturan->google_analytics); ?>');
        </script>
    <?php endif; ?>

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
            --color-primary: <?php echo e($pengaturan->warna_utama ?? '#0B2A4A'); ?>;
            --color-secondary: <?php echo e($pengaturan->warna_sekunder ?? '#1D4ED8'); ?>;
            --color-secondary-hover: <?php echo e($pengaturan->warna_utama ?? '#0B2A4A'); ?>;
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
            box-shadow: -10px 0 40px rgba(0,0,0,0.15);
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
            background: rgba(0,0,0,0.4);
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
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }

        /* =========================================================
           FRONTEND DARK MODE
        ========================================================= */
        body.dark-mode {
            background-color: #111827 !important;
            color: #e5e7eb !important;
        }

        body.dark-mode .bg-white {
            background-color: #1f2937 !important;
            color: #e5e7eb !important;
        }

        body.dark-mode .bg-gray-50 {
            background-color: #111827 !important;
        }

        body.dark-mode .bg-gray-100 {
            background-color: #1f2937 !important;
        }

        body.dark-mode .text-gray-900 {
            color: #f9fafb !important;
        }

        body.dark-mode .text-gray-700 {
            color: #e5e7eb !important;
        }

        body.dark-mode .text-gray-600 {
            color: #d1d5db !important;
        }

        body.dark-mode .text-gray-500 {
            color: #9ca3af !important;
        }

        body.dark-mode .border-gray-200 {
            border-color: #374151 !important;
        }

        body.dark-mode .border-gray-100 {
            border-color: #374151 !important;
        }

        body.dark-mode .shadow-sm,
        body.dark-mode .shadow-md,
        body.dark-mode .shadow-lg {
            box-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
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

        body.dark-mode #darkModeToggle {
            color: #facc15;
        }

        body.dark-mode #darkModeToggle:hover {
            background: #374151;
        }
    </style>
</head>

<body class="bg-white text-gray-800 antialiased">

    <?php
        // Ambil halaman yang aktif dari database
        $activePages = \App\Models\Halaman::where('is_active', true)->get();
        $activePageTitles = $activePages->pluck('judul')->map(function($title) {
            return strtolower($title);
        })->toArray();

        // Filter menu navigasi - hanya tampilkan menu yang terkait dengan halaman aktif
        $mainMenus = $menuNavigasi->filter(function($menu) use ($activePageTitles) {
            if ($menu->status != 'Aktif') return false;

            $menuName = strtolower($menu->nama);

            // Mapping menu ke halaman
            $pageMapping = [
                'tentang' => 'tentang',
                'pemanfaatan & kerjasama' => 'pemanfaatan',
                'publikasi' => 'publikasi',
            ];

            foreach ($pageMapping as $key => $value) {
                if (str_contains($menuName, $key)) {
                    // Cek apakah ada halaman dengan judul yang sesuai dan aktif
                    $exists = \App\Models\Halaman::where('judul', 'like', '%' . $value . '%')
                        ->where('is_active', true)
                        ->exists();
                    return $exists;
                }
            }

            // Menu non-halaman (FAQ, Karier, Kontak) tetap ditampilkan
            return in_array($menuName, ['faq', 'karier', 'kontak', 'beranda', 'aset persediaan tanah']);
        });

        // Menu untuk dropdown "Lainnya"
        $otherMenus = $menuNavigasi->filter(function($menu) {
            return $menu->status == 'Aktif' &&
                   in_array(strtolower($menu->nama), ['faq', 'karier', 'kontak']);
        });

        // Ambil footer settings
        $footer = \App\Models\FooterSetting::getSettings();

        // Menu labels bilingual
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
    ?>

    <!-- ========================================================= -->
    <!-- MOBILE OVERLAY -->
    <!-- ========================================================= -->
    <div class="mobile-overlay" id="mobileOverlay" aria-hidden="true"></div>

    <!-- ========================================================= -->
    <!-- MOBILE NAV -->
    <!-- ========================================================= -->
    <nav class="mobile-nav" id="mobileNav" role="navigation" aria-label="Mobile Navigation">
        <div class="mobile-nav-header">
            <span class="logo-text">Badan <span>Bank Tanah</span></span>
            <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close navigation menu">
                <i class="fas fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="nav-list">
            <div class="nav-section-title"><?php echo e($menuLabels['home']); ?></div>

            <a href="<?php echo e(route('home')); ?>" class="nav-item <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" aria-current="<?php echo e(request()->routeIs('home') ? 'page' : 'false'); ?>">
                <i class="fas fa-house" aria-hidden="true"></i>
                <?php echo e($menuLabels['home']); ?>

            </a>

            <?php
                $menuItems = [
                    ['route' => 'about', 'icon' => 'fa-circle-info', 'label' => $menuLabels['about'], 'check' => 'tentang'],
                    ['route' => 'assets', 'icon' => 'fa-map-pin', 'label' => $menuLabels['assets'], 'check' => 'aset'],
                    ['route' => 'partnership', 'icon' => 'fa-handshake', 'label' => $menuLabels['partnership'], 'check' => 'pemanfaatan'],
                    ['route' => 'halaman.publikasi', 'icon' => 'fa-newspaper', 'label' => $menuLabels['publications'], 'check' => 'publikasi'],
                ];
            ?>

            <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Cek apakah menu ini aktif berdasarkan halaman aktif
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
                ?>
                <?php if($isActive): ?>
                    <a href="<?php echo e(route($item['route'])); ?>" class="nav-item <?php echo e(request()->routeIs($item['route']) ? 'active' : ''); ?>" aria-current="<?php echo e(request()->routeIs($item['route']) ? 'page' : 'false'); ?>">
                        <i class="fas <?php echo e($item['icon']); ?>" aria-hidden="true"></i>
                        <?php echo e($item['label']); ?>

                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="nav-divider"></div>

            <div class="nav-section-title"><?php echo e($menuLabels['others']); ?></div>

            <a href="<?php echo e(route('faq')); ?>" class="nav-item <?php echo e(request()->routeIs('faq') ? 'active' : ''); ?>" aria-current="<?php echo e(request()->routeIs('faq') ? 'page' : 'false'); ?>">
                <i class="fas fa-circle-question" aria-hidden="true"></i>
                <?php echo e($menuLabels['faq']); ?>

                <span class="nav-badge">FAQ</span>
            </a>

            <a href="<?php echo e(route('karier')); ?>" class="nav-item <?php echo e(request()->routeIs('karier') ? 'active' : ''); ?>" aria-current="<?php echo e(request()->routeIs('karier') ? 'page' : 'false'); ?>">
                <i class="fas fa-briefcase" aria-hidden="true"></i>
                <?php echo e($menuLabels['career']); ?>

                <span class="nav-badge"><?php echo e($isEnglish ? 'Career' : 'Karir'); ?></span>
            </a>

            <a href="<?php echo e(route('kontak')); ?>" class="nav-item <?php echo e(request()->routeIs('kontak') ? 'active' : ''); ?>" aria-current="<?php echo e(request()->routeIs('kontak') ? 'page' : 'false'); ?>">
                <i class="fas fa-envelope" aria-hidden="true"></i>
                <?php echo e($menuLabels['contact']); ?>

                <span class="nav-badge"><?php echo e($isEnglish ? 'Contact' : 'Hubungi'); ?></span>
            </a>
        </div>

        <!-- Footer Auth -->
        <div class="mobile-nav-footer">
            <a href="<?php echo e(route('login')); ?>" class="btn-nav btn-nav-login">
                <i class="fas fa-sign-in-alt" aria-hidden="true"></i> <?php echo e($menuLabels['login']); ?>

            </a>
        </div>
    </nav>

    <!-- ========================================================= -->
    <!-- TOP BAR -->
    <!-- ========================================================= -->
    <div class="text-white text-xs hidden sm:block" style="background-color: <?php echo e($pengaturan->warna_utama ?? '#0B2A4A'); ?>;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-2">
            <div class="flex items-center gap-2">
                <i class="fas fa-globe text-blue-300" aria-hidden="true"></i>
                <span class="truncate"><?php echo e($isEnglish ? 'Advancing Productive, Transparent, and Sustainable Land Management' : 'Memajukan Pengelolaan Tanah yang Produktif, Transparan, dan Berkelanjutan'); ?></span>
            </div>
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('kontak')); ?>" class="hover:text-blue-300 transition"><?php echo e($menuLabels['contact']); ?></a>
                <a href="<?php echo e(route('search')); ?>" class="hover:text-blue-300 transition"><?php echo e($menuLabels['search']); ?></a>
                <i class="fas fa-search cursor-pointer hover:text-blue-300 transition" aria-hidden="true"></i>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- NAVBAR UTAMA -->
    <!-- ========================================================= -->
    <header class="bg-white sticky top-0 z-[9999] shadow-sm" role="banner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">

                <!-- ========================================================= -->
                <!-- LOGO -->
                <!-- ========================================================= -->
                <a href="<?php echo e(route('home')); ?>" class="flex items-center flex-shrink-0" aria-label="Badan Bank Tanah - Home">
                    <div class="logo-container">
                        <img src="<?php echo e(asset('images/Logo-badan-bank-tanah.png')); ?>"
                             alt="Logo Badan Bank Tanah"
                             class="w-full h-full object-contain"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%230B2A4A%22/%3E%3Ctext x=%2250%22 y=%2255%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22 font-weight=%22bold%22%3EBT%3C/text%3E%3C/svg%3E'">
                    </div>
                </a>

                <!-- ========================================================= -->
                <!-- DESKTOP NAVIGATION -->
                <!-- ========================================================= -->
                <nav class="hidden lg:flex items-center space-x-8 xl:space-x-10 text-gray-700" aria-label="Main Navigation">

                    <?php
                        $navItems = [
                            ['route' => 'about', 'label' => $menuLabels['about'], 'check' => 'tentang'],
                            ['route' => 'assets', 'label' => $menuLabels['assets'], 'check' => 'aset'],
                            ['route' => 'partnership', 'label' => $menuLabels['partnership'], 'check' => 'pemanfaatan'],
                            ['route' => 'halaman.publikasi', 'label' => $menuLabels['publications'], 'check' => 'publikasi'],
                        ];
                    ?>

                    <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isActive = false;
                            $isRouteActive = request()->routeIs($item['route']);
                            if ($item['check'] == 'tentang') {
                                $isActive = \App\Models\Halaman::where('judul', 'like', '%Tentang%')->where('is_active', true)->exists();
                            } elseif ($item['check'] == 'pemanfaatan') {
                                $isActive = \App\Models\Halaman::where('judul', 'like', '%Pemanfaatan%')->where('is_active', true)->exists();
                            } elseif ($item['check'] == 'publikasi') {
                                $isActive = \App\Models\Halaman::where('judul', 'like', '%Publikasi%')->where('is_active', true)->exists();
                            } else {
                                $isActive = true;
                            }
                        ?>
                        <?php if($isActive): ?>
                            <a href="<?php echo e(route($item['route'])); ?>"
                                class="hover:text-[var(--color-secondary)] transition font-medium <?php echo e($isRouteActive ? 'text-[var(--color-secondary)] font-semibold active-nav' : ''); ?>"
                                aria-current="<?php echo e($isRouteActive ? 'page' : 'false'); ?>">
                                <?php echo e($item['label']); ?>

                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- Dropdown Lainnya (Desktop) -->
                    <?php if($otherMenus->count() > 0): ?>
                    <div class="dropdown-desktop">
                        <button class="flex items-center gap-1 hover:text-[var(--color-secondary)] transition font-medium <?php echo e(request()->routeIs('faq') || request()->routeIs('karier') || request()->routeIs('kontak') ? 'text-[var(--color-secondary)] font-semibold' : ''); ?>"
                                aria-expanded="false">
                            <?php echo e($menuLabels['others']); ?>

                            <i class="fas fa-chevron-down text-[10px]" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <?php $__currentLoopData = $otherMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $icon = match(strtolower($menu->nama)) {
                                        'faq' => 'fa-circle-question',
                                        'karier' => 'fa-briefcase',
                                        'kontak' => 'fa-envelope',
                                        default => 'fa-circle'
                                    };
                                    $routeName = match(strtolower($menu->nama)) {
                                        'faq' => 'faq',
                                        'karier' => 'karier',
                                        'kontak' => 'kontak',
                                        default => ''
                                    };
                                    $label = match(strtolower($menu->nama)) {
                                        'faq' => $menuLabels['faq'],
                                        'karier' => $menuLabels['career'],
                                        'kontak' => $menuLabels['contact'],
                                        default => $menu->nama
                                    };
                                ?>
                                <a href="<?php echo e(route($routeName)); ?>" role="menuitem">
                                    <i class="fas <?php echo e($icon); ?>" aria-hidden="true"></i>
                                    <?php echo e($label); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </nav>

                <!-- ========================================================= -->
                <!-- RIGHT SIDE -->
                <!-- ========================================================= -->
                <div class="flex items-center gap-2 md:gap-3">

                    <!-- Language Toggle -->
                    <button onclick="toggleLanguage()" 
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium border border-gray-200 hover:border-[var(--color-secondary)] hover:text-[var(--color-secondary)] transition"
                            id="langToggle"
                            title="Ganti Bahasa">
                        <i class="fas fa-globe text-xs"></i>
                        <span id="langText"><?php echo e($isEnglish ? 'EN' : 'ID'); ?></span>
                    </button>

                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" aria-label="Toggle dark mode" title="Toggle Dark Mode">
                        <i id="darkModeIconFrontend" class="fas fa-moon text-sm" aria-hidden="true"></i>
                    </button>

                    <!-- Hamburger Menu (Mobile) -->
                    <button class="lg:hidden hamburger" id="hamburgerBtn" aria-label="Toggle navigation menu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                </div>

            </div>
        </div>
    </header>

    <!-- ========================================================= -->
    <!-- MAIN CONTENT -->
    <!-- ========================================================= -->
    <main role="main">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- ========================================================= -->
    <!-- FOOTER -->
    <!-- ========================================================= -->
    <footer class="text-white mt-20" style="background-color: <?php echo e($pengaturan->warna_utama ?? '#0B2A4A'); ?>;" role="contentinfo">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10 border-b border-white/10">

            <!-- Kolom 1: Profil -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-13 h-12 rounded">
                        <img src="<?php echo e(asset('images/Logo-badan-bank-tanah.png')); ?>"
                             alt="Logo Badan Bank Tanah"
                             class="w-full h-full object-contain"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%230B2A4A%22/%3E%3Ctext x=%2250%22 y=%2255%22 text-anchor=%22middle%22 font-size=%2240%22 fill=%22white%22 font-weight=%22bold%22%3EBT%3C/text%3E%3C/svg%3E'">
                    </div>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed">
                    <?php echo e($footer->deskripsi ?? ($isEnglish ? 'Managing state land professionally, transparently, and sustainably for the benefit of the people.' : 'Mengelola tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.')); ?>

                </p>
            </div>

            <!-- Kolom 2: Tautan Cepat -->
            <div>
                <h4 class="font-bold text-white mb-4 uppercase text-xs tracking-wider"><?php echo e($menuLabels['quick_links']); ?></h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <?php $__currentLoopData = $footer->quick_links ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e($link['url'] ?? '#'); ?>" class="hover:text-white transition"><?php echo e($link['label'] ?? 'Link'); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <!-- Kolom 3: Kontak & Sosial Media -->
            <div>
                <h4 class="font-bold text-white mb-4 uppercase text-xs tracking-wider"><?php echo e($menuLabels['contact_info']); ?></h4>
                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-blue-400 mt-0.5" aria-hidden="true"></i>
                        <span><?php echo e($footer->alamat ?? 'Jl. H. Juanda No. 15, Jakarta Pusat'); ?></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-blue-400" aria-hidden="true"></i>
                        <a href="mailto:<?php echo e($footer->email ?? 'info@bantah.go.id'); ?>" class="hover:text-white transition"><?php echo e($footer->email ?? 'info@bantah.go.id'); ?></a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-blue-400" aria-hidden="true"></i>
                        <a href="tel:<?php echo e($footer->telepon ?? '02134567890'); ?>" class="hover:text-white transition"><?php echo e($footer->telepon ?? '(021) 3456-7890'); ?></a>
                    </li>
                </ul>

                <?php
                    $socialMedias = \App\Models\SocialMedia::active()->ordered()->get();
                ?>

                <?php if($socialMedias->count() > 0): ?>
                    <div class="flex flex-wrap gap-3 mt-4">
                        <?php $__currentLoopData = $socialMedias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($social->url); ?>" target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-full flex items-center justify-center hover:scale-110 transition group"
                               style="background-color: <?php echo e($social->warna ?? '#ffffff'); ?>; color: white;"
                               title="<?php echo e($social->nama); ?>" aria-label="<?php echo e($social->nama); ?>">
                                <i class="<?php echo e($social->icon); ?> text-sm group-hover:scale-110 transition" aria-hidden="true"></i>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Kolom 4: Newsletter -->
            <?php if($footer->show_newsletter): ?>
                <div>
                    <h4 class="font-bold text-white mb-4 uppercase text-xs tracking-wider"><?php echo e($menuLabels['newsletter']); ?></h4>
                    <p class="text-sm text-gray-300 mb-3"><?php echo e($isEnglish ? 'Get the latest information from the Land Bank Agency.' : 'Dapatkan informasi terbaru dari Badan Bank Tanah.'); ?></p>
                    <div class="flex">
                        <input type="email" placeholder="<?php echo e($isEnglish ? 'Your Email' : 'Email Anda'); ?>"
                            class="flex-1 bg-white/10 text-white px-4 py-3 rounded-l-lg border border-white/20 focus:outline-none focus:border-blue-400 text-sm placeholder-gray-400"
                            aria-label="Email address for newsletter">
                        <button class="px-4 rounded-r-lg transition hover:opacity-90"
                            style="background-color: <?php echo e($pengaturan->warna_sekunder ?? '#1D4ED8'); ?>;"
                            aria-label="Subscribe to newsletter">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Copyright -->
        <div class="max-w-7xl mx-auto px-4 py-5 flex flex-col md:flex-row justify-between items-center gap-2 text-[10px] md:text-xs text-gray-400">
            <p><?php echo str_replace('{year}', date('Y'), $footer->footer_text ?? '&copy; {year} Badan Bank Tanah. Hak Cipta Dilindungi.'); ?></p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-white transition"><?php echo e($menuLabels['privacy']); ?></a>
                <a href="#" class="hover:text-white transition"><?php echo e($menuLabels['terms']); ?></a>
                <a href="#" class="hover:text-white transition"><?php echo e($menuLabels['accessibility']); ?></a>
            </div>
        </div>
    </footer>

    <!-- ========================================================= -->
    <!-- SCRIPTS -->
    <!-- ========================================================= -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <!-- Mobile Nav Script -->
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
                if (mobileNav.classList.contains('open')) {
                    closeMobileNav();
                } else {
                    openMobileNav();
                }
            }

            if (hamburger) {
                hamburger.addEventListener('click', toggleMobileNav);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeMobileNav);
            }

            if (overlay) {
                overlay.addEventListener('click', closeMobileNav);
            }

            if (mobileNav) {
                mobileNav.querySelectorAll('.nav-item').forEach(link => {
                    link.addEventListener('click', function() {
                        if (mobileNav.classList.contains('open')) {
                            closeMobileNav();
                        }
                    });
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileNav && mobileNav.classList.contains('open')) {
                    closeMobileNav();
                }
            });
        });
    </script>

    <!-- ========================================================= -->
    <!-- SCROLL REVEAL -->
    <!-- ========================================================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            revealElements.forEach(el => {
                revealObserver.observe(el);
            });
        });
    </script>

    <!-- ========================================================= -->
    <!-- FRONTEND DARK MODE -->
    <!-- ========================================================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkToggle = document.getElementById('darkModeToggle');
            const darkIcon = document.getElementById('darkModeIconFrontend');

            if (!darkToggle) return;

            // Cek status dari localStorage
            const savedMode = localStorage.getItem('frontendDarkMode');

            if (savedMode === 'true') {
                document.body.classList.add('dark-mode');
                if (darkIcon) {
                    darkIcon.classList.remove('fa-moon');
                    darkIcon.classList.add('fa-sun');
                }
            }

            darkToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
                const active = document.body.classList.contains('dark-mode');
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

    <!-- ========================================================= -->
    <!-- LANGUAGE TOGGLE -->
    <!-- ========================================================= -->
    <script>
        function toggleLanguage() {
            const langText = document.getElementById('langText');
            const currentLang = langText.textContent.trim();
            const newLang = currentLang === 'ID' ? 'en' : 'id';
            
            const url = new URL(window.location.href);
            url.searchParams.set('lang', newLang);
            window.location.href = url.toString();
        }

        // Update tombol bahasa sesuai session
        document.addEventListener('DOMContentLoaded', function() {
            const langText = document.getElementById('langText');
            if (langText) {
                const currentLang = '<?php echo e(session('locale', 'id')); ?>';
                langText.textContent = currentLang === 'en' ? 'EN' : 'ID';
            }
        });
    </script>

    
    <?php echo $__env->make('components.chatbot', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\Users\Lenovo\badan-tanah-ui-new\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>