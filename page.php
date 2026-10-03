<?php
/**
 * The template for displaying all single pages
 *
 * @package Pooki
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-12 max-w-5xl">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/content', 'page' );
		endwhile;
	endif;
	?>
</main>

<?php
get_footer();
