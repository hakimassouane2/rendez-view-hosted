<?php if( !defined( 'ABSPATH' ) ) exit(); 


$prefix = OVAEM_Settings::$prefix;

$sponsor_level_name = $prefix.'_sponsor_level';
$sponsor_info_name = $prefix.'_sponsor_info';


$event_id    		= isset( $_POST['event_id'] ) ? $_POST['event_id'] : '';
$sponsor_id 		= isset( $_POST['sponsor_id'] ) ? $_POST['sponsor_id'] : '' ;

$count_sponsors_info	= isset( $_POST['count_sponsors_info'] ) ? $_POST['count_sponsors_info'] : '' ;
$add_sponsor_info	= isset( $_POST['add_sponsor_info'] ) ? $_POST['add_sponsor_info'] : '' ;



$sponsor_cat = get_post_meta( $event_id , $sponsor_level_name, true );


$sponsor_info = get_post_meta( $event_id , $sponsor_info_name, true ) ? get_post_meta( $event_id , $sponsor_info_name, true ) : array();

if( $sponsor_info ){
			for($i = 0; $i <= count($sponsor_cat); $i++){
				if( $i == $sponsor_id ){
				for( $d = 0; $d < count($sponsor_info[$i]); $d++ ){
?>

<div class="sponsor_item_info" data-sponsor-id="<?php echo esc_attr($i); ?>" data-sponsor-info-id="<?php echo esc_attr($d); ?>">
	<div class="content_plan">
		
		<div class="head" data-sponsor-id="<?php echo esc_attr($d); ?>">
			<div class="date_label">
				<a href="#" class="delete_sponsor_item_info" title="<?php esc_html_e( 'Remove Sponsor Item', 'ovaem-events-manager' ); ?> ">
					<i class="fa fa-remove"></i>
				</a>
				<span class='label_title'><?php echo $sponsor_info[$i][$d]['link']; ?></span>
			</div>
		</div>

		<div class="plan_data">

			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Link', 'ovaem-events-manager' ); ?> </label>
				<input type="text" class="sponsor_item_link" size="52"
					value="<?php echo $sponsor_info[$i][$d]['link']; ?>" 
					name="<?php echo esc_attr($sponsor_info_name); ?>[<?php echo esc_attr($i);?>][<?php echo esc_attr($d);?>][link]" />
				<br/><br/>
			</div>
			
			<div class="ovaem_event_row">
				<div id="ovaem_sponsor_logo">
					<a class="gallery-add button" 
						data-name="<?php echo esc_attr($sponsor_info_name); ?>[<?php echo esc_attr($i);?>][<?php echo esc_attr($d);?>][logo]" 
						data-res=".image-metabox-list<?php echo esc_attr($i);?><?php echo esc_attr($d);?>"
						href="#" data-uploader-title=<?php esc_html_e( "Add image", "ovaem-events-manager" ); ?>" data-uploader-button-text="Add image(s)">
				    	<?php esc_html_e( "Add image", "ovaem-events-manager" ); ?>
				    </a>

				    <ul id="image-metabox-list" class="image-metabox-list<?php echo esc_attr($i);?><?php echo esc_attr($d);?>">
				      <li>
				        	<input type="hidden" class="sponsor_info_logo" name="<?php echo esc_attr($sponsor_info_name); ?>[<?php echo esc_attr($i);?>][<?php echo esc_attr($d);?>][logo]" value="<?php echo $sponsor_info[$i][$d]['logo']; ?>">
				        	<?php $src_logo = wp_get_attachment_image_src($sponsor_info[$i][$d]['logo']); ?>
				        	<img class="image-preview" src="<?php echo $src_logo[0]; ?>" width="50">
				      </li>
				    </ul>
					
				</div>
				<br/><br/>
			</div>

		</div>
	</div>
</div>


<?php } } } }  elseif( $add_sponsor_info == 'yes' ) {

?>

<div class="sponsor_item_info">
	<div class="content_plan">

		<div class="head">
			<div class="date_label">
				<a href="#" class="delete_sponsor_item_info" title="<?php esc_html_e( 'Remove Plan', 'ovaem-events-manager' ); ?> ">
					<i class="fa fa-remove"></i>
				</a>
				<span class='label_title'></span>
			</div>
			
		</div>

		<div class="plan_data">
			
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Link', 'ovaem-events-manager' ); ?> </label>
				<input type="text" class="sponsor_item_link" size="52"
					value="" 
					name="<?php echo esc_attr($sponsor_info_name); ?>[<?php echo esc_attr($sponsor_id);?>][<?php echo esc_attr($count_sponsors_info);?>][link]" 
					class="schedule_title" 
				/>
				<br/><br/>
			</div>

			<div class="ovaem_event_row">
				<div id="ovaem_sponsor_logo">

					<a class="gallery-add button" 
					data-name="<?php echo esc_attr($sponsor_info_name); ?>[<?php echo esc_attr($sponsor_id);?>][<?php echo esc_attr($count_sponsors_info);?>][logo]" 
					data-res=".image-metabox-list<?php echo esc_attr($sponsor_id);?><?php echo esc_attr($count_sponsors_info);?>"
					href="#" data-uploader-title=<?php esc_html_e( "Add image", "ovaem-events-manager" ); ?>" data-uploader-button-text="Add image(s)">
						<?php esc_html_e( "Add image", "ovaem-events-manager" ); ?>
					</a>

					 <ul id="image-metabox-list" class="image-metabox-list<?php echo esc_attr($sponsor_id);?><?php echo esc_attr($count_sponsors_info);?>">
				      <li>
				        	<input type="hidden" class="sponsor_info_logo" name="<?php echo esc_attr($sponsor_info_name); ?>[<?php echo esc_attr($sponsor_id);?>][<?php echo esc_attr($count_sponsors_info);?>][logo]" value="">
				        	
				      </li>
				    </ul>

				    
					
				</div>
				<br/><br/>

			</div>
			
			
		</div>
	</div>
</div>

<?php  } ?>



