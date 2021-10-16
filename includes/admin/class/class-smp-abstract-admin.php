<?php
/**
 * The admin-specific functionality abstract class of the plugin.
 *
 * @package Sketchpad modified - Plugin
 * @since   0.1.0
 */

/**
 * Abstract class: SMP_Abstract_Admin
 *
 * Defines the plugin name, version, and hooks.
 *
 * @package Sketchpad modified - Plugin
 * @since   0.1.0
 */
abstract class SMP_Abstract_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string  $plugin_name The name of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string  $version The current version of this plugin.
	 */
	protected $version;

	/**
	 * The slug of this plugin.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string  $plugin_slug The slug of this plugin.
	 */
	protected $plugin_slug;

	/**
	 * The text to be displayed in the submenu of this plugin.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string  $plugin_submenu_text The text to be displayed in the submenu of this plugin.
	 */
	protected $plugin_submenu_text;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name         The name of this plugin.
	 * @param string $plugin_version      The current version of this plugin.
	 * @param string $plugin_slug         The slug of this plugin.
	 * @param string $plugin_submenu_text The text to be displayed in the submenu of this plugin.
	 *
	 * @since 0.1.0
	 */
	public function __construct(
		string $plugin_name,
		string $plugin_version,
		string $plugin_slug,
		string $plugin_submenu_text
	) {
		$this->plugin_name         = $plugin_name;
		$this->version             = $plugin_version;
		$this->plugin_slug         = $plugin_slug;
		$this->plugin_submenu_text = $plugin_submenu_text;

		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'setup_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'setup_settings' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
	}

	/**
	 * Initialize for the admin menu.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	public function setup_admin_menu(): void {
		add_options_page(
			$this->plugin_name,
			$this->plugin_submenu_text,
			'activate_plugins',
			$this->plugin_slug,
			array( $this, 'show' ),
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
		$this->register_settings();
		$this->add_settings_sections();
		$this->add_settings_fields();
	}

	/**
	 * Abstract method.
	 *
	 * Register the stylesheets for the admin area.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	abstract public function enqueue_styles(): void;

	/**
	 * Abstract method.
	 *
	 * Register the JavaScript for the admin area.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	abstract public function enqueue_scripts(): void;

	/**
	 * Display the administration screen.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	public function show(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
	}

	/**
	 * Register the settings.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	protected function register_settings(): void {}

	/**
	 * Add settings sections.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	protected function add_settings_sections(): void {}

	/**
	 * Add settings fields.
	 *
	 * @return void
	 *
	 * @since  0.1.0
	 */
	protected function add_settings_fields(): void {}
}
