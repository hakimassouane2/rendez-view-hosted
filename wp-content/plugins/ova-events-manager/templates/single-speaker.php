<?php if ( !defined( 'ABSPATH' ) ) exit();

get_header( );
$show_status_event = OVAEM_Settings::archives_event_show_status();
?>	

<div class="ovaem_single_speaker">
	<div class="container">
		<div class="row">

			<?php	$prefix = OVAEM_Settings::$prefix;
			$date_format = get_option('date_format');
			
			if( have_posts() ): while( have_posts() ): the_post(); global $post; ?>
				
				<?php 
				$social = get_post_meta( get_the_id(), $prefix.'_speaker_social', false );
				$speaker_phone = get_post_meta( get_the_id(), $prefix.'_speaker_phone', true );
				$speaker_mail = get_post_meta( get_the_id(), $prefix.'_speaker_mail', true );
				$speaker_address = get_post_meta( get_the_id(), $prefix.'_speaker_address', true );
				$speaker_website = get_post_meta( get_the_id(), $prefix.'_speaker_website', true );
				$speaker_phone_sanitize = preg_replace('/[^0-9]/', '', $speaker_phone );
				?>

				<div class="content">

					<div class="col-md-4 ova_thumbnail ">

						<?php the_post_thumbnail(); ?>		

					</div>

					<div class="col-md-8 ova_info">

						<h2 class="title"><?php the_title(); ?></h2>

						<div class="job">
							<?php echo get_post_meta( get_the_id(), $prefix.'_speaker_job', true ); ?>
						</div>

						<div class="desc">
							<?php the_content(); ?>
						</div>

						<?php if( $speaker_phone ){ ?>
							<div class="speaker_info">
								<label><i class="icon_phone"></i></label>
								<a href="<?php echo esc_attr('tel:'.$speaker_phone_sanitize); ?>"><?php echo esc_html( $speaker_phone ); ?></a>
							</div>
						<?php } ?>

						<?php if( $speaker_mail ){ ?>
							<div class="speaker_info">
								<label><i class="icon_mail_alt"></i></label>
								<a href="<?php echo esc_attr('mailto:'.$speaker_mail); ?>"><?php echo esc_html( $speaker_mail ); ?></a>
							</div>
						<?php } ?>

						<?php if( $speaker_address ){ ?>
							<div class="speaker_info">
								<label><i class="icon_pin_alt"></i></label>
								<?php echo $speaker_address; ?>
							</div>
						<?php } ?>

						<?php if( $speaker_website ){ ?>
							<div class="speaker_info">
								<label><i class="icon_globe-2"></i></label>
								<a href="<?php echo esc_attr( $speaker_website ); ?>" target="_blank"><?php echo esc_html($speaker_website); ?></a>
							</div>
						<?php } ?>

						<?php if( $social[0]  ){ ?>
							<div class="social_speaker speaker_info">
								<label><i class="social_share"></i></label>
								<?php foreach ($social[0] as $key => $value) { ?>
									<a href="<?php echo $value['link']; ?>" target="_blank"><i class="<?php echo $value['fontclass']; ?>"></i></a>
									
								<?php } ?>
							</div>
						<?php } ?>

					</div>

				</div>

				<?php if( OVAEM_Settings::speaker_joined_event_show() == 'true' ){ 
					$events = apply_filters( 'ovaem_get_events_by_speaker', $post->post_name ); 
					if( $events->have_posts() ): ?>

						<div class="joined">
							<h3 class="title"><?php esc_html_e( "Events Joined", "ovaem-events-manager" ); ?></h3>

							<div class="ovaem_events_filter"><div class="ovaem_events_filter_content"><div class="speaker_joined_event owl-carousel owl-theme">

								<?php while( $events->have_posts() ): $events->the_post(); ?>

									<?php 	$venue_slug = get_post_meta( get_the_id(), $prefix.'_venue', true);
									if( $venue_slug ){
										$venue_detail = get_page_by_path( $venue_slug, OBJECT, OVAEM_Settings::venue_post_type_slug() );
										$venue_title = $venue_detail->post_title;	
									}else{
										$venue_title = '';
									}

									?>

									<div class="ova-item style3">
										<div class="ova_thumbnail">

											<?php 
											$d_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
											$m_img  = wp_get_attachment_image_url( get_post_thumbnail_id(), 'm_img' );

											?>
											<img alt="<?php the_title(); ?>" src="<?php echo esc_url($d_img); ?>" 
												srcset="<?php echo esc_url($d_img).' 1200w'; ?>,
												<?php echo esc_url($m_img).' 767w'; ?>" 
												sizes="(max-width: 767px) 100vw, 600px" >

											
											
											<?php
											$end_time 			= get_post_meta( get_the_id(), $prefix.'_date_end_time', true );
											$start_time 		= get_post_meta( get_the_id(), $prefix.'_date_start_time', true);
											$check_status_event = apply_filters( 'ovaem_check_status_event', $start_time, $end_time );
											$check_pass_time 	= current_time( 'timestamp' ) < $end_time ? true : false;
											?>

											<?php if( $start_time ){ ?>
												<div class="date">
													<span class="month"><?php echo date_i18n($date_format, $start_time); ?></span>
												</div>
											<?php } ?>

											<div class="venue">
												<span><i class="icon_pin_alt"></i></span>
												<?php echo esc_html($venue_title); ?>
											</div>
											<div class="time">
												<span class="price">
													<?php
													$tickets_arr = get_post_meta( get_the_id(), $prefix.'_ticket', true );
													$price = apply_filters( 'ovaem_get_price', $tickets_arr );

													?>
													<span><?php echo $price; ?></span>
												</span>
											</div>
										</div>
										<div class="wrap_content">
											<h2 class="title">
												<a href="<?php echo get_the_permalink(); ?> "><?php the_title(); ?> </a>
											</h2>
											<div class="except"><?php the_excerpt(); ?></div>
											
											<?php if ( $check_pass_time ): ?>
												<div class="more_detail">
													<a class="btn_link" href="<?php echo get_the_permalink(); ?>"><?php esc_html_e( 'Get ticket', 'ovaem-events-manager' ); ?><i class="arrow_right"></i></a>
												</div>
											<?php endif; ?>
											
											<?php if( $show_status_event == 'true' ){ ?>
												<div class="status">
													<?php echo wp_kses( $check_status_event, true); ?>
												</div>
											<?php } ?>
										</div>
									</div>

								<?php endwhile; ?>

							</div></div></div>	

						</div>

					<?php endif; wp_reset_postdata(); ?>
				<?php } ?>

				

			<?php endwhile;endif; wp_reset_postdata(); ?>

		</div>
	</div>		
</div>

<?php get_footer( );
