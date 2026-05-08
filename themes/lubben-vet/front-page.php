<?php
/**
 * Front page — composes homepage sections (docs/prompts/03-page-templates.md).
 *
 * @package Lubben_Vet
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<!-- front-page: theme-driven sections; editable intro can be added later via a child page if needed. -->
<?php
get_template_part( 'template-parts/sections/hero' );
get_template_part( 'template-parts/sections/about-teaser' );
get_template_part( 'template-parts/sections/services-grid' );
get_template_part( 'template-parts/sections/pharmacy-cta' );
get_template_part( 'template-parts/sections/visit-us' );
?>
<?php
get_footer();
