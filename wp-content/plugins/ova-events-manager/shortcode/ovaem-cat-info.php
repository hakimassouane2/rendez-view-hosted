<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_cat_info', 'ovaem_cat_info');
function ovaem_cat_info($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
	    	'icon'	=> '',
	    	'cat'	=> '',
	    	'class'   => '',
	    ), $atts) );

    	$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
   		$cat = get_term_by( 'slug', $cat, $slug_taxonomy_name );
   		

   		if( !$cat ) return '';

		$archives_event_show_past = OVAEM_Settings::archives_event_show_past();
   			
   		if( $archives_event_show_past == 'true' ){
       		$count = $cat->count;
		}else{
			$count = apply_filters( 'ovaem_get_count_e_cat', $cat, 'false' );
		}

   		
   		$html = '<a href="'.home_url('/').'?'.$slug_taxonomy_name.'='.$cat->slug.'" class="cat_info '.$class.'">';
	    	$html .= '<i class="'.$icon.'"></i>';
	       $html .= '<h2 class="name">'.$cat->name.'</h2>';
	       $html .= '<span class="count">'.$count.'</span>';
	    $html .= '</a>';
    
	
	return $html;    

}



if(function_exists('vc_map')){

	$cats = apply_filters('ovaem_get_categories', 10);
	$cats_arr = array( '' => esc_html__('--- Select Category ---', 'ovaem-events-manager') );
	foreach ($cats as $key => $value) {
		$cats_arr[$value->slug] = $value->name;
	}

	vc_map( array(
		 "name" => esc_html__("Category Info", 'ovaem-events-manager'),
		 "base" => "ovaem_cat_info",
		 "class" => "",
		 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		 "icon" => "icon-qk",   
		  "params" => array(

		  	array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Choose Category",'ovaem-events-manager'),
		       "param_name" => "cat",
		       "value" => array_flip($cats_arr),
		       "default" => ""
		       
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Insert Icon Class",'ovaem-events-manager'),
		       "param_name" => "icon"
		       
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