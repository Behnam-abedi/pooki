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
	}

	/**
	 * Dequeue extra styles.
	 */
	public function dequeue_extra_styles() {
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'wc-blocks-vendors-style' );
	}
}
