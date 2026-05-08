<?php
/**
 * Registered navigation menus.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme menu locations.
 */
function lubben_vet_register_nav_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'lubben-vet' ),
			'footer'  => __( 'Footer menu', 'lubben-vet' ),
		)
	);
}
add_action( 'after_setup_theme', 'lubben_vet_register_nav_menus' );

/**
 * Fallback menu when no Primary menu is assigned yet.
 *
 * @return void
 */
function lubben_vet_primary_menu_fallback( $args = array() ) {
	$class = 'site-nav__list';
	if ( is_array( $args ) && ! empty( $args['menu_class'] ) ) {
		$class = $args['menu_class'];
	}

	$items = array(
		array(
			'label' => __( 'Home', 'lubben-vet' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'About', 'lubben-vet' ),
			'url'   => home_url( '/about/' ),
		),
		array(
			'label' => __( 'Contact', 'lubben-vet' ),
			'url'   => home_url( '/contact/' ),
		),
	);

	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $items as $item ) {
		echo '<li class="menu-item"><a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Fallback for footer menu.
 *
 * @return void
 */
function lubben_vet_footer_menu_fallback( $args = array() ) {
	$class = 'site-footer__links';
	if ( is_array( $args ) && ! empty( $args['menu_class'] ) ) {
		$class = $args['menu_class'];
	}
	$pharmacy = 'https://lubbenveterinary.myvetstoreonline.pharmacy';
	$items    = array(
		array(
			'label' => __( 'Home', 'lubben-vet' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'About', 'lubben-vet' ),
			'url'   => home_url( '/about/' ),
		),
		array(
			'label' => __( 'Contact', 'lubben-vet' ),
			'url'   => home_url( '/contact/' ),
		),
		array(
			'label' => __( 'Online Pharmacy', 'lubben-vet' ),
			'url'   => $pharmacy,
			'new'   => true,
		),
	);

	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $items as $item ) {
		$rel = ! empty( $item['new'] ) ? ' rel="noopener noreferrer" target="_blank"' : '';
		echo '<li><a href="' . esc_url( $item['url'] ) . '"' . $rel . '>' . esc_html( $item['label'] ) . '</a></li>';
	}
	echo '</ul>';
}
