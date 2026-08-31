@extends('layouts.frontend')

@section('title', $halaman->judul . ' - Badan Bank Tanah')

@section('content')

{{-- =========================================================
    HERO / PAGE HEADER
========================================================= --}}
<section class="bg-[#0B2A4A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

        <div class="max-w-3xl">

            <span class="inline-flex items-center px-3 py-1 rounded-full
                         bg-white/10 text-blue-200 text-xs font-semibold
                         uppercase tracking-wider mb-5">
                Badan Bank Tanah
            </span>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                {{ $halaman->judul }}
            </h1>

            <div class="h-1 w-20 bg-blue-500 mt-5 mb-5 rounded-full"></div>

            <p class="text-blue-100 text-sm md:text-base leading-relaxed max-w-2xl">
                Mengenal Badan Bank Tanah, visi dan misi, struktur organisasi,
                serta landasan hukum dalam pengelolaan tanah negara.
            </p>

        </div>

    </div>
</section>


{{-- =========================================================
    CONTENT
========================================================= --}}
<section class="bg-gray-50 py-14 md:py-20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- =================================================
            PROFIL BADAN BANK TANAH
        ================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">

            @php
                $images = [];
                if ($halaman->gambar) {
                    $images[] = $halaman->gambar;
                }
                if ($halaman->foto) {
                    $images[] = $halaman->foto;
                }
                $totalImages = count($images);
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-5">

                {{-- KOLOM GAMBAR --}}
                <div class="lg:col-span-2 bg-gray-100 relative overflow-hidden" style="min-height: 350px;">

                    @if ($totalImages > 0)
                        <div class="relative w-full h-full overflow-hidden" id="aboutSlider" style="min-height: 350px;">

                            <div class="flex transition-transform duration-500 ease-in-out h-full" id="aboutSliderTrack">

                                @foreach ($images as $index => $image)
                                    <div class="min-w-full h-full flex-shrink-0 flex items-center justify-center bg-gray-100">
                                        <img
                                            src="{{ asset('storage/' . $image) }}"
                                            alt="{{ $halaman->judul }} - Foto {{ $index + 1 }}"
                                            class="w-full h-full object-contain"
                                            style="max-height: 420px;"
                                        >
                                    </div>
                                @endforeach

                            </div>

                            @if ($totalImages > 1)
                                {{-- Tombol Navigasi --}}
                                <button type="button" class="slider-btn slider-prev" id="aboutSliderPrev">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="slider-btn slider-next" id="aboutSliderNext">
                                    <i class="fas fa-chevron-right"></i>
                                </button>

                                {{-- Dots --}}
                                <div class="slider-dots" id="aboutSliderDots">
                                    @foreach ($images as $index => $image)
                                        <button type="button" class="slider-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></button>
                                    @endforeach
                                </div>

                                {{-- Counter --}}
                                <div class="slider-counter">
                                    <span id="aboutSliderCurrent">1</span> / <span id="aboutSliderTotal">{{ $totalImages }}</span>
                                </div>
                            @endif

                        </div>

                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const track = document.getElementById('aboutSliderTrack');
                                const slides = track ? track.querySelectorAll('.min-w-full') : [];
                                const totalSlides = slides.length;

                                if (totalSlides <= 1) return;

                                let currentIndex = 0;
                                let autoSlideInterval = null;
                                const slideIntervalTime = 4000;

                                const prevBtn = document.getElementById('aboutSliderPrev');
                                const nextBtn = document.getElementById('aboutSliderNext');
                                const dots = document.querySelectorAll('.slider-dot');
                                const currentText = document.getElementById('aboutSliderCurrent');
                                const totalText = document.getElementById('aboutSliderTotal');

                                if (totalText) {
                                    totalText.textContent = totalSlides;
                                }

                                function goToSlide(index) {
                                    if (index < 0) index = totalSlides - 1;
                                    if (index >= totalSlides) index = 0;

                                    currentIndex = index;
                                    const offset = -index * 100;
                                    track.style.transform = 'translateX(' + offset + '%)';

                                    dots.forEach((dot, i) => {
                                        dot.classList.toggle('active', i === index);
                                    });

                                    if (currentText) {
                                        currentText.textContent = index + 1;
                                    }
                                }

                                function nextSlide() { goToSlide(currentIndex + 1); }
                                function prevSlide() { goToSlide(currentIndex - 1); }

                                function startAutoSlide() {
                                    stopAutoSlide();
                                    autoSlideInterval = setInterval(nextSlide, slideIntervalTime);
                                }

                                function stopAutoSlide() {
                                    if (autoSlideInterval) {
                                        clearInterval(autoSlideInterval);
                                        autoSlideInterval = null;
                                    }
                                }

                                if (prevBtn) {
                                    prevBtn.addEventListener('click', function() { prevSlide(); startAutoSlide(); });
                                }
                                if (nextBtn) {
                                    nextBtn.addEventListener('click', function() { nextSlide(); startAutoSlide(); });
                                }

                                dots.forEach((dot) => {
                                    dot.addEventListener('click', function() {
                                        const index = parseInt(this.dataset.slide);
                                        goToSlide(index);
                                        startAutoSlide();
                                    });
                                });

                                const sliderContainer = document.getElementById('aboutSlider');
                                if (sliderContainer) {
                                    sliderContainer.addEventListener('mouseenter', stopAutoSlide);
                                    sliderContainer.addEventListener('mouseleave', startAutoSlide);
                                }

                                document.addEventListener('keydown', function(e) {
                                    if (e.key === 'ArrowLeft') { prevSlide(); startAutoSlide(); }
                                    if (e.key === 'ArrowRight') { nextSlide(); startAutoSlide(); }
                                });

                                let touchStartX = 0;
                                let touchEndX = 0;
                                if (sliderContainer) {
                                    sliderContainer.addEventListener('touchstart', function(e) {
                                        touchStartX = e.changedTouches[0].screenX;
                                    }, { passive: true });

                                    sliderContainer.addEventListener('touchend', function(e) {
                                        touchEndX = e.changedTouches[0].screenX;
                                        const diff = touchStartX - touchEndX;
                                        if (Math.abs(diff) > 50) {
                                            if (diff > 0) { nextSlide(); } else { prevSlide(); }
                                            startAutoSlide();
                                        }
                                    }, { passive: true });
                                }

                                startAutoSlide();
                            });
                        </script>
                        @endpush

                    @else
                        {{-- Placeholder --}}
                        <div class="w-full h-full bg-[#0B2A4A] flex items-center justify-center" style="min-height: 350px;">
                            <div class="text-center px-8">
                                <div class="w-20 h-20 mx-auto rounded-2xl bg-white/10 flex items-center justify-center mb-5">
                                    <i class="fas fa-building-columns text-3xl text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white">Badan Bank Tanah</h3>
                                <p class="text-blue-200 text-sm mt-2">Indonesia Land Bank Authority</p>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- KOLOM KONTEN --}}
                <div class="lg:col-span-3 p-6 md:p-8 lg:p-10">

                    <span class="text-blue-700 text-xs font-bold uppercase tracking-wider">
                        Profil Lembaga
                    </span>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2 mb-4">
                        {{ $halaman->judul }}
                    </h2>

                    <div class="h-1 w-14 bg-blue-600 rounded-full mb-5"></div>

                    <div class="text-gray-600 leading-7 text-sm md:text-base">
                        {!! nl2br(e($halaman->isi)) !!}
                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
            VISI & MISI
        ================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 md:p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-eye text-blue-700 text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-700">Arah Lembaga</span>
                        <h2 class="text-2xl font-bold text-gray-900">Visi</h2>
                    </div>
                </div>
                <div class="border-l-4 border-blue-600 pl-5">
                    <p class="text-gray-600 leading-8 text-sm md:text-base">
                        {!! nl2br(e($halaman->visi ?? 'Visi Badan Bank Tanah ditampilkan berdasarkan konten resmi yang dikelola melalui CMS.')) !!}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 md:p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
                        <i class="fas fa-bullseye text-green-700 text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-green-700">Arah Strategis</span>
                        <h2 class="text-2xl font-bold text-gray-900">Misi</h2>
                    </div>
                </div>
                <div class="border-l-4 border-green-600 pl-5">
                    <p class="text-gray-600 leading-8 text-sm md:text-base whitespace-pre-line">
                        {!! nl2br(e($halaman->misi ?? 'Misi Badan Bank Tanah ditampilkan berdasarkan konten resmi yang dikelola melalui CMS.')) !!}
                    </p>
                </div>
            </div>

        </div>


        {{-- =================================================
            STRUKTUR ORGANISASI
        ================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 md:p-10 mb-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <span class="text-blue-700 text-xs font-bold uppercase tracking-wider">Tata Kelola</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Struktur Organisasi</h2>
                    <div class="h-1 w-14 bg-blue-600 rounded-full mt-4"></div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-sitemap text-blue-700 text-lg"></i>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-gray-50 p-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users text-blue-700 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-lg mb-3">Struktur Organisasi Badan Bank Tanah</h3>
                        <div class="text-gray-600 leading-7 text-sm whitespace-pre-line">
                            {!! nl2br(e($halaman->struktur_organisasi ?? 'Struktur organisasi ditampilkan berdasarkan data resmi yang dikelola melalui CMS Badan Bank Tanah.')) !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- =================================================
            DASAR HUKUM
        ================================================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 md:p-10">

            <div class="flex items-center gap-4 mb-7">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                    <i class="fas fa-scale-balanced text-amber-600 text-lg"></i>
                </div>
                <div>
                    <span class="text-amber-600 text-xs font-bold uppercase tracking-wider">Landasan</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Dasar Hukum</h2>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <div class="flex gap-4">
                    <div class="shrink-0 mt-1">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                            <i class="fas fa-file-lines text-amber-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">Landasan hukum Badan Bank Tanah</h3>
                        <div class="text-sm text-gray-500 leading-7 mt-2 whitespace-pre-line">
                            {!! nl2br(e($halaman->dasar_hukum ?? 'Informasi dasar hukum ditampilkan berdasarkan dokumen dan konten resmi yang dikelola melalui CMS.')) !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>

{{-- =========================================================
    STYLE SLIDER
========================================================= --}}
<style>
    /* Slider Container */
    #aboutSlider {
        min-height: 350px;
        position: relative;
        overflow: hidden;
        background: #f3f4f6;
    }

    #aboutSliderTrack {
        display: flex;
        height: 100%;
        transition: transform 0.5s ease-in-out;
        min-height: 350px;
    }

    #aboutSliderTrack .min-w-full {
        min-width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
    }

    #aboutSliderTrack img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        max-height: 420px;
    }

    /* Slider Button */
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .slider-btn:hover {
        background: rgba(0, 0, 0, 0.8);
        transform: translateY(-50%) scale(1.05);
    }

    .slider-prev {
        left: 12px;
    }

    .slider-next {
        right: 12px;
    }

    /* Dots */
    .slider-dots {
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 10;
    }

    .slider-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        border: 2px solid rgba(255, 255, 255, 0.2);
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
    }

    .slider-dot.active {
        background: white;
        border-color: white;
        transform: scale(1.15);
    }

    .slider-dot:hover {
        background: rgba(255, 255, 255, 0.7);
    }

    /* Counter */
    .slider-counter {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        z-index: 10;
        backdrop-filter: blur(4px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        #aboutSlider,
        #aboutSliderTrack,
        #aboutSliderTrack .min-w-full {
            min-height: 300px;
        }
    }

    @media (max-width: 640px) {
        #aboutSlider,
        #aboutSliderTrack,
        #aboutSliderTrack .min-w-full {
            min-height: 250px;
        }

        .slider-btn {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }

        .slider-prev {
            left: 8px;
        }
        .slider-next {
            right: 8px;
        }

        .slider-dot {
            width: 8px;
            height: 8px;
        }

        .slider-counter {
            font-size: 10px;
            padding: 2px 10px;
            top: 10px;
            right: 10px;
        }

        #aboutSliderTrack img {
            max-height: 300px;
        }
    }

    @media (max-width: 480px) {
        #aboutSlider,
        #aboutSliderTrack,
        #aboutSliderTrack .min-w-full {
            min-height: 200px;
        }

        #aboutSliderTrack img {
            max-height: 250px;
        }
    }
</style>

@endsection