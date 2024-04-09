<?php if ( !defined( 'ABSPATH' ) ) exit(); 

wp_enqueue_script('prettyphoto', EM4U_URI.'/assets/plugins/prettyphoto/jquery.prettyPhoto.js', array('jquery'),null,true);
wp_enqueue_style('prettyphoto', EM4U_URI.'/assets/plugins/prettyphoto/prettyPhoto.css', array(), null);

$galleries = get_post_meta( get_the_id(), 'ovaem_gallery_id', true); 
	if( $galleries ){
?>

	<div class="gallery_modern owl-carousel owl-theme">
		<?php foreach ($galleries as $key => $value) {
	  		$img_full = wp_get_attachment_image_src($value, 'full');
	  		$img_large_medium = wp_get_attachment_image_src($value, 'large_medium');

	  		$img_full_caption = get_the_title( $value );

	  	?>
		    <div class="item">
		    	<a href="<?php echo esc_url( $img_full[0] ); ?>" data-gal="prettyPhoto[gal]">
		      		<img class="owl-lazy"  data-src="<?php echo esc_url( $img_large_medium[0] ); ?>" alt="<?php echo esc_attr($img_full_caption); ?>" />
		      	</a>
		    </div>
	    <?php } ?>		
	</div>


<?php }