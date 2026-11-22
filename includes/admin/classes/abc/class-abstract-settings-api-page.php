<?php
/**
 * Abstract class for the Admin page.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

require_once __DIR__ . '/render/checkbox.php';
require_once __DIR__ . '/enum/checkbox-value.php';
require_once __DIR__ . '/render/file-upload.php';
require_once __DIR__ . '/render/color-picker.php';
require_once __DIR__ . '/render/range.php';
require_once __DIR__ . '/render/textarea.php';

use SketchpadModifiedPlugin\CheckBoxValue;

/**
 * Abstract Settings Api Page Class
 *
 * Defines the plugin name, version, and hooks.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */
abstract class Abstract_Settings_Api_Page {

	/**
	 * The ID of this plugin.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    string  $plugin_name The name of this plugin.
	 */
	protected static string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    string  $version The current version of this plugin.
	 */
	protected static string $version;

	/**
	 * The slug of this plugin.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    string  $plugin_slug The slug of this plugin.
	 */
	protected static string $plugin_slug;

	/**
	 * The text to be displayed in the submenu of this plugin.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    string  $plugin_submenu_text The text to be displayed in the submenu of this plugin.
	 */
	protected static string $plugin_submenu_text;

	/**
	 * The position where this plugin to be displayed in the submenu.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    int|null $plugin_submenu_position The position where this plugin to be displayed in the submenu.
	 */
	protected static int|null $plugin_submenu_position = null;

	/**
	 * Initialize the class and set admin page.
	 *
	 * @since 0.2.0
	 */
	public static function init() {
		if ( ! static::is_activate() ) {
			return;
		}

		static::set_plugin_name();
		static::set_plugin_submenu_text();

		add_action( 'admin_init', array( static::class, 'setup_settings' ) );
		add_action( 'admin_menu', array( static::class, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( static::class, 'enqueue_scripts' ) );
	}

	/**
	 * Initialize the settings.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function setup_settings(): void {
		static::register_settings();
		static::add_settings_sections();
		static::add_settings_fields();
	}

	/**
	 * Register for the admin menu.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function add_admin_menu(): void {
		add_options_page(
			static::$plugin_name,
			static::$plugin_submenu_text,
			'activate_plugins',
			static::$plugin_slug,
			array( static::class, 'show' ),
			static::$plugin_submenu_position
		);
	}

	/**
	 * Set translated plugin name.
	 *
	 * @since  0.2.0
	 */
	abstract protected static function set_plugin_name(): void;

	/**
	 * Set translated plugin_submenu_text.
	 *
	 * @since  0.2.0
	 */
	abstract protected static function set_plugin_submenu_text(): void;

	/**
	 * Register the scripts for the admin area.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function enqueue_scripts(): void {
		if ( ! static::is_enqueue() ) {
			return;
		}

		if ( static::has_render_callback( 'render_file_upload_item' ) ) {
			wp_enqueue_media();
			wp_add_inline_style( 'wp-admin', get_file_upload_inline_style() );
			wp_add_inline_script( 'jquery', get_file_upload_inline_script() );
		}

		if ( static::has_render_callback( 'render_color_picker_item' ) ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_add_inline_script( 'wp-color-picker', get_color_picker_inline_script() );
		}

		if ( static::has_render_callback( 'render_range_item' ) ) {
			wp_add_inline_style( 'wp-admin', get_range_inline_style() );
			wp_add_inline_script( 'jquery', get_range_inline_script() );
		}

		if ( static::has_render_callback( 'render_textarea_item' ) ) {
			wp_add_inline_style( 'wp-admin', get_textarea_inline_style() );
			wp_add_inline_script( 'jquery', get_textarea_inline_script() );
		}

		static::enqueue_styles();
		static::enqueue_script();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function enqueue_styles(): void {}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function enqueue_script(): void {}

	/**
	 * Determine whether to activate.
	 *
	 * @return bool
	 *
	 * @since  0.2.0
	 */
	protected static function is_activate(): bool {
		return current_user_can( 'activate_plugins' );
	}

	/**
	 * Determine whether a file upload field has been registered.
	 *
	 * @param  string $callback_name A function that populates the fields to be detected.
	 * @return bool
	 *
	 * @since  0.2.0
	 */
	protected static function has_render_callback( string $callback_name ): bool {
		global $wp_settings_fields;

		if ( ! is_array( $wp_settings_fields ) ) {
			return false;
		}

		foreach ( $wp_settings_fields as $sections ) {
			foreach ( $sections as $fields ) {
				foreach ( $fields as $field ) {
					$callback = $field['callback'];
					if (
						is_array( $callback ) &&
						isset( $callback[0], $callback[1] ) &&
						$callback_name === $callback[1] &&
						is_a( $callback[0], static::class, true )
					) {
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Determine whether to enqueue.
	 *
	 * @return bool
	 *
	 * @since  0.2.0
	 */
	protected static function is_enqueue(): bool {
		if ( ! static::is_activate() ) {
			return false;
		}

		$screen      = get_current_screen();
		$plugin_slug = static::$plugin_slug;
		if ( ! $screen || "settings_page_{$plugin_slug}" !== $screen->id ) {
			return false;
		}

		return true;
	}

	/**
	 * Display the administration screen.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function show(): void {}

	/**
	 * Register the settings.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function register_settings(): void {}

	/**
	 * Add settings sections.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function add_settings_sections(): void {}

	/**
	 * Add settings fields.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function add_settings_fields(): void {}

	/**
	 * Render Checkbox function.
	 *
	 * @param array{key: string, value?: CheckBoxValue, label?: string, text?: string} $args Rendering parameters.
	 * - `key`   Unique Identifier.
	 * - `value` Initial value.
	 * - `label` Element's label.
	 * - `text`  Element's caption.
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function render_checkbox_item( array $args ): void {
		if ( ! isset( $args['key'] ) ) {
			return;
		}

		$key   = $args['key'];
		$value = get_option( $key, CheckBoxValue::False->value );
		$label = isset( $args['label'] ) ? $args['label'] : '';
		$text  = isset( $args['text'] ) ? $args['text'] : '';

		render_checkbox_item( $key, $value, $label, $text );
	}

	/**
	 * Render file upload component function.
	 *
	 * @param array{key: string, label?: string, text?: string} $args Rendering parameters.
	 * - `key`   Unique option key.
	 * - `label` $label Upload button label.
	 * - `text`  Element's description.
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function render_file_upload_item( array $args ): void {
		if ( ! isset( $args['key'] ) ) {
			return;
		}

		$key   = $args['key'];
		$label = isset( $args['label'] ) ? $args['label'] : array();
		$text  = isset( $args['text'] ) ? $args['text'] : '';

		render_file_upload_item( $key, $label, $text );
	}

	/**
	 * Render a color picker field.
	 *
	 * @param array{key: string, default?: string} $args Rendering parameters.
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function render_color_picker_item( array $args ): void {
		if ( ! isset( $args['key'] ) ) {
			return;
		}

		$key     = $args['key'];
		$default = isset( $args['default'] ) ? $args['default'] : '#f1f1f1';

		render_color_picker_item( $key, $default );
	}

	/**
	 * Render a range field with a button to restore its default value.
	 *
	 * @param array{key: string, min?: float, max?: float, default_value?: float, step?: float, reset_label?: string, text?: string} $args Rendering parameters.
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function render_range_item( array $args ): void {
		if ( ! isset( $args['key'] ) ) {
			return;
		}

		$key           = $args['key'];
		$min           = isset( $args['min'] ) ? $args['min'] : 0;
		$max           = isset( $args['max'] ) ? $args['max'] : 100;
		$default_value = isset( $args['default_value'] ) ? $args['default_value'] : 50;
		$step          = isset( $args['step'] ) ? $args['step'] : 1;
		$reset_label   = isset( $args['reset_label'] ) ? $args['reset_label'] : '';
		$text          = isset( $args['text'] ) ? $args['text'] : '';

		render_range_item( $key, $min, $max, $default_value, $step, $reset_label, $text );
	}

	/**
	 * Render a textarea field with a button to restore its default value.
	 *
	 * @param array{key: string, default_value?: string, reset_label?: string, text?: string} $args Rendering parameters.
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function render_textarea_item( array $args ): void {
		if ( ! isset( $args['key'] ) ) {
			return;
		}

		$key           = $args['key'];
		$default_value = isset( $args['default_value'] ) ? $args['default_value'] : '';
		$reset_label   = isset( $args['reset_label'] ) ? $args['reset_label'] : '';
		$text          = isset( $args['text'] ) ? $args['text'] : '';

		render_textarea_item( $key, $default_value, $reset_label, $text );
	}
}
