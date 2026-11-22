<?php
/**
 * Sanitizer.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Sanitize HTML inserted into the document body.
 *
 * @param mixed $value Submitted value.
 * @return string
 *
 * @since 0.2.0
 */
function sanitize_insert_body_html( $value ): string {
	if ( ! is_string( $value ) ) {
		return '';
	}

	if ( current_user_can( 'unfiltered_html' ) ) {
		return $value;
	}

	return wp_kses_post( $value );
}
