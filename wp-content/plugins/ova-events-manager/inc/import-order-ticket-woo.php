<?php if (!defined('ABSPATH')) {
	exit();
}

if ( !is_admin() ) {
	add_filter('woocommerce_email_attachments', 'ovaem_woocommerce_attachments', 10, 3);
	add_action('woocommerce_thankyou', 'ovaem_woocommerce_thankyou', 10, 1);
}

// Remove attachment files
function ovaem_woocommerce_thankyou( $order_id ) {
	if ( $order_id ) {
		$attachments = get_post_meta( $order_id, 'ovaem_attachments', true );

		if ( $attachments && is_array( $attachments ) ) {
			foreach( $attachments as $file ) {
				if ( file_exists( $file ) ) {
					unlink($file);
				}
			}
			delete_post_meta( $order_id, 'ovaem_attachments' );
		}
	}
}

function ovaem_woocommerce_attachments($attachments, $email_id, $order) {
	$order_woo_id = $order && is_object( $order ) ? $order->get_id() : 0;

   // get session order id that saved
	$attachments_pdf_arr = array();

	if ( isset( WC()->session ) && WC()->session->__isset('attachments_pdf_file') ) {
		$attachments_pdf_arr = WC()->session->get('attachments_pdf_file');
	} else {
		if ( $order_woo_id ) {
			$order_status = 'wc-' . $order->get_status();
			$woo_make_ticket_verify = OVAEM_Settings::woo_make_ticket_verify();
			$verify_ticket = in_array($order_status, $woo_make_ticket_verify[0]) ? 'true' : 'false';

			if ( $verify_ticket == 'true' && $order_woo_id ) {
				$order_ids = OVAEM_Ticket::get_order_by_woo_order($order_woo_id);

				if ( !empty( $order_ids ) && is_array( $order_ids ) ) {
					$order_id = isset( $order_ids[0] ) ? $order_ids[0] : '';

					if ( $order_id ) {
						$attachments_pdf_arr = OVAEM_Ticket::make_pdf_ticket_by_order($order_id);

						if ( $attachments_pdf_arr && is_array( $attachments_pdf_arr ) ) {
							foreach( $attachments_pdf_arr as $k => $file ) {
								$attachments_pdf_arr[$k] = str_replace( '\\', '/', $file );
							}
						}

						$ovaem_order_cart = get_post_meta($order_id, 'ovaem_order_cart', true);
						if ( $ovaem_order_cart ) {
							foreach ($ovaem_order_cart as $id => $quantity) {
								$parse_id = explode('_', $id);
								$event_id = intval($parse_id[0]);
								$package_id = $parse_id[4];
								$package_id = $package_id ? str_replace("ovaminus", "_", urldecode($package_id)) : '';

								if ( OVAEM_Settings::event_file_cer_attachment() == 'yes' ) {

									$cer_attach_array = get_cer_attach($event_id, $package_id);
									if ($cer_attach_array) {
										$attachments_pdf_arr[] = $cer_attach_array;
									}
								}
							}
						}
						
					}
				}
			}
		}
	}

	if (is_array($attachments_pdf_arr) && is_array($attachments)) {
		$pdf_fiels = array_merge_recursive($attachments, $attachments_pdf_arr);
	} else {
		$pdf_fiels = $attachments;
	}

	update_post_meta( $order_woo_id, 'ovaem_attachments', $attachments_pdf_arr, false );

	return $pdf_fiels;
}

function ovaem_import_order_ticket($orderid) {

	$order = wc_get_order($orderid);

	if ( isset( WC()->session ) && WC()->session->__isset('attachments_pdf_file')) {
		WC()->session->__unset('attachments_pdf_file');
	}

	$arr_related_event = array();
	$ovaem_order_cart = array();
	$order_items = $order->get_items();

	foreach ($order_items as $item) {

		$p_quantity = $item->get_quantity();
		$p_id = $item->get_product_id();
		$product = wc_get_product($p_id);
		$p_price = $product->get_price();

		$p_cur = get_woocommerce_currency_symbol();

		$slug_related_event = get_post_meta($p_id, 'ovaem_related_event', true);
		$arr_related_event[] = get_post_meta($p_id, 'ovaem_related_event', true);

		if( $slug_related_event ){
			$ovaem_related_event_package = urldecode(get_post_meta($p_id, 'ovaem_related_event_package', true));
			$ovaem_related_event_package_id = urlencode(get_post_meta($p_id, 'ovaem_related_event_package_id', true));
			$ovaem_related_event_package_id = $ovaem_related_event_package_id ? str_replace('_', 'ovaminus', $ovaem_related_event_package_id) : '';

			$event = get_page_by_path($slug_related_event, OBJECT, OVAEM_Settings::event_post_type_slug());
			$event_id = $event->ID;

			$cart_key = $event_id . '_' . $p_price . '_' . $p_cur . '_' . $ovaem_related_event_package . '_' . $ovaem_related_event_package_id;
			$ovaem_order_cart[$cart_key] = $p_quantity;
		}
		

		// if( !empty($ovaem_order_cart) ) break;
	}

	// Check order not product
	if(count(array_filter($arr_related_event)) == 0) {
		return;
	}

	$title = intval( current_time( 'timestamp' ) );
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

	$meta_input = array(
		'ovaem_order_id' => '',
		'ovaem_order_woo_id' => $orderid,
		'ovaem_name' => $ovaem_name,
		'ovaem_phone' => $ovaem_phone,
		'ovaem_email' => $ovaem_email,
		'ovaem_address' => $ovaem_address,
		'ovaem_company' => $ovaem_company,
		'ovaem_desc' => $ovaem_desc,
		'ovaem_event_status' => $order_status,
		'ovaem_order_cart' => $ovaem_order_cart,
		'ovaem_order_coupon' => $ovaem_order_coupon,
		'ovame_ticket_type' => 'Woo - <a target="_blank" href="' . home_url('/') . 'wp-admin/post.php?post=' . $orderid . '&action=edit">' . $orderid . '</a>',
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

		$woo_make_ticket_verify = OVAEM_Settings::woo_make_ticket_verify();

		$verify_ticket = in_array($order_status, $woo_make_ticket_verify[0]) ? 'true' : 'false';

      // Send mail for organizer
      if( $verify_ticket == 'true' ){

			$mail_to = OVAEM_Settings::paid_ticket_mail_to();
			$send_organizer_mail = in_array('organizer', $mail_to[0]) ? true : false;
			if ($send_organizer_mail) {

				$org_mail_array = array();

				$info_cart_array = array();

				$subject_org = esc_html__("Register Event Success", 'ovaem-events-manager');

				$body_org = OVAEM_Settings::paid_ticket_mail_template();
				$body_org = str_replace('[orderid]', '#' . $order_id, $body_org);
				$body_org = str_replace('[name]', $ovaem_name, $body_org);
				$body_org = str_replace('[phone]', $ovaem_phone, $body_org);
				$body_org = str_replace('[email]', $ovaem_email, $body_org);
				$body_org = str_replace('[address]', $ovaem_address, $body_org);
				$body_org = str_replace('[addition]', $ovaem_desc, $body_org);
				$body_org = str_replace('[company]', $ovaem_company, $body_org);
				$body_org = str_replace('[cart]', '', $body_org);

				$ovaem_order_cart_new = get_post_meta($order_id, 'ovaem_order_cart', true);
				foreach ($ovaem_order_cart_new as $id => $quantity) {

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

					$info_cart = $name_event . ' - ' . $package_event . ': ' . $quantity_event . ' x ' . $price_event . ' = ' . $total_event.$ticket_info_link_pass;

					$organizer_email = trim(get_post_meta($parse_id[0], OVAEM_Settings::$prefix . '_org_email', true));

					if ($organizer_email != '') {
						if (array_key_exists($organizer_email, $org_mail_array)) {
							$org_mail_array[$organizer_email] = $org_mail_array[$organizer_email] . '<br/>' . $info_cart;
						} else {
							$org_mail_array[$organizer_email] = $info_cart;
						}
					}

				}
				if ($org_mail_array) {
					foreach ($org_mail_array as $key_organizer_email => $val_info_cart) {

						$body_info = '';
						$body_info .= $body_org . $val_info_cart;

						OVAEM_Send_Mail::ovaem_sendmail($key_organizer_email, $subject_org, $body_info, array(''));
					}
				}

			}

		}

      // Make ticket
		OVAEM_Ticket::add_ticket($order_id, $verify_ticket, $orderid);

		if( $verify_ticket == 'true' && isset( WC()->session ) ){

			$attachments_pdf_file = OVAEM_Ticket::make_pdf_ticket_by_order($order_id);

	      	// Push attach certifi to attach_certifi array
			$ovaem_order_cart = get_post_meta($order_id, 'ovaem_order_cart', true);
			foreach ($ovaem_order_cart as $id => $quantity) {

				$parse_id = explode('_', $id);
				$event_id = intval($parse_id[0]);
				$package_id = $parse_id[4];
				$package_id = $package_id ? str_replace("ovaminus", "_", urldecode($package_id)) : '';

				if (OVAEM_Settings::event_file_cer_attachment() == 'yes') {

					$cer_attach_array = get_cer_attach($event_id, $package_id);
					if ($cer_attach_array) {
						$attachments_pdf_file[] = $cer_attach_array;
					}

				}
			}

			if (!is_admin()) {
				WC()->session->set('attachments_pdf_file', $attachments_pdf_file);
			}
		}
	}
}

// add the action
if ( ! is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	add_action('woocommerce_order_status_completed', 'ovaem_import_order_ticket', 10, 1);
	add_action('woocommerce_order_status_on-hold', 'ovaem_import_order_ticket', 10, 1);
	add_action('woocommerce_order_status_processing', 'ovaem_import_order_ticket', 10, 1);
	add_action('woocommerce_order_status_pending', 'ovaem_import_order_ticket', 10, 1);
}

/* Metabox For Woocommerce *************************************************************************/
/* Define the custom box */

if (is_admin()) {
	add_action('add_meta_boxes', 'ovaem_add_custom_box');
	add_action('save_post', 'ovaem_save_postdata');
}

/* Adds a box to the main column on the Post and Page edit screens */
function ovaem_add_custom_box() {
	$screens = array('product');
	foreach ($screens as $screen) {
		add_meta_box(
			'ovaem_sectionid',
			__('Related to Event', 'ovaem-events-manager'),
			'ovaem_inner_custom_box',
			$screen,
			'advanced',
			'high'
		);
	}
}

/* Prints the box content */
function ovaem_inner_custom_box($post) {

   // Use nonce for verification
	wp_nonce_field(plugin_basename(__FILE__), 'ovaem_noncename');


	global $post;

	$ovaem_related_event = get_post_meta($post->ID, 'ovaem_related_event', $single = true);
	$ovaem_related_event_package = get_post_meta($post->ID, 'ovaem_related_event_package', $single = true);
	$ovaem_related_event_package_id = get_post_meta($post->ID, 'ovaem_related_event_package_id', $single = true);

	$html = '<label>' . esc_html__('Choose an event', 'ovaem-events-manager') . '&nbsp;<select name="ovaem_related_event">';
	$html .= '<option value="">' . esc_html__('Please choose event', 'ovaem-events-manager') . '</option>';


	$events =  OVAEM_Get_Data::ovaem_get_all_events( 'ASC', -1 );
	foreach ($events as $key => $id) {

		$post = get_post($id);
		$slug = apply_filters( 'editable_slug', $post->post_name, $post );
		$title = get_the_title( $id );

		$selected = ($slug == $ovaem_related_event) ? 'selected' : '';
		$html .= '<option value="' . $slug . '" ' . $selected . ' >' . $title . '</option>';

		
	}


	$html .= '</select></label>';
	$html .= '<br/><br/>';
	$html .= '<label>' . esc_html__('Package Name', 'ovaem-events-manager') . '&nbsp;<input type="text" value="' . $ovaem_related_event_package . '" name="ovaem_related_event_package" /></label>';
	$html .= '<br/><br/>';
	$html .= '<label>' . esc_html__('Package ID.', 'ovaem-events-manager') . '&nbsp;<input type="text" value="' . $ovaem_related_event_package_id . '" name="ovaem_related_event_package_id" /></label>' . esc_html__('You have to insert package id in above event', 'ovaem-events-manager');

	echo $html;

}

/* When the post is saved, saves our custom data */
function ovaem_save_postdata($post_id) {

   // First we need to check if the current user is authorised to do this action.
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

   // Secondly we need to check if the user intended to change this value.
	if (!isset($_POST['ovaem_noncename']) || !wp_verify_nonce($_POST['ovaem_noncename'], plugin_basename(__FILE__))) {
		return;
	}
  

   //if saving in a custom table, get post_ID
	$post_ID = $_POST['post_ID'];

   //sanitize user input
	$ovaem_related_event = sanitize_text_field($_POST['ovaem_related_event']);
	$ovaem_related_event_package = sanitize_text_field($_POST['ovaem_related_event_package']);
	$ovaem_related_event_package_id = sanitize_text_field($_POST['ovaem_related_event_package_id']);
	
	update_post_meta($post_ID, 'ovaem_related_event', $ovaem_related_event);
	update_post_meta($post_ID, 'ovaem_related_event_package', $ovaem_related_event_package);
	update_post_meta($post_ID, 'ovaem_related_event_package_id', $ovaem_related_event_package_id);
}


// add_action( 'woocommerce_email_before_order_table', 'ovaem_email_before_order_table', 10, 4 );	
function ovaem_email_before_order_table( $order, $sent_to_admin, $plain_text, $email ) { 

		$addition_body_email = '';

		$order_status = 'wc-' . $order->get_status();

		$woo_make_ticket_verify = OVAEM_Settings::woo_make_ticket_verify();
		
		if( in_array( $order_status, $woo_make_ticket_verify[0] ) ){

			$order_items = $order->get_items();

			foreach ($order_items as $item) {

				
				$p_id = $item->get_product_id();
				$product = wc_get_product($p_id);
				
				$slug_related_event = get_post_meta($p_id, 'ovaem_related_event', true);
				

				$package_id = urlencode(get_post_meta($p_id, 'ovaem_related_event_package_id', true));
				$package_id = $package_id ? str_replace("ovaminus", "_", urldecode($package_id)) : '';

				$event = get_page_by_path($slug_related_event, OBJECT, OVAEM_Settings::event_post_type_slug());
				$event_id = $event->ID;

				// Get ticket info link, password
				$info_ticket = OVAEM_Get_Data::ovaem_get_info_ticket( intval( $event_id ), $package_id );

				if( $info_ticket ){
	              
	              $addition_body_email .= '<br/>'.get_the_title( $event_id ).': '.$info_ticket['ticket_name'];

	              $addition_body_email .= ( isset( $info_ticket['link'] ) && $info_ticket['link'] ) ? '<br/>'.esc_html__( 'Link:', 'ovaem-events-manager' ).' '.$info_ticket['link'] : '';

	              $addition_body_email .= ( isset( $info_ticket['password'] ) && $info_ticket['password'] ) ? '<br/>'.esc_html__( 'Password:', 'ovaem-events-manager' ).' '.$info_ticket['password'] : '';

	           	}

				
			}

		}
		if( $addition_body_email ){
			echo $addition_body_email.'<br/><br/>';	
		}
		
	

}