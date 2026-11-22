<?php
/**
 * Class for the Admin page.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

require_once __DIR__ . '/../classes/abc/class-abstract-settings-api-tab-page.php';

use SketchpadModifiedPlugin\Abstract_Settings_Api_Tab_Page;
use SketchpadModifiedPlugin\ArticleTitleExtend;
use SketchpadModifiedPlugin\AdminBackground;

/**
 * Extend Settings Page Class
 *
 * Defines the plugin name, version, and hooks.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */
class Extend_Settings_Page extends Abstract_Settings_Api_Tab_Page {

	/**
	 * The version of this plugin.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    string  $version The current version of this plugin.
	 */
	protected static string $version = '0.2.0';

	/**
	 * The slug of this plugin.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    string  $plugin_slug The slug of this plugin.
	 */
	protected static string $plugin_slug = 'sketchpad-modified-plugin';

	/**
	 * The default tab.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    string  $default_tab The key of default tab.
	 */
	protected static string $default_tab = 'site-setting';

	/**
	 * The position where this plugin to be displayed in the submenu.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    int|null $plugin_submenu_position The position where this plugin to be displayed in the submenu.
	 */
	protected static int|null $plugin_submenu_position = 4;

	/**
	 * Set translated plugin name.
	 *
	 * @since  0.2.0
	 */
	protected static function set_plugin_name(): void {
		static::$plugin_name = __( 'Sketchpad modified - Plugin', 'sketchpad-modified-plugin' );
	}

	/**
	 * Set translated plugin_submenu_text.
	 *
	 * @since  0.2.0
	 */
	protected static function set_plugin_submenu_text(): void {
		static::$plugin_submenu_text = __( 'Extend Settings', 'sketchpad-modified-plugin' );
	}

	/**
	 * Set tabs.
	 *
	 * @since  0.2.0
	 */
	protected static function set_tabs(): void {
		static::$tabs = array(
			'site-setting'       => __( 'Site Setting', 'sketchpad-modified-plugin' ),
			'post-setting'       => __( 'Post Setting', 'sketchpad-modified-plugin' ),
			'admin-page-setting' => __( 'Admin Page Setting', 'sketchpad-modified-plugin' ),
			'other-setting'      => __( 'Other Setting', 'sketchpad-modified-plugin' ),
		);
	}

	/**
	 * Register the settings.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function register_settings(): void {
		register_setting( static::$plugin_slug . '-site-setting', 'insert_head_is_enable' );
		register_setting(
			static::$plugin_slug . '-site-setting',
			'insert_head',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'SketchpadModifiedPlugin\sanitize_insert_head_html',
				'default'           => '',
			)
		);

		register_setting(
			static::$plugin_slug . '-site-setting',
			'insert_head_priority',
			array(
				'type'              => 'absint',
				'sanitize_callback' => static function ( $value ): int {
					if ( ! is_int( $value ) && ! is_string( $value ) ) {
						return 10;
					}

					$priority = filter_var(
						wp_unslash( $value ),
						FILTER_VALIDATE_INT,
						array( 'options' => array( 'min_range' => 1 ) )
					);

					return false === $priority ? 10 : $priority;
				},
				'default'           => 10,
			)
		);

		register_setting( static::$plugin_slug . '-site-setting', 'insert_body_is_enable' );

		register_setting(
			static::$plugin_slug . '-site-setting',
			'insert_body',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'SketchpadModifiedPlugin\sanitize_insert_body_html',
				'default'           => '',
			)
		);

		register_setting(
			static::$plugin_slug . '-site-setting',
			'insert_body_priority',
			array(
				'type'              => 'absint',
				'sanitize_callback' => static function ( $value ): int {
					if ( ! is_int( $value ) && ! is_string( $value ) ) {
						return 10;
					}

					$priority = filter_var(
						wp_unslash( $value ),
						FILTER_VALIDATE_INT,
						array( 'options' => array( 'min_range' => 1 ) )
					);

					return false === $priority ? 10 : $priority;
				},
				'default'           => 10,
			)
		);

		register_setting( static::$plugin_slug . '-post-setting', 'article_title_is_enable' );

		register_setting(
			static::$plugin_slug . '-post-setting',
			'article_title_extend',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'SketchpadModifiedPlugin\sanitize_extend_title',
				'default'           => ArticleTitleExtend::EXTEND,
			)
		);

		register_setting( static::$plugin_slug . '-post-setting', 'page_title_is_enable' );

		register_setting(
			static::$plugin_slug . '-post-setting',
			'page_title_extend',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'SketchpadModifiedPlugin\sanitize_extend_title',
				'default'           => ArticleTitleExtend::EXTEND,
			)
		);

		register_setting( static::$plugin_slug . '-admin-page-setting', 'admin_page_background_is_enable' );

		register_setting( static::$plugin_slug . '-admin-page-setting', 'admin_page_background_image' );

		register_setting(
			static::$plugin_slug . '-admin-page-setting',
			'admin_page_background_color',
			array(
				'type'              => 'string',
				'sanitize_callback' => static function ( $value ) {
					return is_string( $value ) ? sanitize_hex_color( $value ) : null;
				},
				'default'           => AdminBackground::BACKGROUND_COLOR,
			)
		);

		register_setting(
			static::$plugin_slug . '-admin-page-setting',
			'admin_page_background_opacity',
			array(
				'type'              => 'float',
				'sanitize_callback' => static function ( $value ): float {
					return is_numeric( $value ) ? min( 1, max( 0, (float) $value ) ) : 0.5;
				},
				'default'           => AdminBackground::OPACITY,
			)
		);

		register_setting(
			static::$plugin_slug . '-admin-page-setting',
			'admin_page_transparent_dom',
			array(
				'type'              => 'string',
				'sanitize_callback' => static function ( $value ): string {
					return is_string( $value ) ? sanitize_textarea_field( $value ) : '';
				},
				'default'           => AdminBackground::TARGET_DOM,
			)
		);

		register_setting( static::$plugin_slug . '-other-setting', 'add_rss_eyecatch' );
		add_option( 'add_rss_eyecatch', Flag::ON );

		register_setting( static::$plugin_slug . '-other-setting', 'remove_edituri_link' );
		add_option( 'remove_edituri_link', Flag::ON );
	}

	/**
	 * Add settings sections.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function add_settings_sections(): void {
		add_settings_section(
			'head_tag_setting',
			__( 'Head Tag Setting', 'sketchpad-modified-plugin' ),
			function () {
				echo '<p>' . esc_html__( 'You can insert html code into the head tag.', 'sketchpad-modified-plugin' ) . '</p>';
			},
			'sketchpad-modified-plugin-site-setting'
		);

		add_settings_section(
			'body_tag_setting',
			__( 'Body Tag Setting', 'sketchpad-modified-plugin' ),
			function () {
				echo '<p>' . esc_html__( 'You can insert html code into the body tag.', 'sketchpad-modified-plugin' ) . '</p>';
			},
			'sketchpad-modified-plugin-site-setting'
		);

		add_settings_section(
			'article_title_setting',
			__( 'Article Title Setting', 'sketchpad-modified-plugin' ),
			function () {
				echo '<p>' . esc_html__( 'Please enter if you want to add text to all article titles.', 'sketchpad-modified-plugin' ) . '</p>';
			},
			'sketchpad-modified-plugin-post-setting'
		);

		add_settings_section(
			'page_title_setting',
			__( 'Page Title Setting', 'sketchpad-modified-plugin' ),
			function () {
				echo '<p>' . esc_html__( 'Please enter if you want to add text to all page titles.', 'sketchpad-modified-plugin' ) . '</p>';
			},
			'sketchpad-modified-plugin-post-setting'
		);

		add_settings_section(
			'admin_page_setting',
			__( 'Admin Page Setting', 'sketchpad-modified-plugin' ),
			function () {
				echo '<p>' . esc_html__( 'Please enter if you want to background image for the admin panel.', 'sketchpad-modified-plugin' ) . '</p>';
			},
			'sketchpad-modified-plugin-admin-page-setting'
		);

		add_settings_section(
			'add_feature',
			__( 'Add Feature', 'sketchpad-modified-plugin' ),
			function () {
				echo '<p>' . esc_html__( "Adds new features to WordPress's standard feature.", 'sketchpad-modified-plugin' ) . '</p>';
			},
			'sketchpad-modified-plugin-other-setting'
		);

		add_settings_section(
			'disable_feature',
			__( 'Disable Feature', 'sketchpad-modified-plugin' ),
			function () {
				echo '<p>' . esc_html__( "Disable WordPress's default features.", 'sketchpad-modified-plugin' ) . '</p>';
			},
			'sketchpad-modified-plugin-other-setting'
		);
	}

	/**
	 * Add settings fields.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function add_settings_fields(): void {
		static::add_site_setting_fields();
		static::add_post_setting_fields();
		static::add_admin_page_setting_fields();
		static::add_other_setting_fields();
	}

	/**
	 * Add site setting fields.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	private static function add_site_setting_fields(): void {
		add_settings_field(
			'insert_head_is_enable',
			'',
			array( static::class, 'render_checkbox_item' ),
			'sketchpad-modified-plugin-site-setting',
			'head_tag_setting',
			array(
				'key'   => 'insert_head_is_enable',
				'label' => __(
					'Enable.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'insert_head',
			__( 'Insert Elements', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_textarea_item' ),
			'sketchpad-modified-plugin-site-setting',
			'head_tag_setting',
			array(
				'key' => 'insert_head',
			)
		);

		add_settings_field(
			'insert_head_priority',
			__( 'Priority', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_range_item' ),
			'sketchpad-modified-plugin-site-setting',
			'head_tag_setting',
			array(
				'key'           => 'insert_head_priority',
				'min'           => 0,
				'max'           => 10,
				'default_value' => 10,
				'step'          => 1,
				'text'          => __( 'The farther left you slide, the more the output will be directed to the head tag.', 'sketchpad-modified-plugin' ),
			)
		);

		add_settings_field(
			'insert_body_is_enable',
			'',
			array( static::class, 'render_checkbox_item' ),
			'sketchpad-modified-plugin-site-setting',
			'body_tag_setting',
			array(
				'key'   => 'insert_body_is_enable',
				'label' => __(
					'Enable.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'insert_body',
			__( 'Insert Elements', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_textarea_item' ),
			'sketchpad-modified-plugin-site-setting',
			'body_tag_setting',
			array(
				'key' => 'insert_body',
			)
		);

		add_settings_field(
			'insert_body_priority',
			__( 'Priority', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_range_item' ),
			'sketchpad-modified-plugin-site-setting',
			'body_tag_setting',
			array(
				'key'           => 'insert_body_priority',
				'min'           => 0,
				'max'           => 10,
				'default_value' => 10,
				'step'          => 1,
				'text'          => __( 'The farther left you slide, the more the output will be directed to the body tag.', 'sketchpad-modified-plugin' ),
			)
		);
	}
	/**
	 * Add post setting fields.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	private static function add_post_setting_fields(): void {
		add_settings_field(
			'article_title_is_enable',
			'',
			array( static::class, 'render_checkbox_item' ),
			'sketchpad-modified-plugin-post-setting',
			'article_title_setting',
			array(
				'key'   => 'article_title_is_enable',
				'label' => __(
					'Enable.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'article_title_extend',
			__( 'Extend all article titles', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_textarea_item' ),
			'sketchpad-modified-plugin-post-setting',
			'article_title_setting',
			array(
				'key'  => 'article_title_extend',
				'text' => __( '* The title of the article is set at location specified by the "{title}" keyword.', 'sketchpad-modified-plugin' ),
			)
		);

		add_settings_field(
			'page_title_is_enable',
			'',
			array( static::class, 'render_checkbox_item' ),
			'sketchpad-modified-plugin-post-setting',
			'page_title_setting',
			array(
				'key'   => 'page_title_is_enable',
				'label' => __(
					'Enable.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'page_title_extend',
			__( 'Extend all page titles', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_textarea_item' ),
			'sketchpad-modified-plugin-post-setting',
			'page_title_setting',
			array(
				'key'  => 'page_title_extend',
				'text' => __( '* The title of the page is set at location specified by the "{title}" keyword.', 'sketchpad-modified-plugin' ),
			)
		);
	}

	/**
	 * Add admin page setting fields.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	private static function add_admin_page_setting_fields(): void {
		add_settings_field(
			'admin_page_background_is_enable',
			'',
			array( static::class, 'render_checkbox_item' ),
			'sketchpad-modified-plugin-admin-page-setting',
			'admin_page_setting',
			array(
				'key'   => 'admin_page_background_is_enable',
				'label' => __(
					'Enable.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'admin_page_background_image',
			__( 'Background image', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_file_upload_item' ),
			'sketchpad-modified-plugin-admin-page-setting',
			'admin_page_setting',
			array(
				'key'   => 'admin_page_background_image',
				'label' => array(
					'title'    => __( 'Select a background image', 'sketchpad-modified-plugin' ),
					'use'      => __( 'Set as a background image', 'sketchpad-modified-plugin' ),
					'empty'    => __( 'Select a background image', 'sketchpad-modified-plugin' ),
					'registed' => __( 'Change the background image', 'sketchpad-modified-plugin' ),
					'delete'   => __( 'Remove the background image', 'sketchpad-modified-plugin' ),
				),
			)
		);

		add_settings_field(
			'admin_page_background_color',
			__( 'Background color', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_color_picker_item' ),
			'sketchpad-modified-plugin-admin-page-setting',
			'admin_page_setting',
			array(
				'key'     => 'admin_page_background_color',
				'default' => AdminBackground::BACKGROUND_COLOR,
			)
		);

		add_settings_field(
			'admin_page_background_opacity',
			__( 'Transparency', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_range_item' ),
			'sketchpad-modified-plugin-admin-page-setting',
			'admin_page_setting',
			array(
				'key'           => 'admin_page_background_opacity',
				'min'           => 0,
				'max'           => 1,
				'default_value' => AdminBackground::OPACITY,
				'step'          => 0.01,
				'text'          => __( 'The farther left you slide, the more transparent the image becomes.', 'sketchpad-modified-plugin' ),
			)
		);

		add_settings_field(
			'admin_page_transparent_dom',
			__( 'DOM to make transparent', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_textarea_item' ),
			'sketchpad-modified-plugin-admin-page-setting',
			'admin_page_setting',
			array(
				'key'           => 'admin_page_transparent_dom',
				'default_value' => AdminBackground::TARGET_DOM,
				'text'          => __( 'Enter the DOM elements you want to make transparent.', 'sketchpad-modified-plugin' ),
			)
		);
	}

	/**
	 * Add other setting fields.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	private static function add_other_setting_fields(): void {
		add_settings_field(
			'remove_edituri_link',
			__( 'EditURI', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_checkbox_item' ),
			'sketchpad-modified-plugin-other-setting',
			'disable_feature',
			array(
				'key'   => 'remove_edituri_link',
				'label' => __(
					'Stop the output of EditURI link.',
					'sketchpad-modified-plugin'
				),
			)
		);

		add_settings_field(
			'add_rss_eyecatch',
			__( 'RSS Eye-Catch', 'sketchpad-modified-plugin' ),
			array( static::class, 'render_checkbox_item' ),
			'sketchpad-modified-plugin-other-setting',
			'add_feature',
			array(
				'key'   => 'add_rss_eyecatch',
				'label' => __(
					'Display Featured Images in RSS Feeds.',
					'sketchpad-modified-plugin'
				),
			)
		);
	}
}
