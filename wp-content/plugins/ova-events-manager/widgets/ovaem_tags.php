<?php if ( !defined( 'ABSPATH' ) ) exit();

class OVAEM_Tags_Event_Widget extends WP_Widget {

	private static $prefix = null;
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		
		self::$prefix = OVAEM_Settings::$prefix;

		parent::__construct(
			'OVAEM_Tags_Event_Widget', // Base ID
			esc_html__( 'OVAEM Tags Event', 'ovaem-events-manager' ) // Name
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

		if ( ! empty( $instance['tag_number'] ) ) {
			$tag_number = apply_filters( 'widget_title', $instance['tag_number'] );
		}

		$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();

		$tag_args = array(
			'smallest'                  => 8, 
			'largest'                   => 22,
			'unit'                      => 'pt', 
			'number'                    => $tag_number,  
			'format'                    => 'flat',
			'separator'                 => "\n",
			'orderby'                   => 'name', 
			'order'                     => 'ASC',
			'exclude'                   => null, 
			'include'                   => null, 
			'link'                      => 'view', 
			'taxonomy'                  => array( 'event_tags' ), 
			'echo'                      => false,
			'child_of'                  => null, // see Note!
		);

		$html = '<div class="ovaem_event_tags_widget">'.wp_tag_cloud($tag_args ).'</div>';

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

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Tags Events', 'ovaem-events-manager' );
		$tag_number = !empty( $instance['tag_number'] ) ? $instance['tag_number'] : '15';
		
		?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'tag_number' ) ); ?>"><?php esc_attr_e( 'Tag Number:', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tag_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag_number' ) ); ?>" type="number" value="<?php echo esc_attr( $tag_number ); ?>">
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
		$instance['tag_number'] = ( ! empty( $new_instance['tag_number'] ) ) ? strip_tags( $new_instance['tag_number'] ) : '15';
	

		return $instance;
	}

}

function register_ovaem_tags_event_widget() {
    register_widget( 'OVAEM_Tags_Event_Widget' );
}
add_action( 'widgets_init', 'register_ovaem_tags_event_widget' );