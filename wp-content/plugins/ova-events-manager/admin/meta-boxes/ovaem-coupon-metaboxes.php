<?php 

if( !defined( 'ABSPATH' ) ) exit();

if( !class_exists( 'OVAEM_coupon_Metaboxes' ) ){

	class OVAEM_coupon_Metaboxes{

		public static function render(){
			
			if( !current_user_can( 'administrator' ) ) return false;
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-coupon.php' );
		}

		public static function save($post_id, $post_data){

			$prefix = OVAEM_Settings::$prefix;

			if( empty($post_data) ) exit();

			// if( array_key_exists($prefix.'_speaker_social', $post_data) == false )   $post_data[$prefix.'_speaker_social'] = '';
			foreach ($post_data as $key => $value) {
				
				if($key == $prefix.'_coupon_start_date') $value = strtotime( $value );
				if($key == $prefix.'_coupon_end_date') $value = strtotime( $value );

				update_post_meta( $post_id, $key, $value );	
			}
			if ( ! isset( $post_data[$prefix.'_enable_for_woo'] ) ) {
				update_post_meta( $post_id, $prefix.'_enable_for_woo', '' );	
			}
			
		}

		public static function create_coupon_woo( $post_id, $post_status ){
			$prefix 		= OVAEM_Settings::$prefix;
			$current_time 	= current_time( 'timestamp' );
			$coupon_code 	= get_post_meta( $post_id, $prefix . '_coupon_code', true );
			$amount 		= get_post_meta( $post_id, $prefix . '_coupon_amount', true );

			$coupon_start_date_time = get_post_meta( $post_id, $prefix . '_coupon_start_date', true );
			$coupon_end_date_time 	= get_post_meta( $post_id, $prefix . '_coupon_end_date', true );
			$post_discount_type 	= get_post_meta( $post_id, $prefix . '_coupon_type', true );

			if ( $post_discount_type === 'percent' ) {
				$discount_type = 'percent';
			} elseif ( $post_discount_type === 'pieces' ) {
				$discount_type = 'fixed_cart';
			}
			// Check start date time coupon event to change post_status
			$post_status = ( (int) $current_time - (int) $coupon_start_date_time ) >= 0 ? 'publish' : '';
			if ( $post_status !== 'publish' ) {
				return;
			}

			$coupon = array(
			    'post_title' 	=> $coupon_code,
			    'post_content' 	=> '',
			    'post_status' 	=> $post_status,
			    'post_author' 	=> 1,
			    'post_type'     => 'shop_coupon'
			);    
			// Create coupon
			$new_coupon_id = wp_insert_post( $coupon );

			// Add meta
			update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
			update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
			update_post_meta( $new_coupon_id, 'individual_use', 'no' );
			update_post_meta( $new_coupon_id, 'usage_limit', '0' );
			update_post_meta( $new_coupon_id, 'usage_limit_per_user', '0' );
			update_post_meta( $new_coupon_id, 'limit_usage_to_x_items', '0' );
			update_post_meta( $new_coupon_id, 'usage_count', '0' );
			update_post_meta( $new_coupon_id, 'exclude_sale_items', 'no' );
			update_post_meta( $new_coupon_id, 'date_expires', $coupon_end_date_time );
			update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
		}

		public static function update_counpon_woo( $post_id, $data, $coupon_woo_id ){
			$post_data 		= $_POST;
			$prefix 		= OVAEM_Settings::$prefix;
			$current_time 	= current_time( 'timestamp' );
			$coupon_code 	= isset( $_POST[$prefix . '_coupon_code'] ) ? $_POST[$prefix . '_coupon_code'] : '';
			$amount 		= isset( $_POST[$prefix . '_coupon_amount'] ) ? $_POST[$prefix . '_coupon_amount'] : '';

			$coupon_start_date_time 	= isset( $_POST[$prefix . '_coupon_start_date'] ) ? strtotime( $_POST[$prefix . '_coupon_start_date'] ) : '';
			$coupon_end_date_time 		= isset( $_POST[$prefix . '_coupon_end_date'] ) ? strtotime( $_POST[$prefix . '_coupon_end_date'] ) : '';
			$post_discount_type 		= isset( $_POST[$prefix . '_coupon_type'] ) ? $_POST[$prefix . '_coupon_type'] : '';

			if ( $post_discount_type === 'percent' ) {
				$discount_type = 'percent';
			} elseif ( $post_discount_type === 'pieces' ) {
				$discount_type = 'fixed_cart';
			}
			// Check start date time coupon event to change post_status
			$post_status 	= $data['post_status'];
			$check_time		= ( (int)$current_time - (int)$coupon_start_date_time ) >= 0 ? true : false;
			if ( ! $check_time ) {
				return;
			}

			$coupon_update = array(
				'ID'           	=> $coupon_woo_id,
				'post_title'   	=> $coupon_code,
				'post_content' 	=> '',
				'post_status' 	=> $post_status,
			);
			// Update coupon
			wp_update_post( $coupon_update );

			// Add meta
			update_post_meta( $coupon_woo_id, 'discount_type', $discount_type );
			update_post_meta( $coupon_woo_id, 'coupon_amount', $amount );
			update_post_meta( $coupon_woo_id, 'date_expires', $coupon_end_date_time );
		}

		public static function pre_update_coupon( $post_id, $data ){
			$get_post_type 	= get_post_type( $post_id );
			if ( $get_post_type !== 'coupon' ) {
				return;
			}
			global $wpdb;
			$prefix 		= OVAEM_Settings::$prefix;
			$post_data 		= $_POST;
			$get_data 		= $_REQUEST;
			$action 		= isset( $get_data['action'] ) ? $get_data['action'] : '';
			
			$coupon_code 	= get_post_meta( $post_id, $prefix . '_coupon_code', true );
			$post_name 		= $coupon_code;
			$post_type 		= 'shop_coupon';
			// get coupon_woo_id from old code coupon event
			$coupon_woo_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type= %s", $post_name, $post_type ) );
			$post_status 	= $data['post_status'];
			$enable_for_woo 		= get_post_meta( $post_id,$prefix . '_enable_for_woo' , true );
			$_post_enable_for_woo 	= $post_data[$prefix . '_enable_for_woo'];

			if ( $post_status !== 'publish' ) {
				if ( $coupon_woo_id ) {
					wp_delete_post( $coupon_woo_id , true);
				}
			} else {

				if ( ! $enable_for_woo && $_post_enable_for_woo ) {
					self::create_coupon_woo( $post_id, $post_status );
				} elseif ( $enable_for_woo && $_post_enable_for_woo ) {
				
					if ( $coupon_woo_id ) {
						self::update_counpon_woo( $post_id, $data, $coupon_woo_id );
					} else {
						self::create_coupon_woo( $post_id, $post_status );
					}
				} elseif ( ! $_post_enable_for_woo ) {
					if ( $coupon_woo_id ) {
						wp_delete_post( $coupon_woo_id , true);
					}
				}
			}

			if ( $action === 'untrash' ) {
				self::create_coupon_woo( $post_id, $post_status );
			}

		}
	}
	if ( class_exists( 'WooCommerce' ) ) {
		add_action( 'pre_post_update', 'OVAEM_coupon_Metaboxes::pre_update_coupon', 20, 2 );
	}
}



