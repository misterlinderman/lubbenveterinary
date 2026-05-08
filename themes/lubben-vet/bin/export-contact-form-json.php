<?php
/**
 * Write inc/gravity-forms/contact-form.json from contact-form-definition.php (no WP bootstrap).
 *
 * Run from anywhere:
 *   php wp-content/themes/lubben-vet/bin/export-contact-form-json.php
 *
 * @package Lubben_Vet
 */

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once dirname( __DIR__ ) . '/inc/gravity-forms/contact-form-definition.php';

$form = lubben_vet_contact_form_definition();

// Match Gravity Forms export shape: numeric form index(es) + version string key.
$payload           = array( $form );
$payload['version'] = '2.8.0';
$json               = json_encode( $payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$target = dirname( __DIR__ ) . '/inc/gravity-forms/contact-form.json';
$ok     = false !== file_put_contents( $target, $json . "\n" );

if ( ! $ok ) {
	fwrite( STDERR, "Could not write {$target}\n" );
	exit( 1 );
}

echo "Wrote {$target}\n";
