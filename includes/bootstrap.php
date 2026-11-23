<?php
/**
 * These features are needed to execute.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.1.0
 */

/**
 * Loading shared modules.
 */
require_once __DIR__ . '/shared/bootstrap.php';

if ( is_admin() ) {
	/**
	 * Loading for the admin pages modules.
	 */
	require_once __DIR__ . '/admin/bootstrap.php';
} else {
	/**
	 * Loading for the other pages modules.
	 */
	require_once __DIR__ . '/hooks/remove-actions.php';
	require_once __DIR__ . '/hooks/extend-title.php';
	require_once __DIR__ . '/hooks/add-rss-eye-catch.php';
}

/**
 * Loading for the all pages module.
 */
require_once __DIR__ . '/hooks/add-head.php';
require_once __DIR__ . '/hooks/add-body.php';
require_once __DIR__ . '/hooks/remove-jetpack-features.php';
