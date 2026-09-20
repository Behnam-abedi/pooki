<?php
/**
 * Pooki WooCommerce Single Product Integration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_WooCommerce_Single
 */
class Pooki_WooCommerce_Single {

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
		// Wrap gallery and summary in a Tailwind grid.
		add_action( 'woocommerce_before_single_product_summary', [ $this, 'wrapper_start' ], 5 );
		add_action( 'woocommerce_after_single_product_summary', [ $this, 'wrapper_end' ], 5 );
	}

	/**
	 * Output custom single product wrapper start.
	 */
	public function wrapper_start() {
		echo '<div class="pooki-single-product-wrap grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 my-8">';
	}

	/**
	 * Output custom single product wrapper end.
	 */
	public function wrapper_end() {
		echo '</div>';
	}
}
