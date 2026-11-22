<?php
/**
 * Add the filter features.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

use SketchpadModifiedPlugin\Flag;

if ( Flag::ON !== get_option( 'insert_body_is_enable', Flag::OFF ) ) {
	return;
}

if ( '' === trim( get_option( 'insert_body', '' ) ) ) {
	return;
}

/**
 * Insert html elements to the body tag.
 *
 * @return void
 *
 * @since  0.2.0
 */
function insert_body(): void {
	$insert_body = trim( get_option( 'insert_body', '' ) );

	echo $insert_body; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

add_filter( 'wp_body_open', 'SketchpadModifiedPlugin\insert_body', get_option( 'insert_body_priority', 0 ) );
