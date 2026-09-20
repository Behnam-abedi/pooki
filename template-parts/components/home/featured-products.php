<?php
/**
 * Featured Products Component
 *
 * @package Pooki
 */
?>
<section aria-labelledby="featured-products-heading" class="pooki-featured-products container mx-auto px-4 py-16 max-w-7xl">
	<div class="text-center mb-10">
		<h2 id="featured-products-heading" class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Arrivals</h2>
		<p class="text-gray-600 max-w-2xl mx-auto">Discover our newest premium products, carefully selected for you.</p>
	</div>
	<div class="featured-products-wrapper">
		<?php
		// Because we globally hooked into the WooCommerce loop in Pooki_WooCommerce_Loop,
		// this native shortcode will automatically render using our beautiful Tailwind CSS grid and polished cards!
		echo do_shortcode('[products limit="8" columns="4" orderby="date" order="DESC"]');
		?>
	</div>
</section>
