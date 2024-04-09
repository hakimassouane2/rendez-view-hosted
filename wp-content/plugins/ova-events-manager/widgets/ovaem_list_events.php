<?php if ( !defined( 'ABSPATH' ) ) exit();

class OVAEM_List_Events_Widget extends WP_Widget {

	private static $prefix = null;
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		
		self::$prefix = OVAEM_Settings::$prefix;

		parent::__construct(
			'ovaem_list_events_widget', // Base ID
			esc_html__( 'OVAEM List Events', 'ovaem-events-manager' ) // Name
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$html = '';

		$date_format = get_option('date_format');



		$events = apply_filters( 'ovaem_events_orderby', $instance['filter'], $instance['count'], $cat = '', $instance['orderby'], $instance['order'], $instance['show_past'] );

		$html .= '<div class="ovaem_list_events_widget"><ul>';

		if( $events->have_posts() ): while( $events->have_posts() ):  $events->the_post(); 
			
			$address = get_post_meta( get_the_id(), self::$prefix.'_address', true );

			$metabox_start_time = get_post_meta( get_the_id(), self::$prefix.'_date_start_time', true ) ? get_post_meta( get_the_id(), self::$prefix.'_date_start_time', true ) : '';
			$metabox_end_time = get_post_meta( get_the_id(), self::$prefix.'_date_end_time', true ) ? get_post_meta( get_the_id(), self::$prefix.'_date_end_time', true ) : '';


			$start_time = $metabox_start_time ? date_i18n( $date_format , $metabox_start_time ) : '';
			$end_time = $metabox_end_time ? date_i18n( $date_format, $metabox_end_time ) : '';

			
				$html .= '<li>';
				$html .= '<img src="'.get_the_post_thumbnail_url( get_the_id(), 'medium' ).'" class="img-responsive">';
				
				$html .= '<h3 class="widget_title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
				
				$html .= '</li>';
			

		endwhile; else :
		$html .= esc_html( "Not Found Events", "ovaem-events-manager" );
		endif;

		$html .= '</ul></div>';

		wp_reset_postdata();
		

        echo $html;
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$prefix = OVAEM_Settings::$prefix;
		$date_start_time = $prefix.'_date_start_time';
    	$date_end_time = $prefix.'_date_end_time';
    	$date_order = $prefix.'_order';
    	$date_created = 'date';


		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'List Events', 'ovaem-events-manager' );
		$filter = !empty( $instance['filter'] ) ? $instance['filter'] : '';
		$count = !empty( $instance['count'] ) ? $instance['count'] : '';
		$orderby = !empty( $instance['orderby'] ) ? $instance['orderby'] : '';
		$order = !empty( $instance['order'] ) ? $instance['order'] : '';
		$show_past = !empty( $instance['show_past'] ) ? $instance['show_past'] : '';
		
		?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php esc_attr_e( 'Filter :', 'ovaem-events-manager' ); ?></label> 
		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>">
			<option value="upcomming" <?php echo ($filter == 'upcomming') ? 'selected':''; ?> > <?php esc_html_e( "UpComing", "ovaem-events-manager" ); ?> </option>
			<option value="featured" <?php echo ($filter == 'featured') ? 'selected':''; ?> > <?php esc_html_e( "Featured", "ovaem-events-manager" ); ?> </option>
			<option value="past" <?php echo ($filter == 'past') ? 'selected':''; ?> > <?php esc_html_e( "Past", "ovaem-events-manager" ); ?> </option>
			<option value="creation_date" <?php echo ($filter == 'creation_date') ? 'selected':''; ?> > <?php esc_html_e( "Creation Date", "ovaem-events-manager" ); ?> </option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_attr_e( 'Count:', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_attr_e( 'Order by :', 'ovaem-events-manager' ); ?></label> 
		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
			<option value="<?php echo esc_attr($date_start_time); ?>" <?php echo ($orderby == $date_start_time) ? 'selected':''; ?> > <?php esc_html_e( "Start Time", "ovaem-events-manager" ); ?> </option>
			<option value="<?php echo esc_attr($date_end_time); ?>" <?php echo ($orderby == $date_end_time) ? 'selected':''; ?> > <?php esc_html_e( "End Time", "ovaem-events-manager" ); ?> </option>
			<option value="<?php echo esc_attr($date_order); ?>" <?php echo ($orderby == $date_order) ? 'selected':''; ?> > <?php esc_html_e( "Order field in event attribute", "ovaem-events-manager" ); ?> </option>
			<option value="<?php echo esc_attr($date_created); ?>" <?php echo ($orderby == $date_created) ? 'selected':''; ?> > <?php esc_html_e( "Created date", "ovaem-events-manager" ); ?> </option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_attr_e( 'Order :', 'ovaem-events-manager' ); ?></label> 
		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
			<option value="ASC" <?php echo ($order == 'ASC') ? 'selected':''; ?> > <?php esc_html_e( "Increase", "ovaem-events-manager" ); ?> </option>
			<option value="DESC" <?php echo ($order== 'DESC') ? 'selected':''; ?> > <?php esc_html_e( "Decrease", "ovaem-events-manager" ); ?> </option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_past' ) ); ?>"><?php esc_attr_e( 'Show Past Event :', 'ovaem-events-manager' ); ?></label> 
		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_past' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_past' ) ); ?>">
			<option value="true" <?php echo ($show_past == 'true') ? 'selected':''; ?> > <?php esc_html_e( "Yes", "ovaem-events-manager" ); ?> </option>
			<option value="false" <?php echo ($show_past == 'false') ? 'selected':''; ?> > <?php esc_html_e( "No", "ovaem-events-manager" ); ?> </option>
		</select>
		</p>

		


		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		
		$prefix = OVAEM_Settings::$prefix;
		$date_start_time = $prefix.'_date_start_time';

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['filter'] = ( ! empty( $new_instance['filter'] ) ) ? strip_tags( $new_instance['filter'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
		$instance['order'] = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
		$instance['show_past'] = ( ! empty( $new_instance['show_past'] ) ) ? strip_tags( $new_instance['show_past'] ) : '';

		return $instance;
	}

}

function register_ovaem_list_events_widget() {
    register_widget( 'OVAEM_List_Events_Widget' );
}
add_action( 'widgets_init', 'register_ovaem_list_events_widget' );