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

		// Live Search AJAX
		add_action( 'wp_ajax_pooki_live_search', [ $this, 'ajax_live_search' ] );
		add_action( 'wp_ajax_nopriv_pooki_live_search', [ $this, 'ajax_live_search' ] );
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

	/**
	 * Handle AJAX live product search.
	 */
	public function ajax_live_search() {
		$search_query = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';

		if ( strlen( $search_query ) < 3 ) {
			wp_send_json_error( 'Query too short' );
		}

		$args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			's'              => $search_query,
			'posts_per_page' => 5,
			'no_found_rows'  => true,
		];

		$query = new WP_Query( $args );
		$results = [];

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$product = wc_get_product( get_the_ID() );
				
				$results[] = [
					'id'         => get_the_ID(),
					'title'      => get_the_title(),
					'url'        => get_permalink(),
					'thumbnail'  => get_the_post_thumbnail( get_the_ID(), 'thumbnail', [ 'class' => 'w-full h-full object-cover' ] ),
					'price_html' => $product->get_price_html(),
				];
			}
			wp_reset_postdata();
			wp_send_json_success( $results );
		}

		wp_send_json_error( 'No products found' );
	}
}
