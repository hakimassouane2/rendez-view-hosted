<?php if ( !defined( 'ABSPATH' ) ) exit();

add_filter( 'body_class', 'em4u_single_event_modern' );
function em4u_single_event_modern( $classes ) {

	$classes[] = 'single-event-modern';

	return $classes;
}

get_header( );


if( OVAEM_Settings::google_key_map() != '' ){
	wp_enqueue_script( 'google-map-api','https://maps.googleapis.com/maps/api/js?key='.OVAEM_Settings::google_key_map().'&callback=Function.prototype&libraries=places', null, true );
	echo '<script>var google_map = true;</script>';
}else{
	echo '<script>var google_map = false;</script>';
}




?>

<?php 
$prefix = OVAEM_Settings::$prefix;
$date_format = get_option('date_format');
$time_format = get_option('time_format');

$id = get_the_id();

$start_time = get_post_meta( $id, $prefix.'_date_start_time', true);
$end_time = get_post_meta( $id, $prefix.'_date_end_time', true);

$room = get_post_meta( $id, $prefix.'_address', true);

$address = get_post_meta( $id, $prefix.'_address_event', true);

$content_sidebar = get_post_meta( $id, $prefix.'_event_sidebar', true);

$event_show_map = OVAEM_Settings::event_show_map();
$event_show_venue = OVAEM_Settings::event_show_venue();


// Get Label
$label_schedule = get_post_meta( $id, $prefix.'_label_schedule', true) ? get_post_meta( $id, $prefix.'_label_schedule', true) : 'Schedule';
$label_speaker  = get_post_meta( $id, $prefix.'_label_speaker', true) ? get_post_meta( $id, $prefix.'_label_speaker', true) : 'Speaker';
$label_ticket   = get_post_meta( $id, $prefix.'_label_ticket', true) ? get_post_meta( $id, $prefix.'_label_ticket', true) : 'Ticket & Price';
$label_contact  = get_post_meta( $id, $prefix.'_label_contact', true) ? get_post_meta( $id, $prefix.'_label_contact', true) : 'Contact';
$label_sidebar  = get_post_meta( $id, $prefix.'_label_sidebar', true) ? get_post_meta( $id, $prefix.'_label_sidebar', true) : 'Your Ads';



$vanue_title = $ovaem_map_lat = $ovaem_map_lng = $map_address = $show_map = '';

if( $event_show_map == 'address' ){
	$ovaem_map_lat = get_post_meta( $id, $prefix.'_event_map_lat', true );
	$ovaem_map_lng = get_post_meta( $id, $prefix.'_event_map_lng', true );
	$map_address = get_post_meta( $id, $prefix.'_event_map_address', true );	
}

if(  $event_show_venue == 'true' || $event_show_map == 'venue' ){
	
	$venue_slug = get_post_meta( get_the_id(), $prefix.'_venue', true);
	
	$venue_detail = apply_filters( 'ovaem_get_venues_list', array($venue_slug), 'false', 1  );
	if( $venue_detail->have_posts() ): while( $venue_detail->have_posts() ): $venue_detail->the_post();
		
		if( $event_show_venue == 'true' ){
			$vanue_title = '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';	
		}
		
		if( $event_show_map == 'venue' ){
			$ovaem_map_lat = get_post_meta( get_the_id(), $prefix.'_map_lat', true );
			$ovaem_map_lng = get_post_meta( get_the_id(), $prefix.'_map_lng', true );
			$map_address = get_post_meta( get_the_id(), $prefix.'_map_address', true );	
		}

	endwhile; endif; wp_reset_postdata();
}

// Get Schedule
$schedule_parent = get_post_meta( get_the_id(), $prefix.'_schedule_date', true );

// Get Speaker
$speakers_slug = explode( ',', get_post_meta( get_the_id(), 'speakers', true ) );




?>
<div class="ova_single_event_modern">
	<div class="grey_bg ova_single_event">
		<?php if( have_posts() ): while( have_posts() ): the_post(); ?>

			<?php if ( ! post_password_required() ) { ?>

				<!-- Gallery, Thumbnail -->
				<?php if( OVAEM_Settings::event_show_gallery() == 'true' ){ ?>
					<div class="gallery">
						<?php 
						if( get_post_meta( get_the_id(), 'ovaem_gallery_id', true) ){
							// Gallery
							do_action( 'ovaem_event_gallery_modern' );	
						}else if( has_post_thumbnail() ) {
							// Thumbnail
							do_action( 'ovaem_event_thumbnail' );
						}

						?>
					</div>
				<?php } ?>

			<?php } ?>

			<?php if ( ! post_password_required() ) { ?>
				<div class="heading">
					<div class="container">
						<div class="heading_content">

							<div class="title">
								<h1><?php the_title(); ?></h1>

								<div class="wrap_date">
									<?php if( $start_time != '' && OVAEM_Settings::event_show_startdate() == 'true' ){ ?>
										<div class="date">
											<label><?php esc_html_e( 'From', 'ovaem-events-manager' ); ?></label>
											<span><?php echo date_i18n($date_format.' '.$time_format, $start_time); ?></span>
										</div>
									<?php } ?>

									<?php if( $end_time != '' && OVAEM_Settings::event_show_enddate() == 'true' ){ ?>
										<div class="date">
											<label><?php esc_html_e( 'To', 'ovaem-events-manager' ); ?></label>
											<span><?php echo date_i18n($date_format.' '.$time_format, $end_time); ?></span>
										</div>
									<?php } ?>
								</div>

								<?php if( OVAEM_Settings::event_show_address() == 'true' && $address ){ ?>
									<div class="clearfix event_row">
										<label>
											<?php esc_html_e( 'Address: ', 'ovaem-events-manager' ); ?>
										</label>
										<span><?php echo $address; ?></span>
									</div>
								<?php } ?>

								<?php if( $room && OVAEM_Settings::event_show_room() == 'true' ){ ?>
									<div class="clearfix event_room_row event_row">
										<label><?php esc_html_e( 'Room: ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $room; ?></span>
									</div>
								<?php } ?>


								<?php if( $vanue_title && OVAEM_Settings::event_show_venue() == 'true' ){ ?>
									<div class="clearfix event_venue_row event_row">
										<label><?php esc_html_e( 'Venue: ', 'ovaem-events-manager' ); ?></label>
										<span><?php echo $vanue_title; ?></span>
									</div>
								<?php } ?>


							</div>

							<div class="ova_share">

								<?php if( OVAEM_Settings::event_show_share_social() == 'true' ){ ?>
									<!-- Socials -->
									<div class="share">
										<button class="ova-btn ova-btn-medium ova-btn-rad-4"><?php esc_html_e( 'Share','ovaem-events-manager' ); ?></button>	
										<div class="social">
											<?php do_action( 'ovaem_event_social' ); ?>
										</div>
									</div>
								<?php } ?>

								<?php if( OVAEM_Settings::event_show_ical() == 'true' ){ ?>	
									<div class="my_calendar">
										<button class="ova-btn ova-btn-medium ova-btn-rad-4"><?php esc_html_e( 'Add to My Calendar','ovaem-events-manager' ); ?></button>
										<div class="event-calendar-sync">
											<span class="sync">
												<?php $date_start = date('m/d/y H:i', $start_time ) ;
												$date_end = date('m/d/y H:i', $end_time );
												$organizer_name = get_post_meta( $id, $prefix.'_org_name', true ) ? get_post_meta( $id, $prefix.'_org_name', true ) : '';
												$organizer_email = get_post_meta( $id, $prefix.'_org_email', true ) ? get_post_meta( $id, $prefix.'_org_email', true ) : '';
												?>
												<a href="http://addtocalendar.com/atc/google?utz=420&amp;uln=en-US&amp;vjs=1.5&amp;e[0][date_start]=<?php echo esc_html($date_start);?>&amp;e[0][date_end]=<?php echo esc_html($date_end);?>&amp;e[0][timezone]=<?php echo get_option('timezone_string'); ?>&amp;e[0][title]=<?php echo get_the_title();?>&amp;e[0][description]=<?php echo get_the_excerpt();?>&amp;e[0][location]=<?php echo esc_html($address);?>&amp;e[0][organizer]=<?php echo esc_html($organizer_name);?>&amp;e[0][organizer_email]=<?php echo esc_html($organizer_email);?>" target="_blank" rel="nofollow"><?php esc_html_e( '+ Google Calendar', 'ovaem-events-manager' );?></a>

												<a href="http://addtocalendar.com/atc/ical?utz=420&amp;uln=en-US&amp;vjs=1.5&amp;e[0][date_start]=<?php echo esc_html($date_start);?>&amp;e[0][date_end]=<?php echo esc_html($date_end);?>&amp;e[0][timezone]=<?php echo get_option('timezone_string'); ?>&amp;e[0][title]=<?php echo get_the_title();?>&amp;e[0][description]=<?php echo get_the_excerpt();?>&amp;e[0][location]=<?php echo esc_html($address);?>&amp;e[0][organizer]=<?php echo esc_html($organizer_name);?>&amp;e[0][organizer_email]=<?php echo esc_html($organizer_email);?>" target="_blank" rel="nofollow"><?php esc_html_e( '+ Ical Export', 'ovaem-events-manager' );?></a>


											</span>
										</div>
									</div>
								<?php } ?>	







							</div>


						</div>

					</div>
				</div>
			<?php } ?>

			<div class="container">
				<div class="row">
					<div class="col-md-8">

						<div class="content">

							<!-- Content -->
							<?php if( OVAEM_Settings::event_show_content() == 'true' ){ ?>
								<div class="desc">
									<h3 class="title_overview">
										<?php esc_html_e( 'Overview', 'ovaem-events-manager' ); ?>
										<span class="one"></span><span class="two"></span><span class="three"></span><span class="four"></span><span class="five"></span>

									</h3>
									<?php the_content(); ?>
								</div>
							<?php } ?>

							<?php if ( ! post_password_required() ) { ?>
								<div class="row">
									<?php if( OVAEM_Settings::event_show_tag() == 'true' ){ ?>
										<div class="col-md-12">
											<!-- Tags -->
											<div class="tags">
												<?php do_action('ovaem_event_tag');  ?>	
											</div>	
										</div>
									<?php } ?>




								</div>
							<?php } ?>

						</div>

						<?php if ( ! post_password_required() ) { ?>

							<!-- Tabs -->
							<?php 
							$event_show_schedule_tab = OVAEM_Settings::event_show_schedule_tab() == 'true';
							$event_show_speaker_tab = OVAEM_Settings::event_show_speaker_tab() == 'true';
							$event_show_ticket_tab = OVAEM_Settings::event_show_ticket_tab() == 'true';
							$event_show_ticket_tab_expired = OVAEM_Settings::event_show_ticket_tab_expired() == 'true';
							$event_show_comments = OVAEM_Settings::event_show_comments() == 'true';

							$contact_shortcode = get_post_meta( get_the_id(), $prefix.'_contact_event', true );
							?>
							<?php if( $event_show_schedule_tab == 'true' || $event_show_speaker_tab == 'true' || $event_show_ticket_tab == 'true' || $event_show_comments == 'true' ){ ?>
								<div class="tab_content" id="event_tab">
									<div class="wrap_nav">
										<ul class="nav">

											<?php if( $event_show_ticket_tab == 'true' ){  ?>
												<?php if( ( $end_time <= current_time( 'timestamp' ) && $event_show_ticket_tab_expired == 'true' ) || ( $end_time > current_time( 'timestamp' ) ) ){ ?>
													<li class="ticket">
														<a data-toggle="tab" href="#ticket"><?php echo esc_html($label_ticket); ?><span class="one"></span><span  class="two"></span><span  class="three"></span></a>
													</li>
												<?php } 
											} ?>

											<?php if( $event_show_schedule_tab == 'true' && $schedule_parent ){  ?>
												<li>
													<a data-toggle="tab" href="#schedule"><?php echo esc_html($label_schedule); ?><span class="one"></span><span  class="two"></span><span  class="three"></span>	</a>
												</li>
											<?php } ?>

											<?php if( $event_show_speaker_tab == 'true' && $speakers_slug && $schedule_parent ){  ?>
												<li>
													<a data-toggle="tab" href="#speaker"><?php echo esc_html($label_speaker); ?><span class="one"></span><span  class="two"></span><span  class="three"></span></a>
												</li>
											<?php } ?>

											<?php if( OVAEM_Settings::event_show_contact() == 'true' && $contact_shortcode != '' ){ ?>
												<li>
													<a data-toggle="tab" href="#event_contact"><?php echo esc_html($label_contact); ?><span class="one"></span><span  class="two"></span><span  class="three"></span></a>
												</li>
											<?php } ?>

										</ul>
									</div>
									<div class="tab-content">

										<?php if( $event_show_ticket_tab == 'true' ){  ?>
											<?php if( ( $end_time <= current_time( 'timestamp' ) && $event_show_ticket_tab_expired == 'true' ) || ( $end_time > current_time( 'timestamp' ) ) ){ ?>
												<div id="ticket" class="tab-pane fade ">
													<div class="row">
														<?php do_action('ovaem_event_ticket'); ?>
													</div>
												</div>
											<?php } 
										} ?>

										<!-- Schedule -->
										<?php if( $event_show_schedule_tab == 'true' && $schedule_parent  ){  ?>
											<div id="schedule" class="tab-pane fade">
												<?php do_action('ovaem_event_schedule'); ?>
											</div>
										<?php } ?>

										<?php if( $event_show_speaker_tab == 'true' && $speakers_slug && $schedule_parent ){  ?>
											<div id="speaker" class="tab-pane fade">
												<?php do_action( 'ovaem_event_speaker' ); ?>
											</div>
										<?php } ?>

										<?php if( OVAEM_Settings::event_show_contact() == 'true' && $contact_shortcode != '' ){ ?>
											<div id="event_contact" class="tab-pane fade ">
												<div class="row">
													<h3 class="title_overview">
														<?php esc_html_e( 'Comments', 'ovaem-events-manager' ); ?>
														<span class="one"></span><span class="two"></span><span class="three"></span><span class="four"></span><span class="five"></span>

													</h3>

													<?php echo do_shortcode( $contact_shortcode ); ?>
												</div>
											</div>
										<?php } ?>

									</div>
								</div>

							<?php } ?>

						<?php } ?>

						<div class="clearfix"></div>
						<?php if ( ( comments_open() || get_comments_number() ) && OVAEM_Settings::event_show_comments() == 'true' ) { ?>
							<div id="event_comments">

								<?php comments_template(); ?>

							</div>
						<?php } ?>

					</div>

					<div class="col-md-4">

						<?php if ( ! post_password_required() ) { ?>

							<!-- Message -->
							<?php if( $start_time!= '' && $end_time!= '' && OVAEM_Settings::event_show_notify() == 'true' ){ ?>
								<?php if( $end_time <= current_time( 'timestamp' ) ){ ?>
									<div class="mb-2 bg-info text-white">
										<?php esc_html_e("The event is expired", "ovaem-events-manager") ?>
									</div>
									<br>
								<?php	}else if( $start_time < current_time( 'timestamp' ) && $end_time >= current_time( 'timestamp' ) ){ ?>
									<div class="mb-2 bg-info text-white">
										<?php esc_html_e("The event is in time", "ovaem-events-manager"); ?>
									</div>
									<br>
								<?php	} ?>
							<?php } ?>



						<?php } ?>	

						<?php if ( ! post_password_required() ) { ?>


							<div class="single_event_right_info">




								<!-- Event Detail -->
								<?php if( $event_show_map != 'no' && $ovaem_map_lat != '' && $ovaem_map_lng != '' ){ ?>
									<div class="event_widget event_info">


										<div class="wrap_event_widget">
											<!-- time -->
											<div class="time">
												<?php $event_map_zoom = OVAEM_Settings::event_map_zoom(); ?>
												<div class="clearfix">
													<div id="ovaem_map" class="ovaem_map" data-lat="<?php echo esc_attr($ovaem_map_lat); ?>" data-lng="<?php echo esc_attr($ovaem_map_lng); ?>" data-zoom="<?php echo esc_attr($event_map_zoom); ?>" data-address="<?php echo esc_attr($map_address); ?>"></div>
													<?php if( OVAEM_Settings::event_show_map_btn() == 'yes' ){ ?>
														<div class="get_direction_map">
															<a class="btn ova-btn text-center" href="https://maps.google.com?saddr=Current+Location&daddr=<?php echo esc_attr($ovaem_map_lat); ?>,<?php echo esc_attr($ovaem_map_lng); ?>" target="_blank" ><i class="fa fa-location-arrow"></i><?php esc_html_e( 'Get Direction', 'ovaem-events-manager' ); ?> </a>
														</div>
													<?php } ?>

												</div>
											</div>

										</div>
									</div>
								<?php } ?>

								<?php if( !empty( $content_sidebar ) && OVAEM_Settings::event_show_extra_info() == 'true' ){ ?>
									<div class="event_widget extra_info">
										<h3 class="title">
											<?php echo esc_html($label_sidebar); ?>
											<span class="one"></span><span  class="two"></span><span  class="three"></span><span  class="four"></span><span  class="five"></span>
											<i class="icon_document_alt"></i>
										</h3>

										<div class="wrap_event_widget">
											<?php echo do_shortcode( $content_sidebar ); ?>		
										</div>
									</div>
								<?php } ?>




								<?php if( OVAEM_Settings::event_show_organizer() == 'true' ){
									do_action( 'ovaem_event_organizer' );	
								} ?>

								<?php if( OVAEM_Settings::event_show_sponsors() == 'true' ){
									do_action( 'ovaem_event_sponsor' );
								} ?>





							</div>
						<?php } ?>

					</div>
				</div>
			</div>
		<?php endwhile; endif; wp_reset_postdata(); ?>



		<?php if ( ! post_password_required() ) { ?>
			<?php 
			if( OVAEM_Settings::event_show_related() == 'true' ){
				do_action('ovaem_event_related');
			} ?>	
		<?php } ?>


	</div>
</div>

<?php get_footer( );
