@extends('layouts.admin')

@section('title', 'Aset Persediaan Tanah')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Halaman -->
        <div class="flex items-start gap-4 mb-6">
            <div class="w-14 h-14 bg-green-100 text-[#006400] rounded-full flex items-center justify-center">
                <i class="fas fa-map-marked-alt text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Aset Persediaan Tanah</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data aset persediaan tanah Badan Bank Tanah.</p>
            </div>
        </div>

        <!-- TAB NAVIGASI ASET - RESPONSIVE -->
        <div class="flex flex-wrap items-center gap-1.5 border-b border-gray-200 pb-3 mb-6">
            <a href="{{ route('admin.aset.index') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.index') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-database text-sm"></i>
                <span>Data Aset</span>
            </a>

            <a href="{{ route('admin.aset.peta') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.peta') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-map-location-dot text-sm"></i>
                <span>Peta Interaktif</span>
            </a>

            <a href="{{ route('admin.aset.profil') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.profil') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-layer-group text-sm"></i>
                <span>Profil Persediaan Tanah</span>
            </a>

            <a href="{{ route('admin.aset.pengelolaan') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.pengelolaan') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-gear text-sm"></i>
                <span>Pengelolaan Tanah</span>
            </a>

            <a href="{{ route('admin.aset.pengembangan') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.pengembangan') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-chart-line text-sm"></i>
                <span>Pengembangan Tanah</span>
            </a>

            <a href="{{ route('admin.aset.wilayah') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.wilayah') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-map text-sm"></i>
                <span>Wilayah</span>
            </a>

            <a href="{{ route('admin.aset.status') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.status') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-circle-check text-sm"></i>
                <span>Status Tanah</span>
            </a>

            <a href="{{ route('admin.aset.dokumen') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.dokumen') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-file-lines text-sm"></i>
                <span>Dokumen</span>
            </a>

            <a href="{{ route('admin.aset.statistik') }}"
                class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('admin.aset.statistik') 
                    ? 'bg-[#006400] text-white shadow-sm' 
                    : 'text-gray-600 hover:bg-gray-100 hover:text-[#006400]' 
                }}">
                <i class="fas fa-chart-pie text-sm"></i>
                <span>Statistik</span>
            </a>
        </div>

        <!-- KARTU STATISTIK ASET - DATA REAL -->
        @php
            $totalAset = \App\Models\AsetTanah::count();
            $totalLokasi = \App\Models\AsetTanah::count();
            $totalProvinsi = \App\Models\AsetTanah::distinct('provinsi')->count('provinsi');
            $totalKabupaten = \App\Models\AsetTanah::distinct('kabupaten')->count('kabupaten');
            $totalLuas = \App\Models\AsetTanah::sum('luas_hektar');
            $totalNilai = 68450000000000;
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-6">

            <!-- TOTAL ASET -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-layer-group text-green-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Total Aset</p>
                        <p class="text-sm font-bold text-gray-900">{{ number_format($totalAset) }}</p>
                        <p class="text-[8px] text-green-600 truncate">Data aset terdaftar</p>
                    </div>
                </div>
            </div>

            <!-- LOKASI ASET -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-location-dot text-blue-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Lokasi Aset</p>
                        <p class="text-sm font-bold text-gray-900">{{ number_format($totalLokasi) }}</p>
                        <p class="text-[8px] text-blue-600 truncate">Lokasi terdata</p>
                    </div>
                </div>
            </div>

            <!-- WILAYAH -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-yellow-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-map text-yellow-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Wilayah</p>
                        <p class="text-sm font-bold text-gray-900">{{ number_format($totalProvinsi) }}</p>
                        <p class="text-[8px] text-yellow-600 truncate">Wilayah terdata</p>
                    </div>
                </div>
            </div>

            <!-- KABUPATEN / KOTA -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-city text-purple-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Kabupaten/Kota</p>
                        <p class="text-sm font-bold text-gray-900">{{ number_format($totalKabupaten) }}</p>
                        <p class="text-[8px] text-purple-600 truncate">Daerah terdata</p>
                    </div>
                </div>
            </div>

            <!-- NILAI INDIKATIF -->
            <div class="bg-white px-3 py-3 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center shrink-0">
                        <i class="fas fa-money-bill-trend-up text-teal-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500 truncate">Nilai Indikatif</p>
                        <p class="text-sm font-bold text-gray-900 whitespace-nowrap">Rp 68,45 T</p>
                        <p class="text-[8px] text-teal-600 truncate">Nilai estimasi aset</p>
                    </div>
                </div>
            </div>

        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Aset Tabel -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden table-container">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center flex-wrap gap-3">
                <h3 class="font-bold text-gray-900">Daftar Aset Persediaan Tanah</h3>
                <div class="flex items-center gap-3 flex-wrap">
                    <a href="{{ route('admin.aset.create') }}"
                        class="bg-[#006400] hover:bg-[#005500] text-white px-4 py-2 rounded text-sm font-bold">
                        + Tambah Aset
                    </a>
                </div>
            </div>

            <!-- ========================================================= -->
            <!-- BULK ACTION BAR -->
            <!-- ========================================================= -->
            <div class="bulk-action-bar hidden items-center gap-3 px-4 py-2.5 bg-green-50 border-b border-green-100">
                <span class="text-sm font-medium text-green-800">
                    <span class="bulk-count">0</span> item dipilih
                </span>
                <span class="text-gray-300">|</span>
                <button type="button" class="bulk-delete-btn text-sm font-semibold text-red-600 hover:text-red-800 transition"
                        data-url="{{ route('admin.aset.bulk-delete') }}">
                    <i class="fas fa-trash mr-1"></i> Hapus Terpilih
                </button>
                <button type="button" class="ml-auto text-sm text-gray-400 hover:text-gray-600 transition"
                        onclick="this.closest('.bulk-action-bar').querySelectorAll('.bulk-item').forEach(cb => cb.checked = false); this.closest('.bulk-action-bar').style.display = 'none';">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm sortable-table">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-4 py-3 w-10">
                                <input type="checkbox" class="bulk-select-all rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30">
                            </th>
                            <th class="px-6 py-3 font-semibold text-gray-600 cursor-pointer hover:text-[#006400] transition" data-sort="kode">
                                Kode Aset <span class="sort-icon text-[10px]"></span>
                            </th>
                            <th class="px-6 py-3 font-semibold text-gray-600 cursor-pointer hover:text-[#006400] transition" data-sort="nama">
                                Nama Lokasi <span class="sort-icon text-[10px]"></span>
                            </th>
                            <th class="px-6 py-3 font-semibold text-gray-600 cursor-pointer hover:text-[#006400] transition" data-sort="provinsi">
                                Provinsi <span class="sort-icon text-[10px]"></span>
                            </th>
                            <th class="px-6 py-3 font-semibold text-gray-600 cursor-pointer hover:text-[#006400] transition" data-sort="kabupaten">
                                Kabupaten <span class="sort-icon text-[10px]"></span>
                            </th>
                            <th class="px-6 py-3 font-semibold text-gray-600 cursor-pointer hover:text-[#006400] transition" data-sort="luas">
                                Luas (Ha) <span class="sort-icon text-[10px]"></span>
                            </th>
                            <th class="px-6 py-3 font-semibold text-gray-600 cursor-pointer hover:text-[#006400] transition" data-sort="status">
                                Status <span class="sort-icon text-[10px]"></span>
                            </th>
                            <th class="px-6 py-3 font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-gray-100">
                        @foreach ($asets as $aset)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4">
                                    <input type="checkbox" class="bulk-item rounded border-gray-300 text-[#006400] focus:ring-[#006400]/30" value="{{ $aset->id }}">
                                </td>
                                <td class="px-6 py-4" data-column="kode">BT-2025-{{ sprintf('%04d', $aset->id) }}</td>
                                <td class="px-6 py-4" data-column="nama">
                                    <div class="flex items-center gap-3">
                                        @if ($aset->gambar)
                                            <img src="{{ asset('storage/' . $aset->gambar) }}"
                                                class="w-10 h-10 rounded object-cover">
                                        @else
                                            <img src="https://picsum.photos/50/50?random={{ $loop->index }}"
                                                class="w-10 h-10 rounded object-cover">
                                        @endif
                                        <span class="font-medium">{{ $aset->nama_lokasi }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4" data-column="provinsi">{{ $aset->provinsi }}</td>
                                <td class="px-6 py-4" data-column="kabupaten">{{ $aset->kabupaten }}</td>
                                <td class="px-6 py-4" data-column="luas">{{ number_format($aset->luas_hektar, 2, ',', '.') }}</td>
                                <td class="px-6 py-4" data-column="status">
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">{{ $aset->status }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 text-gray-500 flex-wrap">
                                        <a href="{{ route('admin.aset.edit', $aset->id) }}" class="hover:text-[#006400]"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('admin.aset.destroy', $aset->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="hover:text-red-600"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <!-- TOMBOL QR CODE -->
                                        <button type="button" onclick="generateQR('aset', {{ $aset->id }})" 
                                                class="hover:text-purple-600" title="Generate QR Code">
                                            <i class="fas fa-qrcode"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
        // Buat modal sederhana
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-[99999] flex items-center justify-center bg-black/50 px-4';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl">
                <div class="mb-4 flex justify-center">${qrCode}</div>
                <h3 class="font-bold text-gray-900 mb-2">QR Code Aset</h3>
                <p class="text-sm text-gray-500 mb-4">Scan untuk membuka halaman aset ini</p>
                <button onclick="this.closest('.fixed').remove()" 
                        class="px-6 py-2.5 bg-[#006400] hover:bg-[#005500] text-white rounded-lg font-semibold text-sm transition">
                    Tutup
                </button>
            </div>
        `;
        document.body.appendChild(modal);
        
        // Tutup dengan klik di luar
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