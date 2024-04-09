<?php if ( !defined( 'ABSPATH' ) ) exit();

class OVAEM_Special_Event_Widget extends WP_Widget {

	private static $prefix = null;
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		
		self::$prefix = OVAEM_Settings::$prefix;

		parent::__construct(
			'ovaem_special_event_widget', // Base ID
			esc_html__( 'OVAEM Special Event', 'ovaem-events-manager' ) // Name
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

		$event = apply_filters( 'ovaem_event', $instance['id'] );

		if( $event->have_posts() ): while( $event->have_posts() ):  $event->the_post(); 

			$metabox_start_time = get_post_meta( get_the_id(), self::$prefix.'_date_start_time', true ) ? get_post_meta( get_the_id(), self::$prefix.'_date_start_time', true ) : '';
			$metabox_end_time = get_post_meta( get_the_id(), self::$prefix.'_date_end_time', true ) ? get_post_meta( get_the_id(), self::$prefix.'_date_end_time', true ) : '';


			$start_time = $metabox_start_time ? date_i18n( $date_format , $metabox_start_time ) : '';
			$end_time = $metabox_end_time ? date_i18n( $date_format, $metabox_end_time ) : '';

			$html .= '<div class="ovaem_special_event_widget">';
				$html .= '<img src="'.get_the_post_thumbnail_url( get_the_id(), 'full' ).'" class="img-responsive">';
				$html .= '<h3 class="widget_title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
				$html .= '<div class="ovaem_time"><i class="icon_clock_alt"></i><span>'.$start_time.' - '.$end_time.'</span></div>';
			$html .= '</div>';

		endwhile;endif;

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

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Special Event', 'ovaem-events-manager' );
		$id = !empty( $instance['id'] ) ? $instance['id'] : '';
		?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php esc_attr_e( 'Select an event :', 'ovaem-events-manager' ); ?></label> 

		 <?php $events =  apply_filters( 'ovaem_events', 'ASC', -1 ); ?>


		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>">

			<?php if( $events->have_posts() ): while( $events->have_posts() ):  $events->the_post(); 

				$slug = get_post_field( 'post_name', get_the_ID() );
				$title = get_post_field( 'post_title', get_the_ID() );

				global $post; 
				$selected = ( $id == $slug ) ? 'selected="selected"' : '';
			?>
				<option value="<?php echo $slug; ?>" <?php echo esc_html($selected); ?> > <?php echo $title; ?> </option>
			<?php endwhile;endif; wp_reset_postdata(); ?>
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
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['id'] = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';

		return $instance;
	}

}

function register_ovaem_special_event_widget() {
    register_widget( 'ovaem_special_event_widget' );
}
add_action( 'widgets_init', 'register_ovaem_special_event_widget' );