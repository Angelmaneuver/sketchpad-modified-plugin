<?php
/**
 * Add the admin page's background features.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

use SketchpadModifiedPlugin\Flag;
use SketchpadModifiedPlugin\AdminBackground;

if ( Flag::ON !== get_option( 'admin_page_background_is_enable', Flag::OFF ) ) {
	return;
}

if ( ! wp_attachment_is_image( absint( get_option( 'admin_page_background_image', 0 ) ) ) ) {
	return;
}

/**
 * Register the background style for the admin area.
 *
 * @return void
 *
 * @since  0.2.0
 */
function enqueue_admin_page_background_style(): void {
	$attachment_id = absint( get_option( 'admin_page_background_image', 0 ) );
	if ( ! wp_attachment_is_image( $attachment_id ) ) {
		return;
	}

	$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
	$hex       = preg_replace( '/#/', '', get_option( 'admin_page_background_color', AdminBackground::BACKGROUND_COLOR ) );
	$red       = hexdec( substr( $hex, 0, 2 ) );
	$green     = hexdec( substr( $hex, 2, 2 ) );
	$blue      = hexdec( substr( $hex, 4, 2 ) );
	$opacity   = get_option( 'admin_page_background_opacity', AdminBackground::OPACITY );
	$targets   = get_option( 'admin_page_transparent_dom', AdminBackground::TARGET_DOM );

	$style = <<<EOM
#wpwrap:before {
	content:"";
	position: fixed;
	top: 0;
	left: 0;
	width:100%;
	height:100%;
	background-image:
		linear-gradient(rgba({$red}, {$green}, {$blue}, {$opacity}), rgba({$red}, {$green}, {$blue}, {$opacity})), url("{$image_url}");
		background-repeat: no-repeat;
		background-size: cover;
}
{$targets} {
	background-color: rgba(255, 255, 255, 0) !important;
}
EOM;

	wp_add_inline_style( 'wp-admin', minify( $style ) );
}

add_action( 'admin_enqueue_scripts', 'SketchpadModifiedPlugin\enqueue_admin_page_background_style' );
