@extends('layouts.admin')

@section('title', 'Peta Interaktif')

@section('content')

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
        <a href="{{ route('admin.aset.index') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.index') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-database text-sm"></i>
            <span>Data Aset</span>
        </a>

        <a href="{{ route('admin.aset.peta') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.peta') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-map-location-dot text-sm"></i>
            <span>Peta Interaktif</span>
        </a>

        <a href="{{ route('admin.aset.profil') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.profil') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-layer-group text-sm"></i>
            <span>Profil Persediaan Tanah</span>
        </a>

        <a href="{{ route('admin.aset.pengelolaan') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.pengelolaan') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-gear text-sm"></i>
            <span>Pengelolaan Tanah</span>
        </a>

        <a href="{{ route('admin.aset.pengembangan') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.pengembangan') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-chart-line text-sm"></i>
            <span>Pengembangan Tanah</span>
        </a>

        <a href="{{ route('admin.aset.wilayah') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.wilayah') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-map text-sm"></i>
            <span>Wilayah</span>
        </a>

        <a href="{{ route('admin.aset.status') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.status') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-circle-check text-sm"></i>
            <span>Status Tanah</span>
        </a>

        <a href="{{ route('admin.aset.dokumen') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.dokumen') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-file-lines text-sm"></i>
            <span>Dokumen</span>
        </a>

        <a href="{{ route('admin.aset.statistik') }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('admin.aset.statistik') ? 'bg-[#006400] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' }}">
            <i class="fas fa-chart-pie text-sm"></i>
            <span>Statistik</span>
        </a>
    </div>

    <!-- KARTU STATISTIK - DATA REAL -->
    @php
        $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
        $totalAset = \App\Models\AsetTanah::count();
        $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
        $totalKabupaten = \App\Models\AsetTanah::distinct('kabupaten')->count('kabupaten');
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-5">
        <!-- TOTAL LUAS -->
        <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-database text-green-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-[8px] text-gray-500">Total Luas</p>
                    <p class="text-sm font-bold text-gray-900">{{ number_format($totalLuas, 2, ',', '.') }} Ha</p>
                    <p class="text-[7px] text-gray-400">Seluruh aset</p>
                </div>
            </div>
        </div>

        <!-- TOTAL ASET -->
        <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-layer-group text-blue-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-[8px] text-gray-500">Total Aset</p>
                    <p class="text-sm font-bold text-gray-900">{{ number_format($totalAset) }}</p>
                    <p class="text-[7px] text-gray-400">Aset terdaftar</p>
                </div>
            </div>
        </div>

        <!-- PROVINSI -->
        <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-map text-purple-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-[8px] text-gray-500">Provinsi</p>
                    <p class="text-sm font-bold text-gray-900">{{ number_format($totalProvinsi) }}</p>
                    <p class="text-[7px] text-gray-400">Wilayah terdata</p>
                </div>
            </div>
        </div>

        <!-- KABUPATEN -->
        <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-city text-orange-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-[8px] text-gray-500">Kabupaten/Kota</p>
                    <p class="text-sm font-bold text-gray-900">{{ number_format($totalKabupaten) }}</p>
                    <p class="text-[7px] text-gray-400">Daerah terdata</p>
                </div>
            </div>
        </div>

        <!-- NILAI INDIKATIF -->
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
                        <p class="text-[9px] text-gray-400 mt-0.5">Lokasi aset persediaan tanah</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <i class="fas fa-search absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 text-[9px]"></i>
                            <input type="text" id="searchMap" placeholder="Cari lokasi..."
                                class="w-32 pl-6 pr-2 py-1.5 text-[9px] border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>
                        <button type="button" onclick="map.setView([-2.5,118],5)"
                            class="px-2.5 py-1.5 text-[9px] border border-gray-200 rounded-md text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-crosshairs mr-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div id="map" class="h-[470px] w-full"></div>

            <div class="px-4 py-3 border-t border-gray-100">
                <div class="flex items-center gap-6">
                    <span class="text-[9px] font-semibold text-gray-500">Legenda Status Tanah</span>
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
        <div class="space-y-4">
            <!-- RINGKASAN PROVINSI - DATA REAL -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-xs font-bold text-gray-900">Ringkasan Per Provinsi</h2>
                    <a href="{{ route('admin.aset.wilayah') }}" class="text-[8px] text-blue-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="p-4 space-y-3">
                    @php
                        $provinsiData = \App\Models\AsetTanah::select('provinsi', \DB::raw('sum(luas_hektar) as total_luas'))
                            ->groupBy('provinsi')
                            ->orderBy('total_luas', 'desc')
                            ->take(5)
                            ->get();
                        $maxLuas = $provinsiData->max('total_luas') ?: 1;
                    @endphp
                    @forelse ($provinsiData as $item)
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[9px] font-semibold text-gray-600">{{ $item->provinsi }}</span>
                                <span class="text-[8px] text-gray-400">{{ number_format($item->total_luas, 0, ',', '.') }} Ha</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-[#006400] rounded-full" style="width: {{ min(100, ($item->total_luas / $maxLuas) * 100) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-[9px] text-gray-400">Belum ada data provinsi.</p>
                    @endforelse
                </div>
            </div>

            <!-- FILTER PETA - DATA REAL -->
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
                            @php
                                $provinsiList = \App\Models\AsetTanah::distinct('provinsi')->pluck('provinsi')->sort();
                            @endphp
                            @foreach ($provinsiList as $provinsi)
                                <option value="{{ $provinsi }}">{{ $provinsi }}</option>
                            @endforeach
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

<script>
    // DATA ASET DARI LARAVEL
    const assetData = [
        @foreach ($asets as $aset)
            {
                id: {{ $aset->id }},
                nama: @json($aset->nama_lokasi),
                provinsi: @json($aset->provinsi),
                luas: {{ $aset->luas_hektar ?? 0 }},
                status: @json($aset->status),
                lat: {{ $aset->lat ?? 0 }},
                lng: {{ $aset->lng ?? 0 }}
            },
        @endforeach
    ];

    // INISIALISASI MAP
    const map = L.map('map').setView([-2.5, 118.0], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // MARKER
    let markers = [];

    function getMarkerColor(status) {
        if (status === 'Tersedia') return '#16a34a';
        if (status === 'Dalam Pengembangan') return '#2563eb';
        if (status === 'Dalam Proses') return '#f97316';
        if (status === 'Terikat') return '#6b7280';
        return '#6b7280';
    }

    function createMarkers(data = assetData) {
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];

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
            marker.bindPopup(`
                <div style="min-width:180px">
                    <strong>${asset.nama}</strong><br>
                    <span>${asset.provinsi ?? '-'}</span><br>
                    <strong>${Number(asset.luas).toLocaleString('id-ID')} Ha</strong><br>
                    <span style="color:${color};font-weight:600">${asset.status ?? '-'}</span>
                </div>
            `);
            marker.addTo(map);
            markers.push(marker);
        });
    }

    createMarkers();

    // FILTER
    function applyMapFilter() {
        const status = document.getElementById('filterStatus').value;
        const provinsi = document.getElementById('filterProvinsi').value;
        const filtered = assetData.filter(asset => {
            const statusMatch = !status || asset.status === status;
            const provinsiMatch = !provinsi || asset.provinsi === provinsi;
            return statusMatch && provinsiMatch;
        });
        createMarkers(filtered);
        if (filtered.length > 0) {
            const bounds = filtered.filter(asset => asset.lat && asset.lng).map(asset => [asset.lat, asset.lng]);
            if (bounds.length > 0) map.fitBounds(bounds, { padding: [30, 30] });
        }
    }

    // SEARCH
    document.getElementById('searchMap').addEventListener('input', function() {
        const keyword = this.value.toLowerCase().trim();
        const filtered = assetData.filter(asset =>
            (asset.nama ?? '').toLowerCase().includes(keyword) ||
            (asset.provinsi ?? '').toLowerCase().includes(keyword)
        );
        createMarkers(filtered);
    });
</script>

@endsection