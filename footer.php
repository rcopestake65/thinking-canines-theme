<?php
/**
 * The footer.
 *
 * @package Thinking_Canines
 */

$tc_email           = tc_option( 'email' );
$tc_whatsapp        = tc_option( 'whatsapp_number' );
$tc_accreditations  = tc_option( 'accreditations' );
$tc_footer_cta      = tc_option( 'footer_cta_title' );
?>
	<footer class="site-footer">
		<div class="site-footer__inner">

			<?php if ( $tc_footer_cta ) : ?>
				<div class="footer-cta animate-up">
					<h2 class="footer-cta__title"><?php echo esc_html( $tc_footer_cta ); ?></h2>
					<div class="btn-row">
						<?php tc_button( tc_option( 'footer_cta_primary' ), 'gold' ); ?>
						<?php tc_button( tc_option( 'footer_cta_secondary' ), 'outline-gold' ); ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="site-footer__main animate-up">
				<div class="site-footer__brand">
					<img src="<?php echo esc_url( TC_THEME_URI . '/assets/images/thinking-canines-logo.svg' ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %s: site name. */ __( '%s logo', 'thinking-canines' ), get_bloginfo( 'name' ) ) ); ?>" class="site-footer__logo" width="120" height="120" loading="lazy">
					<?php if ( tc_option( 'tagline' ) ) : ?>
						<p class="site-footer__tagline"><?php echo esc_html( tc_option( 'tagline' ) ); ?></p>
					<?php endif; ?>
					<?php if ( tc_option( 'footer_blurb' ) ) : ?>
						<p class="site-footer__blurb"><?php echo esc_html( tc_option( 'footer_blurb' ) ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav class="site-footer__col site-footer__col--nav" aria-label="<?php esc_attr_e( 'Footer', 'thinking-canines' ); ?>">
						<span class="site-footer__label"><?php esc_html_e( 'Explore', 'thinking-canines' ); ?></span>
						<?php
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'site-footer__menu',
							'depth'          => 1,
						) );
						?>
					</nav>
				<?php endif; ?>

				<?php if ( $tc_email || $tc_whatsapp || tc_has_social_links() ) : ?>
					<div class="site-footer__col">
						<span class="site-footer__label"><?php esc_html_e( 'Contact', 'thinking-canines' ); ?></span>
						<?php if ( $tc_email ) : ?>
							<a href="mailto:<?php echo esc_attr( antispambot( $tc_email ) ); ?>" class="link-gold"><?php echo esc_html( antispambot( $tc_email ) ); ?></a>
						<?php endif; ?>
						<?php if ( $tc_whatsapp ) : ?>
							<a href="<?php echo esc_url( tc_whatsapp_url() ); ?>" class="link-gold">
								<?php
								/* translators: %s: WhatsApp phone number. */
								echo esc_html( sprintf( __( 'WhatsApp: %s', 'thinking-canines' ), $tc_whatsapp ) );
								?>
							</a>
						<?php endif; ?>
						<?php if ( tc_has_social_links() ) : ?>
							<div class="social-links site-footer__social"><?php tc_social_links( 'social-link--sm', 18 ); ?></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $tc_accreditations ) : ?>
				<div class="accreditations">
					<?php if ( tc_option( 'accreditations_title' ) ) : ?>
						<span class="site-footer__label"><?php echo esc_html( tc_option( 'accreditations_title' ) ); ?></span>
					<?php endif; ?>
					<div class="accreditations__grid">
						<?php foreach ( $tc_accreditations as $tc_logo ) : ?>
							<?php
							if ( empty( $tc_logo['logo'] ) ) {
								continue;
							}
							$tc_img = wp_get_attachment_image( $tc_logo['logo'], 'medium', false, array( 'class' => 'accreditation__img', 'loading' => 'lazy' ) );
							?>
							<?php if ( ! empty( $tc_logo['url'] ) ) : ?>
								<a href="<?php echo esc_url( $tc_logo['url'] ); ?>" class="accreditation" target="_blank" rel="noopener"><?php echo $tc_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<?php else : ?>
								<div class="accreditation"><?php echo $tc_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="site-footer__bottom">
				<span>
					<?php
					/* translators: 1: year, 2: site name. */
					echo esc_html( sprintf( __( '© %1$s %2$s. All rights reserved.', 'thinking-canines' ), wp_date( 'Y' ), get_bloginfo( 'name' ) ) );
					?>
				</span>
				<?php
				if ( has_nav_menu( 'legal' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'legal',
						'container'      => false,
						'menu_class'     => 'site-footer__legal',
						'depth'          => 1,
					) );
				}
				?>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
