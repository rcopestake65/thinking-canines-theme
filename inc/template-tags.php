<?php
/**
 * Template helpers.
 *
 * @package Thinking_Canines
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Button styles available on ACF "button" repeaters.
 *
 * @return array Style => label.
 */
function tc_button_style_choices() {
	return array(
		'purple'       => __( 'Purple', 'thinking-canines' ),
		'gold'         => __( 'Gold', 'thinking-canines' ),
		'outline'      => __( 'Purple outline', 'thinking-canines' ),
		'outline-gold' => __( 'Gold outline', 'thinking-canines' ),
	);
}

/**
 * Output a button from an ACF link field.
 *
 * @param array|null $link  ACF link array (url, title, target).
 * @param string     $style One of tc_button_style_choices().
 * @param array      $args {
 *     Optional.
 *
 *     @type bool   $arrow Append an arrow icon.
 *     @type string $class Extra CSS classes.
 * }
 */
function tc_button( $link, $style = 'purple', $args = array() ) {
	if ( empty( $link['url'] ) ) {
		return;
	}
	$args = wp_parse_args( $args, array(
		'arrow' => false,
		'class' => '',
	) );

	$classes = trim( 'btn btn--' . $style . ' ' . $args['class'] );
	$target  = ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : '';

	printf(
		'<a href="%s" class="%s"%s>%s%s</a>',
		esc_url( $link['url'] ),
		esc_attr( $classes ),
		$target, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
		esc_html( $link['title'] ),
		$args['arrow'] ? tc_icon( 'arrow', 18 ) : '' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG.
	);
}

/**
 * Output a row of buttons from an ACF repeater with "link" and "style" sub fields.
 *
 * @param array|null $rows  Repeater rows.
 * @param array      $args  Passed to tc_button().
 */
function tc_buttons( $rows, $args = array() ) {
	if ( empty( $rows ) ) {
		return;
	}
	echo '<div class="btn-row">';
	foreach ( $rows as $row ) {
		tc_button( $row['link'] ?? null, $row['style'] ?? 'purple', array_merge( $args, array( 'arrow' => ! empty( $row['arrow'] ) ) ) );
	}
	echo '</div>';
}

/**
 * WhatsApp chat URL from Site Settings.
 *
 * @return string
 */
function tc_whatsapp_url() {
	$number = preg_replace( '/\D+/', '', (string) tc_option( 'whatsapp_number' ) );
	if ( '' === $number ) {
		return '';
	}
	// Convert a UK number with a leading 0 to international format.
	if ( 0 === strpos( $number, '0' ) ) {
		$number = '44' . substr( $number, 1 );
	}
	return 'https://wa.me/' . $number;
}

/**
 * Output the Instagram / Facebook icon links from Site Settings.
 *
 * @param string $class Extra classes for each link.
 * @param int    $size  Icon size.
 */
function tc_social_links( $class = '', $size = 20 ) {
	$networks = array(
		'instagram' => array( tc_option( 'instagram_url' ), __( 'Instagram', 'thinking-canines' ) ),
		'facebook'  => array( tc_option( 'facebook_url' ), __( 'Facebook', 'thinking-canines' ) ),
	);
	foreach ( $networks as $icon => $network ) {
		if ( empty( $network[0] ) ) {
			continue;
		}
		printf(
			'<a href="%s" class="%s" aria-label="%s" target="_blank" rel="noopener">%s</a>',
			esc_url( $network[0] ),
			esc_attr( trim( 'social-link ' . $class ) ),
			esc_attr( $network[1] ),
			tc_icon( $icon, $size ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG.
		);
	}
}

/**
 * Whether any social link is set in Site Settings.
 *
 * @return bool
 */
function tc_has_social_links() {
	return tc_option( 'instagram_url' ) || tc_option( 'facebook_url' );
}

/**
 * Output a photo gallery (carousel) for a list of attachment IDs.
 *
 * @param int[]  $ids   Attachment IDs.
 * @param string $label Accessible name for the carousel.
 */
function tc_gallery( $ids, $label ) {
	$slides = array();
	foreach ( (array) $ids as $id ) {
		$src = wp_get_attachment_image_url( $id, 'large' );
		if ( ! $src ) {
			continue;
		}
		$caption  = (string) wp_get_attachment_caption( $id );
		$alt      = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
		$slides[] = array(
			'id'      => $id,
			'src'     => $src,
			'alt'     => '' !== $alt ? $alt : $caption,
			'caption' => $caption,
		);
	}
	if ( ! $slides ) {
		return;
	}

	$count = count( $slides );
	$first = $slides[0];
	$data  = array_map(
		function ( $slide ) {
			return array(
				'src'     => $slide['src'],
				'alt'     => $slide['alt'],
				'caption' => $slide['caption'],
			);
		},
		$slides
	);
	?>
	<div class="gallery" role="region" aria-roledescription="carousel" aria-label="<?php echo esc_attr( $label ); ?>" data-gallery="<?php echo esc_attr( wp_json_encode( $data ) ); ?>" data-index="0">
		<figure class="gallery__frame">
			<div class="gallery__stage">
				<img class="gallery__backdrop" src="<?php echo esc_url( $first['src'] ); ?>" alt="" aria-hidden="true">
				<img class="gallery__img" src="<?php echo esc_url( $first['src'] ); ?>" alt="<?php echo esc_attr( $first['alt'] ); ?>">
				<?php if ( $count > 1 ) : ?>
					<span class="gallery__counter" aria-live="polite"><?php echo esc_html( sprintf( '01 / %02d', $count ) ); ?></span>
					<button type="button" class="gallery__arrow gallery__arrow--prev" aria-label="<?php esc_attr_e( 'Previous photo', 'thinking-canines' ); ?>" data-action="prev"><?php echo tc_icon( 'chevron-left', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
					<button type="button" class="gallery__arrow gallery__arrow--next" aria-label="<?php esc_attr_e( 'Next photo', 'thinking-canines' ); ?>" data-action="next"><?php echo tc_icon( 'chevron-right', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
				<?php endif; ?>
			</div>
			<figcaption class="gallery__caption"<?php echo '' === $first['caption'] ? ' hidden' : ''; ?>><?php echo esc_html( $first['caption'] ); ?></figcaption>
		</figure>
		<?php if ( $count > 1 ) : ?>
			<div class="gallery__thumbs">
				<?php foreach ( $slides as $i => $slide ) : ?>
					<?php
					/* translators: 1: photo number, 2: photo caption. */
					$thumb_label = $slide['caption'] ? sprintf( __( 'Show photo %1$d: %2$s', 'thinking-canines' ), $i + 1, $slide['caption'] ) : sprintf( __( 'Show photo %d', 'thinking-canines' ), $i + 1 );
					?>
					<button type="button" class="gallery__thumb" aria-label="<?php echo esc_attr( $thumb_label ); ?>" data-action="pick" data-index="<?php echo esc_attr( $i ); ?>"<?php echo 0 === $i ? ' aria-current="true"' : ''; ?>>
						<?php echo wp_get_attachment_image( $slide['id'], 'thumbnail', false, array( 'alt' => '', 'loading' => 'lazy' ) ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Whether a nav menu item points at the page currently being viewed.
 *
 * @param WP_Post $item Menu item.
 * @return bool
 */
function tc_is_current_menu_item( $item ) {
	if ( 'post_type' !== $item->type ) {
		return false;
	}
	$object_id = (int) $item->object_id;

	if ( is_singular() && get_queried_object_id() === $object_id ) {
		return true;
	}
	if ( is_front_page() && (int) get_option( 'page_on_front' ) === $object_id ) {
		return true;
	}
	// Blog listing, single posts and post archives all belong to the posts page.
	$posts_page = (int) get_option( 'page_for_posts' );
	return $posts_page === $object_id && ( is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_date() || is_author() );
}

/**
 * Output the numbered full-screen menu items.
 */
function tc_primary_menu() {
	$locations = get_nav_menu_locations();
	$items     = ! empty( $locations['primary'] ) ? wp_get_nav_menu_items( $locations['primary'] ) : array();
	$items     = array_values( array_filter( (array) $items, fn( $item ) => 0 === (int) $item->menu_item_parent ) );

	if ( ! $items ) {
		return;
	}

	echo '<ul class="site-menu__list">';
	foreach ( $items as $i => $item ) {
		$current = tc_is_current_menu_item( $item );
		printf(
			'<li class="site-menu__item"><a href="%1$s" class="site-menu__link%2$s"%3$s data-action="leaveMenu"%4$s><span class="site-menu__num">%5$02d</span>%6$s%7$s</a></li>',
			esc_url( $item->url ),
			$current ? ' is-current' : '',
			$current ? ' aria-current="page"' : '',
			$item->target ? ' target="' . esc_attr( $item->target ) . '"' : '',
			$i + 1,
			esc_html( $item->title ),
			$current ? tc_icon( 'paw', 0, array( 'class' => 'site-menu__paw' ) ) : '' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG.
		);
	}
	echo '</ul>';
}

/**
 * The first page using a given page template.
 *
 * @param string $template Template file, e.g. 'page-templates/contact.php'.
 * @return int Page ID or 0.
 */
function tc_page_with_template( $template ) {
	$pages = get_posts( array(
		'post_type'      => 'page',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		'meta_value'     => $template, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
	) );
	return $pages ? (int) $pages[0] : 0;
}

/**
 * "Category · Date" line for blog cards.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function tc_post_meta_line( $post = null ) {
	$parts      = array();
	$categories = get_the_category( $post ? get_post( $post )->ID : 0 );
	if ( $categories && 'uncategorized' !== $categories[0]->slug ) {
		$parts[] = $categories[0]->name;
	}
	$parts[] = get_the_date( '', $post );
	return implode( ' · ', $parts );
}

/**
 * Plain-text excerpt for cards.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function tc_card_excerpt( $post = null ) {
	return wp_strip_all_tags( get_the_excerpt( $post ) );
}

/**
 * Output a blog card.
 *
 * @param WP_Post|null $post Post (defaults to the current post in the loop).
 */
function tc_post_card( $post = null ) {
	$post = get_post( $post );
	?>
	<a href="<?php the_permalink( $post ); ?>" class="post-card card">
		<span class="post-card__media">
			<?php if ( has_post_thumbnail( $post ) ) : ?>
				<?php echo get_the_post_thumbnail( $post, 'medium_large', array( 'alt' => '', 'loading' => 'lazy' ) ); ?>
			<?php else : ?>
				<?php echo tc_icon( 'paw', 0, array( 'class' => 'post-card__paw', 'fill' => '#2C2053' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
		</span>
		<span class="post-card__body">
			<span class="post-card__meta"><?php echo esc_html( tc_post_meta_line( $post ) ); ?></span>
			<span class="post-card__title"><?php echo esc_html( get_the_title( $post ) ); ?></span>
			<span class="post-card__excerpt"><?php echo esc_html( tc_card_excerpt( $post ) ); ?></span>
		</span>
	</a>
	<?php
}

/**
 * Category filter pills for the blog.
 */
function tc_category_pills() {
	$categories = get_categories( array(
		'hide_empty' => true,
		'exclude'    => array( (int) get_option( 'default_category' ) ),
	) );
	if ( ! $categories ) {
		return;
	}
	$posts_page = (int) get_option( 'page_for_posts' );
	$all_url    = $posts_page ? get_permalink( $posts_page ) : home_url( '/' );
	$current    = is_category() ? get_queried_object_id() : 0;
	?>
	<nav class="pill-nav" aria-label="<?php esc_attr_e( 'Blog categories', 'thinking-canines' ); ?>">
		<a href="<?php echo esc_url( $all_url ); ?>" class="pill pill--sm<?php echo $current ? '' : ' is-active'; ?>"<?php echo $current ? '' : ' aria-current="page"'; ?>><?php esc_html_e( 'All posts', 'thinking-canines' ); ?></a>
		<?php foreach ( $categories as $category ) : ?>
			<?php $is_current = $current === $category->term_id; ?>
			<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" class="pill pill--sm<?php echo $is_current ? ' is-active' : ''; ?>"<?php echo $is_current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $category->name ); ?></a>
		<?php endforeach; ?>
	</nav>
	<?php
}

/**
 * Numbered pagination for post listings.
 */
function tc_pagination() {
	the_posts_pagination( array(
		'class'              => 'pagination',
		'mid_size'           => 1,
		'prev_text'          => tc_icon( 'chevron-left', 18 ) . '<span class="screen-reader-text">' . __( 'Previous page', 'thinking-canines' ) . '</span>',
		'next_text'          => tc_icon( 'chevron-right', 18 ) . '<span class="screen-reader-text">' . __( 'Next page', 'thinking-canines' ) . '</span>',
		'screen_reader_text' => __( 'Blog pages', 'thinking-canines' ),
	) );
}
