/**
 * Physio Anne – minimal JS (mobile menu, hero slider).
 * Uses js- prefixed selectors; no dependencies.
 */
(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const navToggle = document.querySelector('.js-nav-toggle');
    const navMain = document.querySelector('.js-nav-main');

    if (navToggle && navMain) {
        navToggle.addEventListener('click', function () {
            navMain.classList.toggle('is-open');
            const isOpen = navMain.classList.contains('is-open');
            navToggle.setAttribute('aria-expanded', isOpen);
        });
    }

    /* Hero slider: wechselnde Bilder beim Start (wie Live-Seite). */
    const slides = document.querySelectorAll('.hero-slider__slide');

    if (slides.length > 0 && !prefersReducedMotion) {
        let currentIndex = 0;
        const intervalMs = 4500;

        function showSlide(index) {
            const next = (index + slides.length) % slides.length;
            slides.forEach(function (slide, i) {
                slide.classList.toggle('is-active', i === next);
            });
            currentIndex = next;
        }

        setInterval(function () {
            showSlide(currentIndex + 1);
        }, intervalMs);
    }

    /* Kundenfeedbacks: einfacher Carousel (wechselt alle 6 s). */
    const testimonialItems = document.querySelectorAll('.testimonials__item');
    if (testimonialItems.length > 1 && !prefersReducedMotion) {
        let testimonialIndex = 0;
        setInterval(function () {
            testimonialItems[testimonialIndex].classList.remove('is-active');
            testimonialIndex = (testimonialIndex + 1) % testimonialItems.length;
            testimonialItems[testimonialIndex].classList.add('is-active');
        }, 6000);
    }
})();
