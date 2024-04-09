<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_event_countdownt', 'ovaem_event_countdownt');
function ovaem_event_countdownt($atts, $content = null) {

	wp_enqueue_script('jquery-countdown', EM4U_URI.'/assets/plugins/countdown/jquery.plugin.min.js', array('jquery'),null,true);    
	wp_enqueue_script('countdown', EM4U_URI.'/assets/plugins/countdown/jquery.countdown.min.js', array('jquery'),null,true);
	
	if ( function_exists('pll_current_language') ) {
		$current_lang = pll_current_language();
		$countdown_lang = 'jquery.countdown-'.$current_lang.'.js';
		wp_enqueue_script('countdown-language', EM4U_URI.'/assets/plugins/countdown/'.$countdown_lang, array('jquery'),null,true);
	} else {
		$countdown_lang = get_theme_mod( 'countdown_lang', '' );
		if( $countdown_lang != '' && $countdown_lang != 'lang' ){
			wp_enqueue_script('countdown-language', EM4U_URI.'/assets/plugins/countdown/'.$countdown_lang, array('jquery'),null,true);
		}
	}

	$atts = extract( shortcode_atts(
		array(
			'event_slug' => '',
			'timezone' => '0',
			'class'   => '',
		), $atts) );

	$html = '';
	$day = $month = $year = $hour = $minute = 0;
	$prefix = OVAEM_Settings::$prefix;
	

	$event = apply_filters('ovaem_event', $event_slug);


	if( $event->have_posts() ): while( $event->have_posts() ):  $event->the_post();

		$timezone_string = get_option('timezone_string') ;
		$slide_start_time = get_post_meta( get_the_id() , $prefix.'_date_start_time', true ) ? get_post_meta( get_the_id(), $prefix.'_date_start_time', true ) : '';
		if( $slide_start_time ){
			$day = date_i18n( 'd', $slide_start_time );
			$month = date_i18n( 'm', $slide_start_time );
			$year = date_i18n( 'Y', $slide_start_time );
			$hour = date_i18n( 'H', $slide_start_time );
			$minute = date_i18n( 'i', $slide_start_time );
		}
		
		$html .= '<div class="ova_event_countdown"><div class="ova_countdown_slideshow  '.$class.'"><div class="ova_countdown_event" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-timezone_string="'.$timezone_string.'" data-hour="'.$hour.'" data-minute="'.$minute.'" data-timezone="'.$timezone.'"></div></div></div>';
		
	endwhile;endif;wp_reset_postdata();

	return $html;
}


if(function_exists('vc_map')){
	
	$events_arr = array( ''=> esc_html__('-- Select Event --', 'ovaem-events-manager') );
	$events =  OVAEM_Get_Data::ovaem_get_all_events( 'ASC', -1 );
	foreach ($events as $key => $id) {

		$post = get_post($id);
		$slug = $post->post_name;

		$events_arr[$slug] = get_the_title( $id );
	}

	vc_map( array(
		"name" => esc_html__("Event Countdown", 'ovaem-events-manager'),
		"base" => "ovaem_event_countdownt",
		"class" => "",
		"category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		"icon" => "icon-qk",   
		"params" => array(
			
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Event Slug",'ovaem-events-manager'),
				"param_name" => "event_slug",
				"value" => array_flip($events_arr),
				
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Timezone",'ovaem-events-manager'),
				"description" => esc_html__("The timezone for the target times. <br/>
					For example:<br/>
					If Timezone is UTC-9:00 you have to insert -9 <br/>
					If Timezone is UTC-9:30, you have to insert -9*60+30=-570. <br/>
					Read about UTC Time: http://en.wikipedia.org/wiki/List_of_UTC_time_offsets",'ovaem-events-manager'),
				"param_name" => "timezone",
				"value" => '0'
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



