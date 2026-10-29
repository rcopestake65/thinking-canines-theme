<?php
/**
 * 404 page.
 *
 * @package Thinking_Canines
 */

get_header();

$tc_posts_page = (int) get_option( 'page_for_posts' );
?>

<main id="primary">
	<section class="page-hero">
		<div class="not-found__inner container">
			<div class="not-found__content animate-left">
				<p class="eyebrow"><?php esc_html_e( 'Error 404', 'thinking-canines' ); ?></p>
				<h1 class="page-title page-title--compact"><?php esc_html_e( 'Lost the scent', 'thinking-canines' ); ?></h1>
				<p class="page-hero__lead"><?php esc_html_e( "Sorry, we couldn't find that page. It may have moved, or the link may be out of date.", 'thinking-canines' ); ?></p>
				<div class="btn-row">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--purple">
						<?php esc_html_e( 'Back to home', 'thinking-canines' ); ?>
						<?php echo tc_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
					<?php if ( $tc_posts_page ) : ?>
						<a href="<?php echo esc_url( get_permalink( $tc_posts_page ) ); ?>" class="btn btn--outline"><?php echo esc_html( get_the_title( $tc_posts_page ) ); ?></a>
					<?php endif; ?>
				</div>
			</div>
			<?php echo tc_icon( 'paw', 0, array( 'class' => 'not-found__paw', 'fill' => '#2C2053' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</section>
</main>

<?php
get_footer();
