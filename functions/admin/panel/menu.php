<?php
/**
 * Rewriting admin panel menu.
 *
 * @subpackage Sketchpad - modified - plugin 1.0
 * @since      Sketchpad - modified - plugin 1.0
 */

//  add a recycle block editor
function register_sketchpad_admin_menu() {
	add_posts_page(
		__( 'Recycle Block', 'sketchpad-modified-plugin' ),
		__( 'Recycle Block', 'sketchpad-modified-plugin' ),
		'edit_dashboard',
		'edit.php?post_type=wp_block'
	);
}

add_action( 'admin_menu', 'register_sketchpad_admin_menu' );
