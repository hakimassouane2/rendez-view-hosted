<?php 
// Close layout
add_action( 'em4u_woo_close_layout',  'em4u_woo_close_layout' );

function em4u_woo_close_layout(){
	
	wp_reset_postdata();
	
	$main_layout =  isset( $_GET['woo_layout'] ) ? $_GET['woo_layout'] : get_theme_mod('woo_layout','right_sidebar');
	
	$width_sidebar = em4u_woo_width_sidebar();
	?>

	

	<?php if( $main_layout != 'fullwidth' ){ ?>
	</div>
	<?php } ?>


	<?php if( $main_layout == "right_sidebar" || $main_layout == "left_sidebar" ){ ?>
	    <div class="<?php echo esc_attr($width_sidebar).' '.$main_layout; ?> ovaem_general_sidebar">
	    	
	       	<?php get_sidebar('shop'); ?>
	       
	    </div>
	<?php } ?>


	<?php if( $main_layout != 'fullwidth' ){ ?>
		</div></div></section>	
	<?php } ?>

<?php }