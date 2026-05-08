<?php
/**
 * Default page template.
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
</article>
<?php
get_footer();
