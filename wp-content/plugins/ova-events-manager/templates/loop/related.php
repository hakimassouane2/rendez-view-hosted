<?php if ( !defined( 'ABSPATH' ) ) exit();

$prefix = OVAEM_Settings::$prefix;
$date_format = get_option('date_format');
$time_format = get_option('time_format');
$event_slug = OVAEM_Settings::event_post_type_slug();

$show_status_event = OVAEM_Settings::archives_event_show_status();

$events_related = $vanue_title = '';

if( is_singular( $event_slug ) ){

	$events_related  = apply_filters( 'ovaem_get_related_events', get_the_id() );

}else if( is_singular( OVAEM_Settings::venue_post_type_slug() ) ){
	global $post;
	$events_related = apply_filters( 'ovaem_get_venue_joined_event', $post->post_name );
}



if( $events_related ->have_posts() ): ?>
	<div class="event_single_related">
		<div class="container">

			<div class="ova_heading_v2 white">
				<div class="wrap_title">
					<?php if( is_singular( $event_slug ) ){ ?>

						<h3 class="title"><?php esc_html_e( 'related events', 'ovaem-events-manager' ); ?></h3>

					<?php }else if( is_singular( OVAEM_Settings::venue_post_type_slug() ) ){  ?>

						<h3 class="title"><?php esc_html_e( 'Events in this venue', 'ovaem-events-manager' ); ?></h3>

					<?php } ?>
				</div>
				<div class="sub_title"><?php esc_html_e( 'May You like', 'ovaem-events-manager' ); ?>
				<span class="one"></span><span class="two"></span><span class="three"></span>
			</div>
		</div>

		<div class="ovaem_events_filter">
			<div class="ovaem_events_filter_content">
				<div class="related_events owl-carousel owl-theme">

					<?php while( $events_related->have_posts() ): $events_related->the_post(); ?>

						<?php 	$venue_slug = get_post_meta( get_the_id(), $prefix.'_venue', true);
						$venue_detail = get_page_by_path( $venue_slug, OBJECT, OVAEM_Settings::venue_post_type_slug() );
						if( $venue_detail ){
							$vanue_title = $venue_detail->post_title;	
						}

						?>

						<div class="ova-item style3">

							<a href="<?php the_permalink(); ?> ">
								<div class="ova_thumbnail">

									<?php
										$d_img  = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
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
										<?php echo esc_html( sub_string_word( $vanue_title, OVAEM_Settings::ovaem_number_character_venue() ) ); ?>
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
							</a>

							<div class="wrap_content">
								<h2 class="title">
									<a href="<?php echo get_the_permalink(); ?> "><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?> </a>
								</h2>
								<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
								<?php if ( $check_pass_time ): ?>
									<div class="more_detail">
										<a class="btn_link" href="<?php echo get_the_permalink(); ?>"><?php esc_html_e( 'Get ticket', 'ovaem-events-manager' ); ?><i class="arrow_right"></i></a>
									</div>
								<?php endif; ?>
								<?php if( $show_status_event == 'true' ){ ?>
									<div class="status"><?php echo wp_kses( $check_status_event, true); ?></div>
								<?php } ?>
							</div>
						</div>

					<?php endwhile; wp_reset_postdata();  ?>

				</div>
			</div>
		</div>
	</div>
</div>

<?php endif;  ?>	