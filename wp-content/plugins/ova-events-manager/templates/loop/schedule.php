<?php if ( !defined( 'ABSPATH' ) ) exit(); ?>
<?php

	$prefix = OVAEM_Settings::$prefix;


	$schedule_parent = get_post_meta( get_the_id(), $prefix.'_schedule_date', true );
	$name_array_schedule_plan = get_post_meta( get_the_id(), $prefix.'_schedule_plan', true );

	$date_format = get_option('date_format');

	$nav = $content = '';



	$nav .= '<ul class="nav">';

		if( $schedule_parent ){

			foreach ($schedule_parent as $key => $value) {

				$active_tab = $key == 0 ? "active" : "";
				$active_content = $key == 0 ? "in active" : "";

				$count_nav = isset( $name_array_schedule_plan[$key] ) ? count( $name_array_schedule_plan[$key] ) - 1 : '';
				
				$nav .= '<li class="'.esc_attr($active_tab).'"><a data-toggle="tab" href="#'.esc_attr('tab_'.$key.'_event').'">'.esc_html($value['name']);
				$nav .= ( $value['date'] != '' )  ? '<br/> <span class="date">'.date_i18n($date_format, strtotime( $value['date'] ) ) .'</span>' : '';
				$nav .= '</a></li>';

				$content .= '<div id="'.esc_attr('tab_'.$key.'_event').'" class="tab-pane fade '.$active_content.'">';

				if( isset( $name_array_schedule_plan[$key] ) ){
					foreach( $name_array_schedule_plan[$key] as $key_p => $value_p ){

						$speaker_t = ''; 



						$last = ( $key_p == $count_nav ) ? 'last' : '';

						$content .= '<div class="wrap_content '.$last.'">';
							if( $value_p['speakers'] ){
								$content .= '<div class="speaker_side"><ul>';
									$speakers = explode(',', substr( $value_p['speakers'], 0, -1 )  );
									foreach ($speakers as $key => $value) {

										$speaker_arr = apply_filters( 'ovaem_speaker', $value );

										
										if( $speaker_arr ){
											$content .= '<li><a href="'.home_url('/').'?post_type='.$speaker_arr[0]->post_type.'&p='.$speaker_arr[0]->ID.'"><img src="'.get_the_post_thumbnail_url($speaker_arr[0]->ID).'" alt="'.$speaker_arr[0]->post_title.'" width="50"/></a></li>';

											$speaker_job = get_post_meta( $speaker_arr[0]->ID, $prefix.'_speaker_job', true );
											$speaker_t .= '<div class="speaker_info"><div class="speaker_title"><a href="'.home_url('/').'?post_type='.$speaker_arr[0]->post_type.'&p='.$speaker_arr[0]->ID.'">'.$speaker_arr[0]->post_title.'</a></div><div class="speaker_job">'.$speaker_job.'</div></div>';
										}

									}
								$content .= '</ul></div>';
							}

							$content .= '<div class="content_side">';
								$content .= $value_p['title'] ? '<div class="title" >'.$value_p['title'].'</div>' : '';
								$content .= $value_p['time'] ? '<div class="time">'.$value_p['time'].'</div>' : '';
								$content .= $value_p['desc'] ? '<p class="desc">'.$value_p['desc'].'</p>' : '';
								$content .= $speaker_t;
							$content .= '</div>';

						$content .= '</div>';
						
						
						
						
					}
				}
				

				$content .= '</div>';
				

			}
		}
	
	$nav .= '</ul>';  

	echo '<div class="ovaem_schedule">'.$nav.'<div class="tab-content">'.$content.'</div></div>';