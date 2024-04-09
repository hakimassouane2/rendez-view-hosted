<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_search_banner', 'ovaem_search_banner');
function ovaem_search_banner($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
	      'title' => '',
	      'subtitle' => '',
	      'place_name' => '',
	      'place_loc' => '',
	      'place_cat' => '',
	      'show_name' => 'true',
	      'show_state' => 'true',
	      'show_city' => 'true',
	      'show_cat' => 'true',
	      'show_venue'	=> 'true',
	      'show_alltime'	=> 'true',
	      'show_date'	=> 'true',
	      'show_today'	=> 'true',
	      'show_tomorrow'	=> 'true',
	      'show_this_week'	=> 'true',
	      'show_this_week_end'	=> 'true',
	      'show_next_week'	=> 'true',
	      'show_next_month'	=> 'true',
	      'show_past'	=> 'true',
	      'show_future'	=> 'true',
	      'sub_title2' => '',
	      'date_format'	=> 'd M Y',
	      'show_upcoming_btn'	=> 'true',
	      'upcoming_link'	=> '',
	      'upcoming_text'	=> '',
	      'upcoming_icon'	=> '',

	      'show_featured_btn'	=> 'true',
	      'featured_link'	=> '',
	      'featured_text'	=> '',
	      'featured_icon'	=> '',

	      'show_all_events_btn'	=> 'true',
	      'all_events_link'	=> '',
	      'all_events_text'	=> '',
	      'all_events_icon' => '',

	      'search_button_text' 	=> esc_html__('Search','ovaem-events-manager'),
	      'class'   => '',
	    ), $atts) );

      	
       	$event_post_type_slug = OVAEM_Settings::event_post_type_slug();

       	// Get all categories
       	$cats = apply_filters('ovaem_get_categories','');

       	$name_event = isset( $_GET["name_event"] ) ? $_GET["name_event"] : '';
       	$cat = isset( $_GET["cat"] ) ? $_GET["cat"] : '';
       	$name_loc = isset( $_GET["name_country"] ) ? $_GET["name_country"] : '';

       	$name_country = isset( $_GET["name_country"] ) ? $_GET["name_country"] : '';
       	$country = apply_filters( 'ovaem_get_country', $name_country );

       	$name_city = isset( $_GET["name_city"] ) ? $_GET["name_city"] : '';
       	$city = apply_filters( 'ovaem_get_city', $name_city );
       	

       	// Get all categories params
       	$cats_params = apply_filters('ovaem_get_categories_params',$cat);

        $html = '<div class="ovaem_search_banner ovaem_search_state_city '.$class.'">';

        	$html .= $title ? '<h2 class="search_title">'.$title.'</h2>' : '';
        	$html .= $subtitle ? '<h3 class="search_subtitle">'.$subtitle.'</h3>' : '';

        	$html .= '<form action="'.home_url('/').'" method="GET" name="search_event" >';

        		$html .= $show_name == 'true' ? '<div class="ovaem_name_event"><input class="form-controll selectpicker" placeholder="'.$place_name.'" name="name_event" value="'.$name_event.'" /></div>' : '';

				if( $show_state == 'true' ){
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
					// Get all venues
       				$venues = apply_filters('ovaem_venues', '');

					$html .= '<div class="ovaem_venue">';
	    			$html .= '<select name="name_venue" class="selectpicker ">';
	    				$html .= '<option value="">'.esc_html__('All Venue', 'ovaem-events-manager').'</option>';
	    					if($venues->have_posts() ) : while ( $venues->have_posts() ) : $venues->the_post(); 

									global $post;

									$html .= '<option value="'.$post->post_name.'">
										'.get_the_title().'</option>';

								endwhile;endif; wp_reset_postdata(); wp_reset_query();
	    					
	    			$html .= '</select>';
	    			$html .= '</div>';
				}

				if( $show_alltime == 'true' ){

					$html .= '<div class="ovaem_time">';
	        			$html .= '<select name="time" class="selectpicker select_alltime" style="z-index: 9999">';
	        				$html .= '<option value="">'.esc_html__('All Time', 'ovaem-events-manager').'</option>';

	        				$html .= $show_today == 'true' ? '<option value="today">'.esc_html__('Today', 'ovaem-events-manager').'</option>' : '';
	        				
	        				$html .= $show_tomorrow == 'true' ? '<option value="tomorrow">'.esc_html__('Tomorrow', 'ovaem-events-manager').'</option>' : '';
	        				
	        				$html .= $show_this_week == 'true' ? '<option value="this_week" >'.esc_html__('This Week', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_this_week_end == 'true' ? '<option value="this_week_end" >'.esc_html__('This Weekend', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_next_week == 'true' ? '<option value="next_week" >'.esc_html__('Next Week', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_next_month == 'true' ? '<option value="next_month" >'.esc_html__('Next Month', 'ovaem-events-manager').'</option>' : '';

	        				$html .=  $show_past == 'true' ? '<option value="past" >'.esc_html__('Past Events', 'ovaem-events-manager').'</option>' : '';

	        				$html .=  $show_future == 'true' ? '<option value="future">'.esc_html__('Future Events', 'ovaem-events-manager').'</option>' : '';

	        			$html .= '</select>';
	        		$html .= '</div>';
	        		
				}

				if( $show_date ==  'true' ){

	        		
	        		

	        		$html .= '<div class="ovaem_date">';

	        			$html .= '<input id="from" class="ovaem_select_date ovaem_date_from form-controll selectpicker" placeholder="'.esc_html__('From ...', 'ovaem-events-manager').'" data-date_format="'.esc_attr($date_format).'" data-lang="'.OVAEM_Settings::event_calendar_lang().'" data-first-day="'.OVAEM_Settings::first_day_of_week().'" name="ovaem_date_from" value="" />';

	        			$html .= '<input id="to" class="ovaem_select_date ovaem_date_to form-controll selectpicker" placeholder="'.esc_html__('To ...', 'ovaem-events-manager').'" data-date_format="'.esc_attr($date_format).'" data-lang="'.OVAEM_Settings::event_calendar_lang().'" data-first-day="'.OVAEM_Settings::first_day_of_week().'" name="ovaem_date_to" value="" />';

	        		$html .= '</div>';
        		}

				if( $show_cat == 'true' ){

	        		$html .= '<div class="ovaem_cat">';
	        			$html .= wp_dropdown_categories($cats_params);
					$html .= '</div>';
				}


        		$html .= '<input type="hidden" name="post_type" value="'.$event_post_type_slug.'">';
        		$html .= '<input type="hidden" name="search" value="search-event">';
        		$html .= '<div class="ovaem_submit"><input type="submit" value="'.$search_button_text.'" /></div>';
        	$html .= '</form>';

        	$html .= '<div class="sub_title2">'.$sub_title2.'</div>';
        	$html .= '<div class="browser_featured">';
	        	$html .= $show_upcoming_btn == 'true' ? '<a href="'.$upcoming_link.'"><i class="'.$upcoming_icon.'"></i>'.$upcoming_text.'</a>' : '';
	        	$html .= $show_featured_btn == 'true' ? '<a href="'.$featured_link.'"><i class="'.$featured_icon.'"></i>'.$featured_text.'</a>' : '';
	        	$html .= $show_all_events_btn == 'true' ? '<a href="'.$all_events_link.'"><i class="'.$all_events_icon.'"></i>'.$all_events_text.'</a>' : '';
        	$html .= '</div>';

        $html .= '</div>';
	    
	    return $html;

}



if(function_exists('vc_map')){

	vc_map( array(
		 "name" => esc_html__("Search Banner", 'ovaem-events-manager'),
		 "base" => "ovaem_search_banner",
		 "description" => esc_html__("Allow show/hide field in search form", 'ovaem-events-manager'),
		 "class" => "",
		 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		 "icon" => "icon-qk",   
		 "params" => array(
		 	
		 	
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Title",'ovaem-events-manager'),
			       "param_name" => "title",
			       "value" => ""
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Sub Title",'ovaem-events-manager'),
			       "param_name" => "subtitle",
			       "value" => ""
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Placeholder Name",'ovaem-events-manager'),
			       "param_name" => "place_name",
			       "value" => ""
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Placeholder Location",'ovaem-events-manager'),
			       "param_name" => "place_loc",
			       "value" => ""
			    ),
			     array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Placeholder Category",'ovaem-events-manager'),
			       "param_name" => "place_cat",
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
			       "heading" => __("Show State",'ovaem-events-manager'),
			       "param_name" => "show_state",
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
			       "heading" => __("Show Venue",'ovaem-events-manager'),
			       "param_name" => "show_venue",
			       "value" => array(
			       		__('True', 'ovaem-events-manager') => "true",
			       		__('False', 'ovaem-events-manager') => "false"
			       	),
			       "default"	=> "true"
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => __("Show All Time",'ovaem-events-manager'),
			       "param_name" => "show_alltime",
			       "value" => array(
			       		__('True', 'ovaem-events-manager') => "true",
			       		__('False', 'ovaem-events-manager') => "false"
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
			       		__('False', 'ovaem-events-manager') => "false"
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
			       "heading" => __("Show Upcoming Button",'ovaem-events-manager'),
			       "param_name" => "show_upcoming_btn",
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
			       "heading" => esc_html__("Upcoming Link",'ovaem-events-manager'),
			       "param_name" => "upcoming_link"
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Upcoming Text",'ovaem-events-manager'),
			       "param_name" => "upcoming_text",
			       
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Upcoming Icon",'ovaem-events-manager'),
			       "param_name" => "upcoming_icon"
			    ),
			     
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => __("Show Featured Button",'ovaem-events-manager'),
			       "param_name" => "show_featured_btn",
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
			       "heading" => esc_html__("Featured Link",'ovaem-events-manager'),
			       "param_name" => "featured_link"
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Featured Text",'ovaem-events-manager'),
			       "param_name" => "featured_text",

			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Featured Icon",'ovaem-events-manager'),
			       "param_name" => "featured_icon"
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
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => __("Show All Events Button",'ovaem-events-manager'),
			       "param_name" => "show_all_events_btn",
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
			       "heading" => esc_html__("All Events Link",'ovaem-events-manager'),
			       "param_name" => "all_events_link"
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("All Events Text",'ovaem-events-manager'),
			       "param_name" => "all_events_text"
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("All Events Icon",'ovaem-events-manager'),
			       "param_name" => "all_events_icon"
			    ),
			    
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__('Sub Title 2','ovaem-events-manager'),
			       "param_name" => "sub_title2"
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Search button text",'ovaem-events-manager'),
			       "param_name" => "search_button_text"
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
