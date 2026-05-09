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
		__( 'Saturday', 'lubben-vet' )      => __( '8am–12pm', 'lubben-vet' ),
		__( 'Sunday', 'lubben-vet' )        => __( 'Closed', 'lubben-vet' ),
	);

	return apply_filters( 'lubben_vet_hours', $data );
}

/**
 * After-hours / emergency line copy (unescaped).
 *
 * @return string
 */
function lubben_vet_after_hours_note() {
	$text = __( 'After-hours emergencies: call 402-234-1054 — the office line routes to Dr. Lubben.', 'lubben-vet' );

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
 * Client logo preview: State A — mark (2026-2) in header and footer.
 * State B — wordmark (words-1) in header, full lockup (1d) in footer.
 *
 * @return array{a: array{header: string, footer: string}, b: array{header: string, footer: string}}
 */
function lubben_vet_client_logo_preview_map() {
	static $map = null;

	if ( $map !== null ) {
		return $map;
	}

	$base = get_template_directory_uri() . '/assets/images/';
	$map  = array(
		'a' => array(
			'header' => $base . 'lubben-vet-logo-2026-2.svg',
			'footer' => $base . 'lubben-vet-logo-2026-2.svg',
		),
		'b' => array(
			'header' => $base . 'lubben-vet-logo-2026-words-1.svg',
			'footer' => $base . 'lubben-vet-logo-2026-1d.svg',
		),
	);

	return $map;
}

/**
 * Logo img `src` for header (respects client preview when enabled).
 *
 * @return string
 */
function lubben_vet_header_logo_src() {
	if ( defined( 'LUBBEN_VET_CLIENT_LOGO_PREVIEW' ) && LUBBEN_VET_CLIENT_LOGO_PREVIEW ) {
		return lubben_vet_client_logo_preview_map()['a']['header'];
	}

	return lubben_vet_logo_url( 'on-primary' );
}

/**
 * Logo img `src` for footer (respects client preview when enabled).
 *
 * @return string
 */
function lubben_vet_footer_logo_src() {
	if ( defined( 'LUBBEN_VET_CLIENT_LOGO_PREVIEW' ) && LUBBEN_VET_CLIENT_LOGO_PREVIEW ) {
		return lubben_vet_client_logo_preview_map()['a']['footer'];
	}

	return lubben_vet_logo_url( 'footer' );
}

/**
 * Early inline script: apply saved preview state before paint (avoids flash when possible).
 */
function lubben_vet_print_client_logo_preview_head() {
	if ( ! defined( 'LUBBEN_VET_CLIENT_LOGO_PREVIEW' ) || ! LUBBEN_VET_CLIENT_LOGO_PREVIEW ) {
		return;
	}

	$map = lubben_vet_client_logo_preview_map();
	?>
	<script>
	window.lubbenVetLogoPreview=<?php echo wp_json_encode( $map ); ?>;
	window.lubbenVetLogoPreviewApply=function(s){
		var c=window.lubbenVetLogoPreview;if(!c)return;
		try{
			if(localStorage.getItem('lubbenVetLogoPreview')!=='b')return;
			var el=document.querySelector(s==='header'?'.site-header__logo':'.site-footer__logo');
			if(el)el.src=c.b[s];
		}catch(e){}
	};
	</script>
	<?php
}
add_action( 'wp_head', 'lubben_vet_print_client_logo_preview_head', 2 );
