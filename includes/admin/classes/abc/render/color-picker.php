<?php
/**
 * Rendering functions for color picker fields.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Render a WordPress color picker field with a reset button.
 *
 * @param string $key           Unique option key.
 * @param string $default_color Default color.
 * @return void
 *
 * @since 0.2.0
 */
function render_color_picker_item( string $key, string $default_color ): void {
	$value = get_option( $key, $default_color );
	$value = is_string( $value ) ? sanitize_hex_color( $value ) : null;
	$value = null === $value ? $default_color : $value;
	?>
<input
	type               = "text"
	id                 = "<?php echo esc_attr( $key ); ?>"
	name               = "<?php echo esc_attr( $key ); ?>"
	value              = "<?php echo esc_attr( $value ); ?>"
	class              = "color-picker-field"
	data-default-color = "<?php echo esc_attr( $default_color ); ?>"
>
	<?php
}

/**
 * Return inline JavaScript for color picker UI.
 *
 * @return string
 *
 * @since  0.2.0
 */
function get_color_picker_inline_script(): string {
	return 'jQuery(function($){ $(".color-picker-field").wpColorPicker(); });';
}
