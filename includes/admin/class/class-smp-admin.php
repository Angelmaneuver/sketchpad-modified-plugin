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
	 * Register the settings.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	public function setup_settings(): void {
		$checkbox_render = function( $args ) {
			$key           = $args['option_key'];
			$checked       = '1' === get_option( $key, '0' ) ? 'checked' : '';
			$label_comment = $args['label_comment'];
			$comment       = $args['comment'];
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
		};

		register_setting( 'sketchpad-modified-plugin', 'add_reusable_blocks_link' );
		register_setting( 'sketchpad-modified-plugin', 'wp_block_sort_title' );

		add_settings_section(
			'extend_admin_screen',
			__( 'Extend of administration screen', 'sketchpad-modified-plugin' ),
			function( $args ) {
				return;
			},
			'sketchpad-modified-plugin'
		);

		add_settings_field(
			'add_reusable_blocks_link',
			__( 'Reusable Block link', 'sketchpad-modified-plugin' ),
			$checkbox_render,
			'sketchpad-modified-plugin',
			'extend_admin_screen',
			array(
				'option_key'    => 'add_reusable_blocks_link',
				'label_comment' => __(
					'Add a link to the Reusable Block in the post menu.',
					'sketchpad-modified-plugin'
				),
				'comment'       => '',
			)
		);

		add_settings_field(
			'wp_block_sort_title',
			__( 'Reusable Block list order', 'sketchpad-modified-plugin' ),
			$checkbox_render,
			'sketchpad-modified-plugin',
			'extend_admin_screen',
			array(
				'option_key'    => 'wp_block_sort_title',
				'label_comment' => __(
					'Set the initial order of the Reusable Block list to title order.',
					'sketchpad-modified-plugin'
				),
				'comment'       => '',
			)
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
}

add_action(
	'init',
	function() {
		new SMP_Admin();
	}
);