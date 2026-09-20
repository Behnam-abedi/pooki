<?php
/**
 * Pooki Theme Customizer
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Customizer
 */
class Pooki_Customizer {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'register_customizer' ] );
	}

	/**
	 * Register Customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function register_customizer( $wp_customize ) {
		// Hero Section.
		$wp_customize->add_section( 'pooki_hero_section', [
			'title'    => esc_html__( 'Hero Section', 'pooki' ),
			'priority' => 120,
		] );

		// Hero Title.
		$wp_customize->add_setting( 'pooki_hero_title', [
			'default'           => 'Premium Products',
			'sanitize_callback' => 'sanitize_text_field',
		] );
		$wp_customize->add_control( 'pooki_hero_title', [
			'label'   => esc_html__( 'Hero Title', 'pooki' ),
			'section' => 'pooki_hero_section',
			'type'    => 'text',
		] );

		// Hero Subtitle.
		$wp_customize->add_setting( 'pooki_hero_subtitle', [
			'default'           => 'Discover our latest collection',
			'sanitize_callback' => 'sanitize_textarea_field',
		] );
		$wp_customize->add_control( 'pooki_hero_subtitle', [
			'label'   => esc_html__( 'Hero Subtitle', 'pooki' ),
			'section' => 'pooki_hero_section',
			'type'    => 'textarea',
		] );

		// Hero Image.
		$wp_customize->add_setting( 'pooki_hero_image', [
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		] );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pooki_hero_image', [
			'label'    => esc_html__( 'Hero Image', 'pooki' ),
			'section'  => 'pooki_hero_section',
			'settings' => 'pooki_hero_image',
		] ) );
	}
}
