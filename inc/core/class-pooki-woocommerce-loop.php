<?php
/**
 * Pooki WooCommerce Loop Integration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_WooCommerce_Loop
 */
class Pooki_WooCommerce_Loop {

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
		add_filter( 'woocommerce_product_loop_start', [ $this, 'loop_start' ], 10, 1 );
		add_filter( 'woocommerce_product_loop_end', [ $this, 'loop_end' ], 10, 1 );
		add_filter( 'post_class', [ $this, 'product_item_classes' ], 10, 3 );

		// Optimize Archive SEO Descriptions
		remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
		add_action( 'woocommerce_archive_description', [ $this, 'custom_archive_description' ], 10 );

		// Product Card Content Wrapper
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'card_content_wrapper_start' ], 15 );
		add_action( 'woocommerce_after_shop_loop_item', [ $this, 'card_content_wrapper_end' ], 20 );

		// Product Card Title
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_shop_loop_item_title', [ $this, 'custom_loop_product_title' ], 10 );

		// Add to Cart Button Styling
		add_filter( 'woocommerce_loop_add_to_cart_args', [ $this, 'custom_add_to_cart_args' ], 10, 2 );
	}

	/**
	 * Output custom WooCommerce product loop start.
	 *
	 * @param string $html The loop start HTML.
	 * @return string
	 */
	public function loop_start( $html ) {
		return '<div class="pooki-products-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 my-8">';
	}

	/**
	 * Output custom WooCommerce product loop end.
	 *
	 * @param string $html The loop end HTML.
	 * @return string
	 */
	public function loop_end( $html ) {
		return '</div>';
	}

	/**
	 * Add Tailwind classes to individual product items.
	 *
	 * @param array $classes An array of post class names.
	 * @param array $class   An array of additional class names added to the post.
	 * @param int   $post_id The post ID.
	 * @return array
	 */
	public function product_item_classes( $classes, $class, $post_id ) {
		if ( ! is_admin() && function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			if ( 'product' === get_post_type( $post_id ) ) {
				$tailwind_classes = [
					'flex',
					'flex-col',
					'bg-white',
					'rounded-lg',
					'shadow-sm',
					'overflow-hidden',
					'group'
				];
				$classes = array_merge( $classes, $tailwind_classes );
			}
		}

		return $classes;
	}

	/**
	 * Output custom archive description.
	 */
	public function custom_archive_description() {
		$description = get_the_archive_description();
		if ( $description ) {
			echo '<div class="pooki-seo-description text-gray-700 leading-relaxed mb-8 max-w-4xl">' . $description . '</div>';
		}
	}

	/**
	 * Start product card content wrapper.
	 */
	public function card_content_wrapper_start() {
		echo '<div class="p-4 flex flex-col flex-grow">';
	}

	/**
	 * End product card content wrapper.
	 */
	public function card_content_wrapper_end() {
		echo '</div>';
	}

	/**
	 * Custom product loop title.
	 */
	public function custom_loop_product_title() {
		echo '<h2 class="text-lg font-bold text-gray-800 mb-2 leading-tight">' . get_the_title() . '</h2>';
	}

	/**
	 * Custom add to cart button args.
	 *
	 * @param array      $args    Arguments.
	 * @param WC_Product $product Product object.
	 * @return array
	 */
	public function custom_add_to_cart_args( $args, $product ) {
		$args['class'] = isset( $args['class'] ) ? $args['class'] . ' mt-auto w-full block text-center bg-gray-900 text-white font-medium py-2 px-4 rounded-md hover:bg-gray-800 transition-colors' : 'mt-auto w-full block text-center bg-gray-900 text-white font-medium py-2 px-4 rounded-md hover:bg-gray-800 transition-colors';
		return $args;
	}
}
