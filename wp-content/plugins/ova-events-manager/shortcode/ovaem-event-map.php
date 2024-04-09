<?php if ( !defined( 'ABSPATH' ) ) exit();

add_shortcode('ovaem_events_map', 'ovaem_events_map');
function ovaem_events_map($atts, $content = null) {

	$events_map = $attr_map = array();
	$k = 0;

	$prefix = OVAEM_Settings::$prefix;
	$date_start_time = $prefix.'_date_start_time';

      $atts = extract( shortcode_atts(
	    array(
	      'filter' => 'upcomming',
	      'count'	=> -1,
	      'orderby' => $date_start_time,
	      'order' => 'DESC',
	      'show_past' => 'true',
	      'read_more_text' => 'Read More',
	      'map_height'	=> '700px',
	      'zoom_map'	=> '14',
	      'class'   => '',
	    ), $atts) );

        $date_format = get_option('date_format');
        $time_format = get_option('time_format');

        $eventlist = apply_filters( 'ovaem_events_orderby', $filter, $count, $cat = '', $orderby, $order, $show_past );
	    
    	if( $eventlist->have_posts() ): while( $eventlist->have_posts() ):  $eventlist->the_post();

    		$id = get_the_id();

    		$start_time = get_post_meta( $id, $prefix.'_date_start_time', true );
    		$time = $start_time ? date_i18n( $date_format.' '.$time_format, $start_time )  : '';
    		
    		$address = get_post_meta( $id, $prefix.'_address_event', true );
    		
    		$lat = get_post_meta( $id, $prefix.'_event_map_lat', true );
    		$lon = get_post_meta( $id, $prefix.'_event_map_lng', true );

    		if( $lat != '' && $lon != '' ){
	    		$events_map[$k]['title'] = get_the_title();
				$events_map[$k]['img'] = get_the_post_thumbnail_url();
				$events_map[$k]['url'] = get_the_permalink();
				$events_map[$k]['address'] = $address;
				$events_map[$k]['time'] = $time;
				$events_map[$k]['lat'] = $lat;
				$events_map[$k]['lon'] = $lon;
				$k++;
			}


    	endwhile;endif; wp_reset_postdata();


	    $attr_map['readmore_text'] = $read_more_text;
		$attr_map['zoom_map'] =  $zoom_map;
		$attr_map['icon1'] = plugins_url( '/assets/img/m1.png', OVAEM_PLUGIN_FILE );
		$attr_map['icon2'] = plugins_url( '/assets/img/m2.png', OVAEM_PLUGIN_FILE );
		$attr_map['icon3'] = plugins_url( '/assets/img/m3.png', OVAEM_PLUGIN_FILE );
		$attr_map['icon4'] = plugins_url( '/assets/img/m4.png', OVAEM_PLUGIN_FILE );
		$attr_map['icon5'] = plugins_url( '/assets/img/m5.png', OVAEM_PLUGIN_FILE );


		wp_enqueue_script( 'google-map-api','//maps.googleapis.com/maps/api/js?key='.OVAEM_Settings::google_key_map().'&libraries=places', array('jquery'), null, true );

		wp_enqueue_script('markerclusterer', OVAEM_PLUGIN_URI.'assets/libs/markerclusterer.js', array('jquery'),null,true);

		wp_enqueue_script('oms', OVAEM_PLUGIN_URI.'assets/libs/oms.js', array('jquery'),null,true);

	    wp_add_inline_script( 'em4u-theme-js', 'events_map ='.json_encode( $events_map ).';', 'after' );
	    wp_add_inline_script( 'em4u-theme-js', 'attr_map = '.json_encode( $attr_map ).';', 'after' );

	    return '<div id="events_map" style="height: '.$map_height.'; width: 100%;"></div>';

}








if(function_exists('vc_map')){

	$prefix = OVAEM_Settings::$prefix;
	$date_start_time = $prefix.'_date_start_time';
	$date_end_time = $prefix.'_date_end_time';
	$date_order = $prefix.'_order';
	$date_created = 'date';

	vc_map( array(
		 "name" => esc_html__("Event Map", 'ovaem-events-manager'),
		 "base" => "ovaem_events_map",
		 "class" => "",
		 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		 "icon" => "icon-qk",   
		 "params" => array(
		 	
		 		array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Filter",'ovaem-events-manager'),
			       "param_name" => "filter",
			       "value" => array(
			       	 	esc_html__( "Upcoming", "ovaem-events-manager") => "upcomming",
			       	 	esc_html__( "Upcoming/Showing", "ovaem-events-manager") => "upcomming_showing",
			       		esc_html__( "Past", "ovaem-events-manager")	=> "past",
			       		esc_html__( "Featured", "ovaem-events-manager")	=> "featured",
			       		esc_html__( "Creation Date", "ovaem-events-manager")	=> "creation_date"
			       	),
			       "default" => "upcomming"
			       
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Count",'ovaem-events-manager'),
			       "param_name" => "count",
			       "value" => "3",
			       "description" => esc_html__("Insert number",'ovaem-events-manager')
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Orderby",'ovaem-events-manager'),
			       "param_name" => "orderby",
			       "value" => array(
			       		esc_html__("Start time", "ovaem-events-manager" ) => $date_start_time,
			       		esc_html__("End Time", "ovaem-events-manager" )	=> $date_end_time,
			       		esc_html__("Order field in event attribute", "ovaem-events-manager" )	=> $date_order,
			       		esc_html__("Created Date", "ovaem-events-manager" )	=> $date_created,
			       	),
			       "default" => $date_start_time
			       
			    ),

			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Order",'ovaem-events-manager'),
			       "param_name" => "order",
			       "value" => array(
			       		esc_html__("Decrease", "ovaem-events-manager" ) => "DESC",
			       		esc_html__("Increase", "ovaem-events-manager" )	=> "ASC"
			       	),
			       "default" => "DESC"
			       
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show Past Event",'ovaem-events-manager'),
			       "param_name" => "show_past",
			       "value" => array(
			       		esc_html__("Yes", "ovaem-events-manager" ) => "true",
			       		esc_html__("No", "ovaem-events-manager" )	=> "false"
			       	),
			       "default" => "true"
			       
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Read More Text",'ovaem-events-manager'),
			       "param_name" => "read_more_text",
			       "value" => "Read More"
			    ),

			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Map Height",'ovaem-events-manager'),
			       "param_name" => "map_height",
			       "value" => "700px"
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Zoom Map. Example 14",'ovaem-events-manager'),
			       "param_name" => "zoom_map",
			       "default" => "14"
			       
			    ),
			    
			  	array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Class",'ovaem-events-manager'),
			       "param_name" => "class",
			       "value" => "",
			       "description" => esc_html__("Insert class to use for your style",'ovaem-events-manager')
			    )

		 
	)));



}