<?php 

if( !defined( 'ABSPATH' ) ) exit();


$prefix = OVAEM_Settings::$prefix;

/* Add Schedule */
$count_tickets 	= isset( $_POST['count_tickets'] ) ? $_POST['count_tickets'] : '';
$add_ticket		= isset( $_POST['add_ticket'] ) ? $_POST['add_ticket'] : '' ;

$date_format = 'd M Y';
$time_format = 'H:i';
$event_calendar_input_step = OVAEM_Settings::event_calendar_input_step();

/* Load Schedule */
$event_id    		= isset( $_POST['event_id'] ) ? $_POST['event_id'] : '';


$ticket_field = $prefix.'_ticket';
$tickets = array();

$tickets = get_post_meta( $event_id , $ticket_field, true );

if( $add_ticket == 'yes' ){
	$tickets[$count_tickets] = '';
}



if( $tickets ){
	foreach ($tickets as $key => $ticket) {
		
		if($add_ticket == 'yes') $key = $count_tickets;
		
		
 ?>
		<div class="ticket_item ticket_item_<?php echo esc_attr($key); ?>" data-ticket-id="<?php echo esc_attr($key); ?>" data-prefix="<?php echo esc_attr($prefix); ?>">
		    	
			<div class="head">
				<div class="date_label">
					<a href="#" class="delete_ticket" title="<?php esc_html_e( 'Remove Ticket', 'ovaem-events-manager' ); ?> ">
						<i class="fa fa-remove"></i>
					</a>
					<span class='label_title'><?php echo esc_attr( isset( $ticket["ticket_name"] ) ? $ticket["ticket_name"] : '' ); ?></span>
				</div>
				<div class="icon toggle_ticket"><a href="#"><i class="fa fa-arrows-v"></i></a> </div>
			</div>

			<div class="ticket_content">
				

				<div class="ovaem_event_row">
					<label><?php esc_html_e( 'Package ID', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][package_id]" 
						value="<?php echo esc_attr( isset( $ticket["package_id"] ) ? $ticket["package_id"] : '' ); ?>" class="package_id" size="15" />
						<span><?php esc_html_e( 'Unique ID, Not Space _. Example: package01', 'ovaem-events-manager' ); ?></span>
						<br><br>
				</div>

				<div class="ovaem_event_row">
					<label><?php esc_html_e( 'Package', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][ticket_name]" 
						value="<?php echo esc_attr( isset( $ticket["ticket_name"] ) ? $ticket["ticket_name"] : '') ?>" class="ticket_name" size="15" />
						<br><br>
				</div>


				<div class="ovaem_event_row">

					<label class="label"><?php esc_html_e( 'Pay Method', 'ovaem-events-manager' ); ?>:</label>

					<select name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][pay_method]" class="ovaem_pay_method">
						<option value="paid_woo" <?php echo ( isset($ticket["pay_method"]) && $ticket["pay_method"] == 'paid_woo') ? 'selected':'' ?> ><?php esc_html_e( 'Paid Woo', 'ovaem-events-manager' ); ?> </option>
						<option value="free" <?php echo ( isset($ticket["pay_method"]) && $ticket["pay_method"] == 'free') ? 'selected':'' ?> ><?php esc_html_e( 'Free', 'ovaem-events-manager' ); ?> </option>
						<option value="outside" <?php echo ( isset($ticket["pay_method"]) && $ticket["pay_method"] == 'outside') ? 'selected':'' ?> ><?php esc_html_e( 'Outside', 'ovaem-events-manager' ); ?> </option>
						<option value="other_pay_gateway" <?php echo ( isset($ticket["pay_method"]) && $ticket["pay_method"] == 'other_pay_gateway') ? 'selected':'' ?> ><?php esc_html_e( 'Other Pay Gateway', 'ovaem-events-manager' ); ?> </option>
						<?php if ( class_exists( 'WooCommerce' ) ): ?>
							<option value="woo_modern" <?php echo ( isset($ticket["pay_method"]) && $ticket["pay_method"] == 'woo_modern') ? 'selected':'' ?>><?php esc_html_e( 'Woo Modern', 'ovaem-events-manager' ); ?></option>
						<?php endif; ?>
					</select>
					<br/><br>
				</div>	
					
				<div class="ovaem_event_row ova_quatity">
						<label class="label"><?php esc_html_e( 'Quatity', 'ovaem-events-manager' ); ?>:</label>
						<input type="text" class="quatity" name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][quatity]" value="<?php echo esc_attr(isset( $ticket['quatity'] ) ? $ticket['quatity'] : '' ); ?>" />
						<br/><br/>
				</div>

				<div class="ovaem_event_row ova_outside">
						<label class="label"><?php esc_html_e( 'Outside', 'ovaem-events-manager' ); ?>:</label>		 	
						<input type="text" class="outside" name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][outside]" value="<?php echo esc_attr( isset( $ticket['outside'] ) ? $ticket['outside'] : '' ); ?>" size="60" />
						<br/><br/>
				</div>


				

				<div class="ovaem_event_row ova_price">
					<label><?php esc_html_e( 'Price', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][ticket_price]" 
						value="<?php echo esc_attr( isset( $ticket["ticket_price"] ) ? $ticket["ticket_price"] : '' ) ?>" class="ticket_price" size="15" />
						<br><br>
				</div>

				<div class="ovaem_event_row ova_currency">
					<label><?php esc_html_e( 'Currency', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][ticket_cur]" 
						value="<?php echo esc_attr( isset( $ticket["ticket_cur"] ) ? $ticket["ticket_cur"] : '' ) ?>" class="ticket_cur" size="15" />
						<br><br>
				</div>

				<div class="ovaem_event_row ova_woo_id">
					<label><?php esc_html_e( 'Choose Product in Woo', 'ovaem-events-manager' ); ?></label>
					<select name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][ticket_woo_id]" class="ticket_woo_id">
					<option value=""><?php esc_html_e( "--------------", 'ovaem-events-manager' ) ?></option>
					<?php $args = array(
							'post_type' => 'product',
							'posts_per_page' => -1,
							'post_status'	=> 'publish'
							);
						$loop = new WP_Query( $args );
						if ( $loop->have_posts() ) {
							while ( $loop->have_posts() ) : $loop->the_post(); ?>
								<?php if( current_user_can( 'edit_post', $event_id ) ) { ?>
									<option value="<?php echo get_the_id(); ?>" <?php if( isset( $ticket["ticket_woo_id"] ) && $ticket["ticket_woo_id"] == get_the_id() ) echo "selected"; ?> >
									<?php the_title(); ?></option>
								<?php } ?>
							<?php endwhile;
						} else {
							echo esc_html__( 'No products found', 'ovaem-events-manager' );
						}
						wp_reset_postdata(); ?>
					</select>
						<br><br>
				</div>

				<div class="ovaem_event_row ova_number_ticket">
					<label><?php esc_html_e( 'Number Tickets', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][number_ticket]" 
						value="<?php echo esc_attr( isset( $ticket["number_ticket"] ) ? $ticket["number_ticket"] : '' ) ?>" placeholder="<?php esc_html_e('Insert number', 'ovaem-events-manager'); ?>" class="number_ticket" size="15" />
						<br><br>
				</div>

				<div class="ovaem_event_row">
					<label><?php esc_html_e( 'Featured', 'ovaem-events-manager' ); ?></label>
					<select name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][ticket_feature]" class="ticket_feature">
						<option value="no_featured" <?php echo esc_attr( isset($ticket["ticket_feature"]) && $ticket["ticket_feature"] == 'no_featured' ? 'selected': '' ) ?>><?php esc_html_e( 'No', 'ovaem-events-manager' ) ?></option>
						<option value="featured" <?php echo esc_attr( isset($ticket["ticket_feature"]) && $ticket["ticket_feature"] == 'featured' ? 'selected': '' ) ?>> <?php esc_html_e( 'Yes', 'ovaem-events-manager' ) ?> </option>
					</select>
					<br><br>
				</div>

				<div class="ovaem_event_row">
				 	<label class="label"><strong><?php esc_html_e( 'File Certificate attachment Mail. ( Should use PDF or Image file )', 'ovaem-events-manager' ); ?>: </strong></label>
				 	<br><br>
				 	
				 	<?php 
				 		$pdf_attach = isset( $ticket['pdf_attach'] ) ? $ticket['pdf_attach'] : '';
				 		$pdf_attach_info = get_post( $pdf_attach ); ?>

				    <div class="upload">
				    	<?php if ( $pdf_attach && $pdf_attach_img = wp_get_attachment_image_src( $pdf_attach, 'medium' ) ) {
				    		$src = $pdf_attach_img['0']; ?>

				        	<img class="img_ticket" data-src="<?php echo esc_url( $src ); ?> " src="<?php echo esc_url($src); ?>" width="100px"/>

				        <?php }else if ( $pdf_attach && !wp_get_attachment_image_src( $pdf_attach, 'medium' ) ) { ?>

				        	<?php if( file_exists( get_attached_file($pdf_attach) ) ){ ?>
				        	
				        	<a class="file_ticket" href="<?php echo home_url(); ?>/wp-admin/media-upload.php?post_id=<?php echo $pdf_attach; ?>&type=generic&TB_iframe=1">
				        		<?php echo basename((get_attached_file($pdf_attach))); ?>
				        			
				        	</a>

				        	<?php }else{ 
				        		esc_html_e( 'Not found file','ovaem-events-manager' ); 
				        	} ?>

				        <?php } ?>
				        <img class ='img_ticket_2' src="" width="100px" style="display: none;"/>
				        <a class ='file_ticket_2' href="<?php echo home_url(); ?>/wp-admin/media-upload.php?post_id=<?php echo $pdf_attach; ?>&type=generic&TB_iframe=1">
				        </a>


				        <div>
				        	<input type="hidden" name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][pdf_attach]" value="<?php echo $pdf_attach; ?>">
				            <button type="submit" class="upload_pdf_button button"><?php esc_html_e( 'Upload', 'ovaem-events-manager' ) ?></button>
				            <button type="submit" class="remove_pdf_button button">&times;</button>
				        </div>
				    </div>
				</div>


				<div class="ovaem_event_row">
					
					<label><?php esc_html_e( 'Available dates for tickets selling', 'ovaem-events-manager' ); ?></label>

					<select name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][avaiable_date_selling]" class="avaiable_date_selling">
						<option value="open_ended" <?php echo ( isset($ticket["avaiable_date_selling"]) && $ticket["avaiable_date_selling"] == 'open_ended') ? 'selected':'' ?> >
							<?php esc_html_e( 'When public event', 'ovaem-events-manager' ); ?>
						</option>
						<option value="date_range" <?php echo ( isset($ticket["avaiable_date_selling"]) && $ticket["avaiable_date_selling"] == 'date_range') ? 'selected':'' ?> >
							<?php esc_html_e( 'During selected date range', 'ovaem-events-manager' ); ?>
						</option>
						
					</select>
					&nbsp;

					<div class="avaiable_date_selling_date_range">

						<span><?php esc_html_e( 'From', 'ovaem-events-manager' ); ?></span>

						<input 
							type="text" 
							autocomplete="off"
							name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][sell_date_start]" 
							value="<?php echo esc_attr( isset( $ticket["sell_date_start"] ) ? $ticket["sell_date_start"] : '' ) ?>" 
							class="ovaem_datetime_picker sell_date_start" 
							data-date_format="<?php echo esc_attr($date_format); ?>" data-time_format="<?php echo esc_attr($time_format); ?>" 
							data-step="<?php echo esc_attr( $event_calendar_input_step ); ?>" 
							data-first-day="<?php echo esc_attr( OVAEM_Settings::first_day_of_week() ); ?>"
						/>
						
						<?php esc_html_e( "to", 'ovaem-events-manager' ); ?>	

						<input 
							type="text" 
							autocomplete="off"
							name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][sell_date_end]" 
							value="<?php echo esc_attr( isset( $ticket["sell_date_end"] ) ? $ticket["sell_date_end"] : '' ) ?>" 
							class="ovaem_datetime_picker sell_date_end"  
							data-date_format="<?php echo esc_attr($date_format); ?>" data-time_format="<?php echo esc_attr($time_format); ?>" 
							data-step="<?php echo esc_attr( $event_calendar_input_step ); ?>" 
							data-first-day="<?php echo esc_attr( OVAEM_Settings::first_day_of_week() ); ?>"
							/>

						</div>
						
					<br><br>

				</div>

				

				<div class="ovaem_event_row">
					<label><?php esc_html_e( 'Description', 'ovaem-events-manager' ); ?></label><br>
					
					<textarea cols="50" rows="10" name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][ticket_desc]"  class="ticket_desc" ><?php echo esc_html( isset( $ticket["ticket_desc"] ) ? $ticket["ticket_desc"] : '' ) ?></textarea>
					<div class="clearfix"><?php esc_html_e( "You can insert with syntax: {{ Feature 1 }} {{ Feature 2 }} ", "ovaem-events-manager" ) ?> </div>
				</div>

				<br><br>

				<div class="ovaem_event_row">
					<h3 class="title_virtual_event"><?php esc_html_e( 'Insert link, password used for virtual event', 'ovaem-events-manager' ); ?></h3>
					<span class="sub_title_virtual_event"><?php esc_html_e( 'These info will send to email when the customer booking ticket successfully', 'ovaem-events-manager' ); ?></span>
					<br><br>

					<label><?php esc_html_e( 'Link', 'ovaem-events-manager' ); ?></label>
					<input type="text" 
							autocomplete="off"
							name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][link]" 
							value="<?php echo esc_attr( isset( $ticket["link"] ) ? $ticket["link"] : '' ) ?>" 
							class="ticket_link"  
							 />
						
				</div>
				<br>

				<div class="ovaem_event_row">
					<label><?php esc_html_e( 'Password', 'ovaem-events-manager' ); ?></label>
					<input type="text" 
							autocomplete="off"
							name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][password]" 
							value="<?php echo esc_attr( isset( $ticket["password"] ) ? $ticket["password"] : '' ) ?>" 
							class="ticket_password"  
							 />
					
				</div>

				<input type="hidden" name="<?php echo esc_attr($ticket_field); ?>[<?php echo esc_attr($key);?>][ticket_id]"
				value="<?php echo esc_attr( isset( $ticket["ticket_id"] ) ? $ticket["ticket_id"] : '' ) ?>" />

				
			</div>
			
		</div>

<?php }
} ?>

