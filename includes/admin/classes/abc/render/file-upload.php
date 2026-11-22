<?php
/**
 * Rendering function for the Admin page.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

/**
 * Render a file upload field using the WordPress media library.
 *
 * @param string                                                                                  $key Unique option key.
 * @param array{title?: string, use?: string, empty?: string, registed?: string, delete?: string} $label Upload button label.
 * @param string                                                                                  $text Element's caption.
 * @param string                                                                                  $class_prefix Optional class prefix.
 * @param string                                                                                  $size Optional image preview size.
 * @return void
 *
 * @since  0.2.0
 */
function render_file_upload_item( string $key, array $label, string $text, string $class_prefix = '', string $size = 'medium_large' ): void {
	$attachment_id = absint( get_option( $key, 0 ) );
	$is_image      = $attachment_id && wp_attachment_is_image( $attachment_id );
	$preview       = $is_image ? wp_get_attachment_image( $attachment_id, $size, false, array( 'class' => "{$class_prefix}file-preview" ) ) : "<img class=\"{$class_prefix}file-preview\" alt=\"\" style=\"display:none\">";
	$title         = isset( $label['title'] ) ? $label['title'] : __( 'Select an image', 'sketchpad-modified-plugin' );
	$use           = isset( $label['use'] ) ? $label['use'] : __( 'Set this image', 'sketchpad-modified-plugin' );
	$empty         = isset( $label['empty'] ) ? $label['empty'] : __( 'Select an image', 'sketchpad-modified-plugin' );
	$registed      = isset( $label['registed'] ) ? $label['registed'] : __( 'Change an image', 'sketchpad-modified-plugin' );
	$delete        = isset( $label['delete'] ) ? $label['delete'] : __( 'Delete an image', 'sketchpad-modified-plugin' );
	?>
<div class="<?php echo esc_attr( "{$class_prefix}image-content-preview" ); ?>">
	<?php echo $preview; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Generated markup or wp_get_attachment_image(). ?>
</div>
<input
	type  = "hidden"
	id    = "<?php echo esc_attr( $key ); ?>"
	name  = "<?php echo esc_attr( $key ); ?>"
	value = "<?php echo esc_attr( (string) $attachment_id ); ?>"
>
	<div class="<?php echo esc_attr( "{$class_prefix}buttons" ); ?><?php echo $attachment_id ? ' has-file' : ''; ?>">
		<button
			type        = "button"
			class       = "<?php echo esc_attr( "button {$class_prefix}upload-button" ); ?><?php echo $attachment_id ? '' : ' button-hero'; ?>"
			data-target = "<?php echo esc_attr( $key ); ?>"
			data-title  = "<?php echo esc_attr( $title ); ?>"
			data-use    = "<?php echo esc_attr( $use ); ?>"
			data-change = "<?php echo esc_attr( $registed ); ?>"
			data-empty  = "<?php echo esc_attr( $empty ); ?>"
		>
			<?php echo esc_html( $attachment_id ? $registed : $empty ); ?>
		</button>
		<button type="button" class="button button-secondary reset <?php echo esc_attr( "{$class_prefix}remove" ); ?>" data-target="<?php echo esc_attr( $key ); ?>" <?php echo $attachment_id ? '' : 'style="display:none"'; ?>><?php echo esc_html( $delete ); ?></button>
	</div>
	<?php if ( $text ) : ?>
		<p><?php echo esc_html( $text ); ?></p>
	<?php endif; ?>
</input>
	<?php
}

/**
 * Return inline JavaScript for file upload UI.
 *
 * @param string $class_prefix Optional class prefix.
 * @param string $size Optional image preview size.
 * @return string
 *
 * @since  0.2.0
 */
function get_file_upload_inline_script( string $class_prefix = '', string $size = 'medium_large' ): string {
	return <<<END
jQuery(function(\$){
	\$(document).on("click", ".{$class_prefix}upload-button",
		function(event){
			event.preventDefault();
			var button=\$(this);
			var frame=button.data("frame");

			if(!frame){
				var field=\$("#"+button.data("target"));
				var control=button.closest(".{$class_prefix}buttons");
				frame=wp.media({title:button.data("title"), button:{text:button.data("use")}, multiple:false});

				frame.on("select", function(){
					var attachment=frame.state().get("selection").first().toJSON();
					field.val(attachment.id).trigger("change");
					button.text(button.data("change"));
					var preview=control.parent().find(".{$class_prefix}file-preview");

					if(attachment.type==="image"){
						preview.attr("src", attachment.sizes&&attachment.sizes.{$size}?attachment.sizes.{$size}.url:attachment.url).attr("alt", attachment.alt||"").show();
					}else{
						preview.hide().attr("src","");
					}

					button.removeClass("button-hero")
					control.addClass("has-file").find(".{$class_prefix}remove").show();
				});

				button.data("frame", frame);
			}

			frame.open();
		}
	);
	\$(document).on("click", ".{$class_prefix}remove",
		function(event){
			event.preventDefault();
			var button=\$(this);
			var control=button.closest(".{$class_prefix}buttons");

			\$("#"+button.data("target")).val("").trigger("change");

			var upload=control.find(".{$class_prefix}upload-button");
			upload.addClass("button-hero")
			upload.text(upload.data("empty"));

			var preview=control.parent().find(".{$class_prefix}file-preview");
			preview.hide().attr("src", "");

			control.removeClass("has-file");
			button.hide();
		}
	);
});
END;
}

/**
 * Return inline StyleSheet for file upload UI.
 *
 * @param string $class_prefix Optional class prefix.
 * @return string
 *
 * @since  0.2.0
 */
function get_file_upload_inline_style( string $class_prefix = '' ): string {
	return minify(
		"
.{$class_prefix}image-content-preview {
	height: 100%;
    width: 350px;
    margin: 0 0 16px 0;
}
.{$class_prefix}file-preview {
	height: 100%;
    width: 100%;
}
.{$class_prefix}buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 0 0 16px 0;
}
button.reset.{$class_prefix}remove {
    color: #b32d2e;
    text-decoration: none;
    border-color: currentColor;
    box-shadow: none;
    background: transparent;
}
button.reset.{$class_prefix}remove:focus,
button.reset.{$class_prefix}remove:hover {
    background: #b32d2e;
    color: #fff;
    border-color: #b32d2e;
    box-shadow: 0 0 0 1px #b32d2e;
}
"
	);
}
