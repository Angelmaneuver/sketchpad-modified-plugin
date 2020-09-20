<?php
/**
 * Short code created by extending an existing feature.
 *
 * @subpackage Sketchpad - modified - plugin 1.0
 * @since      Sketchpad - modified - plugin 1.0
 */

// has_tag customize for sketchpad - modified
function sketchpad_has_tag( $atts ) {
  $tag = $atts['tag'];
  $true = $atts['true'];
  $false = $atts['false'];
  $result = '';

  if( !empty( $tag ) && ( !empty( $true ) || !empty( $false ) ) ) {
    $result = has_tag( $tag ) ? $true : $false;
  }

  return $result;
}

// return tag list
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
    'topic_count_text_callback' => default_topic_count_text,
    'link'                      => 'view',
    'taxonomy'                  => 'post_tag',
    'echo'                      => false,
    'child_of'                  => null,
  );

  return wp_tag_cloud( is_array( $atts ) ? array_merge( $args, $atts ) : $args );
}

// return avatar
function sketchpad_get_avatar( $atts ) {
  $id_or_email = $atts['id_or_email'];
  $size = $atts['size'];
  $default = $atts['default'];
  $alt = $atts['alt'];
  $args = $atts['args'];
  return get_avatar( $id_or_email, $size, $default, $alt, $args );
}

/* customize for tag cloud */
function sketchpad_wp_tag_cloud($args) {
  $myargs = array(
    'number' => 0
  );
  $args = wp_parse_args($args, $myargs);
  
  return $args;
}

add_filter( 'widget_tag_cloud_args', 'sketchpad_wp_tag_cloud' );

add_shortcode( 'sketchpad_has_tag', 'sketchpad_has_tag' );
add_shortcode( 'sketchpad_tag_cloud', 'sketchpad_tag_cloud' );
add_shortcode( 'sketchpad_get_avatar', 'sketchpad_get_avatar' );
