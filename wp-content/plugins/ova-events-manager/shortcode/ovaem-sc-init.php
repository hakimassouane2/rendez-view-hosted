<?php if ( !defined( 'ABSPATH' ) ) exit();

add_action( 'init', 'em4u_get__shortcode' );
function em4u_get__shortcode(){
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-categories.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-events-filter.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-events-filter-ajax.php';

	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-search-one.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-search-simple.php';

	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-slider-event-two.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-slider-event.php';


	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-speaker-list.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-venues-slider.php';

	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-ticket-event.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-schedule-event.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-simple-event.php';

	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-slideshow.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-slideshow-two.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-slideshow-three.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-register-event-free.php';

	// Countdown
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-event-countdown.php';

	// Cart
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-cart.php';
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-cart-manage-booking.php';

	// Checkout 
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-checkout.php';

	// FrontEnd Submit Event
	//require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-frontend-submit-event.php';

	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-check-ticket.php';

	// Calendar
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-calendar.php';

	// Event Map
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-event-map.php';

	// Search banner
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-search-banner.php';

	// Category INfo
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-cat-info.php';

	// Location Info
	require_once OVAEM_PLUGIN_PATH.'/shortcode/ovaem-loc-info.php';

}

?>