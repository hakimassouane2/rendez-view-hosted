<?php 

if( !defined( 'ABSPATH' ) ) exit();


$speaker_arr = $_POST['speaker_arr'] ? substr( $_POST['speaker_arr'], 0, -1 ) : '';


$speaker_array =  explode(",",$speaker_arr);




$args = array(
	'post_type'	=> OVAEM_Settings::speaker_post_type_slug(),
	'post_status'	=> 'publish',
	'post_name__in'	=> $speaker_array,
	'posts_per_page' => '-1'

);

$speakers = new WP_Query($args);



if( $speakers->have_posts() ): while( $speakers->have_posts() ): $speakers->the_post(); ?>
	
<img src="<?php echo get_the_post_thumbnail_url(); ?>" width="50">

<?php 
endwhile;
endif;
wp_reset_postdata();



