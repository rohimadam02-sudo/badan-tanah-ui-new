@extends('layouts.admin')

@section('title', 'Aset Persediaan Tanah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Halaman -->
        <div class="flex items-start gap-4 mb-6">
            <div class="w-14 h-14 bg-green-100 text-[#006400] rounded-full flex items-center justify-center">
                <i class="fas fa-map-marked-alt text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Aset Persediaan Tanah</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data aset persediaan tanah Badan Bank Tanah.</p>
            </div>
        </div>

        <!-- Tab Navigasi Aset (SEMUA TERHUBUNG) -->

        <!-- TAB NAVIGASI ASET -->
        <div class="grid grid-cols-9 border-b border-gray-200 mb-6">

            <!-- DATA ASET -->
            <a href="{{ route('admin.aset.index') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-[#006400]
               text-[#006400]
               font-semibold text-[11px]
               text-center leading-tight">

                <i class="fas fa-database text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Data Aset
                </span>

            </a>


            <!-- PETA INTERAKTIF -->
            <a href="{{ route('admin.aset.peta') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-transparent
               text-gray-500 hover:text-gray-700
               font-semibold text-[11px]
               text-center leading-tight transition">

                <i class="fas fa-map-location-dot text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Peta Interaktif
                </span>

            </a>


            <!-- PROFIL PERSEDIAAN -->
            <a href="{{ route('admin.aset.profil') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-transparent
               text-gray-500 hover:text-gray-700
               font-semibold text-[11px]
               text-center leading-tight transition">

                <i class="fas fa-layer-group text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Profil Persediaan
                    <br>
                    Tanah
                </span>

            </a>


            <!-- PENGELOLAAN -->
            <a href="{{ route('admin.aset.pengelolaan') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-transparent
               text-gray-500 hover:text-gray-700
               font-semibold text-[11px]
               text-center leading-tight transition">

                <i class="fas fa-gear text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Pengelolaan
                    <br>
                    Tanah
                </span>

            </a>


            <!-- PENGEMBANGAN -->
            <a href="{{ route('admin.aset.pengembangan') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-transparent
               text-gray-500 hover:text-gray-700
               font-semibold text-[11px]
               text-center leading-tight transition">

                <i class="fas fa-chart-line text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Pengembangan
                    <br>
                    Tanah
                </span>

            </a>


            <!-- WILAYAH -->
            <a href="{{ route('admin.aset.wilayah') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-transparent
               text-gray-500 hover:text-gray-700
               font-semibold text-[11px]
               text-center leading-tight transition">

                <i class="fas fa-map text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Wilayah
                </span>

            </a>


            <!-- STATUS TANAH -->
            <a href="{{ route('admin.aset.status') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-transparent
               text-gray-500 hover:text-gray-700
               font-semibold text-[11px]
               text-center leading-tight transition">

                <i class="fas fa-circle-check text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Status
                    <br>
                    Tanah
                </span>

            </a>


            <!-- DOKUMEN -->
            <a href="{{ route('admin.aset.dokumen') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-transparent
               text-gray-500 hover:text-gray-700
               font-semibold text-[11px]
               text-center leading-tight transition">

                <i class="fas fa-file-lines text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Dokumen
                </span>

            </a>


            <!-- STATISTIK -->
            <a href="{{ route('admin.aset.statistik') }}"
                class="flex flex-col items-center justify-start
               gap-2 py-3 px-2 min-w-0
               border-b-2 border-transparent
               text-gray-500 hover:text-gray-700
               font-semibold text-[11px]
               text-center leading-tight transition">

                <i class="fas fa-chart-pie text-sm flex-shrink-0"></i>

                <span class="w-full">
                    Statistik
                </span>

            </a>

        </div>


        <!-- KARTU STATISTIK ASET -->
        <div class="grid grid-cols-5 gap-3 mb-6">

            <!-- TOTAL ASET -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100 min-w-0">
                <div class="flex items-center gap-2">

                    <div
                        class="w-8 h-8 rounded-full bg-green-50
                        flex items-center justify-center shrink-0">
                        <i class="fas fa-layer-group text-green-600 text-xs"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[9px] text-gray-500 truncate">
                            Total Aset
                        </p>

                        <p class="text-sm font-bold text-gray-900 leading-tight">
                            {{ $totalAset }}
                        </p>

                        <p class="text-[8px] text-green-600 truncate">
                            Data aset terdaftar
                        </p>
                    </div>

                </div>
            </div>


            <!-- LOKASI ASET -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100 min-w-0">
                <div class="flex items-center gap-2">

                    <div
                        class="w-8 h-8 rounded-full bg-blue-50
                        flex items-center justify-center shrink-0">
                        <i class="fas fa-location-dot text-blue-600 text-xs"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[9px] text-gray-500 truncate">
                            Lokasi Aset
                        </p>

                        <p class="text-sm font-bold text-gray-900 leading-tight">
                            1.248
                        </p>

                        <p class="text-[8px] text-blue-600 truncate">
                            Lokasi terdata
                        </p>
                    </div>

                </div>
            </div>


            <!-- WILAYAH -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100 min-w-0">
                <div class="flex items-center gap-2">

                    <div
                        class="w-8 h-8 rounded-full bg-yellow-50
                        flex items-center justify-center shrink-0">
                        <i class="fas fa-map text-yellow-600 text-xs"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[9px] text-gray-500 truncate">
                            Wilayah
                        </p>

                        <p class="text-sm font-bold text-gray-900 leading-tight">
                            18
                        </p>

                        <p class="text-[8px] text-yellow-600 truncate">
                            Wilayah terdata
                        </p>
                    </div>

                </div>
            </div>


            <!-- KABUPATEN / KOTA -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100 min-w-0">
                <div class="flex items-center gap-2">

                    <div
                        class="w-8 h-8 rounded-full bg-purple-50
                        flex items-center justify-center shrink-0">
                        <i class="fas fa-city text-purple-600 text-xs"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[9px] text-gray-500 truncate">
                            Kabupaten/Kota
                        </p>

                        <p class="text-sm font-bold text-gray-900 leading-tight">
                            56
                        </p>

                        <p class="text-[8px] text-purple-600 truncate">
                            Daerah terdata
                        </p>
                    </div>

                </div>
            </div>


            <!-- NILAI INDIKATIF -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100 min-w-0">
                <div class="flex items-center gap-2">

                    <div
                        class="w-8 h-8 rounded-full bg-teal-50
                        flex items-center justify-center shrink-0">
                        <i class="fas fa-money-bill-trend-up text-teal-600 text-xs"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-[9px] text-gray-500 truncate">
                            Nilai Indikatif
                        </p>

                        <p class="text-sm font-bold text-gray-900 leading-tight whitespace-nowrap">
                            Rp 68,45 T
                        </p>

                        <p class="text-[8px] text-teal-600 truncate">
                            Nilai estimasi aset
                        </p>
                    </div>

                </div>
            </div>

        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Aset Tabel -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Daftar Aset Persediaan Tanah</h3>
                <a href="{{ route('admin.aset.create') }}"
                    class="bg-[#006400] hover:bg-[#005500] text-white px-4 py-2 rounded text-sm font-bold">+ Tambah Aset</a>
            </div>
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-gray-600">Kode Aset</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Nama Lokasi</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Provinsi</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Kabupaten</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Luas (Ha)</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-gray-100">
                    @foreach ($asets as $aset)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">BT-2025-{{ sprintf('%04d', $aset->id) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($aset->gambar)
                                        <img src="{{ asset('storage/' . $aset->gambar) }}"
                                            class="w-10 h-10 rounded object-cover">
                                    @else
                                        <img src="https://picsum.photos/50/50?random={{ $loop->index }}"
                                            class="w-10 h-10 rounded object-cover">
                                    @endif
                                    <span class="font-medium">{{ $aset->nama_lokasi }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $aset->provinsi }}</td>
                            <td class="px-6 py-4">{{ $aset->kabupaten }}</td>
                            <td class="px-6 py-4">{{ number_format($aset->luas_hektar, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">{{ $aset->status }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2 text-gray-500">
                                    <a href="{{ route('admin.aset.edit', $aset->id) }}" class="hover:text-[#006400]"><i
                                            class="fas fa-pen"></i></a>
                                    <form action="{{ route('admin.aset.destroy', $aset->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-red-600"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
