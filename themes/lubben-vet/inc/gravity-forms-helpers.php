<?php
/**
 * Gravity Forms — theme integration (styling hooks; form lives in admin + JSON export).
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render the primary contact / appointment form (ID 1).
 */
function lubben_vet_render_contact_form() {
	if ( ! function_exists( 'gravity_form' ) ) {
		echo '<p class="gform_missing">' . esc_html__( 'The contact form requires Gravity Forms. Please install and activate the plugin, then import the form from the theme export.', 'lubben-vet' ) . '</p>';
		return;
	}

	gravity_form( 1, false, false, false, null, true, 1, true );
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
 * Optional dynamic form tweaks.
 *
 * @param array $form Form object.
 * @return array
 */
function lubben_vet_gform_dynamic_defaults( $form ) {
	return $form;
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
	if ( 1 !== (int) $form_id || ! is_object( $field ) || ! isset( $field->type, $field->id ) ) {
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
	if ( empty( $form['id'] ) || 1 !== (int) $form['id'] || empty( $confirmation ) ) {
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
	add_filter( 'gform_pre_render', 'lubben_vet_gform_dynamic_defaults' );
	add_filter( 'gform_pre_validation', 'lubben_vet_gform_dynamic_defaults' );
	add_filter( 'gform_pre_submission_filter', 'lubben_vet_gform_dynamic_defaults' );
	add_filter( 'gform_admin_pre_render', 'lubben_vet_gform_dynamic_defaults' );
	add_filter( 'gform_field_content', 'lubben_vet_gform_field_content_classes', 10, 5 );
	add_filter( 'gform_confirmation', 'lubben_vet_gform_confirmation_emergency_class', 15, 4 );
}
