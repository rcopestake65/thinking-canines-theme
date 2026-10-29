<?php
/**
 * Home page.
 *
 * @package Thinking_Canines
 */

get_header();

$tc_services_page = tc_page_with_template( 'page-templates/services.php' );
$tc_services      = $tc_services_page ? tc_field( 'services', $tc_services_page ) : array();
$tc_testimonial   = tc_field( 'testimonial' );
$tc_hero_image    = tc_field( 'hero_image' );
$tc_badge_link    = tc_field( 'hero_badge_link' );
?>

<main id="primary">

	<section class="hero">
		<div class="hero__inner container">
			<div class="hero__content animate-left">
				<?php if ( tc_field( 'hero_eyebrow' ) ) : ?>
					<p class="eyebrow"><?php echo esc_html( tc_field( 'hero_eyebrow' ) ); ?></p>
				<?php endif; ?>
				<h1 class="hero__title"><?php echo esc_html( tc_field( 'hero_title' ) ?: get_the_title() ); ?></h1>
				<?php if ( tc_field( 'hero_tagline' ) ) : ?>
					<p class="hero__tagline"><?php echo esc_html( tc_field( 'hero_tagline' ) ); ?></p>
				<?php endif; ?>
				<?php if ( tc_field( 'hero_intro' ) ) : ?>
					<div class="hero__intro flow"><?php echo wp_kses_post( tc_field( 'hero_intro' ) ); ?></div>
				<?php endif; ?>
				<?php if ( tc_field( 'hero_buttons' ) ) : ?>
					<div class="hero__actions">
						<?php foreach ( tc_field( 'hero_buttons' ) as $tc_row ) : ?>
							<?php tc_button( $tc_row['link'], 'purple', array( 'arrow' => true ) ); ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $tc_hero_image ) : ?>
				<div class="hero__media animate-right">
					<div class="hero__backdrop" aria-hidden="true"></div>
					<?php
					echo wp_get_attachment_image( $tc_hero_image, 'large', false, array(
						'class'         => 'hero__img',
						'sizes'         => '(max-width: 700px) 100vw, 620px',
						'loading'       => 'eager',
						'fetchpriority' => 'high',
					) );
					?>
					<?php if ( tc_field( 'hero_badge_text' ) ) : ?>
						<<?php echo $tc_badge_link ? 'a href="' . esc_url( $tc_badge_link ) . '" target="_blank" rel="noopener"' : 'span'; ?> class="hero__badge">
							<?php echo tc_icon( 'paw', 34 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php echo wp_kses( tc_field( 'hero_badge_text' ), array( 'br' => array() ) ); ?>
						</<?php echo $tc_badge_link ? 'a' : 'span'; ?>>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="section section--cream">
		<div class="features container">
			<div class="section-head animate-up">
				<h2 class="section-title"><?php echo esc_html( tc_field( 'features_title' ) ); ?></h2>
				<?php if ( tc_field( 'features_intro' ) ) : ?>
					<p class="features__intro"><?php echo esc_html( tc_field( 'features_intro' ) ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( tc_field( 'features' ) ) : ?>
				<div class="features__grid">
					<?php foreach ( tc_field( 'features' ) as $tc_feature ) : ?>
						<div class="feature animate-up">
							<div class="feature__icon">
								<?php
								echo 'paw' === $tc_feature['icon']
									? tc_icon( 'paw', 28, array( 'fill' => 'currentColor' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									: tc_icon( $tc_feature['icon'], 28 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</div>
							<h3 class="feature__title"><?php echo esc_html( $tc_feature['title'] ); ?></h3>
							<p class="feature__text"><?php echo esc_html( $tc_feature['text'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( tc_field( 'trust_text' ) || tc_field( 'trust_badges' ) ) : ?>
				<div class="trust-bar animate-up">
					<p class="trust-bar__text"><?php echo esc_html( tc_field( 'trust_text' ) ); ?></p>
					<?php if ( tc_field( 'trust_badges' ) ) : ?>
						<div class="trust-bar__badges">
							<?php foreach ( tc_field( 'trust_badges' ) as $tc_badge ) : ?>
								<span class="trust-badge">✓ <?php echo esc_html( $tc_badge['label'] ); ?></span>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="section">
		<div class="split container">
			<?php if ( tc_field( 'meet_gallery' ) ) : ?>
				<div class="meet__gallery animate-left">
					<?php tc_gallery( tc_field( 'meet_gallery' ), tc_field( 'meet_gallery_label' ) ?: __( 'Photos', 'thinking-canines' ) ); ?>
				</div>
			<?php endif; ?>
			<div class="meet__content animate-right">
				<?php if ( tc_field( 'meet_eyebrow' ) ) : ?>
					<p class="eyebrow"><?php echo esc_html( tc_field( 'meet_eyebrow' ) ); ?></p>
				<?php endif; ?>
				<p class="meet__quote"><?php echo esc_html( tc_field( 'meet_quote' ) ); ?></p>
				<?php if ( tc_field( 'meet_signature' ) ) : ?>
					<p class="meet__sign"><?php echo esc_html( tc_field( 'meet_signature' ) ); ?></p>
				<?php endif; ?>
				<?php tc_button( tc_field( 'meet_button' ), 'purple', array( 'arrow' => true ) ); ?>
			</div>
		</div>
	</section>

	<?php if ( $tc_services ) : ?>
		<section class="section section--gold">
			<div class="services-preview container">
				<div class="section-head animate-up">
					<h2 class="section-title"><?php echo esc_html( tc_field( 'services_title' ) ); ?></h2>
					<?php tc_button( tc_field( 'services_button' ), 'purple', array( 'arrow' => true ) ); ?>
				</div>
				<div class="svc-grid">
					<?php foreach ( $tc_services as $tc_i => $tc_service ) : ?>
						<a href="<?php echo esc_url( get_permalink( $tc_services_page ) . ( $tc_service['anchor'] ? '#' . sanitize_title( $tc_service['anchor'] ) : '' ) ); ?>" class="svc-card card animate-up">
							<?php
							if ( $tc_service['card_image'] ) {
								echo wp_get_attachment_image( $tc_service['card_image'], 'medium_large', false, array( 'class' => 'svc-card__img', 'loading' => 'lazy' ) );
							}
							?>
							<div class="svc-card__body">
								<span class="svc-card__num"><?php echo esc_html( sprintf( '%02d', $tc_i + 1 ) ); ?></span>
								<h3 class="svc-card__title"><?php echo esc_html( $tc_service['card_title'] ?: $tc_service['title'] ); ?></h3>
								<p class="svc-card__text"><?php echo esc_html( $tc_service['card_text'] ); ?></p>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $tc_testimonial ) : ?>
		<?php
		$tc_dog  = tc_field( 'dog', $tc_testimonial );
		$tc_year = tc_field( 'year', $tc_testimonial );
		?>
		<section class="quote-band">
			<?php echo tc_icon( 'paw', 0, array( 'class' => 'quote-band__watermark' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<figure class="quote-band__figure animate-up">
				<span class="quote-band__mark" aria-hidden="true">“</span>
				<blockquote class="quote-band__quote"><?php echo esc_html( tc_field( 'short_quote', $tc_testimonial ) ?: tc_field( 'lead', $tc_testimonial ) ); ?></blockquote>
				<figcaption class="quote-band__caption">
					<span>
						<strong><?php echo esc_html( get_the_title( $tc_testimonial ) ); ?></strong><?php echo $tc_dog ? ', ' . esc_html( $tc_dog ) : ''; ?><?php echo $tc_year ? ' · ' . esc_html( $tc_year ) : ''; ?>
					</span>
					<?php tc_button( tc_field( 'testimonial_button' ), 'gold', array( 'arrow' => true ) ); ?>
				</figcaption>
			</figure>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();
