<?php
/**
 * Fallback template (search results and anything not covered elsewhere).
 *
 * @package Thinking_Canines
 */

get_header();
?>

<main id="primary">

	<section class="page-hero page-hero--xs">
		<div class="page-hero__inner container">
			<h1 class="page-title page-title--compact">
				<?php
				if ( is_search() ) {
					/* translators: %s: search query. */
					echo esc_html( sprintf( __( 'Search: %s', 'thinking-canines' ), get_search_query() ) );
				} else {
					echo esc_html( wp_strip_all_tags( get_the_archive_title() ) );
				}
				?>
			</h1>
		</div>
	</section>

	<?php get_template_part( 'template-parts/post-list' ); ?>

</main>

<?php
get_footer();
