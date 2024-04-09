<?php if ( !defined( 'ABSPATH' ) ) exit();
get_header( );
$event_id = $_GET['regis_free_event'] ? $_GET['regis_free_event'] : '';
$package_id = $_GET['package_id'] ? $_GET['package_id'] : '';
$post_type = OVAEM_Settings::event_post_type_slug();
$event_obj = get_post($event_id);
$ticket_free_max_number = OVAEM_Settings::ticket_free_max_number();

?>


<div class="ovaem_regsiter_event">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<form id="ova_register_event" method="post" action="<?php echo esc_url( home_url('/') ); ?> " accept-charset="UTF-8" enctype="multipart/form-data">
				<fieldset>		
					<div class="row">


						<div class="col-md-12">
							<h3 class="name_event"><?php esc_html_e( 'Register Event: ', 'ovaem-events-manager' ); ?><?php echo $event_obj->post_title; ?></h3>
						</div>
						
						<div class="col-md-6 ova_field">
							<label><?php esc_html_e( "Name *", 'ovaem-events-manager' ); ?></label>
							<input type="text" name="ovaem_name" class="form-control" required >
						</div>

						<div class="col-md-6 ova_field">
							<label><?php esc_html_e( "Phone *", 'ovaem-events-manager' ); ?></label>
							<input type="tel" name="ovaem_phone" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_phone', 'required' ); ?> />
						</div>

						<div class="row clearfix"></div>

						<div class="col-md-6 ova_field">
							<label><?php esc_html_e( "Email *", 'ovaem-events-manager' ); ?></label>
							<input type="email" name="ovaem_email" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_email', 'required' ); ?> />
						</div>

						<div class="col-md-6 ova_field">
							<label><?php esc_html_e( "Number", 'ovaem-events-manager' ); ?></label>
							<select name="ovaem_number" class="form-control selectpicker ">
								<?php for ($i=1; $i <= intval( $ticket_free_max_number ); $i++) {  ?>
									<option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>	
								<?php } ?>
							</select>
						</div>

						<div class="row clearfix"></div>

						<div class="col-md-6 ova_field">
							<label><?php esc_html_e( "Address", 'ovaem-events-manager' ); ?></label>
							<input type="text" name="ovaem_address" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_address', '' ); ?> />
						</div>

						<div class="col-md-6 ova_field">
							<label><?php esc_html_e( "Company", 'ovaem-events-manager' ); ?></label>
							<input type="text" name="ovaem_company" class="form-control" <?php echo apply_filters( 'ovaem_reg_event_require_company', '' ); ?> />
						</div>
						<div class="row clearfix"></div>

						<div class="col-md-12 ova_field">
							<label><?php esc_html_e( "Additional Info", 'ovaem-events-manager' ); ?></label>
							<textarea name="ovaem_desc" class="form-control" cols="50" rows="10" <?php echo apply_filters( 'ovaem_reg_event_require_desc', '' ); ?> ></textarea>
						</div>
						
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
						
						<?php echo apply_filters( 'em4u_recapcha_register_event', '' ); ?>
						

						<div class="col-md-12 text-center">
							<br>
					        <button class="ova_register_event ova-btn ova-trans" 
							data-id="ova_register_event"
							id="register_free_event_btn">

					        	<?php esc_html_e( "Register Event", 'ovaem-events-manager' ); ?>
					        	
					       	</button>
							
							
						</div>
						
						<input type="hidden" name="event_id" value="<?php echo esc_attr($event_id); ?>" />
						<input type="hidden" name="package_id" value="<?php echo esc_attr($package_id); ?>" />
						<input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
						<input type="hidden" name="checkout_free_event" value="yes" />
						
						<?php wp_nonce_field( 'ova_regis_events_nonce', 'ova_regis_events_nonce' ); ?>

					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<?php get_footer( );
