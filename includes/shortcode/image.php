<?php
/**
 * Output the path to the images this plugin hold.
 *
 * @package sketchpad-modified-plugin
 * @since 1.0.0
 */

/**
 * Get icon path short code.
 *
 * @since 1.0.0
 * @param (array|string) $atts arguments for get icon path.
 * @return (void|string) Void if argument is on failure. Otherwise, icon path as a string.
 */
function sketchpad_get_icon_path( $atts ) {
	$type = $atts['type'];
	$path = plugins_url() . '/sketchpad-modified-plugin';

	switch ( $type ) {
		case 'github':
			$path .= '/images/icon/GitHub-Mark-32px.png';
			break;
		case 'twitter':
			$path .= '/images/icon/Twitter_Social_Icon_Circle_Color.png';
			break;
		default:
			$path = null;
	}

	return $path;
}

add_shortcode( 'sketchpad_get_icon_path', 'sketchpad_get_icon_path' );
