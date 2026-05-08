<?php
/**
 * Legacy URL → new URL redirects (301).
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Map legacy Sitebuilder paths to new destinations (paths may include fragments).
 *
 * @return array<string, string>
 */
function lubben_vet_legacy_redirect_map() {
	return array(
		'welcome.html'     => '/',
		'index.html'       => '/',
		'ourpractice.html' => '/about/#practice',
		'drlubben.html'    => '/about/#dr-lubben',
		'ourstaff.html'    => '/about/#our-staff',
		'page1.html'       => '/contact/#hours',
		'contact.html'     => '/contact/',
	);
}

/**
 * Normalize a legacy filename for comparison.
 *
 * @param string $path Request path basename.
 * @return string
 */
function lubben_vet_normalize_legacy_filename( $path ) {
	return strtolower( trim( (string) $path ) );
}

/**
 * Redirect legacy `.html` URLs before WordPress returns 404.
 */
function lubben_vet_legacy_redirects() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	if ( '' === $request_uri ) {
		return;
	}

	$path = wp_parse_url( $request_uri, PHP_URL_PATH );
	if ( ! is_string( $path ) ) {
		return;
	}

	$basename = lubben_vet_normalize_legacy_filename( basename( $path ) );
	if ( '' === $basename || ! str_ends_with( $basename, '.html' ) ) {
		return;
	}

	$map = lubben_vet_legacy_redirect_map();
	if ( ! isset( $map[ $basename ] ) ) {
		return;
	}

	$target = $map[ $basename ];

	if ( '/' === $target ) {
		$url = home_url( '/' );
	} else {
		$frag  = '';
		$route = $target;
		if ( str_contains( $target, '#' ) ) {
			$parts = explode( '#', $target, 2 );
			$route = $parts[0];
			$frag  = isset( $parts[1] ) ? $parts[1] : '';
		}

		$route = trim( $route, '/' );
		$url   = trailingslashit( home_url( '/' . $route ) );
		if ( '' !== $frag ) {
			$url .= '#' . $frag;
		}
	}

	wp_safe_redirect( $url, 301 );
	exit;
}
add_action( 'template_redirect', 'lubben_vet_legacy_redirects', 1 );
