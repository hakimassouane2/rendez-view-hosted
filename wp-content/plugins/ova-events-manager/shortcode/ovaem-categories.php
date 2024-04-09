<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_categories', 'ovaem_categories');
function ovaem_categories($atts, $content = null) {

      	$atts = extract( shortcode_atts(
	    array(
	    	'slug' => '',
			'img' => '',
			'background_color' => '',
			'class'   => '',
	    ), $atts) );

		$html = '';

		$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
		$cat = get_term_by( 'slug', $slug, $slug_taxonomy_name );

		if ( !$cat )  return '';

      

		$img = wp_get_attachment_url( $img, 'full' ) ? wp_get_attachment_url( $img, 'full' ) : '';

		$html .= '<div class="ovaem_categories '.$class.'" style="background: url('.$img.'); ">';
			$html .= '<div class="bg_cover" style="background-color: '.$background_color.'"></div>';
			$html .= '<div class="name"><a href="'.home_url('/').'?'.$slug_taxonomy_name.'='.$cat->slug.'">'.$cat->name.'</a></div>';
		$html .= '</div>';

		return $html;

}



if(function_exists('vc_map')){

	$cats = apply_filters('ovaem_get_categories', 10);
	$cats_arr = array( '' => esc_html__('--- Select Category ---', 'ovaem-events-manager') );
	foreach ($cats as $key => $value) {
		$cats_arr[$value->slug] = $value->name;
	}




	vc_map( array(
		 "name" => esc_html__("Categories", 'ovaem-events-manager'),
		 "base" => "ovaem_categories",
		 "description" => esc_html__("Display thumbnail and category link", 'ovaem-events-manager'),
		 "class" => "",
		 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		 "icon" => "icon-qk",   
		 "params" => array(

		 	
			    
			array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Slug",'ovaem-events-manager'),
		       "param_name" => "slug",
		       "value" => array_flip($cats_arr),
		       "default" => ""
		       
		    ),
		    array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Image",'ovaem-events-manager'),
		       "param_name" => "img",
		       "value" => "",
		       
		    ),
		    array(
		       "type" => "colorpicker",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Background color",'ovaem-events-manager'),
		       "param_name" => "background_color",
		       "value" => "",
		       
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