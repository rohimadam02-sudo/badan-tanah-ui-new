<?php $__env->startSection('title', 'Peta Interaktif'); ?>

<?php $__env->startSection('content'); ?>

    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex items-start gap-4 mb-5">
            <div class="w-12 h-12 bg-green-100 text-[#006400] rounded-full flex items-center justify-center shrink-0">
                <i class="fas fa-map-marked-alt text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Peta Interaktif</h1>
                <p class="text-xs text-gray-500 mt-1">Visualisasi sebaran aset persediaan tanah Badan Bank Tanah.</p>
            </div>
        </div>

        <!-- TAB NAVIGASI ASET - RESPONSIVE -->
        <div class="flex flex-wrap items-center gap-1.5 border-b border-gray-200 pb-3 mb-5">
            <a href="<?php echo e(route('admin.aset.index')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.index') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-database text-sm"></i>
                <span>Data Aset</span>
            </a>

            <a href="<?php echo e(route('admin.aset.peta')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.peta') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-map-location-dot text-sm"></i>
                <span>Peta Interaktif</span>
            </a>

            <a href="<?php echo e(route('admin.aset.profil')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.profil') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-layer-group text-sm"></i>
                <span>Profil Persediaan Tanah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.pengelolaan')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.pengelolaan') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-gear text-sm"></i>
                <span>Pengelolaan Tanah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.pengembangan')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.pengembangan') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-chart-line text-sm"></i>
                <span>Pengembangan Tanah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.wilayah')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.wilayah') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-map text-sm"></i>
                <span>Wilayah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.status')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.status') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-circle-check text-sm"></i>
                <span>Status Tanah</span>
            </a>

            <a href="<?php echo e(route('admin.aset.dokumen')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.dokumen') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-file-lines text-sm"></i>
                <span>Dokumen</span>
            </a>

            <a href="<?php echo e(route('admin.aset.statistik')); ?>"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            <?php echo e(request()->routeIs('admin.aset.statistik') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'); ?>">
                <i class="fas fa-chart-pie text-sm"></i>
                <span>Statistik</span>
            </a>
        </div>

        <!-- KARTU STATISTIK - DATA REAL -->
        <?php
            $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
            $totalAset = \App\Models\AsetTanah::count();
            $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
            $totalKabupaten = \App\Models\AsetTanah::distinct('kabupaten')->count('kabupaten');
        ?>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-5">
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-database text-green-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[8px] text-gray-500">Total Luas</p>
                        <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($totalLuas, 2, ',', '.')); ?> Ha</p>
                        <p class="text-[7px] text-gray-400">Seluruh aset</p>
                    </div>
                </div>
            </div>

            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-layer-group text-blue-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[8px] text-gray-500">Total Aset</p>
                        <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($totalAset)); ?></p>
                        <p class="text-[7px] text-gray-400">Aset terdaftar</p>
                    </div>
                </div>
            </div>

            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-map text-purple-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[8px] text-gray-500">Provinsi</p>
                        <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($totalProvinsi)); ?></p>
                        <p class="text-[7px] text-gray-400">Wilayah terdata</p>
                    </div>
                </div>
            </div>

            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-city text-orange-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[8px] text-gray-500">Kabupaten/Kota</p>
                        <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($totalKabupaten)); ?></p>
                        <p class="text-[7px] text-gray-400">Daerah terdata</p>
                    </div>
                </div>
            </div>

            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-money-bill-trend-up text-teal-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[8px] text-gray-500">Nilai Indikatif</p>
                        <p class="text-sm font-bold text-gray-900 whitespace-nowrap">Rp 68,45 T</p>
                        <p class="text-[7px] text-gray-400">Nilai estimasi aset</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PETA + SIDEBAR -->
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-4">

            <!-- PETA -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-gray-900">Peta Persebaran Aset</h2>
                            <p class="text-[9px] text-gray-400 mt-0.5">Klik marker provinsi untuk melihat detail</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- TOGGLE MODE TAMPILAN -->
                            <div class="flex items-center bg-gray-100 rounded-md p-0.5" id="viewModeToggle">
                                <button type="button" data-mode="provinsi"
                                    class="view-mode-btn px-2.5 py-1 text-[9px] font-semibold rounded transition bg-white text-[#006400] shadow-sm">
                                    Per Provinsi
                                </button>
                                <button type="button" data-mode="aset"
                                    class="view-mode-btn px-2.5 py-1 text-[9px] font-semibold rounded transition text-gray-500">
                                    Per Aset
                                </button>
                            </div>
                            <div class="relative">
                                <i
                                    class="fas fa-search absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 text-[9px]"></i>
                                <input type="text" id="searchMap" placeholder="Cari lokasi..."
                                    class="w-32 pl-6 pr-2 py-1.5 text-[9px] border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                            </div>
                            <button type="button" onclick="resetMapView()"
                                class="px-2.5 py-1.5 text-[9px] border border-gray-200 rounded-md text-gray-600 hover:bg-gray-50">
                                <i class="fas fa-crosshairs mr-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- WRAPPER PETA + PANEL INFO PROVINSI -->
                <div id="map" class="h-[470px] w-full"></div>

                <!-- PANEL INFO PROVINSI - muncul di bawah peta saat marker diklik -->



                <div class="px-4 py-3 border-t border-gray-100">
                    <div class="flex items-center gap-6 flex-wrap">
                        <span class="text-[9px] font-semibold text-gray-500">Legenda</span>
                        <div class="flex items-center gap-1.5 text-[9px] text-gray-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Marker Provinsi
                        </div>
                        <div class="flex items-center gap-1.5 text-[9px] text-gray-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Tersedia
                        </div>
                        <div class="flex items-center gap-1.5 text-[9px] text-gray-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Dalam Pengembangan
                        </div>
                        <div class="flex items-center gap-1.5 text-[9px] text-gray-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Dalam Proses
                        </div>
                        <div class="flex items-center gap-1.5 text-[9px] text-gray-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-gray-500"></span> Terikat
                        </div>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR -->
            <!-- SIDEBAR -->
            <div class="w-full lg:w-80 lg:shrink-0 space-y-4">

                <!-- PANEL INFO ASET (muncul saat marker aset diklik) -->
                <div id="assetPanel" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-[#006400] px-4 py-3 flex items-center justify-between">
                        <h3 id="apName" class="text-xs font-bold text-white uppercase tracking-wide">ASET</h3>
                        <button type="button" onclick="closeAssetPanel()" class="text-white/80 hover:text-white">
                            <i class="fas fa-times text-[10px]"></i>
                        </button>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="text-[8px] text-gray-400">Lokasi</p>
                            <p id="apLokasi" class="text-xs font-bold text-gray-900">-</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-ruler-combined text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[8px] text-gray-400">Luas</p>
                                <p id="apLuas" class="text-sm font-bold text-gray-900">0 Ha</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-circle-check text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[8px] text-gray-400">Status</p>
                                <p id="apStatus" class="text-sm font-bold text-gray-900">-</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-map-location-dot text-purple-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[8px] text-gray-400">Kabupaten/Kota</p>
                                <p id="apKab" class="text-sm font-bold text-gray-900">-</p>
                            </div>
                        </div>
                        <a id="apDetailLink" href="#"
                            class="block text-center bg-[#006400] hover:bg-[#005500] text-white text-[9px] font-semibold py-2 rounded-md transition">
                            Lihat Detail <i class="fas fa-arrow-right ml-0.5 text-[8px]"></i>
                        </a>
                    </div>
                </div>

                <!-- PANEL INFO PROVINSI (muncul saat marker diklik) -->
                <div id="provincePanel"
                    class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-[#006400] px-4 py-3 flex items-center justify-between">
                        <h3 id="ppName" class="text-xs font-bold text-white uppercase tracking-wide">PROVINSI</h3>
                        <button type="button" onclick="closeProvincePanel()" class="text-white/80 hover:text-white">
                            <i class="fas fa-times text-[10px]"></i>
                        </button>
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-layer-group text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[8px] text-gray-400">Jumlah Lahan</p>
                                <p id="ppJumlah" class="text-sm font-bold text-gray-900">0 Lahan</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-ruler-combined text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[8px] text-gray-400">Total Luas</p>
                                <p id="ppLuas" class="text-sm font-bold text-gray-900">0 Ha</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-city text-purple-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[8px] text-gray-400">Kabupaten/Kota</p>
                                <p id="ppKab" class="text-sm font-bold text-gray-900">0 Daerah</p>
                            </div>
                        </div>
                        <a id="ppDetailLink" href="#"
                            class="block text-center bg-[#006400] hover:bg-[#005500] text-white text-[9px] font-semibold py-2 rounded-md transition">
                            Lihat Detail <i class="fas fa-arrow-right ml-0.5 text-[8px]"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-xs font-bold text-gray-900">Ringkasan Per Provinsi</h2> <a
                            href="<?php echo e(route('admin.aset.wilayah')); ?>"
                            class="text-[8px] text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="p-4 space-y-3">
                        <?php
                            $provinsiData = \App\Models\AsetTanah::select(
                                'provinsi',
                                \DB::raw('sum(luas_hektar) as total_luas'),
                            )
                                ->groupBy('provinsi')
                                ->orderBy('total_luas', 'desc')
                                ->take(5)
                                ->get();
                            $maxLuas = $provinsiData->max('total_luas') ?: 1;
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $provinsiData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[9px] font-semibold text-gray-600"><?php echo e($item->provinsi); ?></span>
                                    <span
                                        class="text-[8px] text-gray-400"><?php echo e(number_format($item->total_luas, 0, ',', '.')); ?>

                                        Ha</span>
                                </div>
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#006400] rounded-full"
                                        style="width: <?php echo e(min(100, ($item->total_luas / $maxLuas) * 100)); ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-[9px] text-gray-400">Belum ada data provinsi.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <h2 class="text-xs font-bold text-gray-900">Filter Peta</h2>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <label class="block text-[9px] font-semibold text-gray-500 mb-1">Status Tanah</label>
                            <select id="filterStatus"
                                class="w-full px-2 py-1.5 text-[9px] border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                                <option value="">Semua Status</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Dalam Pengembangan">Dalam Pengembangan</option>
                                <option value="Dalam Proses">Dalam Proses</option>
                                <option value="Terikat">Terikat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[9px] font-semibold text-gray-500 mb-1">Provinsi</label>
                            <select id="filterProvinsi"
                                class="w-full px-2 py-1.5 text-[9px] border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                                <option value="">Semua Provinsi</option>
                                <?php
                                    $provinsiList = \App\Models\AsetTanah::distinct('provinsi')
                                        ->pluck('provinsi')
                                        ->sort();
                                ?>
                                <?php $__currentLoopData = $provinsiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provinsi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($provinsi); ?>"><?php echo e($provinsi); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="button" onclick="applyMapFilter()"
                            class="w-full bg-[#006400] text-white py-2 rounded-md text-[9px] font-semibold hover:bg-[#005500] transition">
                            <i class="fas fa-filter mr-1"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- INFORMASI -->
        <div class="mt-4 bg-green-50 border border-green-100 rounded-lg px-4 py-3">
            <div class="flex items-start gap-2">
                <i class="fas fa-circle-info text-green-600 text-xs mt-0.5"></i>
                <div>
                    <p class="text-[9px] font-semibold text-green-800">Informasi</p>
                    <p class="text-[8px] text-green-700 mt-0.5">
                        Peta menampilkan lokasi aset persediaan tanah berdasarkan data yang tersedia pada sistem.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        /* Marker provinsi biru dengan hover & active state */
        .province-marker-icon {
            background: transparent;
            border: none;
        }

        .province-marker-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #2563eb;
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.4), 0 2px 6px rgba(0, 0, 0, 0.25);
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .province-marker-dot:hover {
            transform: scale(1.25);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.35), 0 3px 10px rgba(0, 0, 0, 0.3);
        }

        .province-marker-dot.active {
            background: #1e40af;
            transform: scale(1.35);
            box-shadow: 0 0 0 6px rgba(37, 99, 235, 0.45), 0 3px 12px rgba(0, 0, 0, 0.35);
            animation: pulseProvince 1.6s infinite;
        }

        @keyframes pulseProvince {
            0% {
                box-shadow: 0 0 0 6px rgba(37, 99, 235, 0.45), 0 3px 12px rgba(0, 0, 0, 0.35);
            }

            70% {
                box-shadow: 0 0 0 14px rgba(37, 99, 235, 0), 0 3px 12px rgba(0, 0, 0, 0.35);
            }

            100% {
                box-shadow: 0 0 0 6px rgba(37, 99, 235, 0.45), 0 3px 12px rgba(0, 0, 0, 0.35);
            }
        }

        .leaflet-popup-content-wrapper {
            border-radius: 8px;
        }
    </style>

    <script>
        /* =========================================================
                                   DATA ASET DARI LARAVEL (existing, dipertahankan)
                                   ========================================================= */
        const assetData = [
            <?php $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    id: <?php echo e($aset->id); ?>,
                    nama: <?php echo json_encode($aset->nama_lokasi, 15, 512) ?>,
                    provinsi: <?php echo json_encode($aset->provinsi, 15, 512) ?>,
                    kabupaten: <?php echo json_encode($aset->kabupaten, 15, 512) ?>,
                    luas: <?php echo e($aset->luas_hektar ?? 0); ?>,
                    status: <?php echo json_encode($aset->status, 15, 512) ?>,
                    lat: <?php echo e($aset->lat ?? 0); ?>,
                    lng: <?php echo e($aset->lng ?? 0); ?>

                },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];

        /* =========================================================
           KOORDINAT PUSAT PROVINSI INDONESIA (38 provinsi)
           Data geografis resmi — bukan data dummy jumlah lahan.
           Jumlah lahan & total luas tetap dihitung dari assetData.
           ========================================================= */
        const PROVINCE_COORDS = {
            'Aceh': [4.6951, 96.7494],
            'Sumatera Utara': [2.1154, 99.5451],
            'Sumatera Barat': [-0.7399, 100.8000],
            'Riau': [0.2933, 101.7068],
            'Kepulauan Riau': [3.9456, 108.1429],
            'Jambi': [-1.6101, 103.6131],
            'Sumatera Selatan': [-3.3194, 103.9144],
            'Bangka Belitung': [-2.7410, 106.4406],
            'Bengkulu': [-3.7928, 102.2608],
            'Lampung': [-4.5586, 105.4068],
            'DKI Jakarta': [-6.2088, 106.8456],
            'Jawa Barat': [-6.9147, 107.6098],
            'Jawa Tengah': [-7.1500, 110.1403],
            'DI Yogyakarta': [-7.7971, 110.3688],
            'Jawa Timur': [-7.5361, 112.2384],
            'Banten': [-6.4058, 106.0640],
            'Bali': [-8.4095, 115.1889],
            'Nusa Tenggara Barat': [-8.6529, 117.3616],
            'Nusa Tenggara Timur': [-8.6573, 121.0794],
            'Kalimantan Barat': [-0.2787, 111.4753],
            'Kalimantan Tengah': [-1.6815, 113.3824],
            'Kalimantan Selatan': [-3.0926, 115.2838],
            'Kalimantan Timur': [0.5387, 116.4194],
            'Kalimantan Utara': [3.0731, 116.0414],
            'Sulawesi Utara': [0.6246, 123.9750],
            'Gorontalo': [0.6999, 122.4467],
            'Sulawesi Tengah': [-1.4300, 121.4456],
            'Sulawesi Barat': [-2.8441, 119.2321],
            'Sulawesi Selatan': [-3.6688, 119.9740],
            'Sulawesi Tenggara': [-4.1449, 122.1746],
            'Maluku': [-3.2385, 130.1453],
            'Maluku Utara': [1.5709, 127.8087],
            'Papua': [-4.2699, 138.0803],
            'Papua Barat': [-1.3361, 133.1747],
            'Papua Barat Daya': [-1.0536, 131.3470],
            'Papua Tengah': [-4.0833, 136.8833],
            'Papua Pegunungan': [-4.0000, 138.5000],
            'Papua Selatan': [-7.5000, 139.5000],
        };

        /* Normalisasi nama provinsi agar cocok dengan data DB */
        function normalizeProvince(name) {
            if (!name) return '';
            return name.toString().trim();
        }

        function getProvinceCoord(provinsi) {
            if (!provinsi) return null;
            const key = normalizeProvince(provinsi);
            if (PROVINCE_COORDS[key]) return PROVINCE_COORDS[key];
            // fallback: cari case-insensitive
            const found = Object.keys(PROVINCE_COORDS).find(
                k => k.toLowerCase() === key.toLowerCase()
            );
            return found ? PROVINCE_COORDS[found] : null;
        }

        /* =========================================================
           AGREGASI DATA PER PROVINSI (dari assetData, bukan hardcode)
           ========================================================= */
        function buildProvinceSummary(data) {
            const summary = {};
            data.forEach(a => {
                const p = normalizeProvince(a.provinsi);
                if (!p) return;
                if (!summary[p]) {
                    summary[p] = {
                        provinsi: p,
                        jumlah_lahan: 0,
                        total_luas: 0,
                        kabupatenSet: new Set(),
                        asetIds: []
                    };
                }
                summary[p].jumlah_lahan += 1;
                summary[p].total_luas += Number(a.luas) || 0;
                if (a.kabupaten) summary[p].kabupatenSet.add(a.kabupaten);
                summary[p].asetIds.push(a.id);
            });
            // konversi Set ke jumlah
            Object.values(summary).forEach(s => {
                s.jumlah_kabupaten = s.kabupatenSet.size;
                delete s.kabupatenSet;
            });
            return Object.values(summary);
        }

        /* =========================================================
           INISIALISASI MAP (existing, dipertahankan)
           ========================================================= */
        const map = L.map('map').setView([-2.5, 118.0], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        /* =========================================================
           STATE
           ========================================================= */
        let markers = [];
        let currentMode = 'provinsi'; // 'provinsi' | 'aset'
        let activeProvince = null;

        /* =========================================================
           MARKER ASET (existing behavior, dipertahankan)
           ========================================================= */
        function getMarkerColor(status) {
            if (status === 'Tersedia') return '#16a34a';
            if (status === 'Dalam Pengembangan') return '#2563eb';
            if (status === 'Dalam Proses') return '#f97316';
            if (status === 'Terikat') return '#6b7280';
            return '#6b7280';
        }

        function clearMarkers() {
            markers.forEach(m => map.removeLayer(m));
            markers = [];
        }

        function createAssetMarkers(data) {
            clearMarkers();
            data.forEach(asset => {
                if (!asset.lat || !asset.lng) return;
                const color = getMarkerColor(asset.status);
                const marker = L.circleMarker([asset.lat, asset.lng], {
                    radius: 7,
                    fillColor: color,
                    color: '#ffffff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.9
                });
                // Klik marker → tampilkan info di panel sidebar (bukan popup)
                marker.on('click', () => selectAsset(asset, marker));

                marker.addTo(map);
                marker._assetData = asset;
                markers.push(marker);
            });
        }

        /* =========================================================
           MARKER PROVINSI (fitur baru)
           ========================================================= */
        function createProvinceMarkers(data) {
            clearMarkers();
            const summary = buildProvinceSummary(data);

            summary.forEach(p => {
                const coord = getProvinceCoord(p.provinsi);
                if (!coord) return; // provinsi tanpa koordinat, skip

                const icon = L.divIcon({
                    className: 'province-marker-icon',
                    html: `<div class="province-marker-dot" data-provinsi="${p.provinsi}"></div>`,
                    iconSize: [18, 18],
                    iconAnchor: [9, 9],
                    popupAnchor: [0, -10]
                });

                const marker = L.marker(coord, {
                    icon: icon
                });

                // Hover tooltip ringan
                marker.bindTooltip(
                    `<strong>${p.provinsi}</strong><br>${p.jumlah_lahan} Lahan • ${Number(p.total_luas).toLocaleString('id-ID')} Ha`, {
                        direction: 'top',
                        offset: [0, -10],
                        className: 'text-[10px]'
                    }
                );

                marker.on('click', () => selectProvince(p, marker));

                marker.addTo(map);
                marker._provinceData = p;
                markers.push(marker);
            });
        }

        function selectProvince(p, marker) {
            // reset active state
            document.querySelectorAll('.province-marker-dot').forEach(el => el.classList.remove('active'));
            const dot = marker.getElement()?.querySelector('.province-marker-dot');
            if (dot) dot.classList.add('active');

            activeProvince = p.provinsi;

            // isi panel
            document.getElementById('ppName').textContent = p.provinsi.toUpperCase();
            document.getElementById('ppJumlah').textContent = `${p.jumlah_lahan} Lahan`;
            document.getElementById('ppLuas').textContent = `${Number(p.total_luas).toLocaleString('id-ID')} Ha`;
            document.getElementById('ppKab').textContent = `${p.jumlah_kabupaten} Daerah`;

            // Link detail: ke halaman wilayah dengan filter provinsi
            const detailUrl = `<?php echo e(route('admin.aset.wilayah')); ?>?provinsi=${encodeURIComponent(p.provinsi)}`;
            document.getElementById('ppDetailLink').href = detailUrl;

            document.getElementById('provincePanel').classList.remove('hidden');
            document.getElementById('assetPanel')?.classList.add('hidden');
        }

        function closeProvincePanel() {
            document.getElementById('provincePanel').classList.add('hidden');
            document.getElementById('assetPanel')?.classList.add('hidden');
            document.querySelectorAll('.province-marker-dot').forEach(el => el.classList.remove('active'));
            activeProvince = null;
        }

        /* ===== PANEL INFO ASET ===== */
        function selectAsset(asset, marker) {
            // reset highlight marker lain
            document.querySelectorAll('.leaflet-interactive').forEach(el => {
                el.setAttribute('fill-opacity', '0.9');
            });
            // highlight marker yang diklik (opsional: ganti warna jadi lebih gelap)
            const el = marker.getElement();
            if (el) el.style.filter = 'drop-shadow(0 0 6px rgba(37, 99, 235, 0.8))';

            // isi panel
            document.getElementById('apName').textContent = asset.nama || 'ASET';
            document.getElementById('apLokasi').textContent = asset.provinsi ?? '-';
            document.getElementById('apLuas').textContent = `${Number(asset.luas).toLocaleString('id-ID')} Ha`;
            document.getElementById('apStatus').textContent = asset.status ?? '-';
            document.getElementById('apKab').textContent = asset.kabupaten ?? '-';

            // link detail (jika ada route detail aset)
            document.getElementById('apDetailLink').href = '#';

            // tampilkan panel aset, sembunyikan panel provinsi
            document.getElementById('assetPanel').classList.remove('hidden');
            document.getElementById('provincePanel').classList.add('hidden');
        }

        function closeAssetPanel() {
            document.getElementById('assetPanel').classList.add('hidden');
            document.querySelectorAll('.leaflet-interactive').forEach(el => {
                el.style.filter = '';
            });
        }

        /* =========================================================
           RENDER BERDASARKAN MODE
           ========================================================= */
        function renderMarkers(data) {
            if (currentMode === 'provinsi') {
                createProvinceMarkers(data);
            } else {
                createAssetMarkers(data);
                closeProvincePanel();
            }
        }

        /* =========================================================
           FILTER & SEARCH (existing, disesuaikan agar support 2 mode)
           ========================================================= */
        function applyMapFilter() {
            const status = document.getElementById('filterStatus').value;
            const provinsi = document.getElementById('filterProvinsi').value;
            const filtered = assetData.filter(asset => {
                const statusMatch = !status || asset.status === status;
                const provinsiMatch = !provinsi || asset.provinsi === provinsi;
                return statusMatch && provinsiMatch;
            });

            // Jika mode provinsi dan ada filter status, otomatis pindah ke mode aset
            // (karena status hanya relevan di level aset)
            if (currentMode === 'provinsi' && status) {
                setViewMode('aset');
            } else {
                renderMarkers(filtered);
            }

            if (filtered.length > 0) {
                const bounds = filtered.filter(a => a.lat && a.lng).map(a => [a.lat, a.lng]);
                if (bounds.length > 0) map.fitBounds(bounds, {
                    padding: [30, 30]
                });
            }
        }

        document.getElementById('searchMap').addEventListener('input', function() {
            const keyword = this.value.toLowerCase().trim();
            const filtered = assetData.filter(asset =>
                (asset.nama ?? '').toLowerCase().includes(keyword) ||
                (asset.provinsi ?? '').toLowerCase().includes(keyword) ||
                (asset.kabupaten ?? '').toLowerCase().includes(keyword)
            );
            renderMarkers(filtered);
        });

        /* =========================================================
           TOGGLE MODE TAMPILAN
           ========================================================= */
        function setViewMode(mode) {
            currentMode = mode;
            document.querySelectorAll('.view-mode-btn').forEach(btn => {
                const isActive = btn.dataset.mode === mode;
                btn.classList.toggle('bg-white', isActive);
                btn.classList.toggle('text-[#006400]', isActive);
                btn.classList.toggle('shadow-sm', isActive);
                btn.classList.toggle('text-gray-500', !isActive);
            });
            closeProvincePanel();
            renderMarkers(assetData);
        }

        document.querySelectorAll('.view-mode-btn').forEach(btn => {
            btn.addEventListener('click', () => setViewMode(btn.dataset.mode));
        });

        /* =========================================================
           RESET VIEW
           ========================================================= */
        function resetMapView() {
            map.setView([-2.5, 118.0], 5);
            document.getElementById('searchMap').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterProvinsi').value = '';
            closeProvincePanel();
            renderMarkers(assetData);
        }

        /* =========================================================
           INITIAL RENDER
           ========================================================= */
        renderMarkers(assetData);
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\badan-tanah-ui-new\resources\views/admin/aset_peta.blade.php ENDPATH**/ ?>