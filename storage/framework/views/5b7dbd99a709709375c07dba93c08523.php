<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'CMS Admin Panel - Badan Bank Tanah'); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/css/admin-dark-mode.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

        /* =========================================================
           SIDEBAR SCROLL
        ========================================================= */
        .sidebar-scroll {
            max-height: calc(100vh - 170px);
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        .sidebar-scroll::-webkit-scrollbar {
            width: 3px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* =========================================================
           ADMIN RESPONSIVE
        ========================================================= */
        @media (max-width: 1023px) {
            .sidebar-desktop {
                position: fixed !important;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 99999 !important;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                width: 280px !important;
                box-shadow: 4px 0 30px rgba(0,0,0,0.15);
            }
            .sidebar-desktop.open {
                transform: translateX(0);
            }
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.4);
                z-index: 99998;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }
            .sidebar-overlay.active {
                opacity: 1;
                pointer-events: all;
            }
            .main-content {
                width: 100% !important;
            }
            .admin-header .header-search {
                display: none !important;
            }
        }

        @media (min-width: 1024px) {
            .sidebar-mobile-toggle {
                display: none !important;
            }
            .sidebar-overlay {
                display: none !important;
            }
        }

        @media (max-width: 640px) {
            .admin-header {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            .admin-header .header-title {
                font-size: 0.8rem !important;
            }
            .admin-header .header-actions {
                gap: 0.5rem !important;
            }
            .admin-header .header-actions button {
                width: 2rem !important;
                height: 2rem !important;
                font-size: 0.8rem !important;
            }
            .admin-content {
                padding: 1rem !important;
            }
            .admin-content .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        /* =========================================================
           SIDEBAR TRANSITION
        ========================================================= */
        .sidebar-transition {
            transition: all 0.2s ease-in-out;
        }
        .menu-active {
            background-color: #006400;
            color: white;
        }
        .menu-active:hover {
            background-color: #005500;
            color: white;
        }
        .sub-menu-active {
            background-color: #f0fdf4;
            color: #006400;
            font-weight: 600;
        }

        /* =========================================================
           NOTIFICATION BADGE PULSE
        ========================================================= */
        @keyframes notification-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }
        .notification-pulse {
            animation: notification-pulse 2s ease-in-out infinite;
        }

        /* =========================================================
           TOAST ANIMATION
        ========================================================= */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.3s ease forwards;
        }

        /* =========================================================
           TOOLTIP SIDEBAR
        ========================================================= */
        .tooltip-container {
            position: relative;
            display: inline-flex;
            align-items: center;
            width: 100%;
        }

        .tooltip-container .tooltip-text {
            visibility: hidden;
            opacity: 0;
            width: auto;
            background: #1f2937;
            color: #fff;
            text-align: center;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            position: absolute;
            z-index: 99999;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%) translateY(5px);
            transition: all 0.25s ease;
            white-space: nowrap;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .tooltip-container .tooltip-text::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: #1f2937;
        }

        .tooltip-container:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .tooltip-container .tooltip-text-left {
            left: 120%;
            transform: translateY(-50%) translateX(0);
            bottom: auto;
            top: 50%;
        }

        .tooltip-container .tooltip-text-left::after {
            top: 50%;
            left: -10px;
            transform: translateY(-50%);
            border-top-color: transparent;
            border-right-color: #1f2937;
            border-left: none;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800 transition-colors duration-300">

    <?php
        $user = auth()->user();
        $role = $user->role;
        $roleLabel = [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'editor' => 'Editor',
            'publisher' => 'Publisher',
        ][$role] ?? ucfirst($role);
    ?>

    <!-- ========================================================= -->
    <!-- LOADING STATE -->
    <!-- ========================================================= -->
    <div id="adminLoading" class="fixed inset-0 bg-white/60 backdrop-blur-sm z-[99999] flex items-center justify-center hidden">
        <div class="text-center">
            <div class="w-12 h-12 border-4 border-[#006400] border-t-transparent rounded-full animate-spin mx-auto"></div>
            <p class="text-sm text-gray-500 mt-3">Memuat data...</p>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- SIDEBAR OVERLAY (Mobile) -->
    <!-- ========================================================= -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()" aria-hidden="true"></div>

    <!-- ========================================================= -->
    <!-- SIDEBAR -->
    <!-- ========================================================= -->
    <aside class="sidebar-desktop w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col sidebar-transition" id="adminSidebar" aria-label="Admin Sidebar Navigation">
        <!-- Logo -->
        <div class="p-4 sm:p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-14 h-14 flex-shrink-0">
                    <img src="<?php echo e(asset('images/Logo-badan-bank-tanah.png')); ?>" alt="Badan Bank Tanah Logo" class="w-12 h-12 object-contain">
                </div>
                <div class="leading-tight min-w-0">
                    <h1 class="font-bold text-sm text-gray-900 truncate">Badan Bank Tanah</h1>
                    <p class="text-[10px] text-gray-500 truncate">Indonesia Land Bank Authority</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">CMS Admin Panel</p>
                <p class="text-[9px] text-gray-400 mt-0.5">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-500 mr-1"></span>
                    <?php echo e($roleLabel); ?>

                </p>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <nav class="flex-1 p-3 space-y-0.5 sidebar-scroll" aria-label="Main Navigation">

            <!-- ============================================= -->
            <!-- DASHBOARD (Semua Role) -->
            <!-- ============================================= -->
            <div class="tooltip-container">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition w-full
                    <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                    <i class="fas fa-home w-5 text-center <?php echo e(request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Dashboard</span>
                </a>
                <span class="tooltip-text">Dashboard</span>
            </div>

            <!-- ============================================= -->
            <!-- WEBSITE (Hanya Super Admin & Admin) -->
            <!-- ============================================= -->
            <?php if(in_array($role, ['super_admin', 'admin'])): ?>
            <div class="pt-3 pb-1.5">
                <p class="px-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Website</p>
            </div>

            <?php
                $websiteOpen = request()->routeIs('admin.website') ||
                              request()->routeIs('admin.halaman.*') ||
                              request()->routeIs('admin.menu_navigasi') ||
                              request()->routeIs('admin.footer.*') ||
                              request()->routeIs('admin.faq.*') ||
                              request()->routeIs('admin.karier.*') ||
                              request()->routeIs('admin.kontak.*') ||
                              request()->routeIs('admin.halaman.edit.partnership') ||
                              request()->routeIs('admin.social-media.*') ||
                              request()->routeIs('admin.lokasi-kantor.*');
            ?>

            <div x-data="{ open: <?php echo e($websiteOpen ? 'true' : 'false'); ?> }" class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition
                    <?php echo e($websiteOpen ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>"
                    aria-expanded="<?php echo e($websiteOpen ? 'true' : 'false'); ?>">
                    <i class="fas fa-globe w-5 text-center <?php echo e($websiteOpen ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Website</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-transition:enter.duration.200ms x-transition:leave.duration.150ms
                    class="mt-0.5 pl-7 space-y-0.5 overflow-hidden" role="menu">

                    <!-- Homepage -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.website')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.website') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-house-chimney w-4 text-center text-[10px]"></i>
                            <span>Homepage</span>
                        </a>
                        <span class="tooltip-text">Homepage</span>
                    </div>

                    <!-- Tentang -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.halaman.edit.tentang')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.halaman.edit.tentang') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-circle-info w-4 text-center text-[10px]"></i>
                            <span>Tentang</span>
                        </a>
                        <span class="tooltip-text">Tentang</span>
                    </div>

                    <!-- Halaman -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.halaman.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.halaman.index') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-file-lines w-4 text-center text-[10px]"></i>
                            <span>Halaman</span>
                        </a>
                        <span class="tooltip-text">Halaman</span>
                    </div>

                    <!-- Menu Navigasi -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.menu_navigasi')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.menu_navigasi') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-bars w-4 text-center text-[10px]"></i>
                            <span>Menu Navigasi</span>
                        </a>
                        <span class="tooltip-text">Menu Navigasi</span>
                    </div>

                    <!-- Footer -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.footer.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.footer.index') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-shoe-prints w-4 text-center text-[10px]"></i>
                            <span>Footer</span>
                        </a>
                        <span class="tooltip-text">Footer</span>
                    </div>

                    <!-- Social Media -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.social-media.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.social-media.*') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-share-alt w-4 text-center text-[10px]"></i>
                            <span>Social Media</span>
                        </a>
                        <span class="tooltip-text">Social Media</span>
                    </div>

                    <!-- Lokasi Kantor -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.lokasi-kantor.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.lokasi-kantor.*') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-map-pin w-4 text-center text-[10px]"></i>
                            <span>Lokasi Kantor</span>
                        </a>
                        <span class="tooltip-text">Lokasi Kantor</span>
                    </div>

                    <!-- FAQ -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.faq.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.faq.index') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-circle-question w-4 text-center text-[10px]"></i>
                            <span>FAQ</span>
                        </a>
                        <span class="tooltip-text">FAQ</span>
                    </div>

                    <!-- Karier -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.karier.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.karier.index') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-briefcase w-4 text-center text-[10px]"></i>
                            <span>Karier</span>
                        </a>
                        <span class="tooltip-text">Karier</span>
                    </div>

                    <!-- Kontak -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.kontak.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.kontak.index') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-envelope w-4 text-center text-[10px]"></i>
                            <span>Kontak Kami</span>
                            <?php
                                $unreadCount = \App\Models\Kontak::where('is_read', 0)->count();
                            ?>
                            <?php if($unreadCount > 0): ?>
                                <span class="ml-auto bg-red-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full min-w-[16px] text-center">
                                    <?php echo e($unreadCount); ?>

                                </span>
                            <?php endif; ?>
                        </a>
                        <span class="tooltip-text">Kontak Kami</span>
                    </div>

                    <!-- Pemanfaatan & Kerjasama -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.halaman.edit.partnership')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.halaman.edit.partnership') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-handshake w-4 text-center text-[10px]"></i>
                            <span>Pemanfaatan & Kerjasama</span>
                        </a>
                        <span class="tooltip-text">Pemanfaatan & Kerjasama</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================= -->
            <!-- ASET PERSEDIAAN TANAH (Hanya Super Admin & Admin) -->
            <!-- ============================================= -->
            <?php if(in_array($role, ['super_admin', 'admin'])): ?>
            <div class="pt-3 pb-1.5">
                <p class="px-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Aset Persediaan Tanah</p>
            </div>

            <?php
                $asetOpen = request()->routeIs('admin.aset.*');
            ?>

            <div x-data="{ open: <?php echo e($asetOpen ? 'true' : 'false'); ?> }" class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition
                    <?php echo e($asetOpen ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>"
                    aria-expanded="<?php echo e($asetOpen ? 'true' : 'false'); ?>">
                    <i class="fas fa-map-marked-alt w-5 text-center <?php echo e($asetOpen ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Aset Persediaan Tanah</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-transition:enter.duration.200ms x-transition:leave.duration.150ms
                    class="mt-0.5 pl-7 space-y-0.5 overflow-hidden" role="menu">

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.index') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-database w-4 text-center text-[10px]"></i>
                            <span>Data Aset</span>
                        </a>
                        <span class="tooltip-text">Data Aset</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.peta')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.peta') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-map-location-dot w-4 text-center text-[10px]"></i>
                            <span>Peta Interaktif</span>
                        </a>
                        <span class="tooltip-text">Peta Interaktif</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.profil')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.profil') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-layer-group w-4 text-center text-[10px]"></i>
                            <span>Profil Persediaan Tanah</span>
                        </a>
                        <span class="tooltip-text">Profil Persediaan Tanah</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.pengelolaan')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.pengelolaan') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-gear w-4 text-center text-[10px]"></i>
                            <span>Pengelolaan Tanah</span>
                        </a>
                        <span class="tooltip-text">Pengelolaan Tanah</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.pengembangan')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.pengembangan') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-chart-line w-4 text-center text-[10px]"></i>
                            <span>Pengembangan Tanah</span>
                        </a>
                        <span class="tooltip-text">Pengembangan Tanah</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.wilayah')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.wilayah') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-map w-4 text-center text-[10px]"></i>
                            <span>Wilayah</span>
                        </a>
                        <span class="tooltip-text">Wilayah</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.status')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.status') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-circle-check w-4 text-center text-[10px]"></i>
                            <span>Status Tanah</span>
                        </a>
                        <span class="tooltip-text">Status Tanah</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.dokumen')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.dokumen') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-file-lines w-4 text-center text-[10px]"></i>
                            <span>Dokumen</span>
                        </a>
                        <span class="tooltip-text">Dokumen</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.aset.statistik')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.aset.statistik') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-chart-pie w-4 text-center text-[10px]"></i>
                            <span>Statistik</span>
                        </a>
                        <span class="tooltip-text">Statistik</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================= -->
            <!-- PEMANFAATAN & KERJASAMA (Hanya Super Admin & Admin) -->
            <!-- ============================================= -->
            <?php if(in_array($role, ['super_admin', 'admin'])): ?>
            <div class="pt-3 pb-1.5">
                <p class="px-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Pemanfaatan & Kerjasama</p>
            </div>

            <?php
                $pemanfaatanOpen = request()->routeIs('admin.proyek-investasi.*') || request()->routeIs('admin.dokumen-kerjasama.*');
            ?>

            <div x-data="{ open: <?php echo e($pemanfaatanOpen ? 'true' : 'false'); ?> }" class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition
                    <?php echo e($pemanfaatanOpen ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>"
                    aria-expanded="<?php echo e($pemanfaatanOpen ? 'true' : 'false'); ?>">
                    <i class="fas fa-handshake w-5 text-center <?php echo e($pemanfaatanOpen ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Pemanfaatan & Kerjasama</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-transition:enter.duration.200ms x-transition:leave.duration.150ms
                    class="mt-0.5 pl-7 space-y-0.5 overflow-hidden" role="menu">

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.proyek-investasi.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.proyek-investasi.*') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-chart-line w-4 text-center text-[10px]"></i>
                            <span>Proyek Investasi</span>
                        </a>
                        <span class="tooltip-text">Proyek Investasi</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.dokumen-kerjasama.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.dokumen-kerjasama.*') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-file-lines w-4 text-center text-[10px]"></i>
                            <span>Dokumen Kerjasama</span>
                        </a>
                        <span class="tooltip-text">Dokumen Kerjasama</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================= -->
            <!-- PUBLIKASI (Semua Role: Super Admin, Admin, Editor, Publisher) -->
            <!-- ============================================= -->
            <?php if(in_array($role, ['super_admin', 'admin', 'editor', 'publisher'])): ?>
            <div class="pt-3 pb-1.5">
                <p class="px-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Publikasi</p>
            </div>

            <?php
                $pubOpen = request()->routeIs('admin.berita.*');
            ?>

            <div x-data="{ open: <?php echo e($pubOpen ? 'true' : 'false'); ?> }" class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition
                    <?php echo e($pubOpen ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>"
                    aria-expanded="<?php echo e($pubOpen ? 'true' : 'false'); ?>">
                    <i class="fas fa-newspaper w-5 text-center <?php echo e($pubOpen ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Publikasi</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-transition:enter.duration.200ms x-transition:leave.duration.150ms
                    class="mt-0.5 pl-7 space-y-0.5 overflow-hidden" role="menu">

                    <!-- Berita -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.berita.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.berita.index') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-newspaper w-4 text-center text-[10px]"></i>
                            <span>Berita</span>
                            <?php
                                $pendingCount = \App\Models\Berita::where('status_approval', 'Menunggu Approval')->count();
                            ?>
                            <?php if($pendingCount > 0 && in_array($role, ['publisher', 'super_admin', 'admin'])): ?>
                                <span class="ml-auto bg-orange-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full min-w-[16px] text-center">
                                    <?php echo e($pendingCount); ?>

                                </span>
                            <?php endif; ?>
                        </a>
                        <span class="tooltip-text">Berita</span>
                    </div>

                    <!-- Siaran Pers -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.berita.siaran_pers')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.berita.siaran_pers') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-bullhorn w-4 text-center text-[10px]"></i>
                            <span>Siaran Pers</span>
                        </a>
                        <span class="tooltip-text">Siaran Pers</span>
                    </div>

                    <!-- Pengumuman -->
                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.berita.pengumuman')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.berita.pengumuman') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-circle-info w-4 text-center text-[10px]"></i>
                            <span>Pengumuman</span>
                        </a>
                        <span class="tooltip-text">Pengumuman</span>
                    </div>

                    <!-- Tambah Berita - Hanya untuk Super Admin, Admin, Editor -->
                    <?php if(in_array($role, ['super_admin', 'admin', 'editor'])): ?>
                    <div class="pt-1">
                        <div class="tooltip-container">
                            <a href="<?php echo e(route('admin.berita.create')); ?>"
                                class="flex items-center gap-2.5 py-1.5 px-3 rounded-md text-xs font-medium text-[#006400] hover:bg-green-50 transition sidebar-transition w-full">
                                <i class="fas fa-plus-circle w-4 text-center text-[10px]"></i>
                                <span>Tambah Berita</span>
                            </a>
                            <span class="tooltip-text">Tambah Berita</span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================= -->
            <!-- MICROSITE (Hanya Super Admin & Admin) -->
            <!-- ============================================= -->
            <?php if(in_array($role, ['super_admin', 'admin'])): ?>
            <div class="pt-3 pb-1.5">
                <p class="px-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Microsite</p>
            </div>

            <?php
                $micrositeOpen = request()->routeIs('admin.microsite.*');
            ?>

            <div x-data="{ open: <?php echo e($micrositeOpen ? 'true' : 'false'); ?> }" class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition
                    <?php echo e($micrositeOpen ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>"
                    aria-expanded="<?php echo e($micrositeOpen ? 'true' : 'false'); ?>">
                    <i class="fas fa-file-lines w-5 text-center <?php echo e($micrositeOpen ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Microsite / Event</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-transition:enter.duration.200ms x-transition:leave.duration.150ms
                    class="mt-0.5 pl-7 space-y-0.5 overflow-hidden" role="menu">

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.microsite.index')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.microsite.index') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-list w-4 text-center text-[10px]"></i>
                            <span>Semua Microsite</span>
                        </a>
                        <span class="tooltip-text">Semua Microsite</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('admin.microsite.create')); ?>"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full
                            <?php echo e(request()->routeIs('admin.microsite.create') ? 'sub-menu-active' : 'text-gray-500 hover:bg-gray-50 hover:text-[#006400]'); ?>"
                            role="menuitem">
                            <i class="fas fa-plus-circle w-4 text-center text-[10px]"></i>
                            <span>Buat Microsite</span>
                        </a>
                        <span class="tooltip-text">Buat Microsite</span>
                    </div>

                    <div class="tooltip-container">
                        <a href="<?php echo e(route('microsite.index')); ?>" target="_blank"
                            class="flex items-center gap-2.5 py-2 px-3 rounded-md text-xs font-medium transition sidebar-transition w-full text-gray-500 hover:bg-gray-50 hover:text-[#006400]">
                            <i class="fas fa-external-link-alt w-4 text-center text-[10px]"></i>
                            <span>Lihat di Frontend</span>
                        </a>
                        <span class="tooltip-text">Lihat di Frontend</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================= -->
            <!-- KONTAK - Hanya Super Admin & Admin (di sidebar) -->
            <!-- ============================================= -->
            <?php if(in_array($role, ['super_admin', 'admin'])): ?>
            <div class="pt-3 pb-1.5">
                <p class="px-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Kontak</p>
            </div>

            <div class="tooltip-container">
                <a href="<?php echo e(route('admin.kontak.index')); ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition w-full
                    <?php echo e(request()->routeIs('admin.kontak.index') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                    <i class="fas fa-envelope w-5 text-center <?php echo e(request()->routeIs('admin.kontak.index') ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Kontak Masuk</span>
                    <?php
                        $unreadCount = \App\Models\Kontak::where('is_read', 0)->count();
                    ?>
                    <?php if($unreadCount > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full min-w-[16px] text-center">
                            <?php echo e($unreadCount); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <span class="tooltip-text">Kontak Masuk</span>
            </div>
            <?php endif; ?>

            <!-- ============================================= -->
            <!-- LAINNYA (Hanya Super Admin) -->
            <!-- ============================================= -->
            <?php if($role == 'super_admin'): ?>
            <div class="pt-3 pb-1.5">
                <p class="px-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">Sistem</p>
            </div>

            <div class="tooltip-container">
                <a href="<?php echo e(route('admin.user.index')); ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition w-full
                    <?php echo e(request()->routeIs('admin.user.*') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                    <i class="fas fa-users w-5 text-center <?php echo e(request()->routeIs('admin.user.*') ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Pengguna</span>
                    <?php
                        $userCount = \App\Models\User::count();
                    ?>
                    <span class="ml-auto text-[8px] text-gray-400"><?php echo e($userCount); ?></span>
                </a>
                <span class="tooltip-text">Pengguna</span>
            </div>

            <div class="tooltip-container">
                <a href="<?php echo e(route('admin.integrasi')); ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition w-full
                    <?php echo e(request()->routeIs('admin.integrasi') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                    <i class="fas fa-plug w-5 text-center <?php echo e(request()->routeIs('admin.integrasi') ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Integrasi</span>
                </a>
                <span class="tooltip-text">Integrasi</span>
            </div>

            <div class="tooltip-container">
                <a href="<?php echo e(route('admin.pengaturan')); ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition w-full
                    <?php echo e(request()->routeIs('admin.pengaturan') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                    <i class="fas fa-gear w-5 text-center <?php echo e(request()->routeIs('admin.pengaturan') ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Pengaturan</span>
                </a>
                <span class="tooltip-text">Pengaturan</span>
            </div>

            <div class="tooltip-container">
                <a href="<?php echo e(route('admin.activity-log')); ?>"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition w-full
                    <?php echo e(request()->routeIs('admin.activity-log*') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                    <i class="fas fa-clock-rotate-left w-5 text-center <?php echo e(request()->routeIs('admin.activity-log*') ? 'text-white' : 'text-gray-400'); ?>"></i>
                    <span>Aktivitas Sistem</span>
                </a>
                <span class="tooltip-text">Aktivitas Sistem</span>
            </div>
            <?php endif; ?>

            <!-- ============================================= -->
            <!-- LIAT WEBSITE (Semua Role) -->
            <!-- ============================================= -->
            <div class="h-4"></div>

            <div class="tooltip-container">
                <a href="<?php echo e(route('home')); ?>" target="_blank"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition sidebar-transition text-gray-500 hover:bg-gray-100 hover:text-[#006400] border border-dashed border-gray-200 mt-2 w-full">
                    <i class="fas fa-external-link-alt w-5 text-center text-gray-400"></i>
                    <span>Lihat Website</span>
                    <span class="ml-auto text-[8px] text-gray-400">
                        <i class="fas fa-arrow-up-right-from-square"></i>
                    </span>
                </a>
                <span class="tooltip-text">Lihat Website</span>
            </div>
        </nav>

        <!-- ========================================================= -->
        <!-- PROFIL ADMIN - SIDEBAR -->
        <!-- ========================================================= -->
        <div class="p-3 border-t border-gray-200 bg-gray-50/80" role="contentinfo">
            <div class="flex items-center gap-3">
                <?php if($user->foto): ?>
                    <img src="<?php echo e(asset('storage/' . $user->foto)); ?>?v=<?php echo e(time()); ?>"
                        class="w-9 h-9 rounded-full object-cover border-2 border-gray-200 flex-shrink-0"
                        alt="Profile photo of <?php echo e($user->name); ?>">
                <?php else: ?>
                    <div class="w-9 h-9 bg-[#006400] rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0" aria-hidden="true">
                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                    </div>
                <?php endif; ?>

                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-gray-900 truncate"><?php echo e($user->name); ?></p>
                    <p class="text-[9px] text-gray-500 capitalize flex items-center gap-1.5">
                        <span class="inline-block w-1.5 h-1.5 rounded-full
                            <?php echo e($user->role == 'super_admin' ? 'bg-purple-500' :
                               ($user->role == 'admin' ? 'bg-blue-500' :
                               ($user->role == 'editor' ? 'bg-yellow-500' :
                               ($user->role == 'publisher' ? 'bg-green-500' : 'bg-gray-500')))); ?>" aria-hidden="true">
                        </span>
                        <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                    </p>
                </div>

                <form method="POST" action="<?php echo e(route('logout')); ?>" class="flex-shrink-0">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1.5 rounded-lg hover:bg-red-50"
                            aria-label="Logout">
                        <i class="fas fa-sign-out-alt text-sm" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ========================================================= -->
    <!-- MAIN CONTENT -->
    <!-- ========================================================= -->
    <div class="flex-1 flex flex-col overflow-hidden main-content">

        <!-- HEADER -->
        <header class="admin-header bg-white h-16 border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0 shadow-sm" role="banner">
            <div class="flex items-center gap-3 flex-1">
                <!-- Mobile Toggle -->
                <button class="sidebar-mobile-toggle text-gray-500 hover:text-gray-700 lg:hidden"
                        onclick="toggleSidebar()"
                        aria-label="Toggle sidebar navigation"
                        aria-expanded="false">
                    <i class="fas fa-bars text-lg" aria-hidden="true"></i>
                </button>

                <!-- ========================================================= -->
                <!-- BREADCRUMB -->
                <!-- ========================================================= -->
                <?php
                    $breadcrumbs = [
                        'admin.dashboard' => 'Dashboard',
                        'admin.aset.index' => 'Data Aset',
                        'admin.aset.create' => 'Tambah Aset',
                        'admin.aset.edit' => 'Edit Aset',
                        'admin.aset.peta' => 'Peta Interaktif',
                        'admin.aset.profil' => 'Profil Persediaan Tanah',
                        'admin.aset.pengelolaan' => 'Pengelolaan Tanah',
                        'admin.aset.pengembangan' => 'Pengembangan Tanah',
                        'admin.aset.wilayah' => 'Wilayah',
                        'admin.aset.status' => 'Status Tanah',
                        'admin.aset.dokumen' => 'Dokumen',
                        'admin.aset.statistik' => 'Statistik',
                        'admin.berita.index' => 'Berita',
                        'admin.berita.create' => 'Tambah Berita',
                        'admin.berita.edit' => 'Edit Berita',
                        'admin.berita.siaran_pers' => 'Siaran Pers',
                        'admin.berita.pengumuman' => 'Pengumuman',
                        'admin.user.index' => 'Pengguna',
                        'admin.user.create' => 'Tambah Pengguna',
                        'admin.user.edit' => 'Edit Pengguna',
                        'admin.faq.index' => 'FAQ',
                        'admin.faq.create' => 'Tambah FAQ',
                        'admin.faq.edit' => 'Edit FAQ',
                        'admin.karier.index' => 'Karier',
                        'admin.karier.create' => 'Tambah Karier',
                        'admin.karier.edit' => 'Edit Karier',
                        'admin.kontak.index' => 'Kontak',
                        'admin.kontak.show' => 'Detail Kontak',
                        'admin.website' => 'Website',
                        'admin.halaman.index' => 'Halaman',
                        'admin.halaman.create' => 'Tambah Halaman',
                        'admin.halaman.edit' => 'Edit Halaman',
                        'admin.halaman.edit.tentang' => 'Edit Tentang',
                        'admin.halaman.edit.partnership' => 'Edit Pemanfaatan & Kerjasama',
                        'admin.menu_navigasi' => 'Menu Navigasi',
                        'admin.footer.index' => 'Footer',
                        'admin.proyek-investasi.index' => 'Proyek Investasi',
                        'admin.proyek-investasi.create' => 'Tambah Proyek Investasi',
                        'admin.proyek-investasi.edit' => 'Edit Proyek Investasi',
                        'admin.dokumen-kerjasama.index' => 'Dokumen Kerjasama',
                        'admin.dokumen-kerjasama.create' => 'Upload Dokumen',
                        'admin.dokumen-kerjasama.edit' => 'Edit Dokumen',
                        'admin.integrasi' => 'Integrasi',
                        'admin.pengaturan' => 'Pengaturan',
                        'admin.microsite.index' => 'Microsite',
                        'admin.microsite.create' => 'Buat Microsite',
                        'admin.microsite.edit' => 'Edit Microsite',
                        'admin.social-media.index' => 'Social Media',
                        'admin.social-media.create' => 'Tambah Social Media',
                        'admin.social-media.edit' => 'Edit Social Media',
                        'admin.lokasi-kantor.index' => 'Lokasi Kantor',
                        'admin.lokasi-kantor.create' => 'Tambah Lokasi Kantor',
                        'admin.lokasi-kantor.edit' => 'Edit Lokasi Kantor',
                        'admin.notifications.index' => 'Notifikasi',
                    ];

                    $currentRoute = Route::currentRouteName();
                    $breadcrumbTitle = $breadcrumbs[$currentRoute] ?? 'Dashboard';
                    
                    // Cari parent route (hanya jika route name ada dan memiliki minimal 2 segmen)
                    $parentTitle = null;
                    if ($currentRoute) {
                        $segments = explode('.', $currentRoute);
                        if (count($segments) >= 2) {
                            $parentRoute = $segments[0] . '.' . $segments[1];
                            $parentTitle = $breadcrumbs[$parentRoute] ?? null;
                        }
                    }
                ?>

                <div class="hidden sm:flex items-center gap-2 text-xs text-gray-500" aria-label="Breadcrumb">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-[#006400] transition" aria-label="Home">
                        <i class="fas fa-home" aria-hidden="true"></i>
                    </a>
                    <i class="fas fa-chevron-right text-gray-300 text-[8px]" aria-hidden="true"></i>
                    <?php if($parentTitle && $parentTitle != $breadcrumbTitle): ?>
                        <span class="text-gray-400"><?php echo e($parentTitle); ?></span>
                        <i class="fas fa-chevron-right text-gray-300 text-[8px]" aria-hidden="true"></i>
                    <?php endif; ?>
                    <span class="font-medium text-gray-700"><?php echo e($breadcrumbTitle); ?></span>
                </div>
            </div>

            <div class="header-actions flex items-center gap-2 sm:gap-3">

                <!-- Search Bar -->
                <div class="relative hidden md:block header-search">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" id="adminSearch"
                        placeholder="Cari menu..."
                        aria-label="Search menu"
                        class="bg-gray-50 border border-gray-200 rounded-lg pl-9 pr-4 py-2 text-sm w-40 lg:w-56 focus:outline-none focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[8px] text-gray-400 bg-gray-200 px-1.5 py-0.5 rounded hidden xl:block" aria-hidden="true">Ctrl+K</span>
                </div>

                <!-- Dark Mode Button -->
                <button id="darkModeButton" type="button"
                    class="text-gray-400 hover:text-gray-700 transition w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center"
                    aria-label="Toggle dark mode"
                    title="Toggle Dark Mode">
                    <i id="darkModeIcon" class="fas fa-moon" aria-hidden="true"></i>
                </button>

                <!-- ========================================================= -->
                <!-- NOTIFICATION DROPDOWN (FIXED) -->
                <!-- ========================================================= -->
                <div x-data="{ 
                    open: false, 
                    notifications: [], 
                    total: 0, 
                    loading: true,
                    pendingNews: 0,
                    unreadContacts: 0
                }" 
                x-init="
                    setTimeout(() => { loading = false; }, 500);
                    fetchNotifications();
                    setInterval(fetchNotifications, 30000);
                "
                @click.outside="open = false"
                class="relative">

                    <button @click="open = !open"
                        class="text-gray-400 hover:text-gray-700 transition w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center relative"
                        aria-label="Notifications"
                        aria-expanded="false"
                        title="Notifikasi">
                        <i class="fas fa-bell" aria-hidden="true"></i>
                        <span x-show="total > 0" x-text="total > 99 ? '99+' : total"
                            class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full min-w-[14px] text-center notification-pulse"
                            style="display: none;">
                        </span>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50"
                        style="display: none;"
                        role="dialog"
                        aria-label="Notifications">

                        <!-- Header -->
                        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                            <span class="font-bold text-sm text-gray-900">Notifikasi</span>
                            <div class="flex items-center gap-2">
                                <span x-show="total > 0" x-text="total" class="text-[10px] text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full"></span>
                                <button x-show="total > 0" @click="markAllAsRead()" class="text-[10px] text-blue-600 hover:underline">
                                    Tandai semua dibaca
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                            <!-- Loading -->
                            <div x-show="loading" class="px-4 py-8 text-center">
                                <i class="fas fa-spinner fa-spin text-gray-400 text-xl" aria-hidden="true"></i>
                                <p class="text-sm text-gray-400 mt-2">Memuat notifikasi...</p>
                            </div>

                            <!-- Empty -->
                            <div x-show="!loading && notifications.length === 0" class="px-4 py-8 text-center">
                                <i class="fas fa-check-circle text-3xl text-gray-300 block mb-2" aria-hidden="true"></i>
                                <p class="text-sm text-gray-400">Tidak ada notifikasi</p>
                                <p class="text-xs text-gray-300 mt-1">Semua sudah dibaca</p>
                            </div>

                            <!-- List -->
                            <template x-for="item in notifications" :key="item.id">
                                <a :href="item.link" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition group">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                         :class="'bg-' + item.icon_bg">
                                        <i :class="'fas ' + item.icon + ' text-' + item.icon_color + ' text-xs'"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-gray-800 truncate" x-text="item.title"></p>
                                        <p class="text-[10px] text-gray-500 line-clamp-1" x-text="item.message || item.content || ''"></p>
                                        <p class="text-[8px] text-gray-400 mt-0.5" x-text="item.time"></p>
                                    </div>
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#006400] flex-shrink-0 mt-1"></span>
                                </a>
                            </template>
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-2 border-t border-gray-100 text-center">
                            <a href="<?php echo e(route('admin.notifications.index')); ?>" class="text-[10px] text-blue-600 hover:underline">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </div>

                <!-- ========================================================= -->
                <!-- USER AVATAR - HEADER -->
                <!-- ========================================================= -->
                <?php if($user->foto): ?>
                    <img src="<?php echo e(asset('storage/' . $user->foto)); ?>?v=<?php echo e(time()); ?>"
                        class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 hidden sm:block"
                        alt="Profile photo of <?php echo e($user->name); ?>">
                <?php else: ?>
                    <div class="w-8 h-8 bg-[#006400] rounded-full flex items-center justify-center text-white font-bold text-xs hidden sm:block" aria-hidden="true">
                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                    </div>
                <?php endif; ?>

            </div>
        </header>

        <!-- CONTENT -->
        <main class="admin-content flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50/80" role="main">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- ========================================================= -->
    <!-- TOAST NOTIFICATION -->
    <!-- ========================================================= -->
    <div id="toastContainer" class="fixed top-20 right-4 z-[99999] space-y-3 max-w-sm w-full" role="alert" aria-live="polite"></div>

    <!-- ========================================================= -->
    <!-- COMING SOON MODAL -->
    <!-- ========================================================= -->
    <div id="comingSoonModal" class="fixed inset-0 z-[99999] flex items-center justify-center px-4 hidden" role="dialog" aria-modal="true" aria-labelledby="comingSoonTitle">
        <div class="absolute inset-0 bg-black/50" onclick="closeComingSoon()" aria-hidden="true"></div>
        <div class="relative bg-white rounded-2xl max-w-md w-full p-8 text-center shadow-2xl animate-fade-up">
            <div class="w-16 h-16 mx-auto rounded-full bg-green-50 flex items-center justify-center mb-4" aria-hidden="true">
                <i class="fas fa-rocket text-3xl text-[#006400]"></i>
            </div>
            <h3 id="comingSoonTitle" class="text-xl font-bold text-gray-900 mb-2">Fitur Segera Hadir</h3>
            <p class="text-sm text-gray-500 mb-6">
                Fitur <span id="featureName" class="font-semibold text-gray-700"></span> sedang dalam pengembangan.
            </p>
            <button onclick="closeComingSoon()" class="px-6 py-2.5 bg-[#006400] hover:bg-[#005500] text-white rounded-lg font-semibold text-sm transition" aria-label="Close">
                Mengerti
            </button>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- SCRIPTS -->
    <!-- ========================================================= -->
    <script>
        // =========================================================
        // SIDEBAR TOGGLE (Mobile)
        // =========================================================
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.querySelector('.sidebar-mobile-toggle');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');

            if (toggleBtn) {
                const isOpen = sidebar.classList.contains('open');
                toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }

            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        // Tutup sidebar saat resize ke desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('adminSidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const toggleBtn = document.querySelector('.sidebar-mobile-toggle');

                sidebar?.classList.remove('open');
                overlay?.classList.remove('active');
                if (toggleBtn) {
                    toggleBtn.setAttribute('aria-expanded', 'false');
                }
                document.body.style.overflow = '';
            }
        });

        // =========================================================
        // SEARCH BAR
        // =========================================================
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('adminSearch');

            if (searchInput) {
                const menuItems = document.querySelectorAll('nav a, nav button');

                searchInput.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase().trim();

                    menuItems.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        const parent = item.closest('.relative') || item.parentElement;

                        if (keyword === '') {
                            if (parent) parent.style.display = '';
                            item.style.display = '';
                        } else if (text.includes(keyword)) {
                            if (parent) parent.style.display = '';
                            item.style.display = '';
                        } else {
                            if (parent) parent.style.display = 'none';
                            item.style.display = 'none';
                        }
                    });

                    document.querySelectorAll('.pt-3, .pb-1.5').forEach(el => {
                        if (keyword === '') {
                            el.style.display = '';
                        } else {
                            const hasVisible = el.nextElementSibling?.querySelector('a:not([style*="display: none"])');
                            if (!hasVisible) {
                                el.style.display = 'none';
                            } else {
                                el.style.display = '';
                            }
                        }
                    });
                });

                // Ctrl+K shortcut
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.select();
                    }
                });
            }
        });

        // =========================================================
        // LOADING STATE
        // =========================================================
        function showLoading() {
            document.getElementById('adminLoading').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('adminLoading').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    showLoading();
                });
            });

            document.querySelectorAll('a.need-loading').forEach(link => {
                link.addEventListener('click', function() {
                    showLoading();
                });
            });
        });

        window.addEventListener('load', function() {
            hideLoading();
        });

        // =========================================================
        // TOAST NOTIFICATION
        // =========================================================
        function showToast(message, type = 'success', duration = 4000) {
            const container = document.getElementById('toastContainer');
            const colors = {
                success: 'bg-green-50 border-green-400 text-green-800',
                error: 'bg-red-50 border-red-400 text-red-800',
                warning: 'bg-yellow-50 border-yellow-400 text-yellow-800',
                info: 'bg-blue-50 border-blue-400 text-blue-800'
            };
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-triangle-exclamation',
                info: 'fa-circle-info'
            };

            const toast = document.createElement('div');
            toast.className = `flex items-start gap-3 p-4 border rounded-xl shadow-lg ${colors[type] || colors.info} animate-slide-in`;
            toast.innerHTML = `
                <i class="fas ${icons[type] || icons.info} text-lg mt-0.5" aria-hidden="true"></i>
                <div class="flex-1 text-sm font-medium">${message}</div>
                <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition" aria-label="Close notification">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            `;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        <?php if(session('success')): ?>
            showToast('<?php echo e(session('success')); ?>', 'success');
        <?php endif; ?>

        <?php if(session('error')): ?>
            showToast('<?php echo e(session('error')); ?>', 'error');
        <?php endif; ?>

        <?php if(session('warning')): ?>
            showToast('<?php echo e(session('warning')); ?>', 'warning');
        <?php endif; ?>

        <?php if(session('info')): ?>
            showToast('<?php echo e(session('info')); ?>', 'info');
        <?php endif; ?>

        // =========================================================
        // COMING SOON MODAL
        // =========================================================
        function showComingSoon(feature) {
            document.getElementById('featureName').textContent = feature;
            document.getElementById('comingSoonModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeComingSoon() {
            document.getElementById('comingSoonModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeComingSoon();
            }
        });

        // =========================================================
        // NOTIFICATION FUNCTIONS - FIXED
        // =========================================================
        function fetchNotifications() {
            const dropdown = document.querySelector('[x-data]');
            if (!dropdown) return;
            
            // Ambil data Alpine.js
            let dataObj = null;
            if (dropdown._x_dataStack && dropdown._x_dataStack.length > 0) {
                dataObj = dropdown._x_dataStack[0];
            }
            
            if (!dataObj) return;
            
            // Set loading true
            dataObj.loading = true;
            
            fetch('<?php echo e(route("admin.notifications.index")); ?>?limit=5&ajax=1')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // Update data
                    dataObj.notifications = data.notifications || [];
                    dataObj.total = data.total || 0;
                    dataObj.pendingNews = data.pending_news || 0;
                    dataObj.unreadContacts = data.unread_contacts || 0;
                    dataObj.loading = false;
                    
                    // Update badge
                    updateBadge(data.total);
                })
                .catch(error => {
                    console.error('Error fetching notifications:', error);
                    dataObj.loading = false;
                    dataObj.notifications = [];
                    dataObj.total = 0;
                    
                    // Coba fallback ke endpoint unread-count
                    fetch('<?php echo e(route("admin.notifications.unread-count")); ?>')
                        .then(res => res.json())
                        .then(data => {
                            updateBadge(data.count || 0);
                        })
                        .catch(() => {
                            updateBadge(0);
                        });
                });
        }

        function updateBadge(count) {
            const badge = document.querySelector('.notification-pulse');
            if (!badge) return;
            
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        }

        function markAllAsRead() {
            if (!confirm('Tandai semua notifikasi sebagai dibaca?')) return;
            
            fetch('<?php echo e(route("admin.notifications.mark-all-read")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update badge dan dropdown
                    const dropdown = document.querySelector('[x-data]');
                    if (dropdown && dropdown._x_dataStack) {
                        const dataObj = dropdown._x_dataStack[0];
                        if (dataObj) {
                            dataObj.notifications = [];
                            dataObj.total = 0;
                            dataObj.pendingNews = 0;
                            dataObj.unreadContacts = 0;
                            updateBadge(0);
                        }
                    }
                    window.location.href = '<?php echo e(route("admin.notifications.index")); ?>';
                }
            })
            .catch(() => {
                window.location.href = '<?php echo e(route("admin.notifications.index")); ?>';
            });
        }

        // =========================================================
        // INIT NOTIFICATION BADGE - Page Load
        // =========================================================
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch notifikasi setelah 1 detik
            setTimeout(fetchNotifications, 1000);
        });

        // =========================================================
        // MARK ALL NOTIFICATIONS AS READ (Fallback)
        // =========================================================
        function markAllAsReadOld() {
            fetch('<?php echo e(route("admin.notifications.mark-all-read")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            }).catch(() => {
                location.reload();
            });
        }
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\Lenovo\badan-tanah-ui-new\resources\views/layouts/admin.blade.php ENDPATH**/ ?>