<!-- <?php 
// Get Info ticket
$ticket = $args['ticket']; ?>

<span style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket["event_name_font_size"]; ?>">
	<?php echo $ticket['event_name']; ?>
</span>

<br><br>

<div style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
	<b><?php esc_html_e( 'Time', 'ovaem-events-manager' ); ?>:</b>
</div>

<div style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket['text_size']; ?> ">
	<?php echo $ticket['time']; ?>
</div>


<br>

<div style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
	<b><?php esc_html_e( 'Venue', 'ovaem-events-manager' ); ?>:</b>
</div>
<div style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket['text_size']; ?> ">
	<?php echo $ticket['venue']; ?>
	<br>
	<?php echo $ticket['address']; ?>
</div>


<br>




<table>
	<tbody>
	  <tr>
		
		<td class="left" style="padding-right: 45px;">
	  		<barcode code="<?php echo $ticket['qrcode_str']; ?>" type="QR" disableborder="1" />
	  	</td>
		

	  	<td class="right">

	  		#<?php echo $ticket['qrcode_str']; ?>

	  		<br><br>

	  		<div>
				<b style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
					<?php esc_html_e( 'Order Info', 'ovaem-events-manager' ); ?>:
				</b>
				<span style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket['text_size']; ?> ">
					<?php echo $ticket['holder_ticket']; ?>
				</span>
			</div>
			

			<br>
			
			<div>
				<b style="color: <?php echo $ticket['label_color']; ?>; font-size: <?php echo $ticket['label_size']; ?>">
					<?php esc_html_e( 'Package', 'ovaem-events-manager' ); ?>:
				</b>
				<span style="color: <?php echo $ticket['text_color']; ?>; font-size: <?php echo $ticket['text_size']; ?> ">
					<?php echo $ticket['package']; ?>
				</span>
			</div>
			

	  	</td>
	  	

	  </tr>

	</tbody>

</table>



 -->


<?php 
// Get Info ticket
$ticket = $args['ticket']; 
?>

<table style="width: 100%">
      <tbody>
        <tr>
          <td style="background-color: black; width: 80%; padding: 1rem">
            <h2 style="color: white">Rendes View: Rumda</h2>
          </td>
          <td style="background-color: black">
            <div style="width: 180px; padding: 1rem">
              <p style="color: white; font-size: 14px">N'DE BULLET</p>
              <p style="color: white; font-size: 16px">DH83D-373F-DG</p>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div style="padding: 1.5rem; border-left: 2px solid #737373">
              <p style="color: #808080; margin-bottom: 8px">HEURE ET UEU</p>
              <span>11 Ass Unisuvua,France</span>
            </div>
            <div
              style="
                border-right: 2px dashed #737373;
                padding: 0.5rem 1.5rem 1.5rem;
                border-bottom: 2px solid #737373;
                border-left: 2px solid #737373;
              "
            >
              <p style="color: #808080; margin-bottom: 8px">
                TYPE DE BILLET ET PRX
              </p>
              <span>Gratuit something</span>
            </div>
            <div
              style="
                width: 100%;
                border-left: 2px solid #737373;
                border-bottom: 2px solid #737373;
              "
            >
              <div
                style="
                  display: inline-block;
                  padding: 1.5rem;
                  border-right: 2px solid #737373;
                  width: calc(100% - 254.5px);
                "
              >
                <p style="color: #808080">HEURE ET UEU</p>
                <span>11 Ass Unisuvua,France</span>
              </div>
              <div
                style="
                  display: inline-block;
                  padding: 1.5rem;
                  width: 150px;
                  border-right: 2px dashed #737373;
                "
              >
                <p style="color: #808080">DATE DE COMMANCE</p>
                <span>11 Nov, 2024</span>
              </div>
            </div>
          </td>
          <td rowspan="3">
            <div
              style="
                border-bottom: 2px solid #737373;
                height: 100%;
                padding: 0.5rem 1rem;
                border-right: 2px solid #737373;
              "
            >
              <div style="padding: 0.5rem">
                <p style="color: #808080; margin-bottom: 8px">N' DE COMMANDE</p>
                <span>DH83D-373F-DG</span>
              </div>
              <div style="padding: 1.5rem 0.5rem 0.5rem">
                <p style="color: #808080; margin-bottom: 8px">
                  STATUT DU PAEMENT
                </p>
                <span>Gratuit something</span>
              </div>
              <div
                style="
                  width: 100px;
                  height: 100%;
                  margin-top: 1rem;
                  padding: 0.5rem;
                "
              >
                <img src="./qrcode.webp" alt="" width="100%" />
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div
      style="
        border-top: 1px dashed #b3b3b3;
        margin-top: 3rem;
        padding-top: 3rem;
      "
    >
      <div style="margin-right: 2rem; display: inline-block; width: 70%">
        <h3 style="margin: 0">INFORMATIONS INPORTANTES</h3>
        <p>
          It is a long established fact that a reader will be distracted by the
          readable content of a page when looking at its layout. The point of
          using Lorem Ipsum is that it has a more-or-less normal distribution of
          letters, as opposed to using 'Content here, content here', making it
          look like readable English. Many desktop publishing packages and web
          page editors now use Lorem Ipsum as their default model text, and a
          search for 'lorem ipsum' will uncover many web sites still in their
          infancy. Various versions have evolved over the years, sometimes by
          accident, sometimes on purpose (injected humour and the like).
        </p>
      </div>
      <img
        src="./prod_image.jpeg"
        alt=""
        style="width: 200px; display: inline-block"
      />
    </div>
