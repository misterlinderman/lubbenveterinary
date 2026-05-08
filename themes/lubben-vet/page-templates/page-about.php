<?php
/**
 * Template Name: About — Lubben Vet
 * About page with stable anchors (docs/01-information-architecture.md).
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
			<p class="page__tagline"><?php esc_html_e( 'Our practice, our doctor, and the people who make your visit welcoming.', 'lubben-vet' ); ?></p>
		</header>
		<div class="page__content">
			<?php the_content(); ?>
		</div>
		<?php
	endwhile;
	?>

	<div class="about-sections">
		<section class="about-section" id="practice">
			<h2><?php esc_html_e( 'Our Practice', 'lubben-vet' ); ?></h2>
			<p>
				<?php esc_html_e( 'Lubben Veterinary Services LLC was formed in 2016. Dr. Scott Lubben is the owner and sole veterinarian in the practice. Dr. Lubben has served the Cass County area for over three decades. Previously working in a mixed animal practice in the Plattsmouth area, he has fulfilled the needs of our area with his farm and home mobile practice.', 'lubben-vet' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'With the addition of the new facilities in Louisville, he has expanded his practice to include small animal surgeries and advanced medicine. He is able to handle all of your animal care needs, including after hours. For animal emergencies, call the office number 402-234-1054 and you will be instructed on how to reach Dr. Lubben.', 'lubben-vet' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'We welcome the opportunity to serve you and your animal family in our new home.', 'lubben-vet' ); ?>
			</p>
		</section>

		<section class="about-section" id="dr-lubben">
			<h2><?php esc_html_e( 'Dr. Scott Lubben, DVM', 'lubben-vet' ); ?></h2>
			<p>
				<?php esc_html_e( 'Lubben Veterinary Services LLC is only the latest in Dr. Lubben\'s veterinary service to Cass, Sarpy, Otoe, and Saunders counties. After graduation he served as a mixed animal practitioner at Plattsmouth Animal Hospital for 20 years and the next six years as the only large animal veterinarian in Cass County. Dr. Lubben has opened the Louisville office to better serve the local and surrounding areas.', 'lubben-vet' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'As a native of southeast Nebraska, he understands the needs and concerns of all large animal and pet owners. Dr. Lubben grew up on a farm in southeast Nebraska. He graduated with his DVM from Kansas State University in May of 1990. Dr. Lubben and his wife Karen were married in 1986 and have three children: Angie (EJ) Buglewicz, Matt (Lauren), and Jeremiah.', 'lubben-vet' ); ?>
			</p>
			<blockquote class="about-pullquote" cite="<?php echo esc_url( home_url( '/' ) ); ?>">
				<p><?php esc_html_e( 'Providing quality veterinary care to all of God\'s creatures great and small.', 'lubben-vet' ); ?></p>
			</blockquote>
		</section>

		<section class="about-section" id="our-staff">
			<h2><?php esc_html_e( 'Our Staff', 'lubben-vet' ); ?></h2>
			<div class="staff-grid">
				<?php foreach ( get_lubben_staff() as $member ) : ?>
					<div class="staff-card">
						<div class="staff-card__photo">
							<?php
							$photo_id = isset( $member['photo_id'] ) ? absint( $member['photo_id'] ) : 0;
							if ( $photo_id ) {
								echo wp_get_attachment_image(
									$photo_id,
									'lubben-card',
									false,
									array( 'alt' => $member['name'] )
								);
							} else {
								echo '<span class="staff-card__initials">' . esc_html( lubben_vet_staff_initials( $member['name'] ) ) . '</span>';
							}
							?>
						</div>
						<h3 class="staff-card__name"><?php echo esc_html( $member['name'] ); ?></h3>
						<div class="staff-card__role"><?php echo esc_html( $member['role'] ); ?></div>
						<p><?php echo esc_html( $member['bio'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="about-section">
			<h2><?php esc_html_e( 'Have questions? Get in touch.', 'lubben-vet' ); ?></h2>
			<p><a class="btn btn--primary" href="<?php echo esc_url( home_url( '/contact/#appointment-form' ) ); ?>"><?php esc_html_e( 'Contact / appointment form', 'lubben-vet' ); ?></a></p>
		</section>
	</div>
</article>
<?php
get_footer();
