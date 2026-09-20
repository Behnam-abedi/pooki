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
		$css_path = get_template_directory() . '/assets/dist/style.css';
		$js_path  = get_template_directory() . '/assets/dist/main.js';

		$css_uri = get_template_directory_uri() . '/assets/dist/style.css';
		$js_uri  = get_template_directory_uri() . '/assets/dist/main.js';

		// Use filemtime for cache-busting if file exists, otherwise fallback
		$css_ver = file_exists( $css_path ) ? filemtime( $css_path ) : '1.0.1';
		$js_ver  = file_exists( $js_path ) ? filemtime( $js_path ) : '1.0.1';

		wp_enqueue_style( 'pooki-main-style', $css_uri, array(), $css_ver );
		wp_enqueue_script( 'pooki-main-script', $js_uri, array('jquery'), $js_ver, true );
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
