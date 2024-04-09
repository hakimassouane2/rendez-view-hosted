<?php if ( !defined( 'ABSPATH' ) ) exit();

add_shortcode('ovaem_eventlist', 'ovaem_eventlist');
function ovaem_eventlist($atts, $content = null) {

		$prefix = OVAEM_Settings::$prefix;
		$date_start_time = $prefix.'_date_start_time';

      $atts = extract( shortcode_atts(
	    array(
	      'filter' => 'upcomming',
	      'count'	=> 3,
	      'address_type'	=> 'room',
	      'orderby' => $date_start_time,
	      'order' => 'DESC',
	      'show_past' => 'true',
	      'show_name' => 'true',
	      'show_time' => 'true',
	      'show_desc' => 'true',
	      'show_readmore' => 'true',
	      'show_button' => 'true',
	      'read_more_text' => 'Read More',
	      'class'   => '',
	    ), $atts) );

        $date_format = get_option('date_format');

        


        $eventlist = apply_filters( 'ovaem_events_orderby', $filter, $count, $cat = '', $orderby, $order, $show_past );

        $prefix = OVAEM_Settings::$prefix;
        

	    $html = '<div class="ovametheme_eventlist">';
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

	    		$time = $start_time ? date_i18n( $date_format, $start_time )  : '';

	    		

	    		$html .= '<div class="col-md-3 ova-item">';
	    			$html .= '<div class="thumbnail">
	    							<img src="'.get_the_post_thumbnail_url().'" alt="'.get_the_title().'" />
	    							<div class="time">'.$time.'</div>
	    					</div>';
	    			$html .= '<h2 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
	    			
	    			$html .= $address != '' ? '<div class="time">'.$address.'</div>';
	    		$html .= '</div>';
	    	endwhile;endif; wp_reset_postdata();
	    $html .= '</div>';
	    
	    return $html;

}
