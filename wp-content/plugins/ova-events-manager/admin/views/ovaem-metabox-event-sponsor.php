<?php 

if( !defined( 'ABSPATH' ) ) exit();


$prefix = OVAEM_Settings::$prefix;

/* Add sponsor */
$count_sponsors 	= isset( $_POST['count_sponsors'] ) ? $_POST['count_sponsors'] : '';
$add_sponsor		= isset( $_POST['add_sponsor'] ) ? $_POST['add_sponsor'] : '' ;


/* Load Schedule */
$event_id    		= isset( $_POST['event_id'] ) ? $_POST['event_id'] : '';


$sponsor_level = $prefix.'_sponsor_level';
$sponsors = array();

$sponsors = get_post_meta( $event_id , $sponsor_level, true );

if( $add_sponsor == 'yes' ){
	$sponsors[$count_sponsors] = '';
}



if( $sponsors ){
	foreach ($sponsors as $key => $value) {
		
		if($add_sponsor == 'yes') $key = $count_sponsors;
		
		
 ?>
		<div class="sponsor_item sponsor_item_<?php echo esc_attr($key); ?>" data-sponsor-id="<?php echo esc_attr($key); ?>" data-prefix="<?php echo esc_attr($prefix); ?>">
		    	
			<div class="head">
				<div class="date_label">
					<a href="#" class="delete_sponsor" title="<?php esc_html_e( 'Remove Sponsor', 'ovaem-events-manager' ); ?> ">
						<i class="fa fa-remove"></i>
					</a>
					<span class='label_title'><?php echo esc_attr($value) ?></span>
				</div>
				<div class="icon toggle_schedule"><a href="#"><i class="fa fa-arrows-v"></i></a> </div>
			</div>

			<div class="sponsor_content">
				
				<div class="ovaem_event_row sponsor_wrap">
					<label><?php esc_html_e( 'Sponsor Level', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($sponsor_level); ?>[<?php echo esc_attr($key);?>]" 
						value="<?php echo esc_attr($value) ?>" class="sponsor_level" size="15" />
				</div>

				<div class="sponsor_list sponsor_list<?php echo esc_attr($key); ?>">
					<!-- Ajax will display content here -->
				</div>

				<div class="add_sponsor_info button  text-right">
					<i class="fa fa-plus"></i> <?php esc_html_e( 'Add Sponsor', 'ovaem-events-manager' ); ?>
				</div>
				
			</div>
			
		</div>

<?php }
} ?>

