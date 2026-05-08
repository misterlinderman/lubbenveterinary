<?php
/**
 * Basic SEO output — meta description and Open Graph.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Map of page slug → meta description (unescaped strings).
 *
 * @return array<string, string>
 */
function lubben_vet_meta_description_map() {
	return array(
		'home'    => 'Mixed animal veterinary care for southeast Nebraska. Small animal, large animal mobile service, surgery, and after-hours emergencies. Louisville, NE.',
		'about'   => 'Dr. Scott Lubben, DVM, has served Cass, Sarpy, Otoe, and Saunders counties for over 30 years. Meet our practice and staff.',
		'contact' => 'Hours, address, and how to reach us. Request an appointment online or call 402-234-1054.',
	);
}

/**
 * Resolve description for the current view.
 *
 * @return string
 */
function lubben_vet_get_meta_description() {
	$map      = lubben_vet_meta_description_map();
	$fallback = get_bloginfo( 'description', 'display' );

	if ( is_front_page() ) {
		return isset( $map['home'] ) ? $map['home'] : $fallback;
	}

	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post && 'page' === $post->post_type ) {
			$slug = $post->post_name;
			if ( isset( $map[ $slug ] ) ) {
				return $map[ $slug ];
			}
		}
	}

	return $fallback;
}

/**
 * Output meta description tag.
 */
function lubben_vet_meta_description() {
	$desc = lubben_vet_get_meta_description();
	if ( '' === $desc ) {
		return;
	}

	printf(
		'<meta name="description" content="%s" />' . "\n",
		esc_attr( wp_strip_all_tags( $desc ) )
	);
}
add_action( 'wp_head', 'lubben_vet_meta_description', 1 );

/**
 * Basic Open Graph tags.
 */
function lubben_vet_open_graph() {
	if ( ! is_singular() && ! is_front_page() ) {
		return;
	}

	$title = wp_get_document_title();
	$desc  = lubben_vet_get_meta_description();
	$url   = '';

	if ( is_singular() ) {
		$url = get_permalink();
	} elseif ( is_front_page() ) {
		$url = home_url( '/' );
	}

	$image = '';
	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
	}

	if ( '' === $image ) {
		$image = get_theme_file_uri( 'assets/images/og-default.jpg' );
	}

	$type = is_front_page() ? 'website' : 'article';

	echo '<meta property="og:title" content="' . esc_attr( wp_strip_all_tags( $title ) ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( wp_strip_all_tags( $desc ) ) . '" />' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '" />' . "\n";

	if ( is_string( $url ) && '' !== $url ) {
		echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	}

	if ( is_string( $image ) && '' !== $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'lubben_vet_open_graph', 2 );
