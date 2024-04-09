<?php
/*
Plugin Name: Ovatheme Events Manager
Plugin URI: https://themeforest.net/user/ovatheme
Description: OvaTheme Events Manager
Author: Ovatheme
Version: 1.6.6
Author URI: https://themeforest.net/user/ovatheme/portfolio
Text Domain: ovaem-events-manager
Domain Path: /languages/
*/

if ( !defined( 'ABSPATH' ) ) exit();

/**
 * OVAEM Class
 */

if( !class_exists( 'OVAEM' ) ){

	final class OVAEM{

		private static $_instance = null;
		
		/**
		 * OVAEM Constructor
		 */

		public function __construct(){
			$this->define_constants();
			$this->includes();
			$this->support_woocommerce();
			$this->rewirte_slug();
		}


		/**
		 * Define constants
		 */
		public function define_constants(){
			
			$this->define( 'OVAEM_PLUGIN_FILE', __FILE__ );
			$this->define( 'OVAEM_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
			$this->define( 'OVAEM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'OVAEM_PLUGIN_BASENAME', plugin_basename( OVAEM_PLUGIN_FILE ) );
			$this->define( 'OVAEM_PLUGIN_ABSPATH', dirname( OVAEM_PLUGIN_FILE ) );
			load_plugin_textdomain( 'ovaem-events-manager', false, basename( dirname( __FILE__ ) ) .'/languages' );
		}

		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}


		/**
		 * Include files
		 */

		public function includes(){
			
			require_once( OVAEM_PLUGIN_PATH.'/inc/ovaem-core-functions.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-settings.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-assets.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-ajax.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-custom-post-types.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-templates-loader.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-get-data.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-get-data-speaker.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-get-data-venue.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-check-ticket.php' );

			require_once( OVAEM_PLUGIN_PATH.'/shortcode/ovaem-sc-init.php' );

			require_once( OVAEM_PLUGIN_PATH.'/widgets/ovaem-widget-init.php' );

			/* Cart */
			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-cart.php' );
			
			/* Register Event */
			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-process-data.php' );
   			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-sendmail.php' );
   			require_once( OVAEM_PLUGIN_PATH.'/pdf/class-ovaem-make-pdf.php' );
   			require_once( OVAEM_PLUGIN_PATH.'/qrcode/class-ovaem-make-qrcode.php' );

   			/* Coupon */
   			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-coupon.php' );

   			/* Add Order */
			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-order.php' );

			/* Ticket Event */
			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-ticket.php' );

			/* Include Order, Ticket from Order Woo */
			require_once( OVAEM_PLUGIN_PATH.'/inc/import-order-ticket-woo.php' );

			/* Location Ajax */
			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-location.php' );
   			
   			// Check captcha

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-recapcha.php' );

			require_once( OVAEM_PLUGIN_PATH.'/inc/class-ovaem-custom-field-checkout.php' );

			if( is_admin() ){
				require_once( OVAEM_PLUGIN_PATH.'/admin/class-ovaem-admin.php' );
			}
			
		}

		protected function support_woocommerce(){
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				require_once 'woomodern/ovaemcptwoo.php';
			}	
		}

		public function rewirte_slug(){
			add_filter( 'register_post_type_args', array($this, 'em4u_change_post_types_slug' ), 10, 2 );
			
		}

		public function em4u_change_post_types_slug( $args, $post_type ) {

			

		   // Event Slug
		   $event_slug = OVAEM_Settings::event_post_type_slug();
		   $event_rewrite_slug = OVAEM_Settings::event_post_type_rewrite_slug();
		   if ( $event_slug === $post_type && $event_slug != $event_rewrite_slug && $event_rewrite_slug != '' ) {
		      $args['rewrite']['slug'] = $event_rewrite_slug;
		   }

		   // Speaker
		   $speaker_slug = OVAEM_Settings::speaker_post_type_slug();
		   $speaker_rewrite_slug = OVAEM_Settings::speaker_post_type_rewrite_slug();
		   if ( $speaker_slug === $post_type && $speaker_slug != $speaker_rewrite_slug && $speaker_rewrite_slug != '' ) {
		      $args['rewrite']['slug'] = $speaker_rewrite_slug;
		   }

		   // Venue
		   $venue_slug = OVAEM_Settings::venue_post_type_slug();
		   $venue_rewrite_slug = OVAEM_Settings::venue_post_type_rewrite_slug();
		   if ( $venue_slug === $post_type && $venue_slug != $venue_rewrite_slug && $venue_rewrite_slug != '' ) {
		      $args['rewrite']['slug'] = $venue_rewrite_slug;
		   }
		   

		   return $args;
		}


		/**
		 * Main Ova Events Manager Instance.
		 */
		public static function instance() {
			if ( !empty( self::$_instance ) ) {
				return self::$_instance;
			}
			return self::$_instance = new self();
		}

		public static function ovaem_add_role(){

			$admin_review = OVAEM_Settings::user_submit_admin_review();

			add_role(
			    'ovaem_event_manager',
			    esc_html__( 'Events Manager', 'ovaem-events-manager' ),
			    array(
			        'read'         => true,
			        'edit_posts'   => true,
			        'delete_posts' => true,
			        'delete_published_posts' => true,
			    )
			);

			$role = get_role( 'ovaem_event_manager' );

			
			if( $admin_review == 'true' ){
				$role->add_cap( 'edit_published_posts' );
				$role->remove_cap( 'publish_posts' );
			}else{
				$role->add_cap( 'edit_published_posts' );
				$role->add_cap( 'publish_posts' );
			}
		    $role->add_cap( 'upload_files' ); 
		}


	}

}


/**
 * Main instance of Ova Events Manager
 */
function OVAEM() {
	return OVAEM::instance();
}

$GLOBALS['OVAEM'] = OVAEM();



// Add role, cap
add_action( 'admin_init', array( 'OVAEM',  'ovaem_add_role') );



