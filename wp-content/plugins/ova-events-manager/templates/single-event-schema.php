<?php if ( ! defined( 'ABSPATH' ) ) exit();
	/* Event Schema */
	$prefix 		=  OVAEM_Settings::$prefix;
	$date_format 	= get_option('date_format');
	$time_format 	= get_option('time_format');
	$id 			= get_the_id();
	$start_time 	= get_post_meta( $id, $prefix.'_date_start_time', true );
	$end_time 		= get_post_meta( $id, $prefix.'_date_end_time', true );
	$address 		= get_post_meta( $id, $prefix.'_address', true);
	$address_map 	= get_post_meta( $id, $prefix.'_event_map_address', true);
	$image 			= get_the_post_thumbnail_url( $id, 'full' );
	$desc 			= get_the_content() ? get_the_excerpt() : '';
	$venue 			= get_post_meta( $id, $prefix.'_venue', true );

	if ( $venue ) {
		$venue_post = get_page_by_path( $venue, OBJECT, 'venue' );
		$venue 		= $venue_post && is_object( $venue_post ) ? $venue_post->post_title : '';
	}

	$org_name 		= get_post_meta( $id, $prefix.'_org_name', true );
	$org_url 		= get_post_meta( $id, $prefix.'_org_website', true );
	$title 			= get_the_title();
	$start_date 	= $start_time ? date( 'Y-m-d H:i:s', $start_time ) : '';
	$end_date 		= $end_time ? date( 'Y-m-d H:i:s', $end_time ) : '';

	if ( $start_date ) {
		$start_date = date_format( date_create( $start_date, timezone_open( wp_timezone_string() ) ), 'c' );
	}

	if ( $end_date ) {
		$end_date = date_format( date_create( $end_date, timezone_open( wp_timezone_string() ) ), 'c' );
	}

	$tickets = array();

	if ( $ticket_arr = get_post_meta( $id, 'ovaem_ticket', true ) ) {
		foreach ( $ticket_arr as $key => $value ) {
			$validFrom_date = get_the_date( get_option( 'date_format' ) );
			$validFrom_time = get_the_date( get_option( 'time_format' ) );
			$validFrom 		= $validFrom_date . ' T ' . $validFrom_time;

			if ( $value['avaiable_date_selling'] == 'date_range' && $value['sell_date_start'] ) {
				$validFrom = $value['sell_date_start'];
			}

			$tickets[] = [
				"@type"			=> "Offer",
				"url" 			=> get_the_permalink(),
				"price" 		=> isset( $value['ticket_price'] ) ? $value['ticket_price'] : 0,
				"priceCurrency" => isset( $value['ticket_cur'] ) ? $value['ticket_cur'] : '',
				"availability" 	=> 'http://schema.org/InStock',
				"validFrom" 	=> $validFrom
			];
		}
	}

?>

<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "Event",
		"name": "<?php echo $title; ?>",
		"startDate": "<?php echo $start_date; ?>",
		"endDate": "<?php echo $end_date; ?>",
		"eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
		"eventStatus": "https://schema.org/EventScheduled",
		"location": 
		{
			"@type": "Place",
			"name": "<?php echo $address; ?>",
			"address": 
			{
				"@type": "PostalAddress",
				"streetAddress": "<?php echo $address_map; ?>",
				"addressLocality": "<?php echo $venue; ?>"
			}
		},
		"image": "<?php echo $image; ?>",
		"description": "<?php echo $desc; ?>",
		"offers": <?php echo json_encode( $tickets ); ?>,
		"performer": 
		{
			"@type": "Organization",
			"name": "<?php echo $org_name; ?>"
		},
		"organizer": {
	        "@type": "Organization",
	        "name": "<?php echo $org_name; ?>",
	        "url": "<?php echo $org_url; ?>"
	    }
	}
</script>