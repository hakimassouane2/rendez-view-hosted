<?php
defined('ABSPATH') || exit();

if (!class_exists('OVAEM_Admin_Tickets')) {

	class OVAEM_Admin_Tickets {

		public function __construct() {
			add_action('manage_event_ticket_posts_custom_column', array($this, 'event_ticket_posts_custom_column'), 10, 2);
			add_filter('manage_edit-event_ticket_sortable_columns', array($this, 'posts_column_register_sortable'), 10, 1);
			add_filter('manage_edit-event_ticket_columns', array($this, 'ovaem_manage_tickets_columns'));

		}

		public function event_ticket_posts_custom_column($column_name, $post_id) {

			if ($column_name == 'ticket_status') {

				if (get_post_meta($post_id, 'ovaem_ticket_status', true) == 'checked_in') {
					echo '<span style="color: blue">' . esc_html__('Checked In', 'ovaem-events-manager') . '</span>';
				} else {
					echo '<span style="color: red">' . esc_html__('Not Checked In', 'ovaem-events-manager') . '</span>';
				}

			}

			if ($column_name == 'buyer_name') {
				echo get_post_meta($post_id, 'ovaem_ticket_buyer_name', true);
			}

			if ($column_name == 'buyer_phone') {
				echo get_post_meta($post_id, 'ovaem_ticket_buyer_phone', true);
			}

			if ($column_name == 'buyer_email') {
				echo get_post_meta($post_id, 'ovaem_ticket_buyer_email', true);
			}

         // Ticket Code
			if ($column_name == 'ticket_qrcode') {
				echo get_post_meta($post_id, 'ovaem_ticket_code', true);
			}

         // Ticket Package
			if ($column_name == 'ticket_package') {
				echo get_post_meta($post_id, 'ovaem_ticket_event_package', true);
			}

			if ($column_name == 'ticket_verify') {

				if (get_post_meta($post_id, 'ovaem_ticket_verify', true) == 'true') {
					echo '<span style="color: blue">' . esc_html__('Verify', 'ovaem-events-manager') . '</span>';
				} else {
					echo '<span style="color: red">' . esc_html__('Not Verify', 'ovaem-events-manager') . '</span>';
				}

			}

			if ($column_name == 'order_id') {
				if (get_post_meta($post_id, 'ovaem_ticket_from_order_id', true)) {
					$orderid = get_post_meta($post_id, 'ovaem_ticket_from_order_id', true);
					echo '<a target="_blank" href="' . home_url('/') . 'wp-admin/post.php?post=' . $orderid . '&action=edit">' . $orderid . '</a>';
				} elseif (get_post_meta($post_id, 'ovaem_ticket_from_woo_order_id', true)) {
					$orderid = get_post_meta($post_id, 'ovaem_ticket_from_woo_order_id', true);
					echo 'Woo - <a target="_blank" href="' . home_url('/') . 'wp-admin/post.php?post=' . $orderid . '&action=edit">' . $orderid . '</a>';
				}
			}

			if ($column_name == 'order_locale') {
				if (get_post_meta($post_id, 'ovaem_ticket_from_order_id', true)) {
					$orderid = get_post_meta($post_id, 'ovaem_ticket_from_order_id', true);
					echo get_post_meta($orderid, 'ovaem_order_locale', true);
				} 

			}

		}

		public function ovaem_manage_tickets_columns($columns) {

			$columns = array(
				'cb' => "<input type ='checkbox' />",
				'title' => esc_html__('Event Name', "ovaem-events-manager"),
				'ticket_package' => esc_html__("Package", "ovaem-events-manager"),
				'ticket_qrcode' => esc_html__("Code", "ovaem-events-manager"),
				'buyer_name' => esc_html__("Holder Ticket", "ovaem-events-manager"),
				'buyer_phone' => esc_html__("Phone", "ovaem-events-manager"),
				'buyer_email' => esc_html__("Email", "ovaem-events-manager"),
				'ticket_verify' => esc_html__("Verify", "ovaem-events-manager"),
				'ticket_status' => esc_html__("Status", "ovaem-events-manager"),
				'order_id' => esc_html__("Order ID", "ovaem-events-manager"),
				'order_locale' => esc_html__("Order Locale", "ovaem-events-manager"),
				'date' => __('Date'),

			);

			return $columns;
		}

		function posts_column_register_sortable($columns) {
			$columns['event_id'] = 'event_id';
			return $columns;
		}

	}
	new OVAEM_Admin_Tickets();

}