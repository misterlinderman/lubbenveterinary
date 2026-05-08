<?php /** Services grid — see docs/03-content-migration.md (Home). */ ?>
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
		'text'  => __( 'Performed in our Louisville clinic.', 'lubben-vet' ),
		'icon'  => 'stethoscope',
	),
	array(
		'title' => __( 'After-Hours Emergencies', 'lubben-vet' ),
		'text'  => __( 'Call 402-234-1054 day or night.', 'lubben-vet' ),
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
						<?php if ( 'paw' === $service['icon'] ) : ?>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 10c-1.5-2-4.5-2-6 0"/><path d="M7 14c-1.2-1.5-3.5-1-4 1.2-.6 2.3.8 4 3 3.8 1.8-.2 2.6-2.2 2.2-3.6"/><path d="M11 18c0 2 2.5 3 4 1.8 1.8-1.2 1-4-1-4"/><path d="M14 14c1.2-1.5 3.5-1 4 1.2.6 2.3-.8 4-3 3.8-1.8-.2-2.6-2.2-2.2-3.6"/></svg>
						<?php elseif ( 'tractor' === $service['icon'] ) : ?>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 16h-2"/><path d="M10 16h-1"/><path d="M18 15v1a2 2 0 0 1-2 2h-2"/><path d="M4 16.5A2.5 2.5 0 0 1 6.5 14H17"/><path d="M5.5 11 7 7h9l3 4"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
						<?php elseif ( 'stethoscope' === $service['icon'] ) : ?>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.8 4.8v6a4 4 0 0 0 8 0v-6"/><path d="M8 4h.01"/><path d="M12 18a3 3 0 0 0 3-3V9"/><circle cx="15" cy="15" r="3"/></svg>
						<?php else : ?>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v3.5"/><path d="M10.2 4.2 12 2l1.8 2.2"/><path d="M12 15h.01"/><path d="M5.2 18.2 3 16l2.2-2.2"/><path d="M18.8 18.2 21 16l-2.2-2.2"/><circle cx="12" cy="12" r="10"/></svg>
						<?php endif; ?>
					</div>
					<h3 class="service-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
					<p class="service-card__text"><?php echo esc_html( $service['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
