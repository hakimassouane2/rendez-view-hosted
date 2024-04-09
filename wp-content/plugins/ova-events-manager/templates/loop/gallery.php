<?php if ( !defined( 'ABSPATH' ) ) exit(); ?>

<?php $galleries = get_post_meta( get_the_id(), 'ovaem_gallery_id', true); 
	if( $galleries ){
?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

	  <!-- Indicators -->
	  <ol class="carousel-indicators">
	  	<?php foreach ($galleries as $key => $value) {
	  		$active =  ( $key == 0 )? 'active': '';
	  	?>
	    <li data-target="#carousel-example-generic" data-slide-to="<?php echo esc_attr($key) ?>" class="<?php echo esc_attr($active); ?>"></li>
	    <?php } ?>
	  </ol>

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox">

	  	<?php foreach ($galleries as $key => $value) {
	  		$active =  ( $key == 0 )? 'active': '';
	  		$images = wp_get_attachment_image_src($value, 'full');
	  	?>
		    <div class="item <?php echo esc_attr($active); ?>">
		      <img src="<?php echo esc_url( $images[0] ); ?>" alt="<?php echo esc_attr($key); ?>">
		    </div>
	    <?php } ?>
	  </div>

	  <!-- Controls -->
	  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only"><?php esc_html_e( "Previous", "ovaem-events-manager" ); ?></span>
	  </a>
	  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only"><?php esc_html_e( "Next", "ovaem-events-manager" ); ?></span>
	  </a>
</div>




<?php }