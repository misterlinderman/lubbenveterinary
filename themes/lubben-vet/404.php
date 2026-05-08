<?php
/**
 * Friendly 404 (docs/01-information-architecture.md; tone docs/03-content-migration.md).
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="not-found container">
	<div class="not-found__inner">
		<h1 class="page__title"><?php esc_html_e( 'We can\'t find that page', 'lubben-vet' ); ?></h1>
		<p><?php esc_html_e( 'Sorry, the page you are looking for is not here. Try the home page, or call us anytime at the number below (including after hours for emergencies).', 'lubben-vet' ); ?></p>
		<p class="not-found__mission"><?php esc_html_e( 'Providing quality veterinary care to all of God\'s creatures great and small.', 'lubben-vet' ); ?></p>
		<div class="not-found__actions">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go home', 'lubben-vet' ); ?></a>
			<a class="btn btn--secondary" href="<?php echo esc_url( get_lubben_phone_tel() ); ?>"><?php echo esc_html( sprintf( __( 'Call %s', 'lubben-vet' ), get_lubben_phone() ) ); ?></a>
		</div>
	</div>
</section>
<?php
get_footer();
