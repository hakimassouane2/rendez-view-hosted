<?php
defined('ABSPATH') || exit();

if (!class_exists('OVAEM_Admin_Orders')) {

	class OVAEM_Admin_Orders {

		public function __construct() {
			add_action('manage_event_order_posts_custom_column', array($this, 'event_order_posts_custom_column'), 10, 2);
			add_filter('manage_edit-event_order_sortable_columns', array($this, 'posts_column_register_sortable'), 10, 1);
			add_filter('manage_edit-event_order_columns', array($this, 'event_replace_column_title_method_a'));
		}

		public function event_order_posts_custom_column($column_name, $post_id) {
			if ($column_name == 'customer_info') {

				$html = '- ' . get_post_meta($post_id, 'ovaem_name', true);
				$html .= '<br/>';

				$html .= '- ' . get_post_meta($post_id, 'ovaem_email', true);
				$html .= '<br/>';

				$html .= '- ' . get_post_meta($post_id, 'ovaem_phone', true);
				$html .= '<br/>';

				$html .= '- ' . get_post_meta($post_id, 'ovaem_address', true);
				$html .= '<br/>';

				if (get_post_meta($post_id, 'ovaem_number', true)) {
					$html .= '- <span class="text_grey">' . esc_html__('Ticket: ', 'ovaem-events-manager') . '</span>' . get_post_meta($post_id, 'ovaem_number', true);
					$html .= '<br/>';
				}

				$html .= '- <span class="text_grey">' . esc_html__('Company: ', 'ovaem-events-manager') . '</span>' . get_post_meta($post_id, 'ovaem_company', true);
				$html .= '<br/>';

				$html .= '- <span class="text_grey">' . esc_html__('Description: ', 'ovaem-events-manager') . '</span>' . shorten_string(get_post_meta($post_id, 'ovaem_desc', true), 10);
				$html .= '<br/>';

				echo $html;
			}

			if ($column_name == 'status') {
				switch (get_post_meta($post_id, 'ovaem_event_status', true)) {

					case 'Pending':
					esc_html_e('Pending', 'ovaem-events-manager');
					break;

					case 'Completed':
					esc_html_e('Completed', 'ovaem-events-manager');
					break;

					case 'Canceled_Reversal':
					esc_html_e('Canceled Reversal', 'ovaem-events-manager');
					break;
					case 'Denied':
					esc_html_e('Denied', 'ovaem-events-manager');
					break;
					case 'Expired':
					esc_html_e('Expired', 'ovaem-events-manager');
					break;
					case 'Failed':
					esc_html_e('Failed', 'ovaem-events-manager');
					break;
					case 'Refunded':
					esc_html_e('Refunded', 'ovaem-events-manager');
					break;
					case 'Reversed':
					esc_html_e('Reversed', 'ovaem-events-manager');
					break;
					case 'Processed':
					esc_html_e('Processed', 'ovaem-events-manager');
					break;
					case 'Voided':
					esc_html_e('Voided', 'ovaem-events-manager');
					break;

            	// For woo
					case 'wc-pending':
					esc_html_e('Pending', 'ovaem-events-manager');
					break;
					case 'wc-processing':
					esc_html_e('Processing', 'ovaem-events-manager');
					break;
					case 'wc-on-hold':
					esc_html_e('On Hold', 'ovaem-events-manager');
					break;
					case 'wc-completed':
					esc_html_e('Completed', 'ovaem-events-manager');
					break;
					case 'wc-cancelled':
					esc_html_e('Cancelled', 'ovaem-events-manager');
					break;
					case 'wc-refunded':
					esc_html_e('Refunded', 'ovaem-events-manager');
					break;
					case 'wc-failed':
					esc_html_e('Failed', 'ovaem-events-manager');
					break;

					case 'error_mail':
					esc_html_e('Error send mail to attendee', 'ovaem-events-manager');
					break;
					default:
					break;
				}
			}

			if ($column_name == 'total') {

				$ovaem_order_cart 	= get_post_meta($post_id, 'ovaem_order_cart', true);
				$ovaem_order_coupon = get_post_meta($post_id, 'ovaem_order_coupon', true);
				$ovaem_order_total 	= get_post_meta($post_id, 'ovaem_order_total', true);

				$total = 0;
				if ($ovaem_order_cart && get_post_meta($post_id, 'ovaem_event_status', true) != 'free') {
					if (is_array($ovaem_order_cart)) { // If user Gateway direct of plugin
						foreach ($ovaem_order_cart as $id => $quantity) {

							$parse_id = explode('_', $id);
							$price = floatval($parse_id[1]);
							$cur = $parse_id[2];
							$total += floatval($price) * intval($quantity);

						}

					}

					$coupon_arr = $ovaem_order_coupon ? OVAEM_Coupon::ovaem_check_coupon($ovaem_order_coupon, false) : array();

					if (is_array($ovaem_order_cart)) {
						$total = OVAEM_Coupon::ovaem_total_with_coupon($coupon_arr, $total, $cur);
					} else {
						$total = '';
					}

               // $html = esc_html__('Total: ', 'ovaem-events-manager');
					$html = ovaem_format_price($total['raw'], $cur);

					if (get_post_meta($post_id, 'ovaem_payment_gateway', true)) {
						$html .= '<br/>' . esc_html__('by ', 'ovaem-events-manager');
						$html .= get_post_meta($post_id, 'ovaem_payment_gateway', true);
					}

					echo $html;
				} elseif ( $ovaem_order_total ) {
					printf( esc_html__( 'Total: %1$s%2$s', 'ovaem-events-manager' ), get_woocommerce_currency_symbol(),$ovaem_order_total );
				} else {
					echo esc_html__('Total: 0', 'ovaem-events-manager');
				}
			}

			if ($column_name == 'ticket_type') {
				echo get_post_meta($post_id, 'ovame_ticket_type', true);
			}

			if ($column_name == 'order_language') {
				$locale_code = get_post_meta($post_id, 'ovaem_order_language', true);
				$language_name = 'English'; 
				switch ($locale_code) {
					case 'fr_FR':
							$language_name = 'Français';
							break;
					default:
							$language_name = 'English';
							break;
				}
				echo $language_name;
			}
		}

		public function event_replace_column_title_method_a($columns) {

			$columns = array(
				'cb' => "<input type ='checkbox' />",
				'title' => esc_html__('ID', "ovaem-events-manager"),
				'customer_info' => esc_html__('Info', "ovaem-events-manager"),
				'total' => esc_html__("Total", "ovaem-events-manager"),
				'status' => esc_html__("Status", "ovaem-events-manager"),
				'ticket_type' => esc_html__("Ticket Type", "ovaem-events-manager"),
				'order_language' => esc_html__("Language", "ovaem-events-manager"),
				'date' => esc_html__('Date', 'ovaem-events-manager'),
			);

			return $columns;
		}

		function posts_column_register_sortable($columns) {
			$columns['event_id'] = 'event_id';
			return $columns;
		}

	}
	new OVAEM_Admin_Orders();

}