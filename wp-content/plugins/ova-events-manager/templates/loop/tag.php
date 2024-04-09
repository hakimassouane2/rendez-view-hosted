<?php if ( !defined( 'ABSPATH' ) ) exit;

$event_tags = get_the_terms( get_the_id(), 'event_tags') ;

if( !empty( $event_tags) ){ ?>
	<div class="ovaem_tags">

		<span><i class="icon_tags_alt"></i><?php esc_html_e('Tags: ', 'ovaem-events-manager'); ?></span>

		<ul>
			<?php foreach ($event_tags as $key => $value) { ?>
				<li>
					<a href="<?php echo  add_query_arg( 'event_tags', esc_attr( $value->slug ), home_url('/') ); ?>"><?php echo esc_html( $value->name ); ?></a>
				</li>	
			<?php } ?>
		
		</ul>

	</div>
<?php } ?>