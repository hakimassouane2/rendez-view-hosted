<?php if ( !defined( 'ABSPATH' ) ) exit();

class OVA_EVENTS_MANAGER_PAYPAL_PROCESS {
	
	private static $prefix = '';
	/**
	 * The Constructor
	 */
	public function __construct() {
		
		self::$prefix = OVAEM_Settings::$prefix;
		add_action( 'init', array( $this, 'ova_process_register_pay' ) );
		
	}


	public function ova_process_register_pay( ){
		

		/* Direct to paypal */
		if ( isset( $_POST['checkout_event'] ) && $_POST['checkout_event'] == 'yes' && $_POST['method_payment'] == 'paypal' ) {
			
			$ovaem_name = sanitize_text_field( $_POST['ovaem_name'] );
			$ovaem_phone = sanitize_text_field( $_POST['ovaem_phone'] );
			$ovaem_email = sanitize_text_field( $_POST['ovaem_email'] );
			$ovaem_address = sanitize_text_field( $_POST['ovaem_address'] );
			$ovaem_company = sanitize_text_field( $_POST['ovaem_company'] );
			$ovaem_desc = sanitize_text_field( $_POST['ovaem_desc'] );
			$order_id = sanitize_text_field( $_POST['id'] );
			
			// Cart
			$cart = $_SESSION['cart'];
			$list_item = '';
			$i = 1;
			foreach ( $_SESSION['cart'] as $id => $quantity ){

				$event = get_post((int)$id );
				$parse_id = explode('_', $id);
				$price = floatval(  $parse_id[1] );
				$cur = $parse_id[2];
				$package = urldecode($parse_id[3]);

				$list_item .= '&item_name_'.$i.'='.urlencode($event->post_title.'-'.$package);
				$list_item .= '&amount_'.$i.'='.urlencode($price);
				$list_item .= '&quantity_'.$i.'='.urlencode($quantity);

				$i++;
			}

			// Discount - Coupon
			$discount_cart = '';
			$coupon_arr = isset( $_SESSION['coupon'] ) ? OVAEM_Coupon::ovaem_check_coupon( $_SESSION['coupon'] ): array();
			if( $coupon_arr ){
				if( $coupon_arr['type'] == 'percent' ){
					$discount_cart = '&discount_rate_cart='.$coupon_arr['amount'];
				}else if( $coupon_arr['type'] == 'pieces' ){
					$discount_cart = '&discount_amount_cart='.$coupon_arr['amount'];
				}
			}

			// Pages setting
			$thanks_page_pay = OVAEM_Settings::thanks_page();
			$cancel_page_pay = OVAEM_Settings::checkout_cancel_page();
			$environment_pay = OVAEM_Settings::paypal_envi();
			$business_email_pay = OVAEM_Settings::paypal_busi_email();
			$paypal_cur = OVAEM_Settings::paypal_cur();

			$notify_url = OVA_PLUGIN_URI.'inc/update_order.php';

			$link_paypal = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		    
		    if($environment_pay == 'live'){
		        $link_paypal = "https://www.paypal.com/cgi-bin/webscr";
		    }else{
		        $link_paypal = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		    }



		    $paypal_url = $link_paypal.'?cmd=_cart&upload=1&business='
		    			.urlencode($business_email_pay)
		    			.$list_item
		    			.'&return='.urlencode($thanks_page_pay)
		    			.'&cancel_return='.urlencode($cancel_page_pay)
		    			.'&notify_url='.urlencode($notify_url)
		    			.'&custom='.urlencode($order_id)
		    			.'&currency_code='.urlencode($paypal_cur)
		    			.$discount_cart
		    			// .'&item_name='.urlencode($title_store_pay)
		    			
		    			;
		    
		    // Delete all item in cart
			@session_start();
			if( isset($_SESSION['cart']) ){
				unset($_SESSION['cart']);
			}
			if( isset($_SESSION['coupon']) ){
				unset($_SESSION['coupon']);	
			}
			session_write_close();
		    			
		   wp_redirect( $paypal_url ); exit;

		}

	}

	


}

new OVA_EVENTS_MANAGER_PAYPAL_PROCESS();






