<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class OVAEM_Templates_Loader {

	private static $event_post_type_slug = 	null;
	private static $slug_taxonomy_name = 	null;
	private static $speaker_post_type_slug = null;
	private static $venue_post_type_slug = null;
	
	/**
	 * The Constructor
	 */
	public function __construct() {

		self::$event_post_type_slug = OVAEM_Settings::event_post_type_slug();
		self::$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
		self::$speaker_post_type_slug = OVAEM_Settings::speaker_post_type_slug();
		self::$venue_post_type_slug = OVAEM_Settings::venue_post_type_slug();

		add_filter( 'template_include', array( $this, 'template_loader' ) );
		
	}

	

	public function template_loader( $template ) {

		$post_type = isset($_REQUEST['post_type'] ) ? esc_html( $_REQUEST['post_type'] ) : get_post_type();
		$search = isset( $_REQUEST['search'] ) ? esc_html( $_REQUEST['search'] ) : '';
		$action = isset( $_REQUEST['action'] ) ? esc_html( $_REQUEST['action'] ) : '';
		$regis_free_event = isset( $_REQUEST['regis_free_event'] ) ? esc_html( $_REQUEST['regis_free_event'] ) : '';
		$checkout_free_event = isset( $_REQUEST['checkout_free_event'] ) ? esc_html( $_REQUEST['checkout_free_event'] ) : '';

		$check_qr = isset( $_REQUEST['qr'] ) ? esc_html( $_REQUEST['qr'] ) : '';
		$qrcode = isset( $_REQUEST['qrcode'] ) ? esc_html( $_REQUEST['qrcode'] ) : '';

		$frontend_submit = isset( $_REQUEST['frontend_submit'] ) ? esc_attr( $_REQUEST['frontend_submit'] ) : '';
		

		// Offline Payment
		if ( isset( $_POST['checkout_event'] ) && $_POST['checkout_event'] == 'yes' && $_POST['method_payment'] == 'offline' && OVAEM_Settings::offline_payment_use() ) {

			$login_before_booking = OVAEM_Settings::login_before_booking();

	        if( $login_before_booking == 'yes' && !is_user_logged_in() ){
	            wp_redirect( wp_login_url() );
	            return true;
	        }else{
	        	OVA_Add_Order::ova_process_offline_proccess();
				return true;	
	        }

			
		}
		
		// Not Event Post Type and Speaker Post Type
		if( is_tax( 'event_tags' ) ||  get_query_var( 'event_tags' ) != '' ){
			$paged = get_query_var('paged') ? get_query_var('paged') : '1';
			query_posts( '&event_tags='.get_query_var( 'event_tags' ).'&paged=' . $paged );
			ovaem_get_template( 'archive-event.php' );
			return false;
		}

		if( is_tax( self::$slug_taxonomy_name ) ||  get_query_var( self::$slug_taxonomy_name ) != '' ){

			$paged = get_query_var('paged') ? get_query_var('paged') : '1';
			
			query_posts( '&'.self::$slug_taxonomy_name.'='.get_query_var( self::$slug_taxonomy_name ).'&paged=' . $paged );
			ovaem_get_template( 'archive-event.php' );
			return false;
		}

		if( is_tax( 'location' ) ||  get_query_var( 'location' ) != '' ){

			$paged = get_query_var('paged') ? get_query_var('paged') : '1';
			query_posts( '&location='.get_query_var( 'location' ).'&paged=' . $paged );
			ovaem_get_template( 'archive-event.php' );
			return false;	
		}


		// Is Event Post Type
		if( $post_type == self::$event_post_type_slug ){

			if( $action != '' ){
		        
				// @TODO: Change url based on locale
				$locale = get_locale();
				if ( $locale == 'en_US' ) {
					$cart_page = OVAEM_Settings::cart_page() ? OVAEM_Settings::cart_page() : home_url('/');
					wp_redirect( $cart_page );
				} else if ( $locale == 'fr_FR' ) {
					$cart_page = OVAEM_Settings::cart_page() ? OVAEM_Settings::cart_page() : home_url('/');
					wp_redirect( 'fr/'.$cart_page );	
				}
				
			} else if( $regis_free_event != '' ){ 

				$login_before_booking = OVAEM_Settings::login_before_booking();

		        if( $login_before_booking == 'yes' && !is_user_logged_in() ){
		            
		            $redirect_to = add_query_arg( 'p', $regis_free_event,  home_url() );
		            $login_url = add_query_arg( 'redirect_to', $redirect_to, wp_login_url() );
		            wp_redirect( $login_url );
		            return false;
		        }else{
		        	ovaem_get_template( 'register-free-event.php' );
					return false;					
		        }

			} else if( $checkout_free_event != '' ){

				$event_id = isset( $_REQUEST['event_id'] ) ? esc_html( $_REQUEST['event_id'] ) : '';

				$login_before_booking = OVAEM_Settings::login_before_booking();

		        if( $login_before_booking == 'yes' && !is_user_logged_in() ){
		            
		            $redirect_to = add_query_arg( 'p', $event_id,  home_url() );
		            $login_url = add_query_arg( 'redirect_to', $redirect_to, wp_login_url() );
		            wp_redirect( $login_url );
		            return false;
		        }


				$post_data = isset( $_POST ) ? $_POST : '';

				if( $event_id != '' && $post_data != '' ){
					OVAEM_Process_Data::save_order_event($event_id, $post_data);
					
				}else{
					
					wp_redirect( home_url('/') );	
				}
				

			}else if( $frontend_submit != '' ){
				$post_data = isset( $_POST ) ? $_POST : '';
				OVAEM_FrontSub_Save::ovaem_save_data($post_data);

			}else if ( $search != '' || is_post_type_archive( self::$event_post_type_slug ) || is_tax( self::$slug_taxonomy_name ) ) {

				ovaem_get_template( 'archive-event.php' );
				return false;

			} else if ( is_single() ) {
				$event_detail_template = OVAEM_Settings::event_detail_template();
				$detail_template = isset( $_GET['detail_template'] ) ? $_GET['detail_template'] : $event_detail_template;
				switch ($detail_template) {
					case 'classic':
						ovaem_get_template( 'single-event.php' );
						break;
					case 'modern':
						
						ovaem_get_template( 'single-event-modern.php' );
						break;
					default:
						ovaem_get_template( 'single-event.php' );
						break;
				}
				
				return false;

			}
		}

		
		// Is Speaker Post Type
		if(  $post_type == self::$speaker_post_type_slug ){

			if ( is_post_type_archive( self::$speaker_post_type_slug ) ) { 

				ovaem_get_template( 'archive-speaker.php' );
				return false;

			} else if ( is_single() ) {

				ovaem_get_template( 'single-speaker.php' );
				return false;

			}
		}

		

		// Is Venue Post Type
		if( $post_type == self::$venue_post_type_slug ){

			if ( is_post_type_archive( self::$venue_post_type_slug ) ) {

				ovaem_get_template( 'archive-venue.php' );
				return false;

			} else if ( is_single() ) {

				ovaem_get_template( 'single-venue.php' );
				return false;

			}
		}

		// Check QR code
		if( $check_qr != '' || $qrcode != '' ){
			ovaem_get_template( 'check-ticket.php' );
			return false;
		}

		
		if ( $post_type !== self::$event_post_type_slug && $post_type !== self::$speaker_post_type_slug && $post_type !== self::$venue_post_type_slug ){
			return $template;
		}


		
	}

}

new OVAEM_Templates_Loader();
