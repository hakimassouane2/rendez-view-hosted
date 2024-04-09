<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_check_ticket', 'ovaem_check_ticket');
function ovaem_check_ticket($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
	      'class'   => '',
	    ), $atts) );

       
	$html = '<form action="'.home_url('/').'" method="get" class="'.$class.'">';
		$html .= '<label>'.esc_html__( 'Enter QR Code: ', 'ovaem-events-manager' ).'<input name="qrcode" type="text" value="" /></label>';
		$html .= '<button>'.esc_html__( 'Check', 'ovaem-events-manager' ).'</button>';
	$html .= '</form>';
	return $html;
}


if(function_exists('vc_map')){
	

		vc_map( array(
			 "name" => esc_html__("Check Ticket", 'ovaem-events-manager'),
			 "base" => "ovaem_check_ticket",
			 "class" => "",
			 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
			 "icon" => "icon-qk",   
			  "params" => array(
			 	
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



