<?php
/**
 * These features are needed to admin pages execute.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

use SketchpadModifiedPlugin\Extend_Settings_Page;

require_once __DIR__ . '/pages/class-extend-settings-page.php';

add_action(
	'init',
	array( Extend_Settings_Page::class, 'init' ),
	10
);

require_once __DIR__ . '/hooks/admin-background.php';
