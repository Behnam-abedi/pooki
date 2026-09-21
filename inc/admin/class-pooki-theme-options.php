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

		// Sticky Header Section
		add_settings_section( 'pooki_sticky_header_section', 'تنظیمات هدر چسبان', null, 'pooki-settings-header' );

		add_settings_field( 'sticky_header_enabled', 'فعال‌سازی هدر چسبان', [ $this, 'render_checkbox_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_header_enabled' ] );
		add_settings_field( 'sticky_header_height', 'ارتفاع هدر چسبان (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_header_height', 'default' => 64 ] );
		add_settings_field( 'sticky_logo_height', 'ارتفاع لوگو چسبان (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_logo_height', 'default' => 40 ] );
		add_settings_field( 'sticky_bg_color', 'رنگ پس‌زمینه چسبان', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_bg_color', 'default' => '#ffffff' ] );
		add_settings_field( 'sticky_border_color', 'رنگ حاشیه چسبان', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_border_color', 'default' => '#e5e7eb' ] );
		add_settings_field( 'sticky_shadow', 'سایه هدر چسبان', [ $this, 'render_select_field' ], 'pooki-settings-header', 'pooki_sticky_header_section', [ 'id' => 'sticky_shadow', 'options' => [ 'none' => 'بدون سایه', 'sm' => 'کوچک', 'md' => 'متوسط', 'lg' => 'بزرگ' ], 'default' => 'md' ] );
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
				'logo_url'              => 'url',
				'header_height'         => 'int',
				'logo_height'           => 'int',
				'header_bg_color'       => 'color',
				'header_border_color'   => 'color',
				'header_shadow'         => 'key',
				'menu_text_color'       => 'color',
				'menu_hover_color'      => 'color',
				'sticky_header_enabled' => 'bool',
				'sticky_header_height'  => 'int',
				'sticky_logo_height'    => 'int',
				'sticky_bg_color'       => 'color',
				'sticky_border_color'   => 'color',
				'sticky_shadow'         => 'key',
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
						$options[ $field ] = sanitize_hex_color( $posted[ $field ] );
					} elseif ( 'url' === $type ) {
						$options[ $field ] = esc_url_raw( $posted[ $field ] );
					} elseif ( 'key' === $type ) {
						$options[ $field ] = sanitize_key( $posted[ $field ] );
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

		echo '<style id="pooki-header-dynamic-vars">';
		echo ':root {';
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
			
			<h2 class="nav-tab-wrapper">
				<a href="?page=pooki-settings&tab=header" class="nav-tab <?php echo $active_tab == 'header' ? 'nav-tab-active' : ''; ?>">سربرگ</a>
			</h2>

			<!-- Success Toast Container -->
			<div id="pooki-toast" style="display: none; padding: 12px 20px; background: #4caf50; color: white; border-radius: 4px; margin-top: 15px; font-weight: bold;"></div>

			<form id="pooki-settings-form" action="options.php" method="post">
				<?php
				settings_fields( 'pooki_options_group' );
				
				if ( $active_tab == 'header' ) {
					do_settings_sections( 'pooki-settings-header' );
				} else {
					do_settings_sections( 'pooki-settings' );
				}
				
				submit_button( 'ذخیره تنظیمات' );
				?>
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
					toast.style.display = 'block';
					
					if (response.success) {
						toast.style.background = '#4caf50';
						toast.innerText = response.data.message || 'تنظیمات ذخیره شد.';
					} else {
						toast.style.background = '#f44336';
						toast.innerText = response.data || 'خطایی رخ داده است.';
					}

					setTimeout(() => {
						toast.style.display = 'none';
					}, 3000);
				})
				.catch(err => {
					console.error(err);
					alert('خطای ارتباط با سرور.');
				})
				.finally(() => {
					submitBtn.disabled = false;
					submitBtn.value = 'ذخیره تنظیمات';
				});
			});
		});
		</script>
		<?php
	}
}
