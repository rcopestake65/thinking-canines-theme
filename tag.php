<?php
/**
 * Tag archive: every post with the current tag, plus a clear route back to
 * the full blog listing.
 *
 * @package Thinking_Canines
 */

get_header();

$tc_posts_page = (int) get_option( 'page_for_posts' );
$tc_blog_url   = $tc_posts_page ? get_permalink( $tc_posts_page ) : home_url( '/' );
$tc_count     = (int) $GLOBALS['wp_query']->found_posts;
?>

<main id="primary">

	<section class="page-hero page-hero--xs">
		<div class="page-hero__inner container animate-down">
			<p class="eyebrow"><?php esc_html_e( 'Posts tagged', 'thinking-canines' ); ?></p>
			<h1 class="page-title page-title--compact"><?php echo esc_html( single_tag_title( '', false ) ); ?></h1>
			<?php if ( tag_description() ) : ?>
				<div class="page-hero__intro"><?php echo wp_kses_post( tag_description() ); ?></div>
			<?php endif; ?>
			<p class="page-hero__intro">
				<?php
				/* translators: %s: number of posts. */
				echo esc_html( sprintf( _n( '%s post with this tag', '%s posts with this tag', $tc_count, 'thinking-canines' ), number_format_i18n( $tc_count ) ) );
				?>
			</p>
			<div class="btn-row">
				<a href="<?php echo esc_url( $tc_blog_url ); ?>" class="btn btn--purple">
					<?php echo tc_icon( 'arrow-left', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php esc_html_e( 'Back to all blog posts', 'thinking-canines' ); ?>
				</a>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/post-list' ); ?>

</main>

<?php
get_footer();
