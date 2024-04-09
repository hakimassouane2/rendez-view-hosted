<?php 

if( !defined( 'ABSPATH' ) ) exit();


global $post;
$prefix = OVAEM_Settings::$prefix;


$speaker_id = isset( $_POST['speaker_id'] ) ? $_POST['speaker_id'] : '' ;
$count_social = isset( $_POST['count_social'] ) ? $_POST['count_social'] : '' ;


$add_social = isset ( $_POST['add_social'] ) ? $_POST['add_social'] : '' ;


$social = $prefix.'_speaker_social';
$speaker_social = get_post_meta( $speaker_id , $prefix.'_speaker_social', true );





if($speaker_social){
 for ($i = 0; $i < count($speaker_social); $i++) { ?>
 	

	<div class="social_item" data-prefix="<?php echo esc_attr($prefix); ?>">
		<span class="remove_social"><i class="fa fa-remove"></i></span>
		<input type="text" class="social_fontclass" size="40"
			placeholder="<?php echo esc_attr('Font Class like: fa fa-facebook', 'ovaem-events-manager'); ?>"
			value="<?php echo esc_attr($speaker_social[$i]['fontclass']); ?>"
			name="<?php echo esc_attr($social);?>[<?php echo esc_attr($i);?>][fontclass]"/>
		
		<input type="text" class="social_link" size="40"
			placeholder="<?php echo esc_attr('Link like: http://facebook.com', 'ovaem-events-manager'); ?>"
			value="<?php echo esc_attr($speaker_social[$i]['link']); ?>"
			name="<?php echo esc_attr($social);?>[<?php echo esc_attr($i);?>][link]"/>

		<br/><br/>
	</div>


<?php } }elseif( $add_social == 'yes' ){ ?>
	
	<div class="social_item" data-prefix="<?php echo esc_attr($prefix); ?>">
		<span class="remove_social"><i class="fa fa-remove"></i></span>
		<input type="text" class="social_fontclass" size="40"
			placeholder="<?php echo esc_attr('Font Class like: fa fa-facebook', 'ovaem-events-manager'); ?>"
			value=""
			name="<?php echo esc_attr($social);?>[<?php echo esc_attr($count_social);?>][fontclass]"/>

		<input type="text" class="social_link" size="40"
			placeholder="<?php echo esc_attr('Link like: http://facebook.com', 'ovaem-events-manager'); ?>"
			value=""  
			name="<?php echo esc_attr($social);?>[<?php echo esc_attr($count_social);?>][link]"/>
		<br/><br/>
	</div>

<?php } ?>

 
