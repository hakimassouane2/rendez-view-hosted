<?php if ( !defined( 'ABSPATH' ) ) exit();

class OVAEM_Search_Event_Widget extends WP_Widget {

	private static $event_post_type_slug = null;
	

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'ovaem_search_event_widget', // Base ID
			esc_html__( 'OVAEM Search Event', 'ovaem-events-manager' ) // Name
		);

		self::$event_post_type_slug = OVAEM_Settings::event_post_type_slug();
		

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
		
		$date_format = 'd M Y';

       	
       	$cats = apply_filters('ovaem_get_categories', '');
       	$venues = apply_filters('ovaem_venues', '');
       	

       	$class = ( !empty( $instance['class'] ) ) ? $instance['class'] : '';
       	$intro = ( !empty( $instance['intro'] ) ) ? $instance['intro'] : '';
       	$show_name = ( !empty( $instance['show_name'] ) ) ? $instance['show_name'] : 'yes';
       	
       	$show_venue = ( !empty( $instance['show_venue'] ) ) ? $instance['show_venue'] : 'yes';
       	$show_cat = ( !empty( $instance['show_cat'] ) ) ? $instance['show_cat'] : 'yes';
       	$show_time = ( !empty( $instance['show_time'] ) ) ? $instance['show_time'] : 'yes';
       	$show_date = ( !empty( $instance['show_date'] ) ) ? $instance['show_date'] : 'yes';

       	$show_states = ( !empty( $instance['show_states'] ) ) ? $instance['show_states'] : 'yes';
       	$show_cities = ( !empty( $instance['show_cities'] ) ) ? $instance['show_cities'] : 'yes';

       	$show_past = ( !empty( $instance['show_past'] ) ) ? $instance['show_past'] : 'yes';
       	$show_feature = ( !empty( $instance['show_feature'] ) ) ? $instance['show_feature'] : 'yes';

       	$show_today = ( !empty( $instance['show_today'] ) ) ? $instance['show_today'] : 'yes';
       	$show_tomorrow = ( !empty( $instance['show_tomorrow'] ) ) ? $instance['show_tomorrow'] : 'yes';
       	$show_this_week = ( !empty( $instance['show_this_week'] ) ) ? $instance['show_this_week'] : 'yes';
       	$show_this_weekend = ( !empty( $instance['show_this_weekend'] ) ) ? $instance['show_this_weekend'] : 'yes';
       	$show_next_week = ( !empty( $instance['show_next_week'] ) ) ? $instance['show_next_week'] : 'yes';
       	$show_next_month = ( !empty( $instance['show_next_month'] ) ) ? $instance['show_next_month'] : 'yes';


       	$get_name = isset( $_REQUEST['name_event'] ) ? esc_attr($_REQUEST['name_event']) : '';
       	$get_address = isset( $_REQUEST['address'] ) ? esc_attr($_REQUEST['address']) : '';
       	$get_venue = isset( $_REQUEST['name_venue'] ) ? esc_attr($_REQUEST['name_venue']) : '';
       	$get_cat = isset( $_REQUEST['cat'] ) ? esc_attr($_REQUEST['cat']) : '';
       	$get_time = isset( $_REQUEST['time'] ) ? esc_attr($_REQUEST['time']) : '';
       	$get_date_from = isset( $_REQUEST['ovaem_date_from'] ) ? esc_attr($_REQUEST['ovaem_date_from']) : '';
       	$get_date_to = isset( $_REQUEST['ovaem_date_to'] ) ? esc_attr($_REQUEST['ovaem_date_to']) : '';

       	$name_country = isset( $_GET["name_country"] ) ? $_GET["name_country"] : '';
       	$country = apply_filters( 'ovaem_get_country', $name_country );

       	$name_city = isset( $_GET["name_city"] ) ? $_GET["name_city"] : '';
       	$city = apply_filters( 'ovaem_get_city', $name_city );

        $html = '<div class="ovaem_search_event search_event_widget '.$class.'">';
        	$html .= $intro ? '<h6 class="search_title">'.$intro.'</h6>' : '';
        	$html .= '<form action="'.home_url('/').'" method="GET" name="search_event" >';

        		$html .= ($show_name == 'yes') ? '<div class="ovaem_name_event"><input class="form-controll" placeholder="'.esc_html__('Enter Name ...', 'ovaem-events-manager').'" name="name_event" value="'.esc_attr($get_name).'" /></div>' : '';

        		if($show_cat == 'yes'){
	        		$html .= '<div class="ovaem_cat">';
		    			$html .= '<select name="cat" class="selectpicker ">';
		    				$html .= '<option value="">'.esc_html__('All Categories', 'ovaem-events-manager').'</option>';
		    					foreach ($cats as $key => $value) {
		    						$selected = ($value->slug == $get_cat) ? 'selected="selected"' : '';

		    						$html .= '<option value="'.$value->slug.'" '.$selected.'>'.$value->name.'</option>';
		    					}
		    			$html .= '</select>';
					$html .= '</div>';
				}
        		

        		if($show_venue == 'yes'){
	        		$html .= '<div class="ovaem_venue">';
		    			$html .= '<select name="name_venue" class="selectpicker ">';
		    				$html .= '<option value="">'.esc_html__('All Venue', 'ovaem-events-manager').'</option>';
		    					if($venues->have_posts() ) : while ( $venues->have_posts() ) : $venues->the_post(); 

										global $post;
										$selected = ( $post->post_name == $get_venue) ? 'selected' : '';

										$html .= '<option value="'.$post->post_name.'" '.$selected.'>
											'.get_the_title().'</option>';

									endwhile;endif;
		    					
		    			$html .= '</select>';
					$html .= '</div>';
				}

        		
				if($show_time == 'yes'){

					$select_today = ($get_time == 'today') ? 'selected="selected"' : '';
					$select_tomorrow = ($get_time == 'tomorrow') ? 'selected="selected"' : '';
					$select_this_week = ($get_time == 'this_week') ? 'selected="selected"' : '';
					$select_this_week_end = ($get_time == 'this_week_end') ? 'selected="selected"' : '';
					$select_next_week = ($get_time == 'next_week') ? 'selected="selected"' : '';
					$select_next_month = ($get_time == 'next_month') ? 'selected="selected"' : '';
					$select_past = ($get_time == 'past') ? 'selected="selected"' : '';
					$select_future = ($get_time == 'future') ? 'selected="selected"' : '';

	        		$html .= '<div class="ovaem_time">';
	        			$html .= '<select name="time" class="selectpicker select_alltime ">';

	        				$html .= '<option value="">'.esc_html__('All Time', 'ovaem-events-manager').'</option>';

	        				$html .= $show_today == 'yes' ? '<option value="today" '.$select_today.'>'.esc_html__('Today', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_tomorrow == 'yes' ? '<option value="tomorrow" '.$select_tomorrow.'>'.esc_html__('Tomorrow', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_this_week == 'yes' ? '<option value="this_week" '.$select_this_week.'>'.esc_html__('This Week', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_this_weekend == 'yes' ? '<option value="this_week_end" '.$select_this_week_end.'>'.esc_html__('This Weekend', 'ovaem-events-manager').'</option>' : '';

	        				$html .=  $show_next_week == 'yes' ? '<option value="next_week" '.$select_next_week.'>'.esc_html__('Next Week', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_next_month == 'yes' ? '<option value="next_month" '.$select_next_month.'>'.esc_html__('Next Month', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_past == 'yes' ? '<option value="past" '.$select_past.'>'.esc_html__('Past Events', 'ovaem-events-manager').'</option>' : '';

	        				$html .= $show_feature == 'yes' ? '<option value="future" '.$select_future.'>'.esc_html__('Future Events', 'ovaem-events-manager').'</option>' : '';

	        			$html .= '</select>';
	        		$html .= '</div>';
        		}

        		
				

        		if( $show_date ==  'yes' ){

	        		$html .= '<div class="ovaem_date">';

	        			$html .= '<input id="from" class="ovaem_select_date ovaem_date_from form-controll selectpicker" placeholder="'.esc_html__('From ...', 'ovaem-events-manager').'" data-date_format="'.esc_attr($date_format).'" name="ovaem_date_from" data-lang="'.OVAEM_Settings::event_calendar_lang().'" data-first-day="'.OVAEM_Settings::first_day_of_week().'" value="'.$get_date_from.'" />';

	        			$html .= '<input id="to" class="ovaem_select_date ovaem_date_to form-controll selectpicker" placeholder="'.esc_html__('To ...', 'ovaem-events-manager').'" data-date_format="'.esc_attr($date_format).'" data-lang="'.OVAEM_Settings::event_calendar_lang().'" data-first-day="'.OVAEM_Settings::first_day_of_week().'" name="ovaem_date_to" value="'.$get_date_to.'" />';

	        		$html .= '</div>';
        		}

        		if( $show_states ==  'yes' || $show_cities ==  'yes' ){
        			$html .= '<div class="ovaem_search_state_city">';
        		}

	        		if( $show_states ==  'yes' ){
	        			$html .= '<div class="ovaem_country">';
			    			$html .= $country;
						$html .= '</div>';
	        		}

	        		if( $show_cities ==  'yes' ){
	        			$html .= '<div class="ovaem_city">';
			    			$html .= $city;
						$html .= '</div>';
	        		}

	        	if( $show_states ==  'yes' || $show_cities ==  'yes' ){	
        			$html .= '</div>';
        		}


        		$html .= '<input type="hidden" name="post_type" value="'.self::$event_post_type_slug.'">';
        		$html .= '<input type="hidden" name="search" value="search-event">';
        		$html .= '<input class="ovame_submit" type="submit" value="'.esc_html__('Search', 'ovaem-events-manager').'" />';
        	$html .= '</form>';
        $html .= '</div>';
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
		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Search Event', 'ovaem-events-manager' );

		$class = !empty( $instance['class'] ) ? $instance['class'] : '';

		$intro = !empty( $instance['intro'] ) ? $instance['intro'] : '';

		$show_name = !empty( $instance['show_name'] ) ? $instance['show_name'] : 'yes';
		$show_venue = !empty( $instance['show_venue'] ) ? $instance['show_venue'] : 'yes';
		$show_cat = !empty( $instance['show_cat'] ) ? $instance['show_cat'] : 'yes';
		$show_time = !empty( $instance['show_time'] ) ? $instance['show_time'] : 'yes';
		$show_date = !empty( $instance['show_date'] ) ? $instance['show_date'] : 'yes';

		$show_states = !empty( $instance['show_states'] ) ? $instance['show_states'] : 'yes';
		$show_cities = !empty( $instance['show_cities'] ) ? $instance['show_cities'] : 'yes';

		$show_past = !empty( $instance['show_past'] ) ? $instance['show_past'] : 'yes';
		$show_feature = !empty( $instance['show_feature'] ) ? $instance['show_feature'] : 'yes';

		$show_today = !empty( $instance['show_today'] ) ? $instance['show_today'] : 'yes';
		$show_tomorrow = !empty( $instance['show_tomorrow'] ) ? $instance['show_tomorrow'] : 'yes';
		$show_this_week = !empty( $instance['show_this_week'] ) ? $instance['show_this_week'] : 'yes';
		$show_this_weekend = !empty( $instance['show_this_weekend'] ) ? $instance['show_this_weekend'] : 'yes';
		$show_next_week = !empty( $instance['show_next_week'] ) ? $instance['show_next_week'] : 'yes';
		$show_next_month = !empty( $instance['show_next_month'] ) ? $instance['show_next_month'] : 'yes';

		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'intro' ) ); ?>"><?php esc_attr_e( 'Intro Text:', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'intro' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'intro' ) ); ?>" type="text" value="<?php echo esc_attr( $intro ); ?>">
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"><?php esc_attr_e( 'Class :', 'ovaem-events-manager' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'class' ) ); ?>" type="text" value="<?php echo esc_attr( $class ); ?>">
		</p>


		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_name' ) ); ?>"><?php esc_attr_e( 'Seach Name :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_name == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_name == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_name' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_venue' ) ); ?>"><?php esc_attr_e( 'Seach Venue :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_venue == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_venue == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_venue' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_venue' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>
		

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_cat' ) ); ?>"><?php esc_attr_e( 'Seach Categories :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_cat == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_cat == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_cat' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>


		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_time' ) ); ?>"><?php esc_attr_e( 'Seach Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_time == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_time == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_time' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_time' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_attr_e( 'Seach date :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_date == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_date == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>


		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_states' ) ); ?>"><?php esc_attr_e( 'Show States :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_states == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_states == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_states' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_states' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_cities' ) ); ?>"><?php esc_attr_e( 'Show Cities :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_cities == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_cities == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_cities' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_cities' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_past' ) ); ?>"><?php esc_attr_e( 'Show Past in All Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_past == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_past == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_past' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_past' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_feature' ) ); ?>"><?php esc_attr_e( 'Show Feature in All Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_feature == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_feature == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_feature' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_feature' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_today' ) ); ?>"><?php esc_attr_e( 'Show Today in All Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_today == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_today == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_today' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_today' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_tomorrow' ) ); ?>"><?php esc_attr_e( 'Show Tomorrow in All Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_tomorrow == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_tomorrow == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_tomorrow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_tomorrow' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>


		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_this_week' ) ); ?>"><?php esc_attr_e( 'Show This Week in All Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_this_week == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_this_week == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_this_week' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_this_week' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_this_weekend' ) ); ?>"><?php esc_attr_e( 'Show This Weekend in All Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_this_weekend == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_this_weekend == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_this_weekend' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_this_weekend' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_next_week' ) ); ?>"><?php esc_attr_e( 'Show Next Week in All Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_next_week == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_next_week == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_next_week' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_next_week' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_next_month' ) ); ?>"><?php esc_attr_e( 'Show Next Month in All Time :', 'ovaem-events-manager' ); ?></label> 

		 <?php
		 	$selected_yes = ( $show_next_month == 'yes') ? 'selected="selected"' : '';
		 	$selected_no = ( $show_next_month == 'no') ? 'selected="selected"' : '';
		 ?>

		<select class="widefat"  id="<?php echo esc_attr( $this->get_field_id( 'show_next_month' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_next_month' ) ); ?>">
			<option value="yes" <?php echo $selected_yes; ?> ><?php esc_attr_e('Yes', 'ovaem-events-manager'); ?></option>
			<option value="no" <?php echo $selected_no; ?> ><?php esc_attr_e('No', 'ovaem-events-manager'); ?></option>
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
		$instance['intro'] = ( ! empty( $new_instance['intro'] ) ) ? strip_tags( $new_instance['intro'] ) : '';
		$instance['class'] = ( ! empty( $new_instance['class'] ) ) ? strip_tags( $new_instance['class'] ) : '';

		$instance['show_name'] = ( ! empty( $new_instance['show_name'] ) ) ? strip_tags( $new_instance['show_name'] ) : 'yes';

		$instance['show_venue'] = ( ! empty( $new_instance['show_venue'] ) ) ? strip_tags( $new_instance['show_venue'] ) : 'yes';

		$instance['show_cat'] = ( ! empty( $new_instance['show_cat'] ) ) ? strip_tags( $new_instance['show_cat'] ) : 'yes';

		$instance['show_time'] = ( ! empty( $new_instance['show_time'] ) ) ? strip_tags( $new_instance['show_time'] ) : 'yes';

		$instance['show_date'] = ( ! empty( $new_instance['show_date'] ) ) ? strip_tags( $new_instance['show_date'] ) : 'yes';

		$instance['show_states'] = ( ! empty( $new_instance['show_states'] ) ) ? strip_tags( $new_instance['show_states'] ) : 'yes';

		$instance['show_cities'] = ( ! empty( $new_instance['show_cities'] ) ) ? strip_tags( $new_instance['show_cities'] ) : 'yes';

		$instance['show_past'] = ( ! empty( $new_instance['show_past'] ) ) ? strip_tags( $new_instance['show_past'] ) : 'yes';

		$instance['show_feature'] = ( ! empty( $new_instance['show_feature'] ) ) ? strip_tags( $new_instance['show_feature'] ) : 'yes';

		$instance['show_today'] = ( ! empty( $new_instance['show_today'] ) ) ? strip_tags( $new_instance['show_today'] ) : 'yes';

		$instance['show_tomorrow'] = ( ! empty( $new_instance['show_tomorrow'] ) ) ? strip_tags( $new_instance['show_tomorrow'] ) : 'yes';

		$instance['show_this_week'] = ( ! empty( $new_instance['show_this_week'] ) ) ? strip_tags( $new_instance['show_this_week'] ) : 'yes';

		$instance['show_this_weekend'] = ( ! empty( $new_instance['show_this_weekend'] ) ) ? strip_tags( $new_instance['show_this_weekend'] ) : 'yes';

		$instance['show_next_week'] = ( ! empty( $new_instance['show_next_week'] ) ) ? strip_tags( $new_instance['show_next_week'] ) : 'yes';

		$instance['show_next_month'] = ( ! empty( $new_instance['show_next_month'] ) ) ? strip_tags( $new_instance['show_next_month'] ) : 'yes';

		

		return $instance;
	}

}

function register_ovaem_search_event_widget() {
    register_widget( 'ovaem_search_event_widget' );
}
add_action( 'widgets_init', 'register_ovaem_search_event_widget' );