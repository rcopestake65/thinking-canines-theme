<?php
/**
 * Template Name: Services
 *
 * @package Thinking_Canines
 */

get_header();

$tc_services = tc_field( 'services' );
?>

<main id="primary">

	<section class="page-hero">
		<div class="page-hero__inner page-hero__inner--wide-gap container animate-down">
			<?php if ( tc_field( 'eyebrow' ) ) : ?>
				<p class="eyebrow"><?php echo esc_html( tc_field( 'eyebrow' ) ); ?></p>
			<?php endif; ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php if ( tc_field( 'lead' ) ) : ?>
				<p class="page-hero__lead"><?php echo esc_html( tc_field( 'lead' ) ); ?></p>
			<?php endif; ?>
			<?php if ( $tc_services ) : ?>
				<nav class="pill-nav" aria-label="<?php esc_attr_e( 'Services on this page', 'thinking-canines' ); ?>">
					<?php foreach ( $tc_services as $tc_service ) : ?>
						<a href="#<?php echo esc_attr( sanitize_title( $tc_service['anchor'] ?: $tc_service['title'] ) ); ?>" class="pill"><?php echo esc_html( $tc_service['nav_label'] ?: $tc_service['title'] ); ?></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( tc_field( 'intro' ) || tc_field( 'callout_title' ) ) : ?>
		<section class="section section--flush-top">
			<div class="intro container">
				<div class="intro__body flow animate-left"><?php echo wp_kses_post( tc_field( 'intro' ) ); ?></div>
				<?php if ( tc_field( 'callout_title' ) ) : ?>
					<aside class="callout animate-right">
						<?php echo tc_icon( 'paw', 40 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<p class="callout__title"><?php echo esc_html( tc_field( 'callout_title' ) ); ?></p>
						<div class="callout__text flow"><?php echo wp_kses_post( tc_field( 'callout_text' ) ); ?></div>
					</aside>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $tc_services ) : ?>
		<?php foreach ( $tc_services as $tc_i => $tc_service ) : ?>
			<?php
			// Odd rows sit on the page background with the photos on the left;
			// even rows alternate between cream and gold backgrounds.
			$tc_reverse = 1 === $tc_i % 2;
			$tc_bg      = $tc_reverse ? '' : ( 0 === ( $tc_i / 2 ) % 2 ? ' section--cream' : ' section--gold' );
			// Each side slides in from the edge it sits against.
			$tc_content_anim = $tc_reverse ? 'animate-right' : 'animate-left';
			$tc_media_anim   = $tc_reverse ? 'animate-left' : 'animate-right';
			?>
			<section id="<?php echo esc_attr( sanitize_title( $tc_service['anchor'] ?: $tc_service['title'] ) ); ?>" class="section service<?php echo esc_attr( $tc_bg ); ?>">
				<div class="service__inner<?php echo $tc_reverse ? ' service__inner--reverse' : ''; ?> container">
					<div class="service__content <?php echo esc_attr( $tc_content_anim ); ?>">
						<span class="service__num"><?php echo esc_html( sprintf( '%02d', $tc_i + 1 ) ); ?></span>
						<h2 class="service__title"><?php echo esc_html( $tc_service['title'] ); ?></h2>
						<?php if ( $tc_service['highlight_before'] ) : ?>
							<p class="service__highlight"><?php echo esc_html( $tc_service['highlight_before'] ); ?></p>
						<?php endif; ?>
						<div class="flow"><?php echo wp_kses_post( $tc_service['body'] ); ?></div>
						<?php if ( $tc_service['highlight_after'] ) : ?>
							<p class="service__highlight"><?php echo esc_html( $tc_service['highlight_after'] ); ?></p>
						<?php endif; ?>
					</div>
					<?php if ( $tc_service['gallery'] ) : ?>
						<div class="service__media <?php echo esc_attr( $tc_media_anim ); ?>">
							<?php
							/* translators: %s: service name. */
							tc_gallery( $tc_service['gallery'], sprintf( __( '%s – photos', 'thinking-canines' ), $tc_service['nav_label'] ?: $tc_service['title'] ) );
							?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ( tc_field( 'cta_title' ) ) : ?>
		<section class="cta-band">
			<div class="cta-band__inner container animate-up">
				<div class="cta-band__text">
					<h2 class="cta-band__title"><?php echo esc_html( tc_field( 'cta_title' ) ); ?></h2>
					<?php if ( tc_field( 'cta_text' ) ) : ?>
						<p class="cta-band__body"><?php echo esc_html( tc_field( 'cta_text' ) ); ?></p>
					<?php endif; ?>
				</div>
				<?php tc_buttons( tc_field( 'cta_buttons' ) ); ?>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();
