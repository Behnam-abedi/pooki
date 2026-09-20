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
		add_action( 'after_setup_theme', [ $this, 'setup_woocommerce' ] );
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
}
