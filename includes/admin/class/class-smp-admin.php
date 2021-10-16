<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package Sketchpad modified - Plugin
 * @since   0.1.0
 */

/**
 * These modules are needed to load this class.
 */
require_once __DIR__ . '/class-smp-abstract-admin.php';

/**
 * Class: SMP_Admin
 *
 * Defines the plugin name, version, and hooks.
 *
 * @package Sketchpad modified - Plugin
 * @since   0.1.0
 */
class SMP_Admin extends SMP_Abstract_Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		parent::__construct(
			__( 'Sketchpad modified - Plugin', 'sketchpad-modified-plugin' ),
			'0.1.0',
			'sketchpad-modified-plugin',
			__( 'Extend Settings', 'sketchpad-modified-plugin' )
		);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 */
	public function enqueue_styles(): void {}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 */
	public function enqueue_scripts(): void {}

	/**
	 * Display the administration screen.
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 */
	public function show(): void {
		parent::show();
		?>
<div class="wrap">
	<h2><?php echo esc_html( "{$this->plugin_name} {$this->plugin_submenu_text}" ); ?></h2>
	<form action="options.php" method="post">
		<?php
		settings_fields( 'sketchpad-modified-plugin' );
		do_settings_sections( 'sketchpad-modified-plugin' );
		submit_button();
		?>
	</form>
</div>
		<?php
	}

	/**
	 * Render Checkbox function.
	 *
	 * @param  array $args Rendering parameters.
	 * @return void
	 *
	 * @since  0.1.0
	 */
	public function render_checkbox_item( $args ): void {
		$key           = $args['option_key'];
		$checked       = '1' === get_option( $key, '0' ) ? 'checked' : '';
		$label_comment = isset( $args['label_comment'] ) ? $args['label_comment'] : '';
		$comment       = isset( $args['comment'] ) ? $args['comment'] : '';
		?>
		<input
			type  = "checkbox"
			id    = "<?php echo esc_attr( $key ); ?>"
			name  = "<?php echo esc_attr( $key ); ?>"
			value = "1"
			<?php echo esc_attr( $checked ); ?>
		>
		<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label_comment ); ?></label>
		<p><?php echo esc_html( $comment ); ?></p>
		<?php
	}

	/**
	 * Register the settings.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	protected function register_settings(): void {
		parent::register_settings();

		register_setting( 'sketchpad-modified-plugin', 'remove_edituri_link' );
		register_setting( 'sketchpad-modified-plugin', 'remove_wlwmanifest_link' );
		register_setting( 'sketchpad-modified-plugin', 'add_reusable_blocks_link' );
		register_setting( 'sketchpad-modified-plugin', 'wp_block_sort_title' );
	}

	/**
	 * Add settings sections.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	protected function add_settings_sections(): void {
		parent::add_settings_sections();

		$callback = function( $args ) {
			return;
		};

		add_settings_section(
			'extend_html_head_screen',
			__( 'Extend of HTML documents meta data.', 'sketchpad-modified-plugin' ),
			$callback,
			'sketchpad-modified-plugin'
		);

		add_settings_section(
			'extend_admin_screen',
			__( 'Extend of administration screen', 'sketchpad-modified-plugin' ),
			$callback,
			'sketchpad-modified-plugin'
		);
	}

	/**
	 * Add settings fields.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	protected function add_settings_fields(): void {
		add_settings_field(
			'remove_edituri_link',
			__( 'EditURI', 'sketchpad-modified-plugin' ),
			array( $this, 'render_checkbox_item' ),
			'sketchpad-modified-plugin',
			'extend_html_head_screen',
			array(
				'option_key'    => 'remove_edituri_link',
				'label_comment' => __(
					'Stop the output of EditURI link.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'remove_wlwmanifest_link',
			__( 'wlwmanifest', 'sketchpad-modified-plugin' ),
			array( $this, 'render_checkbox_item' ),
			'sketchpad-modified-plugin',
			'extend_html_head_screen',
			array(
				'option_key'    => 'remove_wlwmanifest_link',
				'label_comment' => __(
					'Stop the output of wlwmanifest link.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'add_reusable_blocks_link',
			__( 'Reusable Block link', 'sketchpad-modified-plugin' ),
			array( $this, 'render_checkbox_item' ),
			'sketchpad-modified-plugin',
			'extend_admin_screen',
			array(
				'option_key'    => 'add_reusable_blocks_link',
				'label_comment' => __(
					'Add a link to the Reusable Block in the post menu.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'wp_block_sort_title',
			__( 'Reusable Block list order', 'sketchpad-modified-plugin' ),
			array( $this, 'render_checkbox_item' ),
			'sketchpad-modified-plugin',
			'extend_admin_screen',
			array(
				'option_key'    => 'wp_block_sort_title',
				'label_comment' => __(
					'Set the initial order of the Reusable Block list to title order.',
					'sketchpad-modified-plugin'
				),
			)
		);
	}
}

add_action(
	'init',
	function() {
		new SMP_Admin();
	}
);
