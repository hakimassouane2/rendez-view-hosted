<?php get_header();




/* Check type */
$type = isset( $_GET['type'] ) ? $_GET['type'] : get_theme_mod( 'blog_type', 'list' ) ;

?>

<?php if( $type == 'list' ){ ?>

	<?php do_action('em4u_open_layout'); ?>

		<div class="ovaem_blog_page">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			    <?php get_template_part( 'content/content', 'post' ); ?>
			<?php endwhile; ?>

			    <div class="pagination-wrapper">
			        <?php em4u_pagination_theme(); ?>
				</div>

			<?php else : ?>
			        <?php get_template_part( 'content/content', 'none' ); ?>
			<?php endif; ?>
		</div>

	<?php do_action('em4u_close_layout'); ?>

<?php }else if( $type == 'list_two' ){ ?>

	<?php do_action('em4u_open_layout'); ?>

		<div class="ovaem_blog_page list_two ">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			    <?php get_template_part( 'content/content', 'post_list_two' ); ?>
			<?php endwhile; ?>

			    <div class="pagination-wrapper">
			        <?php em4u_pagination_theme(); ?>
				</div>

			<?php else : ?>
			        <?php get_template_part( 'content/content', 'none' ); ?>
			<?php endif; ?>
		</div>

	<?php do_action('em4u_close_layout'); ?>

<?php }else if( $type == 'grid' ){ ?>

	<div class="ovaem_blog_grid_page">
		<div class="container">
			<div class="row">
				<?php $l = $m = 0;  ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				    <?php get_template_part( 'content/content', 'post_grid' ); ?>
				    <?php 
					$m++; $l++;

		    		if( $m == 2 ){ ?> <div class="mobile_row"></div><?php $m = 0; } ?>
		    		<?php if( $l == 3 ){ ?> <div class="row desk_row"></div><?php $l = 0; } ?>

				<?php endwhile; ?>

				    <div class="col-md-12 row pagination-wrapper">
				        <?php em4u_pagination_theme(); ?>
					</div>

				<?php else : ?>
				        <?php get_template_part( 'content/content', 'none' ); ?>
				<?php endif; ?>

			</div>
		</div>
	</div>
		

<?php }else if( $type == 'grid_sidebar' ){ ?>
	
		<?php do_action('em4u_open_layout'); ?>
			<div class="ovaem_blog_grid_page">
				<div class="row">
						<?php $l = $m = 0;  ?>

						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						    <?php get_template_part( 'content/content', 'post_grid_two' ); ?>
						    <?php 
							$m++; $l++;

				    		if( $m == 2 ){ ?> <div class="mobile_row"></div><?php $m = 0; } ?>
				    		<?php if( $l == 2 ){ ?> <div class="row desk_row"></div><?php $l = 0; } ?>

						<?php endwhile; ?>

						    <div class="col-md-12 row pagination-wrapper">
						        <?php em4u_pagination_theme(); ?>
							</div>

						<?php else : ?>
						        <?php get_template_part( 'content/content', 'none' ); ?>
						<?php endif; ?>

				</div>	
			</div>
		<?php do_action('em4u_close_layout'); ?>


<?php } ?>


<?php  get_footer(); ?>