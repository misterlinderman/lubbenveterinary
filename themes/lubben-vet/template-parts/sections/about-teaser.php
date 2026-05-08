<?php /** About teaser — see docs/01-information-architecture.md (Home). */ ?>
<?php
defined( 'ABSPATH' ) || exit;
?>
<section class="section-about-teaser">
	<div class="container about-teaser">
		<div>
			<h2><?php esc_html_e( 'About Our Practice', 'lubben-vet' ); ?></h2>
			<p>
				<?php esc_html_e( 'Lubben Veterinary Services LLC was formed in 2016. Dr. Scott Lubben is the owner and sole veterinarian in this mixed animal practice, serving Cass County and southeast Nebraska with in-clinic care and farm and home mobile service.', 'lubben-vet' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Feel free to stop in and meet our wonderful staff and visit our new office south of Louisville near the water tower.', 'lubben-vet' ); ?>
			</p>
			<p><a class="btn btn--tertiary" href="<?php echo esc_url( home_url( '/about/#dr-lubben' ) ); ?>"><?php esc_html_e( 'Meet Dr. Lubben', 'lubben-vet' ); ?></a></p>
		</div>
		<div class="about-teaser__media about-teaser__placeholder" role="presentation"></div>
	</div>
</section>
