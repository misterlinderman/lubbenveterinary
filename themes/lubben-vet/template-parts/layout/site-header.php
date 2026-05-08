<?php
/**
 * Site header — banner, nav, CTAs (docs/01-information-architecture.md).
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

$appointment_url = home_url( '/contact/#appointment-form' );
$pharmacy_url    = 'https://lubbenveterinary.myvetstoreonline.pharmacy';
?>
<div class="site-nav__backdrop" id="site-nav-backdrop" hidden></div>
<header class="site-header" role="banner">
	<div class="site-header__inner">
		<div class="site-header__brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
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

	<div class="site-nav__panel" id="primary-menu-panel" hidden>
		<a class="btn btn--primary" href="<?php echo esc_url( $appointment_url ); ?>"><?php esc_html_e( 'Request an Appointment', 'lubben-vet' ); ?></a>
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
		<p class="site-nav__mobile-meta">
			<a href="<?php echo esc_url( $pharmacy_url ); ?>" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'Online Pharmacy', 'lubben-vet' ); ?></a>
		</p>
	</div>
</header>
