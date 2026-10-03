<?php
/**
 * Template part for displaying 404 page content
 *
 * @package Pooki
 */

?>
<section class="error-404 not-found text-center py-24">
	<h1 class="text-7xl font-extrabold text-gray-900 mb-6">404</h1>
	<p class="text-xl text-gray-600 mb-10">Oops! The page you are looking for cannot be found.</p>
	<a href="<?php echo esc_url( function_exists('wc_get_page_permalink') ? wc_get_page_permalink( 'shop' ) : home_url('/') ); ?>" class="inline-block bg-gray-900 text-white font-medium py-3 px-8 rounded-md hover:bg-gray-800 transition-colors">Return Home</a>
</section>
