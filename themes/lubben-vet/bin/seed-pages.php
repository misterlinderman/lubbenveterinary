<?php
/**
 * Seed Home / About / Contact pages and menus (idempotent).
 *
 * Run from site web root:
 *   wp eval-file wp-content/themes/lubben-vet/bin/seed-pages.php
 *
 * @package Lubben_Vet
 */

if ( ! function_exists( 'wp_insert_post' ) ) {
	return;
}

/**
 * Get or create a page by slug.
 *
 * @param string $slug Slug.
 * @param string $title Title.
 * @param string $template Page template path.
 * @param string $content Post content.
 * @param string $excerpt Optional excerpt.
 * @return int Page ID.
 */
function lubben_vet_seed_ensure_page( $slug, $title, $template, $content = '', $excerpt = '' ) {
	$existing = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $existing instanceof WP_Post ) {
		wp_update_post(
			array(
				'ID'           => $existing->ID,
				'post_title'   => $title,
				'post_content' => $content,
				'post_excerpt' => $excerpt,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_name'    => $slug,
			)
		);
		update_post_meta( $existing->ID, '_wp_page_template', $template );

		return (int) $existing->ID;
	}

	$post_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $content,
			'post_excerpt' => $excerpt,
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return 0;
	}

	update_post_meta( $post_id, '_wp_page_template', $template );

	return (int) $post_id;
}

$about_intro = '<!-- wp:paragraph --><p>' . __( 'Whether you are new to the area or have known us for years, we are glad you are here. Below you will find more about our practice, Dr. Lubben, and the team that keeps things running smoothly.', 'lubben-vet' ) . '</p><!-- /wp:paragraph -->';

$contact_intro = '<!-- wp:paragraph --><p>' . __( 'We would love to help — send a note below or call the office.', 'lubben-vet' ) . '</p><!-- /wp:paragraph -->';

$home_id = lubben_vet_seed_ensure_page(
	'home',
	__( 'Home', 'lubben-vet' ),
	'default',
	'',
	__( 'Homepage layout is managed in the theme (front-page sections). Edit the hero image under Appearance → Customize.', 'lubben-vet' )
);

$about_id = lubben_vet_seed_ensure_page(
	'about',
	__( 'About', 'lubben-vet' ),
	'page-templates/page-about.php',
	$about_intro
);

$contact_id = lubben_vet_seed_ensure_page(
	'contact',
	__( 'Contact', 'lubben-vet' ),
	'page-templates/page-contact.php',
	$contact_intro
);

if ( $home_id ) {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
}

$pharmacy = 'https://lubbenveterinary.myvetstoreonline.pharmacy';

/**
 * Ensure a nav menu exists and return its term ID.
 *
 * @param string $name Menu name.
 * @return int
 */
function lubben_vet_seed_get_or_create_menu( $name ) {
	$menu = wp_get_nav_menu_object( $name );
	if ( $menu ) {
		return (int) $menu->term_id;
	}
	$created = wp_create_nav_menu( $name );

	return is_wp_error( $created ) ? 0 : (int) $created;
}

/**
 * Determine whether a menu item already links to a URL.
 *
 * @param int    $menu_id Menu ID.
 * @param string $url     URL to match.
 * @return bool
 */
function lubben_vet_seed_menu_has_url( $menu_id, $url ) {
	$items = wp_get_nav_menu_items( $menu_id );
	if ( ! is_array( $items ) ) {
		return false;
	}
	$target = trailingslashit( $url );
	foreach ( $items as $item ) {
		if ( 'custom' === $item->type && isset( $item->url ) ) {
			if ( trailingslashit( $item->url ) === $target ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Remove custom links to the online pharmacy from a menu (IA: primary is Home, About, Contact only).
 *
 * @param int    $menu_id Menu term ID.
 * @param string $pharmacy_url Pharmacy URL.
 * @return void
 */
function lubben_vet_seed_strip_pharmacy_links( $menu_id, $pharmacy_url ) {
	$items = wp_get_nav_menu_items( $menu_id );
	if ( ! is_array( $items ) ) {
		return;
	}
	$base = untrailingslashit( $pharmacy_url );
	foreach ( $items as $item ) {
		if ( 'custom' !== $item->type || empty( $item->url ) ) {
			continue;
		}
		$url = untrailingslashit( (string) $item->url );
		if ( $url === $base || str_starts_with( (string) $item->url, $base ) ) {
			wp_delete_post( (int) $item->ID, true );
		}
	}
}

/**
 * Determine whether a menu item already references a page.
 *
 * @param int $menu_id Menu ID.
 * @param int $page_id Page ID.
 * @return bool
 */
function lubben_vet_seed_menu_has_page( $menu_id, $page_id ) {
	$items = wp_get_nav_menu_items( $menu_id );
	if ( ! is_array( $items ) ) {
		return false;
	}
	foreach ( $items as $item ) {
		if ( 'post_type' === $item->type && (int) $item->object_id === (int) $page_id ) {
			return true;
		}
	}

	return false;
}

$primary_id = lubben_vet_seed_get_or_create_menu( 'Primary' );
if ( $primary_id ) {
	if ( ! lubben_vet_seed_menu_has_url( $primary_id, home_url( '/' ) ) ) {
		wp_update_nav_menu_item(
			$primary_id,
			0,
			array(
				'menu-item-title'  => __( 'Home', 'lubben-vet' ),
				'menu-item-url'    => home_url( '/' ),
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
			)
		);
	}
	if ( $about_id && ! lubben_vet_seed_menu_has_page( $primary_id, $about_id ) ) {
		wp_update_nav_menu_item(
			$primary_id,
			0,
			array(
				'menu-item-title'     => get_the_title( $about_id ),
				'menu-item-object-id' => $about_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	if ( $contact_id && ! lubben_vet_seed_menu_has_page( $primary_id, $contact_id ) ) {
		wp_update_nav_menu_item(
			$primary_id,
			0,
			array(
				'menu-item-title'     => get_the_title( $contact_id ),
				'menu-item-object-id' => $contact_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	// docs/01-information-architecture.md: Online Pharmacy is footer nav only, not primary.
	lubben_vet_seed_strip_pharmacy_links( $primary_id, $pharmacy );

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	$locations['primary'] = $primary_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

$footer_id = lubben_vet_seed_get_or_create_menu( 'Footer' );
if ( $footer_id ) {
	if ( ! lubben_vet_seed_menu_has_url( $footer_id, home_url( '/' ) ) ) {
		wp_update_nav_menu_item(
			$footer_id,
			0,
			array(
				'menu-item-title'  => __( 'Home', 'lubben-vet' ),
				'menu-item-url'    => home_url( '/' ),
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
			)
		);
	}
	if ( $about_id && ! lubben_vet_seed_menu_has_page( $footer_id, $about_id ) ) {
		wp_update_nav_menu_item(
			$footer_id,
			0,
			array(
				'menu-item-title'     => get_the_title( $about_id ),
				'menu-item-object-id' => $about_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	if ( $contact_id && ! lubben_vet_seed_menu_has_page( $footer_id, $contact_id ) ) {
		wp_update_nav_menu_item(
			$footer_id,
			0,
			array(
				'menu-item-title'     => get_the_title( $contact_id ),
				'menu-item-object-id' => $contact_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	if ( ! lubben_vet_seed_menu_has_url( $footer_id, $pharmacy ) ) {
		wp_update_nav_menu_item(
			$footer_id,
			0,
			array(
				'menu-item-title'  => __( 'Online Pharmacy', 'lubben-vet' ),
				'menu-item-url'    => $pharmacy,
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
			)
		);
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	$locations['footer'] = $footer_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

echo "Lubben Vet seed complete.\n";
