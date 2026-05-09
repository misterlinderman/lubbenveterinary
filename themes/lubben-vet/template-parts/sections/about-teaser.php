<?php /** About teaser — see docs/01-information-architecture.md (Home). */ ?>
<?php
defined( 'ABSPATH' ) || exit;

$teaser_img = absint( get_theme_mod( 'lubben_vet_about_teaser_image', 0 ) );

$heading   = trim( (string) get_theme_mod( 'lubben_vet_about_teaser_heading', '' ) );
$p1        = trim( (string) get_theme_mod( 'lubben_vet_about_teaser_p1', '' ) );
$p2        = trim( (string) get_theme_mod( 'lubben_vet_about_teaser_p2', '' ) );
$cta_label = trim( (string) get_theme_mod( 'lubben_vet_about_teaser_cta_label', '' ) );
$cta_url   = trim( (string) get_theme_mod( 'lubben_vet_about_teaser_cta_url', '' ) );

if ( '' === $heading ) {
	$heading = __( 'About Our Practice', 'lubben-vet' );
}
if ( '' === $p1 ) {
	$p1 = __( 'Lubben Veterinary Services LLC was formed in 2016. Dr. Scott Lubben is the owner and sole veterinarian in this mixed animal practice, serving Cass County and southeast Nebraska with in-clinic care and farm and home mobile service.', 'lubben-vet' );
}
if ( '' === $p2 ) {
	$p2 = __( 'Feel free to stop in and meet our wonderful staff and visit our new office south of Louisville near the water tower.', 'lubben-vet' );
}
if ( '' === $cta_label ) {
	$cta_label = __( 'Meet Dr. Lubben', 'lubben-vet' );
}

$cta_href = $cta_url ? esc_url_raw( $cta_url ) : '';
if ( '' === $cta_href ) {
	$cta_href = home_url( '/about/#dr-lubben' );
}
?>
<section class="section-about-teaser">
	<div class="container about-teaser">
		<div>
			<h2><?php echo esc_html( $heading ); ?></h2>
			<p><?php echo esc_html( $p1 ); ?></p>
			<p><?php echo esc_html( $p2 ); ?></p>
			<p><a class="btn btn--tertiary" href="<?php echo esc_url( $cta_href ); ?>"><?php echo esc_html( $cta_label ); ?></a></p>
		</div>
		<div
			class="about-teaser__media<?php echo $teaser_img ? '' : ' about-teaser__placeholder'; ?>"
			<?php echo $teaser_img ? '' : ' role="presentation"'; ?>
		>
			<?php
			if ( $teaser_img ) {
				$alt = get_post_meta( $teaser_img, '_wp_attachment_image_alt', true );
				if ( ! is_string( $alt ) ) {
					$alt = '';
				}
				lubben_vet_the_attachment_picture(
					$teaser_img,
					'large',
					array(
						'class'    => 'about-teaser__image',
						'loading'  => 'lazy',
						'decoding' => 'async',
						'alt'      => $alt,
					)
				);
			}
			?>
		</div>
	</div>
</section>
