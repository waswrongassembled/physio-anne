<?php
/**
 * Title: Kontakt – Vollseite
 * Slug: physio-anne/contact-full
 * Categories: physio-anne
 * Description: Kontaktdaten + Öffnungszeiten + Leaflet-Karte links, CF7-Formular rechts (Kontakt-Seite)
 */
?>
<!-- wp:html -->
<section class="section" aria-labelledby="contact-heading">
  <div class="container">
    <div class="contact-grid">

      <div class="contact-info">
        <p class="eyebrow" style="margin-bottom: 16px;">Erreichbarkeit</p>
        <h2 id="contact-heading" style="font-size: clamp(28px, 3.5vw, 40px); margin-bottom: 24px;">So erreichen<br>Sie mich</h2>

        <div class="contact-detail">
          <div class="contact-detail-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.44a2 2 0 0 1 1.99-2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.06 6.06l.83-.83a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </div>
          <div class="contact-detail-body">
            <strong>Telefon</strong>
            <a href="tel:+436607744162">+43 660 77 44 162</a>
          </div>
        </div>

        <div class="contact-detail">
          <div class="contact-detail-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <div class="contact-detail-body">
            <strong>E-Mail</strong>
            <a href="mailto:info@physio-anne.at">info@physio-anne.at</a>
          </div>
        </div>

        <div class="contact-detail">
          <div class="contact-detail-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div class="contact-detail-body">
            <strong>Adresse</strong>
            <span>Grenzweg 10, 6800 Feldkirch<br>DLZ-Gebäude, 1. Obergeschoss<br>MedReHa</span>
          </div>
        </div>

        <h3 style="font-size: 20px; margin: 36px 0 16px;">Öffnungszeiten</h3>
        <table class="hours-table" aria-label="Öffnungszeiten">
          <tbody>
            <tr><td>Montag</td><td>12:00 – 13:30 Uhr</td></tr>
            <tr><td>Dienstag</td><td>12:00 – 15:30 Uhr</td></tr>
            <tr><td>Mittwoch</td><td>12:00 – 13:30 Uhr</td></tr>
            <tr><td>Donnerstag</td><td>08:00 – 15:30 Uhr</td></tr>
            <tr><td>Freitag</td><td>08:00 – 13:30 Uhr</td></tr>
          </tbody>
        </table>

        <div class="map-wrap" style="margin-top: 32px;">
          <div id="map" aria-label="Standortkarte Physio Anne Feldkirch"></div>
          <div id="map-consent" class="map-consent">
            <p class="map-consent-text">
              Die Karte wird von OpenStreetMap geladen. Dabei wird Ihre IP-Adresse
              an OpenStreetMap übertragen.
            </p>
            <button type="button" id="map-consent-btn" class="btn btn-primary">Karte laden</button>
            <p class="map-consent-alt">
              <a href="https://www.openstreetmap.org/?mlat=47.2597903&amp;mlon=9.6068958#map=17/47.2597903/9.6068958"
                 target="_blank" rel="noopener noreferrer">Stattdessen bei OpenStreetMap öffnen</a>
            </p>
          </div>
        </div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 8px;">
          Kartendaten © <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap</a>-Mitwirkende
        </p>
      </div>

      <div class="contact-form-wrap">
        <p class="eyebrow" style="margin-bottom: 16px;">Terminanfrage</p>
        <h3>Schreiben Sie mir</h3>
        <?php
        // CF7-Formular per Titel suchen – unabhängig von der numerischen ID
        $cf7 = get_page_by_title( 'Kontakt', OBJECT, 'wpcf7_contact_form' );
        if ( $cf7 ) {
            echo do_shortcode( '[contact-form-7 id="' . $cf7->ID . '"]' );
        } else {
            echo '<p style="color:var(--text-muted);font-size:14px;">Kontaktformular wird eingerichtet – bitte rufen Sie uns an: <a href="tel:+436607744162">+43 660 77 44 162</a></p>';
        }
        ?>
      </div>

    </div>
  </div>
</section>

<script>
/* Die Karte lädt erst nach ausdrücklichem Klick. Vorher geht keine Anfrage
   an OpenStreetMap – die IP-Adresse der Besucher:innen wird also nicht
   ungefragt an Dritte übertragen. Leaflet selbst liegt lokal im Theme. */
document.addEventListener('DOMContentLoaded', function () {
  var btn     = document.getElementById('map-consent-btn');
  var consent = document.getElementById('map-consent');
  var el      = document.getElementById('map');
  if (!btn || !consent || !el) return;

  btn.addEventListener('click', function () {
    if (typeof L === 'undefined') return;
    consent.remove();
    el.classList.add('is-loaded');

    var pos = [47.2597903, 9.6068958];
    var map = L.map('map', { scrollWheelZoom: false }).setView(pos, 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap',
      maxZoom: 19
    }).addTo(map);
    var icon = L.divIcon({
      className: '',
      html: '<div style="width:14px;height:14px;background:#9b6ebe;border:3px solid #fff;border-radius:50%;box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>',
      iconSize: [14, 14],
      iconAnchor: [7, 7]
    });
    L.marker(pos, { icon: icon })
      .addTo(map)
      .bindPopup('<strong>Physio Anne</strong><br>Grenzweg 10<br>6800 Feldkirch')
      .openPopup();
  });
});
</script>
<!-- /wp:html -->
