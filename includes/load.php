<?php
/**
 * These functions are needed to execute Sketchpad modified - Plugin.
 *
 * @package Sketchpad modified - Plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Modules loading.
 */
if ( is_admin() ) {
	require_once __DIR__ . '/admin/load.php';
}

require_once __DIR__ . '/remove/load.php';
