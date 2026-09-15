<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $microsite->meta_title ?? $microsite->judul }}</title>
    <meta name="description" content="{{ $microsite->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $microsite->seo_keywords ?? '' }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $microsite->meta_title ?? $microsite->judul }}">
    <meta property="og:description" content="{{ $microsite->meta_description ?? '' }}">
    <meta property="og:type" content="website">
    @if($microsite->image_url)
    <meta property="og:image" content="{{ $microsite->image_url }}">
    @endif
    
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .microsite-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }
        .microsite-header {
            background: linear-gradient(135deg, #0B2A4A, #1a4a6e);
            color: white;
            padding: 4rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        .microsite-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        .microsite-content {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            line-height: 1.8;
        }
        .microsite-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }
        
        /* Custom CSS dari database */
        {!! $microsite->custom_css !!}
    </style>
    
    @if($microsite->custom_js)
    <script>
        {!! $microsite->custom_js !!}
    </script>
    @endif
</head>
<body>
    <div class="microsite-container">
        <!-- Header -->
        <div class="microsite-header">
            @if($microsite->gambar)
                <img src="{{ $microsite->image_url }}" alt="{{ $microsite->judul }}" 
                     class="w-full max-h-96 object-cover rounded-xl mb-6" loading="lazy">
            @endif
            <h1>{{ $microsite->judul }}</h1>
            @if($microsite->tanggal_mulai || $microsite->tanggal_selesai)
                <p class="text-blue-200">
                    <i class="far fa-calendar-alt mr-2"></i>
                    @if($microsite->tanggal_mulai)
                        {{ \Carbon\Carbon::parse($microsite->tanggal_mulai)->format('d M Y') }}
                    @endif
                    @if($microsite->tanggal_selesai)
                        - {{ \Carbon\Carbon::parse($microsite->tanggal_selesai)->format('d M Y') }}
                    @endif
                </p>
            @endif
        </div>
        
        <!-- Content -->
        <div class="microsite-content">
            {!! $microsite->konten !!}
        </div>
        
        <!-- Footer -->
        <div class="text-center text-gray-400 text-sm mt-8 pt-4 border-t border-gray-200">
            <p>© {{ date('Y') }} Badan Bank Tanah</p>
            <a href="{{ route('home') }}" class="text-[#006400] hover:underline">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>