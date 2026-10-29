<?php
/**
 * Template Name: Testimonials
 *
 * The featured testimonial is shown large; all others follow in a grid,
 * ordered by their "Order" attribute and then newest first.
 *
 * @package Thinking_Canines
 */

get_header();

$tc_featured = tc_field( 'featured_testimonial' );
$tc_others   = get_posts( array(
	'post_type'      => 'testimonial',
	'posts_per_page' => -1,
	'post__not_in'   => $tc_featured ? array( $tc_featured ) : array(),
	'orderby'        => array(
		'menu_order' => 'ASC',
		'date'       => 'DESC',
	),
) );
?>

<main id="primary">

	<section class="page-hero page-hero--sm">
		<div class="testimonials-hero__inner container">
			<div class="page-hero__inner animate-down">
				<?php if ( tc_field( 'eyebrow' ) ) : ?>
					<p class="eyebrow"><?php echo esc_html( tc_field( 'eyebrow' ) ); ?></p>
				<?php endif; ?>
				<h1 class="page-title page-title--compact"><?php the_title(); ?></h1>
			</div>
			<?php echo tc_icon( 'paw', 0, array( 'class' => 'testimonials-hero__paw' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</section>

	<section class="section section--flush-top">
		<div class="testimonials container">

			<?php if ( $tc_featured ) : ?>
				<?php
				$tc_photo = tc_field( 'photo', $tc_featured );
				$tc_dog   = tc_field( 'dog', $tc_featured );
				$tc_year  = tc_field( 'year', $tc_featured );
				?>
				<figure class="testimonial-feature animate-up">
					<span class="testimonial-feature__mark" aria-hidden="true">“</span>
					<blockquote class="testimonial-feature__quote">
						<?php if ( tc_field( 'lead', $tc_featured ) ) : ?>
							<p class="testimonial-feature__lead"><?php echo esc_html( tc_field( 'lead', $tc_featured ) ); ?></p>
						<?php endif; ?>
						<?php echo wp_kses_post( wpautop( tc_field( 'quote', $tc_featured ) ) ); ?>
					</blockquote>
					<figcaption class="testimonial-feature__caption">
						<?php
						if ( $tc_photo ) {
							echo wp_get_attachment_image( $tc_photo, 'thumbnail', false, array( 'class' => 'testimonial-feature__avatar', 'loading' => 'lazy' ) );
						}
						?>
						<span class="testimonial-feature__cite">
							<strong><?php echo esc_html( get_the_title( $tc_featured ) ); ?></strong><?php echo $tc_year ? ' · ' . esc_html( $tc_year ) : ''; ?>
						</span>
					</figcaption>
				</figure>
			<?php endif; ?>

			<?php if ( $tc_others ) : ?>
				<div class="testimonial-grid">
					<?php foreach ( $tc_others as $tc_testimonial ) : ?>
						<?php $tc_year = tc_field( 'year', $tc_testimonial ); ?>
						<figure class="testimonial-card animate-up">
							<span class="testimonial-card__mark" aria-hidden="true">“</span>
							<blockquote class="testimonial-card__quote flow">
								<?php if ( tc_field( 'lead', $tc_testimonial ) ) : ?>
									<p><?php echo esc_html( tc_field( 'lead', $tc_testimonial ) ); ?></p>
								<?php endif; ?>
								<?php echo wp_kses_post( wpautop( tc_field( 'quote', $tc_testimonial ) ) ); ?>
							</blockquote>
							<figcaption class="testimonial-card__cite">
								<strong><?php echo esc_html( get_the_title( $tc_testimonial ) ); ?></strong><?php echo $tc_year ? ' · ' . esc_html( $tc_year ) : ''; ?>
							</figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( tc_field( 'cta_text' ) ) : ?>
				<div class="testimonials__cta animate-up">
					<p class="testimonials__cta-text"><?php echo esc_html( tc_field( 'cta_text' ) ); ?></p>
					<?php tc_button( tc_field( 'cta_button' ), 'purple' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</section>

</main>

<?php
get_footer();
