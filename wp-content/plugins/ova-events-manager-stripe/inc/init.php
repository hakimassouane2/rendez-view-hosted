<?php if ( !defined( 'ABSPATH' ) ) exit();

class OVA_EVENTS_MANAGER_STRIPE_CHECKOUT {
	
	private static $prefix = '';
	/**
	 * The Constructor
	 */
	public function __construct() {
		
		self::$prefix = OVAEM_Settings::$prefix;
		add_action( 'init', array( $this, 'ova_stripe_checkout_form' ) );
		
	}


	public function ova_stripe_checkout_form( ){
		

		/* Direct to paypal */
		if ( isset( $_POST['checkout_event'] ) && $_POST['checkout_event'] == 'yes' && $_POST['method_payment'] == 'stripe' ) {



				$order_id = $_POST['id'];
				$payer_email = '';
				
				// Total
				$subtotal = 0;
				foreach ( $_SESSION['cart'] as $id => $quantity ){
					
					$parse_id = explode('_', $id);
					$price = floatval( $parse_id[1] );
					$cur = $parse_id[2];
					$subtotal += $price * $quantity;
				}
				$coupon_arr = isset( $_SESSION['coupon'] ) ? OVAEM_Coupon::ovaem_check_coupon( $_SESSION['coupon'], true ): array();
				$total = OVAEM_Coupon::ovaem_total_with_coupon( $coupon_arr, $subtotal, $cur );

			
				\Stripe\Stripe::setApiKey( trim( OVAEM_Settings::stripe_payment_serect_key() ) );

				// Token is created using Checkout or Elements!
				// Get the payment token ID submitted by the form:
				$token = $_POST['stripeToken'];


				try {
					// Charge the user's card:
					$charge = \Stripe\Charge::create(array(
					  "amount" => $total['raw']*100,
					  "currency" => trim( OVAEM_Settings::stripe_payment_currency() ),
					  "description" => esc_html__( 'Booking Ticket', 'ovaem-events-manager-stripe' ),
					  "metadata" => array("order_id" => $order_id),
					  "source" => $token,
					));

					// Update order 
					OVA_Add_Order::ova_update_order( $order_id , 'Stripe', 'Completed', $charge->balance_transaction, $payer_email );

					// Delete all item in cart
				  unset( $_SESSION['cart'] );
		      unset( $_SESSION['coupon'] );

								
					// Delete all item in cart
					@session_start();
					if( isset($_SESSION['cart']) ){
						unset($_SESSION['cart']);
					}
					if( isset($_SESSION['coupon']) ){
						unset($_SESSION['coupon']);	
					}
					session_write_close();

					wp_redirect( OVAEM_Settings::thanks_page() );
					exit();
					
				} catch (Exception $e) {
					echo $e->getMessage();
					echo '<a href="'.OVAEM_Settings::checkout_page().'">'.esc_html__('Go to checkout page', 'ovaem-events-manager-stripe').'</a>';
					wp_redirect( home_url('/payment-error') );
					exit();
				}
			}

	}

	


}

new OVA_EVENTS_MANAGER_STRIPE_CHECKOUT();






