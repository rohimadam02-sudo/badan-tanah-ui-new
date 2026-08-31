@extends('layouts.admin')

@section('title', 'Tambah Halaman')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Halaman</h1>
        <a href="{{ route('admin.halaman.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">Kembali ke Daftar</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.halaman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold mb-1">Judul Halaman <span class="text-red-500">*</span></label>
                <input type="text" name="judul" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
            </div>
            
            <div>
                <label class="block text-sm font-semibold mb-1">Isi Halaman <span class="text-red-500">*</span></label>
                <textarea name="isi" rows="8" class="w-full border-gray-300 rounded-lg p-3 text-sm" required></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-semibold mb-1">Gambar Halaman</label>
                <input type="file" name="gambar" class="w-full border-gray-300 rounded-lg p-3 text-sm" accept="image/*">
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-bold text-sm">Simpan Halaman</button>
            </div>
        </form>
    </div>
</div>
@endsection