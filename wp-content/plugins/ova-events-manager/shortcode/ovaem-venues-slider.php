<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_venues_slider', 'ovaem_venues_slider');
function ovaem_venues_slider($atts, $content = null) {

	$prefix = OVAEM_Settings::$prefix;

      $atts = extract( shortcode_atts(
	    array(
	    'show_featured' => 'true',	
	    'array_slug' => '',
	    'count'		=> '10',
	    'orderby'	=> $prefix.'_venue_order',
	    'order'	=> 'DESC',
	    'show_title' => 'true',
	    'show_desc' => 'true',
	    'show_address' => 'true',
	    'show_readmore' => 'true',
	    'read_more_text' => 'Read more',
	    'style'	=> 'style1',
	    'show_all_venues' => 'false',
	    'class'   => '',
	    ), $atts) );

      $prefix = OVAEM_Settings::$prefix;

      if( trim( $array_slug ) != ''){
      	$array_slug = explode(',', trim( $array_slug ) );	
      }else{
      	$array_slug = '';
      }
      

      $venues_list = apply_filters( 'ovaem_get_venues_list', $array_slug, $show_featured, $count, $orderby, $order );	

     

      $carousel = '';
      if( $style == 'style1' ){
      	$carousel = 'owl-carousel owl-theme carousel_venues_slider';
      }else if( $style == 'style2' ){
      	$carousel = '';
      }
      

		$html = '<div class="'.$carousel.' '.$style.'  venues_slider '.$class.'">';

			if( $venues_list->have_posts() ): while( $venues_list->have_posts() ):  $venues_list->the_post();

			$address = get_post_meta( get_the_id(), $prefix.'_venue_address', true );
			$img = get_the_post_thumbnail_url( get_the_id(), 'large' );
			$m_img = get_the_post_thumbnail_url( get_the_id(), 'm_img' );

			if( $style == 'style2' ){

				$html .= '<div class="item ova_transa">';

					$html .= '<div class="wrap_img" style="background: url('.$img.') no-repeat">';
						
					$html .= '</div>';

					$html .= '<div class="bottom_content">';

						$html .= '<div class="wrap_content">';
							$html .= $show_title == 'true' ? '<h2><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>' : '';
							$html .= $show_desc == 'true' ? '<div class="desc">'.get_the_excerpt().'</div>' : '';
						$html .= '</div>';

						$html .= $show_address == 'true' ? '<div class="address"><span class="icon"><i class="icon_pin_alt"></i></span><span>'.$address.'</span></div>' : '';

						
						
					$html .= '</div>';

				$html .= '</div>';

			}else{

				$html .= '<div class="item">';

					$html .= '<div class="wrap_img '.$show_readmore.'">';
						$html .= '<img src="'.$m_img.'" alt="'.get_the_title().'" />';
						$html .= $show_readmore == 'true' ? '<div class="read_more"><a class="ova-btn ova-btn-rad-30" href="'.get_the_permalink().'"><i class="arrow_carrot-right_alt"></i>'.$read_more_text.'</a></div>' : '';
					$html .= '</div>';

					$html .= '<div class="wrap_content">';
						$html .= $show_title == 'true' ? '<h2><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>' : '';
						$html .= $show_desc == 'true' ? '<div class="desc">'.get_the_excerpt().'</div>' : '';
					$html .= '</div>';

					$html .= $show_address == 'true' ? '<div class="address"><span class="icon"><i class="icon_pin_alt"></i></span><span>'.$address.'</span></div>' : '';

				$html .= '</div>';

			}
			
			
			endwhile;endif;wp_reset_postdata();

			$html .= ( $show_all_venues == 'true' ) ? '<div class="all_venues_btn text-center"><a class="ova-btn ova-btn-large" href="'.get_post_type_archive_link( OVAEM_Settings::venue_post_type_slug() ).'">'.esc_html__( 'All Venues', 'ovaem-events-manager' ).'</a></div>' : '';

		$html .= '</div>';
	    
	    return $html;

}



if(function_exists('vc_map')){

    	$prefix = OVAEM_Settings::$prefix;
    	$venue_order = $prefix.'_venue_order';
    	$date_created = 'date';

		vc_map( array(
			 "name" => esc_html__("Venue List Slider", 'ovaem-events-manager'),
			 "base" => "ovaem_venues_slider",
			 "description" => esc_html__("Display by slugs or featured", 'ovaem-events-manager'),
			 "class" => "",
			 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
			 "icon" => "icon-qk",   
			 "params" => array(
				
				array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Slug of venue",'ovaem-events-manager'),
			       "description"=> esc_html__("Insert slugs or Empty Field. For example: venue1, venue2, venue3",'ovaem-events-manager'),
			       "param_name" => "array_slug",
			       "value" => "",
			      
			    ),

				array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Only Show Featured",'ovaem-events-manager'),
			       "param_name" => "show_featured",
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
			       "heading" => esc_html__("Count",'ovaem-events-manager'),
			       "param_name" => "count",
			       "value" => "10",
			      
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Order by",'ovaem-events-manager'),
			       "param_name" => "orderby",
			       "value" => array(
			       		esc_html__("Order field in event attribute", "ovaem-events-manager" )	=> $venue_order,
			       		esc_html__("Created Date", "ovaem-events-manager" )	=> $date_created,
			       	),
			       "default" => $venue_order
			       
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
			       "heading" => esc_html__("Show Title",'ovaem-events-manager'),
			       "param_name" => "show_title",
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
			       "heading" => esc_html__("Show Address",'ovaem-events-manager'),
			       "param_name" => "show_address",
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
			       "heading" => esc_html__("Show Readmore",'ovaem-events-manager'),
			       "param_name" => "show_readmore",
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
			       "heading" => esc_html__("Read more text",'ovaem-events-manager'),
			       "param_name" => "read_more_text",
			       "value" => "Read more",
			      
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Style",'ovaem-events-manager'),
			       "param_name" => "style",
			       "value" => array(
			       		esc_html__("Style 1", "ovaem-events-manager" ) => "style1",
			       		esc_html__("Style 2", "ovaem-events-manager" )	=> "style2"
			       	),
			       "default" => "style1"
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show all venues button",'ovaem-events-manager'),
			       "param_name" => "show_all_venues",
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