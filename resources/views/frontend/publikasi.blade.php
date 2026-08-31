@extends('layouts.frontend')

@section('title', $halaman->judul . ' - Badan Bank Tanah')

@section('content')

{{-- =========================================================
    HERO / PAGE HEADER
========================================================= --}}
<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

        <div class="max-w-3xl">

            <span class="inline-flex items-center px-3 py-1 rounded-full
                         bg-white/10 text-blue-200 text-xs font-semibold
                         uppercase tracking-wider mb-5">
                Badan Bank Tanah
            </span>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                {{ $halaman->judul }}
            </h1>

            <div class="h-1 w-20 bg-blue-500 mt-5 mb-5 rounded-full"></div>

            <p class="text-blue-100 text-sm md:text-base leading-relaxed max-w-2xl">
                Informasi resmi dan terkini mengenai kegiatan, kebijakan, dan pengumuman Badan Bank Tanah.
            </p>

        </div>

    </div>
</section>

{{-- =========================================================
    CONTENT
========================================================= --}}
<section class="bg-gray-50 py-14 md:py-20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 md:p-10">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                {{-- KONTEN --}}
                <div class="lg:col-span-3">
                    <span class="text-blue-700 text-xs font-bold uppercase tracking-wider">Informasi</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2 mb-5">{{ $halaman->judul }}</h2>
                    <div class="h-1 w-14 bg-blue-600 rounded-full mb-6"></div>
                    <div class="text-gray-600 leading-8 text-sm md:text-base">
                        {!! nl2br(e($halaman->isi)) !!}
                    </div>

                    {{-- Link ke Publikasi Berita --}}
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <a href="{{ route('publications') }}" class="inline-flex items-center gap-2 text-[#006400] hover:underline font-semibold">
                            Lihat Semua Berita, Siaran Pers & Pengumuman
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                {{-- SIDEBAR --}}
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Kategori Publikasi</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('publications') }}" class="flex items-center justify-between text-sm text-gray-600 hover:text-[#006400] transition">
                                    <span><i class="fas fa-newspaper mr-2 text-blue-500"></i>Semua Publikasi</span>
                                    <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">12</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('publications') }}" class="flex items-center justify-between text-sm text-gray-600 hover:text-[#006400] transition">
                                    <span><i class="fas fa-bullhorn mr-2 text-green-500"></i>Siaran Pers</span>
                                    <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">5</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('publications') }}" class="flex items-center justify-between text-sm text-gray-600 hover:text-[#006400] transition">
                                    <span><i class="fas fa-circle-info mr-2 text-orange-500"></i>Pengumuman</span>
                                    <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">3</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>

@endsection