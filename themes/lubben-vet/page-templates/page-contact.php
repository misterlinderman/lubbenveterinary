<?php
/**
 * Template Name: Contact — Lubben Vet
 * Contact & hours (docs/01-information-architecture.md).
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<article <?php post_class( 'page container' ); ?>>
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="page__header">
			<h1 class="page__title"><?php the_title(); ?></h1>
		</header>
		<div class="page__content">
			<?php the_content(); ?>
		</div>
		<?php
	endwhile;
	?>

	<section class="contact-hours" id="hours">
		<h2><?php esc_html_e( 'Hours', 'lubben-vet' ); ?></h2>
		<ul class="visit-us__hours-list">
			<?php foreach ( get_lubben_hours() as $label => $value ) : ?>
				<li><strong><?php echo esc_html( $label ); ?>:</strong> <?php echo esc_html( $value ); ?></li>
			<?php endforeach; ?>
		</ul>
		<p><?php echo esc_html( lubben_vet_after_hours_note() ); ?></p>
	</section>

	<section class="contact-visit" id="visit">
		<h2><?php esc_html_e( 'Visit / map', 'lubben-vet' ); ?></h2>
		<p><a href="<?php echo esc_url( lubben_vet_maps_link_url() ); ?>"><?php echo esc_html( lubben_vet_format_address_line() ); ?></a></p>
		<div class="visit-us__map">
			<iframe
				title="<?php esc_attr_e( 'Map of Lubben Veterinary Services', 'lubben-vet' ); ?>"
				src="<?php echo esc_url( lubben_vet_maps_embed_url() ); ?>"
				loading="lazy"
				referrerpolicy="no-referrer-when-downgrade"
				allowfullscreen
			></iframe>
		</div>
	</section>

	<section class="appointment-form" id="appointment-form">
		<h2><?php esc_html_e( 'Request an Appointment', 'lubben-vet' ); ?></h2>
		<p><?php esc_html_e( 'We\'ll get back to you within one business day. For after-hours emergencies, please call 402-234-1054.', 'lubben-vet' ); ?></p>
		<?php lubben_vet_render_contact_form(); ?>
	</section>
</article>
<?php
get_footer();
