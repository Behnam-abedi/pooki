<?php
/**
 * Pooki SEO Integration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_SEO
 */
class Pooki_SEO {

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
		// Remove WooCommerce Generator Tag (Security/Bloat).
		remove_action( 'wp_head', 'wc_generator_tag' );
		
		// Hook into WooCommerce to replace default breadcrumbs.
		add_action( 'init', [ $this, 'integrate_rank_math_breadcrumbs' ] );
	}

	/**
	 * Integrate Rank Math breadcrumbs with WooCommerce.
	 */
	public function integrate_rank_math_breadcrumbs() {
		// Remove default WooCommerce breadcrumbs.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		
		// Inject custom Rank Math breadcrumbs wrapper.
		add_action( 'woocommerce_before_main_content', [ $this, 'render_rank_math_breadcrumbs' ], 20 );
	}

	/**
	 * Render Rank Math breadcrumbs.
	 */
	public function render_rank_math_breadcrumbs() {
		if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
			// Tailwind wrappers for SEO Breadcrumbs.
			echo '<div class="pooki-rankmath-breadcrumbs-wrapper w-full mb-6">';
			rank_math_the_breadcrumbs( '<nav aria-label="Breadcrumbs" class="pooki-breadcrumbs text-sm text-gray-500 font-medium">', '</nav>' );
			echo '</div>';
		} elseif ( function_exists( 'woocommerce_breadcrumb' ) ) {
			// Fallback.
			woocommerce_breadcrumb();
		}
	}
}
