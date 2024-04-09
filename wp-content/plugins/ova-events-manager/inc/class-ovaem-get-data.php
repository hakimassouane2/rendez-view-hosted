<?php

if (!defined('ABSPATH')) {
	exit;
}

class OVAEM_Get_Data {

	private static $slug_taxonomy_name = null;
	private static $event_post_type_slug = null;
	private static $upcomming_days = null;
	private static $prefix = '';

	/**
    * The Constructor
    */
	public function __construct() {
		self::$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
		self::$event_post_type_slug = OVAEM_Settings::event_post_type_slug();
		self::$upcomming_days = OVAEM_Settings::upcomming_days();
		self::$prefix = OVAEM_Settings::$prefix;

		add_filter('ovaem_get_categories', array($this, 'ovaem_get_categories'), 10, 0);
		add_filter('ovaem_get_categories_params', array($this, 'ovaem_get_categories_params'), 10, 1);
		add_filter('ovaem_search_event', array($this, 'ovaem_search_event'), 10, 1);
		add_filter('ovaem_events_orderby', array($this, 'ovaem_events_orderby'), 10, 6);
		add_filter('ovaem_events', array($this, 'ovaem_events'), 10, 2);
		add_filter('ovaem_archive_event', array($this, 'ovaem_archive_event'), 10, 3);
		add_filter('ovaem_event', array($this, 'ovaem_event'), 10, 1);
		add_filter('ovaem_events_by_cat', array($this, 'ovaem_events_by_cat'), 10, 4);
		add_filter('ovaem_events_by_tag', array($this, 'ovaem_events_by_tag'), 10, 4);
		add_filter('ovaem_upcoming_past_featured_event', array($this, 'ovaem_upcoming_past_featured_event'), 10, 4);
		add_filter('ovaem_venues', array($this, 'ovaem_venues'), 10, 0);
		add_filter('ovaem_get_events_by_speaker', array($this, 'ovaem_get_events_by_speaker'), 10, 1);
		add_filter('ovaem_get_price', array($this, 'ovaem_get_price'), 10, 1);
		add_filter('ovaem_get_related_events', array($this, 'ovaem_get_related_events'), 10, 1);
		add_filter('ovaem_get_venue_joined_event', array($this, 'ovaem_get_venue_joined_event'), 10, 1);
		add_filter('ovaem_check_status_event', array($this, 'ovaem_check_status_event'), 10, 2);

		add_filter('ovaem_location_event', array($this, 'ovaem_location_event'), 10, 4);

		add_filter('ovaem_get_locs', array($this, 'ovaem_get_locs'), 10, 0);

      // Get Count Event of Cat
		add_filter('ovaem_get_count_e_cat', array($this, 'ovaem_get_count_e_cat'), 10, 2);

      // Get Count Event of Location
		add_filter('ovaem_get_count_e_loc', array($this, 'ovaem_get_count_e_loc'), 10, 2);

      // Get list Booking
		add_filter('ovaem_get_list_booking', array($this, 'ovaem_get_list_booking'), 10, 1);

      // Get Parent Tax Country
		add_filter('ovaem_get_country', array($this, 'ovaem_get_country'), 10, 3);

      // Get Child Tax Country is city
		add_filter('ovaem_get_city', array($this, 'ovaem_get_city'), 10, 3);

	}

	private function ovaem_query_base($paged = '', $orderby = 'date', $order = 'ASC', $show_past = 'true', $show_current = 'true') {

		$args_base = $args_paged = $args_orderby = $args_past = $args_current = array();

		$args_base = array(
			'post_type' => self::$event_post_type_slug,
			'post_status' => 'publish',
			'order' => $order,
		);

		$args_paged = ($paged != '') ? array('paged' => $paged) : array();

		if( $orderby == 'date' ){
			
			$args_orderby = array('orderby' => 'date');

		}else if ( $orderby == '' ){

			$args_orderby = array('orderby' => 'meta_value_num', 'meta_key' => $orderby );

		}else if ( $orderby == 'title' ){

			$args_orderby = array( 'orderby' => 'title' );

		}else if ( $orderby == 'ID' ){

			$args_orderby = array( 'orderby' => 'ID' );
			
		}else if( $orderby == 'ovaem_order' ){

			$args_orderby = array('orderby' => 'meta_value_num', 'meta_key' => 'ovaem_order' );

		}else if( $orderby == 'ovaem_date_end_time' ){

			$args_orderby = array('orderby' => 'meta_value_num', 'meta_key' => 'ovaem_date_end_time' );

		}else if( $orderby == 'ovaem_date_start_time' ){

			$args_orderby = array('orderby' => 'meta_value_num', 'meta_key' => 'ovaem_date_start_time' );
			
		}


		

		if ($show_past === 'false') {

			$args_past = array(
				'meta_query' => array(
					array(
						'key' => self::$prefix . '_date_end_time',
						'value' => current_time('timestamp'),
						'compare' => '>',
					),
				),
			);
		}

		if ($show_current === 'false') {

			$args_current = array(
				'meta_query' => array(
					array(
						'relation' => 'OR',
						array(
							'key' => self::$prefix . '_date_end_time',
							'value' => current_time('timestamp'),
							'compare' => '<',
						),
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => current_time('timestamp'),
							'compare' => '>',
						),
					),
				),
			);
		}

		return array_merge_recursive($args_base, $args_paged, $args_orderby, $args_past, $args_current);
	}

	/**
    * Get All Categories
    */

	public function ovaem_get_categories() {

		$orderby = apply_filters( 'el_select_cats_orderby', 'title' );
		$order = apply_filters( 'el_select_cats_order', 'ASC' );

		$args = array(
			'type' => self::$event_post_type_slug,
			'child_of' => 0,
			'parent' => '',
			'orderby' => $orderby,
			'order' => $order,
			'hide_empty' => 0,
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'number' => '',
			'taxonomy' => self::$slug_taxonomy_name,
			'pad_counts' => false,

		);

		return get_categories($args);
	}

	/* categories paramenter */
	public function ovaem_get_categories_params($selected) {

		$orderby = apply_filters( 'el_select_cats_orderby', 'title' );
		$order = apply_filters( 'el_select_cats_order', 'ASC' );


		$args = array(
			'show_option_all' => '',
			'show_option_none' => esc_html__('All Categories', 'ovaem-events-manager'),
			'option_none_value' => '',
			'orderby' => $orderby,
			'order' => $order,
			'show_count' => 0,
			'hide_empty' => 0,
			'child_of' => 0,
			'exclude' => '',
			'include' => '',
			'echo' => 0,
			'selected' => $selected,
			'hierarchical' => 1,
			'name' => 'cat',
			'id' => '',
			'class' => 'selectpicker ',
			'depth' => 0,
			'tab_index' => 0,
			'type' => self::$event_post_type_slug,
			'taxonomy' => self::$slug_taxonomy_name,
			'hide_if_empty' => false,
			'value_field' => 'slug',
		);

		return ($args);
	}

	/**
    * Search Event
    */
	public function ovaem_search_event($params) {

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$name = isset($params['name_event']) ? esc_html($params['name_event']) : '';
		$cat = isset($params['cat']) ? esc_html($params['cat']) : '';
		$name_venue = isset($params['name_venue']) ? esc_html($params['name_venue']) : '';
		$time = isset($params['time']) ? esc_html($params['time']) : '';
      // $date = isset( $params['ovaem_date'] ) ? esc_html( $params['ovaem_date'] ) : '' ;
		$ovaem_date_from = isset($params['ovaem_date_from']) ? esc_html($params['ovaem_date_from']) : '';
		$ovaem_date_to = isset($params['ovaem_date_to']) ? esc_html($params['ovaem_date_to']) : '';

		$name_country = (isset($params['name_country']) && $params['name_country'] != '') ? esc_html($params['name_country']) : '';
		$name_city = (isset($params['name_city']) && $params['name_city'] != '') ? esc_html($params['name_city']) : '';

      // Init query
		$args_basic = $args_name = $args_address = $args_venue = $args_time = $args_tax = $args_date = $args_country = $args_city = array();

		$show_past = ($time != 'past') ? OVAEM_Settings::search_event_show_past() : 'true';
		$orderby = OVAEM_Settings::search_event_orderby();
		$order = OVAEM_Settings::search_event_order();

      // Query base
		$args_basic = $this->ovaem_query_base($paged, $orderby, $order, $show_past);

	  // Return an array of event IDs.
		$args_basic['fields'] = 'ids';

      // Query Name
		if ($name) {
			$args_name = array('s' => $name);
		}

      // Query Taxonomy
		if ($cat) {
			$args_tax = array(
				'tax_query' => array(
					array(
						'taxonomy' => self::$slug_taxonomy_name,
						'field' => 'slug',
						'terms' => $cat,
					),
				),
			);
		}

      // Query Venue
		if ($name_venue) {
			$args_venue = array(
				'meta_query' => array(
					array(
						'key' => self::$prefix . '_venue',
						'value' => $name_venue,
						'compare' => 'LIKE',
					),

				),
			);
		}

      // Query Country
		if ($name_country) {
			$args_country = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'location',
						'field' => 'slug',
						'terms' => $name_country,
					),
				),
			);
		}

      // Query City
		if ($name_city) {
			$args_city = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'location',
						'field' => 'slug',
						'terms' => $name_city,
					),
				),
			);
		}

      // Query Time
		if ($time) {

			$date_format = get_option('date_format');
			$today_day = current_time($date_format);

         // Return number of current day
			$num_day_current = date('w', strtotime($today_day));

         // Check start of week in wordpress
			$start_of_week = get_option('start_of_week');

         // Return time first day in week
			$week_start = strtotime($today_day) - (($num_day_current - $start_of_week) * 24 * 60 * 60);
         // Return time end day in week
			$week_end = strtotime($today_day) + (7 - $num_day_current + $start_of_week) * 24 * 60 * 60;

         // Next week Start
			$next_week_start = strtotime($today_day) + (7 - $num_day_current + $start_of_week) * 24 * 60 * 60;
         // Next week End
			$next_week_end = $next_week_start + 7 * 24 * 60 * 60;

         // Month Current
			$num_day_current = date('n', strtotime($today_day));

         // First day of next month
			$first_day_next_month = strtotime(date($date_format, strtotime('first day of next month')));
			$last_day_next_month = strtotime(date($date_format, strtotime('last day of next month')));

         // Get Weekend
			$weekend_days = OVAEM_Settings::search_time_this_week_end_day();
			if (isset($weekend_days[0])) {

				if (count($weekend_days[0]) > 1) {
					$start_weekend_day = strtotime($weekend_days[0][0] . ' this week');
					$end_weekend_day = strtotime($weekend_days[0][count($weekend_days[0]) - 1] . ' this week');
				} else {
					$start_weekend_day = strtotime($weekend_days[0][0] . ' this week');
					$end_weekend_day = strtotime($weekend_days[0][0] . ' this week');
				}

			} else {
				$start_weekend_day = strtotime('saturday this week');
				$end_weekend_day = strtotime('sunday this week');
			}

			switch ($time) {

				case 'today':
				$args_time = array(
					'meta_query' => array(
						array(
							'relation' => 'OR',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => array(strtotime($today_day) - 1, strtotime($today_day) + (24 * 60 * 60) + 1),
								'type' => 'numeric',
								'compare' => 'BETWEEN',
							),
							array(
								'relation' => 'AND',
								array(
									'key' => self::$prefix . '_date_start_time',
									'value' => strtotime($today_day),
									'compare' => '<',
								),
								array(
									'key' => self::$prefix . '_date_end_time',
									'value' => strtotime($today_day),
									'compare' => '>=',
								),
							),
						),
					),
				);
				break;

				case 'tomorrow':
				$args_time = array(
					'meta_query' => array(
						array(
							'relation' => 'OR',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => array(strtotime($today_day) + (24 * 60 * 60) - 1, strtotime($today_day) + (2 * 24 * 60 * 60) + 1),
								'type' => 'numeric',
								'compare' => 'BETWEEN',
							),
							array(
								'relation' => 'AND',
								array(
									'key' => self::$prefix . '_date_start_time',
									'value' => strtotime($today_day) + (24 * 60 * 60),
									'compare' => '<',
								),
								array(
									'key' => self::$prefix . '_date_end_time',
									'value' => strtotime($today_day) + (24 * 60 * 60),
									'compare' => '>=',
								),
							),
						),
					),

				);
				break;

				case 'this_week':
				$args_time = array(

					'meta_query' => array(
						array(
							'relation' => 'OR',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => array($week_start - 1, $week_end + 1),
								'type' => 'numeric',
								'compare' => 'BETWEEN',
							),
							array(
								'relation' => 'AND',
								array(
									'key' => self::$prefix . '_date_start_time',
									'value' => $week_start,
									'compare' => '<',
								),
								array(
									'key' => self::$prefix . '_date_end_time',
									'value' => $week_start,
									'compare' => '>=',
								),
							),
						),
					),

				);
				break;

				case 'this_week_end':
				$args_time = array(

					'meta_query' => array(
						array(
							'relation' => 'OR',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => array($start_weekend_day - 1, $end_weekend_day + 24 * 60 * 60 + 1),
								'type' => 'numeric',
								'compare' => 'BETWEEN',
							),
							array(
								'relation' => 'AND',
								array(
									'key' => self::$prefix . '_date_start_time',
									'value' => $start_weekend_day,
									'compare' => '<',
								),
								array(
									'key' => self::$prefix . '_date_end_time',
									'value' => $start_weekend_day,
									'compare' => '>=',
								),
							),
						),
					),

				);
				break;

				case 'next_week':
				$args_time = array(

					'meta_query' => array(
						array(
							'relation' => 'OR',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => array($next_week_start - 1, $next_week_end + 1),
								'type' => 'numeric',
								'compare' => 'BETWEEN',
							),
							array(
								'relation' => 'AND',
								array(
									'key' => self::$prefix . '_date_start_time',
									'value' => $next_week_start,
									'compare' => '<',
								),
								array(
									'key' => self::$prefix . '_date_end_time',
									'value' => $next_week_start,
									'compare' => '>=',
								),
							),
						),
					),

				);
				break;
				case 'next_month':
				$args_time = array(

					'meta_query' => array(
						array(
							'relation' => 'OR',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => array($first_day_next_month - 1, $last_day_next_month + 24 * 60 * 60 + 1),
								'type' => 'numeric',
								'compare' => 'BETWEEN',
							),
							array(
								'relation' => 'AND',
								array(
									'key' => self::$prefix . '_date_start_time',
									'value' => $first_day_next_month,
									'compare' => '<',
								),
								array(
									'key' => self::$prefix . '_date_end_time',
									'value' => $first_day_next_month,
									'compare' => '>=',
								),
							),
						),
					),

				);
				break;
				case 'past':
				$args_time = array(
					'meta_query' => array(
						array(
							'key' => self::$prefix . '_date_end_time',
							'value' => current_time('timestamp'),
							'compare' => '<',
						),
					),
				);
				break;
				case 'future':
				$args_time = array(

					'meta_query' => array(
						array(
							'relation' => 'OR',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => current_time('timestamp'),
								'compare' => '>',
							),
							array(
								'relation' => 'AND',
								array(
									'key' => self::$prefix . '_date_start_time',
									'value' => current_time('timestamp'),
									'compare' => '<=',
								),
								array(
									'key' => self::$prefix . '_date_end_time',
									'value' => current_time('timestamp'),
									'compare' => '>',
								),
							),

						),
					),

				);
				break;

				default:
            # code...
				break;
			}

		}

      // Query date
		if ($ovaem_date_from && $ovaem_date_to) {

			$args_date = array(
				'meta_query' => array(

					array(
						'relation' => 'OR',
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => array(strtotime($ovaem_date_from) - 1, strtotime($ovaem_date_to) + (24 * 60 * 60) + 1),
							'type' => 'numeric',
							'compare' => 'BETWEEN',
						),
						array(
							'relation' => 'AND',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => strtotime($ovaem_date_from),
								'compare' => '<',
							),
							array(
								'key' => self::$prefix . '_date_end_time',
								'value' => strtotime($ovaem_date_from),
								'compare' => '>=',
							),
						),
					),

				),
			);

		} else if ($ovaem_date_from && !$ovaem_date_to) {

			$args_date = array(
				'meta_query' => array(

					array(
						'relation' => 'OR',
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => strtotime($ovaem_date_from),
							'compare' => '>=',
						),
						array(
							'relation' => 'AND',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => strtotime($ovaem_date_from),
								'compare' => '<',
							),
							array(
								'key' => self::$prefix . '_date_end_time',
								'value' => strtotime($ovaem_date_from),
								'compare' => '>=',
							),
						),
					),

				),
			);

		} else if (!$ovaem_date_from && $ovaem_date_to) {

			$args_date = array(
				'meta_query' => array(
					'key' => self::$prefix . '_date_end_time',
					'value' => strtotime($ovaem_date_to) + (24 * 60 * 60),
					'compare' => '<=',
				),

			);

		}

		$args = array_merge_recursive($args_basic, $args_venue, $args_name, $args_time, $args_tax, $args_date, $args_country, $args_city);

		add_filter('posts_where', array($this, 'ovaem_title_filter'), 10, 2);

		$events = new WP_Query($args);

		remove_filter('posts_where', array($this, 'ovaem_title_filter'), 10, 2);

		return $events;
	}

	/**
    * Change search event title in default search
    */
	public function ovaem_title_filter($where, $wp_query) {
		global $wpdb;
		if ($search_term = $wp_query->get('search_prod_title')) {
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($search_term) . '%\'';
		}
		return $where;
	}

	/**
    * Get data order by upcoming, past, featured
    */
	public function ovaem_events_orderby($filter = 'upcomming', $count = '', $cat = '', $orderby = 'date', $order = 'ASC', $show_past = 'true') {

		$args_filter = $tax_query = array();
		$paged = '';

		$args_basic = $this->ovaem_query_base($paged, $orderby, $order, $show_past);

		switch ($filter) {

			case 'upcomming':
			$args_filter = array(
				'posts_per_page' => $count,
				'meta_query' => array(
					array(
						'relation' => 'AND',
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => current_time('timestamp'),
							'compare' => '>',
						),
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => current_time('timestamp') + (self::$upcomming_days * 24 * 60 * 60),
							'compare' => '<=',
						),
					),

				),
			);
			break;

			case 'upcomming_showing':
			$args_filter = array(
				'posts_per_page' => $count,
				'meta_query' => array(
					array(
						'relation' => 'OR',
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => current_time('timestamp'),
							'compare' => '>',
						),
						array(
							'relation' => 'AND',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => current_time('timestamp'),
								'compare' => '<',
							),
							array(
								'key' => self::$prefix . '_date_end_time',
								'value' => current_time('timestamp'),
								'compare' => '>=',
							),
						),
					),
				),
			);
			break;

			case 'featured':
			$args_filter = array(
				'posts_per_page' => $count,
				'meta_query' => array(
					array(
						'key' => self::$prefix . '_featured',
						'value' => 'checked',
						'compare' => '=',
					),
				),
			);
			break;

			case 'past':
			$args_filter = array(
				'posts_per_page' => $count,
				'meta_query' => array(
					array(
						'key' => self::$prefix . '_date_end_time',
						'value' => current_time('timestamp'),
						'compare' => '<',
					),
				),
			);
			break;

			case 'creation_date':
			$args_filter = array(
				'posts_per_page' => $count,
            // 'orderby' => 'post_date'
			);
			break;

			default:
			$args_filter = array(
				'posts_per_page' => $count,
				'post_name__in' => $filter,
			);

			break;
		}

		if ($cat) {
			$tax_query = array(
				'tax_query' => array(
					array(
						'taxonomy' => self::$slug_taxonomy_name,
						'field' => 'slug',
						'terms' => $cat,
					),
				),
			);
		}

		$args = array_merge_recursive($args_basic, $args_filter, $tax_query);

		$eventlist = new WP_Query($args);

		return $eventlist;
	}

	/**
    * Get all events
    */
	public function ovaem_events($order = 'ASC', $count = -1) {

		$args = array(
			'post_type' => self::$event_post_type_slug,
			'post_status' => 'publish',
			'orderby' => 'meta_value_num',
			'order' => $order,
			'meta_key' => self::$prefix . '_date_start_time',
			'posts_per_page' => $count,
			'fields' => 'ids'

		);

		$events = new WP_Query($args);

		return $events;
	}

	/**
    * Get Archive Events
    */
	public function ovaem_archive_event($orderby = 'date', $order = 'ASC', $show_past = 'true') {

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$args_basic = $this->ovaem_query_base($paged, $orderby, $order, $show_past);

		$events = new WP_Query($args_basic);

		return $events;
	}

	/**
    * Filter Event
    */
	public function ovaem_upcoming_past_featured_event($filter = 'upcomming', $orderby = 'date', $order = 'ASC', $show_past = 'true') {

		if (is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		} else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}

		$args_basic = $this->ovaem_query_base($paged, $orderby, $order, $show_past);

		switch ($filter) {
			case 'upcomming':
			$args_filter = array(
				'meta_query' => array(
					array(
						'relation' => 'AND',
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => current_time('timestamp'),
							'compare' => '>=',
						),
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => current_time('timestamp') + (self::$upcomming_days * 24 * 60 * 60),
							'compare' => '<=',
						),
					),

				),
			);
			break;

			case 'upcomming_showing':
			$args_filter = array(
				'posts_per_page' => $count,
				'meta_query' => array(
					array(
						'relation' => 'OR',
						array(
							'key' => self::$prefix . '_date_start_time',
							'value' => current_time('timestamp'),
							'compare' => '>',
						),
						array(
							'relation' => 'AND',
							array(
								'key' => self::$prefix . '_date_start_time',
								'value' => current_time('timestamp'),
								'compare' => '<',
							),
							array(
								'key' => self::$prefix . '_date_end_time',
								'value' => current_time('timestamp'),
								'compare' => '>=',
							),
						),
					),

				),
			);
			break;

			case 'featured':
			$args_filter = array(
				'meta_query' => array(
					array(
						'key' => self::$prefix . '_featured',
						'value' => 'checked',
						'compare' => '=',
					),
				),
			);
			break;
			case 'past':
			$args_filter = array(
				'meta_query' => array(
					array(
						'key' => self::$prefix . '_date_end_time',
						'value' => current_time('timestamp'),
						'compare' => '<',
					),
				),
			);
			break;
			default:
         # code...
			break;
		}

		$args = array_merge_recursive($args_basic, $args_filter);

		$events = new WP_Query($args);

		return $events;
	}

	/**
    * Get event by slug
    */
	public function ovaem_event($event_slug) {

		$args = array(
			'post_type' => self::$event_post_type_slug,
			'post_status' => 'publish',
			'name' => $event_slug,
			'posts_per_page' => 1,
		);

		$event = new WP_Query($args);

		return $event;
	}

	/**
    * Get Events by Category
    */
	public function ovaem_events_by_cat($term, $orderby = 'date', $order = 'ASC', $show_past = 'true') {

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$args_basic = $this->ovaem_query_base($paged, $orderby, $order, $show_past);

		$args_term = array(
			'tax_query' => array(
				array(
					'taxonomy' => self::$slug_taxonomy_name,
					'field' => 'slug',
					'terms' => $term,
				),
			),
		);

		$args = array_merge_recursive($args_basic, $args_term);

		$events = new WP_Query($args);

		return $events;
	}

	/**
    * Get events by tag
    */
	public function ovaem_events_by_tag($tag, $orderby = 'date', $order = 'ASC', $show_past = 'true') {

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$args_basic = $this->ovaem_query_base($paged, $orderby, $order, $show_past);

		$args_tags = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'event_tags',
					'field' => 'slug',
					'terms' => $tag,
				),
			),
		);

		$args = array_merge_recursive($args_basic, $args_tags);

		$events = new WP_Query($args);

		return $events;
	}

	/**
    * Get Venues
    */
	public function ovaem_venues() {

		$orderby = apply_filters( 'el_select_venue_orderby', 'title' );
		$order = apply_filters( 'el_select_venue_order', 'ASC' );

		$args_venue = array(
			'post_type' => OVAEM_Settings::venue_post_type_slug(),
			'post_status' => 'publish',
			'orderby'	=> $orderby,
			'order'	=> $order,
			'posts_per_page' => '-1',
			'nopaging'	=> true
		);

		$venue = new WP_Query($args_venue);

		return $venue;
	}


	public static function ovaem_get_venues() {

		$orderby = apply_filters( 'el_select_venue_orderby', 'title' );
		$order = apply_filters( 'el_select_venue_order', 'ASC' );

		$args_venue = array(
			'post_type' => OVAEM_Settings::venue_post_type_slug(),
			'post_status' => 'publish',
			'orderby'	=> $orderby,
			'order'	=> $order,
			'posts_per_page' => '-1',
			'nopaging'	=> true
		);

		$venue = get_posts($args_venue);

		return $venue;
	}

	/**
    * Get Price
    */
	public function ovaem_get_price($tickets_arr) {
		$price_array = array('');
		$cur = '';

		if (!empty($tickets_arr) && $tickets_arr != '') {

			foreach ($tickets_arr as $key => $value) {

				if ($value['pay_method'] == 'free') {
					$price_array[$key] = 0;
				} elseif ($value['pay_method'] == 'paid_woo' || $value['pay_method'] == 'other_pay_gateway') {
					$price_array[$key] = $value['ticket_price'];
					$cur = $value['ticket_cur'];
				} elseif ($value['pay_method'] == 'outside') {
					$price_array[$key] = $value['ticket_price'];
					$cur = $value['ticket_cur'];
				}
			}
		}

		sort($price_array);
		$sepera = count($price_array) > 1 ? '-' : '';

		$cur_pos = OVAEM_Settings::currency_position();
		if ($cur_pos == 'left') {
			if (count($price_array) > 1) {
				return '<span>' . $cur . $price_array[0] . $sepera . $cur . $price_array[count($price_array) - 1] . '</span>';
			} else {
				if ($price_array[0] != 0) {
					return '<span>' . $cur . $price_array[0] . '</span>';
				} else {
					return '<span>' . esc_html__('Free', 'ovaem-events-manager') . '</span>';
				}

			}

		} else if ($cur_pos == 'right') {

			if (count($price_array) > 1) {
				return '<span>' . $price_array[0] . $cur . $sepera . $price_array[count($price_array) - 1] . $cur . '</span>';
			} else {
				if ($price_array[0] != 0) {
					return '<span>' . $price_array[0] . $cur . '</span>';
				} else {
					return '<span>' . esc_html__('Free', 'ovaem-events-manager') . '</span>';
				}
			}

		} else if ($cur_pos == 'left_space') {

			if (count($price_array) > 1) {
				return '<span>' . $cur . ' ' . $price_array[0] . $sepera . $cur . ' ' . $price_array[count($price_array) - 1] . '</span>';
			} else {
				if ($price_array[0] != 0) {
					return '<span>' . $cur . ' ' . $price_array[0] . '</span>';
				} else {
					return '<span>' . esc_html__('Free', 'ovaem-events-manager') . '</span>';
				}
			}

		} else if ($cur_pos == 'right_space') {
			if (count($price_array) > 1) {
				return '<span>' . $price_array[0] . ' ' . $cur . $sepera . $price_array[count($price_array) - 1] . ' ' . $cur . '</span>';
			} else {
				if ($price_array[0] != 0) {
					return '<span>' . $price_array[0] . ' ' . $cur . '</span>';
				} else {
					return '<span>' . esc_html__('Free', 'ovaem-events-manager') . '</span>';
				}
			}
		}
	}

	/**
    * Get event by speaker who joined
    */
	public function ovaem_get_events_by_speaker($speaker_slug) {

		$archive_orderby = OVAEM_Settings::speaker_joined_event_orderby();
		$archive_order = OVAEM_Settings::speaker_joined_event_order();
		$show_past = OVAEM_Settings::speaker_joined_event_show_past();
		$show_current = OVAEM_Settings::speaker_joined_event_show_current();
		$count = OVAEM_Settings::speaker_joined_event_count();

		$args_base = $this->ovaem_query_base($paged = '', $archive_orderby, $archive_order, $show_past, $show_current);

		$args_speaker = array(
			'posts_per_page' => $count,
			'meta_query' => array(
				array(
					'key' => 'speakers',
					'value' => $speaker_slug,
					'compare' => 'LIKE',
				),
			),
		);

		$args = array_merge_recursive($args_base, $args_speaker);

		$events = new WP_Query($args);

		return $events;
	}

	/**
    * Related Events
    */
	public function ovaem_get_related_events($post__not_in = '') {

		$archive_orderby = OVAEM_Settings::archives_event_orderby();
		$archive_order = OVAEM_Settings::archives_event_order();
		$show_past = OVAEM_Settings::archives_event_show_past();
		$number_event_related = OVAEM_Settings::number_event_related();
		$cat_slug = OVAEM_Settings::slug_taxonomy_name();

		$args_base = $this->ovaem_query_base($paged = '', $archive_orderby, $archive_order, $show_past);

		$args_count = array(
			'posts_per_page' => $number_event_related,
		);

		$obj_cat = get_the_terms($post__not_in, $cat_slug);

		$cat_value_array = array();
		if ($obj_cat) {
			foreach ($obj_cat as $key => $value) {
				$cat_value_array[] = $value->slug;
			}
		}

		$args_cat = array(
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => $cat_slug,
					'field' => 'slug',
					'terms' => $cat_value_array,
				),

			),
			'post__not_in' => array($post__not_in),
		);

		$args_related = array_merge_recursive($args_base, $args_count, $args_cat);

		$events = new WP_Query($args_related);

		return $events;
	}

	/**
    * Venue joined event
    */
	public function ovaem_get_venue_joined_event($post_name) {

		$archive_orderby = OVAEM_Settings::detail_venue_event_orderby();
		$archive_order = OVAEM_Settings::detail_venue_event_order();
		$show_past = OVAEM_Settings::detail_venue_event_show_past();
		$count = OVAEM_Settings::detail_venue_event_count();

		$args_base = $this->ovaem_query_base($paged = '', $archive_orderby, $archive_order, $show_past);

		$args_count = array('posts_per_page' => $count);

		$args_name = array(
			'meta_query' => array(
				array(
					'key' => self::$prefix . '_venue',
					'value' => $post_name,
					'compare' => 'LIKE',
				),

			),
		);

		$args = array_merge_recursive($args_base, $args_count, $args_name);

		$events = new WP_Query($args);
		return $events;
	}

	/* Check Status Event */
	public function ovaem_check_status_event($start_time, $end_time) {
		$current_time = current_time('timestamp');
		if ($start_time > $current_time) {
			return '<span class="upcoming">' . esc_html__('Upcoming', 'ovaem-events-manager') . '</span>';
		} else if ($start_time < $current_time && $current_time < $end_time) {
			return '<span class="showing">' . esc_html__('Showing', 'ovaem-events-manager') . '</span>';
		} else if ($end_time < $current_time) {
			return '<span class="past">' . esc_html__('Past', 'ovaem-events-manager') . '</span>';
		}
	}

	function ovaem_get_country($selected = '', $required = '', $exclude_id = '') {

		$orderby = apply_filters( 'el_select_country_orderby', 'title' );
		$order = apply_filters( 'el_select_country_order', 'ASC' );

		$args = array(
			'show_option_all' => '',
			'show_option_none' => esc_html__('All Countries', 'ovaem-events-manager'),
			'option_none_value' => '',
			'orderby' => $orderby,
			'order' => $order,
			'show_count' => 0,
			'hide_empty' => 0,
			'child_of' => 0,
			'exclude' => $exclude_id,
			'include' => '',
			'echo' => 0,
			'selected' => $selected,
			'hierarchical' => 1,
			'name' => 'name_country',
			'id' => '',
			'class' => 'selectpicker  postform ' . $required,
			'depth' => 1,
			'tab_index' => 0,
			'taxonomy' => 'location',
			'hide_if_empty' => false,
			'value_field' => 'slug',
		);



		return wp_dropdown_categories($args);
	}

	function ovaem_get_city($selected, $required = '', $exclude_id = '') {

		$name_country = isset( $_GET['name_country'] ) ? sanitize_text_field( $_GET['name_country'] ) : '';

		$country_current = get_term_by('slug', $name_country, 'location');
		$parent_id = 0;
		$include = array();

		if ( $country_current != false ) {
			$parent_id = $country_current->term_id;
		} else {

			$args = array (
				'taxonomy' => 'location',
				'orderby' => 'name',
				'order' => 'ASC',
				'hide_empty' => false,
				'fields' => 'all',
				'hierarchical' => false,
			);

			$countries = get_terms( $args );

			if ( ! empty( $countries ) ) {
				foreach ($countries as $key => $value) {
					if ( $value->parent != 0 ) {
						$include[] = $value->term_id;
					}
				}
			}
		}

		$orderby = apply_filters( 'el_select_cities_orderby', 'title' );
		$order = apply_filters( 'el_select_cities_order', 'ASC' );

		$args = array(
			'show_option_all' => '',
			'show_option_none' => esc_html__('All Cities', 'ovaem-events-manager'),
			'option_none_value' => '',
			'orderby' => $orderby,
			'order' => $order,
			'show_count' => 0,
			'hide_empty' => false,
			'include' => $include,
			'echo' => 0,
			'selected' => $selected,
			'hierarchical' => false,
			'name' => 'name_city',
			'id' => '',
			'class' => 'selectpicker  postform ' . $required,
			'depth' => 0,
			'tab_index' => 0,
			'taxonomy' => 'location',
			'value_field' => 'slug',
		);

		if ( $parent_id != 0 ) {
			$args['parent'] = $parent_id;
		}

		return wp_dropdown_categories($args);
	}

	function ovaem_get_locs() {

		$location = get_terms(array(
			'taxonomy' => 'location',
			'hide_empty' => false,
		));

		return $location;
	}

	/**
    * Get Archive Events
    */
	public function ovaem_location_event($term_location, $orderby = 'date', $order = 'ASC', $show_past = 'true') {

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$args_basic = $this->ovaem_query_base($paged, $orderby, $order, $show_past);

		$args_term = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'location',
					'field' => 'slug',
					'terms' => $term_location,
				),
			),
		);

		$args = array_merge_recursive($args_basic, $args_term);

		$events = new WP_Query($args);

		return $events;
	}

	public function ovaem_get_count_e_cat($cat, $show_past = 'true') {

		$args_past = array();

		$args_basic = array(
			'post_type' => self::$event_post_type_slug,
			'post_status' => 'publish',
			'posts_per_page' => '-1',
		);

		$args_term = array(
			'tax_query' => array(
				array(
					'taxonomy' => self::$slug_taxonomy_name,
					'field' => 'slug',
					'terms' => $cat,
				),
			),
		);

		if ($show_past === 'false') {

			$args_past = array(
				'meta_query' => array(
					array(
						'key' => self::$prefix . '_date_end_time',
						'value' => current_time('timestamp'),
						'type' => 'numeric',
						'compare' => '>',
					),
				),
			);

		}

		$args = array_merge_recursive($args_basic, $args_term, $args_past);

		$events = new WP_Query($args);

		return $events->post_count ? $events->post_count : 0;
	}

	public function ovaem_get_count_e_loc($loc, $show_past = 'true') {

		$args_past = array();

		$args_basic = array(
			'post_type' => self::$event_post_type_slug,
			'post_status' => 'publish',
			'posts_per_page' => '-1',
		);

		$args_term = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'location',
					'field' => 'slug',
					'terms' => $loc,
				),
			),
		);

		if ($show_past === 'false') {

			$args_past = array(
				'meta_query' => array(
					array(
						'key' => self::$prefix . '_date_end_time',
						'value' => current_time('timestamp'),
						'type' => 'numeric',
						'compare' => '>',
					),
				),
			);

		}

		$args = array_merge_recursive($args_basic, $args_term, $args_past);

		$events = new WP_Query($args);

		return $events->post_count ? $events->post_count : 0;
	}

	public function ovaem_get_list_booking($paged = 1) {

		$args_basic = array(
			'post_type' => 'event_order',
			'post_status' => 'publish',
			'paged' => $paged,
			'author'	=> get_current_user_id()
		);

		$events = new WP_Query($args_basic);

		return $events;
	}

	// Get link, password of ticket
	public static function ovaem_get_info_ticket( $event_id, $package_id ){

		if( !$event_id || !$package_id ) return;

		$prefix = OVAEM_Settings::$prefix;
		$tickets = get_post_meta( $event_id , $prefix.'_ticket', true );


		if( $tickets ){
			foreach ($tickets as $key => $ticket) {

				if( $ticket['package_id'] === $package_id ){
				
					return $ticket;
					
					
				}
			}
		}

		return;
		
	}

	public static function ovaem_get_all_events($order = 'ASC', $count = -1) {

		$args = array(
			'post_type' => self::$event_post_type_slug,
			'post_status' => 'publish',
			'orderby' => 'meta_value_num',
			'order' => $order,
			'meta_key' => self::$prefix . '_date_start_time',
			'posts_per_page' => $count,
			'fields' => 'ids'

		);

		$events = get_posts( $args );

		return $events;
	}


	

}

new OVAEM_Get_Data();
