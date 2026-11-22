<?php
/**
 * Sanitizer.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Sanitize HTML inserted into the document head.
 *
 * @param mixed $value Submitted value.
 * @return string
 *
 * @since 0.2.0
 */
function sanitize_insert_head_html( $value ): string {
	if ( ! is_string( $value ) ) {
		return '';
	}

	if ( current_user_can( 'unfiltered_html' ) ) {
		return $value;
	}

	return wp_kses(
		$value,
		array(
			'base'     => array(
				'href'   => true,
				'target' => true,
			),
			'link'     => array(
				'as'            => true,
				'blocking'      => true,
				'color'         => true,
				'crossorigin'   => true,
				'fetchpriority' => true,
				'hreflang'      => true,
				'href'          => true,
				'imagesizes'    => true,
				'imagesrcset'   => true,
				'integrity'     => true,
				'media'         => true,
				'rel'           => true,
				'sizes'         => true,
				'title'         => true,
				'type'          => true,
			),
			'meta'     => array(
				'charset'    => true,
				'content'    => true,
				'http-equiv' => true,
				'name'       => true,
				'property'   => true,
			),
			'noscript' => array(),
			'title'    => array(),
		)
	);
}
