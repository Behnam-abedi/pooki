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
		add_action( 'wp_ajax_pooki_import_theme_options', [ $this, 'ajax_import_options' ] );
		add_action( 'wp_head', [ $this, 'inject_dynamic_css' ], 100 );
		add_filter( 'body_class', [ $this, 'mobile_bottom_bar_body_class' ] );
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
		add_settings_field( 'topbar_hide_mobile', 'مخفی کردن در موبایل', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_topbar_section', [ 'id' => 'topbar_hide_mobile', 'default' => 1 ] );
		add_settings_field( 'topbar_height', 'ارتفاع (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_topbar_section', [ 'id' => 'topbar_height', 'default' => 36 ] );
		add_settings_field( 'topbar_content', 'محتوای نوار اعلان (HTML مجاز است)', [ $this, 'render_textarea_field' ], 'pooki-settings-header', 'pooki_topbar_section', [ 'id' => 'topbar_content', 'default' => 'تلفن تماس: ۰۲۱-۱۲۳۴۵۶۷۸ | ارسال رایگان برای خریدهای بالای ۱ میلیون تومان', 'class' => 'pooki-full-width-field' ] );

		// Header Section
		add_settings_section( 'pooki_header_section', 'تنظیمات سربرگ', null, 'pooki-settings-header' );

		add_settings_field( 'logo_url', 'تصویر لوگو', [ $this, 'render_media_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'logo_url' ] );
		add_settings_field( 'header_height', 'ارتفاع سربرگ (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'header_height', 'default' => 80 ] );
		add_settings_field( 'logo_height', 'ارتفاع لوگو (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'logo_height', 'default' => 48 ] );
		add_settings_field( 'header_shadow', 'سایه سربرگ', [ $this, 'render_select_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'header_shadow', 'options' => [ 'none' => 'بدون سایه', 'sm' => 'کوچک', 'md' => 'متوسط', 'lg' => 'بزرگ' ], 'default' => 'sm' ] );
		

		// Navigation Row Section
		add_settings_section( 'pooki_nav_section', 'نوار ناوبری (منو)', null, 'pooki-settings-header' );

		add_settings_field( 'nav_border_top_width', 'ضخامت حاشیه بالا (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_nav_section', [ 'id' => 'nav_border_top_width', 'default' => 1 ] );

		// Sticky Header Section
		add_settings_section( 'pooki_sticky_header_section', 'تنظیمات هدر چسبان', null, 'pooki-settings-header' );

		add_settings_field( 'sticky_header_enabled', 'فعال‌سازی هدر چسبان', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_header_enabled' ] );
		add_settings_field( 'sticky_header_height', 'ارتفاع هدر چسبان (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_header_height', 'default' => 64 ] );
		add_settings_field( 'sticky_logo_height', 'ارتفاع لوگو چسبان (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_logo_height', 'default' => 40 ] );
		add_settings_field( 'sticky_shadow', 'سایه هدر چسبان', [ $this, 'render_select_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_shadow', 'options' => [ 'none' => 'بدون سایه', 'sm' => 'کوچک', 'md' => 'متوسط', 'lg' => 'بزرگ' ], 'default' => 'md' ] );

		// Search Bar Section
		add_settings_section( 'pooki_search_section', 'تنظیمات فرم جستجو', null, 'pooki-settings-header' );

		add_settings_field( 'search_height', 'ارتفاع فرم (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_height', 'default' => 44 ] );
		add_settings_field( 'search_font_size', 'اندازه متن (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_font_size', 'default' => 14 ] );
		add_settings_field( 'search_border_radius', 'گردی گوشه‌ها (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_border_radius', 'default' => 9999 ] );
		add_settings_field( 'search_border_width', 'ضخامت حاشیه عادی (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_border_width', 'default' => 1 ] );
		add_settings_field( 'search_focus_border_width', 'ضخامت حاشیه فوکوس (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_search_section', [ 'id' => 'search_focus_border_width', 'default' => 2 ] );

		// Header Actions Section
		add_settings_section( 'pooki_actions_section', 'تنظیمات دکمه‌های سربرگ', null, 'pooki-settings-header' );

		add_settings_field( 'header_action_icon_size', 'اندازه آیکون (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_icon_size', 'default' => 20 ] );
		add_settings_field( 'header_action_font_size', 'اندازه متن (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_font_size', 'default' => 13 ] );
		add_settings_field( 'header_action_radius', 'گردی گوشه‌ها (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_radius', 'default' => 8 ] );
		
		
		
		
		
		add_settings_field( 'header_action_items', 'مدیریت دکمه‌ها', [ $this, 'render_repeater_field' ], 'pooki-settings-header', 'pooki_actions_section', [ 'id' => 'header_action_items', 'class' => 'pooki-full-width-field' ] );

		// Mobile Navigation Section
		add_settings_section( 'pooki_mobile_nav_section', 'تنظیمات موبایل و نوار پایینی', null, 'pooki-settings-header' );

		// Mobile Header Actions
		add_settings_field( 'mobile_header_height', 'ارتفاع هدر موبایل (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_header_height', 'default' => 60 ] );
		add_settings_field( 'mobile_logo_height', 'حداکثر ارتفاع لوگو موبایل (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_logo_height', 'default' => 35 ] );
		add_settings_field( 'mobile_nav_header_search', 'نمایش جستجو در هدر موبایل', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_nav_header_search', 'default' => 1 ] );
		add_settings_field( 'mobile_nav_header_phone', 'نمایش دکمه تماس در هدر موبایل', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_nav_header_phone', 'default' => 0 ] );
		add_settings_field( 'mobile_nav_header_phone_number', 'شماره تماس', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_nav_header_phone_number', 'default' => '02112345678' ] );
		add_settings_field( 'mobile_nav_header_hamburger', 'نمایش منوی همبرگری', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_nav_header_hamburger', 'default' => 1 ] );

		// Mobile Bottom Bar Actions
		
		add_settings_field( 'mobile_bottom_bar_home', 'نمایش خانه', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_bottom_bar_home', 'default' => 1 ] );
		add_settings_field( 'bottom_bar_label_home', 'برچسب خانه', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'bottom_bar_label_home', 'default' => 'خانه' ] );
		
		add_settings_field( 'mobile_bottom_bar_shop', 'نمایش فروشگاه', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_bottom_bar_shop', 'default' => 1 ] );
		add_settings_field( 'bottom_bar_label_shop', 'برچسب فروشگاه', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'bottom_bar_label_shop', 'default' => 'فروشگاه' ] );
		
		add_settings_field( 'mobile_bottom_bar_cart', 'نمایش سبد خرید', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_bottom_bar_cart', 'default' => 1 ] );
		add_settings_field( 'bottom_bar_label_cart', 'برچسب سبد خرید', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'bottom_bar_label_cart', 'default' => 'سبد خرید' ] );
		
		add_settings_field( 'mobile_bottom_bar_account', 'نمایش حساب', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_bottom_bar_account', 'default' => 1 ] );
		add_settings_field( 'bottom_bar_label_account', 'برچسب حساب', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'bottom_bar_label_account', 'default' => 'حساب من' ] );
		
		add_settings_field( 'mobile_bottom_bar_search', 'نمایش جستجو', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_bottom_bar_search', 'default' => 0 ] );
		add_settings_field( 'bottom_bar_label_search', 'برچسب جستجو', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'bottom_bar_label_search', 'default' => 'جستجو' ] );

		add_settings_field( 'bottom_bar_shadow', 'سایه نوار پایین', [ $this, 'render_select_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 
			'id' => 'bottom_bar_shadow', 
			'default' => 'shadow-lg',
			'options' => [
				'none' => 'بدون سایه',
				'shadow-sm' => 'نرم (Soft)',
				'shadow-md' => 'متوسط (Medium)',
				'shadow-lg' => 'بزرگ (Strong)',
				'shadow-xl' => 'خیلی بزرگ (Extra Strong)'
			]
		] );
		add_settings_field( 'bottom_bar_dividers', 'فعال‌سازی جداکننده‌های عمودی', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'bottom_bar_dividers', 'default' => 0 ] );

		// Bottom Nav Advanced Borders & Active States
		add_settings_field( 'bottom_bar_border_thickness', 'ضخامت حاشیه نوار پایین', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'bottom_bar_border_thickness', 'default' => '1px' ] );

		// Mobile Header Heights
		add_settings_field( 'mobile_header_base_height', 'ارتفاع پایه هدر موبایل', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_header_base_height', 'default' => '70px' ] );
		add_settings_field( 'mobile_header_sticky_height', 'ارتفاع هدر موبایل چسبان', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_header_sticky_height', 'default' => '60px' ] );
		add_settings_field( 'mobile_logo_max_height', 'حداکثر ارتفاع لوگو موبایل', [ $this, 'render_text_field' ], 'pooki-settings-header', 'pooki_mobile_nav_section', [ 'id' => 'mobile_logo_max_height', 'default' => '40px' ] );

		// Unified Drawer Settings

	}


	/**
	 * Render Checkbox Field.
	 */
	public function render_checkbox_field( array $args ): void {
		$key     = $args['id'] ?? ($args['label_for'] ?? '');
		$options = get_option( 'pooki_theme_options', [] );
		$checked = ! empty( $options[ $key ] );
		$desc    = $args['description'] ?? '';

		printf(
			'<label class="pooki-toggle-switch"><input type="checkbox" id="%1$s" name="pooki_theme_options[%1$s]" value="1" %2$s /><span class="pooki-toggle-slider"></span> %3$s</label>',
			esc_attr( $key ),
			checked( $checked, true, false ),
			esc_html( $desc )
		);
	}

	/**
	 * Render Text Field.
	 */
	public function render_text_field( array $args ): void {
		$key         = $args['id'] ?? ($args['label_for'] ?? '');
		$options     = get_option( 'pooki_theme_options', [] );
		$value       = $options[ $key ] ?? ( $args['default'] ?? '' );
		$placeholder = $args['placeholder'] ?? '';
		$desc        = $args['description'] ?? '';

		printf(
			'<input type="text" id="%1$s" name="pooki_theme_options[%1$s]" value="%2$s" placeholder="%3$s" class="regular-text" />',
			esc_attr( $key ),
			esc_attr( $value ),
			esc_attr( $placeholder )
		);
		if ( $desc ) {
			printf( '<p class="description">%s</p>', esc_html( $desc ) );
		}
	}

	/**
	 * Render Number Field.
	 */
	public function render_number_field( array $args ): void {
		$key     = $args['id'] ?? ($args['label_for'] ?? '');
		$options = get_option( 'pooki_theme_options', [] );
		$value   = $options[ $key ] ?? ( $args['default'] ?? '' );
		$min     = isset( $args['min'] ) ? 'min="' . esc_attr( $args['min'] ) . '"' : '';
		$max     = isset( $args['max'] ) ? 'max="' . esc_attr( $args['max'] ) . '"' : '';
		$step    = isset( $args['step'] ) ? 'step="' . esc_attr( $args['step'] ) . '"' : '';

		printf(
			'<input type="number" id="%1$s" name="pooki_theme_options[%1$s]" value="%2$s" class="regular-text" %3$s %4$s %5$s />',
			esc_attr( $key ),
			esc_attr( $value ),
			$min,
			$max,
			$step
		);
	}

	/**
	 * Render Textarea Field.
	 */
	public function render_textarea_field( array $args ): void {
		$key     = $args['id'] ?? ($args['label_for'] ?? '');
		$options = get_option( 'pooki_theme_options', [] );
		$value   = $options[ $key ] ?? ( $args['default'] ?? '' );
		$class   = $args['class'] ?? 'large-text';

		printf(
			'<textarea id="%1$s" name="pooki_theme_options[%1$s]" class="%3$s" rows="4">%2$s</textarea>',
			esc_attr( $key ),
			esc_textarea( $value ),
			esc_attr( $class )
		);
	}

	/**
	 * Render Select Field.
	 */
	public function render_select_field( array $args ): void {
		$key     = $args['id'] ?? ($args['label_for'] ?? '');
		$options = get_option( 'pooki_theme_options', [] );
		$value   = $options[ $key ] ?? ( $args['default'] ?? '' );
		$choices = $args['options'] ?? ($args['choices'] ?? []);

		echo '<select id="' . esc_attr($key) . '" name="pooki_theme_options[' . esc_attr($key) . ']">';
		foreach ( $choices as $val => $label ) {
			echo '<option value="' . esc_attr( $val ) . '" ' . selected( $value, $val, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
	}

	/**
	 * Render Image/Media Field.
	 */
	public function render_image_field( array $args ): void {
		$this->render_media_field($args);
	}

	/**
	 * Render Media Field.
	 */
	public function render_media_field( array $args ): void {
		$key     = $args['id'] ?? ($args['label_for'] ?? '');
		$options = get_option( 'pooki_theme_options', [] );
		$value   = $options[ $key ] ?? '';

		echo '<div style="display:flex; align-items:center; gap:10px;">';
		echo '<input type="hidden" id="' . esc_attr($key) . '" name="pooki_theme_options[' . esc_attr($key) . ']" value="' . esc_attr($value) . '" />';
		echo '<button type="button" class="button pooki-upload-button" data-target="' . esc_attr($key) . '" data-preview="preview-' . esc_attr($key) . '">انتخاب تصویر</button>';
		echo '<button type="button" class="button pooki-remove-button" data-target="' . esc_attr($key) . '" data-preview="preview-' . esc_attr($key) . '">حذف</button>';
		echo '<div id="preview-' . esc_attr($key) . '" style="width: 50px; height: 50px; border: 1px solid #ddd; display: flex; justify-content: center; align-items: center; background: #fafafa;">';
		if ( $value ) {
			echo '<img src="' . esc_url($value) . '" style="max-width:100%; max-height:100%; object-fit:contain;" />';
		} else {
			echo '<span style="color:#999; font-size:12px;">بدون تصویر</span>';
		}
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Render Repeater Field.
	 */
	public function render_repeater_field( array $args ): void {
		$id      = $args['id'];
		$options = get_option( 'pooki_theme_options', [] );
		$value   = isset( $options[ $id ] ) && is_array( $options[ $id ] ) ? $options[ $id ] : [];
		$json_value = wp_json_encode( $value );

		echo '<input type="hidden" id="pooki_repeater_' . esc_attr( $id ) . '" name="pooki_theme_options[' . esc_attr( $id ) . ']" value="' . esc_attr( $json_value ) . '" />';
		echo '<div id="pooki_repeater_ui_' . esc_attr( $id ) . '"></div>';
	}

	/**
	 * Handle AJAX import of theme options.
	 */
	public function ajax_import_options() {
		// Verify capability
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'شما دسترسی لازم را ندارید.' );
		}

		// Verify nonce
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pooki_options_group-options' ) ) {
			wp_send_json_error( 'مشکل امنیتی (Nonce). لطفاً صفحه را رفرش کنید.' );
		}

		if ( empty( $_POST['import_data'] ) ) {
			wp_send_json_error( 'اطلاعاتی ارسال نشد.' );
		}

		$json_data = json_decode( wp_unslash( $_POST['import_data'] ), true );

		if ( ! is_array( $json_data ) || empty( $json_data['theme'] ) || $json_data['theme'] !== 'pooki' || empty( $json_data['options'] ) ) {
			wp_send_json_error( 'فرمت فایل پشتیبان نامعتبر است یا متعلق به این قالب نیست.' );
		}

		if ( isset( $json_data['options']['pooki_theme_options'] ) && is_array( $json_data['options']['pooki_theme_options'] ) ) {
			update_option( 'pooki_theme_options', $json_data['options']['pooki_theme_options'] );
		}

		if ( isset( $json_data['options']['pooki_color_palette'] ) && is_array( $json_data['options']['pooki_color_palette'] ) && class_exists( '\Pooki\Core\ColorRegistry' ) ) {
			$sanitized_colors = \Pooki\Core\ColorRegistry::get_instance()->sanitize_palette( $json_data['options']['pooki_color_palette'] );
			update_option( 'pooki_color_palette', $sanitized_colors );
		}

		wp_send_json_success( 'تنظیمات با موفقیت بازگردانی شد. صفحه رفرش می‌شود...' );
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
				'topbar_hide_mobile'    => 'bool',
				'topbar_height'         => 'int',
				'topbar_content'        => 'html',

				'logo_url'              => 'url',
				'header_height'         => 'int',
				'logo_height'           => 'int',
				'header_shadow'         => 'key',
				'nav_border_top_width'  => 'int',
				'sticky_header_enabled' => 'bool',
				'sticky_header_height'  => 'int',
				'sticky_logo_height'    => 'int',
				'sticky_shadow'         => 'key',
				
				'search_height'         => 'int',
				'search_font_size'      => 'int',
				'search_border_radius'  => 'int',
				'search_border_width'   => 'int',
				'search_focus_border_width' => 'int',
				'header_action_icon_size'          => 'int',
				'header_action_font_size'          => 'int',
				'header_action_radius'             => 'int',
				'header_action_items'              => 'repeater',

				'mobile_header_height'             => 'int',
				'mobile_logo_height'               => 'int',
				'mobile_nav_header_search'         => 'bool',
				'mobile_nav_header_phone'          => 'bool',
				'mobile_nav_header_phone_number'   => 'text',
				'mobile_nav_header_hamburger'      => 'bool',
				
				'mobile_bottom_bar_home'           => 'bool',
				'bottom_bar_label_home'            => 'text',
				'mobile_bottom_bar_shop'           => 'bool',
				'bottom_bar_label_shop'            => 'text',
				'mobile_bottom_bar_cart'           => 'bool',
				'bottom_bar_label_cart'            => 'text',
				'mobile_bottom_bar_account'        => 'bool',
				'bottom_bar_label_account'         => 'text',
				'mobile_bottom_bar_search'         => 'bool',
				'bottom_bar_label_search'          => 'text',
				
				'bottom_bar_shadow'                => 'text',
				'bottom_bar_dividers'              => 'bool',
				'bottom_bar_border_thickness'      => 'text',
				'mobile_header_base_height'        => 'text',
				'mobile_header_sticky_height'      => 'text',
				'mobile_logo_max_height'           => 'text',
				
				];

			foreach ( $fields as $field => $type ) {
				if ( 'bool' === $type ) {
					$options[ $field ] = isset( $posted[ $field ] ) ? 1 : 0;
					continue;
				}

				if ( isset( $posted[ $field ] ) ) {
					if ( 'int' === $type ) {
						$options[ $field ] = absint( $posted[ $field ] );
					} elseif ( 'text' === $type ) {
						$options[ $field ] = sanitize_text_field( $posted[ $field ] );
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

			// Save Color Palette
			if ( isset( $_POST['pooki_color_palette'] ) && class_exists( '\Pooki\Core\ColorRegistry' ) ) {
				$sanitized_colors = \Pooki\Core\ColorRegistry::get_instance()->sanitize_palette( wp_unslash( $_POST['pooki_color_palette'] ) );
				update_option( 'pooki_color_palette', $sanitized_colors );
			}

			$export_data = [
				'theme'     => 'pooki',
				'version'   => '1.0.0',
				'timestamp' => current_time( 'mysql' ),
				'options'   => [
					'pooki_theme_options' => get_option( 'pooki_theme_options', [] ),
					'pooki_color_palette' => get_option( 'pooki_color_palette', [] )
				]
			];
			$json_export = wp_json_encode( $export_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );

			wp_send_json_success( [ 'message' => 'تنظیمات با موفقیت ذخیره شد!', 'export_json' => $json_export ] );
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
		$mobile_header_h  = absint( isset( $opts['mobile_header_height'] ) ? $opts['mobile_header_height'] : 60 );
		$mobile_logo_h    = absint( isset( $opts['mobile_logo_height'] ) ? $opts['mobile_logo_height'] : 35 );
		
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

		$bottom_bar_bg       = sanitize_hex_color( isset( $opts['bottom_bar_bg_color'] ) ? $opts['bottom_bar_bg_color'] : '#ffffff' );
		$bottom_bar_icon     = sanitize_hex_color( isset( $opts['bottom_bar_icon_color'] ) ? $opts['bottom_bar_icon_color'] : '#6b7280' );
		$bottom_bar_icon_a   = sanitize_hex_color( isset( $opts['bottom_bar_icon_active_color'] ) ? $opts['bottom_bar_icon_active_color'] : '#8b5cf6' );

		$bottom_bar_shadow   = esc_attr( isset( $opts['bottom_bar_shadow'] ) ? $opts['bottom_bar_shadow'] : 'shadow-lg' );
		$bottom_bar_divider_color = sanitize_hex_color( isset( $opts['bottom_bar_divider_color'] ) ? $opts['bottom_bar_divider_color'] : '#EBE4D8' );

		$bottom_bar_border_w   = esc_attr( isset( $opts['bottom_bar_border_thickness'] ) ? $opts['bottom_bar_border_thickness'] : '1px' );
		$bottom_bar_border_c   = sanitize_hex_color( isset( $opts['bottom_bar_border_color'] ) ? $opts['bottom_bar_border_color'] : '#e5e7eb' );
		$bottom_bar_active_bg  = sanitize_hex_color( isset( $opts['bottom_bar_active_bg'] ) ? $opts['bottom_bar_active_bg'] : '#FDFBF7' );
		$bottom_bar_active_txt = sanitize_hex_color( isset( $opts['bottom_bar_active_text'] ) ? $opts['bottom_bar_active_text'] : '#8C6D53' );

		$mobile_hdr_base_h     = esc_attr( isset( $opts['mobile_header_base_height'] ) ? $opts['mobile_header_base_height'] : '70px' );
		$mobile_hdr_sticky_h   = esc_attr( isset( $opts['mobile_header_sticky_height'] ) ? $opts['mobile_header_sticky_height'] : '60px' );
		$mobile_logo_max_h     = esc_attr( isset( $opts['mobile_logo_max_height'] ) ? $opts['mobile_logo_max_height'] : '40px' );

		// Fallback to legacy search_modal_bg_color if drawer_bg_color is missing
		$drawer_bg       = sanitize_hex_color( isset( $opts['drawer_bg_color'] ) ? $opts['drawer_bg_color'] : (isset($opts['search_modal_bg_color']) ? $opts['search_modal_bg_color'] : '#FAF7F2') );
		$drawer_text     = sanitize_hex_color( isset( $opts['drawer_text_color'] ) ? $opts['drawer_text_color'] : (isset($opts['search_modal_text_color']) ? $opts['search_modal_text_color'] : '#1f2937') );

		$search_modal_input_bg = sanitize_hex_color( isset( $opts['search_modal_input_bg_color'] ) ? $opts['search_modal_input_bg_color'] : '#FDFBF7' );
		$search_modal_input_border = sanitize_hex_color( isset( $opts['search_modal_input_border_color'] ) ? $opts['search_modal_input_border_color'] : '#EBE4D8' );

		echo '<style id="pooki-header-dynamic-vars">';
		echo ':root {';
		echo '--pooki-topbar-h: ' . esc_attr( $topbar_height ) . 'px;';
		echo '--pooki-topbar-bg: ' . esc_attr( $topbar_bg ) . ';';
		echo '--pooki-topbar-color: ' . esc_attr( $topbar_color ) . ';';

		echo '--pooki-header-h: ' . esc_attr( $header_height ) . 'px;';
		echo '--pooki-logo-h: ' . esc_attr( $logo_height ) . 'px;';
		echo '--pooki-mobile-header-h: ' . esc_attr( $mobile_header_h ) . 'px;';
		echo '--pooki-mobile-logo-h: ' . esc_attr( $mobile_logo_h ) . 'px;';
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

		echo '--pooki-bottom-bar-bg: ' . esc_attr( $bottom_bar_bg ) . ';';
		echo '--pooki-bottom-bar-icon-c: ' . esc_attr( $bottom_bar_icon ) . ';';
		echo '--pooki-bottom-bar-icon-active-c: ' . esc_attr( $bottom_bar_icon_a ) . ';';
		echo '--pooki-bottom-bar-divider: ' . esc_attr( $bottom_bar_divider_color ) . ';';

		// Shadow map helper
		$shadow_map = [
			'none' => 'none',
			'shadow-sm' => '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
			'shadow-md' => '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
			'shadow-lg' => '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
			'shadow-xl' => '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)'
		];
		$shadow_val = isset($shadow_map[$bottom_bar_shadow]) ? $shadow_map[$bottom_bar_shadow] : $shadow_map['shadow-lg'];
		echo '--pooki-bottom-nav-shadow: ' . esc_attr( $shadow_val ) . ';';
		
		echo '--pooki-bottom-nav-border-w: ' . esc_attr( $bottom_bar_border_w ) . ';';
		echo '--pooki-bottom-nav-border-c: ' . esc_attr( $bottom_bar_border_c ) . ';';
		echo '--pooki-bottom-nav-active-bg: ' . esc_attr( $bottom_bar_active_bg ) . ';';
		echo '--pooki-bottom-nav-active-text: ' . esc_attr( $bottom_bar_active_txt ) . ';';

		echo '--pooki-mobile-header-h: ' . esc_attr( $mobile_hdr_base_h ) . ';';
		echo '--pooki-mobile-header-sticky-h: ' . esc_attr( $mobile_hdr_sticky_h ) . ';';
		echo '--pooki-mobile-logo-max-h: ' . esc_attr( $mobile_logo_max_h ) . ';';

		echo '--pooki-drawer-bg: ' . esc_attr( $drawer_bg ) . ';';
		echo '--pooki-drawer-text: ' . esc_attr( $drawer_text ) . ';';
		echo '--pooki-search-modal-input-bg: ' . esc_attr( $search_modal_input_bg ) . ';';
		echo '--pooki-search-modal-input-border: ' . esc_attr( $search_modal_input_border ) . ';';
		echo '}';
		echo '</style>';
	}

	/**
	 * Add body padding for mobile bottom bar
	 */
	public function mobile_bottom_bar_body_class( $classes ) {
		$opts = get_option( 'pooki_theme_options', [] );
		$has_home = isset($opts['mobile_bottom_bar_home']) ? $opts['mobile_bottom_bar_home'] : 1;
		$has_shop = isset($opts['mobile_bottom_bar_shop']) ? $opts['mobile_bottom_bar_shop'] : 1;
		$has_cart = isset($opts['mobile_bottom_bar_cart']) ? $opts['mobile_bottom_bar_cart'] : 1;
		$has_acc  = isset($opts['mobile_bottom_bar_account']) ? $opts['mobile_bottom_bar_account'] : 1;
		$has_srch = isset($opts['mobile_bottom_bar_search']) ? $opts['mobile_bottom_bar_search'] : 0;

		if ( $has_home || $has_shop || $has_cart || $has_acc || $has_srch ) {
			$classes[] = 'pb-16 md:pb-0';
		}
		return $classes;
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
				.pooki-admin-wrap .form-table tr.pooki-full-width-field {
					grid-column: 1 / -1;
					width: 100%;
				}
				.pooki-admin-wrap .form-table th {
					padding: 0 0 10px 0;
					width: auto;
					font-weight: 600;
					color: #1e293b;
				}
				.pooki-admin-wrap .form-table td { padding: 0; }
				.pooki-admin-wrap > h2:not(.nav-tab-wrapper) {
					background: #f8fafc;
					color: #1e293b;
					display: block;
					padding: 16px 20px;
					border-radius: 12px 12px 0 0;
					font-size: 18px;
					margin-top: 0;
					margin-bottom: 0;
					border-bottom: 1px solid #e2e8f0;
				}
				
				/* Sub-Tabs Layout */
				.pooki-tabs-layout {
					display: flex;
					gap: 30px;
					margin-top: 20px;
					align-items: flex-start;
				}
				.pooki-tabs-sidebar {
					width: 250px;
					flex-shrink: 0;
					background: #fff;
					border-radius: 12px;
					border: 1px solid #e2e8f0;
					padding: 10px;
					box-shadow: 0 1px 3px rgba(0,0,0,0.05);
					position: sticky;
					top: 40px;
				}
				.pooki-tabs-sidebar ul { margin: 0; padding: 0; list-style: none; }
				.pooki-tabs-sidebar li { margin-bottom: 5px; }
				.pooki-tabs-sidebar a {
					display: block;
					padding: 10px 15px;
					color: #475569;
					text-decoration: none;
					border-radius: 8px;
					font-weight: 600;
					transition: all 0.2s;
				}
				.pooki-tabs-sidebar a:hover {
					background: #f1f5f9;
					color: #0f172a;
				}
				.pooki-tabs-sidebar a.active {
					background: #4f46e5;
					color: #fff;
				}
				.pooki-tabs-content {
					flex-grow: 1;
					min-width: 0;
					background: #fff;
					border-radius: 12px;
					border: 1px solid #e2e8f0;
					box-shadow: 0 1px 3px rgba(0,0,0,0.05);
					overflow: hidden;
				}
				.pooki-tab-pane {
					display: none;
					animation: pookiFadeIn 0.3s ease;
				}
				.pooki-tab-pane.active {
					display: block;
				}
				/* Override table styles inside tabs to fit flush */
				.pooki-admin-wrap .pooki-tabs-content .form-table {
					border: none;
					box-shadow: none;
					margin: 0;
					border-radius: 0;
				}
				
				@keyframes pookiFadeIn {
					from { opacity: 0; transform: translateY(5px); }
					to { opacity: 1; transform: translateY(0); }
				}
				@media (max-width: 1024px) {
					.pooki-admin-wrap .form-table {
						grid-template-columns: 1fr;
					}
					.pooki-tabs-layout { flex-direction: column; }
					.pooki-tabs-sidebar { width: 100%; position: static; }
				}
				.pooki-admin-wrap input[type="number"], 
				.pooki-admin-wrap input[type="text"], 
				.pooki-admin-wrap select,
				.pooki-admin-wrap textarea {
					width: 100%;
					border-radius: 6px;
					border: 1px solid #cbd5e1;
					padding: 8px 12px;
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

			<form id="pooki-settings-form" action="options.php" method="post" style="padding-bottom: 80px;">
				<?php settings_fields( 'pooki_options_group' ); ?>
				
				<div class="pooki-tabs-layout">
					<div class="pooki-tabs-sidebar">
						<ul id="pooki-tabs-nav">
							<li><a href="#pooki-tab-topbar" class="active" data-target="pooki-tab-topbar">نوار اعلان (Top Bar)</a></li>
							<li><a href="#pooki-tab-header" data-target="pooki-tab-header">ساختار هدر و لوگو</a></li>
							<li><a href="#pooki-tab-nav" data-target="pooki-tab-nav">نوار ناوبری (منو)</a></li>
							<li><a href="#pooki-tab-sticky" data-target="pooki-tab-sticky">هدر چسبان</a></li>
							<li><a href="#pooki-tab-search" data-target="pooki-tab-search">جستجوی زنده</a></li>
							<li><a href="#pooki-tab-actions" data-target="pooki-tab-actions">دکمه‌های هدر</a></li>
							<li><a href="#pooki-tab-mobile-nav" data-target="pooki-tab-mobile-nav">موبایل و نوار پایینی</a></li>
							<li><a href="#pooki-tab-palette" data-target="pooki-tab-palette">پالت رنگ و JSON</a></li>
							<li><a href="#pooki-tab-backup" data-target="pooki-tab-backup">پشتیبان‌گیری و انتقال</a></li>
						</ul>
					</div>
					
					<div class="pooki-tabs-content">
						<div id="pooki-tab-topbar" class="pooki-tab-pane active">
							<h2>نوار اعلان بالای سایت (Top Bar)</h2>
							<table class="form-table" role="presentation">
								<?php do_settings_fields( 'pooki-settings-header', 'pooki_topbar_section' ); ?>
							</table>
						</div>
						
						<div id="pooki-tab-header" class="pooki-tab-pane">
							<h2>تنظیمات سربرگ</h2>
							<table class="form-table" role="presentation">
								<?php do_settings_fields( 'pooki-settings-header', 'pooki_header_section' ); ?>
							</table>
						</div>
						
						<div id="pooki-tab-nav" class="pooki-tab-pane">
							<h2>نوار ناوبری (منو)</h2>
							<table class="form-table" role="presentation">
								<?php do_settings_fields( 'pooki-settings-header', 'pooki_nav_section' ); ?>
							</table>
						</div>
						
						<div id="pooki-tab-sticky" class="pooki-tab-pane">
							<h2>تنظیمات هدر چسبان</h2>
							<table class="form-table" role="presentation">
								<?php do_settings_fields( 'pooki-settings-header', 'pooki_sticky_header_section' ); ?>
							</table>
						</div>
						
						<div id="pooki-tab-search" class="pooki-tab-pane">
							<h2>تنظیمات فرم جستجو</h2>
							<table class="form-table" role="presentation">
								<?php do_settings_fields( 'pooki-settings-header', 'pooki_search_section' ); ?>
							</table>
						</div>
						
						<div id="pooki-tab-actions" class="pooki-tab-pane">
							<h2>تنظیمات دکمه‌های سربرگ</h2>
							<table class="form-table" role="presentation">
								<?php do_settings_fields( 'pooki-settings-header', 'pooki_actions_section' ); ?>
							</table>
						</div>
						
						<div id="pooki-tab-mobile-nav" class="pooki-tab-pane">
							<h2>تنظیمات موبایل و نوار پایینی</h2>
							<table class="form-table" role="presentation">
								<?php do_settings_fields( 'pooki-settings-header', 'pooki_mobile_nav_section' ); ?>
							</table>
						</div>
						
						<div id="pooki-tab-palette" class="pooki-tab-pane">
							<?php
							if ( class_exists( '\Pooki\Core\ColorRegistry' ) ) {
								\Pooki\Core\ColorRegistry::get_instance()->render_admin_ui();
							}
							?>
						</div>
						
						<div id="pooki-tab-backup" class="pooki-tab-pane">
							<h2>پشتیبان‌گیری و انتقال (Backup & Restore)</h2>
							
							<?php
								$export_data = [
									'theme'     => 'pooki',
									'version'   => '1.0.0',
									'timestamp' => current_time( 'mysql' ),
									'options'   => [
										'pooki_theme_options' => get_option( 'pooki_theme_options', [] ),
										'pooki_color_palette' => get_option( 'pooki_color_palette', [] )
									]
								];
								$json_export = wp_json_encode( $export_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
							?>

							<div style="display:flex; gap:20px; flex-wrap:wrap; margin-top: 20px;">
								<div style="flex:1; min-width:300px; padding:20px; background:#fff; border:1px solid #cbd5e1; border-radius:8px;">
									<h3 style="margin-top:0;">برون‌بری تنظیمات (Export)</h3>
									<p style="color:#64748b; font-size:13px;">از تمام تنظیمات قالب (رنگ‌ها، چیدمان، متن‌ها) فایل پشتیبان بگیرید. <strong>لطفا ابتدا تغییرات خود را ذخیره کنید تا در خروجی لحاظ شوند.</strong></p>
									<textarea id="pooki-export-textarea" readonly rows="6" style="width:100%; direction:ltr; font-family:monospace; padding:10px; background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; resize:vertical;" onclick="this.select();"><?php echo esc_textarea( $json_export ); ?></textarea>
									<div style="margin-top:15px; display:flex; gap:10px;">
										<button type="button" class="button button-primary" id="pooki-download-json">دانلود فایل پشتیبان (JSON)</button>
										<button type="button" class="button button-secondary" onclick="navigator.clipboard.writeText(document.getElementById('pooki-export-textarea').value); alert('کپی شد!');">کپی در کلیپبورد</button>
									</div>
								</div>

								<div style="flex:1; min-width:300px; padding:20px; background:#fff; border:1px solid #cbd5e1; border-radius:8px;">
									<h3 style="margin-top:0;">درون‌ریزی تنظیمات (Import)</h3>
									<p style="color:#64748b; font-size:13px;">یک فایل پشتیبان انتخاب کنید یا کد JSON را مستقیما پیست کنید.</p>
									
									<input type="file" id="pooki-import-file" accept=".json" style="margin-bottom:15px; width:100%; padding:10px; border:1px dashed #cbd5e1; border-radius:6px; background:#f8fafc;" />
									
									<textarea id="pooki-import-textarea" rows="4" style="width:100%; direction:ltr; font-family:monospace; padding:10px; border:1px solid #cbd5e1; border-radius:6px; resize:vertical;" placeholder="یا کدهای JSON را اینجا پیست کنید..."></textarea>
									
									<div style="margin-top:15px; display:flex; align-items:center; gap:15px;">
										<button type="button" class="button button-primary" id="pooki-process-import" style="background:#10b981; border-color:#10b981; color:#fff;">بازگردانی تنظیمات (Restore)</button>
										<span id="pooki-import-status" style="font-weight:bold;"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="pooki-sticky-save-bar" style="position: fixed; bottom: 0; left: 0; right: 0; background: #fff; padding: 15px 30px; border-top: 1px solid #e2e8f0; box-shadow: 0 -4px 6px -1px rgba(0,0,0,0.05); z-index: 50; display: flex; justify-content: flex-end; align-items: center; margin-right: 160px;">
					<span id="pooki-save-status" style="margin-left: 15px; font-weight: bold; display: none;"></span>
					<?php submit_button( 'ذخیره تغییرات', 'primary', 'submit', false, [ 'style' => 'font-size: 16px; padding: 8px 32px; border-radius: 8px;' ] ); ?>
				</div>
			</form>
		</div>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			
			// Simple Tab Switcher
			const tabNav = document.getElementById('pooki-tabs-nav');
			if (tabNav) {
				const links = tabNav.querySelectorAll('a');
				const panes = document.querySelectorAll('.pooki-tab-pane');

				function switchTab(link) {
					links.forEach(l => l.classList.remove('active'));
					panes.forEach(p => p.classList.remove('active'));
					
					link.classList.add('active');
					const targetId = link.dataset.target;
					const targetPane = document.getElementById(targetId);
					if (targetPane) {
						targetPane.classList.add('active');
					}
					localStorage.setItem('pooki_active_tab', targetId);
				}

				links.forEach(link => {
					link.addEventListener('click', (e) => {
						e.preventDefault();
						switchTab(link);
					});
				});

				const savedTab = localStorage.getItem('pooki_active_tab');
				let targetLink = tabNav.querySelector(`a[data-target="${savedTab}"]`);
				if (!targetLink) targetLink = links[0];
				if (targetLink) switchTab(targetLink);
			}

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
						
						if (response.data.export_json) {
							const exportArea = document.getElementById('pooki-export-textarea');
							if (exportArea) {
								exportArea.value = response.data.export_json;
							}
						}
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
			// Backup Download
			document.getElementById('pooki-download-json')?.addEventListener('click', function() {
				const data = document.getElementById('pooki-export-textarea').value;
				const blob = new Blob([data], { type: 'application/json' });
				const url = URL.createObjectURL(blob);
				const a = document.createElement('a');
				const date = new Date().toISOString().slice(0,10);
				a.href = url;
				a.download = `pooki-settings-backup-${date}.json`;
				document.body.appendChild(a);
				a.click();
				document.body.removeChild(a);
				URL.revokeObjectURL(url);
			});

			// Backup File Upload Read
			document.getElementById('pooki-import-file')?.addEventListener('change', function(e) {
				const file = e.target.files[0];
				if (!file) return;
				const reader = new FileReader();
				reader.onload = function(e) {
					document.getElementById('pooki-import-textarea').value = e.target.result;
				};
				reader.readAsText(file);
			});

			// Backup Process Import
			document.getElementById('pooki-process-import')?.addEventListener('click', function() {
				const val = document.getElementById('pooki-import-textarea').value;
				const status = document.getElementById('pooki-import-status');
				if (!val) {
					alert('لطفا کدهای JSON را وارد کنید یا فایل را انتخاب کنید.');
					return;
				}

				if (!confirm('آیا مطمئن هستید؟ این کار تمام تنظیمات و رنگ‌های فعلی را بازنویسی می‌کند.')) return;

				const btn = this;
				btn.disabled = true;
				btn.innerText = 'در حال پردازش...';

				const formData = new FormData();
				formData.append('action', 'pooki_import_theme_options');
				formData.append('import_data', val);
				formData.append('_wpnonce', document.getElementById('_wpnonce').value);

				fetch(ajaxurl, {
					method: 'POST',
					body: formData
				})
				.then(res => res.json())
				.then(res => {
					if (res.success) {
						status.style.color = '#10b981';
						status.innerText = res.data;
						setTimeout(() => window.location.reload(), 1500);
					} else {
						status.style.color = '#ef4444';
						status.innerText = res.data || 'خطا در پردازش JSON';
						btn.disabled = false;
						btn.innerText = 'بازگردانی تنظیمات (Restore)';
					}
				})
				.catch(err => {
					console.error(err);
					status.style.color = '#ef4444';
					status.innerText = 'خطای ارتباط با سرور';
					btn.disabled = false;
					btn.innerText = 'بازگردانی تنظیمات (Restore)';
				});
			});
		});
		</script>
		<?php
	}
}
