<?php
/**
 * The template for displaying search results pages
 *
 * @package Pooki
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-12 max-w-7xl">
	<header class="page-header mb-10 text-center">
		<h1 class="text-3xl font-bold text-gray-900">Search Results for: <span class="text-indigo-600"><?php echo get_search_query(); ?></span></h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="search-results-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', 'search' );
			endwhile;
			?>
		</div>
		<div class="mt-12 flex justify-center">
			<?php the_posts_pagination(); ?>
		</div>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
	<?php endif; ?>
</main>

<?php
get_footer();
