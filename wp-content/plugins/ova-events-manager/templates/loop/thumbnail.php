<?php if ( !defined( 'ABSPATH' ) ) exit(); ?>

<?php if( is_archive() ){ ?>
	
	<?php the_post_thumbnail( 'medium' ); ?>
	

<?php }else if( is_single() ){ ?>

	<?php the_post_thumbnail( 'full' ); ?>
	

<?php } ?>



