<?php 
defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEM_Cart' ) ){
	class OVAEM_Cart{

		public function __construct(){

			

			// add_action( 'init', array( $this, 'mySessionStart' ) );

			add_action( 'init', array( $this, 'update_cart' ) );

			add_filter( 'query_vars', array( $this, 'insert_query_vars' ) );
			add_action( 'wp_logout', array( $this, 'mySessionEnd' ) );
			add_action( 'wp_login', array( $this, 'mySessionEnd' ) );


			/* Add Custom Page in My Account */
			add_action( 'init', array( $this, 'ovaem_support_endpoint') );
			add_filter( 'query_vars', array( $this, 'ovaem_support_query_vars'), 0 );
			add_filter( 'woocommerce_account_menu_items', array( $this, 'ovaem_support_link_my_account') );
			add_action( 'woocommerce_account_manage-booking_endpoint', array( $this, 'ovaem_support_content') );
		}

		
		public function insert_query_vars($vars) {
			array_push($vars, 'id'); //store id
			array_push($vars, 'action'); //store action (add, delele, update)
			return $vars;
		}

		public static function update_cart(){
			@session_start();
			
			$action = isset( $_REQUEST['action'] ) ? esc_attr( $_REQUEST['action'] ) : '';
			$id 	= isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';

			// Coupon
			$coupon_code = isset( $_REQUEST['coupon_code'] ) ? esc_attr( $_REQUEST['coupon_code'] ) : '';

			if ( $action ) { // IF has action is add or delete
				switch ( $action ) {
					case 'ovaem_add_to_cart':
						if ( $id ) {
							if ( isset( $_SESSION['cart'][$id] ) ) { // If isset cart, update quantity
								$quantity = $_SESSION['cart'][$id] + 1;
								$_SESSION['cart'][$id] = $quantity;
							} else {
								$quantity = 1; // else make new item with quantity = 1
								$_SESSION['cart'][$id] = esc_attr( $quantity ); //update sesstion again

							}
						}

						return $_SESSION['cart'];
						break;
					case 'delete':
						if ( isset( $_SESSION['cart'] ) && count( $_SESSION['cart'] ) > 0 ) {
							// Check and delete product by id
							if ( isset( $_SESSION['cart'][$id] ) ) unset( $_SESSION['cart'][$id] );
							return $_SESSION['cart'];
						 }else {
							unset( $_SESSION['cart'] );
							return false;
						}
						break;
					case 'update':
						if ( isset( $_POST['cart_update'] ) ) { // Update Cart
							if ( isset( $_POST['quantity'] ) ) {
								if ( isset( $_SESSION['cart'] ) && count( $_SESSION['cart'] ) == 0 ) unset( $_SESSION['cart'] ); // If cart is empty , delelte session 

								foreach ( $_POST['quantity'] as $id => $quantity ) { // loop to update quantity and cart
									if ( $quantity == 0 ) {
										unset($_SESSION['cart'][$id] );
									} else {
										$_SESSION['cart'][$id] = $quantity;
									}
								}

								return $_SESSION['cart'];
							}
						} elseif ( isset( $_POST['coupon_apply'] ) ) {
							// Add coupon
							if ( $coupon_code ) {
								$_SESSION['coupon'] = $coupon_code;
							} else {
								$_SESSION['coupon'] = '';
							}

							return $_SESSION['coupon'];	
						}
						break;	
				}
			}

			session_write_close();
		}


		// Get cart from Order ID
		public static function get_cart( $order_id ){
			$ovaem_order_cart = get_post_meta( $order_id, 'ovaem_order_cart', true );
			$coupon = get_post_meta( $order_id, 'ovaem_order_coupon', true );
			$coupon_arr = isset( $coupon ) ? OVAEM_Coupon::ovaem_check_coupon( $coupon, false ): array(); 
			$total = 0;
			$cart = '';

			//  First we list the items in the cart	
			foreach ( $ovaem_order_cart as $id => $quantity ){

				$parse_id = explode('_', $id);
				$event = get_post( intval( $parse_id[0] ) );

				$price = floatval( $parse_id[1] );
				$cur = $parse_id[2];
				$package = urldecode($parse_id[3]);
				$total += $price * $quantity;

			//  <img
			// 			src="'.esc_url( $image[0] ).'"
			// 			alt="product-img"
			// 			style="width: 70px; height: 70px; object-fit: cover"
			// 		/>

				$cart .= '
				<div
					style="
						display: flex;
						justify-content: space-between;
						border-bottom: 1px dashed #bfbfbf;
						padding: 1rem 0;
						align-items: center;
					"
				>
					<p style="color: #808080; font-size: 17px; width: 68%">
						'.esc_html( $event->post_title ).' - '.esc_html( $package ).' <b>X'.esc_attr($quantity).'</b>
					</p>
					<h3 style="width: 12%; text-align: right; font-size: 17px">'.ovaem_format_price($price * $quantity, $cur).'</h3>
      	</div>
				';
			}


			$total = OVAEM_Coupon::ovaem_total_with_coupon( $coupon_arr, $total, $cur );

			$cart .= '
				<div style="display: flex; align-items: flex-end; flex-direction: column">
					<div style="width: 50%; padding: 1rem 0; min-width: 300px">
						<div
							style="
								display: flex;
								align-items: center;
								justify-content: space-between;
							"
						>
							<span style="color: #808080; font-size: 17px; width: 68%"
								>Subtotal</span
							>
							<h4 style="text-align: right; font-size: 17px; margin: 0.5rem 0">
								'.wp_kses($total['html'],true).'
							</h4>
						</div>
						<div
							style="
								display: flex;
								align-items: center;
								justify-content: space-between;
								border-top: 1px dashed #bfbfbf;
								margin-top: 0.5rem;
								padding-top: 0.5rem;
							"
						>
							<span style="color: #808080; font-size: 17px; width: 68%"
								>Total</span
							>
							<h4 style="text-align: right; font-size: 21px; margin: 0.5rem 0">
								'.wp_kses($total['html'],true).'
							</h4>
						</div>
					</div>
				</div>
			';

			// $cart .= wp_kses($total['html'],true).'</strong> </td>
			// </tr>
			// </tfoot>

			// </table>';

			return apply_filters( 'ovaem_ft_get_cart', $cart, $order_id );
		}

		function mySessionStart() {
			
			if(!session_id()) {
				@session_start();
				@session_write_close();

			}
		}
		function mySessionEnd() {
			 if(session_id()) { @session_destroy (); }
		}


		/* Add Custom Page in My Account */
		// ------------------
		// 1. Register new endpoint to use for My Account page
		// Note: Resave Permalinks or it will give 404 error
		function ovaem_support_endpoint() {
			add_rewrite_endpoint( 'manage-booking', EP_ROOT | EP_PAGES );
		}

		// ------------------
		// 2. Add new query var
		function ovaem_support_query_vars( $vars ) {
			$vars[] = 'manage-booking';
			return $vars;
		}

		// ------------------
		// 3. Insert the new endpoint into the My Account menu
		function ovaem_support_link_my_account( $items ) {
			$items['manage-booking'] = __('Manage Booking', 'ovaem-events-manager');
			return $items;
		}

		// ------------------
		// 4. Add content to the new endpoint
		// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format
		function ovaem_support_content() {
			?>
			<h3 style="margin-top: 0;"><?php esc_html_e('Manage Booking', 'ovaem-events-manager'); ?></h3>
			<?php
			echo do_shortcode( '[ovaem_cart_manage_booking]' );
		}

	}
	new OVAEM_Cart();
}
