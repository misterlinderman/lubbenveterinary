<?php
/**
 * Gravity Forms — contact / appointment form structure (docs/04-gravity-forms-spec.md).
 *
 * Used by `bin/install-gf-contact-form.php` and to regenerate `contact-form.json`.
 * After changes, run the installer or import the JSON in WP admin, then re-export when possible.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Form meta for GFAPI::add_form / export. Omits numeric id (assigned on insert/import).
 *
 * @return array<string, mixed>
 */
function lubben_vet_contact_form_definition() {
	$about_1        = "What's this about?";
	$emergency_copy = 'For an active animal emergency, please call 402-234-1054 right now — the office line reaches Dr. Lubben directly after hours. This form is not monitored 24/7.';
	$safe_emergency = function_exists( 'esc_html' ) ? esc_html( $emergency_copy ) : htmlspecialchars( $emergency_copy, ENT_QUOTES, 'UTF-8' );

	return array(
		'title'                => 'Request an Appointment / Contact Us',
		'description'          => "We'll get back to you within one business day. For after-hours emergencies, please call 402-234-1054.",
		'labelPlacement'       => 'top_label',
		'descriptionPlacement' => 'below',
		'markupVersion'        => 2,
		'enableHoneypot'       => true,
		'honeypotAction'       => 'spam',
		'button'               => array(
			'type'     => 'text',
			'text'     => 'Send Request',
			'imageUrl' => '',
		),
		'personalData'         => array(
			'preventIP' => false,
			'retention' => array(
				'policy'                => 'delete',
				'retain_entries_days'     => 365,
			),
		),
		'fields'               => array(
			array(
				'type'         => 'radio',
				'id'           => 1,
				'formId'       => 0,
				'label'        => $about_1,
				'adminLabel'   => 'Topic',
				'isRequired'   => true,
				'size'         => 'large',
				'errorMessage' => '',
				'choices'      => array(
					array(
						'text'       => 'Appointment request',
						'value'      => 'Appointment request',
						'isSelected' => false,
						'price'      => '',
					),
					array(
						'text'       => 'General question',
						'value'      => 'General question',
						'isSelected' => false,
						'price'      => '',
					),
					array(
						'text'       => 'Billing or records',
						'value'      => 'Billing or records',
						'isSelected' => false,
						'price'      => '',
					),
					array(
						'text'        => 'Emergency',
						'value'       => 'Emergency',
						'isSelected'  => false,
						'price'       => '',
						'description' => 'Use only for non-urgent messages; for an active emergency, call the clinic.',
					),
				),
				'inputs'             => null,
				'conditionalLogic'   => '',
				'description'        => '',
				'allowsPrepopulate'  => false,
				'cssClass'           => '',
			),
			array(
				'type'           => 'name',
				'id'             => 2,
				'formId'         => 0,
				'label'          => 'Your name',
				'isRequired'     => true,
				'nameFormat'     => 'advanced',
				'errorMessage'   => '',
				'inputs'         => array(
					array(
						'id'       => '2.2',
						'label'    => 'Prefix',
						'name'     => '',
						'isHidden' => true,
					),
					array(
						'id'       => '2.3',
						'label'    => 'First',
						'name'     => '',
						'isHidden' => false,
					),
					array(
						'id'       => '2.4',
						'label'    => 'Middle',
						'name'     => '',
						'isHidden' => true,
					),
					array(
						'id'       => '2.6',
						'label'    => 'Last',
						'name'     => '',
						'isHidden' => false,
					),
					array(
						'id'       => '2.8',
						'label'    => 'Suffix',
						'name'     => '',
						'isHidden' => true,
					),
				),
				'conditionalLogic' => '',
			),
			array(
				'type'             => 'phone',
				'id'               => 3,
				'formId'           => 0,
				'label'            => 'Phone number',
				'isRequired'       => true,
				'phoneFormat'      => 'standard',
				'errorMessage'     => '',
				'inputs'           => null,
				'conditionalLogic' => '',
			),
			array(
				'type'             => 'email',
				'id'               => 4,
				'formId'           => 0,
				'label'            => 'Email address',
				'isRequired'       => true,
				'errorMessage'     => '',
				'inputs'           => null,
				'conditionalLogic' => '',
			),
			array(
				'type'               => 'radio',
				'id'                 => 5,
				'formId'             => 0,
				'label'              => 'What kind of patient?',
				'isRequired'         => true,
				'conditionalLogic'   => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Appointment request',
						),
					),
				),
				'choices'            => array(
					array(
						'text'       => 'Small animal (dog, cat, etc.)',
						'value'      => 'Small animal (dog, cat, etc.)',
						'isSelected' => false,
						'price'      => '',
					),
					array(
						'text'       => 'Large animal (cattle, equine, etc.)',
						'value'      => 'Large animal (cattle, equine, etc.)',
						'isSelected' => false,
						'price'      => '',
					),
					array(
						'text'       => 'Other',
						'value'      => 'Other',
						'isSelected' => false,
						'price'      => '',
					),
				),
				'inputs'             => null,
			),
			array(
				'type'               => 'text',
				'id'                 => 6,
				'formId'             => 0,
				'label'              => 'Patient name & species',
				'isRequired'         => true,
				'placeholder'        => 'Bella — golden retriever',
				'conditionalLogic'   => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Appointment request',
						),
					),
				),
				'inputs'             => null,
			),
			array(
				'type'               => 'date',
				'id'                 => 7,
				'formId'             => 0,
				'label'              => 'Preferred date',
				'isRequired'         => false,
				'dateType'           => 'datepicker',
				'dateFormat'         => 'mdy',
				'inputs'             => null,
				'conditionalLogic'     => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Appointment request',
						),
					),
				),
			),
			array(
				'type'               => 'radio',
				'id'                 => 8,
				'formId'             => 0,
				'label'              => 'Preferred time',
				'isRequired'         => false,
				'choices'            => array(
					array( 'text' => 'Morning', 'value' => 'Morning', 'isSelected' => false, 'price' => '' ),
					array( 'text' => 'Midday', 'value' => 'Midday', 'isSelected' => false, 'price' => '' ),
					array( 'text' => 'Afternoon', 'value' => 'Afternoon', 'isSelected' => false, 'price' => '' ),
					array( 'text' => 'No preference', 'value' => 'No preference', 'isSelected' => false, 'price' => '' ),
				),
				'inputs'             => null,
				'conditionalLogic'     => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Appointment request',
						),
					),
				),
			),
			array(
				'type'               => 'checkbox',
				'id'                 => 9,
				'formId'             => 0,
				'label'              => 'Need a mobile/farm visit?',
				'isRequired'         => false,
				'choices'            => array(
					array(
						'text'       => "Yes, I'd like Dr. Lubben to come to me",
						'value'      => "Yes, I'd like Dr. Lubben to come to me",
						'isSelected' => false,
						'price'      => '',
					),
				),
				'inputs'             => array(
					array(
						'id'    => '9.1',
						'label' => "Yes, I'd like Dr. Lubben to come to me",
					),
				),
				'conditionalLogic'   => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Appointment request',
						),
						array(
							'fieldId'  => 5,
							'operator' => 'is',
							'value'    => 'Large animal (cattle, equine, etc.)',
						),
					),
				),
			),
			array(
				'type'               => 'textarea',
				'id'                 => 10,
				'formId'             => 0,
				'label'              => 'Anything we should know?',
				'isRequired'         => false,
				'size'               => 'medium',
				'maxLength'          => '',
				'inputMask'          => false,
				'inputMaskValue'     => '',
				'allowsPrepopulate'  => false,
				'enableCalculation'  => '',
				'conditionalLogic'   => '',
			),
			array(
				'type'               => 'html',
				'id'                 => 11,
				'formId'             => 0,
				'label'              => 'Emergency notice',
				'content'            => '<p>' . $safe_emergency . '</p>',
				'conditionalLogic'   => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Emergency',
						),
					),
				),
			),
		),
		'notifications'        => array(
			'a7f3c9102a4b1' => array(
				'isActive'          => true,
				'id'                => 'a7f3c9102a4b1',
				'name'              => 'Appointment requests',
				'service'           => 'wordpress',
				'event'             => 'form_submission',
				'to'                => 'michaela@lubbenveterinary.com',
				'toType'            => 'email',
				'bcc'               => '',
				'subject'           => '[Appointment] {Name (Prefix):2.2} {Name (Last):2.6} — {Patient name & species:6}',
				'message'           => "{all_fields}\n\n---\nSubmitted from: {embed_url}\nDate: {date_mdy}",
				'from'              => 'noreply@lubbenveterinary.com',
				'fromName'          => 'Lubben Veterinary Website',
				'replyTo'           => '{Email:4}',
				'conditionalLogic'  => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Appointment request',
						),
					),
				),
				'disableAutoformat' => false,
				'enableAttachments' => false,
			),
			'b7f3c9102a4b2' => array(
				'isActive'          => true,
				'id'                => 'b7f3c9102a4b2',
				'name'              => 'General questions',
				'service'           => 'wordpress',
				'event'             => 'form_submission',
				'to'                => 'michaela@lubbenveterinary.com',
				'toType'            => 'email',
				'subject'           => '[General] Question from {Name (First):2.3} {Name (Last):2.6}',
				'message'           => "{all_fields}\n\n---\n{embed_url}",
				'from'              => 'noreply@lubbenveterinary.com',
				'fromName'          => 'Lubben Veterinary Website',
				'replyTo'           => '{Email:4}',
				'conditionalLogic'  => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'General question',
						),
					),
				),
				'disableAutoformat' => false,
				'enableAttachments' => false,
			),
			'c7f3c9102a4b3' => array(
				'isActive'          => true,
				'id'                => 'c7f3c9102a4b3',
				'name'              => 'Billing or records',
				'service'           => 'wordpress',
				'event'             => 'form_submission',
				'to'                => 'billing@lubbenveterinary.com',
				'toType'            => 'email',
				'subject'           => '[Billing/Records] {Name (First):2.3} {Name (Last):2.6}',
				'message'           => "{all_fields}\n\n---\n{embed_url}",
				'from'              => 'noreply@lubbenveterinary.com',
				'fromName'          => 'Lubben Veterinary Website',
				'replyTo'           => '{Email:4}',
				'conditionalLogic'  => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Billing or records',
						),
					),
				),
				'disableAutoformat' => false,
				'enableAttachments' => false,
			),
			'd7f3c9102a4b4' => array(
				'isActive'          => true,
				'id'                => 'd7f3c9102a4b4',
				'name'              => 'Emergency-flagged submission',
				'service'           => 'wordpress',
				'event'             => 'form_submission',
				'to'                => 'michaela@lubbenveterinary.com, dr.lubben@lubbenveterinary.com',
				'toType'            => 'email',
				'subject'           => '🚨 [EMERGENCY via website] {Name (First):2.3} {Name (Last):2.6} — {Phone:3}',
				'message'           => "Phone: {Phone:3}\nName: {Name (First):2.3} {Name (Last):2.6}\n\nNotes:\n{Anything we should know?:10}\n\n---\nThis is a website-form emergency submission. The submitter was instructed to call 402-234-1054.\n\n{all_fields}\n\n{embed_url}",
				'from'              => 'noreply@lubbenveterinary.com',
				'fromName'          => 'Lubben Veterinary Website',
				'replyTo'           => '{Email:4}',
				'conditionalLogic'  => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Emergency',
						),
					),
				),
				'disableAutoformat' => false,
				'enableAttachments' => false,
			),
			'e7f3c9102a4b5' => array(
				'isActive'          => true,
				'id'                => 'e7f3c9102a4b5',
				'name'              => 'Confirmation to submitter',
				'service'           => 'wordpress',
				'event'             => 'form_submission',
				'to'                => '4',
				'toType'            => 'field',
				'subject'           => 'We received your message — Lubben Veterinary Services',
				'message'           => "Hi {Name (First):2.3},\n\nThanks for reaching out. We received your message regarding \"{Topic:1}\".\n\nOur office hours are Monday–Friday 7am–6pm and Saturday 8am–12pm. For after-hours emergencies, call 402-234-1054 — the office line reaches Dr. Lubben directly after hours.\n\nWe aim to respond within one business day.\n\n— Lubben Veterinary Services",
				'from'              => 'noreply@lubbenveterinary.com',
				'fromName'          => 'Lubben Veterinary Website',
				'replyTo'           => '{Email:4}',
				'conditionalLogic'  => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'isnot',
							'value'    => 'Emergency',
						),
					),
				),
				'disableAutoformat' => false,
				'enableAttachments' => false,
			),
		),
		'confirmations'        => array(
			'f7f3c9102a4b6' => array(
				'id'               => 'f7f3c9102a4b6',
				'name'             => 'Default Confirmation',
				'isDefault'        => true,
				'type'             => 'message',
				'message'          => 'Thanks, {Name (First):2.3} — we got your message and will be in touch within one business day. Office hours are Monday–Friday 7am–6pm and Saturday 8am–12pm.',
				'url'              => '',
				'pageId'           => '',
				'queryString'      => '',
				'conditionalLogic' => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'isnot',
							'value'    => 'Emergency',
						),
					),
				),
			),
			'f7f3c9102a4b7' => array(
				'id'               => 'f7f3c9102a4b7',
				'name'             => 'Emergency confirmation',
				'isDefault'        => false,
				'type'             => 'message',
				'message'          => 'We received your message. <strong>For an active emergency, please call 402-234-1054 right now</strong> — the office line reaches Dr. Lubben directly after hours.',
				'url'              => '',
				'pageId'           => '',
				'queryString'      => '',
				'conditionalLogic' => array(
					'actionType' => 'show',
					'logicType'  => 'all',
					'rules'      => array(
						array(
							'fieldId'  => 1,
							'operator' => 'is',
							'value'    => 'Emergency',
						),
					),
				),
			),
		),
		'is_active'            => '1',
	);
}
