@extends('layouts.frontend')

@section('title', ($isEnglish ? ($halaman->judul_en ?? $halaman->judul) : $halaman->judul) . ' - Badan Bank Tanah')

@section('content')

{{-- =========================================================
    HERO / PAGE HEADER
========================================================= --}}
<section class="bg-[#0B2A4A] dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

        <div class="max-w-3xl">

            <span class="inline-flex items-center px-3 py-1 rounded-full
                         bg-white/10 text-blue-200 dark:text-blue-400 text-xs font-semibold
                         uppercase tracking-wider mb-5">
                {{ $isEnglish ? 'Land Bank Agency' : 'Badan Bank Tanah' }}
            </span>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                {{ $isEnglish ? ($halaman->judul_en ?? $halaman->judul) : $halaman->judul }}
            </h1>

            <div class="h-1 w-20 bg-blue-500 mt-5 mb-5 rounded-full"></div>

            <p class="text-blue-100 dark:text-blue-200 text-sm md:text-base leading-relaxed max-w-2xl">
                {{ $isEnglish ? 'Official and latest information regarding the activities, policies, and announcements of the Land Bank Agency.' : 'Informasi resmi dan terkini mengenai kegiatan, kebijakan, dan pengumuman Badan Bank Tanah.' }}
            </p>

        </div>

    </div>
</section>

{{-- =========================================================
    CONTENT
========================================================= --}}
<section class="bg-gray-50 dark:bg-gray-900 py-14 md:py-20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-7 md:p-10">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                {{-- KONTEN --}}
                <div class="lg:col-span-3">
                    <span class="text-blue-700 dark:text-blue-400 text-xs font-bold uppercase tracking-wider">{{ $isEnglish ? 'Information' : 'Informasi' }}</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mt-2 mb-5">
                        {{ $isEnglish ? ($halaman->judul_en ?? $halaman->judul) : $halaman->judul }}
                    </h2>
                    <div class="h-1 w-14 bg-blue-600 dark:bg-blue-500 rounded-full mb-6"></div>
                    <div class="text-gray-600 dark:text-gray-300 leading-8 text-sm md:text-base">
                        {!! nl2br(e($isEnglish ? ($halaman->isi_en ?? $halaman->isi) : $halaman->isi)) !!}
                    </div>

                    {{-- Link ke Publikasi Berita --}}
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('publications') }}" class="inline-flex items-center gap-2 text-[#006400] dark:text-green-400 hover:underline font-semibold">
                            {{ $isEnglish ? 'View All News, Press Releases & Announcements' : 'Lihat Semua Berita, Siaran Pers & Pengumuman' }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                {{-- SIDEBAR --}}
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">{{ $isEnglish ? 'Publication Categories' : 'Kategori Publikasi' }}</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('publications') }}" class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300 hover:text-[#006400] dark:hover:text-green-400 transition">
                                    <span><i class="fas fa-newspaper mr-2 text-blue-500"></i>{{ $isEnglish ? 'All Publications' : 'Semua Publikasi' }}</span>
                                    <span class="text-xs bg-gray-200 dark:bg-gray-600 px-2 py-0.5 rounded-full">12</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('publications') }}" class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300 hover:text-[#006400] dark:hover:text-green-400 transition">
                                    <span><i class="fas fa-bullhorn mr-2 text-green-500"></i>{{ $isEnglish ? 'Press Releases' : 'Siaran Pers' }}</span>
                                    <span class="text-xs bg-gray-200 dark:bg-gray-600 px-2 py-0.5 rounded-full">5</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('publications') }}" class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300 hover:text-[#006400] dark:hover:text-green-400 transition">
                                    <span><i class="fas fa-circle-info mr-2 text-orange-500"></i>{{ $isEnglish ? 'Announcements' : 'Pengumuman' }}</span>
                                    <span class="text-xs bg-gray-200 dark:bg-gray-600 px-2 py-0.5 rounded-full">3</span>
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