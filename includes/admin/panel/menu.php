<?php
/**
 * Overrides admin panel menu.
 *
 * @package sketchpad-modified-plugin
 * @since 1.0.0
 */

/**
 * Add a recycle block link.
 *
 * @since 1.0.0
 * @see https://developer.wordpress.org/reference/hooks/admin_menu/
 */
function register_sketchpad_admin_menu() {
	add_posts_page(
		_x( 'Reusable Blocks', 'block category' ),
		_x( 'Reusable Blocks', 'block category' ),
		'edit_dashboard',
		'edit.php?post_type=wp_block'
	);
}

add_action( 'admin_menu', 'register_sketchpad_admin_menu' );
