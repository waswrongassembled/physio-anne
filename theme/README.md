# Physio Anne Theme – Setup-Anleitung

WordPress Block Theme (FSE) für physio-anne.at
Version: 1.0.0

---

## Setup-Schritte nach Theme-Installation

### 1. `{{THEME_URL}}` ersetzen

In `parts/header.html` und `parts/footer.html` den Platzhalter `{{THEME_URL}}` durch die tatsächliche Theme-URL ersetzen.

Beispiel: `https://physio-anne.at/wp-content/themes/physio-anne-theme`

Einmalig via FTP oder im WP-Editor: **Darstellung → Editor → Template Parts → Kopfzeile / Fußzeile**

### 2. WordPress-Seiten anlegen

| Seitenname  | Slug         | Template            | Bemerkung                                      |
|-------------|--------------|---------------------|------------------------------------------------|
| Startseite  | (beliebig)   | Startseite          | Als Front Page setzen: Einstellungen → Lesen   |
| Über mich   | ueber-mich   | Über mich           |                                                |
| Leistungen  | leistungen   | Leistungen          |                                                |
| Kontakt     | kontakt      | Kontakt             |                                                |
| Impressum   | impressum    | Standard-Seite      |                                                |
| Datenschutz | datenschutz  | Standard-Seite      |                                                |
| AGB         | agb          | Standard-Seite      |                                                |

### 3. Logo hochladen

**Darstellung → Customizer → Website-Identität → Logo**
Datei: `logo.png`, Größe: 52×52 px

### 4. Contact Form 7 installieren (einziges Plugin)

1. **Plugins → Installieren → Contact Form 7** suchen und installieren
2. Formular anlegen mit Feldern: Name, Telefon, E-Mail, Betreff, Nachricht
3. Shortcode in die Kontakt-Seite einfügen (als Shortcode-Block oder Custom HTML Block)

### 5. Inhalte befüllen

Für jede Seite im Gutenberg-Editor die Blocks aus der Kategorie **"Physio Anne"** einfügen:
Klick auf **+** → **Patterns** → **Physio Anne**

**Verfügbare Patterns:**

| Pattern | Seite |
|---|---|
| Hero Startseite | Startseite |
| Intro Strip – Werte | Startseite |
| Über Anne – Teaser | Startseite |
| Leistungen – Service Grid | Startseite |
| Patient:innen-Stimmen | Startseite |
| Preistabelle | Startseite + Leistungen |
| CTA Banner | Startseite + Leistungen + Über mich |
| Page Hero (Unterseiten) | Über mich, Leistungen, Kontakt |

**Platzhalter beim Befüllen ersetzen:**
- `{{THEME_URL}}` → tatsächliche Theme-URL (nur in header.html / footer.html)
- `{{MEDIA_URL}}` → URL des hochgeladenen Bildes aus der WP-Mediathek (in about-teaser und services-grid Patterns)

### 6. Bilder hochladen

Alle Bilder aus `assets/images/` in die **WP-Mediathek** hochladen:

| Datei                | Verwendung                                      |
|----------------------|-------------------------------------------------|
| logo.png             | Header & Footer Logo                            |
| hero-slide1.png      | Hero Slider – Slide 1                           |
| hero-slide2.png      | Hero Slider – Slide 2                           |
| hero-slide3.png      | Hero Slider – Slide 3                           |
| about-col.jpg        | Startseite: Über-mich-Teaser, OG-Image          |
| about-hero.jpg       | Page Hero für Unterseiten                       |
| service-manuelle.jpg | Leistungskarte Manuelle Therapie                |
| service-uebungen.jpg | Leistungskarte Aktive Übungen                   |
| service-atem.jpg     | Leistungskarte Atemtherapie                     |
| service-beckenboden.jpg | Leistungskarte Beckenbodentherapie           |

Nach dem Hochladen in den Custom HTML Blocks die Bild-URLs entsprechend anpassen.

### 7. Meta-Descriptions befüllen

Bei jeder Seite: **Seiteneinstellungen → Custom Fields → `_meta_desc`** ausfüllen (max. 160 Zeichen).

Falls Custom Fields nicht sichtbar sind: Im Gutenberg-Editor oben rechts **Optionen (⋮) → Custom Fields** aktivieren.

### 8. Permalinks konfigurieren

**Einstellungen → Permalinks → "Beitragsname"** (`/%postname%/`)
Danach auf **Änderungen speichern** klicken (erneuert die .htaccess).

> **Wichtig:** Nach der Theme-Aktivierung die Permalinks einmal speichern, damit der Rewrite-Endpoint für `/site.webmanifest` (Web-App-Manifest für Handy-Homescreen) registriert wird.

---

## Wichtige Hinweise

- **Kein Page Builder** – alle Inhalte werden als Gutenberg-Blocks (Custom HTML) gepflegt
- **Nur 1 Plugin** – Contact Form 7 für das Kontaktformular
- **SEO** – JSON-LD, Meta Tags und OG Tags werden automatisch via `functions.php` generiert
- **Texte bearbeiten** – Alle Texte in den Custom HTML Blocks direkt im Gutenberg-Editor bearbeitbar
- **Preise aktualisieren** – Im Pattern `pricing-table` die Werte direkt im HTML bearbeiten

---

## Technische Details

- WordPress 6.4+ (Full Site Editing / FSE)
- PHP 8.0+
- Google Fonts: Cormorant Garamond + DM Sans (via `wp_enqueue_style`)
- Kein `wp-block-styles` Support (eigenes CSS in `assets/css/style.css`)
- SEO / JSON-LD komplett manuell in `functions.php`
