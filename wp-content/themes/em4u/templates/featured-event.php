<?php if ( !defined( 'ABSPATH' ) ) exit();

/** Template Name: Featured Event Template */

get_header( );

if( class_exists('OVAEM') ){

	ovaem_get_template( 'archive-event.php' );
	
}else{ ?>
	<div class="container" style="margin: 60px auto">

		<?php esc_html_e( 'Please active Ovatheme Events Manager Plugin to use this page template', 'em4u' ); ?>

	</div>
<?php }

get_footer( );