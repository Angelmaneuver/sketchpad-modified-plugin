<?php
/**
 * Overrides admin panel menu.
 *
 * @package Sketchpad modified - Plugin
 * @since   0.1.0
 */

/**
 * Add a Recycle Block link.
 *
 * @since 0.1.0
 * @see   https://developer.wordpress.org/reference/hooks/admin_menu/
 */
function register_sketchpad_admin_menu() {
	add_posts_page(
		_x( 'Reusable Blocks', 'block category' ),
		_x( 'Reusable Blocks', 'block category' ),
		'edit_dashboard',
		'edit.php?post_type=wp_block'
	);
}

if ( '1' === get_option( 'add_reusable_blocks_link', '0' ) ) {
	add_action( 'admin_menu', 'register_sketchpad_admin_menu' );
}
