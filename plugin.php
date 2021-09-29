<?php
/**
 * Plugin Name:        Sketchpad modified - Plugin
 * Plugin URI:         https://github.com/Angelmaneuver/sketchpad-modified-plugin
 * Description:        Custom plugin for myself.
 * Requires at latest: 5.8
 * Requires PHP:       7.4
 * Author:             Angelmaneuver
 * Author URI:         https://github.com/Angelmaneuver
 * Version:            0.1.0
 * License:            GNU General Public License V3
 * License URI:        https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:        sketchpad-modified-plugin
 * Domain Path:        /languages
 *
 * @package            Sketchpad modified - Plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Modules loading.
require_once __DIR__ . '/includes/load.php';

/**
 * Plugin initialization.
 *
 * @package sketchpad-modified-plugin
 */
function sketchpad_modified_plugin_init() {
	load_plugin_textdomain( 'sketchpad-modified-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'init', 'sketchpad_modified_plugin_init', 5 );
