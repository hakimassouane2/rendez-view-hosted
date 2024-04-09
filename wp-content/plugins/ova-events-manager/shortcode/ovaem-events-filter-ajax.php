<?php if ( !defined( 'ABSPATH' ) ) exit();

add_shortcode('ovaem_events_filter_ajax', 'ovaem_events_filter_ajax');
function ovaem_events_filter_ajax($atts, $content = null) {

	$prefix = OVAEM_Settings::$prefix;
	$date_start_time = $prefix.'_date_start_time';

	$atts = extract( shortcode_atts(
		array(
			'array_slug' => '',	
			'filter' => 'upcomming',
			'tab_active' => "",
			'orderby' => $date_start_time,
			'order' => 'DESC',
			'show_past' => 'true',
			'address_type' => 'venue',
			'count' => 3,
			'show_name' => 'true',
			'show_time' => 'true',
			'show_price' => 'true',
			'show_desc' => 'true',
			'show_venue' => 'true',
			'get_ticket' => 'Get ticket',
			'show_get_ticket' => 'true',
			'show_get_ticket_expired' => 'true',
			'read_more_text' => 'All events',
			'show_readmore' => 'true',
			'style' => 'style1',
			'btn_style' => 'style1',
			'show_nav' => 'show_nav',
			'show_status' => 'false',
			'class' => '',
		), $atts) );

	// var_dump(ovaem_get_country());
	$prefix = OVAEM_Settings::$prefix;
	$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
	$date_format = get_option('date_format');

	$day_format = OVAEM_Settings::ovaem_day_format();
	$month_format = OVAEM_Settings::ovaem_month_format();
	$year_format = OVAEM_Settings::ovaem_year_format();

	$categories = apply_filters( 'ovaem_get_categories', 10 );
	$array_slug = explode( ',', trim( $array_slug ) );

	$tab_active_all = (trim($tab_active) == '') ? 'current' : '';


	$args = array(
		'array_slug' => $array_slug,	
		'filter' => $filter,
		'tab_active' => $tab_active,
		'orderby' => $orderby,
		'order' => $order,
		'show_past' => $show_past,
		'address_type' => $address_type,
		'count' => $count,
		'show_name' => $show_name,
		'show_time' => $show_time,
		'show_price' => $show_price,
		'show_desc' => $show_desc,
		'show_venue' => $show_venue,
		'get_ticket' => $get_ticket,
		'show_get_ticket' => $show_get_ticket,
		'show_get_ticket_expired' => $show_get_ticket_expired,
		'read_more_text' => $read_more_text,
		'show_readmore' => $show_readmore,
		'style' => $style,
		'btn_style' => $btn_style,
		'show_nav' => $show_nav,
		'show_status' => $show_status,
		'class' => $class,
	);

	?>

	<div class="ovaem_events_filter ovaem_events_filter_ajax <?php echo esc_attr($class); ?>" data-order="<?php echo esc_attr($order); ?>">
		<div class="row">

			<!-- Navigation  -->
			<div class="<?php echo esc_attr('events_filter_'.$show_nav); ?>">
				<div class="select_cat_mobile_btn">
					<div class="btn_filter ova-btn ova-btn-second-color">
						<?php esc_html_e('Select Category', 'ovaem-events-manager'); ?>
						<i class="arrow_carrot-down"></i>
					</div>

					<ul class="clearfix ovaem_events_filter_nav <?php echo esc_attr($style); ?>" data-tab_active ="<?php echo esc_attr($tab_active); ?>">
						<li class="all <?php echo esc_attr($tab_active_all); ?>"><a href="#" class="ova-btn ova-btn-rad-30" data-filter=""><?php esc_html_e( "All", "ovaem-events-manager" ); ?></a></li>
						<?php for( $i=0; $i < count($array_slug); $i++ ) {

							foreach ($categories as $key => $cat) {

								if(trim( $array_slug[$i] ) == $cat->slug){

									$cat_active = ($cat->slug == $tab_active) ? 'current' : '';
									?>
									<li class="<?php echo esc_attr($cat->slug .' '.$cat_active); ?>"><a class="ova-btn ova-btn-rad-30" href="#" data-filter="<?php echo esc_attr($cat->slug); ?>"><?php echo $cat->name; ?></a></li>
								<?php }
							}
						} ?>
					</ul>

				</div>
			</div>



			<!-- Content -->
			<div class="ovaem_events_filter_content" data-event="<?php echo esc_attr(json_encode($args)); ?>">
				<?php
				$l = $m = 0;

				$eventlist = apply_filters( 'ovaem_events_orderby', $filter, $count, trim( $tab_active ), $orderby, $order, $show_past  );
				if( $eventlist->have_posts() ): while( $eventlist->have_posts() ):  $eventlist->the_post();

					$id = get_the_id();
					
					$cat_slug = '';

					$terms  = get_the_terms( $id , $slug_taxonomy_name);
					if ( $terms && ! is_wp_error( $terms ) ) {
						
						foreach ( $terms as $term ) {
							$cat_slug.= ' '.$term->slug ;
						}
					}

					$end_time = get_post_meta( $id, $prefix.'_date_end_time', true );
					$start_time = get_post_meta( $id, $prefix.'_date_start_time', true );
					$time_m = $start_time ? date_i18n( $month_format, $start_time )  : '';
					$time_d = $start_time ? date_i18n( $day_format.'-'.$year_format, $start_time )  : '';

					$date_by_format = $start_time ? date_i18n( $date_format , $start_time )  : '';

					$address = '';
					if( $address_type == 'venue' ){
						$venue_slug = get_post_meta( $id, $prefix.'_venue', true );
						if( $venue_slug ){
							$venue = get_page_by_path( $venue_slug, 'OBJECT', OVAEM_Settings::venue_post_type_slug() );	
							if($venue){
								$address = $venue->post_title;
							}
						}

					}else if( $address_type == 'address' ){
						$address = get_post_meta( $id, $prefix.'_address_event', true );
					}else if( $address_type == 'room' ){
						$address = 	get_post_meta( $id, $prefix.'_address', true );
					}

					$tickets_arr = get_post_meta( $id, $prefix.'_ticket', true );
					$price = apply_filters( 'ovaem_get_price', $tickets_arr );


					$d_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
					$m_img  = wp_get_attachment_image_url( get_post_thumbnail_id(), 'm_img' );

					$check_status_event = apply_filters( 'ovaem_check_status_event', $start_time, $end_time );
					$check_pass_time = (int)current_time( 'timestamp' ) < (int)$end_time ? true : false;

					if ( $show_get_ticket_expired == 'true' ) {
		    			$check_pass_time = true;
		    		}

					if( $style == 'style1' ){ ?>

						<div class="col-md-4 col-sm-6 col-xs-6 ova-item <?php echo esc_attr( $style .' '. $cat_slug ); ?>">
							<?php if( count( $array_slug ) > 1 ) { ?>
								<p class="number" style="display:none;"><?php echo esc_html( strtotime($date_by_format) ); ?></p>
							<?php } ?>

							<a href="<?php the_permalink(); ?>">
								<div class="ova_thumbnail">

									<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_attr($d_img); ?>" srcset=" <?php echo esc_attr($d_img); ?> 370w, <?php echo esc_attr($d_img); ?> 640w" sizes="(max-width: 640px) 100vw, 370px" />
									<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
										<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
									<?php	} ?>

									<?php if ( $show_time == 'true' || $show_price == 'true' ) { ?>
										<div class="time">
											<?php if ( $show_time == 'true' ) { ?>
												<span class="month"><?php echo $time_m; ?></span><span class="date"><?php echo $time_d; ?></span>
											<?php	} ?>

											<?php if ( $show_price == 'true' ) { ?>
												<span class="price"><?php echo $price; ?></span>
											<?php	} ?>
										</div>
									<?php } ?>

								</div>
							</a>

							<div class="wrap_content">
								<?php if ( $show_name == 'true' ) { ?>
									<h2 class="title"><a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?></a></h2>
								<?php } ?>

								<?php if( $show_status == 'true' ){ ?>
									<div class="status"><?php echo $check_status_event; ?></div>
								<?php } ?>

								<?php if( $show_desc == 'true' ){ ?>
									<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
								<?php } ?>

								<?php if( $check_pass_time === true && $show_get_ticket == 'true' ){ ?>
									<div class="more_detail"><a class="btn_link ova-btn ova-btn-rad-30" href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo esc_html($get_ticket); ?></a></div>
								<?php } ?>

							</div>

						</div>


					<?php } else if( $style == 'style2' ) { ?>

						<div class="col-md-4 col-sm-6 col-xs-6 ova-item <?php echo esc_attr( $style .' '. $cat_slug ); ?>">
							<?php if( count( $array_slug ) > 1 ){ ?>
								<p class="number" style="display:none;"><?php echo esc_html( strtotime($date_by_format) ); ?></p>
							<?php } ?>

							<a href="<?php the_permalink(); ?>">
								<div class="ova_thumbnail">

									<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_attr($d_img); ?>" srcset=" <?php echo esc_attr($d_img); ?> 370w, <?php echo esc_attr($d_img); ?> 640w" sizes="(max-width: 640px) 100vw, 370px" />

									<?php if ( $show_time == 'true' ) { ?>
										<div class="time"><span class="month"><?php echo $time_m; ?></span><span class="date"><?php echo $time_d; ?></span></div>
									<?php	} ?>


								</div>
							</a>

							<div class="wrap_content">
								<?php if ( $show_name == 'true' ) { ?>
									<h2 class="title"><a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?></a></h2>
								<?php } ?>

								<?php if( $show_desc == 'true' ){ ?>
									<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
								<?php } ?>

								<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
									<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
								<?php	} ?>

								<?php if ( $check_pass_time === true ): ?>

									<div class="bottom">

										<?php if( $show_get_ticket == 'true' ){ ?>
											<div class="more_detail"><a class="btn_link" href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php esc_html_e($get_ticket, 'ovaem-events-manager'); ?></a></div>
										<?php } ?>

										<?php if( $show_status == 'true' ){ ?>
											<div class="status"><?php echo $check_status_event; ?></div>
										<?php } ?>

										<?php if ( $show_price == 'true' ) { ?>
											<span class="price"><?php echo $price; ?></span>
										<?php	} ?>

									</div>

								<?php endif; ?>

							</div>

						</div>


					<?php	}else if( $style == 'style3' ){ ?>

						<div class="col-md-4 col-sm-6 col-xs-6 ova-item <?php echo esc_attr( $style .' '. $cat_slug ); ?>">

							<?php if( count( $array_slug ) > 1 ){ ?>
								<p class="number" style="display:none;"><?php echo esc_html( strtotime($date_by_format) ); ?></p>
							<?php } ?>

							<a href="<?php the_permalink(); ?>">
								<div class="ova_thumbnail">

									<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_attr($d_img); ?>" srcset=" <?php echo esc_attr($d_img); ?> 370w, <?php echo esc_attr($d_img); ?> 640w" sizes="(max-width: 640px) 100vw, 370px" />

									<?php if ( $show_time == 'true' && $date_by_format ) { ?>
										<div class="date"><span class="month"><?php echo esc_html($date_by_format); ?></span></div>
									<?php } ?>

									<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
										<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
									<?php	} ?>

									<?php if ( $show_price == 'true' && $price ) { ?>
										<div class="time">
											<span class="price"><?php echo $price; ?></span>
										</div>
									<?php	} ?>

								</div>
							</a>

							<div class="wrap_content">
								<?php if ( $show_name == 'true' ) { ?>
									<h2 class="title"><a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?></a></h2>
								<?php } ?>

								<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
									<div class="venue_mobile"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
								<?php	} ?>

								<?php if( $show_desc == 'true' ){ ?>
									<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
								<?php } ?>

								<?php if ( $check_pass_time === true ): ?>

									<?php if( $show_get_ticket == 'true' ){ ?>
										<div class="more_detail"><a class="btn_link" href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php esc_html_e($get_ticket, 'ovaem-events-manager'); ?><i class="arrow_right"></i></a></div>
									<?php } ?>

									<?php if( $show_status == 'true' ) { ?>
										<div class="status"><?php echo $check_status_event; ?></div>
									<?php } ?>

								<?php endif; ?>

							</div>

						</div>


					<?php } else if( $style == 'style4' ) { ?>

						<div class="col-md-4 col-sm-6 col-xs-6 ova-item  style3 <?php echo esc_attr( $style .' '. $cat_slug ); ?>">

							<?php if( count( $array_slug ) > 1 ) { ?>
								<p class="number" style="display:none;"><?php echo esc_html( strtotime($date_by_format) ); ?></p>
							<?php } ?>

							
							<a href="<?php the_permalink(); ?>">
								<div class="ova_thumbnail">

									<img alt="<?php echo esc_attr( get_the_title() ); ?>" src="<?php echo esc_attr($d_img); ?>" srcset=" <?php echo esc_attr($d_img); ?> 370w, <?php echo esc_attr($d_img); ?> 640w" sizes="(max-width: 640px) 100vw, 370px" />

									<?php if ( $show_time == 'true' && $date_by_format ) { ?>
										<div class="date"><span class="month"><?php echo esc_html($date_by_format); ?></span></div>
									<?php } ?>

									<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
										<div class="venue"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
									<?php	} ?>

									<?php if ( $show_price == 'true' && $price ) { ?>
										<div class="time">
											<span class="price"><?php echo $price; ?></span>
										</div>
									<?php	} ?>

								</div>
							</a>

							<div class="wrap_content">
								<?php if ( $show_name == 'true' ) { ?>
									<h2 class="title"><a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo sub_string_word( get_the_title(), OVAEM_Settings::ovaem_number_character_title_event() ); ?></a></h2>
								<?php } ?>

								<?php if ( $show_venue == 'true' && $address != '' ) { ?> 
									<div class="venue_mobile"><span><i class="icon_pin_alt"></i></span><?php echo sub_string_word( $address, OVAEM_Settings::ovaem_number_character_venue() ) ; ?></div>
								<?php	} ?>

								<?php if( $show_desc == 'true' ){ ?>
									<div class="except"><?php echo sub_string_word( get_the_excerpt(), OVAEM_Settings::ovaem_number_character_excerpt() ); ?></div>
								<?php } ?>

								<?php if ( $check_pass_time === true ): ?>

									<?php if( $show_get_ticket == 'true' ){ ?>
										<div class="more_detail"><a class="btn_link" href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php esc_html_e($get_ticket, 'ovaem-events-manager'); ?><i class="arrow_right"></i></a></div>
									<?php } ?>

									<?php if( $show_status == 'true' ) { ?>
										<div class="status"><?php echo $check_status_event; ?></div>
									<?php } ?>

								<?php endif; ?>

							</div>

						</div>

					<?php }

					$m++; $l++;
					if( $m == 2 ) { ?>
						<div class="mobile_row"></div>
						<?php
						$m = 0; 
					}

					if( $l == 3 ) { ?>
						<div class="row"></div>
						<?php
						$l = 0; 
					} 

				endwhile; endif; wp_reset_postdata();

				?>
			</div>
			<?php if( $show_readmore == 'true' ){

				if( $btn_style == 'style2' ){ ?>

					<div class="read_more">
						<a class="ova-btn ova-btn-large" href="<?php echo esc_attr( get_post_type_archive_link(OVAEM_Settings::event_post_type_slug()) ); ?>">
							<?php esc_html_e($read_more_text, 'ovaem-events-manager'); ?>
						</a>
					</div>

				<?php } else { ?>
					<div class="read_more">
						<a class="ova-btn ova-btn-rad-30 ova-btn-arrow" href="<?php echo esc_attr( get_post_type_archive_link(OVAEM_Settings::event_post_type_slug()) ); ?>">
							<i class="arrow_carrot-right_alt"></i><?php esc_html_e($read_more_text, 'ovaem-events-manager'); ?>
						</a>
					</div>
				<?php }
			} ?>

			<!-- Loader -->
			<div class="wrap_loader" style="display: none;">
				<svg class="loader" width="50" height="50">
					<circle cx="25" cy="25" r="10" stroke="#e86c60"/>
					<circle cx="25" cy="25" r="20" stroke="#e86c60"/>
				</svg>
			</div>

			

		</div>
	</div>

	<?php
}

if(function_exists('vc_map')){

	$prefix = OVAEM_Settings::$prefix;
	$date_start_time = $prefix.'_date_start_time';
	$date_end_time = $prefix.'_date_end_time';
	$date_order = $prefix.'_order';
	$date_created = 'date';

	vc_map( array(
		"name" => esc_html__("Category Filter Ajax", 'ovaem-events-manager'),
		"base" => "ovaem_events_filter_ajax",
		"description" => esc_html__("Category Navigation Filter Ajax", 'ovaem-events-manager'),
		"class" => "",
		"category" => esc_html__("Event Manager", 'ovaem-events-manager'),
		"icon" => "icon-qk",   
		"params" => array(

			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Slug Categories list",'ovaem-events-manager'),
				"param_name" => "array_slug",
				"description" => esc_html__("You can find slug in: Events Manager >> Event Categories >> Copy value in Slug column. Example: conference, art, travel, business, concert, education",'ovaem-events-manager'),
				"value" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Tab active",'ovaem-events-manager'),
				"param_name" => "tab_active",
				"description" => esc_html__("Empty to active All tab or insert slug category",'ovaem-events-manager'),
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Filter in each category",'ovaem-events-manager'),
				"param_name" => "filter",
				"value" => array(
					esc_html__( "Upcoming", "ovaem-events-manager") => "upcomming",
					esc_html__( "Upcoming/Showing", "ovaem-events-manager") => "upcomming_showing",
					esc_html__( "Past", "ovaem-events-manager")	=> "past",
					esc_html__( "Featured", "ovaem-events-manager")	=> "featured",
					esc_html__( "Creation Date", "ovaem-events-manager")	=> "creation_date"
				),
				"default" => "upcomming"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Display Address like",'ovaem-events-manager'),
				"param_name" => "address_type",
				"value" => array(
					esc_html__("Venue", "ovaem-events-manager" ) => "venue",
					esc_html__("Address", "ovaem-events-manager" )	=> "address",
					esc_html__("Room", "ovaem-events-manager" )	=> "room"
				),
				"default" => "venue"

			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Count item in each category",'ovaem-events-manager'),
				"param_name" => "count",
				"value" => "3",
				"description" => esc_html__("Insert number.",'ovaem-events-manager')
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Orderby in each category",'ovaem-events-manager'),
				"param_name" => "orderby",
				"value" => array(
					esc_html__("Start time", "ovaem-events-manager" ) => $date_start_time,
					esc_html__("End Time", "ovaem-events-manager" )	=> $date_end_time,
					esc_html__("Order field in event attribute", "ovaem-events-manager" )	=> $date_order,
					esc_html__("Created Date", "ovaem-events-manager" )	=> $date_created,
				),
				"default" => $date_start_time

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Order in each category",'ovaem-events-manager'),
				"param_name" => "order",
				"value" => array(
					esc_html__("Decrease", "ovaem-events-manager" ) => "DESC",
					esc_html__("Increase", "ovaem-events-manager" )	=> "ASC"
				),
				"default" => "DESC"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Past Event",'ovaem-events-manager'),
				"param_name" => "show_past",
				"value" => array(
					esc_html__("Yes", "ovaem-events-manager" ) => "true",
					esc_html__("No", "ovaem-events-manager" )	=> "false"
				),
				"default" => "true"

			),

			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show name",'ovaem-events-manager'),
				"param_name" => "show_name",
				"value" => array(
					esc_html__("True", "ovaem-events-manager" ) => "true",
					esc_html__("False", "ovaem-events-manager" )	=> "false"
				),
				"default" => "true"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Time",'ovaem-events-manager'),
				"param_name" => "show_time",
				"value" => array(
					esc_html__("True", "ovaem-events-manager" ) => "true",
					esc_html__("False", "ovaem-events-manager" )	=> "false"
				),
				"default" => "true"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Description",'ovaem-events-manager'),
				"param_name" => "show_desc",
				"value" => array(
					esc_html__("True", "ovaem-events-manager" ) => "true",
					esc_html__("False", "ovaem-events-manager" )	=> "false"
				),
				"default" => "true"

			),

			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Price",'ovaem-events-manager'),
				"param_name" => "show_price",
				"value" => array(
					esc_html__("True", "ovaem-events-manager" ) => "true",
					esc_html__("False", "ovaem-events-manager" )	=> "false"
				),
				"default" => "true"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Venue",'ovaem-events-manager'),
				"param_name" => "show_venue",
				"value" => array(
					esc_html__("True", "ovaem-events-manager" ) => "true",
					esc_html__("False", "ovaem-events-manager" )	=> "false"
				),
				"default" => "true"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Get Ticket",'ovaem-events-manager'),
				"param_name" => "show_get_ticket",
				"value" => array(
					esc_html__("True", "ovaem-events-manager" ) => "true",
					esc_html__("False", "ovaem-events-manager" )	=> "false"
				),
				"default" => "true"

			),
			// dependency show_get_ticket
			    array(
			       "type" => "dropdown",
			       "holder" => "div",
			       "class" => "",
			       "heading" => esc_html__("Show Expired Get Ticket",'ovaem-events-manager'),
			       "param_name" => "show_get_ticket_expired",
			       'dependency' => array( 'element' => 'show_get_ticket', 'value' => 'true' ),
			       "value" => array(
			       		esc_html__("True", "ovaem-events-manager" ) => "true",
			       		esc_html__("False", "ovaem-events-manager" )	=> "false"
			       	),
			       "default" => "true"
			       
			    ),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Replace Get ticket",'ovaem-events-manager'),
				"param_name" => "get_ticket",
				"value" => "Get ticket"
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Read More",'ovaem-events-manager'),
				"param_name" => "show_readmore",
				"value" => array(
					esc_html__("True", "ovaem-events-manager" ) => "true",
					esc_html__("False", "ovaem-events-manager" )	=> "false"
				),
				"default" => "true"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Button Style",'ovaem-events-manager'),
				"param_name" => "btn_style",
				"value" => array(
					esc_html__("Style 1", "ovaem-events-manager" ) => "style1",
					esc_html__("Style 2", "ovaem-events-manager" )	=> "style2"
				),
				"default" => "style1"

			),

			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Replace All Events Button Text",'ovaem-events-manager'),
				"param_name" => "read_more_text",
				"value" => "All events"
			),

			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Style",'ovaem-events-manager'),
				"param_name" => "style",
				"value" => array(
					esc_html__("Style 1", "ovaem-events-manager" ) => "style1",
					esc_html__("Style 2", "ovaem-events-manager" )	=> "style2",
					esc_html__("Style 3", "ovaem-events-manager" )	=> "style3",
					esc_html__("Style 4", "ovaem-events-manager" )	=> "style4"
				),
				"default" => "style1"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Navigation",'ovaem-events-manager'),
				"param_name" => "show_nav",
				"value" => array(
					esc_html__("Yes", "ovaem-events-manager" ) => "show_nav",
					esc_html__("No", "ovaem-events-manager" )	=> "hide_nav"
				),
				"default" => "show_nav"

			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Show Status",'ovaem-events-manager'),
				"param_name" => "show_status",
				"value" => array(
					esc_html__("False", "ovaem-events-manager" ) => "false",
					esc_html__("True", "ovaem-events-manager" )	=> "true"
				),
				"default" => "false"

			),

			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Class",'ovaem-events-manager'),
				"param_name" => "class",
				"value" => "",
				"description" => esc_html__("Insert class to use for your style",'ovaem-events-manager')
			)


		)));

}