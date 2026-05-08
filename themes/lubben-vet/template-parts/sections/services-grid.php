<?php /** Services grid — docs/01-information-architecture.md §Home; icons per docs/02-design-system.md. */ ?>
<?php
defined( 'ABSPATH' ) || exit;

$services = array(
	array(
		'title' => __( 'Small Animal Care', 'lubben-vet' ),
		'text'  => __( 'Exams, vaccinations, dental, and wellness for dogs and cats.', 'lubben-vet' ),
		'icon'  => 'paw',
	),
	array(
		'title' => __( 'Large Animal & Mobile Service', 'lubben-vet' ),
		'text'  => __( 'Farm and home calls across Cass, Sarpy, Otoe, and Saunders counties.', 'lubben-vet' ),
		'icon'  => 'tractor',
	),
	array(
		'title' => __( 'Surgery & Advanced Medicine', 'lubben-vet' ),
		'text'  => __( 'performed in our Louisville clinic.', 'lubben-vet' ),
		'icon'  => 'stethoscope',
	),
	array(
		'title' => __( 'After-Hours Emergencies', 'lubben-vet' ),
		'text'  => __( 'call 402-234-1054 day or night.', 'lubben-vet' ),
		'icon'  => 'alert',
	),
);
?>
<section class="section-services">
	<div class="container">
		<div class="services-grid__heading">
			<h2><?php esc_html_e( 'What we do', 'lubben-vet' ); ?></h2>
			<p><?php esc_html_e( 'Mixed animal care — in the clinic and on your place.', 'lubben-vet' ); ?></p>
		</div>
		<div class="services-grid">
			<?php foreach ( $services as $service ) : ?>
				<article class="service-card">
					<div class="service-card__icon" aria-hidden="true">
						<?php echo lubben_vet_icon( $service['icon'] ); ?>
					</div>
					<h3 class="service-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
					<p class="service-card__text"><?php echo esc_html( $service['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
