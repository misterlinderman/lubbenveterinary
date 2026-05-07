<?php
/**
 * Fallback template — used only if no more specific template matches.
 *
 * In practice on this site, page.php / front-page.php / 404.php / the
 * page-templates/* files cover every route. This file exists because
 * WordPress requires it.
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<article class="page page--fallback">
	<div class="container">
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
	</div>
</article>
<?php
get_footer();
