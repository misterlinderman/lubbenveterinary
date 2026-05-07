<?php
/**
 * Lubben Vet — functions.php
 *
 * This file is a manifest. It does not define logic; it requires inc/ files
 * that do. Keeping functions.php empty of logic makes the codebase greppable
 * and survives child-theme overrides cleanly.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'LUBBEN_VET_VERSION' ) ) {
	define( 'LUBBEN_VET_VERSION', '0.1.0' );
}

if ( ! defined( 'LUBBEN_VET_DIR' ) ) {
	define( 'LUBBEN_VET_DIR', get_template_directory() );
}

if ( ! defined( 'LUBBEN_VET_URI' ) ) {
	define( 'LUBBEN_VET_URI', get_template_directory_uri() );
}

/**
 * Required theme files. Order matters: setup → enqueue → menus → helpers
 * → redirects → seo → security → gravity-forms-helpers.
 *
 * Files that don't yet exist are silently skipped — this keeps the theme
 * activatable while the build is still in progress (see prompt 04 of the
 * build plan).
 */
$lubben_vet_includes = array(
	'inc/setup.php',
	'inc/enqueue.php',
	'inc/nav-menus.php',
	'inc/helpers.php',
	'inc/redirects.php',
	'inc/seo.php',
	'inc/security.php',
	'inc/customizer.php',
	'inc/gravity-forms-helpers.php',
);

foreach ( $lubben_vet_includes as $lubben_vet_include ) {
	$lubben_vet_path = LUBBEN_VET_DIR . '/' . $lubben_vet_include;
	if ( file_exists( $lubben_vet_path ) ) {
		require_once $lubben_vet_path;
	}
}

unset( $lubben_vet_includes, $lubben_vet_include, $lubben_vet_path );
