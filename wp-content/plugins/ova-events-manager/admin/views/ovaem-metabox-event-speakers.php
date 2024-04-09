<?php 

if( !defined( 'ABSPATH' ) ) exit();

$event_id    			= isset( $_POST['event_id'] ) ? $_POST['event_id'] : '';
$pos_speaker 			= isset( $_POST['pos_speaker'] ) ? $_POST['pos_speaker'] : '';
$speaker_choosed_arr 	= substr( $_POST['speaker_choosed_arr'], 0 ,-1);
$speaker_choosed_array 	= explode( ",", $speaker_choosed_arr);
$orderby 	= OVAEM_Settings::list_speakers_orderby();
$order 		= OVAEM_Settings::list_speakers_order();

$args = array(
	'post_type' 		=> OVAEM_Settings::speaker_post_type_slug(),
	'post_status'		=> 'publish',
	'order'				=> $order,	
	'posts_per_page' 	=> -1
);

if ( 'date' === $orderby ) {
	$args['orderby'] = 'date';
} else if ( 'ovaem_speaker_order' === $orderby ) {
	$args['orderby'] 	= 'meta_value_num';
	$args['meta_key'] 	= $orderby;
} else if ( 'title' === $orderby ) {
	$args['orderby'] 	= 'title';
} else if ( 'ID' === $orderby ) {
	$args['orderby'] 	= 'ID';
} else {
	$args['orderby'] 	= 'title';
}

$query_speaker = new WP_Query($args);

?>

	<br/>
	<a href="#" class="add_speaker button button-large" data-pos-speaker="<?php echo esc_attr($pos_speaker);?>"><?php esc_html_e("Apply Speakers", "ovaem-events-manager"); ?> </a>
	<br/><br/>


	<table id="list_speakers" class="display speakers_list ">
		 <thead>
			<tr>
				<th><?php esc_html_e( "ID", "ovaem-events-manager" );  ?> </th>
				<th><?php esc_html_e( "Title", "ovaem-events-manager" ); ?></th>
				<th><?php esc_html_e( "Image", "ovaem-events-manager" ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if ( $query_speaker->have_posts() ) : while ( $query_speaker->have_posts() ) : $query_speaker->the_post(); global $post;  ?>
				<?php if( current_user_can( 'edit_post', $event_id ) || apply_filters( 'ovaem_show_speaker_for_vendor', false ) ) { ?>
					<tr class="content">
						<td><input type="checkbox" name="speaker_id" value="<?php echo trim( $post->post_name );?>" <?php echo in_array( trim( $post->post_name ), $speaker_choosed_array ) ? ' checked' : ''; ?> /></td>
						<td><?php echo get_the_title(); ?></td>
						<td><img src="<?php echo get_the_post_thumbnail_url(); ?>" width="30"></td>
					</tr>
				<?php } ?>

			<?php endwhile; endif;   ?>
			
			<?php $count = ceil( ( $query_speaker->post_count ) / 10 ) + 1; ?>
			<ul id="ovaem_pagin">
				<?php for ($i = 1; $i < $count; $i++) { $current = ($i==1) ? 'current': ''; ?>
					<li><a href="#" class="<?php echo esc_attr($current); ?>"><?php echo esc_attr($i); ?></a></li>
				<?php } ?>
			</ul>
			
	          
			
			<?php wp_reset_postdata(); ?>
		</tbody>
		
		
	</table>


	<br/>
	<a href="#" class="add_speaker button button-large" data-pos-speaker="<?php echo esc_attr($pos_speaker);?>"><?php esc_html_e("Apply Speakers", "ovaem-events-manager"); ?> </a>
	<br/><br/>



