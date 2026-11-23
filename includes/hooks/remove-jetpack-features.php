<?php
/**
 * Remove the Jetpack's default features.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.1
 */

use SketchpadModifiedPlugin\Flag;

/**
 * Stop the output of implode frontend css.
 *
 * @since 0.2.1
 * @see   https://developer.jetpack.com/hooks/jetpack_implode_frontend_css/
 */
if ( Flag::ON === get_option( 'remove_implode_frontend_css', Flag::OFF ) ) {
	add_filter( 'jetpack_implode_frontend_css', '__return_false' );
}
