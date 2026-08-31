@extends('layouts.admin')

@section('title', 'Berita')

@section('content')

@php
    $role = auth()->user()->role;
    $isAdmin = in_array($role, ['super_admin', 'admin']);
    $isEditor = $role == 'editor';
    $isPublisher = $role == 'publisher';
    $isSuperAdmin = $role == 'super_admin';

    // Tentukan judul halaman berdasarkan route
    $pageTitle = 'Berita';
    if (request()->routeIs('admin.berita.siaran_pers')) {
        $pageTitle = 'Siaran Pers';
    } elseif (request()->routeIs('admin.berita.pengumuman')) {
        $pageTitle = 'Pengumuman';
    }
@endphp

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle }}</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola dan atur {{ strtolower($pageTitle) }} yang ditampilkan di website.</p>
    </div>

    <!-- TAMBAH BERITA (Admin & Super Admin & Editor) -->
    @if (in_array($role, ['super_admin', 'admin', 'editor']))
        <a href="{{ route('admin.berita.create') }}" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i>
            Tambah {{ $pageTitle == 'Berita' ? 'Berita' : $pageTitle }}
        </a>
    @endif
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="px-6 py-3 font-semibold text-gray-700">Judul</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Kategori</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Dilihat</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Status Approval</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($berita as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                @if ($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover" alt="{{ $item->judul }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#0B2A4A]/5">
                                        <i class="fas fa-newspaper text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                            </div>
                            <span class="font-medium text-gray-900 line-clamp-2">{{ $item->judul }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold
                            {{ $item->kategori == 'Siaran Pers' ? 'bg-blue-50 text-blue-700' :
                               ($item->kategori == 'Pengumuman' ? 'bg-orange-50 text-orange-700' :
                               'bg-green-50 text-green-700') }}">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5 text-sm">
                            <i class="far fa-eye text-gray-400"></i>
                            <span class="font-semibold text-gray-700">{{ number_format($item->views ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if ($item->status_approval == 'Draft')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">Draft</span>
                        @elseif ($item->status_approval == 'Menunggu Approval')
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-bold">Menunggu Approval</span>
                        @elseif ($item->status_approval == 'Disetujui')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Disetujui</span>
                        @elseif ($item->status_approval == 'Dipublikasikan')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold">Dipublikasikan</span>
                        @elseif ($item->status_approval == 'Arsip')
                            <span class="bg-gray-300 text-gray-700 px-2 py-1 rounded text-xs font-bold line-through">Arsip</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold">{{ $item->status_approval ?? 'Draft' }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2 flex-wrap">

                            <!-- ========================================= -->
                            <!-- EDIT (Semua role yang bisa edit) -->
                            <!-- ========================================= -->
                            @if ($isSuperAdmin || $isAdmin || $isPublisher || ($isEditor && $item->penulis == auth()->user()->name))
                                <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold">Edit</a>
                            @endif

                            <!-- ========================================= -->
                            <!-- SUBMIT (Editor, Admin, Super Admin) -->
                            <!-- ========================================= -->
                            @if (in_array($role, ['editor', 'admin', 'super_admin']) && $item->status_approval == 'Draft')
                                <form action="{{ route('admin.berita.submit', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Submit berita ini?')">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 text-sm font-bold">Submit</button>
                                </form>
                            @endif

                            <!-- ========================================= -->
                            <!-- APPROVE (Publisher, Admin, Super Admin) -->
                            <!-- ========================================= -->
                            @if (in_array($role, ['publisher', 'admin', 'super_admin']) && $item->status_approval == 'Menunggu Approval')
                                <form action="{{ route('admin.berita.approve', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Approve berita ini?')">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-bold">Approve</button>
                                </form>
                            @endif

                            <!-- ========================================= -->
                            <!-- PUBLISH (Publisher, Admin, Super Admin) -->
                            <!-- ========================================= -->
                            @if (in_array($role, ['publisher', 'admin', 'super_admin']) && ($item->status_approval == 'Disetujui' || $item->status_approval == 'Arsip'))
                                <form action="{{ route('admin.berita.publish', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Publish berita ini?')">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-bold">
                                        {{ $item->status_approval == 'Arsip' ? 'Publikasikan Kembali' : 'Publish' }}
                                    </button>
                                </form>
                            @endif

                            <!-- ========================================= -->
                            <!-- UNPUBLISH / ARSIPKAN (Publisher, Admin, Super Admin) -->
                            <!-- ========================================= -->
                            @if (in_array($role, ['publisher', 'admin', 'super_admin']) && $item->status_approval == 'Dipublikasikan')
                                <form action="{{ route('admin.berita.unpublish', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Arsipkan berita ini?')">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-gray-800 text-sm font-bold">Arsipkan</button>
                                </form>
                            @endif

                            <!-- ========================================= -->
                            <!-- HAPUS (Hanya Admin & Super Admin) -->
                            <!-- ========================================= -->
                            @if ($isSuperAdmin || $isAdmin)
                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold">Hapus</button>
                                </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-newspaper text-3xl text-gray-300 block mb-3"></i>
                        <p class="text-sm">Belum ada {{ strtolower($pageTitle) }}.</p>
                        @if (in_array($role, ['super_admin', 'admin', 'editor']))
                            <a href="{{ route('admin.berita.create') }}" class="text-[#006400] hover:underline text-sm font-semibold">Tambah {{ strtolower($pageTitle) }}</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection