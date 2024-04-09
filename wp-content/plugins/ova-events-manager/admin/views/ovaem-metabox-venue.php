<?php 

if( !defined( 'ABSPATH' ) ) exit();


global $post;

$prefix = OVAEM_Settings::$prefix;
$post_id    = $post->ID;

$venue_order = get_post_meta( $post_id , $prefix.'_venue_order', true ) ? get_post_meta( $post_id , $prefix.'_venue_order', true ) : 1;
$venue_featured = get_post_meta( $post_id , $prefix.'_venue_featured', true ) ? get_post_meta( $post_id , $prefix.'_venue_featured', true ) : 'no';

$venue_phone = get_post_meta( $post_id , $prefix.'_venue_phone', true );
$venue_fax = get_post_meta( $post_id , $prefix.'_venue_fax', true );
$venue_email = get_post_meta( $post_id , $prefix.'_venue_email', true );
$venue_address = get_post_meta( $post_id , $prefix.'_venue_address', true );
$venue_venue_social = get_post_meta( $post_id , $prefix.'_venue_venue_social', true );
$venue_wd_inweek = get_post_meta( $post_id , $prefix.'_venue_wd_inweek', true );
$venue_wd_saturday = get_post_meta( $post_id , $prefix.'_venue_wd_saturday', true );
$venue_wd_sunday = get_post_meta( $post_id , $prefix.'_venue_wd_sunday', true );
$venue_weblink = get_post_meta( $post_id , $prefix.'_venue_weblink', true );


$map_name 		= get_post_meta( $post_id , $prefix.'_map_name', true ) ? get_post_meta( $post_id , $prefix.'_map_name', true ) : esc_html__('New York', 'ovaem-events-manager');
$map_address 	= get_post_meta( $post_id , $prefix.'_map_address', true ) ? get_post_meta( $post_id , $prefix.'_map_address', true ) : esc_html__('New York, NY, USA', 'ovaem-events-manager') ;
$map_lat 		= get_post_meta( $post_id , $prefix.'_map_lat', true ) ? get_post_meta( $post_id , $prefix.'_map_lat', true ) : '40.7127837';
$map_lng 		= get_post_meta( $post_id , $prefix.'_map_lng', true ) ? get_post_meta( $post_id , $prefix.'_map_lng', true ) : '-74.0059413';

// map
$show_map = get_post_meta( $post_id, $prefix.'_show_map', true );

?>

 <div class="container-fluid">
 	<div class="row">

 		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Order', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_order); ?>"  name="<?php echo esc_attr($prefix);?>_venue_order" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Featured', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<select name="<?php echo esc_attr($prefix);?>_venue_featured">
		 		<option value="no" <?php echo ($venue_featured == 'no' ) ? 'selected' : ''; ?> ><?php esc_html_e( 'No', 'ovaem-events-manager' ); ?> </option>
		 		<option value="yes" <?php echo ($venue_featured == 'yes' ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Yes', 'ovaem-events-manager' ); ?> </option>
		 	</select>
		</div>
		<br>
 		- - - - - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - - - - - -
 		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Email', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_email); ?>"  name="<?php echo esc_attr($prefix);?>_venue_email" />
		</div>

 		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Phone', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_phone); ?>"  name="<?php echo esc_attr($prefix);?>_venue_phone" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Fax', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_fax); ?>"  name="<?php echo esc_attr($prefix);?>_venue_fax" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Address', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_address); ?>"  name="<?php echo esc_attr($prefix);?>_venue_address" />
		</div>

		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Web link', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_weblink); ?>"  name="<?php echo esc_attr($prefix);?>_venue_weblink" />
		</div>
		<br>
		- - - - - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - - - - - -
		<!-- Working Hour -->
		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Working days', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_wd_inweek); ?>"  name="<?php echo esc_attr($prefix);?>_venue_wd_inweek" />
		</div>
		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Saturday', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_wd_saturday); ?>"  name="<?php echo esc_attr($prefix);?>_venue_wd_saturday" />
		</div>
		<div class="ovaem_event_row">
 			<br/>
		 	<label class="label"><strong><?php esc_html_e( 'Sunday', 'ovaem-events-manager' ); ?>: </strong></label>
		 	<input type="text" size="40" value="<?php echo esc_attr($venue_wd_sunday); ?>"  name="<?php echo esc_attr($prefix);?>_venue_wd_sunday" />
		</div>
		

		<br>
		- - - - - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - - - - - -
		 <div class="ovaem_event_row">
		 	<div class="ova_show_map">
		 		<br/>
		 		<label class="label"><strong><?php esc_html_e( 'Show Map', 'ovaem-events-manager' ); ?>: </strong></label>

				<select name="<?php echo esc_attr($prefix); ?>_show_map" class="ovaem_show_map">
					<?php
						$selected_yes = ( $show_map == 'yes' ) ? 'selected' : '';
						$selected_no = ( $show_map == 'no' ) ? 'selected' : '';
					?>
					<option value="yes" <?php echo esc_attr($selected_yes); ?> >
						<?php esc_html_e( "Yes", "ovaem-events-manager" ); ?>
					</option>

					<option value="no" <?php echo esc_attr($selected_no); ?> >
						<?php esc_html_e( "No", "ovaem-events-manager" ); ?> 
					</option>
				</select>

				<br/>
		 	</div>
		 </div>

		 <br/>
		 <div class="ovaem_event_row">
		 	<div class="ovaevent_map">
		 		<label class="label"><strong><?php esc_html_e( 'Map', 'ovaem-events-manager' ); ?>: </strong></label>
				<input id="pac-input" value="<?php echo esc_attr($map_address); ?>" class="controls" type="text" placeholder="<?php esc_html_e( 'Enter a venue', 'ovaem-events-manager' ); ?>">
			    <div id="map"></div>
			    <div id="infowindow-content">
			      <span id="place-name"  class="title"><?php echo esc_attr($map_name); ?></span><br>
			      <span id="place-address"><?php echo esc_attr($map_address); ?></span>
			    </div>
			    <input type="hidden" value="<?php echo esc_attr($map_name); ?>" name="<?php echo esc_attr($prefix); ?>_map_name" id="map_name"  />	
			    <label>
			    	<?php esc_html_e( 'Address: ', 'ovaem-events-manager' ); ?>
			    	<input type="text" value="<?php echo esc_attr($map_address); ?>" name="<?php echo esc_attr($prefix); ?>_map_address" id="map_address" />
			    </label>
			    &nbsp;&nbsp;&nbsp;
			    <label>
			    	<?php esc_html_e( 'Latitude: ', 'ovaem-events-manager' ); ?>
			    	<input type="text" value="<?php echo esc_attr($map_lat); ?>" name="<?php echo esc_attr($prefix); ?>_map_lat" id="map_lat"  />	
			    </label>
			    &nbsp;&nbsp;&nbsp;
			    <label>
			    	<?php esc_html_e( 'Longitude: ', 'ovaem-events-manager' ); ?>
			    	<input type="text" value="<?php echo trim(esc_attr($map_lng)); ?>" name="<?php echo esc_attr($prefix); ?>_map_lng" id="map_lng" />	
			    </label>
		    </div>
		</div>

		

		
 	</div>
 </div>

 

<?php wp_nonce_field( 'ova_events_nonce', 'ova_events_nonce' ); ?>
 