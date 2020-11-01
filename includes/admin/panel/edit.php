<?php
/**
 * Rewriting admin edit.
 *
 * @subpackage sketchpad-modified-plugin
 * @since      1.0.0
 */

// set a default order
function sketchpad_default_order_in_admin_edit( $wp_query ){
  global $pagenow;
  if ( $pagenow === 'edit.php' && $wp_query->query_vars['post_type'] === 'wp_block' && !isset($_GET['orderby'] ) ) {
    $wp_query->set( 'orderby', 'title' );
    $wp_query->set( 'order', 'asc' );
  }
}

add_filter( 'pre_get_posts', 'sketchpad_default_order_in_admin_edit' );
