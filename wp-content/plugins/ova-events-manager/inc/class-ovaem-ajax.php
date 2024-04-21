<?php 

defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEM_Frontend_Ajax' ) ){

	class OVAEM_Frontend_Ajax{
		
		public function __construct(){
			$this->init();
		}

		public function init(){

			// Define All Ajax function
			$arr_ajax =  array(
				'events_filter_category',
				'download_ticket',
				'unlink_download_ticket',
				'pagination_manage_booking',
				'ovaem_recapcha_verify_ajax',
			);

			foreach($arr_ajax as $val){
				add_action( 'wp_ajax_'.$val, array( $this, $val ) );
				add_action( 'wp_ajax_nopriv_'.$val, array( $this, $val ) );
			}
		}

		/* Resend PDF Ticket */
		public static function events_filter_category(){
			if( !isset( $_POST['data'] ) ) wp_die();

			$category = $_POST['data']['category'];
			$data_event = $_POST['data']['data_event'];

			extract($data_event);

			$prefix = OVAEM_Settings::$prefix;
			$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
			$date_format = get_option('date_format');

			$day_format = OVAEM_Settings::ovaem_day_format();
			$month_format = OVAEM_Settings::ovaem_month_format();
			$year_format = OVAEM_Settings::ovaem_year_format();


			
			$eventlist = apply_filters( 'ovaem_events_orderby', $filter, $count, $category, $orderby, $order, $show_past  );
			$l = $m = 0;

			if( $eventlist->have_posts() ): while( $eventlist->have_posts() ):  $eventlist->the_post();

				$id = get_the_id();

				$terms  = get_the_terms( $id , $slug_taxonomy_name);
				if ( $terms && ! is_wp_error( $terms ) ) {
					$cat_slug = '';
					foreach ( $terms as $term ) {
						$cat_slug.= ' '.$term->slug ;
					}
				}

				$end_time = get_post_meta( $id, $prefix.'_date_end_time', true );
				$start_time = get_post_meta( $id, $prefix.'_date_start_time', true );
				$time_m = $start_time ? date_i18n( $month_format, $start_time )  : '';
				$time_d = $start_time ? date_i18n( $day_format.'-'.$year_format, $start_time )  : '';

				$date_by_format = $start_time ? date_i18n( $date_format , $start_time )  : '';

				$address = '';
				if( $address_type == 'venue' ){
					$venue_slug = get_post_meta( $id, $prefix.'_venue', true );
					if( $venue_slug ){
						$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );	
						if($venue){
							$address = $venue->post_title;
						}
					}

				}else if( $address_type == 'address' ){
					$address = get_post_meta( $id, $prefix.'_address_event', true );
				}else if( $address_type == 'room' ){
					$address = 	get_post_meta( $id, $prefix.'_address', true );
				}

				$tickets_arr = get_post_meta( $id, $prefix.'_ticket', true );
				$price = apply_filters( 'ovaem_get_price', $tickets_arr );


				$d_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
				$m_img  = wp_get_attachment_image_url( get_post_thumbnail_id(), 'm_img' );

				$check_status_event = apply_filters( 'ovaem_check_status_event', $start_time, $end_time );

				$check_pass_time = (int)current_time( 'timestamp' ) < (int)$end_time ? true : false;

	    		if ( $show_get_ticket_expired == 'true' ) {
	    			$check_pass_time = true;
	    		}


				if( $style == 'style1' ){ ?>

					<div class="col-md-4 col-sm-6 col-xs-6 ova-item <?php echo esc_attr( $style .' '. $cat_slug ); ?>">
						<?php if( count( $array_slug ) > 1 ) { ?>
							<p class="number" style="display:none;"><?php echo esc_html( strtotime($date_by_format) ); ?></p>
						<?php } ?>

						<a href="<?php the_permalink(); ?>">
							<div class="ova_thumbnail">

								<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_attr($d_img); ?>" srcset=" <?php echo esc_attr($d_img); ?> 370w, <?php echo esc_attr($d_img); ?> 640w" sizes="(max-width: 640px) 100vw, 370px" />
								<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
									<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
								<?php	} ?>

								<?php if ( $show_time == 'true' || $show_price == 'true' ) { ?>
									<div class="time">
										<?php if ( $show_time == 'true' ) { ?>
											<span class="month"><?php echo $time_m; ?></span><span class="date"><?php echo $time_d; ?></span>
										<?php	} ?>

										<?php if ( $show_price == 'true' ) { ?>
											<span class="price"><?php echo $price; ?></span>
										<?php	} ?>
									</div>
								<?php } ?>

							</div>
						</a>

						<div class="wrap_content">
							<?php if ( $show_name == 'true' ) { ?>
								<h2 class="title"><a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?></a></h2>
							<?php } ?>

							<?php if( $show_status == 'true' ){ ?>
								<div class="status"><?php echo $check_status_event; ?></div>
							<?php } ?>

							<?php if( $show_desc == 'true' ){ ?>
								<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
							<?php } ?>

							<?php if( $check_pass_time === true && $show_get_ticket == 'true' ){ ?>
								<div class="more_detail"><a class="btn_link ova-btn ova-btn-rad-30" href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo esc_html($get_ticket); ?></a></div>
							<?php } ?>

						</div>

					</div>


				<?php } else if( $style == 'style2' ) { ?>

					<div class="col-md-4 col-sm-6 col-xs-6 ova-item <?php echo esc_attr( $style .' '. $cat_slug ); ?>">
						<?php if( count( $array_slug ) > 1 ){ ?>
							<p class="number" style="display:none;"><?php echo esc_html( strtotime($date_by_format) ); ?></p>
						<?php } ?>

						<a href="<?php the_permalink(); ?>">
							<div class="ova_thumbnail">

								<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_attr($d_img); ?>" srcset=" <?php echo esc_attr($d_img); ?> 370w, <?php echo esc_attr($d_img); ?> 640w" sizes="(max-width: 640px) 100vw, 370px" />

								<?php if ( $show_time == 'true' ) { ?>
									<div class="time"><span class="month"><?php echo $time_m; ?></span><span class="date"><?php echo $time_d; ?></span></div>
								<?php	} ?>
							</div>
						</a>

						<div class="wrap_content">
							<?php if ( $show_name == 'true' ) { ?>
								<h2 class="title"><a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?></a></h2>
							<?php } ?>

							<?php if( $show_desc == 'true' ){ ?>
								<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
							<?php } ?>

							<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
								<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
							<?php	} ?>

							<?php if ( $check_pass_time === true ): ?>
								
								<div class="bottom">

									<?php if( $show_get_ticket == 'true' ){ ?>
										<div class="more_detail"><a class="btn_link" href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php esc_html_e($get_ticket, 'ovaem-events-manager'); ?></a></div>
									<?php } ?>

									<?php if( $show_status == 'true' ){ ?>
										<div class="status"><?php echo $check_status_event; ?></div>
									<?php } ?>

									<?php if ( $show_price == 'true' ) { ?>
										<span class="price"><?php echo $price; ?></span>
									<?php	} ?>

								</div>

							<?php endif; ?>

						</div>

					</div>


				<?php	}else if( $style == 'style3' ){ ?>

					<div class="col-md-4 col-sm-6 col-xs-6 ova-item <?php echo esc_attr( $style .' '. $cat_slug ); ?>">

						<?php if( count( $array_slug ) > 1 ){ ?>
							<p class="number" style="display:none;"><?php echo esc_html( strtotime($date_by_format) ); ?></p>
						<?php } ?>

						<a href="<?php the_permalink(); ?>">
							<div class="ova_thumbnail">

								<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_attr($d_img); ?>" srcset=" <?php echo esc_attr($d_img); ?> 370w, <?php echo esc_attr($d_img); ?> 640w" sizes="(max-width: 640px) 100vw, 370px" />

								<?php if ( $show_time == 'true' && $date_by_format ) { ?>
									<div class="date"><span class="month"><?php echo esc_html($date_by_format); ?></span></div>
								<?php } ?>

								<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
									<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
								<?php	} ?>

								<?php if ( $show_price == 'true' && $price ) { ?>
									<div class="time">
										<span class="price"><?php echo $price; ?></span>
									</div>
								<?php	} ?>

							</div>
						</a>

						<div class="wrap_content">
							<?php if ( $show_name == 'true' ) { ?>
								<h2 class="title"><a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?></a></h2>
							<?php } ?>

							<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
								<div class="venue_mobile"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
							<?php	} ?>

							<?php if( $show_desc == 'true' ){ ?>
								<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
							<?php } ?>

							<?php if ( $check_pass_time === true ): ?>
								
								<?php if( $show_get_ticket == 'true' ){ ?>
									<div class="more_detail"><a class="btn_link" href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php esc_html_e($get_ticket, 'ovaem-events-manager'); ?><i class="arrow_right"></i></a></div>
								<?php } ?>

								<?php if( $show_status == 'true' ) { ?>
									<div class="status"><?php echo $check_status_event; ?></div>
								<?php } ?>

							<?php endif; ?>

						</div>

					</div>


				<?php } else if( $style == 'style4' ) { ?>

					<div class="col-md-4 col-sm-6 col-xs-6 ova-item  style3 <?php echo esc_attr( $style .' '. $cat_slug ); ?>">

						<?php if( count( $array_slug ) > 1 ) { ?>
							<p class="number" style="display:none;"><?php echo esc_html( strtotime($date_by_format) ); ?></p>
						<?php } ?>

						<a href="<?php the_permalink(); ?>">
							<div class="ova_thumbnail">

								<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_attr($d_img); ?>" srcset=" <?php echo esc_attr($d_img); ?> 370w, <?php echo esc_attr($d_img); ?> 640w" sizes="(max-width: 640px) 100vw, 370px" />

								<?php if ( $show_time == 'true' && $date_by_format ) { ?>
									<div class="date"><span class="month"><?php echo esc_html($date_by_format); ?></span></div>
								<?php } ?>

								<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
									<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
								<?php	} ?>

								<?php if ( $show_price == 'true' && $price ) { ?>
									<div class="time">
										<span class="price"><?php echo $price; ?></span>
									</div>
								<?php	} ?>

							</div>
						</a>

						<div class="wrap_content">
							<?php if ( $show_name == 'true' ) { ?>
								<h2 class="title"><a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?></a></h2>
							<?php } ?>

							<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
								<div class="venue_mobile"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
							<?php	} ?>

							<?php if( $show_desc == 'true' ){ ?>
								<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
							<?php } ?>

							<?php if ( $check_pass_time === true ): ?>

								<?php if( $show_get_ticket == 'true' ){ ?>
									<div class="more_detail"><a class="btn_link" href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php esc_html_e($get_ticket, 'ovaem-events-manager'); ?><i class="arrow_right"></i></a></div>
								<?php } ?>

								<?php if( $show_status == 'true' ) { ?>
									<div class="status"><?php echo $check_status_event; ?></div>
								<?php } ?>

							<?php endif; ?>

						</div>

					</div>

				<?php }

				$m++; $l++;
				if( $m == 2 ) { ?>
					<div class="mobile_row"></div>
					<?php
					$m = 0; 
				}

				if( $l == 3 ) { ?>
					<div class="row"></div>
					<?php
					$l = 0; 
				} 

			endwhile; endif; wp_reset_postdata();

			wp_die();		
		}

		/* Download file PDF Ticket */
		public function download_ticket() {

			$booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : "";

			$order_info = get_post( $booking_id);
			$order_author = $order_info ? $order_info->post_author : '';
			

			if( !is_user_logged_in() ) wp_die();

			if( intval( get_current_user_id() ) !== intval( $order_author ) ) wp_die();

			$arr_upload = wp_upload_dir();
			$base_url_upload = $arr_upload['baseurl'];

			if( empty($booking_id) || !isset( $_POST['ovaem_download_ticket_nonce'] ) || !wp_verify_nonce( sanitize_text_field($_POST['ovaem_download_ticket_nonce']), 'ovaem_download_ticket_nonce' ) ) wp_die() ;

			$list_ticket = array();
			$list_ticket = OVAEM_Ticket::make_pdf_ticket_by_order( $booking_id );

			$list_url_ticket = [];
			if (is_array($list_ticket) && !empty($list_ticket)) {
				foreach($list_ticket as $ticket_pdf) {
					$position = strrpos($ticket_pdf, '/');
					$name = substr($ticket_pdf, $position);
					$list_url_ticket[] = $base_url_upload . $name;
				}
			}
			
			echo json_encode($list_url_ticket);

			wp_die();
		}

		/* Delete file PDF Ticket after create */
		public function unlink_download_ticket() {
			$data = isset($_POST['data_url']) ? $_POST['data_url'] : array();
			$arr_upload = wp_upload_dir();
			$basedir = $arr_upload['basedir'];

			$list_uri_ticket = [];
			if (is_array($data) && !empty($data)) {
				foreach($data as $ticket_pdf) {
					$position = strrpos($ticket_pdf, '/');
					$name = substr($ticket_pdf, $position);
					$list_uri_ticket[] = esc_url( $basedir . $name );
				}
			}

			if (empty($list_uri_ticket) || !is_array($list_uri_ticket)) wp_die();
			$total_ticket_pdf = count($list_uri_ticket);
			if (!empty($list_uri_ticket) && is_array($list_uri_ticket)) {
				foreach ($list_uri_ticket as $key => $value) {
					if( $key < $total_ticket_pdf ){
						if (file_exists($value)) unlink($value);
					} 
				}
			}
			wp_die();
		}

		/* Pagination Manage Bookings */
		public function pagination_manage_booking() {
			if( !isset( $_POST['data'] ) ) wp_die();
			$paged = isset($_POST['data']['paged']) ? sanitize_text_field($_POST['data']['paged']) : 1;
			$list_bookings = apply_filters( 'ovaem_get_list_booking', $paged );
			?>

			<table>
				<thead class="event_head">
					<tr>
						<td class="id"><?php esc_html_e("ID", "ovaem-events-manager") ?></td>
						<td><?php esc_html_e("Date Created", "ovaem-events-manager") ?></td>
						<td><?php esc_html_e("Status", "ovaem-events-manager") ?></td>
						<td><?php esc_html_e("Action", "ovaem-events-manager") ?></td>
					</tr>
				</thead>
				<tbody class="event_body">
				<?php if($list_bookings->have_posts() ) : while ( $list_bookings->have_posts() ) : $list_bookings->the_post();
						$booking_id = get_the_ID();
						$id_event = get_post_meta( $booking_id, 'ovaem_ticket_event_id', true );
						$ovaem_event_id = get_post_meta( $booking_id, 'ovaem_event_id', true );
						$ovaem_event_status = get_post_meta( $booking_id, 'ovaem_event_status', true );

						// Only display if the status is "Completed"
						if ($ovaem_event_status === 'Pending') :
				?>
				<tr>
						<td data-colname="<?php esc_attr_e('ID', 'ovaem-events-manager'); ?>" class="id"><?php echo esc_html($booking_id); ?></td>

						<td data-colname="<?php esc_attr_e('Date Created', 'ovaem-events-manager'); ?>" >
								<?php 
								$date_format = get_option('date_format');
								$time_format = get_option('time_format');
								echo get_the_date($date_format, $booking_id) . " - " . get_the_date($time_format, $booking_id);
								?>
						</td>

						<td data-colname="<?php esc_attr_e('Status', 'ovaem-events-manager'); ?>" >
								<?php 
								switch ($ovaem_event_status) {
										case 'Pending':
												esc_html_e('Pending', 'ovaem-events-manager');
												break;
										case 'Completed':
												esc_html_e('Completed', 'ovaem-events-manager');
												break;
										case 'Canceled_Reversal':
												esc_html_e('Canceled Reversal', 'ovaem-events-manager');
												break;
										case 'Denied':
												esc_html_e('Denied', 'ovaem-events-manager');
												break;
										case 'Expired':
												esc_html_e('Expired', 'ovaem-events-manager');
												break;
										case 'Failed':
												esc_html_e('Failed', 'ovaem-events-manager');
												break;
										case 'Refunded':
												esc_html_e('Refunded', 'ovaem-events-manager');
												break;
										case 'Reversed':
												esc_html_e('Reversed', 'ovaem-events-manager');
												break;
										case 'Processed':
												esc_html_e('Processed', 'ovaem-events-manager');
												break;
										case 'Voided':
												esc_html_e('Voided', 'ovaem-events-manager');
												break;
										// For woo
										case 'wc-pending':
												esc_html_e('Pending', 'ovaem-events-manager');
												break;
										case 'wc-processing':
												esc_html_e('Processing', 'ovaem-events-manager');
												break;
										case 'wc-on-hold':
												esc_html_e('On Hold', 'ovaem-events-manager');
												break;
										case 'wc-completed':
												esc_html_e('Completed', 'ovaem-events-manager');
												break;
										case 'wc-cancelled':
												esc_html_e('Cancelled', 'ovaem-events-manager');
												break;
										case 'wc-refunded':
												esc_html_e('Refunded', 'ovaem-events-manager');
												break;
										case 'wc-failed':
												esc_html_e('Failed', 'ovaem-events-manager');
												break;
										case 'error_mail':
												esc_html_e('Error send mail to attendee', 'ovaem-events-manager');
												break;
										default:
												break;
								}
								?>
						</td>

						<td>
								<div class="wp-button-my-booking">
										<div class="button-dowload-ticket">
												<div class="submit-load-more dowload-ticket">
														<div class="load-more">
																<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
														</div>
												</div>
												<button class="button download-ticket" data-nonce="<?php echo wp_create_nonce( 'ovaem_download_ticket_nonce' ); ?>" data-booking_id="<?php echo esc_attr($booking_id) ?>"><?php esc_html_e( "Download", "ovaem-events-manager" ); ?></button>
										</div>
								</div>
						</td>
				</tr>
				<?php 
						endif; // End status check
				endwhile; else : ?> 
				<td colspan="8"><?php esc_html_e( 'Not Found Bookings', 'ovaem-events-manager' ); ?></td> 
				<?php endif; wp_reset_postdata(); ?>

					<?php $total = $list_bookings->max_num_pages;?>
					<?php if ( $total > 1 ) { ?>
						<td colspan="8">
							<div class="ovaem_pagination">
								<?php ovaem_pagination_ajax($list_bookings->found_posts, $list_bookings->query_vars['posts_per_page'], $paged); ?>
							</div>
						</td>			
					<?php } ?>
				</tbody>
			</table>

			<!-- Loader -->
			<div class="wrap_loader" style="display: none;">
				<svg class="loader" width="50" height="50">
					<circle cx="25" cy="25" r="10" stroke="#e86c60"/>
					<circle cx="25" cy="25" r="20" stroke="#e86c60"/>
				</svg>
			</div>

			<?php
			
			wp_die();
		}

		public function ovaem_recapcha_verify_ajax(){
			$post_data 	= $_POST['data'];
			$secret_key = isset( $post_data['secret'] ) ? sanitize_text_field( $post_data['secret'] ) : '';
			$response 	= isset( $post_data['response'] ) ? sanitize_text_field( $post_data['response'] ) : '';

			$check_recapcha = ovaem_recapcha_verify( $response, $secret_key );
			
			echo $check_recapcha;
			wp_die();
		}

	}

	new OVAEM_Frontend_Ajax();

}

?>