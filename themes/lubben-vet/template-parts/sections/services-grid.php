<?php /** Services grid — docs/01-information-architecture.md §Home. */ ?>
<?php
defined( 'ABSPATH' ) || exit;

$defaults = array(
	array(
		'title' => __( 'Small Animal Care', 'lubben-vet' ),
		'text'  => __( 'Exams, vaccinations, dental, and wellness for dogs and cats.', 'lubben-vet' ),
	),
	array(
		'title' => __( 'Large Animal & Mobile Service', 'lubben-vet' ),
		'text'  => __( 'Farm and home calls across Cass, Sarpy, Otoe, and Saunders counties.', 'lubben-vet' ),
	),
	array(
		'title' => __( 'Surgery & Advanced Medicine', 'lubben-vet' ),
		'text'  => __( 'performed in our Louisville clinic.', 'lubben-vet' ),
	),
	array(
		'title' => __( 'After-Hours Emergencies', 'lubben-vet' ),
		'text'  => __( 'call 402-234-1054 day or night.', 'lubben-vet' ),
	),
);

$services = array();
for ( $i = 0; $i < 4; $i++ ) {
	$n       = $i + 1;
	$def     = $defaults[ $i ];
	$title_t = trim( (string) get_theme_mod( "lubben_vet_service_{$n}_title", '' ) );
	$text_t  = trim( (string) get_theme_mod( "lubben_vet_service_{$n}_text", '' ) );

	$services[] = array(
		'title' => '' !== $title_t ? $title_t : $def['title'],
		'text'  => '' !== $text_t ? $text_t : $def['text'],
	);
}

$section_heading = trim( (string) get_theme_mod( 'lubben_vet_services_heading', '' ) );
$section_intro   = trim( (string) get_theme_mod( 'lubben_vet_services_intro', '' ) );
if ( '' === $section_heading ) {
	$section_heading = __( 'What we do', 'lubben-vet' );
}
if ( '' === $section_intro ) {
	$section_intro = __( 'Mixed animal care — in the clinic and on your place.', 'lubben-vet' );
}
?>
<section class="section-services">
	<div class="container">
		<div class="services-grid__heading">
			<h2><?php echo esc_html( $section_heading ); ?></h2>
			<p><?php echo esc_html( $section_intro ); ?></p>
		</div>
		<div class="services-grid">
			<?php foreach ( $services as $service ) : ?>
				<article class="service-card">
					<h3 class="service-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
					<p class="service-card__text"><?php echo esc_html( $service['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
