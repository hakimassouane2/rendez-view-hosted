<?php if( !defined( 'ABSPATH' ) ) exit();

$post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : '';
$prefix = OVAEM_Settings::$prefix;

$label_schedule  = get_post_meta( $post_id, $prefix.'_label_schedule', true);
$label_speaker   = get_post_meta( $post_id, $prefix.'_label_speaker', true);
$label_sponsor   = get_post_meta( $post_id, $prefix.'_label_sponsor', true);
$label_organizer = get_post_meta( $post_id, $prefix.'_label_organizer', true);
$label_ticket    = get_post_meta( $post_id, $prefix.'_label_ticket', true);
$label_contact   = get_post_meta( $post_id, $prefix.'_label_contact', true);
$label_sidebar   = get_post_meta( $post_id, $prefix.'_label_sidebar', true);
$label_comment   = get_post_meta( $post_id, $prefix.'_label_comment', true);

?>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Schedule', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" name="<?php echo esc_attr($prefix); ?>_label_schedule" value="<?php echo esc_attr($label_schedule); ?>" placeholder="Insert Label" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Speaker', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" name="<?php echo esc_attr($prefix); ?>_label_speaker" value="<?php echo esc_attr($label_speaker); ?>" placeholder="Insert Label" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Sponsor', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" name="<?php echo esc_attr($prefix); ?>_label_sponsor" value="<?php echo esc_attr($label_sponsor); ?>" placeholder="Insert Label" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Organizer', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" name="<?php echo esc_attr($prefix); ?>_label_organizer" value="<?php echo esc_attr($label_organizer); ?>" placeholder="Insert Label" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Ticket', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" name="<?php echo esc_attr($prefix); ?>_label_ticket" value="<?php echo esc_attr($label_ticket); ?>" placeholder="Insert Label" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Contact', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" name="<?php echo esc_attr($prefix); ?>_label_contact" value="<?php echo esc_attr($label_contact); ?>" placeholder="Insert Label" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Sidebar Content', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" name="<?php echo esc_attr($prefix); ?>_label_sidebar" value="<?php echo esc_attr($label_sidebar); ?>" placeholder="Insert Label" />
</div>
<br/>

<div class="ovaem_event_row">
	<label class="label"><strong><?php esc_html_e( 'Comment', 'ovaem-events-manager' ); ?>: </strong></label>
	<input type="text" name="<?php echo esc_attr($prefix); ?>_label_comment" value="<?php echo esc_attr($label_comment); ?>" placeholder="Insert Label" />
</div>
<br/>