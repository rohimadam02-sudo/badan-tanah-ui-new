@extends('layouts.admin')

@section('title', 'Proyek Investasi')

@section('content')

@php
    $role = auth()->user()->role;
    $isAdmin = in_array($role, ['super_admin', 'admin']);
@endphp

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Proyek Investasi</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola data proyek investasi Badan Bank Tanah.</p>
    </div>
    @if ($isAdmin)
        <a href="{{ route('admin.proyek-investasi.create') }}" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i>
            Tambah Proyek
        </a>
    @endif
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total Proyek</p>
                <p class="text-2xl font-bold text-gray-900">{{ $proyek->count() }}</p>
                <p class="text-[10px] text-green-600 mt-0.5"><i class="fas fa-arrow-up text-[8px] mr-1"></i>12% dari bulan lalu</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-chart-line text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Aktif</p>
                <p class="text-2xl font-bold text-green-600">{{ $proyek->where('is_active', true)->count() }}</p>
                <p class="text-[10px] text-green-600 mt-0.5"><i class="fas fa-check-circle text-[8px] mr-1"></i>Berjalan</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center">
                <i class="fas fa-circle-check text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Dalam Proses</p>
                <p class="text-2xl font-bold text-orange-500">{{ $proyek->where('status', 'Dalam Proses')->count() }}</p>
                <p class="text-[10px] text-orange-500 mt-0.5"><i class="fas fa-clock text-[8px] mr-1"></i>Pengembangan</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center">
                <i class="fas fa-clock text-orange-500"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Selesai</p>
                <p class="text-2xl font-bold text-blue-600">{{ $proyek->where('status', 'Selesai')->count() }}</p>
                <p class="text-[10px] text-blue-600 mt-0.5"><i class="fas fa-check-double text-[8px] mr-1"></i>Komplit</p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-check-double text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-900">Daftar Proyek Investasi</h2>
            <p class="text-[10px] text-gray-400 mt-0.5">Kelola dan pantau proyek investasi Badan Bank Tanah.</p>
        </div>
        <div class="text-xs text-gray-400">
            {{ $proyek->count() }} data
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Sektor</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Nilai</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($proyek as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="w-10 h-10 rounded-lg object-cover" alt="{{ $item->judul }}">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                            @endif
                            <span class="font-medium text-gray-900">{{ $item->judul }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->lokasi }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            {{ $item->sektor == 'Industri' ? 'bg-blue-50 text-blue-700' :
                               ($item->sektor == 'Pariwisata' ? 'bg-green-50 text-green-700' :
                               ($item->sektor == 'Pertanian' ? 'bg-yellow-50 text-yellow-700' :
                               'bg-purple-50 text-purple-700')) }}">
                            {{ $item->sektor }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        @if ($item->nilai_investasi)
                            Rp {{ number_format($item->nilai_investasi, 0, ',', '.') }}
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            {{ $item->status == 'Aktif' ? 'bg-green-50 text-green-700' :
                               ($item->status == 'Dalam Proses' ? 'bg-orange-50 text-orange-700' :
                               ($item->status == 'Selesai' ? 'bg-blue-50 text-blue-700' :
                               'bg-gray-50 text-gray-500')) }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            @if ($isAdmin)
                                <a href="{{ route('admin.proyek-investasi.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.proyek-investasi.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('assets.show', $item->id) }}" target="_blank" class="text-gray-400 hover:text-blue-600 text-sm font-bold" title="Lihat di Frontend">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-chart-line text-3xl text-gray-300 block mb-3"></i>
                        <p class="text-sm">Belum ada proyek investasi.</p>
                        @if ($isAdmin)
                            <a href="{{ route('admin.proyek-investasi.create') }}" class="text-[#006400] hover:underline text-sm font-semibold">Tambah proyek</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
        <p class="text-[10px] text-gray-400">Menampilkan {{ $proyek->count() }} proyek</p>
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