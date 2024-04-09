<?php if( !defined( 'ABSPATH' ) ) exit(); 

$prefix = OVAEM_Settings::$prefix;
$post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : '';

$contact_event = get_post_meta( $post_id , $prefix.'_contact_event', true ) ? get_post_meta( $post_id , $prefix.'_contact_event', true ) : '';

?>

<strong><?php esc_html_e( 'Insert shortcode of contact form 7 ', 'ovaem-events-manager' ); ?></strong><br>
<input type="text" name="<?php echo esc_attr($prefix); ?>_contact_event" value="<?php echo esc_attr($contact_event); ?>" size="50" style="border: 1px solid #ccc; height: 40px;"/>
<br>

<?php esc_html_e( 'You can find in menu: Contact >> Contact Forms. Example: [contact-form-7 id="1275" title="Contact Event"]', 'ovaem-events-manager' ); ?>