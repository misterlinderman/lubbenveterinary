<?php /** Hero section — see docs/01-information-architecture.md (Home). */ ?>
<?php
defined( 'ABSPATH' ) || exit;

$appointment_url = home_url( '/contact/#appointment-form' );
$hero_id         = absint( get_theme_mod( 'lubben_vet_hero_image', 0 ) );
?>
<section class="hero" aria-label="<?php esc_attr_e( 'Welcome', 'lubben-vet' ); ?>">
	<div class="hero__media">
		<?php
		if ( $hero_id ) {
			$alt = get_post_meta( $hero_id, '_wp_attachment_image_alt', true );
			if ( ! is_string( $alt ) ) {
				$alt = '';
			}
			lubben_vet_the_attachment_picture(
				$hero_id,
				'lubben-hero',
				array(
					'class'         => 'hero__image',
					'fetchpriority' => 'high',
					'loading'       => 'eager',
					'alt'           => $alt,
					'decoding'      => 'async',
				)
			);
		} else {
			$webp_path = get_theme_file_path( 'assets/images/hero-default.webp' );
			$jpg       = get_theme_file_uri( 'assets/images/hero-default.jpg' );
			if ( is_readable( $webp_path ) ) {
				$webp = get_theme_file_uri( 'assets/images/hero-default.webp' );
				?>
				<picture>
					<source type="image/webp" srcset="<?php echo esc_url( $webp ); ?>">
					<img
						class="hero__image"
						src="<?php echo esc_url( $jpg ); ?>"
						alt=""
						width="1920"
						height="900"
						fetchpriority="high"
						loading="eager"
						decoding="async"
					>
				</picture>
				<?php
			} else {
				?>
				<img
					class="hero__image"
					src="<?php echo esc_url( $jpg ); ?>"
					alt=""
					width="1920"
					height="900"
					fetchpriority="high"
					loading="eager"
					decoding="async"
				>
				<?php
			}
		}
		?>
	</div>
	<div class="hero__inner">
		<h1 class="hero__title"><?php esc_html_e( 'Caring for the animals of southeast Nebraska.', 'lubben-vet' ); ?></h1>
		<p class="hero__subtitle"><?php esc_html_e( 'Providing quality veterinary care to all of God\'s creatures great and small.', 'lubben-vet' ); ?></p>
		<div class="hero__actions">
			<a class="btn btn--primary" href="<?php echo esc_url( $appointment_url ); ?>"><?php esc_html_e( 'Request an Appointment', 'lubben-vet' ); ?></a>
			<a class="btn btn--secondary" href="<?php echo esc_url( get_lubben_phone_tel() ); ?>"><?php echo esc_html( sprintf( __( 'Call %s', 'lubben-vet' ), get_lubben_phone() ) ); ?></a>
		</div>
	</div>
</section>
