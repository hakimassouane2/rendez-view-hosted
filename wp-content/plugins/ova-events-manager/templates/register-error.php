<?php if ( !defined( 'ABSPATH' ) ) exit();
	get_header( );
?>
	<div class="container">
		<div class="row text-center register_event_error">
			<?php esc_html_e( "Please fill full require field in form or Tickets are sold out", "ovaem-events-manager" ); ?>
			<a href="#" onclick="window.history.go(-1); return false;" ><?php esc_html_e( "Go Back", "ovaem-events-manager" ); ?></a>		
		</div>
	</div>

<?php get_footer( );
