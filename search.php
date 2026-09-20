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
				?>
				<article id="post-<?php the_ID(); ?>" class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition duration-200">
					<h2 class="text-lg font-bold mb-3 leading-tight"><a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-indigo-600 transition-colors"><?php the_title(); ?></a></h2>
					<div class="text-sm text-gray-600 flex-grow line-clamp-3 mb-4"><?php the_excerpt(); ?></div>
					<a href="<?php the_permalink(); ?>" class="mt-auto inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">View Details &rarr;</a>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<div class="mt-12 flex justify-center">
			<?php the_posts_pagination(); ?>
		</div>
	<?php else : ?>
		<div class="text-center py-12">
			<h2 class="text-2xl font-bold text-gray-900 mb-6">No results found</h2>
			<div class="max-w-md mx-auto">
				<?php get_search_form(); ?>
			</div>
		</div>
	<?php endif; ?>
</main>

<?php
get_footer();
