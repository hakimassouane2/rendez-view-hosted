<?php if ( !defined( 'ABSPATH' ) ) exit();

	global $post;
	
	
?>
<div class="ovame_order_detail">



	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Code", "ovaem-events-manager" ); ?>: </strong>
			<strong><?php echo get_post_meta( $post->ID, 'ovaem_ticket_code', true ) ?></strong>
		</label>
		<br><br>
	</div>	


	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Ticket Verify", "ovaem-events-manager" ); ?>: </strong>
			<?php if( get_post_meta( $post->ID, 'ovaem_ticket_verify', true ) == 'true' ){
				echo '<strong style="color: blue">'.esc_html__('Verify ( Customer has paid )', 'ovaem-events-manager').'</strong>';
			}else{
				echo '<strong style="color: red">'.esc_html__('Not Verify ( Customer has not paid ) ', 'ovaem-events-manager').'</strong>';
			}

			?>
		</label>
		<br><br>
	</div>	

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Status", "ovaem-events-manager" ); ?>: </strong>
			<?php if( get_post_meta( $post->ID, 'ovaem_ticket_status', true ) == 'checked_in' ){
				
				echo '<strong style="color: blue">'.esc_html__('Checked In', 'ovaem-events-manager').'</strong>';

				
			}else{

				echo '<strong style="color: red">'.esc_html__('Not Checked In', 'ovaem-events-manager').'</strong>';
				
			}
			?>
		</label>
		<br><br>
	</div>

	


	<h3><?php esc_html_e( "Purchaser", 'ovaem-events-manager' ); ?></h3>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Name",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_buyer_name', true ) ?>
		</label>
		<br><br>
	</div>
	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Email",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_buyer_email', true ); ?>
		</label>
		<br><br>
	</div>
	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Phone",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_buyer_phone', true ) ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Address",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_buyer_address', true ) ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Company",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_buyer_company', true ) ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Description",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_buyer_desc', true ) ?>
		</label>
		<br><br>
	</div>




	<h3><?php esc_html_e( "Event", 'ovaem-events-manager' ); ?></h3>
	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Event",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_event_name', true ) ?>
		</label>
		<br><br>
	</div>
	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Package",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_event_package', true ) ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Package ID",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_package_id', true ) ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Start Time",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_event_start_time', true ) ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "End Time",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_event_end_time', true ) ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Venue",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_event_venue', true ) ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Address",  "ovaem-events-manager" ); ?>:</strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_event_address', true ) ?>
		</label>
		<br><br>
	</div>


	<h3><?php esc_html_e( "Action", 'ovaem-events-manager' ); ?></h3>
	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Resend Ticket",  "ovaem-events-manager" ); ?>:</strong>

			<div id="resend_ticket" style="display: inline-block;">
				
				<input type="email" style="height: 30px; width: 150px;" value="<?php echo get_post_meta( $post->ID, 'ovaem_ticket_buyer_email', true ); ?>" name="buyer_email" class="buyer_email">
			
				<input type="hidden" name="ticket_id" value="<?php echo get_the_id(); ?>" class="ticket_id" />
				
				<input type="hidden" name="name_event" value="<?php echo get_post_meta( $post->ID, 'ovaem_ticket_event_name', true ) ?>" class="name_event" />

				<input type="hidden" name="verify_ticket" value="<?php echo get_post_meta( $post->ID, 'ovaem_ticket_verify', true ) ?>" class="verify_ticket" />

				<a href="#" class="button button-primary button-large resend_ticket">
					<?php esc_html_e( 'Resend', 'ovaem-events-manager' ); ?>
				</a>
				<span class="alert_result"></span>

			</div>

		</label>
		
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( 'Status: ', 'ovaem-events-manager' ); ?></strong>

			<select name="ovaem_ticket_status">
				<option value="not_checked_in" <?php selected( 'not_checked_in', get_post_meta( $post->ID, 'ovaem_ticket_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Not Checked In', 'ovaem-events-manager' ); ?></option>

				<option value="checked_in" <?php selected( 'checked_in', get_post_meta( $post->ID, 'ovaem_ticket_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Checked In', 'ovaem-events-manager' ); ?></option>

			</select>
		</label><br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( 'Verify Ticket: ', 'ovaem-events-manager' ); ?></strong>

			<select name="ovaem_ticket_verify">

				<option value="true" <?php selected( 'true', get_post_meta( $post->ID, 'ovaem_ticket_verify', true ), 'selected' ); ?> ><?php esc_html_e( 'Yes', 'ovaem-events-manager' ); ?></option>

				<option value="false" <?php selected( 'false', get_post_meta( $post->ID, 'ovaem_ticket_verify', true ), 'selected' ); ?> ><?php esc_html_e( 'No', 'ovaem-events-manager' ); ?></option>

			</select>

		</label><br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Ticket exported from Order ID: ",  "ovaem-events-manager" ); ?></strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_ticket_from_order_id', true ); ?>
		</label>
		<br><br>
	</div>


	<?php if( get_post_meta( $post->ID, 'ovaem_ticket_from_woo_order_id', true ) ){ ?>
		<div class="ovaem_row">
			<label>
				<strong><?php esc_html_e( "Woo Order Ticket if have: ",  "ovaem-events-manager" ); ?>:</strong>
				<a href="<?php echo esc_url( home_url( '/' ) ).'wp-admin/post.php?post='.get_post_meta( $post->ID, 'ovaem_ticket_from_woo_order_id', true ).'&action=edit' ?>" target="_blank"><?php echo get_post_meta( $post->ID, 'ovaem_ticket_from_woo_order_id', true ); ?></a>
				
			</label>
			<br><br>
		</div>
	<?php } ?>
	


</div>

<?php wp_nonce_field( 'ova_events_nonce', 'ova_events_nonce' ); ?>
	
	

		
			
		