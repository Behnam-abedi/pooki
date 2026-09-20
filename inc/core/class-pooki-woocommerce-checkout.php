<?php
/**
 * Pooki WooCommerce Checkout Integration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_WooCommerce_Checkout
 */
class Pooki_WooCommerce_Checkout {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 */
	private function init_hooks() {
		add_action( 'woocommerce_checkout_before_customer_details', [ $this, 'wrapper_start' ], 5 );
		add_action( 'woocommerce_checkout_after_customer_details', [ $this, 'wrapper_middle' ], 50 );
		add_action( 'woocommerce_checkout_after_order_review', [ $this, 'wrapper_end' ], 50 );
	}

	/**
	 * Start checkout layout wrapper.
	 */
	public function wrapper_start() {
		echo '<div class="pooki-checkout-layout grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 mt-8"><div class="lg:col-span-7">';
	}

	/**
	 * Middle checkout layout wrapper (closes main form, opens sticky summary).
	 */
	public function wrapper_middle() {
		echo '</div><div class="lg:col-span-5"><div class="pooki-order-summary bg-gray-50 p-6 md:p-8 rounded-2xl border border-gray-100 sticky top-24">';
	}

	/**
	 * End checkout layout wrapper.
	 */
	public function wrapper_end() {
		echo '</div></div></div>';
	}
}
