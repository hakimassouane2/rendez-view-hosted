<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_slider_event_two', 'ovaem_slider_event_two');
function ovaem_slider_event_two($atts, $content = null) {

		wp_enqueue_script('jquery-countdown', EM4U_URI.'/assets/plugins/countdown/jquery.plugin.min.js', array('jquery'),null,true);    
	    wp_enqueue_script('countdown', EM4U_URI.'/assets/plugins/countdown/jquery.countdown.min.js', array('jquery'),null,true);
	    
	    if ( function_exists('pll_current_language') ) {
			$current_lang = pll_current_language();
			$countdown_lang = 'jquery.countdown-'.$current_lang.'.js';
			wp_enqueue_script('countdown-language', EM4U_URI.'/assets/plugins/countdown/'.$countdown_lang, array('jquery'),null,true);
		} else {
			$countdown_lang = get_theme_mod( 'countdown_lang', '' );
			if( $countdown_lang != '' && $countdown_lang != 'lang' ){
				wp_enqueue_script('countdown-language', EM4U_URI.'/assets/plugins/countdown/'.$countdown_lang, array('jquery'),null,true);
			}
		}

		$prefix = OVAEM_Settings::$prefix;
		$date_start_time = $prefix.'_date_start_time';

      $atts = extract( shortcode_atts(
	    array(
			'filter' => 'featured',
			'slug_events'		=> '',
	      	'list_id_event'	=> '',
			'cat' => '',
			'address_type'	=> 'venue',
			'count'	=> 5,
			'orderby' => $date_start_time,
			'order' => 'DESC',
			'show_past' => 'true',
			'timezone' => '0',
	      	'class'   => '',
	      	'show_get_ticket_expired' => 'true',
	    ), $atts) );

      	$prefix = OVAEM_Settings::$prefix;
      	$date_format = get_option('date_format');
      	
      	if( $list_id_event != '' ){
			$filter = explode(',', str_replace( ' ','',$list_id_event ) );
		}else{
			$filter = ( $slug_events != '' ) ? array( $slug_events ) : $filter;	
		}
      	
      	

      	$eventlist = apply_filters( 'ovaem_events_orderby', $filter, $count, $cat , $orderby, $order, $show_past );

      		$html = '<div class="ovaem_slider_events_two ">';

      			if( $eventlist->have_posts() ): while( $eventlist->have_posts() ):  $eventlist->the_post();

		    		$id = get_the_id();

		    		$address = '';
					if( $address_type == 'venue' ){
						$venue_slug = get_post_meta( $id, $prefix.'_venue', true );
						if( $venue_slug ){
							$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );	
							if($venue){
								$address = $venue->post_title;
							}
						}
		    			
					}else if( $address_type == 'address' ){
						$address = get_post_meta( $id, $prefix.'_address_event', true );
					}else if( $address_type == 'room' ){
						$address = 	get_post_meta( $id, $prefix.'_address', true );
					}


		    		$start_time = get_post_meta( $id, $prefix.'_date_start_time', true );
		    		$end_time = get_post_meta( $id, $prefix.'_date_end_time', true );

		    		$date = $start_time ? date_i18n( $date_format , $start_time )  : '';

		    		// Countdown
		    		$day = date_i18n( 'd', $start_time  );
		    		$month = date_i18n( 'm', $start_time  );
		    		$year = date_i18n( 'Y', $start_time  );
		    		$hour = $start_time ? date_i18n( 'H' , $start_time )  : '';
		    		$minute = $start_time ? date_i18n( 'i' , $start_time )  : '';

		    		$check_pass_time = (int)current_time( 'timestamp' ) < (int)$end_time ? true : false;
		    		if ( $show_get_ticket_expired == 'true' ) {
		    			$check_pass_time = true;
		    		}

      				$html .= '<div class="item">';

      					$html .= '<div class="event_content"><a href="'.get_the_permalink().'">';

      						
      						$html .= '<div class="wrap_img" style="background: url('.get_the_post_thumbnail_url().');"></div>';

	      					$html .= '<h2 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
	      						
	      					$html .= '<div class="wrap_date_venue">';
		      					$html .= '<div class="time"><i class="icon_calendar"></i>'.$date.'</div>';
		      					$html .= $address ? '<div class="venue"><i class="icon_pin_alt"></i>'.$address.'</div>' : '';
	      					$html .= '</div>';

	      					$html .= '<div class="desc">'.shorten_string( get_the_excerpt(), 20).' . . .</div>';

      					$html .= '</a></div>';

      					$html .= '<div class="countdown">';
      						$html .= '<div class="ova_countdown_menu"><div class="ova_countdown_event" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-hour="'.$hour.'" data-minute="'.$minute.'" data-timezone="'.$timezone.'"></div></div>';
      					$html .= '</div>';

      					if ( $check_pass_time === true ) {

      						$html .= '<a class="ova-btn" href="'.get_the_permalink().'">'.esc_html__( 'Get Ticket', 'ovaem-events-manager' ).'</a>';
      					}
      					
      				$html .= '</div>';
      				
      				

      			endwhile; endif; wp_reset_postdata();
      			

			$html .= '</div>';
	    
	    return $html;

}



if(function_exists('vc_map')){

	

    	$prefix = OVAEM_Settings::$prefix;
    	$date_start_time = $prefix.'_date_start_time';
    	$date_end_time = $prefix.'_date_end_time';
    	$date_order = $prefix.'_order';
    	$date_created = 'date';

    	$cats = apply_filters('ovaem_get_categories', 10);
    	$cats_arr = array( '' => esc_html__('--- Select Category ---') );
    	foreach ($cats as $key => $value) {
    		$cats_arr[$value->slug] = $value->name;
    	}

    	
    	$events = array();
    	$events['------------'] = '';

    	$events_arr =  OVAEM_Get_Data::ovaem_get_all_events( 'ASC', -1 );
		foreach ($events_arr as $key => $id) {

			$post = get_post($id);
			$slug = $post->post_name;

			$events[ get_the_title( $id ) ] = $slug;
		}


		vc_map( array(
			 "name" => esc_html__("Event Slider Two", 'ovaem-events-manager'),
			 "base" => "ovaem_slider_event_two",
			 "class" => "",
			 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
			 "description" => esc_html__("Display in menugamenu", 'ovaem-events-manager'),
			 "icon" => "icon-qk",   
			 "params" => array(
				    
				array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Filter",'ovaem-events-manager'),
			       "param_name" => "filter",
			       "value" => array(
			       		esc_html__( "Featured", "ovaem-events-manager")	=> "featured",
			       	 	esc_html__( "Upcoming", "ovaem-events-manager") => "upcomming",
			       	 	esc_html__( "Upcoming/Showing", "ovaem-events-manager") => "upcomming_showing",
			       		esc_html__( "Past", "ovaem-events-manager")	=> "past",
			       		esc_html__( "Creation Date", "ovaem-events-manager")	=> "creation_date"
			       	),
			       "default" => "featured"
			    ),

			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Choose an Event",'ovaem-events-manager'),
			       "description" => esc_html__("To use this option, you have to make field: Slug Events is Empty",'ovaem-events-manager'),
			       "param_name" => "slug_events",
			       "value" => $events,
			       "default" => ""
			       
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Insert Multiple Slug Events",'ovaem-events-manager'),
			       "description" => esc_html__("Example: slug-event-1, slug-event-2",'ovaem-events-manager'),
			       "param_name" => "list_id_event",
			       "value" => "",
			       
			    ),			 

			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Choose category",'ovaem-events-manager'),
			       "param_name" => "cat",
			       "value" => array_flip($cats_arr),
			       "default" => ""
			       
			    ),

			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Display Address like",'ovaem-events-manager'),
			       "param_name" => "address_type",
			       "value" => array(
			       		esc_html__("Venue", "ovaem-events-manager" ) => "venue",
			       		esc_html__("Address", "ovaem-events-manager" )	=> "address",
			       		esc_html__("Room", "ovaem-events-manager" )	=> "room"
			       	),
			       "default" => "venue"
			       
			    ),

			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Orderby in each category",'ovaem-events-manager'),
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
			   	// dependency show_past
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show Expired Get Ticket",'ovaem-events-manager'),
			       "param_name" => "show_get_ticket_expired",
			       'dependency' => array( 'element' => 'show_past', 'value' => 'true' ),
			       "value" => array(
			       		esc_html__("True", "ovaem-events-manager" ) => "true",
			       		esc_html__("False", "ovaem-events-manager" )	=> "false"
			       	),
			       "default" => "true"
			       
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
				       "type" => "textfield",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Timezone",'ovaem-events-manager'),
				       "description" => esc_html__("The timezone for the target times. <br/>
		For example:<br/>
		If Timezone is UTC-9:00 you have to insert -9 <br/>
		If Timezone is UTC-9:30, you have to insert -9*60+30=-570. <br/>
		Read about UTC Time: http://en.wikipedia.org/wiki/List_of_UTC_time_offsets",'ovaem-events-manager'),
				       "param_name" => "timezone",
				       "value" => '0'
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