# Changelog – Physio Anne Theme

Alle relevanten Änderungen nach Version. Format: `[Version] Datum – Kurzbeschreibung`.

---

## [1.0.10] 10.06.2026 – Feedback Anne: Verbands-Mitgliedschaft, Preistabelle-Korrektur, Mobile-Abstand

### Geändert
- **Preistabelle – additiv-Markierung korrigiert** (`pricing-table.php`, `pricing-table-white.php`, `services-full.php`): Stern (*) von Elektrotherapie zu Heilmassage verschoben. Heilmassage ist bei ÖGK und BVAEB nur additiv (eigener Posten = Elektrotherapie). ÖGK/BVAEB-Werte der Heilmassage erhalten `*`, Elektrotherapie verliert ihn; Fußnote entsprechend von „Elektrotherapie" auf „Heilmassage" geändert.
- **Mobile-Abstand Hero → Werte-Strip** (`assets/css/style.css`): `hero-dots` margin-bottom 16 → 32px; gestapelte `intro-strip`-Items mit `gap: var(--space-md)` statt 0 – mehr Luft zwischen Slider-Dots und „Menschlich/Kompetent/Individuell" auf Mobile.

### Hinzugefügt
- **Physio-Austria-Mitgliedschaft** (`about-full.php`): neuer Qualifikations-Eintrag „Mitglied bei Physio Austria – Bundesverband der PhysiotherapeutInnen Österreichs (seit 2026)" auf der Über-mich-Seite.

### Nachgezogen (aus 1.0.9 noch nicht committet)
- WCAG-Kontrast-Buttons (`btn-primary`/`btn-accent`/`btn-outline` auf `*-dark`), Heading-Order h4 → h3 (`intro-strip.php`, `footer.html`), `data-pagespeed-no-transform` auf Hero-Bilder (`hero-start.php`) – Quelländerungen zu 1.0.9, die im Working-Tree lagen.

---

## [1.0.9] 22.05.2026 – Lighthouse Audit: PageSpeed-Fix, Heading-Order, Color-Contrast

### Geändert
- **`data-pagespeed-no-transform`** auf alle Hero- und Service-Card-Bilder: verhindert, dass das PageSpeed-Modul `<picture>` auflöst und unkomprimierte Original-PNGs (~16 MB) ausliefert – war Hauptursache für LCP 83 s (mobile)
- **Heading-Order** h4 → h3: `intro-strip.php` (Menschlich / Kompetent / Individuell) und `footer.html` (Kontakt / Navigation) – kein h1→h4-Sprung mehr; CSS-Größen erhalten
- **Color Contrast WCAG AA**:
  - `btn-primary`: `background: var(--primary-dark)` (#7a4ea0, 6,0:1 mit Weiß), hover `var(--deep-purple)`
  - `btn-accent`: `background: var(--teal-dark)` (#007f88, 4,77:1 mit Weiß), hover `#005f66`
  - `btn-outline`: `color/border: var(--primary-dark)`, hover-Hintergrund `var(--primary-dark)`
  - `.pricing-note a`: `color: var(--primary-dark); text-decoration: underline`

### Warum
Lighthouse Desktop (22.05.2026): Accessibility 90 → Ziel ≥95. PageSpeed-Modul rewrite von `<picture>` blockierte WebP-Auslieferung. WCAG-Violations bei Buttons (Teal + Lila hatten &lt;4,5:1 Kontrast). Heading-Sprung h1→h4 verletzt WCAG 1.3.1.

---

## [1.0.8] 22.05.2026 – Modern Web Guidance Audit: A11y + Performance Fixes

### Geändert
- **`scroll-behavior`**: `smooth` nur noch unter `@media (prefers-reduced-motion: no-preference)` – schützt User mit Vestibular-Beschwerden
- **`:focus-visible`**: Formfelder (native + CF7) zeigen Keyboard-Fokus-Outline (`2px solid var(--primary)`) – `outline: none` gilt jetzt nur noch für Maus-Klick (`:focus` ohne `:focus-visible`)
- **Hero Dots**: `aria-hidden="true"` entfernt, ersetzt durch `role="group" aria-label="Slider-Navigation"` – Screen Reader können Navigation nun erreichen
- **`fetchpriority="low"`** auf Slides 2+3 explizit gesetzt (war implizit durch `loading="lazy"`) – explizites Browser-Signal für Lade-Priorisierung
- **`will-change: opacity`** auf `.hero-figure` – GPU-Layer-Promotion für Fade-Animation
- **`color-scheme: light`** in `:root` – verhindert FOUC bei System-Dark-Mode
- **Font-Metric-Fallbacks**: `@font-face` mit `size-adjust` für Cormorant Garamond (87.5%) und DM Sans (105%) – reduziert CLS beim Google-Fonts-Swap (Baseline Newly Available)

### Warum
Modern Web Guidance Audit (GoogleChrome/modern-web-guidance Skill) identifizierte diese Punkte als umsetzbare Verbesserungen ohne Design-Impact. Accessibility-Score-Potential: ≥90→95+. CLS durch Font-Swap messbar reduziert.

---

## [1.0.7] 08.05.2026 – Hero-Bilder Resize + Rekompression

### Geändert
- Hero-Figuren (desktop) von Originalgröße auf max. 1600px Höhe skaliert:
  - `hero-slide1.webp`: 1200×3516px → 545×1600px, 572 KB → **66 KB** (−88 %)
  - `hero-slide2.webp`: 3243×3065px → 1692×1600px, 330 KB → **76 KB** (−77 %)
  - `hero-slide3.webp`: 1302×2904px → 716×1600px, 180 KB → **52 KB** (−71 %)
- Gesamt Desktop-Hero: 1.082 KB → **194 KB** (−82 %)
- WebP-Qualität auf q=60 gesetzt (war: q=75 default); Alpha q=80

### Warum
Bilder wurden in Originalgröße (bis zu 3.516 px hoch) ausgeliefert, obwohl der Hero maximal ~800 px hoch ist. Für 2× Retina sind 1.600 px mehr als ausreichend. Hauptursache für langsame Startseite trotz WebP.

---

## [1.0.6] 07.05.2026 – CF7 nur auf Kontaktseite laden (bfcache-Fix)

### Geändert
- Contact Form 7 Scripts + CSS werden jetzt nur noch auf `/kontakt/` enqueued
- Auf allen anderen Seiten: CF7 dequeued via `wp_enqueue_scripts` Prio 100

### Warum
CF7 registriert einen `unload`-Event-Handler im Hauptframe. Dieser blockiert den Browser-Back/Forward-Cache (bfcache) auf allen Seiten, was Seitennavigation verlangsamt. Lighthouse Diagnostics meldete: *"Page prevented back/forward cache restoration – unload handler"*.

### Known Issue
`/kontakt/` hat weiterhin den CF7-`unload`-Handler (unvermeidbar ohne CF7 zu patchen). Betrifft nur diese eine Seite.

---

## [1.0.5] 07.05.2026 – Mobile LCP Regression behoben

### Geändert
- Hero slides 2 + 3 zurück auf `loading="lazy"` (war fälschlicherweise `loading="eager"`)

### Was war falsch
In v1.0.3 wurden alle 3 Hero-Slides auf `loading="eager"` gesetzt. Auf Mobile (Fast 3G Simulation) lud der Browser dadurch gleichzeitig alle 3 PNG-Fallbacks (~15,7 MB) → LCP 46,6 s, Performance-Score 64 % (war 98 %).

### Korrekte Logik
- Slide 1 (sichtbar beim Laden): `loading="eager"` + `fetchpriority="high"` → LCP-Element
- Slides 2 + 3 (versteckt): `loading="lazy"` → werden erst bei Bedarf geladen
- Gilt für alle Breakpoints (Mobile, Tablet, Desktop) – `loading` ist kein CSS-Attribut

---

## [1.0.4] 07.05.2026 – Service-Bilder optimiert, global-styles Revert

### Geändert
- Service-Bilder auf `/leistungen/` auf WebP + `<picture>` umgestellt:
  - `services-detail.php` und `services-full.php` aktualisiert
  - Desktop: `service-*.webp` 2048px (50–141 KB statt 300–600 KB JPG)
  - Mobile: `service-*-sm.webp` 800px (10–18 KB)
  - `sizes="(max-width: 900px) 100vw, 50vw"` für korrekte Browser-Auswahl
- Erstes Service-Bild: `loading="eager"` + `fetchpriority="high"` (LCP auf /leistungen/)
- Service-Bilder 2–4: `loading="lazy"` mit expliziten `width`/`height` (kein CLS)
- `wp-block-library` JS + CSS auf Frontend dequeued (spart ~100 KB JS)
- Revert: `wp_dequeue_style('global-styles')` entfernt

### Warum global-styles Revert
Dequeuing von `global-styles` reduzierte Best Practices Score von 100 → 81 (WordPress-Abhängigkeit für Block-Rendering). Alle anderen Block-Editor-Assets können sicher entfernt werden.

---

## [1.0.3] 07.05.2026 – Tablet-Breakpoints Hero

### Geändert
- Hero-Figuren: kleine WebP-Varianten für `(max-width: 768px)` erstellt
  - `hero-slide1-sm.webp`: 245×720px, 23 KB
  - `hero-slide2-sm.webp`: 28 KB
  - `hero-slide3-sm.webp`: 22 KB
- `<source media="(max-width: 768px)">` in `hero-start.php` ergänzt
- Tablet spart damit ~1 MB gegenüber Desktop-WebP

---

## [1.0.2] 07.05.2026 – Performance-Optimierungen Runde 1

### Geändert
- Google Fonts: `<link rel="preconnect">` für `fonts.googleapis.com` + `fonts.gstatic.com` ergänzt (Prio 1 in wp_head)
- LCP-Preload: `<link rel="preload" as="image" type="image/webp">` für `hero-slide1.webp` auf Startseite
- Preload-URL auf `.webp` geändert (war `.png`)
- `X-PageSpeed: off` Header aus `functions.php` entfernt → PageSpeed-Modul wieder aktiv
- Block-Editor Assets dequeued: `wp-block-library` CSS + JS (nicht `global-styles`)
- CF7-Formular Erfolgs-Styling: `.wpcf7-form.sent .wpcf7-response-output` Override in `assets/css/style.css`

### Warum PageSpeed wieder aktiviert
PageSpeed-Modul auf dem Server konvertiert automatisch Bilder zu WebP. Deaktivierung (`X-PageSpeed: off`) verhinderte diese serverseitige Optimierung. Nun nutzen wir beide: eigene `<picture>` Elemente (Browser wählt WebP direkt) + PageSpeed als Fallback.

---

## [1.0.1] 07.05.2026 – Hero-Bilder WebP-Konvertierung

### Hinzugefügt
- Hero-Figuren als WebP konvertiert (via `cwebp`):
  - `hero-slide1.webp` (damals 572 KB, jetzt 66 KB nach v1.0.7)
  - `hero-slide2.webp` (damals 330 KB, jetzt 76 KB)
  - `hero-slide3.webp` (damals 180 KB, jetzt 52 KB)
- `<picture>` Element in `hero-start.php` mit WebP `<source>` + PNG Fallback
- `fetchpriority="high"` + `loading="eager"` auf erstem Hero-Slide (LCP)
- `loading="lazy"` auf Slides 2 + 3

### Warum
LCP auf Desktop war 28,8 s. Ursache: 3 PNG-Dateien (5 MB, 7,3 MB, 3,4 MB) ohne Optimierung. WebP bringt sofort ~88–95 % Größenreduktion.

---

## [1.0.0] März–April 2026 – Initiales Theme-Release

### Hinzugefügt
- WordPress FSE Block Theme von Grund auf neu entwickelt
- Design-System: Farben (Primary Lila, Teal, Lilac), Fonts (Cormorant Garamond + DM Sans)
- Templates: front-page, leistungen, ueber-mich, kontakt, page (fallback)
- Patterns: hero-start, hero-leistungen, hero-kontakt, hero-page, services-full, services-detail, services-grid, about-full, about-teaser, testimonials, cta-banner (3 Varianten), intro-strip, pricing-table, contact-full
- SEO: Vollständige Open Graph + Twitter Card Meta-Tags, JSON-LD (LocalBusiness, Person, WebSite, WebPage, FAQPage, BreadcrumbList)
- PWA: site.webmanifest, Favicons (16, 32, 48, 180, 192, 512px), Apple Touch Icon
- Leaflet.js Karte auf /kontakt/ (nur auf dieser Seite geladen)
- Contact Form 7 Integration

### Design-Grundlage
Basierend auf Mockups und Feedback von Anne Günthner (Kundin). Figuren freigestellt (PNG mit Alpha-Kanal), Layout: Hero mit slideshow-Figuren rechts, Content links.
