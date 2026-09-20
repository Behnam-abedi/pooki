<?php
/**
 * Cart Drawer Component
 *
 * @package Pooki
 */
?>
<div x-data x-show="$store.cart.open" class="fixed inset-0 z-50 overflow-hidden" style="display: none;" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
	<div class="absolute inset-0 overflow-hidden">
		<!-- Background overlay -->
		<div x-show="$store.cart.open" 
			 x-transition:enter="ease-in-out duration-500" 
			 x-transition:enter-start="opacity-0" 
			 x-transition:enter-end="opacity-100" 
			 x-transition:leave="ease-in-out duration-500" 
			 x-transition:leave-start="opacity-100" 
			 x-transition:leave-end="opacity-0" 
			 class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
			 @click="$store.cart.open = false" 
			 aria-hidden="true"></div>

		<div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
			<!-- Slide-over panel -->
			<div x-show="$store.cart.open" 
				 x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
				 x-transition:enter-start="translate-x-full" 
				 x-transition:enter-end="translate-x-0" 
				 x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
				 x-transition:leave-start="translate-x-0" 
				 x-transition:leave-end="translate-x-full" 
				 class="pointer-events-auto w-screen max-w-md">
				<?php get_template_part( 'template-parts/components/cart/drawer-content' ); ?>
			</div>
		</div>
	</div>
</div>
