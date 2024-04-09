<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_frontend_submit_event', 'ovaem_frontend_submit_event');
function ovaem_frontend_submit_event($atts, $content = null) {
	if( !is_user_logged_in() ){
		ob_start(); ?>
			<div class="submit_event_login">
				<?php esc_html_e('Please login to submit event', 'ovaem-events-manager'); ?>: 
				<a href="<?php echo wp_login_url(); ?>" title="Login"><?php esc_html_e( 'Sing In', 'ovaem-events-manager' ) ?></a>
			</div>
		<?php return ob_get_clean();	
	}else{
		ob_start();
	    echo do_action( 'ovaem_frontend_submit' );
	    return ob_get_clean();	
	}
	
}



if(function_exists('vc_map')){

	


	vc_map( array(
		 "name" => esc_html__("ovaem_frontend_submit_event", 'ovaem-events-manager'),
		 "base" => "ovaem_frontend_submit_event",
		 "class" => "",
		 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		 "icon" => "icon-qk",   
		 "params" => array(
		 
	)));

}