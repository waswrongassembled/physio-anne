<?php
/**
 * Title: Leistungen – Details
 * Slug: physio-anne/services-detail
 * Categories: physio-anne
 * Description: 4 Leistungen als alternierende Bild-Text-Sektionen mit Hands-on/off Kategorien
 */
?>
<!-- wp:html -->
<section class="section" style="padding-top: 0;" aria-label="Leistungen im Detail">
  <div class="container">

    <div class="service-category">
      <p class="eyebrow">Hands-on</p>
      <p>Passive Behandlung – ich arbeite direkt an Ihrem Körper.</p>
    </div>

    <div class="service-detail">
      <div class="service-detail-img">
        <picture>
          <source type="image/webp" srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-manuelle-sm.webp 800w, <?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-manuelle.webp 2048w" sizes="(max-width: 900px) 100vw, 50vw">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-manuelle.jpg" alt="Manuelle Therapie" loading="eager" fetchpriority="high" width="2048" height="1363">
        </picture>
      </div>
      <div class="service-detail-text">
        <p class="eyebrow">Leistung 01</p>
        <h3>Manuelle Therapie</h3>
        <p>Die Manuelle Therapie ist eine spezialisierte Form der Physiotherapie, bei der gezielte Handgriffe eingesetzt werden, um Bewegungseinschränkungen zu lösen und Schmerzen zu lindern.</p>
        <p>Ich arbeite mit sanften Mobilisierungstechniken an Gelenken und Weichteilen. Ziel ist es, die natürliche Beweglichkeit wiederherzustellen und Muskelspannungen zu reduzieren.</p>
        <p><strong>Geeignet bei:</strong> Rückenschmerzen, Nackenschmerzen, Schulter- und Knieproblemen, nach Operationen, Sportverletzungen.</p>
      </div>
    </div>

    <div class="service-category service-category--primary service-category--spacer">
      <p class="eyebrow">Hands-off</p>
      <p>Aktive Therapie – Sie arbeiten selbst, ich begleite und leite an.</p>
    </div>

    <div class="service-detail reverse">
      <div class="service-detail-img">
        <picture>
          <source type="image/webp" srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-uebungen-sm.webp 800w, <?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-uebungen.webp 2048w" sizes="(max-width: 900px) 100vw, 50vw">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-uebungen.jpg" alt="Aktive Übungen" loading="lazy" width="2048" height="1363">
        </picture>
      </div>
      <div class="service-detail-text">
        <p class="eyebrow">Leistung 02</p>
        <h3>Aktive Übungen</h3>
        <p>Aktive Übungen sind ein wesentlicher Bestandteil der Physiotherapie. Durch gezieltes Training stärken wir die Muskulatur, verbessern die Koordination und unterstützen den Heilungsprozess.</p>
        <p>Ich erstelle für Sie ein individuelles Übungsprogramm, das Sie auch zu Hause weiterführen können. So bleiben Sie aktiv und erzielen nachhaltige Ergebnisse.</p>
        <p><strong>Geeignet bei:</strong> Muskelaufbau nach Verletzungen, Haltungskorrektur, Sturzprophylaxe, Rückenproblematiken.</p>
      </div>
    </div>

    <div class="service-detail">
      <div class="service-detail-img">
        <picture>
          <source type="image/webp" srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-atem-sm.webp 800w, <?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-atem.webp 2048w" sizes="(max-width: 900px) 100vw, 50vw">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-atem.jpg" alt="Atemtherapie" loading="lazy" width="2048" height="1363" style="object-position: right center;">
        </picture>
      </div>
      <div class="service-detail-text">
        <p class="eyebrow">Leistung 03</p>
        <h3>Atemtherapie</h3>
        <p>Atmen ist die grundlegendste Funktion unseres Körpers – und doch atmen viele von uns unbewusst und ineffizient. Die Atemtherapie hilft, die Atmung neu zu entdecken und zu verbessern.</p>
        <p>Durch bewusste Atemtechniken lassen sich Lungenkapazität, Entspannungsfähigkeit und allgemeines Wohlbefinden deutlich steigern.</p>
        <p><strong>Geeignet bei:</strong> Lungenproblemen, Asthma, Stress, Atemwegserkrankungen, postoperativer Nachsorge.</p>
      </div>
    </div>

    <div class="service-detail reverse">
      <div class="service-detail-img">
        <picture>
          <source type="image/webp" srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-beckenboden-sm.webp 800w, <?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-beckenboden.webp 2048w" sizes="(max-width: 900px) 100vw, 50vw">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-beckenboden.jpg" alt="Beckenbodentherapie" loading="lazy" width="2048" height="1362">
        </picture>
      </div>
      <div class="service-detail-text">
        <p class="eyebrow">Leistung 04</p>
        <h3>Beckenbodentherapie</h3>
        <p>Der Beckenboden ist eine oft unterschätzte Muskelgruppe, die eine zentrale Rolle für unsere Gesundheit, Stabilität und Lebensqualität spielt.</p>
        <p>In der Beckenbodentherapie erarbeiten wir gemeinsam ein Bewusstsein für diese Muskulatur und trainieren gezielt Kräftigung oder – wo nötig – Entspannung.</p>
        <p><strong>Geeignet bei:</strong> Inkontinenz, nach der Geburt, bei Beckenschmerzen, Senkungsbeschwerden, für Frauen und Männer.</p>
      </div>
    </div>

  </div>
</section>
<!-- /wp:html -->
