<?php
/**
 * Pooki Blocks Registration
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Blocks
 */
class Pooki_Blocks {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_blocks' ] );
	}

	/**
	 * Register custom blocks.
	 */
	public function register_blocks() {
		$blocks_dir = get_template_directory() . '/blocks/';
		
		// Hero Slider
		if ( file_exists( $blocks_dir . 'hero-slider/block.json' ) ) {
			register_block_type( $blocks_dir . 'hero-slider' );
		}
	}
}
