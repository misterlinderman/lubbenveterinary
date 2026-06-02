<?php
/**
 * Per-page custom fields — editable on each page in Pages → Edit.
 *
 * Values save as post meta on the owning page. Empty meta falls back to
 * Appearance → Customize (theme_mod), then templates apply their built-in defaults.
 *
 * @package Lubben_Vet
 * @since   0.1.6
 */

defined( 'ABSPATH' ) || exit;

/**
 * Field groups keyed by context. Each field maps to a meta key identical to the
 * former Customizer setting ID for backward compatibility.
 *
 * @return array<string, array<string, mixed>>
 */
function lubben_vet_page_field_groups() {
	static $groups = null;

	if ( null !== $groups ) {
		return $groups;
	}

	$text     = 'text';
	$textarea = 'textarea';
	$url      = 'url';
	$checkbox = 'checkbox';
	$image    = 'image';

	$groups = array(
		'home' => array(
			'title'       => __( 'Homepage sections', 'lubben-vet' ),
			'description' => __( 'These fields control the homepage layout. They only apply when this page is set as the static front page (Settings → Reading).', 'lubben-vet' ),
			'sections'    => array(
				'branding' => array(
					'title'       => __( 'Site branding', 'lubben-vet' ),
					'description' => __( 'Header and footer logos on every page of the site.', 'lubben-vet' ),
					'fields'      => array(
						'lubben_vet_logo_wordmark_lockup' => array(
							'type'    => $checkbox,
							'label'   => __( 'Wordmark in nav bar, full lockup in footer', 'lubben-vet' ),
							'default' => true,
						),
					),
				),
				'marquee' => array(
					'title'  => __( 'Announcement banner', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_marquee_enabled' => array(
							'type'  => $checkbox,
							'label' => __( 'Show announcement banner', 'lubben-vet' ),
						),
						'lubben_vet_marquee_text'    => array(
							'type'  => $text,
							'label' => __( 'Banner text', 'lubben-vet' ),
						),
						'lubben_vet_marquee_link'    => array(
							'type'  => $url,
							'label' => __( 'Optional link URL', 'lubben-vet' ),
						),
					),
				),
				'hero'    => array(
					'title'  => __( 'Hero', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_hero_image'           => array(
							'type'  => $image,
							'label' => __( 'Hero image', 'lubben-vet' ),
						),
						'lubben_vet_hero_title'           => array(
							'type'  => $text,
							'label' => __( 'Heading', 'lubben-vet' ),
						),
						'lubben_vet_hero_subtitle'        => array(
							'type'  => $textarea,
							'label' => __( 'Subheading', 'lubben-vet' ),
						),
						'lubben_vet_hero_primary_label'   => array(
							'type'  => $text,
							'label' => __( 'Primary button label', 'lubben-vet' ),
						),
						'lubben_vet_hero_primary_url'     => array(
							'type'  => $url,
							'label' => __( 'Primary button URL', 'lubben-vet' ),
						),
						'lubben_vet_hero_secondary_label' => array(
							'type'  => $text,
							'label' => __( 'Secondary button label', 'lubben-vet' ),
						),
						'lubben_vet_hero_secondary_url'   => array(
							'type'  => $url,
							'label' => __( 'Secondary button URL (empty = phone link)', 'lubben-vet' ),
						),
					),
				),
				'about_teaser' => array(
					'title'  => __( 'About teaser', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_about_teaser_image'     => array(
							'type'  => $image,
							'label' => __( 'Side image', 'lubben-vet' ),
						),
						'lubben_vet_about_teaser_heading'   => array(
							'type'  => $text,
							'label' => __( 'Section heading', 'lubben-vet' ),
						),
						'lubben_vet_about_teaser_p1'        => array(
							'type'  => $textarea,
							'label' => __( 'First paragraph', 'lubben-vet' ),
						),
						'lubben_vet_about_teaser_p2'        => array(
							'type'  => $textarea,
							'label' => __( 'Second paragraph', 'lubben-vet' ),
						),
						'lubben_vet_about_teaser_cta_label' => array(
							'type'  => $text,
							'label' => __( 'Button label', 'lubben-vet' ),
						),
						'lubben_vet_about_teaser_cta_url'   => array(
							'type'  => $url,
							'label' => __( 'Button URL', 'lubben-vet' ),
						),
					),
				),
				'services' => array(
					'title'  => __( 'Services grid', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_services_heading' => array(
							'type'  => $text,
							'label' => __( 'Section heading', 'lubben-vet' ),
						),
						'lubben_vet_services_intro'   => array(
							'type'  => $textarea,
							'label' => __( 'Intro paragraph', 'lubben-vet' ),
						),
					),
				),
				'pharmacy' => array(
					'title'  => __( 'Online pharmacy band', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_pharmacy_title'  => array(
							'type'  => $text,
							'label' => __( 'Heading', 'lubben-vet' ),
						),
						'lubben_vet_pharmacy_body'   => array(
							'type'  => $textarea,
							'label' => __( 'Body text', 'lubben-vet' ),
						),
						'lubben_vet_pharmacy_button' => array(
							'type'  => $text,
							'label' => __( 'Button label', 'lubben-vet' ),
						),
						'lubben_vet_pharmacy_url'    => array(
							'type'  => $url,
							'label' => __( 'Pharmacy URL', 'lubben-vet' ),
						),
					),
				),
				'visit' => array(
					'title'  => __( 'Visit us', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_visit_heading' => array(
							'type'  => $text,
							'label' => __( 'Section heading', 'lubben-vet' ),
						),
					),
				),
			),
		),
		'about' => array(
			'title'       => __( 'About page sections', 'lubben-vet' ),
			'description' => __( 'Structured sections below the main editor content. Anchors (#practice, #dr-lubben, #our-staff) stay fixed in the theme.', 'lubben-vet' ),
			'sections'    => array(
				'about_main' => array(
					'title'  => __( 'Page intro & sections', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_about_page_tagline'           => array(
							'type'  => $textarea,
							'label' => __( 'Intro tagline below title', 'lubben-vet' ),
						),
						'lubben_vet_about_section_practice_title' => array(
							'type'  => $text,
							'label' => __( '“Our Practice” section heading', 'lubben-vet' ),
						),
						'lubben_vet_about_section_practice_p1'    => array(
							'type'  => $textarea,
							'label' => __( 'Our Practice — first paragraph', 'lubben-vet' ),
						),
						'lubben_vet_about_section_practice_p2'    => array(
							'type'  => $textarea,
							'label' => __( 'Our Practice — second paragraph', 'lubben-vet' ),
						),
						'lubben_vet_about_section_practice_p3'    => array(
							'type'  => $textarea,
							'label' => __( 'Our Practice — third paragraph', 'lubben-vet' ),
						),
						'lubben_vet_about_section_dr_title'       => array(
							'type'  => $text,
							'label' => __( '“Dr. Lubben” section heading', 'lubben-vet' ),
						),
						'lubben_vet_about_section_dr_p1'          => array(
							'type'  => $textarea,
							'label' => __( 'Dr. Lubben — first paragraph', 'lubben-vet' ),
						),
						'lubben_vet_about_section_dr_p2'          => array(
							'type'  => $textarea,
							'label' => __( 'Dr. Lubben — second paragraph', 'lubben-vet' ),
						),
						'lubben_vet_about_pullquote'              => array(
							'type'  => $textarea,
							'label' => __( 'Pullquote under Dr. Lubben section', 'lubben-vet' ),
						),
						'lubben_vet_about_section_staff_title'    => array(
							'type'  => $text,
							'label' => __( '“Our Staff” section heading', 'lubben-vet' ),
						),
						'lubben_vet_about_bottom_title'           => array(
							'type'  => $text,
							'label' => __( 'Bottom call-to-action heading', 'lubben-vet' ),
						),
						'lubben_vet_about_bottom_cta_label'       => array(
							'type'  => $text,
							'label' => __( 'Bottom button label', 'lubben-vet' ),
						),
					),
				),
				'staff' => array(
					'title'  => __( 'Our Staff', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_about_staff' => array(
							'type'        => 'repeater',
							'label'       => __( 'Staff members', 'lubben-vet' ),
							'add_label'   => __( 'Add staff member', 'lubben-vet' ),
							'item_label'  => __( 'Staff member', 'lubben-vet' ),
							'empty_label' => __( 'No staff members yet.', 'lubben-vet' ),
							'fields'      => array(
								'name'     => array(
									'type'  => $text,
									'label' => __( 'Name', 'lubben-vet' ),
								),
								'role'     => array(
									'type'  => $text,
									'label' => __( 'Job title', 'lubben-vet' ),
								),
								'bio'      => array(
									'type'  => $textarea,
									'label' => __( 'Bio', 'lubben-vet' ),
								),
								'photo_id' => array(
									'type'  => $image,
									'label' => __( 'Photo', 'lubben-vet' ),
								),
							),
						),
					),
				),
			),
		),
		'contact' => array(
			'title'       => __( 'Contact page options', 'lubben-vet' ),
			'description' => __( 'Hours, address, and map come from the theme contact data and appear consistently site-wide.', 'lubben-vet' ),
			'sections'    => array(
				'contact_main' => array(
					'title'  => __( 'Page intro', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_contact_page_tagline' => array(
							'type'  => $textarea,
							'label' => __( 'Intro tagline below title', 'lubben-vet' ),
						),
					),
				),
			),
		),
		'page' => array(
			'title'       => __( 'Page options', 'lubben-vet' ),
			'description' => __( 'Optional subtitle shown under the page title.', 'lubben-vet' ),
			'sections'    => array(
				'page_main' => array(
					'title'  => __( 'Header', 'lubben-vet' ),
					'fields' => array(
						'lubben_vet_page_tagline' => array(
							'type'  => $textarea,
							'label' => __( 'Tagline below title', 'lubben-vet' ),
						),
					),
				),
			),
		),
	);

	for ( $n = 1; $n <= 4; $n++ ) {
		$groups['home']['sections']['services']['fields'][ "lubben_vet_service_{$n}_title" ] = array(
			'type'  => $text,
			/* translators: %d service card slot 1–4 */
			'label' => sprintf( __( 'Service card %d — title', 'lubben-vet' ), $n ),
		);
		$groups['home']['sections']['services']['fields'][ "lubben_vet_service_{$n}_text" ] = array(
			'type'  => $textarea,
			/* translators: %d service card slot 1–4 */
			'label' => sprintf( __( 'Service card %d — description', 'lubben-vet' ), $n ),
		);
	}

	return $groups;
}

/**
 * Flat map of meta key → owning group slug.
 *
 * @return array<string, string>
 */
function lubben_vet_page_field_key_groups() {
	static $map = null;

	if ( null !== $map ) {
		return $map;
	}

	$map = array();
	foreach ( lubben_vet_page_field_groups() as $group_slug => $group ) {
		foreach ( $group['sections'] as $section ) {
			foreach ( $section['fields'] as $key => $field ) {
				$map[ $key ] = $group_slug;
			}
		}
	}

	return $map;
}

/**
 * Page ID that stores fields for a group.
 *
 * @param string $group_slug home|about|contact|page.
 * @return int
 */
function lubben_vet_page_fields_post_id( $group_slug ) {
	static $cache = array();

	if ( isset( $cache[ $group_slug ] ) ) {
		return $cache[ $group_slug ];
	}

	switch ( $group_slug ) {
		case 'home':
			$id = (int) get_option( 'page_on_front' );
			break;
		case 'about':
			$id = lubben_vet_get_page_id_by_template( 'page-templates/page-about.php' );
			break;
		case 'contact':
			$id = lubben_vet_get_page_id_by_template( 'page-templates/page-contact.php' );
			break;
		default:
			$id = 0;
			break;
	}

	$cache[ $group_slug ] = $id;

	return $id;
}

/**
 * First published page using a template.
 *
 * @param string $template Relative template path under theme root.
 * @return int
 */
function lubben_vet_get_page_id_by_template( $template ) {
	static $by_template = array();

	if ( isset( $by_template[ $template ] ) ) {
		return $by_template[ $template ];
	}

	$pages = get_posts(
		array(
			'post_type'              => 'page',
			'post_status'            => 'publish',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_key'               => '_wp_page_template',
			'meta_value'             => $template,
		)
	);

	$by_template[ $template ] = $pages ? (int) $pages[0] : 0;

	return $by_template[ $template ];
}

/**
 * Resolve which page stores a given field key.
 *
 * @param string $key Meta key.
 * @param int    $explicit_post_id Optional override (e.g. current page in admin).
 * @return int
 */
function lubben_vet_page_field_post_id_for_key( $key, $explicit_post_id = 0 ) {
	if ( $explicit_post_id > 0 ) {
		return $explicit_post_id;
	}

	$groups = lubben_vet_page_field_key_groups();
	if ( ! isset( $groups[ $key ] ) ) {
		return 0;
	}

	$group = $groups[ $key ];

	if ( 'page' === $group ) {
		if ( is_page() ) {
			return get_queried_object_id();
		}

		return 0;
	}

	return lubben_vet_page_fields_post_id( $group );
}

/**
 * Whether post meta has a stored (including empty-string) value.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @return bool
 */
function lubben_vet_page_meta_is_set( $post_id, $key ) {
	if ( $post_id <= 0 ) {
		return false;
	}

	return metadata_exists( 'post', $post_id, $key );
}

/**
 * Read a page field: post meta → theme_mod → empty string.
 *
 * @param string $key     Meta / theme_mod key.
 * @param int    $post_id Owning page; inferred from key when 0.
 * @return string
 */
function lubben_vet_get_page_field( $key, $post_id = 0 ) {
	$post_id = lubben_vet_page_field_post_id_for_key( $key, $post_id );

	if ( $post_id > 0 && lubben_vet_page_meta_is_set( $post_id, $key ) ) {
		$val = get_post_meta( $post_id, $key, true );
		return is_scalar( $val ) ? (string) $val : '';
	}

	$mod = get_theme_mod( $key, '' );
	if ( is_bool( $mod ) ) {
		return $mod ? '1' : '';
	}

	return is_scalar( $mod ) ? trim( (string) $mod ) : '';
}

/**
 * Integer page field (attachment IDs).
 *
 * @param string $key     Meta key.
 * @param int    $post_id Owning page.
 * @return int
 */
function lubben_vet_get_page_field_int( $key, $post_id = 0 ) {
	return absint( lubben_vet_get_page_field( $key, $post_id ) );
}

/**
 * Boolean page field (checkboxes).
 *
 * @param string $key     Meta key.
 * @param int    $post_id Owning page.
 * @return bool
 */
function lubben_vet_get_page_field_bool( $key, $post_id = 0 ) {
	$post_id = lubben_vet_page_field_post_id_for_key( $key, $post_id );

	if ( $post_id > 0 && lubben_vet_page_meta_is_set( $post_id, $key ) ) {
		return (bool) get_post_meta( $post_id, $key, true );
	}

	return (bool) get_theme_mod( $key, false );
}

/**
 * Decode stored repeater rows from post meta.
 *
 * @param string $key     Meta key.
 * @param int    $post_id Owning page.
 * @return array<int, array<string, mixed>>
 */
function lubben_vet_get_page_field_repeater( $key, $post_id = 0 ) {
	$post_id = lubben_vet_page_field_post_id_for_key( $key, $post_id );
	$field   = lubben_vet_page_field_definition( $key );

	if ( ! $field || 'repeater' !== $field['type'] || ! isset( $field['fields'] ) ) {
		return array();
	}

	if ( $post_id <= 0 || ! lubben_vet_page_meta_is_set( $post_id, $key ) ) {
		return array();
	}

	$raw = get_post_meta( $post_id, $key, true );
	if ( is_string( $raw ) && '' !== $raw ) {
		$decoded = json_decode( $raw, true );
		$raw     = is_array( $decoded ) ? $decoded : array();
	} elseif ( ! is_array( $raw ) ) {
		$raw = array();
	}

	return lubben_vet_sanitize_repeater_rows( $raw, $field['fields'] );
}

/**
 * Sanitize repeater rows against subfield definitions.
 *
 * @param mixed                             $rows      Raw rows.
 * @param array<string, array<string, string>> $subfields Subfield map.
 * @return array<int, array<string, mixed>>
 */
function lubben_vet_sanitize_repeater_rows( $rows, $subfields ) {
	if ( ! is_array( $rows ) ) {
		return array();
	}

	$sanitized = array();

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$clean = array();
		foreach ( $subfields as $subkey => $subfield ) {
			$sanitize          = lubben_vet_page_field_sanitize_callback( $subfield['type'] );
			$raw               = isset( $row[ $subkey ] ) ? $row[ $subkey ] : '';
			$clean[ $subkey ]  = $sanitize( $raw );
		}

		if ( '' === trim( (string) ( $clean['name'] ?? '' ) ) ) {
			continue;
		}

		$sanitized[] = $clean;
	}

	return $sanitized;
}

/**
 * Register post meta for REST and sanitization.
 */
function lubben_vet_register_page_field_meta() {
	foreach ( lubben_vet_page_field_key_groups() as $key => $group_slug ) {
		$field = lubben_vet_page_field_definition( $key );
		if ( ! $field ) {
			continue;
		}

		register_post_meta(
			'page',
			$key,
			array(
				'type'              => lubben_vet_page_field_meta_type( $field['type'] ),
				'single'            => true,
				'show_in_rest'      => true,
				'auth_callback'     => static function () {
					return current_user_can( 'edit_pages' );
				},
				'sanitize_callback' => lubben_vet_page_field_sanitize_callback( $field['type'] ),
			)
		);
	}
}
add_action( 'init', 'lubben_vet_register_page_field_meta' );

/**
 * Locate a field definition by meta key.
 *
 * @param string $key Meta key.
 * @return array<string, string>|null
 */
function lubben_vet_page_field_definition( $key ) {
	foreach ( lubben_vet_page_field_groups() as $group ) {
		foreach ( $group['sections'] as $section ) {
			if ( isset( $section['fields'][ $key ] ) ) {
				return $section['fields'][ $key ];
			}
		}
	}

	return null;
}

/**
 * REST/meta type for a field.
 *
 * @param string $type Field type.
 * @return string
 */
function lubben_vet_page_field_meta_type( $type ) {
	switch ( $type ) {
		case 'image':
			return 'integer';
		case 'checkbox':
			return 'boolean';
		case 'repeater':
			return 'string';
		default:
			return 'string';
	}
}

/**
 * Sanitizer for a field type.
 *
 * @param string $type Field type.
 * @return callable
 */
function lubben_vet_page_field_sanitize_callback( $type ) {
	switch ( $type ) {
		case 'textarea':
			return 'sanitize_textarea_field';
		case 'url':
			return 'esc_url_raw';
		case 'checkbox':
			return static function ( $value ) {
				return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			};
		case 'image':
			return 'absint';
		case 'repeater':
			return static function ( $value ) {
				return is_string( $value ) ? $value : '';
			};
		default:
			return 'sanitize_text_field';
	}
}

/**
 * Meta boxes on page edit screens.
 *
 * @param WP_Post $post Current post.
 */
function lubben_vet_add_page_field_meta_boxes( $post ) {
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}

	$front_id        = (int) get_option( 'page_on_front' );
	$page_template   = get_page_template_slug( $post );
	$is_front        = $front_id > 0 && $front_id === (int) $post->ID;
	$is_about        = 'page-templates/page-about.php' === $page_template;
	$is_contact      = 'page-templates/page-contact.php' === $page_template;
	$show_page_opts  = ! $is_front && ! $is_about && ! $is_contact;

	$boxes = array();
	if ( $is_front ) {
		$boxes['home'] = lubben_vet_page_field_groups()['home'];
	}
	if ( $is_about ) {
		$boxes['about'] = lubben_vet_page_field_groups()['about'];
	}
	if ( $is_contact ) {
		$boxes['contact'] = lubben_vet_page_field_groups()['contact'];
	}
	if ( $show_page_opts ) {
		$boxes['page'] = lubben_vet_page_field_groups()['page'];
	}

	foreach ( $boxes as $slug => $group ) {
		add_meta_box(
			'lubben_vet_page_fields_' . $slug,
			$group['title'],
			'lubben_vet_render_page_field_meta_box',
			'page',
			'normal',
			'high',
			array(
				'group' => $group,
				'slug'  => $slug,
			)
		);
	}
}
add_action( 'add_meta_boxes_page', 'lubben_vet_add_page_field_meta_boxes' );

/**
 * Render a page-field meta box.
 *
 * @param WP_Post $post Post object.
 * @param array   $box  Meta box args.
 */
function lubben_vet_render_page_field_meta_box( $post, $box ) {
	$group = isset( $box['args']['group'] ) ? $box['args']['group'] : null;
	if ( ! is_array( $group ) ) {
		return;
	}

	wp_nonce_field( 'lubben_vet_save_page_fields', 'lubben_vet_page_fields_nonce' );

	echo '<div class="lv-fields lubben-vet-page-fields">';

	if ( ! empty( $group['description'] ) ) {
		echo '<p class="lv-fields__intro">';
		echo '<span class="dashicons dashicons-info-outline" aria-hidden="true"></span>';
		echo esc_html( $group['description'] );
		echo '</p>';
	}

	$section_index = 0;
	foreach ( $group['sections'] as $section ) {
		$open = 0 === $section_index ? ' open' : '';
		echo '<details class="lv-section"' . $open . '>';
		if ( ! empty( $section['title'] ) ) {
			echo '<summary class="lv-section__summary">' . esc_html( $section['title'] ) . '</summary>';
		}
		echo '<div class="lv-section__body">';

		if ( ! empty( $section['description'] ) ) {
			echo '<p class="lv-section__description">' . esc_html( $section['description'] ) . '</p>';
		}

		foreach ( $section['fields'] as $key => $field ) {
			if ( 'repeater' === $field['type'] ) {
				lubben_vet_render_page_field_repeater( $post, $key, $field );
			} else {
				lubben_vet_render_page_field_control( $post, $key, $field );
			}
		}

		echo '</div></details>';
		++$section_index;
	}

	echo '</div>';
}

/**
 * Single admin control.
 *
 * @param WP_Post              $post  Post.
 * @param string               $key   Meta key.
 * @param array<string, string> $field Field definition.
 */
function lubben_vet_render_page_field_control( $post, $key, $field ) {
	$type  = $field['type'];
	$label = $field['label'];
	$id    = 'lubben-vet-field-' . sanitize_key( $key );
	$name  = $key;
	$value = get_post_meta( $post->ID, $key, true );

	if ( ! metadata_exists( 'post', $post->ID, $key ) ) {
		$mod = get_theme_mod( $key, '' );
		if ( 'checkbox' === $type ) {
			if ( is_bool( $mod ) ) {
				$value = $mod ? '1' : '';
			} elseif ( isset( $field['default'] ) ) {
				$value = $field['default'] ? '1' : '';
			} else {
				$value = $mod ? '1' : '';
			}
		} elseif ( 'image' === $type ) {
			$value = absint( $mod );
		} else {
			$value = is_scalar( $mod ) ? (string) $mod : '';
		}
	}

	$row_class = 'lv-field lubben-vet-page-fields__row lubben-vet-page-fields__row--' . esc_attr( $type );
	echo '<div class="' . $row_class . '">';

	switch ( $type ) {
		case 'checkbox':
			echo '<label class="lv-toggle" for="' . esc_attr( $id ) . '">';
			echo '<input type="checkbox" class="lv-toggle__input" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="1" ' . checked( (bool) $value, true, false ) . '>';
			echo '<span class="lv-toggle__track" aria-hidden="true"></span>';
			echo '<span class="lv-toggle__label">' . esc_html( $label ) . '</span>';
			echo '</label>';
			break;

		case 'textarea':
			echo '<label class="lv-field__label" for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
			echo '<textarea class="lv-field__textarea large-text" rows="3" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( (string) $value ) . '</textarea>';
			break;

		case 'url':
			echo '<label class="lv-field__label" for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
			echo '<input type="url" class="lv-field__input large-text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( (string) $value ) . '" placeholder="https://">';
			break;

		case 'image':
			$attachment_id = absint( $value );
			$preview       = $attachment_id ? wp_get_attachment_image( $attachment_id, 'medium', false, array( 'class' => 'lubben-vet-page-fields__thumb' ) ) : '';
			$empty_class   = $attachment_id ? '' : ' is-empty';
			echo '<span class="lv-field__label lubben-vet-page-fields__label">' . esc_html( $label ) . '</span>';
			echo '<div class="lv-image-picker">';
			echo '<input type="hidden" class="lubben-vet-page-fields__image-id" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( (string) $attachment_id ) . '">';
			echo '<div class="lv-image-picker__preview lubben-vet-page-fields__preview' . esc_attr( $empty_class ) . '">' . $preview . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<div class="lv-image-picker__actions">';
			echo '<button type="button" class="button button-primary lubben-vet-page-fields__choose" data-target="' . esc_attr( $id ) . '">' . esc_html__( 'Choose image', 'lubben-vet' ) . '</button>';
			echo '<button type="button" class="button-link lubben-vet-page-fields__remove" data-target="' . esc_attr( $id ) . '">' . esc_html__( 'Remove image', 'lubben-vet' ) . '</button>';
			echo '</div></div>';
			break;

		default:
			echo '<label class="lv-field__label" for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
			echo '<input type="text" class="lv-field__input large-text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( (string) $value ) . '">';
			break;
	}

	echo '</div>';
}

/**
 * Repeater rows for the admin UI (saved meta or theme defaults).
 *
 * @param WP_Post              $post  Post.
 * @param string               $key   Meta key.
 * @param array<string, mixed> $field Field definition.
 * @return array<int, array<string, mixed>>
 */
function lubben_vet_page_field_repeater_rows_for_admin( $post, $key, $field ) {
	if ( metadata_exists( 'post', $post->ID, $key ) ) {
		return lubben_vet_get_page_field_repeater( $key, $post->ID );
	}

	if ( 'lubben_vet_about_staff' === $key && function_exists( 'lubben_vet_default_staff' ) ) {
		return lubben_vet_default_staff();
	}

	return array();
}

/**
 * Render a repeater field group.
 *
 * @param WP_Post              $post  Post.
 * @param string               $key   Meta key.
 * @param array<string, mixed> $field Field definition.
 */
function lubben_vet_render_page_field_repeater( $post, $key, $field ) {
	$rows       = lubben_vet_page_field_repeater_rows_for_admin( $post, $key, $field );
	$item_label = ! empty( $field['item_label'] ) ? $field['item_label'] : __( 'Item', 'lubben-vet' );
	$add_label  = ! empty( $field['add_label'] ) ? $field['add_label'] : __( 'Add item', 'lubben-vet' );
	$empty_lbl  = ! empty( $field['empty_label'] ) ? $field['empty_label'] : '';

	echo '<div class="lv-field lubben-vet-page-fields__row lubben-vet-page-fields__row--repeater">';
	echo '<span class="lv-field__label lubben-vet-page-fields__label">' . esc_html( $field['label'] ) . '</span>';

	echo '<div class="lubben-vet-repeater" data-key="' . esc_attr( $key ) . '" data-item-label="' . esc_attr( $item_label ) . '">';
	echo '<div class="lubben-vet-repeater__items">';

	if ( empty( $rows ) && $empty_lbl ) {
		echo '<p class="lubben-vet-repeater__empty description">' . esc_html( $empty_lbl ) . '</p>';
	}

	foreach ( $rows as $index => $row ) {
		lubben_vet_render_page_field_repeater_row( $key, $field, $index, $row );
	}

	echo '</div>';
	echo '<p><button type="button" class="button lubben-vet-repeater__add"><span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span> ' . esc_html( $add_label ) . '</button></p>';

	ob_start();
	lubben_vet_render_page_field_repeater_row( $key, $field, '__INDEX__', array() );
	$template = ob_get_clean();
	echo '<script type="text/html" class="lubben-vet-repeater__template" data-key="' . esc_attr( $key ) . '">';
	echo $template; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in row renderer.
	echo '</script>';

	echo '</div>';
	echo '</div>';
}

/**
 * Single repeater row markup.
 *
 * @param string               $key    Meta key.
 * @param array<string, mixed> $field  Field definition.
 * @param int|string           $index  Row index or __INDEX__ placeholder.
 * @param array<string, mixed> $row    Row values.
 */
function lubben_vet_render_page_field_repeater_row( $key, $field, $index, $row ) {
	$subfields   = isset( $field['fields'] ) ? $field['fields'] : array();
	$item_label  = ! empty( $field['item_label'] ) ? $field['item_label'] : __( 'Item', 'lubben-vet' );
	$name_prefix = $key . '[' . $index . ']';
	$display_idx = is_numeric( $index ) ? ( (int) $index + 1 ) : '';

	echo '<div class="lubben-vet-repeater__item" data-index="' . esc_attr( (string) $index ) . '">';
	echo '<div class="lubben-vet-repeater__item-header">';
	echo '<strong class="lubben-vet-repeater__item-title">';
	echo esc_html( $item_label );
	if ( '' !== $display_idx ) {
		echo ' #' . esc_html( (string) $display_idx );
	}
	echo '</strong>';
	echo '<button type="button" class="button-link-delete lubben-vet-repeater__remove">' . esc_html__( 'Remove', 'lubben-vet' ) . '</button>';
	echo '</div>';

	foreach ( $subfields as $subkey => $subfield ) {
		$sub_id    = 'lubben-vet-field-' . sanitize_key( $key ) . '-' . $index . '-' . $subkey;
		$sub_name  = $name_prefix . '[' . $subkey . ']';
		$sub_value = isset( $row[ $subkey ] ) ? $row[ $subkey ] : '';
		$sub_type  = $subfield['type'];

		echo '<div class="lv-field lubben-vet-page-fields__row lubben-vet-page-fields__row--' . esc_attr( $sub_type ) . '">';

		switch ( $sub_type ) {
			case 'textarea':
				echo '<label class="lv-field__label" for="' . esc_attr( $sub_id ) . '">' . esc_html( $subfield['label'] ) . '</label>';
				echo '<textarea class="lv-field__textarea large-text" rows="3" id="' . esc_attr( $sub_id ) . '" name="' . esc_attr( $sub_name ) . '">' . esc_textarea( (string) $sub_value ) . '</textarea>';
				break;

			case 'image':
				$attachment_id = absint( $sub_value );
				$preview       = $attachment_id ? wp_get_attachment_image( $attachment_id, 'medium', false, array( 'class' => 'lubben-vet-page-fields__thumb' ) ) : '';
				$empty_class   = $attachment_id ? '' : ' is-empty';
				echo '<span class="lv-field__label lubben-vet-page-fields__label">' . esc_html( $subfield['label'] ) . '</span>';
				echo '<div class="lv-image-picker">';
				echo '<input type="hidden" class="lubben-vet-page-fields__image-id" id="' . esc_attr( $sub_id ) . '" name="' . esc_attr( $sub_name ) . '" value="' . esc_attr( (string) $attachment_id ) . '">';
				echo '<div class="lv-image-picker__preview lubben-vet-page-fields__preview' . esc_attr( $empty_class ) . '">' . $preview . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<div class="lv-image-picker__actions">';
				echo '<button type="button" class="button button-primary lubben-vet-page-fields__choose" data-target="' . esc_attr( $sub_id ) . '">' . esc_html__( 'Choose image', 'lubben-vet' ) . '</button>';
				echo '<button type="button" class="button-link lubben-vet-page-fields__remove" data-target="' . esc_attr( $sub_id ) . '">' . esc_html__( 'Remove image', 'lubben-vet' ) . '</button>';
				echo '</div></div>';
				break;

			default:
				echo '<label class="lv-field__label" for="' . esc_attr( $sub_id ) . '">' . esc_html( $subfield['label'] ) . '</label>';
				echo '<input type="text" class="lv-field__input large-text" id="' . esc_attr( $sub_id ) . '" name="' . esc_attr( $sub_name ) . '" value="' . esc_attr( (string) $sub_value ) . '">';
				break;
		}

		echo '</div>';
	}

	echo '</div>';
}

/**
 * Persist page fields on save.
 *
 * @param int $post_id Post ID.
 */
function lubben_vet_save_page_fields( $post_id ) {
	if ( ! isset( $_POST['lubben_vet_page_fields_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lubben_vet_page_fields_nonce'] ) ), 'lubben_vet_save_page_fields' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}

	$allowed_keys = lubben_vet_allowed_page_field_keys_for_post( $post );
	if ( empty( $allowed_keys ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$posted = wp_unslash( $_POST );

	foreach ( $allowed_keys as $key ) {
		$field = lubben_vet_page_field_definition( $key );
		if ( ! $field ) {
			continue;
		}

		$sanitize = lubben_vet_page_field_sanitize_callback( $field['type'] );

		if ( 'checkbox' === $field['type'] ) {
			$raw   = isset( $posted[ $key ] ) ? $posted[ $key ] : '';
			$value = $sanitize( $raw );
			update_post_meta( $post_id, $key, $value ? 1 : 0 );
			continue;
		}

		if ( 'repeater' === $field['type'] ) {
			$raw_rows = isset( $posted[ $key ] ) && is_array( $posted[ $key ] ) ? $posted[ $key ] : array();
			$rows     = lubben_vet_sanitize_repeater_rows( $raw_rows, $field['fields'] );
			update_post_meta( $post_id, $key, wp_json_encode( $rows ) );
			continue;
		}

		if ( ! isset( $posted[ $key ] ) ) {
			continue;
		}

		$value = $sanitize( $posted[ $key ] );
		update_post_meta( $post_id, $key, $value );
	}

	// Unchecked checkboxes are absent from POST — clear them explicitly.
	foreach ( $allowed_keys as $key ) {
		$field = lubben_vet_page_field_definition( $key );
		if ( $field && 'checkbox' === $field['type'] && ! isset( $posted[ $key ] ) ) {
			update_post_meta( $post_id, $key, 0 );
		}
	}
}
add_action( 'save_post_page', 'lubben_vet_save_page_fields' );

/**
 * Keys editable on a given page.
 *
 * @param WP_Post $post Page.
 * @return string[]
 */
function lubben_vet_allowed_page_field_keys_for_post( $post ) {
	$front_id       = (int) get_option( 'page_on_front' );
	$page_template  = get_page_template_slug( $post );
	$is_front       = $front_id > 0 && $front_id === (int) $post->ID;
	$is_about       = 'page-templates/page-about.php' === $page_template;
	$is_contact     = 'page-templates/page-contact.php' === $page_template;
	$show_page_opts = ! $is_front && ! $is_about && ! $is_contact;

	$slugs = array();
	if ( $is_front ) {
		$slugs[] = 'home';
	}
	if ( $is_about ) {
		$slugs[] = 'about';
	}
	if ( $is_contact ) {
		$slugs[] = 'contact';
	}
	if ( $show_page_opts ) {
		$slugs[] = 'page';
	}

	$keys = array();
	foreach ( $slugs as $slug ) {
		$group = lubben_vet_page_field_groups()[ $slug ];
		foreach ( $group['sections'] as $section ) {
			$keys = array_merge( $keys, array_keys( $section['fields'] ) );
		}
	}

	return $keys;
}

/**
 * Admin assets for image pickers.
 *
 * @param string $hook_suffix Current admin screen.
 */
function lubben_vet_enqueue_page_fields_admin( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	wp_enqueue_media();

	$path = get_theme_file_path( 'assets/js/page-fields-admin.js' );
	if ( ! file_exists( $path ) ) {
		return;
	}

	wp_enqueue_script(
		'lubben-vet-page-fields-admin',
		get_theme_file_uri( 'assets/js/page-fields-admin.js' ),
		array( 'jquery' ),
		LUBBEN_VET_VERSION,
		true
	);

	wp_enqueue_style(
		'lubben-vet-page-fields-admin',
		get_theme_file_uri( 'assets/css/page-fields-admin.css' ),
		array(),
		LUBBEN_VET_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'lubben_vet_enqueue_page_fields_admin' );
