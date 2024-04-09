<?php if ( !defined( 'ABSPATH' ) ) exit(); ?>




<?php 	$prefix = OVAEM_Settings::$prefix;
		$post_type = OVAEM_Settings::speaker_post_type_slug();

		$speakers_slug = explode( ',', get_post_meta( get_the_id(), 'speakers', true ) );

		$schedule_parent = get_post_meta( get_the_id(), $prefix.'_schedule_date', true );

?>	
	<?php if( $speakers_slug && $schedule_parent!= '' ){

		$args = array(
		  'post_name__in' => $speakers_slug,
		  'post_type'   => $post_type,
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'orderby' => 'meta_value_num', 
		  'meta_key' => 'ovaem_speaker_order'
		);

		

		$speakers = new WP_Query($args); ?>
			<div class="ova_speaker_list_wrap style4">
				<?php if( $speakers->have_posts() ):
					while( $speakers->have_posts() ): $speakers->the_post(); ?>

						<div class="col-md-4 col-sm-4 ova-col">
							<div class="ova_speaker_list ">
								<?php $img = get_the_post_thumbnail_url( get_the_id(), 'medium'); ?>
								<img src="<?php echo esc_url($img); ?>"  alt="<?php the_title(); ?>">
								<div class="content">
									<div class="wrap_info ova-trans">
										<h3 class="title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										<div class="job"><?php echo get_post_meta( get_the_id(), $prefix.'_speaker_job', true ); ?></div>
									</div>
									<?php $socials = get_post_meta( get_the_id(), $prefix.'_speaker_social', true );

										if( $socials ){ ?>
											<ul class="social">
												<?php foreach ($socials as $key => $value) { ?>
													<li> <a target="_blank" href="<?php echo esc_url($value['link']) ?>"><i class="<?php echo $value['fontclass']; ?>"></i></a> </li>	
												<?php }	?>
											</ul>
										<?php } ?>
								
								</div>
							</div>
						</div>

				<?php endwhile; endif; wp_reset_postdata(); ?>

			</div>

	<?php } ?>
