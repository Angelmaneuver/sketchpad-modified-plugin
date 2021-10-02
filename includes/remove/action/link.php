<?php
/**
 * Remove HTML documents meta data links.
 *
 * @package Sketchpad modified - Plugin
 * @since   0.1.0
 */

/**
 * Stop the output of EditURI link.
 *
 * @since 0.1.0
 * @see   https://developer.wordpress.org/reference/functions/rsd_link/
 */
if ( '1' === get_option( 'remove_edituri_link', '0' ) ) {
	remove_action( 'wp_head', 'rsd_link' );
}

/**
 * Stop the output of wlwmanifest link.
 *
 * @since 0.1.0
 * @see   https://developer.wordpress.org/reference/functions/wlwmanifest_link/
 */
if ( '1' === get_option( 'remove_wlwmanifest_link', '0' ) ) {
	remove_action( 'wp_head', 'wlwmanifest_link' );
}
