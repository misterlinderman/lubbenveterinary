<?php
/**
 * Archive template (blog off at launch; supported for later use).
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="page container">
	<header class="page__header">
		<h1 class="page__title"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="page__content">', '</div>' ); ?>
	</header>
	<?php if ( have_posts() ) : ?>
		<ul>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php
			endwhile;
			?>
		</ul>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing here yet.', 'lubben-vet' ); ?></p>
	<?php endif; ?>
</section>
<?php
get_footer();
