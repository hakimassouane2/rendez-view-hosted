<?php if ( !defined( 'ABSPATH' ) ) exit();
@session_start();
session_write_close();

$session_coupon = isset( $_SESSION['coupon'] ) ? $_SESSION['coupon'] : '';

if ( isset( $_SESSION['cart'] ) && count( $_SESSION['cart'] ) > 0 ) { ?>

	<div class="ova_cart">
		<form action="" method="post">

			<div class="col-md-8">
				<table id="cart" class="event_table">

					<thead>
						<tr>
							
							<th class="product-name"><?php _e( 'Event Name', 'ovaem-events-manager' ); ?></th>
							<th class="product-price"><?php _e( 'Price', 'ovaem-events-manager' ); ?></th>
							<th class="product-quantity"><?php _e( 'Quantity', 'ovaem-events-manager' ); ?></th>
							<th class="product-subtotal"><?php _e( 'Total', 'ovaem-events-manager' ); ?></th>
							<th class="product-remove"><?php esc_html_e( 'Remove', 'ovaem-events-manager' ); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php
						$total = 0;
						$ticket_free_max_number = OVAEM_Settings::ticket_free_max_number();

						foreach ( $_SESSION['cart'] as $id => $quantity ){ // Loop cart section array to get id and info of event
							$parse_id = explode('_', $id);

							$event = get_post((int)$parse_id[0] );
							$price = floatval( $parse_id[1] );
							$cur = $parse_id[2];
							$package = urldecode($parse_id[3]);

							?>
							<tr>


								<td data-title="<?php esc_attr_e( 'Event Name', 'ovaem-events-manager' ); ?>" >
									<a href="<?php echo esc_url( home_url('/?page_id='.$event->ID) ); ?> "><?php echo esc_html( $event->post_title ); ?> <!-- - <?php echo $package; ?> --> </a>
								</td>

								<td  data-title="<?php esc_attr_e( 'Price', 'ovaem-events-manager' ); ?>">
									<div class="price"><?php echo ovaem_format_price($price,$cur); ?></div>
								</td>

								<td data-title="<?php esc_attr_e( 'Quantity', 'ovaem-events-manager' ); ?>">
									<input class="qty" min="1" max="<?php echo esc_attr($ticket_free_max_number); ?>" autocomplete="off" type="number" value="<?php echo esc_attr($quantity); ?>" name="quantity[<?php echo $id; ?>]" size="4" />
								</td>

								<td data-title="<?php esc_attr_e( 'Total', 'ovaem-events-manager' ); ?>" >
									<div class="total">
										<?php echo ovaem_format_price($price * $quantity, $cur); ?> 
										<?php $total += $price * $quantity; ?></div> </td>


								<td class="mobile_remove">
									<a class="remove" href="<?php echo esc_url( get_home_url('/') ).'?action=delete&id='.$id.'&post_type='.OVAEM_Settings::event_post_type_slug(); ?>">
										
										<i class="icon_close"></i>
									</a>
								</td>			
							</tr>
									
								<?php } ?>
								<tr>
									<td colspan="6" class="mobile_cart">
										<div class="update_cart">
											<input type="submit" class="ova-btn ova-btn-medium ova-btn-rad-4 ova-btn-main-color " name="cart_update" value="<?php esc_html_e( "Update Cart", 'ovaem-events-manager' ); ?>" title="<?php esc_html_e( "Update Cart", 'ovaem-events-manager' ); ?>"/>
										</div>
									</td>
								</tr>
							</tbody>

							
						</table>
					</div>

					<?php 
					$coupon_arr = OVAEM_Coupon::ovaem_check_coupon( $session_coupon, true );
					
					?>
					<div class="col-md-4">
						<div class="cart-collaterals">

							<div class="coupon">

								<label for="coupon_code"><?php _e( 'Discount code', 'ovaem-events-manager' ); ?>
								<span class="one"></span><span class="two"></span><span class="three"></span><span class="four"></span><span class="five"></span>
								
							</label>

							<input type="text" name="coupon_code" class="coupon_code" value="<?php echo $session_coupon;  ?>" placeholder="<?php esc_html_e( 'Coupon Code', 'ovaem-events-manager' ); ?>" />

							<input type="submit" name="coupon_apply" class="coupon_btn ova-btn ova-btn-medium ova-btn-rad-4 ova-btn-second-color" value="<?php esc_html_e('Apply coupon','ovaem-events-manager'); ?>" />

							<!-- <span class="msg_coupon"><?php echo $session_coupon ? $coupon_arr['msg'] : ''; ?></span> -->
							
						</div>

						<div class="cart_total">
							<label for="coupon_code"><?php _e( 'Cart Total', 'ovaem-events-manager' ); ?>
							<span class="one"></span><span class="two"></span><span class="three"></span><span class="four"></span><span class="five"></span>
							
						</label>
						<table>
							<tbody><tr class="cart-subtotal">
								<th><?php esc_html_e( 'Subtotal', 'ovaem-events-manager' ); ?></th>
								<td data-title="Subtotal"><?php echo ovaem_format_price($total, $cur); ?></td>
							</tr>

							<tr class="order-total">
								<th><?php esc_html_e( 'Total', 'ovaem-events-manager' ); ?></th>
								<td><strong>
									
									<?php 
										// Total with coupon
									$total = OVAEM_Coupon::ovaem_total_with_coupon( $coupon_arr, $total, $cur );
									if( $total ){
										echo wp_kses($total['html'],true);	
									}
									?>
								</strong></td>
							</tr>
						</tbody></table>
					</div>

					

					<?php $checkout_page = OVAEM_Settings::checkout_page(); ?>
					
					<a href="<?php echo esc_url($checkout_page); ?>" class="event-checkout ova-btn ova-btn-large ova-btn-rad-4 ova-btn-main-color"><?php esc_html_e( "Check Out", 'ovaem-events-manager' ); ?></a>
				</div>
				
			</div>
			
			<input type="hidden" name="post_type" value="<?php echo OVAEM_Settings::event_post_type_slug(); ?>">
			<input type="hidden" name="action" value="update">

		</form>
	</div>

<?php } else { ?>
	<div class="container">
		<?php esc_html_e( "Cart is empty. ", 'ovaem-events-manager' ); ?>
		<a href="<?php echo home_url('/'); ?>"><?php esc_html_e( 'Go to home page', 'ovaem-events-manager' ); ?></a>
		<br/><br/>
	</div>
<?php }









