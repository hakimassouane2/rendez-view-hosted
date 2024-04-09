<?php 

function em4u_close_layout($special_layout){
	
	// Close layout
	wp_reset_postdata();
	$main_layout = $special_layout ? $special_layout : em4u_get_current_main_layout();
	$width_sidebar = em4u_width_sidebar($special_layout);

	?>

	<?php if( $main_layout != 'fullwidth' ){ ?>	
		</div>
	<?php } ?>


	<?php if( $main_layout == "right_sidebar" || $main_layout == "left_sidebar" ){ ?>
	    <div class="<?php echo esc_attr($width_sidebar); ?> ovaem_general_sidebar">
	       <?php get_sidebar(); ?>
	    </div>
	<?php } ?>

	<?php if( $main_layout != 'fullwidth' ){ ?>	
		</div></div></section>
	<?php } ?>

	<?php 

}

add_action( 'em4u_close_layout', 'em4u_close_layout', 10, 1 );