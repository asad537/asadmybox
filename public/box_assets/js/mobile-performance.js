/**
 * Mobile Performance Optimization Script
 * Handles lazy loading, image optimization, and performance enhancements
 */

(function () {
    'use strict';

    // Defer non-critical CSS loading
    function loadDeferredStyles() {
        const addStylesNode = document.getElementById('deferred-styles');
        if (addStylesNode) {
            const replacement = document.createElement('div');
            replacement.innerHTML = addStylesNode.textContent;
            document.body.appendChild(replacement);
            addStylesNode.parentElement.removeChild(addStylesNode);
        }
    }

    // Native lazy loading fallback for older browsers
    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            // Browser supports native lazy loading - just ensure data-src is set if lazy load class is present
            const images = document.querySelectorAll('img.lazy');
            images.forEach(img => {
                if (img.dataset.src && !img.src) {
                    img.src = img.dataset.src;
                }
                if (img.dataset.srcset && !img.srcset) {
                    img.srcset = img.dataset.srcset;
                }
            });
        } else {
            // Fallback to Intersection Observer
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                        }
                        if (img.dataset.srcset) {
                            img.srcset = img.dataset.srcset;
                        }
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '200px 0px', // Load earlier for smoother experience
                threshold: 0.01
            });

            const lazyImages = document.querySelectorAll('img.lazy');
            lazyImages.forEach(img => imageObserver.observe(img));
        }
    }

    // Optimize images based on device pixel ratio
    function optimizeImageQuality() {
        // Only run if supported
        if (!('imageRendering' in document.documentElement.style)) return;

        const dpr = window.devicePixelRatio || 1;
        const images = document.querySelectorAll('img[data-optimize]');

        images.forEach(img => {
            if (dpr > 1) {
                img.style.imageRendering = '-webkit-optimize-contrast';
            }
        });
    }

    // Preload critical images - Updated to use requestIdleCallback for better performance
    function preloadCriticalImages() {
        const preloading = () => {
            const criticalImages = document.querySelectorAll('img[fetchpriority="high"]');
            criticalImages.forEach(img => {
                const link = document.createElement('link');
                link.rel = 'preload';
                link.as = 'image';
                link.href = img.src;
                if (img.srcset) link.imagesrcset = img.srcset;
                if (img.sizes) link.imagesizes = img.sizes;
                document.head.appendChild(link);
            });
        };

        if ('requestIdleCallback' in window) {
            window.requestIdleCallback(preloading);
        } else {
            preloading();
        }
    }

    // Reduce layout shift by setting image dimensions
    // Optimized to avoid forced reflow by using requestAnimationFrame
    function preventLayoutShift() {
        const images = document.querySelectorAll('img:not([width]):not([height])');
        if (images.length === 0) return;

        requestAnimationFrame(() => {
            images.forEach(img => {
                // If it's already loaded or in cache, we can get dimensions without a reflow
                if (img.complete && img.naturalWidth) {
                    img.setAttribute('width', img.naturalWidth);
                    img.setAttribute('height', img.naturalHeight);
                }
            });
        });
    }

    // Initialize on DOM ready
    function initAll() {
        initLazyLoading();
        optimizeImageQuality();
        preventLayoutShift();
        preloadCriticalImages();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    // Load deferred styles after page load
    window.addEventListener('load', loadDeferredStyles, { passive: true });

    // Optimize font loading
    if ('fonts' in document) {
        // Use a simpler approach to avoid large promises if not needed
        document.fonts.ready.then(function () {
            document.documentElement.classList.add('fonts-loaded');
        });
    }

})();

