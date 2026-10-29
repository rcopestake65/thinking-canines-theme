<?php
/**
 * Grid of post cards for the remaining posts in the main query, with pagination.
 *
 * @package Thinking_Canines
 */

$tc_has_more = have_posts();
?>
<section class="section section--flush-top">
	<div class="post-list container">
		<?php if ( $tc_has_more ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					tc_post_card();
				endwhile;
				?>
			</div>
		<?php elseif ( 0 === $GLOBALS['wp_query']->post_count ) : ?>
			<p class="empty-state"><?php esc_html_e( 'No posts yet – check back soon.', 'thinking-canines' ); ?></p>
		<?php endif; ?>

		<?php tc_pagination(); ?>
	</div>
</section>
