@extends('layouts.frontend')

@section('title', 'Profil Pimpinan - Badan Bank Tanah')

@section('content')
<section class="bg-[#0B2A4A] py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Profil Pimpinan</h1>
        <div class="h-1 w-20 bg-blue-500 mt-4 rounded-full"></div>
    </div>
</section>

<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
            <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Data profil pimpinan sedang dalam proses pembaruan.</p>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('about') }}" class="text-sm text-gray-500 hover:text-[#006400] transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Tentang
            </a>
        </div>
    </div>
</section>
@endsection