<?php
/**
 * Cart Drawer Content Fragment
 *
 * @package Pooki
 */
$is_empty = ! class_exists( 'WooCommerce' ) || WC()->cart->is_empty();
?>
<div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl" id="pooki-cart-drawer-content">
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
				<?php if ( $is_empty ) : ?>
					<p class="text-gray-500 text-center py-10">Your cart is currently empty.</p>
				<?php else : ?>
					<ul role="list" class="-my-6 divide-y divide-gray-200">
						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
								$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_gallery_thumbnail', [ 'class' => 'h-full w-full object-cover object-center rounded-md' ] ), $cart_item, $cart_item_key );
								$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
								<li class="flex py-6">
									<div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
										<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</div>

									<div class="ml-4 flex flex-1 flex-col">
										<div>
											<div class="flex justify-between text-base font-medium text-gray-900">
												<h3>
													<?php if ( empty( $product_permalink ) ) : ?>
														<?php echo wp_kses_post( $product_name ); ?>
													<?php else : ?>
														<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo wp_kses_post( $product_name ); ?></a>
													<?php endif; ?>
												</h3>
												<p class="ml-4"><?php echo $product_price; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
											</div>
										</div>
										<div class="flex flex-1 items-end justify-between text-sm">
											<p class="text-gray-500">Qty <?php echo esc_html( $cart_item['quantity'] ); ?></p>
											<div class="flex">
												<?php
												echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													'woocommerce_cart_item_remove_link',
													sprintf(
														'<a href="%s" class="font-medium text-indigo-600 hover:text-indigo-500 remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">Remove</a>',
														esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
														/* translators: %s is the product name */
														esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
														esc_attr( $product_id ),
														esc_attr( $cart_item_key ),
														esc_attr( $_product->get_sku() )
													),
													$cart_item_key
												);
												?>
											</div>
										</div>
									</div>
								</li>
								<?php
							}
						}
						?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php if ( ! $is_empty ) : ?>
		<div class="border-t border-gray-200 px-4 py-6 sm:px-6">
			<div class="flex justify-between text-base font-medium text-gray-900">
				<p>Subtotal</p>
				<p><?php echo WC()->cart->get_cart_subtotal(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			</div>
			<p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
			<div class="mt-6">
				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</a>
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
	<?php endif; ?>
</div>
