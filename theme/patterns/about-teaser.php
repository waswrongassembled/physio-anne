<?php
/**
 * Title: Über Anne – Teaser
 * Slug: physio-anne/about-teaser
 * Categories: physio-anne
 * Description: Zweispaltiger Über-mich-Teaser mit Foto und Text (Startseite)
 */
?>
<!-- wp:html -->
<section class="section" aria-labelledby="about-heading">
  <div class="container">
    <div class="about-split">
      <div class="about-split-img">
        <picture>
          <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about-col.webp" type="image/webp">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about-col.jpg" alt="Anne Günthner, Physiotherapeutin" loading="lazy" width="768" height="1200">
        </picture>
      </div>
      <div class="about-split-text">
        <p class="eyebrow">Über mich</p>
        <h2 id="about-heading">Anne Günthner –<br>Ihre Physiotherapeutin</h2>
        <p>Ich bin staatlich geprüfte Physiotherapeutin seit 2012 und lebe seit 2014 in Vorarlberg. In meiner Arbeit steht der Mensch, der zu mir kommt, stets im Vordergrund.</p>
        <p>Mein Ziel ist es, die Beschwerden des Körpers zu verstehen und Ihnen zu helfen, damit umzugehen – einfühlsam, individuell und nachhaltig.</p>
        <a href="/ueber-mich/" class="btn btn-outline">Mehr über mich erfahren</a>
      </div>
    </div>
  </div>
</section>
<!-- /wp:html -->
