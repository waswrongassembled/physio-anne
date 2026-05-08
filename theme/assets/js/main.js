// ── Theme URL für dynamische Image-Pfade ─────────
// (wird von WordPress via wp_localize_script gesetzt)
// var physioAnne = { themeUrl: '...' };  // gesetzt durch functions.php

// ── Sticky header ──────────────────────────────
const header = document.querySelector('.site-header');
if (header) {
  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 10);
  }, { passive: true });
}

// ── Hamburger menu ─────────────────────────────
const hamburger = document.querySelector('.hamburger');
const mobileNav = document.querySelector('.mobile-nav');
if (hamburger && mobileNav) {
  hamburger.addEventListener('click', () => {
    const open = hamburger.classList.toggle('open');
    mobileNav.classList.toggle('open', open);
    hamburger.setAttribute('aria-expanded', open);
  });
  // Close on link click
  mobileNav.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      hamburger.classList.remove('open');
      mobileNav.classList.remove('open');
    });
  });
}

// ── Hero slider ────────────────────────────────
(function () {
  const slides = document.querySelectorAll('.hero-figure');
  const dots   = document.querySelectorAll('.hero-dot');
  if (!slides.length) return;

  let current = 0;
  let timer;

  function goTo(idx) {
    slides[current].classList.remove('active');
    dots[current]?.classList.remove('active');
    current = (idx + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current]?.classList.add('active');
  }

  function next() { goTo(current + 1); }

  function start() {
    timer = setInterval(next, 5000);
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      clearInterval(timer);
      goTo(i);
      start();
    });
  });

  // Respect reduced motion
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    start();
  }
})();

// ── Active nav link ────────────────────────────
(function () {
  // Supports both static HTML (kontakt.html) and WP pretty permalinks (/kontakt/)
  var pathname = window.location.pathname.replace(/\/$/, '');
  var current = pathname.split('/').pop() || '';
  // Remove .html extension for static compatibility
  current = current.replace(/\.html$/, '');

  document.querySelectorAll('.main-nav a, .mobile-nav a').forEach(function(a) {
    var href = a.getAttribute('href')
      .replace(/\/$/, '')
      .split('/')
      .pop()
      .replace(/\.html$/, '');
    var isHome = (current === '' || current === 'index') && (href === '' || href === 'index');
    if (href === current || isHome) {
      a.classList.add('active');
    }
  });
})();
