<?php 

if( !defined( 'ABSPATH' ) ) exit();

global $post;

$date_format = 'd M Y';
$time_format = 'H:i';
$event_calendar_input_step = OVAEM_Settings::event_calendar_input_step();

$prefix = OVAEM_Settings::$prefix;
$post_id    = $post->ID;

$coupon_code = get_post_meta( $post_id , $prefix.'_coupon_code', true );

$coupon_type = get_post_meta( $post_id , $prefix.'_coupon_type', true ) ? get_post_meta( $post_id , $prefix.'_coupon_type', true ) :'percent';
$coupon_amount = get_post_meta( $post_id , $prefix.'_coupon_amount', true );

$coupon_start_date = get_post_meta( $post_id , $prefix.'_coupon_start_date', true );
$coupon_end_date = get_post_meta( $post_id , $prefix.'_coupon_end_date', true );


if( $coupon_start_date && $coupon_end_date ){
	$coupon_start_date = date( $date_format.' '.$time_format, $coupon_start_date );
	$coupon_end_date 	=  date( $date_format.' '.$time_format, $coupon_end_date );	
}else{
	$coupon_start_date = $coupon_end_date = '';
}

$enable_for_woo = get_post_meta( $post_id , $prefix.'_enable_for_woo', true );

?>

 <div class="container-fluid">
 	<div class="row">

 		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Code', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($coupon_code); ?>"  name="<?php echo esc_attr($prefix);?>_coupon_code" />
		</div>

		
		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label">
		 		<strong><?php esc_html_e( 'Discount', 'ovaem-events-manager' ); ?>: </strong></label>
		 		<input type="text" size="10" value="<?php echo esc_attr($coupon_amount); ?>"  name="<?php echo esc_attr($prefix);?>_coupon_amount" />
		 	<select name="<?php echo esc_attr($prefix);?>_coupon_type">
		 		<option value="percent" <?php echo ($coupon_type == 'percent' ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Rate (%)', 'ovaem-events-manager' ); ?> </option>
		 		<option value="pieces" <?php echo ($coupon_type == 'pieces' ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Amount ($)', 'ovaem-events-manager' ); ?> </option>
		 	</select>

		 	
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Start date', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input 
		 		type="text" 
		 		autocomplete="off" 
		 		size="40" 
		 		class="ovaem_datetime_picker" 
		 		value="<?php echo esc_attr($coupon_start_date); ?>"  
		 		name="<?php echo esc_attr($prefix);?>_coupon_start_date" 
		 		data-date_format="<?php echo esc_attr($date_format); ?>" 
		 		data-time_format="<?php echo esc_attr($time_format); ?>" 
		 		data-step="<?php echo esc_attr( $event_calendar_input_step ); ?>" 
		 		data-first-day="<?php echo esc_attr( OVAEM_Settings::first_day_of_week() ); ?>"
		 	/>
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'End date', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input 
		 		type="text" 
		 		autocomplete="off" 
		 		size="40" 
		 		class="ovaem_datetime_picker" 
		 		value="<?php echo esc_attr($coupon_end_date); ?>"  
		 		name="<?php echo esc_attr($prefix);?>_coupon_end_date" 
		 		data-date_format="<?php echo esc_attr($date_format); ?>" 
		 		data-time_format="<?php echo esc_attr($time_format); ?>" 
		 		data-step="<?php echo esc_attr( $event_calendar_input_step ); ?>" 
		 		data-first-day="<?php echo esc_attr( OVAEM_Settings::first_day_of_week() ); ?>"
		 		/>
		</div>
		<?php if ( class_exists( 'WooCommerce' ) ): ?>
			<div class="ovaem_event_row">
				<br/>
			 	<label class="label"><strong><?php esc_html_e( 'Enabled for Woo', 'ovaem-events-manager' ); ?>: </strong></label>
				<input name="<?php echo esc_attr( $prefix . '_enable_for_woo'); ?>" type="checkbox" <?php checked( $enable_for_woo, '1'); ?> id="<?php echo esc_attr( $prefix . '_enable_for_woo'); ?>" value="1">
			</div>
		<?php endif; ?>
 	</div>
 </div>

 

<?php wp_nonce_field( 'ova_events_nonce', 'ova_events_nonce' ); ?>
 