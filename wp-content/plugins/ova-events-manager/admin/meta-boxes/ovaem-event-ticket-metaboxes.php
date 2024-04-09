<?php 

if( !defined( 'ABSPATH' ) ) exit();

if( !class_exists( 'OVAEM_Event_Ticket_Metaboxes' ) ){

	class OVAEM_Event_Ticket_Metaboxes{

		public static function render(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-ticket.php' );
		}

		public static function save($post_id, $post_data){

			$prefix = OVAEM_Settings::$prefix;

			if( empty($post_data) ) exit();

			foreach ($post_data as $key => $value) {
				update_post_meta( $post_id, $key, sanitize_text_field($value) );	
			}
			
			
		}

	}

}



 ?>