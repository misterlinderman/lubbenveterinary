<?php
/**
 * Create or replace the contact form via GFAPI (docs/04-gravity-forms-spec.md).
 *
 * Requires Gravity Forms active. Run from WordPress root:
 *   wp eval-file wp-content/themes/lubben-vet/bin/install-gf-contact-form.php
 *
 * Copies form ID into option `lubben_vet_gf_contact_form_id` for non-default IDs.
 *
 * @package Lubben_Vet
 */

if ( ! function_exists( 'get_option' ) ) {
	return;
}

if ( ! class_exists( 'GFAPI' ) ) {
	fwrite( STDERR, "Gravity Forms (GFAPI) is not available. Activate Gravity Forms and try again.\n" );
	return;
}

$theme_inc = get_template_directory() . '/inc/gravity-forms/contact-form-definition.php';
if ( ! is_readable( $theme_inc ) ) {
	fwrite( STDERR, "Missing contact form definition: {$theme_inc}\n" );
	return;
}

require_once $theme_inc;

$form = lubben_vet_contact_form_definition();

$replace_id = 0;
if ( isset( $GLOBALS['argv'] ) && is_array( $GLOBALS['argv'] ) ) {
	foreach ( $GLOBALS['argv'] as $i => $arg ) {
		if ( '--replace=' === substr( $arg, 0, 10 ) ) {
			$replace_id = (int) substr( $arg, 10 );
			break;
		}
	}
}

if ( $replace_id > 0 ) {
	$form['id'] = $replace_id;
	$result     = GFAPI::update_form( $form );
	if ( is_wp_error( $result ) ) {
		fwrite( STDERR, 'GFAPI::update_form failed: ' . $result->get_error_message() . "\n" );
		return;
	}
	update_option( 'lubben_vet_gf_contact_form_id', $replace_id );
	echo "Updated form #{$replace_id} and saved lubben_vet_gf_contact_form_id.\n";
	return;
}

$result = GFAPI::add_form( $form );

if ( is_wp_error( $result ) ) {
	fwrite( STDERR, 'GFAPI::add_form failed: ' . $result->get_error_message() . "\n" );
	return;
}

update_option( 'lubben_vet_gf_contact_form_id', (int) $result );
echo "Created form #{$result}. Saved option lubben_vet_gf_contact_form_id.\n";
echo "Import / re-export: use Forms → Import/Export and replace inc/gravity-forms/contact-form.json after verification.\n";
