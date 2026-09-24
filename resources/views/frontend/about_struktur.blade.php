@extends('layouts.frontend')

@section('title', 'Struktur Organisasi - Badan Bank Tanah')

@section('content')

    {{-- ========================================================= --}}
    {{-- HERO --}}
    {{-- ========================================================= --}}
    <section class="bg-[#0B2A4A] relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg viewBox="0 0 1200 300" class="w-full h-full" preserveAspectRatio="none">
                <path d="M0,200 Q300,100 600,180 T1200,150 L1200,300 L0,300 Z" fill="#ffffff" />
                <path d="M0,250 Q300,180 600,220 T1200,200 L1200,300 L0,300 Z" fill="#ffffff" opacity="0.5" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <nav class="text-xs text-blue-200 mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 flex-wrap">
                    <li><a href="{{ route('home') }}"
                            class="hover:text-white transition">{{ session('locale') === 'en' ? 'Home' : 'Beranda' }}</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-[8px]"></i></li>
                    <li><a href="{{ route('about') }}"
                            class="hover:text-white transition">{{ session('locale') === 'en' ? 'About' : 'Tentang' }}</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-[8px]"></i></li>
                    <li class="text-white font-semibold">Struktur Organisasi</li>
                </ol>
            </nav>

            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur flex items-center justify-center">
                    <i class="fas fa-sitemap text-yellow-400 text-xl"></i>
                </div>
                <span class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-widest">
                    {{ session('locale') === 'en' ? 'About Us' : 'Tentang Kami' }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                Struktur Organisasi
            </h1>
            <div class="h-1 w-20 bg-yellow-400 mt-4 rounded-full"></div>
        </div>
    </section>

    {{-- ========================================================= --}}
    {{-- KONTEN --}}
    {{-- ========================================================= --}}
    <section class="bg-gray-50 py-1 sm:py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">

                {{-- KONTEN UTAMA --}}
                <div class="lg:col-span-3">

                    {{-- ================================================= --}}
                    {{-- STRUKTUR ORGANISASI - TREE VIEW --}}
                    {{-- ================================================= --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12 lg:p-16 min-h-[600px]">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                            <div>
                                <span class="text-blue-700 text-xs font-bold uppercase tracking-wider">Tata Kelola</span>
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Struktur Organisasi</h2>
                                <div class="h-1 w-14 bg-blue-600 rounded-full mt-4"></div>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-sitemap text-blue-700 text-lg"></i>
                            </div>
                        </div>

                        <div class="overflow-x-auto py-8">
                            @php
                                $struktur = $halaman->struktur_organisasi ?? '';
                                $lines = array_filter(explode("\n", $struktur));
                                $isList = count($lines) > 1;
                            @endphp

                            @if ($isList)
                                <div class="tree-view min-w-[800px] py-6">
                                    <div class="flex flex-col items-center">
                                        {{-- Root --}}
                                        <div
                                            class="bg-[#0B2A4A] text-white px-8 py-4 rounded-xl font-bold text-base shadow-md">
                                            {{ $lines[0] ?? 'Struktur Organisasi' }}
                                        </div>

                                        @if (count($lines) > 1)
                                            <div class="w-px h-12 bg-gray-300"></div>
                                            <div class="flex flex-wrap justify-center gap-6 gap-y-10 mt-4">
                                                @foreach (array_slice($lines, 1) as $line)
                                                    @php
                                                        $clean = trim(preg_replace('/^\d+\.\s*/', '', $line));
                                                        $colors = [
                                                            'blue',
                                                            'green',
                                                            'purple',
                                                            'orange',
                                                            'red',
                                                            'teal',
                                                            'indigo',
                                                            'pink',
                                                        ];
                                                        $color = $colors[$loop->index % count($colors)];
                                                        $bgColor = $color . '-50';
                                                        $borderColor = $color . '-200';
                                                        $textColor = $color . '-800';
                                                    @endphp
                                                    <div class="flex flex-col items-center min-w-[180px]">
                                                        <div
                                                            class="bg-{{ $bgColor }} border border-{{ $borderColor }} px-5 py-3.5 rounded-lg text-sm font-semibold text-{{ $textColor }} shadow-sm text-center">
                                                            {{ $clean }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-10">
                                    <div class="flex items-start gap-5">
                                        <div
                                            class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-users text-blue-700 text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900 text-lg mb-4">Struktur Organisasi Badan Bank
                                                Tanah</h3>
                                            <div class="text-gray-600 leading-8 text-base whitespace-pre-line">
                                                {!! nl2br(e($struktur)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                    {{-- Tombol navigasi bawah --}}
                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('about.visi-misi') }}"
                            class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-[var(--color-secondary)] transition font-medium">
                            <i class="fas fa-arrow-left"></i> Visi & Misi
                        </a>
                        <a href="{{ route('about.fungsi') }}"
                            class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-[var(--color-secondary)] transition font-medium">
                            Fungsi & Tugas <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .tree-view {
            padding: 1rem 0;
        }

        .tree-view .w-px {
            min-height: 2rem;
        }
    </style>
@endpush
