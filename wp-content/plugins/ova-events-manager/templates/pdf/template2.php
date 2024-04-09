<?php 
// Get Info ticket
$ticket = $args['ticket']; ?>


	<table class="pdf_content">
		<tbody>
		  <tr style="border: 5px solid <?php echo $ticket['color_border_ticket'] ?>;">

		  	<td class="left">
		  		<table style="width: 100%; border-collapse: collapse;" >
					
					<tr class="name_event">
						<!-- Event Name -->
						<td colspan="2">
							<span style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
								<b><?php esc_html_e( 'Event', 'ovaem-events-manager' ); ?>:</b>
							</span>
							<br>
							<span style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket["event_name_font_size"]; ?>">
								<?php echo $ticket['event_name']; ?>
							</span>
						</td>
					</tr>

					<tr class="time">
						<td class="time_content" style="border-right: 5px solid <?php echo $ticket['color_border_ticket'] ?>; ">

							<div style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
								<b><?php esc_html_e( 'Time', 'ovaem-events-manager' ); ?>:</b>
							</div>

							<div style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket['text_size']; ?> ">
								<?php echo $ticket['time']; ?>
							</div>

						</td>
						<td class="venue_content" align="right">
							<div style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
								<b><?php esc_html_e( 'Venue', 'ovaem-events-manager' ); ?>:</b>
							</div>
							<div style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket['text_size']; ?> ">
								<!-- <?php echo $ticket['venue']; ?> -->
								<br>
								<?php echo $ticket['address']; ?>
							</div>
					</td>
					</tr>
					
					<tr class="order_info">
						<td colspan="2">
							<div style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
								<b><?php esc_html_e( 'Order Info', 'ovaem-events-manager' ); ?>:</b>
							</div>
							<div style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket['text_size']; ?> ">
								
								<?php if( $ticket['ovaem_ticket_from_order_id'] ){ ?>
									<?php echo '#'.$ticket['ovaem_ticket_from_order_id']; ?>
								<?php } ?>
								<br>
								<?php echo $ticket['holder_ticket']; ?>
							</div>
						</td>
					</tr>

					<tr class="ticket_type">
						<td colspan="2">
							<div style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
								<b><?php esc_html_e( 'Package', 'ovaem-events-manager' ); ?>:</b>
							</div>
							<div style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket['text_size']; ?> ">
								<!-- Ticket Number -->
								<?php echo $ticket['package']; ?>
							</div>
						</td>
					</tr>

				</table>
		  	</td>

		  	<td class="right">
		  		<table style="border: none;" ertical-align="top">
		  			
					<tr>
						<td>
							<?php if( isset( $ticket['logo_url'] ) ){ ?>
								<img src="<?php echo esc_url($ticket['logo_url']); ?>" width="150" />
							<?php } ?>
						</td>
					</tr>
				<br><br>
					<tr>
						<td>
							<barcode code="<?php echo $ticket['qrcode_str']; ?>" type="QR" disableborder="1" />
						</td>
					</tr>

				</table>
		  	</td>

		  </tr>

		</tbody>

	</table>

	


<style>

	table.pdf_content{
		border-collapse: collapse;	
	}
	
	

	.left{
		width: 500px;
		border-right: 5px solid <?php echo $ticket['color_border_ticket'] ?>;	
		padding: 0px;

	}

	.right{
		width: 150px;
		padding: 15px;
	}

	
	
	.name_event td,
	.time td,
	.order_info td
	{
		border: none;
		border-bottom: 5px solid <?php echo $ticket['color_border_ticket'] ?>c;
		padding: 15px;
	}

	.ticket_type td{
		padding: 15px;	
	}

</style>

