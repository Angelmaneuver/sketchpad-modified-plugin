<?php
/**
 * Add the filter features.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

use SketchpadModifiedPlugin\Flag;

if ( Flag::ON !== get_option( 'insert_head_is_enable', Flag::OFF ) ) {
	return;
}

if ( '' === trim( get_option( 'insert_head', '' ) ) ) {
	return;
}

/**
 * Insert html elements to the head tag.
 *
 * @return void
 *
 * @since  0.2.0
 */
function insert_head(): void {
	$insert_head = trim( get_option( 'insert_head', '' ) );

	echo $insert_head; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

add_filter( 'wp_head', 'SketchpadModifiedPlugin\insert_head', get_option( 'insert_head_priority', 0 ) );
add_filter( 'admin_head', 'SketchpadModifiedPlugin\insert_head', get_option( 'insert_head_priority', 0 ) );
add_filter( 'embed_head', 'SketchpadModifiedPlugin\insert_head', get_option( 'insert_head_priority', 0 ) );
