@props([
    'src' => '',
    'alt' => '',
    'class' => '',
    'placeholder' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"%3E%3Crect width="100" height="100" fill="%23f3f4f6"/%3E%3C/svg%3E',
    'width' => null,
    'height' => null,
])

@php
    $id = 'img-' . uniqid();
@endphp

<div class="lazy-container {{ $class }}" style="{{ $width ? 'width:'.$width.';' : '' }}{{ $height ? 'height:'.$height.';' : '' }}">
    <img id="{{ $id }}" 
         data-src="{{ $src }}" 
         src="{{ $placeholder }}" 
         alt="{{ $alt }}"
         class="lazy-load w-full h-full object-cover transition-opacity duration-500"
         style="opacity:0;"
         loading="lazy"
         width="{{ $width }}"
         height="{{ $height }}">
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const img = document.getElementById('{{ $id }}');
    if (img) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const imgEl = entry.target;
                    const src = imgEl.dataset.src;
                    if (src) {
                        const tempImg = new Image();
                        tempImg.onload = function() {
                            imgEl.src = src;
                            imgEl.style.opacity = '1';
                            imgEl.removeAttribute('data-src');
                        };
                        tempImg.src = src;
                    }
                    observer.unobserve(imgEl);
                }
            });
        });
        observer.observe(img);
    }
});
</script>
@endpush