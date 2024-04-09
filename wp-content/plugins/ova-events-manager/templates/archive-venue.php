<?php if ( !defined( 'ABSPATH' ) ) exit();
	
	get_header( );

	$prefix = OVAEM_Settings::$prefix;

	$style =  isset( $_GET['type'] ) ? $_GET['type'] : OVAEM_Settings::archive_venue_style();
	
	
	$l = 0;
	$m = 0;

?>

	<div class="ovaem_archive_venue">
		<div class="container">
			<div class="row">

				
					<?php if( $style == 'style1' ){ ?>

						<?php if( have_posts() ): while( have_posts() ): the_post();

								$d_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
								$m_img  = wp_get_attachment_image_url( get_post_thumbnail_id(), 'm_img' );
								$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
						?>

						<div class="col-md-4 col-sm-6">
				      		<div class="ova_venue_item">

				      			<img alt="<?php the_title(); ?>" src="<?php echo esc_url($img); ?>" 
												srcset="<?php echo esc_url($d_img).' 1200w'; ?>,
												<?php echo esc_url($m_img).' 767w'; ?>" 
												sizes="(max-width: 767px) 100vw, 600px" >

				      			<div class="content">
				      				<h3 class="title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
					      			<div class="desc"><?php the_excerpt(); ?></div>
					      			<div class="address">
					      				<i class="icon_pin_alt"></i>
					      				<?php echo get_post_meta( get_the_id(), $prefix.'_venue_address', true ); ?>
					      			</div>	
				      			</div>
				      			


				      		</div>
				      	</div>

				      	<?php $l++;$m++; ?>
				      	<?php if( $m == 2 ){ ?> <div class="mobile_row"></div> <?php $m = 0; } ?>
						<?php if( $l == 3 ){ ?> <div class="row large_row"></div> <?php $l = 0; } ?>
						 

						<?php endwhile; endif; wp_reset_postdata(); ?>

						<div class="ovaem_events_pagination clearfix">
							<?php ovaem_pagination_theme(); ?>
							
						</div>

			      	<?php } else if( $style == 'style2' ){ ?>

			      		<div class="col-md-8">
		      				<div class="row">
		      					<?php if( have_posts() ): while( have_posts() ): the_post();


										$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
										$d_img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'd_img' );
										$m_img  = wp_get_attachment_image_url( get_post_thumbnail_id(), 'm_img' );
								?>
				      					<div class="col-sm-6">
								      		<div class="ova_venue_item">

								      			
								      			<img alt="<?php the_title(); ?>" src="<?php echo esc_url($img); ?>" 
												srcset="<?php echo esc_url($d_img).' 1200w'; ?>,
												<?php echo esc_url($m_img).' 767w'; ?>" 
												sizes="(max-width: 767px) 100vw, 600px" >

								      			<div class="content">
								      				<h3 class="title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
									      			<div class="desc"><?php the_excerpt(); ?></div>
									      			<div class="address">
									      				<i class="icon_pin_alt"></i>
									      				<?php echo get_post_meta( get_the_id(), $prefix.'_venue_address', true ); ?>
									      			</div>	
								      			</div>
								      			


								      		</div>
								      	</div>

						      	<?php $l++;$m++; ?>
						      	<?php if( $m == 2 ){ ?> <div class="mobile_row"></div> <?php $m = 0; } ?>
								<?php if( $l == 2 ){ ?> <div class="row large_row"></div> <?php $l = 0; } ?>
								 

								<?php endwhile; endif; wp_reset_postdata(); ?>

								<div class="ovaem_events_pagination clearfix">
									<?php ovaem_pagination_theme(); ?>
								</div>

		      				</div>
			      		</div>

			      		<div class="col-md-4">
			      			<div class="events_sidebar">
				      			<?php if( is_active_sidebar('ovaem-sidebar') ){ ?>
									<?php dynamic_sidebar('ovaem-sidebar'); ?>
								<?php } ?>	
							</div>
			      		</div>

			      	<?php } ?>

			</div>
		</div>
	</div>

<?php get_footer( );