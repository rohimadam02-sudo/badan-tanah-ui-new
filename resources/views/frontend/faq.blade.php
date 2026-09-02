@extends('layouts.frontend')

@section('title', 'FAQ - Badan Bank Tanah')

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
                <i class="fas fa-circle-question"></i>
                Pusat Bantuan
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                FAQ
                <span class="text-blue-300">Badan Bank Tanah</span>
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed mt-4 max-w-2xl">
                Temukan jawaban atas pertanyaan yang paling sering diajukan tentang Badan Bank Tanah,
                aset persediaan tanah, dan pemanfaatan aset.
            </p>
            <div class="h-1 w-20 bg-blue-500 mt-6 rounded-full"></div>
        </div>
    </div>
</section>

{{-- =========================================================
    MAIN CONTENT
========================================================= --}}
<section class="bg-gray-50 py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 mb-8">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchFaq" placeholder="Cari pertanyaan..."
                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
            </div>

            {{-- Dynamic Categories --}}
            <div class="flex flex-wrap gap-2 mt-3" id="categoryFilter">
                <button type="button" class="filter-btn active px-4 py-1.5 rounded-full text-xs font-medium bg-[#006400] text-white hover:bg-[#005500] transition" data-kategori="Semua">
                    Semua
                </button>
                @foreach($categories as $cat)
                    <button type="button" class="filter-btn px-4 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition" data-kategori="{{ $cat }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- FAQ List --}}
        <div class="space-y-4" id="faqList">
            @forelse ($faqs as $index => $faq)
            <div class="faq-item bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition hover:shadow-md" data-kategori="{{ $faq->kategori }}">
                <button type="button" class="faq-toggle w-full text-left px-6 py-5 flex items-center justify-between gap-4 hover:bg-gray-50 transition group">
                    <div class="flex items-start gap-4">
                        <span class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $faq->kategori }}</span>
                            <span class="text-sm md:text-base font-semibold text-gray-800 group-hover:text-[#006400] transition block mt-1">
                                {{ $faq->pertanyaan }}
                            </span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300 flex-shrink-0"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5 pt-0 border-t border-gray-100">
                    <div class="flex items-start gap-4 pt-4">
                        <i class="fas fa-reply text-[#006400] text-sm mt-1"></i>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $faq->jawaban }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                    <i class="fas fa-circle-question text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum Ada FAQ</h3>
                <p class="text-sm text-gray-500 mt-2">Belum terdapat pertanyaan dan jawaban yang tersimpan.</p>
            </div>
            @endforelse
        </div>

        {{-- Call to Action --}}
        <div class="mt-10 bg-gradient-to-r from-[#0B2A4A] to-[#163F66] rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-white mb-2">Masih Ada Pertanyaan?</h3>
            <p class="text-blue-200 text-sm mb-5">Hubungi kami untuk informasi lebih lanjut.</p>
            <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 bg-white text-[#0B2A4A] hover:bg-gray-100 px-6 py-3 rounded-xl font-bold text-sm transition">
                <i class="fas fa-envelope"></i>
                Hubungi Kami
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // =========================================================
    // TOGGLE FAQ
    // =========================================================
    const toggles = document.querySelectorAll('.faq-toggle');
    toggles.forEach(btn => {
        btn.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('.fa-chevron-down');
            answer.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });

    // =========================================================
    // FILTER FAQ BY CATEGORY
    // =========================================================
    const filterBtns = document.querySelectorAll('.filter-btn');
    const faqItems = document.querySelectorAll('.faq-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            filterBtns.forEach(b => {
                b.classList.remove('active', 'bg-[#006400]', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-600');
            });
            this.classList.remove('bg-gray-100', 'text-gray-600');
            this.classList.add('active', 'bg-[#006400]', 'text-white');

            const kategori = this.dataset.kategori;

            faqItems.forEach(item => {
                if (kategori === 'Semua') {
                    item.style.display = 'block';
                } else {
                    const itemKategori = item.dataset.kategori;
                    if (itemKategori === kategori) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });

    // =========================================================
    // SEARCH FAQ
    // =========================================================
    const searchInput = document.getElementById('searchFaq');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase().trim();
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-toggle .text-gray-800')?.textContent?.toLowerCase() || '';
                const answer = item.querySelector('.faq-answer p')?.textContent?.toLowerCase() || '';
                if (question.includes(keyword) || answer.includes(keyword)) {
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