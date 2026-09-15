@extends('layouts.admin')

@section('title', 'Dokumen Kerjasama')

@section('content')

@php
    $role = auth()->user()->role;
    $isAdmin = in_array($role, ['super_admin', 'admin']);
@endphp

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dokumen Kerjasama</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola dokumen booklet dan informasi kerjasama.</p>
    </div>
    @if ($isAdmin)
        <a href="{{ route('admin.dokumen-kerjasama.create') }}" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i>
            Upload Dokumen
        </a>
    @endif
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total Dokumen</p>
                <p class="text-2xl font-bold text-gray-900">{{ $dokumen->count() }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-file-pdf text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Booklet</p>
                <p class="text-2xl font-bold text-blue-600">{{ $dokumen->where('kategori', 'booklet')->count() }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-book text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Aktif</p>
                <p class="text-2xl font-bold text-green-600">{{ $dokumen->where('is_active', true)->count() }}</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                <i class="fas fa-circle-check text-green-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Daftar Dokumen</h2>
            <p class="text-[10px] text-gray-400 mt-0.5">Kelola dokumen booklet dan informasi kerjasama.</p>
        </div>
        <div class="text-xs text-gray-400">
            {{ $dokumen->count() }} dokumen
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Ukuran</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($dokumen as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->judul }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            {{ $item->kategori == 'booklet' ? 'bg-blue-50 text-blue-700' :
                               ($item->kategori == 'panduan' ? 'bg-green-50 text-green-700' :
                               ($item->kategori == 'brosur' ? 'bg-purple-50 text-purple-700' :
                               'bg-gray-50 text-gray-500')) }}">
                            {{ ucfirst($item->kategori) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->ukuran ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            {{ $item->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-500' }}">
                            {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.dokumen-kerjasama.download', $item->id) }}" 
                               class="text-green-600 hover:text-green-800 text-sm font-bold" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                            @if ($isAdmin)
                                <a href="{{ route('admin.dokumen-kerjasama.edit', $item->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-bold" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.dokumen-kerjasama.destroy', $item->id) }}" method="POST" 
                                      class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-file-pdf text-3xl text-gray-300 block mb-3"></i>
                        <p class="text-sm">Belum ada dokumen.</p>
                        @if ($isAdmin)
                            <a href="{{ route('admin.dokumen-kerjasama.create') }}" class="text-[#006400] hover:underline text-sm font-semibold">Upload dokumen</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-[10px] text-gray-400">Menampilkan {{ $dokumen->count() }} dokumen</p>
        <div class="flex items-center gap-2">
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition disabled:opacity-50" disabled>
                <i class="fas fa-chevron-left text-xs"></i>
            </button>
            <span class="text-xs font-medium text-gray-700">1</span>
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition disabled:opacity-50" disabled>
                <i class="fas fa-chevron-right text-xs"></i>
            </button>
        </div>
    </div>
</div>
@endsection