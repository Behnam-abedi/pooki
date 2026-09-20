<?php
/**
 * Pooki Cart AJAX Integration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Cart_Ajax
 */
class Pooki_Cart_Ajax {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'cart_fragments' ] );
	}

	/**
	 * Add to cart fragments.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array
	 */
	public function cart_fragments( $fragments ) {
		// Update Cart Count Badge
		ob_start();
		$cart_count = class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0;
		?>
		<span id="pooki-cart-count" class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-indigo-600 text-[10px] font-bold text-white">
			<?php echo esc_html( $cart_count ); ?>
		</span>
		<?php
		$fragments['#pooki-cart-count'] = ob_get_clean();

		// Update Cart Drawer Content
		ob_start();
		get_template_part( 'template-parts/components/cart/drawer-content' );
		$fragments['#pooki-cart-drawer-content'] = ob_get_clean();

		return $fragments;
	}
}
