<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class OVAEM_Coupon {
	
	private static $prefix = '';

	
	/**
	 * The Constructor
	 */
	public function __construct() {
		
		self::$prefix = OVAEM_Settings::$prefix;

		add_filter( 'ovaem_check_coupon', array( $this, 'ovaem_check_coupon' ), 10, 2  );
		add_filter( 'ovaem_total_with_coupon', array( $this, 'ovaem_total_with_coupon' ), 10, 3  );
		
		
		
	}


	public static function ovaem_check_coupon( $coupon_code, $sensitive = true ){
		
		$args_base = array(
			'post_type' => 'coupon',
			'post_status' => 'publish',
			'posts_per_page' => 1
		);

		$args_coupon = array(
			'meta_query' => array(
        		array(
	        		'key' => self::$prefix.'_coupon_code',
	        		'value' => $coupon_code,
	        		'compare' => '='
	        	)
        	)
		);

		$args_sensitive = array();
		if( $sensitive == true ){
			$args_sensitive = array(
				'meta_query' => array(
						'relation' => 'AND',
						array(
							'key' => self::$prefix.'_coupon_start_date',
							'value' => current_time( 'timestamp' ),
							'compare' => '<'
						),
						array(
							'key' => self::$prefix.'_coupon_end_date',
							'value' => current_time( 'timestamp' ),
							'compare' => '>='
						)
				)
			);	
		}
		

		$args = array_merge_recursive($args_base, $args_coupon, $args_sensitive);
		
		$coupons = new WP_Query($args);

		$coupon_arr = array();
		
		if( $coupons->have_posts() ): while( $coupons->have_posts() ): $coupons->the_post();
			$coupon_arr['type'] = get_post_meta( get_the_id(), self::$prefix.'_coupon_type', true );
			$coupon_arr['amount'] = intval( get_post_meta( get_the_id(), self::$prefix.'_coupon_amount', true ) );
			$coupon_arr['msg'] = esc_html__('Valid', 'ovaem-events-manager');
		endwhile; else:
			$coupon_arr['type'] = '';
			$coupon_arr['amount'] = 0 ;
			$coupon_arr['msg'] = esc_html__('InValid', 'ovaem-events-manager');
		endif;

		return $coupon_arr;

	}

	public static function ovaem_total_with_coupon( $coupon_arr = array(), $total = 0, $cur = '' ){

		$total_arr = array();

		

			if( ( $coupon_arr != null ) && ( $coupon_arr['type'] != '' ) ){
				if( $coupon_arr['type'] == 'percent' ){

					$total_finish = $total - $total*$coupon_arr['amount']/100;
					$total_arr['html'] = '<span class="total_finish">'.ovaem_format_price( $total_finish, $cur ) .'</span>';
					$total_arr['html'] .= '<span class="msg_coupon">'.esc_html__( ' ( Coupon: '.$coupon_arr['amount'].'% )', 'ovaem-events-manager' ).'</span>';

					$total_arr['raw'] = $total_finish;

				}else{

					$total_finish = $total - $coupon_arr['amount'];
					$total_arr['html'] = '<span class="total_finish">'.ovaem_format_price( $total_finish, $cur ) .'</span>';
					$total_arr['html'] .= '<span class="msg_coupon">'.esc_html__( ' ( Coupon: ', 'ovaem-events-manager' );
					$total_arr['html'] .= ovaem_format_price($coupon_arr['amount'], $cur);
					$total_arr['html'] .= ')</span>';

					$total_arr['raw'] = $total_finish;

				}

			}else{
				$total_arr['html'] = ovaem_format_price( $total, $cur );
				$total_arr['raw'] = $total;
			}

		
		return $total_arr;
	}




}

new OVAEM_Coupon();
