<?php
/**
 * Site footer — practice info, hours, links (docs/01-information-architecture.md).
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

$address_line  = lubben_vet_format_address_line();
$maps_url      = lubben_vet_maps_link_url();
$pharmacy_url  = 'https://lubbenveterinary.myvetstoreonline.pharmacy';
$hours         = get_lubben_hours();
?>
<footer class="site-footer" role="contentinfo">
	<div class="site-footer__inner container">
		<div class="site-footer__grid">
			<div>
				<div class="site-footer__brand">
					<img src="<?php echo esc_url( lubben_vet_logo_url( 'footer' ) ); ?>" alt="" width="280" height="124" class="site-footer__logo" decoding="async" />
					<span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span>
				</div>
				<p class="site-footer__mission"><?php esc_html_e( 'Providing quality veterinary care to all of God\'s creatures great and small.', 'lubben-vet' ); ?></p>
				<p>
					<a href="<?php echo esc_url( $maps_url ); ?>"><?php echo esc_html( $address_line ); ?></a><br>
					<a href="<?php echo esc_url( get_lubben_phone_tel() ); ?>"><?php echo esc_html( get_lubben_phone() ); ?></a>
				</p>
			</div>
			<div>
				<div class="site-footer__title"><?php esc_html_e( 'Hours', 'lubben-vet' ); ?></div>
				<ul class="visit-us__hours-list">
					<?php foreach ( $hours as $label => $value ) : ?>
						<li><strong><?php echo esc_html( $label ); ?>:</strong> <?php echo esc_html( $value ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p><?php echo esc_html( lubben_vet_after_hours_note() ); ?></p>
			</div>
			<div>
				<div class="site-footer__title"><?php esc_html_e( 'Quick links', 'lubben-vet' ); ?></div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'site-footer__links',
						'depth'          => 1,
						'fallback_cb'    => 'lubben_vet_footer_menu_fallback',
					)
				);
				?>
			</div>
		</div>
	</div>
	<div class="site-footer__bottom container">
		<p>&copy; <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> <?php esc_html_e( 'Lubben Veterinary Services LLC', 'lubben-vet' ); ?></p>
	</div>
</footer>
