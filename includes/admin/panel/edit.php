<?php
/**
 * Overrides admin edit.
 *
 * @package sketchpad-modified-plugin
 * @since 1.0.0
 */

/**
 * Overrides the sort condition of the recycle block list.
 *
 * @since 1.0.0
 * @param WP_Query $wp_query WP_Query instance.
 * @see https://developer.wordpress.org/reference/hooks/pre_get_posts/
 */
function sketchpad_default_order_in_admin_edit( $wp_query ) {
	global $pagenow;
	if ( 'edit.php' === $pagenow && 'wp_block' === $wp_query->query_vars['post_type'] && ! isset( $_GET['orderby'] ) ) {
		$wp_query->set( 'orderby', 'title' );
		$wp_query->set( 'order', 'asc' );
	}
}

add_filter( 'pre_get_posts', 'sketchpad_default_order_in_admin_edit' );
