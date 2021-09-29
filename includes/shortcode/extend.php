<?php
/**
 * Short code created by extending an existing feature.
 *
 * @package Sketchpad modified - Plugin
 * @since   0.1.0
 */

/**
 * Method to extend tag cloud.
 *
 * @since 1.0.0
 * @param array $args Args used for the tag cloud widget.
 * @return extended $args.
 * @see https://developer.wordpress.org/reference/hooks/widget_tag_cloud_args/
 */
function sketchpad_wp_tag_cloud( $args ) {
	$myargs = array( 'number' => 0 );
	$args   = wp_parse_args( $args, $myargs );
	return $args;
}

/**
 * Tag cloud short code.
 *
 * @since 1.0.0
 * @param (array|string) $atts arguments for displaying a tag cloud.
 * @return (void|string|array) Void if 'echo' argument is true, or on failure. Otherwise, tag cloud as a string or an array, depending on 'format' argument.
 * @see https://developer.wordpress.org/reference/functions/wp_tag_cloud/
 */
function sketchpad_tag_cloud( $atts ) {
	$args = array(
		'smallest'                  => 8,
		'largest'                   => 22,
		'unit'                      => 'pt',
		'number'                    => 0,
		'format'                    => 'list',
		'separator'                 => "\n",
		'orderby'                   => 'name',
		'order'                     => 'ASC',
		'exclude'                   => null,
		'include'                   => null,
		'topic_count_text_callback' => null,
		'link'                      => 'view',
		'taxonomy'                  => 'post_tag',
		'echo'                      => false,
		'child_of'                  => null,
	);

	return wp_tag_cloud( is_array( $atts ) ? array_merge( $args, $atts ) : $args );
}

/**
 * Get avatar short code.
 *
 * @since 1.0.0
 * @param (array|string) $atts arguments for displaying a avatar.
 * @return (string|false) <img> tag for the user's avatar. False on failure.
 * @see https://developer.wordpress.org/reference/functions/get_avatar/
 */
function sketchpad_get_avatar( $atts ) {
	$id_or_email = $atts['id_or_email'];
	$size        = $atts['size'];
	$default     = $atts['default'];
	$alt         = $atts['alt'];
	$args        = $atts['args'];
	return get_avatar( $id_or_email, $size, $default, $alt, $args );
}

add_filter( 'widget_tag_cloud_args', 'sketchpad_wp_tag_cloud' );

add_shortcode( 'sketchpad_tag_cloud', 'sketchpad_tag_cloud' );
add_shortcode( 'sketchpad_get_avatar', 'sketchpad_get_avatar' );
