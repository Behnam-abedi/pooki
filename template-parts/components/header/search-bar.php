<?php
/**
 * Product Search Bar Component
 *
 * @package Pooki
 */
?>
<form role="search" method="get" class="pooki-search-form relative flex items-center w-full max-w-md" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="hidden" name="post_type" value="product" />
	<input type="search" name="s" class="w-full bg-gray-100 text-gray-900 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-full py-2 pl-10 pr-4 transition-all text-sm" placeholder="Search for products..." value="<?php echo get_search_query(); ?>" required />
	<button type="submit" class="absolute left-3 text-gray-500 hover:text-indigo-600 transition-colors" aria-label="Search">
		<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
	</button>
</form>
