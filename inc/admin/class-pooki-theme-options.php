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
		add_action( 'wp_ajax_pooki_save_theme_options', [ $this, 'ajax_save_options' ] );
		add_action( 'wp_head', [ $this, 'inject_dynamic_css' ], 100 );
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

		add_settings_field( 'header_height', 'ارتفاع سربرگ (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'header_height', 'default' => 80 ] );
		add_settings_field( 'logo_height', 'ارتفاع لوگو (px)', [ $this, 'render_number_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'logo_height', 'default' => 48 ] );
		add_settings_field( 'menu_text_color', 'رنگ متن منو', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'menu_text_color', 'default' => '#374151' ] );
		add_settings_field( 'menu_hover_color', 'رنگ هاور منو', [ $this, 'render_color_field' ], 'pooki-settings-header', 'pooki_header_section', [ 'id' => 'menu_hover_color', 'default' => '#ec4899' ] );
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

			// Sanitize specific fields
			if ( isset( $posted['header_height'] ) ) {
				$options['header_height'] = absint( $posted['header_height'] );
			}

			if ( isset( $posted['logo_height'] ) ) {
				$options['logo_height'] = absint( $posted['logo_height'] );
			}

			if ( isset( $posted['menu_text_color'] ) ) {
				$options['menu_text_color'] = sanitize_hex_color( $posted['menu_text_color'] );
			}

			if ( isset( $posted['menu_hover_color'] ) ) {
				$options['menu_hover_color'] = sanitize_hex_color( $posted['menu_hover_color'] );
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
		$options = get_option( 'pooki_theme_options', [] );

		$header_height    = isset( $options['header_height'] ) && $options['header_height'] ? absint( $options['header_height'] ) : 80;
		$logo_height      = isset( $options['logo_height'] ) && $options['logo_height'] ? absint( $options['logo_height'] ) : 48;
		$menu_text_color  = isset( $options['menu_text_color'] ) && $options['menu_text_color'] ? sanitize_hex_color( $options['menu_text_color'] ) : '#374151';
		$menu_hover_color = isset( $options['menu_hover_color'] ) && $options['menu_hover_color'] ? sanitize_hex_color( $options['menu_hover_color'] ) : '#ec4899';

		echo '<style id="pooki-dynamic-header-styles">';
		echo ':root {';
		echo '--pooki-header-height: ' . esc_attr( $header_height ) . 'px;';
		echo '--pooki-logo-height: ' . esc_attr( $logo_height ) . 'px;';
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
		</script>
		<?php
	}
}
