<?php
/**
 * Responsive imagery helpers (docs/02-design-system.md — WebP + fallback).
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Absolute URL for the primary WebP derivative when WordPress stores it in attachment meta.
 *
 * @param int $attachment_id Attachment ID.
 * @return string URL or empty.
 */
function lubben_vet_webp_source_url( $attachment_id ) {
	$attachment_id = absint( $attachment_id );
	$file          = get_attached_file( $attachment_id );
	$meta          = wp_get_attachment_metadata( $attachment_id );

	if ( ! $file || ! is_array( $meta ) || empty( $meta['sources']['image/webp']['file'] ) ) {
		return '';
	}

	$webp_relative = $meta['sources']['image/webp']['file'];
	$webp_path     = path_join( dirname( $file ), $webp_relative );

	if ( ! file_exists( $webp_path ) ) {
		return '';
	}

	$dir_url  = trailingslashit( dirname( wp_get_attachment_url( $attachment_id ) ) );
	$relative = str_replace( '\\', '/', $webp_relative );

	return $dir_url . $relative;
}

/**
 * Print attachment image wrapped in <picture> when a WebP source exists; otherwise default image tag.
 *
 * @param int                  $attachment_id Attachment ID.
 * @param string|int[]         $size          Image size.
 * @param array<string, mixed> $attr          Attributes for wp_get_attachment_image().
 * @return void
 */
function lubben_vet_the_attachment_picture( $attachment_id, $size, $attr = array() ) {
	$attachment_id = absint( $attachment_id );
	$webp          = lubben_vet_webp_source_url( $attachment_id );
	$img           = wp_get_attachment_image( $attachment_id, $size, false, $attr );

	if ( '' === $img ) {
		return;
	}

	if ( '' === $webp ) {
		echo $img;
		return;
	}

	echo '<picture>';
	echo '<source type="image/webp" srcset="' . esc_url( $webp ) . '">';
	echo $img;
	echo '</picture>';
}
