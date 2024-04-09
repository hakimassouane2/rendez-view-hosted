<?php 
defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEM_Admin_Assets' ) ){
	class OVAEM_Admin_Assets{

		public function __construct(){

			add_action( 'admin_footer', array( $this, 'enqueue_scripts' ), 10, 2 );
		}

		public function enqueue_scripts(){

			// Google Map
			if( OVAEM_Settings::google_key_map() != '' ){
				wp_enqueue_script( 'google-map-api','https://maps.googleapis.com/maps/api/js?key='.OVAEM_Settings::google_key_map().'&callback=Function.prototype&libraries=places', false, true );
				echo '<script>var google_map = true;</script>';
			}else{
				echo '<script>var google_map = false;</script>';
			}

			wp_enqueue_script('lib_js', OVAEM_PLUGIN_URI.'assets/js/admin/map.js', array('jquery'),false,true);
			
			
			// Jquery UI
			wp_enqueue_script('jquery_ui_js', OVAEM_PLUGIN_URI.'assets/libs/jquery-ui/jquery-ui.js', array('jquery'),false,true);
			
			// Date Time Picker
			wp_enqueue_script('datetimepicker_js', OVAEM_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.full.min.js', array('jquery'), false, true );
			
			


			// Init admin js
			wp_enqueue_script('admin_js', OVAEM_PLUGIN_URI.'assets/js/admin/script.js', array('jquery'),false,true);
			wp_localize_script( 'admin_js', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

			// Gallery Metabox
			wp_enqueue_script('image_metabox', OVAEM_PLUGIN_URI.'assets/js/admin/image.js', array('jquery'),false,true);
			wp_enqueue_script('gallery_metabox', OVAEM_PLUGIN_URI.'assets/js/admin/gallery-metabox.js', array('jquery'),false,true);
			
			
			

			// Jquery UI
			wp_enqueue_style('jquery_ui_css', OVAEM_PLUGIN_URI.'assets/libs/jquery-ui/jquery-ui.css' );

			// Date Time Picker
			wp_enqueue_style('datetimepicker_css', OVAEM_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.css' );

			// Font Awesome
			wp_enqueue_style('font-awesome', OVAEM_PLUGIN_URI.'assets/libs/font-awesome/css/font-awesome.min.css' );

			// Init Css Admin
			wp_enqueue_style( 'admin_css', OVAEM_PLUGIN_URI.'assets/css/admin/style.css' );
			 
		}



	}
	new OVAEM_Admin_Assets();
}
