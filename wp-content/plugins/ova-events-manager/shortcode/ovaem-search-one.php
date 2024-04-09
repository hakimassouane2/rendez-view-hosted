<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_search_one', 'ovaem_search_one');
function ovaem_search_one($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
	      'intro' => '',
	      'show_name' => 'true',
	      'show_venue' => 'true',
	      'show_cat' => 'true',
	      'show_country' => 'true',
	      'show_city' => 'true',
	      'show_time' => 'true',
	      'show_date' => 'true',
	      'date_format'	=> 'd M Y',
	      'show_today'	=> 'true',
	      'show_tomorrow'	=> 'true',
	      'show_this_week'	=> 'true',
	      'show_this_week_end'	=> 'true',
	      'show_next_week'	=> 'true',
	      'show_next_month'	=> 'true',
	      'show_past'	=> 'true',
	      'show_future'	=> 'true',

	      'class'   => '',
	    ), $atts) );

      	
       	$event_post_type_slug = OVAEM_Settings::event_post_type_slug();

       	// Get all categories
       	$cats = apply_filters('ovaem_get_categories','');

       	
       	// Get all venues
       	$venues = apply_filters('ovaem_venues', '');
       	

       	$name_event = isset( $_GET["name_event"] ) ? $_GET["name_event"] : '';
       	$cat = isset( $_GET["cat"] ) ? $_GET["cat"] : '';
       	$name_venue = isset( $_GET["name_venue"] ) ? $_GET["name_venue"] : '';
       	$time = isset( $_GET["time"] ) ? $_GET["time"] : '';
       	
       	$ovaem_date_from = isset( $_GET["ovaem_date_from"] ) ? $_GET["ovaem_date_from"] : '';
       	$ovaem_date_to = isset( $_GET["ovaem_date_to"] ) ? $_GET["ovaem_date_to"] : '';

       	$name_country = isset( $_GET["name_country"] ) ? $_GET["name_country"] : '';
       	$country = apply_filters( 'ovaem_get_country', $name_country );

       	$name_city = isset( $_GET["name_city"] ) ? $_GET["name_city"] : '';
       	$city = apply_filters( 'ovaem_get_city', $name_city );

       	

       	// Get all categories params
       	$cats_params = apply_filters('ovaem_get_categories_params',$cat);


        $html = '<div class="ovaem_search_event ovaem_search_state_city '.$class.'">';

        	$html .= $intro ? '<h3 class="search_title">'.$intro.'</h3>' : '';

        	$html .= '<form action="'.home_url('/').'" method="GET" name="search_event" >';

        		$html .= $show_name == 'true' ? '<div class="ovaem_name_event"><input class="form-controll selectpicker" placeholder="'.esc_html__('Enter Name ...', 'ovaem-events-manager').'" name="name_event" value="'.$name_event.'" /></div>' : '';

        		if( $show_cat == 'true' ){

	        		$html .= '<div class="ovaem_cat">';
	        			$html .= wp_dropdown_categories($cats_params);
					$html .= '</div>';
				}

				if( $show_country == 'true' ){
	        		$html .= '<div class="ovaem_country">';
		    			$html .= $country;
					$html .= '</div>';
				}

				if( $show_city == 'true' ){
	        		$html .= '<div class="ovaem_city">';
		    			$html .= $city;
					$html .= '</div>';
				}

        		
        		if( $show_venue == 'true' ){
	        		$html .= '<div class="ovaem_venue">';
		    			$html .= '<select name="name_venue" class="selectpicker ">';
		    				$html .= '<option value="">'.esc_html__('All Venue', 'ovaem-events-manager').'</option>';
		    					if($venues->have_posts() ) : while ( $venues->have_posts() ) : $venues->the_post(); 

										global $post;


										$selected = ( $post->post_name == $name_venue ) ? 'selected' : '';

										$html .= '<option value="'.$post->post_name.'" '.$selected.'>
											'.get_the_title().'</option>';

									endwhile;endif; wp_reset_postdata(); wp_reset_query();
		    					
		    			$html .= '</select>';
					$html .= '</div>';
				}


				

				
				if( $show_time == 'true' ){
					
					$select_today = ( $time == 'today' ) ? 'selected' : '';
					$select_tomorrow = ( $time == 'tomorrow' ) ? 'selected' : '';
					$select_this_week = ( $time == 'this_week' ) ? 'selected' : '';
					$select_this_week_end = ( $time == 'this_week_end' ) ? 'selected' : '';
					$select_next_week = ( $time == 'next_week' ) ? 'selected' : '';
					$select_next_month = ( $time == 'next_month' ) ? 'selected' : '';
					$select_past = ( $time == 'past' ) ? 'selected' : '';
					$select_future = ( $time == 'future' ) ? 'selected' : '';


					

	        		$html .= '<div class="ovaem_time">';
	        			$html .= '<select name="time" class="selectpicker select_alltime " style="z-index: 9999">';
	        				$html .= '<option value="">'.esc_html__('All Time', 'ovaem-events-manager').'</option>';

	        				$html .= $show_today == 'true' ? '<option value="today" '.$select_today.'>'.esc_html__('Today', 'ovaem-events-manager').'</option>' : '';
	        				
	        				$html .= $show_tomorrow == 'true' ? '<option value="tomorrow" '.$select_tomorrow.'>'.esc_html__('Tomorrow', 'ovaem-events-manager').'</option>' : '';
	        				
	        				$html .= $show_this_week == 'true' ? '<option value="this_week"  '.$select_this_week.'>'.esc_html__('This Week', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_this_week_end == 'true' ? '<option value="this_week_end"  '.$select_this_week_end.'>'.esc_html__('This Weekend', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_next_week == 'true' ? '<option value="next_week" '.$select_next_week .'>'.esc_html__('Next Week', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_next_month == 'true' ? '<option value="next_month" '.$select_next_month.'>'.esc_html__('Next Month', 'ovaem-events-manager').'</option>' : '';

	        				$html .=  $show_past == 'true' ? '<option value="past" '.$select_past.'>'.esc_html__('Past Events', 'ovaem-events-manager').'</option>' : '';

	        				$html .=  $show_future == 'true' ? '<option value="future" '.$select_future.'>'.esc_html__('Future Events', 'ovaem-events-manager').'</option>' : '';

	        			$html .= '</select>';
	        		$html .= '</div>';
        		}

        		

        		if( $show_date ==  'true' ){

	        		$html .= '<div class="ovaem_date">';

	        			$html .= '<input id="from" class="ovaem_select_date ovaem_date_from form-controll selectpicker" placeholder="'.esc_html__('From ...', 'ovaem-events-manager').'" data-date_format="'.esc_attr($date_format).'" data-lang="'.OVAEM_Settings::event_calendar_lang().'" data-first-day="'.OVAEM_Settings::first_day_of_week().'" name="ovaem_date_from" value="'.$ovaem_date_from.'" />';

	        			$html .= '<input id="to" class="ovaem_select_date ovaem_date_to form-controll selectpicker" placeholder="'.esc_html__('To ...', 'ovaem-events-manager').'" data-date_format="'.esc_attr($date_format).'" data-lang="'.OVAEM_Settings::event_calendar_lang().'" data-first-day="'.OVAEM_Settings::first_day_of_week().'" name="ovaem_date_to" value="'.$ovaem_date_to.'" />';

	        		$html .= '</div>';
        		}

        		$html .= '<input type="hidden" name="post_type" value="'.$event_post_type_slug.'">';
        		$html .= '<input type="hidden" name="search" value="search-event">';
        		$html .= '<div class="ovaem_submit"><input type="submit" value="'.esc_html__('Find Event', 'ovaem-events-manager').'" /></div>';
        	$html .= '</form>';
        $html .= '</div>';
	    
	    return $html;

}



if(function_exists('vc_map')){

		vc_map( array(
			 "name" => esc_html__("Search Event Full", 'ovaem-events-manager'),
			 "base" => "ovaem_search_one",
			 "description" => esc_html__("Allow show/hide field in search form", 'ovaem-events-manager'),
			 "class" => "",
			 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
			 "icon" => "icon-qk",   
			 "params" => array(
			 	
			 		
				    array(
				       "type" => "textfield",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Intro Text",'ovaem-events-manager'),
				       "param_name" => "intro",
				       "value" => ""
				    ),
				    array(
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => __("Show name",'ovaem-events-manager'),
				       "param_name" => "show_name",
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
				       "heading" => __("Show venue",'ovaem-events-manager'),
				       "param_name" => "show_venue",
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
				       "heading" => __("Show Category",'ovaem-events-manager'),
				       "param_name" => "show_cat",
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
				       "heading" => __("Show State",'ovaem-events-manager'),
				       "param_name" => "show_country",
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
				       "heading" => __("Show City",'ovaem-events-manager'),
				       "param_name" => "show_city",
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
				       "heading" => __("Show Time",'ovaem-events-manager'),
				       "param_name" => "show_time",
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
				       "heading" => __("Show Date",'ovaem-events-manager'),
				       "param_name" => "show_date",
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
				       "heading" => esc_html__("Date Format",'ovaem-events-manager'),
				       "param_name" => "date_format",
				       "default" => 'd M Y'
				    ),
				    array(
				       "type" => "dropdown",
				       "holder" => "div",
				       "class" => "",
				       "heading" => __("Show Today in All Time",'ovaem-events-manager'),
				       "param_name" => "show_today",
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
				       "heading" => __("Show Tomorrow in All Time",'ovaem-events-manager'),
				       "param_name" => "show_tomorrow",
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
				       "heading" => __("Show This Week in All Time",'ovaem-events-manager'),
				       "param_name" => "show_this_week",
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
				       "heading" => __("Show This Weekend in All Time",'ovaem-events-manager'),
				       "param_name" => "show_this_week_end",
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
				       "heading" => __("Show Next Week in All Time",'ovaem-events-manager'),
				       "param_name" => "show_next_week",
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
				       "heading" => __("Show Next Month in All Time",'ovaem-events-manager'),
				       "param_name" => "show_next_month",
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
				       "heading" => __("Show Past in All Time",'ovaem-events-manager'),
				       "param_name" => "show_past",
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
				       "heading" => __("Show Future in All Time",'ovaem-events-manager'),
				       "param_name" => "show_future",
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
				       "heading" => esc_html__("Class",'ovaem-events-manager'),
				       "param_name" => "class"
				    )

			 
		)));



}