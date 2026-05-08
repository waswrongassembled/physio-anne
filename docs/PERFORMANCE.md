# Performance-Dokumentation – Physio Anne Theme

Stand: 08.05.2026

---

## Ausgangslage (vor Optimierung, ca. Mai 2026)

| Seite | Device | Performance | LCP | FCP | TBT | CLS |
|---|---|---|---|---|---|---|
| Startseite | Desktop | **74** | 28,8 s | – | – | – |
| Startseite | Mobile | ~98 % | – | – | 0 ms | – |
| Accessibility | – | **90** | – | – | – | – |
| Best Practices | – | **100** | – | – | – | – |
| SEO | – | **100** | – | – | – | – |

**Root-Cause Desktop LCP 28,8 s:**  
Hero-Slider mit 3 unkomprimierten PNG-Dateien (5,0 MB + 7,3 MB + 3,4 MB = 15,7 MB) ohne WebP, ohne Preload, ohne `fetchpriority`.

---

## Optimierungsmaßnahmen (chronologisch)

### 1. WebP-Konvertierung Hero-Bilder
- Tool: `cwebp` (Homebrew)
- Bilder mit Alpha-Kanal (freigestellte Figuren) → WebP Lossless/Palette-Mode
- Ergebnis Erstkonvertierung (q=75): slide1 572 KB, slide2 330 KB, slide3 180 KB

### 2. `<picture>` Element mit WebP-Source + PNG-Fallback
```html
<picture>
  <source srcset="hero-slide1.webp" type="image/webp">
  <img src="hero-slide1.png" loading="eager" fetchpriority="high">
</picture>
```
Browser wählt WebP wenn unterstützt; PNG als sicherer Fallback für ältere Browser.

### 3. LCP-Optimierung
- `loading="eager"` + `fetchpriority="high"` auf Hero-Slide 1 (LCP-Element)
- `<link rel="preload" as="image" type="image/webp">` für `hero-slide1.webp` im `<head>`
- Alle anderen Bilder: `loading="lazy"`

### 4. Mobile-Breakpoints Hero
- `-sm.webp` Varianten erstellt (max 720px Höhe) für `media="(max-width: 768px)"`
- Tablet/Mobile: 23 KB + 28 KB + 22 KB = 73 KB statt ~1 MB

### 5. Service-Bilder /leistungen/
- 2048×1363 JPG → WebP 2048px (Desktop) + 800px (Mobile, `max-width: 900px`)
- `<picture>` + `srcset` mit `sizes` für korrekte Browserauswahl

### 6. Block-Editor Assets entfernt
```php
wp_dequeue_style( 'wp-block-library' );
wp_dequeue_style( 'wp-block-library-theme' );
wp_dequeue_script( 'wp-block-library' );
// NICHT: wp_dequeue_style('global-styles') → bricht Best Practices (Score 100→81)
```

### 7. Google Fonts Preconnect
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
```

### 8. Hero-Bilder Resize (v1.0.7)
Originale waren bis zu 3.516 px hoch – weit über dem Nötigem für 2× Retina bei 800px Hero-Höhe.
Resize auf max. 1.600 px Höhe + q=60:

| Datei | Vorher | Nachher | Reduktion |
|---|---|---|---|
| hero-slide1.webp | 572 KB | 66 KB | −88 % |
| hero-slide2.webp | 330 KB | 76 KB | −77 % |
| hero-slide3.webp | 180 KB | 52 KB | −71 % |
| **Gesamt** | **1.082 KB** | **194 KB** | **−82 %** |

### 9. CF7 bfcache-Fix
Contact Form 7 setzt `unload`-Handler → blockiert Browser bfcache.
Fix: CF7-Scripts nur auf `/kontakt/` laden.

```php
if ( ! is_page( 'kontakt' ) ) {
    wp_dequeue_script( 'contact-form-7' );
    wp_dequeue_style( 'contact-form-7' );
}
```

---

## Aktueller Status (v1.0.7, 08.05.2026)

| Seite | Device | Performance | LCP | Anmerkung |
|---|---|---|---|---|
| Startseite | Desktop | TBD | TBD | v1.0.7 noch nicht deployed |
| Startseite | Mobile | TBD | TBD | v1.0.7 noch nicht deployed |
| Unterseiten | Desktop | sehr gut | – | bestätigt nach v1.0.6 |
| Unterseiten | Mobile | sehr gut | – | bestätigt nach v1.0.6 |

> Lighthouse nach Upload von v1.0.7 neu ausführen und Tabelle aktualisieren.

---

## Known Issues

### TBT (Total Blocking Time) Mobile
- **Symptom:** TBT 390 ms auf Mobile (war zuvor 0 ms)
- **Status:** Ursache unklar – möglicherweise timing-bedingt durch Slider-JS oder wp-block-library-Interaktion
- **Nächster Schritt:** Nach v1.0.7-Deploy Lighthouse erneut prüfen; ggf. `main.js` profilen

### CF7 unload-Handler auf /kontakt/
- **Symptom:** bfcache auf /kontakt/ weiterhin blockiert
- **Workaround:** Keiner ohne CF7-Upgrade oder eigenes Patching
- **Impact:** Gering – betrifft nur Navigation weg von /kontakt/ per Back-Button

### PageSpeed-Modul Interaktion
- Server hat PageSpeed-Modul aktiv
- Eigene `<picture>` + WebP-Sources haben Vorrang vor PageSpeed-Transformation
- Konflikt möglich wenn PageSpeed PNG-Fallbacks zusätzlich transformiert → Cache purge nach Theme-Update empfohlen

### about-Bild auf Startseite
- User-Feedback: about-Bild trägt zur langsamen Startseite bei
- about-col.webp ist 768×1200px, 40 KB → technisch optimiert, `loading="lazy"`
- Prüfen ob `loading="eager"` gesetzt wurde (sollte lazy sein, da unterhalb des Folds)

---

## Bild-Inventar

| Datei | Zweck | Desktop | Mobile | Format |
|---|---|---|---|---|
| hero-slide1 | Hero Figur 1 (LCP) | 545×1600, 66 KB | 245×720, 23 KB | WebP + PNG |
| hero-slide2 | Hero Figur 2 | 1692×1600, 76 KB | 28 KB | WebP + PNG |
| hero-slide3 | Hero Figur 3 | 716×1600, 52 KB | 22 KB | WebP + PNG |
| about-col | Anne Portrait | 768×1200, 40 KB | – | WebP + JPG |
| about-hero | Page-Hero Banner | 1280×500, 19 KB | – | WebP + JPG |
| service-manuelle | Manuelle Therapie | 2048px, 92 KB | 800px, 15 KB | WebP + JPG |
| service-uebungen | Aktive Übungen | 50 KB | 10 KB | WebP + JPG |
| service-atem | Atemtherapie | 76 KB | 11 KB | WebP + JPG |
| service-beckenboden | Beckenbodentherapie | 141 KB | 18 KB | WebP + JPG |

---

## Empfehlungen (offene Punkte)

1. **Lighthouse v1.0.7 ausführen** – Desktop + Mobile Startseite + alle Unterseiten
2. **TBT untersuchen** – Browser DevTools Performance Tab, nach JS-Blocking suchen
3. **PageSpeed-Cache purgen** nach jedem Theme-Update (Server-Admin)
4. **about-col Loading prüfen** – sicherstellen dass `loading="lazy"` gesetzt ist
5. **CF7 updaten** – neuere CF7-Versionen nutzen ggf. `pagehide` statt `unload`
