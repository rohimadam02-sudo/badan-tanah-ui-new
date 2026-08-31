@extends('layouts.frontend')

@section('title', 'Publikasi')

@section('content')

{{-- =========================================================
    HERO
========================================================= --}}
<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 text-blue-200 px-4 py-2 rounded-full text-xs font-semibold">
                <i class="fas fa-newspaper"></i>
                Publikasi Badan Bank Tanah
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mt-5">
                Informasi dan Publikasi
                <span class="text-blue-300">Resmi</span>
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed mt-5 max-w-2xl">
                Temukan berita, siaran pers, dan pengumuman resmi Badan Bank Tanah dalam satu tempat.
            </p>
        </div>
    </div>
</section>

{{-- =========================================================
    PUBLICATION
========================================================= --}}
<section class="bg-gray-50" x-data="{ activeTab: 'Berita' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

        {{-- =====================================================
            TAB
        ====================================================== --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-2 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                @foreach ([
                    ['Berita', 'fa-newspaper'],
                    ['Siaran Pers', 'fa-bullhorn'],
                    ['Pengumuman', 'fa-circle-info']
                ] as $tab)
                    <button type="button"
                        @click="activeTab = '{{ $tab[0] }}'"
                        :class="activeTab === '{{ $tab[0] }}'
                            ? 'bg-[#0B2A4A] text-white shadow-sm'
                            : 'text-gray-600 hover:bg-gray-50'"
                        class="flex items-center justify-center gap-3 px-5 py-3.5 rounded-xl text-sm font-bold transition">
                        <i class="fas {{ $tab[1] }}"></i>
                        {{ $tab[0] }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Informasi Terbaru</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mt-2">Publikasi Badan Bank Tanah</h2>
            </div>
            <p class="text-sm text-gray-500 max-w-md leading-relaxed">
                Informasi resmi dan terkini mengenai kegiatan, kebijakan, dan pengumuman Badan Bank Tanah.
            </p>
        </div>

        {{-- =====================================================
            PUBLICATION GRID
        ====================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($berita as $item)

                <article
                    x-show="activeTab === '{{ $item->kategori }}'"
                    x-transition.opacity
                    class="group bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition">

                    {{-- IMAGE --}}
                    <div class="h-56 bg-gray-100 relative overflow-hidden">

                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B2A4A] to-[#163F66]">
                                @if ($item->kategori === 'Berita')
                                    <i class="fas fa-newspaper text-5xl text-white/30"></i>
                                @elseif ($item->kategori === 'Siaran Pers')
                                    <i class="fas fa-bullhorn text-5xl text-white/30"></i>
                                @else
                                    <i class="fas fa-circle-info text-5xl text-white/30"></i>
                                @endif
                            </div>
                        @endif

                        {{-- CATEGORY BADGE --}}
                        <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 bg-white text-[#0B2A4A] text-[10px] px-3 py-1.5 rounded-md font-bold uppercase shadow-sm">
                            @if ($item->kategori === 'Berita')
                                <i class="fas fa-newspaper"></i>
                            @elseif ($item->kategori === 'Siaran Pers')
                                <i class="fas fa-bullhorn"></i>
                            @else
                                <i class="fas fa-circle-info"></i>
                            @endif
                            {{ $item->kategori }}
                        </span>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">

                        {{-- META --}}
                        <div class="flex items-center justify-between gap-3 mb-3">
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <i class="far fa-calendar"></i>
                                {{ $item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') : $item->created_at?->format('d M Y') }}
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <i class="far fa-eye"></i>
                                {{ number_format($item->views, 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- TITLE --}}
                        <h3 class="font-bold text-lg text-gray-900 leading-snug line-clamp-2 group-hover:text-[var(--color-secondary)] transition">
                            {{ $item->judul }}
                        </h3>

                        {{-- EXCERPT --}}
                        <p class="text-sm text-gray-500 leading-relaxed mt-3 line-clamp-3">
                            {{ $item->ringkasan }}
                        </p>

                        {{-- AUTHOR --}}
                        <div class="flex items-center gap-2 mt-5 pt-4 border-t border-gray-100">
                            <div class="w-7 h-7 rounded-full bg-[#0B2A4A]/10 flex items-center justify-center">
                                <i class="fas fa-user-tie text-xs text-[#0B2A4A]"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">
                                {{ $item->penulis }}
                            </span>
                        </div>

                        {{-- CTA --}}
                        <a href="{{ route('publications.show', $item->id) }}"
                           class="inline-flex items-center gap-2 mt-5 text-sm font-bold link-secondary hover:underline">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>

                    </div>

                </article>

            @endforeach

        </div>

        {{-- =====================================================
            PAGINATION
        ====================================================== --}}
        <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500">
                Menampilkan publikasi terbaru Badan Bank Tanah
            </p>
            <div class="flex items-center gap-2">
                <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-lg bg-white text-gray-400">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#0B2A4A] text-white text-sm font-bold">1</span>
                <button type="button" class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-lg bg-white text-gray-600">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>

    </div>
</section>

@endsection