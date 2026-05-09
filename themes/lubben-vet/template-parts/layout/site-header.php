<?php
/**
 * Site header — banner, nav, CTAs (docs/01-information-architecture.md).
 *
 * Mobile nav drawer must stay *outside* <header>: `backdrop-filter` on `.site-header`
 * creates a fixed-position containing block and would shrink the drawer to header height.
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

$appointment_url = home_url( '/contact/#appointment-form' );
?>
<div class="site-nav__backdrop" id="site-nav-backdrop" hidden></div>
<header class="site-header" role="banner">
	<div class="site-header__inner">
		<div class="site-header__brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( lubben_vet_logo_url( 'on-primary' ) ); ?>" alt="" width="300" height="133" class="site-header__logo" decoding="async" />
				<span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span>
			</a>
		</div>

		<nav class="site-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'lubben-vet' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'depth'          => 1,
					'fallback_cb'    => 'lubben_vet_primary_menu_fallback',
				)
			);
			?>
		</nav>

		<div class="site-header__actions">
			<a class="site-header__tel" href="<?php echo esc_url( get_lubben_phone_tel() ); ?>"><?php echo esc_html( get_lubben_phone() ); ?></a>
			<a class="btn btn--primary site-header__cta" href="<?php echo esc_url( $appointment_url ); ?>"><?php esc_html_e( 'Request an Appointment', 'lubben-vet' ); ?></a>
			<button type="button" class="site-header__menu-toggle" id="site-nav-toggle" aria-expanded="false" aria-controls="primary-menu-panel">
				<span class="site-header__menu-toggle-icon" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'lubben-vet' ); ?></span>
			</button>
		</div>
	</div>
</header>

<div class="site-nav__panel" id="primary-menu-panel" hidden role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'lubben-vet' ); ?>">
	<div class="site-nav__panel-toolbar">
		<button type="button" id="site-nav-close" class="site-nav__close" aria-label="<?php esc_attr_e( 'Close menu', 'lubben-vet' ); ?>">
			<span class="site-nav__close-x" aria-hidden="true"></span>
		</button>
	</div>
	<div class="site-nav__panel-body">
		<a class="btn btn--primary site-nav__panel-cta" href="<?php echo esc_url( $appointment_url ); ?>"><?php esc_html_e( 'Request an Appointment', 'lubben-vet' ); ?></a>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'site-nav__mobile-list',
				'depth'          => 1,
				'fallback_cb'    => 'lubben_vet_primary_menu_fallback',
			)
		);
		?>
	</div>
</div>
