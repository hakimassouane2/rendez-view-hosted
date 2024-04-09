<?php 

if( !defined( 'ABSPATH' ) ) exit();

global $post;

$post_id    = $post->ID;


?>

<div class="container-fluid">
	<div class="row">

		<div id="tabs">

			<ul>
				<li><a href="#basic_event_metabox"><?php esc_html_e( 'Basic', 'ovaem-events-manager' ); ?> </a></li>
				<li><a href="#schedule_event_metabox" class="schedule_event_metabox_tab"><?php esc_html_e( 'Schedule', 'ovaem-events-manager' ); ?></a></li>
				<li><a href="#gallery_event_metabox"><?php esc_html_e( 'Gallery', 'ovaem-events-manager' ); ?></a></li>
				<li><a href="#sponsor_event_metabox" class="sponsor_event_metabox_tab"><?php esc_html_e( 'Sponsor', 'ovaem-events-manager' ); ?></a></li>
				<li><a href="#organizer_event_metabox"><?php esc_html_e( 'Organizer', 'ovaem-events-manager' ); ?></a></li>
				<li><a href="#ticket_event_metabox"><?php esc_html_e( 'Ticket', 'ovaem-events-manager' ); ?></a></li>
				<li><a href="#faq_event_metabox"><?php esc_html_e( 'FAQ', 'ovaem-events-manager' ); ?></a></li>
				<li><a href="#contact_event"><?php esc_html_e( 'Contact', 'ovaem-events-manager' ); ?></a></li>
				<li><a href="#sidebar"><?php esc_html_e( 'Sidebar Content', 'ovaem-events-manager' ); ?></a></li>
				<li><a href="#label"><?php esc_html_e( 'Frontend Label', 'ovaem-events-manager' ); ?></a></li>
				
			</ul>

			<!-- Basic Tab Content -->  
			<div id="basic_event_metabox">
				
				<?php require_once( OVAEM_PLUGIN_PATH.'/admin/views/ovaem-metabox-event-basic.php' ); ?>

			</div>

			<!-- Schedule -->  
			<div id="schedule_event_metabox">
				<div class="schedules">
					<!-- Ajax will display content here -->
				</div>

				<div class="add_schedule button button-primary button-large text-right" data-event-id="<?php echo esc_attr($post_id); ?>"><i class="fa fa-plus"></i> <?php esc_html_e( 'Add Date', 'ovaem-events-manager' ); ?> </div>
			</div>

			<!-- Gallery -->
			<div id="gallery_event_metabox">
				<?php require_once( OVAEM_PLUGIN_PATH.'/admin/views/ovaem-metabox-event-gallery.php' ); ?>
			</div>

			<!-- Sponsor -->
			<div id="sponsor_event_metabox">
				<div class="sponsors">
					<!-- Ajax will display content here -->
				</div>
				
				<div class="add_sponsor button button-primary button-large text-right" data-event-id="<?php echo esc_attr($post_id); ?>"><i class="fa fa-plus"></i> <?php esc_html_e( 'Create Sponsor', 'ovaem-events-manager' ); ?> </div>
			</div>

			<!-- Organizer -->
			<div id="organizer_event_metabox">
				<div class="organizers">
					<?php require_once( OVAEM_PLUGIN_PATH.'/admin/views/ovaem-metabox-event-organizer.php' ); ?>
				</div>
			</div>

			<div id="ticket_event_metabox">
				<div class="tickets">
					<!-- Ajax will display content here -->
				</div>
				<div class="add_ticket button button-primary button-large text-right" data-event-id="<?php echo esc_attr($post_id); ?>"><i class="fa fa-plus"></i> <?php esc_html_e( 'Add Ticket', 'ovaem-events-manager' ); ?> </div>
			</div>
			
			<!-- contact form 7 -->
			<div id="faq_event_metabox">
				<div class="faqs">
					<?php require_once( OVAEM_PLUGIN_PATH.'/admin/views/ovaem-metabox-event-faq.php' ); ?>
				</div>
				<div class="add_faq button button-primary button-large text-right" data-event-id="<?php echo esc_attr($post_id); ?>"><i class="fa fa-plus"></i> <?php esc_html_e( 'Add Faq', 'ovaem-events-manager' ); ?> </div>
			</div>

			<!-- contact form 7 -->
			<div id="contact_event">
				<div class="contact_events">
					<?php require_once( OVAEM_PLUGIN_PATH.'/admin/views/ovaem-metabox-event-contact.php' ); ?>
				</div>
			</div>

			<!-- Sidebar -->
			<div id="sidebar">
				<div class="content_sidebar">
					<?php require_once( OVAEM_PLUGIN_PATH.'/admin/views/ovaem-metabox-event-sidebar.php' ); ?>
				</div>
			</div>

			<div id="label">
				<div class="content_label">
					<?php require_once( OVAEM_PLUGIN_PATH.'/admin/views/ovaem-metabox-event-label.php' ); ?>
				</div>
			</div>

		</div>

		<br/> 
	</div>
</div>

<div id="dialogs">
	<!-- Ajax display here -->
</div>	



<?php wp_nonce_field( 'ova_events_nonce', 'ova_events_nonce' ); ?>