<?php
/**
 * Advanced Custom Fields integration.
 *
 * Field groups, the Testimonial post type and the Site Settings options page
 * are managed in the ACF admin and synced to /acf-json in this theme.
 *
 * @package Thinking_Canines
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Save ACF JSON to the theme.
 *
 * @return string
 */
function tc_acf_json_save_path() {
	return TC_THEME_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'tc_acf_json_save_path' );

/**
 * Load ACF JSON from the theme.
 *
 * @param array $paths Load paths.
 * @return array
 */
function tc_acf_json_load_paths( $paths ) {
	$paths[] = TC_THEME_DIR . '/acf-json';
	return array_unique( $paths );
}
add_filter( 'acf/settings/load_json', 'tc_acf_json_load_paths' );

/**
 * Get a field value, tolerating ACF being inactive.
 *
 * @param string    $name    Field name.
 * @param int|false $post_id Post ID, or false for the current post.
 * @return mixed
 */
function tc_field( $name, $post_id = false ) {
	return function_exists( 'get_field' ) ? get_field( $name, $post_id ) : null;
}

/**
 * Get a Site Settings (options page) value.
 *
 * @param string $name Field name.
 * @return mixed
 */
function tc_option( $name ) {
	return tc_field( $name, 'option' );
}
