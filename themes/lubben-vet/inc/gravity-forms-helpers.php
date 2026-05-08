<?php
/**
 * Gravity Forms — theme integration (styling hooks; form lives in admin + JSON export).
 *
 * Hooks register only when Gravity Forms is active (`GFForms`). `lubben_vet_render_contact_form()`
 * still runs without the plugin and shows a short fallback message.
 *
 * Part B — WP admin (manual): install/activate Gravity Forms → import
 * `inc/gravity-forms/contact-form.json` (or run `wp eval-file` on `bin/install-gf-contact-form.php`) →
 * confirm notifications, confirmations, honeypot, retention 365d, SMTP (WP Mail SMTP) → test each
 * “What’s this about?” path → re-export form JSON from Forms → Import/Export → replace repo JSON → commit.
 * Verify GF theme CSS is off: wrapper should not use `.gform-theme--orbital`; our `theme.css` block styles the form.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Form ID for the primary contact / appointment form (defaults to 1; set by installer option).
 *
 * @return int
 */
function lubben_vet_get_contact_form_id() {
	return (int) apply_filters( 'lubben_vet_contact_form_id', (int) get_option( 'lubben_vet_gf_contact_form_id', 1 ) );
}

/**
 * Render the primary contact / appointment form.
 */
function lubben_vet_render_contact_form() {
	if ( ! function_exists( 'gravity_form' ) ) {
		echo '<p class="gform_missing">' . esc_html__( 'The contact form requires Gravity Forms. Please install and activate the plugin, then import the form from the theme export.', 'lubben-vet' ) . '</p>';
		return;
	}

	$form_id = lubben_vet_get_contact_form_id();

	gravity_form(
		$form_id,
		false,
		true,
		false,
		null,
		true,
		1,
		true
	);
}

/**
 * Disable Gravity Forms bundled theme CSS.
 *
 * @return bool
 */
function lubben_vet_gform_disable_theme_css() {
	return true;
}

/**
 * Contact form: ensure submit label (definition also sets it; this keeps translations central).
 *
 * @param array<string, mixed> $form Form array.
 * @return array<string, mixed>
 */
function lubben_vet_gform_contact_form_tweaks( $form ) {
	if ( empty( $form['id'] ) || lubben_vet_get_contact_form_id() !== (int) $form['id'] ) {
		return $form;
	}

	if ( isset( $form['button'] ) && is_array( $form['button'] ) ) {
		$form['button']['type'] = 'text';
		$form['button']['text'] = __( 'Send Request', 'lubben-vet' );
	}

	return $form;
}

/**
 * Preferred date cannot be before today (field 7).
 *
 * @param array<string, mixed>                $result Validation result.
 * @param mixed                               $value  Submitted value.
 * @param array<string, mixed>                $form   Form array.
 * @param GF_Field|object $field Field object.
 * @return array<string, mixed>
 */
function lubben_vet_gform_contact_preferred_date_validation( $result, $value, $form, $field ) {
	if ( ! is_object( $field ) || empty( $form['id'] ) || lubben_vet_get_contact_form_id() !== (int) $form['id'] ) {
		return $result;
	}

	if ( 'date' !== $field->type || 7 !== (int) $field->id ) {
		return $result;
	}

	if ( $result['is_valid'] && '' === (string) $value ) {
		return $result;
	}

	$value     = (string) $value;
	$submitted = DateTime::createFromFormat( 'm/d/Y', $value, wp_timezone() );
	if ( ! $submitted instanceof DateTime ) {
		return $result;
	}

	$today = new DateTime( 'today', wp_timezone() );
	if ( $submitted < $today ) {
		$result['is_valid'] = false;
		$result['message']  = esc_html__( 'Please choose today or a future date.', 'lubben-vet' );
	}

	return $result;
}

/**
 * Appointment staff email: BCC Dr. Lubben when mobile/farm visit is checked (field 9).
 *
 * @param array<string, mixed>      $notification Notification settings.
 * @param array<string, mixed>      $form         Form array.
 * @param array<string, mixed>|false $entry       Entry.
 * @return array<string, mixed>|false
 */
function lubben_vet_gform_appointment_bcc_dr( $notification, $form, $entry ) {
	if ( empty( $form['id'] ) || lubben_vet_get_contact_form_id() !== (int) $form['id'] ) {
		return $notification;
	}

	if ( empty( $notification['name'] ) || 'Appointment requests' !== $notification['name'] ) {
		return $notification;
	}

	if ( ! is_array( $entry ) ) {
		return $notification;
	}

	$bcc_dr = 'dr.lubben@lubbenveterinary.com';
	if ( ! empty( $entry['9.1'] ) ) {
		$existing        = isset( $notification['bcc'] ) ? trim( (string) $notification['bcc'] ) : '';
		$notification['bcc'] = $existing ? $existing . ', ' . $bcc_dr : $bcc_dr;
	}

	return $notification;
}

/**
 * Add emergency notice styling hooks to HTML field output.
 *
 * @param string     $field_content Field HTML.
 * @param object     $field         Field object.
 * @param string     $value         Value.
 * @param int|string $entry_id      Entry ID.
 * @param int|string $form_id       Form ID.
 * @return string
 */
function lubben_vet_gform_field_content_classes( $field_content, $field, $value, $entry_id, $form_id ) {
	if ( lubben_vet_get_contact_form_id() !== (int) $form_id || ! is_object( $field ) || ! isset( $field->type, $field->id ) ) {
		return $field_content;
	}

	if ( 'html' !== $field->type || 11 !== (int) $field->id ) {
		return $field_content;
	}

	if ( false === stripos( $field_content, 'class="' ) ) {
		return '<div class="lubben-form__notice">' . $field_content . '</div>';
	}

	return preg_replace( '/class="/', 'class="lubben-form__notice ', $field_content, 1 );
}

/**
 * Emphasize emergency confirmations when copy matches the launch spec.
 *
 * @param string               $confirmation Confirmation message/HTML.
 * @param array<string, mixed> $form         Form object.
 * @param array<string, mixed> $entry        Entry.
 * @param bool                 $ajax         Whether AJAX.
 * @return string
 */
function lubben_vet_gform_confirmation_emergency_class( $confirmation, $form, $entry, $ajax ) {
	if ( empty( $form['id'] ) || lubben_vet_get_contact_form_id() !== (int) $form['id'] || empty( $confirmation ) ) {
		return $confirmation;
	}

	if ( is_string( $confirmation ) && false !== stripos( $confirmation, '402-234-1054' ) && false !== stripos( $confirmation, 'active emergency' ) ) {
		if ( preg_match( '/^<div /', trim( $confirmation ) ) ) {
			return preg_replace( '/^<div /', '<div class="lubben-form__confirmation--emergency" ', trim( $confirmation ), 1 );
		}
		return '<div class="lubben-form__confirmation--emergency">' . $confirmation . '</div>';
	}

	return $confirmation;
}

if ( class_exists( 'GFForms' ) ) {
	add_filter( 'gform_disable_form_theme_css', 'lubben_vet_gform_disable_theme_css' );
	add_filter( 'gform_pre_render', 'lubben_vet_gform_contact_form_tweaks' );
	add_filter( 'gform_pre_validation', 'lubben_vet_gform_contact_form_tweaks' );
	add_filter( 'gform_pre_submission_filter', 'lubben_vet_gform_contact_form_tweaks' );
	add_filter( 'gform_admin_pre_render', 'lubben_vet_gform_contact_form_tweaks' );
	add_filter( 'gform_field_validation', 'lubben_vet_gform_contact_preferred_date_validation', 10, 4 );
	add_filter( 'gform_notification', 'lubben_vet_gform_appointment_bcc_dr', 10, 3 );
	add_filter( 'gform_field_content', 'lubben_vet_gform_field_content_classes', 10, 5 );
	add_filter( 'gform_confirmation', 'lubben_vet_gform_confirmation_emergency_class', 15, 4 );
}
