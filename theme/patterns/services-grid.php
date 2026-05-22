<?php
/**
 * Title: Leistungen – Service Grid
 * Slug: physio-anne/services-grid
 * Categories: physio-anne
 * Description: Vier Service-Karten (Manuelle Therapie, Aktive Übungen, Atemtherapie, Beckenbodentherapie)
 */
?>
<!-- wp:html -->
<section class="section section--alt" aria-labelledby="services-heading">
  <div class="container">
    <div class="section-header">
      <p class="eyebrow">Leistungen</p>
      <h2 id="services-heading">Was ich für Sie tun kann</h2>
      <p>Ob nach einer Operation, bei chronischen Schmerzen oder zur Prävention – ich begleite Sie auf Ihrem Weg zur Beweglichkeit und Lebensqualität.</p>
    </div>
    <div class="services-grid">
      <article class="service-card">
        <div class="service-card-img">
          <picture>
            <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-manuelle.webp" type="image/webp">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-manuelle.jpg" alt="Manuelle Therapie" loading="lazy" width="2048" height="1363" data-pagespeed-no-transform>
          </picture>
        </div>
        <div class="service-card-body">
          <h3>Manuelle Therapie</h3>
          <p>Gezielte Handgriffe zur Mobilisierung von Gelenken, Lösung von Verspannungen und Verbesserung der Beweglichkeit.</p>
        </div>
      </article>
      <article class="service-card">
        <div class="service-card-img">
          <picture>
            <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-uebungen.webp" type="image/webp">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-uebungen.jpg" alt="Aktive Übungen" loading="lazy" width="2048" height="1363" data-pagespeed-no-transform>
          </picture>
        </div>
        <div class="service-card-body">
          <h3>Aktive Übungen</h3>
          <p>Individuelle Kräftigungs- und Beweglichkeitsübungen, die auf Ihre persönlichen Bedürfnisse abgestimmt sind.</p>
        </div>
      </article>
      <article class="service-card">
        <div class="service-card-img">
          <picture>
            <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-atem.webp" type="image/webp">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-atem.jpg" alt="Atemtherapie" loading="lazy" width="2048" height="1363" data-pagespeed-no-transform>
          </picture>
        </div>
        <div class="service-card-body">
          <h3>Atemtherapie</h3>
          <p>Bewusste Atemtechniken zur Verbesserung der Lungenfunktion, Entspannung und Körperwahrnehmung.</p>
        </div>
      </article>
      <article class="service-card">
        <div class="service-card-img">
          <picture>
            <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-beckenboden.webp" type="image/webp">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-beckenboden.jpg" alt="Beckenbodentherapie" loading="lazy" width="2048" height="1362" data-pagespeed-no-transform>
          </picture>
        </div>
        <div class="service-card-body">
          <h3>Beckenbodentherapie</h3>
          <p>Spezialisiertes Training zur Stärkung und Entspannung der Beckenbodenmuskulatur – für Frauen und Männer.</p>
        </div>
      </article>
    </div>
    <div style="text-align:center; margin-top: 48px;">
      <a href="/leistungen/" class="btn btn-primary">Alle Leistungen im Detail</a>
    </div>
  </div>
</section>
<!-- /wp:html -->
