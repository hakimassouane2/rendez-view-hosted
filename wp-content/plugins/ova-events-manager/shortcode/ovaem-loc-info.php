<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_loc_info', 'ovaem_loc_info');
function ovaem_loc_info($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
	    	'image'	=> '',
	    	'image_m' => '',
	    	'loc'	=> '',
	    	'class'   => '',
	    ), $atts) );

      	$loc_obj = get_term_by( 'slug', $loc, 'location' );

      	$link = home_url('/').'?location='.$loc_obj->slug;

      	
   		if( OVAEM_Settings::archives_event_show_past() == 'true' ){
       		$count = $loc_obj->count;
       }else{
       	$count = apply_filters( 'ovaem_get_count_e_loc', $loc, 'false' );
       }

      	$image = wp_get_attachment_url( $image, 'full' ) ? wp_get_attachment_url( $image, 'full' ) : '';
      	$image_m = wp_get_attachment_url( $image_m, 'full' ) ? wp_get_attachment_url( $image_m, 'full' ) : '';

      	$html = '<div class="city-girds '.$class.'">';
			$html .= '<div class="city-thumb">
						<img src="'.$image.'" class="visible hidden-xs" alt="'.esc_html__('location','ovaem-events-manager').'">
						<img src="'.$image_m.'" class="hidden visible-xs" alt="'.esc_html__('location','ovaem-events-manager').'">
					</div>';
			
			$html .= '<div class="city-title text-center">
						<h3 class="lp-h3">
							<a href="'.$link.'">'.$loc_obj->name.'</a>
						</h3>
						<label class="lp-listing-quantity">'.$count.' '.esc_html__('Events','ovaem-events-manager').'</label>
					</div>';

			$html .= '<a href="'.$link.'" class="overlay-link"></a>';

		$html .= '</div>';
	
	return $html;    

}



if(function_exists('vc_map')){

	$locs = apply_filters('ovaem_get_locs', 10);

	$loc_arr = array( '' => esc_html__('--- Select Location ---', 'ovaem-events-manager') );
	if( $locs != '' ){
    	foreach ($locs as $key => $value) {
    		$loc_arr[$value->slug] = $value->name;
    	}
	}
	vc_map( array(
		 "name" => esc_html__("Location Info", 'ovaem-events-manager'),
		 "base" => "ovaem_loc_info",
		 "class" => "",
		 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		 "icon" => "icon-qk",   
		  "params" => array(

		  	array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Choose Category",'ovaem-events-manager'),
		       "param_name" => "loc",
		       "value" => array_flip($loc_arr),
		       "default" => ""
		       
		    ),
		  	array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Desktop Image",'ovaem-events-manager'),
		       "param_name" => "image"
		       
		    ),
		    array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Mobile Image",'ovaem-events-manager'),
		       "param_name" => "image_m"
		       
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'ovaem-events-manager'),
		       "param_name" => "class"
		       
		    )
		  )
		 ));

}