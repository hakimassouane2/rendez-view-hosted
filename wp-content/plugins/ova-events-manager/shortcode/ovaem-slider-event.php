<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_slider_event', 'ovaem_slider_event');
function ovaem_slider_event($atts, $content = null) {

	// Slick
	wp_enqueue_script('slick', OVAEM_PLUGIN_URI.'assets/libs/slick/slick.min.js', array('jquery'),null,false);
	// Slick
	wp_enqueue_style('slick_main', OVAEM_PLUGIN_URI.'assets/libs/slick/slick.css', array(), null );
	wp_enqueue_style('slick_theme', OVAEM_PLUGIN_URI.'assets/libs/slick/slick-theme.css', array(), null );

		$prefix = OVAEM_Settings::$prefix;
		$date_start_time = $prefix.'_date_start_time';

		$atts = extract( shortcode_atts(
			array(
				'filter' => 'featured',
				'slug_events'		=> '',
				'list_id_event'	=> '',
				'count'	=> 5,
				'orderby' => $date_start_time,
				'order' => 'DESC',
				'show_past' => 'true',
				'show_button' => 'true',
				'number_item_slide' => '3',
				'address_type'	=> 'venue',
				'class'   => '',
			), $atts) );

      	$prefix = OVAEM_Settings::$prefix;
      	$date_format = get_option('date_format');

      	if( $list_id_event != '' ){
			$filter = explode(',', str_replace( ' ','',$list_id_event ) );
		}else{
			$filter = ( $slug_events != '' ) ? array( $slug_events ) : $filter;	
		}

		$i = rand();

      	$eventlist = apply_filters( 'ovaem_events_orderby', $filter, $count, $cat = '', $orderby, $order, $show_past );

      		$html = '<div class="wrap-ovaem-slider-events"><div class="ovaem-slider-events '.$class.' '.$i.'" data-number_item_slide="'.$number_item_slide.'">';

      			

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

		    		$date_by_format = $start_time ? date_i18n( $date_format , $start_time )  : '';

		    		$d_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
		    		$m_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'm_img' );

      				$html .= '<div class="item">';

      					$html .= '<a href="'.get_the_permalink().'"><div class="content">';
      						
	      						$html .= '<img alt="'.get_the_title().'" src="'.$d_img.'" srcset=" '.$d_img.' 370w, '.$m_img.' 640w" sizes="(max-width: 640px) 100vw, 370px" />';
	      					

	      					$html .= '<div class="wrap_date_venue">';
		      					$html .= '<div class="time">'.$date_by_format.'</div>';
		      					$html .= $address ? '<div class="venue">'.$address.'</div>' : '';
	      					$html .= '</div>';

      					$html .= '</div></a>';

      					$html .= '<a class="read_more" href="'.get_the_permalink().'"><i class="arrow_right ova-trans"></i></a>';
      					$html .= '<h2 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
      					
      				$html .= '</div>';
      				
      				

      			endwhile; endif; wp_reset_postdata();
      			

			$html .= '</div>';

				if( $show_button == 'true' ){
					$html .= '<button type="button" class="ova-slick-next" data-count="'.$i.'"><i class="arrow_carrot-right"></i></button>';
					$html .= '<button type="button" class="ova-slick-prev"  data-count="'.$i.'"><i class="arrow_carrot-left"></i></button>';
				}

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
		"name" => esc_html__("Event Slider", 'ovaem-events-manager'),
		"base" => "ovaem_slider_event",
		"description" => esc_html__( "horizontally with scroll",  'ovaem-events-manager' ),
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
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Next, Prev Button",'ovaem-events-manager'),
				"param_name" => "show_button",
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
				"heading" => esc_html__("Number item slide",'ovaem-events-manager'),
				"param_name" => "number_item_slide",
				"value" => "3",
				"description" => esc_html__("Number items in each slide",'ovaem-events-manager')
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