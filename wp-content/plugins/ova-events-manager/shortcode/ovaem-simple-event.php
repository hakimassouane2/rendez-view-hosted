<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_simple_event', 'ovaem_simple_event');
function ovaem_simple_event($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
	      'event_slug' => '',
	      'featured_event_label' => '',
	      'full_event_label' => '',
	      'class'   => '',
	    ), $atts) );

      	$prefix = OVAEM_Settings::$prefix;	
      	$html = '';

      	if( $event_slug ){

	       	$event = apply_filters( 'ovaem_event', $event_slug );

	       	$html .= '<div class="ovaem_simple_event"><div class="bg_cover"></div><div class="row">';
	       		

	       		$html .= $featured_event_label ? '<div class="col-md-2"><div class="title">'.$featured_event_label.'</div></div>' : '';

	       		

			       	
			       	if( $event->have_posts() ): while( $event->have_posts() ):  $event->the_post();
			       		
						$schedule_parent = get_post_meta( get_the_id(), $prefix.'_schedule_date', true );
						$name_array_schedule_plan = get_post_meta( get_the_id(), $prefix.'_schedule_plan', true );

						$html .= '<div class="col-md-10">';

				       		$html .= '<div class="owl-carousel owl-theme  ovaem_simple_event_info">';

				       			if( $schedule_parent ){
									foreach ($schedule_parent as $key => $value) {

										if( isset( $name_array_schedule_plan[$key] ) ){
											foreach( $name_array_schedule_plan[$key] as $key_p => $value_p ){
												$html .= '<div class="item">';
													$html .= $value_p['time'] ? '<div class="time">'.$value_p['time'].'</div>' : '';
													$html .= $value_p['title'] ? '<div class="name" >'.shorten_string($value_p['title'], 3) .'</div>' : '';
												$html .= '</div>';
												
											}
										}
									}
								}

				       		$html .= '</div>';
			       		
			       		$html .= '</div>';

			       		$html .= $full_event_label ? '<div class="more_detail"><a href="'.get_the_permalink().'">'.$full_event_label.'</a></div>' : '';

			       	endwhile; endif; wp_reset_postdata();


	       	$html .= '</div></div>';

        }else{
        	return '<div class="text-center">'.esc_html__( 'Please choose event in backend', 'ovaem-events-manager' ).'</div>';
        }
        
	    
	    return $html;

}



if(function_exists('vc_map')){

   
 		$events_arr = array( ''=> esc_html__('-- Select Event --', 'ovaem-events-manager') );
 		$events =  OVAEM_Get_Data::ovaem_get_all_events( 'ASC', -1 );
		foreach ($events as $key => $id) {

			$post = get_post($id);
			$slug = $post->post_name;

			$events_arr[$slug] = get_the_title( $id );
		}

		vc_map( array(
			 "name" => esc_html__("Simple Event", 'ovaem-events-manager'),
			 "base" => "ovaem_simple_event",
			 "description" => esc_html__("Display schedule of an event", 'ovaem-events-manager'),
			 "class" => "",
			 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
			 "icon" => "icon-qk",   
			 "params" => array(
			 	
			 		

				    array(
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Event slug",'ovaem-events-manager'),
				       "param_name" => "event_slug",
				       "value" => array_flip($events_arr),
				       "default" => '',
				    ),
				    array(
				       "type" => "textfield",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Featured event label",'ovaem-events-manager'),
				       "param_name" => "featured_event_label",
				       "value" => ""
				    ),
				    array(
				       "type" => "textfield",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Full event label",'ovaem-events-manager'),
				       "param_name" => "full_event_label",
				       "value" => ""
				    ),
				    
				  	array(
				       "type" => "textfield",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Class",'ovaem-events-manager'),
				       "param_name" => "class"
				    )

			 
		)));



}