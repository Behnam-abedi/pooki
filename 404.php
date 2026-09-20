<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Pooki
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-24 max-w-3xl text-center">
	<h1 class="text-7xl font-extrabold text-gray-900 mb-6">404</h1>
	<p class="text-xl text-gray-600 mb-10">Oops! The page you are looking for cannot be found.</p>
	<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-block bg-gray-900 text-white font-medium py-3 px-8 rounded-md hover:bg-gray-800 transition-colors">Return to Shop</a>
</main>

<?php
get_footer();
