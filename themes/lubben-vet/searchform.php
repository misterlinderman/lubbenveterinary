<?php
/**
 * Accessible search form (defensive — not shown in primary UI).
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

$uid = wp_unique_id( 'search-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Search for:', 'lubben-vet' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $uid ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
	<button type="submit" class="btn btn--primary">
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'lubben-vet' ); ?></span>
		<span aria-hidden="true"><?php esc_html_e( 'Submit', 'lubben-vet' ); ?></span>
	</button>
</form>
