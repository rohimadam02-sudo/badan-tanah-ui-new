@extends('layouts.frontend')

@section('title', 'Fungsi & Tugas - Badan Bank Tanah')

@section('content')
<section class="bg-[#0B2A4A] py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white">Fungsi & Tugas</h1>
        <div class="h-1 w-20 bg-blue-500 mt-4 rounded-full"></div>
    </div>
</section>

<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <p class="text-gray-600 mb-4">Fungsi dan tugas Badan Bank Tanah:</p>
            <ul class="list-disc ml-6 space-y-2 text-gray-600">
                <li>Mengelola aset tanah negara secara profesional</li>
                <li>Menyediakan tanah untuk kepentingan umum</li>
                <li>Mendukung program Reforma Agraria</li>
                <li>Mengoptimalkan pemanfaatan tanah negara</li>
            </ul>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('about') }}" class="text-sm text-gray-500 hover:text-[#006400] transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Tentang
            </a>
        </div>
    </div>
</section>
@endsection