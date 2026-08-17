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

## robots.txt

Die robots.txt wird vom Theme erzeugt (`functions.php`, Abschnitt J) und ist
damit versioniert. Haltung: **Zitieren ja, Trainieren nein.** Antwort- und
Suchcrawler der KI-Anbieter (`OAI-SearchBot`, `Claude-SearchBot`,
`PerplexityBot`, `ChatGPT-User`, `Claude-User`, `Google-Extended`) sind
erlaubt, reine Trainingscrawler (`GPTBot`, `ClaudeBot`, `CCBot`, `Bytespider`,
`meta-externalagent`, `Applebot-Extended`, `Amazonbot`) bleiben gesperrt.

**Cloudflare muss dafür mitspielen.** Cloudflare stellt seinen eigenen Block
*vor* die vom Theme erzeugte Datei; die dortige Sperre gewinnt, weil Crawler
die erste passende User-agent-Gruppe auswerten. Solange sie aktiv ist, laufen
die Freigaben hier ins Leere.

Abschalten unter: **Cloudflare Dashboard → physio-anne.at → AI Crawl Control**
(früher „AI Audit"). Dort die Blockierregel für AI-Crawler deaktivieren und,
falls aktiv, „Manage robots.txt" ausschalten. Danach prüfen:

```sh
curl -s https://physio-anne.at/robots.txt | head -5
# erste Zeile muss der Kommentar aus functions.php sein,
# nicht Cloudflares Content-Signal-Präambel
```

Google-Extended steuert nur Gemini und Grounding – **nicht** die normale
Google-Suche und **nicht** die AI Overviews, die aus dem regulären Suchindex
kommen. Eine Sperre dort kostet also keine klassischen Rankings.

---

## Kontakt / Auftraggeber

**Kunde:** Anne Günthner, Physiotherapeutin  
**Domain:** physio-anne.at  
**Entwicklung:** Andre Schade – [andre@schade.family](mailto:andre@schade.family)
