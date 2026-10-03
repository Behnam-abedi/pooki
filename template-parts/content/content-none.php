<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Pooki
 */

?>
<section class="no-results not-found text-center py-12">
	<header class="page-header mb-6">
		<h1 class="text-2xl font-bold text-gray-900">Nothing Found</h1>
	</header>

	<div class="page-content max-w-md mx-auto text-gray-600">
		<?php if ( is_search() ) : ?>
			<p class="mb-6">Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p class="mb-6">It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.</p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
