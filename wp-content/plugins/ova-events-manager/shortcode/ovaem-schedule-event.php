<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_schedule_event', 'ovaem_schedule_event');
function ovaem_schedule_event($atts, $content = null) {

      $atts = extract( shortcode_atts(
	    array(
			'event_slug' => '',
	      	'class'   => '',
	    ), $atts) );

      	 if( $event_slug != '' ){

      	 	$event = apply_filters( 'ovaem_event', $event_slug );

			if( $event->have_posts() ): while( $event->have_posts() ):  $event->the_post(); 

			ob_start(); ?>

			<div class="ovaem_schedule_single_event ">

				<?php do_action('ovaem_event_schedule'); ?>


			</div>

			<?php endwhile; endif; wp_reset_postdata();  
			return ob_get_clean(); 


      	 }else{
      	 	return '<div class="text-center">'.esc_html__( 'Please choose event to display ticket', 'ovaem-events-manager' ).'</div>';
      	 }

      	
		

			
	    
	    

}



if(function_exists('vc_map')){

	$events_arr = array( '' => esc_html__('-- Select Event --', 'ovaem-events-manager') );

	$events =  OVAEM_Get_Data::ovaem_get_all_events( 'ASC', -1 );
	foreach ($events as $key => $id) {

		$post = get_post($id);
		$slug = $post->post_name;
		
		$events_arr[$slug] = get_the_title( $id );
	}



	vc_map( array(
		 "name" => esc_html__("Schedule Event", 'ovaem-events-manager'),
		 "base" => "ovaem_schedule_event",
		 "class" => "",
		 "category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		 "icon" => "icon-qk",   
		 "description" => esc_html__("Display schedule of an event", 'ovaem-events-manager'),
		 "params" => array(
			    
			  
			array(
			   "type" => "dropdown",
			   "holder" => "div",
			   "class" => "",
			   "heading" => esc_html__("Choose event to display schedule in event",'ovaem-events-manager'),
			   "param_name" => "event_slug",
			   "value" => array_flip($events_arr),
			   "default" => '',
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