<?php
/**
 * Single post template (blog off at launch; supported for later use).
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
			<p><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
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
