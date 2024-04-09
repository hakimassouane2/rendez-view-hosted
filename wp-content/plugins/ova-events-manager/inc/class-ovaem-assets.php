<?php 
defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEM_Assets' ) ){
	class OVAEM_Assets{

		public function __construct(){

			add_action( 'wp_enqueue_scripts', array( $this, 'ovaem_enqueue_scripts' ), 10 ,0 );

		}
		

		public function ovaem_enqueue_scripts(){
			// select2
			wp_enqueue_style( 'ova-select2-css', OVAEM_PLUGIN_URI.'assets/libs/select2/css/select2.min.css');
			wp_enqueue_script( 'ova-select2-js', OVAEM_PLUGIN_URI.'assets/libs/select2/js/select2.min.js', array('jquery'), false, true );
			// Date Time Picker
			wp_enqueue_script('datetimepicker_js', OVAEM_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.full.min.js', array('jquery'), null, true );
			wp_enqueue_script('validate', OVAEM_PLUGIN_URI.'assets/libs/validate/jquery.validate.min.js', array('jquery'), null, true );
			

			// Ajax Checkout Event
			wp_enqueue_script('ajax-script', OVAEM_PLUGIN_URI.'assets/js/frontend/checkout_event.js',array('jquery'),null,true);
			wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );			

			

			// recaptcha
			if( ovaem_show_captcha() ){
				$recapcha_type 	= OVAEM_Settings::captcha_type();
				$site_key 		= OVAEM_Settings::captcha_sitekey();

				wp_enqueue_script('ovaem-handle-recapcha', OVAEM_PLUGIN_URI . 'assets/js/frontend/recapcha.js' , array(), false, false);
				wp_localize_script( 'ovaem-handle-recapcha', 'recapcha_object', array( 'site_key' => $site_key ) );

				if ( $recapcha_type === 'v2' ) {
					wp_enqueue_script('ovaem-recapcha', 'https://www.google.com/recaptcha/api.js?hl=' . esc_attr( get_locale() ) . '&onload=ovaem_recapcha_v2&render=explicit', array(), false, false);
				} elseif ( $recapcha_type === 'v3' ) {
					wp_enqueue_script('ovaem-recapcha', 'https://www.google.com/recaptcha/api.js?onload=ovaem_recapcha_v3&render='.esc_attr( $site_key ), array(), false, false);
				}
			}

			wp_enqueue_script( 'ovaem_script', OVAEM_PLUGIN_URI.'assets/js/frontend/ovaem_script.js', array('jquery'), null, true );
			
			// Date Time Picker
			wp_enqueue_style('datetimepicker_css', OVAEM_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.css', array(), null );

			wp_enqueue_style( 'ovaem_style', OVAEM_PLUGIN_URI.'assets/css/frontend/ovaem_style.css' );
		}


	}
	new OVAEM_Assets();
}
