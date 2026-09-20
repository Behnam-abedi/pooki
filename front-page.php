<?php
/**
 * The front page template file
 *
 * @package Pooki
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php get_template_part( 'template-parts/components/hero/main' ); ?>
	<?php get_template_part( 'template-parts/components/home/featured-products' ); ?>
</main>

<?php
get_footer();
