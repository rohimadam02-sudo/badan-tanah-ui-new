@extends('layouts.admin')

@section('title', 'Lokasi Kantor')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Lokasi Kantor</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola lokasi kantor Badan Bank Tanah.</p>
        </div>
        <a href="{{ route('admin.lokasi-kantor.create') }}" 
           class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i> Tambah Lokasi
        </a>
    </div>

    <!-- Informasi -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-map-location-dot text-blue-500 mt-0.5"></i>
            <div>
                <p class="text-sm font-medium text-blue-800">Lokasi yang aktif akan tampil di peta halaman Kontak</p>
                <p class="text-xs text-blue-600">Seret icon <i class="fas fa-grip-vertical"></i> untuk mengatur urutan</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4 py-3 w-10">#</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Nama</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Alamat</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Koordinat</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="sortableBody">
                    @forelse($lokasi as $item)
                    <tr class="hover:bg-gray-50 transition" data-id="{{ $item->id }}">
                        <td class="px-4 py-4">
                            <i class="fas fa-grip-vertical text-gray-300 cursor-move"></i>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-medium">{{ $item->nama }}</span>
                                @if($item->is_utama)
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-yellow-100 text-yellow-700">Utama</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->alamat }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->lat }}, {{ $item->lng }}
                        </td>
                        <td class="px-6 py-4">
                            <button type="button" onclick="toggleStatus({{ $item->id }})"
                                    class="px-2 py-1 rounded text-xs font-bold transition
                                    {{ $item->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.lokasi-kantor.edit', $item->id) }}" 
                                   class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.lokasi-kantor.destroy', $item->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus lokasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-map-pin text-3xl text-gray-300 block mb-3"></i>
                            <p class="text-sm">Belum ada lokasi kantor.</p>
                            <a href="{{ route('admin.lokasi-kantor.create') }}" class="text-[#006400] hover:underline text-sm font-semibold">
                                Tambah lokasi
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('sortableBody');
    
    if (tbody) {
        new Sortable(tbody, {
            handle: '.fa-grip-vertical',
            animation: 150,
            onEnd: function() {
                const order = [];
                tbody.querySelectorAll('tr').forEach((tr, index) => {
                    order.push(tr.dataset.id);
                });
                
                fetch('{{ route('admin.lokasi-kantor.update-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Urutan berhasil diperbarui!', 'success');
                    }
                })
                .catch(() => {
                    showToast('Gagal memperbarui urutan', 'error');
                });
            }
        });
    }
});

function toggleStatus(id) {
    fetch(`/admin/lokasi-kantor/${id}/toggle`, {
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