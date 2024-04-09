<?php 

if( !defined( 'ABSPATH' ) ) exit();


$prefix = OVAEM_Settings::$prefix;

/* Add Schedule */
$count_schedules 	= isset( $_POST['count_schedules'] ) ? $_POST['count_schedules'] : '';
$add_schedule		= isset( $_POST['add_schedule'] ) ? $_POST['add_schedule'] : '';



$date_format = 'd M Y';
$time_format = 'H:i';
$event_calendar_input_step = OVAEM_Settings::event_calendar_input_step();

/* Load Schedule */
$event_id    		= isset( $_POST['event_id'] ) ? $_POST['event_id'] : '';


$schedules_date = $prefix.'_schedule_date';
$schedules = array();

$schedules = get_post_meta( $event_id , $schedules_date, true );

if( $add_schedule == 'yes' ){
	$schedules[$count_schedules] = '';
}



if( $schedules ){
	foreach ($schedules as $key => $schedule) {
		
		if($add_schedule == 'yes') $key = $count_schedules;
		
		
 ?>
		<div class="schedule_item schedule_item_<?php echo esc_attr($key); ?>" data-schedule-id="<?php echo esc_attr($key); ?>" data-prefix="<?php echo esc_attr($prefix); ?>">
		    	
			<div class="head">
				<div class="date_label">
					<a href="#" class="delete_schedule" title="<?php esc_html_e( 'Remove Schedule', 'ovaem-events-manager' ); ?> ">
						<i class="fa fa-remove"></i>
					</a>
					<span class='label_title'><?php echo esc_attr( isset( $schedule['name'] ) ? $schedule['name'] : '' ) ?></span>
				</div>
				<div class="icon toggle_schedule"><a href="#"><i class="fa fa-arrows-v"></i></a> </div>
			</div>

			<div class="schedule_content">
				
				<div class="ovaem_event_row">
					<label><?php esc_html_e( 'Name', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($schedules_date); ?>[<?php echo esc_attr($key);?>][name]" 
						value="<?php echo esc_attr( isset( $schedule['name'] ) ? $schedule['name'] : '' ) ?>" class="schedule_name" size="15" />
						<br><br>
				</div>


				<div class="ovaem_event_row">
					<label><?php esc_html_e( 'Date', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($schedules_date); ?>[<?php echo esc_attr($key);?>][date]" 
						value="<?php echo esc_attr( isset( $schedule['date'] ) ? $schedule['date'] : '' ) ?>" 
						class="schedule_date ovaem_datetime_picker"  
						autocomplete="off" 
						data-date_format="<?php echo esc_attr($date_format); ?>" data-time_format="" 
						data-step="<?php echo esc_attr( $event_calendar_input_step ); ?>" 
						data-first-day="<?php echo esc_attr( OVAEM_Settings::first_day_of_week() ); ?>" />
				</div>

				
				<div class="schedule_plans schedule_plans<?php echo esc_attr($key); ?>">
					<!-- Ajax will display content here -->
				</div>

				<div class="add_schedule_plan button  text-right">
					<i class="fa fa-plus"></i> <?php esc_html_e( 'Add Plan', 'ovaem-events-manager' ); ?>
				</div>
				
			</div>
			
		</div>

<?php }
} ?>

