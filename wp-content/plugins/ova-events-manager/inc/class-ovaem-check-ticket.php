<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class OVAEM_Check_Ticket {
	
	/**
	 * The Constructor
	 */
	public function __construct() {

		add_filter( 'ovaem_check_ticket', array( $this, 'ovaem_check_ticket' ), 10, 1  );
		add_filter( 'ovame_check_qrcode_ticket', array( $this, 'ovame_check_qrcode_ticket' ), 10, 1  );
		
	}


	public function ovaem_check_ticket( $id ){

		$args = array(
			'post_type' => 'event_order',
			'post_status' => 'publish',
			'name'	=> $id
		);
		
		$result = new WP_Query($args);
		
		if( $result->post_count != 0){
			return $result;
		}else{
			return false;
		}
	}

	// Check ticket New Version
	public function ovame_check_qrcode_ticket( $code ){

		
		$args = array(
			'post_type' => 'event_ticket',
			'post_status' => 'publish',
			'meta_query' => array(
				'relation' => 'AND',
                array(
                    'key' => 'ovaem_ticket_verify',
                    'value' => 'true',
                    'compare' => '='
                ),
                array(
                    'key' => 'ovaem_ticket_code',
                    'value' => $code,
                    'compare' => '='
                ),
                array(
                    'key' => 'ovaem_ticket_status',
                    'value' => 'not_checked_in',
                    'compare' => '='
                )
            )
		);
		
		$result = new WP_Query($args);
		
		if( $result->have_posts() ): while( $result->have_posts() ): $result->the_post();
			
			if( is_admin() || is_super_admin() ){
				update_post_meta( get_the_id(), 'ovaem_ticket_status', 'checked_in', 'not_checked_in' );
			}
			$buyer['name'] = get_post_meta( get_the_id(), 'ovaem_ticket_buyer_name', true );
			$buyer['email'] = get_post_meta( get_the_id(), 'ovaem_ticket_buyer_email', true );
			$buyer['phone'] = get_post_meta( get_the_id(), 'ovaem_ticket_buyer_phone', true );
			$buyer['address'] = get_post_meta( get_the_id(), 'ovaem_ticket_buyer_address', true );
			$buyer['company'] = get_post_meta( get_the_id(), 'ovaem_ticket_buyer_company', true );
			$buyer['desc'] = get_post_meta( get_the_id(), 'ovaem_ticket_buyer_desc', true );

			$buyer['code'] = get_post_meta( get_the_id(), 'ovaem_ticket_code', true );
			$buyer['event'] = get_post_meta( get_the_id(), 'ovaem_ticket_event_name', true );
			$buyer['package'] = get_post_meta( get_the_id(), 'ovaem_ticket_event_package', true );
			$buyer['start_time'] = get_post_meta( get_the_id(), 'ovaem_ticket_event_start_time', true );
			$buyer['end_time'] = get_post_meta( get_the_id(), 'ovaem_ticket_event_end_time', true );
			$buyer['venue'] = get_post_meta( get_the_id(), 'ovaem_ticket_event_venue', true );
			$buyer['address'] = get_post_meta( get_the_id(), 'ovaem_ticket_event_address', true );
			$buyer['orderid'] = get_post_meta( get_the_id(), 'ovaem_ticket_from_order_id', true );

			return $buyer;

		endwhile; else:

			return false;

		endif;	wp_reset_postdata();
		
	}


}

new OVAEM_Check_Ticket();
