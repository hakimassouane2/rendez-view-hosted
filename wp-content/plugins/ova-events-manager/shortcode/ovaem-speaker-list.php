<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_speaker_list', 'ovaem_speaker_list');
function ovaem_speaker_list($atts, $content = null) {

	$prefix = OVAEM_Settings::$prefix;

      $atts = extract( shortcode_atts(
	    array(
	    'show_featured' => 'true',	
	    'array_slug' => '',
	    'count'		=> '10',
	    'orderby'	=> $prefix.'_speaker_order',
	    'order'	=> 'DESC',
	    'show_title' => 'true',
	    'show_link' => 'true',
	    'show_social' => 'true',
	    'show_job' => 'true',
	    'style'	=> 'style1',
	    'dis_all_speaker' => "true",
	    'read_more_text' => 'All Speakers',
	    'style_button_read_more' => 'ova-btn-rad-30 ova-btn-arrow',
	    'class'   => '',
	    ), $atts) );

      
      if( trim( $array_slug ) != ''){
      	$speaker_slugs = explode(',', trim( $array_slug ) );	
      }else{
      	$speaker_slugs = array();
      }
     

      $speakerslist = apply_filters( 'ovaem_get_speakers_list', $speaker_slugs, $show_featured, $count, $orderby, $order);	

      $l = 0;
	  $m = 0;
      

      $html = '<div class="ova_speaker_list_wrap '.$class.' '.$style.'"><div class="row speaker_row">';


      if( $speakerslist->have_posts() ): while( $speakerslist->have_posts() ):  $speakerslist->the_post();

      $img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );

      	if($style == 'style1' ){

	      	$html .= '<div class="col-md-3 col-sm-6">';
	      		$html .= '<div class="ova_speaker_list ">';
	      			

	      			$html .= '<img src="'.$img.'"  alt="'.get_the_title().'" />';
	      			
	      			$html .= '<div class="content">';
	      				$html .= '<div class="trig"><i class="arrow_carrot-up"></i></div>';
	      				if( $show_title == 'true' ){
	      					$html .= $show_link == 'true' ? '<h3 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>' : '<h3>'.get_the_title().'</h3>' ;	
	      				}

	      				$html .= $show_job == 'true' ? '<div class="job">'.get_post_meta( get_the_id(), $prefix.'_speaker_job', true ).'</div>' : '';
	      				
	      				if( $show_social == 'true' ){

	      					$socials = get_post_meta( get_the_id(), $prefix.'_speaker_social', true );
	  						if( $socials ){
		      					$html .= '<ul class="social">';
		      						foreach ($socials as $key => $value) {
		      							$html .= '<li><a target="_blank" href="'.$value['link'].'"><i class="'.$value['fontclass'].'"></i></a></li>';
		      						}
		      						
		      					$html .= '</ul>';
		      				}
	      				}

	      			$html .= '</div>';

	      		$html .= '</div>';
	      	$html .= '</div>';

      	} else if( $style == 'style2' || $style == 'style2 style3' ){

      		$html .= '<div class="col-md-3 col-sm-6">';
	      		$html .= '<div class="ova_speaker_list ">';
	      			

	      			$html .= '<div class="wrap_img">';

		      			$html .= '<img src="'.$img.'"  alt="'.get_the_title().'" />';

		      			if( $show_social == 'true' ){

	      					$socials = get_post_meta( get_the_id(), $prefix.'_speaker_social', true );
	  						if( $socials ){
		      					$html .= '<ul class="social">';
		      						foreach ($socials as $key => $value) {
		      							$html .= '<li><a target="_blank" href="'.$value['link'].'"><i class="'.$value['fontclass'].'"></i></a></li>';
		      						}
		      						
		      					$html .= '</ul>';
		      				}
	      				}

      				$html .= '</div>';
	      			
	      			$html .= '<div class="content">';
	      				$html .= '<div class="trig"><i class="arrow_carrot-up"></i></div>';
	      				if( $show_title == 'true' ){
	      					$html .= $show_link == 'true' ? '<h3 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>' : '<h3>'.get_the_title().'</h3>' ;	
	      				}

	      				$html .= $show_job == 'true' ? '<div class="job">'.get_post_meta( get_the_id(), $prefix.'_speaker_job', true ).'</div>' : '';
	      				
	      				

	      			$html .= '</div>';

	      		$html .= '</div>';
	      	$html .= '</div>';
	      	
      	}else if( $style == 'style4' ){
      		$html .= '<div class="col-md-3 col-sm-6">';
	      		$html .= '<div class="ova_speaker_list ">';
	      			

	      			$html .= '<img src="'.$img.'"  alt="'.get_the_title().'" />';
	      			
	      			$html .= '<div class="content">';

	      				$html .='<div class="wrap_info ova-trans">';
		      				
		      				if( $show_title == 'true' ){
		      					$html .= $show_link == 'true' ? '<h3 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>' : '<h3>'.get_the_title().'</h3>' ;	
		      				}
		      				$html .= $show_job == 'true' ? '<div class="job">'.get_post_meta( get_the_id(), $prefix.'_speaker_job', true ).'</div>' : '';

		      			$html .= '</div>';
	      				
	      				if( $show_social == 'true' ){

	      					$socials = get_post_meta( get_the_id(), $prefix.'_speaker_social', true );
	  						if( $socials ){
		      					$html .= '<ul class="social">';
		      						foreach ($socials as $key => $value) {
		      							$html .= '<li><a target="_blank" href="'.$value['link'].'"><i class="'.$value['fontclass'].'"></i></a></li>';
		      						}
		      						
		      					$html .= '</ul>';
		      				}
	      				}

	      			$html .= '</div>';

	      		$html .= '</div>';
	      	$html .= '</div>';
      	}

      	$l++; $m++; 
      	if( $m == 2 ){ $html .= '<div class="mobile_row"></div>'; $m = 0; }
		if( $l == 4 ){ $html .= '<div class="row"></div>'; $l = 0; }




      endwhile; endif; wp_reset_postdata();
      
      $html .= ( $dis_all_speaker =='true' ) ? '<div class="read_more"><a class="ova-btn '.$style_button_read_more.'" href="'.get_post_type_archive_link(OVAEM_Settings::speaker_post_type_slug()).'"><i class="arrow_carrot-right_alt"></i>'.$read_more_text.'</a></div>' : '';

	$html .= '</div></div>';
	    
	return $html;

}



if(function_exists('vc_map')){

    	$prefix = OVAEM_Settings::$prefix;
    	$speaker_order = $prefix.'_speaker_order';
    	$date_created = 'date';

		vc_map( array(
			 "name" => esc_html__("Speaker List", 'ovaem-events-manager'),
			 "base" => "ovaem_speaker_list",
			 "description" => esc_html__("Display by slugs or featured", 'ovaem-events-manager'),
			 "class" => "",
			 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
			 "icon" => "icon-qk",   
			 "params" => array(
				
				array(
			       "type" => "textfield",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Slug of Speaker",'ovaem-events-manager'),
			       "description"=> esc_html__("Insert SLUGS or EMPTY. For example: speaker1, speaker2, speaker3",'ovaem-events-manager'),
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
			       		esc_html__("Order field in event attribute", "ovaem-events-manager" )	=> $speaker_order,
			       		esc_html__("Created Date", "ovaem-events-manager" )	=> $date_created,
			       	),
			       "default" => $speaker_order
			       
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
			       "heading" => esc_html__("Make Link in title",'ovaem-events-manager'),
			       "param_name" => "show_link",
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
			       "heading" => esc_html__("Show Social",'ovaem-events-manager'),
			       "param_name" => "show_social",
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
			       "heading" => esc_html__("Show Job",'ovaem-events-manager'),
			       "param_name" => "show_job",
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
			       "heading" => esc_html__("Style",'ovaem-events-manager'),
			       "param_name" => "style",
			       "value" => array(
			       		esc_html__("Style 1", "ovaem-events-manager" ) => "style1",
			       		esc_html__("Style 2", "ovaem-events-manager" )	=> "style2",
			       		esc_html__("Style 3", "ovaem-events-manager" )	=> "style2 style3",
			       		esc_html__("Style 4", "ovaem-events-manager" )	=> "style4"
			       	),
			       "default" => "style1"
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Display all speaker",'ovaem-events-manager'),
			       "param_name" => "dis_all_speaker",
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
			       "value" => "All Speakers",
			      
			    ),
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Style button read more",'ovaem-events-manager'),
			       "param_name" => "style_button_read_more",
			       "value" => array(
			       		esc_html__("Radius button and arrow", "ovaem-events-manager" ) => "ova-btn-rad-30 ova-btn-arrow",
			       		esc_html__("No Radius and arrow", "ovaem-events-manager" )	=> "hide_arrow"
			       	),
			       "default" => "ova-btn-rad-30 ova-btn-arrow"
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