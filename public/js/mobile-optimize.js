/**
 * Mobile Performance Optimization Script
 * Handles lazy loading, image optimization, and performance improvements
 */

(function() {
    'use strict';

    // Configuration
    const config = {
        imageQuality: 75,
        lazyLoadThreshold: '50px',
        enableWebP: true,
        deferImages: true
    };

    /**
     * Lazy Load Images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        
                        // Load the image
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                        }
                        
                        if (img.dataset.srcset) {
                            img.srcset = img.dataset.srcset;
                        }
                        
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: config.lazyLoadThreshold
            });

            // Observe all lazy images
            document.querySelectorAll('img.lazy').forEach(img => {
                imageObserver.observe(img);
            });
        } else {
            // Fallback for browsers without IntersectionObserver
            loadAllImages();
        }
    }

    /**
     * Fallback: Load all images immediately
     */
    function loadAllImages() {
        document.querySelectorAll('img.lazy').forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
            if (img.dataset.srcset) {
                img.srcset = img.dataset.srcset;
            }
            img.classList.remove('lazy');
            img.classList.add('loaded');
        });
    }

    /**
     * Optimize images for mobile
     */
    function optimizeImages() {
        const images = document.querySelectorAll('img[data-mobile-src]');
        
        images.forEach(img => {
            if (window.innerWidth <= 768 && img.dataset.mobileSrc) {
                img.src = img.dataset.mobileSrc;
            }
        });
    }

    /**
     * Defer non-critical CSS
     */
    function deferCSS() {
        const deferredStyles = document.querySelectorAll('link[data-defer]');
        
        deferredStyles.forEach(link => {
            link.rel = 'stylesheet';
            link.removeAttribute('data-defer');
        });
    }

    /**
     * Preload critical resources
     */
    function preloadCriticalResources() {
        // Preload hero image
        const heroImage = document.querySelector('[data-hero-image]');
        if (heroImage && heroImage.dataset.heroImage) {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'image';
            link.href = heroImage.dataset.heroImage;
            document.head.appendChild(link);
        }
    }

    /**
     * Reduce animations on low-end devices
     */
    function optimizeAnimations() {
        // Check if device prefers reduced motion
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.classList.add('reduce-motion');
        }

        // Disable animations on low-end devices
        if (navigator.hardwareConcurrency && navigator.hardwareConcurrency <= 2) {
            document.documentElement.classList.add('low-end-device');
        }
    }

    /**
     * Optimize third-party scripts
     */
    function optimizeThirdPartyScripts() {
        // Delay loading of non-critical third-party scripts
        const scripts = document.querySelectorAll('script[data-delay]');
        
        const loadScript = () => {
            scripts.forEach(script => {
                if (script.dataset.src) {
                    script.src = script.dataset.src;
                    script.removeAttribute('data-delay');
                }
            });
        };

        // Load after user interaction or after 3 seconds
        let loaded = false;
        const load = () => {
            if (!loaded) {
                loaded = true;
                loadScript();
            }
        };

        ['scroll', 'touchstart', 'click'].forEach(event => {
            window.addEventListener(event, load, { once: true, passive: true });
        });

        setTimeout(load, 3000);
    }

    /**
     * Service Worker Registration (for caching)
     */
    function registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {
                    // Silently fail if service worker registration fails
                });
            });
        }
    }

    /**
     * Reduce layout shifts
     */
    function preventLayoutShifts() {
        // Add aspect ratio boxes for images without dimensions
        document.querySelectorAll('img:not([width]):not([height])').forEach(img => {
            img.style.aspectRatio = '16/9';
        });
    }

    /**
     * Initialize all optimizations
     */
    function init() {
        // Run immediately
        preloadCriticalResources();
        optimizeAnimations();
        preventLayoutShifts();

        // Run after DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                initLazyLoading();
                optimizeImages();
                optimizeThirdPartyScripts();
            });
        } else {
            initLazyLoading();
            optimizeImages();
            optimizeThirdPartyScripts();
        }

        // Run after page load
        window.addEventListener('load', () => {
            deferCSS();
            registerServiceWorker();
        });

        // Handle orientation changes
        window.addEventListener('orientationchange', () => {
            setTimeout(optimizeImages, 100);
        });
    }

    // Start optimization
    init();

    // Expose API for manual control
    window.MobileOptimize = {
        loadAllImages,
        optimizeImages,
        deferCSS
    };

})();
