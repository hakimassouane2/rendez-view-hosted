<?php

function em4u_open_layout($special_layout){
	

	// Open layout
	$main_layout = em4u_get_current_main_layout();
	$width_main_content = ($main_layout == 'no_sidebar' ) ? 'ovatheme_nosidebar' : em4u_width_main_content($special_layout);

	?>
		<?php if( $main_layout != 'fullwidth' ){ ?>

			<section class="ova-page-section">
			    <div class="container">
			        <div class="row">
			            <div class=" <?php echo esc_attr($width_main_content); ?>" >
			            
		<?php } ?>
	<?php 

}

add_action( 'em4u_open_layout', 'em4u_open_layout', 10, 1);