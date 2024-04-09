<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_search_simple', 'ovaem_search_simple');
function ovaem_search_simple($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
	      'title' => '',
	      'sub_title' => '',
	      'placeholder_label' => '',
	      'background' => '',
	      'background_color_cover' => '',
	      'class'   => '',
	    ), $atts) );

      	$background = wp_get_attachment_url( $background, 'full' ) ? wp_get_attachment_url( $background, 'full' ) : '';

       	$event_post_type_slug = OVAEM_Settings::event_post_type_slug();
       	
        $html = '<div class="ovaem_search_event_simple '.$class.'" style="background: url('.$background.'); "><div class="bg_cover" style="background-color: '.$background_color_cover.'"></div>';
        	
        	$html .= '<div class="container">';
	        	
	        	$html .= $title ? '<h3 class="search_title">'.$title.'</h3>' : '';
	        	$html .= $sub_title ? '<div class="sub_title">'.$sub_title.'</div>' : '';

	        	$html .= '<form action="'.home_url('/').'" method="GET" name="search_event" >';

	        		$html .= '<div class="ovaem_name_event"><input class="form-controll selectpicker" placeholder="'.$placeholder_label.'" name="name_event" value="" /><div class="ovaem_submit"><button type="submit"><i class="icon_search"></i></button></div></div>';
	        		

	        		$html .= '<input type="hidden" name="post_type" value="'.$event_post_type_slug.'">';
	        		$html .= '<input type="hidden" name="search" value="search-event">';
	        		
	        	$html .= '</form>';
	        	
	        $html .= '</div>';

        $html .= '</div>';
	    
	    return $html;

}



if(function_exists('vc_map')){

		vc_map( array(
			 "name" => esc_html__("Search Simple", 'ovaem-events-manager'),
			 "base" => "ovaem_search_simple",
			 "description" => esc_html__("Only display name field in search form", 'ovaem-events-manager'),
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
				       "heading" => esc_html__("Sub title",'ovaem-events-manager'),
				       "param_name" => "sub_title",
				       "value" => ""
				    ),
				    array(
				       "type" => "textfield",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Placeholder label",'ovaem-events-manager'),
				       "param_name" => "placeholder_label",
				       "value" => ""
				    ),
				     array(
				       "type" => "attach_image",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Background",'ovaem-events-manager'),
				       "param_name" => "background",
				       "value" => ""
				    ),
				    array(
				       "type" => "colorpicker",
				       "holder" => "div",
				       "class" => "",
				       "heading" => esc_html__("Background color cover",'ovaem-events-manager'),
				       "param_name" => "background_color_cover",
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