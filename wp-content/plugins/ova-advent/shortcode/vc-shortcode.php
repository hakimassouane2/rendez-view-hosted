<?php
add_action('init','init_visual_composer_custom');
function init_visual_composer_custom(){
    if(function_exists('vc_map')){

vc_map( array(
	 "name" => esc_html__("Slider", 'adventpro'),
	 "base" => "ova_adevent_main_slider",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "as_parent" => array('only' => 'ova_adevent_main_slider_item', ), 
    "content_element" => true,
    "js_view" => 'VcColumnView',
    "show_settings_on_create" => false,

	 "params" => array(
	 	
	 		
	 		array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Auto slider",'adventpro'),
		       "param_name" => "auto_slider",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Duration of slider(ms). 1000ms = 1s",'adventpro'),
		       "param_name" => "duration",
		       "value"	=> '3000'
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Navigation",'adventpro'),
		       "param_name" => "navigation",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Loop",'adventpro'),
		       "param_name" => "loop",
		       "value" => array(
		       		esc_html__('True', 'adventpro') => "true",
		       		esc_html__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Height desk",'adventpro'),
		       "param_name" => "height_desk",
		       "value" => "680px",
		       "description" => esc_html__('Insert full-height or height (750px)','adventpro')
		    ),
		     array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Height Ipad",'adventpro'),
		       "param_name" => "height_ipad",
		       "value" => "768px",
		       "description" => esc_html__('Insert full-height or height (768px)','adventpro')
		    ),
		      array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Height Mobile",'adventpro'),
		       "param_name" => "height_mobile",
		       "value" => "800px",
		       "description" => esc_html__('Insert full-height or height (800px)','adventpro')
		    ),

		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Padding Top Desktop",'adventpro'),
		       "param_name" => "padding_top_desk",
		       "value" => "230px"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Padding Top Ipad",'adventpro'),
		       "param_name" => "padding_top_ipad",
		       "value" => "230px"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Padding Top Mobile",'adventpro'),
		       "param_name" => "padding_top_mobile",
		       "value" => "230px"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));


vc_map( array(
	 "name" => esc_html__("Slider Item", 'adventpro'),
	 "base" => "ova_adevent_main_slider_item",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "as_child" => array('only' => 'ova_adevent_main_slider'),
     "content_element" => true,
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Image",'adventpro'),
		       "param_name" => "img"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Date",'adventpro'),
		       "param_name" => "date"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Address",'adventpro'),
		       "param_name" => "address"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Sub Title",'adventpro'),
		       "param_name" => "sub_title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Button text",'adventpro'),
		       "param_name" => "button_text"
		    ),
	    	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Button link",'adventpro'),
		       "param_name" => "button_link"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Target Link",'adventpro'),
		       "param_name" => "target_link",
		       "value" => array(
		       		__('Same Window', 'adventpro') => "_self",
		       		__('New Window', 'adventpro') => "_blank",
		       	),
		       "default"	=> "_self"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Display cover background",'adventpro'),
		       "param_name" => "cover_bg",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Show CountDown",'adventpro'),
		       "param_name" => "show_countdown",
		       "value" => array(
		       		__('No', 'adventpro') => "no",
		       		__('Yes', 'adventpro') => "yes",
		       	),
		       "default"	=> "no"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Day",'adventpro'),
		       "description" => esc_html__("Insert Number: 10",'adventpro'),
		       "param_name" => "day"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Month",'adventpro'),
		       "description" => esc_html__("Insert Number: 10",'adventpro'),
		       "param_name" => "month"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Year",'adventpro'),
		       "description" => esc_html__("Insert Number: 2017",'adventpro'),
		       "param_name" => "year"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Hour",'adventpro'),
		       "description" => esc_html__("Insert Number from 0 to 12",'adventpro'),
		       "param_name" => "hour"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Minute",'adventpro'),
		       "description" => esc_html__("Insert Number from 0 to 59",'adventpro'),
		       "param_name" => "minute"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Timezone",'adventpro'),
		       "description" => esc_html__("The timezone for the target times. <br/>
For example:<br/>
If Timezone is UTC-9:00 you have to insert -9 <br/>
If Timezone is UTC-9:30, you have to insert -9*60+30=-570. <br/>
Read about UTC Time: http://en.wikipedia.org/wiki/List_of_UTC_time_offsets",'adventpro'),
		       "param_name" => "timezone",
		       "value" => '0'
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_ova_adevent_main_slider extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ova_adevent_main_slider_item extends WPBakeryShortCode {
    }
}

/* Slider V2 */

vc_map( array(
	 "name" => esc_html__("Slider V2", 'adventpro'),
	 "base" => "ova_adevent_main_slider_two",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "as_parent" => array('only' => 'ova_adevent_main_slider_two_item', ), 
    "content_element" => true,
    "js_view" => 'VcColumnView',
    "show_settings_on_create" => false,

	 "params" => array(
	 	
	 		
	 		array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Auto slider",'adventpro'),
		       "param_name" => "auto_slider",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Duration of slider(ms). 1000ms = 1s",'adventpro'),
		       "param_name" => "duration",
		       "value"	=> '3000'
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Navigation",'adventpro'),
		       "param_name" => "navigation",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Loop",'adventpro'),
		       "param_name" => "loop",
		       "value" => array(
		       		esc_html__('True', 'adventpro') => "true",
		       		esc_html__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Height desk",'adventpro'),
		       "param_name" => "height_desk",
		       "value" => "680px",
		       "description" => esc_html__('Insert full-height or height (750px)','adventpro')
		    ),
		     array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Height Ipad",'adventpro'),
		       "param_name" => "height_ipad",
		       "value" => "768px",
		       "description" => esc_html__('Insert full-height or height (768px)','adventpro')
		    ),
		      array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Height Mobile",'adventpro'),
		       "param_name" => "height_mobile",
		       "value" => "800px",
		       "description" => esc_html__('Insert full-height or height (800px)','adventpro')
		    ),

		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Padding Top Desktop",'adventpro'),
		       "param_name" => "padding_top_desk",
		       "value" => "230px"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Padding Top Ipad",'adventpro'),
		       "param_name" => "padding_top_ipad",
		       "value" => "230px"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Padding Top Mobile",'adventpro'),
		       "param_name" => "padding_top_mobile",
		       "value" => "230px"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));


vc_map( array(
	 "name" => esc_html__("Slider Item", 'adventpro'),
	 "base" => "ova_adevent_main_slider_two_item",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "as_child" => array('only' => 'ova_adevent_main_slider_two'),
     "content_element" => true,
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Image",'adventpro'),
		       "param_name" => "img"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Date",'adventpro'),
		       "param_name" => "date"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Hour",'adventpro'),
		       "param_name" => "hour"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Address",'adventpro'),
		       "param_name" => "address"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Sub Title",'adventpro'),
		       "param_name" => "sub_title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Button text",'adventpro'),
		       "param_name" => "button_text"
		    ),
	    	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Button link",'adventpro'),
		       "param_name" => "button_link"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Display cover background",'adventpro'),
		       "param_name" => "cover_bg",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_ova_adevent_main_slider_two extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ova_adevent_main_slider_two_item extends WPBakeryShortCode {
    }
}

/* /Slider V2 */


/* Banner One */

vc_map( array(
	 "name" => esc_html__("Banner One", 'adventpro'),
	 "base" => "ova_adevent_banner_one",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Icon",'adventpro'),
		       "description" => esc_html__("Insert Font icon: Fontawesome, Flaticon, Eleganticon. You can read in the documentation",'adventpro'),
		       "param_name" => "icon"
		    ),
		    array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Image",'adventpro'),
		       "param_name" => "img"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Date and Address",'adventpro'),
		       "param_name" => "date"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textarea",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Description",'adventpro'),
		       "param_name" => "desc"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));

/* /Banner one */

vc_map( array(
	 "name" => esc_html__("Service", 'adventpro'),
	 "base" => "ova_adevent_service",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Icon",'adventpro'),
		       "description" => esc_html__("Insert Font icon: Fontawesome, Flaticon, Eleganticon. You can read in the documentation",'adventpro'),
		       "param_name" => "icon"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Description",'adventpro'),
		       "param_name" => "desc"
		    ),
		    
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Read more icon.",'adventpro'),
		       "description" => esc_html__("Insert Font icon: Fontawesome, Flaticon, Eleganticon. You can read in the documentation",'adventpro'),
		       "param_name" => "read_more_icon",
		       "value" => "arrow_right"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Read more text",'adventpro'),
		       "description" => esc_html__("You have to empty 'Read more icon' field to display this text",'adventpro'),
		       "param_name" => "read_more_text"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Read more link",'adventpro'),
		       "param_name" => "read_more_link"
		    ),
		    
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Target",'adventpro'),
		       "param_name" => "target",
		       "value" => array(
		       		__('Self', 'adventpro') => "_self",
		       		__('Blank', 'adventpro') => "_blank",
		       	),
		       "default"	=> "_self"
		    ),

		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Style",'adventpro'),
		       "param_name" => "style",
		       "value" => array(
		       		__('Style 1', 'adventpro') => "style1",
		       		__('Style 2', 'adventpro') => "style2",
		       	),
		       "default"	=> "style1"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));




vc_map( array(
	 "name" => esc_html__("Heading", 'adventpro'),
	 "base" => "ova_adevent_heading",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Sub title",'adventpro'),
		       "param_name" => "sub_title"
		    ),
		    
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));


vc_map( array(
	 "name" => esc_html__("Heading V2", 'adventpro'),
	 "base" => "ova_adevent_heading_v2",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Sub title",'adventpro'),
		       "param_name" => "sub_title"
		    ),
		    array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Image",'adventpro'),
		       "param_name" => "img"
		    ),
		    
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));


vc_map( array(
	 "name" => esc_html__("Heading V3", 'adventpro'),
	 "base" => "ova_adevent_heading_v3",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Sub title",'adventpro'),
		       "param_name" => "sub_title"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));



vc_map( array(
	 "name" => esc_html__("Heading V4", 'adventpro'),
	 "base" => "ova_adevent_heading_v4",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title",
		       "description"=> esc_html__("For example: About {this event}",'adventpro'),
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Sub title",'adventpro'),
		       "param_name" => "sub_title"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Show Line",'adventpro'),
		       "param_name" => "show_line",
		       "value" => array(
		       		__('Yes', 'adventpro') => "true",
		       		__('No', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert text-center to dislay center",'adventpro')
		    )

	 
)));

vc_map( array(
	 "name" => esc_html__("Box", 'adventpro'),
	 "base" => "ova_adevent_box",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Number",'adventpro'),
		       "param_name" => "number"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textarea",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Description",'adventpro'),
		       "param_name" => "desc"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Link",'adventpro'),
		       "param_name" => "btn_link"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Style",'adventpro'),
		       "param_name" => "style",
		       "value" => array(
		       		__('Style 1', 'adventpro') => "style1",
		       		__('Style 2', 'adventpro') => "style2",
		       	),
		       "default"	=> "style1"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));






$args = array(
  'orderby' => 'name',
  'order' => 'ASC'
  );

$categories=get_categories($args);
$cate_array = array();
$arrayCateAll = array('All categories ' => 'all' );
if ($categories) {
	foreach ( $categories as $cate ) {
		$cate_array[$cate->cat_name] = $cate->slug;
	}
} else {
	$cate_array["No content Category found"] = 0;
}



vc_map( array(
	 "name" => __("Blog", 'adventpro'),
	 "base" => "ova_adevent_blog",
	 "class" => "",
	 "category" => __("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",   
	 "params" => array(

	 	array(
	       "type" => "dropdown",
	       "holder" => "div",
	       "class" => "",
	       "heading" => __("Category",'adventpro'),
	       "param_name" => "category",
	       "value" => array_merge($arrayCateAll,$cate_array),
	       "description" => __("Choose a Content Category from the drop down list.", 'adventpro')
	   ),
	    array(
    	   "type" => "textfield",
	       "holder" => "div",
	       "class" => "",
	       "heading" => __("Total item show",'adventpro'),
	       "param_name" => "total_count",
	       "value" => "20",
	       "description" => __('For example: 10','adventpro')
	    ),
	    array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => __("Show image thumbnail",'adventpro'),
            "param_name" => "show_thumb",
            "value" => array(
                  __('true', 'adventpro') => 'true',
                  __('false', 'adventpro') => 'false',
            ),
            "default"  => 'true'
        ),
        array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => __("Show title",'adventpro'),
            "param_name" => "show_title",
            "value" => array(
                  __('true', 'adventpro') => 'true',
                  __('false', 'adventpro') => 'false',
            ),
            "default"  => 'true'
        ),
        array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => __("Show description",'adventpro'),
            "param_name" => "show_desc",
            "value" => array(
                  __('true', 'adventpro') => 'true',
                  __('false', 'adventpro') => 'false',
            ),
            "default"  => 'true'
        ),
        array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => __("Show Comment",'adventpro'),
            "param_name" => "show_comment",
            "value" => array(
                  __('true', 'adventpro') => 'true',
                  __('false', 'adventpro') => 'false',
            ),
            "default"  => 'true'
        ),
        array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => __("Show Date",'adventpro'),
            "param_name" => "show_date",
            "value" => array(
                  __('true', 'adventpro') => 'true',
                  __('false', 'adventpro') => 'false',
            ),
            "default"  => 'true'
        ),
        array(
            "type" => "dropdown",
            "holder" => "div",
            "class" => "",
            "heading" => __("Show Readmore",'adventpro'),
            "param_name" => "show_readmore",
            "value" => array(
                  __('true', 'adventpro') => 'true',
                  __('false', 'adventpro') => 'false',
            ),
            "default"  => 'true'
        ),
        array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Auto slider",'adventpro'),
		       "param_name" => "auto_slider",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Duration of slider(ms). 1000ms = 1s",'adventpro'),
		       "param_name" => "duration",
		       "value"	=> '3000'
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Dots",'adventpro'),
		       "param_name" => "dots",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Loop",'adventpro'),
		       "param_name" => "loop",
		       "value" => array(
		       		esc_html__('True', 'adventpro') => "true",
		       		esc_html__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => __("Class",'adventpro'),
            "description" => __("You can use bg_grey for new style",'adventpro'),
            "param_name" => "class",
            "value" => ""
        )
)));




vc_map( array(
	 "name" => esc_html__("Map 1", 'adventpro'),
	 "base" => "ova_advent_map1",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Image",'adventpro'),
		       "param_name" => "img"
		    ),
		    array(
		       "type" => "textarea_html",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Info",'adventpro'),
		       "description" => esc_html__( "Insert shortcode: [ova_advent_info icon=\"arrow_right\" title=\"name1\" /] ", 'adventpro' ),
		       "param_name" => "content"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Style",'adventpro'),
		       "param_name" => "style",
		       "value" => array(
		       		esc_html__('Style 1', 'adventpro') => "style1",
		       		esc_html__('Style 2', 'adventpro') => "style2",
		       	),
		       "default"	=> "style1"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));


vc_map( array(
	 "name" => esc_html__("Skill", 'adventpro'),
	 "base" => "ova_advent_skill",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Icon",'adventpro'),
		       "param_name" => "icon"
		    ),
		   	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Name",'adventpro'),
		       "param_name" => "name"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Number",'adventpro'),
		       "param_name" => "number"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));



vc_map( array(
	 "name" => esc_html__("Button", 'adventpro'),
	 "base" => "ova_advent_button",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Name",'adventpro'),
		       "param_name" => "name"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Link",'adventpro'),
		       "param_name" => "link"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Target",'adventpro'),
		       "param_name" => "target",
		       "value" =>  array(
			       	esc_html__( 'Same Window', 'adventpro' ) => '_self',
			       	esc_html__( 'New Window', 'adventpro' ) => '_blank',
		       	),
		       "default" => '_self'
		    ),
		   	array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Size",'adventpro'),
		       "param_name" => "size",
		       "value" =>  array(
			       	esc_html__( 'Large', 'adventpro' ) => 'ova-btn-large',
			       	esc_html__( 'Medium', 'adventpro' ) => 'ova-btn-medium',
			       	esc_html__( 'Small', 'adventpro' ) => 'ova-btn-small',
		       	),
		       "default" => 'ova-btn-large'
		    ),
		   	array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Radius",'adventpro'),
		       "param_name" => "radius",
		       "value" =>  array(
			       	esc_html__( 'Border Radius 4', 'adventpro' ) => 'ova-btn-rad-4',
			       	esc_html__( 'Border Radius 30', 'adventpro' ) => 'ova-btn-rad-30',
			       	esc_html__( 'Border Radius 0', 'adventpro' ) => 'ova-btn-rad-0'
		       	),
		       "default" => 'ova-btn-rad-4'
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Background main color",'adventpro'),
		       "param_name" => "bg_main_color",
		       "value" =>  array(
		       		esc_html__( 'Transparent', 'adventpro' ) => 'ova-btn-transparent',
			       	esc_html__( 'Main Color', 'adventpro' ) => 'ova-btn-main-color',
			       	esc_html__( 'Second Color', 'adventpro' ) => 'ova-btn-second-color',
			       	
		       	),
		       "default" => 'ova-btn-transparent'
		    ),
		   
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));



vc_map( array(
	 "name" => esc_html__("Intro", 'adventpro'),
	 "base" => "ova_advent_join_event",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textarea",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Description",'adventpro'),
		       "param_name" => "desc"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));



vc_map( array(
	 "name" => esc_html__("Info", 'adventpro'),
	 "base" => "ova_advent_info_event",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Icon",'adventpro'),
		       "param_name" => "icon"
		    ),
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textarea",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Description",'adventpro'),
		       "param_name" => "desc"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right. Insert white_color to text is white",'adventpro')
		    )

	 
)));


vc_map( array(
	 "name" => esc_html__("About", 'adventpro'),
	 "base" => "ova_advent_about",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
	 	
	 		
		   
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Icon image beside title",'adventpro'),
		       "param_name" => "icon_img"
		    ),
		    
		    array(
		       "type" => "textarea",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Description",'adventpro'),
		       "param_name" => "desc"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Button text",'adventpro'),
		       "param_name" => "btn_text"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Button link",'adventpro'),
		       "param_name" => "btn_link"
		    ),
		    
		    
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert no_border to dont display border-right",'adventpro')
		    )

	 
)));




vc_map( array(
	 "name" => esc_html__("Testimonial", 'adventpro'),
	 "base" => "ova_advent_testimonial",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "as_parent" => array('only' => 'ova_advent_testimonial_item'), 
    "content_element" => true,
    "js_view" => 'VcColumnView',
    "show_settings_on_create" => false,

	 "params" => array(
	 	
	 		
	 		array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Count item each slide",'adventpro'),
		       "param_name" => "count",
		       "value" => "2",
		      
		    ),
	 		array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Auto slider",'adventpro'),
		       "param_name" => "auto_slider",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Duration of slider(ms). 1000ms = 1s",'adventpro'),
		       "param_name" => "duration",
		       "value"	=> '3000'
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Pagination",'adventpro'),
		       "param_name" => "pagination",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Loop",'adventpro'),
		       "param_name" => "loop",
		       "value" => array(
		       		esc_html__('True', 'adventpro') => "true",
		       		esc_html__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));


vc_map( array(
	 "name" => esc_html__("Testimonial Item", 'adventpro'),
	 "base" => "ova_advent_testimonial_item",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "as_child" => array('only' => 'ova_advent_testimonial'),
     "content_element" => true,
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Image",'adventpro'),
		       "param_name" => "image"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("name",'adventpro'),
		       "param_name" => "name"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("job",'adventpro'),
		       "param_name" => "job"
		    ),
		    array(
		       "type" => "textarea",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Description",'adventpro'),
		       "param_name" => "desc"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Show quota",'adventpro'),
		       "param_name" => "show_quota",
		       "value" => array(
		       		esc_html__('True', 'adventpro') => "true",
		       		esc_html__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_ova_advent_testimonial extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ova_advent_testimonial_item extends WPBakeryShortCode {
    }
}



vc_map( array(
	 "name" => esc_html__("Gallery v1", 'adventpro'),
	 "base" => "ova_advent_gallery_v1",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "as_parent" => array('only' => 'ova_advent_gallery_v1_item'), 
    "content_element" => true,
    "js_view" => 'VcColumnView',
    "show_settings_on_create" => false,

	 "params" => array(
	 	
	 		
	 		array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Count item each slide",'adventpro'),
		       "param_name" => "count",
		       "value" => "2",
		      
		    ),
	 		array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Auto slider",'adventpro'),
		       "param_name" => "auto_slider",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Duration of slider(ms). 1000ms = 1s",'adventpro'),
		       "param_name" => "duration",
		       "value"	=> '3000'
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Pagination",'adventpro'),
		       "param_name" => "pagination",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Navigation",'adventpro'),
		       "param_name" => "navigation",
		       "value" => array(
		       		__('True', 'adventpro') => "true",
		       		__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		    array(
		       "type" => "dropdown",
		       "holder" => "div",
		       "class" => "",
		       "heading" => __("Loop",'adventpro'),
		       "param_name" => "loop",
		       "value" => array(
		       		esc_html__('True', 'adventpro') => "true",
		       		esc_html__('False', 'adventpro') => "false",
		       	),
		       "default"	=> "true"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));


vc_map( array(
	 "name" => esc_html__("Gallery V1 Item", 'adventpro'),
	 "base" => "ova_advent_gallery_v1_item",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "as_child" => array('only' => 'ova_advent_gallery_v1'),
     "content_element" => true,
	 "params" => array(
	 	
	 		
		    
			array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Image",'adventpro'),
		       "param_name" => "image"
		    ),
		    array(
		       "type" => "attach_image",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Thumbnail",'adventpro'),
		       "param_name" => "thumbnail"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Date",'adventpro'),
		       "param_name" => "date"
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_ova_advent_gallery_v1 extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_ova_advent_gallery_v1_item extends WPBakeryShortCode {
    }
}


vc_map( array(
	 "name" => esc_html__("Contact Info", 'adventpro'),
	 "base" => "ova_advent_contact_info",
	 "class" => "",
	 "category" => esc_html__("ADVENTPRO", 'adventpro'),
	 "icon" => "icon-qk",
	 "params" => array(
		    
			array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Icon",'adventpro'),
		       "param_name" => "icon",
		       "description" => esc_html__( "You can find here: https://www.elegantthemes.com/blog/resources/elegant-icon-font", "adventpro" )
		    ),
		    array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("title",'adventpro'),
		       "param_name" => "title"
		    ),
		    array(
		       "type" => "textarea",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Description",'adventpro'),
		       "param_name" => "desc",
		       "description"=> esc_html__("You can insert like {{ Line 1}} {{ Line 2}}",'adventpro'),
		    ),
		  	array(
		       "type" => "textfield",
		       "holder" => "div",
		       "class" => "",
		       "heading" => esc_html__("Class",'adventpro'),
		       "param_name" => "class",
		       "value" => "",
		       "description" => esc_html__("Insert class to use for your style",'adventpro')
		    )

	 
)));



/* Gmap */

vc_map( array(
	"name" => __("Google Map", 'adventpro'),
	"base" => "ova_advent_map",
	"class" => "",
	"category" => __("ADVENTPRO", 'adventpro'),
	"icon" => "icon-qk",
	"params" => array(
		array(
		   "type" => "textfield",
		   "holder" => "div",
		   "class" => "",
		   "heading" => __("Id for map section",'adventpro'),
		   "param_name" => "idmap",
		   "value" => "map-canvas",
		   "description" => 'Insert id to display map. For example: map-canvas'
		),
		array(
		   "type" => "textarea_raw_html",
		   "holder" => "div",
		   "class" => "",
		   "heading" => __("location",'adventpro'),
		   "param_name" => "location",
		   "value" => "",
		   "description" => 'Insert latitude parameter for google map. <br/>For example: 51.503454,-0.119562 | 51.499633,-0.124755'
                        
		),
		array(
		   "type" => "textarea_raw_html",
		   "holder" => "div",
		   "class" => "",
		   "heading" => __("title",'adventpro'),
		   "param_name" => "title",
		   "value" => "",
		   "description" => 'Insert title parameter for google map. <br/>For example: Hotel 1 | Hotel 2'
		),
		array(
		   "type" => "textfield",
		   "holder" => "div",
		   "class" => "",
		   "heading" => __("Zoom",'adventpro'),
		   "param_name" => "zoom",
		   "value" => "15",
		   "description" => 'Insert zoom parameter for google map. Default 12'
		),
		array(
		   "type" => "attach_image",
		   "holder" => "div",
		   "class" => "",
		   "heading" => __("Icon for marker",'adventpro'),
		   "param_name" => "icon",
		   "value" => ""
		),
		array(
		   "type" => "textfield",
		   "holder" => "div",
		   "class" => "",
		   "heading" => __("Class",'adventpro'),
		   "param_name" => "class",
		   "value" => "",
		   "description" => 'Insert class'
		),

)));
/* /map */





}} /* /if //function */
?>