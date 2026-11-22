<?php
/**
 * String Utility.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Perform a css minification.
 *
 * @param  string $css Css strings.
 * @return string
 *
 * @since   0.2.0
 */
function minify( string $css ): string {
	$minify = preg_replace( '/\s+/', ' ', $css );
	$minify = preg_replace( '/\s*([{}:;,])\s*/', '$1', $minify );
	$minify = trim( $minify );

	return $minify;
}
