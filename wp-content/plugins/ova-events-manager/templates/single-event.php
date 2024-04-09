<?php if ( !defined( 'ABSPATH' ) ) exit();

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

$venue_title = $ovaem_map_lat = $ovaem_map_lng = $map_address = $show_map = '';

// Get Label
$label_schedule = get_post_meta( $id, $prefix.'_label_schedule', true) ? get_post_meta( $id, $prefix.'_label_schedule', true) : esc_html__( 'Schedule', 'ovaem-events-manager' );
$label_speaker  = get_post_meta( $id, $prefix.'_label_speaker', true) ? get_post_meta( $id, $prefix.'_label_speaker', true) : esc_html__( 'Speaker', 'ovaem-events-manager' );
$label_ticket   = get_post_meta( $id, $prefix.'_label_ticket', true) ? get_post_meta( $id, $prefix.'_label_ticket', true) : esc_html__( 'Ticket & Price', 'ovaem-events-manager' );
$label_contact  = get_post_meta( $id, $prefix.'_label_contact', true) ? get_post_meta( $id, $prefix.'_label_contact', true) : esc_html__( 'Contact', 'ovaem-events-manager' );
$label_sidebar  = get_post_meta( $id, $prefix.'_label_sidebar', true) ? get_post_meta( $id, $prefix.'_label_sidebar', true) : esc_html__( 'Extra Info', 'ovaem-events-manager' );
$label_comment  = get_post_meta( $id, $prefix.'_label_comment', true) ? get_post_meta( $id, $prefix.'_label_comment', true) : esc_html__( 'Comments', 'ovaem-events-manager' );
$label_faq  = get_post_meta( $id, $prefix.'label_faq', true) ? get_post_meta( $id, $prefix.'label_faq', true) : esc_html__( 'FAQ', 'ovaem-events-manager' );


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
			$venue_title = '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';	
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


$tickets = get_post_meta( get_the_id(), $prefix.'_ticket', true );

?>

<div class="grey_bg ova_single_event">
	<div class="container">
		<div class="row">

			<?php if( have_posts() ): while( have_posts() ): the_post(); ?>

				<div class="col-md-8">

					<div class="content">

						<?php if ( ! post_password_required() ) { ?>

							<!-- Message -->
							<!-- <?php if( $start_time!= '' && $end_time!= '' && OVAEM_Settings::event_show_notify() == 'true' ){ ?>
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
							<?php } ?> -->

							<!-- Gallery, Thumbnail -->
							<?php if( OVAEM_Settings::event_show_gallery() == 'true' ){ ?>
								<div class="gallery">
									<?php 
									if( get_post_meta( get_the_id(), 'ovaem_gallery_id', true) ){
											// Gallery
										do_action( 'ovaem_event_gallery' );	
									}else if( has_post_thumbnail() ) {
											// Thumbnail
										do_action( 'ovaem_event_thumbnail' );	
									}

									?>
								</div>
							<?php } ?>

						<?php } ?>

						
						
						<!-- Content -->
						<?php if( OVAEM_Settings::event_show_content() == 'true' ){ ?>
							<div class="desc">
								<?php
								if ( get_the_content() ) {
									the_content();
								}
								
								?>
							</div>
						<?php } ?>

						
						<?php if ( ! post_password_required() ) { ?>
							<div class="row">
								<?php if( OVAEM_Settings::event_show_tag() == 'true' ){ ?>
									<div class="col-md-7">
										<!-- Tags -->
										<div class="tags">
											<?php do_action('ovaem_event_tag');  ?>	
										</div>	
									</div>
								<?php } ?>
								

								<?php if( OVAEM_Settings::event_show_share_social() == 'true' ){ ?>
									<div class="col-md-5">
										<!-- Socials -->
										<div class="social">
											<span><i class="social_share"></i> <?php esc_html_e( 'Share', 'ovaem-events-manager' ); ?></span>
											<?php do_action( 'ovaem_event_social' ); ?>
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

						$event_show_faq = OVAEM_Settings::event_show_faq() == 'true';
						$event_faq_title = get_post_meta( get_the_id(), $prefix.'_faq_title', true );

						$contact_shortcode = get_post_meta( get_the_id(), $prefix.'_contact_event', true );
						?>
						<?php if( $event_show_schedule_tab == 'true' || $event_show_speaker_tab == 'true' || $event_show_ticket_tab == 'true' || $event_show_comments == 'true' || $event_show_faq ){ ?>
							<div class="tab_content" id="event_tab">
								<div class="wrap_nav">
									<ul class="nav">

										<?php if( $event_show_schedule_tab == 'true' && $schedule_parent ){  ?>
											<li class="<?php echo esc_attr( OVAEM_Settings::event_scroll_tab() == 'schedule' ? 'schedule' : '' ); ?>">
												<a data-toggle="tab" href="#schedule"><?php echo esc_html($label_schedule); ?><span class="one"></span><span  class="two"></span><span  class="three"></span>	</a>
											</li>
										<?php } ?>

										<?php if( $event_show_speaker_tab == 'true' && $speakers_slug && $schedule_parent ){  ?>
											<li class="<?php echo esc_attr( OVAEM_Settings::event_scroll_tab() == 'speaker' ? 'speaker' : '' ); ?>">
												<a data-toggle="tab" href="#speaker"><?php echo esc_html($label_speaker); ?><span class="one"></span><span  class="two"></span><span  class="three"></span></a>
											</li>
										<?php } ?>

										<?php if( $event_show_ticket_tab == 'true' && $tickets != '' ){  ?>
											<?php if( ( $end_time <= current_time( 'timestamp' ) && $event_show_ticket_tab_expired == 'true' ) || ( $end_time > current_time( 'timestamp' ) ) ){ ?>
												<li class="<?php echo esc_attr( OVAEM_Settings::event_scroll_tab() == 'ticket' ? 'ticket' : '' ); ?>">
													<a data-toggle="tab" href="#ticket"><?php echo esc_html($label_ticket); ?><span class="one"></span><span  class="two"></span><span  class="three"></span></a>
												</li>
											<?php } 
										} ?>

										<?php if( $event_show_faq == 'true' && $event_faq_title != '' ){ ?>
											<li class="<?php echo esc_attr( OVAEM_Settings::event_scroll_tab() == 'event_faq' ? 'event_faq' : '' ); ?>">
												<a data-toggle="tab" href="#event_faq"><?php echo esc_html($label_faq); ?><span class="one"></span><span  class="two"></span><span  class="three"></span></a>
											</li>
										<?php } ?>

										<?php if ( ( comments_open() || get_comments_number() ) && OVAEM_Settings::event_show_comments() == 'true' ) { ?>
											<li class="<?php echo esc_attr( OVAEM_Settings::event_scroll_tab() == 'event_comments' ? 'event_comments' : '' ); ?>">
												<a data-toggle="tab" href="#event_comments"><?php echo esc_html($label_comment); ?><span class="one"></span><span  class="two"></span><span  class="three"></span></a>
											</li>
										<?php } ?>

										<?php if( OVAEM_Settings::event_show_contact() == 'true' && $contact_shortcode != '' ){ ?>
											<li class="<?php echo esc_attr( OVAEM_Settings::event_scroll_tab() == 'event_contact' ? 'event_contact' : '' ); ?>">
												<a data-toggle="tab" href="#event_contact"><?php echo esc_html($label_contact); ?><span class="one"></span><span  class="two"></span><span  class="three"></span></a>
											</li>
										<?php } ?>

										

									</ul>
								</div>
								<div class="tab-content">

									<!-- Schedule -->
									<?php if( $event_show_schedule_tab == 'true' &&  $schedule_parent ){  ?>
										<div id="schedule" class="tab-pane fade">
											<?php do_action('ovaem_event_schedule'); ?>
										</div>
									<?php } ?>

									<?php if( $event_show_speaker_tab == 'true' && $speakers_slug && $schedule_parent ){  ?>
										<div id="speaker" class="tab-pane fade">
											<?php do_action( 'ovaem_event_speaker' ); ?>
										</div>
									<?php } ?>

									<?php if( $event_show_ticket_tab == 'true' && $tickets != '' ){  ?>
										<?php if( ( $end_time <= current_time( 'timestamp' ) && $event_show_ticket_tab_expired == 'true' ) || ( $end_time > current_time( 'timestamp' ) ) ){ ?>
											<div id="ticket" class="tab-pane fade ">
												<div class="row">
													<?php do_action('ovaem_event_ticket'); ?>
												</div>
											</div>
										<?php } 
									} ?>

									<?php if( $event_show_faq == 'true' && $event_faq_title != '' ){ ?>
										<div id="event_faq" class="tab-pane fade ">
											<div class="row">
												<?php do_action('ovaem_event_faq'); ?>
											</div>
										</div>
									<?php } ?>

									<?php if ( ( comments_open() || get_comments_number() ) && OVAEM_Settings::event_show_comments() == 'true' ) { ?>
										<div id="event_comments" class="tab-pane fade ">
											<div class="row">
												<?php comments_template(); ?>
											</div>
										</div>
									<?php } ?>

									<?php if( OVAEM_Settings::event_show_contact() == 'true' && $contact_shortcode != '' ){ ?>
										<div id="event_contact" class="tab-pane fade ">
											<div class="row">
												<?php echo do_shortcode( $contact_shortcode ); ?>
											</div>
										</div>
									<?php } ?>

								</div>
							</div>

						<?php } ?>

					<?php } ?>

				</div>

				<div class="col-md-4">

					<?php if ( ! post_password_required() ) { ?>

						<?php $btn_show_book = OVAEM_Settings::event_show_book_now() == 'true' ? 'has_btn_book' : ''; ?>
						<div class="single_event_right_info <?php echo esc_attr( $btn_show_book ); ?>">

							<?php  $flag_show_btn = false;

								if( OVAEM_Settings::event_show_book_now() == 'true' && $tickets != '' ){

									$flag_show_btn = true;

									if( $end_time > current_time( 'timestamp' ) ){
										$flag_show_btn = true;    
									}else{
										$flag_show_btn = false;
									}

									if( OVAEM_Settings::event_show_book_now_event_past() == 'true' ){
										$flag_show_btn = true;
									}

								}

								if( $flag_show_btn  ){ ?>

									<?php if( count($tickets) == 1 && $tickets[0]['pay_method'] == 'outside' ){ ?>

										<div class="wrap_btn_book external_link">
											<a class="book_now_btn" target="_blank" href="<?php echo esc_url( $tickets[0]['outside'] ); ?>">
												<?php esc_html_e( 'Register Event Now', 'ovaem-events-manager' ); ?>
											</a>
										</div>

									<?php }else{ ?>

										<div class="wrap_btn_book " data-tab-active="<?php echo esc_attr( OVAEM_Settings::event_scroll_tab() ); ?>">
											<a class="book_now_btn" href="#"><?php esc_html_e( 'Register Event Now', 'ovaem-events-manager' ); ?></a>
										</div>
									<?php } ?>

									

								<?php } ?>


							<!-- Event Detail -->
							<div class="event_widget event_info">

								<h3 class="title">
									<?php esc_html_e( 'Event Detail', 'ovaem-events-manager' ); ?>
									<span class="one"></span><span  class="two"></span><span  class="three"></span><span  class="four"></span><span  class="five"></span>
									<i class="icon_document_alt"></i>
								</h3>

								<div class="wrap_event_widget">
									<!-- time -->
									<div class="time">

										<?php if( $start_time != '' && OVAEM_Settings::event_show_startdate() == 'true' ){ ?>
											<div class="clearfix event_row">
												<label><?php esc_html_e( 'Start Date: ', 'ovaem-events-manager' ); ?></label>
												<span><?php echo date_i18n($date_format.' '.$time_format, $start_time); ?></span>
											</div>
										<?php } ?>

										<?php if( $end_time != '' && OVAEM_Settings::event_show_enddate() == 'true' ){ ?>
											<div class="clearfix event_row">
												<label><?php esc_html_e( 'End Date: ', 'ovaem-events-manager' ); ?></label>
												<span><?php echo date_i18n($date_format.' '.$time_format, $end_time); ?></span>
											</div>
										<?php } ?>

										<?php if( $room && OVAEM_Settings::event_show_room() == 'true' ){ ?>
											<div class="clearfix event_row">
												<label><?php esc_html_e( 'Room: ', 'ovaem-events-manager' ); ?></label>
												<span><?php echo $room; ?></span>
											</div>
										<?php } ?>

										<?php if( $venue_title && OVAEM_Settings::event_show_venue() == 'true' ){ ?>
											<div class="clearfix event_row">
												<label><?php esc_html_e( 'Venue: ', 'ovaem-events-manager' ); ?></label>
												<span><?php echo $venue_title; ?></span>
											</div>
										<?php } ?>

										<?php if( OVAEM_Settings::event_show_address() == 'true' && $address ){ ?>
											<div class="clearfix event_row">
												<label>
													<?php esc_html_e( 'Address: ', 'ovaem-events-manager' ); ?>
												</label>
												<span><?php echo $address; ?></span>
											</div>
										<?php } ?>

										<?php if( $event_show_map != 'no' && $ovaem_map_lat != '' && $ovaem_map_lng != '' ){ 
											$event_map_zoom = OVAEM_Settings::event_map_zoom();
											?>

											<div class="clearfix">
												<label><?php esc_html_e( 'Map: ', 'ovaem-events-manager' ); ?></label>
												<div id="ovaem_map" class="ovaem_map" data-lat="<?php echo esc_attr($ovaem_map_lat); ?>" data-lng="<?php echo esc_attr($ovaem_map_lng); ?>" data-zoom="<?php echo esc_attr($event_map_zoom); ?>" data-address="<?php echo esc_attr($map_address); ?>"></div>

												<?php if( OVAEM_Settings::event_show_map_btn() == 'yes' ){ ?>
													<div class="get_direction_map">
														<a class="btn ova-btn text-center" href="https://maps.google.com?saddr=Current+Location&daddr=<?php echo esc_attr($ovaem_map_lat); ?>,<?php echo esc_attr($ovaem_map_lng); ?>" target="_blank" ><i class="fa fa-location-arrow"></i><?php esc_html_e( 'Get Direction', 'ovaem-events-manager' ); ?> </a>
													</div>
												<?php } ?>

											</div>
										<?php } ?>

										<?php if( OVAEM_Settings::event_show_ical() == 'true' ){ ?>
											<div class="event-calendar-sync">
												<span class="sync">
													<?php 
													$date_start =  $start_time ? date('m/d/y H:i', $start_time ) : '';
													$date_end = $end_time ? date('m/d/y H:i', $end_time ) : '';
													$organizer_name = get_post_meta( $id, $prefix.'_org_name', true ) ? get_post_meta( $id, $prefix.'_org_name', true ) : '';
													$organizer_email = get_post_meta( $id, $prefix.'_org_email', true ) ? get_post_meta( $id, $prefix.'_org_email', true ) : '';
													?>
													<a href="http://addtocalendar.com/atc/google?utz=420&amp;uln=en-US&amp;vjs=1.5&amp;e[0][date_start]=<?php echo esc_html($date_start);?>&amp;e[0][date_end]=<?php echo esc_html($date_end);?>&amp;e[0][timezone]=<?php echo get_option('timezone_string'); ?>&amp;e[0][title]=<?php echo get_the_title();?>&amp;e[0][description]=<?php echo get_the_excerpt();?>&amp;e[0][location]=<?php echo esc_html($address);?>&amp;e[0][organizer]=<?php echo esc_html($organizer_name);?>&amp;e[0][organizer_email]=<?php echo esc_html($organizer_email);?>" target="_blank" rel="nofollow"><?php esc_html_e( '+ Google Calendar', 'ovaem-events-manager' );?></a>

													<a href="http://addtocalendar.com/atc/ical?utz=420&amp;uln=en-US&amp;vjs=1.5&amp;e[0][date_start]=<?php echo esc_html($date_start);?>&amp;e[0][date_end]=<?php echo esc_html($date_end);?>&amp;e[0][timezone]=<?php echo get_option('timezone_string'); ?>&amp;e[0][title]=<?php echo get_the_title();?>&amp;e[0][description]=<?php echo get_the_excerpt();?>&amp;e[0][location]=<?php echo esc_html($address);?>&amp;e[0][organizer]=<?php echo esc_html($organizer_name);?>&amp;e[0][organizer_email]=<?php echo esc_html($organizer_email);?>" target="_blank" rel="nofollow"><?php esc_html_e( '+ Ical Export', 'ovaem-events-manager' );?></a>


												</span>
											</div>
										<?php } ?>

									</div>

								</div>


							</div>


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

			<?php endwhile;
		endif; wp_reset_postdata(); ?>

	</div>
</div>


<?php if ( ! post_password_required() ) { ?>
	<?php 
	if( OVAEM_Settings::event_show_related() == 'true' ){
		do_action('ovaem_event_related');
	} ?>	
<?php } ?>


<?php do_action( 'ovaem_single_event_schema' ); ?>

</div>

<?php get_footer( );
