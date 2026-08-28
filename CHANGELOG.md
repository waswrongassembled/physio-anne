# Changelog – Physio Anne Theme

Alle relevanten Änderungen nach Version. Format: `[Version] Datum – Kurzbeschreibung`.

---

## [1.0.28] 28.08.2026 – Versionsstempel für Theme-Assets

### Behoben
- **Geänderte Dateien erreichten niemanden mehr** (`functions.php`, neuer Abschnitt vor der Platzhalter-Ersetzung): `assets/.htaccess` liefert seit 1.0.26 `immutable, max-age=31536000`. Das heißt wörtlich, dass Browser und Zwischenspeicher die Datei ein Jahr lang als unveränderlich behandeln und nicht mehr nachfragen dürfen. In 1.0.27 wurde `logo-120.webp` unter demselben Namen neu komprimiert – live kam weiter die alte Fassung (8.446 statt 6.680 Bytes), nachweisbar daran, dass dieselbe URL mit angehängter Abfrage sofort die neue Datei lieferte.

  Neu hängt das Theme an alle eigenen Asset-URLs `?v=<Theme-Version>`. Eine neue Version ergibt neue URLs, und neue URLs sind für jeden Cache neue Dateien. Der Dateiname bleibt unangetastet, die Regel „bei Änderung umbenennen" entfällt.

  Gestempelt werden: Bilder und Logos aus Template-Parts und Seiteninhalt (über den `render_block`-Filter), die Schrift-Preloads, die Schriftpfade im Inline-CSS, das Hero-Preload samt `imagesrcset`, Favicons und die Icons im Webmanifest. Die Funktion ist idempotent – eine URL, die bereits eine Abfrage trägt, bleibt unberührt.

  **Nicht** gestempelt werden die Bilder in OG-Metas und JSON-LD: Die lesen Suchmaschinen und soziale Netze, dort ist eine saubere URL mehr wert als Cache-Kontrolle.

### Geändert
- **Bildfilter arbeitet auf dem Pfad statt auf der URL** (`functions.php`): Der Stempel hängt zum Zeitpunkt des Filters schon dran, und `preg_replace( '#\.webp$#', '-sm.webp', … )` hätte auf `…webp?v=1.0.28` nicht mehr gegriffen – das `srcset` hätte zweimal dieselbe Datei mit zwei Breiten angegeben. Der Filter trennt die Abfrage jetzt ab, leitet Dateipfad und `-sm`-Namen aus dem sauberen Pfad ab und stempelt die fertigen URLs neu.

---

## [1.0.27] 28.08.2026 – Kleine Fassungen für die Porträtbilder

Nachtrag zu 1.0.25/1.0.26. Live gemessen nach 1.0.26: Performance 91, Accessibility 100, Best Practices 100, SEO 100, Agentic Browsing 100. LCP 3,9 → 2,8 s.

### Neu
- **`about-col-sm.webp` und `anne-sm.webp`** (je 400 × 625, rund 11 KB gegenüber 39–41 KB): Die beiden Porträtbilder hatten als einzige verbliebene Motive keine kleine Fassung. Der Auslieferungsfilter aus 1.0.25 hängt sie jetzt automatisch als `srcset` an.
- **`logo-120.webp` neu komprimiert**: 8.446 → 6.680 Bytes, gleiche Maße.

### Geändert
- **`sizes` für Bilder ohne eigene Regel** (`functions.php`, Bildfilter): `92vw` statt `100vw` unterhalb 900 px. Der Container hat seitliches Polster, das Bild misst auf einem 412er Display rund 380 px. Bei `100vw` fordert der Browser 412 px an und nimmt deshalb selbst bei einfacher Pixeldichte die große Fassung – die kleine wäre nie zum Zug gekommen.

### Was das nicht löst
Lighthouse meldet weiterhin rund 80 KB unter „Improve image delivery", und das wird so bleiben. Die Rechnung dort vergleicht die Pixelbreite der Datei mit der CSS-Breite und lässt die Pixeldichte außen vor: `hero-slide1-sm.webp` ist 245 px breit für eine Darstellung mit 123 CSS-Pixeln – auf einem Retina-Display exakt richtig, für den Audit „zu groß". Diesen Posten auf null zu bringen hieße, überall einfache Pixeldichte auszuliefern; die Bilder wären auf jedem heutigen Telefon sichtbar weich. Bewusst nicht gemacht.

---

## [1.0.26] 28.08.2026 – Cache-Dauer der Theme-Assets

### Neu
- **`assets/.htaccess`**: Schriften, Bilder, CSS und JS aus dem Theme bekommen `Cache-Control: public, max-age=31536000, immutable`. Bisher lieferte der Server `max-age=14400` – vier Stunden für Dateien, deren Inhalt sich nie ändert; Lighthouse rechnete 204 KB pro Wiederbesuch. Sicher ist die lange Dauer, weil sich unter derselben URL nichts ändert: Schriften und Bilder wechseln bei einer Änderung den Dateinamen, CSS und JS hängen einen Versionsparameter aus der Dateizeit an. Die Direktiven stehen in `<IfModule mod_headers.c>` – fehlt das Modul, bliebe die Datei sonst nicht wirkungslos, sondern würde die betroffenen Dateien mit HTTP 500 beantworten.

### Hinweis zur Wirksamkeit
Greift nur, wenn Apache für dieses Verzeichnis `AllowOverride FileInfo` (oder `All`) erlaubt. Prüfbefehl:

```sh
curl -sI https://physio-anne.at/wp-content/themes/physio-anne-theme/assets/fonts/dm-sans-400-latin.woff2 | grep -i cache-control
```

Erwartet: `public, max-age=31536000, immutable`. Kommt weiter `max-age=14400`, ist `AllowOverride` zu, und die Regel muss in die Server- oder Cloudflare-Konfiguration.

---

## [1.0.25] 28.08.2026 – Agentic Browsing, Kontraste, blockierendes CSS

Anlass: Lighthouse 13 auf Mobil. Performance 81, Accessibility 90, Best Practices 100, SEO 100 – und die neue Kategorie **Agentic Browsing bei 33**. Diese Kategorie wertet nur zwei Prüfungen, weil die WebMCP-Gruppe mangels Formular-Tools nicht anwendbar ist; beide schlugen fehl.

### Behoben – Agentic Browsing
- **`llms.txt` ohne Markdown-Links** (`functions.php`, Abschnitt I): Die Seitenliste stand als Klartext (`- Startseite: https://…`). Der Audit erwartet echte Markdown-Links und meldete „File does not appear to contain any links". Jetzt `- [Startseite](https://…): Kurzbeschreibung`, dazu ein Abschnitt „Rechtliches" mit Impressum, Datenschutz und AGB.
- **Slider-Punkte nicht im Accessibility-Baum** (`functions.php`, Abschnitt C2): `<div class="hero-dots" aria-hidden="true">` enthält drei fokussierbare `<button>`. Für Screenreader und KI-Agenten existieren sie damit nicht, per Tabulator sind sie trotzdem erreichbar. Lighthouse zählt das doppelt – als `aria-hidden-focus` in der Accessibility und als schlecht geformten Baum in der neuen Kategorie. Das Pattern war seit Längerem korrigiert, der Datenbankinhalt nicht; der Auslieferungsfilter zieht das jetzt nach.

### Behoben – Accessibility
- **Farbkontraste unter 4,5:1** (`assets/css/style.css`, `patterns/cta-banner*.php`, `functions.php` Abschnitt C2): Fußzeilentext und die Links auf Impressum/Datenschutz/AGB standen mit `rgba(255,255,255,0.3)` auf `#4a2060` – **2,46:1**. Die Eyebrow-Zeile im CTA-Banner und die Wochentage in den Öffnungszeiten lagen mit `0.5` bei **4,32:1**, knapp unter der Anforderung. Alle drei jetzt auf `0.6` = **5,53:1**. Der Hover-Zustand der Fußzeilenlinks entsprechend von `0.7` auf `0.85`.
- **Slider-Punkte als Tippziel zu klein** (`assets/css/style.css`): Folgefehler aus der Korrektur oben – solange die Punkte hinter `aria-hidden` lagen, prüfte axe ihre Größe nicht. Sichtbar sind 8 px, gefordert sind 24 px. Die Schaltfläche misst jetzt 24 px, der Punkt wird als `::before` gezeichnet; das Aussehen bleibt gleich.
- **Übersprungene Überschriftenebene** (`patterns/intro-strip.php`, `functions.php` Abschnitt C2): Im Werte-Streifen folgte `<h4>` direkt auf die `<h1>` des Heros. Jetzt `<h2>`; `style.css` führt `.intro-item h2` mit, die Optik bleibt unverändert.

### Behoben – Performance
- **Zwei rendernde blockierende Stylesheets** (`functions.php`, neuer Abschnitt A2): `fonts.css` und `style.css` standen als `<link>` im `<head>`. Lighthouse rechnete 1.830 ms dafür, und die LCP-Aufschlüsselung wies 2.173 ms als Element-Render-Delay aus – die Seite wartete also fast ausschließlich auf diese zwei Dateien. Beide werden jetzt inline in den `<head>` geschrieben (rund 45 KB unkomprimiert, gzip etwa 8 KB), die Requests entfallen. Die relativen `url('../fonts/…')` in `fonts.css` werden dabei absolut gemacht, sonst liefen sie gegen die Seiten-URL ins Leere. Ist eine Datei nicht lesbar, greift der alte Weg über `wp_enqueue_style`.
- **Bilder ohne Maße und immer in voller Größe** (`functions.php`, neuer Filter nach Abschnitt C2): Der Datenbankinhalt liefert `<img>` ohne `width`/`height`; `service-beckenboden.webp` wiegt 140 KB und erscheint auf einer Karte von 380 px Breite. Lighthouse rechnete 599 KB Überschuss. Der Filter trägt die Maße aus der Datei nach und hängt ein `srcset` an, wo eine `-sm`-Fassung daneben liegt. Die `-sm`-Dateien sind die 2x-Fassungen für Mobilgeräte, ihre halbe Pixelbreite ist deshalb die CSS-Breite im `sizes`-Attribut.
- **Logo als 60-KB-PNG** (`parts/header.html`, `parts/footer.html`, neu `assets/images/logo-120.webp`): Beide Template-Parts luden `logo.png` (300 × 300, 60 KB) für eine Darstellung mit 52 bzw. 60 px Kantenlänge. Der WebP-Filter aus 1.0.18 greift dort nicht, weil er nur auf den Seiteninhalt wirkt. Neu eine 120-px-Fassung mit 8 KB.
- **Servicekarten ohne `srcset`** (`patterns/services-grid.php`): Die Karten luden die 2048-px-Fassung. Jetzt `-sm` (800 px) mit `sizes`, wie es `services-full.php` und `services-detail.php` schon vormachen.

### Offen (nicht im Theme lösbar)
- **Cache-Dauer der Schriften**: Die acht WOFF2-Dateien kommen mit vier Stunden `max-age`, obwohl ihr Inhalt sich nie ändert. 204 KB pro Wiederbesuch. Muss serverseitig oder als Cloudflare-Cache-Regel auf ein Jahr `immutable` gesetzt werden.

---

## [1.0.24] 27.08.2026 – XML-RPC antwortet mit dem richtigen Statuscode

### Behoben
- **XML-RPC-Sperre lieferte HTTP 200 mit leerem Rumpf** (`functions.php`, Abschnitt L): Bei einer XML-RPC-Anfrage tauscht WordPress den Die-Handler gegen `_xmlrpc_wp_die_handler()`. Der verpackt die Meldung in ein `IXR_Error` und braucht dafür `$wp_xmlrpc_server` – den legt `xmlrpc.php` aber erst nach `init` an. Das `wp_die()` aus 1.0.23 wurde deshalb still verschluckt: der Endpunkt war blockiert, meldete aber 200 statt 403. Statt `wp_die()` jetzt `status_header( 403 )` mit eigener Textantwort.

---

## [1.0.23] 27.08.2026 – Ferneinlieferung abgeschaltet: Beitrag per E-Mail und XML-RPC

### Behoben
- **„Beitrag per E-Mail" war scharf geschaltet** (`functions.php`, neuer Abschnitt L): Unter Einstellungen → Schreiben stand das allgemeine Praxis-Postfach auf Port 110 ohne Transportverschlüsselung – nicht das geheime Extra-Konto, das WordPress dafür verlangt. `wp-mail.php` holte das Postfach per POP3 ab und legte aus jeder Nachricht einen Beitrag an: Autor Benutzer 1, Status „ausstehend", Kategorie „Allgemein", Datum aus dem `Date`-Header. So sind 136 Beiträge aus der Praxiskorrespondenz in die Datenbank gelangt, darunter Patientennamen mit Behandlungsbezug (Art. 9 DSGVO). Der Filter `enable_post_by_email_configuration` bricht `wp-mail.php` jetzt mit 403 ab und blendet die Einstellungssektion aus.
- **Postfach-Zugangsdaten aus der Datenbank entfernt** (`functions.php`, Abschnitt L): `mailserver_pass` liegt in WordPress unverschlüsselt in `wp_options`. Server, Login und Port werden einmalig ohne Passwort protokolliert, danach werden alle vier Optionen auf die Werkswerte zurückgesetzt. Eine Backend-Meldung nennt den Befund und weist auf den nötigen Passwortwechsel hin; sie lässt sich per Button quittieren.
- **XML-RPC abgeschaltet** (`functions.php`, Abschnitt L): zweiter Weg, um von außen Beiträge anzulegen (`wp.newPost`, `metaWeblog.newPost`). `xmlrpc_enabled` allein lässt den Endpunkt weiter antworten, deshalb zusätzlich ein `wp_die()` mit 403 auf `XMLRPC_REQUEST`.

### Hinweis
Der Riegel im Theme überlebt WordPress-Updates, aber keinen Theme-Wechsel. Dauerhaft wirkt das Zurücksetzen der Optionen in der Datenbank. Die 136 Beiträge müssen einmalig gelöscht und der Papierkorb geleert werden.

---

## [1.0.22] 27.08.2026 – Kommentare dicht, /llms.txt ohne Umweg

### Behoben
- **Kommentar-Spam über `wp-comments-post.php`** (`functions.php`, neuer Abschnitt K): Die Block-Templates rendern kein Kommentarformular, das hielt Bots aber nicht auf – `wp-comments-post.php` nimmt POST-Anfragen unabhängig vom Frontend entgegen. Über den WordPress-Beispielbeitrag „Hallo Welt!" landeten so Backlink-Kommentare in der Moderationswarteschlange. `comments_open` und `pings_open` liefern jetzt fest `false`, womit `wp_handle_comment_submission()` die Einsendung ablehnt. Zusätzlich geschlossen: die REST-Route `/wp/v2/comments`, der XML-RPC-Pingback und der `X-Pingback`-Header. Kommentar-Support ist von allen Inhaltstypen entfernt, das Backend-Menü und das Dashboard-Widget sind ausgeblendet.
- **`/llms.txt` antwortete mit 301 statt direkt** (`functions.php`, Abschnitt I): `redirect_canonical()` hängte an den Pfad einen Slash an und leitete auf `/llms.txt/` weiter. Der Inhalt kam an, aber Clients, die Weiterleitungen auf `.txt`-Ressourcen nicht verfolgen, sahen nur den Redirect. Der Canonical-Redirect ist für diese Route jetzt abgeschaltet.

### Hinweis
Die sieben bereits eingegangenen Spam-Kommentare und der Beispielbeitrag „Hallo Welt!" liegen in der Datenbank und müssen einmalig im Backend gelöscht werden. `edit-comments.php` bleibt dafür absichtlich per URL erreichbar.

---

## [1.0.21] 17.08.2026 – Doppeltes Favicon-Set: remove_action braucht die richtige Priorität

### Behoben
- **Zweites Favicon-Set stand weiter im `<head>`** (`functions.php`, Abschnitt H): Das `remove_action( 'wp_head', 'wp_site_icon' )` aus 1.0.18 war wirkungslos. WordPress registriert die Funktion mit Priorität 99, und `remove_action` entfernt nur bei exakter Übereinstimmung von Callback **und** Priorität – ohne Angabe gilt der Standardwert 10. Live standen deshalb acht Icon-Links im `<head>`: vier aus dem Theme, drei aus `wp-content/uploads/` und das Manifest. Jetzt mit Priorität 99 entfernt.
- **oEmbed-Absicherung** (`functions.php`, Abschnitt H): `wp_oembed_add_discovery_links` ist je nach WordPress-Version mit Priorität 4 *und* 10 registriert. Beide werden entfernt, damit nach einem WordPress-Update nicht wieder eine Variante durchkommt.

Die übrigen `remove_action`-Aufrufe wurden gegen `wp-includes/default-filters.php` geprüft und stimmen (`feed_links` 2, `feed_links_extra` 3, `print_emoji_detection_script` 7, `rel_canonical` und `rest_output_link_wp_head` jeweils 10). `wlwmanifest_link` existiert seit WordPress 6.3 nicht mehr – der Aufruf bleibt als harmlose Leeroperation stehen.

---

## [1.0.20] 17.08.2026 – Karten-Einwilligung greift wirklich, Rewrite-Regeln heilen selbst

Beides sind Nachbesserungen an 1.0.18/1.0.19: Die Live-Prüfung nach dem Upload zeigte, dass zwei Änderungen nicht angekommen waren.

### Behoben
- **Karte lud weiterhin ungefragt** (`functions.php` Abschnitt C2, `assets/js/map.js`, `patterns/contact-full.php`): Die Einwilligungslösung aus 1.0.18 lag nur im Pattern – der Inhalt der Kontaktseite kommt aber aus der Datenbank und enthielt unverändert den Kartencontainer samt Inline-Initialisierung, die die Kacheln beim Seitenaufruf lud. Die DSGVO-Wirkung war damit null. Der `the_content`-Filter entfernt jetzt die alte Initialisierung und setzt das Overlay davor. Die Kartenlogik liegt neu in `assets/js/map.js`; das Overlay-Markup erzeugt `physio_anne_map_consent_html()`, die Pattern und Filter gemeinsam nutzen. Koordinaten stehen als Konstanten `PHYSIO_ANNE_LAT` / `PHYSIO_ANNE_LNG` nur noch an einer Stelle.
- **`/llms.txt` lieferte 404** (`functions.php`, Abschnitt I): `add_rewrite_rule()` meldet eine Route nur an; in der Datenbank landet sie erst durch einen Flush. Nach dem Upload von 1.0.19 fehlte der, die Route war also toter Code. Neu: Ein Versionsvergleich löst nach jedem Theme-Update einmalig einen Soft-Flush aus (`.htaccess` bleibt unberührt). Damit heilt sich das künftig selbst.

### Hinweis
`/site.webmanifest` war nie defekt – der 301 in der Prüfung war nur die Ergänzung des Schrägstrichs; die Route liefert 200 mit `application/manifest+json`.

---

## [1.0.19] 17.08.2026 – robots.txt aus dem Theme: Zitieren erlaubt, Trainieren nicht

### Neu
- **robots.txt wird vom Theme erzeugt** (`functions.php`, Abschnitt J): Bisher lieferte WordPress nur den Standardblock, die AI-Crawler-Sperre kam von Cloudflare. Der neue `robots_txt`-Filter schreibt die vollständige Richtlinie – damit ist sie versioniert und nachvollziehbar. Haltung: Antwort- und Suchcrawler (`OAI-SearchBot`, `Claude-SearchBot`, `PerplexityBot`, `ChatGPT-User`, `Claude-User`, `Google-Extended`) dürfen zitieren, reine Trainingscrawler (`GPTBot`, `ClaudeBot`, `CCBot`, `Bytespider`, `meta-externalagent`, `Applebot-Extended`, `Amazonbot`) bleiben gesperrt. Content-Signal entsprechend auf `search=yes, ai-input=yes, ai-train=no`.
- **`docs/DATENSCHUTZ-TEXTBAUSTEINE.md`**: Fertige Absätze für die Datenschutzerklärung, die den Stand nach 1.0.18 beschreiben – Karte mit Einwilligung statt automatischem Laden, lokal gehostete Schriften.

### Wichtig für die Wirksamkeit
Cloudflare stellt seinen eigenen Block **vor** die vom Theme erzeugte Datei. Da Crawler die erste passende `User-agent`-Gruppe auswerten, gewinnt die Cloudflare-Sperre. Sie muss im Dashboard unter **AI Crawl Control** deaktiviert werden, sonst laufen die Freigaben ins Leere. Anleitung und Prüfbefehl stehen in `README.md`, Abschnitt „robots.txt".

---

## [1.0.18] 17.08.2026 – Datenschutz: lokale Schriften & Karte mit Einwilligung, Schema-Ausbau

Umsetzung der offenen Punkte aus dem SEO-Audit.

### Datenschutz
- **Google Fonts lokal gehostet** (`assets/fonts/`, `assets/css/fonts.css`, `functions.php`): Cormorant Garamond und DM Sans wurden bei jedem Seitenaufruf von `fonts.googleapis.com` und `fonts.gstatic.com` geladen und dabei die IP-Adresse der Besucher:innen an Google übertragen – ohne Einwilligung und ohne Erwähnung in der Datenschutzerklärung. 16 woff2-Dateien (Subsets latin + latin-ext, SIL Open Font License) liegen jetzt im Theme. Preconnect zu Google entfällt, stattdessen Preload der beiden Above-the-fold-Schnitte.
- **Leaflet lokal gehostet** (`assets/vendor/leaflet/`): Skript, Stylesheet und Marker-Grafiken kommen nicht mehr von `unpkg.com`.
- **Karte lädt erst nach Klick** (`patterns/contact-full.php`, `assets/css/style.css`): Die Kacheln von OpenStreetMap wurden beim Seitenaufruf automatisch geladen. Jetzt liegt ein Einwilligungs-Overlay über der Karte; ohne Klick geht keine Anfrage an Dritte raus. Als Alternative ist ein direkter Link zu OpenStreetMap hinterlegt.

### Behoben
- **Telefonnummer** (`functions.php`, alle Patterns, `parts/footer.html`): Verlinkt war `tel:+43660774162` – eine Stelle zu wenig, Anrufe gingen ins Leere. Dieselbe falsche Nummer stand im JSON-LD als `telephone`. Korrekt ist `+43 660 77 44 162` (`+436607744162`). Der `the_content`-Filter korrigiert die Nummer auch im Datenbank-Inhalt.
- **Koordinaten** (`functions.php`): `geo` im JSON-LD wich rund 20 Meter vom Google Business Profile ab; jetzt exakt 47.2597903 / 9.6068958.

### Geändert
- **`sameAs` mit Google Business Profile** (`functions.php`): Verknüpft Website und Brancheneintrag als dieselbe Entität – Grundlage dafür, dass Google und LLMs beide Quellen zusammenführen.
- **Honorare als `hasOfferCatalog`** (`functions.php`): Acht `Offer`-Knoten mit Preis, Währung und Dauer. "Was kostet Physiotherapie in Feldkirch" ist maschinenlesbar beantwortet statt nur als Fließtext.
- **`dateModified` an den WebPage-Knoten** (`functions.php`): Aktualitätssignal; LLMs können die Preisangaben zeitlich einordnen.
- **`AggregateRating` entfernt** (`functions.php`): War mit `ratingCount: 2` selbst ausgezeichnet. Google wertet solche Bewertungen für `LocalBusiness` seit 2024 nicht mehr als Rich Result. Die echten Rezensionen wirken über das Business Profile, das jetzt per `sameAs` verknüpft ist.
- **`/llms.txt`** (`functions.php`, Abschnitt I): Kompaktes Faktenprofil der Praxis für KI-Assistenten – Adresse, Leistungen, Honorare, Zuweisungs- und Erstattungsregeln.
- **Aufgeräumt** (`functions.php`, Abschnitt H): Feed- und oEmbed-Links aus dem `<head>` entfernt, Feed-Aufrufe leiten per 301 auf die Startseite (die Seite hat keine Beiträge). `wp_site_icon` entfernt, das ein zweites Favicon-Set neben dem des Themes ausgab.

### Noch offen
- Die Datenschutzerklärung beschreibt die Karte als automatisch eingebunden. Der Abschnitt gehört an die neue Einwilligungslösung angepasst – der Text liegt in der Datenbank, also im Seiteneditor.
- AI-Crawler sind in der robots.txt gesperrt (`ClaudeBot`, `GPTBot`, `Google-Extended` u.a.). Solange das so bleibt, kann die Seite in KI-Antworten nicht als Quelle auftauchen. Cloudflare-Einstellung, kein Theme-Thema.

---

## [1.0.17] 17.08.2026 – WebP-Auslieferung, Canonical-Bereinigung, de-AT

Aus dem SEO-Audit nach 1.0.16. Kernbefund: Die Startseite lieferte rund 17 MB Bilder aus.

### Behoben
- **PNG statt WebP im Seiteninhalt** (`functions.php`, Abschnitt C2): Die Hero-Slides wurden als PNG ausgeliefert – 5,1 MB + 7,4 MB + 3,5 MB – obwohl die WebP-Varianten (66 KB / 76 KB / 52 KB) im Theme liegen. Ursache: Die Templates nutzen `wp:post-content`, der Seiteninhalt liegt also in der Datenbank und stammt aus einem älteren Pattern-Stand ohne `<picture>`-Markup; spätere Verbesserungen an `patterns/hero-start.php` erreichten die Live-Seiten nie. Neuer `the_content`-Filter schreibt Theme-Bildpfade auf die WebP-Variante um, sofern die Datei existiert. Idempotent, `logo.png` (kein WebP-Pendant) bleibt unangetastet. Bildlast der Startseite: ~17 MB → ~1 MB.
- **Doppeltes rel=canonical** (`functions.php`, Abschnitt B): WordPress' `rel_canonical` und das Theme-eigene Canonical standen beide im `<head>`. WordPress-Variante per `remove_action` entfernt.
- **Canonical auf Fehlerseiten** (`functions.php`, Abschnitt E): 404- und Suchseiten fielen auf die Startseiten-Metadaten zurück und gaben `rel=canonical` auf `/` aus – erklärte die Fehlerseite zum Duplikat der Startseite. Canonical wird jetzt nur noch für gepflegte Seiten ausgegeben.

### Geändert
- **`noindex, follow` statt `noindex, nofollow`** (`functions.php`, Abschnitt E): Betrifft nur noch 404- und Suchseiten. `follow` lässt den Crawler den Navigationslinks folgen, statt den Pfad zu kappen.
- **`lang="de-AT"` statt `lang="de"`** (`functions.php`, Abschnitt B): Deckungsgleich mit `inLanguage: de-AT` im JSON-LD, signalisiert Google die österreichische Zielregion.

### Offen (nicht in dieser Version)
- Telefonnummer inkonsistent: Anzeigetext `+43 660 77 44 162` (12 Stellen) vs. `tel:`-Link und JSON-LD `+43660774162` (11 Stellen). Eine der beiden ist falsch – Klärung mit Anne nötig, dann NAP überall angleichen.
- `sameAs` im JSON-LD fehlt (Google Business Profile, Instagram, Facebook) – braucht die URLs.
- Google Fonts werden von `fonts.googleapis.com` geladen; für DSGVO-Konformität lokal hosten.
- `AggregateRating` mit `ratingCount: 2` ist selbst ausgezeichnet; Google wertet das für LocalBusiness nicht als Rich Result.

---

## [1.0.16] 17.08.2026 – Rechtsseiten indexierbar: noindex von Impressum, Datenschutz und AGB entfernt

Auslöser: Google Search Console meldete „Excluded by ‚noindex' tag". Ursache war nicht die WordPress-Einstellung „Suchmaschinen davon abhalten, diese Website zu indexieren", sondern das Theme selbst.

### Geändert
- **noindex für Rechtsseiten entfernt** (`functions.php`, Abschnitt E): `/impressum/`, `/datenschutz/` und `/agb/` gaben `noindex, nofollow` aus. Der Flag `'noindex' => true` ist bei allen drei Einträgen der SEO-Map entfallen. Begründung: Das Impressum liefert Google die NAP-Daten (Name, Adresse, Telefon) und stützt damit das lokale Geschäftsprofil für Feldkirch; die Seiten sind unique, also kein Duplicate-Signal. Zusätzlich blockierte das `nofollow` den Linkfluss der Footer-Navigation zurück auf Leistungen und Kontakt.
- **Sitemap-Ausschluss entfernt** (`functions.php`, Abschnitt G): Der `wp_sitemaps_posts_query_args`-Filter hatte die drei Seiten aus `wp-sitemap-posts-page-1.xml` genommen. Sitemap enthält damit wieder alle sieben Seiten statt vier.

### Unverändert
- 404- und Suchseiten liefern weiterhin `noindex, nofollow` (Fallback auf Startseiten-Metadaten, siehe 1.0.15).

---

## [1.0.15] 28.07.2026 – SEO-Fixes aus Search Console: Alt-URL-Aliase + SERP-Titles

Auslöser: Google Search Console meldete „Not found (404)" für Alt-URLs der statischen Vorgängerseite.

### Behoben
- **404 bei `about.html` und `agbs.html`** (`functions.php`, Abschnitt F): Der Redirect aus 1.0.14 mappte Alt-URLs nur 1:1 auf gleichnamige Slugs. `about.html` (heute `/ueber-mich/`) und `agbs.html` (heute `/agb/`) fielen deshalb durch den Existenz-Guard und lieferten 404. Neue Alias-Map (`about` → `ueber-mich`, `agbs` → `agb`) leitet beide per 301 korrekt weiter. Ursache: 1.0.14 deckte den Dateibestand von `legacy/v2-html/` ab, die beiden Abweichler stammen aus `legacy/v1-html/`.

### Geändert
- **SERP-Title aus der SEO-Map** (`functions.php`, Abschnitt E): Die keyword-starken Titles der Map („Leistungen – Physiotherapie Feldkirch | Physio Anne") wurden bisher nur für `og:title`/`twitter:title` ausgegeben; im `<title>` stand der WordPress-Default („Leistungen – Physio Anne"). Neuer `pre_get_document_title`-Filter zieht den Map-Title ins `<title>` – das Ortskeyword steht damit im wichtigsten On-Page-Signal für lokale Suche.
- **Refactoring** (`functions.php`, Abschnitt E): SEO-Map und Slug-Ermittlung aus der `wp_head`-Closure in `physio_anne_seo_pages()` / `physio_anne_seo_slug()` extrahiert, damit Metas und Title-Filter dieselbe Quelle nutzen.
- **noindex für nicht gepflegte Anfragen** (`functions.php`, Abschnitt E): 404- und Suchseiten fielen auf die Startseiten-Metadaten zurück und gaben damit ein Canonical auf `/` aus. Diese Fälle liefern jetzt `noindex, nofollow`.

### Hinweis (kein Fehler)
- „Page with redirect" (3 Seiten) in der Search Console betrifft `http://www.physio-anne.at/`, `https://www.physio-anne.at/`, `http://physio-anne.at/` – alle leiten korrekt per 301 auf `https://physio-anne.at/`. Erwartetes Verhalten einer Domain-Property, keine Aktion nötig. „Validate Fix" kann hier nie grün werden.

---

## [1.0.14] 19.07.2026 – SEO: 301-Redirects für Alt-URLs + Sitemap-Cleanup

### Hinzugefügt
- **301-Redirects** (`functions.php`, Abschnitt F): Alt-URLs der statischen Vorgängerseite (`/leistungen.html`, `/ueber-mich.html`, `/kontakt.html`, `/index.html` usw.) leiten jetzt per 301 auf die neuen Permalinks (`/leistungen/`, …) um statt 404 zu liefern. Erhält bestehende Google-Rankings und Backlinks. Greift nur bei 404 und nur, wenn die Zielseite existiert.

### Geändert
- **Sitemap-Cleanup** (`functions.php`, Abschnitt G): User- und Taxonomie-Sitemaps deaktiviert (leer/irrelevant), Beitrags-Sitemap entfernt (Seite nutzt keine Posts), noindex-Seiten (Impressum, Datenschutz, AGB) aus der Seiten-Sitemap ausgeschlossen. `wp-sitemap.xml` listet damit nur noch die 4 indexierbaren Seiten – konsistent mit den robots-Metas.

---

## [1.0.13] 25.06.2026 – Neue 404-Fehlerseite

### Hinzugefügt
- **404-Template** (`templates/404.html`) + **Pattern** (`patterns/error-404.php`): Professionelle Fehlerseite mit Header/Footer, „Hoppla – diese Seite gibt es nicht."-Hinweis und Buttons „Zur Startseite" / „Kontakt & Termin". Wird in WordPress automatisch bei nicht gefundenen URLs (HTTP 404) ausgespielt.
- **404-Styles** (`assets/css/style.css`): zentriertes Layout, großer gedämpfter „404"-Code in Teal, responsive Button-Reihe.

---

## [1.0.12] 25.06.2026 – Preistabelle: Heilmassage auch bei SVS nur additiv

### Geändert
- **SVS-Markierung Heilmassage** (`pricing-table.php`, `pricing-table-white.php`, `services-full.php`): SVS-Rückerstattung der Heilmassage (€ 9,13) erhält den additiv-Stern (`* € 9,13`). Fußnote von „bei ÖGK und BVAEB" auf „bei ÖGK, BVAEB und SVS" geändert. Heilmassage ist nun in allen drei Kassen als nur additiv ausgewiesen.

---

## [1.0.11] 10.06.2026 – Fix: Hero/Intro-Overlap auf Startseite (Mobile)

### Behoben
- **Hero überlappte Werte-Strip auf Mobile** (`assets/css/style.css`): `.hero { max-height: 700px }` im 768px-Media-Query entfernt. Zusammen mit `overflow: visible` kappte die 700px-Grenze die Hero-Box, während der Inhalt (Text + Buttons + 360px-Figur + Dots) darüber hinauslief und den Anfang des `intro-strip` verdeckte – Icon + Überschrift „Menschlich" waren unsichtbar. Hero wächst auf Mobile jetzt mit dem Inhalt (`height: auto`, `max-height: none`).

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
