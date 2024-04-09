<?php if ( !defined( 'ABSPATH' ) ) exit();
$prefix = OVAEM_Settings::$prefix;

$tickets = get_post_meta( get_the_id(), $prefix.'_ticket', true );
$post_type = OVAEM_Settings::event_post_type_slug();

$currency_position = OVAEM_Settings::currency_position();

$date_format = get_option('date_format');
$time_format = get_option('time_format');



$start_time = get_post_meta( get_the_id(), $prefix.'_date_start_time', true);
$end_time = get_post_meta( get_the_id(), $prefix.'_date_end_time', true);

$current_time = current_time( 'timestamp' );

$html = '';

	// Free ticket
	if( ( is_array($tickets) && count($tickets) == 1 && $tickets[0]['pay_method'] == 'free' ) ){
		
		$package_id = $tickets[0]['package_id'] ? $tickets[0]['package_id'] : '';

		$sell_from = strtotime( $tickets[0]['sell_date_start'] ) ;
		$sell_to = strtotime( $tickets[0]['sell_date_end'] );

		if( ( $sell_from < $current_time &&  $current_time < $sell_to  && $tickets[0]['avaiable_date_selling'] != 'open_ended' ) || ($tickets[0]['avaiable_date_selling'] == 'open_ended' ) ){

			echo '<div class="register_form_free_ticket">';
			echo do_shortcode('[ovaem_register_event_free event_id="'.get_the_id().'" package_id="'.$package_id.'" show_name="true" show_phone="true" show_ticket="true" show_address="true" show_company="true" show_desc="true"  /]');
			echo '</div>';
		}else{
			esc_html_e( 'The Ticket sale has expired', 'ovaem-events-manager' );
		}

	}else if( $tickets != '' ) {
	
		foreach ($tickets as $key => $value) {

			$list_featured = str_replace( '}}', '</li>', str_replace( '{{', '<li><i class="arrow_right"></i>', $value['ticket_desc'] ) );

			$ticket_cur = ($value['pay_method'] != 'free') ? esc_html( $value['ticket_cur'] ) : '';
			$ticket_price = ( $value['pay_method'] == 'free' ) ? esc_html( 'Free', 'ovaem-events-manager' ) : esc_html( $value['ticket_price'] );
			$ticket_feature = $value['ticket_feature'];

			

			$sell_from = strtotime( $value['sell_date_start'] ) ;
			$sell_to = strtotime( $value['sell_date_end'] );
			
			

			// Renaming Ticket
			$package_id = isset( $value['package_id'] )? $value['package_id'] : '';
			$event_id =  get_the_id();
			$remaining_ticket =  OVAEM_Ticket::remaining_ticket( $event_id, $package_id );

			// Stock Product
			$qty_product = 0;
			

			if( ( $sell_from < $current_time &&  $current_time < $sell_to  && $value['avaiable_date_selling'] != 'open_ended' ) || ( $value['avaiable_date_selling'] == 'open_ended' ) ){
		?>
			
				<div class="ovame_tickets col-md-4">
					<div class="wrap_tickets <?php echo esc_attr( $ticket_feature ); ?>">

						<h3 class="ovaem_ticket_name"><?php echo esc_html( $value['ticket_name'] ); ?></h3>

						<div class="wrap_content">

							<div class="top">
								<div class="icon"></div>

								<?php if( $currency_position == 'left' ){ ?>

									<div class="price">
										<?php echo $ticket_cur; ?><?php echo $ticket_price; ?>
									</div>

								<?php }else if( $currency_position == 'right' ){ ?>

									<div class="price">
										<?php echo $ticket_price; ?><?php echo $ticket_cur; ?>
									</div>

								<?php }else if( $currency_position == 'left_space' ){ ?>

									<div class="price">
										<?php echo $ticket_cur; ?>&nbsp;<?php echo $ticket_price; ?>
									</div>

								<?php }else if( $currency_position == 'right_space' ){ ?>

									<div class="price">
										<?php echo $ticket_price; ?>&nbsp;<?php echo $ticket_cur; ?>
										
									</div>

								<?php } ?>
								
								<!-- number ticket	 -->
								<div class="number_ticket">
									<?php if( $value['pay_method'] == 'paid_woo' && class_exists('woocommerce') ){
										global $woocommerce;
										$product_id = $value['ticket_woo_id'];
										if( $value['ticket_woo_id'] != '' ){
											$product = wc_get_product( $product_id );
											$qty_product = $product->get_stock_quantity();
											echo $product->get_stock_quantity().'&nbsp;'; esc_html_e( 'Tickets', 'ovaem-events-manager' ) ;
										}

									}else{ ?>
										<?php echo $remaining_ticket; ?>&nbsp;<?php esc_html_e( 'Tickets', 'ovaem-events-manager' ) ;?>
									<?php } ?>
								</div>

							</div>
							

							<div class="ova_featured"><ul style="list-style:none; padding:0;"><?php echo wp_kses( $list_featured, true ); ?> </ul></div>

							<?php if( 
								( $sell_from < $current_time &&  $current_time < $sell_to  && $value['avaiable_date_selling'] != 'open_ended' ) 
								|| ( $value['avaiable_date_selling'] == 'open_ended' &&  ( $current_time < ( $start_time ) || ( ($start_time) < $current_time && $current_time < ( $end_time )  ) ) )  ){ ?>

									<?php if( $value['pay_method'] == 'free'){ ?>
										<div class="ovaem_register">

											<?php if( $start_time!= '' && $end_time!= '' ){ ?>
												<?php if( $end_time <= current_time( 'timestamp' ) ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'The event is expired', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Register Event', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else if( $remaining_ticket == 0 ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else{ ?>	
													<a class="ova-btn" href="<?php echo esc_url( home_url('/') ).'?post_type='.$post_type.'&regis_free_event='.get_the_id().'&package_id='.$value['package_id'].' ' ?> "><?php esc_html_e( 'Register Event', 'ovaem-events-manager' ); ?></a>
												<?php } ?>
											<?php } ?>

											
										</div>
									<?php } else if( $value['pay_method'] == 'paid_woo' && class_exists('woocommerce')  ){ ?>

										<div class="ovaem_register">
											<?php global $woocommerce;
												  $cart_url = wc_get_cart_url();
												  $permalink_structure = get_option('permalink_structure');
												  if ( empty( $permalink_structure ) ){
												  	$cart_url = $cart_url.'&add-to-cart='.$value['ticket_woo_id'];
												  }else{
												  	$cart_url = $cart_url.'?add-to-cart='.$value['ticket_woo_id'];
												  }
											 ?>

											
											<?php if( $start_time!= '' && $end_time!= '' ){ ?>
												<?php if( $end_time <= current_time( 'timestamp' ) ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'The event is expired', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Register Event', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else if( $qty_product === 0 ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else{ ?>	

													<a class="ova-btn" href="<?php echo esc_url($cart_url); ?>"><?php esc_html_e( 'Register Event', 'ovaem-events-manager' ); ?></a>

													
												<?php } ?>
											<?php } ?>


											


										</div>

									<?php } else if( $value['pay_method'] == 'outside' ){ ?>

										<div class="ovaem_register">
											<?php if( $start_time!= '' && $end_time!= '' ){ ?>
												<?php if( $end_time <= current_time( 'timestamp' ) ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'The event is expired', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'External Link', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else if( $remaining_ticket == 0 ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else{ ?>	

													<a class="ova-btn" target="_blank" href="<?php echo esc_html( $value['outside'] ); ?>"><?php esc_html_e( 'External Link', 'ovaem-events-manager' ); ?></a>

													
												<?php } ?>
											<?php } ?>


											
										</div>

									<?php }else if( $value['pay_method'] == 'other_pay_gateway' ){  ?>
										<div class="ovaem_register">

											<?php if( $start_time!= '' && $end_time!= '' ){ ?>

												<?php if( $end_time <= current_time( 'timestamp' ) ){ ?>

													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'The event is expired', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Register Event', 'ovaem-events-manager' ); ?>
													</a>

												<?php }else if( $remaining_ticket == 0 ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else{ ?>	

													<a href="<?php echo home_url('/').'?post_type='.$post_type.'&action=ovaem_add_to_cart&id='.get_the_id().'_'.$ticket_price.'_'.$ticket_cur.'_'.urlencode($value['ticket_name']).'_'.urlencode( str_replace( "_", "ovaminus", $value['package_id'] ) ).'' ?>" class="ova-btn"><?php esc_html_e( 'Add To Cart' ,'ovaem-events-manager' ); ?></a>

													
												<?php } ?>

											<?php } ?>


											
										</div>
									<?php } else if( $value['pay_method'] == 'woo_modern' && class_exists('woocommerce')  ){ ?>

										<div class="ovaem_register">
											<?php global $woocommerce;
												  $cart_url 			= wc_get_cart_url();
												  $permalink_structure 	= get_option('permalink_structure');
												  $qty_event 			= $value['number_ticket'] ? $value['number_ticket'] : 0;
												  $ticket_id 			= $value['ticket_id'];

												  if ( empty( $permalink_structure ) ){
												  	$cart_url = $cart_url.'?add-to-cart='.$ticket_id;
												  }else{
												  	$cart_url = $cart_url.'?add-to-cart='.$ticket_id;
												  }
											 ?>

											
											<?php if( $start_time!= '' && $end_time!= '' ){ ?>
												<?php if( $end_time <= current_time( 'timestamp' ) ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'The event is expired', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Register Event', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else if( $qty_event === 0 ){ ?>
													<a class="ova-btn expired" href="#" title="<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>">
														<?php esc_html_e( 'Sold out', 'ovaem-events-manager' ); ?>
													</a>
												<?php }else{ ?>	

													<a class="ova-btn ova_add_to_cart"
													href="<?php echo esc_url($cart_url); ?>"><?php esc_html_e( 'Register Event', 'ovaem-events-manager' ); ?></a>

													
												<?php } ?>
											<?php } ?>

										</div>
									<?php } ?>

							<?php } ?>
							
						</div>

						

					</div>

				</div>
			
			

		<?php } }
 	}

 


