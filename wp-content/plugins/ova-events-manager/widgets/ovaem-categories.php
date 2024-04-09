<?php if ( !defined( 'ABSPATH' ) ) exit();

class OVAEM_Categories_Widget extends WP_Widget {

	private static $prefix = null;
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		
		self::$prefix = OVAEM_Settings::$prefix;

		parent::__construct(
			'OVAEM_Categories_Widget', // Base ID
			esc_html__( 'OVAEM All Categories', 'ovaem-events-manager' ) // Name
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
		$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();

		$cats = apply_filters( 'ovaem_get_categories', 10 );
		echo "<ul class='ovaem_list_categories_widget'>";
			foreach ($cats as $key => $value) {
				
				$terms = get_term( $value->term_id, OVAEM_Settings::slug_taxonomy_name(), object );

				echo '<li><a href="'.home_url('/').'?'.$slug_taxonomy_name.'='.$value->slug.'">'.$value->name.'</a><span class="count">'.$terms->count.'</span></li>';
				
				
			}
		echo "</ul>";


		
		
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

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'All Categories', 'ovaem-events-manager' );
		
		?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
	

		return $instance;
	}

}

function register_ovaem_categories_widget() {
    register_widget( 'OVAEM_Categories_Widget' );
}
add_action( 'widgets_init', 'register_ovaem_categories_widget' );