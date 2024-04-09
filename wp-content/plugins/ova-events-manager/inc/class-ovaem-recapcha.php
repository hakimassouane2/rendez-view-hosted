<?php
defined('ABSPATH') || exit();

if ( ! class_exists('OVAEM_Recapcha') ) {
	class OVAEM_Recapcha {

		public function __construct(){

			$recapcha_type 			= OVAEM_Settings::captcha_type();
			$enable_login 			= OVAEM_Settings::enable_for_login();
			$enable_register 		= OVAEM_Settings::enable_for_register();
			$enable_lost_password 	= OVAEM_Settings::enable_for_lost_password();
			$enable_comment 		= OVAEM_Settings::enable_for_comment();
			$enable_register_event 	= OVAEM_Settings::enable_register_event();
			$enable_woo_checkout 	= OVAEM_Settings::enable_woo_checkout();
			$enable_event_checkout 	= OVAEM_Settings::enable_event_checkout();

			$hooks = array(
				'login_form_middle' 				=> $enable_login,
				'em4u_register_recapcha' 			=> $enable_register,
				'em4u_recapcha_event_checkout' 		=> $enable_event_checkout,
			);

			foreach ( $hooks as $hook => $enable ) {
				if ( ovaem_show_captcha() && $enable ) {
					if ( $recapcha_type == 'v3' ) {
						add_action( $hook, array( $this, 'ovaem_display_captcha_input' ) );
					} elseif ( $recapcha_type == 'v2' ) {
						add_action( $hook, array( $this, 'ovaem_recaptcha_display_wrapper' ) );
					}
				}
			}
			// lost password
			if ( ovaem_show_captcha() && $enable_lost_password ) {
				if ( $recapcha_type == 'v3' ) {
					add_action( 'woocommerce_lostpassword_form', array( $this, 'ovaem_display_captcha_input_e' ) );
				} elseif ( $recapcha_type == 'v2' ) {
					add_action( 'woocommerce_lostpassword_form', array( $this, 'ovaem_recaptcha_display_wrapper_e' ) );
				}
				add_action( 'lostpassword_post', array( $this, 'ovaem_handle_recapcha_lost_password' ), 10, 2 );
			}
			// comment
			if ( ovaem_show_captcha() && $enable_comment ) {
				if ( $recapcha_type == 'v3' ) {
					if ( get_post_type() !== 'product' ) {
						add_filter( 'comment_form_fields', array( $this, 'ovaem_display_captcha_input_comment' ) );
					} else {
						add_filter( 'comment_form_fields', array( $this, 'ovaem_display_captcha_input_comment_woo' ) );
					}
					
				} elseif ( $recapcha_type == 'v2' ) {
					if ( get_post_type() !== 'product' ) {
						add_filter( 'comment_form_fields', array( $this, 'ovaem_recaptcha_display_wrapper_comment' ) );
					} else {
						add_filter( 'comment_form_fields', array( $this, 'ovaem_recaptcha_display_wrapper_comment_woo' ) );
					}
					
				}
				add_filter( 'comment_form_fields', array( $this, 'ovaem_move_recapcha_field_to_bottom' ) );
				add_action( 'preprocess_comment', array( $this, 'ovaem_recaptcha_process_comment_form' ) );
			}
			// register event
			if ( ovaem_show_captcha() && $enable_register_event ) {
				if ( $recapcha_type == 'v3' ) {
					add_action( 'em4u_recapcha_register_event_free', array( $this, 'ovaem_display_captcha_input' ) );
					add_action( 'em4u_recapcha_register_event', array( $this, 'ovaem_display_captcha_input' ) );
				} elseif ( $recapcha_type == 'v2' ) {
					add_action( 'em4u_recapcha_register_event_free', array( $this, 'ovaem_recaptcha_display_wrapper_event' ) );
					add_action( 'em4u_recapcha_register_event', array( $this, 'ovaem_recaptcha_display_wrapper_event' ) );
				}
			}
			// woo checkout
			if ( ovaem_show_captcha() && $enable_woo_checkout ) {
				if ( $recapcha_type == 'v3' ) {
					add_action( 'woocommerce_checkout_before_order_review_heading', array( $this, 'ovaem_display_captcha_input_e' ), 99, 0 );
				} elseif ( $recapcha_type == 'v2' ) {
					add_action( 'woocommerce_checkout_before_order_review_heading', array( $this, 'ovaem_recaptcha_display_wrapper_e' ), 99, 0 );
				}
				add_action( 'woocommerce_checkout_process', array( $this, 'ovaem_handle_recapcha_woo_checkout' ), 10, 2 );
			}
			
		}

		public function ovaem_display_captcha_input(){
			return '<input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">';
		}

		public function ovaem_recaptcha_display_wrapper(){
			return '<div class="ovaem-recaptcha-wrapper" data-mess="'. esc_attr__( 'CAPTCHA verification failed.', 'ovaem-events-manager' ) .'"></div>';
		}

		public function ovaem_recaptcha_display_wrapper_event(){
			?>
			<div class="col-md-12 ova_field">
				<div class="ovaem-recaptcha-wrapper" data-mess="<?php echo esc_attr__( 'CAPTCHA verification failed.', 'ovaem-events-manager' ); ?> "></div>
			</div>
			<?php
		}

		public function ovaem_display_captcha_input_e(){
			echo '<input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">';
		}

		public function ovaem_recaptcha_display_wrapper_e(){
			echo '<div class="ovaem-recaptcha-wrapper" data-mess="'. esc_attr__( 'CAPTCHA verification failed.', 'ovaem-events-manager' ) .'"></div>';
		}

		public function ovaem_display_captcha_input_comment( $fields ){
			$fields['recapcha'] = '<input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">';
			return $fields;
		}

		public function ovaem_recaptcha_display_wrapper_comment( $fields ){
			$fields['recapcha'] = '<div class="ovaem-recaptcha-wrapper" data-mess="'. esc_attr__( 'CAPTCHA verification failed.', 'ovaem-events-manager' ) .'"></div>';
			return $fields;
		}

		public function ovaem_display_captcha_input_comment_woo( $fields ){
			$fields['fields']['recapcha'] = '<input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">';
			return $fields;
		}

		public function ovaem_recaptcha_display_wrapper_comment_woo( $fields ){
			$fields['fields']['recapcha'] = '<div class="ovaem-recaptcha-wrapper" data-mess="'. esc_attr__( 'CAPTCHA verification failed.', 'ovaem-events-manager' ) .'"></div>';
			return $fields;
		}

		public function ovaem_move_recapcha_field_to_bottom( $fields ) {
			$recapcha_field = $fields['recapcha'];
			unset( $fields['recapcha'] );
			$fields['recapcha'] = $recapcha_field;
			return $fields;
		}

		public function ovaem_handle_recapcha_lost_password( $errors, $user_data ){

			if ( isset( $_REQUEST['g-recaptcha-response'] ) ) {
				$response 			= $_REQUEST['g-recaptcha-response'];
				$secret 			= OVAEM_Settings::captcha_serectkey();
				$check_recapcha 	= ovaem_recapcha_verify( $response, $secret );
				if ( ! $check_recapcha ) {
					$errors->add( 'recapcha', __( 'CAPTCHA verification failed.', 'ovaem-events-manager' ) );
					return false;
				}
			}

		}

		public function ovaem_recaptcha_process_comment_form( $commentdata ){
			if ( absint( $commentdata['user_ID'] ) > 0 ) {
			    return $commentdata;
			}
			if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) {
				$response 	= $_POST['g-recaptcha-response'];
				$secret 	= OVAEM_Settings::captcha_serectkey();
				$check_recapcha = ovaem_recapcha_verify( $response, $secret );
				if ( ! $check_recapcha ) {
					wp_die( __( 'CAPTCHA verification failed.', 'ovaem-events-manager' ), __( 'Error', 'ovaem-events-manager' ), array(
							'response'  => 403,
							'back_link' => true,
						) );
				}
			}
			return $commentdata;
		}

		public function ovaem_handle_recapcha_woo_checkout(){
			if ( isset( $_REQUEST['g-recaptcha-response'] ) ) {
				$response 			= $_REQUEST['g-recaptcha-response'];
				$secret 			= OVAEM_Settings::captcha_serectkey();
				$check_recapcha 	= ovaem_recapcha_verify( $response, $secret );
				if ( ! $check_recapcha ) {
					$errors = new WP_Error();
					$errors->add( 'recapcha', __( 'CAPTCHA verification failed.', 'ovaem-events-manager' ) );
					$data = $errors->get_error_data( 'recapcha' );
					wc_add_notice( __( 'CAPTCHA verification failed.', 'ovaem-events-manager' ), 'error', $data );
				}
			}
		}

	}
	new OVAEM_Recapcha();
}