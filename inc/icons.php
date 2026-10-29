<?php
/**
 * Inline SVG icons.
 *
 * @package Thinking_Canines
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icons selectable for the home page feature boxes.
 *
 * @return array Icon name => label.
 */
function tc_feature_icon_choices() {
	return array(
		'home'     => __( 'House', 'thinking-canines' ),
		'paw'      => __( 'Paw', 'thinking-canines' ),
		'document' => __( 'Document', 'thinking-canines' ),
		'heart'    => __( 'Heart', 'thinking-canines' ),
	);
}

/**
 * Return an inline SVG icon.
 *
 * @param string $name Icon name.
 * @param int    $size Width and height in pixels; 0 omits them so CSS sizes the icon.
 * @param array  $args {
 *     Optional. Extra settings.
 *
 *     @type string $class CSS class.
 *     @type string $fill  Fill colour for the paw (defaults to the brand gold).
 * }
 * @return string
 */
function tc_icon( $name, $size = 24, $args = array() ) {
	$args = wp_parse_args( $args, array(
		'class' => '',
		'fill'  => '#EED18D',
	) );

	$stroke = 'fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"';

	switch ( $name ) {
		case 'paw':
			$view  = '0 0 100 100';
			$attrs = 'fill="' . esc_attr( $args['fill'] ) . '"';
			$body  = '<ellipse cx="20" cy="44" rx="10" ry="14" transform="rotate(-22 20 44)"/><ellipse cx="39" cy="22" rx="10" ry="15" transform="rotate(-8 39 22)"/><ellipse cx="62" cy="22" rx="10" ry="15" transform="rotate(8 62 22)"/><ellipse cx="81" cy="44" rx="10" ry="14" transform="rotate(22 81 44)"/><path d="M50 48c-12 0-26 16-26 30 0 9 7 14 15 12 5-1 7-4 11-4s6 3 11 4c8 2 15-3 15-12 0-14-14-30-26-30z"/>';
			break;
		case 'arrow':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="2.4"';
			$body  = '<path d="M5 12h14M13 6l6 6-6 6"/>';
			break;
		case 'arrow-left':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="2.4"';
			$body  = '<path d="M19 12H5M11 6l-6 6 6 6"/>';
			break;
		case 'chevron-left':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="2.6"';
			$body  = '<path d="M15 5l-7 7 7 7"/>';
			break;
		case 'chevron-right':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="2.6"';
			$body  = '<path d="M9 5l7 7-7 7"/>';
			break;
		case 'close':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="2.6"';
			$body  = '<path d="M6 6l12 12M18 6L6 18"/>';
			break;
		case 'check':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="2.4"';
			$body  = '<path d="M5 12.5l4.5 4.5L19 7.5"/>';
			break;
		case 'home':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="1.9"';
			$body  = '<path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/><path d="M10 20v-6h4v6"/>';
			break;
		case 'document':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="1.9"';
			$body  = '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/>';
			break;
		case 'heart':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="1.9"';
			$body  = '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1 1.1L12 21l7.8-7.5 1-1.1a5.5 5.5 0 0 0 0-7.8z"/>';
			break;
		case 'instagram':
			$view  = '0 0 24 24';
			$attrs = 'fill="none" stroke="currentColor" stroke-width="2"';
			$body  = '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"/>';
			break;
		case 'facebook':
			$view  = '0 0 24 24';
			$attrs = 'fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"';
			$body  = '<path d="M15 3h-2.5A3.5 3.5 0 0 0 9 6.5V10H6.5v3.5H9V21h3.5v-7.5H15l.5-3.5h-3V7a1 1 0 0 1 1-1H15z"/>';
			break;
		case 'whatsapp':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="2"';
			$body  = '<path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 20.5l1.6-5.4A8.4 8.4 0 1 1 21 11.5z"/>';
			break;
		case 'email':
			$view  = '0 0 24 24';
			$attrs = $stroke . ' stroke-width="2"';
			$body  = '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>';
			break;
		default:
			return '';
	}

	$size_attrs = $size ? sprintf( ' width="%1$d" height="%1$d"', $size ) : '';
	$class      = $args['class'] ? ' class="' . esc_attr( $args['class'] ) . '"' : '';

	return sprintf(
		'<svg viewBox="%s"%s %s aria-hidden="true" focusable="false"%s>%s</svg>',
		$view,
		$size_attrs,
		$attrs,
		$class,
		$body
	);
}
