<?php if ( !defined( 'ABSPATH' ) ) exit();

$errors = isset( $_REQUEST['err'] ) ? sanitize_text_field( $_REQUEST['err'] ) : '';
$errors = explode(",", $errors);

	$login_before_booking = OVAEM_Settings::login_before_booking();
    if( $login_before_booking == 'yes' && !is_user_logged_in() ){
        
        $redirect_to = get_permalink();
        $login_url = add_query_arg( 'redirect_to', $redirect_to, wp_login_url() ); ?>
			<div class="ovaem_checkout_page ova_stripe_wrap">
				<div class="container">
					<p><?php esc_html_e( 'You have to login to checkout', 'ovaem-events-manager' ); ?>&nbsp;
						<a href="<?php echo esc_url($login_url); ?>"><?php esc_html_e( 'Go to Login Page', 'ovaem-events-manager' ); ?></a>
					</p>
				</div>
			</div>	
    <?php exit(); }


	$post_type = OVAEM_Settings::event_post_type_slug();
?>

<?php if ( isset( $_SESSION['cart'] ) && count( $_SESSION['cart'] ) > 0 ) { ?>

	<?php 

	wp_enqueue_script('stripe_lib', 'https://js.stripe.com/v3/', array('jquery'), null, false );
 	// Add Public Key
	$array_pub_key = array( "pub_key" => trim( OVAEM_Settings::stripe_payment_public_key() ) );
	wp_localize_script( 'ovaem_script', 'stripe_pub_key', $array_pub_key );

	$array_notice = array();
	foreach ( $_SESSION['cart'] as $id => $quantity ){
		$event = get_post((int)$id );
		$parse_id = explode('_', $id);
		$event_id = (int)$parse_id[0];
		$package = urldecode($parse_id[3]);
		$package_id = str_replace( "ovaminus", "_", urldecode($parse_id[4]) );
		$remaining_ticket =  OVAEM_Ticket::remaining_ticket( $event_id, $package_id );
		if( $remaining_ticket < $quantity ){
			$array_notice[] = $event->post_title.' '.esc_html__('Renaming ticket: ', 'ovaem-events-manager').$remaining_ticket;
		}
	}
	if( !empty( $array_notice ) ){
		foreach ($array_notice as $key => $value) {
			echo $value.'<br/>';
		}
		echo '<a href="'.OVAEM_Settings::cart_page().'">'.esc_html__(' Update Cart ', 'ovaem-events-manager').'</a>';
		exit();
	}
	?>

	<div class="ovaem_checkout_page ova_stripe_wrap">
		<div class="container">
			
			<form id="ova_register_paid_event" method="post" action="<?php echo esc_url( home_url('/') ); ?> " accept-charset="UTF-8" enctype="multipart/form-data">
				<fieldset>		
					
					<div class="form-alert">
						<?php if ( $errors && is_array( $errors ) ): ?>
							<ul>
								<?php foreach ( $errors as $error ): ?>

									<?php if ( $error === 'recapcha' ): ?>
										<li><?php esc_html_e( 'CAPTCHA verification failed.','ovaem-events-manager' ); ?></li>
									<?php endif; ?>
									
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>

					<div class="checkout_your_info">
						
						<h3 class="ova_title"><?php esc_html_e( 'Your Information', 'ovaem-events-manager' ); ?><span class="one"></span><span class="two"></span><span class="three"></span><span class="four"></span><span class="five"></span></h3>		

						<input type="hidden" name="ovaem_event_id" class="ovaem_event_id form-control" value="<?php echo esc_attr($event_id); ?>" >


						<div class="col-md-6">
							<div class="row row_left">
								<div class="ova_field">
									<label><?php esc_html_e( "Name *", 'ovaem-events-manager' ); ?></label>
									<input type="text" name="ovaem_name" class="ovaem_name form-control" required >
								</div>

								<div class="ova_field">
									<label><?php esc_html_e( "Phone *", 'ovaem-events-manager' ); ?></label>
									<input type="tel" name="ovaem_phone" class="form-control" required />
								</div>

								<div class="ova_field">
									<label><?php esc_html_e( "Address *", 'ovaem-events-manager' ); ?></label>
									<input type="text" name="ovaem_address" class="form-control"required />
								</div>

								<div class="ova_field">
									<label><?php esc_html_e( "City *", 'ovaem-events-manager' ); ?></label>
									<input type="text" name="ovaem_city" class="form-control"required />
								</div>
								
								<?php do_action( 'ovaem_after_checkout_your_info' ); ?>
							</div>
						</div>

						<div class="col-md-6">
							<div class="row row_right">			
								<div class="ova_field">
									<label><?php esc_html_e( "Email *", 'ovaem-events-manager' ); ?></label>
									<input type="email" name="ovaem_email" class="form-control" required/>
								</div>

								<div class="ova_field">
									<label><?php esc_html_e( "Country/region *", 'ovaem-events-manager' ); ?></label>
									<input type="text" name="ovaem_country" class="form-control" required />
								</div>

								<div class="ova_field">
									<label><?php esc_html_e( "Apartment, suite, etc", 'ovaem-events-manager' ); ?></label>
									<input type="text" name="ovaem_apt" class="form-control" />
								</div>

								<div class="ova_field">
									<label><?php esc_html_e( "Postal code *", 'ovaem-events-manager' ); ?></label>
									<input type="text" name="ovaem_postal_code" class="form-control" required />
								</div>

								<!-- <div class="ova_field">
									<label><?php esc_html_e( "Company", 'ovaem-events-manager' ); ?></label>
									<input type="text" name="ovaem_company" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_company', '' ); ?> />
								</div> -->


								<!-- <div class="ova_field">
									<label><?php esc_html_e( "Additional Info", 'ovaem-events-manager' ); ?></label>
									<textarea name="ovaem_desc" class="form-control" cols="50" rows="9" <?php echo apply_filters( 'ovaem_reg_event_require_desc', '' ); ?> ></textarea>
								</div> -->

							</div>
						</div>
					</div>

					<!-- Cart -->
					<div class="checkout_cart">

						<h3 class="ova_title"><?php esc_html_e( 'Your Order', 'ovaem-events-manager' ); ?><span class="one"></span><span class="two"></span><span class="three"></span><span class="four"></span><span class="five"></span></h3>

						<table class="checkout_order">
							<thead>
								<tr>
									<th class="event-name"><?php esc_html_e( 'Event', 'ovaem-events-manager' ); ?></th>
									<th class="event-total"><?php esc_html_e( 'Total', 'ovaem-events-manager' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $total = 0;
								foreach ( $_SESSION['cart'] as $id => $quantity ){
									$event = get_post((int)$id );
									$parse_id = explode('_', $id);
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
									<td><?php echo ovaem_format_price( $total, $cur ); ?></td>
								</tr>

								<tr class="order-total">
									<th><?php esc_html_e('Total', 'ovaem-events-manager' ); ?></th>
									<td><strong><?php 
									$coupon_arr = isset( $_SESSION['coupon'] ) ? OVAEM_Coupon::ovaem_check_coupon( $_SESSION['coupon'], true ): array(); 

									$total = OVAEM_Coupon::ovaem_total_with_coupon( $coupon_arr, $total, $cur );


									?><?php echo wp_kses($total['html'],true); ?></strong> </td>
								</tr>
							</tfoot>

						</table>
					</div>

					<!-- method payment -->
					<div class="method_payment">

						<h3 class="ova_title"><?php esc_html_e( 'Payment Gateway', 'ovaem-events-manager' ); ?><span class="one"></span><span class="two"></span><span class="three"></span><span class="four"></span><span class="five"></span></h3>

						<?php echo apply_filters('ova_list_payment_gateway', 10); ?>
					</div>


					<!-- terms and conditions -->
					<?php if (OVAEM_Settings::terms_conditions_page() != '') { ?>
						<div class="terms_conditions">

							<input type="checkbox" class="input-checkbox" name="ovaem_terms" id="terms" required>
							<span class="terms-and-conditions-checkbox-text">
								<?php esc_html_e( 'I have read and agree to the website', 'ovaem-events-manager' ); ?>
								<a href="<?php echo esc_attr(OVAEM_Settings::terms_conditions_page()); ?>" class="terms-and-conditions-link" target="_blank"><?php esc_html_e( 'terms and conditions', 'ovaem-events-manager' ); ?></a>
							</span>
						</div>
					<?php } ?>

					<?php echo apply_filters( 'em4u_recapcha_event_checkout', '' ); ?>
					<button type="submit" class="submit-checkout-form ova-btn ova-btn-main-color" data-idform="ova_register_paid_event">
						<?php esc_html_e( "Register Event", 'ovaem-events-manager' ); ?>
					</button>


					<input type="hidden" name="post_type" value="<?php  echo esc_attr($post_type); ?>" />
					<input type="hidden" name="checkout_event" value="yes" />


					<input type="hidden" name="id" value="" />

					<?php
					$ajax_nonce = wp_create_nonce( 'ajax_checkout_security' );
					?>

					<input type="hidden" name="ajax_nonce" value="<?php echo esc_attr( $ajax_nonce ); ?>" />

					<?php wp_nonce_field( 'ova_checkout_events_nonce', 'ova_checkout_events_nonce' ); ?>

				</fieldset>
			</form>
			
		</div>
	</div>

<?php }else{ ?>
	<div class="container">
		<?php esc_html_e( "Checkout is empty. ", 'ovaem-events-manager' ); ?>
		<a href="<?php echo home_url('/'); ?>"><?php esc_html_e( 'Go to home page', 'ovaem-events-manager' ); ?></a>
		<br/><br/>
	</div>
<?php } ?>


	