<?php if( !defined( 'ABSPATH' ) ) exit(); 

$prefix = OVAEM_Settings::$prefix;

$event_id    		= isset( $_POST['event_id'] ) ? $_POST['event_id'] : '';
$count_plans 		= isset( $_POST['count_plans'] ) ? $_POST['count_plans'] : '';
$add_schedule_plan	= isset( $_POST['add_schedule_plan'] ) ? $_POST['add_schedule_plan'] : '';
$schedule_id 		= isset( $_POST['schedule_id'] ) ? $_POST['schedule_id'] : '' ;

$schedules_plan = $prefix.'_schedule_plan';


$schedules_date = $prefix.'_schedule_date';
$schedules_date = get_post_meta( $event_id , $schedules_date, true );

$schedules = array();
$schedules = get_post_meta( $event_id , $schedules_plan, true );

if( $schedules ){
			for($i = 0; $i <= count($schedules_date); $i++){
				if( $i == $schedule_id ){
				for( $d = 0; $d < count($schedules[$i]); $d++ ){
?>

<div class="plan_item" data-schedule-id="<?php echo esc_attr($i); ?>" data-plan-id="<?php echo esc_attr($d); ?>">
	<div class="content_plan">
		
		<div class="head" data-schedule-id="<?php echo esc_attr($d); ?>">
			<div class="date_label">
				<a href="#" class="delete_plan" title="<?php esc_html_e( 'Remove Plan', 'ovaem-events-manager' ); ?> ">
					<i class="fa fa-remove"></i>
				</a>
				<span class='label_title'><?php echo $schedules[$i][$d]['title']; ?></span>
			</div>
			<div class="icon toggle_schedule"><a href="#"><i class="fa fa-arrows-v"></i></a> </div>
		</div>
		<div class="plan_data">
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Title', 'ovaem-events-manager' ); ?> </label>
				<input type="text" class="schedule_title" size="52"
					value="<?php echo $schedules[$i][$d]['title']; ?>" 
					name="<?php echo esc_attr($schedules_plan); ?>[<?php echo esc_attr($i);?>][<?php echo esc_attr($d);?>][title]" 
					class="schedule_title" 
				/>
				<br/><br/>
			</div>
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Time', 'ovaem-events-manager' ); ?> </label>
				<input type="text" class="schedule_time" size="52"
					value="<?php echo $schedules[$i][$d]['time']; ?>" 
					name="<?php echo esc_attr($schedules_plan); ?>[<?php echo esc_attr($i);?>][<?php echo esc_attr($d);?>][time]" 
					class="schedule_time" 
				/>
				<br/><br/>
			</div>
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Description', 'ovaem-events-manager' ); ?> </label>
				<textarea class="schedule_desc" rows="5" cols="50"
						  name="<?php echo esc_attr($schedules_plan); ?>[<?php echo esc_attr($i);?>][<?php echo esc_attr($d);?>][desc]"><?php echo trim($schedules[$i][$d]['desc']);?></textarea>
				<br/><br/>
			</div>
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Speakers', 'ovaem-events-manager' ); ?> </label>
				<a href="#" class="choose_speakers" data-pos-speaker="schedule_speaker_<?php echo esc_attr($i."_".$d); ?>"><?php esc_html_e("Choose Speakers","ovaem-events-manager"); ?></a>
				<input type="hidden" class="schedule_speaker schedule_speaker_<?php echo esc_attr($i."_".$d); ?>" 
					value="<?php echo $schedules[$i][$d]['speakers']; ?>" 
					name="<?php echo esc_attr($schedules_plan); ?>[<?php echo esc_attr($i);?>][<?php echo esc_attr($d);?>][speakers]" 
					class="schedule_speakers" 
				/>
				<br/><br/>
				<div class="spekers_img">
					
				</div>
				<br/><br/>
			</div>
		</div>
	</div>
</div>


<?php } } } }  elseif( $add_schedule_plan == 'yes' ) {

?>

<div class="plan_item">
	<div class="content_plan">

		<div class="head">
			<div class="date_label">
				<a href="#" class="delete_plan" title="<?php esc_html_e( 'Remove Plan', 'ovaem-events-manager' ); ?> ">
					<i class="fa fa-remove"></i>
				</a>
				<span class='label_title'></span>
			</div>
			<div class="icon toggle_schedule"><a href="#"><i class="fa fa-arrows-v"></i></a> </div>
		</div>

		<div class="plan_data">
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Title', 'ovaem-events-manager' ); ?> </label>
				<input type="text" class="schedule_title" size="52"
					value="" 
					name="<?php echo esc_attr($schedules_plan); ?>[<?php echo esc_attr($schedule_id);?>][<?php echo esc_attr($count_plans);?>][title]" 
					class="schedule_title" 
				/>
				<br/><br/>
			</div>
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Time', 'ovaem-events-manager' ); ?> </label>
				<input type="text" class="schedule_time" size="52"
					value="" 
					name="<?php echo esc_attr($schedules_plan); ?>[<?php echo esc_attr($schedule_id);?>][<?php echo esc_attr($count_plans);?>][time]" 
					class="schedule_time" 
				/>
				<br/><br/>
			</div>
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Description', 'ovaem-events-manager' ); ?> </label>
				<textarea class="schedule_desc" rows="5" cols="50"
						  name="<?php echo esc_attr($schedules_plan); ?>[<?php echo esc_attr($schedule_id);?>][<?php echo esc_attr($count_plans);?>][desc]"></textarea>
				<br/><br/>
			</div>
			<div class="ovaem_event_row">
				<label><?php esc_html_e( 'Speakers', 'ovaem-events-manager' ); ?> </label>
				<a href="#" class="choose_speakers" data-pos-speaker="schedule_speaker_<?php echo esc_attr($schedule_id."_".$count_plans); ?>"><?php esc_html_e("Choose Speakers","ovaem-events-manager"); ?></a>
				<input type="hidden" class="schedule_speaker schedule_speaker_<?php echo esc_attr($schedule_id."_".$count_plans); ?>" 
					value="" 
					name="<?php echo esc_attr($schedules_plan); ?>[<?php echo esc_attr($schedule_id);?>][<?php echo esc_attr($count_plans);?>][speakers]" 
					class="schedule_speakers" 
				/>
				<br/><br/>
				<div class="spekers_img">
					
				</div>
				<br/><br/>
			</div>
		</div>
	</div>
</div>

<?php  } ?>



