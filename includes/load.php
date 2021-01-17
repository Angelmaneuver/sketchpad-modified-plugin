<?php
/**
 * These functions are needed to load sketchpad - modified plugin.
 *
 * @package sketchpad-modified-plugin
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current = plugin_dir_path( __FILE__ );

if ( is_admin() ) {
	require_once $current . 'admin/panel/edit.php';
	require_once $current . 'admin/panel/menu.php';
}

require_once $current . 'shortcode/extend.php';
require_once $current . 'shortcode/image.php';
