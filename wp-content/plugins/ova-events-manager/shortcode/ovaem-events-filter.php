<?php if ( !defined( 'ABSPATH' ) ) exit();

add_shortcode('ovaem_events_filter', 'ovaem_events_filter');
function ovaem_events_filter($atts, $content = null) {


	// isotope
	wp_enqueue_script('isotope_pkgd_min', OVAEM_PLUGIN_URI.'assets/libs/isotope.pkgd.min.js', array('jquery'),null,true);

	$prefix = OVAEM_Settings::$prefix;
	$date_start_time = $prefix.'_date_start_time';

      $atts = extract( shortcode_atts(
	    array(
	      'array_slug'    => '',	
	      'filter' => 'upcomming',
	      'tab_active'	=> "",
	      'orderby' => $date_start_time,
	      'order' => 'DESC',
	      'show_past' => 'true',
	      'address_type'	=> 'venue',
	      'count'	=> 3,
	      'show_name' => 'true',
	      'show_time' => 'true',
	      'show_price' => 'true',
	      'show_desc' => 'true',
	      'show_venue' => 'true',
	      'get_ticket' => 'Get ticket',
	      'no_ticket' => 'No ticket',
	      'show_get_ticket' => 'true',
	      'show_get_ticket_expired' => 'true',
	      'read_more_text' => 'All events',
	      'show_readmore' => 'true',
	      'style' => 'style1',
	      'btn_style' => 'style1',
	      'show_nav' => 'show_nav',
	      'show_status' => 'false',
	      'class'   => '',
	    ), $atts) );

      	

      	$prefix = OVAEM_Settings::$prefix;
      	$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
      	$date_format = get_option('date_format');

      	$day_format = OVAEM_Settings::ovaem_day_format();
		$month_format = OVAEM_Settings::ovaem_month_format();
		$year_format = OVAEM_Settings::ovaem_year_format();


    	$categories = apply_filters( 'ovaem_get_categories', 10 );
    	$array_slug = explode( ',', trim( $array_slug ) );

    	$tab_active_all = (trim($tab_active) == '') ? 'current' : '';

	    $html = '<div class="ovaem_events_filter '.$class.'" data-order="'.$order.'"><div class="row">';

	    	/* Navigation */
    		$html .= '<div class="events_filter_'.$show_nav.'">';
		    	$html .= '<div class="select_cat_mobile_btn"><div class="btn_filter ova-btn ova-btn-second-color">'.esc_html__('Select Category', 'ovaem-events-manager').'<i class="arrow_carrot-down"></i></div>';

			    	$html .='<ul class="clearfix ovaem_events_filter_nav '.$style.'" data-tab_active ="'.$tab_active.'">
			                    <li class="all '.$tab_active_all.'"><a href="#" class="ova-btn ova-btn-rad-30" data-filter="*">'.esc_html__( "All", "ovaem-events-manager" ).'</a></li>';
			                    for( $i=0; $i < count($array_slug); $i++ ){

							      foreach ($categories as $key => $cat) {

							        if(trim( $array_slug[$i] ) == $cat->slug){

							        	$tab_active = ($cat->slug == $tab_active) ? 'current':'';
							          	$html .= '<li class="'.$cat->slug.' '.$tab_active.'"><a class="ova-btn ova-btn-rad-30" href="#" data-filter=".'.$cat->slug.'">'.$cat->name.'</a></li>';

							        }

							      }

							    }
			                $html .='</ul>';

		        $html .= '</div>';
	    	$html .= '</div>';





            /* Content */
            $html .= '<div class="ovaem_events_filter_content">';
            $l = $m = 0;
            
            $event_ids = array();

            for( $i=0; $i < count($array_slug); $i++ ){
            	
            	$eventlist = apply_filters( 'ovaem_events_orderby', $filter, $count, trim( $array_slug[$i] ), $orderby, $order, $show_past  );

            	if( $eventlist->have_posts() ): while( $eventlist->have_posts() ):  $eventlist->the_post();
            		
            		$id = get_the_id();

            		if ( in_array( $id, $event_ids ) ) {
            			continue;
            		} else {
            			array_push( $event_ids, $id );
            		}

            		$cat_slug = '';
            		$terms  = get_the_terms( $id , $slug_taxonomy_name);
                    if ( $terms && ! is_wp_error( $terms ) ) : 
                        foreach ( $terms as $term ) {
                          $cat_slug.= ' '.$term->slug ;
                        }
                    endif;

                    $end_time = get_post_meta( $id, $prefix.'_date_end_time', true );
		    		$start_time = get_post_meta( $id, $prefix.'_date_start_time', true );
					$time_m = $start_time ? date_i18n( $month_format, $start_time )  : '';
			    	$time_d = $start_time ? date_i18n( $day_format.'-'.$year_format, $start_time )  : '';

		    		$date_by_format = $start_time ? date_i18n( $date_format , $start_time )  : '';

		    		

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

		    		
		    		
		    		$tickets_arr = get_post_meta( $id, $prefix.'_ticket', true );
		    		$price = apply_filters( 'ovaem_get_price', $tickets_arr );


		    		
		    		$d_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
		    		$m_img  = wp_get_attachment_image_url( get_post_thumbnail_id(), 'm_img' );

		    		$check_status_event = apply_filters( 'ovaem_check_status_event', $start_time, $end_time );
		    		$check_pass_time = (int)current_time( 'timestamp' ) < (int)$end_time ? true : false;

		    		if ( $show_get_ticket_expired == 'true' ) {
		    			$check_pass_time = true;
		    		}

		    		if( $style == 'style1' ){


		    			$html .= '<div class="col-md-4 col-sm-6 col-xs-6 ova-item isotope-item '.$style.' '.$cat_slug.'">';

		    				if( count( $array_slug ) > 1 ){
		    					$html .= '<p class="number" style="display:none;">'.strtotime($date_by_format).'</p>';
		    				}
			    			$html .= '<a href="'.get_the_permalink().'"><div class="ova_thumbnail">

			    							<img alt="'.get_the_title().'" src="'.$d_img.'" srcset=" '.$d_img.' 370w, '.$m_img.' 640w" sizes="(max-width: 640px) 100vw, 370px" />';

			    							$html .= ( $show_venue == 'true' && $address != '' )  ? '<div class="venue"><span><i class="icon_pin_alt"></i></span>'.esc_html( sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ).'</div>' : '';

			    							if( $show_time == 'true' || $show_price == 'true' ){
			    							$html .= '<div class="time">';
			    								$html .= $show_time == 'true' ? '<span class="month">'.$time_m.'</span><span class="date">'.$time_d.'</span>' : '';
			    								if ( ! empty( $tickets_arr ) ) {
			    									$html .= $show_price == 'true' ? '<span class="price">'.$price.'</span>' : '';
			    								}
			    							$html .= '</div>';
			    							}

			    			$html .= '</div></a>';

			    			$html .= '<div class="wrap_content">';

			    			$html .= $show_name == 'true' ? '<h2 class="title"><a href="'.get_the_permalink().'">'.sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ).'</a></h2>' : '';

			    			if( $show_status == 'true' ){
			    				$html .= '<div class="status">'.$check_status_event.'</div>';
			    			}

			    			$html .= $show_desc == 'true' ? '<div class="except">'.sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ).'</div>' : '';

			    			if ( empty( $tickets_arr ) ) {
			    				$html .= $show_get_ticket == 'true' ? '<div class="more_detail"><a class="btn_link ova-btn ova-btn-rad-30" href="'.get_the_permalink().'">'.$no_ticket.'</a></div>' : '';
			    			} else {
			    				if ( $check_pass_time === true ) {

			    					$html .= $show_get_ticket == 'true' ? '<div class="more_detail"><a class="btn_link ova-btn ova-btn-rad-30" href="'.get_the_permalink().'">'.$get_ticket.'</a></div>' : '';
			    				}
			    			}

			    			$html .= '</div>';

		    			$html .= '</div>';

		    			

		    		}else if( $style == 'style2' ){

		    			$html .= '<div class="col-md-4 col-sm-6 col-xs-6 ova-item isotope-item '.$style.' '.$cat_slug.'">';

		    				if( count( $array_slug ) > 1 ){
		    					$html .= '<p class="number" style="display:none;">'.strtotime($date_by_format).'</p>';
		    				}

			    			$html .= '<a href="'.get_the_permalink().'"><div class="ova_thumbnail">

			    							<img alt="'.get_the_title().'" src="'.$d_img.'" srcset=" '.$d_img.' 370w, '.$m_img.' 640w" sizes="(max-width: 640px) 100vw, 370px" />';
			    							
			    							$html .= $show_time == 'true' ? '<div class="time"><span class="month">'.$time_m.'</span><span class="date">'.$time_d.'</span></div>' : '';
			    							

			    			$html .= '</div></a>';

			    			$html .= '<div class="wrap_content">';
			    			$html .= $show_name == 'true' ? '<h2 class="title"><a href="'.get_the_permalink().'">'.sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ).'</a></h2>' : '';
			    			$html .= $show_desc == 'true' ? '<div class="except">'.sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ).'</div>' : '';
			    			$html .= ( $show_venue == 'true' && $address != '' ) ? '<div class="venue"><span><i class="icon_pin_alt"></i></span>'.esc_html( sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ).'</div>' : '';
			    			
			    			$html .= '<div class="bottom">';

			    			$flag = true;

			    			if ( empty( $tickets_arr ) ) {
			    				$html .= $show_get_ticket == 'true' ? '<div class="more_detail"><a class="btn_link" href="'.get_the_permalink().'"><span>'.$no_ticket.'</span></a></div>' : '';
			    			} else {
			    				if ( $check_pass_time === true ) {
			    					$html .= $show_get_ticket == 'true' ? '<div class="more_detail"><a class="btn_link" href="'.get_the_permalink().'"><span>'.$get_ticket.'</span></a></div>' : '';
				    			} else {
				    				$flag = false;
				    			}
			    			}

			    			if ( $show_get_ticket == 'true' && $flag ) {

				    			if( $show_status == 'true' ){
				    				$html .= '<div class="status">'.$check_status_event.'</div>';
				    			}
				    			
				    			if ( ! empty( $tickets_arr ) ) {
									$html .= $show_price == 'true' ? '<span class="price">'.$price.'</span>' : '';
								}

							}

			    			$html .= '</div>';

			    			$html .= '</div>';

		    			$html .= '</div>';


		    		}else if( $style == 'style3' ){

		    			$html .= '<div class="col-md-4 col-sm-6 col-xs-6 ova-item isotope-item '.$style.' '.$cat_slug.'">';

		    				if( count( $array_slug ) > 1 ){
		    					$html .= '<p class="number" style="display:none;">'.strtotime($date_by_format).'</p>';
		    				}

			    			$html .= '<a href="'.get_the_permalink().'"><div class="ova_thumbnail">

    							<img alt="'.get_the_title().'" src="'.$d_img.'" srcset=" '.$d_img.' 370w, '.$m_img.' 640w" sizes="(max-width: 640px) 100vw, 370px" />';
    							
    							$html .= ( $show_time == 'true' && $date_by_format ) ? '<div class="date"><span class="month">'.$date_by_format.'</span></div>' : '';

    							$html .= ( $show_venue == 'true' && $address != '' ) ? '<div class="venue"><span><i class="icon_pin_alt"></i></span>'.esc_html( sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ).'</div>' : '';

    							if ( ! empty( $tickets_arr ) ) {
									$html .= ( $show_price == 'true' && $price ) ? '<div class="time"><span class="price">'.$price.'</span></div>' : '';
								}
			    							

			    			$html .= '</div></a>';

			    			$html .= '<div class="wrap_content">';
			    			$html .= $show_name == 'true' ? '<h2 class="title"><a href="'.get_the_permalink().'">'.sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ).'</a></h2>' : '';
			    			
			    			$html .= ( $show_venue == 'true' && $address != '' ) ? '<div class="venue_mobile"><span><i class="icon_pin_alt"></i></span>'.esc_html( sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ).'</div>' : '';

			    			$html .= $show_desc == 'true' ? '<div class="except">'.sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ).'</div>' : '';

			    			if ( empty( $tickets_arr ) ) {
			    				$html .= $show_get_ticket == 'true' ? '<div class="more_detail"><a class="btn_link" href="'.get_the_permalink().'">'.$no_ticket.'<i class="arrow_right"></i></a></div>' : '';
			    			} else {
			    				if ( $check_pass_time === true ) {
			    					$html .= $show_get_ticket == 'true' ? '<div class="more_detail"><a class="btn_link" href="'.get_the_permalink().'">'.$get_ticket.'<i class="arrow_right"></i></a></div>' : '';
			    				}
			    			}

			    			if( $show_status == 'true' ){
			    				$html .= '<div class="status">'.$check_status_event.'</div>';
			    			}

			    			$html .= '</div>';

		    			$html .= '</div>';

		    		}else if( $style == 'style4' ){

		    			$html .= '<div class="col-md-4 col-sm-6 col-xs-6 ova-item isotope-item style3 '.$style.' '.$cat_slug.'">';

		    				if( count( $array_slug ) > 1 ){
		    					$html .= '<p class="number" style="display:none;">'.strtotime($date_by_format).'</p>';
		    				}

			    			$html .= '<a href="'.get_the_permalink().'"><div class="ova_thumbnail">

    							<img alt="'.get_the_title().'" src="'.$d_img.'" srcset=" '.$d_img.' 370w, '.$m_img.' 640w" sizes="(max-width: 640px) 100vw, 370px" />';

    							$html .= ( $show_time == 'true' && $date_by_format ) ? '<div class="date"><span class="month">'.$date_by_format.'</span></div>' : '';

    							$html .= ( $show_venue == 'true' && $address != '' ) ? '<div class="venue"><span><i class="icon_pin_alt"></i></span>'.esc_html( sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ).'</div>' : '';

    							if ( ! empty( $tickets_arr ) ) {
									$html .= ( $show_price == 'true' && $price ) ? '<div class="time"><span class="price">'.$price.'</span></div>' : '';
								}
			    							

			    			$html .= '</div></a>';

			    			$html .= '<div class="wrap_content">';
			    			$html .= $show_name == 'true' ? '<h2 class="title"><a href="'.get_the_permalink().'">'.sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ).'</a></h2>' : '';

			    			$html .= ( $show_venue == 'true' && $address != '' ) ? '<div class="venue_mobile"><span><i class="icon_pin_alt"></i></span>'.esc_html( sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ).'</div>' : '';
			    			$html .= $show_desc == 'true' ? '<div class="except">'.sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ).'</div>' : '';

			    			if ( empty( $tickets_arr ) ) {
			    				$html .= $show_get_ticket == 'true' ? '<div class="more_detail"><a class="btn_link" href="'.get_the_permalink().'">'.$no_ticket.'<i class="arrow_right"></i></a></div>' : '';
			    			} else {
			    				if ( $check_pass_time === true ) {
			    					$html .= $show_get_ticket == 'true' ? '<div class="more_detail"><a class="btn_link" href="'.get_the_permalink().'">'.$get_ticket.'<i class="arrow_right"></i></a></div>' : '';
			    				}
			    			}

			    			if( $show_status == 'true' ){
			    				$html .= '<div class="status">'.$check_status_event.'</div>';
			    			}

			    			$html .= '</div>';

		    			$html .= '</div>';

		    		}

		    			
		    		
		    		$m++; $l++;
		    		if( $m == 2 ){ $html .= '<div class="mobile_row"></div>'; $m = 0; }
		    		if( $l == 3 ){ $html .= '<div class="row"></div>'; $l = 0; }

            	endwhile;endif; wp_reset_postdata();

            }

            $html .= '</div>';

            if( $show_readmore == 'true' ){

            	if( $btn_style == 'style2' ){
        			
        			$html .= '<div class="read_more"><a class="ova-btn ova-btn-large" href="'.get_post_type_archive_link(OVAEM_Settings::event_post_type_slug()).'">'.$read_more_text.'</a></div>';

            	}else{
            		$html .= '<div class="read_more"><a class="ova-btn ova-btn-rad-30 ova-btn-arrow" href="'.get_post_type_archive_link(OVAEM_Settings::event_post_type_slug()).'"><i class="arrow_carrot-right_alt"></i>'.$read_more_text.'</a></div>';

            		
            	}
            	
            }
            
	    	

	    $html .= '</div></div>';
	    
	    return $html;

}



if(function_exists('vc_map')){

	$prefix = OVAEM_Settings::$prefix;
	$date_start_time = $prefix.'_date_start_time';
	$date_end_time = $prefix.'_date_end_time';
	$date_order = $prefix.'_order';
	$date_created = 'date';

	vc_map( array(
		 "name" => esc_html__("Category Filter", 'ovaem-events-manager'),
		 "base" => "ovaem_events_filter",
		 "description" => esc_html__("Category Navigation Filter", 'ovaem-events-manager'),
		 "class" => "",
		 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		 "icon" => "icon-qk",   
		 "params" => array(
		 	
		 		array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Slug Categories list",'ovaem-events-manager'),
			       "param_name" => "array_slug",
			       "description" => esc_html__("You can find slug in: Events Manager >> Event Categories >> Copy value in Slug column. Example: conference, art, travel, business, concert, education",'ovaem-events-manager'),
			       "value" => ""
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Tab active",'ovaem-events-manager'),
			       "param_name" => "tab_active",
			       "description" => esc_html__("Empty to active All tab or insert slug category",'ovaem-events-manager'),
			       "value" => ""
			    ),
		 		array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Filter in each category",'ovaem-events-manager'),
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
			       "heading" => esc_html__("Count item in each category",'ovaem-events-manager'),
			       "param_name" => "count",
			       "value" => "3",
			       "description" => esc_html__("Insert number.",'ovaem-events-manager')
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
			       "heading" => esc_html__("Order in each category",'ovaem-events-manager'),
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
			       "heading" => esc_html__("Show name",'ovaem-events-manager'),
			       "param_name" => "show_name",
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
			       "heading" => esc_html__("Show Time",'ovaem-events-manager'),
			       "param_name" => "show_time",
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
			       "heading" => esc_html__("Show Description",'ovaem-events-manager'),
			       "param_name" => "show_desc",
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
			       "heading" => esc_html__("Show Price",'ovaem-events-manager'),
			       "param_name" => "show_price",
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
			       "heading" => esc_html__("Show Venue",'ovaem-events-manager'),
			       "param_name" => "show_venue",
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
			       "heading" => esc_html__("Show Get Ticket",'ovaem-events-manager'),
			       "param_name" => "show_get_ticket",
			       "value" => array(
			       		esc_html__("True", "ovaem-events-manager" ) => "true",
			       		esc_html__("False", "ovaem-events-manager" )	=> "false"
			       	),
			       "default" => "true"
			       
			    ),
			    // dependency show_get_ticket
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show Expired Get Ticket",'ovaem-events-manager'),
			       "param_name" => "show_get_ticket_expired",
			       'dependency' => array( 'element' => 'show_get_ticket', 'value' => 'true' ),
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
			       "heading" => esc_html__("Replace Get ticket",'ovaem-events-manager'),
			       "param_name" => "get_ticket",
			       "value" => "Get ticket"
			    ),
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Replace No ticket",'ovaem-events-manager'),
			       "param_name" => "no_ticket",
			       "value" => "No ticket"
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show Read More",'ovaem-events-manager'),
			       "param_name" => "show_readmore",
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
			       "heading" => esc_html__("Button Style",'ovaem-events-manager'),
			       "param_name" => "btn_style",
			       "value" => array(
			       		esc_html__("Style 1", "ovaem-events-manager" ) => "style1",
			       		esc_html__("Style 2", "ovaem-events-manager" )	=> "style2"
			       	),
			       "default" => "style1"
			       
			    ),
			    
			    array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Replace All Events Button Text",'ovaem-events-manager'),
			       "param_name" => "read_more_text",
			       "value" => "All events"
			    ),
			    
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Style",'ovaem-events-manager'),
			       "param_name" => "style",
			       "value" => array(
			       		esc_html__("Style 1", "ovaem-events-manager" ) => "style1",
			       		esc_html__("Style 2", "ovaem-events-manager" )	=> "style2",
			       		esc_html__("Style 3", "ovaem-events-manager" )	=> "style3",
			       		esc_html__("Style 4", "ovaem-events-manager" )	=> "style4"
			       	),
			       "default" => "style1"
			       
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show Navigation",'ovaem-events-manager'),
			       "param_name" => "show_nav",
			       "value" => array(
			       		esc_html__("Yes", "ovaem-events-manager" ) => "show_nav",
			       		esc_html__("No", "ovaem-events-manager" )	=> "hide_nav"
			       	),
			       "default" => "show_nav"
			       
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show Status",'ovaem-events-manager'),
			       "param_name" => "show_status",
			       "value" => array(
			       		esc_html__("False", "ovaem-events-manager" ) => "false",
			       		esc_html__("True", "ovaem-events-manager" )	=> "true"
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