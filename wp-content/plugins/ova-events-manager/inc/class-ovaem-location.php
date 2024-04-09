<?php if (!defined('ABSPATH')) {
	exit();
}

if (!class_exists('OVA_Location')) {
	class OVA_Location {

		public function __construct() {

			add_action('wp_ajax_ova_load_city', array($this, 'ova_load_city'));
			add_action('wp_ajax_nopriv_ova_load_city', array($this, 'ova_load_city'));

		}
 
		public static function ova_load_city() {

			$city_html = '<option value="">' . esc_html__(' All Cities', 'ovaem-events-manager') . '</option>';

			$data = $_POST['data'];

			$country = $data['country'] ? sanitize_text_field($data['country']) : '';

			$term_country = get_term_by('slug', $country, 'location');
			

			/* No States selected, so reset state list */
			if ( $term_country == false ) {

				$args = array (
					'taxonomy' => 'location',
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => false,
					'fields' => 'all',
					'hierarchical' => false,
				);

				$parent_terms = get_terms( $args );

				if ( ! empty( $parent_terms ) ) {
				
					foreach ( $parent_terms as $pterm ) {
						if ( $pterm->parent != 0 ) {
							$city_html .= '<option value="' . $pterm->slug . '">' . $pterm->name . '</option>';
						}
					}
				}

			} else {
					$args = array (
					'taxonomy' => 'location', //empty string(''), false, 0 don't work, and return empty array
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => false, //can be 1, '1' too
					'fields' => 'all',
					'parent' => $term_country->term_id,
					'hierarchical' => false, //can be 1, '1' too
				);

				$country_info = get_terms( $args );

				if ( ! empty( $country_info ) ) {
					foreach ($country_info as $value) {
						$city_html .= '<option value="' . $value->slug . '">' . $value->name . '</option>';
					}
				}
				
			}

			echo $city_html;
			wp_die();

		}

	}
	new OVA_Location();
}
