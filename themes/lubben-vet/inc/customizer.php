<?php
/**
 * Customizer settings.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Customizer controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function lubben_vet_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'lubben_vet_theme',
		array(
			'title'       => __( 'Lubben Vet', 'lubben-vet' ),
			'description' => __( 'Theme options for the Lubben Vet site.', 'lubben-vet' ),
			'priority'    => 30,
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_hero_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'lubben_vet_hero_image',
			array(
				'label'     => __( 'Homepage hero image', 'lubben-vet' ),
				'section'   => 'lubben_vet_theme',
				'mime_type' => 'image',
			)
		)
	);
}
add_action( 'customize_register', 'lubben_vet_customize_register' );
