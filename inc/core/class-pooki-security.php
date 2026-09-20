<?php
/**
 * Pooki Security and Optimization
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Security
 */
class Pooki_Security {

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
		add_action( 'init', [ $this, 'clean_wp_head' ] );
	}

	/**
	 * Clean up WordPress head bloat.
	 */
	public function clean_wp_head() {
		// Remove WP version generator (Security)
		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'the_generator', '__return_empty_string' );
		
		// Remove unnecessary links (Bloat removal for Core Web Vitals)
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	}
}
