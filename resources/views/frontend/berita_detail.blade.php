@extends('layouts.frontend')

@section('title', $berita->judul . ' - Badan Bank Tanah')

@section('content')

{{-- =========================================================
    HERO / HEADER
========================================================= --}}
<section class="relative bg-[#0B2A4A] overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-green-500 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20">
        <div class="max-w-3xl">
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="inline-flex items-center gap-1.5 bg-white/10 border border-white/10 text-blue-200 text-[10px] sm:text-xs font-semibold px-3 py-1.5 rounded-full">
                    <i class="fas fa-newspaper"></i>
                    {{ $berita->kategori }}
                </span>
                <span class="text-blue-300/50 text-xs">•</span>
                <span class="text-blue-300/70 text-xs flex items-center gap-1.5">
                    <i class="far fa-calendar-alt"></i>
                    {{ $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') : $berita->created_at->format('d M Y') }}
                </span>
                <span class="text-blue-300/50 text-xs">•</span>
                <span class="text-blue-300/70 text-xs flex items-center gap-1.5">
                    <i class="far fa-eye"></i>
                    {{ number_format($berita->views ?? 0, 0, ',', '.') }} Dilihat
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                {{ $berita->judul }}
            </h1>
            <div class="flex items-center gap-3 mt-4">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white/10 flex items-center justify-center text-white font-bold text-xs sm:text-sm">
                    {{ strtoupper(substr($berita->penulis, 0, 1)) }}
                </div>
                <div>
                    <p class="text-white text-sm font-medium">{{ $berita->penulis }}</p>
                    <p class="text-blue-300/60 text-xs">Penulis</p>
                </div>
            </div>
            <div class="h-1 w-16 bg-blue-500 mt-6 rounded-full"></div>
        </div>
    </div>
</section>

{{-- =========================================================
    MAIN CONTENT
========================================================= --}}
<section class="bg-gray-50 py-8 sm:py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Gambar Utama --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="relative">
                @if ($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}"
                        class="w-full h-[200px] sm:h-[300px] md:h-[400px] object-cover"
                        alt="{{ $berita->judul }}">
                @else
                    <div class="w-full h-[200px] sm:h-[300px] md:h-[400px] bg-gradient-to-br from-[#0B2A4A] to-[#163F66] flex items-center justify-center">
                        <div class="text-center text-white/30">
                            <i class="fas fa-newspaper text-5xl sm:text-6xl md:text-7xl mb-3"></i>
                            <p class="text-sm">Gambar tidak tersedia</p>
                        </div>
                    </div>
                @endif

                {{-- Badge Kategori --}}
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center gap-1.5 bg-white/95 backdrop-blur-sm text-[#0B2A4A] text-[10px] sm:text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                        <i class="fas
                            {{ $berita->kategori == 'Siaran Pers' ? 'fa-bullhorn' :
                               ($berita->kategori == 'Pengumuman' ? 'fa-circle-info' :
                               'fa-newspaper') }}">
                        </i>
                        {{ $berita->kategori }}
                    </span>
                </div>

                {{-- Share Button --}}
                <div class="absolute bottom-4 right-4 flex gap-2">
                    <button onclick="shareArticle()" class="bg-white/95 backdrop-blur-sm hover:bg-white text-[#0B2A4A] w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shadow-md transition hover:scale-110">
                        <i class="fas fa-share-alt text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Konten Berita --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 md:p-10 mb-8">
            <div class="prose prose-sm sm:prose-base md:prose-lg max-w-none">
                {!! nl2br(e($berita->konten)) !!}
            </div>

            {{-- Meta Info --}}
            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-calendar-alt"></i>
                        {{ $berita->created_at->format('d F Y H:i') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-user"></i>
                        {{ $berita->penulis }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-eye"></i>
                        {{ number_format($berita->views ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Share Buttons --}}
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-400 mr-1">Bagikan:</span>
                    <button onclick="shareTo('facebook')" class="w-8 h-8 rounded-full bg-[#1877F2]/10 text-[#1877F2] hover:bg-[#1877F2] hover:text-white transition flex items-center justify-center">
                        <i class="fab fa-facebook-f text-xs"></i>
                    </button>
                    <button onclick="shareTo('twitter')" class="w-8 h-8 rounded-full bg-[#000000]/10 text-[#000000] hover:bg-[#000000] hover:text-white transition flex items-center justify-center">
                        <i class="fab fa-x-twitter text-xs"></i>
                    </button>
                    <button onclick="shareTo('linkedin')" class="w-8 h-8 rounded-full bg-[#0A66C2]/10 text-[#0A66C2] hover:bg-[#0A66C2] hover:text-white transition flex items-center justify-center">
                        <i class="fab fa-linkedin-in text-xs"></i>
                    </button>
                    <button onclick="shareTo('whatsapp')" class="w-8 h-8 rounded-full bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white transition flex items-center justify-center">
                        <i class="fab fa-whatsapp text-xs"></i>
                    </button>
                    <button onclick="copyLink()" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-[#006400] hover:text-white transition flex items-center justify-center">
                        <i class="fas fa-link text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Navigasi Publikasi --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @php
                $prev = \App\Models\Berita::where('id', '<', $berita->id)
                        ->where('status', 'Dipublikasikan')
                        ->orderBy('id', 'desc')
                        ->first();
                $next = \App\Models\Berita::where('id', '>', $berita->id)
                        ->where('status', 'Dipublikasikan')
                        ->orderBy('id', 'asc')
                        ->first();
            @endphp

            @if ($prev)
            <a href="{{ route('publications.show', $prev->id) }}"
                class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:border-[#006400] hover:shadow-md transition">
                <i class="fas fa-arrow-left text-[#006400] text-sm group-hover:-translate-x-1 transition"></i>
                <div class="min-w-0 flex-1">
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider">Sebelumnya</p>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 group-hover:text-[#006400] transition truncate">{{ $prev->judul }}</p>
                </div>
            </a>
            @else
            <div></div>
            @endif

            @if ($next)
            <a href="{{ route('publications.show', $next->id) }}"
                class="group flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 hover:border-[#006400] hover:shadow-md transition sm:justify-end">
                <div class="min-w-0 flex-1 text-right">
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider">Selanjutnya</p>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 group-hover:text-[#006400] transition truncate">{{ $next->judul }}</p>
                </div>
                <i class="fas fa-arrow-right text-[#006400] text-sm group-hover:translate-x-1 transition"></i>
            </a>
            @else
            <div></div>
            @endif
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-8 text-center">
            <a href="{{ route('publications') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#006400] transition">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Publikasi
            </a>
        </div>

        {{-- Publikasi Terkait --}}
        @php
            $related = \App\Models\Berita::where('kategori', $berita->kategori)
                        ->where('id', '!=', $berita->id)
                        ->where('status', 'Dipublikasikan')
                        ->latest()
                        ->take(3)
                        ->get();
        @endphp

        @if ($related->count() > 0)
        <div class="mt-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-6 bg-[#006400] rounded-full"></div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900">Publikasi Terkait</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach ($related as $item)
                <a href="{{ route('publications.show', $item->id) }}"
                    class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-lg transition">
                    <div class="h-36 sm:h-40 bg-gray-200 relative overflow-hidden">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                alt="{{ $item->judul }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B2A4A] to-[#163F66]">
                                <i class="fas fa-newspaper text-white/20 text-3xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="text-[8px] font-bold uppercase px-2 py-0.5 rounded-full bg-white/95 text-[#0B2A4A]">
                                {{ $item->kategori }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="text-xs sm:text-sm font-bold text-gray-900 line-clamp-2 group-hover:text-[#006400] transition">
                            {{ $item->judul }}
                        </h4>
                        <p class="text-[10px] text-gray-400 mt-1.5 flex items-center gap-2">
                            <i class="far fa-calendar-alt"></i>
                            {{ $item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') : $item->created_at->format('d M Y') }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Share Functions
    function shareArticle() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $berita->judul }}',
                text: '{{ Str::limit(strip_tags($berita->konten), 150) }}',
                url: window.location.href
            }).catch(() => {});
        } else {
            // Fallback: copy link
            copyLink();
        }
    }

    function shareTo(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ $berita->judul }}');
        let shareUrl = '';

        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                break;
            default:
                return;
        }

        window.open(shareUrl, '_blank', 'width=600,height=500');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-24 left-1/2 -translate-x-1/2 bg-[#006400] text-white px-6 py-3 rounded-xl shadow-lg text-sm font-medium z-50 animate-fade-up';
            toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Link berhasil disalin!';
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }).catch(() => {
            // Fallback
            const input = document.createElement('input');
            input.value = window.location.href;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            input.remove();
            alert('Link berhasil disalin!');
        });
    }
</script>
@endpush