<?php
/**
 * ShortCode Initializer.
 *
 * @subpackage Sketchpad - modified - plugin 1.0
 * @since      Sketchpad - modified - plugin 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current = plugin_dir_path( __FILE__ );

require_once $current . 'shortcode/extend.php';

if( is_admin() ) {
	require_once $current . 'admin/panel/menu.php';
}
