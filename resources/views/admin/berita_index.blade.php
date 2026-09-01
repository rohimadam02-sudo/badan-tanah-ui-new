@extends('layouts.admin')

@section('title', 'Berita')

@section('content')

@php
    $role = auth()->user()->role;
    $isAdmin = in_array($role, ['super_admin', 'admin']);
    $isEditor = $role == 'editor';
    $isPublisher = $role == 'publisher';
    $isSuperAdmin = $role == 'super_admin';

    $pageTitle = 'Berita';
    if (request()->routeIs('admin.berita.siaran_pers')) {
        $pageTitle = 'Siaran Pers';
    } elseif (request()->routeIs('admin.berita.pengumuman')) {
        $pageTitle = 'Pengumuman';
    }
@endphp

<div class="flex justify-between items-center mb-8 flex-wrap gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle }}</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola dan atur {{ strtolower($pageTitle) }} yang ditampilkan di website.</p>
    </div>

    @if (in_array($role, ['super_admin', 'admin', 'editor']))
        <a href="{{ route('admin.berita.create') }}" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i>
            Tambah {{ $pageTitle == 'Berita' ? 'Berita' : $pageTitle }}
        </a>
    @endif
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden table-container">
    <!-- ========================================================= -->
    <!-- BULK ACTION BAR -->
    <!-- ========================================================= -->
    @if (in_array($role, ['super_admin', 'admin']))
    <div class="bulk-action-bar hidden items-center gap-3 px-4 py-2.5 bg-green-50 border-b border-green-100">
        <span class="text-sm font-medium text-green-800">
            <span class="bulk-count">0</span> item dipilih
        </span>
        <span class="text-gray-300">|</span>
        <button type="button" class="bulk-delete-btn text-sm font-semibold text-red-600 hover:text-red-800 transition"
                data-url="{{ route('admin.berita.bulk-delete') }}">
            <i class="fas fa-trash mr-1"></i> Hapus Terpilih
        </button>
        <button type="button" class="ml-auto text-sm text-gray-400 hover:text-gray-600 transition"
                onclick="this.closest('.bulk-action-bar').querySelectorAll('.bulk-item').forEach(cb => cb.checked = false); this.closest('.bulk-action-bar').style.display = 'none';">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm sortable-table">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    @if (in_array($role, ['super_admin', 'admin']))
                    <th class="px-4 py-3 w-10">
                        <input type="checkbox" class="bulk-select-all rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                    </th>
                    @endif
                    <th class="px-6 py-3 font-semibold text-gray-700 cursor-pointer hover:text-[#006400] transition" data-sort="judul">
                        Judul <span class="sort-icon text-[10px]"></span>
                    </th>
                    <th class="px-6 py-3 font-semibold text-gray-700 cursor-pointer hover:text-[#006400] transition" data-sort="kategori">
                        Kategori <span class="sort-icon text-[10px]"></span>
                    </th>
                    <th class="px-6 py-3 font-semibold text-gray-700 cursor-pointer hover:text-[#006400] transition" data-sort="views">
                        Dilihat <span class="sort-icon text-[10px]"></span>
                    </th>
                    <th class="px-6 py-3 font-semibold text-gray-700 cursor-pointer hover:text-[#006400] transition" data-sort="status">
                        Status Approval <span class="sort-icon text-[10px]"></span>
                    </th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($berita as $item)
                <tr class="hover:bg-gray-50 transition">
                    @if (in_array($role, ['super_admin', 'admin']))
                    <td class="px-4 py-4">
                        <input type="checkbox" class="bulk-item rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30" value="{{ $item->id }}">
                    </td>
                    @endif
                    <td class="px-6 py-4" data-column="judul">
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
                    <td class="px-6 py-4" data-column="kategori">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold
                            {{ $item->kategori == 'Siaran Pers' ? 'bg-blue-50 text-blue-700' :
                               ($item->kategori == 'Pengumuman' ? 'bg-orange-50 text-orange-700' :
                               'bg-green-50 text-green-700') }}">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4" data-column="views">
                        <div class="flex items-center gap-1.5 text-sm">
                            <i class="far fa-eye text-gray-400"></i>
                            <span class="font-semibold text-gray-700">{{ number_format($item->views ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4" data-column="status">
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
                            @if ($isSuperAdmin || $isAdmin || $isPublisher || ($isEditor && $item->penulis == auth()->user()->name))
                                <a href="{{ route('admin.berita.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold">Edit</a>
                            @endif

                            @if (in_array($role, ['editor', 'admin', 'super_admin']) && $item->status_approval == 'Draft')
                                <form action="{{ route('admin.berita.submit', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Submit berita ini?')">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 text-sm font-bold">Submit</button>
                                </form>
                            @endif

                            @if (in_array($role, ['publisher', 'admin', 'super_admin']) && $item->status_approval == 'Menunggu Approval')
                                <form action="{{ route('admin.berita.approve', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Approve berita ini?')">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-bold">Approve</button>
                                </form>
                            @endif

                            @if (in_array($role, ['publisher', 'admin', 'super_admin']) && ($item->status_approval == 'Disetujui' || $item->status_approval == 'Arsip'))
                                <form action="{{ route('admin.berita.publish', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Publish berita ini?')">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-bold">
                                        {{ $item->status_approval == 'Arsip' ? 'Publikasikan Kembali' : 'Publish' }}
                                    </button>
                                </form>
                            @endif

                            @if (in_array($role, ['publisher', 'admin', 'super_admin']) && $item->status_approval == 'Dipublikasikan')
                                <form action="{{ route('admin.berita.unpublish', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Arsipkan berita ini?')">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-gray-800 text-sm font-bold">Arsipkan</button>
                                </form>
                            @endif

                            @if ($isSuperAdmin || $isAdmin)
                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin Hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold">Hapus</button>
                                </form>
                            @endif

                            <!-- TOMBOL QR CODE -->
                            <button type="button" onclick="generateQR('berita', {{ $item->id }})" 
                                    class="text-purple-600 hover:text-purple-800 text-sm font-bold" title="Generate QR Code">
                                <i class="fas fa-qrcode"></i> QR
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
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

<script>
function generateQR(type, id) {
    const url = `/admin/${type}/${id}/generate-qr`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showQRModal(data.qr_code);
        } else {
            showToast('Gagal generate QR Code', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    });
}

function showQRModal(qrCode) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-[99999] flex items-center justify-center bg-black/50 px-4';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl">
            <div class="mb-4 flex justify-center">${qrCode}</div>
            <h3 class="font-bold text-gray-900 mb-2">QR Code Berita</h3>
            <p class="text-sm text-gray-500 mb-4">Scan untuk membuka halaman berita ini</p>
            <button onclick="this.closest('.fixed').remove()" 
                    class="px-6 py-2.5 bg-[#006400] hover:bg-[#005500] text-white rounded-lg font-semibold text-sm transition">
                Tutup
            </button>
        </div>
    `;
    document.body.appendChild(modal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.remove();
        }
    });
}

function showToast(message, type = 'success') {
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'fixed top-20 right-4 z-[99999] space-y-3 max-w-sm w-full';
        document.body.appendChild(container);
    }

    const colors = {
        success: 'bg-green-50 border-green-400 text-green-800',
        error: 'bg-red-50 border-red-400 text-red-800',
        warning: 'bg-yellow-50 border-yellow-400 text-yellow-800',
        info: 'bg-blue-50 border-blue-400 text-blue-800'
    };
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-triangle-exclamation',
        info: 'fa-circle-info'
    };

    const toast = document.createElement('div');
    toast.className = `flex items-start gap-3 p-4 border rounded-xl shadow-lg ${colors[type] || colors.success} animate-slide-in`;
    toast.innerHTML = `
        <i class="fas ${icons[type] || icons.success} text-lg mt-0.5"></i>
        <div class="flex-1 text-sm font-medium">${message}</div>
        <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}
</script>

@endsection