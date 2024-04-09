<?php if( !defined( 'ABSPATH' ) ) exit();

$prefix = OVAEM_Settings::$prefix;
$post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : '';

$org_name = get_post_meta( $post_id , $prefix.'_org_name', true ) ? get_post_meta( $post_id , $prefix.'_org_name', true ) : '';
$org_email = get_post_meta( $post_id , $prefix.'_org_email', true ) ? get_post_meta( $post_id , $prefix.'_org_email', true ) : '';
$org_phone = get_post_meta( $post_id , $prefix.'_org_phone', true ) ? get_post_meta( $post_id , $prefix.'_org_phone', true ) : '';
$org_website = get_post_meta( $post_id , $prefix.'_org_website', true ) ? get_post_meta( $post_id , $prefix.'_org_website', true ) : '';
$org_desc = get_post_meta( $post_id , $prefix.'_org_desc', true ) ? get_post_meta( $post_id , $prefix.'_org_desc', true ) : '';	
$logo = get_post_meta( $post_id , $prefix.'_org_logo', true ) ? get_post_meta( $post_id , $prefix.'_org_logo', true ) : '';

?>

<div class="ovaem_event_row">
	<label class="label">
		<strong><?php esc_html_e( 'Logo (.png)', 'ovaem-events-manager' ); ?>:</strong>
	</label>
	<br><br>
	<?php
		$value = '';
		
		if ( $logo ) {
			$image_attributes = wp_get_attachment_image_src( $logo, 'medium' );
			$src 	= $image_attributes[0];
			$value 	= $logo;
		}
	?>
	<div class="upload">
		<?php if ( $logo ) { ?>
			<img class="img_logo" data-src="<?php echo esc_url( $src ); ?>" src="<?php echo esc_url( $src ); ?>" width="100px"/>
		<?php } ?>
		    <img class="img_logo_2" src="" width="100px" style="display: none;"/>
		<div>
			<input type="hidden" name="<?php echo $prefix;?>_org_logo" value="<?php echo  esc_attr( $value ); ?>" />
			<button type="submit" class="upload_image_button button">
				<?php esc_html_e( 'Upload', 'ovaem-events-manager' ); ?>
			</button>
			<button type="submit" class="remove_image_button button">&times;</button>
		</div>
	</div>
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Name', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" value="<?php echo esc_attr($org_name); ?>" placeholder="Insert Name"  name="<?php echo esc_attr($prefix); ?>_org_name" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Email', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" value="<?php echo esc_attr($org_email); ?>" placeholder="Insert Email"  name="<?php echo esc_attr($prefix); ?>_org_email" />
</div>
<br/>


<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Phone', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="number" value="<?php echo esc_attr($org_phone); ?>" placeholder="Insert Phone"  name="<?php echo esc_attr($prefix); ?>_org_phone" />
</div>
<br/>


<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Website', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" value="<?php echo esc_attr($org_website); ?>" placeholder="Insert Website"  name="<?php echo esc_attr($prefix); ?>_org_website" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Description', 'ovaem-events-manager' ); ?>: </strong></label>
	<textarea name="<?php echo esc_attr($prefix); ?>_org_desc" rows="10" cols="70"><?php echo esc_attr($org_desc); ?></textarea>
</div>
<br/>



