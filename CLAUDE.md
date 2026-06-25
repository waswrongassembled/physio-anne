# Physio Anne Theme – Repo

WordPress Block-Theme (FSE) für physio-anne.at. **Dies ist das einzige aktive Verzeichnis.**
Die losen Ordner unter `freelancer/physio-anne.at/` (`physio-anne-theme 2/3`, `physio-anne-v2`) sind veraltet – nicht verwenden.

## Struktur

```
theme/                  ← Theme-Quelle, HIER alle Änderungen
  style.css             ← Haltet die Version (Header `Version:`)
  functions.php
  theme.json
  patterns/             ← Block-Patterns (Preistabellen etc.)
  templates/  parts/  assets/
releases/               ← gebaute Theme-Zips (physio-anne-theme-vX.Y.Z.zip)
CHANGELOG.md
```

Remote: `github.com/waswrongassembled/physio-anne` (origin).

## Preistabellen

Preise stehen als HTML in **drei** Patterns – immer alle drei synchron halten:
- `theme/patterns/pricing-table.php` – Startseite (dunkler Block)
- `theme/patterns/pricing-table-white.php` – Leistungen-Seite (weiß)
- `theme/patterns/services-full.php` – Leistungen-Detailseite (enthält dieselbe Tabelle)

Spalten: Leistung | Dauer | Preis | ÖGK | BVAEB | SVS. `*` = nur additiv erstattbar; bei Änderung Fußnote (`pricing-note`) mitführen.

## Release-Workflow (neues Paket)

1. Änderung in `theme/…` machen.
2. `Version:` in `theme/style.css` inkrementieren (z.B. 1.0.12 → 1.0.13).
3. CHANGELOG.md – neuen Block oben einfügen: `## [Version] DD.MM.YYYY – Kurzbeschreibung`.
4. Zip bauen (Ordnername im Zip = `physio-anne-theme/`, ohne `.DS_Store`):

   ```sh
   VER=1.0.13
   STAGE=$(mktemp -d)
   mkdir -p "$STAGE/physio-anne-theme"
   cp -R theme/ "$STAGE/physio-anne-theme/"
   find "$STAGE" -name .DS_Store -delete
   (cd "$STAGE" && zip -rqX "$OLDPWD/releases/physio-anne-theme-v$VER.zip" physio-anne-theme)
   ```

5. Verifizieren: `unzip -p releases/physio-anne-theme-v$VER.zip physio-anne-theme/style.css | grep ^Version`.
6. Commit + Push, sofort:

   ```sh
   git add -A
   git commit -m "vX.Y.Z: Kurzbeschreibung"
   git push
   ```

Installation in WordPress: Design → Themes → Hochladen → Zip aus `releases/`.
