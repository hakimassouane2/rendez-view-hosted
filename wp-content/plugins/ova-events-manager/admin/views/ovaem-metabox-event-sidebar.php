<?php if( !defined( 'ABSPATH' ) ) exit(); 

$prefix = OVAEM_Settings::$prefix;
$post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : '';

$event_sidebar = get_post_meta( $post_id , $prefix.'_event_sidebar', true ) ? get_post_meta( $post_id , $prefix.'_event_sidebar', true ) : '';

?>

<strong><?php esc_html_e( 'Content display in Sidebar of Event. You can insert Shortcode, HTML Tag here ', 'ovaem-events-manager' ); ?></strong><br>
<textarea name="<?php echo esc_attr($prefix); ?>_event_sidebar" style="width: 500px; height: 300px;"><?php echo $event_sidebar; ?></textarea>
<br>


