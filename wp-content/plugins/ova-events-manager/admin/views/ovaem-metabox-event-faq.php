<?php 

if( !defined( 'ABSPATH' ) ) exit();


$prefix = OVAEM_Settings::$prefix;

/* Add faq */
$count_faqs 	= isset( $_POST['count_faqs'] ) ? $_POST['count_faqs'] : '';
$add_faq		= isset( $_POST['add_faq'] ) ? $_POST['add_faq'] : '' ;


/* Load Schedule */
$event_id    		= isset( $_POST['event_id'] ) ? $_POST['event_id'] : '';


$faq_title = $prefix.'_faq_title';
$faq_desc_name = $prefix.'_faq_desc';
$faqs = array();

$faqs = get_post_meta( $event_id , $faq_title, true );

$faq_desc_value = get_post_meta( $event_id , $faq_desc_name, true );

if( $add_faq == 'yes' ){
	$faqs[$count_faqs] = '';
}



if( $faqs ){
	foreach ($faqs as $key => $value) {
		
		if($add_faq == 'yes') $key = $count_faqs;
		
		
 ?>
		<div class="faq_item faq_item_<?php echo esc_attr($key); ?>" data-faq-id="<?php echo esc_attr($key); ?>" data-prefix="<?php echo esc_attr($prefix); ?>">
		    	
			<div class="head">
				<div class="date_label">
					<a href="#" class="delete_faq" title="<?php esc_html_e( 'Remove faq', 'ovaem-events-manager' ); ?> ">
						<i class="fa fa-remove"></i>
					</a>
					<span class='label_title'><?php echo esc_attr($value) ?></span>
				</div>
				<div class="icon toggle_schedule"><a href="#"><i class="fa fa-arrows-v"></i></a> </div>
			</div>

			<div class="faq_content">
				
				<div class="ovaem_event_row faq_wrap">

					<label><?php esc_html_e( 'Title', 'ovaem-events-manager' ); ?></label>
					<input type="text"
						name="<?php echo esc_attr($faq_title); ?>[<?php echo esc_attr($key);?>]" 
						value="<?php echo esc_attr($value) ?>" class="faq_title" size="15" />
					<div class="clear clearfix"><br><br></div>
					<label><?php esc_html_e( 'Description', 'ovaem-events-manager' ); ?></label>
					<textarea name="<?php echo esc_attr($faq_desc_name); ?>[<?php echo esc_attr($key);?>]"  id="" cols="50" rows="5"><?php echo do_shortcode( $faq_desc_value[$key] ); ?></textarea>

				</div>

				
			</div>
			
		</div>

<?php }
} ?>

