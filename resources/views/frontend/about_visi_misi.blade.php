@extends('layouts.frontend')

@section('title', 'Visi & Misi - Badan Bank Tanah')

@section('content')
<section class="bg-[#0B2A4A] py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Visi & Misi</h1>
        <div class="h-1 w-20 bg-blue-500 mt-4 rounded-full"></div>
    </div>
</section>

<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Visi</h2>
                <div class="border-l-4 border-blue-600 pl-5">
                    <p class="text-gray-600 leading-relaxed">
                        {!! nl2br(e($halaman->visi ?? 'Visi Badan Bank Tanah belum diisi.')) !!}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Misi</h2>
                <div class="border-l-4 border-green-600 pl-5">
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                        {!! nl2br(e($halaman->misi ?? 'Misi Badan Bank Tanah belum diisi.')) !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('about') }}" class="text-sm text-gray-500 hover:text-[#006400] transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Tentang
            </a>
        </div>
    </div>
</section>
@endsection