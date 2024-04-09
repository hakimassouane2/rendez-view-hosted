<?php 

if( !defined( 'ABSPATH' ) ) exit();


if( !class_exists( 'OVAEM_Admin' ) ){

	/**
	 * Make Admin Class
	 */
	class OVAEM_Admin{
		public static $custom_meta_fields = array();

		/**
		 * Construct Admin
		 */
		public function __construct(){
			$this->init();

		}

		public function init(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-admin-settings.php' );
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-admin-menu.php' );
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-admin-assets.php' );
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-admin-metaboxes.php' );
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-admin-ajax.php' );
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-admin-orders.php' );
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-admin-tickets.php' );
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-export-page.php' );
			require_once( OVAEM_PLUGIN_PATH. '/admin/class-ovaem-cfc-settings.php' );
			
		}


	}
	new OVAEM_Admin();


	

}