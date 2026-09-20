<?php
/**
 * Pooki Performance Optimization
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Performance
 */
class Pooki_Performance {

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
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_extra_styles' ], 100 );
		add_action( 'wp_enqueue_scripts', [ $this, 'optimize_wc_cart_fragments' ], 99 );
		add_action( 'wp_head', [ $this, 'preload_primary_font' ], 1 );
	}

	/**
	 * Dequeue extra styles.
	 */
	public function dequeue_extra_styles() {
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'wc-blocks-vendors-style' );
	}

	/**
	 * Optimize WooCommerce Cart Fragments.
	 */
	public function optimize_wc_cart_fragments() {
		// Only load cart fragments on WooCommerce pages (Shop, Cart, Checkout, Product)
		if ( function_exists( 'is_woocommerce' ) && ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
			wp_dequeue_script( 'wc-cart-fragments' );
		}
	}

	/**
	 * Preload primary font via preconnects.
	 */
	public function preload_primary_font() {
		// Note: Adjust the path if Vazirmatn is hosted elsewhere locally. 
		// For now, we add a DNS prefetch/preconnect for Google Fonts as a fallback or structure placeholder.
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
	}
}
