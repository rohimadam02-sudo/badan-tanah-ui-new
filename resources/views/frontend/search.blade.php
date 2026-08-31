@extends('layouts.frontend')

@section('title', 'Pencarian')

@section('content')
<div class="bg-[#0B2A4A] py-20">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-white">Pencarian</h1>
        <p class="text-blue-200 mt-3">Cari aset tanah, berita, atau informasi lainnya.</p>
        <div class="h-1 w-20 bg-blue-500 mt-4"></div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="mb-8">
        <form action="{{ route('search') }}" method="GET" class="flex gap-4">
            <input type="text" name="q" value="{{ $keyword }}" placeholder="Masukkan kata kunci..." class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B2A4A]">
            <button type="submit" class="bg-[#0B2A4A] text-white px-8 py-4 rounded-lg font-bold shrink-0">Cari</button>
        </form>
    </div>

    <!-- Hasil Pencarian -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Hasil Aset -->
        <div>
            <h2 class="text-xl font-bold mb-4">Aset Tanah ({{ count($asets) }})</h2>
            <div class="space-y-4">
                @foreach ($asets as $aset)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <h3 class="font-bold">{{ $aset->nama_lokasi }}</h3>
                    <p class="text-sm text-gray-500">{{ $aset->provinsi }}</p>
                    <a href="{{ route('assets.show', $aset->id) }}" class="text-sm text-[#0B2A4A] font-bold">Baca Selengkapnya</a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Hasil Berita -->
        <div>
            <h2 class="text-xl font-bold mb-4">Publikasi ({{ count($berita) }})</h2>
            <div class="space-y-4">
                @foreach ($berita as $item)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <h3 class="font-bold">{{ $item->judul }}</h3>
                    <p class="text-sm text-gray-500">{{ $item->kategori }}</p>
                    <a href="{{ route('publications.show', $item->id) }}" class="text-sm text-[#0B2A4A] font-bold">Baca Selengkapnya</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection