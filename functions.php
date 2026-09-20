<?php
/**
 * Pooki Theme Functions
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Theme Init Class
 */
final class Pooki_Theme_Init {

	/**
	 * Instance of this class.
	 *
	 * @var Pooki_Theme_Init
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance.
	 *
	 * @return Pooki_Theme_Init
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->load_dependencies();
		$this->init_hooks();
	}

	/**
	 * Load required dependencies.
	 */
	private function load_dependencies() {
		require_once get_template_directory() . '/inc/core/class-pooki-assets.php';
		new Pooki_Assets();
	}

	/**
	 * Initialize hooks.
	 */
	private function init_hooks() {
		add_action( 'after_setup_theme', [ $this, 'theme_supports' ] );
	}

	/**
	 * Setup theme supports.
	 */
	public function theme_supports() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		] );
	}
}

// Boot up the theme.
Pooki_Theme_Init::get_instance();

/**
 * Helper wrapper for Rank Math Breadcrumbs.
 */
if ( ! function_exists( 'pooki_the_breadcrumbs' ) ) {
	function pooki_the_breadcrumbs() {
		if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
			rank_math_the_breadcrumbs();
		}
	}
}
