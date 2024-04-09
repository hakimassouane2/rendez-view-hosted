<?php if( !defined( 'ABSPATH' ) ) exit();


$post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : '';
$galleries = get_post_meta( $post_id, 'ovaem_gallery_id', true); 

?>

<table class="ovaem_ad_galleries form-table">
	<tr><td>
		<a class="gallery-add button button button-primary button-large text-right" href="#" data-uploader-title="<?php esc_html_e( "Add image(s) to gallery", "ovaem-events-manager" ); ?>" data-uploader-button-text="Add image(s)"><?php esc_html_e( "Add image(s)", "ovaem-events-manager" ); ?></a>

		<ul id="gallery-metabox-list">
			<?php if ($galleries) : foreach ($galleries as $key => $value) : $image = wp_get_attachment_image_src($value); ?>

				<li>
					<input type="hidden" name="ovaem_gallery_id[<?php echo $key; ?>]" value="<?php echo esc_attr($value); ?>">
					<img class="image-preview" src="<?php echo $image[0]; ?>">
					<a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image"><?php esc_html_e( "Change image", "ovaem-events-manager" ); ?></a><br>
					<small><a class="remove-image" href="#"><?php esc_html_e( "Remove image", "ovaem-events-manager" ); ?></a></small>
				</li>

			<?php endforeach; endif; ?>
		</ul>

	</td></tr>
</table>