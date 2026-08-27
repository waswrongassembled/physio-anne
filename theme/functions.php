<?php
/**
 * Physio Anne Theme – functions.php
 *
 * @package physio-anne-theme
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* ════════════════════════════════════════════════════════════
   PLATZHALTER-ERSETZUNG (Template Parts sind reines HTML)
════════════════════════════════════════════════════════════ */

add_filter( 'render_block', function ( $block_content ) {
    if ( strpos( $block_content, '{{THEME_URL}}' ) !== false ) {
        $block_content = str_replace( '{{THEME_URL}}', get_template_directory_uri(), $block_content );
    }
    if ( strpos( $block_content, '{{MEDIA_URL}}' ) !== false ) {
        $block_content = str_replace( '{{MEDIA_URL}}', get_template_directory_uri() . '/assets/images', $block_content );
    }
    return $block_content;
} );

/* ════════════════════════════════════════════════════════════
   A) THEME SETUP
════════════════════════════════════════════════════════════ */

add_action( 'after_setup_theme', function () {

    // Sprachunterstützung
    load_theme_textdomain( 'physio-anne-theme', get_template_directory() . '/languages' );

    // Theme Supports
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'wp-block-patterns' );

    add_theme_support( 'custom-logo', [
        'height'      => 52,
        'width'       => 52,
        'flex-height' => false,
        'flex-width'  => false,
    ] );

    // Kein wp-block-styles (eigenes CSS)
    // add_theme_support( 'wp-block-styles' ); // absichtlich deaktiviert

    // HTML5 Markup
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ] );
} );


/* ── Assets enqueuen ─────────────────────────────────────── */

add_action( 'wp_enqueue_scripts', function () {

    // Schriften – lokal gehostet (kein Verbindungsaufbau zu Google, DSGVO)
    wp_enqueue_style(
        'physio-anne-fonts',
        get_template_directory_uri() . '/assets/css/fonts.css',
        [],
        filemtime( get_template_directory() . '/assets/css/fonts.css' )
    );

    // Haupt-CSS
    wp_enqueue_style(
        'physio-anne-style',
        get_template_directory_uri() . '/assets/css/style.css',
        [ 'physio-anne-fonts' ],
        filemtime( get_template_directory() . '/assets/css/style.css' )
    );

    // Haupt-JS (im Footer)
    wp_enqueue_script(
        'physio-anne-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        filemtime( get_template_directory() . '/assets/js/main.js' ),
        true // im Footer laden
    );

    // Theme-URL für JS-Bildpfade
    wp_localize_script( 'physio-anne-main', 'physioAnne', [
        'themeUrl' => get_template_directory_uri(),
    ] );

    // Leaflet – lokal gehostet, nur auf der Kontakt-Seite.
    // Das Skript lädt von sich aus keine Kacheln; die Karte wird erst nach
    // Klick initialisiert (siehe patterns/contact-full.php).
    if ( is_page( 'kontakt' ) ) {
        wp_enqueue_style(
            'leaflet-css',
            get_template_directory_uri() . '/assets/vendor/leaflet/leaflet.css',
            [],
            '1.9.4'
        );
        wp_enqueue_script(
            'leaflet-js',
            get_template_directory_uri() . '/assets/vendor/leaflet/leaflet.js',
            [],
            '1.9.4',
            true
        );
        wp_enqueue_script(
            'physio-anne-map',
            get_template_directory_uri() . '/assets/js/map.js',
            [ 'leaflet-js' ],
            filemtime( get_template_directory() . '/assets/js/map.js' ),
            true
        );
    }
} );

// Preload der Schriften, die above the fold gebraucht werden.
// Ersetzt den früheren Preconnect zu Google – die Dateien liegen jetzt lokal.
add_action( 'wp_head', function () {
    $t = get_template_directory_uri() . '/assets/fonts/';
    foreach ( [ 'cormorant-garamond-600-latin.woff2', 'dm-sans-400-latin.woff2' ] as $font ) {
        echo '<link rel="preload" as="font" type="font/woff2" crossorigin href="' . esc_url( $t . $font ) . '">' . "\n";
    }
}, 1 );

// Block-Editor JS + CSS auf Frontend dequeuen
add_action( 'wp_enqueue_scripts', function () {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_script( 'wp-block-library' );

    // CF7 nur auf Kontakt-Seite laden (unload-Handler blockiert bfcache auf allen anderen Seiten)
    if ( ! is_page( 'kontakt' ) ) {
        wp_dequeue_script( 'contact-form-7' );
        wp_dequeue_style( 'contact-form-7' );
    }
}, 100 );

/* ════════════════════════════════════════════════════════════
   B) WP HEAD CLEANER
════════════════════════════════════════════════════════════ */

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// WordPress-eigenes Canonical entfernen – Abschnitt E setzt ein eigenes.
// Sonst stehen zwei rel=canonical im <head>.
remove_action( 'wp_head', 'rel_canonical' );

// Titel-Trennzeichen
add_filter( 'document_title_separator', fn() => '–' );

// Sprachcode inkl. Region: passt zu inLanguage "de-AT" im JSON-LD und
// signalisiert Google die österreichische Zielregion.
add_filter( 'language_attributes', function ( $output ) {
    return preg_replace( '/lang="de(-[A-Za-z]+)?"/', 'lang="de-AT"', $output );
} );

/* ════════════════════════════════════════════════════════════
   C) FAVICONS & APP ICONS (wp_head, Prio 2)
════════════════════════════════════════════════════════════ */

add_action( 'wp_head', function () {
    $t = get_template_directory_uri();
    echo "\n<!-- Favicons & App Icons -->\n";
    echo '<link rel="icon" type="image/x-icon" href="' . esc_url( $t ) . '/assets/images/favicon.ico">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( $t ) . '/assets/images/favicon-32x32.png">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url( $t ) . '/assets/images/favicon-16x16.png">' . "\n";
    echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( $t ) . '/assets/images/apple-touch-icon.png">' . "\n";
    echo '<link rel="manifest" href="/site.webmanifest">' . "\n";
    echo '<meta name="theme-color" content="#9b6ebe">' . "\n";
    echo '<meta name="msapplication-TileColor" content="#9b6ebe">' . "\n";
}, 2 );

/* ════════════════════════════════════════════════════════════
   D) WEBMANIFEST – dynamischer Endpoint /site.webmanifest
════════════════════════════════════════════════════════════ */

add_action( 'init', function () {
    add_rewrite_rule( '^site\.webmanifest$', 'index.php?physio_manifest=1', 'top' );
} );

add_filter( 'query_vars', function ( $vars ) {
    $vars[] = 'physio_manifest';
    return $vars;
} );

add_action( 'template_redirect', function () {
    if ( ! get_query_var( 'physio_manifest' ) ) return;

    $t = get_template_directory_uri();
    $manifest = [
        'name'             => 'Physio Anne – Physiotherapie Feldkirch',
        'short_name'       => 'Physio Anne',
        'description'      => 'Ihre Physiotherapeutin in Feldkirch. Anne Günthner – individuell, kompetent, menschlich.',
        'start_url'        => '/',
        'display'          => 'browser',
        'background_color' => '#faf8fb',
        'theme_color'      => '#9b6ebe',
        'lang'             => 'de-AT',
        'icons'            => [
            [ 'src' => $t . '/assets/images/favicon-192x192.png', 'sizes' => '192x192', 'type' => 'image/png', 'purpose' => 'any maskable' ],
            [ 'src' => $t . '/assets/images/favicon-512x512.png', 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'any maskable' ],
        ],
    ];

    header( 'Content-Type: application/manifest+json; charset=UTF-8' );
    echo json_encode( $manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
    exit;
} );

/* ════════════════════════════════════════════════════════════
   E) SEO / META TAGS / JSON-LD (wp_head, Prio 1)
════════════════════════════════════════════════════════════ */

/**
 * Slug der aktuell ausgelieferten Seite als Schlüssel für die SEO-Map.
 * Leerstring, wenn die Anfrage keine gepflegte Seite trifft (404, Suche, …).
 */
function physio_anne_seo_slug(): string {

    global $post;

    if ( is_front_page() ) {
        return 'front-page';
    }
    if ( is_page() && $post ) {
        return $post->post_name;
    }
    return '';
}

/**
 * Seitenspezifische SEO-Daten: Title, Description, OG/Twitter, noindex.
 * Wird von wp_head (Metas) und pre_get_document_title (SERP-Title) genutzt.
 */
function physio_anne_seo_pages(): array {

    $site_url = 'https://physio-anne.at';

    return [
        'front-page' => [
            'title'       => 'Physio Anne – Physiotherapie in Feldkirch',
            'description' => 'Ihre Physiotherapeutin in Feldkirch. Anne Günthner bietet individuelle Physiotherapie: Manuelle Therapie, Aktive Übungen, Atemtherapie und Beckenbodentherapie.',
            'url'         => $site_url . '/',
            'og_type'     => 'website',
            'tw_desc'     => 'Ihre Physiotherapeutin in Feldkirch. Anne Günthner – individuell, kompetent, menschlich.',
        ],
        'ueber-mich' => [
            'title'       => 'Über mich – Anne Günthner, Physiotherapeutin | Physio Anne',
            'description' => 'Anne Günthner – staatlich geprüfte Physiotherapeutin seit 2012. Wahltherapeutin in Feldkirch, Vorarlberg. Individuell, kompetent, menschlich.',
            'url'         => $site_url . '/ueber-mich/',
            'og_type'     => 'profile',
            'tw_desc'     => 'Anne Günthner – Physiotherapeutin in Feldkirch. Über 10 Jahre Erfahrung, spezialisiert auf Manuelle Therapie und Beckenbodentherapie.',
        ],
        'leistungen' => [
            'title'       => 'Leistungen – Physiotherapie Feldkirch | Physio Anne',
            'description' => 'Physiotherapie in Feldkirch: Manuelle Therapie, Aktive Übungen, Atemtherapie, Beckenbodentherapie, KPE & Heilmassage. Wahltherapeutin Anne Günthner.',
            'url'         => $site_url . '/leistungen/',
            'og_type'     => 'website',
            'tw_desc'     => 'Manuelle Therapie, Aktive Übungen, Atemtherapie, Beckenbodentherapie – individuell und einfühlsam in Feldkirch.',
        ],
        'kontakt' => [
            'title'       => 'Kontakt & Termin – Physio Anne Feldkirch',
            'description' => 'Termin anfragen bei Physio Anne in Feldkirch. Tel: +43 660 77 44 162, Grenzweg 10, DLZ-Gebäude, 6800 Feldkirch.',
            'url'         => $site_url . '/kontakt/',
            'og_type'     => 'website',
            'tw_desc'     => 'Jetzt Termin anfragen bei Physio Anne in Feldkirch – Wahltherapeutin Anne Günthner.',
        ],
        'impressum' => [
            'title'       => 'Impressum – Physio Anne',
            'description' => 'Impressum von Physio Anne – Anne Günthner, Physiotherapeutin in Feldkirch.',
            'url'         => $site_url . '/impressum/',
            'og_type'     => 'website',
            'tw_desc'     => 'Impressum – Physio Anne Feldkirch',
        ],
        'datenschutz' => [
            'title'       => 'Datenschutzerklärung – Physio Anne',
            'description' => 'Datenschutzerklärung von Physio Anne – Anne Günthner, Physiotherapeutin in Feldkirch.',
            'url'         => $site_url . '/datenschutz/',
            'og_type'     => 'website',
            'tw_desc'     => 'Datenschutz – Physio Anne Feldkirch',
        ],
        'agb' => [
            'title'       => 'AGB – Physio Anne',
            'description' => 'Allgemeine Geschäftsbedingungen von Physio Anne – Anne Günthner, Physiotherapeutin in Feldkirch.',
            'url'         => $site_url . '/agb/',
            'og_type'     => 'website',
            'tw_desc'     => 'AGB – Physio Anne Feldkirch',
        ],
    ];
}

/**
 * SERP-Title aus der SEO-Map statt WordPress-Default (Seitentitel – Site-Title).
 * Bringt das Ortskeyword ins <title>, wichtigstes On-Page-Signal für lokale Suche.
 */
add_filter( 'pre_get_document_title', function ( $title ) {

    $pages = physio_anne_seo_pages();
    $slug  = physio_anne_seo_slug();

    return $pages[ $slug ]['title'] ?? $title;
} );

add_action( 'wp_head', function () {

    global $post;

    $theme_url  = get_template_directory_uri();
    $og_image   = $theme_url . '/assets/images/about-col.jpg';
    $og_img_alt = 'Anne Günthner, Physiotherapeutin in Feldkirch';

    $site_url = 'https://physio-anne.at';
    $slug     = physio_anne_seo_slug();
    $pages    = physio_anne_seo_pages();

    $current = $pages[ $slug ] ?? $pages['front-page'];

    // Aus Custom Field überschreiben wenn gesetzt
    if ( $post && ! empty( get_post_meta( $post->ID, '_meta_desc', true ) ) ) {
        $current['description'] = get_post_meta( $post->ID, '_meta_desc', true );
    }

    $title       = esc_attr( $current['title'] );
    $description = esc_attr( $current['description'] );
    $page_url    = esc_url( $current['url'] );
    $og_type     = esc_attr( $current['og_type'] ?? 'website' );
    $tw_desc     = esc_attr( $current['tw_desc'] ?? $current['description'] );
    // Nicht gepflegte Anfragen (404, Suche) fallen auf die Startseiten-Daten zurück –
    // die dürfen dann nicht indexiert werden, sonst Duplicate-Signal auf die Startseite.
    $noindex     = ! empty( $current['noindex'] ) || '' === $slug;
    // Rechtsseiten (Impressum, Datenschutz, AGB) sind bewusst indexierbar:
    // Impressum liefert Google die NAP-Daten für das lokale Geschäftsprofil.

    echo "\n<!-- Physio Anne SEO -->\n";

    // Meta Description
    echo '<meta name="description" content="' . $description . '">' . "\n";

    // Canonical – nur für gepflegte Seiten. Auf 404/Suche zeigte der Fallback
    // sonst auf die Startseite und erklärte die Fehlerseite zu deren Duplikat.
    if ( ! $noindex ) {
        echo '<link rel="canonical" href="' . $page_url . '">' . "\n";
    }

    // noindex für nicht gepflegte Anfragen (404, Suche)
    if ( $noindex ) {
        echo '<meta name="robots" content="noindex, follow">' . "\n";
    }

    // Open Graph
    echo '<meta property="og:type"        content="' . $og_type . '">' . "\n";
    echo '<meta property="og:url"         content="' . $page_url . '">' . "\n";
    echo '<meta property="og:title"       content="' . $title . '">' . "\n";
    echo '<meta property="og:description" content="' . $description . '">' . "\n";
    echo '<meta property="og:image"       content="' . esc_url( $og_image ) . '">' . "\n";
    echo '<meta property="og:image:alt"   content="' . esc_attr( $og_img_alt ) . '">' . "\n";
    echo '<meta property="og:locale"      content="de_AT">' . "\n";

    // Twitter Card
    echo '<meta name="twitter:card"        content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title"       content="' . $title . '">' . "\n";
    echo '<meta name="twitter:description" content="' . $tw_desc . '">' . "\n";
    echo '<meta name="twitter:image"       content="' . esc_url( $og_image ) . '">' . "\n";

    // Preload Hero-Image (nur Startseite)
    if ( $slug === 'front-page' ) {
        echo '<link rel="preload" as="image" href="' . esc_url( $theme_url . '/assets/images/hero-slide1.webp' ) . '" type="image/webp">' . "\n";
    }

    // JSON-LD
    echo physio_anne_get_jsonld( $slug, $site_url, $theme_url );

}, 1 );

/* ── JSON-LD Generator ─────────────────────────────────── */

function physio_anne_get_jsonld( string $slug, string $site_url, string $theme_url ): string {

    $business_id = $site_url . '/#business';
    $anne_id     = $site_url . '/#anne';
    $website_id  = $site_url . '/#website';

    // Gemeinsamer Business-Block
    $business = [
        '@type'           => [ 'LocalBusiness', 'MedicalBusiness' ],
        '@id'             => $business_id,
        'name'            => 'Physio Anne – Wahlpraxis für Physiotherapie',
        'alternateName'   => 'Physio Anne',
        'description'     => 'Wahlpraxis für Physiotherapie in Feldkirch, Vorarlberg. Anne Günthner ist staatlich geprüfte Physiotherapeutin mit Spezialisierung auf Manuelle Therapie, Atemtherapie und Beckenbodentherapie.',
        'url'             => $site_url,
        'logo'            => $theme_url . '/assets/images/logo.png',
        'image'           => $theme_url . '/assets/images/about-col.jpg',
        'telephone'       => '+436607744162',
        'email'           => 'info@physio-anne.at',
        'address'         => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Grenzweg 10, DLZ-Gebäude 1. OG',
            'addressLocality' => 'Feldkirch',
            'postalCode'      => '6800',
            'addressRegion'   => 'Vorarlberg',
            'addressCountry'  => 'AT',
        ],
        // Koordinaten exakt wie im Google Business Profile hinterlegt –
        // Abweichungen schwächen den Abgleich der Einträge.
        'geo'             => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => 47.2597903,
            'longitude' => 9.6068958,
        ],
        // Verknüpft die Website mit dem Google Business Profile. Erst dadurch
        // erkennen Google und LLMs Website und Eintrag als dieselbe Praxis.
        'sameAs'          => [
            'https://maps.google.com/?cid=14752575632081097472',
        ],
        'openingHoursSpecification' => [
            [ '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Monday',    'opens' => '12:00', 'closes' => '13:30' ],
            [ '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Tuesday',   'opens' => '12:00', 'closes' => '15:30' ],
            [ '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Wednesday', 'opens' => '12:00', 'closes' => '13:30' ],
            [ '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Thursday',  'opens' => '08:00', 'closes' => '15:30' ],
            [ '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Friday',    'opens' => '08:00', 'closes' => '13:30' ],
        ],
        'openingHours'    => [ 'Mo 12:00-13:30', 'Tu 12:00-15:30', 'We 12:00-13:30', 'Th 08:00-15:30', 'Fr 08:00-13:30' ],
        'priceRange'      => '€€',
        'currenciesAccepted' => 'EUR',
        'medicalSpecialty' => 'PhysicalTherapy',
        'areaServed'      => [
            [ '@type' => 'City',              'name' => 'Feldkirch' ],
            [ '@type' => 'City',              'name' => 'Rankweil' ],
            [ '@type' => 'City',              'name' => 'Götzis' ],
            [ '@type' => 'City',              'name' => 'Altenstadt' ],
            [ '@type' => 'AdministrativeArea', 'name' => 'Vorarlberg' ],
        ],
        'contactPoint'    => [
            '@type'       => 'ContactPoint',
            'telephone'   => '+436607744162',
            'contactType' => 'appointment scheduling',
        ],
        'founder'         => [ '@id' => $anne_id ],
        'employee'        => [ '@id' => $anne_id ],
        // Honorare strukturiert. "Was kostet Physiotherapie in Feldkirch" ist
        // eine der häufigsten lokalen Suchanfragen – als Offer ist die Antwort
        // maschinenlesbar statt nur Fließtext. Preise USt-befreit gem.
        // § 6 Abs. 1 Z 19 UStG, siehe patterns/pricing-table*.php.
        'hasOfferCatalog' => [
            '@type'           => 'OfferCatalog',
            'name'            => 'Honorare Physio Anne',
            'itemListElement' => array_map(
                fn( $o ) => [
                    '@type'         => 'Offer',
                    'name'          => $o[0],
                    'price'         => $o[1],
                    'priceCurrency' => 'EUR',
                    'availability'  => 'https://schema.org/InStock',
                    'itemOffered'   => [
                        '@type'    => 'Service',
                        'name'     => $o[0],
                        'provider' => [ '@id' => $business_id ],
                    ],
                    'eligibleDuration' => [
                        '@type'    => 'QuantitativeValue',
                        'value'    => $o[2],
                        'unitCode' => 'MIN',
                    ],
                ],
                [
                    [ 'Heilgymnastik 30 Minuten',        '53.00',  30 ],
                    [ 'Heilgymnastik 45 Minuten',        '80.00',  45 ],
                    [ 'Heilgymnastik 60 Minuten',        '106.00', 60 ],
                    [ 'KPE (Lymphdrainage) 30 Minuten',  '53.00',  30 ],
                    [ 'KPE (Lymphdrainage) 45 Minuten',  '80.00',  45 ],
                    [ 'KPE (Lymphdrainage) 60 Minuten',  '106.00', 60 ],
                    [ 'Heilmassage 15 Minuten',          '27.00',  15 ],
                    [ 'Elektrotherapie 15 Minuten',      '7.50',   15 ],
                ]
            ),
        ],
    ];

    // Anne Person-Block
    $anne = [
        '@type'     => 'Person',
        '@id'       => $anne_id,
        'name'      => 'Anne Günthner',
        'jobTitle'  => 'Physiotherapeutin',
        'description' => 'Staatlich geprüfte Physiotherapeutin seit 2012. Freiberuflich tätig als Wahltherapeutin in Feldkirch seit Juni 2024.',
        'url'       => $site_url . '/ueber-mich/',
        'image'     => $theme_url . '/assets/images/about-col.jpg',
        'worksFor'  => [ '@id' => $business_id ],
        'knowsAbout' => [ 'Physiotherapie', 'Manuelle Therapie', 'Atemtherapie', 'Beckenbodentherapie' ],
    ];

    // Website-Block
    $website = [
        '@type'     => 'WebSite',
        '@id'       => $website_id,
        'url'       => $site_url,
        'name'      => 'Physio Anne',
        'inLanguage' => 'de-AT',
        'publisher' => [ '@id' => $business_id ],
    ];

    $graph = [];

    switch ( $slug ) {

        /* ── STARTSEITE ── */
        case 'front-page':
            $graph[] = $business;
            $graph[] = $anne;
            $graph[] = $website;
            $graph[] = [
                '@type'    => 'WebPage',
                '@id'      => $site_url . '/#webpage',
                'url'      => $site_url . '/',
                'name'     => 'Physio Anne – Physiotherapie in Feldkirch',
                'isPartOf' => [ '@id' => $website_id ],
                'about'    => [ '@id' => $business_id ],
                'inLanguage' => 'de-AT',
            ];
            // Kein AggregateRating: Google wertet selbst ausgezeichnete
            // Bewertungen für LocalBusiness seit 2024 nicht mehr als Rich
            // Result und stuft sie als "self-serving" ein. Die echten
            // Rezensionen wirken über das Google Business Profile, das per
            // sameAs mit dieser Seite verknüpft ist.
            $graph[] = [
                '@type'      => 'FAQPage',
                'mainEntity' => [
                    [
                        '@type' => 'Question',
                        'name'  => 'Was ist eine Wahltherapeutin?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Eine Wahltherapeutin ist eine Physiotherapeutin ohne Kassenvertrag. Sie rechnet direkt mit den Patient:innen ab. Gesetzliche Krankenkassen (ÖGK, BVAEB, SVS) erstatten einen Teil der Kosten auf Antrag. Der Vorteil: freie Therapeutinnenwahl, flexible Termine und mehr Zeit pro Behandlung.' ],
                    ],
                    [
                        '@type' => 'Question',
                        'name'  => 'Brauche ich eine ärztliche Zuweisung für Physiotherapie?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Ja. Als Physiotherapeutin ist Anne Günthner weisungsgebunden – eine ärztliche Zuweisung (Überweisung) ist für die Behandlung erforderlich und Voraussetzung für die Kassenerstattung. Bitte bringen Sie die Zuweisung zum ersten Termin mit.' ],
                    ],
                    [
                        '@type' => 'Question',
                        'name'  => 'Was kostet Physiotherapie bei Physio Anne in Feldkirch?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Heilgymnastik: €53 (30 Min.), €80 (45 Min.), €106 (60 Min.). Heilmassage: €27 (15 Min.). Elektrotherapie: €7,50 (15 Min.). Alle Preise ohne MwSt. (USt-befreit gem. § 6 Abs. 1 Z 19 UStG). Krankenkassen erstatten einen Teil der Kosten.' ],
                    ],
                ],
            ];
            break;

        /* ── LEISTUNGEN ── */
        case 'leistungen':
            $graph[] = [
                '@type'       => 'MedicalTherapy',
                'name'        => 'Manuelle Therapie',
                'description' => 'Gezielte Handgriffe zur Mobilisierung von Gelenken, Lösung von Verspannungen und Verbesserung der Beweglichkeit. Geeignet bei Rückenschmerzen, Nackenschmerzen, Schulter- und Knieproblemen, nach Operationen und Sportverletzungen.',
                'provider'    => [ '@id' => $business_id ],
                'availableService' => [ '@type' => 'MedicalProcedure', 'name' => 'Manuelle Therapie', 'procedureType' => 'TherapeuticProcedure' ],
            ];
            $graph[] = [
                '@type'       => 'MedicalTherapy',
                'name'        => 'Aktive Übungen',
                'description' => 'Individuelle Kräftigungs- und Beweglichkeitsübungen für Muskelaufbau nach Verletzungen, Haltungskorrektur und Sturzprophylaxe.',
                'provider'    => [ '@id' => $business_id ],
            ];
            $graph[] = [
                '@type'       => 'MedicalTherapy',
                'name'        => 'Atemtherapie',
                'description' => 'Bewusste Atemtechniken zur Verbesserung der Lungenfunktion, Entspannung und Körperwahrnehmung. Geeignet bei Lungenproblemen, Asthma, Stress und postoperativer Nachsorge.',
                'provider'    => [ '@id' => $business_id ],
            ];
            $graph[] = [
                '@type'       => 'MedicalTherapy',
                'name'        => 'Beckenbodentherapie',
                'description' => 'Spezialisiertes Training zur Stärkung und Entspannung der Beckenbodenmuskulatur für Frauen und Männer. Geeignet bei Inkontinenz, nach der Geburt und bei Beckenschmerzen.',
                'provider'    => [ '@id' => $business_id ],
            ];
            $graph[] = [
                '@type'      => 'FAQPage',
                'mainEntity' => [
                    [
                        '@type' => 'Question',
                        'name'  => 'Brauche ich eine ärztliche Zuweisung für Physiotherapie?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Ja, für die meisten Leistungen ist eine ärztliche Zuweisung (Verordnung) erforderlich. Sie erleichtert auch die Rückerstattung durch die Krankenkasse.' ],
                    ],
                    [
                        '@type' => 'Question',
                        'name'  => 'Zahlt die Krankenkasse bei einer Wahltherapeutin?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Als Wahltherapeutin rechnet Anne Günthner direkt mit Ihnen ab. Viele Krankenkassen (ÖGK, BVAEB, SVS) erstatten einen Teil der Kosten. Die Erstattungsbeträge variieren je nach Kasse und Leistung.' ],
                    ],
                    [
                        '@type' => 'Question',
                        'name'  => 'Was kostet eine Physiotherapie-Stunde bei Physio Anne?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Heilgymnastik kostet €53 für 30 Minuten, €80 für 45 Minuten und €106 für 60 Minuten. Heilmassage (15 Min.) €27, Elektrotherapie (15 Min.) €7,50.' ],
                    ],
                    [
                        '@type' => 'Question',
                        'name'  => 'Bietet Physio Anne Beckenbodentherapie an?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Ja, Beckenbodentherapie ist eine Spezialisierung von Anne Günthner. Das Angebot richtet sich an Frauen und Männer, z.B. bei Inkontinenz, nach der Geburt oder bei Beckenschmerzen.' ],
                    ],
                    [
                        '@type' => 'Question',
                        'name'  => 'Wie lange dauert eine Physiotherapie-Einheit?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Die Behandlungseinheiten sind in 30, 45 oder 60 Minuten buchbar, je nach Therapieart und individuellem Bedarf.' ],
                    ],
                    [
                        '@type' => 'Question',
                        'name'  => 'Brauchen SVS-Versicherte eine Bewilligung vor dem ersten Termin?',
                        'acceptedAnswer' => [ '@type' => 'Answer', 'text' => 'Ja. SVS-Versicherte (Sozialversicherungsanstalt der Selbständigen) müssen vor dem ersten Behandlungstermin eine Bewilligung bei der SVS einholen. Bitte klären Sie das vor Ihrer Terminbuchung, damit die Kostenerstattung reibungslos funktioniert.' ],
                    ],
                ],
            ];
            $graph[] = [
                '@type'    => 'WebPage',
                '@id'      => $site_url . '/leistungen/#webpage',
                'url'      => $site_url . '/leistungen/',
                'name'     => 'Leistungen – Physiotherapie Feldkirch | Physio Anne',
                'isPartOf' => [ '@id' => $website_id ],
                'about'    => [ '@id' => $business_id ],
                'inLanguage' => 'de-AT',
            ];
            $graph[] = [
                '@type'           => 'BreadcrumbList',
                'itemListElement' => [
                    [ '@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => $site_url . '/' ],
                    [ '@type' => 'ListItem', 'position' => 2, 'name' => 'Leistungen', 'item' => $site_url . '/leistungen/' ],
                ],
            ];
            break;

        /* ── ÜBER MICH ── */
        case 'ueber-mich':
            $anne_full = $anne;
            $anne_full['hasCredential'] = [
                '@type'               => 'EducationalOccupationalCredential',
                'credentialCategory'  => 'Staatlich geprüfte Physiotherapeutin',
                'description'         => 'MTD-Gesetz (BGBL Nr. 460/1992), Berufsausübung seit 2012',
                'recognizedBy'        => [ '@type' => 'GovernmentOrganization', 'name' => 'Republik Österreich' ],
            ];
            $graph[] = $anne_full;
            $graph[] = [
                '@type'    => 'WebPage',
                '@id'      => $site_url . '/ueber-mich/#webpage',
                'url'      => $site_url . '/ueber-mich/',
                'name'     => 'Über mich – Anne Günthner, Physiotherapeutin | Physio Anne',
                'isPartOf' => [ '@id' => $website_id ],
                'about'    => [ '@id' => $anne_id ],
                'inLanguage' => 'de-AT',
            ];
            $graph[] = [
                '@type'           => 'BreadcrumbList',
                'itemListElement' => [
                    [ '@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => $site_url . '/' ],
                    [ '@type' => 'ListItem', 'position' => 2, 'name' => 'Über mich',  'item' => $site_url . '/ueber-mich/' ],
                ],
            ];
            break;

        /* ── KONTAKT ── */
        case 'kontakt':
            $graph[] = $business;
            $graph[] = [
                '@type'    => 'WebPage',
                '@id'      => $site_url . '/kontakt/#webpage',
                'url'      => $site_url . '/kontakt/',
                'name'     => 'Kontakt & Termin – Physio Anne Feldkirch',
                'isPartOf' => [ '@id' => $website_id ],
                'about'    => [ '@id' => $business_id ],
                'inLanguage' => 'de-AT',
            ];
            $graph[] = [
                '@type'           => 'BreadcrumbList',
                'itemListElement' => [
                    [ '@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => $site_url . '/' ],
                    [ '@type' => 'ListItem', 'position' => 2, 'name' => 'Kontakt',    'item' => $site_url . '/kontakt/' ],
                ],
            ];
            break;

        /* ── FALLBACK (legale Seiten etc.) ── */
        default:
            $graph[] = $website;
            break;
    }

    if ( empty( $graph ) ) {
        return '';
    }

    // Änderungsdatum an die WebPage-Knoten hängen. Aktualität ist ein
    // Rankingsignal, und LLMs können die Angaben – vor allem die Preise –
    // zeitlich einordnen statt sie unbefristet zu zitieren.
    $current_post = get_post();
    if ( $current_post ) {
        $modified = get_post_modified_time( 'c', true, $current_post );
        foreach ( $graph as &$node ) {
            if ( 'WebPage' === ( $node['@type'] ?? '' ) ) {
                $node['dateModified'] = $modified;
            }
        }
        unset( $node );
    }

    $jsonld = json_encode(
        [ '@context' => 'https://schema.org', '@graph' => $graph ],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );

    return "\n<script type=\"application/ld+json\">\n" . $jsonld . "\n</script>\n";
}

/* ════════════════════════════════════════════════════════════
   C2) KORREKTUREN AM AUSGELIEFERTEN SEITENINHALT

   Der Seiteninhalt liegt in der Datenbank (die Templates nutzen
   wp:post-content) und stammt aus einem älteren Pattern-Stand. Spätere
   Verbesserungen an den Patterns erreichen die Live-Seiten deshalb nicht,
   solange der Inhalt nicht neu eingesetzt wird. Bis dahin werden zwei Dinge
   beim Ausliefern korrigiert. Beide Filter sind idempotent und stören auch
   dann nicht, wenn der DB-Inhalt später aktualisiert wird.
════════════════════════════════════════════════════════════ */

add_filter( 'the_content', function ( $content ) {

    /* 1. WebP statt PNG/JPG.
       Die drei Hero-Slides gehen als PNG mit zusammen rund 16 MB raus,
       obwohl die WebP-Varianten derselben Bilder rund 200 KB wiegen.
       Bilder ohne WebP-Pendant (z.B. logo.png) bleiben unangetastet. */
    $images_dir = get_template_directory() . '/assets/images/';

    $content = preg_replace_callback(
        '#(assets/images/)([\w-]+)\.(png|jpe?g)#i',
        function ( $m ) use ( $images_dir ) {
            return file_exists( $images_dir . $m[2] . '.webp' )
                ? $m[1] . $m[2] . '.webp'
                : $m[0];
        },
        $content
    );

    /* 2. Telefonnummer im tel:-Link.
       Der alte Stand verlinkt +43660774162 – eine Stelle zu wenig, der
       Anruf geht ins Leere. Korrekt ist +43 660 77 44 162. */
    return str_replace( 'tel:+43660774162', 'tel:+436607744162', $content );
}, 20 );

/**
 * Koordinaten der Praxis – exakt wie im Google Business Profile.
 * Eine Quelle für JSON-LD, Karte und Overlay.
 */
const PHYSIO_ANNE_LAT = 47.2597903;
const PHYSIO_ANNE_LNG = 9.6068958;

/**
 * Einwilligungs-Overlay für die Standortkarte.
 * Wird sowohl vom Pattern als auch vom the_content-Filter genutzt, damit der
 * Text nur an einer Stelle steht.
 */
function physio_anne_map_consent_html(): string {

    $osm = sprintf(
        'https://www.openstreetmap.org/?mlat=%1$s&mlon=%2$s#map=17/%1$s/%2$s',
        PHYSIO_ANNE_LAT,
        PHYSIO_ANNE_LNG
    );

    return sprintf(
        '<div id="map-consent" class="map-consent" data-lat="%s" data-lng="%s">'
        . '<p class="map-consent-text">Die Karte wird von OpenStreetMap geladen.'
        . ' Dabei wird Ihre IP-Adresse an OpenStreetMap übertragen.</p>'
        . '<button type="button" id="map-consent-btn" class="btn btn-primary">Karte laden</button>'
        . '<p class="map-consent-alt"><a href="%s" target="_blank" rel="noopener noreferrer">'
        . 'Stattdessen bei OpenStreetMap öffnen</a></p>'
        . '</div>',
        esc_attr( PHYSIO_ANNE_LAT ),
        esc_attr( PHYSIO_ANNE_LNG ),
        esc_url( $osm )
    );
}

/* ── Karte im Datenbank-Inhalt nachrüsten ─────────────────────
   Der Inhalt der Kontaktseite stammt aus einem älteren Pattern-Stand: Er
   enthält den Kartencontainer plus eine Inline-Initialisierung, die die
   Kacheln beim Seitenaufruf lädt – also ohne Einwilligung. Der Filter
   entfernt diese Initialisierung und setzt das Overlay davor. Greift nur,
   wenn das Overlay nicht schon im Inhalt steht. */

add_filter( 'the_content', function ( $content ) {

    if ( false === strpos( $content, 'id="map"' ) || false !== strpos( $content, 'map-consent' ) ) {
        return $content;
    }

    // Alte Inline-Initialisierung entfernen; die Logik liegt in assets/js/map.js.
    $content = preg_replace_callback(
        '#<script\b[^>]*>[\s\S]*?</script>#i',
        fn( $m ) => false !== strpos( $m[0], 'L.map(' ) ? '' : $m[0],
        $content
    );

    // Overlay direkt hinter den Kartencontainer setzen.
    // Callback statt Ersetzungsstring, damit $ und \ im HTML nicht als
    // Rückverweise gedeutet werden.
    return preg_replace_callback(
        '#<div\s+id="map"[^>]*>\s*</div>#i',
        fn( $m ) => $m[0] . physio_anne_map_consent_html(),
        $content,
        1
    );
}, 21 );

/* ════════════════════════════════════════════════════════════
   D) BLOCK PATTERN KATEGORIE
════════════════════════════════════════════════════════════ */

add_action( 'init', function () {
    register_block_pattern_category( 'physio-anne', [
        'label' => __( 'Physio Anne', 'physio-anne-theme' ),
    ] );
} );

/* ════════════════════════════════════════════════════════════
   E) META DESCRIPTION – Custom Field
════════════════════════════════════════════════════════════ */

add_action( 'init', function () {
    register_post_meta( 'page', '_meta_desc', [
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => fn() => current_user_can( 'edit_posts' ),
        'description'   => 'Individuelle Meta-Description für diese Seite (max. 160 Zeichen).',
    ] );
} );

/* ════════════════════════════════════════════════════════════
   F) 301-REDIRECTS – Alt-URLs der statischen Vorgängerseite
   /leistungen.html → /leistungen/ usw. (sonst 404, Rankings weg)
════════════════════════════════════════════════════════════ */

add_action( 'template_redirect', function () {
    if ( ! is_404() ) {
        return;
    }

    $path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
    if ( ! $path || ! preg_match( '#^/([a-z0-9-]+)\.html$#i', $path, $m ) ) {
        return;
    }

    $slug = strtolower( $m[1] );

    // Alt-Slugs, die in WordPress anders heißen (about.html, agbs.html liefen ins 404)
    $aliases = [
        'about' => 'ueber-mich',
        'agbs'  => 'agb',
    ];
    $slug = $aliases[ $slug ] ?? $slug;

    $target = ( 'index' === $slug ) ? home_url( '/' ) : home_url( '/' . $slug . '/' );

    // Nur auf tatsächlich existierende Seiten umleiten
    if ( 'index' !== $slug && ! get_page_by_path( $slug ) ) {
        return;
    }

    wp_safe_redirect( $target, 301 );
    exit;
}, 5 );

/* ════════════════════════════════════════════════════════════
   G) SITEMAP-CLEANUP – nur indexierbare Seiten listen
════════════════════════════════════════════════════════════ */

// User- und Taxonomie-Sitemaps deaktivieren (leer bzw. irrelevant)
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
    return in_array( $name, [ 'users', 'taxonomies' ], true ) ? false : $provider;
}, 10, 2 );

// Beitrags-Sitemap deaktivieren – Seite nutzt keine Posts
add_filter( 'wp_sitemaps_post_types', function ( $post_types ) {
    unset( $post_types['post'] );
    return $post_types;
} );

// Impressum, Datenschutz und AGB gehören seit 1.0.16 in die Sitemap –
// kein Ausschluss mehr, da die Seiten indexiert werden sollen.

/* ════════════════════════════════════════════════════════════
   H) AUFRÄUMEN – Feeds, oEmbed, doppelte Favicons
   Die Seite hat keine Beiträge; Feeds und Einbettungs-Endpunkte
   sind damit toter Ballast im <head> und in der Crawl-Struktur.
════════════════════════════════════════════════════════════ */

remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rest_output_link_wp_head' );

// oEmbed ist in manchen WordPress-Versionen doppelt registriert (Priorität 4
// und 10). Beide entfernen, sonst bleibt je nach Version eine Variante übrig.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 4 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// Das Theme gibt in Abschnitt C ein vollständiges Favicon-Set aus.
// wp_site_icon würde ein zweites, konkurrierendes Set daneben stellen.
// Priorität 99 ist zwingend: WordPress registriert die Funktion mit dieser
// Priorität, und remove_action entfernt nur bei exakter Übereinstimmung.
remove_action( 'wp_head', 'wp_site_icon', 99 );

// Feed-Aufrufe auf die Startseite umleiten statt leere XML-Dateien auszuliefern
add_action( 'template_redirect', function () {
    if ( ! is_feed() ) {
        return;
    }
    wp_safe_redirect( home_url( '/' ), 301 );
    exit;
}, 1 );

/* ════════════════════════════════════════════════════════════
   I) /llms.txt – Kurzprofil für KI-Assistenten

   Analog zu robots.txt, aber für Sprachmodelle: eine kompakte, faktische
   Zusammenfassung der Praxis, damit Assistenten korrekt zitieren statt aus
   dem Seitenlayout zu raten. Bewusst knapp und ohne Werbesprache.
════════════════════════════════════════════════════════════ */

add_action( 'init', function () {
    add_rewrite_rule( '^llms\.txt$', 'index.php?physio_llms=1', 'top' );
} );

/* Rewrite-Regeln nach einem Theme-Update einmalig neu schreiben.
   add_rewrite_rule() meldet die Regel nur an; in der Datenbank landet sie
   erst durch einen Flush. Ohne das liefert eine neu hinzugefügte Route nach
   dem Upload einen 404, bis jemand die Permalinks speichert – genau das war
   bei /llms.txt in 1.0.19 der Fall. Der Versionsvergleich erledigt das
   künftig von selbst. Soft-Flush: die .htaccess bleibt unberührt. */
add_action( 'init', function () {
    $current = wp_get_theme()->get( 'Version' );

    if ( get_option( 'physio_anne_rewrite_version' ) !== $current ) {
        flush_rewrite_rules( false );
        update_option( 'physio_anne_rewrite_version', $current );
    }
}, 99 );

add_filter( 'query_vars', function ( $vars ) {
    $vars[] = 'physio_llms';
    return $vars;
} );

/* WordPress hängt über redirect_canonical() an unbekannte Pfade einen Slash
   an und schickt /llms.txt per 301 auf /llms.txt/. Der Inhalt kommt zwar an,
   aber ein Client, der Weiterleitungen auf .txt-Ressourcen nicht verfolgt,
   sieht nur den Redirect. Für diese eine Route abschalten. */
add_filter( 'redirect_canonical', function ( $redirect_url ) {
    return get_query_var( 'physio_llms' ) ? false : $redirect_url;
} );

add_action( 'template_redirect', function () {
    if ( ! get_query_var( 'physio_llms' ) ) {
        return;
    }

    header( 'Content-Type: text/plain; charset=UTF-8' );
    echo <<<'TXT'
# Physio Anne

> Wahlpraxis für Physiotherapie in Feldkirch, Vorarlberg (Österreich).
> Inhaberin: Anne Günthner, staatlich geprüfte Physiotherapeutin seit 2012,
> freiberuflich als Wahltherapeutin seit Juni 2024.

## Eckdaten

- Adresse: Grenzweg 10, DLZ-Gebäude 1. OG, 6800 Feldkirch, Österreich
- Telefon: +43 660 77 44 162
- E-Mail: info@physio-anne.at
- Einzugsgebiet: Feldkirch, Rankweil, Götzis, Altenstadt, Vorarlberg
- Öffnungszeiten: Mo 12:00–13:30, Di 12:00–15:30, Mi 12:00–13:30,
  Do 08:00–15:30, Fr 08:00–13:30

## Leistungen

- Manuelle Therapie
- Aktive Übungen
- Atemtherapie
- Beckenbodentherapie (Frauen und Männer)
- KPE / Lymphdrainage
- Heilmassage
- Elektrotherapie

## Honorare

- Heilgymnastik: 53 € (30 Min.), 80 € (45 Min.), 106 € (60 Min.)
- KPE (Lymphdrainage): 53 € (30 Min.), 80 € (45 Min.), 106 € (60 Min.)
- Heilmassage: 27 € (15 Min.)
- Elektrotherapie: 7,50 € (15 Min.)
- Umsatzsteuerbefreit gemäß § 6 Abs. 1 Z 19 UStG.

## Wichtige Hinweise

- Wahltherapeutin: kein Kassenvertrag, Abrechnung direkt mit den
  Patient:innen. ÖGK, BVAEB und SVS erstatten auf Antrag einen Teil.
- Eine ärztliche Zuweisung ist für die Behandlung erforderlich und
  Voraussetzung für die Kostenerstattung.
- SVS-Versicherte benötigen vor dem ersten Termin eine Bewilligung der SVS.

## Seiten

- Startseite: https://physio-anne.at/
- Über mich: https://physio-anne.at/ueber-mich/
- Leistungen und Preise: https://physio-anne.at/leistungen/
- Kontakt und Terminanfrage: https://physio-anne.at/kontakt/

TXT;
    exit;
} );

/* ════════════════════════════════════════════════════════════
   J) ROBOTS.TXT

   Haltung: Die Praxis soll in KI-Antworten als Quelle auftauchen dürfen,
   ihre Inhalte aber nicht als Trainingsmaterial hergeben. Beides lässt sich
   trennen, weil die Anbieter getrennte Crawler betreiben:

   - Antwort-/Suchcrawler holen Inhalte, um sie in einer Antwort zu zitieren
     und zu verlinken (OAI-SearchBot, Claude-SearchBot, PerplexityBot) oder
     weil ein Mensch gerade danach gefragt hat (ChatGPT-User, Claude-User).
     Diese sind erlaubt – ohne sie ist die Praxis in ChatGPT, Claude und
     Perplexity schlicht nicht auffindbar.
   - Trainingscrawler sammeln für das Modelltraining (GPTBot, ClaudeBot,
     CCBot, Bytespider, meta-externalagent, Applebot-Extended). Diese
     bleiben gesperrt.

   Google-Extended steuert die Nutzung in Gemini und beim Grounding. Es hat
   KEINEN Einfluss auf die normale Google-Suche und auch nicht auf die
   AI Overviews – die kommen aus dem regulären Suchindex.

   WICHTIG: Cloudflare stellt seinen eigenen Block vor diese Datei. Solange
   die AI-Bot-Sperre dort aktiv ist, greifen die Freigaben hier nicht.
   Siehe README, Abschnitt "robots.txt".
════════════════════════════════════════════════════════════ */

add_filter( 'robots_txt', function ( $output, $public ) {

    // Auf einer als nicht öffentlich markierten Installation nichts überschreiben
    if ( ! $public ) {
        return $output;
    }

    $sitemap = esc_url_raw( home_url( '/wp-sitemap.xml' ) );

    return <<<TXT
# Suche und KI-Antworten sind erwünscht, Modelltraining nicht.
Content-Signal: search=yes, ai-input=yes, ai-train=no

User-agent: *
Allow: /
Disallow: /wp-admin/
Allow: /wp-admin/admin-ajax.php

# ── Antwort- und Suchcrawler: erlaubt ──────────────────────
User-agent: OAI-SearchBot
Allow: /

User-agent: ChatGPT-User
Allow: /

User-agent: Claude-SearchBot
Allow: /

User-agent: Claude-User
Allow: /

User-agent: PerplexityBot
Allow: /

User-agent: Perplexity-User
Allow: /

User-agent: Google-Extended
Allow: /

# ── Trainingscrawler: gesperrt ─────────────────────────────
User-agent: GPTBot
Disallow: /

User-agent: ClaudeBot
Disallow: /

User-agent: CCBot
Disallow: /

User-agent: Bytespider
Disallow: /

User-agent: meta-externalagent
Disallow: /

User-agent: Applebot-Extended
Disallow: /

User-agent: Amazonbot
Disallow: /

Sitemap: {$sitemap}

TXT;
}, 10, 2 );

/* ════════════════════════════════════════════════════════════
   K) KOMMENTARE – vollständig abschalten

   Die Praxisseite besteht aus statischen Seiten, es gibt keine Beiträge und
   keine Diskussion. Die Block-Templates rendern deshalb gar kein
   Kommentarformular – das allein reicht aber nicht: wp-comments-post.php
   nimmt POST-Anfragen unabhängig vom Frontend entgegen, und genau darüber
   tragen Spam-Bots ihre Backlinks ein. Sichtbar wurde das an den
   Moderations-Mails zum WordPress-Beispielbeitrag „Hallo Welt!".

   Der Riegel muss deshalb serverseitig sitzen: comments_open() auf false
   bringt wp_handle_comment_submission() dazu, die Einsendung abzulehnen.
   Die übrigen Filter schließen die Nebenwege (REST, XML-RPC-Pingback) und
   räumen die Kommentar-Oberfläche im Backend auf.
════════════════════════════════════════════════════════════ */

// Kommentar- und Trackback-Unterstützung von allen Inhaltstypen nehmen
add_action( 'init', function () {
    foreach ( get_post_types() as $type ) {
        if ( post_type_supports( $type, 'comments' ) ) {
            remove_post_type_support( $type, 'comments' );
            remove_post_type_support( $type, 'trackbacks' );
        }
    }
}, 100 );

// Kern-Prüfung: schließt Frontend-Formular UND den direkten POST auf
// wp-comments-post.php. Priorität 20, damit sie nach möglichen Plugins greift.
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open',    '__return_false', 20, 2 );

// Bereits in der Datenbank liegende Kommentare nirgends mehr ausgeben
add_filter( 'comments_array', '__return_empty_array', 20, 2 );

// REST-Route /wp/v2/comments entfernen – zweiter Einlieferungsweg für Bots
add_filter( 'rest_endpoints', function ( $endpoints ) {
    unset(
        $endpoints['/wp/v2/comments'],
        $endpoints['/wp/v2/comments/(?P<id>[\d]+)']
    );
    return $endpoints;
} );

// XML-RPC-Pingback abschalten – dritter Weg, zugleich ein DDoS-Verstärker
add_filter( 'xmlrpc_methods', function ( $methods ) {
    unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );
    return $methods;
} );

add_filter( 'wp_headers', function ( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
} );

/* Backend aufräumen. Die URL edit-comments.php bleibt bewusst erreichbar:
   die Freigabe-/Papierkorb-Links aus den alten Moderations-Mails sollen
   weiter funktionieren, damit der Altbestand abgeräumt werden kann. */
add_action( 'admin_menu', function () {
    remove_menu_page( 'edit-comments.php' );
}, 999 );

add_action( 'wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node( 'comments' );
} );

add_action( 'wp_dashboard_setup', function () {
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
} );
