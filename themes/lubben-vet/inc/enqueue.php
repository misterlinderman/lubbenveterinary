<?php
/**
 * Asset enqueue.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Front-end scripts and styles.
 */
function lubben_vet_enqueue_assets() {
	wp_enqueue_style(
		'lubben-vet-theme',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		LUBBEN_VET_VERSION
	);

	$nav_path = get_theme_file_path( 'assets/js/nav.js' );
	if ( file_exists( $nav_path ) ) {
		wp_enqueue_script(
			'lubben-vet-nav',
			get_theme_file_uri( 'assets/js/nav.js' ),
			array(),
			LUBBEN_VET_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'lubben_vet_enqueue_assets' );

/**
 * Block editor iframe — keeps editor CSS in sync when iterating.
 */
function lubben_vet_enqueue_block_editor_assets() {
	wp_enqueue_style(
		'lubben-vet-editor',
		get_theme_file_uri( 'assets/css/editor.css' ),
		array(),
		LUBBEN_VET_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'lubben_vet_enqueue_block_editor_assets' );
