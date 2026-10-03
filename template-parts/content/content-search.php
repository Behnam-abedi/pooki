<?php
/**
 * Template part for displaying results in search pages
 *
 * @package Pooki
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col h-full hover:shadow-md transition duration-200'); ?>>
	<h2 class="text-lg font-bold mb-3 leading-tight"><a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-indigo-600 transition-colors"><?php the_title(); ?></a></h2>
	<div class="text-sm text-gray-600 flex-grow line-clamp-3 mb-4"><?php the_excerpt(); ?></div>
	<a href="<?php the_permalink(); ?>" class="mt-auto inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">View Details &rarr;</a>
</article>
