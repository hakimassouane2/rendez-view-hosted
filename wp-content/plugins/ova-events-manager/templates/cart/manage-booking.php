<?php 
if ( !defined( 'ABSPATH' ) ) exit();
?>

<div class="ovaem-bookings">

	<table>
		<thead class="event_head">
			<tr>
				<td class="id"><?php esc_html_e("ID", "ovaem-events-manager") ?></td>
				<td><?php esc_html_e("Date Created", "ovaem-events-manager") ?></td>
				<td><?php esc_html_e("Status", "ovaem-events-manager") ?></td>
				<td><?php esc_html_e("Action", "ovaem-events-manager") ?></td>
			</tr>
		</thead>
		<tbody class="event_body">
			<?php 
			$list_bookings = apply_filters( 'ovaem_get_list_booking', 1 );

			if($list_bookings->have_posts() ) : while ( $list_bookings->have_posts() ) : $list_bookings->the_post();
				$booking_id = get_the_ID();
				$ovaem_event_status = get_post_meta( $booking_id, 'ovaem_event_status', true );

				// Display row only if status is "Pending"
				if ($ovaem_event_status === 'Pending') :
			?>
				<tr>
					<td data-colname="<?php esc_attr_e('ID', 'ovaem-events-manager'); ?>" class="id"><?php echo esc_html($booking_id); ?></td>

					<td data-colname="<?php esc_attr_e('Date Created', 'ovaem-events-manager'); ?>" >
						<?php 
						$date_format = get_option('date_format');
						$time_format = get_option('time_format');
						echo get_the_date($date_format, $booking_id) . " - " . get_the_date($time_format, $booking_id);
						?>
					</td>

					<td data-colname="<?php esc_attr_e('Status', 'ovaem-events-manager'); ?>" >
						<?php 
						switch (get_post_meta($booking_id, 'ovaem_event_status', true)) {

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
						?>
					</td>

					<td>
						<div class="wp-button-my-booking">
							<div class="button-dowload-ticket">
								<button class="button download-ticket" data-nonce="<?php echo wp_create_nonce( 'ovaem_download_ticket_nonce' ); ?>" data-booking_id="<?php echo esc_attr($booking_id) ?>"><?php esc_html_e( "Download", "ovaem-events-manager" ); ?></button>
							</div>
						</div>
					</td>
				</tr>
			<?php
				endif; // End of conditional check for status
			endwhile; else : ?> 
			<tr><td colspan="4"><?php esc_html_e( 'Not Found Bookings', 'ovaem-events-manager' ); ?></td></tr> 
			<?php endif; wp_reset_postdata(); ?>

			<?php $total = $list_bookings->max_num_pages;?>
			<?php if ( $total > 1 ) { ?>
				<tr><td colspan="4">
					<div class="ovaem_pagination">
						<?php ovaem_pagination_ajax($list_bookings->found_posts, $list_bookings->query_vars['posts_per_page'], 1); ?>
					</div>
				</td></tr>			
			<?php } ?>
		</tbody>
	</table>

	<!-- Loader -->
	<div class="wrap_loader" style="display: none;">
		<svg class="loader" width="50" height="50">
			<circle cx="25" cy="25" r="10" stroke="#e86c60"/>
			<circle cx="25" cy="25" r="20" stroke="#e86c60"/>
		</svg>
	</div>

</div>
