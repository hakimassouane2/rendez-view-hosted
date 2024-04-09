<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_slideshow_three', 'ovaem_slideshow_three');
function ovaem_slideshow_three($atts, $content = null) {

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
	      'address_type'	=> 'venue',
	      'cover_bg'     => 'true',
	      'bg_color' => '',
	      'show_name' => "true",
	      'show_phone' => "true",
	      'show_ticket' => "true",
	      'show_address' => "false",
	      'show_company' => "false",
	      'show_desc' => "false",
	      'class'   => '',
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
	    $html .= '<div class="main_slider main_slider_three main_slider_v1 owl-carousel '.$class.'" data-height_desk="'.$height_desk.'"  data-height_ipad="'.$height_ipad.'" data-height_mobile="'.$height_mobile.'" data-loop="'.$loop.'" data-auto_slider="'.$auto_slider.'" data-duration="'.$duration.'" data-navigation="'.$navigation.'" data-padding_top_desk="'.$padding_top_desk.'" data-padding_top_ipad="'.$padding_top_ipad.'" data-padding_top_mobile="'.$padding_top_mobile.'" >';
				    
	    	if( $slideshow->have_posts() ): while( $slideshow->have_posts() ):  $slideshow->the_post();

	    		$id = get_the_id();
	    		$has_ticket_free = 'false';

	    		// Get Ticket
        		$tickets = get_post_meta( get_the_id(), $prefix.'_ticket', true );
        		
        		if( $tickets ){
					foreach ($tickets as $key => $value) {
						if( $value['pay_method'] == 'free' ){
							$has_ticket_free = 'true';
							$package_id = isset( $value['package_id'] ) ? $value['package_id'] : '';
							break;	
						}
						
					}
				}

	    		$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );

			    $timezone_string = get_option('timezone_string') ;

			    $slide_start_time = get_post_meta( $id , $prefix.'_date_start_time', true ) ? get_post_meta( $id, $prefix.'_date_start_time', true ) : '';

				$date = $slide_start_time ? date_i18n( $date_format, get_post_meta( $id, $prefix.'_date_start_time', true ) ) : '';

				
				


				$address = '';
				if( $address_type == 'venue' ){
					$venue_slug = get_post_meta( $id, $prefix.'_venue', true );
					$venue_detail = apply_filters( 'ovaem_get_venues_list', array( $venue_slug ), 'false', 1 );

					$venue_obj = $address = '';
					if( $venue_slug ){
						$venue_obj = get_page_by_path( $venue_slug, OBJECT, OVAEM_Settings::venue_post_type_slug() );
						$address = $venue_obj->post_title;	
					}
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

			                                        	$html .= '<div class="container-fluid"><div class="row">';

			                                        		$html .= '<div class="col-md-6 event_info">';
			                                        			$html .= '<div class="slider_date">';

																$html .= $date ? '<div class="box"><i class="icon_calendar"></i> <span>'.$date.'</span></div>' : '';

																$html .= $address ? '<div class="box"><i class="icon_pin_alt"></i> <span>'.$address.'</span></div>' : '';

																$html .= '</div>';

																$html .= '<h2 class="title">'.get_the_title().'</h2>';
																$html .= '<h3 class="sub_title">'.get_the_excerpt().'</h3>';

																$html .= $read_more_text ? '<div class="ova_button"><a class="ova-btn ova-btn-rad-30 ova-btn-white" href="'.get_the_permalink().'">'.$read_more_text.'</a></div>' : '';	
			                                        		$html .= '</div>';

			                                        		// Check have free ticket
			                                        		if( $has_ticket_free == 'true' ){
				                                        		$html .= '<div class="col-md-6 event_register">';
				                                        			$html .= do_shortcode( '[ovaem_register_event_free event_id="'.get_the_id().'" package_id="'.$package_id.'" 
				                                        				show_name="'.$show_name.'" show_phone="'.$show_phone.'" show_ticket="'.$show_ticket.'"  show_address="'.$show_address.'" show_company="'.$show_company.'" show_desc="'.$show_desc.'" /]' );
				                                        		$html .= '</div>';
			                                        		}

															

			                                           $html .= '</div></div>';
			                                    
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
			 "name" => esc_html__("Slideshow Event Register", 'ovaem-events-manager'),
			 "base" => "ovaem_slideshow_three",
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
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Show Name in register form",'ovaem-events-manager'),
				       "param_name" => "show_name",
				       "value"	=> array(
				       		"true" => "true",
				       		"false" => "false"
				       	),
				       "default" => "true"
				    ),
				    array(
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Show Phone in register form",'ovaem-events-manager'),
				       "param_name" => "show_phone",
				       "value"	=> array(
				       		"true" => "true",
				       		"false" => "false"
				       	),
				       "default" => "true"
				    ),
				    array(
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Show Ticket in register form",'ovaem-events-manager'),
				       "param_name" => "show_ticket",
				       "value"	=> array(
				       		"true" => "true",
				       		"false" => "false"
				       	),
				       "default" => "true"
				    ),
				    array(
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Show Address in register form",'ovaem-events-manager'),
				       "param_name" => "show_address",
				       "value"	=> array(
				       		"false" => "false",
				       		"true" => "true"
				       	),
				       "default" => "false"
				    ),
				    array(
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Show Company in register form",'ovaem-events-manager'),
				       "param_name" => "show_company",
				       "value"	=> array(
				       		"false" => "false",
				       		"true" => "true"
				       	),
				       "default" => "false"
				    ),
				    array(
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Show Description in register form",'ovaem-events-manager'),
				       "param_name" => "show_desc",
				       "value"	=> array(
				       		"false" => "false",
				       		"true" => "true"
				       	),
				       "default" => "false"
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