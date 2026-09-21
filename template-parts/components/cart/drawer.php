<?php
/**
 * Cart Drawer Component
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div 
	x-data
	x-show="$store.cart.isOpen"
	class="relative z-50" 
	aria-labelledby="slide-over-title" 
	role="dialog" 
	aria-modal="true"
	style="display: none;"
>
	<!-- Background backdrop -->
	<div 
		x-show="$store.cart.isOpen"
		x-transition:enter="ease-in-out duration-500"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="ease-in-out duration-500"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
	></div>

	<div class="fixed inset-0 overflow-hidden">
		<div class="absolute inset-0 overflow-hidden">
			<!-- Sliding from the LEFT in RTL layout -->
			<div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full pr-10">
				
				<div 
					x-show="$store.cart.isOpen"
					@click.outside="$store.cart.toggle()"
					x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
					x-transition:enter-start="-translate-x-full"
					x-transition:enter-end="translate-x-0"
					x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
					x-transition:leave-start="translate-x-0"
					x-transition:leave-end="-translate-x-full"
					class="pointer-events-auto w-screen max-w-md"
				>
					<div class="flex h-full flex-col bg-white shadow-xl">
						
						<!-- Header -->
						<div class="flex items-center justify-between px-4 py-6 sm:px-6 bg-pooki-cream border-b border-gray-100">
							<h2 class="text-lg font-bold text-gray-900" id="slide-over-title">سبد خرید شما</h2>
							<div class="ml-3 flex h-7 items-center">
								<button @click="$store.cart.toggle()" type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
									<span class="absolute -inset-0.5"></span>
									<span class="sr-only">Close panel</span>
									<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
									</svg>
								</button>
							</div>
						</div>

						<!-- Cart Content (WooCommerce Mini Cart) -->
						<div class="pooki-mini-cart-container relative flex-1 overflow-y-auto px-4 py-6 sm:px-6">
							<div class="widget_shopping_cart_content">
								<?php woocommerce_mini_cart(); ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
