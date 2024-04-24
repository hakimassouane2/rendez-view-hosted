<?php if ( !defined( 'ABSPATH' ) ) exit();
//get_header( ); ?>
<div class="container ova-page-section" style="font-family: Poppins, sans-serif">
	<div class="result_ticket">

		<?php // Check Permission 
		$qr = isset( $_REQUEST['qr'] ) ? esc_html( $_REQUEST['qr'] ) : '';
		$qrcode = isset( $_REQUEST['qrcode'] ) ? esc_html( $_REQUEST['qrcode'] ) : '';
		$prefix = OVAEM_Settings::prefix();
		
		if( $qr ){
			$check = apply_filters( 'ovaem_check_ticket', $qr );
			if( $check ){ ?>
				<strong>
					<?php echo esc_html__('Ticket is valid', 'ovaem-events-manager'); ?> <br/>
				</strong>
				<?php if( $check->have_posts() ): while( $check->have_posts() ): $check->the_post() ?>
					<label>
						<?php esc_html_e('Ticket ID', 'ovaem-events-manager'); ?>:
					</label>&nbsp;<?php echo get_the_title(); ?><br/>
					<label>
						<?php esc_html_e('Name', 'ovaem-events-manager'); ?>:
					</label>&nbsp;<?php echo get_post_meta( get_the_id(), $prefix.'_name', true); ?><br/>
					<label>
						<?php esc_html_e('Number Ticket', 'ovaem-events-manager'); ?>:
					</label>&nbsp;<?php echo get_post_meta( get_the_id(), $prefix.'_number' , true); ?><br/>
					<label>
						<?php esc_html_e('Phone', 'ovaem-events-manager'); ?>:
					</label>&nbsp;<?php echo get_post_meta( get_the_id(), $prefix.'_phone', true); ?><br/>
					<label>
						<?php esc_html_e('Email', 'ovaem-events-manager'); ?>:
					</label>&nbsp;<?php echo get_post_meta( get_the_id(), $prefix.'_email', true); ?><br/>
					<label>
						<?php esc_html_e('Address', 'ovaem-events-manager'); ?>:
					</label>&nbsp;<?php echo get_post_meta( get_the_id(), $prefix.'_address', true); ?><br/>
					<label>
						<?php esc_html_e('Description', 'ovaem-events-manager'); ?>:
					</label>&nbsp;<?php echo get_post_meta( get_the_id(), $prefix.'_desc', true); ?><br/>
				<?php endwhile; endif; wp_reset_postdata(); ?>
			<?php } else { ?>
					<?php echo esc_html__('Ticket is invalid', 'ovaem-events-manager'); ?>
			<?php }
		} else {
			$buyer[''] = get_post_meta( get_the_id(), 'ovaem_ticket_code', true );
			$buyer[''] = get_post_meta( get_the_id(), 'ovaem_ticket_event_name', true );
			$buyer[''] = get_post_meta( get_the_id(), 'ovaem_ticket_event_package', true );
			$buyer[''] = get_post_meta( get_the_id(), 'ovaem_ticket_event_start_time', true );
			$buyer[''] = get_post_meta( get_the_id(), 'ovaem_ticket_event_end_time', true );
			$buyer[''] = get_post_meta( get_the_id(), 'ovaem_ticket_event_venue', true );
			$buyer[''] = get_post_meta( get_the_id(), 'ovaem_ticket_event_address', true );
			$buyer[''] = get_post_meta( get_the_id(), 'ovaem_ticket_from_order_id', true );
			$result = apply_filters( 'ovame_check_qrcode_ticket', $qrcode );

			// If valid
			if( $result != '' ) { ?>
				<?php if( get_locale() == 'fr_FR' ) { ?>
					<div style="max-width: 430px;margin: 0 auto;display: flex;align-items: center;flex-direction: column;padding: 2rem 0;">
						<img src="https://rendez-view.com/wp-content/uploads/2024/03/success.png" alt="success" style="width: 60px;" >
						<h1 style="margin: 0;margin-top: 1rem; color: green;">Billet Valide</h1>
						<div style="text-align: center; margin-top: 1em; margin-bottom: 1em;">
						<p style="margin: 0px;">
							<strong><?php esc_html_e( "Nom",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['name']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Code",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['code']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Événement",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['event']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "ID de la commande",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['orderid']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Package",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['package']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Heure de début",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['start_time']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Heure de fin",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['end_time']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Lieu",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['venue']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Adresse",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['address']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Email",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['email']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Téléphone",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['phone']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Adresse",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['address']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Société",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['company']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Description",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['desc']; ?>
						</p>
						</div>
						<div style="background-color: rgb(230, 230, 255,0.3);padding: 1.5rem;border-radius: 16px;">
							<p style="margin: 0; font-size: 0.9em" ><b>UN PROBLÈME?</b></p>
							<p style="color: #999999;font-size: 14px;font-weight: 500;">Vous pouvez nous contacter par le biais du formulaire de contact disponible ci-dessous, vous pouvez également essayer de nous joindre à notre adresse e-mail edsp.contact@gmail.com ou nous appeler au numéro de téléphone suivant +33659991231. </p>
							<button style="border: 1px solid #3399ff;color: #3399ff;width: 100%;padding: 1rem;background-color: transparent;font-size: 16px;font-weight: 600;margin-top: 0.5rem; cursor: pointer;"><a href="<?php echo get_bloginfo('url').'/contact' ?>" style="color: #3399ff; text-decoration: none;">Formulaire de Contact</a></button>
						</div>
					</div>

				<?php }else{ ?>
					<div style="max-width: 430px;margin: 0 auto;display: flex;align-items: center;flex-direction: column;padding: 2rem 0;">
						<img src="https://rendez-view.com/wp-content/uploads/2024/03/success.png" alt="success" style="width: 60px;" >
						<h1 style="margin: 0;margin-top: 1rem; color: green;">Valid Ticket</h1>
						<div style="text-align: center; margin-top: 1em; margin-bottom: 1em;">
						<p style="margin: 0px;">
							<strong><?php esc_html_e( "Name",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['name']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Code",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['code']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Event",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['event']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Order ID",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['orderid']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Package",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['package']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Start Time",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['start_time']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "End Time",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['end_time']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Venue",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['venue']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Address",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['address']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Email",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['email']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Phone",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['phone']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Address",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['address']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Company",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['company']; ?>
						</p>
						<p style="margin: 0px;">
							<strong ><?php esc_html_e( "Description",  "ovaem-events-manager" ); ?>:</strong>
							<?php echo $result['desc']; ?>
						</p>
						</div>
						<div style="background-color: rgb(230, 230, 255,0.3);padding: 1.5rem;border-radius: 16px;">
							<p style="margin: 0; font-size: 0.9em" ><b>HAVING AN ISSUE?</b></p>
							<p style="color: #999999;font-size: 14px;font-weight: 500;">You can contact us through the contact form available down bellow, alternatively you can try to reach us at our mail edsp.contact@gmail.com or try to call us at the following phone number +33659991231. </p>
							<button style="border: 1px solid #3399ff;color: #3399ff;width: 100%;padding: 1rem;background-color: transparent;font-size: 16px;font-weight: 600;margin-top: 0.5rem; cursor: pointer;"><a href="<?php echo get_bloginfo('url').'/contact' ?>" style="color: #3399ff; text-decoration: none;">Go to Contact Form</a></button>
						</div>
					</div>
				<?php } ?>

			<?php } else { ?>
				<?php if(get_locale() == 'fr_FR' ) { ?>
					<div style="max-width: 430px;margin: 0 auto;display: flex;align-items: center;flex-direction: column;padding: 2rem 0;">
						<img src="https://rendez-view.com/wp-content/uploads/2024/03/failure.png" alt="Failure" style="width: 60px;" >
						<h1 style="margin: 0;margin-top: 1rem; color: red;">Billet Invalide</h1>
						<p style="font-size: 18px;font-weight: 600;">Ce billet est expiré ou a déjà été utilisé</p>
						<div style="background-color: rgb(230, 230, 255,0.3);padding: 1.5rem;border-radius: 16px;">
							<p style="margin: 0; font-size: 0.9em" ><b>QUE FAIRE?</b></p>
							<p style="color: #999999;font-size: 14px;font-weight: 500;">Vous pouvez nous contacter par le biais du formulaire de contact disponible ci-dessous, vous pouvez également essayer de nous joindre à notre adresse e-mail edsp.contact@gmail.com ou nous appeler au numéro de téléphone suivant +33659991231. </p>
							<button style="border: 1px solid #3399ff;color: #3399ff;width: 100%;padding: 1rem;background-color: transparent;font-size: 16px;font-weight: 600;margin-top: 0.5rem; cursor: pointer;"><a href="<?php echo get_bloginfo('url').'/contact' ?>" style="color: #3399ff; text-decoration: none;">Formulaire de Contact</a></button>
						</div>
					</div>
				<?php } else { ?>
					<div style="max-width: 430px;margin: 0 auto;display: flex;align-items: center;flex-direction: column;padding: 2rem 0;">
						<img src="https://rendez-view.com/wp-content/uploads/2024/03/failure.png" alt="Failure" style="width: 60px;" >
						<h1 style="margin: 0;margin-top: 1rem; color: red;">Invalid Ticket</h1>
						<p style="font-size: 18px;font-weight: 600;">This ticket is either used or expired.</p>
						<div style="background-color: rgb(230, 230, 255,0.3);padding: 1.5rem;border-radius: 16px;">
							<p style="margin: 0; font-size: 0.9em" ><b>WHAT TO DO?</b></p>
							<p style="color: #999999;font-size: 14px;font-weight: 500;">You can contact us through the contact form available down bellow, alternatively you can try to reach us at our mail edsp.contact@gmail.com or try to call us at the following phone number +33659991231 </p>
							<button style="border: 1px solid #3399ff;color: #3399ff;width: 100%;padding: 1rem;background-color: transparent;font-size: 16px;font-weight: 600;margin-top: 0.5rem; cursor: pointer;"><a href="<?php echo get_bloginfo('url').'/contact' ?>" style="color: #3399ff; text-decoration: none;">Go to Contact Form</a></button>
						</div>
					</div>
				<?php } ?>
			<?php }
		}
		?>
	</div>
</div>

<?php //get_footer( );
