<?php
/**
 * Abstract class for the Admin page.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

require_once __DIR__ . '/class-abstract-settings-api-page.php';

use SketchpadModifiedPlugin\Abstract_Settings_Api_Page;

/**
 * Abstract Settings Api Tab Page Class
 *
 * Defines the plugin name, version, and hooks.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */
abstract class Abstract_Settings_Api_Tab_Page extends Abstract_Settings_Api_Page {

	/**
	 * The default tab.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    string  $default_tab The key of default tab.
	 */
	protected static string $default_tab;

	/**
	 * The tabs.
	 *
	 * @since  0.2.0
	 * @access protected
	 * @var    array{string, string} $tabs The tabs associative array (tab key => tab label).
	 */
	protected static array $tabs = array();

	/**
	 * Initialize the class and set admin page.
	 *
	 * @since 0.2.0
	 */
	public static function init() {
		parent::init();

		static::set_tabs();
	}

	/**
	 * Set tabs.
	 *
	 * @since  0.2.0
	 */
	abstract protected static function set_tabs(): void;

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	protected static function enqueue_styles(): void {
		$css = "
			.nav-tab-wrapper {
				display: flex;
				justify-content: center;
				align-items: flex-end;
				gap: 4px;
				margin: 20px 0 0;
				padding: 0;
				border-bottom: 1px solid #c3c4c7;
			}
			.nav-tab-wrapper .nav-tab {
				margin: 0 4px 0 0;
				padding: 8px 12px;
				border: none;
				border-radius: 0;
				background: transparent;
				color: #50575e;
				text-decoration: none;
				line-height: 1.4;
				position: relative;
			}
			.nav-tab-wrapper .nav-tab:hover {
				background: transparent;
				color: #2271b1;
			}
			.nav-tab-wrapper .nav-tab.nav-tab-active {
				background: transparent;
				color: #1d2327;
			}
			.nav-tab-wrapper .nav-tab.nav-tab-active::after {
				content: '';
				display: block;
				position: absolute;
				left: 0;
				right: 0;
				bottom: -1px;
				height: 2px;
				background: #2271b1;
			}
			.wrap form {
				margin-top: 16px;
				padding: 12px 0 0;
			}
		";

		wp_add_inline_style( 'wp-admin', minify( $css ) );
	}

	/**
	 * Display the administration screen.
	 *
	 * @return void
	 *
	 * @since  0.2.0
	 */
	public static function show(): void {
		$active = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : static::$default_tab; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Tab selection is navigation state, not form submission.

		if ( ! array_key_exists( $active, static::$tabs ) ) {
			$active = static::$default_tab;
		}

		$title       = static::$plugin_submenu_text;
		$plugin_slug = static::$plugin_slug;
		$page_slug   = "{$plugin_slug}-{$active}";
		?>
<div class="wrap">
	<h2><?php echo esc_html( "{$title}" ); ?></h2>
	<nav class="nav-tab-wrapper">
		<?php foreach ( static::$tabs as $slug => $label ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'tab', $slug, admin_url( "options-general.php?page={$plugin_slug}" ) ) ); ?>" class="nav-tab <?php echo $active === $slug ? 'nav-tab-active' : ''; ?>">
				<?php echo esc_html( $label ); ?>
			</a>
		<?php endforeach; ?>
	</nav>
	<form action="options.php" method="post">
		<?php
		settings_fields( "{$plugin_slug}-{$active}" );
		do_settings_sections( $page_slug );
		submit_button();
		?>
	</form>
</div>
		<?php
	}
}
