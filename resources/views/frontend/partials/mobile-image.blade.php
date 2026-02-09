{{--
    Mobile-Optimized Image Component
    
    Usage:
    @include('frontend.partials.mobile-image', [
        'src' => 'image.jpg',
        'alt' => 'Image description',
        'class' => 'product-image',
        'lazy' => true,
        'width' => 400,
        'height' => 400
    ])
--}}

@php
    $lazy = $lazy ?? true;
    $class = $class ?? '';
    $width = $width ?? null;
    $height = $height ?? null;
    $isMobile = $is_mobile ?? false;
    
    // Generate image paths
    $imagePath = asset('images/' . $src);
    $webpPath = asset('images/' . pathinfo($src, PATHINFO_FILENAME) . '.webp');
    
    // Mobile-specific smaller image if available
    $mobileImagePath = $isMobile ? asset('images/mobile/' . $src) : $imagePath;
    
    // Lazy loading attributes
    $lazyClass = $lazy ? 'lazy' : '';
    $srcAttr = $lazy ? 'data-src' : 'src';
@endphp

@if($isMobile)
    {{-- Mobile: Use picture element with WebP support --}}
    <picture>
        <source 
            type="image/webp" 
            {{ $lazy ? 'data-srcset' : 'srcset' }}="{{ $webpPath }}"
        >
        <img 
            {{ $srcAttr }}="{{ $mobileImagePath }}"
            alt="{{ $alt }}"
            class="{{ $class }} {{ $lazyClass }}"
            @if($width) width="{{ $width }}" @endif
            @if($height) height="{{ $height }}" @endif
            @if($lazy) src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {{ $width ?? 400 }} {{ $height ?? 400 }}'%3E%3C/svg%3E" @endif
            loading="{{ $lazy ? 'lazy' : 'eager' }}"
            decoding="async"
            @if($width && $height) style="aspect-ratio: {{ $width }}/{{ $height }};" @endif
        >
    </picture>
@else
    {{-- Desktop: Standard image --}}
    <img 
        {{ $srcAttr }}="{{ $imagePath }}"
        alt="{{ $alt }}"
        class="{{ $class }} {{ $lazyClass }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        @if($lazy) src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {{ $width ?? 400 }} {{ $height ?? 400 }}'%3E%3C/svg%3E" @endif
        loading="{{ $lazy ? 'lazy' : 'eager' }}"
        decoding="async"
    >
@endif
