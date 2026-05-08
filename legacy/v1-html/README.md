# Physio Anne – HTML-Entwurf

Statischer HTML-Entwurf für die spätere Umsetzung auf WordPress.com (Personal/Premium).  
Struktur und Inhalte sind so gehalten, dass die Seite mit dem Block-Editor selbst gepflegt werden kann.

## Ordnerstruktur

- **index.html** – Startseite (Willkommen, Leistungen, Öffnungszeiten, Preise)
- **about.html** – Über mich
- **kontakt.html** – Kontakt, Öffnungszeiten, Formular-Platzhalter
- **impressum.html** – Impressum
- **datenschutz.html** – Datenschutzerklärung
- **agbs.html** – AGBs
- **css/style.css** – Ein zentrales Stylesheet
- **js/main.js** – Mobile Menü (Hamburger)
- **assets/** – Bilder (beim Import ersetzen)

## Übernahme in WordPress

1. **Eine HTML-Datei = eine WordPress-Seite**  
   Pro Datei eine neue Seite anlegen (Startseite, Über mich, Kontakt, Impressum, Datenschutz, AGBs).

2. **Inhalte im Block-Editor**  
   Nur Standard-Blöcke nutzen: Überschrift, Absatz, Liste, Bild, Button, Spalten, Tabelle.  
   Kein „Custom HTML“ nötig – Texte direkt als Absätze/Überschriften einfügen.

3. **Menü & Footer**  
   In WordPress unter „Design → Menü“ das Hauptmenü anlegen (Über mich, Kontakt).  
   Footer-Links (Impressum, Datenschutz, AGBs) über einen Footer-Block oder Widget einbinden.  
   **Wichtig:** Datenschutz-Link muss auf die Seite mit der Datenschutzerklärung zeigen (nicht „dateschutz“).

4. **Kontaktformular**  
   Auf WordPress.com den Formular-Block einfügen. Felder und Bestätigungstext im Editor anpassen.

5. **Rechtstexte**  
   Vollständige Texte für Impressum, Datenschutz und AGBs aus dem Backup (Ordner `anne/` oder Datenbank) in die entsprechenden WordPress-Seiten übernehmen.

6. **Bilder**  
   - **Logo:** Aus dem Backup `htdocs/wp-content/uploads/2026/02/Logo-ohne-Hintergrund.png` (oder
     `2024/09/icon-Kopie.png`) nach `assets/logo.png` kopieren – dann zeigt der Header das Logo; sonst erscheint
     der Text „Physio Anne“.
   - **Über mich:** Profilbild (z. B. aus Backup/Mediathek) als `assets/anne.jpg` ablegen oder in WordPress
     in die Mediathek hochladen und in den Block einfügen.

## Technik

- Semantisches HTML5, eine CSS-Datei, minimales JavaScript (nur Mobile-Menü).
- Keine Build-Tools. Links zwischen den Seiten sind relativ.
- Kontaktformular: hier nur Platzhalter, kein Backend.
