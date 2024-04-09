<?php if ( !defined( 'ABSPATH' ) ) exit(); ?>

<?php if( is_archive() ){ ?>
	
	<h2 class="ovaem_event_title" ><a href="<?php the_permalink(); ?> "><?php the_title(); ?></a></h2>

<?php }else if( is_single() ){ ?>

	<h1 class="ovaem_event_title" ><?php the_title(); ?></h1>

<?php } ?>
