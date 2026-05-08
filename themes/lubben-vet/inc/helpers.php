<?php
/**
 * Theme helpers — address, hours, staff, phone, map URLs.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Practice address parts (unescaped).
 *
 * @return array<string, string>
 */
function get_lubben_address() {
	$data = array(
		'street' => '1276 Sand Hill Circle',
		'suite'  => 'Suite 1',
		'city'   => 'Louisville',
		'state'  => 'NE',
		'zip'    => '68037',
	);

	return apply_filters( 'lubben_vet_address', $data );
}

/**
 * Full single-line address (unescaped).
 *
 * @return string
 */
function lubben_vet_format_address_line() {
	$a = get_lubben_address();

	return trim(
		sprintf(
			'%1$s, %2$s, %3$s, %4$s %5$s',
			$a['street'],
			$a['suite'],
			$a['city'],
			$a['state'],
			$a['zip']
		)
	);
}

/**
 * Google Maps search URL for the practice.
 *
 * @return string
 */
function lubben_vet_maps_link_url() {
	$query = lubben_vet_format_address_line();

	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $query );
}

/**
 * Google Maps embed URL (no API key).
 *
 * @return string
 */
function lubben_vet_maps_embed_url() {
	$query = lubben_vet_format_address_line();

	return 'https://maps.google.com/maps?q=' . rawurlencode( $query ) . '&z=14&output=embed&ie=UTF8';
}

/**
 * Office hours labels → lines (unescaped values).
 *
 * @return array<string, string>
 */
function get_lubben_hours() {
	$data = array(
		__( 'Monday – Friday', 'lubben-vet' ) => __( '7:00 a.m. – 6:00 p.m.', 'lubben-vet' ),
		__( 'Saturday', 'lubben-vet' )        => __( '8:00 a.m. – 12:00 p.m.', 'lubben-vet' ),
		__( 'Sunday', 'lubben-vet' )            => __( 'Closed', 'lubben-vet' ),
	);

	return apply_filters( 'lubben_vet_hours', $data );
}

/**
 * After-hours / emergency line copy (unescaped).
 *
 * @return string
 */
function lubben_vet_after_hours_note() {
	$text = __( 'After-hours emergencies: call the office at any time — this line reaches Dr. Lubben directly.', 'lubben-vet' );

	return apply_filters( 'lubben_vet_after_hours_note', $text );
}

/**
 * Primary office phone (display string).
 *
 * @return string
 */
function get_lubben_phone() {
	$phone = '402-234-1054';

	return apply_filters( 'lubben_vet_phone', $phone );
}

/**
 * Tel URL for primary phone (digits only).
 *
 * @return string
 */
function get_lubben_phone_tel() {
	$digits = preg_replace( '/\D+/', '', get_lubben_phone() );

	return 'tel:' . $digits;
}

/**
 * Staff records for About page cards.
 *
 * @return array<int, array<string, int|string>>
 */
function get_lubben_staff() {
	$data = array(
		array(
			'name'     => 'Michaela Nielsen',
			'role'     => __( 'Office Manager', 'lubben-vet' ),
			'bio'      => __( 'Lead administrator and primary point of contact for scheduling and client care.', 'lubben-vet' ),
			'photo_id' => 0,
		),
		array(
			'name'     => 'Candy Damme',
			'role'     => __( 'Staff', 'lubben-vet' ),
			'bio'      => __( 'Helps keep our patients and clients comfortable from check-in to checkout.', 'lubben-vet' ),
			'photo_id' => 0,
		),
		array(
			'name'     => 'LeAnn Burger',
			'role'     => __( 'Staff', 'lubben-vet' ),
			'bio'      => __( 'Supports the care team and the people who love their animals.', 'lubben-vet' ),
			'photo_id' => 0,
		),
	);

	return apply_filters( 'lubben_vet_staff', $data );
}

/**
 * Initials from a display name.
 *
 * @param string $name Full name.
 * @return string
 */
function lubben_vet_staff_initials( $name ) {
	$parts = preg_split( '/\s+/', trim( $name ), -1, PREG_SPLIT_NO_EMPTY );
	if ( empty( $parts ) ) {
		return '';
	}
	if ( count( $parts ) === 1 ) {
		return strtoupper( mb_substr( $parts[0], 0, 1 ) );
	}

	return strtoupper( mb_substr( $parts[0], 0, 1 ) . mb_substr( $parts[ count( $parts ) - 1 ], 0, 1 ) );
}
