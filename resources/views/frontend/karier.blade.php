@extends('layouts.frontend')

@section('title', 'Karier - Badan Bank Tanah')

@section('content')

{{-- =========================================================
    HERO / HEADER
========================================================= --}}
<section class="relative bg-[#0B2A4A] overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-green-500 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 text-blue-200 text-xs font-semibold px-4 py-2 rounded-full mb-5">
                <i class="fas fa-briefcase"></i>
                Peluang Karier
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                Karier
                <span class="text-blue-300">Badan Bank Tanah</span>
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed mt-4 max-w-2xl">
                Bergabunglah dengan kami untuk membangun negeri melalui pengelolaan tanah yang profesional, transparan, dan berkelanjutan.
            </p>
            <div class="h-1 w-20 bg-blue-500 mt-6 rounded-full"></div>
        </div>
    </div>
</section>

{{-- =========================================================
    MAIN CONTENT
========================================================= --}}
<section class="bg-gray-50 py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Statistik --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                <p class="text-2xl font-bold text-[#006400]">{{ $kariers->count() }}</p>
                <p class="text-xs text-gray-500">Total Lowongan</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $kariers->where('status', 'Buka')->count() }}</p>
                <p class="text-xs text-gray-500">Lowongan Aktif</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                <p class="text-2xl font-bold text-purple-600">{{ $kariers->pluck('lokasi')->unique()->count() }}</p>
                <p class="text-xs text-gray-500">Lokasi</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                <p class="text-2xl font-bold text-orange-500">{{ $kariers->where('status', 'Tutup')->count() }}</p>
                <p class="text-xs text-gray-500">Telah Ditutup</p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchKarier" placeholder="Cari lowongan berdasarkan judul, lokasi..."
                        class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>
                <select id="filterStatus" class="px-4 py-3 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    <option value="all">Semua Status</option>
                    <option value="Buka">Buka</option>
                    <option value="Tutup">Tutup</option>
                </select>
            </div>
        </div>

        {{-- Karier List --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="karierList">
            @forelse ($kariers as $karier)
            <div class="karier-item bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition group" data-status="{{ $karier->status }}">
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-base text-gray-900 group-hover:text-[#006400] transition line-clamp-1">
                                    {{ $karier->judul }}
                                </h3>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                    <i class="fas fa-location-dot"></i>
                                    <span>{{ $karier->lokasi ?? 'Tidak ditentukan' }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="status-badge px-3 py-1 rounded-full text-[10px] font-bold whitespace-nowrap
                            {{ $karier->status == 'Buka' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $karier->status == 'Buka' ? '● Buka' : '● Tutup' }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-2 mb-4">
                        {{ $karier->deskripsi }}
                    </p>

                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Kualifikasi:</span>
                        <span class="text-xs text-gray-600 line-clamp-1">{{ Str::limit($karier->kualifikasi, 60) }}</span>
                    </div>

                    <button type="button" onclick="toggleDetail(this)"
                        class="text-xs font-semibold text-[#006400] hover:underline inline-flex items-center gap-1">
                        Lihat Detail <i class="fas fa-chevron-down text-[8px] transition-transform"></i>
                    </button>

                    <div class="karier-detail hidden mt-4 pt-4 border-t border-gray-100">
                        <div class="grid grid-cols-1 gap-3 text-sm">
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Deskripsi Lengkap</p>
                                <p class="text-gray-600 leading-relaxed mt-1">{{ $karier->deskripsi }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Kualifikasi</p>
                                <p class="text-gray-600 leading-relaxed mt-1">{{ $karier->kualifikasi }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Lokasi</p>
                                <p class="text-gray-600 mt-1">{{ $karier->lokasi ?? 'Tidak ditentukan' }}</p>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded-lg text-xs font-bold transition">
                                    <i class="fas fa-paper-plane"></i>
                                    Lamar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                    <i class="fas fa-briefcase text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum Ada Lowongan</h3>
                <p class="text-sm text-gray-500 mt-2">Belum terdapat informasi lowongan kerja yang tersedia saat ini.</p>
                <p class="text-sm text-gray-400 mt-1">Silakan cek kembali secara berkala.</p>
            </div>
            @endforelse
        </div>

        {{-- Call to Action --}}
        <div class="mt-10 bg-gradient-to-r from-[#0B2A4A] to-[#163F66] rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-white mb-2">Tidak Menemukan Posisi yang Sesuai?</h3>
            <p class="text-blue-200 text-sm mb-5">Kirimkan CV Anda dan kami akan menghubungi Anda ketika ada posisi yang sesuai.</p>
            <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 bg-white text-[#0B2A4A] hover:bg-gray-100 px-6 py-3 rounded-xl font-bold text-sm transition">
                <i class="fas fa-envelope"></i>
                Kirim Lamaran Spontan
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    function toggleDetail(btn) {
        const detail = btn.nextElementSibling;
        const icon = btn.querySelector('.fa-chevron-down');
        detail.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
        btn.textContent = detail.classList.contains('hidden') ? 'Lihat Detail ' : 'Sembunyikan ';
        btn.appendChild(icon);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Search
        const searchInput = document.getElementById('searchKarier');
        const karierItems = document.querySelectorAll('.karier-item');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();
                karierItems.forEach(item => {
                    const title = item.querySelector('h3')?.textContent?.toLowerCase() || '';
                    const location = item.querySelector('.fa-location-dot')?.parentElement?.textContent?.toLowerCase() || '';
                    const desc = item.querySelector('p.text-gray-600')?.textContent?.toLowerCase() || '';

                    if (title.includes(keyword) || location.includes(keyword) || desc.includes(keyword)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Filter Status
        const filterStatus = document.getElementById('filterStatus');
        if (filterStatus) {
            filterStatus.addEventListener('change', function() {
                const status = this.value;
                karierItems.forEach(item => {
                    const itemStatus = item.dataset.status;
                    if (status === 'all' || itemStatus === status) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush