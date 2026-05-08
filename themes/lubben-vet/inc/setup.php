<?php
/**
 * Theme setup.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme supports and baseline settings.
 */
function lubben_vet_setup() {
	load_theme_textdomain( 'lubben-vet', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	add_editor_style( 'assets/css/editor.css' );

	add_image_size( 'lubben-hero', 1920, 900, true );
	add_image_size( 'lubben-card', 800, 600, true );
}
add_action( 'after_setup_theme', 'lubben_vet_setup' );

/**
 * Pattern category for file-based patterns.
 */
function lubben_vet_register_block_pattern_category() {
	register_block_pattern_category(
		'lubben-vet',
		array(
			'label' => __( 'Lubben Vet', 'lubben-vet' ),
		)
	);
}
add_action( 'init', 'lubben_vet_register_block_pattern_category' );

/**
 * Content width for embedded media.
 *
 * @global int $content_width
 */
function lubben_vet_content_width() {
	$GLOBALS['content_width'] = 1140;
}
add_action( 'after_setup_theme', 'lubben_vet_content_width', 0 );
