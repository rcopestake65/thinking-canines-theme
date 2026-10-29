<?php
/**
 * Thinking Canines theme functions.
 *
 * @package Thinking_Canines
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TC_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'TC_THEME_DIR', get_template_directory() );
define( 'TC_THEME_URI', get_template_directory_uri() );

// GSAP version loaded from the CDN.
define( 'TC_GSAP_VERSION', '3.13.0' );

require TC_THEME_DIR . '/inc/acf.php';
require TC_THEME_DIR . '/inc/icons.php';
require TC_THEME_DIR . '/inc/template-tags.php';

/**
 * Theme setup.
 */
function tc_setup() {
	load_theme_textdomain( 'thinking-canines', TC_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
		'navigation-widgets',
	) );

	register_nav_menus( array(
		'primary' => __( 'Main Menu (full-screen)', 'thinking-canines' ),
		'footer'  => __( 'Footer "Explore" Menu', 'thinking-canines' ),
		'legal'   => __( 'Footer Legal Links', 'thinking-canines' ),
	) );
}
add_action( 'after_setup_theme', 'tc_setup' );

/**
 * Enqueue styles and scripts.
 */
function tc_enqueue_assets() {
	wp_enqueue_style( 'tc-main', TC_THEME_URI . '/assets/css/main.css', array(), TC_THEME_VERSION );

	// GSAP core + ScrollTrigger from the jsDelivr CDN.
	wp_enqueue_script(
		'gsap',
		'https://cdn.jsdelivr.net/npm/gsap@' . TC_GSAP_VERSION . '/dist/gsap.min.js',
		array(),
		null,
		array( 'strategy' => 'defer', 'in_footer' => true )
	);
	wp_enqueue_script(
		'gsap-scrolltrigger',
		'https://cdn.jsdelivr.net/npm/gsap@' . TC_GSAP_VERSION . '/dist/ScrollTrigger.min.js',
		array( 'gsap' ),
		null,
		array( 'strategy' => 'defer', 'in_footer' => true )
	);

	// Menu and gallery behaviour.
	wp_enqueue_script(
		'tc-site',
		TC_THEME_URI . '/assets/js/site.js',
		array(),
		TC_THEME_VERSION,
		array( 'strategy' => 'defer', 'in_footer' => true )
	);

	// Scroll animations.
	wp_enqueue_script(
		'tc-main',
		TC_THEME_URI . '/assets/js/main.js',
		array( 'gsap', 'gsap-scrolltrigger' ),
		TC_THEME_VERSION,
		array( 'strategy' => 'defer', 'in_footer' => true )
	);
}
add_action( 'wp_enqueue_scripts', 'tc_enqueue_assets' );

/**
 * Preload the two most-used font files.
 */
function tc_preload_fonts() {
	foreach ( array( 'bricolage-grotesque-latin', 'open-sans-latin' ) as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( TC_THEME_URI . '/assets/fonts/' . $font . '.woff2' )
		);
	}
}
add_action( 'wp_head', 'tc_preload_fonts', 1 );

/**
 * Swap the "no-js" class for "js" as early as possible to avoid a flash of
 * content before GSAP animations run.
 */
function tc_js_class() {
	echo "<script>document.documentElement.classList.replace('no-js','js');</script>\n";
}
add_action( 'wp_head', 'tc_js_class', 0 );

/**
 * Use the theme logo as the favicon until a Site Icon is set in the Customizer.
 */
function tc_fallback_favicon() {
	if ( has_site_icon() ) {
		return;
	}
	printf(
		'<link rel="icon" href="%s" type="image/svg+xml">' . "\n",
		esc_url( TC_THEME_URI . '/assets/images/thinking-canines-logo.svg' )
	);
}
add_action( 'wp_head', 'tc_fallback_favicon' );

/**
 * Preconnect to the GSAP CDN.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function tc_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://cdn.jsdelivr.net',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'tc_resource_hints', 10, 2 );

/**
 * Shorter excerpts for blog cards.
 *
 * @return int
 */
function tc_excerpt_length() {
	return 28;
}
add_filter( 'excerpt_length', 'tc_excerpt_length' );

/**
 * Plain ellipsis after trimmed excerpts.
 *
 * @return string
 */
function tc_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'tc_excerpt_more' );

// Archive headings show just the category / tag name, without "Category:".
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
