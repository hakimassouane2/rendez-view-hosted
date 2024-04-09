<?php
/**
 * Main FilterHooks class.
 *
 * @package WooModern\WM
 */

namespace WooModern\OvaemCptWoo\Hooks;

defined( 'ABSPATH' ) || exit();

use WooModern\OvaemCptWoo\Modal\CPTOrderItemProduct;
use WooModern\OvaemCptWoo\Modal\CPTProductDataStore;
use WooModern\OvaemCptWoo\Traits\SingletonTrait;
use OVAEM_Settings;
use OVAEM_Ticket;
use OVAEM_Send_Mail;
use OVAEM_Event_Metaboxes;

/**
 * Main FilterHooks class.
 */
class FilterHooks {
	/**
	 * Singleton
	 */
	use SingletonTrait;

	/**
	 * Init Hooks.
	 *
	 * @return void
	 */
	private function __construct() {

		add_filter( 'woocommerce_data_stores', [ $this, 'ovaemcptwoo_data_stores' ], 99 );
		add_filter('woocommerce_product_get_price', [ $this, 'ovaemcptwoo_product_get_price' ] , 10, 2 );
		// Order Product Class.
		add_filter('woocommerce_get_order_item_classname', [ $this, 'ovaemcptwoo_get_order_item_classname' ] , 12, 3 );
		// Add suggestions to the product tabs.
		// Checkout Page issue. Plugin Support.
        add_filter('woocommerce_checkout_create_order_line_item_object', [ $this, 'ovaemcptwoo_checkout_create_order_line_item_object' ] , 12 );

        add_action('woocommerce_order_status_changed',array( $this, 'send_ticket_mail' ), 10, 3 );
		// Handle booking event
        add_action( 'woocommerce_checkout_update_order_meta', [ $this, 'ovaemcptwoo_event_order' ], 10, 2 );

		// limit quantity
		add_action( 'woocommerce_after_cart_item_quantity_update', [ $this, 'ovaemcptwoo_limit_cart_item_quantity' ], 20, 4 );
		
		add_action( 'before_delete_post', [ $this, 'ovaemcptwoo_delete_tickets' ], 10, 2 );

		add_filter( 'woocommerce_admin_order_item_thumbnail', [ $this, 'ovaemcptwoo_admin_order_item_thumbnail' ], 10, 3 );

		add_filter( 'woocommerce_before_order_itemmeta', [ $this, 'ovaemcptwoo_before_order_itemmeta' ], 10, 3 );

		add_filter( 'woocommerce_cart_item_name', [ $this, 'ovaemcptwoo_cart_item_name' ], 10, 3 );

		add_filter( 'woocommerce_order_item_permalink', [ $this, 'ovaemcptwoo_order_item_permalink' ], 10, 3 );
	}

	/**
	 * @param $obj_WC_Order_Item_Product
	 * @param $cart_item_key
	 * @param $values
	 * @param $order
	 *
	 * @return mixed
	 */
	public function ovaemcptwoo_checkout_create_order_line_item_object( $obj_WC_Order_Item_Product ) {
		$obj_WC_Order_Item_Product = new CPTOrderItemProduct();
		return $obj_WC_Order_Item_Product;
	}

	/**
	 * @param $price
	 * @param $product
	 *
	 * @return mixed
	 */
	public function ovaemcptwoo_product_get_price( $price, $product ) {
		
		$product_id = $product->get_id();

		if ( get_post_type( $product_id ) === 'ovaem_ticket_type' ) {
			$price = get_post_meta( $product_id, '_price', true );
		}

		return apply_filters( 'ovaemcptwoo_product_get_price', $price, $product );
	}

	/**
	 * @param $stores
	 *
	 * @return mixed
	 */
	public function ovaemcptwoo_data_stores( $stores ) {
		$stores['product'] = CPTProductDataStore::class;
		return $stores;
	}

	/**
	 * @param $stores
	 *
	 * @return mixed
	 */
	public function ovaemcptwoo_get_order_item_classname( $classname, $item_type, $id ) {
		if ( 'WC_Order_Item_Product' === $classname ) {
			$classname = '\WooModern\OvaemCptWoo\Modal\CPTOrderItemProduct';
		}
		return $classname;
	}

	public function ovaemcptwoo_event_order( $woo_order_id, $_post_data ){
		$order = wc_get_order( $woo_order_id );

		// Create event order
		$title = current_time( 'timestamp' );
		$post_data['post_type'] = 'event_order';
		$post_data['post_title'] = $title;
		$post_data['post_status'] = 'publish';

		// Add Customer is Author of Order
		if( is_user_logged_in() ){
			$post_data['post_author'] = get_current_user_id();
		}

		$ovaem_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
		$ovaem_phone = $order->get_billing_phone();
		$ovaem_email = $order->get_billing_email();
		$ovaem_address = $order->get_billing_address_1();
		$ovaem_company = $order->get_billing_company();
		$ovaem_desc = $order->get_customer_note();
		$ovaem_order_coupon = '';
		$order_status = 'wc-' . $order->get_status();

		$order_total = $order->get_total();

		$meta_input = array(
			'ovaem_order_id' => '',
			'ovaem_order_woo_id' => $woo_order_id,
			'ovaem_name' => $ovaem_name,
			'ovaem_phone' => $ovaem_phone,
			'ovaem_email' => $ovaem_email,
			'ovaem_address' => $ovaem_address,
			'ovaem_company' => $ovaem_company,
			'ovaem_desc' => $ovaem_desc,
			'ovaem_event_status' => $order_status,
			'ovaem_order_cart' => '',
			'ovaem_order_coupon' => $ovaem_order_coupon,
			'ovame_ticket_type' => 'Woo - <a target="_blank" href="' . home_url('/') . 'wp-admin/post.php?post=' . $woo_order_id . '&action=edit">' . $woo_order_id . '</a>',
			'ovaem_payment_gateway' => '',
			'ovaem_order_total' =>$order_total,
		);

		$post_data['meta_input'] = $meta_input;

		$order_id = wp_insert_post($post_data, true);

		if ( ! is_wp_error( $order_id ) ) {

      		// Update Order ID to metabox
			update_post_meta($order_id, 'ovaem_order_id', $order_id, '');

      		// Update Post Title to Order Id
			$update_post = array(
				'ID' => $order_id,
				'post_title' => $order_id,
				'post_name' => $order_id,
			);
			wp_update_post( $update_post );

			do_action( 'ovaem_woomodern_checkout_event_order_created', $order_id, $_POST );

			// end create booking
		}
	}

	public function send_ticket_mail( $woo_order_id, $old_status, $new_status ){
		$order = wc_get_order( $woo_order_id );

		$order_ids = ovaem_get_booking_by_order_woo_id( $woo_order_id );

		if ( empty( $order_ids ) ) {
			return;
		}

		$order_id = $order_ids[0];

		$new_status = 'wc-'.$new_status;

		$woo_make_ticket_verify = OVAEM_Settings::woo_make_ticket_verify();

		$verify_ticket = in_array( $new_status, $woo_make_ticket_verify[0] ) ? 'true' : 'false';

		// send mail to customer

		$ovaem_name 	= $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
		$ovaem_phone 	= $order->get_billing_phone();
		$ovaem_email 	= $order->get_billing_email();
		$ovaem_address 	= $order->get_billing_address_1();
		$ovaem_company 	= $order->get_billing_company();
		$ovaem_desc 	= $order->get_customer_note();

		$body_org = OVAEM_Settings::paid_ticket_mail_template();
		$body_org = str_replace('[orderid]', '#' . $order_id, $body_org);
		$body_org = str_replace('[name]', $ovaem_name, $body_org);
		$body_org = str_replace('[phone]', $ovaem_phone, $body_org);
		$body_org = str_replace('[email]', $ovaem_email, $body_org);
		$body_org = str_replace('[address]', $ovaem_address, $body_org);
		$body_org = str_replace('[addition]', $ovaem_desc, $body_org);
		$body_org = str_replace('[company]', $ovaem_company, $body_org);
		$body_org = str_replace('[transaction_id]', $order_id, $body_org);
		$body_org = str_replace('[cart]', '', $body_org);

		$body_info = $body_org;

		// Add ticket
		$prefix 		= OVAEM_Settings::$prefix;
		$prefix_ticket 	= $prefix . '_ticket_';
		$date_format 	= get_option('date_format');
		$time_format 	= get_option('time_format');

		$buyer_name 	= get_post_meta( $order_id, 'ovaem_name', true );
		$buyer_email 	= get_post_meta( $order_id, 'ovaem_email', true );
		$buyer_phone 	= get_post_meta( $order_id, 'ovaem_phone', true );
		$buyer_address 	= get_post_meta( $order_id, 'ovaem_address', true );
		$buyer_company 	= get_post_meta( $order_id, 'ovaem_company', true );
		$buyer_desc 	= get_post_meta( $order_id, 'ovaem_desc', true );

		$post_data['post_type'] = 'event_ticket';
		$post_data['post_status'] = 'publish';
		$author = get_post_field( 'post_author', $order_id );

		if ( count( $order->get_items() ) > 0 ) {

			$ticket_ids = ovaem_get_ticket_by_order_woo_id( $woo_order_id );

			if ( empty( $ticket_ids ) ) {

				foreach ( $order->get_items() as $item ) {
					$quantity 	= $item->get_quantity();
					$product 	= $item->get_product();
					$product_id = $item->get_product_id();

					if ( 'ovaem_ticket_type' === get_post_type( $product_id ) ) {

						// find ticket of event
						$event_id 		= get_post_meta( $product_id, '_event_id', true );
						$event 			= get_post( $event_id );
						$tickets 		= get_post_meta( $event_id, 'ovaem_ticket', true );
						$ticket_key 	= get_post_meta( $product_id, '_package_key', true );
						$ticket 		= $tickets[$ticket_key];
						// MAIL BODY
						$ticket_info_link_pass = '';
						if( $ticket['link'] || $ticket['password'] ){

							$ticket_info_link_pass .= '<br/>'.$ticket['ticket_name'];
							$ticket_info_link_pass .= ( isset( $ticket['link'] ) && $ticket['link'] ) ? '<br/>'.esc_html__( 'Link:', 'ovaem-events-manager' ).' '.$ticket['link'] : '';

							$ticket_info_link_pass .= ( isset( $ticket['password'] ) && $ticket['password'] ) ? '<br/>'.esc_html__( 'Password:', 'ovaem-events-manager' ).' '.$ticket['password'] : '';
						}


						$name_event 	= '<strong>' . $event->post_title . '</strong>';
						$package_event 	= '<strong>' . urldecode( $ticket['ticket_name'] ) . '</strong>';

						$price_event = $product->get_price();
						$total_event =  get_woocommerce_currency_symbol().$item->get_total();

						$info_cart = $name_event . ' - ' . $package_event . ': ' . $quantity . ' x ' . $price_event . ' = ' . $total_event.$ticket_info_link_pass. '<br/>';
						$body_info .= $info_cart;

						// TICKET
						// Start End time event
						$start_time_stamp 	= get_post_meta( $event_id, $prefix.'_date_start_time', true );
						$end_time_stamp 	= get_post_meta( $event_id, $prefix.'_date_end_time', true );
						$start_dayweek 		= OVAEM_Ticket::em4u_dayweek( date( 'w' , $start_time_stamp) );
						$end_dayweek 		= OVAEM_Ticket::em4u_dayweek( date( 'w' , $end_time_stamp) );

						$start_time = $start_dayweek.', '.date_i18n($date_format, $start_time_stamp).' '.date_i18n( $time_format, $start_time_stamp );
						$end_time = $end_dayweek.', '.date_i18n($date_format, $end_time_stamp).' '.date_i18n( $time_format, $end_time_stamp ) ;

						$venue = $venue_address = '';
						$venue_slug = get_post_meta( $event_id, $prefix.'_venue', true );
						if( $venue_slug ){
							$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );
							$venue_address = get_post_meta( $venue->ID, $prefix.'_venue_address', true );
						}

						// handle create ticket
						$ticket_id 			= $ticket['package_id'];
						$ticket_link 		= $ticket['link'];
						$ticket_password 	= $ticket['password'];
						$ticket_name 		= $ticket['ticket_name'];
						$post_arr = array(
							'post_title'   	=> $event->post_title,
							'post_content' 	=> '',
							'post_status'  	=> 'publish',
							'post_author'  	=> $author,
							'post_type' 	=> 'event_ticket',
						);
						for ($i=0; $i < $quantity ; $i++) { 
							$ticket_id = wp_insert_post( $post_arr );
							if ( ! is_wp_error( $ticket_id ) ) {
								update_post_meta( $ticket_id, $prefix_ticket.'code' , md5( OVAEM_Settings::event_secret_key() . current_time( 'timestamp' ). $i . $event_id . $ticket_key ) );
								update_post_meta( $ticket_id, $prefix_ticket.'status' , 'not_checked_in' );
								update_post_meta( $ticket_id, $prefix_ticket.'buyer_name' , $buyer_name );
								update_post_meta( $ticket_id, $prefix_ticket.'buyer_email' , $buyer_email );
								update_post_meta( $ticket_id, $prefix_ticket.'buyer_phone' , $buyer_phone );
								update_post_meta( $ticket_id, $prefix_ticket.'buyer_address' , $buyer_address );
								update_post_meta( $ticket_id, $prefix_ticket.'buyer_company' , $buyer_company );
								update_post_meta( $ticket_id, $prefix_ticket.'buyer_desc' , $buyer_desc );
								update_post_meta( $ticket_id, $prefix_ticket.'event_name' , $event->post_title );
								update_post_meta( $ticket_id, $prefix_ticket.'event_id' , $event_id );
								update_post_meta( $ticket_id, $prefix_ticket.'package_id' , $ticket_id );
								update_post_meta( $ticket_id, $prefix_ticket.'info_link' , $ticket_link );
								update_post_meta( $ticket_id, $prefix_ticket.'info_password' , $ticket_password );
								update_post_meta( $ticket_id, $prefix_ticket.'event_package' , $ticket_name );
								update_post_meta( $ticket_id, $prefix_ticket.'event_start_time' , $start_time );
								update_post_meta( $ticket_id, $prefix_ticket.'event_end_time' , $end_time );
								update_post_meta( $ticket_id, $prefix_ticket.'event_venue' , $venue->post_title );
								update_post_meta( $ticket_id, $prefix_ticket.'event_address' , $venue_address );
								update_post_meta( $ticket_id, $prefix_ticket.'from_order_id' , $order_id );
								update_post_meta( $ticket_id, $prefix_ticket.'from_woo_order_id' , $woo_order_id );
								update_post_meta( $ticket_id, $prefix_ticket.'verify' , $verify_ticket );
							}
						}
						// minus the number of tickets
						$stock 			= (int)$ticket['number_ticket'] - (int)$quantity;
						$stock_status 	= $stock != '0' ? 'instock' : 'outofstock';
						$tickets[$ticket_key]['number_ticket'] = $stock;

						update_post_meta( $event_id, 'ovaem_ticket', $tickets );
						update_post_meta( $product_id, '_stock', $stock );
						update_post_meta( $product_id, '_stock_status', $stock_status );

					}
				}

			}
			// send mail
			if ( $verify_ticket == 'true' ) {

				foreach ( $ticket_ids as $id_ticket ) {
					update_post_meta( $id_ticket, $prefix_ticket.'verify' , 'true' );
				}

				$mail_to 		= $ovaem_email;
				$subject_org 	= esc_html__("Register Event Success", 'ovaem-events-manager');
				$ticket_pdf 	= OVAEM_Ticket::make_pdf_ticket_by_order( $order_id );
				$ovaem_sendmail = OVAEM_Send_Mail::ovaem_sendmail( $mail_to, $subject_org, $body_info, $ticket_pdf );
				// clear file pdf
				if ( $ticket_pdf && is_array( $ticket_pdf ) ) {
					foreach ( $ticket_pdf as $file) {
						wp_delete_file( $file );
					}
				}
			}
		}
	}

	public function ovaemcptwoo_limit_cart_item_quantity( $cart_item_key, $quantity, $old_quantity, $cart ){
	    // if( ! is_cart() ) return; // Only on cart page

		$product_id = $cart->cart_contents[ $cart_item_key ]['product_id'];
		$limit = null;
		if ( get_post_type( $product_id ) === 'ovaem_ticket_type' ) {

			$package_key 	= get_post_meta( $product_id, '_package_key', true );
			$stock 			= get_post_meta( $product_id, '_stock', true );
			$limit 			= $stock;
		}
		// check limit item
		if ( $limit ) {
			if( $quantity > $limit ){
		        // Change the quantity to the limit allowed
		    	$cart->cart_contents[ $cart_item_key ]['quantity'] = $limit;
		        // Add a custom notice
		    	wc_add_notice( __('Quantity limit reached for this item'), 'notice' );
		    }
		}
	}

	public function ovaemcptwoo_delete_tickets( $postid, $post ){
		if ( get_post_type( $postid ) !== 'ovaem_ticket_type' ) {
			return;
		}
		OVAEM_Event_Metaboxes::delete_all_tickets( $postid );
	}

	public function ovaemcptwoo_admin_order_item_thumbnail( $image, $item_id, $item ){
		$post_id = $item->get_product_id();
		if ( get_post_type( $post_id ) !== 'ovaem_ticket_type' ) {
			return;
		}
		$event_id 	= get_post_meta( $post_id, '_event_id', true);
		$image 		= get_the_post_thumbnail( $event_id, 'thumbnail' );
		return apply_filters( 'ovaemcptwoo_admin_order_item_thumbnail', $image, $item_id, $item );
	}

	public function ovaemcptwoo_before_order_itemmeta( $item_id, $item, $product ){
		$product_id = $product->get_id();
		$event_id 	= get_post_meta( $product_id, '_event_id', true );
			if ( get_post_type( $product_id ) === 'ovaem_ticket_type' ) {
		?>
			<br/>
			<a href="<?php echo esc_url( get_edit_post_link( $event_id ) ); ?>"><?php esc_html_e( 'View details', 'ovaem-events-manager' ); ?></a>
		<?php
		}
	}

	public function ovaemcptwoo_cart_item_name( $url, $cart_item, $cart_item_key ){
		$product_id = $cart_item['product_id'];
		$event_id 	= get_post_meta( $product_id, '_event_id', true );

		$url = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink( $product_id ) ), get_the_title( $product_id ) );

		if ( $event_id ) {
			$url = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink( $event_id ) ), get_the_title( $product_id ) );
		}
		
		return apply_filters( 'ovaemcptwoo_cart_item_name', $url, $cart_item, $cart_item_key );
	}

	public function ovaemcptwoo_order_item_permalink( $permalink, $item, $order ){
		$product_id = $item->get_product_id();
		if ( get_post_type( $product_id ) !== 'ovaem_ticket_type' ) {
			return;
		}
		$event_id 	= get_post_meta( $product_id, '_event_id', true );
		$permalink 	= get_permalink( $event_id );
		return apply_filters( 'ovaemcptwoo_order_item_permalink' ,$permalink, $item, $order );
	}

}






