<?php

add_action( 'em4u_woo_open_layout',  'em4u_woo_open_layout' );

function em4u_woo_open_layout(){


$main_layout =  isset( $_GET['woo_layout'] ) ? $_GET['woo_layout'] : get_theme_mod('woo_layout','right_sidebar');

$width_main_content = ($main_layout == 'no_sidebar' ) ? 'ovatheme_woo_nosidebar' : em4u_woo_width_main_content();




?>

	<?php if( $main_layout != 'fullwidth' ){ ?>
	<section class="page-section ova-woo-shop">
	    <div class="container">
	        <div class="row">
	            <div class=" <?php echo esc_attr($width_main_content); ?>" >
	<?php } ?>

<?php }