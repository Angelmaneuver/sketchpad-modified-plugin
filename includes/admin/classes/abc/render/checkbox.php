<?php
/**
 * Rendering function for the Admin page.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

require_once __DIR__ . '/../enum/checkbox-value.php';

use SketchpadModifiedPlugin\CheckBoxValue;

/**
 * Rendering checkbox.
 *
 * @param  string $key Unique Identifier.
 * @param  string $value Initial value.
 * @param  string $label Element's label.
 * @param  string $text Element's caption.
 * @return void
 */
function render_checkbox_item( string $key, string $value, string $label, string $text ): void {
	$checked = CheckBoxValue::True->value === $value ? 'checked' : '';
	?>
<input
	type  = "checkbox"
	id    = "<?php echo esc_attr( $key ); ?>"
	name  = "<?php echo esc_attr( $key ); ?>"
	value = "<?php echo esc_attr( CheckBoxValue::True->value ); ?>"
	<?php echo esc_attr( $checked ); ?>
>
<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
<p><?php echo esc_html( $text ); ?></p>
	<?php
}
