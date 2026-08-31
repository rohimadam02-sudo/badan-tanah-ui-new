@extends('layouts.frontend')

@section('title', 'Kontak')

@section('content')
<div class="bg-[#0B2A4A] py-20">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-white">Kontak</h1>
        <p class="text-blue-200 mt-3">Hubungi kami untuk informasi lebih lanjut.</p>
        <div class="h-1 w-20 bg-blue-500 mt-4"></div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Alamat</p>
                        <p class="text-sm text-gray-500">Jl. H. Juanda No. 15, Jakarta Pusat</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 text-green-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-phone text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Telepon</p>
                        <p class="text-sm text-gray-500">(021) 3456-7890</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Email</p>
                        <p class="text-sm text-gray-500">info@bantah.go.id</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('kontak.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Nama</label>
                            <input type="text" name="nama" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Email</label>
                            <input type="email" name="email" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Telepon</label>
                            <input type="text" name="telepon" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Pesan</label>
                            <textarea name="pesan" rows="5" class="w-full border-gray-300 rounded-lg p-3 text-sm" required></textarea>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-lg font-bold text-sm">Kirim Pesan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection