<?php
/**
 * The header, including the full-screen menu.
 *
 * @package Thinking_Canines
 */

$tc_logo_url  = TC_THEME_URI . '/assets/images/thinking-canines-logo.svg';
$tc_home_link = sprintf(
	/* translators: %s: site name. */
	__( '%s – home', 'thinking-canines' ),
	get_bloginfo( 'name' )
);
$tc_logo_alt  = sprintf(
	/* translators: %s: site name. */
	__( '%s logo', 'thinking-canines' ),
	get_bloginfo( 'name' )
);
$tc_book      = tc_option( 'header_button' );
$tc_email     = tc_option( 'email' );
$tc_whatsapp  = tc_option( 'whatsapp_number' );
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'thinking-canines' ); ?></a>

	<header class="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php echo esc_attr( $tc_home_link ); ?>" rel="home">
			<img src="<?php echo esc_url( $tc_logo_url ); ?>" alt="<?php echo esc_attr( $tc_logo_alt ); ?>" class="site-logo__img" width="112" height="112">
		</a>
		<div class="site-header__actions">
			<?php tc_button( $tc_book, 'outline', array( 'class' => 'site-header__book' ) ); ?>
			<button type="button" class="menu-toggle" aria-expanded="false" aria-controls="site-menu" data-action="openMenu">
				<?php esc_html_e( 'Menu', 'thinking-canines' ); ?>
				<span class="menu-toggle__icon" aria-hidden="true">
					<span class="menu-toggle__bar"></span>
					<span class="menu-toggle__bar"></span>
					<span class="menu-toggle__bar menu-toggle__bar--short"></span>
				</span>
			</button>
		</div>
	</header>

	<div id="site-menu" class="site-menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'thinking-canines' ); ?>" hidden>
		<?php echo tc_icon( 'paw', 0, array( 'class' => 'site-menu__watermark' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<div class="site-menu__top">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-menu__logo" aria-label="<?php echo esc_attr( $tc_home_link ); ?>" data-action="leaveMenu">
				<img src="<?php echo esc_url( $tc_logo_url ); ?>" alt="<?php echo esc_attr( $tc_logo_alt ); ?>" class="site-logo__img" width="112" height="112">
			</a>
			<button type="button" class="menu-close" data-action="closeMenu">
				<?php esc_html_e( 'Close', 'thinking-canines' ); ?>
				<span class="menu-close__icon" aria-hidden="true"><?php echo tc_icon( 'close', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</button>
		</div>

		<div class="site-menu__body">
			<nav class="site-menu__nav" aria-label="<?php esc_attr_e( 'Main', 'thinking-canines' ); ?>">
				<?php tc_primary_menu(); ?>
			</nav>

			<aside class="site-menu__aside">
				<?php if ( tc_option( 'tagline' ) ) : ?>
					<p class="site-menu__tagline"><?php echo esc_html( tc_option( 'tagline' ) ); ?></p>
				<?php endif; ?>

				<?php if ( $tc_email || $tc_whatsapp ) : ?>
					<div class="site-menu__group">
						<span class="site-menu__label"><?php esc_html_e( 'Get in touch', 'thinking-canines' ); ?></span>
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
					</div>
				<?php endif; ?>

				<?php if ( tc_has_social_links() ) : ?>
					<div class="site-menu__group site-menu__group--social">
						<span class="site-menu__label"><?php esc_html_e( 'Follow', 'thinking-canines' ); ?></span>
						<div class="social-links"><?php tc_social_links(); ?></div>
					</div>
				<?php endif; ?>
			</aside>
		</div>
	</div>
