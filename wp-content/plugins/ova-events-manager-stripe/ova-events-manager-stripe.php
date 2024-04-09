<?php
/*
Plugin Name: OVA Events Manager Stripe Payment Gateway
Plugin URI: https://themeforest.net/user/ovatheme
Description: OVA Events Manager Stripe
Author: Ovatheme
Version: 1.1.4
Author URI: https://themeforest.net/user/ovatheme/portfolio
Text Domain: ova-events-manager-stripe
*/

if ( !defined( 'ABSPATH' ) ) exit();

/**
 * OVA_EVENTS_MANAGER_STRIPE Class
 */

if( !class_exists( 'OVA_EVENTS_MANAGER_STRIPE' ) ){

	class OVA_EVENTS_MANAGER_STRIPE{

		private static $_instance = null;

		/**
		 * Check Events Manager activated
		 *
		 * @var bool
		 */
		protected static $_ovaem_loaded = false;

		/**
		 * Notice for error
		 *
		 * @var
		 */
		protected static $_notice;

		
		/**
		 * OVAEM Constructor
		 */

		public function __construct(){

			// If Event Manager is actived
			if( self::$_ovaem_loaded ){
				$this->define_constants();
				$this->includes();
				
			}
			
		}


		/**
		 * Define constants
		 */
		public function define_constants(){
			$this->define( 'OVA_STRIPE_PLUGIN_FILE', __FILE__ );
			$this->define( 'OVA_STRIPE_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
			$this->define( 'OVA_STRIPE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			load_plugin_textdomain( 'ova-events-manager-stripe', false, basename( dirname( __FILE__ ) ) .'/languages' ); 
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
			
			// Checkout Form 
			require_once( OVA_STRIPE_PLUGIN_PATH.'/stripe-php-master/init.php' );
			require_once( OVA_STRIPE_PLUGIN_PATH.'/inc/init.php' );


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

		/**
		 * Plugin load
		 */
		public static function load() {

			if ( !function_exists( 'is_plugin_active' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			// check Events Manager Plugin activated
			if ( class_exists('OVAEM') && is_plugin_active( 'ova-events-manager/ova-events-manager.php' ) ) {
				self::$_ovaem_loaded = true;
			} else {
				self::$_ovaem_loaded = false;
				if ( !self::$_notice ) {
					self::$_notice = 'required_active_ovaem';
				}
			}

			OVA_EVENTS_MANAGER_STRIPE::instance();

			if ( !self::$_ovaem_loaded ) {
				add_action( 'admin_notices', array( __CLASS__, 'admin_notice' ) );
			}

		}

		/*
		 * Show admin notice when active plugin
		 */
		public static function admin_notice() {
			?>
			<div class="error">
				<?php
				switch ( self::$_notice ) {
					case 'required_active_ovaem':
						echo '<p>' . __( wp_kses( '<strong>Ova Events Manager Plugin </strong> requires <strong></strong> is activated. Please install and active it before you can using this add-on.', array( 'strong' => array() ) ), 'ova-events-manager-stripe' ) . '</p>';
						break;
				} ?>
			</div>
			<?php
		}

		

	}

}

add_action( 'plugins_loaded', array( 'OVA_EVENTS_MANAGER_STRIPE', 'load' ) );

