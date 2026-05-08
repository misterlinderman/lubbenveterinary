<?php
/**
 * Inline icons from assets/images/icons/ (docs/02-design-system.md).
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Allowed icon slugs → file basename (without .svg).
 *
 * @return string[]
 */
function lubben_vet_icon_slugs() {
	return array( 'paw', 'tractor', 'stethoscope', 'alert-triangle' );
}

/**
 * Map shorthand keys used in templates to file slugs.
 *
 * @param string $key Short key (e.g. alert).
 * @return string
 */
function lubben_vet_icon_normalize_slug( $key ) {
	$map = array(
		'alert' => 'alert-triangle',
	);
	if ( isset( $map[ $key ] ) ) {
		return $map[ $key ];
	}
	return $key;
}

/**
 * Load and cache SVG markup from the theme (trusted local files only).
 *
 * @param string $key Icon key or slug.
 * @return string Raw SVG markup, or empty string.
 */
function lubben_vet_icon( $key ) {
	static $cache = array();

	$slug = lubben_vet_icon_normalize_slug( $key );
	$slug = sanitize_title( $slug );
	if ( '' === $slug || ! in_array( $slug, lubben_vet_icon_slugs(), true ) ) {
		return '';
	}

	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}

	$path = get_theme_file_path( 'assets/images/icons/' . $slug . '.svg' );
	if ( ! is_readable( $path ) ) {
		$cache[ $slug ] = '';
		return '';
	}

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme file.
	$contents = file_get_contents( $path );
	if ( ! is_string( $contents ) ) {
		$cache[ $slug ] = '';
		return '';
	}

	$cache[ $slug ] = $contents;
	return $cache[ $slug ];
}
