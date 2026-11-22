<?php
/**
 * Add the filter features.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

use SketchpadModifiedPlugin\Flag;

if ( Flag::ON !== get_option( 'add_rss_eyecatch', Flag::ON ) ) {
	return;
}

/**
 * Insert namespace of RSS feeds.
 *
 * @return void
 *
 * @since  0.2.0
 */
function insert_namespaces(): void {
	echo <<<'EOM'
xmlns:media="http://search.yahoo.com/mrss/"

EOM;
}

add_action( 'rss2_ns', 'SketchpadModifiedPlugin\insert_namespaces' );

/**
 * Insert Eye-Catch of RSS feeds.
 *
 * @return void
 *
 * @since  0.2.0
 */
function insert_eye_catch(): void {
	if ( ! has_post_thumbnail() ) {
		return;
	}

	$thumbnail_id = get_post_thumbnail_id();
	$image        = wp_get_attachment_image_src( $thumbnail_id );
	if ( false === $image ) {
		return;
	}

	printf(
		'<media:thumbnail url="%s" />' . "\n",
		esc_url( $image[0] )
	);

	$file      = get_attached_file( $thumbnail_id );
	$file_size = $file ? wp_filesize( $file ) : false;
	$mime_type = get_post_mime_type( $thumbnail_id );
	if ( false === $file_size || ! $mime_type ) {
		return;
	}

	printf(
		'<enclosure url="%s" length="%s" type="%s" />' . "\n",
		esc_url( $image[0] ),
		esc_attr( (string) $file_size ),
		esc_attr( $mime_type )
	);
}

add_action( 'rss2_item', 'SketchpadModifiedPlugin\insert_eye_catch' );
