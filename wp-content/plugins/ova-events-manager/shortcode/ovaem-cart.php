<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_cart', 'ovaem_cart');
function ovaem_cart($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
	      'class'   => '',
	    ), $atts) );

    

    ob_start();
    
    echo '<div class="'.$class.'">';
      echo ovaem_get_template( 'cart/cart.php' );
    echo '</div>';

    $content = ob_get_contents();
    ob_clean();
	ob_end_flush();
	
	return $content;
}



if(function_exists('vc_map')){

	vc_map( array(
	 "name" => esc_html__("Cart", 'ovaem-events-manager'),
	 "base" => "ovaem_cart",
	 "class" => "",
	 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
	 "icon" => "icon-qk",   
	  "params" => array(
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