<?php 

if( !defined( 'ABSPATH' ) ) exit();

if( !class_exists( 'OVAEM_Event_Metaboxes' ) ){

	class OVAEM_Event_Metaboxes{

		public static function render(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-event.php' );
		}

		public static function save($post_id, $post_data){
			
			$prefix = OVAEM_Settings::$prefix;

			if( empty($post_data) ) exit();
			
			if( array_key_exists($prefix.'_featured', $post_data) == false ){
				$post_data[$prefix.'_featured'] = '';
			}else{
				$post_data[$prefix.'_featured'] = 'checked';
			}

			// Check schedule exits
			$schedule_date = isset( $post_data[$prefix.'_schedule_date'] ) ? $post_data[$prefix.'_schedule_date'] : '';

			if( $schedule_date ){

				// Make Speakers metabox to store all speaker in each plan
				$speakers_arr =  '';
				$plans = isset( $post_data[$prefix.'_schedule_plan'] ) ? $post_data[$prefix.'_schedule_plan'] : array();

				if( !empty( $plans ) ){
					foreach ($plans as $key_plan => $value_plan) {
						if( $value_plan ){
							foreach ($value_plan as $key => $value) {
								$speakers_arr .= $value['speakers'];
							}	
						}
					}
					$post_data['speakers'] = $speakers_arr;
				}
				

			}else{
				$post_data[$prefix.'_schedule_date'] = '';
			}

			// Check sponsor exits
			$sponsor_level = isset( $post_data[$prefix.'_sponsor_level'] ) ? $post_data[$prefix.'_sponsor_level'] : '';
			if( !$sponsor_level ){
				$post_data[$prefix.'_sponsor_level'] = '';
			}

			// Check gallery exits
			if( !isset( $post_data['ovaem_gallery_id'] ) ){
				$post_data['ovaem_gallery_id'] = '';
			}
			
			$ticket_field = isset( $post_data[$prefix.'_ticket'] ) ? $post_data[$prefix.'_ticket'] : '';

			if( ! $ticket_field ){
				$post_data[$prefix.'_ticket'] = '';
				self::delete_all_tickets( $post_id );
			} else {
				foreach ( $ticket_field as $key => $value ) {
					if ( empty( $value ) || $value['package_id'] == '' ) {
						unset( $ticket_field[$key] );
					} else {
						// handle create_product_variation
						$pay_method = $value['pay_method'];
						$package_id = $value['package_id'];
						// check pay method
						if ( $pay_method === 'woo_modern' ) {
							$ticket_id = self::create_ticket( $post_id ,$post_data, $key, $value);
							$ticket_field[$key]['ticket_id'] = $ticket_id;
						} else {
							self::delete_ticket_by_package_id( $post_id, $package_id );
						}
					}
				}
				self::delete_ticket( $post_id, $ticket_field );
				$post_data[$prefix.'_ticket'] = $ticket_field;
			}

			// Check faq exits
			$faq_level = isset( $post_data[$prefix.'_faq_title'] ) ? $post_data[$prefix.'_faq_title'] : '';
			
			if( !$faq_level ){
				$post_data[$prefix.'_faq_title'] = '';
			}

			foreach ($post_data as $key => $value) {

				if($key == $prefix.'_date_start_time') $value = strtotime($value);
				if($key == $prefix.'_date_end_time') $value = strtotime($value);
				
				update_post_meta( $post_id, $key, $value );	
			}
		}

		public static function create_ticket( $post_id ,$post_data, $key, $value ){

			$ticket_price 	= $value['ticket_price'];
			$package_id 	= $value['package_id'];
			$ticket_name 	= $value['ticket_name'];
			$number_ticket 	= $value['number_ticket'] ? $value['number_ticket'] : '0';
			$stock_status 	= $number_ticket != '0' ? 'instock' : 'outofstock';

			$ticket = array(
				'post_title'  	=> $post_data['post_title'] . ' - ' . $ticket_name,
				'post_name'   	=> sanitize_title( $post_data['post_title'] .'-'. $ticket_name ),
				'post_status' 	=> 'publish',
				'post_type'   	=> 'post',
				'guid'			=> get_permalink( $post_id ),
			);
			
			$ticket_id = $value['ticket_id'] ? $value['ticket_id'] : '';

			if ( ! $ticket_id ) {
				$ticket_id = wp_insert_post( $ticket );
				// set post type
				$post_type = 'ovaem_ticket_type';
				global $wpdb;
				$query = "UPDATE {$wpdb->prefix}posts SET post_type='".$post_type."' WHERE id='".$ticket_id."' LIMIT 1";
				$wpdb->query($query);
			} else {
				$ticket = array(
					'ID' => $ticket_id,
					'post_title' => $post_data['post_title'] . ' - ' . $ticket_name,
					'post_name'   	=> sanitize_title( $post_data['post_title'] .'-'. $ticket_name ),
					'guid'			=> get_permalink( $post_id ),
				);
				wp_update_post( $ticket );
			}

			update_post_meta( $ticket_id, '_price', $ticket_price );
			update_post_meta( $ticket_id, '_event_id', $post_id );
			update_post_meta( $ticket_id, '_package_key', $key );
			update_post_meta( $ticket_id, '_package_id', $package_id );
			update_post_meta( $ticket_id, '_stock', $number_ticket );
			update_post_meta( $ticket_id, '_stock_status', $stock_status );

			return $ticket_id;
		}

		public static function delete_all_tickets( $post_id ){
			$args = array(
			    'meta_query' => array(
			        array(
			            'key' => '_event_id',
			            'value' => $post_id,
			            'compare' => '=',
			        )
			    ),
			    'post_type' => 'ovaem_ticket_type',
			    'posts_per_page' => -1,
			    'fields' => 'ids',
			);
			$tickets = get_posts($args);
			foreach ( $tickets as $ticket_id ) {
				wp_delete_post( $ticket_id );
			}
		}

		public static function delete_ticket( $post_id, $ticket_field ){
			$args = array(
			    'meta_query' => array(
			    	'relation' => 'AND',
			        array(
			            'key' => '_event_id',
			            'value' => $post_id,
			            'compare' => '=',
			        ),
			    ),
			    'post_type' => 'ovaem_ticket_type',
			    'posts_per_page' => -1,
			    'fields' => 'ids',
			);

			foreach ( $ticket_field as $key => $value ) {

				$package_id = $value['package_id'];
				// $method 	= $value['pay_method'];

				array_push($args['meta_query'], array(
			            'key' => '_package_id',
			            'value' => $package_id,
			            'compare' => '!=',
			        ),
			);
			}
			$tickets = get_posts($args);
			foreach ( $tickets as $ticket_id ) {
				wp_delete_post( $ticket_id );
			}
			
		}

		public static function delete_ticket_by_package_id( $post_id, $package_id ){

			$args = array(
			    'meta_query' => array(
			    	'relation' => 'AND',
			        array(
			            'key' => '_event_id',
			            'value' => $post_id,
			            'compare' => '=',
			        ),
			        array(
			            'key' => '_package_id',
			            'value' => $package_id,
			            'compare' => '=',
			        ),
			    ),
			    'post_type' => 'ovaem_ticket_type',
			    'posts_per_page' => -1,
			    'fields' => 'ids',
			);

			$tickets = get_posts($args);
			foreach ( $tickets as $ticket_id ) {
				wp_delete_post( $ticket_id );
			}
		}

	}

}

?>