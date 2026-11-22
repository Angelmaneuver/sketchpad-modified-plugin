<?php
/**
 * Plugin Name:        Sketchpad modified - Plugin
 * Plugin URI:         https://github.com/Angelmaneuver/sketchpad-modified-plugin
 * Description:        We'll add features that aren't included in WordPress's standard functionality.
 * Requires at latest: 7.1
 * Requires PHP:       8.3
 * Author:             Angelmaneuver
 * Author URI:         https://github.com/Angelmaneuver
 * Version:            0.2.0
 * License:            GNU General Public License V3
 * License URI:        https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:        sketchpad-modified-plugin
 * Domain Path:        /languages
 *
 * @package            SketchpadModifiedPlugin
 * @since              0.1.0
 */

namespace SketchpadModifiedPlugin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loading modules.
 */
require_once __DIR__ . '/includes/bootstrap.php';

/**
 * Plugin initialization.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.1.0
 */
function init() {
	load_plugin_textdomain( 'sketchpad-modified-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'init', __NAMESPACE__ . '\\init', 5 );
