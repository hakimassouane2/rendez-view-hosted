<?php
/**
 * Main initialization class.
 *
 * @package WooModern\OvaemCptWoo
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

require_once OVAEM_PLUGIN_PATH . 'woomodern/vendor/autoload.php';

use WooModern\OvaemCptWoo\Hooks\FilterHooks;
use WooModern\OvaemCptWoo\Traits\SingletonTrait;;

if ( ! class_exists( OVAEM_CPT_Woo::class ) ) {
	/**
	 * Main initialization class.
	 */
	final class OVAEM_CPT_Woo {
		
		/**
		 * Singleton
		 */
		use SingletonTrait;

		/**
		 * Class Constructor
		 */
		private function __construct() {

			// HPOS
			add_action( 'before_woocommerce_init', function() {
				if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
					\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', OVAEM_PLUGIN_FILE, true );
				}
			} );

			 $this->init_controller();

        }

		/**
		 * Init
		 *
		 * @return void
		 */
		public function init_controller() {

			// Include File.
            FilterHooks::instance();
		}
	}

	/**
	 * @return OVAEM_CPT_Woo
	 */
	function ovaem_cpt_woo() {
		return OVAEM_CPT_Woo::instance();
	}

	ovaem_cpt_woo();
}