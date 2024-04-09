<?php if ( !defined( 'ABSPATH' ) ) exit();

get_header( );
if( OVAEM_Settings::google_key_map() != '' ){
	wp_enqueue_script( 'google-map-api','https://maps.googleapis.com/maps/api/js?key='.OVAEM_Settings::google_key_map().'&callback=Function.prototype&libraries=places', null, true );
	echo '<script>var google_map = true;</script>';
}else{
	echo '<script>var google_map = false;</script>';
}

?>

<?php $prefix = OVAEM_Settings::$prefix; ?>

<div class="grey_bg ova_single_venue">
	<div class="container">
		<div class="row">

			<?php if( have_posts() ): while( have_posts() ): the_post(); ?>

				<?php 
					$email = get_post_meta( get_the_id(), $prefix.'_venue_email', true );
					$phone = get_post_meta( get_the_id(), $prefix.'_venue_phone', true );
					$fax = get_post_meta( get_the_id(), $prefix.'_venue_fax', true );
					$address = get_post_meta( get_the_id(), $prefix.'_venue_address', true );
					$weblink = get_post_meta( get_the_id(), $prefix.'_venue_weblink', true );

					$wd_inweek = get_post_meta( get_the_id(), $prefix.'_venue_wd_inweek', true );
					$wd_saturday = get_post_meta( get_the_id(), $prefix.'_venue_wd_saturday', true );
					$wd_sunday = get_post_meta( get_the_id(), $prefix.'_venue_wd_sunday', true );

					$show_map = get_post_meta( get_the_id(), $prefix.'_show_map', true );
					$ovaem_map_lat = get_post_meta( get_the_id(), $prefix.'_map_lat', true );
					$ovaem_map_lng = get_post_meta( get_the_id(), $prefix.'_map_lng', true );

					if( $email || $phone || $fax || $address || $weblink || $wd_inweek || $wd_saturday || $wd_sunday || $show_map == 'yes' ){
						$col_left = 'col-md-8';
						$col_right = 'col-md-4';
					}else{
						$col_left = 'col-md-12';
						$col_right = '';
					}
					
				?>

				<div class="<?php echo esc_attr($col_left); ?>">

					<div class="content">

						
					
						<!-- Gallery, Thumbnail -->
						<div class="gallery">
							<?php 
								
									do_action( 'ovaem_event_thumbnail' );	
								

							?>
						</div>

						
						
						<!-- Content -->
						<div class="desc">
							<?php the_content(); ?>
						</div>

						
						
						<!-- Socials -->
						<div class="social">
							<span><i class="social_share"></i> <?php esc_html_e( 'Share', 'ovaem-events-manager' ); ?></span>
							<?php do_action( 'ovaem_event_social' ); ?>
						</div>
							

					</div>

					

				</div>

				<div class="<?php echo esc_attr($col_right); ?>">

					<!-- Event Detail -->
					<?php if( $email || $phone || $fax || $address || $weblink ){ ?>
						<div class="event_widget event_info">
						

							<h3 class="title">
								<?php esc_html_e( 'Venue Detail', 'ovaem-events-manager' ); ?>
								<span class="one"></span><span  class="two"></span><span  class="three"></span><span  class="four"></span><span  class="five"></span>
								<i class="icon_document_alt"></i>
							</h3>
								
							<div class="wrap_event_widget">

								
								<!-- time -->
								<div class="time">

									
									<?php if( $email ){ ?>
									<div class="clearfix event_row">
										<label><?php esc_html_e( 'Email: ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $email; ?></span>
									</div>
									<?php } ?>

									<?php if( $phone ){ ?>
									<div class="clearfix event_row">
										<label><?php esc_html_e( 'Phone: ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $phone; ?></span>
									</div>
									<?php } ?>

									<?php if( $fax ){ ?>
									<div class="clearfix event_row">
										<label><?php esc_html_e( 'Fax: ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $fax; ?></span>
									</div>
									<?php } ?>

									<?php if( $address ){ ?>
									<div class="clearfix event_row">
										<label><?php esc_html_e( 'Address: ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $address; ?></span>
									</div>
									<?php } ?>

									<?php if( $weblink ){ ?>
									<div class="clearfix event_row">
										<label><?php esc_html_e( 'Web link: ', 'ovaem-events-manager' ); ?></label>
										<span><a href="<?php echo esc_url($weblink); ?>" target="_blank"><?php echo $weblink; ?></a></span>
									</div>
									<?php } ?>

									
								</div>
								
							</div>

							
						</div>
					<?php } ?>

					<?php if( $show_map == 'yes' ){ ?>
						<div class="event_widget">
						
							<h3 class="title">
								<?php esc_html_e( 'Google Maps', 'ovaem-events-manager' ); ?>
								<span class="one"></span><span  class="two"></span><span  class="three"></span><span  class="four"></span><span  class="five"></span>
								<i class="icon_pin_alt"></i>
							</h3>
								
							<div class="wrap_event_widget">
								<?php if( $show_map == 'yes' && $ovaem_map_lat != '' && $ovaem_map_lng != '' ){ 
									$map_zoom = OVAEM_Settings::detail_venue_event_map_zoom();
								?>


								<div class="clearfix">
									<div id="ovaem_map" class="ovaem_map" data-lat="<?php echo esc_attr($ovaem_map_lat); ?>" data-lng="<?php echo esc_attr($ovaem_map_lng); ?>" data-zoom="<?php echo esc_attr($map_zoom); ?>" data-address="<?php echo esc_attr($address); ?>"></div>

									<div class="get_direction_map">
										<a class="btn ova-btn text-center" href="https://maps.google.com?saddr=Current+Location&daddr=<?php echo esc_attr($ovaem_map_lat); ?>,<?php echo esc_attr($ovaem_map_lng); ?>" target="_blank" ><i class="fa fa-location-arrow"></i><?php esc_html_e( 'Get Direction', 'ovaem-events-manager' ); ?> </a>
									</div>
									
								</div>
								<?php } ?>
							</div>

						</div>
					<?php } ?>

					<?php if( $wd_inweek || $wd_saturday || $wd_sunday ){ ?>

						<div class="event_widget event_sponsors">
						
							<h3 class="title">
								<?php esc_html_e( 'Working Hours', 'ovaem-events-manager' ); ?>
								<span class="one"></span><span  class="two"></span><span  class="three"></span><span  class="four"></span><span  class="five"></span>
								<i class="icon_clock_alt"></i>
							</h3>
								
							<div class="wrap_event_widget">
								
								<?php if( $wd_inweek ){ ?>
									<div class="clearfix event_row">
										<label><?php esc_html_e( 'Weekdays ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $wd_inweek; ?></span>
									</div>
								<?php } ?>

								<?php if( $wd_saturday ){ ?>
									<div class="clearfix event_row">
										<label><?php esc_html_e( 'Saturday ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $wd_saturday; ?></span>
									</div>
								<?php } ?>

								<?php if( $wd_sunday ){ ?>
									<div class="clearfix event_row">
										<label><?php esc_html_e( 'Sunday ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $wd_sunday; ?></span>
									</div>
								<?php } ?>

								
							
							</div>

						</div>
					<?php } ?>
					
				</div>

			<?php endwhile; endif; wp_reset_postdata(); ?>

		</div>
	</div>

	<?php 
	if( OVAEM_Settings::detail_venue_event_show() == 'true' ){
		do_action('ovaem_event_related');
	}
	?>	

		

</div>

<?php get_footer( );
