<?php 

defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEM_Admin_Ajax' ) ){

	class OVAEM_Admin_Ajax{
		
		public function __construct(){
			$this->init();

			
		}

		public function init(){

			// Define All Ajax function
			$arr_ajax =  array(
				'generate_metabox_event_schedule',
				'generate_metabox_event_plan',
				'generate_metabox_speakers',
				'generate_metabox_speaker_social',
				'generate_metabox_dis_speakers',
				'generate_metabox_event_sponsor',
				'generate_metabox_event_sponsor_info',
				'generate_metabox_event_ticket',
				'resend_pdf_ticket',
				'generate_metabox_event_faq'
			);

			foreach($arr_ajax as $val){
				add_action( 'wp_ajax_'.$val, array( $this, $val ) );
				add_action( 'wp_ajax_nopriv_'.$val, array( $this, $val ) );
			}

			// backend
			$arr_ajax_backend = array(
				'ovaem_sortable_checkout_field'
			);

			foreach ($arr_ajax_backend as $hook) {
				add_action( 'wp_ajax_'.$hook, array( $this, $hook ) );
			}

		}

		/**
		 * Schedule Ajax
		 */
		public static function generate_metabox_event_schedule(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-event-schedule.php' );
			wp_die();
		}

		/**
		 * Sponsor Ajax
		 */
		public static function generate_metabox_event_sponsor(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-event-sponsor.php' );
			wp_die();
		}

		/* Ticket Ajax */
		public static function generate_metabox_event_ticket(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-event-ticket.php' );
			wp_die();
		}

		/**
		 * Sponsor Item Info ajax
		 */
		public static function generate_metabox_event_sponsor_info(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-event-sponsor-info.php' );
			wp_die();
		}
		

		/**
		 * Plan Ajax
		 */
		public static function generate_metabox_event_plan(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-event-schedule-plan.php' );
			wp_die();
		}

		/**
		 * All Speakers
		 */
		public static function generate_metabox_speakers(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-event-speakers.php' );
			wp_die();	
		}

		/**
		 * Social Speaker
		 */
		public static function generate_metabox_speaker_social(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-speaker-social.php' );
			wp_die();
		}

		/**
		 * display speakery by ids
		 */
		public static function generate_metabox_dis_speakers(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-dis-speakers.php' );
			wp_die();	
		}

		/* Resend PDF Ticket */
		public static function resend_pdf_ticket(){

			$ticket_id = $_POST['ticket_id'];
			$buyer_email = $_POST['buyer_email'];
			$name_event = $_POST['name_event'];
			$verify_ticket = $_POST['verify_ticket'];

			if( $verify_ticket == 'false' ){
				esc_html_e( 'You have to verify ticket before sent', 'ovaem-events-manager' );
				wp_die();
			}

			$ticket_pdf = array();
			$pdf = new OVAEM_Make_PDF();
			$ticket_pdf['0'] = $pdf->make_pdf_ticket( $ticket_id );

			$ticket_info_link = get_post_meta( $ticket_id, 'ovaem_ticket_info_link', true );
			$ticket_info_password = get_post_meta( $ticket_id, 'ovaem_ticket_info_password', true );
			
			$subject = esc_html__( 'Resend Ticket', 'ovaem-events-manager' );
			$body = esc_html__( 'Resend Ticket of event: ', 'ovaem-events-manager' ).$name_event;

			if( $ticket_info_link ){
				$body .= '<br/>'.esc_html__( 'Link:', 'ovaem-events-manager' ).' '.$ticket_info_link;
			}
			if( $ticket_info_password ){
				$body .= '<br/>'.esc_html__( 'Password:', 'ovaem-events-manager' ).' '.$ticket_info_password;
			}

			if( OVAEM_Send_Mail::ovaem_sendmail( $buyer_email, $subject, $body, $ticket_pdf ) ){
				// Delete PDF Ticket file in server
				if ( $ticket_pdf && is_array( $ticket_pdf ) ) {
					foreach( $ticket_pdf as $value ) {
						unlink( $value );
					}
				}

                esc_html_e( 'Sent', 'ovaem-events-manager' );

            }else{
            	esc_html_e( 'Send Error', 'ovaem-events-manager' );
            }
            

			wp_die();		
		}

		
		/**
		 * FAQ Ajax
		 */
		public static function generate_metabox_event_faq(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-event-faq.php' );
			wp_die();
		}

		public function ovaem_sortable_checkout_field(){
			if ( ! isset( $_POST['pos'] ) ) {
				wp_die();
			}
			$pos = $_POST['pos'];
			$ova_checkout_form = get_option( 'ova_checkout_form', array() );

			foreach ( $pos as $name => $position ) {
				$ova_checkout_form[$name]['position'] = $position;
			}

			$ova_checkout_form = ovaem_sortby_position( $ova_checkout_form );

			update_option( 'ova_checkout_form', $ova_checkout_form );

			$list_fields = get_option( 'ova_checkout_form', array() );

			ovaem_get_list_fields( $list_fields );

			wp_die();
		}




	}

	new OVAEM_Admin_Ajax();

}

 ?>