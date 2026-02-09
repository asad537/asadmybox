{{-- Mobile-Specific Head Optimizations --}}
@if(isset($is_mobile) && $is_mobile)
<!-- Mobile Viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">

<!-- Resource Hints for Mobile -->
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://www.google-analytics.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://www.google-analytics.com">

<!-- Critical CSS Inline for Mobile -->
<style>
{!! file_get_contents(public_path('css/mobile-critical.css')) !!}
</style>

<!-- Defer Non-Critical CSS -->
<link rel="preload" href="{{ asset('css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>

<!-- Preload Hero Image -->
@if(isset($slider_banner) && $slider_banner)
<link rel="preload" as="image" href="{{ asset('images/' . $slider_banner) }}" imagesrcset="{{ asset('images/' . $slider_banner) }} 768w" imagesizes="100vw">
@endif

<!-- Mobile Optimization Script -->
<script>
// Inline critical performance script
(function() {
    // Add mobile class to html
    document.documentElement.classList.add('mobile-device');
    
    // Detect connection speed
    if ('connection' in navigator) {
        const conn = navigator.connection;
        if (conn.effectiveType === 'slow-2g' || conn.effectiveType === '2g') {
            document.documentElement.classList.add('slow-connection');
        }
    }
    
    // Reduce animations on low-end devices
    if (navigator.hardwareConcurrency && navigator.hardwareConcurrency <= 2) {
        document.documentElement.classList.add('low-end-device');
    }
})();
</script>

<!-- Defer Mobile Optimization Script -->
<script src="{{ asset('js/mobile-optimize.js') }}" defer></script>

@else
<!-- Desktop Viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Standard CSS -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endif

<!-- Common Meta Tags -->
<meta name="theme-color" content="#667eea">
<meta name="format-detection" content="telephone=no">
