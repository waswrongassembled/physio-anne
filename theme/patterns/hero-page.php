<?php
/**
 * Title: Hero – Über mich
 * Slug: physio-anne/hero-page
 * Categories: physio-anne
 * Description: Hero für die Seite „Über mich"
 */
?>
<!-- wp:html -->
<div class="page-hero">
  <picture>
    <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about-hero.webp" type="image/webp">
    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about-hero.jpg" alt="Anne Günthner, Physiotherapeutin in Feldkirch" loading="eager" fetchpriority="high" width="1280" height="500">
  </picture>
  <div class="page-hero-overlay">
    <div class="container">
      <div class="page-hero-text">
        <p class="eyebrow">Über mich</p>
        <h1>Anne Günthner</h1>
      </div>
    </div>
  </div>
</div>
<!-- /wp:html -->
