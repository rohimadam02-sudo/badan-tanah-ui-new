@extends('layouts.admin')

@section('title', 'Microsite / Event')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Microsite / Event</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola halaman event dan microsite khusus.</p>
        </div>
        <a href="{{ route('admin.microsite.create') }}" 
           class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i> Buat Microsite
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-gray-600">Judul</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Slug</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Dilihat</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($microsites as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                                         class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 bg-[#0B2A4A]/5 rounded flex items-center justify-center">
                                        <i class="fas fa-file-lines text-gray-400"></i>
                                    </div>
                                @endif
                                <span class="font-medium">{{ $item->judul }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">/event/{{ $item->slug }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold
                                {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                            @if($item->is_featured)
                                <span class="px-2 py-1 rounded text-xs font-bold bg-yellow-100 text-yellow-700 ml-1">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            @if($item->tanggal_mulai)
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ number_format($item->views ?? 0) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('microsite.show', $item->slug) }}" target="_blank"
                                   class="text-blue-600 hover:text-blue-800" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.microsite.edit', $item->id) }}"
                                   class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.microsite.destroy', $item->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus microsite ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <button type="button" onclick="toggleStatus({{ $item->id }})"
                                        class="text-gray-400 hover:text-gray-600" title="Toggle Status">
                                    <i class="fas fa-toggle-{{ $item->is_active ? 'on' : 'off' }}"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-file-lines text-3xl text-gray-300 block mb-3"></i>
                            <p class="text-sm">Belum ada microsite.</p>
                            <a href="{{ route('admin.microsite.create') }}" class="text-[#006400] hover:underline text-sm font-semibold">Buat microsite</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function toggleStatus(id) {
    fetch(`/admin/microsite/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(() => alert('Gagal mengubah status'));
}
</script>
@endsection