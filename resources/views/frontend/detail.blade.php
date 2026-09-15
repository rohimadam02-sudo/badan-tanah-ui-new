@extends('layouts.frontend')

@section('title', $aset->nama_lokasi)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Gambar Aset -->
        <div>
            <div class="rounded-2xl overflow-hidden shadow-lg">
                <img src="https://picsum.photos/800/600?random=1" class="w-full h-[400px] object-cover" alt="">
            </div>
        </div>

        <!-- Informasi Detail -->
        <div>
            <span class="text-[#006400] font-bold text-sm uppercase tracking-widest">Aset Persediaan Tanah</span>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $aset->nama_lokasi }}</h1>
            <p class="text-sm text-gray-500 mt-2">{{ $aset->provinsi }}, {{ $aset->kabupaten }}</p>

            <div class="mt-6 grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Luas Tanah</p>
                    <p class="text-2xl font-bold text-[#006400]">{{ number_format($aset->luas_hektar, 2, ',', '.') }} Ha</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="text-lg font-bold">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded font-bold">{{ $aset->status }}</span>
                    </p>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="font-bold text-lg mb-4">Lokasi Peta</h3>
                <div id="map" class="h-[350px] rounded-2xl shadow-lg border border-gray-200"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var map = L.map('map').setView([{{ $aset->lat }}, {{ $aset->lng }}], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([{{ $aset->lat }}, {{ $aset->lng }}]).addTo(map)
        .bindPopup('<b>{{ $aset->nama_lokasi }}</b>');
</script>
@endpush