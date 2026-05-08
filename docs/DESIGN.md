# Design-System – Physio Anne Theme

## Corporate Identity

Vollständiges CI-Dokument (Logo, Visitenkarte, Briefpapier, Kuvert):  
→ [`docs/ci/physio-anne-corporate-identity.pdf`](ci/physio-anne-corporate-identity.pdf)

### Original CI-Farbe (vor Website-Redesign)
Die CI-Unterlagen zeigen **Teal** (`#4a7c7e` / Blau-Grün) als Primärfarbe.  
Beim WordPress-Redesign (März 2026) wurde die Website-Primärfarbe auf **Lila** (`#6b2d8b`) umgestellt – auf Wunsch der Kundin. Teal blieb als Akzentfarbe erhalten.

| CI-Element | Farbe |
|---|---|
| Logo, Schrift | Teal/Slate |
| Hintergründe (Karte, Kuvert) | Teal dunkel |
| Briefpapier Seitenleiste | Teal dunkel |

---


---

## Farben

Definiert in `theme/assets/css/style.css` als CSS Custom Properties:

| Variable | Wert | Verwendung |
|---|---|---|
| `--primary` | `#6b2d8b` (Lila) | Hauptfarbe, Buttons, Akzente |
| `--primary-light` | helleres Lila | Hover-States |
| `--teal` | Türkis | Hands-off-Kategorie, Karten |
| `--accent` | – | CTA-Buttons |
| `--lilac` | Helleres Lila | Karten-Variante |
| `--bg` | `#faf8fb` | Seitenhintergrund |
| `--bg-alt` | – | Alternierende Sektionen |
| `--text` | Dunkelgrau | Fließtext |

### Farb-Zuordnung Leistungs-Karten
- `info-card--primary` → Lila (ärztliche Zuweisung, wichtig)
- `info-card--teal` → Türkis (SVS-Hinweis)
- `info-card--lilac` → Lila hell (Wahltherapie-Info)

---

## Typografie

| Rolle | Font | Gewichte | Quelle |
|---|---|---|---|
| Überschriften (h1–h3) | Cormorant Garamond | 300, 400, 600 + Italic | Google Fonts |
| Fließtext, UI | DM Sans | 300, 400, 500 | Google Fonts |

### Eyebrow-Texte
Kategorie-Labels oberhalb von Überschriften (`<p class="eyebrow">`):
- Kleinschrift, gesperrt, Primärfarbe
- Beispiele: "Physiotherapie Feldkirch", "Mein Angebot", "Leistung 01"

---

## Layout-Prinzipien

### Container
- `.container` → max-width mit horizontalem Padding
- `.section-narrow` → schmalere Variante für Text-lastigen Content

### Sektionen
- `.section` → Standard-Abstand oben/unten
- `.section--alt` → alternierende Hintergrundfarbe (für Abwechslung)

### Hero (Startseite)
- Vollbild-Hero (`100vh` oder fixe Höhe)
- Figur rechts freigestellt (PNG mit Alpha / WebP mit Alpha)
- Text + Buttons links
- 3-Slide-Slider mit Dot-Navigation
- Overlay-Schicht (`.hero-overlay`) für Lesbarkeit

### Service-Detail Layout
- Alternierend: Bild links / Text rechts → `reverse`-Klasse → Bild rechts / Text links
- 2-Spalten-Grid ab ~900px, darunter einspaltig

---

## Komponenten

### Buttons
- `.btn.btn-accent` → Primärer CTA (gefüllt, Akzentfarbe)
- `.btn.btn-outline` → Sekundärer CTA (Outline)

### Karten
- `.info-card` → Standard weiß
- `.info-card--primary/.--teal/.--lilac` → farbige Varianten

### Preistabelle
- `.pricing-table-wrap` → horizontales Scrolling auf Mobile
- `.price-highlight` → Hervorgehobene Preisspalte
- `.col-dauer` → Dauerspalte

### Hero-Dots (Slider-Navigation)
- `.hero-dots` → Container
- `.hero-dot` → einzelner Button (Kreis)
- `.hero-dot.active` → aktiver Slide

---

## Bilder / Medien

### Freigestellte Figuren (Hero)
- Format: PNG (original, Alpha-Kanal) + WebP (optimiert)
- Ausrichtung: stehende Personen, von unten beschnitten
- Responsive: Desktop 1.600px Höhe max, Mobile 720px Höhe

### Content-Bilder (Leistungen, Über mich)
- Format: JPG (original) + WebP (optimiert)
- Seitenverhältnis Leistungen: 2048×1363 (3:2 Landscape)
- Seitenverhältnis Portrait (Anne): 768×1200 (Portrait)
- service-atem: `object-position: right center` (Ausschnitt)

---

## Barrierefreiheit (Accessibility)

- Hero: `aria-label="Willkommen bei Physio Anne"`, Figuren `aria-hidden="true"` (dekorativ)
- Dots: `aria-label="Bild 1/2/3"` auf Buttons
- Sektionen: `aria-labelledby` wo Überschrift vorhanden, `aria-label` sonst
- Bilder: dekorative mit `alt=""`, inhaltliche mit beschreibendem `alt`-Text
- Score Accessibility: 90 (Stand Ausgangslage) – Potenzial für Verbesserung

---

## SEO / Structured Data

Alles in `functions.php` → `physio_anne_get_jsonld()`:

| Schema-Typ | Seite |
|---|---|
| `LocalBusiness` + `MedicalBusiness` | Startseite, Kontakt |
| `Person` (Anne Günthner) | Startseite, Über mich |
| `WebSite` | Startseite |
| `WebPage` | Alle Seiten |
| `FAQPage` | Startseite, Leistungen |
| `MedicalTherapy` (4×) | Leistungen |
| `BreadcrumbList` | Leistungen, Über mich, Kontakt |
| `AggregateRating` | Startseite |

Score SEO: 100 – vollständig.
