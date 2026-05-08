<?php /** Pharmacy CTA — see docs/01-information-architecture.md (Home). */ ?>
<?php
defined( 'ABSPATH' ) || exit;

$pharmacy_url = 'https://lubbenveterinary.myvetstoreonline.pharmacy';
?>
<section class="section-pharmacy-cta">
	<div class="container pharmacy-cta">
		<div class="pharmacy-cta__text">
			<h2 class="pharmacy-cta__title"><?php esc_html_e( 'Shop Our Online Pharmacy', 'lubben-vet' ); ?></h2>
			<p>
				<?php esc_html_e( 'Order prescription diets, heartworm and flea prevention, and other trusted products for convenient home delivery.', 'lubben-vet' ); ?>
			</p>
		</div>
		<a class="btn btn--primary" href="<?php echo esc_url( $pharmacy_url ); ?>" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'Open pharmacy', 'lubben-vet' ); ?></a>
	</div>
</section>
