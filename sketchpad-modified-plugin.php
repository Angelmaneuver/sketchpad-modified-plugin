<?php
/**
 * Plugin Name: sketchpad-modified-plugin
 * Plugin URI: https://github.com/Angelmaneuver/sketchpad-modified-plugin
 * Description: sketchpad-modified-plugin — is a custom plugin for myself.
 * Author: Angelmaneuver
 * Author URI: https://github.com/Angelmaneuver
 * Version: 1.0.0
 * License: License: GNU General Public License V3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: sketchpad-modified-plugin
 * Domain Path: /languages
 *
 * @package sketchpad-modified-plugin
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Apply the translation.
 *
 * @since 1.0.0
 */
function sketchpad_modified_plugin_load_textdomain() {
	load_plugin_textdomain( 'sketchpad-modified-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// Initilaize.
require_once plugin_dir_path( __FILE__ ) . 'includes/load.php';

add_action( 'init', 'sketchpad_modified_plugin_load_textdomain' );
