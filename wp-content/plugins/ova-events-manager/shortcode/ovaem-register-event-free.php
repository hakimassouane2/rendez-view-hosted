<?php if ( !defined( 'ABSPATH' ) ) exit();


add_shortcode('ovaem_register_event_free', 'ovaem_register_event_free');
function ovaem_register_event_free($atts, $content = null) {

	$atts = extract( shortcode_atts(
		array(
			'event_id' => '',
			'package_id' => '',
			'style' => 'white',
			'show_title' => "true",
			'show_name' => "true",
			'show_phone' => "true",
			'show_ticket' => "true",
			'show_address' => "true",
			'show_company' => "true",
			'show_desc' => "false",
			'class'   => '',
		), $atts) );


	$ticket_free_max_number = OVAEM_Settings::ticket_free_max_number();
	$event_post_type_slug = OVAEM_Settings::event_post_type_slug();
	ob_start();
	?>

	<form id="ova_register_event" method="post" action="<?php echo esc_url( home_url('/') ); ?> " class="<?php echo $class.' '.$style; ?> ovaem_register_free_event" enctype='multipart/form-data'>
		<fieldset>		
			<div class="row">

				<?php if( $show_title == 'true' ){ ?>
					<div class="col-md-12">
						<h3 class="name_event"><?php esc_html_e( 'Register Event Free', 'ovaem-events-manager' ); ?> </h3>
					</div>
				<?php } ?>


				<?php if( $show_name == 'true' ){  ?>	
					<div class="col-md-12 ova_field">
						<input type="text" placeholder="<?php esc_html_e('Name *', 'ovaem-events-manager'); ?>" name="ovaem_name" class="form-control" required >
					</div>
				<?php } ?>

				<?php if( $show_phone == 'true' ){  ?>	
					<div class="col-md-12 ova_field">
						<input type="tel" placeholder="<?php esc_html_e('Phone *', 'ovaem-events-manager'); ?>" name="ovaem_phone" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_phone', 'required' ); ?> />
					</div>
				<?php } ?>

				<div class="col-md-12 ova_field">
					<input type="email" placeholder="<?php esc_html_e('Email *', 'ovaem-events-manager'); ?>" name="ovaem_email" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_email', 'required' ); ?>/>
				</div>


				<?php if( $show_ticket == 'true' ){  ?>
					<div class="col-md-12 ova_field">
						<select name="ovaem_number" class="form-control selectpicker " required>
							<option value=""><?php esc_html_e('Ticket Number *', 'ovaem-events-manager'); ?></option>
							<?php for ($i=1; $i <= intval( $ticket_free_max_number ); $i++) { ?>
								<option value="<?php echo esc_attr($i); ?>">
									<?php echo esc_html($i); ?>
								</option>
							<?php } ?>
						</select>
					</div>
				<?php } ?>


				<?php if( $show_address == 'true' ){  ?>
					<div class="col-md-12 ova_field">
						<input type="text" placeholder="<?php esc_html_e('Address', 'ovaem-events-manager'); ?>" name="ovaem_address" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_address', '' ); ?> />
					</div>
				<?php } ?>


				<?php if( $show_company == 'true' ){  ?>
					<div class="col-md-12 ova_field">
						<input type="text"  placeholder="<?php esc_html_e('Company', 'ovaem-events-manager'); ?> " name="ovaem_company" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_company', '' ); ?>  />
					</div>
				<?php } ?>

				<?php if( $show_desc == 'true' ){ ?>
					<div class="col-md-12 ova_field">
						<textarea placeholder="<?php esc_html_e('Additional Info', 'ovaem-events-manager'); ?> " name="ovaem_desc" class="form-control" cols="10" rows="5" <?php echo apply_filters( 'ovaem_reg_event_require_desc', '' ); ?> ></textarea>
					</div>
				<?php } ?>
				<!-- Custom Field -->
				<?php do_action( 'ovaem_before_register_event_button' ); ?>

				<!-- terms and conditions -->
				<?php if (OVAEM_Settings::terms_conditions_page() != '') { ?>
					<div class="col-md-12 ova_field terms_conditions">

						<input type="checkbox" class="input-checkbox" name="ovaem_terms" id="terms" required>
						<span class="terms-and-conditions-checkbox-text">
							<?php esc_html_e( 'I have read and agree to the website', 'ovaem-events-manager' ); ?>
							<a href="<?php echo esc_attr(OVAEM_Settings::terms_conditions_page()); ?>" class="terms-and-conditions-link" target="_blank"><?php esc_html_e( 'terms and conditions', 'ovaem-events-manager' ); ?></a>
						</span>
					</div>
				<?php } ?>
				<!-- Recaptcha -->
				<?php echo apply_filters( 'em4u_recapcha_register_event_free', '' ); ?>

				<div class="col-md-12 text-center">
					<br>
					<button 
					id="register_free_event_btn"
					type="submit" 
					class="ova-btn ova-btn-rad-5 ova-btn-white ova-btn-main-color" 
					data-id="ova_register_event">
						<?php esc_html_e( "Register Event Free", 'ovaem-events-manager' ); ?>
					</button>
				</div>

				<input type="hidden" name="event_id" value="<?php echo esc_attr( $event_id ); ?>" />
				<input type="hidden" name="package_id" value="<?php echo esc_attr( trim( $package_id ) ); ?>" />

				<input type="hidden" name="post_type" value="<?php echo esc_attr( $event_post_type_slug ); ?>" />
				<input type="hidden" name="checkout_free_event" value="yes" />

				<?php wp_nonce_field( 'ova_regis_events_nonce', 'ova_regis_events_nonce' ); ?>

			</div>
		</fieldset>
	</form>

	<?php 
	wp_reset_postdata();
	return ob_get_clean();

}



if(function_exists('vc_map')){
	
	$events_arr = array( ''=> esc_html__('-- Select Event --', 'ovaem-events-manager') );

	

	$events =  OVAEM_Get_Data::ovaem_get_all_events( 'ASC', -1 );
	foreach ($events as $key => $id) {

		$post = get_post($id);
		$slug = $post->post_name;
		
		$events_arr[$id] = get_the_title( $id );
	}


	vc_map( array(
		"name" => esc_html__("Register Event Free Form", 'ovaem-events-manager'),
		"base" => "ovaem_register_event_free",
		"description" => esc_html__("Display Register Form", 'ovaem-events-manager'),
		"class" => "",
		"category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		"icon" => "icon-qk",   
		"params" => array(


			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Event ID",'ovaem-events-manager'),
				"param_name" => "event_id",
				"value" => array_flip($events_arr),

			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Package ID of ticket",'ovaem-events-manager'),
				"param_name" => "package_id"
			),

			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Style",'ovaem-events-manager'),
				"param_name" => "style",
				"value"	=> array(
					"white" => "white",
					"dark" => "dark"
				),
				"default" => "white"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show title form",'ovaem-events-manager'),
				"param_name" => "show_title",
				"value"	=> array(
					"true" => "true",
					"false" => "false"
				),
				"default" => "true"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show name",'ovaem-events-manager'),
				"param_name" => "show_name",
				"value"	=> array(
					"true" => "true",
					"false" => "false"
				),
				"default" => "true"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show phone",'ovaem-events-manager'),
				"param_name" => "show_phone",
				"value"	=> array(
					"true" => "true",
					"false" => "false"
				),
				"default" => "true"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show ticket",'ovaem-events-manager'),
				"param_name" => "show_ticket",
				"value"	=> array(
					"true" => "true",
					"false" => "false"
				),
				"default" => "true"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show address",'ovaem-events-manager'),
				"param_name" => "show_address",
				"value"	=> array(
					"true" => "true",
					"false" => "false"
				),
				"default" => "true"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show company",'ovaem-events-manager'),
				"param_name" => "show_company",
				"value"	=> array(
					"true" => "true",
					"false" => "false"
				),
				"default" => "true"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Description",'ovaem-events-manager'),
				"param_name" => "show_desc",
				"value"	=> array(
					"false" => "false",
					"true" => "true"
				),
				"default" => "false"
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