<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_slideshow_two', 'ovaem_slideshow_two');
function ovaem_slideshow_two($atts, $content = null) {

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
	      'filter' => 'upcomming',
	      'slug_events'		=> '',
	      'list_id_event'	=> '',
	      'count'	=> 3,
	      'orderby' => $date_start_time,
	      'order' => 'DESC',
	      'show_past' => 'yes',
	      'auto_slider' => 'true',
	      'duration'    => '3000',
	      'navigation'  => 'true',
	      'loop'        => 'true',
	      'height_desk' => '680px',
	      'height_ipad' => '768px',
	      'height_mobile' => '800px',
	      'padding_top_desk'	=> '230px',
	      'padding_top_ipad'	=> '230px',
	      'padding_top_mobile'	=> '230px',
	      'read_more_text'    => 'Read more',
	      'cover_bg'     => 'true',
	      'bg_color' => '',
	      'address_type'	=> 'venue',
	      'timezone' => '0',
	      'class'   => '',
	      'show_get_ticket_expired' => 'true',
	    ), $atts) );

        $id = rand();
		$date_format = get_option('date_format');

		if( $list_id_event != '' ){
			$filter = explode(',', str_replace( ' ','',$list_id_event ) );
		}else{
			$filter = ( $slug_events != '' ) ? array( $slug_events ) : $filter;	
		}


        $slideshow = apply_filters( 'ovaem_events_orderby', $filter, $count, $cat = '', $orderby, $order, $show_past  );


        $html = '';
	    $html .= '<div class="main_slider main_slider_two main_slider_v1 owl-carousel '.$class.'" data-height_desk="'.$height_desk.'"  data-height_ipad="'.$height_ipad.'" data-height_mobile="'.$height_mobile.'" data-loop="'.$loop.'" data-auto_slider="'.$auto_slider.'" data-duration="'.$duration.'" data-navigation="'.$navigation.'" data-padding_top_desk="'.$padding_top_desk.'" data-padding_top_ipad="'.$padding_top_ipad.'" data-padding_top_mobile="'.$padding_top_mobile.'" >';
	    
	    	if( $slideshow->have_posts() ): while( $slideshow->have_posts() ):  $slideshow->the_post();

	    		$id = get_the_id();
	    		$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );

			    $timezone_string = get_option('timezone_string') ;

			    $slide_start_time = get_post_meta( $id , $prefix.'_date_start_time', true ) ? get_post_meta( $id, $prefix.'_date_start_time', true ) : '';

				
				$day = $month = $year = $hour = $minute = 0;
				if( $slide_start_time ){
					$day = date_i18n( 'd', $slide_start_time );
					$month = date_i18n( 'm', $slide_start_time );
					$year = date_i18n( 'Y', $slide_start_time );
					$hour = date_i18n( 'H', $slide_start_time );
					$minute = date_i18n( 'i', $slide_start_time );
				}
				


				$address = '';
				if( $address_type == 'venue' ){
					$venue_slug = get_post_meta( $id, $prefix.'_venue', true );
					$venue_detail = apply_filters( 'ovaem_get_venues_list', array( $venue_slug ), 'false', 1 );

					$venue_obj = $venue_slug ? get_page_by_path( $venue_slug, OBJECT, OVAEM_Settings::venue_post_type_slug() ) : '';
					$address = $venue_obj ? $venue_obj->post_title : '';	
				}else if( $address_type == 'address' ){
					$address = get_post_meta( $id, $prefix.'_address_event', true );
				}else if( $address_type == 'room' ){
					$address = 	get_post_meta( $id, $prefix.'_address', true );
				}
				
			
				


			    $html .= '<div class="item text-center '.$class.'" style="background-image: url('.$img.')" data-speed="10">';

			                    $html .= ($cover_bg == 'true') ? '<div class="cover_bg" style="background-color: '.$bg_color.'"></div>':'';

			                    $html.= '<div class="caption">
			                                <div class="container">
			                                    <div class="div-table">
			                                        <div class="div-cell">';

			                                           $html .= '<div class="slider_date">';

			                                           	$html .= $address ? '<div class="box"><span>'.$address.'</span></div>' : '';

			                                           $html .= '</div>';

			                                           $html .= '<h2 class="title">'.get_the_title().'</h2>';

			                                           // $html .= '<div class="event_date">'.get_the_excerpt().'</div>';
			                                           
			                                           $html .= '<div class="ova_countdown_slideshow"><div class="ova_countdown_event" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-timezone_string="'.$timezone_string.'" data-hour="'.$hour.'" data-minute="'.$minute.'" data-timezone="'.$timezone.'"></div></div>';


			                                           $html .= $read_more_text ? '<div class="ova_button"><a class="ova-btn ova-btn-large ova-btn-rad-30 ova-btn-white" href="'.get_the_permalink().'">'.$read_more_text.'</a></div>' : '';
			                                    
			        $html .= '</div></div></div></div></div>';

	    	endwhile;endif;wp_reset_postdata();

	    $html .= '</div>';


        
	    
	    return $html;

}



if(function_exists('vc_map')){

	$prefix = OVAEM_Settings::$prefix;
	$date_start_time = $prefix.'_date_start_time';
	$date_end_time = $prefix.'_date_end_time';
	$date_order = $prefix.'_order';
	$date_created = 'date';

	
	$events = array();
	$events['------------'] = '';


	$events_arr =  OVAEM_Get_Data::ovaem_get_all_events( 'ASC', -1 );
	foreach ($events_arr as $key => $id) {

		$post = get_post($id);
		$slug = $post->post_name;

		$events[ get_the_title( $id ) ] = $slug;
	}

	vc_map( array(
		"name" => esc_html__("Slideshow Event Countdown", 'ovaem-events-manager'),
		"base" => "ovaem_slideshow_two",
		"class" => "",
		"category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		"icon" => "icon-qk",   
		"params" => array(
			
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Filter",'ovaem-events-manager'),
				"description" => esc_html__("To use this option, you have to make field: Choose Event is Empty",'ovaem-events-manager'),
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
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Choose Event",'ovaem-events-manager'),
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
				"heading" => esc_html__("Order by",'ovaem-events-manager'),
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
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __("Auto slider",'ovaem-events-manager'),
				"param_name" => "auto_slider",
				"value" => array(
					__('True', 'ovaem-events-manager') => "true",
					__('False', 'ovaem-events-manager') => "false",
				),
				"default"	=> "true"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Duration of slider(ms). 1000ms = 1s",'ovaem-events-manager'),
				"param_name" => "duration",
				"value"	=> '3000'
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __("Navigation",'ovaem-events-manager'),
				"param_name" => "navigation",
				"value" => array(
					__('True', 'ovaem-events-manager') => "true",
					__('False', 'ovaem-events-manager') => "false",
				),
				"default"	=> "true"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __("Loop",'ovaem-events-manager'),
				"param_name" => "loop",
				"value" => array(
					esc_html__('True', 'ovaem-events-manager') => "true",
					esc_html__('False', 'ovaem-events-manager') => "false",
				),
				"default"	=> "true"
			),
			
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Height desk",'ovaem-events-manager'),
				"param_name" => "height_desk",
				"value" => "680px",
				"description" => esc_html__('Insert full-height or height (750px)','ovaem-events-manager')
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Height Ipad",'ovaem-events-manager'),
				"param_name" => "height_ipad",
				"value" => "768px",
				"description" => esc_html__('Insert full-height or height (768px)','ovaem-events-manager')
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Height Mobile",'ovaem-events-manager'),
				"param_name" => "height_mobile",
				"value" => "800px",
				"description" => esc_html__('Insert full-height or height (800px)','ovaem-events-manager')
			),

			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Padding Top Desktop",'ovaem-events-manager'),
				"param_name" => "padding_top_desk",
				"value" => "230px"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Padding Top Ipad",'ovaem-events-manager'),
				"param_name" => "padding_top_ipad",
				"value" => "230px"
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Padding Top Mobile",'ovaem-events-manager'),
				"param_name" => "padding_top_mobile",
				"value" => "230px"
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
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Display cover background",'ovaem-events-manager'),
				"param_name" => "cover_bg",
				"value" => array(
					__('True', 'ovaem-events-manager') => "true",
					__('False', 'ovaem-events-manager') => "false",
				),
				"default"	=> "true"
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Background color cover",'ovaem-events-manager'),
				"param_name" => "bg_color",
				"value" => "",
				
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