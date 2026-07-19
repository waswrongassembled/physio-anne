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

    // Google Fonts
    wp_enqueue_style(
        'physio-anne-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap',
        [],
        null
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

    // Leaflet – nur auf Kontakt-Seite laden
    if ( is_page( 'kontakt' ) ) {
        wp_enqueue_style(
            'leaflet-css',
            'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
            [],
            '1.9.4'
        );
        wp_enqueue_script(
            'leaflet-js',
            'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
            [],
            '1.9.4',
            true
        );
    }
} );

// Preconnect für Google Fonts
add_action( 'wp_head', function () {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
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

// Titel-Trennzeichen
add_filter( 'document_title_separator', fn() => '–' );

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

add_action( 'wp_head', function () {

    global $post;

    $site_url   = 'https://physio-anne.at';
    $theme_url  = get_template_directory_uri();
    $og_image   = $theme_url . '/assets/images/about-col.jpg';
    $og_img_alt = 'Anne Günthner, Physiotherapeutin in Feldkirch';

    // Slug der aktuellen Seite ermitteln
    $slug = '';
    if ( is_front_page() ) {
        $slug = 'front-page';
    } elseif ( is_page() && $post ) {
        $slug = $post->post_name;
    }

    // Seitenspezifische Meta-Daten
    $pages = [
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
            'noindex'     => true,
        ],
        'datenschutz' => [
            'title'       => 'Datenschutzerklärung – Physio Anne',
            'description' => 'Datenschutzerklärung von Physio Anne – Anne Günthner, Physiotherapeutin in Feldkirch.',
            'url'         => $site_url . '/datenschutz/',
            'og_type'     => 'website',
            'tw_desc'     => 'Datenschutz – Physio Anne Feldkirch',
            'noindex'     => true,
        ],
        'agb' => [
            'title'       => 'AGB – Physio Anne',
            'description' => 'Allgemeine Geschäftsbedingungen von Physio Anne – Anne Günthner, Physiotherapeutin in Feldkirch.',
            'url'         => $site_url . '/agb/',
            'og_type'     => 'website',
            'tw_desc'     => 'AGB – Physio Anne Feldkirch',
            'noindex'     => true,
        ],
    ];

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
    $noindex     = ! empty( $current['noindex'] );

    echo "\n<!-- Physio Anne SEO -->\n";

    // Meta Description
    echo '<meta name="description" content="' . $description . '">' . "\n";

    // Canonical
    echo '<link rel="canonical" href="' . $page_url . '">' . "\n";

    // noindex für legale Seiten
    if ( $noindex ) {
        echo '<meta name="robots" content="noindex, nofollow">' . "\n";
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
        'telephone'       => '+43660774162',
        'email'           => 'info@physio-anne.at',
        'address'         => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Grenzweg 10, DLZ-Gebäude 1. OG',
            'addressLocality' => 'Feldkirch',
            'postalCode'      => '6800',
            'addressRegion'   => 'Vorarlberg',
            'addressCountry'  => 'AT',
        ],
        'geo'             => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => 47.259972,
            'longitude' => 9.606842,
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
            'telephone'   => '+43660774162',
            'contactType' => 'appointment scheduling',
        ],
        'founder'         => [ '@id' => $anne_id ],
        'employee'        => [ '@id' => $anne_id ],
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
            $graph[] = [
                '@type'      => 'AggregateRating',
                'itemReviewed' => [ '@id' => $business_id ],
                'ratingValue' => '5',
                'bestRating'  => '5',
                'ratingCount' => '2',
            ];
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

    $jsonld = json_encode(
        [ '@context' => 'https://schema.org', '@graph' => $graph ],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );

    return "\n<script type=\"application/ld+json\">\n" . $jsonld . "\n</script>\n";
}

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

    $slug   = strtolower( $m[1] );
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

// noindex-Seiten (Impressum, Datenschutz, AGB) aus Seiten-Sitemap entfernen
add_filter( 'wp_sitemaps_posts_query_args', function ( $args, $post_type ) {
    if ( 'page' !== $post_type ) {
        return $args;
    }
    $exclude = array_filter( array_map(
        fn( $slug ) => get_page_by_path( $slug )->ID ?? 0,
        [ 'impressum', 'datenschutz', 'agb' ]
    ) );
    $args['post__not_in'] = array_merge( $args['post__not_in'] ?? [], $exclude );
    return $args;
}, 10, 2 );
