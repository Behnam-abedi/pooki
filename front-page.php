<?php
/**
 * The front page template file
 *
 * @package Pooki
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	
	// Legacy fallbacks if no block content exists
	if ( ! has_blocks() ) {
		get_template_part( 'template-parts/components/hero/slider' );
		get_template_part( 'template-parts/components/hero/main' );
		get_template_part( 'template-parts/components/home/featured-products' );
	}
	?>
</main>

<?php
get_footer();
