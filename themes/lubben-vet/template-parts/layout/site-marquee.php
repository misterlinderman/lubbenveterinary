<?php /** Homepage announcement bar — Appearance → Customize → Lubben Vet content. */ ?>
<?php
defined( 'ABSPATH' ) || exit;

if ( ! is_front_page() || ! get_theme_mod( 'lubben_vet_marquee_enabled', false ) ) {
	return;
}

$text_raw = get_theme_mod( 'lubben_vet_marquee_text', '' );
$text     = is_string( $text_raw ) ? trim( $text_raw ) : '';
if ( '' === $text ) {
	return;
}

$link_raw = get_theme_mod( 'lubben_vet_marquee_link', '' );
$link     = is_string( $link_raw ) ? esc_url_raw( $link_raw ) : '';
?>
<div class="site-marquee" role="region" aria-label="<?php esc_attr_e( 'Announcement', 'lubben-vet' ); ?>">
	<div class="site-marquee__inner container">
		<?php if ( $link ) : ?>
			<a class="site-marquee__link" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $text ); ?></a>
		<?php else : ?>
			<p class="site-marquee__text"><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
	</div>
</div>
