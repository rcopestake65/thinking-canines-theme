<?php
/**
 * Template Name: About
 *
 * @package Thinking_Canines
 */

get_header();

$tc_hero_image  = tc_field( 'hero_image' );
$tc_quals       = tc_field( 'qualifications' );
$tc_outro_image = tc_field( 'outro_image' );
?>

<main id="primary">

	<section class="page-hero about-hero">
		<div class="about-hero__inner container">
			<div class="about-hero__content animate-left">
				<?php if ( tc_field( 'eyebrow' ) ) : ?>
					<p class="eyebrow"><?php echo esc_html( tc_field( 'eyebrow' ) ); ?></p>
				<?php endif; ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php if ( tc_field( 'tagline' ) ) : ?>
					<p class="about-hero__tagline"><?php echo esc_html( tc_field( 'tagline' ) ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $tc_hero_image ) : ?>
				<div class="about-hero__media animate-right">
					<?php echo wp_get_attachment_image( $tc_hero_image, 'large', false, array( 'class' => 'about-hero__img', 'sizes' => '(max-width: 480px) 100vw, 440px', 'loading' => 'eager' ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( tc_field( 'text_sections' ) ) : ?>
		<?php foreach ( tc_field( 'text_sections' ) as $tc_i => $tc_section ) : ?>
			<section class="section<?php echo 0 === $tc_i % 2 ? ' section--cream' : ''; ?>">
				<div class="text-section container">
					<div class="text-section__aside animate-left">
						<h2 class="text-section__title"><?php echo esc_html( $tc_section['title'] ); ?></h2>
					</div>
					<div class="text-section__body flow animate-right">
						<?php echo wp_kses_post( $tc_section['body'] ); ?>
						<?php if ( $tc_section['pull_quote'] ) : ?>
							<blockquote class="pull-quote"><?php echo esc_html( $tc_section['pull_quote'] ); ?></blockquote>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ( $tc_quals ) : ?>
		<section class="section section--flush-top">
			<div class="qualifications container">
				<?php if ( tc_field( 'qualifications_title' ) ) : ?>
					<h2 class="qualifications__title animate-up"><?php echo esc_html( tc_field( 'qualifications_title' ) ); ?></h2>
				<?php endif; ?>
				<ul class="qual-list">
					<?php foreach ( $tc_quals as $tc_qual ) : ?>
						<li class="qual animate-up">
							<span class="qual__icon" aria-hidden="true"><?php echo tc_icon( 'check', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<span class="qual__text">
								<strong class="qual__name"><?php echo esc_html( $tc_qual['name'] ); ?></strong>
								<?php if ( $tc_qual['organisation'] ) : ?>
									<span class="qual__org"><?php echo esc_html( $tc_qual['organisation'] ); ?></span>
								<?php endif; ?>
							</span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( tc_field( 'outro_body' ) || $tc_outro_image ) : ?>
		<section class="section section--cream">
			<div class="split container">
				<div class="outro__content animate-left">
					<div class="flow"><?php echo wp_kses_post( tc_field( 'outro_body' ) ); ?></div>
					<?php if ( tc_field( 'outro_signoff' ) ) : ?>
						<p class="outro__sign"><?php echo esc_html( tc_field( 'outro_signoff' ) ); ?></p>
					<?php endif; ?>
					<?php tc_buttons( tc_field( 'outro_buttons' ) ); ?>
				</div>
				<?php if ( $tc_outro_image ) : ?>
					<figure class="outro__figure animate-right">
						<?php echo wp_get_attachment_image( $tc_outro_image, 'large', false, array( 'class' => 'outro__img', 'loading' => 'lazy' ) ); ?>
						<?php if ( tc_field( 'outro_caption' ) ) : ?>
							<figcaption class="outro__caption"><?php echo esc_html( tc_field( 'outro_caption' ) ); ?></figcaption>
						<?php endif; ?>
					</figure>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();
