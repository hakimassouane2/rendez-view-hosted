<?php if ( !defined( 'ABSPATH' ) ) exit();

$prefix = OVAEM_Settings::$prefix;
$post_type = OVAEM_Settings::speaker_post_type_slug();

$id = get_the_id();
$label_sponsor = get_post_meta( $id, $prefix.'_label_sponsor', true) ? get_post_meta( $id, $prefix.'_label_sponsor', true) : 'Sponsors';

$sponsor_level = get_post_meta( get_the_id(), $prefix.'_sponsor_level', true );

if( $sponsor_level ){ ?>

	<div class="event_widget event_sponsors">

		<h3 class="title">
			<?php echo esc_html($label_sponsor); ?>
			<span class="one"></span><span  class="two"></span><span  class="three"></span><span  class="four"></span><span  class="five"></span>
			<i class="icon_group"></i>
		</h3>

		<div class="wrap_event_widget">

			<?php foreach ($sponsor_level as $key => $value) {

				$sponsor_info = get_post_meta( get_the_id(), $prefix.'_sponsor_info', true );

				if( $sponsor_info[$key] ){ ?>
					<div class="ovaem_sponsor">
						<?php if( count($sponsor_level) > 1 ){ ?>
							<div class="ovaem_sponsor_name"><?php echo esc_html( $value ); ?></div>
						<?php } ?>
						<ul>
							<?php foreach ($sponsor_info[$key] as $key_info => $value_info) { ?>
								<li><a href="<?php echo $value_info['link'] ?>">
									<img src="<?php echo esc_url(wp_get_attachment_url($value_info['logo'])); ?>" alt="<?php echo esc_html( $value ); ?>">
								</a></li>

							<?php } ?>
						</ul>
					</div>
				<?php }
			} ?>

		</div>
	</div>

<?php } ?>	
