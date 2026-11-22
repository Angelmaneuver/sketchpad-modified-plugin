<?php
/**
 * Constant Class.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Admin Background Constant Class
 *
 * Manage admin background default values.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */
class AdminBackground {
	public const BACKGROUND_COLOR = '#f1f1f1';
	public const OPACITY          = 0.5;
	public const TARGET_DOM       = <<<'EOM'
body, .postbox, #activity-widget, #the-comment-list, .comment-item, .community-events ul, .edit-post-header, .components-notice, .interface-interface-skeleton__content, .edit-post-visual-editor, .editor-styles-wrapper, .edit-post-visual-editor__content-area > div, .edit-post-layout__footer
EOM;
}
