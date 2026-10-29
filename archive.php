<?php
/**
 * Post archives (categories, tags, dates, authors).
 *
 * @package Thinking_Canines
 */

get_header();

$tc_posts_page = (int) get_option( 'page_for_posts' );
?>

<main id="primary">

	<section class="page-hero page-hero--xs">
		<div class="page-hero__inner container animate-down">
			<p class="eyebrow"><?php echo esc_html( $tc_posts_page ? get_the_title( $tc_posts_page ) : __( 'Blog', 'thinking-canines' ) ); ?></p>
			<h1 class="page-title page-title--compact"><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
			<?php if ( get_the_archive_description() ) : ?>
				<div class="page-hero__intro"><?php echo wp_kses_post( get_the_archive_description() ); ?></div>
			<?php endif; ?>
			<?php tc_category_pills(); ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/post-list' ); ?>

</main>

<?php
get_footer();
