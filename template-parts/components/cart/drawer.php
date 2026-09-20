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
				<div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
					<div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
						<div class="flex items-start justify-between">
							<h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Shopping cart</h2>
							<div class="ml-3 flex h-7 items-center">
								<button type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500" @click="$store.cart.open = false">
									<span class="absolute -inset-0.5"></span>
									<span class="sr-only">Close panel</span>
									<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
									</svg>
								</button>
							</div>
						</div>

						<div class="mt-8">
							<div class="flow-root">
								<!-- Placeholder for cart items -->
								<p class="text-gray-500 text-center py-10">Your cart is currently empty.</p>
							</div>
						</div>
					</div>

					<div class="border-t border-gray-200 px-4 py-6 sm:px-6">
						<div class="flex justify-between text-base font-medium text-gray-900">
							<p>Subtotal</p>
							<p>$0.00</p>
						</div>
						<p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
						<div class="mt-6">
							<a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</a>
						</div>
						<div class="mt-6 flex justify-center text-center text-sm text-gray-500">
							<p>
								or
								<button type="button" class="font-medium text-indigo-600 hover:text-indigo-500" @click="$store.cart.open = false">
									Continue Shopping
									<span aria-hidden="true"> &rarr;</span>
								</button>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
