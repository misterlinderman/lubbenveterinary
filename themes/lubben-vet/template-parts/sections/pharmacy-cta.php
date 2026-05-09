<?php /** Pharmacy CTA — docs/03-content-migration.md §Content to elevate. */ ?>
<?php
defined( 'ABSPATH' ) || exit;

$title_raw = trim( (string) get_theme_mod( 'lubben_vet_pharmacy_title', '' ) );
$body_raw  = trim( (string) get_theme_mod( 'lubben_vet_pharmacy_body', '' ) );
$btn_raw   = trim( (string) get_theme_mod( 'lubben_vet_pharmacy_button', '' ) );
$url_raw   = trim( (string) get_theme_mod( 'lubben_vet_pharmacy_url', '' ) );

$title = '' !== $title_raw ? $title_raw : __( 'Shop Our Online Pharmacy', 'lubben-vet' );
$body  = '' !== $body_raw
	? $body_raw
	: __( 'Order food, prescriptions, and trusted supplies for your animals. Home delivery is available through our online pharmacy partner.', 'lubben-vet' );
$btn   = '' !== $btn_raw ? $btn_raw : __( 'Open pharmacy', 'lubben-vet' );

$pharmacy_url = '' !== $url_raw ? esc_url_raw( $url_raw ) : 'https://lubbenveterinary.myvetstoreonline.pharmacy';
?>
<section class="section-pharmacy-cta">
	<div class="container pharmacy-cta">
		<div class="pharmacy-cta__text">
			<h2 class="pharmacy-cta__title"><?php echo esc_html( $title ); ?></h2>
			<p><?php echo esc_html( $body ); ?></p>
		</div>
		<a class="btn btn--primary" href="<?php echo esc_url( $pharmacy_url ); ?>" rel="noopener noreferrer" target="_blank"><?php echo esc_html( $btn ); ?></a>
	</div>
</section>
