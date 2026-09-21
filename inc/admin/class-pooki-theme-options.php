<?php
/**
 * Pooki Native Theme Options Panel
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Theme_Options
 * Implements Singleton design pattern.
 */
class Pooki_Theme_Options {

	/**
	 * Instance of this class.
	 *
	 * @var Pooki_Theme_Options
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance.
	 *
	 * @return Pooki_Theme_Options
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
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 */
	private function init_hooks() {
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
		add_action( 'wp_ajax_pooki_save_theme_options', [ $this, 'ajax_save_options' ] );
		add_action( 'wp_head', [ $this, 'inject_dynamic_css' ], 100 );
	}

	/**
	 * Enqueue Media Scripts
	 */
	public function enqueue_admin_scripts( $hook ) {
		if ( 'toplevel_page_pooki-settings' !== $hook ) {
			return;
		}
		wp_enqueue_media();
	}

	/**
	 * Register Admin Menu Page.
	 */
	public function register_admin_menu() {
		add_menu_page(
			'تنظیمات پوکی',
			'تنظیمات پوکی',
			'manage_options',
			'pooki-settings',
			[ $this, 'render_admin_page' ],
			'dashicons-admin-generic',
			59
		);
	}

	/**
	 * Register settings and sections.
	 */
	public function register_settings() {
		register_setting( 'pooki_options_group', 'pooki_theme_options' );

		// Top Bar Section
		add_settings_section( 'pooki_topbar_section', 'نوار اعلان بالای سایت (Top Bar)', null, 'pooki-settings-header' );

		add_settings_field( 'topbar_enabled', 'نمایش نوار اعلان', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_topbar_section', [ 'id' => 'topbar_enabled', 'default' => 1 ] );
		add_settings_field( 'topbar_height', 'ارتفاع (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_topbar_section', [ 'id' => 'topbar_height', 'default' => 36 ] );
		add_settings_field( 'topbar_bg_color', 'رنگ پس‌زمینه', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_topbar_section', [ 'id' => 'topbar_bg_color', 'default' => '#4f46e5' ] );
		add_settings_field( 'topbar_text_color', 'رنگ متن', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_topbar_section', [ 'id' => 'topbar_text_color', 'default' => '#ffffff' ] );
		add_settings_field( 'topbar_content', 'محتوای نوار اعلان (HTML مجاز است)', [ $this, 'render_textarea_field' ], 'pooki-settings-header', 'pooki_topbar_section', [ 'id' => 'topbar_content', 'default' => 'تلفن تماس: ۰۲۱-۱۲۳۴۵۶۷۸ | ارسال رایگان برای خریدهای بالای ۱ میلیون تومان' ] );

		// Header Section
		add_settings_section( 'pooki_header_section', 'تنظیمات سربرگ', null, 'pooki-settings-header' );

		add_settings_field( 'logo_url', 'تصویر لوگو', [ $this, 'render_media_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'logo_url' ] );
		add_settings_field( 'header_height', 'ارتفاع سربرگ (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'header_height', 'default' => 80 ] );
		add_settings_field( 'logo_height', 'ارتفاع لوگو (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'logo_height', 'default' => 48 ] );
		add_settings_field( 'header_bg_color', 'رنگ پس‌زمینه سربرگ', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'header_bg_color', 'default' => '#ffffff' ] );
		add_settings_field( 'header_border_color', 'رنگ حاشیه سربرگ', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'header_border_color', 'default' => '#f3f4f6' ] );
		add_settings_field( 'header_shadow', 'سایه سربرگ', [ $this, 'render_select_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'header_shadow', 'options' => [ 'none' => 'بدون سایه', 'sm' => 'کوچک', 'md' => 'متوسط', 'lg' => 'بزرگ' ], 'default' => 'sm' ] );
		
		add_settings_field( 'menu_text_color', 'رنگ متن منو', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'menu_text_color', 'default' => '#374151' ] );
		add_settings_field( 'menu_hover_color', 'رنگ هاور منو', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'menu_hover_color', 'default' => '#ec4899' ] );

		// Navigation Row Section
		add_settings_section( 'pooki_nav_section', 'نوار ناوبری (منو)', null, 'pooki-settings-header' );

		add_settings_field( 'nav_bg_color', 'رنگ پس‌زمینه نوار', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_nav_section', [ 'id' => 'nav_bg_color', 'default' => 'transparent' ] );
		add_settings_field( 'nav_sticky_bg_color', 'رنگ پس‌زمینه در حالت چسبان', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_nav_section', [ 'id' => 'nav_sticky_bg_color', 'default' => 'transparent' ] );
		add_settings_field( 'nav_border_top_width', 'ضخامت حاشیه بالا (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_nav_section', [ 'id' => 'nav_border_top_width', 'default' => 1 ] );
		add_settings_field( 'nav_border_top_color', 'رنگ حاشیه بالا', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_nav_section', [ 'id' => 'nav_border_top_color', 'default' => '#f3f4f6' ] );

		// Sticky Header Section
		add_settings_section( 'pooki_sticky_header_section', 'تنظیمات هدر چسبان', null, 'pooki-settings-header' );

		add_settings_field( 'sticky_header_enabled', 'فعال‌سازی هدر چسبان', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_header_enabled' ] );
		add_settings_field( 'sticky_header_height', 'ارتفاع هدر چسبان (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_header_height', 'default' => 64 ] );
		add_settings_field( 'sticky_logo_height', 'ارتفاع لوگو چسبان (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_logo_height', 'default' => 40 ] );
		add_settings_field( 'sticky_bg_color', 'رنگ پس‌زمینه چسبان', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_bg_color', 'default' => '#ffffff' ] );
		add_settings_field( 'sticky_border_color', 'رنگ حاشیه چسبان', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_border_color', 'default' => '#e5e7eb' ] );
		add_settings_field( 'sticky_shadow', 'سایه هدر چسبان', [ $this, 'render_select_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_shadow', 'options' => [ 'none' => 'بدون سایه', 'sm' => 'کوچک', 'md' => 'متوسط', 'lg' => 'بزرگ' ], 'default' => 'md' ] );

		// Search Bar Section
		add_settings_section( 'pooki_search_section', 'تنظیمات فرم جستجو', null, 'pooki-settings-header' );

		add_settings_field( 'search_height', 'ارتفاع فرم (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_height', 'default' => 44 ] );
		add_settings_field( 'search_font_size', 'اندازه متن (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_font_size', 'default' => 14 ] );
		add_settings_field( 'search_text_color', 'رنگ متن', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_text_color', 'default' => '#111827' ] );
		add_settings_field( 'search_placeholder_color', 'رنگ متغیر (Placeholder)', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_placeholder_color', 'default' => '#9ca3af' ] );
		add_settings_field( 'search_bg_color', 'رنگ پس‌زمینه عادی', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_bg_color', 'default' => '#f3f4f6' ] );
		add_settings_field( 'search_focus_bg_color', 'رنگ پس‌زمینه فوکوس', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_focus_bg_color', 'default' => '#ffffff' ] );
		add_settings_field( 'search_border_radius', 'گردی گوشه‌ها (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_border_radius', 'default' => 9999 ] );
		add_settings_field( 'search_border_width', 'ضخامت حاشیه عادی (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_border_width', 'default' => 1 ] );
		add_settings_field( 'search_focus_border_width', 'ضخامت حاشیه فوکوس (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_focus_border_width', 'default' => 2 ] );
		add_settings_field( 'search_border_color', 'رنگ حاشیه عادی', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_border_color', 'default' => '#e5e7eb' ] );
		add_settings_field( 'search_focus_border_color', 'رنگ حاشیه فوکوس', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_focus_border_color', 'default' => '#ec4899' ] );

		// Header Actions Section
		add_settings_section( 'pooki_actions_section', 'تنظیمات دکمه‌های سربرگ', null, 'pooki-settings-header' );

		add_settings_field( 'header_action_icon_size', 'اندازه آیکون (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_icon_size', 'default' => 20 ] );
		add_settings_field( 'header_action_font_size', 'اندازه متن (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_font_size', 'default' => 13 ] );
		add_settings_field( 'header_action_radius', 'گردی گوشه‌ها (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_radius', 'default' => 8 ] );
		
		add_settings_field( 'header_action_icon_color', 'رنگ آیکون', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_icon_color', 'default' => '#374151' ] );
		add_settings_field( 'header_action_icon_hover_color', 'رنگ هاور آیکون', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_icon_hover_color', 'default' => '#ec4899' ] );
		
		add_settings_field( 'header_action_text_color', 'رنگ متن', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_text_color', 'default' => '#374151' ] );
		add_settings_field( 'header_action_text_hover_color', 'رنگ هاور متن', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_text_hover_color', 'default' => '#ec4899' ] );
		
		add_settings_field( 'header_action_bg_color', 'رنگ پس‌زمینه', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_bg_color', 'default' => 'transparent' ] );
		add_settings_field( 'header_action_bg_hover_color', 'رنگ هاور پس‌زمینه', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_bg_hover_color', 'default' => '#f3f4f6' ] );
		
		add_settings_field( 'header_action_border_color', 'رنگ حاشیه', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_border_color', 'default' => 'transparent' ] );
		
		add_settings_field( 'header_action_items', 'مدیریت دکمه‌ها', [ $this, 'render_repeater_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_items' ] );

	}

	/**
	 * Render Checkbox Field.
	 */
	public function render_checkbox_field( $args ) {
		$options = get_option( 'pooki_theme_options' );
		$id      = $args['id'];
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : 0;
		echo '<input type="checkbox" name="pooki_theme_options[' . esc_attr( $id ) . ']" value="1" ' . checked( 1, $value, false ) . ' />';
	}

	/**
	 * Render Number Field.
	 */
	public function render_number_field( $args ) {
		$options = get_option( 'pooki_theme_options' );
		$id      = $args['id'];
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $args['default'];
		echo '<input type="number" name="pooki_theme_options[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="regular-text" />';
	}

	/**
	 * Render Textarea Field.
	 */
	public function render_textarea_field( $args ) {
		$options = get_option( 'pooki_theme_options' );
		$id      = $args['id'];
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $args['default'];
		echo '<textarea name="pooki_theme_options[' . esc_attr( $id ) . ']" class="large-text" rows="3" style="width:100%; border-radius:6px; border:1px solid #cbd5e1; padding:10px;">' . esc_textarea( $value ) . '</textarea>';
	}

	/**
	 * Render Color Field.
	 */
	public function render_color_field( $args ) {
		$options = get_option( 'pooki_theme_options' );
		$id      = $args['id'];
		$value   = isset( $options[ $id ] ) && ! empty( $options[ $id ] ) ? $options[ $id ] : $args['default'];
		echo '<input type="color" name="pooki_theme_options[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="regular-text" />';
	}

	/**
	 * Render Select Field.
	 */
	public function render_select_field( $args ) {
		$options = get_option( 'pooki_theme_options' );
		$id      = $args['id'];
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : $args['default'];
		echo '<select name="pooki_theme_options[' . esc_attr( $id ) . ']">';
		foreach ( $args['options'] as $val => $label ) {
			echo '<option value="' . esc_attr( $val ) . '" ' . selected( $val, $value, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
	}

	/**
	 * Render Media Field.
	 */
	public function render_media_field( $args ) {
		$options = get_option( 'pooki_theme_options' );
		$id      = $args['id'];
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : '';
		
		echo '<div class="pooki-media-wrapper" style="display: flex; gap: 15px; align-items: center;">';
		echo '<input type="hidden" id="pooki_media_url_' . esc_attr( $id ) . '" name="pooki_theme_options[' . esc_attr( $id ) . ']" value="' . esc_url( $value ) . '" />';
		
		echo '<div class="pooki-media-preview" id="pooki_media_preview_' . esc_attr( $id ) . '" style="width: 150px; height: 60px; background: #f0f0f1; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; overflow: hidden;">';
		if ( ! empty( $value ) ) {
			echo '<img src="' . esc_url( $value ) . '" style="max-width: 100%; max-height: 100%; object-fit: contain;" />';
		} else {
			echo '<span style="color: #999; font-size: 12px;">بدون تصویر</span>';
		}
		echo '</div>';
		
		echo '<div>';
		echo '<button type="button" class="button pooki-upload-button" data-target="pooki_media_url_' . esc_attr( $id ) . '" data-preview="pooki_media_preview_' . esc_attr( $id ) . '">انتخاب تصویر</button>';
		echo '<button type="button" class="button pooki-remove-button" style="margin-right: 5px; color: #d63638; border-color: #d63638;" data-target="pooki_media_url_' . esc_attr( $id ) . '" data-preview="pooki_media_preview_' . esc_attr( $id ) . '">حذف</button>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Render Repeater Field (JSON Based)
	 */
	public function render_repeater_field( $args ) {
		$options = get_option( 'pooki_theme_options' );
		$id      = $args['id'];
		$value   = isset( $options[ $id ] ) && is_array( $options[ $id ] ) ? $options[ $id ] : [];
		$json_value = wp_json_encode( $value );

		echo '<input type="hidden" id="pooki_repeater_' . esc_attr( $id ) . '" name="pooki_theme_options[' . esc_attr( $id ) . ']" value="' . esc_attr( $json_value ) . '" />';
		echo '<div id="pooki_repeater_ui_' . esc_attr( $id ) . '"></div>';

		// We will inject a script inside the render_admin_page to handle this securely.
	}

	/**
	 * Handle AJAX save of theme options.
	 */
	public function ajax_save_options() {
		// Check capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'شما دسترسی لازم را ندارید.' );
		}

		// Verify nonce
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pooki_options_group-options' ) ) {
			wp_send_json_error( 'مشکل امنیتی (Nonce). لطفاً صفحه را رفرش کنید.' );
		}

		if ( isset( $_POST['pooki_theme_options'] ) && is_array( $_POST['pooki_theme_options'] ) ) {
			$options = get_option( 'pooki_theme_options', [] );
			$posted  = wp_unslash( $_POST['pooki_theme_options'] );

			$fields = [
				'topbar_enabled'        => 'bool',
				'topbar_height'         => 'int',
				'topbar_bg_color'       => 'color',
				'topbar_text_color'     => 'color',
				'topbar_content'        => 'html',

				'logo_url'              => 'url',
				'header_height'         => 'int',
				'logo_height'           => 'int',
				'header_bg_color'       => 'color',
				'header_border_color'   => 'color',
				'header_shadow'         => 'key',
				'menu_text_color'       => 'color',
				'menu_hover_color'      => 'color',
				
				'nav_bg_color'          => 'color',
				'nav_sticky_bg_color'   => 'color',
				'nav_border_top_width'  => 'int',
				'nav_border_top_color'  => 'color',
				
				'sticky_header_enabled' => 'bool',
				'sticky_header_height'  => 'int',
				'sticky_logo_height'    => 'int',
				'sticky_bg_color'       => 'color',
				'sticky_border_color'   => 'color',
				'sticky_shadow'         => 'key',
				
				'search_height'         => 'int',
				'search_font_size'      => 'int',
				'search_text_color'     => 'color',
				'search_placeholder_color' => 'color',
				'search_bg_color'       => 'color',
				'search_focus_bg_color' => 'color',
				'search_border_radius'  => 'int',
				'search_border_width'   => 'int',
				'search_focus_border_width' => 'int',
				'search_border_color'   => 'color',
				'search_focus_border_color' => 'color',

				'header_action_icon_size'          => 'int',
				'header_action_font_size'          => 'int',
				'header_action_radius'             => 'int',
				'header_action_icon_color'         => 'color',
				'header_action_icon_hover_color'   => 'color',
				'header_action_text_color'         => 'color',
				'header_action_text_hover_color'   => 'color',
				'header_action_bg_color'           => 'color',
				'header_action_bg_hover_color'     => 'color',
				'header_action_border_color'       => 'color',
				'header_action_items'              => 'repeater',
			];

			foreach ( $fields as $field => $type ) {
				if ( 'bool' === $type ) {
					$options[ $field ] = isset( $posted[ $field ] ) ? 1 : 0;
					continue;
				}

				if ( isset( $posted[ $field ] ) ) {
					if ( 'int' === $type ) {
						$options[ $field ] = absint( $posted[ $field ] );
					} elseif ( 'color' === $type ) {
						// 'transparent' is valid in CSS
						if ( $posted[ $field ] === 'transparent' ) {
							$options[ $field ] = 'transparent';
						} else {
							$options[ $field ] = sanitize_hex_color( $posted[ $field ] );
						}
					} elseif ( 'url' === $type ) {
						$options[ $field ] = esc_url_raw( $posted[ $field ] );
					} elseif ( 'key' === $type ) {
						$options[ $field ] = sanitize_key( $posted[ $field ] );
					} elseif ( 'html' === $type ) {
						$options[ $field ] = wp_kses_post( $posted[ $field ] );
					} elseif ( 'repeater' === $type ) {
						// Process repeater JSON string securely
						$json_data = json_decode( wp_unslash( $posted[ $field ] ), true );
						$items = [];
						if ( is_array( $json_data ) ) {
							// Allowed SVG tags
							$svg_args = [
								'svg' => [
									'class'           => true,
									'fill'            => true,
									'viewbox'         => true,
									'xmlns'           => true,
									'stroke'          => true,
									'stroke-width'    => true,
									'stroke-linecap'  => true,
									'stroke-linejoin' => true,
								],
								'path' => [
									'd'               => true,
									'fill'            => true,
									'stroke'          => true,
									'stroke-width'    => true,
									'stroke-linecap'  => true,
									'stroke-linejoin' => true,
								],
								'circle' => [
									'cx'              => true,
									'cy'              => true,
									'r'               => true,
									'fill'            => true,
									'stroke'          => true,
									'stroke-width'    => true,
								]
							];
							
							foreach ( $json_data as $item ) {
								$items[] = [
									'type'     => isset( $item['type'] ) ? sanitize_key( $item['type'] ) : '',
									'label'    => isset( $item['label'] ) ? sanitize_text_field( $item['label'] ) : '',
									'url'      => isset( $item['url'] ) ? esc_url_raw( $item['url'] ) : '',
									'icon_svg' => isset( $item['icon_svg'] ) ? wp_kses( $item['icon_svg'], $svg_args ) : '',
								];
							}
						}
						$options[ $field ] = $items;
					}
				}
			}

			update_option( 'pooki_theme_options', $options );
			wp_send_json_success( [ 'message' => 'تنظیمات با موفقیت ذخیره شد!' ] );
		}

		wp_send_json_error( 'اطلاعاتی ارسال نشد.' );
	}

	/**
	 * Inject Dynamic CSS Variables to frontend.
	 */
	public function inject_dynamic_css() {
		$opts = get_option( 'pooki_theme_options', [] );

		$topbar_height    = absint( isset( $opts['topbar_height'] ) ? $opts['topbar_height'] : 36 );
		$topbar_bg        = sanitize_hex_color( isset( $opts['topbar_bg_color'] ) ? $opts['topbar_bg_color'] : '#4f46e5' );
		$topbar_color     = sanitize_hex_color( isset( $opts['topbar_text_color'] ) ? $opts['topbar_text_color'] : '#ffffff' );

		$header_height    = absint( isset( $opts['header_height'] ) ? $opts['header_height'] : 80 );
		$logo_height      = absint( isset( $opts['logo_height'] ) ? $opts['logo_height'] : 48 );
		$header_bg        = sanitize_hex_color( isset( $opts['header_bg_color'] ) ? $opts['header_bg_color'] : '#ffffff' );
		$header_border    = sanitize_hex_color( isset( $opts['header_border_color'] ) ? $opts['header_border_color'] : '#f3f4f6' );
		
		$sticky_height    = absint( isset( $opts['sticky_header_height'] ) ? $opts['sticky_header_height'] : 64 );
		$sticky_logo_h    = absint( isset( $opts['sticky_logo_height'] ) ? $opts['sticky_logo_height'] : 40 );
		$sticky_bg        = sanitize_hex_color( isset( $opts['sticky_bg_color'] ) ? $opts['sticky_bg_color'] : '#ffffff' );
		$sticky_border    = sanitize_hex_color( isset( $opts['sticky_border_color'] ) ? $opts['sticky_border_color'] : '#e5e7eb' );

		$menu_text_color  = sanitize_hex_color( isset( $opts['menu_text_color'] ) ? $opts['menu_text_color'] : '#374151' );
		$menu_hover_color = sanitize_hex_color( isset( $opts['menu_hover_color'] ) ? $opts['menu_hover_color'] : '#ec4899' );

		$nav_bg           = esc_attr( isset( $opts['nav_bg_color'] ) ? $opts['nav_bg_color'] : 'transparent' );
		$nav_sticky_bg    = esc_attr( isset( $opts['nav_sticky_bg_color'] ) ? $opts['nav_sticky_bg_color'] : 'transparent' );
		$nav_border_top_w = absint( isset( $opts['nav_border_top_width'] ) ? $opts['nav_border_top_width'] : 1 );
		$nav_border_top_c = sanitize_hex_color( isset( $opts['nav_border_top_color'] ) ? $opts['nav_border_top_color'] : '#f3f4f6' );

		$search_height         = absint( isset( $opts['search_height'] ) ? $opts['search_height'] : 44 );
		$search_font_size      = absint( isset( $opts['search_font_size'] ) ? $opts['search_font_size'] : 14 );
		$search_text_color     = sanitize_hex_color( isset( $opts['search_text_color'] ) ? $opts['search_text_color'] : '#111827' );
		$search_placeholder    = sanitize_hex_color( isset( $opts['search_placeholder_color'] ) ? $opts['search_placeholder_color'] : '#9ca3af' );
		$search_bg             = sanitize_hex_color( isset( $opts['search_bg_color'] ) ? $opts['search_bg_color'] : '#f3f4f6' );
		$search_focus_bg       = sanitize_hex_color( isset( $opts['search_focus_bg_color'] ) ? $opts['search_focus_bg_color'] : '#ffffff' );
		$search_radius         = absint( isset( $opts['search_border_radius'] ) ? $opts['search_border_radius'] : 9999 );
		$search_border_w       = absint( isset( $opts['search_border_width'] ) ? $opts['search_border_width'] : 1 );
		$search_focus_border_w = absint( isset( $opts['search_focus_border_width'] ) ? $opts['search_focus_border_width'] : 2 );
		$search_border_c       = sanitize_hex_color( isset( $opts['search_border_color'] ) ? $opts['search_border_color'] : '#e5e7eb' );
		$search_focus_border_c = sanitize_hex_color( isset( $opts['search_focus_border_color'] ) ? $opts['search_focus_border_color'] : '#ec4899' );

		$action_icon_size  = absint( isset( $opts['header_action_icon_size'] ) ? $opts['header_action_icon_size'] : 20 );
		$action_font_size  = absint( isset( $opts['header_action_font_size'] ) ? $opts['header_action_font_size'] : 13 );
		$action_radius     = absint( isset( $opts['header_action_radius'] ) ? $opts['header_action_radius'] : 8 );
		
		$action_icon_c       = esc_attr( isset( $opts['header_action_icon_color'] ) ? $opts['header_action_icon_color'] : '#374151' );
		$action_icon_hover_c = esc_attr( isset( $opts['header_action_icon_hover_color'] ) ? $opts['header_action_icon_hover_color'] : '#ec4899' );
		$action_text_c       = esc_attr( isset( $opts['header_action_text_color'] ) ? $opts['header_action_text_color'] : '#374151' );
		$action_text_hover_c = esc_attr( isset( $opts['header_action_text_hover_color'] ) ? $opts['header_action_text_hover_color'] : '#ec4899' );
		$action_bg           = esc_attr( isset( $opts['header_action_bg_color'] ) ? $opts['header_action_bg_color'] : 'transparent' );
		$action_bg_hover     = esc_attr( isset( $opts['header_action_bg_hover_color'] ) ? $opts['header_action_bg_hover_color'] : '#f3f4f6' );
		$action_border       = esc_attr( isset( $opts['header_action_border_color'] ) ? $opts['header_action_border_color'] : 'transparent' );

		echo '<style id="pooki-header-dynamic-vars">';
		echo ':root {';
		echo '--pooki-topbar-h: ' . esc_attr( $topbar_height ) . 'px;';
		echo '--pooki-topbar-bg: ' . esc_attr( $topbar_bg ) . ';';
		echo '--pooki-topbar-color: ' . esc_attr( $topbar_color ) . ';';

		echo '--pooki-header-h: ' . esc_attr( $header_height ) . 'px;';
		echo '--pooki-logo-h: ' . esc_attr( $logo_height ) . 'px;';
		echo '--pooki-header-bg: ' . esc_attr( $header_bg ) . ';';
		echo '--pooki-header-border: ' . esc_attr( $header_border ) . ';';

		echo '--pooki-sticky-h: ' . esc_attr( $sticky_height ) . 'px;';
		echo '--pooki-sticky-logo-h: ' . esc_attr( $sticky_logo_h ) . 'px;';
		echo '--pooki-sticky-bg: ' . esc_attr( $sticky_bg ) . ';';
		echo '--pooki-sticky-border: ' . esc_attr( $sticky_border ) . ';';

		echo '--pooki-menu-color: ' . esc_attr( $menu_text_color ) . ';';
		echo '--pooki-menu-hover-color: ' . esc_attr( $menu_hover_color ) . ';';

		echo '--pooki-nav-bg: ' . esc_attr( $nav_bg ) . ';';
		echo '--pooki-nav-sticky-bg: ' . esc_attr( $nav_sticky_bg ) . ';';
		echo '--pooki-nav-border-top-w: ' . esc_attr( $nav_border_top_w ) . 'px;';
		echo '--pooki-nav-border-top-c: ' . esc_attr( $nav_border_top_c ) . ';';

		echo '--pooki-search-h: ' . esc_attr( $search_height ) . 'px;';
		echo '--pooki-search-font-size: ' . esc_attr( $search_font_size ) . 'px;';
		echo '--pooki-search-color: ' . esc_attr( $search_text_color ) . ';';
		echo '--pooki-search-placeholder: ' . esc_attr( $search_placeholder ) . ';';
		echo '--pooki-search-bg: ' . esc_attr( $search_bg ) . ';';
		echo '--pooki-search-focus-bg: ' . esc_attr( $search_focus_bg ) . ';';
		echo '--pooki-search-radius: ' . esc_attr( $search_radius ) . 'px;';
		echo '--pooki-search-border-w: ' . esc_attr( $search_border_w ) . 'px;';
		echo '--pooki-search-focus-border-w: ' . esc_attr( $search_focus_border_w ) . 'px;';
		echo '--pooki-search-border-c: ' . esc_attr( $search_border_c ) . ';';
		echo '--pooki-search-focus-border-c: ' . esc_attr( $search_focus_border_c ) . ';';

		echo '--pooki-action-icon-size: ' . esc_attr( $action_icon_size ) . 'px;';
		echo '--pooki-action-font-size: ' . esc_attr( $action_font_size ) . 'px;';
		echo '--pooki-action-radius: ' . esc_attr( $action_radius ) . 'px;';
		echo '--pooki-action-icon-c: ' . esc_attr( $action_icon_c ) . ';';
		echo '--pooki-action-icon-hover-c: ' . esc_attr( $action_icon_hover_c ) . ';';
		echo '--pooki-action-text-c: ' . esc_attr( $action_text_c ) . ';';
		echo '--pooki-action-text-hover-c: ' . esc_attr( $action_text_hover_c ) . ';';
		echo '--pooki-action-bg: ' . esc_attr( $action_bg ) . ';';
		echo '--pooki-action-bg-hover: ' . esc_attr( $action_bg_hover ) . ';';
		echo '--pooki-action-border: ' . esc_attr( $action_border ) . ';';
		echo '}';
		echo '</style>';
	}

	/**
	 * Render the Admin Page UI.
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'header';
		?>
		<div class="wrap pooki-admin-wrap">
			<h1>تنظیمات قالب پوکی</h1>

			<style>
				.pooki-admin-wrap { font-family: Tahoma, sans-serif; }
				.pooki-admin-wrap .form-table {
					display: grid;
					grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
					gap: 20px;
					background: #fff;
					padding: 24px;
					border-radius: 12px;
					border: 1px solid #e2e8f0;
					box-shadow: 0 1px 3px rgba(0,0,0,0.05);
					margin-bottom: 30px;
					margin-top: 15px;
				}
				.pooki-admin-wrap .form-table tbody { display: contents; }
				.pooki-admin-wrap .form-table tr {
					display: flex;
					flex-direction: column;
					background: #f8fafc;
					padding: 16px;
					border-radius: 8px;
					border: 1px solid #e2e8f0;
				}
				.pooki-admin-wrap .form-table th {
					padding: 0 0 10px 0;
					width: auto;
					font-weight: 600;
					color: #1e293b;
				}
				.pooki-admin-wrap .form-table td { padding: 0; }
				.pooki-admin-wrap > h2:not(.nav-tab-wrapper) {
					background: #1e293b;
					color: #fff;
					display: block;
					padding: 12px 16px;
					border-radius: 8px;
					font-size: 16px;
					margin-top: 2rem;
					margin-bottom: -10px;
					box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
				}
				@media (max-width: 1024px) {
					.pooki-admin-wrap .form-table {
						grid-template-columns: 1fr;
					}
				}
				.pooki-admin-wrap input[type="number"], 
				.pooki-admin-wrap input[type="text"], 
				.pooki-admin-wrap select {
					width: 100%;
					border-radius: 6px;
					border: 1px solid #cbd5e1;
					padding: 6px 12px;
				}
				.pooki-admin-wrap input[type="color"] {
					height: 36px;
					width: 100%;
					padding: 2px;
					border-radius: 6px;
					cursor: pointer;
				}
			</style>
			
			<h2 class="nav-tab-wrapper">
				<a href="?page=pooki-settings&tab=header" class="nav-tab <?php echo $active_tab == 'header' ? 'nav-tab-active' : ''; ?>">سربرگ</a>
			</h2>

			<!-- Success Toast Container -->
			<div id="pooki-toast" style="display: none; padding: 12px 20px; background: #4caf50; color: white; border-radius: 4px; margin-top: 15px; font-weight: bold;"></div>

			<div class="pooki-json-importer" style="margin-top: 20px; background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
				<h3 style="margin-top:0; color: #1e293b;">درون‌ریزی پالت رنگ (JSON)</h3>
				<p style="color: #64748b; font-size: 13px;">یک شیء JSON حاوی کلید رنگ‌ها و مقادیر Hex وارد کنید.</p>
				<textarea id="pooki-json-palette" rows="3" style="width: 100%; font-family: monospace; direction: ltr; border-radius: 6px; border: 1px solid #cbd5e1; padding: 10px;" placeholder='{"header_bg_color":"#ffffff", "menu_text_color":"#1f2937"}'></textarea>
				<button type="button" id="pooki-import-json-btn" class="button button-secondary" style="margin-top: 10px;">اعمال رنگ‌ها</button>
				<span id="pooki-json-status" style="margin-right: 10px; font-weight: bold;"></span>
			</div>

			<form id="pooki-settings-form" action="options.php" method="post" style="padding-bottom: 80px;">
				<?php
				settings_fields( 'pooki_options_group' );
				
				if ( $active_tab == 'header' ) {
					do_settings_sections( 'pooki-settings-header' );
				} else {
					do_settings_sections( 'pooki-settings' );
				}
				?>
				<div class="pooki-sticky-save-bar" style="position: fixed; bottom: 0; left: 0; right: 0; background: #fff; padding: 15px 30px; border-top: 1px solid #e2e8f0; box-shadow: 0 -4px 6px -1px rgba(0,0,0,0.05); z-index: 50; display: flex; justify-content: flex-end; align-items: center; margin-right: 160px;">
					<span id="pooki-save-status" style="margin-left: 15px; font-weight: bold; display: none;"></span>
					<?php submit_button( 'ذخیره تغییرات', 'primary', 'submit', false, [ 'style' => 'font-size: 16px; padding: 8px 32px; border-radius: 8px;' ] ); ?>
				</div>
			</form>
		</div>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			
			// Media Uploader
			let file_frame;
			const uploadButtons = document.querySelectorAll('.pooki-upload-button');
			const removeButtons = document.querySelectorAll('.pooki-remove-button');

			uploadButtons.forEach(button => {
				button.addEventListener('click', function(e) {
					e.preventDefault();
					const targetInput = document.getElementById(this.dataset.target);
					const previewDiv = document.getElementById(this.dataset.preview);

					if (file_frame) {
						file_frame.open();
						return;
					}

					file_frame = wp.media({
						title: 'انتخاب تصویر',
						button: {
							text: 'استفاده از این تصویر'
						},
						multiple: false
					});

					file_frame.on('select', function() {
						const attachment = file_frame.state().get('selection').first().toJSON();
						targetInput.value = attachment.url;
						previewDiv.innerHTML = '<img src="' + attachment.url + '" style="max-width: 100%; max-height: 100%; object-fit: contain;" />';
					});

					file_frame.open();
				});
			});

			removeButtons.forEach(button => {
				button.addEventListener('click', function(e) {
					e.preventDefault();
					const targetInput = document.getElementById(this.dataset.target);
					const previewDiv = document.getElementById(this.dataset.preview);
					targetInput.value = '';
					previewDiv.innerHTML = '<span style="color: #999; font-size: 12px;">بدون تصویر</span>';
				});
			});

			// Header Actions Repeater Logic
			const repeaterInput = document.getElementById('pooki_repeater_header_action_items');
			if (repeaterInput) {
				const repeaterUI = document.getElementById('pooki_repeater_ui_header_action_items');
				let items = [];
				try {
					items = JSON.parse(repeaterInput.value) || [];
				} catch(e) {
					items = [];
				}

				function renderRepeater() {
					repeaterUI.innerHTML = '';
					items.forEach((item, index) => {
						const box = document.createElement('div');
						box.style.border = '1px solid #cbd5e1';
						box.style.background = '#fff';
						box.style.padding = '15px';
						box.style.marginBottom = '10px';
						box.style.borderRadius = '8px';
						box.innerHTML = `
							<div style="display: flex; gap: 10px; margin-bottom: 10px;">
								<select class="item-type" data-index="${index}" style="min-width: 150px;">
									<option value="cart" ${item.type === 'cart' ? 'selected' : ''}>سبد خرید (Cart)</option>
									<option value="account" ${item.type === 'account' ? 'selected' : ''}>حساب کاربری (Account)</option>
									<option value="custom" ${item.type === 'custom' ? 'selected' : ''}>سفارشی (Custom)</option>
								</select>
								<input type="text" class="item-label regular-text" placeholder="عنوان (اختیاری)" data-index="${index}" value="${item.label ? item.label.replace(/"/g, '&quot;') : ''}">
								<input type="text" class="item-url regular-text" placeholder="آدرس لینک (برای سفارشی)" data-index="${index}" value="${item.url ? item.url.replace(/"/g, '&quot;') : ''}">
							</div>
							<div>
								<textarea class="item-svg large-text" placeholder="کد SVG آیکون (اختیاری - پیش‌فرض استفاده خواهد شد)" data-index="${index}" style="height:60px; font-family: monospace; direction: ltr;">${item.icon_svg ? item.icon_svg : ''}</textarea>
							</div>
							<div style="text-align: left; margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
								<div style="display: flex; gap: 5px;">
									<button type="button" class="button button-secondary move-up" data-index="${index}" ${index === 0 ? 'disabled' : ''}>▲ بالا</button>
									<button type="button" class="button button-secondary move-down" data-index="${index}" ${index === items.length - 1 ? 'disabled' : ''}>▼ پایین</button>
								</div>
								<button type="button" class="button button-link-delete remove-item" data-index="${index}">حذف این دکمه</button>
							</div>
						`;
						repeaterUI.appendChild(box);
					});

					const addBtn = document.createElement('button');
					addBtn.type = 'button';
					addBtn.className = 'button button-primary';
					addBtn.innerText = '+ افزودن دکمه جدید';
					addBtn.addEventListener('click', () => {
						items.push({ type: 'custom', label: '', url: '', icon_svg: '' });
						updateHiddenAndRender();
					});
					repeaterUI.appendChild(addBtn);

					// Bind events
					repeaterUI.querySelectorAll('.item-type').forEach(el => el.addEventListener('change', updateItem));
					repeaterUI.querySelectorAll('.item-label').forEach(el => el.addEventListener('input', updateItem));
					repeaterUI.querySelectorAll('.item-url').forEach(el => el.addEventListener('input', updateItem));
					repeaterUI.querySelectorAll('.item-svg').forEach(el => el.addEventListener('input', updateItem));
					repeaterUI.querySelectorAll('.remove-item').forEach(el => {
						el.addEventListener('click', (e) => {
							const idx = parseInt(e.target.dataset.index, 10);
							items.splice(idx, 1);
							updateHiddenAndRender();
						});
					});
					repeaterUI.querySelectorAll('.move-up').forEach(el => {
						el.addEventListener('click', (e) => {
							const idx = parseInt(e.target.dataset.index, 10);
							if (idx > 0) {
								const temp = items[idx - 1];
								items[idx - 1] = items[idx];
								items[idx] = temp;
								updateHiddenAndRender();
							}
						});
					});
					repeaterUI.querySelectorAll('.move-down').forEach(el => {
						el.addEventListener('click', (e) => {
							const idx = parseInt(e.target.dataset.index, 10);
							if (idx < items.length - 1) {
								const temp = items[idx + 1];
								items[idx + 1] = items[idx];
								items[idx] = temp;
								updateHiddenAndRender();
							}
						});
					});
				}

				function updateItem(e) {
					const idx = parseInt(e.target.dataset.index, 10);
					if (e.target.classList.contains('item-type')) items[idx].type = e.target.value;
					if (e.target.classList.contains('item-label')) items[idx].label = e.target.value;
					if (e.target.classList.contains('item-url')) items[idx].url = e.target.value;
					if (e.target.classList.contains('item-svg')) items[idx].icon_svg = e.target.value;
					repeaterInput.value = JSON.stringify(items);
				}

				function updateHiddenAndRender() {
					repeaterInput.value = JSON.stringify(items);
					renderRepeater();
				}

				renderRepeater();
			}

			// JSON Importer
			const jsonImportBtn = document.getElementById('pooki-import-json-btn');
			if (jsonImportBtn) {
				jsonImportBtn.addEventListener('click', function() {
					const val = document.getElementById('pooki-json-palette').value;
					const status = document.getElementById('pooki-json-status');
					try {
						const data = JSON.parse(val);
						let count = 0;
						for (const key in data) {
							const input = document.querySelector(`input[name="pooki_theme_options[${key}]"]`);
							if (input && input.type === 'color') {
								input.value = data[key];
								input.style.boxShadow = '0 0 0 2px #4caf50';
								setTimeout(() => input.style.boxShadow = 'none', 2000);
								count++;
							}
						}
						status.style.color = '#4caf50';
						status.innerText = `${count} رنگ با موفقیت اعمال شد. فراموش نکنید تنظیمات را ذخیره کنید.`;
					} catch (e) {
						status.style.color = '#f44336';
						status.innerText = 'خطا در فرمت JSON';
					}
				});
			}

			// AJAX Save
			document.getElementById('pooki-settings-form').addEventListener('submit', function(e) {
				e.preventDefault();
				const form = this;
				const formData = new FormData(form);
				formData.append('action', 'pooki_save_theme_options');

				const submitBtn = form.querySelector('input[type="submit"]');
				submitBtn.disabled = true;
				submitBtn.value = 'در حال ذخیره...';

				fetch(ajaxurl, {
					method: 'POST',
					body: formData
				})
				.then(res => res.json())
				.then(response => {
					const toast = document.getElementById('pooki-toast');
					const status = document.getElementById('pooki-save-status');
					toast.style.display = 'block';
					status.style.display = 'inline-block';
					
					if (response.success) {
						toast.style.background = '#4caf50';
						toast.innerText = response.data.message || 'تنظیمات ذخیره شد.';
						status.style.color = '#4caf50';
						status.innerText = 'تغییرات ذخیره شد!';
					} else {
						toast.style.background = '#f44336';
						toast.innerText = response.data || 'خطایی رخ داده است.';
						status.style.color = '#f44336';
						status.innerText = 'خطا در ذخیره‌سازی';
					}

					setTimeout(() => {
						toast.style.display = 'none';
						status.style.display = 'none';
					}, 3000);
				})
				.catch(err => {
					console.error(err);
					alert('خطای ارتباط با سرور.');
				})
				.finally(() => {
					submitBtn.disabled = false;
					submitBtn.value = 'ذخیره تغییرات';
				});
			});
		});
		</script>
		<?php
	}
}
