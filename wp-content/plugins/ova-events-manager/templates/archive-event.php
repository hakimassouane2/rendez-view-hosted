<?php if ( !defined( 'ABSPATH' ) ) exit();

get_header( );

$prefix = OVAEM_Settings::$prefix;

$archive_orderby = OVAEM_Settings::archives_event_orderby();
$archive_order = OVAEM_Settings::archives_event_order();
$show_past = OVAEM_Settings::archives_event_show_past();

$day_format = OVAEM_Settings::ovaem_day_format();
$month_format = OVAEM_Settings::ovaem_month_format();
$year_format = OVAEM_Settings::ovaem_year_format();

$get_search = isset( $_GET["search"] ) ? $_GET["search"] : '';

$archives_event_style = isset( $_GET["type"] ) ? $_GET["type"] : OVAEM_Settings::archives_event_style();
$archives_event_style_grid = OVAEM_Settings::archives_event_style_grid();

$style_grid = isset( $_GET["style_grid"] ) ? $_GET["style_grid"] : $archives_event_style_grid;
$row_class = ( $style_grid != 'style4' ) ? 'row': '';
$m = 0;
$l = 0;

$col = ( $archives_event_style == 'grid_sidebar' ) ? 'col-md-6 col-sm-6' : 'col-md-4 col-sm-6';

$show_status_event = OVAEM_Settings::archives_event_show_status();
$show_get_ticket = OVAEM_Settings::archives_event_show_get_ticket();



$event_categories = OVAEM_Settings::slug_taxonomy_name();

if( $get_search == 'search-event' ){ /* Search Event */

	$events = apply_filters( 'ovaem_search_event', $_REQUEST );

}else if( get_query_var( $event_categories ) != '' ){ /* Event Category */

	$events = apply_filters( 'ovaem_events_by_cat', get_query_var( $event_categories ), $archive_orderby, $archive_order, $show_past );

}else if( get_query_var( 'event_tags' ) != '' ){ /* Event Tag */

	$events = apply_filters( 'ovaem_events_by_tag', get_query_var( 'event_tags' ) , $archive_orderby, $archive_order, $show_past );


}else if( is_page_template( 'templates/upcoming-event.php' ) ) { /* Upcoming Event */
	
	$events = apply_filters( 'ovaem_upcoming_past_featured_event', 'upcomming', $archive_orderby, $archive_order, $show_past );	
	
}else if( is_page_template( 'templates/past-event.php' ) ) { /* Past Event */
	
	$events = apply_filters( 'ovaem_upcoming_past_featured_event', 'past', $archive_orderby, $archive_order = 'DESC', $show_past='true' );	
	
}else if( is_page_template( 'templates/featured-event.php' ) ) { /* Featured Event */
	
	$events = apply_filters( 'ovaem_upcoming_past_featured_event', 'featured', $archive_orderby, $archive_order, $show_past );	

}else if( is_page_template( 'templates/events.php' ) ) { /* Archive Event */
	
	$events = apply_filters( 'ovaem_archive_event', $archive_orderby, $archive_order, $show_past );	
	
}elseif( get_query_var( 'location' ) != '' || is_tax( 'location' )  ){
	
	$events = apply_filters( 'ovaem_location_event', get_query_var( 'location' ), $archive_orderby, $archive_order, $show_past );

}else{ /* Archive Events */
	
	$events = apply_filters( 'ovaem_archive_event', $archive_orderby, $archive_order, $show_past );

}

?>

<!-- search -->
<div class="ovaem_archives_event <?php echo esc_attr($archives_event_style); ?>">

	<?php if( $archives_event_style != 'list_sidebar' && $archives_event_style != 'grid_sidebar' ){ ?>

		<?php 
		$show_name = OVAEM_Settings::search_name();
		$show_cat = OVAEM_Settings::search_cat();
		$show_venue = OVAEM_Settings::search_venue();
		$show_time = OVAEM_Settings::search_time();
		$show_date = OVAEM_Settings::search_date();

		$show_today = OVAEM_Settings::search_time_today();
		$show_tomorrow = OVAEM_Settings::search_time_tomorrow();
		$show_this_week = OVAEM_Settings::search_time_this_week();
		$show_this_week_end = OVAEM_Settings::search_time_this_week_end();
		$show_next_week = OVAEM_Settings::search_time_next_week();
		$show_next_month = OVAEM_Settings::search_time_next_month();
		$show_past = OVAEM_Settings::search_time_past();
		$show_future = OVAEM_Settings::search_time_future();

		$show_country = OVAEM_Settings::search_event_show_states();
		$show_city = OVAEM_Settings::search_event_show_cities();
		$date_format = 'd M Y';
		?>
		<?php if( $show_name != 'false' || $show_cat != 'false' || $show_venue != 'false' || $show_time != 'false' || $show_date != 'false' ){ ?>
			<div class="ovaem_search">
				<div class="container">
					<?php echo do_shortcode('[ovaem_search_one show_name="'.$show_name.'" show_cat="'.$show_cat.'" show_venue="'.$show_venue.'" show_time="'.$show_time.'" show_date="'.$show_date.'" show_today="'.$show_today.'" show_tomorrow="'.$show_tomorrow.'" show_this_week="'.$show_this_week.'" show_this_week_end="'.$show_this_week_end.'" show_next_week="'.$show_next_week.'" show_next_month="'.$show_next_month.'" show_past="'.$show_past.'" show_country="'.$show_country.'" show_city="'.$show_city.'" show_future="'.$show_future.'" date_format="'.$date_format.'"  /]'); ?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if( $archives_event_style == 'grid' || $archives_event_style == 'grid_sidebar' ){ ?>
		<div class="container">
			
			<?php if( ( is_tax('categories') || get_query_var( $event_categories ) != '' ) && OVAEM_Settings::archives_event_show_desc_cat() == 'true' ){ ?>
				
					<?php
						$cat_obj = get_term_by( 'slug', get_query_var( $event_categories ), 'categories' );
						if( $cat_obj ){ ?>
							
							<div class="tax_desc">
								<?php echo $cat_obj->description; ?>
							</div>			
						<?php } ?>
				
			<?php } ?>

			<?php if( $archives_event_style == 'grid_sidebar' ){ ?>
				<div class="row"> <!-- Open row -->
					<div class="col-md-8">
						
					<?php } ?>

					<!-- Content -->
					<div class="<?php echo esc_attr($row_class); ?>">
						<div class="ovaem_events_filter">
							<div class="ovaem_events_filter_content">

								<?php if( $events->have_posts() ): while( $events->have_posts() ): $events->the_post();

									$end_time = get_post_meta( get_the_id(), $prefix.'_date_end_time', true );
									$start_time = get_post_meta( get_the_id(), $prefix.'_date_start_time', true );
									$time_m = $start_time ? date_i18n( $month_format, $start_time )  : '';
									$time_d = $start_time ? date_i18n( $day_format.'-'.$year_format, $start_time )  : '';
									$date_format = get_option('date_format');
									$date_by_format = $start_time ? date_i18n( $date_format , $start_time )  : '';

									$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
									// $img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
									$d_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
									$m_img  = wp_get_attachment_image_url( get_post_thumbnail_id(), 'm_img' );


									$venue_slug = get_post_meta( get_the_id(), $prefix.'_venue', true );
									$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );

									$tickets_arr = get_post_meta( get_the_id(), $prefix.'_ticket', true );
									$price = apply_filters( 'ovaem_get_price', $tickets_arr );

									$check_status_event = apply_filters( 'ovaem_check_status_event', $start_time, $end_time );
									$check_pass_time = (int)current_time( 'timestamp' ) < (int)$end_time ? true : false;
									if ( $show_get_ticket != 'false' ) {
										$check_pass_time = true;
									}
									?>

									<?php if( $style_grid == 'style1' ){ ?>

										<div class="<?php echo $col; ?> ova-item style1 ">

											<a href="<?php the_permalink(); ?>">
												<div class="ova_thumbnail">
													<?php if( $d_img ){ ?>
														<img alt="<?php esc_html_e( get_the_title() ); ?>" src="<?php echo esc_url($d_img); ?>" 
														srcset="<?php echo esc_url($d_img).' 1200w'; ?>,
														<?php echo esc_url($m_img).' 767w'; ?>" 
														sizes="(max-width: 767px) 100vw, 600px" >
													<?php } ?>

													<?php if( $venue){ ?>	
														<div class="venue">
															<span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $venue->post_title, OVAEM_Settings::ovaem_number_character_venue() ); ?>
														</div>
													<?php } ?>

													<div class="time">
														<span class="month"><?php echo $time_m; ?></span>
														<span class="date"><?php echo $time_d; ?></span>
														<?php if ( ! empty( $tickets_arr ) ): ?>
															<span class="price"><span><?php echo $price; ?></span></span>
														<?php endif; ?>
													</div>

												</div>
											</a>

											<div class="wrap_content">

												<h2 class="title">
													<a href="<?php the_permalink(); ?>"><?php echo sub_string_word(get_the_title(), OVAEM_Settings::ovaem_number_character_title_event()); ?></a>
												</h2>
												<?php if( $show_status_event == 'true' ){ ?>
													<div class="status">
														<?php echo wp_kses( $check_status_event, true); ?>
													</div>
												<?php } ?>
												<?php
												$the_excerpt = get_the_content() ? get_the_excerpt() : '';
												?>
												<div class="except"><?php echo sub_string_word($the_excerpt, OVAEM_Settings::ovaem_number_character_excerpt()); ?></div>

												<?php if ( $check_pass_time ): ?>
													
													<div class="more_detail">
														<a class="btn_link ova-btn ova-btn-rad-30" href="<?php the_permalink(); ?>">
															<?php if ( empty( $tickets_arr ) ): ?>
																<?php esc_html_e('No ticket', 'ovaem-events-manager'); ?>
															<?php else: ?>
																<?php esc_html_e('Get ticket', 'ovaem-events-manager'); ?>
															<?php endif; ?>
														</a>
													</div>

												<?php endif; ?>

											</div>

										</div>

									<?php } else if( $style_grid == 'style2' ){ ?>

										<div class="<?php echo $col; ?> ova-item style2 ">
											<a href="<?php the_permalink(); ?>">
												<div class="ova_thumbnail">

													<?php if( $d_img ){ ?>	
														<img alt="<?php esc_html_e( get_the_title() ); ?>" src="<?php echo esc_url($d_img); ?>" 
														srcset="<?php echo esc_url($d_img).' 1200w'; ?>,
														<?php echo esc_url($m_img).' 767w'; ?>" 
														sizes="(max-width: 767px) 100vw, 600px" >
													<?php } ?>


													<div class="time">
														<span class="month"><?php echo $time_m; ?></span>
														<span class="date"><?php echo $time_d; ?></span>
													</div>

												</div>
											</a>

											<div class="wrap_content">

												<h2 class="title">
													<a href="<?php the_permalink(); ?>"><?php echo sub_string_word(get_the_title(), OVAEM_Settings::ovaem_number_character_title_event()); ?></a>
												</h2>
												<?php
												$the_excerpt = get_the_content() ? get_the_excerpt() : '';
												?>
												<div class="except"><?php echo sub_string_word( $the_excerpt, OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>

												<?php if( $venue ){ ?>
													<div class="venue"><span><i class="icon_pin_alt"></i></span>
														<?php echo sub_string_word( $venue->post_title, OVAEM_Settings::ovaem_number_character_venue() ); ?>
													</div>
												<?php } ?>
													
												<div class="bottom">
													<?php if ( $check_pass_time ): ?>
														<div class="more_detail">
															<a class="btn_link" href="<?php the_permalink(); ?>">
																<?php if ( empty( $tickets_arr ) ): ?>
																	<span><?php esc_html_e('No ticket', 'ovaem-events-manager'); ?></span>
																<?php else: ?>
																	<span><?php esc_html_e('Get ticket', 'ovaem-events-manager'); ?></span>
																<?php endif; ?>
															</a>
														</div>
													
														<?php if( $show_status_event == 'true' ){ ?>
															<div class="status">
																<?php echo wp_kses( $check_status_event, true); ?>
															</div>
														<?php } ?>	

														<?php if ( ! empty( $tickets_arr ) ): ?>
															<span class="price"><?php echo $price; ?></span>
														<?php endif; ?>
													<?php endif; ?>
												</div>

											</div>
										</div>

									<?php }else if( $style_grid == 'style3' ){ ?>



										<div class="<?php echo $col; ?> ova-item style3">

											<a href="<?php the_permalink(); ?>">
												<div class="ova_thumbnail">
													<?php if( $d_img ){ ?>
														<img alt="<?php esc_html_e( get_the_title() ); ?>" src="<?php echo esc_url($d_img); ?>" 
														srcset="<?php echo esc_url($d_img).' 1200w'; ?>,
														<?php echo esc_url($m_img).' 767w'; ?>" 
														sizes="(max-width: 767px) 100vw, 600px" >
													<?php } ?>

													<div class="date"><span class="month"><?php echo $date_by_format; ?></span></div>

													<?php if( $venue ){ ?>
														<div class="venue">
															<span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $venue->post_title, OVAEM_Settings::ovaem_number_character_venue() ); ?>
														</div>
													<?php } ?>
													<?php if ( ! empty( $tickets_arr ) ): ?>
														<div class="time">
															<span class="price"><span><?php echo $price; ?></span></span>
														</div>
													<?php endif; ?>
												</div>
											</a>

											<div class="wrap_content">

												<h2 class="title">
													<a href="<?php the_permalink(); ?>"><?php echo sub_string_word(get_the_title(), OVAEM_Settings::ovaem_number_character_title_event()); ?></a>
												</h2>

												<?php if($venue){ ?>
													<div class="venue_mobile">
														<span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $venue->post_title, OVAEM_Settings::ovaem_number_character_venue() ); ?>
													</div>
												<?php }
												$the_excerpt = get_the_content() ? get_the_excerpt() : '';
												?>
												<div class="except"><?php echo sub_string_word( $the_excerpt, OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
												<?php if ( $check_pass_time ): ?>
													
													<div class="more_detail">
														<?php if ( empty( $tickets_arr ) ): ?>
															<a class="btn_link" href="<?php the_permalink(); ?>"><?php esc_html_e('No ticket', 'ovaem-events-manager'); ?><i class="arrow_right"></i></a>
														<?php else: ?>
															<a class="btn_link" href="<?php the_permalink(); ?>"><?php esc_html_e('Get ticket', 'ovaem-events-manager'); ?><i class="arrow_right"></i></a>
														<?php endif; ?>
													</div>

												<?php endif; ?>

												<?php if( $show_status_event == 'true' ){ ?>
													<div class="status">
														<?php echo wp_kses( $check_status_event, true); ?>
													</div>
												<?php } ?>	

											</div>

										</div>

									<?php }else if( $style_grid == 'style4' ){ ?>

										<div class="<?php echo $col; ?> ova-item style3 style4">

											<a href="<?php the_permalink(); ?>">
												<div class="ova_thumbnail">
													<?php if( $d_img ){ ?>
														<img alt="<?php esc_html_e( get_the_title() ); ?>" src="<?php echo esc_url($d_img); ?>" 
														srcset="<?php echo esc_url($d_img).' 1200w'; ?>,
														<?php echo esc_url($m_img).' 767w'; ?>" 
														sizes="(max-width: 767px) 100vw, 600px" >
													<?php } ?>

													<div class="date"><span class="month"><?php echo $date_by_format; ?></span></div>

													<?php if($venue){ ?>
														<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $venue->post_title, OVAEM_Settings::ovaem_number_character_venue() ); ?></div>
													<?php } ?>
													<?php if ( ! empty( $tickets_arr ) ): ?>
														<div class="time">
															<span class="price"><span><?php echo $price; ?></span></span>
														</div>
													<?php endif; ?>
												</div>
											</a>

											<div class="wrap_content">

												<h2 class="title">
													<a href="<?php the_permalink(); ?>"><?php echo sub_string_word(get_the_title(), OVAEM_Settings::ovaem_number_character_title_event()); ?></a>
												</h2>

												<?php if( $venue ){ ?>
													<div class="venue_mobile">
														<span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $venue->post_title, OVAEM_Settings::ovaem_number_character_venue() ); ?>
													</div>
												<?php }
												$the_excerpt = get_the_content() ? get_the_excerpt() : '';
												?>
												<div class="except"><?php echo sub_string_word( $the_excerpt, OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>

												<?php if ( $check_pass_time ): ?>

													<div class="more_detail">
														<a class="btn_link" href="<?php the_permalink(); ?>">
															<?php if ( empty( $tickets_arr ) ): ?>
																<?php esc_html_e('No ticket', 'ovaem-events-manager'); ?>
															<?php else: ?>
																<?php esc_html_e('Get ticket', 'ovaem-events-manager'); ?>
															<?php endif; ?>
															<i class="arrow_right"></i>
														</a>
													</div>

												<?php endif; ?>

												<?php if( $show_status_event == 'true' ){ ?>
													<div class="status">
														<?php echo wp_kses( $check_status_event, true); ?>
													</div>
												<?php } ?>	

											</div>

										</div>

									<?php } ?>

									<?php 
									$m++; $l++;
									if( $archives_event_style == 'grid_sidebar' ){

										if( $m == 2 ){ ?> <div class="mobile_row"></div><?php $m = 0; } ?>
										<?php if( $l == 2 ){ ?> <div class="row"></div><?php $l = 0; } ?>

									<?php }else{
										if( $m == 2 ){ ?> <div class="mobile_row"></div><?php $m = 0; } ?>
										<?php if( $l == 3 ){ ?> <div class="row"></div><?php $l = 0; } ?>	
									<?php } ?>



								<?php endwhile; 
								else: ?>

									<div class="container search_not_found">
										<?php esc_html_e( 'Not Found Events', 'ovaem-events-manager' ); ?>
									</div>

								<?php endif; wp_reset_postdata(); wp_reset_query(); ?>

								<div class="ovaem_events_pagination clearfix">
									<?php ovaem_pagination_theme($events); ?>
								</div>
							</div>
						</div>
					</div>

					<?php if( $archives_event_style == 'grid_sidebar' ){ ?>	
					</div>
				<?php } ?>

				<?php if( $archives_event_style == 'grid_sidebar' ){ ?>
					<div class="col-md-4">

						<div class="events_sidebar">
							<?php if( is_active_sidebar('ovaem-sidebar') ){ ?>
								<?php dynamic_sidebar('ovaem-sidebar'); ?>
							<?php } ?>	
						</div>

					</div>
				</div><!-- Close row -->
			<?php } ?>

		</div>
	<?php } else if( $archives_event_style == 'list' ){ ?>
		<div class="container">
			<?php if( $events->have_posts() ): while( $events->have_posts() ): $events->the_post(); 

				$end_time = get_post_meta( get_the_id(), $prefix.'_date_end_time', true );
				$start_time = get_post_meta( get_the_id(), $prefix.'_date_start_time', true );
				$time_m = $start_time ? date_i18n( $month_format, $start_time )  : '';
				$time_d = $start_time ? date_i18n( $day_format.'-'.$year_format, $start_time )  : '';

				$date_format = get_option('date_format');
				$date_by_format = $start_time ? date_i18n( $date_format , $start_time )  : '';

				$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
				$venue_slug = get_post_meta( get_the_id(), $prefix.'_venue', true );
				$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );

				$tickets_arr = get_post_meta( get_the_id(), $prefix.'_ticket', true );

				$price = apply_filters( 'ovaem_get_price', $tickets_arr );

				$check_status_event = apply_filters( 'ovaem_check_status_event', $start_time, $end_time );
				$check_pass_time = (int)current_time( 'timestamp' ) < (int)$end_time ? true : false;
				if ( $show_get_ticket != 'false' ) {
					$check_pass_time = true;
				}
				?>

				<div class="ovaem_events_list">
					<div class="col-md-6 ova_thumbnail">
						<a href="<?php the_permalink(); ?>">
							
							<?php if( $img ){ ?>	
								<img alt="<?php esc_html_e( get_the_title() ); ?>" src="<?php echo esc_url($img); ?>">
							<?php } ?>

							<div class="startdate">
								<?php echo $date_by_format; ?>

								<?php if( $show_status_event == 'true' ){ ?>
									<span class="event_status"> <span class="splash">/</span> <?php echo wp_kses( $check_status_event, true); ?></span>
								<?php } ?>

							</div>
							<div class="price"><?php echo $price; ?></div>
						</a>
					</div>
					<div class="col-md-6 info">

						<?php if( $venue ){ ?>
							<div class="venue"><span class="icon"><i class="icon_pin_alt"></i></span><span><?php echo sub_string_word( $venue->post_title, OVAEM_Settings::ovaem_number_character_venue() ); ?></span></div>
						<?php } ?>

						<h2 class="title">
							<a href="<?php the_permalink(); ?>"><?php echo sub_string_word(get_the_title(), OVAEM_Settings::ovaem_number_character_title_event()); ?></a>
						</h2>
						<div class="except">
							<?php
							if ( get_the_content() ) {
								echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() );
							}
							?>
						</div>
						<?php if ( $check_pass_time ): ?>
							<?php if ( ! empty( $tickets_arr ) ): ?>
								<div class="more_detail">
									<a class="btn_link ova-btn" href="<?php the_permalink(); ?>">
										<?php esc_html_e('Get ticket', 'ovaem-events-manager'); ?>
									</a>
								</div>
							<?php else: ?>
								<div class="more_detail">
									<a class="btn_link ova-btn" href="#">
										<?php esc_html_e('No ticket', 'ovaem-events-manager'); ?>
									</a>
								</div>
							<?php endif; ?>
							

						<?php endif; ?>
					</div>
				</div>

			<?php endwhile; 
			else: ?>

				<div class="container search_not_found">
					<?php esc_html_e( 'Not Found Events', 'ovaem-events-manager' ); ?>
				</div>

			<?php endif; wp_reset_postdata(); wp_reset_query(); ?>

			<div class="ovaem_events_pagination clearfix">
				<?php ovaem_pagination_theme($events); ?>
			</div>

		</div>
	<?php }else if( $archives_event_style == 'list_sidebar' ){ ?>
		<div class="container">
			<div class="col-md-8">
				<div class="row">
					<?php if( $events->have_posts() ): while( $events->have_posts() ): $events->the_post(); 

						$end_time = get_post_meta( get_the_id(), $prefix.'_date_end_time', true );
						$start_time = get_post_meta( get_the_id(), $prefix.'_date_start_time', true );
						$time_m = $start_time ? date_i18n( $month_format, $start_time )  : '';
						$time_d = $start_time ? date_i18n( $day_format.'-'.$year_format, $start_time )  : '';
						$date_format = get_option('date_format');
						$date_by_format = $start_time ? date_i18n( $date_format , $start_time )  : '';

						$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
						$venue_slug = get_post_meta( get_the_id(), $prefix.'_venue', true );
						$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );

						$tickets_arr = get_post_meta( get_the_id(), $prefix.'_ticket', true );
						$price = apply_filters( 'ovaem_get_price', $tickets_arr );

						$check_status_event = apply_filters( 'ovaem_check_status_event', $start_time, $end_time );
						$check_pass_time 	= (int)current_time( 'timestamp' ) < (int)$end_time ? true : false;
						if ( $show_get_ticket != 'false' ) {
							$check_pass_time = true;
						}
						?>

						<div class="ovaem_events_list sidebar <?php echo $archives_event_style; ?>">
							<div class="col-md-6 col-sm-6 ova_thumbnail" style="background: url(<?php echo esc_url($img); ?>)">
								<a href="<?php the_permalink(); ?>">
									
									<?php if( $img ){ ?>	
										<img alt="<?php esc_html_e( get_the_title() ); ?>" src="<?php echo esc_url($img); ?>">
									<?php } ?>

									<div class="startdate">
										<?php echo $date_by_format; ?>
										<?php if( $show_status_event == 'true' ){ ?>
											<span class="event_status"> 
												<span class="splash">/</span> 
												<?php echo wp_kses( $check_status_event, true); ?>
											</span>
										<?php } ?>		
									</div>
									<div class="price"><?php echo $price; ?></div>
								</a>
							</div>
							<div class="col-md-6 col-sm-6 info">
								<?php if($venue){ ?>
									<div class="venue"><span class="icon"><i class="icon_pin_alt"></i></span><span><?php echo $venue ? sub_string_word( $venue->post_title, OVAEM_Settings::ovaem_number_character_venue() ) : ''; ?></span></div>
								<?php } ?>
								<h2 class="title">
									<a href="<?php the_permalink(); ?>"><?php echo sub_string_word(get_the_title(), OVAEM_Settings::ovaem_number_character_title_event()); ?></a>
								</h2>
								<div class="except">
									<?php
									if ( get_the_content() ) {
										echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() );
									}
									
									?>
										
									</div>
								<?php if ( $check_pass_time ): ?>

									<?php if ( ! empty( $tickets_arr ) ): ?>
										<div class="more_detail">
											<a class="btn_link" href="<?php the_permalink(); ?>">
												<?php esc_html_e('Get ticket', 'ovaem-events-manager'); ?>
												<span></span>
											</a>
										</div>
									<?php else: ?>
										<div class="more_detail">
											<a class="btn_link" href="#">
												<?php esc_html_e('No ticket', 'ovaem-events-manager'); ?>
												<span></span>
											</a>
										</div>
									<?php endif; ?>

								<?php endif; ?>
							</div>
						</div>

					<?php endwhile; 
					else: ?>
						<div class="container search_not_found">
							<?php esc_html_e( 'Not Found Events', 'ovaem-events-manager' ); ?>
						</div>
					<?php endif; wp_reset_postdata(); wp_reset_query(); ?>

					<div class="ovaem_events_pagination clearfix">
						<?php ovaem_pagination_theme($events);  ?>
					</div>

				</div>
			</div>

			<div class="col-md-4">
				<div class="row">
					<div class="events_sidebar">
						<?php if( is_active_sidebar('ovaem-sidebar') ){ ?>
							<?php dynamic_sidebar('ovaem-sidebar'); ?>
						<?php } ?>	
					</div>
				</div>
			</div>

		</div>

	<?php } ?>


</div>


<?php get_footer( );
