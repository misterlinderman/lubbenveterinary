<?php
/**
 * Lubben Vet — functions.php (manifest).
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'LUBBEN_VET_VERSION' ) ) {
	define( 'LUBBEN_VET_VERSION', '0.1.5' );
}

if ( ! defined( 'LUBBEN_VET_DIR' ) ) {
	define( 'LUBBEN_VET_DIR', get_template_directory() );
}

if ( ! defined( 'LUBBEN_VET_URI' ) ) {
	define( 'LUBBEN_VET_URI', get_template_directory_uri() );
}

/** Temporary client review: alternate logo sets + fixed toggle (disable after sign-off). */
if ( ! defined( 'LUBBEN_VET_CLIENT_LOGO_PREVIEW' ) ) {
	define( 'LUBBEN_VET_CLIENT_LOGO_PREVIEW', true );
}

$lubben_vet_includes = array(
	'inc/setup.php',
	'inc/enqueue.php',
	'inc/nav-menus.php',
	'inc/helpers.php',
	'inc/icons.php',
	'inc/images.php',
	'inc/customizer.php',
	'inc/redirects.php',
	'inc/seo.php',
	'inc/gravity-forms-helpers.php',
);

foreach ( $lubben_vet_includes as $lubben_vet_include ) {
	$lubben_vet_path = LUBBEN_VET_DIR . '/' . $lubben_vet_include;
	if ( file_exists( $lubben_vet_path ) ) {
		require_once $lubben_vet_path;
	}
}

unset( $lubben_vet_includes, $lubben_vet_include, $lubben_vet_path );
