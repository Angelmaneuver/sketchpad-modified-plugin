<?php
/**
 * Rendering functions for range fields.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Render a range field with a button to restore its default value.
 *
 * @param string $key           Unique option key.
 * @param float  $min           Minimum value.
 * @param float  $max           Maximum value.
 * @param float  $default_value Default value.
 * @param float  $step          Range step value.
 * @param string $reset_label   Reset button label.
 * @param string $text          Element's description.
 * @return void
 *
 * @since 0.2.0
 */
function render_range_item( string $key, float $min, float $max, float $default_value, float $step, string $reset_label, string $text ): void {
	$value = get_option( $key, $default_value );
	$value = is_numeric( $value ) ? min( $max, max( $min, (float) $value ) ) : $default_value;
	?>
<div class="range-control">
	<input
		type         = "range"
		id           = "<?php echo esc_attr( $key ); ?>"
		name         = "<?php echo esc_attr( $key ); ?>"
		min          = "<?php echo esc_attr( (string) $min ); ?>"
		max          = "<?php echo esc_attr( (string) $max ); ?>"
		step         = "<?php echo esc_attr( (string) $step ); ?>"
		value        = "<?php echo esc_attr( (string) $value ); ?>"
		data-default = "<?php echo esc_attr( (string) $default_value ); ?>"
	>
</div>
<div class="range-buttons">
	<button type="button" class="button button-primary range-reset" data-target="<?php echo esc_attr( $key ); ?>">
		<?php echo '' !== $reset_label ? esc_html( $reset_label ) : esc_html__( 'Reset to default', 'sketchpad-modified-plugin' ); ?>
	</button>
</div>
	<?php if ( $text ) : ?>
		<p><?php echo esc_html( $text ); ?></p>
	<?php endif; ?>
	<?php
}

/**
 * Return inline JavaScript for resetting range fields.
 *
 * @return string
 *
 * @since 0.2.0
 */
function get_range_inline_script(): string {
	return <<<'END'
jQuery(function($){
	$(document).on("click", ".range-reset", function(){
		var input = $("#" + $(this).data("target"));
		input.val(input.data("default"));
	});
});
END;
}

/**
 * Return inline StyleSheet for range fields UI.
 *
 * @return string
 *
 * @since  0.2.0
 */
function get_range_inline_style(): string {
	return minify(
		'
.range-control > input {
	width: 350px;
}
.range-control, .range-buttons {
    margin: 0 0 16px 0;
}
'
	);
}
