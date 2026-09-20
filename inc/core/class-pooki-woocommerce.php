<?php
/**
 * Pooki WooCommerce Integration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_WooCommerce
 */
class Pooki_WooCommerce {

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
		add_action( 'after_setup_theme', [ $this, 'setup_woocommerce' ] );

		// Remove default WooCommerce wrappers.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Add custom Tailwind wrappers.
		add_action( 'woocommerce_before_main_content', [ $this, 'wrapper_start' ], 10 );
		add_action( 'woocommerce_after_main_content', [ $this, 'wrapper_end' ], 10 );
	}

	/**
	 * Setup WooCommerce theme support.
	 */
	public function setup_woocommerce() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Output the custom WooCommerce wrapper start.
	 */
	public function wrapper_start() {
		echo '<main id="primary" class="site-main container mx-auto px-4 py-8 max-w-7xl">';
		get_template_part( 'template-parts/components/seo/breadcrumbs' );
	}

	/**
	 * Output the custom WooCommerce wrapper end.
	 */
	public function wrapper_end() {
		echo '</main>';
	}
}
