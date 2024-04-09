<?php
defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEM_Admin_Menu' ) ){

	class OVAEM_Admin_Menu{

		public function __construct(){
			$this->init();
		}

		public function init(){
			add_action( 'admin_menu', array( $this, 'ovaem_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'ovaem_remove_menu_items' ) );
		}

		public function ovaem_admin_menu(){

			// Get Options
			
	 		$slug = OVAEM_Settings::event_post_type_slug() ? OVAEM_Settings::event_post_type_slug() : '';
	 		$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name() ? OVAEM_Settings::slug_taxonomy_name() : '';
	 			

			add_menu_page( 
				__( 'Events Manager', 'ovaem-events-manager' ), 
				__( 'Events Manager', 'ovaem-events-manager' ), 
				'edit_posts', 
				'ova-events-menu', 
				null, 
				'dashicons-calendar-alt', 
				4
				);
			add_submenu_page( 
				'ova-events-menu', 
				__( 'Location', 'ovaem-events-manager' ), 
				__( 'Location', 'ovaem-events-manager' ), 
				'administrator', 
				'edit-tags.php?taxonomy=location&post_type='.$slug
			);
			
			add_submenu_page( 
				'ova-events-menu', 
				__( $slug.' '.$slug_taxonomy_name, 'ovaem-events-manager' ), 
				__( $slug.' '.$slug_taxonomy_name, 'ovaem-events-manager' ), 
				'administrator', 
				'edit-tags.php?taxonomy='.$slug_taxonomy_name.'&post_type='.$slug
			);

			

			add_submenu_page(
				'ova-events-menu', 
				__( 'Tags', 'ovaem-events-manager' ), 
				__( 'Tags', 'ovaem-events-manager' ), 
				'manage_options', 
				'edit-tags.php?taxonomy=event_tags'.'&post_type='.$slug
			);

			add_submenu_page( 
				'ova-events-menu', 
				__( 'Export', 'ovaem-events-manager' ), 
				__( 'Export', 'ovaem-events-manager' ), 
				'manage_options', 
				'export_page', 
				array( 'OVAEM_Admin_Export', 'create_admin_export_page' )
			);

			add_submenu_page( 
				'ova-events-menu', 
				__( 'Settings', 'ovaem-events-manager' ), 
				__( 'Settings', 'ovaem-events-manager' ), 
				'administrator', 
				'general_settings', 
				array( 'OVAEM_Admin_Settings', 'create_admin_setting_page' ),
				11
			);

		}
		public function ovaem_remove_menu_items() {
		    if( !current_user_can( 'administrator' ) ):
		        remove_submenu_page( 'ova-events-menu','edit.php?post_type=coupon' );
		        remove_submenu_page( 'ova-events-menu','edit.php?post_type=event_order' );
		    endif;
		}
		

	}
	new OVAEM_Admin_Menu();

}