<?php
/**
 * Customizer — site-wide and template content editable from Appearance → Customize.
 *
 * Empty fields fall back to the theme’s built-in defaults.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitize checkbox / on-off for marquee.
 *
 * @param mixed $value Submitted value.
 * @return bool
 */
function lubben_vet_sanitize_bool_theme_mod( $value ) {
	return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
}

/**
 * Register Customizer sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function lubben_vet_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'lubben_vet_content',
		array(
			'title'       => __( 'Lubben Vet content', 'lubben-vet' ),
			'description' => __( 'Edit homepage sections, announcements, About/Contact templates, and key images.', 'lubben-vet' ),
			'priority'    => 30,
		)
	);

	// --- Homepage: announcement (“marquee”) — front page only. ---
	$wp_customize->add_section(
		'lubben_vet_marquee',
		array(
			'title'       => __( 'Home — Announcement banner', 'lubben-vet' ),
			'description' => __( 'Thin banner shown above the header on the homepage only.', 'lubben-vet' ),
			'panel'       => 'lubben_vet_content',
			'priority'    => 10,
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_marquee_enabled',
		array(
			'default'           => false,
			'sanitize_callback' => 'lubben_vet_sanitize_bool_theme_mod',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_marquee_enabled',
		array(
			'label'   => __( 'Show announcement banner on homepage', 'lubben-vet' ),
			'section' => 'lubben_vet_marquee',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_marquee_text',
		array(
			'default'              => '',
			'sanitize_callback'    => 'sanitize_text_field',
			'sanitize_js_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_marquee_text',
		array(
			'label'   => __( 'Banner text', 'lubben-vet' ),
			'section' => 'lubben_vet_marquee',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_marquee_link',
		array(
			'default'              => '',
			'sanitize_callback'    => 'esc_url_raw',
			'sanitize_js_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_marquee_link',
		array(
			'label'   => __( 'Optional link URL (whole banner becomes a link)', 'lubben-vet' ),
			'section' => 'lubben_vet_marquee',
			'type'    => 'url',
		)
	);

	// --- Home hero (setting ID `lubben_vet_hero_image` unchanged for backward compatibility). ---
	$wp_customize->add_section(
		'lubben_vet_home_hero',
		array(
			'title' => __( 'Home — Hero', 'lubben-vet' ),
			'panel' => 'lubben_vet_content',
			'priority' => 20,
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
				'label'     => __( 'Hero image', 'lubben-vet' ),
				'section'   => 'lubben_vet_home_hero',
				'mime_type' => 'image',
			)
		)
	);

	foreach (
		array(
			'lubben_vet_hero_title'           => __( 'Heading', 'lubben-vet' ),
			'lubben_vet_hero_subtitle'        => __( 'Subheading', 'lubben-vet' ),
			'lubben_vet_hero_primary_label'   => __( 'Primary button label', 'lubben-vet' ),
			'lubben_vet_hero_secondary_label' => __( 'Secondary button label', 'lubben-vet' ),
		) as $sid => $clabel
	) {
		$is_area = 'lubben_vet_hero_subtitle' === $sid;
		$wp_customize->add_setting(
			$sid,
			array(
				'default'              => '',
				'sanitize_callback'    => $is_area ? 'sanitize_textarea_field' : 'sanitize_text_field',
				'sanitize_js_callback' => $is_area ? 'sanitize_textarea_field' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$sid,
			array(
				'label'   => $clabel,
				'section' => 'lubben_vet_home_hero',
				'type'    => $is_area ? 'textarea' : 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'lubben_vet_hero_primary_url',
		array(
			'default'              => '',
			'sanitize_callback'    => 'esc_url_raw',
			'sanitize_js_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_hero_primary_url',
		array(
			'label'   => __( 'Primary button URL', 'lubben-vet' ),
			'section' => 'lubben_vet_home_hero',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_hero_secondary_url',
		array(
			'default'              => '',
			'sanitize_callback'    => 'esc_url_raw',
			'sanitize_js_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_hero_secondary_url',
		array(
			'label'       => __( 'Secondary button URL (leave empty to use the office phone tel: link)', 'lubben-vet' ),
			'description' => __( 'When empty, the second button stays a “call” action using the theme phone number.', 'lubben-vet' ),
			'section'     => 'lubben_vet_home_hero',
			'type'        => 'url',
		)
	);

	// --- About teaser ---
	$wp_customize->add_section(
		'lubben_vet_home_about_teaser',
		array(
			'title' => __( 'Home — About teaser', 'lubben-vet' ),
			'panel' => 'lubben_vet_content',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_about_teaser_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'lubben_vet_about_teaser_image',
			array(
				'label'     => __( 'Side image', 'lubben-vet' ),
				'section'   => 'lubben_vet_home_about_teaser',
				'mime_type' => 'image',
			)
		)
	);

	foreach (
		array(
			'lubben_vet_about_teaser_heading'   => __( 'Section heading', 'lubben-vet' ),
			'lubben_vet_about_teaser_p1'        => __( 'First paragraph', 'lubben-vet' ),
			'lubben_vet_about_teaser_p2'        => __( 'Second paragraph', 'lubben-vet' ),
			'lubben_vet_about_teaser_cta_label' => __( 'Button label', 'lubben-vet' ),
		) as $sid => $clabel
	) {
		$is_para = in_array( $sid, array( 'lubben_vet_about_teaser_p1', 'lubben_vet_about_teaser_p2' ), true );
		$wp_customize->add_setting(
			$sid,
			array(
				'default'              => '',
				'sanitize_callback'    => $is_para ? 'sanitize_textarea_field' : 'sanitize_text_field',
				'sanitize_js_callback' => $is_para ? 'sanitize_textarea_field' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$sid,
			array(
				'label'   => $clabel,
				'section' => 'lubben_vet_home_about_teaser',
				'type'    => $is_para ? 'textarea' : 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'lubben_vet_about_teaser_cta_url',
		array(
			'default'              => '',
			'sanitize_callback'    => 'esc_url_raw',
			'sanitize_js_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_about_teaser_cta_url',
		array(
			'label'   => __( 'Button URL', 'lubben-vet' ),
			'section' => 'lubben_vet_home_about_teaser',
			'type'    => 'url',
		)
	);

	// --- Services grid ---
	$wp_customize->add_section(
		'lubben_vet_home_services',
		array(
			'title' => __( 'Home — Services grid', 'lubben-vet' ),
			'panel' => 'lubben_vet_content',
			'priority' => 40,
		)
	);

	foreach (
		array(
			'lubben_vet_services_heading' => __( 'Section heading', 'lubben-vet' ),
			'lubben_vet_services_intro'  => __( 'Intro paragraph below heading', 'lubben-vet' ),
		) as $sid => $clabel
	) {
		$is_intro = 'lubben_vet_services_intro' === $sid;
		$wp_customize->add_setting(
			$sid,
			array(
				'default'              => '',
				'sanitize_callback'    => $is_intro ? 'sanitize_textarea_field' : 'sanitize_text_field',
				'sanitize_js_callback' => $is_intro ? 'sanitize_textarea_field' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$sid,
			array(
				'label'   => $clabel,
				'section' => 'lubben_vet_home_services',
				'type'    => $is_intro ? 'textarea' : 'text',
			)
		);
	}

	for ( $n = 1; $n <= 4; $n++ ) {
		$wp_customize->add_setting(
			"lubben_vet_service_{$n}_title",
			array(
				'default'              => '',
				'sanitize_callback'    => 'sanitize_text_field',
				'sanitize_js_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"lubben_vet_service_{$n}_title",
			array(
				/* translators: %d service card slot 1–4 */
				'label'   => sprintf( __( 'Service card %d — title', 'lubben-vet' ), $n ),
				'section' => 'lubben_vet_home_services',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"lubben_vet_service_{$n}_text",
			array(
				'default'              => '',
				'sanitize_callback'    => 'sanitize_textarea_field',
				'sanitize_js_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_control(
			"lubben_vet_service_{$n}_text",
			array(
				/* translators: %d service card slot 1–4 */
				'label'   => sprintf( __( 'Service card %d — description', 'lubben-vet' ), $n ),
				'section' => 'lubben_vet_home_services',
				'type'    => 'textarea',
			)
		);
	}

	// --- Pharmacy ---
	$wp_customize->add_section(
		'lubben_vet_home_pharmacy',
		array(
			'title' => __( 'Home — Online pharmacy band', 'lubben-vet' ),
			'panel' => 'lubben_vet_content',
			'priority' => 50,
		)
	);

	foreach (
		array(
			'lubben_vet_pharmacy_title'   => __( 'Heading', 'lubben-vet' ),
			'lubben_vet_pharmacy_body'    => __( 'Body text', 'lubben-vet' ),
			'lubben_vet_pharmacy_button'  => __( 'Button label', 'lubben-vet' ),
		) as $sid => $clabel
	) {
		$is_body = 'lubben_vet_pharmacy_body' === $sid;
		$wp_customize->add_setting(
			$sid,
			array(
				'default'              => '',
				'sanitize_callback'    => $is_body ? 'sanitize_textarea_field' : 'sanitize_text_field',
				'sanitize_js_callback' => $is_body ? 'sanitize_textarea_field' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$sid,
			array(
				'label'   => $clabel,
				'section' => 'lubben_vet_home_pharmacy',
				'type'    => $is_body ? 'textarea' : 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'lubben_vet_pharmacy_url',
		array(
			'default'              => '',
			'sanitize_callback'    => 'esc_url_raw',
			'sanitize_js_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_pharmacy_url',
		array(
			'label'   => __( 'Pharmacy URL', 'lubben-vet' ),
			'section' => 'lubben_vet_home_pharmacy',
			'type'    => 'url',
		)
	);

	// --- Visit us (home section heading only) ---
	$wp_customize->add_section(
		'lubben_vet_home_visit',
		array(
			'title'       => __( 'Home — Visit us', 'lubben-vet' ),
			'description' => __( 'Address, hours map, and after-hours note still come from the theme contact data.', 'lubben-vet' ),
			'panel'       => 'lubben_vet_content',
			'priority'    => 60,
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_visit_heading',
		array(
			'default'              => '',
			'sanitize_callback'    => 'sanitize_text_field',
			'sanitize_js_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_visit_heading',
		array(
			'label'   => __( 'Section heading', 'lubben-vet' ),
			'section' => 'lubben_vet_home_visit',
			'type'    => 'text',
		)
	);

	// --- About page template ---
	$wp_customize->add_section(
		'lubben_vet_template_about',
		array(
			'title'       => __( 'About page template', 'lubben-vet' ),
			'description' => __( 'For the About page assigned the “About — Lubben Vet” template. Page title still comes from the editor.', 'lubben-vet' ),
			'panel'       => 'lubben_vet_content',
			'priority'    => 70,
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_about_page_tagline',
		array(
			'default'              => '',
			'sanitize_callback'    => 'sanitize_textarea_field',
			'sanitize_js_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_about_page_tagline',
		array(
			'label'   => __( 'Intro tagline below title', 'lubben-vet' ),
			'section' => 'lubben_vet_template_about',
			'type'    => 'textarea',
		)
	);

	foreach (
		array(
			'lubben_vet_about_section_practice_title' => __( '“Our Practice” section heading', 'lubben-vet' ),
			'lubben_vet_about_section_dr_title'       => __( '“Dr. Lubben” section heading', 'lubben-vet' ),
			'lubben_vet_about_section_staff_title'    => __( '“Our Staff” section heading', 'lubben-vet' ),
			'lubben_vet_about_bottom_title'           => __( 'Bottom call-to-action heading', 'lubben-vet' ),
			'lubben_vet_about_bottom_cta_label'       => __( 'Bottom button label', 'lubben-vet' ),
		) as $sid => $clabel
	) {
		$wp_customize->add_setting(
			$sid,
			array(
				'default'              => '',
				'sanitize_callback'    => 'sanitize_text_field',
				'sanitize_js_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$sid,
			array(
				'label'   => $clabel,
				'section' => 'lubben_vet_template_about',
				'type'    => 'text',
			)
		);
	}

	foreach (
		array(
			'lubben_vet_about_section_practice_p1' => __( 'Our Practice — first paragraph', 'lubben-vet' ),
			'lubben_vet_about_section_practice_p2' => __( 'Our Practice — second paragraph', 'lubben-vet' ),
			'lubben_vet_about_section_practice_p3' => __( 'Our Practice — third paragraph', 'lubben-vet' ),
			'lubben_vet_about_section_dr_p1'       => __( 'Dr. Lubben — first paragraph', 'lubben-vet' ),
			'lubben_vet_about_section_dr_p2'       => __( 'Dr. Lubben — second paragraph', 'lubben-vet' ),
		) as $sid => $clabel
	) {
		$wp_customize->add_setting(
			$sid,
			array(
				'default'              => '',
				'sanitize_callback'    => 'sanitize_textarea_field',
				'sanitize_js_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_control(
			$sid,
			array(
				'label'   => $clabel,
				'section' => 'lubben_vet_template_about',
				'type'    => 'textarea',
			)
		);
	}

	$wp_customize->add_setting(
		'lubben_vet_about_pullquote',
		array(
			'default'              => '',
			'sanitize_callback'    => 'sanitize_textarea_field',
			'sanitize_js_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_about_pullquote',
		array(
			'label'   => __( 'Pullquote under Dr. Lubben section', 'lubben-vet' ),
			'section' => 'lubben_vet_template_about',
			'type'    => 'textarea',
		)
	);

	// --- Contact page template ---
	$wp_customize->add_section(
		'lubben_vet_template_contact',
		array(
			'title' => __( 'Contact page template', 'lubben-vet' ),
			'panel' => 'lubben_vet_content',
			'priority' => 80,
		)
	);

	$wp_customize->add_setting(
		'lubben_vet_contact_page_tagline',
		array(
			'default'              => '',
			'sanitize_callback'    => 'sanitize_textarea_field',
			'sanitize_js_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'lubben_vet_contact_page_tagline',
		array(
			'label'   => __( 'Intro tagline below title', 'lubben-vet' ),
			'section' => 'lubben_vet_template_contact',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'lubben_vet_customize_register' );
