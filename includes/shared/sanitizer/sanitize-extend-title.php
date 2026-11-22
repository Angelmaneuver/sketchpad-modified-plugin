<?php
/**
 * Sanitizer.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Sanitize extend title HTML into the title block.
 *
 * @param mixed $value Submitted value.
 * @return string
 *
 * @since 0.2.0
 */
function sanitize_extend_title( $value ): string {
	if ( ! is_string( $value ) ) {
		return '';
	}

	if ( current_user_can( 'unfiltered_html' ) ) {
		return $value;
	}

	return wp_kses_post( $value );
}
