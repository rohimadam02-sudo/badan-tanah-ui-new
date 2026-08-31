@extends('layouts.admin')

@section('title', 'Statistik')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-5">
        <h1 class="text-xl font-bold text-gray-900">Aset Persediaan Tanah</h1>
        <p class="text-[10px] text-gray-500 mt-1">Kelola dan pantau informasi persediaan tanah.</p>
    </div>

    {{-- NAVIGASI ASET --}}
    <div class="overflow-x-auto">
        @include('admin.aset._navigation')
    </div>

    {{-- HEADER STATISTIK --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-5">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-[#006400] flex items-center justify-center flex-shrink-0">
                <i class="fas fa-chart-column text-xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-bold text-gray-900">Statistik Aset</h2>
                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Ringkasan statistik persediaan tanah.</p>
            </div>
        </div>
    </div>

    {{-- STATISTIK UTAMA - DATA REAL --}}
    @php
        $totalAset = \App\Models\AsetTanah::count();
        $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
        $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
        $totalKabupaten = \App\Models\AsetTanah::distinct('kabupaten')->count('kabupaten');
        $totalTersedia = \App\Models\AsetTanah::where('status', 'Tersedia')->count();
        $totalPengembangan = \App\Models\AsetTanah::where('status', 'Dalam Pengembangan')->count();
        $totalProses = \App\Models\AsetTanah::where('status', 'Dalam Proses')->count();
        $totalTerikat = \App\Models\AsetTanah::where('status', 'Terikat')->count();

        $peruntukanData = \App\Models\AsetTanah::select('peruntukan', \DB::raw('count(*) as total'))
            ->whereNotNull('peruntukan')
            ->groupBy('peruntukan')
            ->get();

        $skemaData = \App\Models\AsetTanah::select('skema', \DB::raw('count(*) as total'))
            ->whereNotNull('skema')
            ->groupBy('skema')
            ->get();

        $provinsiData = \App\Models\AsetTanah::select('provinsi', \DB::raw('count(*) as total'), \DB::raw('sum(luas_hektar) as total_luas'))
            ->groupBy('provinsi')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $maxTotal = $peruntukanData->max('total') ?: 1;
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Total Aset</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($totalAset) }}</h3>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Total Luas</p>
            <h3 class="text-2xl font-bold text-green-600 mt-2">{{ number_format($totalLuas, 2, ',', '.') }} Ha</h3>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Provinsi</p>
            <h3 class="text-2xl font-bold text-blue-600 mt-2">{{ number_format($totalProvinsi) }}</h3>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
            <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Kabupaten/Kota</p>
            <h3 class="text-2xl font-bold text-purple-600 mt-2">{{ number_format($totalKabupaten) }}</h3>
        </div>
    </div>

    {{-- STATUS ASET --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
            <p class="text-[8px] text-green-600">Tersedia</p>
            <p class="text-xl font-bold text-green-700">{{ number_format($totalTersedia) }}</p>
            <p class="text-[8px] text-green-500">{{ $totalAset > 0 ? round(($totalTersedia / $totalAset) * 100) : 0 }}%</p>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
            <p class="text-[8px] text-blue-600">Dalam Pengembangan</p>
            <p class="text-xl font-bold text-blue-700">{{ number_format($totalPengembangan) }}</p>
            <p class="text-[8px] text-blue-500">{{ $totalAset > 0 ? round(($totalPengembangan / $totalAset) * 100) : 0 }}%</p>
        </div>
        <div class="bg-orange-50 border border-orange-100 rounded-xl p-4">
            <p class="text-[8px] text-orange-600">Dalam Proses</p>
            <p class="text-xl font-bold text-orange-700">{{ number_format($totalProses) }}</p>
            <p class="text-[8px] text-orange-500">{{ $totalAset > 0 ? round(($totalProses / $totalAset) * 100) : 0 }}%</p>
        </div>
        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
            <p class="text-[8px] text-gray-600">Terikat</p>
            <p class="text-xl font-bold text-gray-700">{{ number_format($totalTerikat) }}</p>
            <p class="text-[8px] text-gray-500">{{ $totalAset > 0 ? round(($totalTerikat / $totalAset) * 100) : 0 }}%</p>
        </div>
    </div>

    {{-- SEBARAN PERUNTUKAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-900">Sebaran Peruntukan</h2>
            </div>
            <div class="p-5 space-y-4">
                @forelse ($peruntukanData as $item)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-semibold text-gray-700">{{ $item->peruntukan }}</span>
                            <span class="text-[10px] font-bold text-gray-900">{{ number_format($item->total) }}</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-blue-500" style="width: {{ $maxTotal > 0 ? ($item->total / $maxTotal) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 py-4">Belum ada data peruntukan.</p>
                @endforelse
            </div>
        </div>

        {{-- SEBARAN SKEMA --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-900">Sebaran Skema</h2>
            </div>
            <div class="p-5 space-y-4">
                @forelse ($skemaData as $item)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-semibold text-gray-700">{{ $item->skema }}</span>
                            <span class="text-[10px] font-bold text-gray-900">{{ number_format($item->total) }}</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-green-500" style="width: {{ $maxTotal > 0 ? ($item->total / $maxTotal) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 py-4">Belum ada data skema.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- RINGKASAN WILAYAH --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-900">Ringkasan Sebaran Wilayah</h2>
            <a href="{{ route('admin.aset.wilayah') }}" class="text-[9px] font-semibold text-[#006400] hover:underline">
                Lihat Wilayah <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Provinsi</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Jumlah Aset</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Total Luas</th>
                        <th class="px-5 py-3 text-[10px] font-bold text-gray-500">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($provinsiData as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4 text-[10px] font-semibold text-gray-800">{{ $item->provinsi }}</td>
                            <td class="px-5 py-4 text-[10px] text-gray-600">{{ number_format($item->total) }}</td>
                            <td class="px-5 py-4 text-[10px] text-gray-600">{{ number_format($item->total_luas, 0, ',', '.') }} Ha</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#006400] rounded-full" style="width: {{ $totalAset > 0 ? ($item->total / $totalAset) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-[9px] font-semibold text-gray-600">{{ $totalAset > 0 ? round(($item->total / $totalAset) * 100) : 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400">Belum ada data wilayah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[8px] text-gray-400">Menampilkan 5 provinsi teratas</p>
            <a href="{{ route('admin.aset.index') }}" class="text-[9px] font-semibold text-[#006400] hover:underline">
                Kelola seluruh aset <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

</div>

@endsection