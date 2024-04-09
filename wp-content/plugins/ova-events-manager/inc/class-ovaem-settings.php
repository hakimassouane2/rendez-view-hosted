<?php

if (!defined('ABSPATH')) {
	exit;
}

class OVAEM_Settings {

	public static $prefix = 'ovaem';
	public static $options = null;

	public function __construct() {
		self::$options = $this->getoptions();
	}

	public static function prefix() {
		return self::$prefix;
	}

	/**
    * Get All Categories
    */

	public function getoptions() {
		return get_option('ovaem_options');
	}

	/**
    * Get Category slug
    */
	public static function slug_taxonomy_name() {
		$ops = get_option('ovaem_options');
		return isset($ops['slug_taxonomy_name']) ? $ops['slug_taxonomy_name'] : 'categories';
	}

	/**
    * Post type slug
    */
	public static function event_post_type_slug() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_post_type_slug']) ? $ops['event_post_type_slug'] : 'event';
	}

	public static function event_post_type_rewrite_slug() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_post_type_rewrite_slug']) ? $ops['event_post_type_rewrite_slug'] : 'event';
	}

	/**
    * Post type name
    */
	public static function event_post_type_name() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_post_type_name']) ? $ops['event_post_type_name'] : 'Events';
	}

	/**
    * Post type singular name
    */
	public static function event_post_type_singular_name() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_post_type_singular_name']) ? $ops['event_post_type_singular_name'] : 'Event';
	}

	/**
    * Speaker Post type slug
    */
	public static function speaker_post_type_slug() {
		$ops = get_option('ovaem_options');
		return isset($ops['speaker_post_type_slug']) ? $ops['speaker_post_type_slug'] : 'speaker';
	}

	public static function speaker_post_type_rewrite_slug() {
		$ops = get_option('ovaem_options');
		return isset($ops['speaker_post_type_rewrite_slug']) ? $ops['speaker_post_type_rewrite_slug'] : 'speaker';
	}

	/**
    * Venue Post type slug
    */
	public static function venue_post_type_slug() {
		$ops = get_option('ovaem_options');
		return isset($ops['venue_post_type_slug']) ? $ops['venue_post_type_slug'] : 'venue';
	}

	public static function venue_post_type_rewrite_slug() {
		$ops = get_option('ovaem_options');
		return isset($ops['venue_post_type_rewrite_slug']) ? $ops['venue_post_type_rewrite_slug'] : 'venue';
	}

	/**
    * Google key map
    */
	public static function google_key_map() {
		$ops = get_option('ovaem_options');
		return isset($ops['google_key_map']) ? $ops['google_key_map'] : '';
	}

	/**
    * Search Name
    */
	public static function search_name() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_name']) ? $ops['search_name'] : 'true';
	}
	/**
    * Search Cat
    */
	public static function search_cat() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_cat']) ? $ops['search_cat'] : 'true';
	}
	/**
    * Search Venue
    */
	public static function search_venue() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_venue']) ? $ops['search_venue'] : 'true';
	}
	/**
    * Search time
    */
	public static function search_time() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time']) ? $ops['search_time'] : 'true';
	}

	public static function search_time_today() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_today']) ? $ops['search_time_today'] : 'true';
	}

	public static function search_time_tomorrow() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_tomorrow']) ? $ops['search_time_tomorrow'] : 'true';
	}

	public static function search_time_this_week() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_this_week']) ? $ops['search_time_this_week'] : 'true';
	}

	public static function search_time_this_week_end() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_this_week_end']) ? $ops['search_time_this_week_end'] : 'true';
	}

	public static function search_time_this_week_end_day() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_this_week_end_day']) ? $ops['search_time_this_week_end_day'] : array(0 => array('saturday', 'sunday'));
	}

	public static function search_time_next_week() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_next_week']) ? $ops['search_time_next_week'] : 'true';
	}

	public static function search_time_next_month() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_next_month']) ? $ops['search_time_next_month'] : 'true';
	}

	public static function search_time_past() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_past']) ? $ops['search_time_past'] : 'true';
	}

	public static function search_time_future() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_time_future']) ? $ops['search_time_future'] : 'true';
	}
	/**
    * Search date
    */
	public static function search_date() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_date']) ? $ops['search_date'] : 'true';
	}

	public static function event_show_tag() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_tag']) ? $ops['event_show_tag'] : 'true';
	}

	public static function event_show_share_social() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_share_social']) ? $ops['event_show_share_social'] : 'true';
	}

	public static function event_show_schedule_tab() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_schedule_tab']) ? $ops['event_show_schedule_tab'] : 'true';
	}

	public static function event_show_speaker_tab() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_speaker_tab']) ? $ops['event_show_speaker_tab'] : 'true';
	}
	public static function event_show_book_now() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_book_now']) ? $ops['event_show_book_now'] : 'true';
	}

	public static function event_show_book_now_event_past() {
        $ops = get_option('ovaem_options');
        return isset($ops['event_show_book_now_event_past']) ? $ops['event_show_book_now_event_past'] : 'true';
    }

    public static function event_scroll_tab() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_scroll_tab']) ? $ops['event_scroll_tab'] : 'ticket';
	}

	public static function event_show_ticket_tab() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_ticket_tab']) ? $ops['event_show_ticket_tab'] : 'true';
	}
	public static function event_show_ticket_tab_expired() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_ticket_tab_expired']) ? $ops['event_show_ticket_tab_expired'] : 'false';
	}
	public static function event_show_related() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_related']) ? $ops['event_show_related'] : 'true';
	}
	public static function event_show_comments() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_comments']) ? $ops['event_show_comments'] : 'true';
	}

	public static function event_show_contact() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_contact']) ? $ops['event_show_contact'] : 'true';
	}

	public static function event_show_notify() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_notify']) ? $ops['event_show_notify'] : 'true';
	}

	public static function event_show_venue() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_venue']) ? $ops['event_show_venue'] : 'true';
	}

	public static function event_show_address() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_address']) ? $ops['event_show_address'] : 'true';
	}

	public static function event_show_organizer() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_organizer']) ? $ops['event_show_organizer'] : 'true';
	}

	public static function event_show_sponsors() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_sponsors']) ? $ops['event_show_sponsors'] : 'true';
	}

	public static function event_show_extra_info() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_extra_info']) ? $ops['event_show_extra_info'] : 'true';
	}

	public static function event_show_faq() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_faq']) ? $ops['event_show_faq'] : 'true';
	}

	public static function event_show_ical() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_ical']) ? $ops['event_show_ical'] : 'true';
	}

	public static function event_show_content() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_content']) ? $ops['event_show_content'] : 'true';
	}

	public static function event_show_startdate() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_startdate']) ? $ops['event_show_startdate'] : 'true';
	}

	public static function event_show_enddate() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_enddate']) ? $ops['event_show_enddate'] : 'true';
	}

	public static function event_show_room() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_room']) ? $ops['event_show_room'] : 'true';
	}

	public static function event_show_gallery() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_gallery']) ? $ops['event_show_gallery'] : 'true';
	}

	public static function event_detail_template() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_detail_template']) ? $ops['event_detail_template'] : 'classic';
	}

	public static function event_show_map() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_map']) ? $ops['event_show_map'] : 'address';
	}

	public static function event_show_map_btn() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_show_map_btn']) ? $ops['event_show_map_btn'] : 'yes';
	}

	public static function event_map_zoom() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_map_zoom']) ? $ops['event_map_zoom'] : '20';
	}

	/**
    * upcomming days
    */
	public static function upcomming_days() {
		$ops = get_option('ovaem_options');
		return isset($ops['upcomming_days']) ? $ops['upcomming_days'] : '1000';
	}

	/**
    * Number event related
    */
	public static function number_event_related() {
		$ops = get_option('ovaem_options');
		return isset($ops['number_event_related']) ? $ops['number_event_related'] : '4';
	}

	/**
    * Currency Position
    */
	public static function currency_position() {
		$ops = get_option('ovaem_options');
		return isset($ops['currency_position']) ? $ops['currency_position'] : 'left';
	}

	/**
    * Google Type Event
    */
	public static function google_type_event() {
		$ops = get_option('ovaem_options');
		return isset($ops['google_type_event']) ? $ops['google_type_event'] : 'yes';
	}
	public static function event_secret_key() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_secret_key']) ? $ops['event_secret_key'] : 'ovatheme.com';
	}

	public static function event_calendar_input_step() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_calendar_input_step']) ? $ops['event_calendar_input_step'] : 30;
	}

	public static function archives_event_style() {
		$ops = get_option('ovaem_options');
		return isset($ops['archives_event_style']) ? $ops['archives_event_style'] : 'grid';
	}
	public static function archives_event_style_grid() {
		$ops = get_option('ovaem_options');
		return isset($ops['archives_event_style_grid']) ? $ops['archives_event_style_grid'] : 'style1';
	}
	public static function archives_event_show_past() {
		$ops = get_option('ovaem_options');
		return isset($ops['archives_event_show_past']) ? $ops['archives_event_show_past'] : 'true';
	}

	public static function archives_event_show_desc_cat() {
		$ops = get_option('ovaem_options');
		return isset($ops['archives_event_show_desc_cat']) ? $ops['archives_event_show_desc_cat'] : 'true';
	}
	
	public static function archives_event_show_status() {
		$ops = get_option('ovaem_options');
		return isset($ops['archives_event_show_status']) ? $ops['archives_event_show_status'] : 'false';
	}

	public static function archives_event_show_get_ticket() {
		$ops = get_option('ovaem_options');
		return isset($ops['archives_event_show_get_ticket']) ? $ops['archives_event_show_get_ticket'] : 'true';
	}

	public static function archives_event_orderby() {
		$ops = get_option('ovaem_options');
		return isset($ops['archives_event_orderby']) ? $ops['archives_event_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
	}

	public static function archives_event_order() {
		$ops = get_option('ovaem_options');
		return isset($ops['archives_event_order']) ? $ops['archives_event_order'] : 'ASC';
	}

	public static function ovaem_day_format() {
		$ops = get_option('ovaem_options');
		return isset($ops['ovaem_day_format']) ? $ops['ovaem_day_format'] : 'j';
	}
	public static function ovaem_month_format() {
		$ops = get_option('ovaem_options');
		return isset($ops['ovaem_month_format']) ? $ops['ovaem_month_format'] : 'M';
	}

	public static function ovaem_year_format() {
		$ops = get_option('ovaem_options');
		return isset($ops['ovaem_year_format']) ? $ops['ovaem_year_format'] : 'Y';
	}

	public static function ovaem_list_post_per_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['ovaem_list_post_per_page']) ? $ops['ovaem_list_post_per_page'] : 9;
	}

	public static function ovaem_number_character_title_event() {
		$ops = get_option('ovaem_options');
		return isset($ops['ovaem_number_character_title_event']) ? $ops['ovaem_number_character_title_event'] : 30;
	}

	public static function ovaem_number_character_excerpt() {
		$ops = get_option('ovaem_options');
		return isset($ops['ovaem_number_character_excerpt']) ? $ops['ovaem_number_character_excerpt'] : 60;
	}

	public static function ovaem_number_character_venue() {
		$ops = get_option('ovaem_options');
		return isset($ops['ovaem_number_character_venue']) ? $ops['ovaem_number_character_venue'] : 20;
	}

	public static function search_event_show_past() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_event_show_past']) ? $ops['search_event_show_past'] : 'true';
	}

	public static function search_event_show_states() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_event_show_states']) ? $ops['search_event_show_states'] : 'true';
	}
	public static function search_event_show_cities() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_event_show_cities']) ? $ops['search_event_show_cities'] : 'true';
	}

	public static function search_event_orderby() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_event_orderby']) ? $ops['search_event_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
	}

	public static function search_event_order() {
		$ops = get_option('ovaem_options');
		return isset($ops['search_event_order']) ? $ops['search_event_order'] : 'ASC';
	}

	public static function list_speakers_style() {
		$ops = get_option('ovaem_options');
		return isset($ops['list_speakers_style']) ? $ops['list_speakers_style'] : 'style1';
	}

	public static function list_speakers_link_title() {
		$ops = get_option('ovaem_options');
		return isset($ops['list_speakers_link_title']) ? $ops['list_speakers_link_title'] : 'true';
	}
	public static function list_speakers_show_job() {
		$ops = get_option('ovaem_options');
		return isset($ops['list_speakers_show_job']) ? $ops['list_speakers_show_job'] : 'true';
	}
	public static function list_speakers_show_social() {
		$ops = get_option('ovaem_options');
		return isset($ops['list_speakers_show_social']) ? $ops['list_speakers_show_social'] : 'true';
	}

	public static function list_speakers_post_per_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['list_speakers_post_per_page']) ? $ops['list_speakers_post_per_page'] : 12;
	}

	public static function archive_venue_posts_per_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['archive_venue_posts_per_page']) ? $ops['archive_venue_posts_per_page'] : 12;
	}

	public static function archive_venue_style() {
		$ops = get_option('ovaem_options');
		return isset($ops['archive_venue_style']) ? $ops['archive_venue_style'] : 'style1';
	}

	public static function list_speakers_orderby() {
		$ops = get_option('ovaem_options');
		return isset($ops['list_speakers_orderby']) ? $ops['list_speakers_orderby'] : OVAEM_Settings::$prefix . '_speaker_order';
	}

	

	public static function list_speakers_order() {
		$ops = get_option('ovaem_options');
		return isset($ops['list_speakers_order']) ? $ops['list_speakers_order'] : 'ASC';
	}

	public static function speaker_joined_event_show() {
		$ops = get_option('ovaem_options');
		return isset($ops['speaker_joined_event_show']) ? $ops['speaker_joined_event_show'] : 'true';
	}

	public static function speaker_joined_event_show_past() {
		$ops = get_option('ovaem_options');
		return isset($ops['speaker_joined_event_show_past']) ? $ops['speaker_joined_event_show_past'] : 'true';
	}

	public static function speaker_joined_event_show_current() {
		$ops = get_option('ovaem_options');
		return isset($ops['speaker_joined_event_show_current']) ? $ops['speaker_joined_event_show_current'] : 'true';
	}

	public static function speaker_joined_event_count() {
		$ops = get_option('ovaem_options');
		return isset($ops['speaker_joined_event_count']) ? $ops['speaker_joined_event_count'] : '100';
	}

	public static function speaker_joined_event_orderby() {
		$ops = get_option('ovaem_options');
		return isset($ops['speaker_joined_event_orderby']) ? $ops['speaker_joined_event_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
	}

	public static function speaker_joined_event_order() {
		$ops = get_option('ovaem_options');
		return isset($ops['speaker_joined_event_order']) ? $ops['speaker_joined_event_order'] : 'ASC';
	}

	public static function archive_venue_orderby() {
		$ops = get_option('ovaem_options');
		return isset($ops['archive_venue_orderby']) ? $ops['archive_venue_orderby'] : OVAEM_Settings::$prefix . '_venue_order';
	}

	public static function archive_venue_order() {
		$ops = get_option('ovaem_options');
		return isset($ops['archive_venue_order']) ? $ops['archive_venue_order'] : 'ASC';
	}

	public static function detail_venue_event_show() {
		$ops = get_option('ovaem_options');
		return isset($ops['detail_venue_event_show']) ? $ops['detail_venue_event_show'] : 'true';
	}
	public static function detail_venue_event_show_past() {
		$ops = get_option('ovaem_options');
		return isset($ops['detail_venue_event_show_past']) ? $ops['detail_venue_event_show_past'] : 'true';
	}

	public static function detail_venue_event_map_zoom() {
		$ops = get_option('ovaem_options');
		return isset($ops['detail_venue_event_map_zoom']) ? $ops['detail_venue_event_map_zoom'] : '20';
	}
	public static function detail_venue_event_count() {
		$ops = get_option('ovaem_options');
		return isset($ops['detail_venue_event_count']) ? $ops['detail_venue_event_count'] : '100';
	}

	public static function detail_venue_event_orderby() {
		$ops = get_option('ovaem_options');
		return isset($ops['detail_venue_event_orderby']) ? $ops['detail_venue_event_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
	}

	public static function send_mail_from() {
		$ops = get_option('ovaem_options');
		return isset($ops['send_mail_from']) ? $ops['send_mail_from'] : get_option( 'admin_email' );
	}

	public static function detail_venue_event_order() {
		$ops = get_option('ovaem_options');
		return isset($ops['detail_venue_event_order']) ? $ops['detail_venue_event_order'] : 'ASC';
	}

	public static function checkout_payment_default() {
		$ops = get_option('ovaem_options');
		return isset($ops['checkout_payment_default']) ? $ops['checkout_payment_default'] : 'offline';
	}

	/**
    * events_per_page
    */
   // public static function events_per_page(){
   //    $ops = get_option('ovaem_options');
   //    return isset( $ops['events_per_page'] ) ? $ops['events_per_page'] : '';
   // }

	/**
    * cart page
    */
	public static function cart_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['cart_page']) ? $ops['cart_page'] : '';
	}

	/**
    * Checkout page
    */
	public static function checkout_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['checkout_page']) ? $ops['checkout_page'] : '';
	}

	/* Terms and Conditions page */
	public static function terms_conditions_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['terms_conditions_page']) ? $ops['terms_conditions_page'] : '';
	}

	/**
    * Checkout cancel page
    */
	public static function checkout_cancel_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['checkout_cancel_page']) ? $ops['checkout_cancel_page'] : '';
	}

	/**
    * Paypal Live
    */
	public static function paypal_envi() {
		$ops = get_option('ovaem_options');
		return isset($ops['paypal_envi']) ? $ops['paypal_envi'] : 'live';
	}

	public static function paypal_busi_email() {
		$ops = get_option('ovaem_options');
		return isset($ops['paypal_busi_email']) ? $ops['paypal_busi_email'] : '';
	}
	public static function paypal_save_log() {
		$ops = get_option('ovaem_options');
		return isset($ops['paypal_save_log']) ? $ops['paypal_save_log'] : 'false';
	}
	public static function paypal_info() {
		$ops = get_option('ovaem_options');
		return isset($ops['paypal_info']) ? $ops['paypal_info'] : esc_html__('Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.', 'ovaem-events-manager');
	}
	public static function paypal_cur() {
		$ops = get_option('ovaem_options');
		return isset($ops['paypal_cur']) ? $ops['paypal_cur'] : 'USD';
	}

	public static function stripe_payment_public_key() {
		$ops = get_option('ovaem_options');
		return isset($ops['stripe_payment_public_key']) ? $ops['stripe_payment_public_key'] : '';
	}
	public static function stripe_payment_serect_key() {
		$ops = get_option('ovaem_options');
		return isset($ops['stripe_payment_serect_key']) ? $ops['stripe_payment_serect_key'] : '';
	}
	public static function stripe_payment_currency() {
		$ops = get_option('ovaem_options');
		return isset($ops['stripe_payment_currency']) ? $ops['stripe_payment_currency'] : 'USD';
	}

	public static function stripe_info() {
		$ops = get_option('ovaem_options');
		return isset($ops['stripe_info']) ? $ops['stripe_info'] : esc_html__('You can pay with your credit card.', 'ovaem-events-manager');
	}

	public static function pdf_ticket_template() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_template']) ? $ops['pdf_ticket_template'] : 'version2';
	}

	public static function pdf_ticket_show_logo() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_logo']) ? $ops['pdf_ticket_show_logo'] : 'true';
	}

	

	public static function pdf_ticket_show_order_id() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_order_id']) ? $ops['pdf_ticket_show_order_id'] : 'true';
	}

	public static function pdf_ticket_show_order_time() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_order_time']) ? $ops['pdf_ticket_show_order_time'] : 'true';
	}

	public static function pdf_ticket_show_time() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_time']) ? $ops['pdf_ticket_show_time'] : 'true';
	}

	public static function event_mail_attachment() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_mail_attachment']) ? $ops['event_mail_attachment'] : 'both';
	}

	public static function event_file_cer_attachment() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_file_cer_attachment']) ? $ops['event_file_cer_attachment'] : 'yes';
	}

	public static function pdf_ticket_logo() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_logo']) ? $ops['pdf_ticket_logo'] : '';
	}

	public static function pdf_ticket_show_venue() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_venue']) ? $ops['pdf_ticket_show_venue'] : 'true';
	}
	public static function pdf_ticket_show_adress() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_adress']) ? $ops['pdf_ticket_show_adress'] : 'true';
	}
	public static function pdf_ticket_show_code() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_code']) ? $ops['pdf_ticket_show_code'] : 'true';
	}
	public static function pdf_ticket_show_holder_ticket() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_holder_ticket']) ? $ops['pdf_ticket_show_holder_ticket'] : 'true';
	}
	public static function pdf_ticket_show_package() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_package']) ? $ops['pdf_ticket_show_package'] : 'true';
	}
	public static function pdf_ticket_show_qrcode() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_show_qrcode']) ? $ops['pdf_ticket_show_qrcode'] : 'true';
	}
	public static function pdf_ticket_format_qr() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_format_qr']) ? $ops['pdf_ticket_format_qr'] : 'url';
	}

	public static function pdf_ticket_label_color() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_label_color']) ? $ops['pdf_ticket_label_color'] : '#333333';
	}

	public static function pdf_ticket_text_color() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_text_color']) ? $ops['pdf_ticket_text_color'] : '#555555';
	}

	public static function pdf_ticket_event_fontsize() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_event_fontsize']) ? $ops['pdf_ticket_event_fontsize'] : '18';
	}

	public static function pdf_ticket_label_fontsize() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_label_fontsize']) ? $ops['pdf_ticket_label_fontsize'] : '12';
	}

	public static function pdf_ticket_text_fontsize() {
		$ops = get_option('ovaem_options');
		return isset($ops['pdf_ticket_text_fontsize']) ? $ops['pdf_ticket_text_fontsize'] : '12';
	}

	public static function user_submit_admin_review() {
		$ops = get_option('ovaem_options');
		return isset($ops['user_submit_admin_review']) ? $ops['user_submit_admin_review'] : 'true';
	}

	public static function captcha_type() {
		$ops = get_option('ovaem_options');
		return isset($ops['captcha_type']) ? $ops['captcha_type'] : 'v2';
	}

	public static function captcha_sitekey() {
		$ops = get_option('ovaem_options');
		return isset($ops['captcha_sitekey']) ? $ops['captcha_sitekey'] : '';
	}

	public static function captcha_serectkey() {
		$ops = get_option('ovaem_options');
		return isset($ops['captcha_serectkey']) ? $ops['captcha_serectkey'] : '';
	}

	public static function enable_for_login() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_for_login']) ? $ops['enable_for_login'] : '';
	}

	public static function enable_for_register() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_for_register']) ? $ops['enable_for_register'] : '';
	}

	public static function enable_for_lost_password() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_for_lost_password']) ? $ops['enable_for_lost_password'] : '';
	}

	public static function enable_for_comment() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_for_comment']) ? $ops['enable_for_comment'] : '';
	}

	public static function enable_register_event() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_register_event']) ? $ops['enable_register_event'] : '';
	}

	public static function enable_woo_checkout() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_woo_checkout']) ? $ops['enable_woo_checkout'] : '';
	}
	
	public static function enable_event_checkout() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_event_checkout']) ? $ops['enable_event_checkout'] : '';
	}

	public static function enable_event_free() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_event_free']) ? $ops['enable_event_free'] : '';
	}
	
	public static function enable_event_cfc_checkout() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_event_cfc_checkout']) ? $ops['enable_event_cfc_checkout'] : '';
	}
	
	public static function enable_event_cfc_woo_checkout() {
		$ops = get_option('ovaem_options');
		return isset($ops['enable_event_cfc_woo_checkout']) ? $ops['enable_event_cfc_woo_checkout'] : '';
	}
	
	public static function ticket_free_max_number() {
		$ops = get_option('ovaem_options');
		return isset($ops['ticket_free_max_number']) ? $ops['ticket_free_max_number'] : '10';
	}

	public static function login_before_booking() {
		$ops = get_option('ovaem_options');
		return isset($ops['login_before_booking']) ? $ops['login_before_booking'] : 'no';
	}

	public static function event_calendar_lang() {
		$ops = get_option('ovaem_options');
		return isset($ops['event_calendar_lang']) ? $ops['event_calendar_lang'] : 'en-GB';
	}

	public static function first_day_of_week() {
		$ops = get_option('ovaem_options');
		return isset($ops['first_day_of_week']) ? $ops['first_day_of_week'] : '0';
	}
	

	/**
    * thanks page
    */
	public static function thanks_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['thanks_page']) ? $ops['thanks_page'] : '';
	}

	public static function woo_product_hidden() {
        $ops = get_option('ovaem_options');
        return isset($ops['woo_product_hidden']) ? $ops['woo_product_hidden'] : '';
    }

	public static function woo_make_ticket_verify() {
		$ops = get_option('ovaem_options');
		return isset($ops['woo_make_ticket_verify']) ? $ops['woo_make_ticket_verify'] : array(0 => array('wc-completed', 'wc-on-hold'));
	}

	/**
    * mail to
    */
	public static function mail_to() {
		$ops = get_option('ovaem_options');
		return isset($ops['mail_to']) ? $ops['mail_to'] : array(0 => array('admin', 'client'));
	}

	public static function paid_ticket_mail_to() {
		$ops = get_option('ovaem_options');
		return isset($ops['paid_ticket_mail_to']) ? $ops['paid_ticket_mail_to'] : array(0 => array('admin', 'client'));
	}
	/**
    * mail template
    */
	public static function mail_template() {
		$ops = get_option('ovaem_options');
		return isset($ops['mail_template']) ? $ops['mail_template'] : 'Event Name: [event] <br/>
		Order ID: [orderid]<br/>
		Name: [name] <br/>
		Phone: [phone] <br/>
		Email: [email] <br/>
		Address: [address] <br/>
		Company: [company] <br/>
		Number: [number] <br/>
		Addition: [addition] <br/>';
	}

	/**
    * paid ticket mail template
    */
	// public static function paid_ticket_mail_template() {
	// 	$ops = get_option('ovaem_options');
	// 	return isset($ops['paid_ticket_mail_template']) ? $ops['paid_ticket_mail_template'] : 'Order ID: [orderid]<br/>
	// 	Name: [name] <br/>
	// 	Phone: [phone] <br/>
	// 	Email: [email] <br/>
	// 	Address: [address] <br/>
	// 	Company: [company] <br/>
	// 	Addition: [addition] <br/>
	// 	Cart: [cart] <br/>';
	// }

	public static function paid_ticket_mail_template() {
	$file_path = plugin_dir_path(__FILE__) . '../mail-templates/paid-ticket-mail-template-customer.html';
	if (file_exists($file_path)) {
		return file_get_contents($file_path);
	} else {
		return 'Order ID: [orderid]<br/>
		Name: [name] <br/>
		Phone: [phone] <br/>
		Email: [email] <br/>
		Address: [address] <br/>
		Company: [company] <br/>
		Addition: [addition] <br/>
		Cart: [cart] <br/>';
	}
}

	/**
    *
    */
	public static function user_manage_event_page() {
		$ops = get_option('ovaem_options');
		return isset($ops['user_manage_event_page']) ? $ops['user_manage_event_page'] : '';
	}

	public static function frontend_submit_limit_gallery() {
		$ops = get_option('ovaem_options');
		return isset($ops['frontend_submit_limit_gallery']) ? $ops['frontend_submit_limit_gallery'] : '4';
	}

	public static function frontend_submit_limit_tags() {
		$ops = get_option('ovaem_options');
		return isset($ops['frontend_submit_limit_tags']) ? $ops['frontend_submit_limit_tags'] : '10';
	}

	public static function frontend_submit_show_editor() {
		$ops = get_option('ovaem_options');
		return isset($ops['frontend_submit_show_editor']) ? $ops['frontend_submit_show_editor'] : 'yes';
	}

	public static function google_key_map_new() {
		$ops = get_option('ovaem_options');
		return isset($ops['google_key_map_new']) ? $ops['google_key_map_new'] : '';
	}

	public static function offline_payment_use() {
		$ops = get_option('ovaem_options');
		return isset($ops['offline_payment_use']) ? $ops['offline_payment_use'] : 'true';
	}

	public static function offline_payment_verify_ticket() {
		$ops = get_option('ovaem_options');
		return isset($ops['offline_payment_verify_ticket']) ? $ops['offline_payment_verify_ticket'] : 'true';
	}

	public static function offline_payment_info() {
		$ops = get_option('ovaem_options');
		return isset($ops['offline_payment_info']) ? $ops['offline_payment_info'] : esc_html__('In Admin: You can config allow to send ticket after checkout successfully.', 'ovaem-events-manager');
	}

}

new OVAEM_Settings();
