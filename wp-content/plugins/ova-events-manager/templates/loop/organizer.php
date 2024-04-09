<?php if ( !defined( 'ABSPATH' ) ) exit(); ?>
<?php 

$prefix = OVAEM_Settings::$prefix;
$id =  get_the_id();
$label_organizer = get_post_meta( $id, $prefix.'_label_organizer', true) ? get_post_meta( $id, $prefix.'_label_organizer', true) : esc_html__( 'Organizers', 'ovaem-events-manager' );

$name = get_post_meta( $id, $prefix.'_org_name', true );
$email = get_post_meta( $id, $prefix.'_org_email', true );
$phone = get_post_meta( $id, $prefix.'_org_phone', true );
$website = get_post_meta( $id, $prefix.'_org_website', true );
$desc = get_post_meta( $id, $prefix.'_org_desc', true );
$logo = get_post_meta( $id , $prefix.'_org_logo', true ) ? get_post_meta( $id , $prefix.'_org_logo', true ) : '';


?>

<?php if( $name || $email || $phone || $website || $desc ){ ?>

	<div class="event_widget"><div class="wrap_event_widget">

		<h3 class="title">
			<?php echo esc_html($label_organizer); ?>
			<span class="one"></span><span  class="two"></span><span  class="three"></span><span  class="four"></span><span  class="five"></span>
			<i class="icon_profile"></i>
		</h3>

		<?php if ( $logo ):
			$image_logo = wp_get_attachment_image( $logo, 'medium' );
			?>
			<div class="clearfix event_row org_logo">
				<?php echo $image_logo; ?>
			</div>
		<?php endif; ?>

		<?php if( $name ){ ?>
			<div class="clearfix event_row">
				<label><?php esc_html_e( "Name: ", "ovaem-events-manager" ); ?></label>
				<span><?php echo esc_html($name ); ?></span>
			</div>
		<?php } ?>

		<?php if( $email ){ ?>
			<div class="clearfix event_row">
				<label><?php esc_html_e( "Email: ", "ovaem-events-manager" ); ?></label>
				<span><?php echo esc_html($email ); ?></span> 
			</div>
		<?php } ?>

		<?php if( $phone ){ ?>
			<div class="clearfix event_row">
				<label><?php esc_html_e( "Phone: ", "ovaem-events-manager" ); ?></label> 
				<span><?php echo esc_html($phone ); ?></span>
			</div>
		<?php } ?>

		<?php if( $website ){ ?>
			<div class="clearfix event_row">
				<label><?php esc_html_e( "website: ", "ovaem-events-manager" ); ?></label>
				<a href="<?php echo esc_url($website); ?>"><span><?php echo esc_html($website ); ?></span></a>
			</div>
		<?php } ?>

		<?php if( $desc ){ ?>
			<div class="clearfix event_row">
				<label><?php esc_html_e( "Description: ", "ovaem-events-manager" ); ?></label>
				<span><?php echo esc_html($desc ); ?></span>
			</div>
		<?php } ?>


	</div></div>

<?php } ?>
