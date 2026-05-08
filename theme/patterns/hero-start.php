<?php
/**
 * Title: Hero Startseite
 * Slug: physio-anne/hero-start
 * Categories: physio-anne
 * Description: Hero Slider mit 3 freigestellten Figuren (Startseite)
 */
?>
<!-- wp:html -->
<section class="hero" aria-label="Willkommen bei Physio Anne">
  <div class="hero-overlay"></div>

  <!-- Freigestellte Figur rechts -->
  <div class="hero-figures" aria-hidden="true">
    <div class="hero-figure active">
      <picture>
        <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide1-sm.webp" type="image/webp" media="(max-width: 768px)">
        <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide1.webp" type="image/webp">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide1.png" alt="" loading="eager" fetchpriority="high">
      </picture>
    </div>
    <div class="hero-figure">
      <picture>
        <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide2-sm.webp" type="image/webp" media="(max-width: 768px)">
        <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide2.webp" type="image/webp">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide2.png" alt="" loading="lazy">
      </picture>
    </div>
    <div class="hero-figure">
      <picture>
        <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide3-sm.webp" type="image/webp" media="(max-width: 768px)">
        <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide3.webp" type="image/webp">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-slide3.png" alt="" loading="lazy">
      </picture>
    </div>
  </div>

  <!-- Text links -->
  <div class="hero-content">
    <div class="container">
      <div class="hero-text">
        <p class="eyebrow">Physiotherapie Feldkirch</p>
        <h1>Ich freue mich,<br>dass Sie <em>hier</em> sind.</h1>
        <p>Herzlich Willkommen bei Physio Anne – Ihrer Praxis für individuelle Physiotherapie in Feldkirch.</p>
        <div class="hero-btns">
          <a href="/kontakt/" class="btn btn-accent">Termin anfragen</a>
          <a href="/leistungen/" class="btn btn-outline">Leistungen entdecken</a>
        </div>
      </div>
    </div>
  </div>

  <div class="hero-dots" aria-hidden="true">
    <button class="hero-dot active" aria-label="Bild 1"></button>
    <button class="hero-dot" aria-label="Bild 2"></button>
    <button class="hero-dot" aria-label="Bild 3"></button>
  </div>
</section>
<!-- /wp:html -->
