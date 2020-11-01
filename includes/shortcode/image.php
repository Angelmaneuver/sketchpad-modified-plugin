<?php
/**
 * Short code to output the path to the images this plugin hold.
 *
 * @subpackage sketchpad-modified-plugin
 * @since      1.0.0
 */

// return icon path
function sketchpad_get_icon_path( $atts ) {
  $type = $atts['type'];
  $path = plugins_url() . '/sketchpad-modified-plugin';

  switch( $type ) {
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
