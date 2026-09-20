<?php
/**
 * Pooki Menus
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Menus
 */
class Pooki_Menus {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'register_menus' ] );
	}

	/**
	 * Register navigation menus.
	 */
	public function register_menus() {
		register_nav_menus( [
			'primary' => esc_html__( 'Primary Desktop Menu', 'pooki' ),
			'mobile'  => esc_html__( 'Mobile Menu', 'pooki' ),
			'footer'  => esc_html__( 'Footer Menu', 'pooki' ),
		] );
	}
}
