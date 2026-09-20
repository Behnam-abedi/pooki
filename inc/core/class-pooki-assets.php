<?php
/**
 * Pooki Assets Management
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Assets
 */
class Pooki_Assets {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_filter( 'script_loader_tag', [ $this, 'add_module_attribute' ], 10, 3 );
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_assets() {
		$theme_version = wp_get_theme()->get( 'Version' );

		// CSS
		$css_path = '/assets/dist/main.css';
		$css_uri  = get_template_directory_uri() . $css_path;
		$css_dir  = get_template_directory() . $css_path;
		$css_ver  = file_exists( $css_dir ) ? filemtime( $css_dir ) : $theme_version;

		wp_enqueue_style( 'pooki-main-style', $css_uri, [], $css_ver );

		// JS
		$js_path = '/assets/dist/main.js';
		$js_uri  = get_template_directory_uri() . $js_path;
		$js_dir  = get_template_directory() . $js_path;
		$js_ver  = file_exists( $js_dir ) ? filemtime( $js_dir ) : $theme_version;

		wp_enqueue_script( 'pooki-main-script', $js_uri, [], $js_ver, true );
	}

	/**
	 * Add type="module" to scripts.
	 *
	 * @param string $tag    The `<script>` tag for the enqueued script.
	 * @param string $handle The script's registered handle.
	 * @param string $src    The script's source URL.
	 * @return string
	 */
	public function add_module_attribute( $tag, $handle, $src ) {
		// Ensure we only add type="module" to our specific script.
		if ( 'pooki-main-script' === $handle ) {
			if ( false === strpos( $tag, 'type="module"' ) ) {
				$tag = str_replace( '<script ', '<script type="module" ', $tag );
			}
		}
		return $tag;
	}
}
