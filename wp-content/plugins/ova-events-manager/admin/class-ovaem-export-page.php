<?php 

if( !defined( 'ABSPATH' ) ) exit();


if( !class_exists( 'OVAEM_Admin_Export' ) ){

	/**
	 * Make Admin Class
	 */
	class OVAEM_Admin_Export{

		
		public function __construct(){
			add_action( 'admin_action_export', array( $this, 'admin_action_export' ) );
		}

		public static function create_admin_export_page(){
			$post_type = OVAEM_Settings::event_post_type_slug();

			$events = new WP_Query(
				array(
					'post_type' => $post_type,
					'post_status' => 'publish',
					'order'	=> 'ASC',
					'posts_per_page' => -1

				)
			);
			?>
			 <div class="wrap">

				<h1><?php esc_html_e( "Export Attendees", "ovaem-events-manager" ); ?></h1><br/>

				<form method="POST" action="<?php echo admin_url( 'admin.php' ); ?>">
	                <div class="metabox-prefs">

	                	<label><strong><?php esc_html_e('Choose fields to export', 'ovaem-events-manager'); ?> </strong></label><br>
                        <label ><input  name="check_list[]"  value="event"  type="checkbox" checked ><?php esc_html_e('Event Name','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="package"  type="checkbox" checked ><?php esc_html_e('Event Package','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="qrcode"  type="checkbox" checked ><?php esc_html_e('Code','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="verify"  type="checkbox" checked ><?php esc_html_e('Verify Status','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="checking"  type="checkbox" checked ><?php esc_html_e('Checking Status','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="attendee"  type="checkbox" checked ><?php esc_html_e('Attendee Name','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="email"  type="checkbox" checked ><?php esc_html_e('Attendee Email','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="phone"  type="checkbox" checked ><?php esc_html_e('Attendee Phone','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="address"  type="checkbox" checked ><?php esc_html_e('Attendee Address','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="company"  type="checkbox" checked ><?php esc_html_e('Attendee Company','ovaem-events-manager'); ?></label>
                        <label ><input  name="check_list[]"  value="description"  type="checkbox" checked ><?php esc_html_e('Attendee Description','ovaem-events-manager'); ?></label>
                        
                        <br>
                        <br>
	                    <label>
	                    	<strong><?php esc_html_e('Choose an Event to export or All', 'ovaem-events-manager'); ?> </strong>
	                    	<select name="export_event">

	                        	<option value="all"><?php esc_html_e( 'All Events', 'ovaem-events-manager' ); ?></option>

	                        	<?php if( $events->have_posts() ): while( $events->have_posts() ): $events->the_post(); ?>
			
										<option value="<?php echo get_the_id(); ?>"><?php echo get_the_title(); ?></option>

									<?php endwhile; else: ?>

									<?php return false;

									endif;	wp_reset_postdata();
	                        	?>

	                        </select>
	                    </label>

	                    <br/>
	                    <br />
	                    <label>
	                    	<strong><?php esc_html_e('Ticket: Verify Status', 'ovaem-events-manager'); ?> </strong>
	                    	<select name="verify_status">

	                        	<option value="all"><?php esc_html_e( 'All', 'ovaem-events-manager' ); ?></option>
	                        	<option value="true"><?php esc_html_e( 'Verify', 'ovaem-events-manager' ); ?></option>
	                        	<option value="false"><?php esc_html_e( 'Not Verify', 'ovaem-events-manager' ); ?></option>

	                        </select>
	                    </label>

	                    <br/>
	                    <br />
	                    <label>
	                    	<strong><?php esc_html_e('Ticket: Checking Status', 'ovaem-events-manager'); ?> </strong>
	                    	<select name="checking_status">

	                        	<option value="all"><?php esc_html_e( 'All', 'ovaem-events-manager' ); ?></option>
	                        	<option value="checked_in"><?php esc_html_e( 'Checked', 'ovaem-events-manager' ); ?></option>
	                        	<option value="not_checked_in"><?php esc_html_e( 'Not Checked', 'ovaem-events-manager' ); ?></option>

	                        </select>
	                    </label>

	                    	
	                        
	                        <br class="clear">
	                </div>
	                <br>
	                <input type="hidden" name="action" value="export">
	            	<input id="button" class="btn button" name="export" value="<?php esc_html_e( 'Export', 'ovaem-events-manager' ); ?>" type="submit" >
	            </form>

			</div>
		<?php }

		
		function admin_action_export(){



		    // filter
		    $filter = $verify_status_arg = $checking_status_arg = array();
		    $export_event = isset( $_POST['export_event'] ) ? $_POST['export_event'] : 'all';
		    $verify_status = isset( $_POST['verify_status'] ) ? $_POST['verify_status'] : 'all';
		    $checking_status = isset( $_POST['checking_status'] ) ? $_POST['checking_status'] : 'all';
		    

		    // SHow fields to export
		    $check_list = isset( $_POST['check_list'] ) ? $_POST['check_list'] : array();
		    


		    $basic = array(
				    	'post_type' => 'event_ticket',
						'post_status' => 'publish',
						'order'	=> 'ASC',
						'posts_per_page' => -1
				    );

		    if( $export_event != 'all'){
		    	$filter = array(
		    		'meta_query' => array(
		    			array(
						'key' => 'ovaem_ticket_event_id',
						'value' => $export_event,
						'compare' => '='
						)
					)
		    	);
		    }

		    if( $verify_status != 'all' ){
		    	$verify_status_arg = array(
		    		'meta_query' => array(
		    			array(
						'key' => 'ovaem_ticket_verify',
						'value' => $verify_status,
						'compare' => '='
						)
					)
		    	);
		    }

		    if( $checking_status != 'all' ){
		    	$checking_status_arg = array(
		    		'meta_query' => array(
		    			array(
						'key' => 'ovaem_ticket_status',
						'value' => $checking_status,
						'compare' => '='
						)
					)
		    	);
		    }

		    

		    $args = array_merge_recursive( $basic, $filter, $verify_status_arg, $checking_status_arg );

		    $tickets = new WP_Query( $args );

		    $csv_row = '';


		    $field_event = in_array('event', $check_list) ? esc_html__( 'Event', 'ovaem-events-manager' ) : '';
		    $field_package = in_array('package', $check_list) ? esc_html__( 'Package', 'ovaem-events-manager' ) : '';
		    $field_qrcode = in_array('qrcode', $check_list) ? esc_html__( 'QR Code', 'ovaem-events-manager' ) : '';
		    $field_verify = in_array('verify', $check_list) ? esc_html__( 'Verify Status', 'ovaem-events-manager' ) : '';
		    $field_checking = in_array('checking', $check_list) ? esc_html__( 'Checking Status', 'ovaem-events-manager' ) : '';
		    $field_attendee = in_array('attendee', $check_list) ? esc_html__( 'Attendee', 'ovaem-events-manager' ) : '';
		    $field_email = in_array('email', $check_list) ? esc_html__( 'Email', 'ovaem-events-manager' ) : '';
		    $field_phone = in_array('phone', $check_list) ? esc_html__( 'Phone', 'ovaem-events-manager' ) : '';
		    $field_address = in_array('address', $check_list) ? esc_html__( 'Address', 'ovaem-events-manager' ) : '';
		    $field_company = in_array('company', $check_list) ? esc_html__( 'Company', 'ovaem-events-manager' ) : '';
		    $field_description = in_array('description', $check_list) ? esc_html__( 'Description', 'ovaem-events-manager' ) : '';
		    

		    $csv_row .= $field_event ? $field_event."\t" : '';
			$csv_row .= $field_package ? $field_package."\t" : '';
			$csv_row .= $field_qrcode ? $field_qrcode."\t" : '';
			$csv_row .= $field_verify ? $field_verify."\t" : '';
		    $csv_row .= $field_checking ? $field_checking."\t" : '';
		    $csv_row .= $field_attendee ? $field_attendee."\t" : '';
		    $csv_row .= $field_email ? $field_email."\t" : '';
		    $csv_row .= $field_phone ? $field_phone."\t" : '';
		    $csv_row .= $field_address ? $field_address."\t" : '';
		    $csv_row .= $field_company ? $field_company."\t" : '';
		    $csv_row .= $field_description ? $field_description."\t" : '';
		    $csv_row .= "\r\n";
		    

	        $extra_field_export = '';
	        $get_fields = '';
	        

	        /* Write Data */
	        if( $tickets->have_posts() ): while( $tickets->have_posts() ): $tickets->the_post();

	        	global $post;
	        	
	        	// Event Name
	        	if( $field_event ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_event_name', true )."\t";

	        	}
	        	

	        	// Package
	        	if( $field_package ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_event_package', true )."\t";
	        	}

	        	// QR Code
	        	if( $field_qrcode ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_code', true )."\t";
	        	}
	        	
	        	

	        	// Verify
	        	if( $field_verify ){
	        		if( get_post_meta( $post->ID, 'ovaem_ticket_verify', true ) == 'true' ){
		        		$csv_row .= esc_html__( 'Verify', 'ovaem-events-manager' )."\t";
		        	}else{
		        		$csv_row .= esc_html__( 'Not Verify', 'ovaem-events-manager' )."\t";
		        	}	
	        	}
	        	
	        	

	        	// Checking
	        	if( $field_checking ){
		        	if( get_post_meta( $post->ID, 'ovaem_ticket_status', true ) == 'checked_in' ){
		        		$csv_row .= esc_html__( 'Checked in', 'ovaem-events-manager' )."\t";
		        	}else{
		        		$csv_row .= esc_html__( 'Not Checked', 'ovaem-events-manager' )."\t";
		        	}
	        	}
	        	


	        	// Buyer name
	        	if( $field_attendee ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_buyer_name', true )."\t";
	        	}
	        	

	        	// Buyer email
	        	if( $field_email ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_buyer_email', true )."\t";
	        	}
	        	
	        	// Buyer phone
	        	if( $field_phone ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_buyer_phone', true )."\t";
	        	}

	        	// Buyer address
	        	if( $field_address ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_buyer_address', true )."\t";
	        	}

	        	// Buyer company
	        	if( $field_company ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_buyer_company', true )."\t";
	        	}

	        	// Buyer description
	        	if( $field_description ){
	        		$csv_row .= get_post_meta( $post->ID, 'ovaem_ticket_buyer_desc', true )."\t";	
	        	}

	        	$csv_row .= "\r\n";

	        endwhile;endif;

	        $csv = chr(255).chr(254).mb_convert_encoding($csv_row, "UTF-16LE", "UTF-8");

	       
	        header("Content-type: application/x-msdownload");
			header("Content-disposition: csv; filename=" . date("Y-m-d") ."_Attendee_List.csv; size=".strlen($csv));

			echo $csv;
	       
            exit();
		    
		}



	}
	new OVAEM_Admin_Export();


	

}