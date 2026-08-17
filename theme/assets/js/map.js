/* ============================================================
   Standortkarte – lädt erst nach ausdrücklicher Einwilligung

   Vor dem Klick geht keine Anfrage an OpenStreetMap raus, die IP-Adresse
   der Besucher:innen wird also nicht ungefragt an Dritte übertragen.
   Leaflet selbst liegt lokal im Theme.

   Das Markup kommt aus physio_anne_map_consent_html() in functions.php.
   Die Koordinaten stehen als data-Attribute am Overlay, damit sie nur an
   einer Stelle gepflegt werden.
   ============================================================ */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    var el      = document.getElementById('map');
    var consent = document.getElementById('map-consent');
    var btn     = document.getElementById('map-consent-btn');

    if (!el || !consent || !btn) return;

    btn.addEventListener('click', function () {
      if (typeof L === 'undefined') return;

      var lat = parseFloat(consent.dataset.lat);
      var lng = parseFloat(consent.dataset.lng);
      if (isNaN(lat) || isNaN(lng)) return;

      consent.remove();
      el.classList.add('is-loaded');

      var map = L.map('map', { scrollWheelZoom: false }).setView([lat, lng], 15);

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

      L.marker([lat, lng], { icon: icon })
        .addTo(map)
        .bindPopup('<strong>Physio Anne</strong><br>Grenzweg 10<br>6800 Feldkirch')
        .openPopup();
    });
  });
})();
