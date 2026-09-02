<?php $__env->startSection('title', 'Publikasi'); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 text-blue-200 px-4 py-2 rounded-full text-xs font-semibold">
                <i class="fas fa-newspaper"></i>
                Publikasi Badan Bank Tanah
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mt-5">
                Informasi dan Publikasi
                <span class="text-blue-300">Resmi</span>
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed mt-5 max-w-2xl">
                Temukan berita, siaran pers, dan pengumuman resmi Badan Bank Tanah dalam satu tempat.
            </p>
        </div>
    </div>
</section>


<section class="bg-gray-50" x-data="publicationPage()" x-init="init()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

        
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-2 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                <button type="button" @click="activeTab = 'Berita'; currentPage = 1"
                    class="tab-btn px-4 py-3 rounded-xl text-sm font-bold transition text-gray-600 hover:bg-gray-50"
                    :class="activeTab === 'Berita' ? 'bg-[#0B2A4A] text-white shadow-sm' : ''">
                    <i class="fas fa-newspaper mr-2"></i> Berita
                </button>
                <button type="button" @click="activeTab = 'Siaran Pers'; currentPage = 1"
                    class="tab-btn px-4 py-3 rounded-xl text-sm font-bold transition text-gray-600 hover:bg-gray-50"
                    :class="activeTab === 'Siaran Pers' ? 'bg-[#0B2A4A] text-white shadow-sm' : ''">
                    <i class="fas fa-bullhorn mr-2"></i> Siaran Pers
                </button>
                <button type="button" @click="activeTab = 'Pengumuman'; currentPage = 1"
                    class="tab-btn px-4 py-3 rounded-xl text-sm font-bold transition text-gray-600 hover:bg-gray-50"
                    :class="activeTab === 'Pengumuman' ? 'bg-[#0B2A4A] text-white shadow-sm' : ''">
                    <i class="fas fa-circle-info mr-2"></i> Pengumuman
                </button>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" x-model="searchQuery" @input="currentPage = 1"
                        placeholder="Cari publikasi..."
                        class="w-full pl-9 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>
            </div>
        </div>

        
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Informasi Terbaru</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mt-2">Publikasi Badan Bank Tanah</h2>
            </div>
            <p class="text-sm text-gray-500 max-w-md leading-relaxed">
                <span x-text="filteredPublications.length"></span> publikasi ditemukan
            </p>
        </div>

        
        <div x-show="loading" x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="i in 6" :key="i">
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                        <div class="skeleton skeleton-image" style="height:224px;"></div>
                        <div class="p-6 space-y-3">
                            <div class="flex justify-between">
                                <div class="skeleton skeleton-text" style="width:40%;"></div>
                                <div class="skeleton skeleton-text" style="width:20%;"></div>
                            </div>
                            <div class="skeleton skeleton-text-lg" style="width:90%;"></div>
                            <div class="skeleton skeleton-text" style="width:70%;"></div>
                            <div class="skeleton skeleton-text" style="width:50%;"></div>
                            <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                                <div class="skeleton skeleton-circle"></div>
                                <div class="skeleton skeleton-text" style="width:30%;"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        
        <div x-show="!loading && filteredPublications.length === 0" x-cloak
            class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                <i class="fas fa-newspaper text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Tidak ada publikasi</h3>
            <p class="text-sm text-gray-500 mt-2" x-text="searchQuery ? 'Tidak ada hasil untuk pencarian "' + searchQuery + '"' : 'Belum ada publikasi yang tersedia.'"></p>
        </div>

        
        <div x-show="!loading && filteredPublications.length > 0" x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="item in paginatedPublications" :key="item.id">
                    <article class="group bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition">
                        
                        <div class="h-56 bg-gray-100 relative overflow-hidden">
                            <template x-if="item.gambar">
                                <img :src="'<?php echo e(asset('storage')); ?>/' + item.gambar" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                            </template>
                            <template x-if="!item.gambar">
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B2A4A] to-[#163F66]">
                                    <i class="fas fa-newspaper text-5xl text-white/30"></i>
                                </div>
                            </template>

                            
                            <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 bg-white text-[#0B2A4A] text-[10px] px-3 py-1.5 rounded-md font-bold uppercase shadow-sm">
                                <i class="fas" :class="item.kategori === 'Berita' ? 'fa-newspaper' : (item.kategori === 'Siaran Pers' ? 'fa-bullhorn' : 'fa-circle-info')"></i>
                                <span x-text="item.kategori"></span>
                            </span>
                        </div>

                        
                        <div class="p-6">
                            
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                    <i class="far fa-calendar"></i>
                                    <span x-text="formatDate(item.tanggal_publikasi || item.created_at)"></span>
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                    <i class="far fa-eye"></i>
                                    <span x-text="formatNumber(item.views || 0)"></span>
                                </div>
                            </div>

                            
                            <h3 class="font-bold text-lg text-gray-900 leading-snug line-clamp-2 group-hover:text-[var(--color-secondary)] transition" x-text="item.judul"></h3>

                            
                            <p class="text-sm text-gray-500 leading-relaxed mt-3 line-clamp-3" x-text="item.ringkasan"></p>

                            
                            <div class="flex items-center gap-2 mt-5 pt-4 border-t border-gray-100">
                                <div class="w-7 h-7 rounded-full bg-[#0B2A4A]/10 flex items-center justify-center">
                                    <i class="fas fa-user-tie text-xs text-[#0B2A4A]"></i>
                                </div>
                                <span class="text-xs font-semibold text-gray-600" x-text="item.penulis"></span>
                            </div>

                            
                            <a :href="'/berita/' + item.id"
                               class="inline-flex items-center gap-2 mt-5 text-sm font-bold link-secondary hover:underline">
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </article>
                </template>
            </div>

            
            <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">
                    Menampilkan <span x-text="((currentPage - 1) * perPage) + 1"></span> -
                    <span x-text="Math.min(currentPage * perPage, filteredPublications.length)"></span>
                    dari <span x-text="filteredPublications.length"></span> publikasi
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
function publicationPage() {
    return {
        publications: <?php echo json_encode($berita, 15, 512) ?>,
        loading: true, // SET TRUE - agar skeleton muncul
        activeTab: 'Berita',
        searchQuery: '',
        currentPage: 1,
        perPage: 6,

        get filteredPublications() {
            let result = this.publications.filter(item => item.kategori === this.activeTab);

            if (this.searchQuery.trim()) {
                const q = this.searchQuery.toLowerCase().trim();
                result = result.filter(item =>
                    item.judul.toLowerCase().includes(q) ||
                    item.ringkasan.toLowerCase().includes(q) ||
                    item.penulis.toLowerCase().includes(q)
                );
            }

            return result;
        },

        get paginatedPublications() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredPublications.slice(start, end);
        },

        get totalPages() {
            return Math.ceil(this.filteredPublications.length / this.perPage);
        },

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

        formatDate(date) {
            if (!date) return '-';
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        },

        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        },

        init() {
            // Simulasi loading selesai setelah 500ms
            setTimeout(() => {
                this.loading = false;
            }, 500);
        }
    };
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/frontend/publications.blade.php ENDPATH**/ ?>