<?php defined( 'ABSPATH' ) || exit();
	$prefix = OVAEM_Settings::$prefix;

	$date_format = 'd M Y';
	$time_format = 'H:i';

	

	$venue = '';
	$venues = apply_filters( 'ovaem_venues', '' );

	$categories = apply_filters( 'ovaem_get_categories', 10 );

	$limit_gallery = OVAEM_Settings::frontend_submit_limit_gallery();

	$settings_editor = array(
		'textarea_name' => $prefix.'_content',
		'media_buttons' => false
	);

	

?>
<div class="container-fluid">
	<form method="post" action="<?php echo esc_url( home_url('/') ); ?>" class="ovaem_frontend_submit" id="ovaem_frontend_submit" enctype="multipart/form-data">

		<div class="row">

			<div class="ovaem_row col-md-6">
				<label>
					<span class="name"><?php esc_html_e( "Name", "ovaem-events-manager" ); ?>: </span>
					<input type="text" name="ovaem_name"  required="" placeholder="<?php esc_html__( 'Name', 'ovaem-events-manager' ); ?> " />	
				</label>
				
			</div>
			
			

			<div class="ovaem_row col-md-6">
				<label>
					<span class="name"><?php esc_html_e( "Address", "ovaem-events-manager" ); ?>:</span>
					<input type="text" name="<?php echo esc_attr($prefix).'_address'; ?>"  />	
				</label>
				
			</div>

			<div class="ovaem_row col-md-6">
				<label>
					<span class="name"><?php esc_html_e( "Start Time", "ovaem-events-manager" ); ?></span>
					<input type="text" name="<?php echo esc_attr($prefix).'_date_start_time'; ?>" class="ovaem_datetime_submit" data-date_format="<?php echo $date_format; ?>" data-time_format="<?php echo $time_format; ?>"  />	
				</label>
				
			</div>

			<div class="ovaem_row col-md-6">
				<label>
					<span class="name"><?php esc_html_e( "End  Time", "ovaem-events-manager" ); ?></span>
					<input type="text" name="<?php echo esc_attr($prefix).'_date_end_time'; ?>" class="ovaem_datetime_submit" data-date_format="<?php echo $date_format; ?>" data-time_format="<?php echo $time_format; ?>"   />	
				</label>
				
			</div>

			<div class="ovaem_row col-md-6">

				<label>
					<span class="name"><?php esc_html_e( 'Categories', 'ovaem-events-manager' ); ?>:</span>
					<select name="<?php echo esc_attr($prefix); ?>_cat" class="ovaem_venues">
						<option value="" >-----------</option>
						<?php foreach ($categories as $key => $value) { ?>
							<option value="<?php echo esc_attr($value->term_id); ?>" >
								<?php echo $value->name; ?> 
							</option>	
						<?php } ?>
					</select>

				</label>

				

			</div>

			<div class="ovaem_row col-md-6">

				<label>
					<span class="name"><?php esc_html_e( 'Venue', 'ovaem-events-manager' ); ?></span>
					<select name="<?php echo esc_attr($prefix); ?>_venue" class="ovaem_venues">

						<option value="" >---------------</option>

						<?php if($venues->have_posts() ) : while ( $venues->have_posts() ) : $venues->the_post(); 
							global $post;
							$selected = ( $post->post_name == $venue) ? 'selected' : '';
						?>
							<option value="<?php echo esc_attr($post->post_name); ?>" <?php echo esc_attr($selected); ?> ><?php the_title(); ?> </option>
						<?php endwhile;endif; ?>
					</select>

				</label>

				
				
			</div>

			<div class="ovaem_row col-md-6">
				<label>
					<span class="name"><?php esc_html_e( 'Thumbnail', 'ovaem-events-manager' ); ?>:</span>
					<input type="file" name="image_feature" class="ovame_file" />
					<div><?php esc_html_e('extension: .jpg, .png, .jpeg', 'ovaem-events-manager'); ?></div>
				</label>
				
				
			</div>
			<div class="ovaem_row col-md-6">
				<label>
					<span class="name"><?php esc_html_e( 'Gallery', 'ovaem-events-manager' ); ?>:</span>
					<input type="file" name="gallery[]" multiple class="ovame_file"/>
					<span><?php printf( esc_html__('limit %s images with extension .jpg, .jpeg, .png', 'ovaem-events-manager' ), $limit_gallery ); ?></span>
				</label>
			</div>

			<div class="ovaem_row col-md-12">
				<label class="ova_desc">
					<span class="name"><?php esc_html_e( 'Intro', 'ovaem-events-manager' ); ?>:</span>
					<textarea name="<?php echo $prefix.'_intro'; ?>" cols="90" rows="3"></textarea><br/>
					<?php esc_html_e( "You should insert about 150 words. Don't insert html tag here." ) ?>
				</label>
			</div>
			

			<div class="ovaem_row col-md-12">
				<label class="ova_desc">
					<span class="name"><?php esc_html_e( 'Description', 'ovaem-events-manager' ); ?>:</span>
					<?php if( OVAEM_Settings::frontend_submit_show_editor() == 'yes' ){ ?>
						<?php wp_editor( '',  $prefix.'_content' , $settings_editor ); ?> 
					<?php }else{ ?>
						<textarea name="<?php echo $prefix.'_content'; ?>" cols="90" rows="10" required></textarea>
					<?php } ?>
				</label>
			</div>

			

			<div class="ovaem_row col-md-6">
				<label>
					<span class="name"><?php esc_html_e( 'Tags', 'ovaem-events-manager' ); ?>:</span>
					<input type="text" name="<?php echo $prefix.'_tags'; ?>" />
					<span><?php printf( esc_html__('separated by comma. Limit %s words', 'ovaem-events-manager'), OVAEM_Settings::frontend_submit_limit_tags() ); ?>
				</label>
				
					 

				
				
			</div>
			

		</div>

		<div class="ovaem_row">
			<button type="submit" class="ova-btn ova-btn-main-color"><?php esc_html_e( "Submit", "ovaem-events-manager" ); ?></button>
		</div>

		<input type="hidden" name="post_type" value="<?php echo OVAEM_Settings::event_post_type_slug(); ?>">
		<input type="hidden" name="frontend_submit" value="<?php echo OVAEM_Settings::event_post_type_slug(); ?>">

		<?php wp_nonce_field( 'ovaem_submit_event_nonce', 'ovaem_submit_event_nonce' ); ?>
		

	</form>
</div>