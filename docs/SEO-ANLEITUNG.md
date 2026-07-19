# SEO-Anleitung – physio-anne.at gefunden werden

Stand: 19.07.2026 (Theme v1.0.14). Technisches On-Page-SEO ist fertig (Meta-Tags, Schema.org, Sitemap, Redirects). Die folgenden Schritte brauchen Konto-Zugänge und müssen manuell gemacht werden.

---

## 1. Google Search Console (wichtigster Schritt)

Ohne Search Console weiß niemand, ob und wie Google die Seite indexiert.

1. Mit Google-Konto anmelden: https://search.google.com/search-console
2. „Property hinzufügen" → **Domain** → `physio-anne.at`
3. Google zeigt einen DNS-TXT-Eintrag → in **Cloudflare** unter DNS → Records eintragen (Type: TXT, Name: `@`, Inhalt: der angezeigte `google-site-verification=...`-Wert)
4. Zurück in der Search Console „Bestätigen" klicken
5. Links im Menü **Sitemaps** → `wp-sitemap.xml` eintragen → Senden
6. Menü **URL-Prüfung** → nacheinander diese URLs eingeben und je „Indexierung beantragen":
   - `https://physio-anne.at/`
   - `https://physio-anne.at/leistungen/`
   - `https://physio-anne.at/ueber-mich/`
   - `https://physio-anne.at/kontakt/`

Nach 1–2 Wochen unter **Indexierung → Seiten** prüfen: alle 4 Seiten sollten „indexiert" sein.

## 2. Google Business Profile (größter Hebel für lokale Suche)

„Physiotherapie Feldkirch" wird überwiegend über Google Maps / das lokale Kartenfeld gesucht.

1. https://business.google.com → „Jetzt verwalten"
2. Unternehmen suchen: „Physio Anne Feldkirch" – falls schon ein Eintrag existiert: **beanspruchen**, sonst neu anlegen
3. Angaben (müssen exakt zur Website passen):
   - Name: `Physio Anne – Wahlpraxis für Physiotherapie`
   - Kategorie: **Physiotherapeut** (Hauptkategorie)
   - Adresse: Grenzweg 10, DLZ-Gebäude 1. OG, 6800 Feldkirch
   - Telefon: +43 660 77 44 162
   - Website: https://physio-anne.at
   - Öffnungszeiten: Mo 12:00–13:30, Di 12:00–15:30, Mi 12:00–13:30, Do 08:00–15:30, Fr 08:00–13:30
4. Verifizierung durchführen (meist Postkarte an die Praxisadresse oder Video)
5. 5–10 Fotos hochladen (Praxis, Behandlungsraum, Anne)
6. **Rezensionen**: zufriedene Patientinnen aktiv um eine Google-Bewertung bitten – stärkster lokaler Rankingfaktor. Link zum Bewerten findet sich im Business-Profil unter „Rezensionen erhalten".

## 3. Bing Webmaster Tools (5 Minuten)

1. https://www.bing.com/webmasters → anmelden
2. „Aus Google Search Console importieren" wählen → fertig (übernimmt Property + Sitemap automatisch)

## 4. Verzeichnisse / Citations

Überall exakt gleiche Angaben verwenden (Name, Adresse, Telefon – wie oben):

| Verzeichnis | URL | Hinweis |
|---|---|---|
| Physio Austria Therapeutensuche | https://www.physioaustria.at | Verbandsmitgliedschaft besteht → Eintrag prüfen, Website verlinken (starker Backlink) |
| Herold | https://www.herold.at | Kostenloser Basiseintrag |
| WKO Firmen A–Z | https://firmen.wko.at | Über WKO-Mitgliedschaft |
| Apple Maps | https://businessconnect.apple.com | Apple Business Connect |
| DocFinder | https://www.docfinder.at | Prüfen, ob Physiotherapeuten gelistet werden |

## 5. Erfolgskontrolle (ab ~4 Wochen)

- Search Console → **Leistung**: Klicks/Impressionen für „physiotherapie feldkirch", „physio feldkirch"
- Google Maps: Platzierung im lokalen 3er-Pack beobachten
- Bei Bedarf nächster Ausbauschritt: eigene Unterseite pro Therapieform (Manuelle Therapie, Beckenbodentherapie, …) für bessere Rankings je Suchbegriff

---

*Hinweis Datenschutz: Für Google Business Profile und Verzeichniseinträge nur Praxis-Kontaktdaten verwenden, keine privaten Daten.*
