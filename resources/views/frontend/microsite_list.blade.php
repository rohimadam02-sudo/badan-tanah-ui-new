@extends('layouts.frontend')

@section('title', 'Event & Microsite - Badan Bank Tanah')

@section('content')

<section class="bg-[#0B2A4A] py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 bg-white/10 text-blue-200 text-xs font-semibold px-4 py-2 rounded-full mb-4">
                <i class="fas fa-file-lines"></i>
                Event & Microsite
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-white">Event & Microsite</h1>
            <p class="text-blue-100 mt-3">Informasi event dan campaign khusus Badan Bank Tanah.</p>
            <div class="h-1 w-20 bg-blue-500 mt-4"></div>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4">

        @if($microsites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($microsites as $item)
                    <a href="{{ route('microsite.show', $item->slug) }}" 
                       class="group bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="relative h-48 bg-gray-200">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="{{ $item->judul }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B2A4A] to-[#163F66]">
                                    <i class="fas fa-file-lines text-5xl text-white/30"></i>
                                </div>
                            @endif
                            @if($item->is_featured)
                                <span class="absolute top-3 right-3 bg-yellow-400 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            @endif
                            @if($item->tanggal_mulai)
                                <span class="absolute bottom-3 left-3 bg-black/60 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                    @if($item->tanggal_selesai)
                                        - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                    @endif
                                </span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 text-lg group-hover:text-[#006400] transition line-clamp-2">
                                {{ $item->judul }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-2 line-clamp-2">
                                {{ strip_tags($item->konten) }}
                            </p>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-400">
                                    <i class="far fa-eye mr-1"></i>
                                    {{ number_format($item->views ?? 0) }}
                                </span>
                                <span class="text-xs font-semibold text-[#006400] group-hover:underline">
                                    Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 text-center text-xs text-gray-400">
                Menampilkan {{ $microsites->count() }} microsite
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-16 text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                    <i class="fas fa-file-lines text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum Ada Microsite</h3>
                <p class="text-sm text-gray-500 mt-2">Belum ada event atau microsite yang tersedia saat ini.</p>
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-[#006400] transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
            </a>
        </div>

    </div>
</section>

@endsection