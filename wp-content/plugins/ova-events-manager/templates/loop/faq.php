<?php if ( !defined( 'ABSPATH' ) ) exit();
$prefix = OVAEM_Settings::$prefix;
$event_faq_title = get_post_meta( get_the_id(), $prefix.'_faq_title', true );
$event_faq_desc = get_post_meta( get_the_id(), $prefix.'_faq_desc', true );

?>

<div class="faqs">

	<?php foreach ($event_faq_title as $key => $value) { ?>
		<div class="item">

			<div class="faq_title" data-toggle="collapse" data-target="<?php echo '#demo'.$key; ?>">
				<?php echo $value; ?>
					<i class="fas fa-plus" aria-hidden="true"></i>
				</div>

			<div id="<?php echo 'demo'.$key; ?>" class="faq_desc collapse">
				<div class="faq_content">
					<?php echo do_shortcode( $event_faq_desc[$key] ); ?>
				</div>
			</div>
			
		</div>
	<?php } ?>

</div>
