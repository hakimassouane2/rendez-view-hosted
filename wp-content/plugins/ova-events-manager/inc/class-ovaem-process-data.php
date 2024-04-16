<?php
defined('ABSPATH') || exit();

if (!class_exists('OVAEM_Process_Data')) {
   class OVAEM_Process_Data {

   	public static function save_order_event($post_id, $post_data) {

         // Bail if we're doing an auto save
         if (empty($_POST) && defined('DOING_AJAX') && DOING_AJAX) {
            return;
         }

         // if our nonce isn't there, or we can't verify it, bail
         if (!isset($_POST['ova_regis_events_nonce']) || !wp_verify_nonce($_POST['ova_regis_events_nonce'], 'ova_regis_events_nonce')) {
            return;
         }
         
         /**
          * Captcha
          */
         if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) {
            $response         = $_POST['g-recaptcha-response'];
            $secret           = OVAEM_Settings::captcha_serectkey();
            $check_recapcha   = ovaem_recapcha_verify( $response, $secret );
            if ( ! $check_recapcha ) {
               wp_die( __( 'CAPTCHA verification failed.', 'ovaem-events-manager' ), __( 'Error', 'ovaem-events-manager' ), array(
                     'response'  => 403,
                     'back_link' => true,
                  ) );
            }
         }

         // Change post type to event_order

         $title = current_time( 'timestamp' );

         $post_data['post_type'] = 'event_order';
         $post_data['post_title'] = $title;
         $post_data['post_status'] = 'publish';

         // Input data that client insert at frontend
         $input_event_id      = esc_attr( $post_data['event_id'] ) ? sanitize_text_field( $post_data['event_id'] ) : '';
         $input_package_id    = esc_attr( $post_data['package_id'] ) ? sanitize_text_field( $post_data['package_id'] ) : '';
         $input_ovaem_name    = isset( $post_data['ovaem_name'] ) && esc_attr( $post_data['ovaem_name'] ) ? sanitize_text_field( $post_data['ovaem_name'] ) : '';
         $input_ovaem_phone   = isset( $post_data['ovaem_phone'] ) ? sanitize_text_field( $post_data['ovaem_phone'] ) : '';
         $input_ovaem_email   = esc_attr( $post_data['ovaem_email'] ) ? sanitize_text_field( $post_data['ovaem_email'] ) : '';
         $input_ovaem_address = isset( $post_data['ovaem_address'] ) && esc_attr( $post_data['ovaem_address'] ) ? sanitize_text_field( $post_data['ovaem_address'] ) : '';
         $input_ovaem_desc    = isset( $post_data['ovaem_desc'] ) ? sanitize_text_field( $post_data['ovaem_desc'] ) : '';
         $input_ovaem_number  = isset( $post_data['ovaem_number'] ) && esc_attr( $post_data['ovaem_number'] ) ? intval( $post_data['ovaem_number'] ) : 1;
         $input_ovaem_company = isset( $post_data['ovaem_company'] ) ? sanitize_text_field( $post_data['ovaem_company'] ) : '';
         $input_ovaem_terms   = isset( $post_data['ovaem_terms'] ) ? sanitize_text_field( $post_data['ovaem_terms'] ) : '';
         $event_obj           = get_post( $input_event_id );

         $meta_input = array(
            'ovaem_order_id'        => '',
            'event_id'              => '<a href="' . home_url('/?post_type=' . OVAEM_Settings::event_post_type_slug() . '&p=' . $event_obj->ID) . '">' . $event_obj->post_title . '</a>',
            'package_id'            => $input_package_id,
            'ovaem_name'            => $input_ovaem_name,
            'ovaem_phone'           => $input_ovaem_phone,
            'ovaem_email'           => $input_ovaem_email,
            'ovaem_address'         => $input_ovaem_address,
            'ovaem_desc'            => $input_ovaem_desc,
            'ovaem_number'          => $input_ovaem_number,
            'ovaem_company'         => $input_ovaem_company,
            'ovaem_free_event_id'   => $event_obj->ID,
            'ovame_ticket_type'     => 'Free',
            'ovaem_event_status'    => 'error_mail',
            'ovaem_terms'           => $input_ovaem_terms
         );

         $post_data['meta_input'] = $meta_input;

         $event_id = $post_data['event_id'];
         $remaining_ticket = OVAEM_Ticket::remaining_ticket($event_id, $input_package_id);


         // Get ticket info
         $info_ticket = OVAEM_Get_Data::ovaem_get_info_ticket( $event_id, $input_package_id );
         
         // Add Customer is Author of Order
         if( is_user_logged_in() ){
            $post_data['post_author'] = get_current_user_id();
         }

         if ( $remaining_ticket < $input_ovaem_number) {

            ovaem_get_template('register-error.php');

         } else if (!$input_event_id || (isset($post_data['ovaem_name']) && !$input_ovaem_name) || !$input_ovaem_email ) {

            ovaem_get_template('register-error.php');

         } else {

            if ($order_id_new = wp_insert_post($post_data, true)) {

               // Update Order ID to metabox
               update_post_meta($order_id_new, 'ovaem_order_id', $order_id_new, '');

               // Update Post Title to Order Id
               $update_post = array(
                  'ID' => $order_id_new,
                  'post_title' => $order_id_new,
                  'post_name' => $order_id_new
               );
               
               wp_update_post($update_post);

               do_action( 'ovaem_after_save_order_event_free', $order_id_new, $post_data );

               // Add Ticket
               OVAEM_Ticket::add_ticket($order_id_new);

               // Info Order
               $order_info = get_post($order_id_new);

               // Get Link, Password per package
              

               // Send mail for Organizer, Customer, Admin
               $mail_to = OVAEM_Settings::mail_to();
               $send_mail_to = array();
               $admin_mail = in_array('admin', $mail_to[0]) ? get_option('admin_email') : '';
               $client_mail = in_array('client', $mail_to[0]) ? $input_ovaem_email : '';

               if (in_array('organizer', $mail_to[0])) {

                  $auth = get_post($input_event_id);
                  $send_mail_array[] = get_the_author_meta('user_email', $auth->post_author);
               }

               if ($admin_mail) {
                  $send_mail_array[] = $admin_mail;
               }
               if ($client_mail) {
                  $send_mail_array[] = $client_mail;
               }

               $send_mail_to_multi_obj = !empty($send_mail_array) ? implode(',', $send_mail_array) : '';

              
               $body = OVAEM_Settings::mail_template();
               $body = str_replace('[event]', '<a href="' . home_url('/?post_type=' . OVAEM_Settings::event_post_type_slug() . '&p=' . $event_obj->ID) . '">' . $event_obj->post_title . '</a>', $body);
               $body = str_replace('[orderid]', $order_id_new, $body);
               $body = str_replace('[client_name]', $input_ovaem_name, $body);
               $body = str_replace('[phone]', $input_ovaem_phone, $body);
               $body = str_replace('[email]', $input_ovaem_email, $body);
               $body = str_replace('[address]', $input_ovaem_address, $body);
               $body = str_replace('[addition]', $input_ovaem_desc, $body);
               $body = str_replace('[number]', $input_ovaem_number, $body);
               $body = str_replace('[company]', $input_ovaem_company, $body);

               $current_locale = get_locale();

               if ($current_locale == 'fr_FR') {
                  $body = str_replace('Here are your tickets', 'Voici vos billets', $body);
                  $body = str_replace('[bottom_text]', 'N\'hésitez pas à nous contacter si vous avez des questions ! Nous serions heureux de vous aider. Il vous suffit de nous contacter via', $body);
                   $subject = esc_html__("Voici vos billets", 'ovaem-events-manager');
               } else {
                 $body = str_replace('[bottom_text]', 'Feel free to contact us if you have any questions or comments! We are happy to help. Just contact us via', $body);
                  $subject = esc_html__("Here are your tickets", 'ovaem-events-manager');
               }

               if( $info_ticket ){
                  $body .= $info_ticket['link'] ? '<br/>'.esc_html__( 'Link:', 'ovaem-events-manager' ).' '.$info_ticket['link'] : '';
                  $body .= $info_ticket['password'] ? '<br/>'.esc_html__( 'Password:', 'ovaem-events-manager' ).' '.$info_ticket['password'] : '';
               }

               // Instanciation of inherited class

               if ($send_mail_to_multi_obj) {

                  // Make PDF Ticket From Code List by Order ID
                  $ticket_pdf = array();
                  $ticket_pdf = OVAEM_Ticket::make_pdf_ticket_by_order($order_id_new);

                  $total_ticket_pdf = count($ticket_pdf);

                  if (OVAEM_Settings::event_file_cer_attachment() == 'yes') {

                     $input_package_id = isset($input_package_id) ? str_replace("ovaminus", "_", urldecode($input_package_id)) : '';
                     $cer_attach_array = get_cer_attach($input_event_id, $input_package_id);
                     if ($cer_attach_array) {
                        $ticket_pdf[] = $cer_attach_array;
                     }

                  }

                  if (OVAEM_Send_Mail::ovaem_sendmail($send_mail_to_multi_obj, $subject, $body, $ticket_pdf)) {

                     // Delete PDF Ticket file in server

                     foreach ($ticket_pdf as $key => $value) {
                        if ($key < $total_ticket_pdf) {
                           unlink($value);
                        }

                     }

                     update_post_meta($order_id_new, 'ovaem_event_status', 'Completed', 'error_mail');

                     $thanks_page = OVAEM_Settings::thanks_page();
                     if ($thanks_page) {
                        wp_redirect($thanks_page);
                     } else {
                        wp_redirect(home_url('/'));
                     }
                     

                  } else {
                     ovaem_get_template('register-send-mail.php');
                  }

               }

               return true;
            }

         }

         return false;

      }

   }
   new OVAEM_Process_Data();
}
