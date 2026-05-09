<?php /** Visit us — see docs/01-information-architecture.md (Home). */ ?>
<?php
defined( 'ABSPATH' ) || exit;

$appointment_url = home_url( '/contact/#appointment-form' );
$address_line    = lubben_vet_format_address_line();
$hours           = get_lubben_hours();
$embed           = lubben_vet_maps_embed_url();

$visit_heading = trim( (string) get_theme_mod( 'lubben_vet_visit_heading', '' ) );
if ( '' === $visit_heading ) {
	$visit_heading = __( 'Visit us', 'lubben-vet' );
}
?>
<section class="section-visit-us">
	<div class="container visit-us">
		<div>
			<h2><?php echo esc_html( $visit_heading ); ?></h2>
			<p><a href="<?php echo esc_url( lubben_vet_maps_link_url() ); ?>"><?php echo esc_html( $address_line ); ?></a></p>
			<ul class="visit-us__hours-list">
				<?php foreach ( $hours as $label => $value ) : ?>
					<li><strong><?php echo esc_html( $label ); ?>:</strong> <?php echo esc_html( $value ); ?></li>
				<?php endforeach; ?>
			</ul>
			<p><?php echo esc_html( lubben_vet_after_hours_note() ); ?></p>
			<p><a class="btn btn--primary" href="<?php echo esc_url( $appointment_url ); ?>"><?php esc_html_e( 'Request an Appointment', 'lubben-vet' ); ?></a></p>
		</div>
		<div class="visit-us__map">
			<iframe
				title="<?php esc_attr_e( 'Map of Lubben Veterinary Services', 'lubben-vet' ); ?>"
				src="<?php echo esc_url( $embed ); ?>"
				loading="lazy"
				referrerpolicy="no-referrer-when-downgrade"
				allowfullscreen
			></iframe>
		</div>
	</div>
</section>
