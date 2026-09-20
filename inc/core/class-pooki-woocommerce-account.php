<?php
/**
 * Pooki WooCommerce Account Integration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_WooCommerce_Account
 */
class Pooki_WooCommerce_Account {

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
		// My Account Dashboard Layout.
		add_action( 'woocommerce_before_account_navigation', [ $this, 'account_wrapper_start' ], 5 );
		add_action( 'woocommerce_after_account_navigation', [ $this, 'account_wrapper_middle' ], 15 );
		add_action( 'woocommerce_after_my_account', [ $this, 'account_wrapper_end' ], 50 );

		// Login/Register Form Layout.
		add_action( 'woocommerce_before_customer_login_form', [ $this, 'login_wrapper_start' ], 5 );
		add_action( 'woocommerce_after_customer_login_form', [ $this, 'login_wrapper_end' ], 50 );
	}

	/**
	 * Start account layout wrapper.
	 */
	public function account_wrapper_start() {
		echo '<div class="pooki-account-layout max-w-6xl mx-auto flex flex-col md:flex-row gap-8 my-12"><aside class="md:w-1/4">';
	}

	/**
	 * Middle account layout wrapper.
	 */
	public function account_wrapper_middle() {
		echo '</aside><main class="md:w-3/4 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 pooki-account-content">';
	}

	/**
	 * End account layout wrapper.
	 */
	public function account_wrapper_end() {
		echo '</main></div>';
	}

	/**
	 * Start login layout wrapper.
	 */
	public function login_wrapper_start() {
		echo '<div class="pooki-login-layout max-w-4xl mx-auto my-12 bg-white p-6 md:p-10 rounded-2xl shadow-sm border border-gray-100">';
	}

	/**
	 * End login layout wrapper.
	 */
	public function login_wrapper_end() {
		echo '</div>';
	}
}
