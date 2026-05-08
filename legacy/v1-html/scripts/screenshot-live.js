/**
 * Screenshots der Live-Seite physio-anne.at (alle Unterseiten).
 * Verwendung: npm run screenshots:live
 * Voraussetzung: npx playwright install chromium (einmalig).
 */

const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

const BASE = 'https://physio-anne.at';
const PAGES = [
    { url: BASE + '/', name: 'index' },
    { url: BASE + '/about/', name: 'about' },
    { url: BASE + '/kontakt/', name: 'kontakt' },
    { url: BASE + '/impressum/', name: 'impressum' },
    { url: BASE + '/datenschutz/', name: 'datenschutz' },
    { url: BASE + '/agbs/', name: 'agbs' },
];

const OUT_DIR = path.join(__dirname, '..', 'screenshots-live');
const VIEWPORT = { width: 1440, height: 900 };

(async () => {
    const out = path.resolve(OUT_DIR);
    fs.mkdirSync(out, { recursive: true });
    console.log('Screenshots werden gespeichert in:', out);

    const browser = await chromium.launch({ headless: true });
    const context = await browser.newContext({
        viewport: VIEWPORT,
        userAgent: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
    });

    for (const page of PAGES) {
        const slug = page.name;
        const file = path.join(out, slug + '.png');
        const p = await context.newPage();
        try {
            await p.goto(page.url, { waitUntil: 'networkidle', timeout: 30000 });
            await p.waitForTimeout(1500);
            await p.screenshot({ path: file, fullPage: true });
            console.log('OK:', slug);
        } catch (err) {
            console.error('Fehler', slug, err.message);
        } finally {
            await p.close();
        }
    }

    await context.close();
    await browser.close();
    console.log('Fertig.');
})();
