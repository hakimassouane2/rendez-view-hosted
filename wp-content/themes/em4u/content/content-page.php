
<?php the_content();?>


<?php 
$args = array(
	'before' => '<div class="ova_clearfix ova_page_pagination">'.esc_html__( 'Pages:', 'em4u' ),
	'after'	=> '</div>',
	'separator'        => '&nbsp;&nbsp;'
);
wp_link_pages( $args ); ?>