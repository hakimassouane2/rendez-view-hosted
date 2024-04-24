<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'OVAEM_Ticket' ) ){
	class OVAEM_Ticket {

		public static function translate_date_to_french($date_string) {
				// Define arrays for English and French day and month names
				$english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
				$french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

				$english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				$french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

				// Replace English day and month names with French
				$date_string = str_replace($english_days, $french_days, $date_string);
				$date_string = str_replace($english_months, $french_months, $date_string);

				return $date_string;
		}

		// Add Ticket when client checkout before paid
		public static function add_ticket( $order_id, $ticket_verify = 'false', $order_id_woo = '' ){

			$prefix = OVAEM_Settings::$prefix;
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');

			$buyer_name = get_post_meta( $order_id, 'ovaem_name', true );
			$buyer_email = get_post_meta( $order_id, 'ovaem_email', true );
			$buyer_phone = get_post_meta( $order_id, 'ovaem_phone', true );
			$ovaem_number = get_post_meta( $order_id, 'ovaem_number', true );

			$buyer_address = get_post_meta( $order_id, 'ovaem_address', true );
			$buyer_company = get_post_meta( $order_id, 'ovaem_company', true );
			$buyer_desc = get_post_meta( $order_id, 'ovaem_desc', true );

			

			$ovaem_order_cart = get_post_meta( $order_id, 'ovaem_order_cart', true );
			

			$post_data['post_type'] = 'event_ticket';
			$post_data['post_status'] = 'publish';

			$author = get_post_field( 'post_author', $order_id );
			$post_data['post_author'] = $author ? $author : '';


			if ( is_array( $ovaem_order_cart ) ){ /* Paid Ticket */
				foreach ( $ovaem_order_cart as $id => $quantity ){

					$parse_id = explode('_', $id);

					$event_id = intval( $parse_id[0] );
					$event = get_post( $event_id  );

					if( $event->post_type == OVAEM_Settings::event_post_type_slug() ){
						$locale_code = get_post_meta( $order_id, 'ovaem_order_language', true );
						$start_time_stamp = get_post_meta( $event_id, $prefix.'_date_start_time', true );
						$end_time_stamp = get_post_meta( $event_id, $prefix.'_date_end_time', true );

						if ($locale_code === 'fr_FR') {
								$start_time_format = 'l j F Y H:i:s'; // French date format
								$end_time_format = 'l j F Y H:i:s'; // French date format
						} else {
								$start_time_format = 'l jS F Y H:i:s'; // English date format
								$end_time_format = 'l jS F Y H:i:s'; // English date format
						}

						// Format start time
						$start_datetime = new DateTime();
						$start_datetime->setTimestamp($start_time_stamp);
						$start_time = $start_datetime->format($start_time_format);

						// Format end time
						$end_datetime = new DateTime();
						$end_datetime->setTimestamp($end_time_stamp);
						$end_time = $end_datetime->format($end_time_format);

						if ($locale_code === 'fr_FR') {
								$start_time = self::translate_date_to_french($start_time);
								$end_time = self::translate_date_to_french($end_time);
						}

						$venue = $venue_address = '';
						$venue_slug = get_post_meta( $event_id, $prefix.'_venue', true );
						if( $venue_slug ){
							$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );
							$venue_address = get_post_meta( $venue->ID, $prefix.'_venue_address', true );	
						}


						$event_title = $event->post_title;
						$package = urldecode($parse_id[3]);

						$package_id = isset($parse_id[4]) ? str_replace( "ovaminus", "_", urldecode($parse_id[4]) ) : '';

						$post_data['post_title'] = $event_title;

						$ticket_info = OVAEM_Get_Data::ovaem_get_info_ticket( $event_id, $package_id );
						$ticket_info_link = ( isset( $ticket_info['link'] ) && $ticket_info['link'] ) ? $ticket_info['link'] : '';
						$ticket_info_password = ( isset( $ticket_info['password'] ) && $ticket_info['password'] ) ? $ticket_info['password'] : '';

						$ovaem_pdf_ticket_logo = get_post_meta( $event_id, 'ovaem_pdf_ticket_logo', true );

						for( $i = 0; $i < $quantity; $i++ ){
							$mix_id = $order_id . '-ova-em-' . $id . '-ova-em-' . $i . OVAEM_Settings::event_secret_key();
							$uniqid = md5( $mix_id );

							$meta_input = array(
								'ovaem_ticket_code' 	=> $uniqid,
								'ovaem_ticket_status'=> 'not_checked_in',
								'ovaem_ticket_buyer_name' 	=> $buyer_name,
								'ovaem_ticket_buyer_email' 	=> $buyer_email,
								'ovaem_ticket_buyer_phone' => $buyer_phone,
								'ovaem_ticket_buyer_address' => $buyer_address,
								'ovaem_ticket_buyer_company' => $buyer_company,
								'ovaem_ticket_buyer_desc' => $buyer_desc,
								'ovaem_ticket_event_name' => $event_title,
								'ovaem_pdf_ticket_logo'	=> $ovaem_pdf_ticket_logo,
								'ovaem_ticket_event_id' => $event_id,
								'ovaem_ticket_package_id' => $package_id,
								'ovaem_ticket_info_link'	=> $ticket_info_link,
								'ovaem_ticket_info_password'	=> $ticket_info_password,
								'ovaem_ticket_event_package' 	=> $package,
								'ovaem_ticket_event_start_time' => $start_time,
								'ovaem_ticket_event_end_time' => $end_time,
								'ovaem_ticket_event_venue' => $venue->post_title,
								'ovaem_ticket_event_address' => $venue_address,
								'ovaem_ticket_from_order_id' => $order_id,
								'ovaem_ticket_from_woo_order_id' => $order_id_woo,
								'ovaem_ticket_verify' => $ticket_verify
							);
							$post_data['meta_input'] = $meta_input;

							$ticket_id_new = wp_insert_post( $post_data, true );
							
							// Update Post Title to Order Id
							$update_post = array(
								'ID' => $ticket_id_new,
								'post_name' => $uniqid
							);
							wp_update_post( $update_post );
						}

					}

				}
			} else if ( intval( $ovaem_number ) ){ /* Free Ticket */

				$event_id = get_post_meta( $order_id, 'ovaem_free_event_id', true );

				$package_id = get_post_meta( $order_id, 'package_id', true );

				$free_event_info = get_post( $event_id );

				$locale_code = get_post_meta( $order_id, 'ovaem_order_language', true );

				$start_time_stamp = get_post_meta( $event_id, $prefix.'_date_start_time', true );
				$end_time_stamp = get_post_meta( $event_id, $prefix.'_date_end_time', true );


				// Check if locale is French
				if ($locale_code === 'fr_FR') {
						$start_time_format = 'l j F Y H:i:s'; // French date format
						$end_time_format = 'l j F Y H:i:s'; // French date format
				} else {
						$start_time_format = 'l jS F Y H:i:s'; // English date format
						$end_time_format = 'l jS F Y H:i:s'; // English date format
				}

				// Format start time
				$start_datetime = new DateTime();
				$start_datetime->setTimestamp($start_time_stamp);
				$start_time = $start_datetime->format($start_time_format);

				// Format end time
				$end_datetime = new DateTime();
				$end_datetime->setTimestamp($end_time_stamp);
				$end_time = $end_datetime->format($end_time_format);

			if ($locale_code === 'fr_FR') {
						$start_time = self::translate_date_to_french($start_time);
						$end_time = self::translate_date_to_french($end_time);
				}


				$venue = $venue_address = '';
				$venue_slug = get_post_meta( $event_id, $prefix.'_venue', true );
				if( $venue_slug ){
					$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );
					$venue_address = get_post_meta( $venue->ID, $prefix.'_venue_address', true );
				}

				$post_data['post_title'] = $free_event_info->post_title;
				
				$author = get_post_field( 'post_author', $order_id );
				$post_data['post_author'] = $author ? $author : '';

				$ticket_info = OVAEM_Get_Data::ovaem_get_info_ticket( $event_id, $package_id );
				$ticket_info_link = ( isset( $ticket_info['link'] ) && $ticket_info['link'] ) ? $ticket_info['link'] : '';
				$ticket_info_password = ( isset( $ticket_info['password'] ) && $ticket_info['password'] ) ? $ticket_info['password'] : '';

				$ovaem_pdf_ticket_logo = get_post_meta( $event_id, 'ovaem_pdf_ticket_logo', true );

				for( $i = 0; $i < intval( $ovaem_number ); $i++ ){
					$mix_id = $order_id . '-ova-em-' . $i . OVAEM_Settings::event_secret_key();
					$uniqid = md5( $mix_id ); 

					$meta_input = array(
						'ovaem_ticket_code' 	=> $uniqid,
						'ovaem_ticket_status'=> 'not_checked_in',
						'ovaem_ticket_buyer_name' 	=> $buyer_name,
						'ovaem_ticket_buyer_email' 	=> $buyer_email,
						'ovaem_ticket_buyer_phone' => $buyer_phone,
						'ovaem_ticket_buyer_address' => $buyer_address,
						'ovaem_ticket_buyer_company' => $buyer_company,
						'ovaem_ticket_buyer_desc' => $buyer_desc,
						'ovaem_ticket_event_name' => $free_event_info->post_title,
						'ovaem_pdf_ticket_logo'	=> $ovaem_pdf_ticket_logo,
						'ovaem_ticket_event_id' => $event_id,
						'ovaem_ticket_package_id' => $package_id,
						'ovaem_ticket_info_link'	=> $ticket_info_link,
						'ovaem_ticket_info_password'	=> $ticket_info_password,
						'ovaem_ticket_event_package' 	=> esc_html__('Free', 'ovaem-events-manager' ),
						'ovaem_ticket_event_start_time' => $start_time,
						'ovaem_ticket_event_end_time' => $end_time,
						'ovaem_ticket_event_venue' => $venue->post_title,
						'ovaem_ticket_event_address' => $venue_address,
						'ovaem_ticket_from_order_id' => $order_id,
						'ovaem_ticket_verify' => 'true'
					);
					$post_data['meta_input'] = $meta_input;

					$ticket_id_new = wp_insert_post( $post_data, true );

					// Update Post Title to Order Id
					$update_post = array(
						'ID' => $ticket_id_new,
						'post_name' => $uniqid
					);
					wp_update_post( $update_post );
				}
			}


			return true;
		}


		// Make PDF Ticket
		public static function make_pdf_ticket_by_order( $order_id ){

			$args = array(
				'post_type' => 'event_ticket',
				'post_status' => 'publish',
				'posts_per_page' => '-1',
				'meta_query' => array(
					array(
						'key' => 'ovaem_ticket_from_order_id',
						'value' => $order_id,
						'compare' => '='
					)
				)
			);
			$tickets = new WP_Query( $args );

			
			$ticket_pdf = array();
			$k = 0;
			$client_count = 1;

			if( $tickets->have_posts() ): while( $tickets->have_posts() ): $tickets->the_post();

				$pdf = new OVAEM_Make_PDF();
				$ticket_id = get_the_id();

				if( OVAEM_Settings::event_mail_attachment() == 'pdf' || OVAEM_Settings::event_mail_attachment() == 'both' ){
					if( get_post_meta( $ticket_id, 'ovaem_ticket_verify', true ) == 'true' ){
						$ticket_pdf[$k] = $pdf->make_pdf_ticket( $ticket_id, $client_count );
						$k++;	
					}
				}

				if( OVAEM_Settings::event_mail_attachment() == 'qr' || OVAEM_Settings::event_mail_attachment() == 'both' ){
					$code = get_post_meta( $ticket_id, 'ovaem_ticket_code', true );
					// @TODO: Check order locale here to add /fr before the qrcode url
					$qrcode = ( OVAEM_Settings::pdf_ticket_format_qr() == 'code' ) ? $code : home_url( '/' ).'?qrcode='.$code;
					$qrcode = new QRcode($qrcode, 'H');
					$qr_image = WP_CONTENT_DIR.'/uploads/ticket_qr_'.$code.'.png';
					$qrcode->displayPNG('100',array(255,255,255), array(0,0,0), $qr_image , 0);
					$ticket_pdf[$k] = $qr_image;
					$k++;
				}

				$client_count++;

			endwhile; endif; wp_reset_postdata();
			
			
			return $ticket_pdf;
		}

		// Make PDF Ticket By Woo Order
		public static function get_order_by_woo_order( $order_woo_id ){

			$args = array(
				'post_type' 		=> 'event_order',
				'post_status' 		=> 'publish',
				'posts_per_page' 	=> '-1',
				'fields' 			=> 'ids',
				'meta_query' 		=> array(
					array(
						'key' => 'ovaem_order_woo_id',
						'value' => $order_woo_id,
						'compare' => '='
					)
				)
			);

			$orders 	= new WP_Query( $args );
			$order_ids 	= array();

			if ( $orders->have_posts() ): while( $orders->have_posts() ): $orders->the_post();
				$order_id = get_the_id();
				array_push( $order_ids, $order_id );
			endwhile; endif; wp_reset_postdata();
			
			return $order_ids;
		}


		// Verify ticket allow to checkin
		public static function verify_pdf_ticket( $order_id ){

			$args = array(
				'post_type' => 'event_ticket',
				'post_status' => 'publish',
				'posts_per_page' => '-1',
				'meta_query' => array(
					array(
						'key' => 'ovaem_ticket_from_order_id',
						'value' => $order_id,
						'compare' => '='
					)
				)
			);
			$tickets = new WP_Query( $args );

			
			$ticket_pdf = array();
			$k = 0;

			if( $tickets->have_posts() ): while( $tickets->have_posts() ): $tickets->the_post();

				global $post;

				update_post_meta( $post->ID, 'ovaem_ticket_verify', 'true' );
				

			endwhile; endif; wp_reset_postdata();
			

			return true;
		}



		public static function remaining_ticket( $event_id, $package_id ){

			// Get total ticket of event_id and package_id
			$total_ticket = 0;
			$prefix = OVAEM_Settings::$prefix;
			$tickets = get_post_meta( $event_id, $prefix.'_ticket', true );
			if( $tickets ){
				foreach ($tickets as $key => $value) {
					if( isset( $value['package_id'] ) && $value['package_id'] ==  $package_id ){
						$total_ticket = $value['number_ticket'];	
					}				
				}	
			}
			

			$args = array(
				'post_type' => 'event_ticket',
				'post_status' => 'publish',
				'posts_per_page' => '-1',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'ovaem_ticket_event_id',
						'value' => $event_id,
						'compare' => '='
					),
					array(
						'key' => 'ovaem_ticket_package_id',
						'value' => $package_id,
						'compare' => '='
					),
					array(
						'key' => 'ovaem_ticket_verify',
						'value' => 'true',
						'compare' => '='
					)
				)
			);
			$tickets = new WP_Query( $args );
			$tickets_count = $tickets->post_count;
			return ( (int)$total_ticket - (int)$tickets_count );
		}

		public static function em4u_dayweek( $date ){
			switch ($date) {

				case '0':
				$day = esc_html__( 'Sunday', 'ovaem-events-manager' );
				break;
				case '1':
				$day = esc_html__( 'Monday', 'ovaem-events-manager' );
				break;	
				case '2':
				$day = esc_html__( 'Tuesday', 'ovaem-events-manager' );
				break;	
				case '3':
				$day = esc_html__( 'Wednesday', 'ovaem-events-manager' );
				break;
				case '4':
				$day = esc_html__( 'Thursday', 'ovaem-events-manager' );
				break;		
				case '5':
				$day = esc_html__( 'Friday', 'ovaem-events-manager' );
				break;	
				case '6':
				$day = esc_html__( 'Saturday', 'ovaem-events-manager' );
				break;
				
				default:
				$day = '';
				break;
			}
			return $day;
		}
		


	}
}

new OVAEM_Ticket();
