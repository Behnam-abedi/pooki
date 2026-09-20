<?php
/**
 * Pooki Theme Options Panel
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Pooki_Theme_Options
 */
class Pooki_Theme_Options {

	/**
	 * Constructor.
	 */
	public function __construct() {
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
	 * Register admin menu.
	 */
	public function register_admin_menu() {
		add_menu_page(
			__( 'Pooki Settings', 'pooki' ),
			__( 'Pooki Settings', 'pooki' ),
			'manage_options',
			'pooki-settings',
			[ $this, 'render_settings_page' ],
			'dashicons-admin-generic',
			59
		);
	}

	/**
	 * Register settings and fields.
	 */
	public function register_settings() {
		register_setting( 'pooki_options_group', 'pooki_theme_options' );

		add_settings_section(
			'pooki_general_section',
			__( 'General Store Settings', 'pooki' ),
			null,
			'pooki-settings'
		);

		add_settings_field(
			'pooki_topbar_text',
			__( 'Top Bar Announcement', 'pooki' ),
			[ $this, 'render_text_field' ],
			'pooki-settings',
			'pooki_general_section',
			[ 'label_for' => 'pooki_topbar_text' ]
		);

		add_settings_field(
			'pooki_support_phone',
			__( 'Support Phone Number', 'pooki' ),
			[ $this, 'render_text_field' ],
			'pooki-settings',
			'pooki_general_section',
			[ 'label_for' => 'pooki_support_phone' ]
		);
	}

	/**
	 * Render text field.
	 *
	 * @param array $args Field arguments.
	 */
	public function render_text_field( $args ) {
		$options = get_option( 'pooki_theme_options' );
		$id      = $args['label_for'];
		$value   = isset( $options[ $id ] ) ? $options[ $id ] : '';
		?>
		<input type="text" id="<?php echo esc_attr( $id ); ?>" name="pooki_theme_options[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
		<?php
	}

	/**
	 * Render settings page.
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Pooki Theme Settings', 'pooki' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'pooki_options_group' );
				do_settings_sections( 'pooki-settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
