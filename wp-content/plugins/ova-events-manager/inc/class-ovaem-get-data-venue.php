<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class OVAEM_Get_Data_Venue {

	private static $prefix = '';

	
	/**
	 * The Constructor
	 */
	public function __construct() {
		
		self::$prefix = OVAEM_Settings::$prefix;

		add_filter( 'ovaem_get_venues_list', array( $this, 'ovaem_get_venues_list' ), 10, 5  );
		
		
		
		
	}

	private function ovaem_query_base( $paged = '', $orderby = 'date', $order = 'ASC' ){

		$args_base = array(
			'post_type' => OVAEM_Settings::venue_post_type_slug(),
			'post_status' => 'publish',
			'order'	=> $order,
		);
		
		$args_paged = ( $paged != '' ) ? array( 'paged' => $paged ) : array();

		$args_orderby = ($orderby == 'date') ? array( 'orderby' => 'date' ) : array( 'orderby' => 'meta_value_num', 'meta_key' => $orderby );

		return array_merge_recursive( $args_base, $args_paged, $args_orderby );

	}

	

	/**
	 * Get Venues by array slugs
	 */
	public function ovaem_get_venues_list($array_venues_slugs,  $show_featured, $count, $orderby = 'date', $order = 'ASC' ){

		$args_base = $this->ovaem_query_base( $paged = '' , $orderby, $order);
		$args_count = array( 'posts_per_page' => $count );
		
		$args_name = $args_featured =array();

		if( !empty( $array_venues_slugs ) ){
			$args_name = array(
				'post_name__in' => $array_venues_slugs
			);	
		}

		if( $show_featured == 'true' ){
			$args_featured = array(
				'meta_query' => array(
					array(
						'key'     => self::$prefix.'_venue_featured',
						'value'   => 'yes',
						'compare' => '=',
					)
				)
			);
		}
		

		$args = array_merge_recursive( $args_base, $args_count, $args_name, $args_featured );

		
		$list = new WP_Query($args);

		return $list;
	}

	
	





}

new OVAEM_Get_Data_Venue();
