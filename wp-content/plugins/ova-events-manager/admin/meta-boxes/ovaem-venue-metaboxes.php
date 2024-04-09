<?php 

if( !defined( 'ABSPATH' ) ) exit();

if( !class_exists( 'OVAEM_Venue_Metaboxes' ) ){

	class OVAEM_Venue_Metaboxes{

		public static function render(){
			require_once( OVAEM_PLUGIN_PATH. '/admin/views/ovaem-metabox-venue.php' );

		}

		public static function save($post_id, $post_data){

			$prefix = OVAEM_Settings::$prefix;

			if( empty($post_data) ) exit();

			if( array_key_exists($prefix.'_speaker_social', $post_data) == false )   $post_data[$prefix.'_speaker_social'] = '';
			
			foreach ($post_data as $key => $value) {
				update_post_meta( $post_id, $key, $value );	
			}
			
			
		}


		
	}

}

