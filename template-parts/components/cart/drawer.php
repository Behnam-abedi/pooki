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
	@pooki:open-cart.window="$store.cart.isOpen = true"
	class="relative z-[110]" 
	aria-labelledby="slide-over-title" 
	role="dialog" 
	aria-modal="true"
	style="display: none;"
>
	<!-- Background backdrop -->
	<div 
		x-show="$store.cart.isOpen"
		x-transition:enter="transition-opacity ease-out duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-in duration-200"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		@click="$store.cart.isOpen = false"
		class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-md"
		aria-hidden="true"
	></div>

	<div class="fixed inset-0 overflow-hidden pointer-events-none">
		<div class="absolute inset-0 overflow-hidden">
			<!-- Drawer Container -->
			<div class="pointer-events-none fixed inset-y-0 right-0 z-[110] flex w-[85vw] sm:w-96">
				
				<div 
					x-show="$store.cart.isOpen"
					x-transition:enter="transform transition-transform duration-300 ease-out"
					x-transition:enter-start="translate-x-full"
					x-transition:enter-end="translate-x-0"
					x-transition:leave="transform transition-transform duration-300 ease-out"
					x-transition:leave-start="translate-x-0"
					x-transition:leave-end="translate-x-full"
					@keydown.escape.window="$store.cart.isOpen = false"
					class="pointer-events-auto w-full flex flex-col shadow-2xl h-full"
					style="background-color: var(--pooki-drawer-bg, #FAF7F2); color: var(--pooki-drawer-text, #292524);"
				>
					<!-- Header -->
					<div class="flex items-center justify-between px-5 py-4 border-b border-stone-200/60 shrink-0">
						<h2 class="text-lg font-bold" id="slide-over-title">سبد خرید شما</h2>
						<button @click="$store.cart.isOpen = false" type="button" class="p-2 rounded-full transition-colors opacity-70 hover:opacity-100 bg-stone-100/50" style="color: var(--pooki-drawer-text);">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
						</button>
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
