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
            'label' => "Profil Persediaan\nTanah",
        ],
        [
            'route' => 'admin.aset.pengelolaan',
            'icon' => 'fa-gear',
            'label' => "Pengelolaan\nTanah",
        ],
        [
            'route' => 'admin.aset.pengembangan',
            'icon' => 'fa-chart-line',
            'label' => "Pengembangan\nTanah",
        ],
        [
            'route' => 'admin.aset.wilayah',
            'icon' => 'fa-map',
            'label' => 'Wilayah',
        ],
        [
            'route' => 'admin.aset.status',
            'icon' => 'fa-circle-check',
            'label' => "Status\nTanah",
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


<div class="overflow-x-auto">

    <div class="min-w-[900px] grid grid-cols-9
                border-b border-gray-200 mb-5">

        @foreach ($navigationItems as $item)

            @php
                $active = request()->routeIs($item['route']);
            @endphp

            <a href="{{ route($item['route']) }}"
                class="relative flex flex-col items-center
                       justify-start gap-2
                       py-3 px-2
                       border-b-2
                       transition
                       {{ $active
                            ? 'border-[#006400] text-[#006400]'
                            : 'border-transparent text-gray-500 hover:text-gray-700'
                       }}">

                <i class="fas {{ $item['icon'] }} text-sm"></i>

                <span class="text-[10px] font-semibold
                             text-center leading-tight
                             whitespace-pre-line">
                    {{ $item['label'] }}
                </span>

            </a>

        @endforeach

    </div>

</div>