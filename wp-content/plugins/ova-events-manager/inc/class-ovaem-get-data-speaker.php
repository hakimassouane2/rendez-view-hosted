<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class OVAEM_Get_Data_Speaker {

	
	private static $speaker_post_type_slug = '';
	private static $prefix = '';

	
	/**
	 * The Constructor
	 */
	public function __construct() {

		
		self::$speaker_post_type_slug = OVAEM_Settings::speaker_post_type_slug();
		self::$prefix = OVAEM_Settings::$prefix;

		add_filter( 'ovaem_speaker', array( $this, 'ovaem_speaker' ), 10, 1  );
		add_filter( 'ovaem_get_speakers_list', array( $this, 'ovaem_get_speakers_list' ), 10, 5  );
		add_filter( 'ovaem_archive_speaker', array( $this, 'ovaem_archive_speaker' ), 10, 0 );
		
	}


	private function ovaem_query_base( $paged = '', $orderby = 'date', $order = 'ASC' ){

		$list_speakers_post_per_page = OVAEM_Settings::list_speakers_post_per_page();
		$list_speakers_post_per_page = isset($list_speakers_post_per_page) && $list_speakers_post_per_page ? $list_speakers_post_per_page : 12;

		$args_base = array(
			'post_type' => self::$speaker_post_type_slug,
			'post_status' => 'publish',
			'order'	=> $order,
		);
		
		$args_paged = ( $paged != '' ) ? array( 'paged' => $paged ) : array();

		$args_orderby = ($orderby == 'date') ? array( 'orderby' => 'date' ) : array( 'orderby' => 'meta_value_num', 'meta_key' => $orderby );

		return array_merge_recursive( $args_base, $args_paged, $args_orderby );

	}

	
	/**
	 *  Archive speaker
	 */
	public function ovaem_archive_speaker(){
		
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		$orderby = OVAEM_Settings::list_speakers_orderby();
		$order = OVAEM_Settings::list_speakers_order();

		$args = $this->ovaem_query_base( $paged , $orderby, $order);

		$speaker = new WP_Query( $args );

		return $speaker;
	}

	

	/**
	 * Get speaker by slug
	 */
	public function ovaem_speaker($speaker_slug){

		$args = array(
			'post_type' => self::$speaker_post_type_slug,
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'name' => $speaker_slug
		);

		$speaker = get_posts( $args );

		return $speaker;
	}

	

	/**
	 * Get Venues by array slugs
	 */
	public function ovaem_get_speakers_list($speaker_slugs, $show_featured, $count, $orderby, $order){

		$args_slug = $args_featured = array();
		$args_base = $this->ovaem_query_base( $paged = '', $orderby, $order );
		$args_count = array( 'posts_per_page' => $count );

		if( !empty( $speaker_slugs ) ){
			$args_slug = array(
				'post_name__in' => $speaker_slugs
			);	
		}
		
		if( $show_featured == 'true' ){

			$args_featured = array(
				'meta_query' => array(
					array(
						'key'     => self::$prefix.'_speaker_featured',
						'value'   => 'yes',
						'compare' => '=',
					),
				)
			);

		}


		$args = array_merge_recursive( $args_base, $args_count, $args_slug, $args_featured );

		
		
		$list = new WP_Query($args);

		return $list;
	}








}

new OVAEM_Get_Data_Speaker();
