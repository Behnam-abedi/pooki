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
			?>
			<h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 text-center"><?php the_title(); ?></h1>
			<div class="pooki-page-content text-gray-700 leading-relaxed space-y-6">
				<?php the_content(); ?>
			</div>
			<?php
		endwhile;
	endif;
	?>
</main>

<?php
get_footer();
