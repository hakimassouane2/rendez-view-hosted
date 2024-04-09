<?php if ( !defined( 'ABSPATH' ) ) exit();

	global $post;
	$ovame_ticket_type = get_post_meta( $post->ID, 'ovame_ticket_type', true );
	
?>
<div class="ovame_order_detail">
	<div class="ovaem_row">
		<label>

			<div class="ovaem_row">
				<label>
					<strong><?php esc_html_e( "Order ID",  "ovaem-events-manager" ); ?>: </strong>
					#<?php echo get_post_meta( $post->ID, 'ovaem_order_id', true ) ?>
				</label>
				<br><br>
			</div>

			<strong><?php esc_html_e( "Status", "ovaem-events-manager" ); ?>: </strong>
			<select name="ovaem_event_status">
				
				<option value="Pending" <?php selected( 'Pending', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Pending', 'ovaem-events-manager' ); ?></option>

				<option value="Completed" <?php selected( 'Completed', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Completed', 'ovaem-events-manager' ); ?></option>

				<option value="Canceled_Reversal" <?php selected( 'Canceled_Reversal', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Canceled Reversal', 'ovaem-events-manager' ); ?></option>
				
				<option value="Denied" <?php selected( 'Denied', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Denied', 'ovaem-events-manager' ); ?></option>

				<option value="Expired" <?php selected( 'Expired', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Expired', 'ovaem-events-manager' ); ?></option>

				<option value="Failed" <?php selected( 'Failed', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Failed', 'ovaem-events-manager' ); ?></option>
				

				<option value="Refunded" <?php selected( 'Refunded', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Refunded', 'ovaem-events-manager' ); ?></option>

				<option value="Reversed" <?php selected( 'Reversed', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Reversed', 'ovaem-events-manager' ); ?></option>

				<option value="Processed" <?php selected( 'Processed', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Processed', 'ovaem-events-manager' ); ?></option>

				<option value="Voided" <?php selected( 'Voided', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Voided', 'ovaem-events-manager' ); ?></option>

				<option value="wc-pending" <?php selected( 'wc-pending', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Pending', 'ovaem-events-manager' ); ?></option>

				<option value="wc-processing" <?php selected( 'wc-processing', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Woo Processing', 'ovaem-events-manager' ); ?></option>

				<option value="wc-on-hold" <?php selected( 'wc-on-hold', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Woo On Hold', 'ovaem-events-manager' ); ?></option>

				<option value="wc-completed" <?php selected( 'wc-completed', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Woo Completed', 'ovaem-events-manager' ); ?></option>

				<option value="wc-cancelled" <?php selected( 'wc-cancelled', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Woo Cancelled', 'ovaem-events-manager' ); ?></option>

				<option value="wc-refunded" <?php selected( 'wc-refunded', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Woo Refunded', 'ovaem-events-manager' ); ?></option>

				<option value="wc-failed" <?php selected( 'wc-failed', get_post_meta( $post->ID, 'ovaem_event_status', true ), 'selected' ); ?> ><?php esc_html_e( 'Woo Failed', 'ovaem-events-manager' ); ?></option>


			</select>
		</label>
		<br><br>
	</div>

	<?php if( $ovame_ticket_type == 'Free' ){ ?>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Event Name", "ovaem-events-manager" ); ?>: </strong>
			<?php $free_event_info = get_post( get_post_meta( $post->ID, 'ovaem_free_event_id', true ) );
			echo $free_event_info->post_title; ?>
		</label>
		
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Ticket Number", "ovaem-events-manager" ); ?>: </strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_number', true ); ?>
		</label>
		
		<br><br>
	</div>

	
	<?php } ?>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Ticket Type",  "ovaem-events-manager" ); ?>: </strong>
			<?php echo get_post_meta( $post->ID, 'ovame_ticket_type', true ) ?>
		</label>
		<br><br>
	</div>

	<?php if( get_post_meta( $post->ID, 'ovaem_payment_gateway', true ) ){ ?>
		<div class="ovaem_row">
			<label>
				<strong><?php esc_html_e( "Payment Gateway",  "ovaem-events-manager" ); ?>:</strong>
				<?php echo get_post_meta( $post->ID, 'ovaem_payment_gateway', true ) ?>
			</label>
			<br><br>
		</div>
	<?php } ?>

	
	<?php if( get_post_meta( $post->ID, 'ovaem_transaction_id', true ) ){ ?>
		<div class="ovaem_row">
			<label>
				<strong><?php esc_html_e( "Transaction ID",  "ovaem-events-manager" ); ?>: </strong>
				<?php echo get_post_meta( $post->ID, 'ovaem_transaction_id', true ) ?>
			</label>
			<br><br>
		</div>
	<?php } ?>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Name",  "ovaem-events-manager" ); ?>: </strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_name', true ); ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Email", "ovaem-events-manager" ); ?>: </strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_email', true ); ?>
		</label>
		<br><br>
	</div>



	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Phone", "ovaem-events-manager" ); ?>: </strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_phone', true ); ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Address", "ovaem-events-manager" ); ?>: </strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_address', true ); ?>
		</label>
		
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Company", "ovaem-events-manager" ); ?>: </strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_company', true ); ?>
		</label>
		<br><br>
	</div>

	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Additional Info", "ovaem-events-manager" ); ?>: </strong>
			<?php echo get_post_meta( $post->ID, 'ovaem_desc', true ); ?>
		</label>
		<br><br>
	</div>

	<?php if( get_post_meta( $post->ID, 'ovaem_order_coupon', true ) ){ ?>
	<div class="ovaem_row">
		<label>
			<strong><?php esc_html_e( "Coupon",  "ovaem-events-manager" ); ?>: </strong>
			<?php echo $coupon = get_post_meta( $post->ID, 'ovaem_order_coupon', true ) ?>
		</label>
		<br><br>
	</div>
	<?php } ?>
	<?php do_action( 'ovaem_metabox_order_detail_end', $post->ID ); ?>

	<?php if( $ovaem_order_cart = get_post_meta( $post->ID, 'ovaem_order_cart', true ) ){ ?>
		<?php if( is_array($ovaem_order_cart) ){ ?>
				<div class="ovaem_row">
					<label>
						<strong><?php esc_html_e( "Cart",  "ovaem-events-manager" ); ?>: </strong>
						
					</label>
					<table class="checkout_order">
						<thead>
							<tr>
								<th class="event-name"><?php esc_html_e( 'Event', 'ovaem-events-manager' ); ?></th>
								<th class="event-total"><?php esc_html_e( 'Total', 'ovaem-events-manager' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $total = 0;
								foreach ( $ovaem_order_cart as $id => $quantity ){
									$parse_id = explode('_', $id);
									$event = get_post( intval( $parse_id[0] ) );
									$price = floatval( $parse_id[1] );
									$cur = $parse_id[2];
									$package = urldecode($parse_id[3]);
							?>
								<tr class="cart_item">
									<td class="event-name">
										<?php echo esc_html( $event->post_title ); ?> - <?php echo $package; ?>
										<strong class="event-quantity">× <?php echo esc_attr($quantity); ?></strong>
									</td>
									<td class="event-total">
										<?php echo ovaem_format_price($price * $quantity, $cur); ?> <?php $total += $price * $quantity; ?>
									</td>
								</tr>
							<?php } ?>	
								
						</tbody>

						<tfoot>

							<tr class="cart-subtotal">
								<th><?php esc_html_e('Subtotal', 'ovaem-events-manager' ); ?></th>
								<td><strong><?php echo ovaem_format_price( $total, $cur ); ?></strong></td>
							</tr>
							
							<tr class="order-total">
								<th><?php esc_html_e('Total', 'ovaem-events-manager' ); ?></th>
								<td><strong><?php 
									$coupon_arr = isset( $coupon ) ? OVAEM_Coupon::ovaem_check_coupon( $coupon, false ): array(); 

									$total = OVAEM_Coupon::ovaem_total_with_coupon( $coupon_arr, $total, $cur );
									

								?><?php echo wp_kses($total['html'],true); ?></strong> </td>
							</tr>
						</tfoot>

					</table>
					<br><br>
				</div>
			<?php }else{ // Order Woocommerce ?>
				<div class="ovaem_row">
					<label>
						<strong><?php esc_html_e( "Order Detail in Woocommerce",  "ovaem-events-manager" ); ?>: </strong>
					</label>
					<a target="_blank" href="<?php echo esc_url( $ovaem_order_cart ); ?>"><?php esc_html_e( 'View Detail Order in Woocommerce', 'ovaem-events-manager' ); ?></a>
					
				</div>
			<?php } ?>
	<?php } ?>
	

	

</div>

<?php wp_nonce_field( 'ova_events_nonce', 'ova_events_nonce' ); ?>
	
	

		
			
		