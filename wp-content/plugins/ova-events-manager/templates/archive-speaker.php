<?php if ( !defined( 'ABSPATH' ) ) exit();
	
	get_header( );

	$prefix = OVAEM_Settings::$prefix;

	$style =  isset( $_GET['type'] ) ? $_GET['type'] : OVAEM_Settings::list_speakers_style();
	$style = ( $style == 'style3' ) ? 'style2 style3' : $style;
	
	$show_link = OVAEM_Settings::list_speakers_link_title() ? OVAEM_Settings::list_speakers_link_title() : 'true';
	$show_job = OVAEM_Settings::list_speakers_show_job() ? OVAEM_Settings::list_speakers_show_job() : 'true';
	$show_social = OVAEM_Settings::list_speakers_show_social() ? OVAEM_Settings::list_speakers_show_social() : 'true';
	

	$l = 0;
	$m = 0;
?>	
<div class="ovaem_archive_speaker">
	<div class="container">
		<div class="row">
			<div class="ova_speaker_list_wrap <?php echo $style; ?>">
	
				<?php if( have_posts() ): while( have_posts() ): the_post(); 

						$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );

				?>

				<?php if( $style == 'style1' ){ ?>
					<div class="col-md-3 col-sm-6">
			      		<div class="ova_speaker_list ">
			      			

			      			<img src="<?php echo esc_url($img); ?>" alt="<?php esc_html_e( get_the_title() ); ?>" />
			      			
			      			<div class="content">

			      				<div class="trig"><i class="arrow_carrot-up"></i></div>
		      					<?php if( $show_link == 'true' ){ ?>
		      						<h3 class="title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
		      					<?php }else{ ?>
		      						<h3><?php the_title(); ?></h3>
		      					<?php } ?>
			      					
			      				

			      				<?php if( $show_job == 'true' ){ ?>
			      					<div class="job"><?php echo get_post_meta( get_the_id(), $prefix.'_speaker_job', true ); ?></div>
			      				<?php } ?>
			      				
			      				<?php if( $show_social == 'true' ){ ?>

			      					<?php $socials = get_post_meta( get_the_id(), $prefix.'_speaker_social', true ); ?>

			  						<?php if( $socials ){ ?>

				      					<ul class="social">
				      						<?php foreach ($socials as $key => $value) { ?>
				      							<li><a target="_blank" href="<?php echo $value['link']; ?>">
				      								<i class="<?php echo $value['fontclass']; ?>"></i>
				      							</a></li>
				      						<?php } ?>
				      						
				      					</ul>

				      				<?php } ?>
			      				<?php } ?>

			      			</div>

			      		</div>
			      	</div>
			      	
				<?php } else if( $style == 'style2' || $style == 'style2 style3' ){ ?>

					<div class="col-md-3 col-sm-6">
		      			<div class="ova_speaker_list ">
		      			

		      				<div class="wrap_img">

			      				<img src="<?php echo esc_url($img); ?>" alt="<?php esc_html_e( get_the_title() ); ?>" />

				      			<?php if( $show_social == 'true' ){ ?>

			      					<?php $socials = get_post_meta( get_the_id(), $prefix.'_speaker_social', true );
			  						
			  						if( $socials ){ ?>
			      						<ul class="social">
				      						<?php foreach ($socials as $key => $value) { ?>
				      							<li><a target="_blank" href="<?php echo $value['link']; ?>">
				      								<i class="<?php echo $value['fontclass']; ?>"></i>
				      							</a></li>
				      						<?php } ?>
				      						
				      					</ul>
				      				<?php } ?>

			      				<?php } ?>

	      					</div>
		      			
			      			<div class="content">

			      				<div class="trig"><i class="arrow_carrot-up"></i></div>
			      				
		      					<?php if( $show_link == 'true' ){ ?>
		      						<h3 class="title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
		      					<?php }else{ ?>
		      						<h3><?php the_title(); ?></h3>
		      					<?php } ?>
				      					
			      				

			      				<?php if( $show_job == 'true' ){ ?>
			      					<div class="job"><?php echo get_post_meta( get_the_id(), $prefix.'_speaker_job', true ); ?></div>
			      				<?php } ?>

			      			</div>

		      			</div>
		      		</div>


				<?php } else if( $style == 'style4' ){ ?>

					<div class="col-md-3 col-sm-6">
			      		<div class="ova_speaker_list ">
			      			

			      			<img src="<?php echo esc_url($img); ?>" alt="<?php esc_html_e( get_the_title() ); ?>" />
			      			
			      			<div class="content">

			      				<div class="wrap_info ova-trans">
				      				
				      				<?php if( $show_link == 'true' ){ ?>
			      						<h3 class="title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
			      					<?php }else{ ?>
			      						<h3><?php the_title(); ?></h3>
			      					<?php } ?>

				      				<?php if( $show_job == 'true' ){ ?>
				      					<div class="job"><?php echo get_post_meta( get_the_id(), $prefix.'_speaker_job', true ); ?></div>
				      				<?php } ?>

				      			</div>
			      				
			      				<?php if( $show_social == 'true' ){ ?>

			      					<?php $socials = get_post_meta( get_the_id(), $prefix.'_speaker_social', true );
			  						
			  						if( $socials ){ ?>
			      						<ul class="social">
				      						<?php foreach ($socials as $key => $value) { ?>
				      							<li><a target="_blank" href="<?php echo $value['link']; ?>">
				      								<i class="<?php echo $value['fontclass']; ?>"></i>
				      							</a></li>
				      						<?php } ?>
				      						
				      					</ul>
				      				<?php } ?>

			      				<?php } ?>

			      			</div>

			      		</div>
		      		</div>

				<?php } ?>

				<?php $l++;$m++; ?>
		      	<?php if( $m == 2 ){ ?> <div class="mobile_row"></div> <?php $m = 0; } ?>
				<?php if( $l == 4 ){ ?> <div class="row"></div> <?php $l = 0; } ?>
				 

				<?php endwhile; else: ?>
					<?php esc_html_e( 'Not Found Speaker', 'ovaem-events-manager' ); ?>
				<?php endif; wp_reset_query(); wp_reset_postdata(); ?>

				<div class="ovaem_events_pagination clearfix">
					<?php ovaem_pagination_theme(); ?>

				</div>

			</div>
		</div>
	</div>
</div>
<?php get_footer( );
