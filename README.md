# Physio Anne Theme

WordPress Full Site Editing (FSE) Block Theme für [physio-anne.at](https://physio-anne.at) –  
Wahlpraxis für Physiotherapie von Anne Günthner in Feldkirch, Vorarlberg.

---

## Repo-Struktur

```
physio-anne-theme-repo/
├── theme/          ← WP-Theme-Quellcode (→ wp-content/themes/physio-anne-theme/)
├── releases/       ← Fertige ZIP-Pakete für WordPress-Upload
└── docs/           ← Technische Dokumentation, Performance-Berichte
```

---

## Deployment

### Theme hochladen

1. ZIP aus `releases/` nehmen (neueste Version)
2. WordPress Admin → Design → Themes → Theme hochladen
3. Nach Upload: Theme aktivieren

### Manueller Upload (SFTP)

```
theme/ → /wp-content/themes/physio-anne-theme/
```

Achtung: Ordnername im ZIP muss `physio-anne-theme` sein (ohne Leerzeichen/Zahl).

---

## Neue Version bauen

```bash
# 1. Version in theme/style.css erhöhen (z.B. 1.0.7 → 1.0.8)
# 2. ZIP bauen:
cd /tmp && rm -rf physio-anne-theme && mkdir physio-anne-theme
cp -R /pfad/zum/repo/theme/. physio-anne-theme/
zip -r physio-anne-theme-vX.Y.Z.zip physio-anne-theme/ -x "*.DS_Store"
# 3. ZIP nach releases/ kopieren
# 4. CHANGELOG.md updaten
# 5. Git commit + push
```

---

## Tech Stack

| Was | Womit |
|---|---|
| CMS | WordPress 6.7 |
| Theme-Typ | Full Site Editing (FSE) Block Theme |
| PHP | 8.0+ |
| Fonts | Cormorant Garamond + DM Sans (Google Fonts) |
| Karte | Leaflet.js (nur /kontakt/) |
| Formulare | Contact Form 7 |
| Hosting | Vorarlberg / PageSpeed-fähiger Server |

---

## Seiten

| Seite | Template | Pattern |
|---|---|---|
| Startseite | `front-page.html` | `hero-start`, `intro-strip`, `services-grid`, `about-teaser`, `testimonials`, `cta-banner` |
| Leistungen | `page-leistungen.html` | `hero-leistungen`, `services-full` |
| Über mich | `page-ueber-mich.html` | `hero-page`, `about-full`, `cta-banner-ueber-mich` |
| Kontakt | `page-kontakt.html` | `hero-kontakt`, `contact-full` |
| Impressum/Datenschutz/AGB | `page.html` | (reiner WordPress-Editor-Inhalt) |

---

## Kontakt / Auftraggeber

**Kunde:** Anne Günthner, Physiotherapeutin  
**Domain:** physio-anne.at  
**Entwicklung:** Andre Schade – [andre.schade@massiveart.com](mailto:andre.schade@massiveart.com)
