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
 * Whether rendered nav markup already links to the pharmacy store.
 *
 * @param string $items Nav HTML.
 * @param string $url   Pharmacy URL.
 * @return bool
 */
function lubben_vet_nav_items_contain_pharmacy_url( $items, $url ) {
	$base = untrailingslashit( $url );
	if ( false !== strpos( $items, esc_url( $url ) ) || false !== strpos( $items, esc_url( $base ) ) ) {
		return true;
	}

	return false !== strpos( $items, 'myvetstoreonline.pharmacy' );
}

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
		array(
			'label' => __( 'Shop Pharmacy', 'lubben-vet' ),
			'url'   => get_lubben_pharmacy_url(),
			'new'   => true,
		),
	);

	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $items as $item ) {
		$rel = ! empty( $item['new'] ) ? ' rel="noopener noreferrer" target="_blank"' : '';
		echo '<li class="menu-item"><a href="' . esc_url( $item['url'] ) . '"' . $rel . '>' . esc_html( $item['label'] ) . '</a></li>';
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
		array(
			'label' => __( 'Online Pharmacy', 'lubben-vet' ),
			'url'   => get_lubben_pharmacy_url(),
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

/**
 * Append Shop Pharmacy to the primary menu when it is not already present.
 *
 * @param string   $items Menu HTML.
 * @param stdClass $args  wp_nav_menu() args.
 * @return string
 */
function lubben_vet_append_shop_pharmacy_nav_item( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}

	$url = get_lubben_pharmacy_url();
	if ( lubben_vet_nav_items_contain_pharmacy_url( $items, $url ) ) {
		return $items;
	}

	$items .= sprintf(
		'<li class="menu-item menu-item-type-custom menu-item-pharmacy"><a href="%s" target="_blank" rel="noopener noreferrer">%s</a></li>',
		esc_url( $url ),
		esc_html__( 'Shop Pharmacy', 'lubben-vet' )
	);

	return $items;
}
add_filter( 'wp_nav_menu_items', 'lubben_vet_append_shop_pharmacy_nav_item', 10, 2 );

/**
 * Open pharmacy links in a new tab from any assigned menu.
 *
 * @param array    $atts  Link attributes.
 * @param WP_Post  $item  Menu item.
 * @param stdClass $args  wp_nav_menu() args.
 * @param int      $depth Menu depth.
 * @return array
 */
function lubben_vet_pharmacy_nav_link_attributes( $atts, $item, $args, $depth ) {
	unset( $args, $depth );

	if ( empty( $item->url ) ) {
		return $atts;
	}

	$base = untrailingslashit( get_lubben_pharmacy_url() );
	$url  = untrailingslashit( (string) $item->url );
	if ( $url === $base || str_starts_with( (string) $item->url, $base ) ) {
		$atts['target'] = '_blank';
		$atts['rel']    = 'noopener noreferrer';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'lubben_vet_pharmacy_nav_link_attributes', 10, 4 );
