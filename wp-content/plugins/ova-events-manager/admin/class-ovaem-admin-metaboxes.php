<?php 
if(  !defined( 'ABSPATH' ) )	exit();

if( !class_exists( 'OVAEM_Admin_Metaboxes' ) ){

	class OVAEM_Admin_Metaboxes{

		private static $event_post_type_slug = null;
		private static $speaker_post_type_slug = null;
		private static $event_order_post_type_slug = null;
		private static $venue_post_type_slug = null;
		private static $coupon_post_type_slug = null;
		private static $event_ticket_post_type_slug = null;
		

		public function __construct(){
			
			$this->require_metabox();

			/**
			 * Save post meta
			 */
			self::$event_post_type_slug = OVAEM_Settings::event_post_type_slug();
			self::$speaker_post_type_slug = OVAEM_Settings::speaker_post_type_slug();
			self::$event_order_post_type_slug = 'event_order';
			self::$venue_post_type_slug = OVAEM_Settings::venue_post_type_slug();;
			self::$coupon_post_type_slug = 'coupon';
			self::$event_ticket_post_type_slug = 'event_ticket';

			add_action( 'add_meta_boxes', array( $this , 'ovaem_add_metabox' ), 11 );
			add_action( 'save_post', array( $this , 'ovaem_save_metabox' ) );

			
			

			add_action( 'ova_events_process_update_'.self::$event_post_type_slug.'_meta', array( 'OVAEM_Event_Metaboxes', 'save' ), 10, 2 );

			add_action( 'ova_events_process_update_'.self::$speaker_post_type_slug.'_meta', array( 'OVAEM_Speaker_Metaboxes', 'save' ), 10, 2 );

			add_action( 'ova_events_process_update_'.self::$event_order_post_type_slug.'_meta', array( 'OVAEM_Event_Order_Metaboxes', 'save' ), 10, 2 );

			add_action( 'ova_events_process_update_'.self::$event_ticket_post_type_slug.'_meta', array( 'OVAEM_Event_Ticket_Metaboxes', 'save' ), 10, 2 );

			add_action( 'ova_events_process_update_'.self::$venue_post_type_slug.'_meta', array( 'OVAEM_Venue_Metaboxes', 'save' ), 10, 2 );

			add_action( 'ova_events_process_update_'.self::$coupon_post_type_slug.'_meta', array( 'OVAEM_coupon_Metaboxes', 'save' ), 10, 2 );
			
		}

		public function require_metabox(){
			require_once( OVAEM_PLUGIN_PATH.'/admin/meta-boxes/ovaem-event-metaboxes.php' );
			require_once( OVAEM_PLUGIN_PATH.'/admin/meta-boxes/ovaem-event-order-metaboxes.php' );
			require_once( OVAEM_PLUGIN_PATH.'/admin/meta-boxes/ovaem-speaker-metaboxes.php' );
			require_once( OVAEM_PLUGIN_PATH.'/admin/meta-boxes/ovaem-venue-metaboxes.php' );
			require_once( OVAEM_PLUGIN_PATH.'/admin/meta-boxes/ovaem-coupon-metaboxes.php' );
			require_once( OVAEM_PLUGIN_PATH.'/admin/meta-boxes/ovaem-event-ticket-metaboxes.php' );
		}

		/**
		 * Regisgter Metabox
		 */
		public function ovaem_add_metabox(){

			// Event Metaboxes
			add_meta_box(
				'event-metabox-settings',
				__( 'Event Settings', 'ovaem-events-manager' ),
				array( 'OVAEM_Event_Metaboxes', 'render' ),
				self::$event_post_type_slug,
				'normal',
				'high'
			);

		    // Speaker Metaboxes
			add_meta_box(
				'speaker-metabox-settings',
				__( 'Speaker Settings', 'ovaem-events-manager' ),
				array( 'OVAEM_Speaker_Metaboxes', 'render' ),
				self::$speaker_post_type_slug,
				'normal',
				'high'
			);

		    // Order Metaboxes
			add_meta_box(
				'event-order-metabox-settings',
				__( 'Order Settings', 'ovaem-events-manager' ),
				array( 'OVAEM_Event_Order_Metaboxes', 'render' ),
				'event_order',
				'normal',
				'high'
			);

			add_meta_box(
				'event-ticket-metabox-settings',
				__( 'Ticket Details', 'ovaem-events-manager' ),
				array( 'OVAEM_Event_Ticket_Metaboxes', 'render' ),
				'event_ticket',
				'normal',
				'high'
			);

		    // Venue Metabox
			add_meta_box(
				'venue-metabox-settings',
				__( 'Venue Settings', 'ovaem-events-manager' ),
				array( 'OVAEM_Venue_Metaboxes', 'render' ),
				self::$venue_post_type_slug,
				'normal',
				'high'
			);

		    // coupon Metabox
			add_meta_box(
				'coupon-metabox-settings',
				__( 'coupon Settings', 'ovaem-events-manager' ),
				array( 'OVAEM_coupon_Metaboxes', 'render' ),
				'coupon',
				'normal',
				'high'
			);
			
		}

		/**
		 * Save metabox
		 */
		public function ovaem_save_metabox($post_id){
			
			// Bail if we're doing an auto save
			if ( empty( $_POST ) && defined( 'DOING_AJAX' ) && DOING_AJAX ) return;
			
			// if our nonce isn't there, or we can't verify it, bail
			if( !isset( $_POST['ova_events_nonce'] ) || !wp_verify_nonce( $_POST['ova_events_nonce'], 'ova_events_nonce' ) ) return false;
			
		    // if our current user can't edit this post, bail
			if( !current_user_can( 'edit_post', $post_id ) ) return false;

			$post_type = get_post_type( $post_id );
			
			if ( !in_array( $post_type, array( self::$event_post_type_slug,  self::$speaker_post_type_slug, self::$event_order_post_type_slug, self::$venue_post_type_slug, self::$coupon_post_type_slug, self::$event_ticket_post_type_slug ) ) ) {
				return false;
			}
			

			do_action( 'ova_events_process_update_' . $post_type . '_meta', $post_id, $_POST );
			
		}


	}

	new OVAEM_Admin_Metaboxes();

}

?>