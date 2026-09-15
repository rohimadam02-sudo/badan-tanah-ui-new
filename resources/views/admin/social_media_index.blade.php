@extends('layouts.admin')

@section('title', 'Social Media')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Social Media</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola social media yang tampil di footer website.</p>
        </div>
        <a href="{{ route('admin.social-media.create') }}" 
           class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
            <i class="fas fa-plus mr-1.5"></i> Tambah Social Media
        </a>
    </div>

    <!-- Informasi -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-arrows-alt text-blue-500 mt-0.5"></i>
            <div>
                <p class="text-sm font-medium text-blue-800">Drag & Drop untuk mengubah urutan</p>
                <p class="text-xs text-blue-600">Seret icon <i class="fas fa-grip-vertical"></i> untuk mengatur ulang posisi social media</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm" id="socialMediaTable">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4 py-3 w-10">#</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Icon</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Nama</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">URL</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="sortableBody">
                    @forelse($socialMedias as $item)
                    <tr class="hover:bg-gray-50 transition" data-id="{{ $item->id }}">
                        <td class="px-4 py-4">
                            <i class="fas fa-grip-vertical text-gray-300 cursor-move"></i>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-lg"
                                 style="background-color: {{ $item->warna ?? '#6b7280' }}">
                                <i class="{{ $item->icon }}"></i>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $item->nama }}</td>
                        <td class="px-6 py-4 text-gray-500 truncate max-w-[200px]">
                            <a href="{{ $item->url }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $item->url }}
                            </a>
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
                                <a href="{{ route('admin.social-media.edit', $item->id) }}" 
                                   class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.social-media.destroy', $item->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus social media ini?')">
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
                            <i class="fas fa-share-alt text-3xl text-gray-300 block mb-3"></i>
                            <p class="text-sm">Belum ada social media.</p>
                            <a href="{{ route('admin.social-media.create') }}" class="text-[#006400] hover:underline text-sm font-semibold">
                                Tambah social media
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- SORTABLE JS -->
<!-- ========================================================= -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // =========================================================
    // DRAG & DROP SORTING
    // =========================================================
    const tbody = document.getElementById('sortableBody');
    
    if (tbody) {
        new Sortable(tbody, {
            handle: '.fa-grip-vertical',
            animation: 150,
            onEnd: function() {
                const order = [];
                tbody.querySelectorAll('tr').forEach((tr, index) => {
                    order.push({
                        id: tr.dataset.id,
                        urutan: index + 1
                    });
                });
                
                // Kirim ke server
                fetch('{{ route('admin.social-media.update-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order.map(item => item.id) })
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

// =========================================================
// TOGGLE STATUS
// =========================================================
function toggleStatus(id) {
    fetch(`/admin/social-media/${id}/toggle`, {
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

// =========================================================
// TOAST
// =========================================================
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