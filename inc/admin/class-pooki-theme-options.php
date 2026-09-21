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

		// We will register sections and fields here later
	}

	/**
	 * Render the Admin Page UI.
	 */
	public function render_admin_page() {
		// Check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Get the active tab from the $_GET param
		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'general';
		?>
		<div class="wrap pooki-admin-wrap">
			<h1>تنظیمات قالب پوکی</h1>
			
			<h2 class="nav-tab-wrapper">
				<a href="?page=pooki-settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">عمومی</a>
				<a href="?page=pooki-settings&tab=header" class="nav-tab <?php echo $active_tab == 'header' ? 'nav-tab-active' : ''; ?>">سربرگ</a>
				<a href="?page=pooki-settings&tab=colors" class="nav-tab <?php echo $active_tab == 'colors' ? 'nav-tab-active' : ''; ?>">رنگ‌ها</a>
				<a href="?page=pooki-settings&tab=typography" class="nav-tab <?php echo $active_tab == 'typography' ? 'nav-tab-active' : ''; ?>">تایپوگرافی</a>
			</h2>

			<form action="options.php" method="post">
				<?php
				settings_fields( 'pooki_options_group' );
				do_settings_sections( 'pooki-settings' );
				submit_button( 'ذخیره تنظیمات' );
				?>
			</form>
		</div>
		<?php
	}
}
