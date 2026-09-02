<?php $__env->startSection('title', 'Aset Persediaan Tanah'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 text-xs font-semibold text-blue-200 uppercase tracking-wider mb-4">
                <i class="fas fa-layer-group"></i>
                Aset Persediaan Tanah
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-white">Aset Persediaan Tanah</h1>
            <p class="text-blue-100 mt-4 leading-relaxed">
                Temukan informasi aset persediaan tanah Badan Bank Tanah
                berdasarkan lokasi, luas tanah, peruntukan, dan skema
                pemanfaatannya.
            </p>
            <div class="h-1 w-16 bg-blue-500 mt-6"></div>
        </div>
    </div>
</section>


<section class="bg-gray-50 py-12">

    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
        x-data="asetPage()"
        x-init="init()"
    >

        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Cari Aset Tanah</h2>
                    <p class="text-sm text-gray-500 mt-1">Gunakan filter untuk menemukan aset yang sesuai dengan kebutuhan Anda.</p>
                </div>
                <div class="text-sm text-gray-500">
                    <span x-text="totalItems"></span> aset ditemukan
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Lokasi</label>
                    <select x-model="filters.provinsi"
                        class="w-full h-11 border border-gray-300 rounded-lg text-sm px-3 focus:ring-2 focus:ring-[#0B2A4A] focus:border-[#0B2A4A]">
                        <option value="">Semua Provinsi</option>
                        <option value="Jawa Tengah">Jawa Tengah</option>
                        <option value="Sumatera Selatan">Sumatera Selatan</option>
                        <option value="Papua Selatan">Papua Selatan</option>
                    </select>
                </div>

                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Luas Minimum</label>
                    <div class="relative">
                        <input type="number" min="0" step="0.01" x-model="filters.luas_min"
                            placeholder="Contoh: 1"
                            class="w-full h-11 border border-gray-300 rounded-lg text-sm px-3 pr-12 focus:ring-2 focus:ring-[#0B2A4A] focus:border-[#0B2A4A]">
                        <span class="absolute right-3 top-3 text-xs text-gray-400">Ha</span>
                    </div>
                </div>

                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Luas Maksimum</label>
                    <div class="relative">
                        <input type="number" min="0" step="0.01" x-model="filters.luas_max"
                            placeholder="Contoh: 5"
                            class="w-full h-11 border border-gray-300 rounded-lg text-sm px-3 pr-12 focus:ring-2 focus:ring-[#0B2A4A] focus:border-[#0B2A4A]">
                        <span class="absolute right-3 top-3 text-xs text-gray-400">Ha</span>
                    </div>
                </div>

                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Peruntukan</label>
                    <select x-model="filters.peruntukan"
                        class="w-full h-11 border border-gray-300 rounded-lg text-sm px-3 focus:ring-2 focus:ring-[#0B2A4A] focus:border-[#0B2A4A]">
                        <option value="">Semua Peruntukan</option>
                        <option value="Industri">Industri</option>
                        <option value="Pertanian">Pertanian</option>
                        <option value="Perumahan">Perumahan</option>
                    </select>
                </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">

                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Skema</label>
                    <select x-model="filters.skema"
                        class="w-full h-11 border border-gray-300 rounded-lg text-sm px-3 focus:ring-2 focus:ring-[#0B2A4A] focus:border-[#0B2A4A]">
                        <option value="">Semua Skema</option>
                        <option value="Sewa">Sewa</option>
                        <option value="Kerjasama">Kerjasama</option>
                    </select>
                </div>

                <div class="sm:col-span-1 lg:col-span-3 flex flex-col sm:flex-row justify-end items-stretch sm:items-end gap-3">
                    <button type="button" @click="resetFilter()"
                        class="h-11 px-6 rounded-lg border border-gray-300 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <i class="fas fa-rotate-left mr-2"></i> Reset Filter
                    </button>
                    <button type="button" @click="applyFilter()"
                        class="h-11 px-7 rounded-lg bg-[#0B2A4A] text-white text-sm font-semibold hover:bg-[#12395f] transition">
                        <i class="fas fa-filter mr-2"></i> Terapkan Filter
                    </button>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Peta Sebaran Aset</h2>
                        <p class="text-sm text-gray-500 mt-1">Lokasi aset persediaan tanah Badan Bank Tanah.</p>
                    </div>
                    <span class="text-xs text-gray-500">
                        <i class="fas fa-location-dot text-[#006400] mr-1"></i>
                        Marker aset
                    </span>
                </div>
            </div>
            <div id="assetMap" class="w-full h-[420px] bg-blue-50"></div>
        </div>

        
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Daftar Aset</h2>
                <p class="text-sm text-gray-500 mt-1">Informasi aset persediaan tanah yang tersedia.</p>
            </div>
        </div>

        
        <div x-show="loading" x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <template x-for="i in 6" :key="i">
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm">
                        <div class="skeleton skeleton-image" style="height:208px;"></div>
                        <div class="p-5 space-y-3">
                            <div class="skeleton skeleton-text-lg" style="width:80%;"></div>
                            <div class="skeleton skeleton-text" style="width:60%;"></div>
                            <div class="skeleton skeleton-text" style="width:40%;"></div>
                            <div class="pt-4 border-t border-gray-100">
                                <div class="skeleton skeleton-text" style="width:30%;"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="skeleton skeleton-text" style="height:40px;"></div>
                                <div class="skeleton skeleton-text" style="height:40px;"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        
        <div x-show="!loading && paginatedAssets.length === 0" x-cloak
            class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <div class="w-14 h-14 mx-auto rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-map-location-dot text-gray-400 text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 mt-4">Aset tidak ditemukan</h3>
            <p class="text-sm text-gray-500 mt-1">Tidak ada aset yang sesuai dengan filter yang dipilih.</p>
            <button type="button" @click="resetFilter()"
                class="mt-5 text-sm font-semibold text-[#0B2A4A] hover:underline">Reset Filter</button>
        </div>

        
        <div x-show="!loading && paginatedAssets.length > 0" x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <template x-for="item in paginatedAssets" :key="item.id">
                    <article class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg transition">
                        
                        <div class="relative h-52 bg-gray-100">
                            <img :src="item.gambar ? '<?php echo e(asset('storage')); ?>/' + item.gambar : 'https://picsum.photos/600/400?random=' + item.id"
                                :alt="item.nama_lokasi" class="w-full h-full object-cover" loading="lazy">
                            <span class="absolute top-4 left-4 text-white text-[10px] px-3 py-1.5 rounded-md font-bold uppercase tracking-wide"
                                :class="item.status === 'Tersedia' ? 'bg-[#006400]' : (item.status === 'Dalam Pengembangan' ? 'bg-blue-600' : 'bg-orange-500')"
                                x-text="item.status"></span>
                        </div>

                        
                        <div class="p-5">
                            <h3 class="font-bold text-base text-gray-900 leading-snug" x-text="item.nama_lokasi"></h3>
                            <div class="flex items-start gap-2 mt-2">
                                <i class="fas fa-location-dot text-gray-400 text-xs mt-1"></i>
                                <p class="text-xs text-gray-500 leading-relaxed"
                                    x-text="item.provinsi + (item.kabupaten ? ', ' + item.kabupaten : '')"></p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-[10px] text-gray-400 uppercase tracking-wide">Luas Tanah</p>
                                <p class="text-lg font-extrabold text-[#006400] mt-1"
                                    x-text="formatNumber(item.luas_hektar) + ' Ha'"></p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mt-4">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-[9px] text-gray-400 uppercase">Peruntukan</p>
                                    <p class="text-xs font-semibold text-gray-700 mt-1" x-text="item.peruntukan || '-'"></p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-[9px] text-gray-400 uppercase">Skema</p>
                                    <p class="text-xs font-semibold text-gray-700 mt-1" x-text="item.skema || '-'"></p>
                                </div>
                            </div>

                            <a :href="'/aset/' + item.id"
                                class="mt-5 w-full h-10 inline-flex items-center justify-center gap-2 rounded-lg bg-[#0B2A4A] text-white text-xs font-semibold hover:bg-[#12395f] transition">
                                Lihat Detail Aset <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </template>
            </div>

            
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">
                    Menampilkan <span x-text="((currentPage - 1) * perPage) + 1"></span> - 
                    <span x-text="Math.min(currentPage * perPage, filteredAssets.length)"></span> 
                    dari <span x-text="filteredAssets.length"></span> aset
                </p>
                <div class="flex items-center gap-1.5 flex-wrap justify-center">
                    
                    <button type="button" @click="changePage(currentPage - 1)" :disabled="currentPage <= 1"
                        class="w-9 h-9 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-[#006400] transition flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>

                    
                    <template x-for="page in getVisiblePages()" :key="page">
                        <template x-if="page === '...'">
                            <span class="px-1 text-gray-400">...</span>
                        </template>
                        <template x-if="page !== '...'">
                            <button type="button" @click="changePage(page)"
                                class="w-9 h-9 rounded-lg border transition flex items-center justify-center text-sm font-medium"
                                :class="page === currentPage ? 'bg-[#006400] text-white border-[#006400] shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:border-[#006400]'"
                                x-text="page"></button>
                        </template>
                    </template>

                    
                    <button type="button" @click="changePage(currentPage + 1)" :disabled="currentPage >= totalPages"
                        class="w-9 h-9 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-[#006400] transition flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function asetPage() {
    return {
        /* =====================================================
           DATA
        ====================================================== */
        asets: [],
        loading: true,
        map: null,
        markers: [],
        currentPage: 1,
        perPage: 6,
        totalItems: 0,

        /* =====================================================
           FILTER
        ====================================================== */
        filters: {
            provinsi: '',
            luas_min: '',
            luas_max: '',
            peruntukan: '',
            skema: ''
        },

        /* =====================================================
           COMPUTED
        ====================================================== */
        get filteredAssets() {
            let result = [...this.asets];
            const f = this.filters;

            if (f.provinsi) {
                result = result.filter(item => item.provinsi === f.provinsi);
            }
            if (f.luas_min) {
                result = result.filter(item => Number(item.luas_hektar) >= Number(f.luas_min));
            }
            if (f.luas_max) {
                result = result.filter(item => Number(item.luas_hektar) <= Number(f.luas_max));
            }
            if (f.peruntukan) {
                result = result.filter(item => item.peruntukan === f.peruntukan);
            }
            if (f.skema) {
                result = result.filter(item => item.skema === f.skema);
            }

            this.totalItems = result.length;
            return result;
        },

        get paginatedAssets() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredAssets.slice(start, end);
        },

        get totalPages() {
            return Math.ceil(this.filteredAssets.length / this.perPage);
        },

        /* =====================================================
           METHODS
        ====================================================== */
        getVisiblePages() {
            const total = this.totalPages;
            const current = this.currentPage;
            const pages = [];
            const showPages = 5;
            const half = Math.floor(showPages / 2);

            if (total <= showPages) {
                for (let i = 1; i <= total; i++) pages.push(i);
                return pages;
            }

            let start = Math.max(1, current - half);
            let end = Math.min(total, current + half);

            if (end - start + 1 < showPages) {
                if (start === 1) {
                    end = Math.min(total, start + showPages - 1);
                } else if (end === total) {
                    start = Math.max(1, end - showPages + 1);
                }
            }

            if (start > 1) {
                pages.push(1);
                if (start > 2) pages.push('...');
            }

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }

            if (end < total) {
                if (end < total - 1) pages.push('...');
                pages.push(total);
            }

            return pages;
        },

        changePage(page) {
            if (page < 1 || page > this.totalPages) return;
            this.currentPage = page;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        /* =====================================================
           INIT
        ====================================================== */
        async init() {
            console.log('ASET PAGE: init');
            this.loading = true;
            this.initMap();
            await this.fetchAset();
            this.loading = false;
        },

        /* =====================================================
           INIT MAP
        ====================================================== */
        initMap() {
            const mapElement = document.getElementById('assetMap');
            if (!mapElement) {
                console.error('ASET PAGE: #assetMap tidak ditemukan');
                return;
            }
            if (this.map) {
                console.log('ASET PAGE: map sudah dibuat');
                return;
            }

            this.map = L.map('assetMap').setView([-2.5, 118], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(this.map);
            console.log('ASET PAGE: map berhasil dibuat');
        },

        /* =====================================================
           FETCH DATA
        ====================================================== */
        async fetchAset(filters = this.filters) {
            this.loading = true;
            this.currentPage = 1;

            try {
                const cleanFilters = {};
                Object.keys(filters).forEach(key => {
                    if (filters[key] !== '' && filters[key] !== null && filters[key] !== undefined) {
                        cleanFilters[key] = filters[key];
                    }
                });

                const params = new URLSearchParams(cleanFilters).toString();
                const response = await fetch(`/aset/filter?${params}`);

                if (!response.ok) {
                    throw new Error('Gagal mengambil data aset');
                }

                const data = await response.json();
                console.log('DATA DATABASE:', data);

                if (Array.isArray(data) && data.length > 0) {
                    this.asets = data;
                    console.log('ASET PAGE: menggunakan data database');
                } else {
                    this.asets = this.filterDummyAssets(filters);
                    console.log('ASET PAGE: menggunakan dummy');
                }

                this.updateMap();

            } catch (error) {
                console.error('ASET PAGE: API error', error);
                this.asets = this.filterDummyAssets(filters);
                this.updateMap();
            } finally {
                this.loading = false;
            }
        },

        /* =====================================================
           FILTER DATA DUMMY
        ====================================================== */
        filterDummyAssets(filters = {}) {
            return this.dummyAssets.filter(item => {
                if (filters.provinsi && item.provinsi !== filters.provinsi) return false;
                if (filters.luas_min && Number(item.luas_hektar) < Number(filters.luas_min)) return false;
                if (filters.luas_max && Number(item.luas_hektar) > Number(filters.luas_max)) return false;
                if (filters.peruntukan && item.peruntukan !== filters.peruntukan) return false;
                if (filters.skema && item.skema !== filters.skema) return false;
                return true;
            });
        },

        /* =====================================================
           APPLY / RESET FILTER (FIXED - Reset currentPage)
        ====================================================== */
        async applyFilter() {
            console.log('ASET PAGE: apply filter', this.filters);
            this.currentPage = 1; // Reset ke halaman pertama
            await this.fetchAset(this.filters);
        },

        async resetFilter() {
            this.filters = { provinsi: '', luas_min: '', luas_max: '', peruntukan: '', skema: '' };
            this.currentPage = 1; // Reset ke halaman pertama
            await this.fetchAset(this.filters);
        },

        /* =====================================================
           UPDATE MAP
        ====================================================== */
        updateMap() {
            if (!this.map) {
                console.warn('ASET PAGE: map belum tersedia');
                return;
            }

            this.clearMarkers();
            const assets = Array.isArray(this.asets) ? this.asets : [];

            if (assets.length === 0) {
                console.log('ASET PAGE: tidak ada data untuk map');
                return;
            }

            console.log('ASET PAGE: update map', assets);

            assets.forEach(item => {
                const lat = Number(item.lat);
                const lng = Number(item.lng);

                if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                    console.warn('Koordinat tidak valid:', item);
                    return;
                }

                let markerColor = '#006400';
                if (item.status === 'Dalam Pengembangan') markerColor = '#2563EB';
                if (item.status === 'Dalam Proses') markerColor = '#F97316';

                const markerIcon = L.divIcon({
                    className: 'asset-map-marker',
                    html: `
                        <div style="width:20px;height:20px;background:${markerColor};border:3px solid white;border-radius:50%;box-shadow:0 2px 8px rgba(0,0,0,.35);"></div>
                    `,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10],
                    popupAnchor: [0, -10]
                });

                const marker = L.marker([lat, lng], { icon: markerIcon }).addTo(this.map);

                marker.bindPopup(`
                    <div style="min-width:230px;font-family:Inter,sans-serif;">
                        <div style="font-size:15px;font-weight:700;color:#111827;margin-bottom:6px;">${item.nama_lokasi ?? 'Aset Tanah'}</div>
                        <div style="font-size:11px;color:#6B7280;margin-bottom:12px;">
                            <i class="fas fa-location-dot"></i> ${item.kabupaten ?? ''}, ${item.provinsi ?? ''}
                        </div>
                        <div style="background:#F0FDF4;padding:10px;border-radius:7px;margin-bottom:10px;">
                            <div style="font-size:9px;color:#6B7280;text-transform:uppercase;">Total Luas</div>
                            <div style="font-size:14px;font-weight:700;color:#006400;">${this.formatNumber(item.luas_hektar)} Ha</div>
                        </div>
                        <div style="font-size:11px;line-height:1.8;color:#4B5563;">
                            <strong>Peruntukan:</strong> ${item.peruntukan ?? '-'}<br>
                            <strong>Skema:</strong> ${item.skema ?? '-'}<br>
                            <strong>Status:</strong> ${item.status ?? '-'}
                        </div>
                        <div style="margin-top:12px;padding:6px;text-align:center;background:#FFF7ED;color:#C2410C;border-radius:5px;font-size:9px;">Data demonstrasi</div>
                    </div>
                `);

                this.markers.push(marker);
            });

            const validAssets = assets.filter(item => Number.isFinite(Number(item.lat)) && Number.isFinite(Number(item.lng)));
            if (validAssets.length > 0) {
                const bounds = L.latLngBounds(validAssets.map(item => [Number(item.lat), Number(item.lng)]));
                this.map.fitBounds(bounds, { padding: [30, 30], maxZoom: 6 });
            }
        },

        clearMarkers() {
            if (!this.map) return;
            this.markers.forEach(marker => this.map.removeLayer(marker));
            this.markers = [];
        },

        formatNumber(num) {
            if (num === null || num === undefined || num === '') return '0,00';
            return parseFloat(num).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },

        /* =====================================================
           DATA DUMMY
        ====================================================== */
        dummyAssets: [
            { id: 'dummy-1', nama_lokasi: 'Kawasan Industri Terpadu Batang', provinsi: 'Jawa Tengah', kabupaten: 'Batang', luas_hektar: 2450, status: 'Tersedia', peruntukan: 'Industri', skema: 'Kerjasama', lat: -6.9004, lng: 109.7422, gambar: null },
            { id: 'dummy-2', nama_lokasi: 'Tanah Bekas HGU PT. Sinar Harapan', provinsi: 'Sumatera Selatan', kabupaten: 'Musi Banyuasin', luas_hektar: 1850.50, status: 'Dalam Pengembangan', peruntukan: 'Pertanian', skema: 'Sewa', lat: -2.4858, lng: 103.5038, gambar: null },
            { id: 'dummy-3', nama_lokasi: 'Kawasan Sentra Pangan Merauke', provinsi: 'Papua Selatan', kabupaten: 'Merauke', luas_hektar: 5320.75, status: 'Tersedia', peruntukan: 'Pertanian', skema: 'Kerjasama', lat: -8.4966, lng: 140.3940, gambar: null },
            { id: 'dummy-4', nama_lokasi: 'Kawasan Pengembangan Perumahan Bogor', provinsi: 'Jawa Barat', kabupaten: 'Bogor', luas_hektar: 850.25, status: 'Dalam Proses', peruntukan: 'Perumahan', skema: 'Kerjasama', lat: -6.5950, lng: 106.8160, gambar: null },
            { id: 'dummy-5', nama_lokasi: 'Kawasan Pertanian Produktif Gowa', provinsi: 'Sulawesi Selatan', kabupaten: 'Gowa', luas_hektar: 1250.80, status: 'Tersedia', peruntukan: 'Pertanian', skema: 'Sewa', lat: -5.3170, lng: 119.7420, gambar: null },
            { id: 'dummy-6', nama_lokasi: 'Kawasan Industri Kalimantan Timur', provinsi: 'Kalimantan Timur', kabupaten: 'Kutai Kartanegara', luas_hektar: 3150.40, status: 'Dalam Pengembangan', peruntukan: 'Industri', skema: 'Kerjasama', lat: -0.5020, lng: 117.1530, gambar: null }
        ]
    };
}

window.asetPage = asetPage;
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/frontend/assets.blade.php ENDPATH**/ ?>