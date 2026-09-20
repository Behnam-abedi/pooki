<?php
/**
 * Pooki WooCommerce Forms Integration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_WooCommerce_Forms
 */
class Pooki_WooCommerce_Forms {

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
		add_filter( 'woocommerce_checkout_fields', [ $this, 'optimize_checkout_fields' ], 10, 1 );
		add_filter( 'woocommerce_form_field_args', [ $this, 'custom_form_field_args' ], 10, 3 );
	}

	/**
	 * Optimize checkout fields.
	 *
	 * @param array $fields Checkout fields.
	 * @return array
	 */
	public function optimize_checkout_fields( $fields ) {
		unset( $fields['billing']['billing_company'] );
		unset( $fields['billing']['billing_address_2'] );
		return $fields;
	}

	/**
	 * Custom form field args.
	 *
	 * @param array  $args  Field arguments.
	 * @param string $key   Field key.
	 * @param string $value Field value.
	 * @return array
	 */
	public function custom_form_field_args( $args, $key, $value ) {
		// Ensure input_class is an array
		if ( ! isset( $args['input_class'] ) ) {
			$args['input_class'] = [];
		} elseif ( ! is_array( $args['input_class'] ) ) {
			$args['input_class'] = [ $args['input_class'] ];
		}

		// Ensure class is an array
		if ( ! isset( $args['class'] ) ) {
			$args['class'] = [];
		} elseif ( ! is_array( $args['class'] ) ) {
			$args['class'] = [ $args['class'] ];
		}

		$tailwind_input_classes = [ 'w-full', 'rounded-md', 'border', 'border-gray-300', 'px-4', 'py-2', 'text-gray-700', 'focus:outline-none', 'focus:ring-2', 'focus:ring-indigo-500', 'focus:border-transparent', 'transition-shadow' ];
		$tailwind_wrapper_classes = [ 'mb-4' ];

		$args['input_class'] = array_merge( $args['input_class'], $tailwind_input_classes );
		$args['class']       = array_merge( $args['class'], $tailwind_wrapper_classes );

		return $args;
	}
}
