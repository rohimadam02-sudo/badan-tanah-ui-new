@extends('layouts.admin')

@section('title', 'Menu Navigasi')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Menu Navigasi</h1>
        <p class="text-sm text-gray-500 mt-1">Atur menu navigasi yang tampil di website.</p>
    </div>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <form action="{{ route('admin.menu_navigasi.update') }}" method="POST">
        @csrf
        <div class="space-y-4">
            @foreach ($menu as $item)
            <div class="flex items-center gap-4 border border-gray-200 rounded-lg p-4">
                <i class="fas fa-grip-vertical text-gray-400"></i>
                <div>
                    <p class="font-bold text-sm">{{ $item->nama }}</p>
                    <p class="text-xs text-gray-500">{{ $item->link }}</p>
                </div>
                <div class="ml-auto flex items-center gap-2">
                    <span class="text-xs text-gray-400">Status:</span>
                    <select name="menu[{{ $item->id }}][status]" class="border border-gray-300 rounded p-2 text-sm">
                        <option value="Aktif" {{ $item->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $item->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-bold text-sm">Simpan Menu</button>
        </div>
    </form>
</div>
@endsection