<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Pooki
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-24 max-w-3xl text-center">
	<?php get_template_part( 'template-parts/content/content', '404' ); ?>
</main>

<?php
get_footer();
