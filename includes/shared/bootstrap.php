<?php
/**
 * These modules are needed to execute.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

/**
 * Loading modules.
 */
require_once __DIR__ . '/constants/class-flag.php';
require_once __DIR__ . '/constants/class-articletitleextend.php';
require_once __DIR__ . '/constants/class-adminbackground.php';

/**
 * Loading utilities.
 */
require_once __DIR__ . '/util/minify.php';

/**
 * Loading sanitizers.
 */
require_once __DIR__ . '/sanitizer/sanitize-insert-head-html.php';
require_once __DIR__ . '/sanitizer/sanitize-insert-body-html.php';
require_once __DIR__ . '/sanitizer/sanitize-extend-title.php';
