<?php
/**
 * Remove the WordPress's default features.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.1.1
 */

use SketchpadModifiedPlugin\Flag;

/**
 * Stop the output of EditURI link.
 *
 * @since 0.1.0
 * @see   https://developer.wordpress.org/reference/functions/rsd_link/
 */
if ( Flag::ON === get_option( 'remove_edituri_link', Flag::ON ) ) {
	remove_action( 'wp_head', 'rsd_link' );
}
