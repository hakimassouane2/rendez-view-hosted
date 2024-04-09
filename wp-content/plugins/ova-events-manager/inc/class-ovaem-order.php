<?php if (!defined('ABSPATH')) {
	exit();
}

if (!class_exists('OVA_Add_Order')) {
	class OVA_Add_Order {

		public function __construct() {

			add_action('wp_ajax_ova_add_order_info', array($this, 'ova_add_order_info'));
			add_action('wp_ajax_nopriv_ova_add_order_info', array($this, 'ova_add_order_info'));

			add_filter('ova_list_payment_gateway', array($this, 'ova_list_payment_gateway'), 10, 0);

		}

		public static function ova_add_order_info() {

      // Bail if we're doing an auto save
			if (empty($_POST) && defined('DOING_AJAX') && DOING_AJAX) {
				return;
			}

      // Check security ajax
			if (!check_ajax_referer( 'ajax_checkout_security' , 'security' )) {
				echo 'fase';
				return false;
			}

			$data = $_POST['data'];

			$title = intval( current_time( 'timestamp' ) );
			$ovaem_name = $data['ovaem_name'] ? sanitize_text_field($data['ovaem_name']) : '';
			$ovaem_phone = $data['ovaem_phone'] ? sanitize_text_field($data['ovaem_phone']) : '';
			$ovaem_email = $data['ovaem_email'] ? sanitize_text_field($data['ovaem_email']) : '';
			$ovaem_address = $data['ovaem_address'] ? sanitize_text_field($data['ovaem_address']) : '';
			$ovaem_company = $data['ovaem_company'] ? sanitize_text_field($data['ovaem_company']) : '';
			$ovaem_desc = $data['ovaem_desc'] ? sanitize_text_field($data['ovaem_desc']) : '';
			$ovaem_order_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : '';
			$ovaem_order_coupon = isset($_SESSION['coupon']) ? $_SESSION['coupon'] : '';
			$post_data['post_type'] = 'event_order';
			$post_data['post_title'] = $title;
			$post_data['post_status'] = 'publish';

			// Add Customer is Author of Order
			if( is_user_logged_in() ){
			  $post_data['post_author'] = get_current_user_id();
			}

         // Order id is empty
			if ($ovaem_name == '' || $ovaem_email == '') {
				echo 'false';
				return false;
			}

			$meta_input = array(
				'ovaem_order_id' => '',
				'ovaem_name' => $ovaem_name,
				'ovaem_phone' => $ovaem_phone,
				'ovaem_email' => $ovaem_email,
				'ovaem_address' => $ovaem_address,
				'ovaem_company' => $ovaem_company,
				'ovaem_desc' => $ovaem_desc,
				'ovaem_event_status' => 'Pending',
				'ovaem_order_cart' => $ovaem_order_cart,
				'ovaem_order_coupon' => $ovaem_order_coupon,
				'ovaem_order_language' => get_locale(),
				'ovame_ticket_type' => 'Paid',
				'ovaem_payment_gateway' => '',
			);

			$post_data['meta_input'] = $meta_input;

			if ($order_id = wp_insert_post($post_data, true)) {

            // Update Order ID to metabox
				update_post_meta($order_id, 'ovaem_order_id', $order_id, '');

            // Update Post Title to Order Id
				$update_post = array(
					'ID' => $order_id,
					'post_title' => $order_id,
					'post_name' => $order_id,
				);
				wp_update_post($update_post);

            // Add Ticket
				OVAEM_Ticket::add_ticket($order_id);
				echo $order_id;
				wp_die();

			} else {
				echo 'false';
				wp_die();
			}

		}

      // Update Status, Gateway Order
		public static function ova_update_order($order_id, $gateway = '', $payment_status = '', $transaction_id = '', $payer_email = '') {
			update_post_meta($order_id, 'ovaem_event_status', $payment_status, 'Pending');
			update_post_meta($order_id, 'ovaem_payment_gateway', $gateway, '');
			update_post_meta($order_id, 'ovaem_transaction_id', $transaction_id, '');

      // Order Info
			$order_id = get_post_meta($order_id, 'ovaem_order_id', true);
			$name = get_post_meta($order_id, 'ovaem_name', true);
			$email = get_post_meta($order_id, 'ovaem_email', true);
			$phone = get_post_meta($order_id, 'ovaem_phone', true);
			$address = get_post_meta($order_id, 'ovaem_address', true);
			$company = get_post_meta($order_id, 'ovaem_company', true);
			$desc = get_post_meta($order_id, 'ovaem_desc', true);
			$order_date = get_post_time("Y-m-d H:i:s", false, $order_id, true );

      // Send mail for Admin, Attendees
			$mail_to = OVAEM_Settings::paid_ticket_mail_to();
			$send_mail_to = array();
			$admin_mail = in_array('admin', $mail_to[0]) ? get_option('admin_email') : '';
			$client_mail = in_array('client', $mail_to[0]) ? $email : '';

			if ($admin_mail) {
				$send_mail_array[] = $admin_mail;
			}
			if ($client_mail) {
				$send_mail_array[] = $client_mail;
			}
			if ($payer_email && ($client_mail != $payer_email)) {
				$send_mail_array[] = $payer_email;
			}

			$send_mail_to_multi_obj = !empty($send_mail_array) ? implode(',', $send_mail_array) : '';

      // Cart
			$cart = OVAEM_Cart::get_cart($order_id);
			$body = OVAEM_Settings::paid_ticket_mail_template();
			$body = str_replace('[orderid]', '#' . $order_id, $body);
			$body = str_replace('[client_name]', $name, $body);
			$body = str_replace('[phone]', $phone, $body);
			$body = str_replace('[email]', $email, $body);
			$body = str_replace('[address]', $address, $body);
			$body = str_replace('[addition]', $desc, $body);
			$body = str_replace('[company]', $company, $body);
			$body = str_replace('[cart]', $cart, $body);
			$body = str_replace('[order_date]', $order_date, $body);
			$body = str_replace('[transaction_id]', $transaction_id, $body);
			$body = str_replace('[payment_method]', $gateway, $body);

			$current_locale = get_locale();

			if ($current_locale == 'fr_FR') {
				$subject = esc_html__("[Rendez-view] Confirmation de votre achat", 'ovaem-events-manager');
				$body = str_replace('Here is your receipt', 'Voici votre reçu', $body);
				$body = str_replace('Your order from', 'Votre commande du', $body);
				$body = str_replace('Order number', 'Numéro de commande', $body);
				$body = str_replace('Payment option', 'Moyen de paiement', $body);
				$body = str_replace('Delivery address', 'Adresse de livraison', $body);
				$body = str_replace('Billing address', 'Adresse de facturation', $body);
				$body = str_replace('Products', 'Billets', $body);
				$body = str_replace('Quantity', 'Quantité', $body);
				$body = str_replace('Payment Method', 'Moyen de paiement', $body);
				$body = str_replace('Subtotal', 'Sous-total', $body);
				$body = str_replace('[top_text]', 'Vous trouverez ci-dessous un bref résumé de votre achat. Vous trouverez votre billet au format PDF ou QR code joint à ce mail. Veuillez le conserver précieusement et l\'apporter avec vous lors de l\'événement.', $body);
				$body = str_replace('[bottom_text]', 'N\'hésitez pas à nous contacter si vous avez des questions ! Nous serions heureux de vous aider. Il vous suffit de nous contacter via', $body);
			} else {
				$subject = esc_html__("[Rendez-view] Confirmation of your purchase", 'ovaem-events-manager');
				$body = str_replace('[top_text]', 'Below you\'ll find a brief summary of your charge. You will find your ticket in PDF or QR code format attached to this mail. Please keep it safe and bring it with you to the event.', $body);
				$body = str_replace('[bottom_text]', 'Feel free to contact us if you have any questions or comments! We are happy to help. Just contact us via', $body);
			}
			
    	// Instanciation of inherited class
			$send_organizer_mail = in_array('organizer', $mail_to[0]) ? true : false;
			if ($send_organizer_mail) {
				$org_mail_array = array();
				$info_cart_array = array();

				$subject_org = esc_html__("Register Event Success", 'ovaem-events-manager');

				$body_org = OVAEM_Settings::paid_ticket_mail_template();
				$body_org = str_replace('[orderid]', '#' . $order_id, $body_org);
				$body_org = str_replace('[name]', $name, $body_org);
				$body_org = str_replace('[phone]', $phone, $body_org);
				$body_org = str_replace('[email]', $email, $body_org);
				$body_org = str_replace('[address]', $address, $body_org);
				$body_org = str_replace('[addition]', $desc, $body_org);
				$body_org = str_replace('[company]', $company, $body_org);
				$body_org = str_replace('[transaction_id]', $transaction_id, $body_org);
				$body_org = str_replace('[cart]', '', $body_org);

				$ovaem_order_cart = get_post_meta($order_id, 'ovaem_order_cart', true);
				foreach ($ovaem_order_cart as $id => $quantity) {

					$parse_id = explode('_', $id);
					$event = get_post(intval($parse_id[0]));
					$price = floatval($parse_id[1]);
					$cur = $parse_id[2];

					// Get ticket info link, password
					$package_id = isset($parse_id[4]) ? str_replace( "ovaminus", "_", urldecode($parse_id[4]) ) : '';
					$info_ticket = OVAEM_Get_Data::ovaem_get_info_ticket( intval( $parse_id[0] ), $package_id );

	        $ticket_info_link_pass = '';
					if( $info_ticket ) {
						$ticket_info_link_pass .= '<br/>'.$info_ticket['ticket_name'];
	          $ticket_info_link_pass .= ( isset( $info_ticket['link'] ) && $info_ticket['link'] ) ? '<br/>'.esc_html__( 'Link:', 'ovaem-events-manager' ).' '.$info_ticket['link'] : '';
						$ticket_info_link_pass .= ( isset( $info_ticket['password'] ) && $info_ticket['password'] ) ? '<br/>'.esc_html__( 'Password:', 'ovaem-events-manager' ).' '.$info_ticket['password'] : '';
					}

					$name_event = '<strong>' . $event->post_title . '</strong>';
					$package_event = '<strong>' . urldecode($parse_id[3]) . '</strong>';
					$quantity_event = $quantity;
					$price_event = ovaem_format_price($price, $cur);
					$total_event = ovaem_format_price($price * $quantity, $cur);
					$info_cart = '<br/>'.$name_event . ' - ' . $package_event . ': ' . $quantity_event . ' x ' . $price_event . ' = ' . $total_event. $ticket_info_link_pass;
					$organizer_email = get_the_author_meta('user_email', $event->post_author);

					if( $org_mail_array[$organizer_email] ){
						$org_mail_array[$organizer_email] .= $info_cart;	
					} else {
						$org_mail_array[$organizer_email] = $info_cart;	
					}
				}

				if ($org_mail_array) {
					foreach ($org_mail_array as $key_organizer_email => $val_info_cart) {
						$body_info = $body_org . $val_info_cart;
						OVAEM_Send_Mail::ovaem_sendmail($key_organizer_email, $subject_org, $body_info, array(''));
					}
				}
			}

			if ($send_mail_to_multi_obj) {
        // Verify Ticket have Order ID
				OVAEM_Ticket::verify_pdf_ticket($order_id);
        // Make PDF Ticket From Code List by Order ID
				$ticket_pdf = OVAEM_Ticket::make_pdf_ticket_by_order($order_id);
				$total_ticket_pdf = count($ticket_pdf);

        // Push attach certifi to pdf ticket array
				$ovaem_order_cart = get_post_meta($order_id, 'ovaem_order_cart', true);
				foreach ($ovaem_order_cart as $id => $quantity) {
					$parse_id = explode('_', $id);
					$event_id = intval($parse_id[0]);
					$package_id = $parse_id[4];
					$package_id = isset($package_id) ? str_replace("ovaminus", "_", urldecode($package_id)) : '';

					if (OVAEM_Settings::event_file_cer_attachment() == 'yes') {
						$cer_attach_array = get_cer_attach($event_id, $package_id);
						if ($cer_attach_array) {
							$ticket_pdf[] = $cer_attach_array;
						}
					}

					// Get ticket info link, password
					$info_ticket = OVAEM_Get_Data::ovaem_get_info_ticket( intval( $parse_id[0] ), $package_id );
					if( $info_ticket ) {    
						// $body .= '<br/>'.$info_ticket['ticket_name'];
						$body .= ( isset( $info_ticket['link'] ) && $info_ticket['link'] ) ? '<br/>'.esc_html__( 'Link:', 'ovaem-events-manager' ).' '.$info_ticket['link'] : '';
						$body .= ( isset( $info_ticket['password'] ) && $info_ticket['password'] ) ? '<br/>'.esc_html__( 'Password:', 'ovaem-events-manager' ).' '.$info_ticket['password'] : '';
					}
				}

				if (OVAEM_Send_Mail::ovaem_sendmail($send_mail_to_multi_obj, $subject, $body, $ticket_pdf)) {
          // Delete PDF Ticket file in server
					foreach( $ticket_pdf as $key => $value ) {
						if ($key < $total_ticket_pdf) {
							unlink($value);
						}
					}
				} else {
					ovaem_get_template('register-send-mail.php');
				}
			}
		}

		public function ova_list_payment_gateway() {
			$html = '<ul>';

			$checkout_payment_default = OVAEM_Settings::checkout_payment_default();
			$offline_selected = ($checkout_payment_default == 'offline') ? 'checked' : '';
			$paypal_selected = ($checkout_payment_default == 'paypal') ? 'checked' : '';
			$stripe_selected = ($checkout_payment_default == 'stripe') ? 'checked' : '';

			if (OVAEM_Settings::offline_payment_use() == 'true') {

				$html .= '<li><input ' . $offline_selected . ' type="radio" name="method_payment" value="offline" /><span>' . esc_html__('Offline Payment', 'ovaem-events-manager') . '</span>';
				$html .= '<div class="info">' . OVAEM_Settings::offline_payment_info() . '</div>';
				$html .= '</li>';
			}

			// if (class_exists('OVA_EVENTS_MANAGER_PAYPAL') && is_plugin_active('ova-events-manager-paypal/ova-events-manager-paypal.php')) {
			// 	$html .= '<li>';
			// 	$html .= '<input type="radio" ' . $paypal_selected . ' name="method_payment" value="paypal" /><span>' . esc_html__('PayPal', 'ovaem-events-manager') . '</span>';
			// 	$html .= '<div class="info">' . OVAEM_Settings::paypal_info() . '</div>';
			// 	$html .= '</li>';
			// }

			if (class_exists('OVA_EVENTS_MANAGER_STRIPE') && is_plugin_active('ova-events-manager-stripe/ova-events-manager-stripe.php') && OVAEM_Settings::stripe_payment_public_key() != '' && OVAEM_Settings::stripe_payment_serect_key() != '') {
				global $wp;
				$html .= '<li>';
				$html .= '<input type="radio" ' . $stripe_selected . ' name="method_payment" value="stripe" /><span>' . esc_html__('Stripe', 'ovaem-events-manager') . '</span>';
				$html .= '<div class="info">';
				$html .= OVAEM_Settings::stripe_info();
				$html .= '<div class="form-row">
				<label for="card-element">
				Credit or debit card
				</label>
				<div id="card-element">
				<!-- a Stripe Element will be inserted here. -->
				</div>

				<!-- Used to display Element errors -->
				<div id="card-errors" role="alert"></div>
				</div>';
				$html .= '</div>';
				$html .= '</li>';
			}

			$html .= '</ul>';

			return $html;
		}

		public static function ova_process_offline_proccess() {

			/* Direct to paypal */
			if (isset($_POST['checkout_event']) && $_POST['checkout_event'] == 'yes' && $_POST['method_payment'] == 'offline') {

            // Pages setting
			$thanks_page_pay 	= OVAEM_Settings::thanks_page();
			$cancel_page_pay 	= OVAEM_Settings::checkout_cancel_page();
			$checkout_page 		= OVAEM_Settings::checkout_page();

            // Bail if we're doing an auto save
			if (empty($_POST) && defined('DOING_AJAX') && DOING_AJAX) {
				return;
			}

            // if our nonce isn't there, or we can't verify it, bail
				if (!isset($_POST['ova_checkout_events_nonce']) || !wp_verify_nonce($_POST['ova_checkout_events_nonce'], 'ova_checkout_events_nonce')) {
					return;
				}

				if ( isset( $_REQUEST['g-recaptcha-response'] ) ) {
					$response 			= $_REQUEST['g-recaptcha-response'];
					$secret 			= OVAEM_Settings::captcha_serectkey();
					$check_recapcha 	= ovaem_recapcha_verify( $response, $secret );
					if ( ! $check_recapcha ) {
						$redirect = add_query_arg( array( 'err'=>'recapcha' ), $checkout_page );
						wp_redirect( $redirect);
						exit();
					}
				}

				$ovaem_order_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : '';
				$ovaem_order_coupon = isset($_SESSION['coupon']) ? $_SESSION['coupon'] : '';
				

				$ovaem_name = $_POST['ovaem_name'] ? sanitize_text_field($_POST['ovaem_name']) : '';
				$ovaem_phone = $_POST['ovaem_phone'] ? sanitize_text_field($_POST['ovaem_phone']) : '';
				$ovaem_email = $_POST['ovaem_email'] ? sanitize_text_field($_POST['ovaem_email']) : '';
				$ovaem_address = $_POST['ovaem_address'] ? sanitize_text_field($_POST['ovaem_address']) : '';
				$ovaem_company = $_POST['ovaem_company'] ? sanitize_text_field($_POST['ovaem_company']) : '';
				$ovaem_desc = $_POST['ovaem_desc'] ? sanitize_text_field($_POST['ovaem_desc']) : '';
				$order_id = $_POST['id'] ? sanitize_text_field($_POST['id']) : '';

				if ($ovaem_name == '' || $ovaem_email == '') {
					echo 'false';
					return false;
				}

				$meta_input = array(
					'ovaem_order_id' => '',
					'ovaem_name' => $ovaem_name,
					'ovaem_phone' => $ovaem_phone,
					'ovaem_email' => $ovaem_email,
					'ovaem_address' => $ovaem_address,
					'ovaem_company' => $ovaem_company,
					'ovaem_desc' => $ovaem_desc,
					'ovaem_event_status' => 'Completed',
					'ovaem_order_cart' => $ovaem_order_cart,
					'ovaem_order_coupon' => $ovaem_order_coupon,
					'ovame_ticket_type' => 'Offline',
					'ovaem_payment_gateway' => 'Offline',
				);

				$title = current_time( 'timestamp' );
				$post_data['post_type'] = 'event_order';
				$post_data['post_title'] = $title;
				$post_data['post_status'] = 'publish';
				$post_data['meta_input'] = $meta_input;

				// Add Customer is Author of Order
				if( is_user_logged_in() ){
				  $post_data['post_author'] = get_current_user_id();
				}

				if ($order_id = wp_insert_post($post_data, true)) {

               		// Update Order ID to metabox
					update_post_meta($order_id, 'ovaem_order_id', $order_id, '');

               		// Update Post Title to Order Id
					$update_post = array(
						'ID' => $order_id,
						'post_title' => $order_id,
						'post_name' => $order_id,
					);
					wp_update_post($update_post);

					do_action( 'ovaem_after_save_order_event_offline', $order_id, $_POST );

               		// Add Ticket
					OVAEM_Ticket::add_ticket($order_id);

					// Delete all item in cart
					@session_start();
					if( isset($_SESSION['cart']) ){
						unset($_SESSION['cart']);
					}
					if( isset($_SESSION['coupon']) ){
						unset($_SESSION['coupon']);	
					}
					session_write_close();


					if (self::ova_offline_sendmail($order_id)) {
						
						wp_redirect($thanks_page_pay);
						return true;
					}

					

				} else {
					wp_redirect($cancel_page_pay);
					return false;
				}

			}
			return true;

		}

		public static function ova_offline_sendmail($order_id, $payer_email = '') {

         // Order Info
			$order_id = get_post_meta($order_id, 'ovaem_order_id', true);
			$name = get_post_meta($order_id, 'ovaem_name', true);
			$email = get_post_meta($order_id, 'ovaem_email', true);
			$phone = get_post_meta($order_id, 'ovaem_phone', true);
			$address = get_post_meta($order_id, 'ovaem_address', true);
			$company = get_post_meta($order_id, 'ovaem_company', true);
			$desc = get_post_meta($order_id, 'ovaem_desc', true);

         // Send mail for Admin, Attendees
			$mail_to = OVAEM_Settings::paid_ticket_mail_to();
			$send_mail_to = array();
			$admin_mail = in_array('admin', $mail_to[0]) ? get_option('admin_email') : '';
			$client_mail = in_array('client', $mail_to[0]) ? $email : '';

			if ($admin_mail) {
				$send_mail_array[] = $admin_mail;
			}
			if ($client_mail) {
				$send_mail_array[] = $client_mail;
			}
			if ($payer_email && ($client_mail != $payer_email)) {
				$send_mail_array[] = $payer_email;
			}

			$send_mail_to_multi_obj = !empty($send_mail_array) ? implode(',', $send_mail_array) : '';

         // Cart
			$cart = OVAEM_Cart::get_cart($order_id);

			$subject = esc_html__("Register Event Success", 'ovaem-events-manager');
			$body = OVAEM_Settings::paid_ticket_mail_template();
			$body = str_replace('[orderid]', '#' . $order_id, $body);
			$body = str_replace('[name]', $name, $body);
			$body = str_replace('[phone]', $phone, $body);
			$body = str_replace('[email]', $email, $body);
			$body = str_replace('[address]', $address, $body);
			$body = str_replace('[addition]', $desc, $body);
			$body = str_replace('[company]', $company, $body);
			$body = str_replace('[cart]', $cart, $body);
			$body = str_replace('[transaction_id]', $order_id, $body);

         // Send mail to each organizer
			$send_organizer_mail = in_array('organizer', $mail_to[0]) ? true : false;
			if ($send_organizer_mail) {

				$org_mail_array = array();

				$info_cart_array = array();

				$subject_org = esc_html__("Register Event Success", 'ovaem-events-manager');

				$body_org = OVAEM_Settings::paid_ticket_mail_template();
				$body_org = str_replace('[orderid]', '#' . $order_id, $body_org);
				$body_org = str_replace('[name]', $name, $body_org);
				$body_org = str_replace('[phone]', $phone, $body_org);
				$body_org = str_replace('[email]', $email, $body_org);
				$body_org = str_replace('[address]', $address, $body_org);
				$body_org = str_replace('[addition]', $desc, $body_org);
				$body_org = str_replace('[company]', $company, $body_org);
				$body_org = str_replace('[cart]', '', $body_org);
				$body_org = str_replace('[transaction_id]', $order_id, $body_org);

				$ovaem_order_cart = get_post_meta($order_id, 'ovaem_order_cart', true);
				foreach ($ovaem_order_cart as $id => $quantity) {

					$parse_id = explode('_', $id);
					$event = get_post(intval($parse_id[0]));
					$price = floatval($parse_id[1]);
					$cur = $parse_id[2];


					// Get ticket info link, password
					$package_id = isset($parse_id[4]) ? str_replace( "ovaminus", "_", urldecode($parse_id[4]) ) : '';
					$info_ticket = OVAEM_Get_Data::ovaem_get_info_ticket( intval( $parse_id[0] ), $package_id );
					
					$ticket_info_link_pass = '';
					if( $info_ticket ){
	                  
	                  $ticket_info_link_pass .= '<br/>'.$info_ticket['ticket_name'];
	                  $ticket_info_link_pass .= ( isset( $info_ticket['link'] ) && $info_ticket['link'] ) ? '<br/>'.esc_html__( 'Link:', 'ovaem-events-manager' ).' '.$info_ticket['link'] : '';

	                  $ticket_info_link_pass .= ( isset( $info_ticket['password'] ) && $info_ticket['password'] ) ? '<br/>'.esc_html__( 'Password:', 'ovaem-events-manager' ).' '.$info_ticket['password'] : '';

	               	}

					$name_event = '<strong>' . $event->post_title . '</strong>';
					$package_event = '<strong>' . urldecode($parse_id[3]) . '</strong>';
					$quantity_event = $quantity;
					$price_event = ovaem_format_price($price, $cur);
					$total_event = ovaem_format_price($price * $quantity, $cur);

					$info_cart = '<br/>'.$name_event . ' - ' . $package_event . ': ' . $quantity_event . ' x ' . $price_event . ' = ' . $total_event. $ticket_info_link_pass;

					$organizer_email = get_the_author_meta('user_email', $event->post_author);

					if( $org_mail_array[$organizer_email] ){
						$org_mail_array[$organizer_email] .= $info_cart;	
					}else{
						$org_mail_array[$organizer_email] = $info_cart;	
					}
					

				}
				if ($org_mail_array) {
					foreach ($org_mail_array as $key_organizer_email => $val_info_cart) {

						$body_info = $body_org . $val_info_cart;

						OVAEM_Send_Mail::ovaem_sendmail($key_organizer_email, $subject_org, $body_info, array(''));
					}
				}

			}

         // Instanciation of inherited class
			if ($send_mail_to_multi_obj) {

            // Verify Ticket have Order ID
				if (OVAEM_Settings::offline_payment_verify_ticket() == 'true') {
					OVAEM_Ticket::verify_pdf_ticket($order_id);
				}

            // Make PDF Ticket From Code List by Order ID
				$ticket_pdf = OVAEM_Ticket::make_pdf_ticket_by_order($order_id);
				$total_ticket_pdf = count($ticket_pdf);

            // Push attach certifi to pdf ticket array
				$ovaem_order_cart = get_post_meta($order_id, 'ovaem_order_cart', true);
				foreach ($ovaem_order_cart as $id => $quantity) {

					$parse_id = explode('_', $id);
					$event_id = intval($parse_id[0]);
					$package_id = $parse_id[4];
					$package_id = isset($package_id) ? str_replace("ovaminus", "_", urldecode($package_id)) : '';

					if (OVAEM_Settings::event_file_cer_attachment() == 'yes') {

						$cer_attach_array = get_cer_attach($event_id, $package_id);
						if ($cer_attach_array) {
							$ticket_pdf[] = $cer_attach_array;
						}

					}

					// Get ticket info link, password
					$info_ticket = OVAEM_Get_Data::ovaem_get_info_ticket( intval( $parse_id[0] ), $package_id );

					if( $info_ticket ){
	                  
	                  $body .= '<br/>'.$info_ticket['ticket_name'];
	                  $body .= ( isset( $info_ticket['link'] ) && $info_ticket['link'] ) ? '<br/>'.esc_html__( 'Link:', 'ovaem-events-manager' ).' '.$info_ticket['link'] : '';

	                  $body .= ( isset( $info_ticket['password'] ) && $info_ticket['password'] ) ? '<br/>'.esc_html__( 'Password:', 'ovaem-events-manager' ).' '.$info_ticket['password'] : '';

	               	}

				}

				if (OVAEM_Send_Mail::ovaem_sendmail($send_mail_to_multi_obj, $subject, $body, $ticket_pdf)) {

               		// Delete PDF Ticket file in server
					foreach( $ticket_pdf as $key => $value ) {
						if( $key < $total_ticket_pdf ) {
							if ( file_exists( $value ) ) unlink( $value );
						}
					}

				} else {
					ovaem_get_template('register-send-mail.php');
				}

			}
			return true;

		}

	}
	new OVA_Add_Order();
}
