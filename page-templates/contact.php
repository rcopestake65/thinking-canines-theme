<?php
/**
 * Template Name: Contact
 *
 * @package Thinking_Canines
 */

get_header();

$tc_email     = tc_option( 'email' );
$tc_whatsapp  = tc_option( 'whatsapp_number' );
$tc_shortcode = trim( (string) tc_field( 'form_shortcode' ) );
?>

<main id="primary">

	<section class="page-hero page-hero--sm">
		<div class="page-hero__inner container">
			<?php if ( tc_field( 'eyebrow' ) ) : ?>
				<p class="eyebrow"><?php echo esc_html( tc_field( 'eyebrow' ) ); ?></p>
			<?php endif; ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php if ( tc_field( 'tagline' ) ) : ?>
				<p class="page-hero__tagline"><?php echo esc_html( tc_field( 'tagline' ) ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="section section--flush-top">
		<div class="contact container">

			<div class="contact__details">
				<?php if ( $tc_whatsapp ) : ?>
					<a href="<?php echo esc_url( tc_whatsapp_url() ); ?>" class="contact-card card">
						<span class="contact-card__icon" aria-hidden="true"><?php echo tc_icon( 'whatsapp', 26 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span class="contact-card__text">
							<span class="contact-card__label"><?php esc_html_e( 'WhatsApp', 'thinking-canines' ); ?></span>
							<span class="contact-card__value"><?php echo esc_html( $tc_whatsapp ); ?></span>
						</span>
					</a>
				<?php endif; ?>

				<?php if ( $tc_email ) : ?>
					<a href="mailto:<?php echo esc_attr( antispambot( $tc_email ) ); ?>" class="contact-card contact-card--light card">
						<span class="contact-card__icon" aria-hidden="true"><?php echo tc_icon( 'email', 24 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span class="contact-card__text">
							<span class="contact-card__label"><?php esc_html_e( 'Email', 'thinking-canines' ); ?></span>
							<span class="contact-card__value"><?php echo esc_html( antispambot( $tc_email ) ); ?></span>
						</span>
					</a>
				<?php endif; ?>

				<?php if ( tc_has_social_links() ) : ?>
					<div class="contact-follow">
						<span class="contact__label"><?php echo esc_html( tc_field( 'follow_label' ) ?: __( 'Follow along', 'thinking-canines' ) ); ?></span>
						<div class="social-links"><?php tc_social_links( 'social-link--purple' ); ?></div>
					</div>
				<?php endif; ?>

				<?php if ( tc_field( 'area_text' ) ) : ?>
					<div class="contact-area">
						<?php if ( tc_field( 'area_title' ) ) : ?>
							<span class="contact__label"><?php echo esc_html( tc_field( 'area_title' ) ); ?></span>
						<?php endif; ?>
						<p class="contact-area__text"><?php echo esc_html( tc_field( 'area_text' ) ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<div class="enquiry">
				<div class="enquiry__head">
					<?php if ( tc_field( 'form_title' ) ) : ?>
						<h2 class="enquiry__title"><?php echo esc_html( tc_field( 'form_title' ) ); ?></h2>
					<?php endif; ?>
					<?php if ( tc_field( 'form_intro' ) ) : ?>
						<p class="enquiry__intro"><?php echo esc_html( tc_field( 'form_intro' ) ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( $tc_shortcode ) : ?>
					<div class="enquiry__form"><?php echo do_shortcode( $tc_shortcode ); ?></div>
				<?php elseif ( current_user_can( 'edit_pages' ) ) : ?>
					<div class="form-placeholder">
						<span class="form-placeholder__badge"><?php esc_html_e( 'Form placeholder', 'thinking-canines' ); ?></span>
						<p class="form-placeholder__text"><?php esc_html_e( 'Add the WPForms shortcode in the "Enquiry form shortcode" field on this page to show the form here. Only logged-in editors can see this box.', 'thinking-canines' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</section>

</main>

<?php
get_footer();
