<?php
/**
 * Rendering functions for textarea fields.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Render a textarea field with a button to restore its default value.
 *
 * @param string $key           Unique option key.
 * @param string $default_value Default textarea value.
 * @param string $reset_label   Reset button label.
 * @param string $text          Element's description.
 * @return void
 *
 * @since 0.2.0
 */
function render_textarea_item( string $key, string $default_value, string $reset_label, string $text ): void {
	$value = get_option( $key, $default_value );
	$value = is_string( $value ) ? $value : $default_value;
	?>
<div class="textarea-control">
	<textarea
		id           = "<?php echo esc_attr( $key ); ?>"
		name         = "<?php echo esc_attr( $key ); ?>"
		rows         = "8"
		data-default = "<?php echo esc_attr( $default_value ); ?>"
	><?php echo esc_textarea( $value ); ?></textarea>
</div>
<div class="textarea-buttons">
	<button type="button" class="button button-primary textarea-reset" data-target="<?php echo esc_attr( $key ); ?>">
		<?php echo '' !== $reset_label ? esc_html( $reset_label ) : esc_html__( 'Reset to default', 'sketchpad-modified-plugin' ); ?>
	</button>
</div>
	<?php if ( $text ) : ?>
		<p><?php echo esc_html( $text ); ?></p>
	<?php endif; ?>
	<?php
}

/**
 * Return inline JavaScript for resetting textarea fields.
 *
 * @return string
 *
 * @since 0.2.0
 */
function get_textarea_inline_script(): string {
	return <<<'END'
jQuery(function($){
	$(document).on("click", ".textarea-reset", function(){
		var input = $("#" + $(this).data("target"));
		input.val(input.data("default"));
	});
});
END;
}

/**
 * Return inline styles for textarea fields.
 *
 * @return string
 *
 * @since 0.2.0
 */
function get_textarea_inline_style(): string {
	return minify(
		'
.textarea-control > textarea {
	width: 550px;
	max-width: 100%;
	min-height: 235px;
}
.textarea-control, .textarea-buttons {
	margin: 0 0 16px 0;
}
.textarea-buttons .textarea-reset {
	min-height: 80px;
	padding: 0 32px;
	font-size: 22px;
}
'
	);
}
