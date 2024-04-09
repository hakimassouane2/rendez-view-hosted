<?php 

if( !defined( 'ABSPATH' ) ) exit();

$prefix 	= OVAEM_Settings::$prefix;
$post_id    = $post->ID;

$date_format = 'd M Y';
$time_format = 'H:i';

$event_calendar_input_step = OVAEM_Settings::event_calendar_input_step();
$checked = get_post_meta( $post_id , $prefix.'_featured', true ) ? get_post_meta( $post_id , $prefix.'_featured', true ) : '';

$date_start_timestamp 	= ( get_post_meta( $post_id , $prefix.'_date_start_time', true ) != '' ) ? get_post_meta( $post_id , $prefix.'_date_start_time', true ) : '';
$date_end_timestamp 	= ( get_post_meta( $post_id , $prefix.'_date_end_time', true ) != '' ) ? get_post_meta( $post_id , $prefix.'_date_end_time', true ) : '';

if ( absint( $date_start_timestamp ) && absint( $date_end_timestamp ) ) {
	$date_start_time = date( $date_format.' '.$time_format, $date_start_timestamp );
	$date_end_time 	=  date( $date_format.' '.$time_format, $date_end_timestamp );	
} else {
	$date_start_time = $date_end_time = '';
}

$address 		= get_post_meta( $post_id , $prefix.'_address', true );
$address_event 	= get_post_meta( $post_id , $prefix.'_address_event', true );
$order 			= get_post_meta( $post_id , $prefix.'_order', true ) ? get_post_meta( $post_id , $prefix.'_order', true ) : 1;
$schedules 		= get_post_meta( $post_id , $prefix.'_schedule', true );

// Get all venue
$venue 	= get_post_meta( $post_id, $prefix.'_venue', true );
$venues = OVAEM_Get_Data::ovaem_get_venues();

// Logo Ticket
$logo_ticket 		= get_post_meta( $post_id , $prefix.'_pdf_ticket_logo', true ) ? get_post_meta( $post_id , $prefix.'_pdf_ticket_logo', true ) : '';
$event_map_name 	= get_post_meta( $post_id , $prefix.'_event_map_name', true ) ? get_post_meta( $post_id , $prefix.'_event_map_name', true ) : '';
$event_map_address 	= get_post_meta( $post_id , $prefix.'_event_map_address', true ) ? get_post_meta( $post_id , $prefix.'_event_map_address', true ) : '' ;
$event_map_lat 		= get_post_meta( $post_id , $prefix.'_event_map_lat', true ) ? get_post_meta( $post_id , $prefix.'_event_map_lat', true ) : '';
$event_map_lng 		= get_post_meta( $post_id , $prefix.'_event_map_lng', true ) ? get_post_meta( $post_id , $prefix.'_event_map_lng', true ) : '';

?>

<div class="ovaem_event_row">
	<label class="label">
		<strong><?php esc_html_e( 'Order', 'ovaem-events-manager' ); ?>:</strong>
	</label>
	<input 
		type="number" 
		value="<?php echo esc_attr( $order ); ?>" 
		placeholder="Insert number" 
		name="<?php echo esc_attr( $prefix ); ?>_order" />
</div>
<br/>
<div class="ovaem_event_row">
	<label class="label">
		<strong><?php esc_html_e( 'Featured', 'ovaem-events-manager' ); ?>:</strong>
	</label>
	<input 
		type="checkbox" 
		value="<?php echo esc_html( $checked ); ?>" 
		name="<?php echo esc_attr( $prefix ); ?>_featured" <?php echo esc_html( $checked ); ?> />
</div>
<br/>
<div class="ovaem_event_row">
	<label class="label">
		<strong><?php esc_html_e( 'Time', 'ovaem-events-manager' ); ?>:</strong>
	</label>
	<span><?php esc_html_e( 'From', 'ovaem-events-manager' ); ?></span>
	<input 
		type="text" 
		name="<?php echo esc_attr( $prefix ); ?>_date_start_time" 
		id="date_start_time" 
		class="ova_datepicker" 
		value="<?php echo esc_attr( $date_start_time ); ?>" 
		data-date_format="<?php echo esc_attr( $date_format ); ?>" 
		data-time_format="<?php echo esc_attr( $time_format ); ?>" 
		data-step="<?php echo esc_attr( $event_calendar_input_step ); ?>" 
		data-first-day="<?php echo esc_attr( OVAEM_Settings::first_day_of_week() ); ?>" 
		autocomplete="off" />
	<span><?php esc_html_e( 'to', 'ovaem-events-manager' ); ?></span>
	<input 
		type="text" 
		name="<?php echo esc_attr( $prefix ); ?>_date_end_time" 
		id="date_end_time" 
		class="ova_datepicker" 
		value="<?php echo esc_attr( $date_end_time ); ?>" 
		data-first-day="<?php echo esc_attr( OVAEM_Settings::first_day_of_week() ); ?>" 
		autocomplete="off" />
</div>
<br/>
<div class="ovaem_event_row">
	<label class="label">
		<strong><?php esc_html_e( 'Logo in PDF Ticket (.png)', 'ovaem-events-manager' ); ?>:</strong>
	</label>
	<br><br>
	<?php
		$value = '';
		
		if ( $logo_ticket ) {
			$image_attributes = wp_get_attachment_image_src( $logo_ticket, 'medium' );
			$src 	= $image_attributes[0];
			$value 	= $logo_ticket;
		}
	?>
	<div class="upload">
		<?php if ( $logo_ticket ) { ?>
			<img class="img_logo" data-src="<?php echo esc_url( $src ); ?>" src="<?php echo esc_url( $src ); ?>" width="100px"/>
		<?php } ?>
		    <img class="img_logo_2" src="" width="100px" style="display: none;"/>
		<div>
			<input type="hidden" name="<?php echo $prefix;?>_pdf_ticket_logo" value="<?php echo  esc_attr( $value ); ?>" />
			<button type="submit" class="upload_image_button button">
				<?php esc_html_e( 'Upload', 'ovaem-events-manager' ); ?>
			</button>
			<button type="submit" class="remove_image_button button">&times;</button>
		</div>
	</div>
</div>
<br/>
<div class="ovaem_event_row">
	<div class="ova_address">
		<label class="label">
			<strong><?php esc_html_e( 'Room', 'ovaem-events-manager' ); ?></strong>
		</label>		 	
		<input 
			type="text" 
			class="outside" 
			name="<?php echo esc_attr($prefix); ?>_address" 
			value="<?php echo esc_attr($address ); ?>" 
			size="30" />
		<br><br>
		<label class="label">
			<strong><?php esc_html_e( 'in Venue', 'ovaem-events-manager' ); ?></strong>
		</label>
		<select name="<?php echo esc_attr($prefix); ?>_venue" class="ovaem_venues">
			<option value=""><?php esc_html_e( "Select Venue", "ovaem-events-manager" ); ?></option>
			<?php foreach ( $venues as $ve ) {
				$selected = $ve->post_name == $venue ? 'selected' : '';
			?>
				<option value="<?php echo esc_attr( $ve->post_name ); ?>" <?php echo esc_attr( $selected ); ?>>
					<?php echo $ve->post_title; ?>
				</option>
			<?php } ?>
		</select>
		<br><br>
		<label class="label">
			<strong><?php esc_html_e( 'Address', 'ovaem-events-manager' ); ?></strong>
		</label>		 	
		<input 
			type="text" 
			class="outside" 
			name="<?php echo esc_attr($prefix); ?>_address_event" 
			value="<?php echo esc_attr($address_event ); ?>" 
			size="30" />
	</div>
</div>
<br>
<div class="ovaem_event_row">
	<div class="ovaevent_map">
		<label class="label">
			<strong><?php esc_html_e( 'Map', 'ovaem-events-manager' ); ?>:</strong>
		</label>
		<input 
			id="pac-input" 
			value="<?php echo esc_attr( $event_map_address ); ?>" 
			class="controls" 
			type="text" 
			placeholder="<?php esc_html_e( 'Enter a venue', 'ovaem-events-manager' ); ?>" />
		<div id="map"></div>
		<div id="infowindow-content">
			<span id="place-name" class="title"><?php echo esc_attr( $event_map_name ); ?></span><br>
			<span id="place-address"><?php echo esc_attr( $event_map_address ); ?></span>
		</div>
		<input 
			type="hidden" 
			value="<?php echo esc_attr( $event_map_name ); ?>" 
			name="<?php echo esc_attr( $prefix ); ?>_event_map_name" 
			id="map_name" />	
		<label>
			<?php esc_html_e( 'Address: ', 'ovaem-events-manager' ); ?>
			<input 
				type="text" 
				value="<?php echo esc_attr( $event_map_address ); ?>" 
				name="<?php echo esc_attr( $prefix ); ?>_event_map_address" 
				id="map_address" />
		</label>
		&nbsp;&nbsp;&nbsp;
		<label>
			<?php esc_html_e( 'Latitude: ', 'ovaem-events-manager' ); ?>
			<input 
				type="text" 
				value="<?php echo esc_attr( $event_map_lat ); ?>" 
				name="<?php echo esc_attr($prefix); ?>_event_map_lat" 
				id="map_lat" />
		</label>
		&nbsp;&nbsp;&nbsp;
		<label>
			<?php esc_html_e( 'Longitude: ', 'ovaem-events-manager' ); ?>
			<input 
				type="text" 
				value="<?php echo trim( esc_attr( $event_map_lng ) ); ?>" 
				name="<?php echo esc_attr( $prefix ); ?>_event_map_lng" 
				id="map_lng" />	
		</label>
	</div>
</div>