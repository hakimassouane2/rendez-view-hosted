<?php 

if( !defined( 'ABSPATH' ) ) exit();


global $post;

$prefix = OVAEM_Settings::$prefix;
$post_id    = $post->ID;

$speaker_job = get_post_meta( $post_id , $prefix.'_speaker_job', true );

$speaker_phone = get_post_meta( $post_id , $prefix.'_speaker_phone', true );

$speaker_mail = get_post_meta( $post_id , $prefix.'_speaker_mail', true );

$speaker_address = get_post_meta( $post_id , $prefix.'_speaker_address', true );

$speaker_website = get_post_meta( $post_id , $prefix.'_speaker_website', true );


$speaker_featured = get_post_meta( $post_id , $prefix.'_speaker_featured', true ) ? get_post_meta( $post_id , $prefix.'_speaker_featured', true ) : 'no';
$speaker_order = get_post_meta( $post_id , $prefix.'_speaker_order', true ) ? get_post_meta( $post_id , $prefix.'_speaker_order', true ) : 1;

?>

 <div class="container-fluid">
 	<div class="row">

 		


		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Order', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($speaker_order); ?>"  name="<?php echo esc_attr($prefix);?>_speaker_order" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Featured', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<select name="<?php echo esc_attr($prefix);?>_speaker_featured">
		 		<option value="no" <?php echo ($speaker_featured == 'no' ) ? 'selected' : ''; ?> ><?php esc_html_e( 'No', 'ovaem-events-manager' ); ?> </option>
		 		<option value="yes" <?php echo ($speaker_featured == 'yes' ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Yes', 'ovaem-events-manager' ); ?> </option>
		 	</select>
		</div>

		<br>
 		- - - - - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - - - - - -
		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Job', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($speaker_job); ?>"  name="<?php echo esc_attr($prefix);?>_speaker_job" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Phone', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($speaker_phone); ?>"  name="<?php echo esc_attr($prefix);?>_speaker_phone" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Mail', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($speaker_mail); ?>"  name="<?php echo esc_attr($prefix);?>_speaker_mail" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Address', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($speaker_address); ?>"  name="<?php echo esc_attr($prefix);?>_speaker_address" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Website', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($speaker_website); ?>"  name="<?php echo esc_attr($prefix);?>_speaker_website" />
		</div>

		<div class="ovaem_event_row">
		 	<label class="label">
		 		<br/>
		 		<strong><?php esc_html_e( 'Social Network', 'ovaem-events-manager' ); ?>: </strong><br/><br/>

		 		<div class="content_social">
		 			<!-- Ajax display here -->
		 		</div>

		 		<div class="add_social" data-speaker-id="<?php echo esc_attr($post_id);?>">
		 			<a href="#" class="button button-primary button-large">
		 				<?php esc_html_e('Add Social', 'ovaem-events-manager'); ?>
		 			</a>
		 		</div>

		 	</label>
		 	
		</div>

 	</div>
 </div>

 

<?php wp_nonce_field( 'ova_events_nonce', 'ova_events_nonce' ); ?>
 