<?php
/**
 * Theme helpers — address, hours, staff, phone, map URLs.
 *
 * @package Lubben_Vet
 * @since   0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Practice address parts (unescaped). Verbatim from docs/03-content-migration.md.
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
 * Google Maps place URL for the practice (official listing).
 *
 * @return string
 */
function lubben_vet_maps_link_url() {
	return 'https://www.google.com/maps/place/Lubben+Veterinary+Service,+LLC/@40.9878424,-96.1641287,17z/data=!4m15!1m8!3m7!1s0x87940e6525d53eb9:0x61ed8483e726489!2s1276+Sand+Hill+Rd+STE+1,+Louisville,+NE+68037!3b1!8m2!3d40.9878424!4d-96.1641287!16s%2Fg%2F11kc4d56_w!3m5!1s0x87940e639d55b131:0x2169c548e13a5336!8m2!3d40.9878424!4d-96.1641287!16s%2Fg%2F11cl_g3ws8';
}

/**
 * Map iframe embed URL — same coordinates as lubben_vet_maps_link_url().
 *
 * Legacy `output=embed` Google URLs often show “Place info couldn’t load”; use Embed API view
 * mode when `LUBBEN_GOOGLE_MAPS_EMBED_API_KEY` is defined in wp-config.php, otherwise OSM.
 *
 * @return string
 */
function lubben_vet_maps_embed_url() {
	$lat  = '40.9878424';
	$lng  = '-96.1641287';
	$zoom = '17';

	if ( defined( 'LUBBEN_GOOGLE_MAPS_EMBED_API_KEY' ) && LUBBEN_GOOGLE_MAPS_EMBED_API_KEY ) {
		return add_query_arg(
			array(
				'key'    => LUBBEN_GOOGLE_MAPS_EMBED_API_KEY,
				'center' => $lat . ',' . $lng,
				'zoom'   => $zoom,
			),
			'https://www.google.com/maps/embed/v1/view'
		);
	}

	// ~500 m around the clinic (min_lon,min_lat,max_lon,max_lat); marker is lat,lon per OSM embed.
	$bbox = '-96.1665,40.9863,-96.1617,40.9894';

	return 'https://www.openstreetmap.org/export/embed.html?bbox=' . rawurlencode( $bbox ) . '&layer=mapnik&marker=' . rawurlencode( $lat . ',' . $lng );
}

/**
 * Office hours labels → lines (unescaped values).
 *
 * Labels/values use en dashes per docs/03-content-migration.md §Content to keep verbatim.
 *
 * @return array<string, string>
 */
function get_lubben_hours() {
	$data = array(
		__( 'Monday–Friday', 'lubben-vet' ) => __( '7am–6pm', 'lubben-vet' ),
		__( 'Saturday', 'lubben-vet' )      => __( '8am–12pm — please call ahead to confirm we are in the office', 'lubben-vet' ),
		__( 'Sunday', 'lubben-vet' )        => __( 'Closed', 'lubben-vet' ),
	);

	return apply_filters( 'lubben_vet_hours', $data );
}

/**
 * After-hours emergency line digits (Dr. Lubben cell — not echoed in HTML).
 *
 * @return string
 */
function lubben_vet_emergency_phone_digits() {
	$digits = '4022978315';

	return apply_filters( 'lubben_vet_emergency_phone_digits', $digits );
}

/**
 * Obfuscated payload for front-end emergency phone decode (not the raw number).
 *
 * @return int[]
 */
function lubben_vet_emergency_phone_payload() {
	$payload = array_map(
		static function ( $char ) {
			return ord( $char ) + 17;
		},
		str_split( lubben_vet_emergency_phone_digits() )
	);

	return apply_filters( 'lubben_vet_emergency_phone_payload', $payload );
}

/**
 * After-hours lead copy (no phone number).
 *
 * @return string
 */
function lubben_vet_after_hours_lead() {
	$text = __( 'After-hours emergencies: contact Dr. Lubben directly.', 'lubben-vet' );

	return apply_filters( 'lubben_vet_after_hours_lead', $text );
}

/**
 * After-hours / emergency line copy (unescaped).
 *
 * @deprecated Use lubben_vet_after_hours_lead() and lubben_vet_render_after_hours_emergency().
 * @return string
 */
function lubben_vet_after_hours_note() {
	return lubben_vet_after_hours_lead();
}

/**
 * Emergency contact trigger + modal markup (number revealed via JS only).
 *
 * @param array<string, string> $args Optional wrapper tag/class overrides.
 */
function lubben_vet_render_after_hours_emergency( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'tag'   => 'p',
			'class' => 'after-hours-emergency',
		)
	);

	$tag = tag_escape( $args['tag'] );
	?>
	<<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- tag_escape(). ?> class="<?php echo esc_attr( $args['class'] ); ?>">
		<span class="after-hours-emergency__lead"><?php echo esc_html( lubben_vet_after_hours_lead() ); ?></span>
		<button type="button" class="btn btn--secondary after-hours-emergency__trigger" data-emergency-trigger>
			<?php esc_html_e( 'Emergency contact', 'lubben-vet' ); ?>
		</button>
	</<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php
}

/**
 * One shared modal shell; phone digits injected on open in emergency-contact.js.
 */
function lubben_vet_print_emergency_contact_modal() {
	?>
	<div class="emergency-modal" id="lubben-emergency-modal" hidden>
		<div class="emergency-modal__backdrop" data-emergency-close tabindex="-1" aria-hidden="true"></div>
		<div
			class="emergency-modal__dialog"
			role="dialog"
			aria-modal="true"
			aria-labelledby="lubben-emergency-modal-title"
			aria-describedby="lubben-emergency-modal-body"
		>
			<button type="button" class="emergency-modal__close" data-emergency-close aria-label="<?php esc_attr_e( 'Close', 'lubben-vet' ); ?>">&times;</button>
			<h2 class="emergency-modal__title" id="lubben-emergency-modal-title"><?php esc_html_e( 'After-hours emergency', 'lubben-vet' ); ?></h2>
			<p class="emergency-modal__body" id="lubben-emergency-modal-body">
				<?php esc_html_e( 'For an active animal emergency, call Dr. Lubben directly:', 'lubben-vet' ); ?>
			</p>
			<p class="emergency-modal__number" data-emergency-number hidden></p>
			<p class="emergency-modal__actions">
				<a class="btn btn--primary" href="#" data-emergency-call hidden><?php esc_html_e( 'Call now', 'lubben-vet' ); ?></a>
			</p>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'lubben_vet_print_emergency_contact_modal' );

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
 * Online pharmacy store URL (external).
 *
 * @return string
 */
function get_lubben_pharmacy_url() {
	$url = 'https://lubbenveterinary.myvetstoreonline.pharmacy';

	return apply_filters( 'lubben_vet_pharmacy_url', $url );
}

/**
 * Default staff records when the About page has no saved staff meta.
 *
 * @return array<int, array<string, int|string>>
 */
function lubben_vet_default_staff() {
	return array(
		array(
			'name'     => 'Michaela Nielsen',
			'role'     => __( 'Office Manager', 'lubben-vet' ),
			'bio'      => __( 'Office manager for Lubben Veterinary Services. Scheduling, records, and making sure your visit goes smoothly; more after intake.', 'lubben-vet' ),
			'photo_id' => 0,
		),
		array(
			'name'     => 'Candy Damme',
			'role'     => __( 'Staff', 'lubben-vet' ),
			'bio'      => __( 'Part of our client and patient care team. Personal bio coming after intake.', 'lubben-vet' ),
			'photo_id' => 0,
		),
		array(
			'name'     => 'LeAnn Burger',
			'role'     => __( 'Staff', 'lubben-vet' ),
			'bio'      => __( 'Part of our client and patient care team. Personal bio coming after intake.', 'lubben-vet' ),
			'photo_id' => 0,
		),
	);
}

/**
 * Staff records for About page cards.
 *
 * @param int $post_id About page ID; inferred from template when 0.
 * @return array<int, array<string, int|string>>
 */
function get_lubben_staff( $post_id = 0 ) {
	if ( $post_id <= 0 && function_exists( 'lubben_vet_page_fields_post_id' ) ) {
		$post_id = lubben_vet_page_fields_post_id( 'about' );
	}

	$key = 'lubben_vet_about_staff';

	if ( $post_id > 0 && function_exists( 'lubben_vet_get_page_field_repeater' ) ) {
		if ( ! lubben_vet_page_meta_is_set( $post_id, $key ) ) {
			$data = lubben_vet_default_staff();
		} else {
			$data = lubben_vet_get_page_field_repeater( $key, $post_id );
		}
	} else {
		$data = lubben_vet_default_staff();
	}

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

/**
 * URL for a bundled SVG logo.
 *
 * @param string $variant `default` field mark on light UI; `on-primary` light artwork on primary;
 *                        `footer` full-color mark on white (1c).
 * @return string
 */
function lubben_vet_logo_url( $variant = 'default' ) {
	switch ( $variant ) {
		case 'on-primary':
			$file = 'lubben-vet-logo-2026-1b.svg';
			break;
		case 'footer':
			$file = 'lubben-vet-logo-2026-1c.svg';
			break;
		default:
			$file = 'lubben-vet-logo-2026-1.svg';
			break;
	}

	return get_template_directory_uri() . '/assets/images/' . $file;
}

/**
 * Whether nav/footer use wordmark + lockup (Home page field; default on after client sign-off).
 *
 * @return bool
 */
function lubben_vet_logo_uses_wordmark_lockup() {
	if ( function_exists( 'lubben_vet_page_fields_post_id' ) && function_exists( 'lubben_vet_page_meta_is_set' ) ) {
		$post_id = lubben_vet_page_fields_post_id( 'home' );
		if ( $post_id > 0 && lubben_vet_page_meta_is_set( $post_id, 'lubben_vet_logo_wordmark_lockup' ) ) {
			return (bool) get_post_meta( $post_id, 'lubben_vet_logo_wordmark_lockup', true );
		}
	}

	return true;
}

/**
 * Header and footer logo URLs for the active branding option.
 *
 * @return array{header: string, footer: string}
 */
function lubben_vet_nav_logo_urls() {
	static $urls = null;

	if ( null !== $urls ) {
		return $urls;
	}

	$base = get_template_directory_uri() . '/assets/images/';

	if ( lubben_vet_logo_uses_wordmark_lockup() ) {
		$urls = array(
			'header' => $base . 'lubben-vet-logo-2026-words-1.svg',
			'footer' => $base . 'lubben-vet-logo-2026-1d.svg',
		);
	} else {
		$urls = array(
			'header' => $base . 'lubben-vet-logo-2026-2.svg',
			'footer' => $base . 'lubben-vet-logo-2026-2.svg',
		);
	}

	return $urls;
}

/**
 * Logo img `src` for header.
 *
 * @return string
 */
function lubben_vet_header_logo_src() {
	return lubben_vet_nav_logo_urls()['header'];
}

/**
 * Logo img `src` for footer.
 *
 * @return string
 */
function lubben_vet_footer_logo_src() {
	return lubben_vet_nav_logo_urls()['footer'];
}
