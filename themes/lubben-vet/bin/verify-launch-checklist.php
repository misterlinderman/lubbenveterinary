<?php
/**
 * Verify repo-side expectations from docs/06-launch-checklist.md (automatable only).
 *
 * Run from WordPress root:
 *   wp eval-file wp-content/themes/lubben-vet/bin/verify-launch-checklist.php
 *
 * Checks: legacy 301 map matches the launch doc, core templates exist, search visibility flag.
 * Does not replace: SMTP tests, DNS, Lighthouse, manual browser runs.
 *
 * @package Lubben_Vet
 */

if ( ! function_exists( 'get_template_directory' ) ) {
	return;
}

$theme_dir = get_template_directory();

if ( is_readable( $theme_dir . '/inc/redirects.php' ) ) {
	require_once $theme_dir . '/inc/redirects.php';
}

/**
 * Expected legacy paths and targets — keep in sync with docs/06-launch-checklist.md § Legacy redirects.
 *
 * @return array<string, string>
 */
function lubben_vet_launch_expected_legacy_redirects() {
	return array(
		'welcome.html'     => '/',
		'index.html'       => '/',
		'ourpractice.html' => '/about/#practice',
		'drlubben.html'    => '/about/#dr-lubben',
		'ourstaff.html'    => '/about/#our-staff',
		'page1.html'       => '/contact/#hours',
		'contact.html'     => '/contact/',
	);
}

$fail = false;

$expected = lubben_vet_launch_expected_legacy_redirects();
if ( ! function_exists( 'lubben_vet_legacy_redirect_map' ) ) {
	fwrite( STDERR, "FAIL: lubben_vet_legacy_redirect_map() not defined (inc/redirects.php missing?)\n" );
	$fail = true;
} else {
	$actual = lubben_vet_legacy_redirect_map();
	foreach ( $expected as $legacy => $dest ) {
		if ( ! isset( $actual[ $legacy ] ) ) {
			fwrite( STDERR, "FAIL: redirect map missing key: {$legacy}\n" );
			$fail = true;
			continue;
		}
		if ( $actual[ $legacy ] !== $dest ) {
			fwrite( STDERR, "FAIL: {$legacy} → expected {$dest}, got {$actual[$legacy]}\n" );
			$fail = true;
		}
	}
	foreach ( array_keys( $actual ) as $key ) {
		if ( ! isset( $expected[ $key ] ) ) {
			fwrite( STDERR, "WARN: redirect map has extra key: {$key} (not in launch checklist)\n" );
		}
	}
}

$required_templates = array(
	'404.php',
	'inc/redirects.php',
	'inc/gravity-forms-helpers.php',
	'inc/gravity-forms/contact-form.json',
	'page-templates/page-contact.php',
	'page-templates/page-about.php',
);
foreach ( $required_templates as $rel ) {
	$path = $theme_dir . '/' . $rel;
	if ( ! is_readable( $path ) ) {
		fwrite( STDERR, "FAIL: missing or unreadable: {$rel}\n" );
		$fail = true;
	}
}

$json = $theme_dir . '/inc/gravity-forms/contact-form.json';
if ( is_readable( $json ) ) {
	$raw = file_get_contents( $json );
	$data = is_string( $raw ) ? json_decode( $raw, true ) : null;
	if ( ! is_array( $data ) || ( ! isset( $data[0] ) && ! isset( $data['0'] ) ) ) {
		fwrite( STDERR, "WARN: contact-form.json may be empty or not a Gravity Forms-style export.\n" );
	}
}

// Search engine visibility (Settings → Reading). "0" = discourage (bad for production launch).
$discourage = get_option( 'blog_public' );
if ( '0' === (string) $discourage ) {
	echo "WARN: blog_public is 0 — “Search engine visibility” discourages indexing (OK for staging, not for go-live).\n";
} else {
	echo "OK: blog_public allows indexing (typical production).\n";
}

if ( $fail ) {
	fwrite( STDERR, "\nLaunch checklist verification failed.\n" );
	exit( 1 );
}

echo "OK: legacy redirect map and required theme paths match docs/06-launch-checklist.md.\n";
echo "Next: SMTP, form notification tests, Lighthouse, manual a11y/mobile/browsers, DNS — see checklist.\n";
