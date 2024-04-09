<?php if ( !defined( 'ABSPATH' ) ) exit(); ?>
<?php

$prefix = OVAEM_Settings::$prefix;

$ovaem_map_lat = get_post_meta( get_the_id(), $prefix.'_map_lat', true );
$ovaem_map_lng = get_post_meta( get_the_id(), $prefix.'_map_lng', true );
$map_address = get_post_meta( get_the_id(), $prefix.'_map_address', true );

$show_map = get_post_meta( get_the_id(), $prefix.'_show_map', true );
if( $show_map == 'yes' ){
?>
<div id="ovaem_map" class="ovaem_map" data-lat="<?php echo esc_attr($ovaem_map_lat); ?>" data-lng="<?php echo esc_attr($ovaem_map_lng); ?>" data-address="<?php echo esc_attr($map_address); ?>"></div>
<?php } ?>