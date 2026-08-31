@php
    $navigationItems = [
        [
            'route' => 'admin.aset.index',
            'icon' => 'fa-database',
            'label' => 'Data Aset',
        ],
        [
            'route' => 'admin.aset.peta',
            'icon' => 'fa-map-location-dot',
            'label' => 'Peta Interaktif',
        ],
        [
            'route' => 'admin.aset.profil',
            'icon' => 'fa-layer-group',
            'label' => 'Profil Persediaan Tanah',
        ],
        [
            'route' => 'admin.aset.pengelolaan',
            'icon' => 'fa-gear',
            'label' => 'Pengelolaan Tanah',
        ],
        [
            'route' => 'admin.aset.pengembangan',
            'icon' => 'fa-chart-line',
            'label' => 'Pengembangan Tanah',
        ],
        [
            'route' => 'admin.aset.wilayah',
            'icon' => 'fa-map',
            'label' => 'Wilayah',
        ],
        [
            'route' => 'admin.aset.status',
            'icon' => 'fa-circle-check',
            'label' => 'Status Tanah',
        ],
        [
            'route' => 'admin.aset.dokumen',
            'icon' => 'fa-file-lines',
            'label' => 'Dokumen',
        ],
        [
            'route' => 'admin.aset.statistik',
            'icon' => 'fa-chart-pie',
            'label' => 'Statistik',
        ],
    ];
@endphp

{{-- =========================================================
    NAVIGASI ASET - RESPONSIVE (FLEX-WRAP)
    ========================================================= --}}
<div class="flex flex-wrap items-center gap-1.5 border-b border-gray-200 pb-3 mb-5">
    @foreach ($navigationItems as $item)
        @php
            $active = request()->routeIs($item['route']);
        @endphp

        <a href="{{ route($item['route']) }}"
            class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition whitespace-nowrap
            {{ $active
                ? 'bg-[#006400] text-white shadow-sm'
                : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]'
            }}">
            <i class="fas {{ $item['icon'] }} text-sm"></i>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</div>