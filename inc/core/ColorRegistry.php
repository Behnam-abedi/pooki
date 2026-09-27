<?php
/**
 * Core Color Registry
 *
 * @package Pooki\Core
 */

namespace Pooki\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ColorRegistry
 * Singleton pattern for managing theme dynamic colors.
 */
class ColorRegistry {

	/**
	 * Instance of this class.
	 *
	 * @var ColorRegistry
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance.
	 *
	 * @return ColorRegistry
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
		add_action( 'wp_head', [ $this, 'render_css_variables' ], 1 );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		// Assuming there is an action or we can hook into Pooki_Theme_Options tabs
		// Wait, Pooki_Theme_Options has hardcoded tabs.
		// If we want to hook into it, maybe we use an existing section or create one.
	}

	/**
	 * Get registered colors.
	 *
	 * @return array
	 */
	public function get_registered_colors() {
		$default_palette = [
			'header_bg' => [
				'key'     => 'header_bg',
				'label'   => 'رنگ پس‌زمینه سربرگ',
				'section' => 'header',
				'css_var' => '--pooki-header-bg-color',
				'default' => '#ffffff',
			],
			'nav_hover' => [
				'key'     => 'nav_hover',
				'label'   => 'رنگ هاور نوار ناوبری',
				'section' => 'header',
				'css_var' => '--pooki-nav-hover-color',
				'default' => '#f3f4f6',
			],
			'menu_text' => [
				'key'     => 'menu_text',
				'label'   => 'رنگ متن منو',
				'section' => 'header',
				'css_var' => '--pooki-menu-text-color',
				'default' => '#374151',
			],
			'menu_hover' => [
				'key'     => 'menu_hover',
				'label'   => 'رنگ هاور منو',
				'section' => 'header',
				'css_var' => '--pooki-menu-hover-color',
				'default' => '#ec4899',
			],
			'header_border' => [
				'key'     => 'header_border',
				'label'   => 'رنگ حاشیه سربرگ',
				'section' => 'header',
				'css_var' => '--pooki-header-border-color',
				'default' => '#f3f4f6',
			],
			'sticky_bg' => [
				'key'     => 'sticky_bg',
				'label'   => 'رنگ پس‌زمینه چسبان',
				'section' => 'header',
				'css_var' => '--pooki-sticky-bg-color',
				'default' => '#ffffff',
			],
			'sticky_border' => [
				'key'     => 'sticky_border',
				'label'   => 'رنگ حاشیه چسبان',
				'section' => 'header',
				'css_var' => '--pooki-sticky-border-color',
				'default' => '#e5e7eb',
			],
			'search_bg' => [
				'key'     => 'search_bg',
				'label'   => 'رنگ پس‌زمینه جستجو',
				'section' => 'search',
				'css_var' => '--pooki-search-bg-color',
				'default' => '#f3f4f6',
			],
			'search_focus_bg' => [
				'key'     => 'search_focus_bg',
				'label'   => 'رنگ پس‌زمینه فوکوس جستجو',
				'section' => 'search',
				'css_var' => '--pooki-search-focus-bg-color',
				'default' => '#ffffff',
			],
			'search_border' => [
				'key'     => 'search_border',
				'label'   => 'رنگ حاشیه جستجو',
				'section' => 'search',
				'css_var' => '--pooki-search-border-color',
				'default' => '#e5e7eb',
			],
			'search_focus_border' => [
				'key'     => 'search_focus_border',
				'label'   => 'رنگ حاشیه فوکوس جستجو',
				'section' => 'search',
				'css_var' => '--pooki-search-focus-border-color',
				'default' => '#ec4899',
			],
			'search_text' => [
				'key'     => 'search_text',
				'label'   => 'رنگ متن جستجو',
				'section' => 'search',
				'css_var' => '--pooki-search-text-color',
				'default' => '#111827',
			],
			'search_placeholder' => [
				'key'     => 'search_placeholder',
				'label'   => 'رنگ نگهدارنده جستجو',
				'section' => 'search',
				'css_var' => '--pooki-search-placeholder-color',
				'default' => '#9ca3af',
			],
			'header_action_icon' => [
				'key'     => 'header_action_icon',
				'label'   => 'رنگ آیکون دکمه‌ها',
				'section' => 'actions',
				'css_var' => '--pooki-header-action-icon-color',
				'default' => '#374151',
			],
			'header_action_icon_hover' => [
				'key'     => 'header_action_icon_hover',
				'label'   => 'رنگ هاور آیکون دکمه‌ها',
				'section' => 'actions',
				'css_var' => '--pooki-header-action-icon-hover-color',
				'default' => '#ec4899',
			],
			'header_action_text' => [
				'key'     => 'header_action_text',
				'label'   => 'رنگ متن دکمه‌ها',
				'section' => 'actions',
				'css_var' => '--pooki-header-action-text-color',
				'default' => '#374151',
			],
			'header_action_text_hover' => [
				'key'     => 'header_action_text_hover',
				'label'   => 'رنگ هاور متن دکمه‌ها',
				'section' => 'actions',
				'css_var' => '--pooki-header-action-text-hover-color',
				'default' => '#ec4899',
			],
			'header_action_bg' => [
				'key'     => 'header_action_bg',
				'label'   => 'رنگ پس‌زمینه دکمه‌ها',
				'section' => 'actions',
				'css_var' => '--pooki-header-action-bg-color',
				'default' => '#ffffff',
			],
			'header_action_bg_hover' => [
				'key'     => 'header_action_bg_hover',
				'label'   => 'رنگ هاور پس‌زمینه دکمه‌ها',
				'section' => 'actions',
				'css_var' => '--pooki-header-action-bg-hover-color',
				'default' => '#f3f4f6',
			],
			'header_action_border' => [
				'key'     => 'header_action_border',
				'label'   => 'رنگ حاشیه دکمه‌ها',
				'section' => 'actions',
				'css_var' => '--pooki-header-action-border-color',
				'default' => '#ffffff',
			],
			'topbar_bg' => [
				'key'     => 'topbar_bg',
				'label'   => 'رنگ پس‌زمینه نوار اعلان',
				'section' => 'topbar',
				'css_var' => '--pooki-topbar-bg-color',
				'default' => '#4f46e5',
			],
			'topbar_text' => [
				'key'     => 'topbar_text',
				'label'   => 'رنگ متن نوار اعلان',
				'section' => 'topbar',
				'css_var' => '--pooki-topbar-text-color',
				'default' => '#ffffff',
			],
			'nav_bg' => [
				'key'     => 'nav_bg',
				'label'   => 'رنگ پس‌زمینه ناوبری',
				'section' => 'nav',
				'css_var' => '--pooki-nav-bg-color',
				'default' => '#ffffff',
			],
			'nav_sticky_bg' => [
				'key'     => 'nav_sticky_bg',
				'label'   => 'رنگ پس‌زمینه ناوبری چسبان',
				'section' => 'nav',
				'css_var' => '--pooki-nav-sticky-bg-color',
				'default' => '#ffffff',
			],
			'nav_border_top' => [
				'key'     => 'nav_border_top',
				'label'   => 'رنگ حاشیه بالای ناوبری',
				'section' => 'nav',
				'css_var' => '--pooki-nav-border-top-color',
				'default' => '#f3f4f6',
			],
			'bottom_bar_bg' => [
				'key'     => 'bottom_bar_bg',
				'label'   => 'رنگ پس‌زمینه نوار پایینی',
				'section' => 'mobile',
				'css_var' => '--pooki-bottom-bar-bg-color',
				'default' => '#ffffff',
			],
			'bottom_bar_icon' => [
				'key'     => 'bottom_bar_icon',
				'label'   => 'رنگ آیکون نوار پایینی',
				'section' => 'mobile',
				'css_var' => '--pooki-bottom-bar-icon-color',
				'default' => '#6b7280',
			],
			'bottom_bar_icon_active' => [
				'key'     => 'bottom_bar_icon_active',
				'label'   => 'رنگ فعال آیکون نوار پایینی',
				'section' => 'mobile',
				'css_var' => '--pooki-bottom-bar-icon-active-color',
				'default' => '#8b5cf6',
			],
			'bottom_bar_divider' => [
				'key'     => 'bottom_bar_divider',
				'label'   => 'رنگ جداکننده نوار پایینی',
				'section' => 'mobile',
				'css_var' => '--pooki-bottom-bar-divider-color',
				'default' => '#EBE4D8',
			],
			'search_modal_bg' => [
				'key'     => 'search_modal_bg',
				'label'   => 'رنگ پس‌زمینه مودال جستجو',
				'section' => 'mobile',
				'css_var' => '--pooki-search-modal-bg-color',
				'default' => '#FAF7F2',
			],
			'search_modal_input_bg' => [
				'key'     => 'search_modal_input_bg',
				'label'   => 'رنگ پس‌زمینه ورودی مودال جستجو',
				'section' => 'mobile',
				'css_var' => '--pooki-search-modal-input-bg-color',
				'default' => '#FDFBF7',
			],
			'search_modal_input_border' => [
				'key'     => 'search_modal_input_border',
				'label'   => 'رنگ حاشیه ورودی مودال جستجو',
				'section' => 'mobile',
				'css_var' => '--pooki-search-modal-input-border-color',
				'default' => '#EBE4D8',
			],
			'search_modal_text' => [
				'key'     => 'search_modal_text',
				'label'   => 'رنگ متن مودال جستجو',
				'section' => 'mobile',
				'css_var' => '--pooki-search-modal-text-color',
				'default' => '#1f2937',
			],
		];

		return apply_filters( 'pooki_registered_colors', $default_palette );
	}

	/**
	 * Get the current active palette.
	 *
	 * @return array
	 */
	public function get_active_palette() {
		$registered_colors = $this->get_registered_colors();
		$saved_palette     = get_option( 'pooki_color_palette', [] );
		$active_palette    = [];

		foreach ( $registered_colors as $key => $color ) {
			if ( isset( $saved_palette[ $key ] ) && ! empty( $saved_palette[ $key ] ) ) {
				$active_palette[ $key ] = $saved_palette[ $key ];
			} else {
				$active_palette[ $key ] = $color['default'];
			}
		}

		return $active_palette;
	}

	/**
	 * Render CSS variables in wp_head.
	 */
	public function render_css_variables() {
		$registered_colors = $this->get_registered_colors();
		$active_palette    = $this->get_active_palette();

		if ( empty( $registered_colors ) ) {
			return;
		}

		echo '<style id="pooki-color-registry-vars">';
		echo ':root {';
		foreach ( $registered_colors as $key => $color ) {
			$value = esc_attr( $active_palette[ $key ] );
			echo esc_attr( $color['css_var'] ) . ': ' . $value . ';';
		}
		echo '}';
		echo '</style>';
	}

	/**
	 * Register settings for Color Registry (optional integration if needed).
	 * We can hook into the existing customizer/theme options if desired, 
	 * or handle it via our own admin menu page.
	 */
	public function register_settings() {
		register_setting( 'pooki_color_palette_group', 'pooki_color_palette', [ $this, 'sanitize_palette' ] );
	}

	/**
	 * Sanitize JSON Import / palette save
	 */
	public function sanitize_palette( $input ) {
		$sanitized = [];
		$registered = $this->get_registered_colors();
		
		if ( ! is_array( $input ) ) {
			// Maybe it was JSON?
			$decoded = json_decode( $input, true );
			if ( is_array( $decoded ) ) {
				$input = $decoded;
			} else {
				return get_option( 'pooki_color_palette', [] );
			}
		}

		foreach ( $input as $key => $value ) {
			if ( isset( $registered[ $key ] ) ) {
				$sanitized[ $key ] = sanitize_hex_color( $value );
			}
		}
		return $sanitized;
	}

	/**
	 * Render the Admin UI inside the theme options palette tab.
	 */
	public function render_admin_ui() {
		$registered = $this->get_registered_colors();
		$active     = $this->get_active_palette();

		// Group by section
		$sections = [];
		foreach ( $registered as $key => $color ) {
			$sections[ $color['section'] ][] = $color;
		}

		echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">';
		foreach ( $sections as $section_key => $colors ) {
			echo '<div class="pooki-color-section" style="background: #fff; padding: 15px; border: 1px solid #cbd5e1; border-radius: 8px;">';
			echo '<h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px;">' . esc_html( ucfirst( $section_key ) ) . ' Colors</h3>';
			foreach ( $colors as $color ) {
				$val = isset( $active[ $color['key'] ] ) ? $active[ $color['key'] ] : $color['default'];
				echo '<div style="margin-bottom: 15px;">';
				echo '<label style="display:block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">' . esc_html( $color['label'] ) . '</label>';
				echo '<div style="display:flex; gap: 10px; align-items: center;">';
				echo '<input type="color" name="pooki_color_palette[' . esc_attr( $color['key'] ) . ']" value="' . esc_attr( $val ) . '" style="height: 36px; padding: 2px; border-radius: 6px; cursor: pointer;" />';
				echo '<button type="button" class="button pooki-reset-color" data-default="' . esc_attr( $color['default'] ) . '">بازنشانی</button>';
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
		}
		echo '</div>';

		// JSON Export / Import
		$json_export = wp_json_encode( $active, JSON_PRETTY_PRINT );

		// Tailwind format
		$tailwind_colors = [];
		foreach ( $registered as $key => $color ) {
			$tw_key = str_replace( '_', '-', $key );
			$tailwind_colors[$tw_key] = 'var(' . $color['css_var'] . ')';
		}
		$tailwind_output = wp_json_encode( ['theme' => ['extend' => ['colors' => ['pooki' => $tailwind_colors]]]], JSON_PRETTY_PRINT );

		echo '<div style="margin-top: 30px; border-top: 2px solid #eee; padding-top: 20px;">';
		echo '<h2>درون‌ریزی / برون‌بری JSON</h2>';
		
		echo '<div style="display: flex; gap: 20px; flex-wrap: wrap;">';
		
		echo '<div style="flex: 1; min-width: 300px;">';
		echo '<h3>Import Palette (JSON)</h3>';
		echo '<textarea id="pooki-color-registry-import" rows="6" style="width:100%; direction:ltr; font-family:monospace; padding:10px;"></textarea>';
		echo '<button type="button" class="button button-secondary" id="pooki-registry-import-btn" style="margin-top:10px;">اعمال JSON</button>';
		echo '</div>';

		echo '<div style="flex: 1; min-width: 300px;">';
		echo '<h3>Export Active Palette</h3>';
		echo '<textarea readonly rows="6" style="width:100%; direction:ltr; font-family:monospace; padding:10px; background:#f8fafc;" onclick="this.select();">' . esc_textarea( $json_export ) . '</textarea>';
		echo '</div>';

		echo '</div>';

		echo '<div style="margin-top: 20px;">';
		echo '<h3>Tailwind Config (JSON)</h3>';
		echo '<textarea readonly rows="12" style="width:100%; direction:ltr; font-family:monospace; padding:10px; background:#f8fafc;" onclick="this.select();">' . esc_textarea( $tailwind_output ) . '</textarea>';
		echo '</div>';

		echo '</div>';

		echo '<script>
			document.querySelectorAll(".pooki-reset-color").forEach(btn => {
				btn.addEventListener("click", function() {
					this.previousElementSibling.value = this.dataset.default;
				});
			});
			document.getElementById("pooki-registry-import-btn")?.addEventListener("click", function() {
				try {
					let data = JSON.parse(document.getElementById("pooki-color-registry-import").value);
					for (let key in data) {
						let input = document.querySelector(`input[name="pooki_color_palette[${key}]"]`);
						if(input) { input.value = data[key]; }
					}
					alert("رنگ‌ها اعمال شدند. لطفاً ذخیره کنید.");
				} catch(e) {
					alert("JSON نامعتبر است.");
				}
			});
		</script>';
	}
}
