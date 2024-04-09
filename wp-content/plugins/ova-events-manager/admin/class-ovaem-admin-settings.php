<?php

if (!defined('ABSPATH')) {
   exit();
}

if (!class_exists('OVAEM_Admin_Settings')) {

   /**
    * Make Admin Class
    */
   class OVAEM_Admin_Settings {

      /**
       * Construct Admin
       */
      public function __construct() {
         add_action('admin_init', array($this, 'register_options'));
         add_action('admin_enqueue_scripts', array($this, 'em4u_load_scripts_admin'));
      }

      public function em4u_load_scripts_admin() {
         wp_enqueue_media();
      }

      public function register_options() {

         // Register settings
         register_setting(
            'ovaem_options_group', // Option group
            'ovaem_options', // Name Option
            array($this, 'settings_callback') // Call Back
         );

         /**
          * General Settings
          */

         // Add Section: Taxonomy Settings
         add_settings_section(
            'taxonomy_section_id', // ID
            esc_html__('Taxonomy Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'taxonomy_settings' // Page
         );

         // Add Fields: Taxonomy
         add_settings_field(
            'slug_taxonomy_name', // ID
            esc_html__('Change Slug', 'ovaem-events-manager'),
            array($this, 'slug_taxonomy_name'),
            'taxonomy_settings', // Page
            'taxonomy_section_id' // Section
         );

         // Add Section: Event Post Type Settings
         add_settings_section(
            'general_section_id', // ID
            esc_html__('Event Post Type', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'general_settings' // Page
         );

         // Add Fields: Event Post Type Section
         add_settings_field(
            'event_post_type_slug', // ID
            // esc_html__('Change Slug *', 'ovaem-events-manager'),
            array($this, 'event_post_type_slug'),
            'general_settings', // Page
            'general_section_id' // Section
         );

         add_settings_field(
            'event_post_type_rewrite_slug', // ID
            esc_html__('Rewrite Slug at frontend', 'ovaem-events-manager'),
            array($this, 'event_post_type_rewrite_slug'),
            'general_settings', // Page
            'general_section_id' // Section
         );

         // Add Section: Speaker Settings Settings
         add_settings_section(
            'speaker_section_id', // ID
            esc_html__('Speaker Post Type', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'speaker_settings' // Page
         );

         // Add Fields: Speaker Post Type Section
         add_settings_field(
            'speaker_post_type_slug', // ID
            // esc_html__('Change slug','ovaem-events-manager' ),
            array($this, 'speaker_post_type_slug'),
            'speaker_settings', // Page
            'speaker_section_id' // Section
         );

         add_settings_field(
            'speaker_post_type_rewrite_slug', // ID
            esc_html__('Rewrite Slug at frontend', 'ovaem-events-manager'),
            array($this, 'speaker_post_type_rewrite_slug'),
            'speaker_settings', // Page
            'speaker_section_id' // Section
         );

         add_settings_section(
            'slug_venue_section_id', // ID
            esc_html__('Venue Post Type', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'slug_venue_settings' // Page
         );

         // Add Fields: Speaker Post Type Section
         add_settings_field(
            'venue_post_type_slug', // ID
            // esc_html__('Change slug','ovaem-events-manager' ),
            array($this, 'venue_post_type_slug'),
            'slug_venue_settings', // Page
            'slug_venue_section_id' // Section
         );

         add_settings_field(
            'venue_post_type_rewrite_slug', // ID
            esc_html__('Rewrite slug at frontend', 'ovaem-events-manager'),
            array($this, 'venue_post_type_rewrite_slug'),
            'slug_venue_settings', // Page
            'slug_venue_section_id' // Section
         );

         /**
          * Basic Settings
          */

         // Add Section: Basic Settings
         add_settings_section(
            'basic_section_id', // ID
            esc_html__('Basic Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'basic_settings' // Page
         );

         // Add Fields: Basic Section
         add_settings_field(
            'google_key_map', // ID
            esc_html__('Google Key Map', 'ovaem-events-manager'),
            array($this, 'google_key_map'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );

         add_settings_field(
            'upcomming_days', // ID
            esc_html__('Upcoming Day', 'ovaem-events-manager'),
            array($this, 'upcomming_days'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );

         add_settings_field(
            'number_event_related', // ID
            esc_html__('Number Event Related', 'ovaem-events-manager'),
            array($this, 'number_event_related'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );

         add_settings_field(
            'currency_position', // ID
            esc_html__('Currency Position', 'ovaem-events-manager'),
            array($this, 'currency_position'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );

         add_settings_field(
            'google_type_event', // ID
            esc_html__('Google Type Event', 'ovaem-events-manager'),
            array($this, 'google_type_event'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );

         add_settings_field(
            'event_secret_key', // ID
            esc_html__('Secret Key QR Code', 'ovaem-events-manager'),
            array($this, 'event_secret_key'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );

         add_settings_field(
            'event_calendar_input_step', // ID
            esc_html__('Step time when choose date', 'ovaem-events-manager'),
            array($this, 'event_calendar_input_step'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );

         add_settings_field(
            'event_calendar_lang', // ID
            esc_html__('Calendar Language', 'ovaem-events-manager'),
            array($this, 'event_calendar_lang'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );

         add_settings_field(
            'first_day_of_week', // ID
            esc_html__('The first day of week', 'ovaem-events-manager'),
            array($this, 'first_day_of_week'),
            'basic_settings', // Page
            'basic_section_id' // Section ID
         );
       
         /**
          * List Events
          */
         add_settings_section(
            'list_events_section_id', // ID
            esc_html__('List Events Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'list_events_settings' // Page
         );

         add_settings_field(
            'archives_event_style', // ID
            esc_html__('Style Archives/Category Event', 'ovaem-events-manager'),
            array($this, 'archives_event_style'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'archives_event_style_grid', // ID
            esc_html__('Grid Style', 'ovaem-events-manager'),
            array($this, 'archives_event_style_grid'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'archives_event_show_past', // ID
            esc_html__('Display Past Event', 'ovaem-events-manager'),
            array($this, 'archives_event_show_past'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

          add_settings_field(
            'archives_event_show_desc_cat', // ID
            esc_html__('Display Description of Category', 'ovaem-events-manager'),
            array($this, 'archives_event_show_desc_cat'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'archives_event_show_status', // ID
            esc_html__('Display Status Event', 'ovaem-events-manager'),
            array($this, 'archives_event_show_status'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'archives_event_show_get_ticket', // ID
            esc_html__('Display Get Ticket', 'ovaem-events-manager'),
            array($this, 'archives_event_show_get_ticket'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'archives_event_orderby', // ID
            esc_html__('Order By', 'ovaem-events-manager'),
            array($this, 'archives_event_orderby'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'archives_event_order', // ID
            esc_html__('Order', 'ovaem-events-manager'),
            array($this, 'archives_event_order'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'ovaem_day_format', // ID
            esc_html__('Day Format', 'ovaem-events-manager'),
            array($this, 'ovaem_day_format'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'ovaem_month_format', // ID
            esc_html__('Month Format', 'ovaem-events-manager'),
            array($this, 'ovaem_month_format'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'ovaem_year_format', // ID
            esc_html__('Year Format', 'ovaem-events-manager'),
            array($this, 'ovaem_year_format'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'ovaem_list_post_per_page', // ID
            esc_html__('Events Per Page', 'ovaem-events-manager'),
            array($this, 'ovaem_list_post_per_page'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'ovaem_number_character_title_event', // ID
            esc_html__('Number Of Character Title Event', 'ovaem-events-manager'),
            array($this, 'ovaem_number_character_title_event'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'ovaem_number_character_excerpt', // ID
            esc_html__('Number Of Character Excerpt', 'ovaem-events-manager'),
            array($this, 'ovaem_number_character_excerpt'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         add_settings_field(
            'ovaem_number_character_venue', // ID
            esc_html__('Number Of Character Venue', 'ovaem-events-manager'),
            array($this, 'ovaem_number_character_venue'),
            'list_events_settings', // Page
            'list_events_section_id' // Section ID
         );

         /**
          * Search Settings
          */
         add_settings_section(
            'search_section_id', // ID
            esc_html__('Search Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'search_settings' // Page
         );

         // Add Fields: search_name
         add_settings_field(
            'search_name', // ID
            esc_html__('Search Name', 'ovaem-events-manager'),
            array($this, 'search_name'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         // Add Fields: search_cat
         add_settings_field(
            'search_cat', // ID
            esc_html__('Search Cat', 'ovaem-events-manager'),
            array($this, 'search_cat'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         // Add Fields: search_venue
         add_settings_field(
            'search_venue', // ID
            esc_html__('Search Venue', 'ovaem-events-manager'),
            array($this, 'search_venue'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         // Add Fields: search_time
         add_settings_field(
            'search_time', // ID
            esc_html__('Search Time', 'ovaem-events-manager'),
            array($this, 'search_time'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_today', // ID
            esc_html__('Show today in All Time', 'ovaem-events-manager'),
            array($this, 'search_time_today'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_tomorrow', // ID
            esc_html__('Show tomorrow in All Time', 'ovaem-events-manager'),
            array($this, 'search_time_tomorrow'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_this_week', // ID
            esc_html__('Show this week in All Time', 'ovaem-events-manager'),
            array($this, 'search_time_this_week'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_this_week_end', // ID
            esc_html__('Show this weekend in All Time', 'ovaem-events-manager'),
            array($this, 'search_time_this_week_end'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_this_week_end_day', // ID
            esc_html__('Choose the weekends', 'ovaem-events-manager'),
            array($this, 'search_time_this_week_end_day'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_next_week', // ID
            esc_html__('Show next week in All Time', 'ovaem-events-manager'),
            array($this, 'search_time_next_week'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_next_month', // ID
            esc_html__('Show next month in All Time', 'ovaem-events-manager'),
            array($this, 'search_time_next_month'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_past', // ID
            esc_html__('Show past in All Time', 'ovaem-events-manager'),
            array($this, 'search_time_past'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_time_future', // ID
            esc_html__('Show future in All Time', 'ovaem-events-manager'),
            array($this, 'search_time_future'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         // Add Fields: search_date
         add_settings_field(
            'search_date', // ID
            esc_html__('Search Date', 'ovaem-events-manager'),
            array($this, 'search_date'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_event_show_past', // ID
            esc_html__('Display Past Event', 'ovaem-events-manager'),
            array($this, 'search_event_show_past'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_event_show_states', // ID
            esc_html__('Show States', 'ovaem-events-manager'),
            array($this, 'search_event_show_states'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_event_show_cities', // ID
            esc_html__('Show Cities', 'ovaem-events-manager'),
            array($this, 'search_event_show_cities'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_event_orderby', // ID
            esc_html__('Order By', 'ovaem-events-manager'),
            array($this, 'search_event_orderby'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         add_settings_field(
            'search_event_order', // ID
            esc_html__('Order', 'ovaem-events-manager'),
            array($this, 'search_event_order'),
            'search_settings', // Page
            'search_section_id' // Section ID
         );

         /**
          * Event Detail Settings
          */
         add_settings_section(
            'event_detail_section_id', // ID
            esc_html__('Event Detail Settings', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'event_detail_settings' // Page
         );

         add_settings_field(
            'event_detail_template', // ID
            esc_html__('Template', 'ovaem-events-manager'),
            array($this, 'event_detail_template'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_content', // ID
            esc_html__('Show Content', 'ovaem-events-manager'),
            array($this, 'event_show_content'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_gallery', // ID
            esc_html__('Show Gallery', 'ovaem-events-manager'),
            array($this, 'event_show_gallery'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         // Add Fields: show_tag
         add_settings_field(
            'event_show_tag', // ID
            esc_html__('Show Tag', 'ovaem-events-manager'),
            array($this, 'event_show_tag'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_share_social', // ID
            esc_html__('Show Share Social', 'ovaem-events-manager'),
            array($this, 'event_show_share_social'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_book_now', // ID
            esc_html__('Show Book Now Button', 'ovaem-events-manager'),
            array($this, 'event_show_book_now'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_book_now_event_past', // ID
            esc_html__('Show Book Now Button when event expired', 'ovaem-events-manager'),
            array($this, 'event_show_book_now_event_past'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_scroll_tab', // ID
            esc_html__('Scroll Tab', 'ovaem-events-manager'),
            array($this, 'event_scroll_tab'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_schedule_tab', // ID
            esc_html__('Show Schedule Tab', 'ovaem-events-manager'),
            array($this, 'event_show_schedule_tab'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_speaker_tab', // ID
            esc_html__('Show Speaker Tab', 'ovaem-events-manager'),
            array($this, 'event_show_speaker_tab'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_ticket_tab', // ID
            esc_html__('Show Ticket Tab', 'ovaem-events-manager'),
            array($this, 'event_show_ticket_tab'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_ticket_tab_expired', // ID
            esc_html__('Show Ticket Tab When event expired', 'ovaem-events-manager'),
            array($this, 'event_show_ticket_tab_expired'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_related', // ID
            esc_html__('Show Related Event', 'ovaem-events-manager'),
            array($this, 'event_show_related'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_comments', // ID
            esc_html__('Show Comemnts Event', 'ovaem-events-manager'),
            array($this, 'event_show_comments'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_contact', // ID
            esc_html__('Show Contact Form', 'ovaem-events-manager'),
            array($this, 'event_show_contact'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_notify', // ID
            esc_html__('Show notify: in time or expired', 'ovaem-events-manager'),
            array($this, 'event_show_notify'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_startdate', // ID
            esc_html__('Show Start Date', 'ovaem-events-manager'),
            array($this, 'event_show_startdate'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_enddate', // ID
            esc_html__('Show End Date', 'ovaem-events-manager'),
            array($this, 'event_show_enddate'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_room', // ID
            esc_html__('Show Room', 'ovaem-events-manager'),
            array($this, 'event_show_room'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_venue', // ID
            esc_html__('Show venue', 'ovaem-events-manager'),
            array($this, 'event_show_venue'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_address', // ID
            esc_html__('Show Address', 'ovaem-events-manager'),
            array($this, 'event_show_address'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_organizer', // ID
            esc_html__('Show Organizer', 'ovaem-events-manager'),
            array($this, 'event_show_organizer'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_map', // ID
            esc_html__('Show Map', 'ovaem-events-manager'),
            array($this, 'event_show_map'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_map_btn', // ID
            esc_html__('Show Map Button', 'ovaem-events-manager'),
            array($this, 'event_show_map_btn'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_ical', // ID
            esc_html__('Show Google Calendar', 'ovaem-events-manager'),
            array($this, 'event_show_ical'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_map_zoom', // ID
            esc_html__('Map Zoom', 'ovaem-events-manager'),
            array($this, 'event_map_zoom'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_sponsors', // ID
            esc_html__('Show Sponsors', 'ovaem-events-manager'),
            array($this, 'event_show_sponsors'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_extra_info', // ID
            esc_html__('Show Extra Info', 'ovaem-events-manager'),
            array($this, 'event_show_extra_info'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         add_settings_field(
            'event_show_faq', // ID
            esc_html__('Show FAQ', 'ovaem-events-manager'),
            array($this, 'event_show_faq'),
            'event_detail_settings', // Page
            'event_detail_section_id' // Section ID
         );

         /**
          * Speaker Settings
          */
         add_settings_section(
            'list_speakers_section_id', // ID
            esc_html__('Archive Speaker Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'list_speakers_settings' // Page
         );

         // Add Fields
         add_settings_field(
            'list_speakers_style', // ID
            esc_html__('Style', 'ovaem-events-manager'),
            array($this, 'list_speakers_style'),
            'list_speakers_settings', // Page
            'list_speakers_section_id' // Section ID
         );

         add_settings_field(
            'list_speakers_orderby', // ID
            esc_html__('Order By', 'ovaem-events-manager'),
            array($this, 'list_speakers_orderby'),
            'list_speakers_settings', // Page
            'list_speakers_section_id' // Section ID
         );

         add_settings_field(
            'list_speakers_order', // ID
            esc_html__('Order', 'ovaem-events-manager'),
            array($this, 'list_speakers_order'),
            'list_speakers_settings', // Page
            'list_speakers_section_id' // Section ID
         );

         // Add Fields
         add_settings_field(
            'list_speakers_link_title', // ID
            esc_html__('Link Title', 'ovaem-events-manager'),
            array($this, 'list_speakers_link_title'),
            'list_speakers_settings', // Page
            'list_speakers_section_id' // Section ID
         );

         // Add Fields
         add_settings_field(
            'list_speakers_show_job', // ID
            esc_html__('Show Job', 'ovaem-events-manager'),
            array($this, 'list_speakers_show_job'),
            'list_speakers_settings', // Page
            'list_speakers_section_id' // Section ID
         );

         // Add Fields
         add_settings_field(
            'list_speakers_show_social', // ID
            esc_html__('Show Social', 'ovaem-events-manager'),
            array($this, 'list_speakers_show_social'),
            'list_speakers_settings', // Page
            'list_speakers_section_id' // Section ID
         );

         add_settings_field(
            'list_speakers_post_per_page', // ID
            esc_html__('Number Speaker per page', 'ovaem-events-manager'),
            array($this, 'list_speakers_post_per_page'),
            'list_speakers_settings', // Page
            'list_speakers_section_id' // Section ID
         );

         /**
          * Speaker Detail Settings
          */
         add_settings_section(
            'detail_speaker_section_id', // ID
            esc_html__('Detail Speaker Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'detail_speakers_settings' // Page
         );

         add_settings_field(
            'speaker_joined_event_show', // ID
            esc_html__('Events Joined show', 'ovaem-events-manager'),
            array($this, 'speaker_joined_event_show'),
            'detail_speakers_settings', // Page
            'detail_speaker_section_id' // Section ID
         );

         add_settings_field(
            'speaker_joined_event_count', // ID
            esc_html__('Speaker joined event:: Count', 'ovaem-events-manager'),
            array($this, 'speaker_joined_event_count'),
            'detail_speakers_settings', // Page
            'detail_speaker_section_id' // Section ID
         );

         add_settings_field(
            'speaker_joined_event_show_past', // ID
            esc_html__('Speaker joined event: Show Past Event', 'ovaem-events-manager'),
            array($this, 'speaker_joined_event_show_past'),
            'detail_speakers_settings', // Page
            'detail_speaker_section_id' // Section ID
         );

         add_settings_field(
            'speaker_joined_event_show_current', // ID
            esc_html__('Speaker joined event: Show Current Event', 'ovaem-events-manager'),
            array($this, 'speaker_joined_event_show_current'),
            'detail_speakers_settings', // Page
            'detail_speaker_section_id' // Section ID
         );

         add_settings_field(
            'speaker_joined_event_orderby', // ID
            esc_html__('Speaker joined event: Order By', 'ovaem-events-manager'),
            array($this, 'speaker_joined_event_orderby'),
            'detail_speakers_settings', // Page
            'detail_speaker_section_id' // Section ID
         );

         add_settings_field(
            'speaker_joined_event_order', // ID
            esc_html__('Speaker joined event: Order', 'ovaem-events-manager'),
            array($this, 'speaker_joined_event_order'),
            'detail_speakers_settings', // Page
            'detail_speaker_section_id' // Section ID
         );

         /**
          * Venue Settings
          */
         add_settings_section(
            'venue_section_id', // ID
            esc_html__('Venue Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'venue_settings' // Page
         );

         // Add Fields
         add_settings_field(
            'archive_venue_style', // ID
            esc_html__('Archive Venue Style', 'ovaem-events-manager'),
            array($this, 'archive_venue_style'),
            'venue_settings', // Page
            'venue_section_id' // Section ID
         );

         add_settings_field(
            'archive_venue_orderby', // ID
            esc_html__('Order By', 'ovaem-events-manager'),
            array($this, 'archive_venue_orderby'),
            'venue_settings', // Page
            'venue_section_id' // Section ID
         );

        
         add_settings_field(
            'archive_venue_order', // ID
            esc_html__('Order', 'ovaem-events-manager'),
            array($this, 'archive_venue_order'),
            'venue_settings', // Page
            'venue_section_id' // Section ID
         );

          add_settings_field(
            'archive_venue_posts_per_page', // ID
            esc_html__('Number Venue per page', 'ovaem-events-manager'),
            array($this, 'archive_venue_posts_per_page'),
            'venue_settings', // Page
            'venue_section_id' // Section ID
         );


         add_settings_section(
            'detail_venue_section_id', // ID
            esc_html__('Detail Venue Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'detail_venue_settings' // Page
         );

         add_settings_field(
            'detail_venue_event_show', // ID
            esc_html__('Events in this venue: Show section', 'ovaem-events-manager'),
            array($this, 'detail_venue_event_show'),
            'detail_venue_settings', // Page
            'detail_venue_section_id' // Section ID
         );

         add_settings_field(
            'detail_venue_event_count', // ID
            esc_html__('Events in this venue: Count', 'ovaem-events-manager'),
            array($this, 'detail_venue_event_count'),
            'detail_venue_settings', // Page
            'detail_venue_section_id' // Section ID
         );

         add_settings_field(
            'detail_venue_event_show_past', // ID
            esc_html__('Events in this venue: Show Past Event', 'ovaem-events-manager'),
            array($this, 'detail_venue_event_show_past'),
            'detail_venue_settings', // Page
            'detail_venue_section_id' // Section ID
         );

         add_settings_field(
            'detail_venue_event_map_zoom', // ID
            esc_html__('Map Zoom', 'ovaem-events-manager'),
            array($this, 'detail_venue_event_map_zoom'),
            'detail_venue_settings', // Page
            'detail_venue_section_id' // Section ID
         );

         add_settings_field(
            'detail_venue_event_orderby', // ID
            esc_html__('Events in this venue:: Order By', 'ovaem-events-manager'),
            array($this, 'detail_venue_event_orderby'),
            'detail_venue_settings', // Page
            'detail_venue_section_id' // Section ID
         );

         add_settings_field(
            'detail_venue_event_order', // ID
            esc_html__('Events in this venue:: Order', 'ovaem-events-manager'),
            array($this, 'detail_venue_event_order'),
            'detail_venue_settings', // Page
            'detail_venue_section_id' // Section ID
         );

         /**
          * Checkout Settings
          */
         // Add Section: Checkout Settings
         add_settings_section(
            'checkout_section_id', // ID
            esc_html__('Checkout Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'checkout_settings' // Page
         );

         add_settings_field(
            'login_before_booking', // ID
            esc_html__('Login before booking', 'ovaem-events-manager'),
            array($this, 'login_before_booking'),
            'checkout_settings', // Page
            'checkout_section_id' // Section ID
         );

         add_settings_field(
            'ticket_free_max_number', // ID
            esc_html__('Maximum number of tickets per event in cart', 'ovaem-events-manager'),
            array($this, 'ticket_free_max_number'),
            'checkout_settings', // Page
            'checkout_section_id' // Section ID
         );

         // Add Fields: Basic Section
         add_settings_field(
            'cart_page', // ID
            esc_html__('Cart Page', 'ovaem-events-manager'),
            array($this, 'cart_page'),
            'checkout_settings', // Page
            'checkout_section_id' // Section ID
         );

         add_settings_field(
            'checkout_page', // ID
            esc_html__('Checkout Page', 'ovaem-events-manager'),
            array($this, 'checkout_page'),
            'checkout_settings', // Page
            'checkout_section_id' // Section ID
         );

         add_settings_field(
            'thanks_page', // ID
            esc_html__('Thanks Page after register', 'ovaem-events-manager'),
            array($this, 'thanks_page'),
            'checkout_settings', // Page
            'checkout_section_id' // Section ID
         );

         add_settings_field(
            'checkout_cancel_page', // ID
            esc_html__('Cancel Page while register', 'ovaem-events-manager'),
            array($this, 'checkout_cancel_page'),
            'checkout_settings', // Page
            'checkout_section_id' // Section ID
         );

         add_settings_field(
            'terms_conditions_page', // ID
            esc_html__('Terms and Conditions Page', 'ovaem-events-manager'),
            array($this, 'terms_conditions_page'),
            'checkout_settings', // Page
            'checkout_section_id' // Section ID
         );

         add_settings_field(
            'checkout_payment_default', // ID
            esc_html__('Default Payment Gateway', 'ovaem-events-manager'),
            array($this, 'checkout_payment_default'),
            'checkout_settings', // Page
            'checkout_section_id' // Section ID
         );

         /* Paypal Settings */
         // Add Section: Checkout Settings
         add_settings_section(
            'paypal_section_id', // ID
            esc_html__('Paypal Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'paypal_settings' // Page
         );

         // Add Fields: paypal Section
         add_settings_field(
            'paypal_envi', // ID
            esc_html__('Paypal Environment', 'ovaem-events-manager'),
            array($this, 'paypal_envi'),
            'paypal_settings', // Page
            'paypal_section_id' // Section ID
         );

         add_settings_field(
            'paypal_busi_email', // ID
            esc_html__('Paypal Business Email', 'ovaem-events-manager'),
            array($this, 'paypal_busi_email'),
            'paypal_settings', // Page
            'paypal_section_id' // Section ID
         );

         add_settings_field(
            'paypal_save_log', // ID
            esc_html__('Save Log transactions', 'ovaem-events-manager'),
            array($this, 'paypal_save_log'),
            'paypal_settings', // Page
            'paypal_section_id' // Section ID
         );

         add_settings_field(
            'paypal_info', // ID
            esc_html__('Paypal info when client checkout', 'ovaem-events-manager'),
            array($this, 'paypal_info'),
            'paypal_settings', // Page
            'paypal_section_id' // Section ID
         );

         add_settings_field(
            'paypal_cur', // ID
            esc_html__('Currency', 'ovaem-events-manager'),
            array($this, 'paypal_cur'),
            'paypal_settings', // Page
            'paypal_section_id' // Section ID
         );

         /* Offline Payment Settings */
         add_settings_section(
            'offline_payment_section_id', // ID
            esc_html__('Offline Payment Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'offline_payment_settings' // Page
         );

         // Add Fields: paypal Section
         add_settings_field(
            'offline_payment_use', // ID
            esc_html__('Use Offline Payment', 'ovaem-events-manager'),
            array($this, 'offline_payment_use'),
            'offline_payment_settings', // Page
            'offline_payment_section_id' // Section ID
         );

         add_settings_field(
            'offline_payment_verify_ticket', // ID
            esc_html__('Allow Verify Ticket after checkout so you can send pdf ticket to Attendees', 'ovaem-events-manager'),
            array($this, 'offline_payment_verify_ticket'),
            'offline_payment_settings', // Page
            'offline_payment_section_id' // Section ID
         );

         add_settings_field(
            'offline_payment_info', // ID
            esc_html__('Offline Payment Info when client checkout', 'ovaem-events-manager'),
            array($this, 'offline_payment_info'),
            'offline_payment_settings', // Page
            'offline_payment_section_id' // Section ID
         );

         /* Stripe Payment Settings */
         add_settings_section(
            'stripe_payment_section_id', // ID
            esc_html__('Stripe Payment Setting', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'stripe_payment_settings' // Page
         );

         add_settings_field(
            'stripe_info', // ID
            esc_html__('Stripe info when client checkout', 'ovaem-events-manager'),
            array($this, 'stripe_info'),
            'stripe_payment_settings', // Page
            'stripe_payment_section_id' // Section ID
         );

         // Add Fields: paypal Section
         add_settings_field(
            'stripe_payment_public_key', // ID
            esc_html__('Public Key', 'ovaem-events-manager'),
            array($this, 'stripe_payment_public_key'),
            'stripe_payment_settings', // Page
            'stripe_payment_section_id' // Section ID
         );

         add_settings_field(
            'stripe_payment_serect_key', // ID
            esc_html__('Serect Key', 'ovaem-events-manager'),
            array($this, 'stripe_payment_serect_key'),
            'stripe_payment_settings', // Page
            'stripe_payment_section_id' // Section ID
         );

         add_settings_field(
            'stripe_payment_currency', // ID
            esc_html__('Currency', 'ovaem-events-manager'),
            array($this, 'stripe_payment_currency'),
            'stripe_payment_settings', // Page
            'stripe_payment_section_id' // Section ID
         );

         /* Stripe Payment Settings */
         add_settings_section(
            'woo_payment_section_id', // ID
            esc_html__('Woocommerce Booking', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'woo_payment_section_setting' // Page
         );

         add_settings_field(
            'woo_make_ticket_verify', // ID
            esc_html__('Verify ticket when order status is:', 'ovaem-events-manager'),
            array($this, 'woo_make_ticket_verify'),
            'woo_payment_section_setting', // Page
            'woo_payment_section_id' // Section ID
         );

         /**
          * Event Free Setting
          */
         add_settings_section(
            'event_mail_section_id', // ID
            esc_html__('Attachment File', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'event_mail_settings' // Page
         );

            add_settings_field(
               'event_mail_attachment', // ID
               esc_html__('Attachment QR,PDF in Mail ', 'ovaem-events-manager'),
               array($this, 'event_mail_attachment'),
               'event_mail_settings', // Page
               'event_mail_section_id' // Section ID
            );
            add_settings_field(
               'event_file_cer_attachment', // ID
               esc_html__('Attachment File Certificate in Mail ', 'ovaem-events-manager'),
               array($this, 'event_file_cer_attachment'),
               'event_mail_settings', // Page
               'event_mail_section_id' // Section ID
            );

         add_settings_section(
            'send_from_section_id', // ID
            esc_html__('Send From', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'send_from_setting' // Page
         );
            add_settings_field(
               'send_mail_from', // ID
               esc_html__('Send Email From', 'ovaem-events-manager'),
               array($this, 'send_mail_from'),
               'send_from_setting', // Page
               'send_from_section_id' // Section ID
            );

         // Add Section: Free Settings
         add_settings_section(
            'event_free_section_id', // ID
            esc_html__('Mail Template of Free Ticket', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'event_free_settings' // Page
         );

         add_settings_field(
            'mail_to', // ID
            esc_html__('Mail to after registing free event success: ', 'ovaem-events-manager'),
            array($this, 'mail_to'),
            'event_free_settings', // Page
            'event_free_section_id' // Section ID
         );

         add_settings_field(
            'mail_template', // ID
            esc_html__('Mail template: ', 'ovaem-events-manager'),
            array($this, 'mail_template'),
            'event_free_settings', // Page
            'event_free_section_id' // Section ID
         );

         add_settings_section(
            'paid_event_mail_section_id', // ID
            esc_html__('Mail Template of Paid Ticket', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'paid_event_mail_settings' // Page
         );

         add_settings_field(
            'paid_ticket_mail_to', // ID
            esc_html__('Mail to after booking successfully: ', 'ovaem-events-manager'),
            array($this, 'paid_ticket_mail_to'),
            'paid_event_mail_settings', // Page
            'paid_event_mail_section_id' // Section ID
         );

         add_settings_field(
            'paid_ticket_mail_template', // ID
            esc_html__('Mail template: ', 'ovaem-events-manager'),
            array($this, 'paid_ticket_mail_template'),
            'paid_event_mail_settings', // Page
            'paid_event_mail_section_id' // Section ID
         );

         add_settings_section(
            'pdf_ticket_section_id', // ID
            esc_html__('PDF Ticket Settings', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'pdf_ticket_settings' // Page
         );

         add_settings_field(
            'pdf_ticket_template', // ID
            esc_html__('Ticket Template: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_template'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_logo', // ID
            esc_html__('Logo: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_logo'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_show_logo', // ID
            esc_html__('Show Logo: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_logo'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_show_time', // ID
            esc_html__('Show Time: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_time'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

        

         add_settings_field(
            'pdf_ticket_show_order_id', // ID
            esc_html__('Show Order ID: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_order_id'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_show_holder_ticket', // ID
            esc_html__('Show Holder Ticket: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_holder_ticket'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_show_order_time', // ID
            esc_html__('Show Order Time: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_order_time'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

       

         add_settings_field(
            'pdf_ticket_show_venue', // ID
            esc_html__('Show Venue Line 1: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_venue'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );
         add_settings_field(
            'pdf_ticket_show_adress', // ID
            esc_html__('Show Venue Line 2: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_adress'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_format_qr', // ID
            esc_html__('Scan QR Code Image displays: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_format_qr'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_show_qrcode', // ID
            esc_html__('Show QR Code Image: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_qrcode'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );
         add_settings_field(
            'pdf_ticket_show_code', // ID
            esc_html__('Show Code: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_code'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_show_package', // ID
            esc_html__('Show Package: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_show_package'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_label_color', // ID
            esc_html__('Label Color: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_label_color'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page
         );

         add_settings_field(
            'pdf_ticket_text_color', // ID
            esc_html__('Text Color: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_text_color'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page
         );

         add_settings_field(
            'pdf_ticket_event_fontsize', // ID
            esc_html__('Event Font Size: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_event_fontsize'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page
         );

         add_settings_field(
            'pdf_ticket_label_fontsize', // ID
            esc_html__('Label Font Size: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_label_fontsize'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         add_settings_field(
            'pdf_ticket_text_fontsize', // ID
            esc_html__('Text Font Size: ', 'ovaem-events-manager'),
            array($this, 'pdf_ticket_text_fontsize'),
            'pdf_ticket_settings', // Section ID
            'pdf_ticket_section_id' // Page

         );

         /**
          * User Submit Settings
          */
         // Add Section: User Submit
         add_settings_section(
            'user_submit_id', // ID
            esc_html__('User Submit Settings', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'user_submit_settings' // Page
         );

         add_settings_field(
            'user_submit_admin_review', // ID
            esc_html__('Admin Review before Public Event', 'ovaem-events-manager'),
            array($this, 'user_submit_admin_review'),
            'user_submit_settings', // Page
            'user_submit_id' // Section ID
         );


         /**
          * captcha Settings
          */
         // Add Section: captcha Submit
         add_settings_section(
            'captcha_reg_event_id', // ID
            esc_html__('Captcha Settings', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'captcha_settings' // Page
         );

         add_settings_field(
            'captcha_type', // ID
            esc_html__('Captcha type', 'ovaem-events-manager'),
            array($this, 'captcha_type'),
            'captcha_settings', // Page
            'captcha_reg_event_id' // Section ID
         );

         add_settings_field(
            'captcha_sitekey', // ID
            esc_html__('Captcha site key', 'ovaem-events-manager'),
            array($this, 'captcha_sitekey'),
            'captcha_settings', // Page
            'captcha_reg_event_id' // Section ID
         );

         add_settings_field(
            'captcha_serectkey', // ID
            esc_html__('Captcha secrect key', 'ovaem-events-manager'),
            array($this, 'captcha_serectkey'),
            'captcha_settings', // Page
            'captcha_reg_event_id' // Section ID
         );

         add_settings_section(
            'captcha_stt_id', // ID
            esc_html__('Status Settings', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'captcha_settings' // Page
         );

         add_settings_field(
            'enable_for_login', // ID
            esc_html__('Enable for Login', 'ovaem-events-manager'),
            array($this, 'enable_for_login'),
            'captcha_settings', // Page
            'captcha_stt_id' // Section ID
         );

         add_settings_field(
            'enable_for_register', // ID
            esc_html__('Enable for Register', 'ovaem-events-manager'),
            array($this, 'enable_for_register'),
            'captcha_settings', // Page
            'captcha_stt_id' // Section ID
         );

         add_settings_field(
            'enable_for_lost_password', // ID
            esc_html__('Enable for Lost Password', 'ovaem-events-manager'),
            array($this, 'enable_for_lost_password'),
            'captcha_settings', // Page
            'captcha_stt_id' // Section ID
         );

         add_settings_field(
            'enable_for_comment', // ID
            esc_html__('Enable for Comment', 'ovaem-events-manager'),
            array($this, 'enable_for_comment'),
            'captcha_settings', // Page
            'captcha_stt_id' // Section ID
         );

         add_settings_field(
            'enable_register_event', // ID
            esc_html__('Enable for Register Event', 'ovaem-events-manager'),
            array($this, 'enable_register_event'),
            'captcha_settings', // Page
            'captcha_stt_id' // Section ID
         );

         add_settings_field(
            'enable_woo_checkout', // ID
            esc_html__('Enable for Woocommerce Checkout', 'ovaem-events-manager'),
            array($this, 'enable_woo_checkout'),
            'captcha_settings', // Page
            'captcha_stt_id' // Section ID
         );

         add_settings_field(
            'enable_event_checkout', // ID
            esc_html__('Enable for Event Checkout', 'ovaem-events-manager'),
            array($this, 'enable_event_checkout'),
            'captcha_settings', // Page
            'captcha_stt_id' // Section ID
         );

         /**
          * Custom Field Checkout Settings
          */
         add_settings_section(
            'custom_field_checkout_event_id', // ID
            esc_html__('Custom Field Checkout Settings', 'ovaem-events-manager'), // Title
            array($this, 'print_options_section'),
            'cfc_checkout_settings' // Page
         );

         add_settings_field(
            'enable_event_free', // ID
            esc_html__('Enable for Event Free', 'ovaem-events-manager'),
            array($this, 'enable_event_free'),
            'cfc_checkout_settings', // Page
            'custom_field_checkout_event_id' // Section ID
         );

         add_settings_field(
            'enable_event_cfc_checkout', // ID
            esc_html__('Enable for Event Checkout', 'ovaem-events-manager'),
            array($this, 'enable_event_cfc_checkout'),
            'cfc_checkout_settings', // Page
            'custom_field_checkout_event_id' // Section ID
         );

         add_settings_field(
            'enable_event_cfc_woo_checkout', // ID
            esc_html__('Enable for Woocommerce Checkout', 'ovaem-events-manager'),
            array($this, 'enable_event_cfc_woo_checkout'),
            'cfc_checkout_settings', // Page
            'custom_field_checkout_event_id' // Section ID
         );

      }

      public function print_options_section() {
         return true;
      }

      public function settings_callback($input) {

         $new_input = array();

         if (isset($input['event_post_type_slug'])) {
            $new_input['event_post_type_slug'] = sanitize_text_field($input['event_post_type_slug']) ? sanitize_text_field($input['event_post_type_slug']) : 'event';
         }

         if (isset($input['event_post_type_rewrite_slug'])) {
            $new_input['event_post_type_rewrite_slug'] = sanitize_text_field($input['event_post_type_rewrite_slug']) ? sanitize_text_field($input['event_post_type_rewrite_slug']) : 'event';
         }

         if (isset($input['speaker_post_type_slug'])) {
            $new_input['speaker_post_type_slug'] = sanitize_text_field($input['speaker_post_type_slug']) ? sanitize_text_field($input['speaker_post_type_slug']) : 'speaker';
         }

         if (isset($input['speaker_post_type_rewrite_slug'])) {
            $new_input['speaker_post_type_rewrite_slug'] = sanitize_text_field($input['speaker_post_type_rewrite_slug']) ? sanitize_text_field($input['speaker_post_type_rewrite_slug']) : 'speaker';
         }

         if (isset($input['venue_post_type_slug'])) {
            $new_input['venue_post_type_slug'] = sanitize_text_field($input['venue_post_type_slug']) ? sanitize_text_field($input['venue_post_type_slug']) : 'venue';
         }

         if (isset($input['venue_post_type_rewrite_slug'])) {
            $new_input['venue_post_type_rewrite_slug'] = sanitize_text_field($input['venue_post_type_rewrite_slug']) ? sanitize_text_field($input['venue_post_type_rewrite_slug']) : 'venue';
         }

         if (isset($input['location_post_type_slug'])) {
            $new_input['location_post_type_slug'] = sanitize_text_field($input['location_post_type_slug']) ? sanitize_text_field($input['location_post_type_slug']) : 'location';
         }

         if (isset($input['slug_taxonomy_name'])) {
            $new_input['slug_taxonomy_name'] = sanitize_text_field($input['slug_taxonomy_name']) ? sanitize_text_field($input['slug_taxonomy_name']) : 'categories';
         }

         if (isset($input['google_key_map'])) {
            $new_input['google_key_map'] = sanitize_text_field($input['google_key_map']) ? sanitize_text_field($input['google_key_map']) : '';
         }

         if (isset($input['search_name'])) {
            $new_input['search_name'] = sanitize_text_field($input['search_name']) ? sanitize_text_field($input['search_name']) : 'true';
         }

         if (isset($input['search_cat'])) {
            $new_input['search_cat'] = sanitize_text_field($input['search_cat']) ? sanitize_text_field($input['search_cat']) : 'true';
         }

         if (isset($input['search_venue'])) {
            $new_input['search_venue'] = sanitize_text_field($input['search_venue']) ? sanitize_text_field($input['search_venue']) : 'true';
         }

         if (isset($input['search_time'])) {
            $new_input['search_time'] = sanitize_text_field($input['search_time']) ? sanitize_text_field($input['search_time']) : 'true';
         }

         if (isset($input['search_time_today'])) {
            $new_input['search_time_today'] = sanitize_text_field($input['search_time_today']) ? sanitize_text_field($input['search_time_today']) : 'true';
         }

         if (isset($input['search_time_tomorrow'])) {
            $new_input['search_time_tomorrow'] = sanitize_text_field($input['search_time_tomorrow']) ? sanitize_text_field($input['search_time_tomorrow']) : 'true';
         }

         if (isset($input['search_time_this_week'])) {
            $new_input['search_time_this_week'] = sanitize_text_field($input['search_time_this_week']) ? sanitize_text_field($input['search_time_this_week']) : 'true';
         }

         if (isset($input['search_time_this_week_end'])) {
            $new_input['search_time_this_week_end'] = sanitize_text_field($input['search_time_this_week_end']) ? sanitize_text_field($input['search_time_this_week_end']) : 'true';
         }

         if (isset($input['search_time_this_week_end_day'])) {
            $new_input['search_time_this_week_end_day'][] = $input['search_time_this_week_end_day'] ? $input['search_time_this_week_end_day'] : array(0 => array('saturday', 'sunday'));
         }

         if (isset($input['search_time_next_week'])) {
            $new_input['search_time_next_week'] = sanitize_text_field($input['search_time_next_week']) ? sanitize_text_field($input['search_time_next_week']) : 'true';
         }

         if (isset($input['search_time_next_month'])) {
            $new_input['search_time_next_month'] = sanitize_text_field($input['search_time_next_month']) ? sanitize_text_field($input['search_time_next_month']) : 'true';
         }

         if (isset($input['search_time_past'])) {
            $new_input['search_time_past'] = sanitize_text_field($input['search_time_past']) ? sanitize_text_field($input['search_time_past']) : 'true';
         }

         if (isset($input['search_time_future'])) {
            $new_input['search_time_future'] = sanitize_text_field($input['search_time_future']) ? sanitize_text_field($input['search_time_future']) : 'true';
         }

         if (isset($input['search_date'])) {
            $new_input['search_date'] = sanitize_text_field($input['search_date']) ? sanitize_text_field($input['search_date']) : 'true';
         }

         if (isset($input['event_show_tag'])) {
            $new_input['event_show_tag'] = sanitize_text_field($input['event_show_tag']) ? sanitize_text_field($input['event_show_tag']) : 'true';
         }

         if (isset($input['event_show_share_social'])) {
            $new_input['event_show_share_social'] = sanitize_text_field($input['event_show_share_social']) ? sanitize_text_field($input['event_show_share_social']) : 'true';
         }

         if (isset($input['event_show_schedule_tab'])) {
            $new_input['event_show_schedule_tab'] = sanitize_text_field($input['event_show_schedule_tab']) ? sanitize_text_field($input['event_show_schedule_tab']) : 'true';
         }

         if (isset($input['event_show_speaker_tab'])) {
            $new_input['event_show_speaker_tab'] = sanitize_text_field($input['event_show_speaker_tab']) ? sanitize_text_field($input['event_show_speaker_tab']) : 'true';
         }

         if (isset($input['event_show_book_now'])) {
            $new_input['event_show_book_now'] = sanitize_text_field($input['event_show_book_now']) ? sanitize_text_field($input['event_show_book_now']) : 'true';
         }

         if (isset($input['event_show_book_now_event_past'])) {
            $new_input['event_show_book_now_event_past'] = sanitize_text_field($input['event_show_book_now_event_past']) ? sanitize_text_field($input['event_show_book_now_event_past']) : 'true';
         }

         if (isset($input['event_scroll_tab'])) {
            $new_input['event_scroll_tab'] = sanitize_text_field($input['event_scroll_tab']) ? sanitize_text_field($input['event_scroll_tab']) : 'ticket';
         }

         if (isset($input['event_show_ticket_tab'])) {
            $new_input['event_show_ticket_tab'] = sanitize_text_field($input['event_show_ticket_tab']) ? sanitize_text_field($input['event_show_ticket_tab']) : 'true';
         }

         if (isset($input['event_show_ticket_tab_expired'])) {
            $new_input['event_show_ticket_tab_expired'] = sanitize_text_field($input['event_show_ticket_tab_expired']) ? sanitize_text_field($input['event_show_ticket_tab_expired']) : 'false';
         }

         if (isset($input['event_show_related'])) {
            $new_input['event_show_related'] = sanitize_text_field($input['event_show_related']) ? sanitize_text_field($input['event_show_related']) : 'true';
         }

         if (isset($input['event_show_comments'])) {
            $new_input['event_show_comments'] = sanitize_text_field($input['event_show_comments']) ? sanitize_text_field($input['event_show_comments']) : 'true';
         }

         if (isset($input['event_show_contact'])) {
            $new_input['event_show_contact'] = sanitize_text_field($input['event_show_contact']) ? sanitize_text_field($input['event_show_contact']) : 'true';
         }

         if (isset($input['event_show_notify'])) {
            $new_input['event_show_notify'] = sanitize_text_field($input['event_show_notify']) ? sanitize_text_field($input['event_show_notify']) : 'true';
         }

         if (isset($input['event_show_venue'])) {
            $new_input['event_show_venue'] = sanitize_text_field($input['event_show_venue']) ? sanitize_text_field($input['event_show_venue']) : 'true';
         }

         if (isset($input['event_show_startdate'])) {
            $new_input['event_show_startdate'] = sanitize_text_field($input['event_show_startdate']) ? sanitize_text_field($input['event_show_startdate']) : 'true';
         }

         if (isset($input['event_show_enddate'])) {
            $new_input['event_show_enddate'] = sanitize_text_field($input['event_show_enddate']) ? sanitize_text_field($input['event_show_enddate']) : 'true';
         }

         if (isset($input['event_show_room'])) {
            $new_input['event_show_room'] = sanitize_text_field($input['event_show_room']) ? sanitize_text_field($input['event_show_room']) : 'true';
         }

         if (isset($input['event_show_gallery'])) {
            $new_input['event_show_gallery'] = sanitize_text_field($input['event_show_gallery']) ? sanitize_text_field($input['event_show_gallery']) : 'true';
         }

         if (isset($input['event_detail_template'])) {
            $new_input['event_detail_template'] = sanitize_text_field($input['event_detail_template']) ? sanitize_text_field($input['event_detail_template']) : 'classic';
         }

         if (isset($input['event_show_address'])) {
            $new_input['event_show_address'] = sanitize_text_field($input['event_show_address']) ? sanitize_text_field($input['event_show_address']) : 'true';
         }

         if (isset($input['event_show_organizer'])) {
            $new_input['event_show_organizer'] = sanitize_text_field($input['event_show_organizer']) ? sanitize_text_field($input['event_show_organizer']) : 'true';
         }

         if (isset($input['event_show_sponsors'])) {
            $new_input['event_show_sponsors'] = sanitize_text_field($input['event_show_sponsors']) ? sanitize_text_field($input['event_show_sponsors']) : 'true';
         }

         if (isset($input['event_show_content'])) {
            $new_input['event_show_content'] = sanitize_text_field($input['event_show_content']) ? sanitize_text_field($input['event_show_content']) : 'true';
         }

         if (isset($input['event_show_extra_info'])) {
            $new_input['event_show_extra_info'] = sanitize_text_field($input['event_show_extra_info']) ? sanitize_text_field($input['event_show_extra_info']) : 'true';
         }

          if (isset($input['event_show_faq'])) {
            $new_input['event_show_faq'] = sanitize_text_field($input['event_show_faq']) ? sanitize_text_field($input['event_show_faq']) : 'true';
         }

         if (isset($input['event_show_map'])) {
            $new_input['event_show_map'] = sanitize_text_field($input['event_show_map']) ? sanitize_text_field($input['event_show_map']) : 'address';
         }

         if (isset($input['event_show_map_btn'])) {
            $new_input['event_show_map_btn'] = sanitize_text_field($input['event_show_map_btn']) ? sanitize_text_field($input['event_show_map_btn']) : 'yes';
         }

         if (isset($input['event_show_ical'])) {
            $new_input['event_show_ical'] = sanitize_text_field($input['event_show_ical']) ? sanitize_text_field($input['event_show_ical']) : 'true';
         }

         if (isset($input['event_map_zoom'])) {
            $new_input['event_map_zoom'] = sanitize_text_field($input['event_map_zoom']) ? sanitize_text_field($input['event_map_zoom']) : '20';
         }

         if (isset($input['upcomming_days'])) {
            $new_input['upcomming_days'] = sanitize_text_field($input['upcomming_days']) ? sanitize_text_field($input['upcomming_days']) : 1000;
         }

         if (isset($input['number_event_related'])) {
            $new_input['number_event_related'] = sanitize_text_field($input['number_event_related']) ? sanitize_text_field($input['number_event_related']) : 4;
         }

         if (isset($input['currency_position'])) {
            $new_input['currency_position'] = $input['currency_position'] ? $input['currency_position'] : 'left';
         }
         if (isset($input['google_type_event'])) {
            $new_input['google_type_event'] = $input['google_type_event'] ? $input['google_type_event'] : 'yes';
         }

         if (isset($input['event_secret_key'])) {
            $new_input['event_secret_key'] = sanitize_text_field($input['event_secret_key']) ? sanitize_text_field($input['event_secret_key']) : 'ovatheme.com';
         }

         if (isset($input['event_calendar_input_step'])) {
            $new_input['event_calendar_input_step'] = sanitize_text_field($input['event_calendar_input_step']) ? sanitize_text_field($input['event_calendar_input_step']) : 30;
         }

         if (isset($input['archives_event_style'])) {
            $new_input['archives_event_style'] = $input['archives_event_style'] ? $input['archives_event_style'] : 'grid';
         }
         if (isset($input['archives_event_style_grid'])) {
            $new_input['archives_event_style_grid'] = $input['archives_event_style_grid'] ? $input['archives_event_style_grid'] : 'style1';
         }

         if (isset($input['event_calendar_lang'])) {
            $new_input['event_calendar_lang'] = $input['event_calendar_lang'] ? $input['event_calendar_lang'] : 'en-GB';
         }

         if (isset($input['first_day_of_week'])) {
            $new_input['first_day_of_week'] = $input['first_day_of_week'] ? $input['first_day_of_week'] : '0';
         }

         if (isset($input['archives_event_show_past'])) {
            $new_input['archives_event_show_past'] = $input['archives_event_show_past'] ? $input['archives_event_show_past'] : 'true';
         }

         if (isset($input['archives_event_show_desc_cat'])) {
            $new_input['archives_event_show_desc_cat'] = $input['archives_event_show_desc_cat'] ? $input['archives_event_show_desc_cat'] : 'true';
         }

         
         if (isset($input['archives_event_show_status'])) {
            $new_input['archives_event_show_status'] = $input['archives_event_show_status'] ? $input['archives_event_show_status'] : 'false';
         }

         if (isset($input['archives_event_show_get_ticket'])) {
            $new_input['archives_event_show_get_ticket'] = $input['archives_event_show_get_ticket'] ? $input['archives_event_show_get_ticket'] : 'false';
         }
         

         if (isset($input['archives_event_orderby'])) {
            $new_input['archives_event_orderby'] = $input['archives_event_orderby'] ? $input['archives_event_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
         }
         if (isset($input['archives_event_order'])) {
            $new_input['archives_event_order'] = $input['archives_event_order'] ? $input['archives_event_order'] : 'ASC';
         }

         if (isset($input['ovaem_day_format'])) {
            $new_input['ovaem_day_format'] = $input['ovaem_day_format'] ? $input['ovaem_day_format'] : 'j';
         }
         if (isset($input['ovaem_month_format'])) {
            $new_input['ovaem_month_format'] = $input['ovaem_month_format'] ? $input['ovaem_month_format'] : 'M';
         }

         if (isset($input['ovaem_year_format'])) {
            $new_input['ovaem_year_format'] = $input['ovaem_year_format'] ? $input['ovaem_year_format'] : 'Y';
         }

         if (isset($input['ovaem_list_post_per_page'])) {
            $new_input['ovaem_list_post_per_page'] = $input['ovaem_list_post_per_page'] ? $input['ovaem_list_post_per_page'] : 9;
         }

         if (isset($input['ovaem_number_character_title_event'])) {
            $new_input['ovaem_number_character_title_event'] = $input['ovaem_number_character_title_event'] ? $input['ovaem_number_character_title_event'] : 30;
         }

         if (isset($input['ovaem_number_character_excerpt'])) {
            $new_input['ovaem_number_character_excerpt'] = $input['ovaem_number_character_excerpt'] ? $input['ovaem_number_character_excerpt'] : 60;
         }

         if (isset($input['ovaem_number_character_venue'])) {
            $new_input['ovaem_number_character_venue'] = $input['ovaem_number_character_venue'] ? $input['ovaem_number_character_venue'] : 20;
         }

         if (isset($input['search_event_show_past'])) {
            $new_input['search_event_show_past'] = $input['search_event_show_past'] ? $input['search_event_show_past'] : 'true';
         }

         if (isset($input['search_event_show_states'])) {
            $new_input['search_event_show_states'] = $input['search_event_show_states'] ? $input['search_event_show_states'] : 'true';
         }
         if (isset($input['search_event_show_cities'])) {
            $new_input['search_event_show_cities'] = $input['search_event_show_cities'] ? $input['search_event_show_cities'] : 'true';
         }

         if (isset($input['search_event_orderby'])) {
            $new_input['search_event_orderby'] = $input['search_event_orderby'] ? $input['search_event_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
         }
         if (isset($input['search_event_order'])) {
            $new_input['search_event_order'] = $input['search_event_order'] ? $input['search_event_order'] : 'ASC';
         }

         if (isset($input['list_speakers_orderby'])) {
            $new_input['list_speakers_orderby'] = $input['list_speakers_orderby'] ? $input['list_speakers_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
         }
         if (isset($input['list_speakers_order'])) {
            $new_input['list_speakers_order'] = $input['list_speakers_order'] ? $input['list_speakers_order'] : 'ASC';
         }

         if (isset($input['speaker_joined_event_show'])) {
            $new_input['speaker_joined_event_show'] = $input['speaker_joined_event_show'] ? $input['speaker_joined_event_show'] : 'true';
         }
         if (isset($input['speaker_joined_event_show_past'])) {
            $new_input['speaker_joined_event_show_past'] = $input['speaker_joined_event_show_past'] ? $input['speaker_joined_event_show_past'] : 'true';
         }
         if (isset($input['speaker_joined_event_show_current'])) {
            $new_input['speaker_joined_event_show_current'] = $input['speaker_joined_event_show_current'] ? $input['speaker_joined_event_show_current'] : 'true';
         }

         if (isset($input['speaker_joined_event_count'])) {
            $new_input['speaker_joined_event_count'] = sanitize_text_field($input['speaker_joined_event_count']) ? sanitize_text_field($input['speaker_joined_event_count']) : 100;
         }

         if (isset($input['speaker_joined_event_orderby'])) {
            $new_input['speaker_joined_event_orderby'] = $input['speaker_joined_event_orderby'] ? $input['speaker_joined_event_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
         }
         if (isset($input['speaker_joined_event_order'])) {
            $new_input['speaker_joined_event_order'] = $input['speaker_joined_event_order'] ? $input['speaker_joined_event_order'] : 'ASC';
         }

         if (isset($input['detail_venue_event_show'])) {
            $new_input['detail_venue_event_show'] = $input['detail_venue_event_show'] ? $input['detail_venue_event_show'] : 'true';
         }
         if (isset($input['detail_venue_event_count'])) {
            $new_input['detail_venue_event_count'] = sanitize_text_field($input['detail_venue_event_count']) ? sanitize_text_field($input['detail_venue_event_count']) : 100;
         }

         if (isset($input['detail_venue_event_show_past'])) {
            $new_input['detail_venue_event_show_past'] = $input['detail_venue_event_show_past'] ? $input['detail_venue_event_show_past'] : 'true';
         }
         if (isset($input['detail_venue_event_map_zoom'])) {
            $new_input['detail_venue_event_map_zoom'] = $input['detail_venue_event_map_zoom'] ? $input['detail_venue_event_map_zoom'] : '20';
         }

         if (isset($input['woo_make_ticket_verify'])) {
            $new_input['woo_make_ticket_verify'][] = $input['woo_make_ticket_verify'] ? $input['woo_make_ticket_verify'] : array(0 => array('wc-completed', 'wc-on-hold'));
         }

         if (isset($input['detail_venue_event_orderby'])) {
            $new_input['detail_venue_event_orderby'] = $input['detail_venue_event_orderby'] ? $input['detail_venue_event_orderby'] : OVAEM_Settings::$prefix . '_date_start_time';
         }
         if (isset($input['detail_venue_event_order'])) {
            $new_input['detail_venue_event_order'] = $input['detail_venue_event_order'] ? $input['detail_venue_event_order'] : 'ASC';
         }

         if (isset($input['ticket_free_max_number'])) {
            $new_input['ticket_free_max_number'] = sanitize_text_field($input['ticket_free_max_number']) ? sanitize_text_field($input['ticket_free_max_number']) : '10';
         }

          if (isset($input['login_before_booking'])) {
            $new_input['login_before_booking'] = sanitize_text_field($input['login_before_booking']) ? sanitize_text_field($input['login_before_booking']) : 'no';
         }

         if (isset($input['thanks_page'])) {
            $new_input['thanks_page'] = sanitize_text_field($input['thanks_page']) ? sanitize_text_field($input['thanks_page']) : '';
         }

         if (isset($input['mail_to'])) {
            $new_input['mail_to'][] = $input['mail_to'] ? $input['mail_to'] : array(0 => array('admin', 'client'));
         }
         if (isset($input['paid_ticket_mail_to'])) {
            $new_input['paid_ticket_mail_to'][] = $input['paid_ticket_mail_to'] ? $input['paid_ticket_mail_to'] : array(0 => array('admin', 'client'));
         }

         if (isset($input['mail_template'])) {
            $new_input['mail_template'] = $input['mail_template'] ? $input['mail_template'] : 'Event Name: [event] <br/>
				Order ID: [orderid] <br/>
				Name: [name] <br/>
				Phone: [phone] <br/>
				Email: [email] <br/>
				Address: [address] <br/>
				Address: [company] <br/>
				Number: [number] <br/>
				Addition: [addition] <br/>';
         }

         if (isset($input['paid_ticket_mail_template'])) {
            $new_input['paid_ticket_mail_template'] = $input['paid_ticket_mail_template'] ? $input['paid_ticket_mail_template'] : '<br/>
				Order ID: [orderid] <br/>
				Name: [name] <br/>
				Phone: [phone] <br/>
				Email: [email] <br/>
				Address: [address] <br/>
				Address: [company] <br/>
				Addition: [addition] <br/>
				Transaction: [transaction_id] <br/>
				Cart: [cart] <br/>';
         }

         if (isset($input['user_manage_event_page'])) {
            $new_input['user_manage_event_page'] = $input['user_manage_event_page'] ? $input['user_manage_event_page'] : '';
         }
         if (isset($input['frontend_submit_limit_gallery'])) {
            $new_input['frontend_submit_limit_gallery'] = $input['frontend_submit_limit_gallery'] ? $input['frontend_submit_limit_gallery'] : '';
         }
         if (isset($input['frontend_submit_limit_tags'])) {
            $new_input['frontend_submit_limit_tags'] = $input['frontend_submit_limit_tags'] ? $input['frontend_submit_limit_tags'] : '10';
         }

         if (isset($input['frontend_submit_show_editor'])) {
            $new_input['frontend_submit_show_editor'] = $input['frontend_submit_show_editor'] ? $input['frontend_submit_show_editor'] : 'yes';
         }

         if (isset($input['list_speakers_style'])) {
            $new_input['list_speakers_style'] = $input['list_speakers_style'] ? $input['list_speakers_style'] : 'style1';
         }
         if (isset($input['list_speakers_link_title'])) {
            $new_input['list_speakers_link_title'] = $input['list_speakers_link_title'] ? $input['list_speakers_link_title'] : 'true';
         }
         if (isset($input['list_speakers_show_job'])) {
            $new_input['list_speakers_show_job'] = $input['list_speakers_show_job'] ? $input['list_speakers_show_job'] : 'true';
         }
         if (isset($input['list_speakers_show_social'])) {
            $new_input['list_speakers_show_social'] = $input['list_speakers_show_social'] ? $input['list_speakers_show_social'] : 'true';
         }
         if (isset($input['list_speakers_post_per_page'])) {
            $new_input['list_speakers_post_per_page'] = $input['list_speakers_post_per_page'] ? $input['list_speakers_post_per_page'] : 12;
         }

         if (isset($input['archive_venue_posts_per_page'])) {
            $new_input['archive_venue_posts_per_page'] = $input['archive_venue_posts_per_page'] ? $input['archive_venue_posts_per_page'] : 12;
         }

         

         if (isset($input['archive_venue_style'])) {
            $new_input['archive_venue_style'] = $input['archive_venue_style'] ? $input['archive_venue_style'] : 'style1';
         }
         if (isset($input['archive_venue_orderby'])) {
            $new_input['archive_venue_orderby'] = $input['archive_venue_orderby'] ? $input['archive_venue_orderby'] : OVAEM_Settings::$prefix . '_venue_order';
         }
         if (isset($input['archive_venue_order'])) {
            $new_input['archive_venue_order'] = $input['archive_venue_order'] ? $input['archive_venue_order'] : 'ASC';
         }

         // if( isset( $input['events_per_page'] ) )
         //     $new_input['events_per_page'] = sanitize_text_field( $input['events_per_page'] ) ? sanitize_text_field( $input['events_per_page'] ) : 12;

         if (isset($input['cart_page'])) {
            $new_input['cart_page'] = sanitize_text_field($input['cart_page']) ? sanitize_text_field($input['cart_page']) : '';
         }

         if (isset($input['checkout_page'])) {
            $new_input['checkout_page'] = sanitize_text_field($input['checkout_page']) ? sanitize_text_field($input['checkout_page']) : '';
         }

         if (isset($input['checkout_cancel_page'])) {
            $new_input['checkout_cancel_page'] = sanitize_text_field($input['checkout_cancel_page']) ? sanitize_text_field($input['checkout_cancel_page']) : '';
         }

         if (isset($input['terms_conditions_page'])) {
            $new_input['terms_conditions_page'] = sanitize_text_field($input['terms_conditions_page']) ? sanitize_text_field($input['terms_conditions_page']) : '';
         }

         if (isset($input['checkout_payment_default'])) {
            $new_input['checkout_payment_default'] = sanitize_text_field($input['checkout_payment_default']) ? sanitize_text_field($input['checkout_payment_default']) : 'offline';
         }

         if (isset($input['paypal_envi'])) {
            $new_input['paypal_envi'] = sanitize_text_field($input['paypal_envi']) ? sanitize_text_field($input['paypal_envi']) : 'live';
         }

         if (isset($input['paypal_save_log'])) {
            $new_input['paypal_save_log'] = sanitize_text_field($input['paypal_save_log']) ? sanitize_text_field($input['paypal_save_log']) : 'false';
         }

         if (isset($input['paypal_busi_email'])) {
            $new_input['paypal_busi_email'] = sanitize_text_field($input['paypal_busi_email']) ? sanitize_text_field($input['paypal_busi_email']) : '';
         }

         if (isset($input['paypal_info'])) {
            $new_input['paypal_info'] = sanitize_text_field($input['paypal_info']) ? sanitize_text_field($input['paypal_info']) : esc_html__('Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.', 'ovaem-events-manager');
         }

         if (isset($input['paypal_cur'])) {
            $new_input['paypal_cur'] = sanitize_text_field($input['paypal_cur']) ? sanitize_text_field($input['paypal_cur']) : 'USD';
         }

         if (isset($input['offline_payment_verify_ticket'])) {
            $new_input['offline_payment_verify_ticket'] = sanitize_text_field($input['offline_payment_verify_ticket']) ? sanitize_text_field($input['offline_payment_verify_ticket']) : 'true';
         }

         if (isset($input['offline_payment_use'])) {
            $new_input['offline_payment_use'] = sanitize_text_field($input['offline_payment_use']) ? sanitize_text_field($input['offline_payment_use']) : 'true';
         }

         if (isset($input['offline_payment_info'])) {
            $new_input['offline_payment_info'] = sanitize_text_field($input['offline_payment_info']) ? sanitize_text_field($input['offline_payment_info']) : esc_html__('In Admin: You can config allow to send ticket after checkout successfully.', 'ovaem-events-manager');
         }

         if (isset($input['stripe_payment_public_key'])) {
            $new_input['stripe_payment_public_key'] = sanitize_text_field($input['stripe_payment_public_key']) ? sanitize_text_field($input['stripe_payment_public_key']) : '';
         }

         if (isset($input['stripe_payment_serect_key'])) {
            $new_input['stripe_payment_serect_key'] = sanitize_text_field($input['stripe_payment_serect_key']) ? sanitize_text_field($input['stripe_payment_serect_key']) : '';
         }

         if (isset($input['stripe_info'])) {
            $new_input['stripe_info'] = sanitize_text_field($input['stripe_info']) ? sanitize_text_field($input['stripe_info']) : esc_html__('You can pay with your credit card.', 'ovaem-events-manager');
         }

         if (isset($input['stripe_payment_currency'])) {
            $new_input['stripe_payment_currency'] = sanitize_text_field($input['stripe_payment_currency']) ? sanitize_text_field($input['stripe_payment_currency']) : 'USD';
         }

         if (isset($input['pdf_ticket_template'])) {
            $new_input['pdf_ticket_template'] = $input['pdf_ticket_template'] ? $input['pdf_ticket_template'] : 'version2';
         }

         if (isset($input['pdf_ticket_show_time'])) {
            $new_input['pdf_ticket_show_time'] = $input['pdf_ticket_show_time'] ? $input['pdf_ticket_show_time'] : 'true';
         }
         if (isset($input['event_mail_attachment'])) {
            $new_input['event_mail_attachment'] = $input['event_mail_attachment'] ? $input['event_mail_attachment'] : 'both';
         }

         if (isset($input['event_file_cer_attachment'])) {
            $new_input['event_file_cer_attachment'] = $input['event_file_cer_attachment'] ? $input['event_file_cer_attachment'] : 'yes';
         }

        
         

         if (isset($input['pdf_ticket_show_order_id'])) {
            $new_input['pdf_ticket_show_order_id'] = $input['pdf_ticket_show_order_id'] ? $input['pdf_ticket_show_order_id'] : 'true';
         }

         if (isset($input['pdf_ticket_show_order_time'])) {
            $new_input['pdf_ticket_show_order_time'] = $input['pdf_ticket_show_order_time'] ? $input['pdf_ticket_show_order_time'] : 'true';
         }

         if (isset($input['pdf_ticket_show_logo'])) {
            $new_input['pdf_ticket_show_logo'] = $input['pdf_ticket_show_logo'] ? $input['pdf_ticket_show_logo'] : 'true';
         }

         if (isset($input['pdf_ticket_logo'])) {
            $new_input['pdf_ticket_logo'] = $input['pdf_ticket_logo'] ? $input['pdf_ticket_logo'] : '';
         }

         if (isset($input['pdf_ticket_show_venue'])) {
            $new_input['pdf_ticket_show_venue'] = $input['pdf_ticket_show_venue'] ? $input['pdf_ticket_show_venue'] : 'true';
         }
         if (isset($input['pdf_ticket_show_adress'])) {
            $new_input['pdf_ticket_show_adress'] = $input['pdf_ticket_show_adress'] ? $input['pdf_ticket_show_adress'] : 'true';
         }
         if (isset($input['pdf_ticket_show_code'])) {
            $new_input['pdf_ticket_show_code'] = $input['pdf_ticket_show_code'] ? $input['pdf_ticket_show_code'] : 'true';
         }
         if (isset($input['pdf_ticket_show_holder_ticket'])) {
            $new_input['pdf_ticket_show_holder_ticket'] = $input['pdf_ticket_show_holder_ticket'] ? $input['pdf_ticket_show_holder_ticket'] : 'true';
         }
         if (isset($input['pdf_ticket_show_package'])) {
            $new_input['pdf_ticket_show_package'] = $input['pdf_ticket_show_package'] ? $input['pdf_ticket_show_package'] : 'true';
         }
         if (isset($input['pdf_ticket_show_qrcode'])) {
            $new_input['pdf_ticket_show_qrcode'] = $input['pdf_ticket_show_qrcode'] ? $input['pdf_ticket_show_qrcode'] : 'true';
         }
         if (isset($input['pdf_ticket_format_qr'])) {
            $new_input['pdf_ticket_format_qr'] = $input['pdf_ticket_format_qr'] ? $input['pdf_ticket_format_qr'] : 'url';
         }

         if (isset($input['pdf_ticket_event_fontsize'])) {
            $new_input['pdf_ticket_event_fontsize'] = $input['pdf_ticket_event_fontsize'] ? $input['pdf_ticket_event_fontsize'] : '18';
         }

         if (isset($input['send_mail_from'])) {
            $new_input['send_mail_from'] = $input['send_mail_from'] ? $input['send_mail_from'] : get_option( 'admin_email' );
         }

         if (isset($input['pdf_ticket_label_color'])) {
            $new_input['pdf_ticket_label_color'] = $input['pdf_ticket_label_color'] ? $input['pdf_ticket_label_color'] : '#333333';
         }
         if (isset($input['pdf_ticket_text_color'])) {
            $new_input['pdf_ticket_text_color'] = $input['pdf_ticket_text_color'] ? $input['pdf_ticket_text_color'] : '#555555';
         }

         if (isset($input['pdf_ticket_label_fontsize'])) {
            $new_input['pdf_ticket_label_fontsize'] = $input['pdf_ticket_label_fontsize'] ? $input['pdf_ticket_label_fontsize'] : '12';
         }
         if (isset($input['pdf_ticket_text_fontsize'])) {
            $new_input['pdf_ticket_text_fontsize'] = $input['pdf_ticket_text_fontsize'] ? $input['pdf_ticket_text_fontsize'] : '12';
         }

         if (isset($input['user_submit_admin_review'])) {
            $new_input['user_submit_admin_review'] = $input['user_submit_admin_review'] ? $input['user_submit_admin_review'] : 'true';
         }

         if (isset($input['captcha_type'])) {
            $new_input['captcha_type'] = $input['captcha_type'] ? $input['captcha_type'] : '';
         }

         if (isset($input['captcha_sitekey'])) {
            $new_input['captcha_sitekey'] = $input['captcha_sitekey'] ? $input['captcha_sitekey'] : '';
         }

         if (isset($input['captcha_serectkey'])) {
            $new_input['captcha_serectkey'] = $input['captcha_serectkey'] ? $input['captcha_serectkey'] : '';
         }

         if (isset($input['enable_for_login'])) {
            $new_input['enable_for_login'] = $input['enable_for_login'] ? $input['enable_for_login'] : '';
         }

         if (isset($input['enable_for_register'])) {
            $new_input['enable_for_register'] = $input['enable_for_register'] ? $input['enable_for_register'] : '';
         }

         if (isset($input['enable_for_lost_password'])) {
            $new_input['enable_for_lost_password'] = $input['enable_for_lost_password'] ? $input['enable_for_lost_password'] : '';
         }

         if (isset($input['enable_for_comment'])) {
            $new_input['enable_for_comment'] = $input['enable_for_comment'] ? $input['enable_for_comment'] : '';
         }

         if (isset($input['enable_register_event'])) {
            $new_input['enable_register_event'] = $input['enable_register_event'] ? $input['enable_register_event'] : '';
         }

         if (isset($input['enable_woo_checkout'])) {
            $new_input['enable_woo_checkout'] = $input['enable_woo_checkout'] ? $input['enable_woo_checkout'] : '';
         }
         
         if (isset($input['enable_event_checkout'])) {
            $new_input['enable_event_checkout'] = $input['enable_event_checkout'] ? $input['enable_event_checkout'] : '';
         }
         
         if (isset($input['enable_event_free'])) {
            $new_input['enable_event_free'] = $input['enable_event_free'] ? $input['enable_event_free'] : '';
         }
         
         if (isset($input['enable_event_cfc_checkout'])) {
            $new_input['enable_event_cfc_checkout'] = $input['enable_event_cfc_checkout'] ? $input['enable_event_cfc_checkout'] : '';
         }
         
         if (isset($input['enable_event_cfc_woo_checkout'])) {
            $new_input['enable_event_cfc_woo_checkout'] = $input['enable_event_cfc_woo_checkout'] ? $input['enable_event_cfc_woo_checkout'] : '';
         }
         
         
         return $new_input;
      }

      public static function create_admin_setting_page() {?>

			<div class="wrap">

				<h1><?php esc_html_e("Event Settings", "ovaem-events-manager");?></h1><br/>

				<form method="post" action="options.php" id="ovaem-event-setting">

					<div class="container-fluid">
						<div class="row">

							<div id="tabs">

								<ul>

									<li><a href="#general_settings"><?php esc_html_e('General Settings', 'ovaem-events-manager');?> </a></li>

									<li><a href="#basic_settings" class="basic_settings"><?php esc_html_e('Basic Settings', 'ovaem-events-manager');?></a></li>

									<li><a href="#list_speakers_settings" class="list_speakers_settings"><?php esc_html_e('Speakers Settings', 'ovaem-events-manager');?></a></li>

									<li><a href="#venue_settings" class="venue_settings"><?php esc_html_e('Venue Settings', 'ovaem-events-manager');?></a></li>



									<li><a href="#checkout_settings" class="checkout_settings"><?php esc_html_e('Checkout Settings', 'ovaem-events-manager');?></a></li>

									<li><a href="#event_free_settings" class="event_free_settings"><?php esc_html_e('Mail Template Settings', 'ovaem-events-manager');?></a></li>

									<li><a href="#user_submit_settings" class="user_submit_settings"><?php esc_html_e('User Submit Settings', 'ovaem-events-manager');?></a></li>

                           <li><a href="#captcha_settings" class="captcha_settings"><?php esc_html_e('Captcha Settings', 'ovaem-events-manager');?></a></li>

                           <li><a href="#cfc_checkout_settings" class="cfc_checkout_settings"><?php esc_html_e('Custom Field Checkout Settings', 'ovaem-events-manager');?></a></li>

								</ul>

								<!-- Basic Tab Content -->
								<div id="general_settings" class="ovaem_settings">

									<?php settings_fields('ovaem_options_group'); // Options group ?>

									<div class="event_post_type">
										<?php do_settings_sections('taxonomy_settings'); // Page   ?>
										<hr>
										<?php do_settings_sections('general_settings'); // Page   ?>
										<hr>
										<?php do_settings_sections('speaker_settings'); // Page   ?>
										<hr>
										<?php do_settings_sections('slug_location_settings'); // Page   ?>

										<?php do_settings_sections('slug_venue_settings'); // Page   ?>


										<strong>
											<?php echo "<br/><br/>";
         esc_html_e('Please note: save Permalink again after change slug: ', 'ovaem-events-manager');
         esc_html_e('Settings >> Permalinks >> Choose Plain then Settings >> Permalinks >> Choose Post name  ', 'ovaem-events-manager'); ?>
										</strong>
									</div>




								</div>

								<!-- Schedule Tab Content -->
								<div id="basic_settings" class="ovaem_settings">
									<?php do_settings_sections('basic_settings'); // Page ?>
									<hr>
									<?php do_settings_sections('list_events_settings'); // Page ?>
									<hr>
									<?php do_settings_sections('search_settings'); // Page ?>
									<hr>
									<?php do_settings_sections('event_detail_settings');?>

								</div>

								<div id="list_speakers_settings" class="ovaem_settings">
									<?php do_settings_sections('list_speakers_settings'); // Page ?>
									<hr>
									<?php do_settings_sections('detail_speakers_settings'); // Page ?>
								</div>

								<div id="venue_settings" class="ovaem_settings">
									<?php do_settings_sections('venue_settings'); // Page ?>
									<hr>
									<?php do_settings_sections('detail_venue_settings'); // Page ?>

								</div>





								<div id="checkout_settings" class="ovaem_settings">

									<?php do_settings_sections('checkout_settings'); // Page ?>

									<div class="offline_payment_settings">
										<?php do_settings_sections('offline_payment_settings'); // Page ?>
									</div>

									<?php if (class_exists('OVA_EVENTS_MANAGER_PAYPAL') && is_plugin_active('ova-events-manager-paypal/ova-events-manager-paypal.php')) {?>
										<div class="paypal_settings">
											<?php do_settings_sections('paypal_settings'); // Page ?>
										</div>
									<?php }?>

									<?php if (class_exists('OVA_EVENTS_MANAGER_STRIPE') && is_plugin_active('ova-events-manager-stripe/ova-events-manager-stripe.php')) {?>
										<div class="stripe_payment_settings">
											<?php do_settings_sections('stripe_payment_settings'); // Page ?>
										</div>
									<?php }?>

									<?php if (class_exists('woocommerce') && is_plugin_active('woocommerce/woocommerce.php')) {?>
										<div class="woo_payment_section_setting">
											<?php do_settings_sections('woo_payment_section_setting'); // Page ?>
										</div>
									<?php }?>





								</div>

								<div id="event_free_settings" class="ovaem_settings">


                           

									<?php do_settings_sections('event_mail_settings'); // Page ?>

                           <?php do_settings_sections('send_from_setting'); // Page ?>

									<?php do_settings_sections('event_free_settings'); // Page ?>

									<?php do_settings_sections('paid_event_mail_settings'); // Page ?>

									<?php do_settings_sections('pdf_ticket_settings'); // Page ?>

								</div>

								<div id="user_submit_settings" class="ovaem_settings">
									<?php do_settings_sections('user_submit_settings'); // Page ?>
								</div>
                        
                        <div id="captcha_settings" class="ovaem_settings">
                           <?php do_settings_sections('captcha_settings'); // Page ?>
                        </div>

                        <div id="cfc_checkout_settings" class="ovaem_settings">
                           <?php do_settings_sections('cfc_checkout_settings'); // Page ?>
                        </div>


							</div>

							<br/>
						</div>
					</div>


					<?php submit_button();?>

				</form>
			</div>

			<?php
}

      public function event_post_type_slug() {
         $event_post_type_slug = esc_attr(OVAEM_Settings::event_post_type_slug());
         printf(
            '<input class="hide_change_slug" type="text" id="event_post_type_slug" name="ovaem_options[event_post_type_slug]" value="%s" />',
            isset($event_post_type_slug) ? $event_post_type_slug : 'event'
         );
         echo '<span class="hide_change_slug">' . esc_html__(' Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long  and  without any spaces', 'ovaem-events-manager') . '<span>';

      }

      public function event_post_type_rewrite_slug() {
         $event_post_type_rewrite_slug = esc_attr(OVAEM_Settings::event_post_type_rewrite_slug());
         printf(
            '<input type="text" id="event_post_type_rewrite_slug" name="ovaem_options[event_post_type_rewrite_slug]" value="%s" />',
            isset($event_post_type_rewrite_slug) ? $event_post_type_rewrite_slug : 'event'
         );
         echo '<span>' . esc_html__(' Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long  and  without any spaces', 'ovaem-events-manager') . '<span>';

      }

      public function speaker_post_type_slug() {
         $speaker_post_type_slug = esc_attr(OVAEM_Settings::speaker_post_type_slug());
         printf(
            '<input type="text" class="hide_change_slug" id="speaker_post_type_slug" name="ovaem_options[speaker_post_type_slug]" value="%s" />',
            isset($speaker_post_type_slug) ? $speaker_post_type_slug : ''
         );
         echo '<span class="hide_change_slug">' . esc_html__(' Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long and  without any spaces', 'ovaem-events-manager') . '<span>';

      }

      public function speaker_post_type_rewrite_slug() {
         $speaker_post_type_rewrite_slug = esc_attr(OVAEM_Settings::speaker_post_type_rewrite_slug());
         printf(
            '<input type="text"  id="speaker_post_type_rewrite_slug" name="ovaem_options[speaker_post_type_rewrite_slug]" value="%s" />',
            isset($speaker_post_type_rewrite_slug) ? $speaker_post_type_rewrite_slug : ''
         );
         echo '<span >' . esc_html__(' Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long and  without any spaces', 'ovaem-events-manager') . '<span>';

      }

      public function venue_post_type_slug() {
         $venue_post_type_slug = esc_attr(OVAEM_Settings::venue_post_type_slug());
         printf(
            '<input type="text" id="venue_post_type_slug" name="ovaem_options[venue_post_type_slug]" value="%s" />',
            isset($venue_post_type_slug) ? $venue_post_type_slug : ''
         );
         echo '<span>' . esc_html__(' Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long and  without any spaces', 'ovaem-events-manager') . '<span>';

      }

      public function venue_post_type_rewrite_slug() {
         $venue_post_type_rewrite_slug = esc_attr(OVAEM_Settings::venue_post_type_rewrite_slug());
         printf(
            '<input type="text" id="venue_post_type_rewrite_slug" name="ovaem_options[venue_post_type_rewrite_slug]" value="%s" />',
            isset($venue_post_type_rewrite_slug) ? $venue_post_type_rewrite_slug : ''
         );
         echo '<span>' . esc_html__(' Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long and  without any spaces', 'ovaem-events-manager') . '<span>';

      }

      public function location_post_type_slug() {
         $location_post_type_slug = esc_attr(OVAEM_Settings::location_post_type_slug());
         printf(
            '<input type="text" id="location_post_type_slug" name="ovaem_options[location_post_type_slug]" value="%s" />',
            isset($location_post_type_slug) ? $location_post_type_slug : ''
         );
         echo '<span>' . esc_html__(' Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long and  without any spaces', 'ovaem-events-manager') . '<span>';

      }

      public function slug_taxonomy_name() {
         $slug_taxonomy_name = esc_attr(OVAEM_Settings::slug_taxonomy_name());
         printf(
            '<input type="text" id="slug_taxonomy_name" name="ovaem_options[slug_taxonomy_name]" value="%s" />',
            isset($slug_taxonomy_name) ? $slug_taxonomy_name : 'categories'
         );
         echo '<span>' . esc_html__(' Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long', 'ovaem-events-manager') . '<span>';

      }

      public function google_key_map() {
         $google_key_map = esc_attr(OVAEM_Settings::google_key_map());
         printf(
            '<input type="text" id="google_key_map"  name="ovaem_options[google_key_map]" value="%s" />',
            isset($google_key_map) ? $google_key_map : ''
         );
         echo ' <span class="desc">' . esc_html__('You can get here: https://developers.google.com/maps/documentation/javascript/get-api-key ', 'ovaem-events-manager') . '</span>';

      }

      public function search_name() {

         $search_name = OVAEM_Settings::search_name();
         $search_name = isset($search_name) ? $search_name : 'true';

         $true = ('true' == $search_name) ? 'selected' : '';
         $false = ('false' == $search_name) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_name]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_cat() {

         $search_cat = OVAEM_Settings::search_cat();
         $search_cat = isset($search_cat) ? $search_cat : 'true';

         $true = ('true' == $search_cat) ? 'selected' : '';
         $false = ('false' == $search_cat) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_cat]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_venue() {

         $search_venue = OVAEM_Settings::search_venue();
         $search_venue = isset($search_venue) ? $search_venue : 'true';

         $true = ('true' == $search_venue) ? 'selected' : '';
         $false = ('false' == $search_venue) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_venue]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function search_time() {

         $search_time = OVAEM_Settings::search_time();
         $search_time = isset($search_time) ? $search_time : 'true';

         $true = ('true' == $search_time) ? 'selected' : '';
         $false = ('false' == $search_time) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function search_time_today() {

         $search_time_today = OVAEM_Settings::search_time_today();
         $search_time_today = isset($search_time_today) ? $search_time_today : 'true';

         $true = ('true' == $search_time_today) ? 'selected' : '';
         $false = ('false' == $search_time_today) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time_today]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function search_time_tomorrow() {

         $search_time_tomorrow = OVAEM_Settings::search_time_tomorrow();
         $search_time_tomorrow = isset($search_time_tomorrow) ? $search_time_tomorrow : 'true';

         $true = ('true' == $search_time_tomorrow) ? 'selected' : '';
         $false = ('false' == $search_time_tomorrow) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time_tomorrow]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_time_this_week() {

         $search_time_this_week = OVAEM_Settings::search_time_this_week();
         $search_time_this_week = isset($search_time_this_week) ? $search_time_this_week : 'true';

         $true = ('true' == $search_time_this_week) ? 'selected' : '';
         $false = ('false' == $search_time_this_week) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time_this_week]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_time_this_week_end() {

         $search_time_this_week_end = OVAEM_Settings::search_time_this_week_end();
         $search_time_this_week_end = isset($search_time_this_week_end) ? $search_time_this_week_end : 'true';

         $true = ('true' == $search_time_this_week_end) ? 'selected' : '';
         $false = ('false' == $search_time_this_week_end) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time_this_week_end]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_time_this_week_end_day() {

         $search_time_this_week_end_day = OVAEM_Settings::search_time_this_week_end_day();
         $search_time_this_week_end_day = isset($search_time_this_week_end_day) ? $search_time_this_week_end_day : array(0 => array('saturday', 'sunday'));
         $selected_monday = in_array('monday', $search_time_this_week_end_day[0]) ? 'selected' : '';
         $selected_tuesday = in_array('tuesday', $search_time_this_week_end_day[0]) ? 'selected' : '';
         $selected_wednesday = in_array('wednesday', $search_time_this_week_end_day[0]) ? 'selected' : '';
         $selected_thursday = in_array('thursday', $search_time_this_week_end_day[0]) ? 'selected' : '';
         $selected_friday = in_array('friday', $search_time_this_week_end_day[0]) ? 'selected' : '';
         $selected_saturday = in_array('saturday', $search_time_this_week_end_day[0]) ? 'selected' : '';
         $selected_sunday = in_array('sunday', $search_time_this_week_end_day[0]) ? 'selected' : '';

         $html = '<select multiple name="ovaem_options[search_time_this_week_end_day][]">';

         $html .= '<option ' . $selected_monday . ' value="monday">' . esc_html__('Monday', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $selected_tuesday . ' value="tuesday">' . esc_html__('Tuesday', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $selected_wednesday . ' value="wednesday">' . esc_html__('Wednesday', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $selected_thursday . ' value="thursday">' . esc_html__('Thursday', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $selected_friday . ' value="friday">' . esc_html__('Friday', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $selected_saturday . ' value="saturday">' . esc_html__('Saturday', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $selected_sunday . ' value="sunday">' . esc_html__('Sunday', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function search_time_next_week() {

         $search_time_next_week = OVAEM_Settings::search_time_next_week();
         $search_time_next_week = isset($search_time_next_week) ? $search_time_next_week : 'true';

         $true = ('true' == $search_time_next_week) ? 'selected' : '';
         $false = ('false' == $search_time_next_week) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time_next_week]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_time_next_month() {

         $search_time_next_month = OVAEM_Settings::search_time_next_month();
         $search_time_next_month = isset($search_time_next_month) ? $search_time_next_month : 'true';

         $true = ('true' == $search_time_next_month) ? 'selected' : '';
         $false = ('false' == $search_time_next_month) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time_next_month]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_time_past() {

         $search_time_past = OVAEM_Settings::search_time_past();
         $search_time_past = isset($search_time_past) ? $search_time_past : 'true';

         $true = ('true' == $search_time_past) ? 'selected' : '';
         $false = ('false' == $search_time_past) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time_past]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_time_future() {

         $search_time_future = OVAEM_Settings::search_time_future();
         $search_time_future = isset($search_time_future) ? $search_time_future : 'true';

         $true = ('true' == $search_time_future) ? 'selected' : '';
         $false = ('false' == $search_time_future) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_time_future]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function search_date() {

         $search_date = OVAEM_Settings::search_date();
         $search_date = isset($search_date) ? $search_date : 'true';

         $true = ('true' == $search_date) ? 'selected' : '';
         $false = ('false' == $search_date) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_date]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_tag() {

         $event_show_tag = OVAEM_Settings::event_show_tag();
         $event_show_tag = isset($event_show_tag) ? $event_show_tag : 'true';

         $true = ('true' == $event_show_tag) ? 'selected' : '';
         $false = ('false' == $event_show_tag) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_tag]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_share_social() {

         $event_show_share_social = OVAEM_Settings::event_show_share_social();
         $event_show_share_social = isset($event_show_share_social) ? $event_show_share_social : 'true';

         $true = ('true' == $event_show_share_social) ? 'selected' : '';
         $false = ('false' == $event_show_share_social) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_share_social]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_schedule_tab() {

         $event_show_schedule_tab = OVAEM_Settings::event_show_schedule_tab();
         $event_show_schedule_tab = isset($event_show_schedule_tab) ? $event_show_schedule_tab : 'true';

         $true = ('true' == $event_show_schedule_tab) ? 'selected' : '';
         $false = ('false' == $event_show_schedule_tab) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_schedule_tab]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_speaker_tab() {

         $event_show_speaker_tab = OVAEM_Settings::event_show_speaker_tab();
         $event_show_speaker_tab = isset($event_show_speaker_tab) ? $event_show_speaker_tab : 'true';

         $true = ('true' == $event_show_speaker_tab) ? 'selected' : '';
         $false = ('false' == $event_show_speaker_tab) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_speaker_tab]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_book_now() {

         $event_show_book_now = OVAEM_Settings::event_show_book_now();
         $event_show_book_now = isset($event_show_book_now) ? $event_show_book_now : 'true';

         $true = ('true' == $event_show_book_now) ? 'selected' : '';
         $false = ('false' == $event_show_book_now) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_book_now]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_book_now_event_past() {

         $event_show_book_now_event_past = OVAEM_Settings::event_show_book_now_event_past();
         $event_show_book_now_event_past = isset($event_show_book_now_event_past) ? $event_show_book_now_event_past : 'true';

         $true = ('true' == $event_show_book_now_event_past) ? 'selected' : '';
         $false = ('false' == $event_show_book_now_event_past) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_book_now_event_past]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      

      public function event_scroll_tab() {

         $event_scroll_tab = OVAEM_Settings::event_scroll_tab();
         $selected = isset($event_scroll_tab) ? $event_scroll_tab : 'ticket';

         $html = '<select  name="ovaem_options[event_scroll_tab]">';
         $html .= '<option '.selected( $selected, 'ticket', false ).' value="ticket">' . esc_html__('Ticket', 'ovaem-events-manager') . '</option>';
         $html .= '<option '.selected( $selected, 'schedule', false ).' value="schedule">' . esc_html__('Schedule', 'ovaem-events-manager') . '</option>';
         $html .= '<option '.selected( $selected, 'speaker', false ).' value="speaker">' . esc_html__('Speaker', 'ovaem-events-manager') . '</option>';
         $html .= '<option '.selected( $selected, 'event_faq', false ).' value="event_faq">' . esc_html__('FAQ', 'ovaem-events-manager') . '</option>';
         $html .= '<option '.selected( $selected, 'event_comments', false ).' value="event_comments">' . esc_html__('Comments', 'ovaem-events-manager') . '</option>';
         $html .= '<option '.selected( $selected, 'event_contact', false ).' value="event_contact">' . esc_html__('Contact', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         $html .= '<span >' . esc_html__('Scroll down the tab when clicking book now', 'ovaem-events-manager') . '<span>';

         print($html);

      }

      public function event_show_ticket_tab() {

         $event_show_ticket_tab = OVAEM_Settings::event_show_ticket_tab();
         $event_show_ticket_tab = isset($event_show_ticket_tab) ? $event_show_ticket_tab : 'true';

         $true = ('true' == $event_show_ticket_tab) ? 'selected' : '';
         $false = ('false' == $event_show_ticket_tab) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_ticket_tab]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_ticket_tab_expired() {

         $event_show_ticket_tab_expired = OVAEM_Settings::event_show_ticket_tab_expired();
         $event_show_ticket_tab_expired = isset($event_show_ticket_tab_expired) ? $event_show_ticket_tab_expired : 'true';

         $true = ('true' == $event_show_ticket_tab_expired) ? 'selected' : '';
         $false = ('false' == $event_show_ticket_tab_expired) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_ticket_tab_expired]">';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function event_show_related() {

         $event_show_related = OVAEM_Settings::event_show_related();
         $event_show_related = isset($event_show_related) ? $event_show_related : 'true';

         $true = ('true' == $event_show_related) ? 'selected' : '';
         $false = ('false' == $event_show_related) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_related]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_comments() {

         $event_show_comments = OVAEM_Settings::event_show_comments();
         $event_show_comments = isset($event_show_comments) ? $event_show_comments : 'true';

         $true = ('true' == $event_show_comments) ? 'selected' : '';
         $false = ('false' == $event_show_comments) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_comments]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_contact() {

         $event_show_contact = OVAEM_Settings::event_show_contact();
         $event_show_contact = isset($event_show_contact) ? $event_show_contact : 'true';

         $true = ('true' == $event_show_contact) ? 'selected' : '';
         $false = ('false' == $event_show_contact) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_contact]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_notify() {

         $event_show_notify = OVAEM_Settings::event_show_notify();
         $event_show_notify = isset($event_show_notify) ? $event_show_notify : 'true';

         $true = ('true' == $event_show_notify) ? 'selected' : '';
         $false = ('false' == $event_show_notify) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_notify]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_venue() {

         $event_show_venue = OVAEM_Settings::event_show_venue();
         $event_show_venue = isset($event_show_venue) ? $event_show_venue : 'true';

         $true = ('true' == $event_show_venue) ? 'selected' : '';
         $false = ('false' == $event_show_venue) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_venue]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_startdate() {

         $event_show_startdate = OVAEM_Settings::event_show_startdate();
         $event_show_startdate = isset($event_show_startdate) ? $event_show_startdate : 'true';

         $true = ('true' == $event_show_startdate) ? 'selected' : '';
         $false = ('false' == $event_show_startdate) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_startdate]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_enddate() {

         $event_show_enddate = OVAEM_Settings::event_show_enddate();
         $event_show_enddate = isset($event_show_enddate) ? $event_show_enddate : 'true';

         $true = ('true' == $event_show_enddate) ? 'selected' : '';
         $false = ('false' == $event_show_enddate) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_enddate]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_room() {

         $event_show_room = OVAEM_Settings::event_show_room();
         $event_show_room = isset($event_show_room) ? $event_show_room : 'true';

         $true = ('true' == $event_show_room) ? 'selected' : '';
         $false = ('false' == $event_show_room) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_room]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }
      public function event_show_gallery() {

         $event_show_gallery = OVAEM_Settings::event_show_gallery();
         $event_show_gallery = isset($event_show_gallery) ? $event_show_gallery : 'true';

         $true = ('true' == $event_show_gallery) ? 'selected' : '';
         $false = ('false' == $event_show_gallery) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_gallery]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_detail_template() {

         $event_detail_template = OVAEM_Settings::event_detail_template();
         $event_detail_template = isset($event_detail_template) ? $event_detail_template : 'classic';

         $classic = ('classic' == $event_detail_template) ? 'selected' : '';
         $modern = ('modern' == $event_detail_template) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_detail_template]">';
         $html .= '<option ' . $classic . ' value="classic">' . esc_html__('Classic', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $modern . ' value="modern">' . esc_html__('Modern', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_address() {

         $event_show_address = OVAEM_Settings::event_show_address();
         $event_show_address = isset($event_show_address) ? $event_show_address : 'true';

         $true = ('true' == $event_show_address) ? 'selected' : '';
         $false = ('false' == $event_show_address) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_address]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_map() {

         $event_show_map = OVAEM_Settings::event_show_map();
         $event_show_map = isset($event_show_map) ? $event_show_map : 'address';

         $map_address = ('address' == $event_show_map) ? 'selected' : '';
         $map_venue = ('venue' == $event_show_map) ? 'selected' : '';
         $map_none = ('no' == $event_show_map) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_map]">';
         $html .= '<option ' . $map_address . ' value="address">' . esc_html__('of Event', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $map_venue . ' value="venue">' . esc_html__('of Venue', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $map_none . ' value="no">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_map_btn() {

         $event_show_map_btn = OVAEM_Settings::event_show_map_btn();
         $event_show_map_btn = isset($event_show_map_btn) ? $event_show_map_btn : 'yes';

         $map_yes = ('yes' == $event_show_map_btn) ? 'selected' : '';
         $map_no = ('no' == $event_show_map_btn) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_map_btn]">';
         $html .= '<option ' . $map_yes . ' value="yes">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $map_no . ' value="no">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_organizer() {

         $event_show_organizer = OVAEM_Settings::event_show_organizer();
         $event_show_organizer = isset($event_show_organizer) ? $event_show_organizer : 'true';

         $true = ('true' == $event_show_organizer) ? 'selected' : '';
         $false = ('false' == $event_show_organizer) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_organizer]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_sponsors() {

         $event_show_sponsors = OVAEM_Settings::event_show_sponsors();
         $event_show_sponsors = isset($event_show_sponsors) ? $event_show_sponsors : 'true';

         $true = ('true' == $event_show_sponsors) ? 'selected' : '';
         $false = ('false' == $event_show_sponsors) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_sponsors]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_content() {

         $event_show_content = OVAEM_Settings::event_show_content();
         $event_show_content = isset($event_show_content) ? $event_show_content : 'true';

         $true = ('true' == $event_show_content) ? 'selected' : '';
         $false = ('false' == $event_show_content) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_content]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_extra_info() {

         $event_show_extra_info = OVAEM_Settings::event_show_extra_info();
         $event_show_extra_info = isset($event_show_extra_info) ? $event_show_extra_info : 'true';

         $true = ('true' == $event_show_extra_info) ? 'selected' : '';
         $false = ('false' == $event_show_extra_info) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_extra_info]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_faq() {

         $event_show_faq = OVAEM_Settings::event_show_faq();
         $event_show_faq = isset($event_show_faq) ? $event_show_faq : 'true';

         $true = ('true' == $event_show_faq) ? 'selected' : '';
         $false = ('false' == $event_show_faq) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_faq]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_show_ical() {

         $event_show_ical = OVAEM_Settings::event_show_ical();
         $event_show_ical = isset($event_show_ical) ? $event_show_ical : 'true';

         $true = ('true' == $event_show_ical) ? 'selected' : '';
         $false = ('false' == $event_show_ical) ? 'selected' : '';

         $html = '<select  name="ovaem_options[event_show_ical]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function event_map_zoom() {

         $event_map_zoom = OVAEM_Settings::event_map_zoom();
         $event_map_zoom = isset($event_map_zoom) ? $event_map_zoom : 'true';

         printf(
            '<input type="text" id="event_map_zoom" name="ovaem_options[event_map_zoom]" value="%s" />',
            isset($event_map_zoom) ? $event_map_zoom : '20'
         );

      }

      public function upcomming_days() {
         $upcomming_days = esc_attr(OVAEM_Settings::upcomming_days());
         printf(
            '<input type="text" id="upcomming_days" placeholder="' . esc_html__('Insert Number', 'ovaem-events-manager') . '" name="ovaem_options[upcomming_days]" value="%s" />',
            isset($upcomming_days) ? $upcomming_days : '1000'
         );
         echo ' <span class="desc">' . esc_html__('days countdown', 'ovaem-events-manager') . '</span>';

      }

      public function number_event_related() {
         $number_event_related = esc_attr(OVAEM_Settings::number_event_related());
         printf(
            '<input type="text" id="number_event_related" placeholder="' . esc_html__('Insert Number', 'ovaem-events-manager') . '" name="ovaem_options[number_event_related]" value="%s" />',
            isset($number_event_related) ? $number_event_related : '4'
         );
      }

      public function currency_position() {

         $currency_position = OVAEM_Settings::currency_position();
         $currency_position = isset($currency_position) ? $currency_position : 'left';

         $left = ('left' == $currency_position) ? 'selected' : '';
         $right = ('right' == $currency_position) ? 'selected' : '';
         $left_space = ('left_space' == $currency_position) ? 'selected' : '';
         $right_space = ('right_space' == $currency_position) ? 'selected' : '';

         $html = '<select  name="ovaem_options[currency_position]">';
         $html .= '<option ' . $left . ' value="left">' . esc_html__('Left ($99.99)', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $right . ' value="right">' . esc_html__('Right (99.99$)', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $left_space . ' value="left_space">' . esc_html__('Left with space ($ 99.99)', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $right_space . ' value="right_space">' . esc_html__('Right with space (99.99 $)', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }
      public function google_type_event() {

         $google_type_event = OVAEM_Settings::google_type_event();
         $google_type_event = isset($google_type_event) ? $google_type_event : 'yes';

         $yes = ('yes' == $google_type_event) ? 'selected' : '';
         $no = ('no' == $google_type_event) ? 'selected' : '';

         $html = '<select  name="ovaem_options[google_type_event]">';
         $html .= '<option ' . $yes . ' value="yes">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $no . ' value="no">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';
         $html .= '&nbsp;&nbsp;<span>' . esc_html__('Result search in google will display type event', 'ovaem-events-manager') . '</span>';

         print($html);

      }

      public function event_secret_key() {

         $event_secret_key = OVAEM_Settings::event_secret_key();
         $event_secret_key = isset($event_secret_key) ? $event_secret_key : 'true';

         printf(
            '<input type="text" id="event_secret_key" name="ovaem_options[event_secret_key]" value="%s" />',
            isset($event_secret_key) ? $event_secret_key : '20'
         );
      }

      public function event_calendar_input_step() {

         $event_calendar_input_step = OVAEM_Settings::event_calendar_input_step();
         $event_calendar_input_step = isset($event_calendar_input_step) ? $event_calendar_input_step : 30;

         printf(
            '<input type="text" id="event_calendar_input_step" name="ovaem_options[event_calendar_input_step]" value="%s" /><span>'.' '.esc_html__( 'Example: 9:00, 9:30, 10:00, 10:30', 'ovaem-events-manager' ).'</span>',
            isset($event_calendar_input_step) ? $event_calendar_input_step : 30
         );




      }

      public function archives_event_style() {
         $archives_event_style = OVAEM_Settings::archives_event_style();
         $archives_event_style = isset($archives_event_style) ? $archives_event_style : 'grid';

         $grid = ('grid' == $archives_event_style) ? 'selected' : '';
         $list = ('list' == $archives_event_style) ? 'selected' : '';
         $list_sidebar = ('list_sidebar' == $archives_event_style) ? 'selected' : '';
         $grid_sidebar = ('grid_sidebar' == $archives_event_style) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archives_event_style]">';
         $html .= '<option ' . $grid . ' value="grid">' . esc_html__('Grid', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $list . ' value="list">' . esc_html__('List', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $list_sidebar . ' value="list_sidebar">' . esc_html__('List with Sidebar', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $grid_sidebar . ' value="grid_sidebar">' . esc_html__('Grid with Sidebar', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function archives_event_style_grid() {
         $archives_event_style_grid = OVAEM_Settings::archives_event_style_grid();
         $archives_event_style_grid = isset($archives_event_style_grid) ? $archives_event_style_grid : 'style1';

         $style1 = ('style1' == $archives_event_style_grid) ? 'selected' : '';
         $style2 = ('style2' == $archives_event_style_grid) ? 'selected' : '';
         $style3 = ('style3' == $archives_event_style_grid) ? 'selected' : '';
         $style4 = ('style4' == $archives_event_style_grid) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archives_event_style_grid]">';
         $html .= '<option ' . $style1 . ' value="style1">' . esc_html__('Style 1', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $style2 . ' value="style2">' . esc_html__('Style 2', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $style3 . ' value="style3">' . esc_html__('Style 3', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $style4 . ' value="style4">' . esc_html__('Style 4', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         $html .= '&nbsp;&nbsp;<span>' . esc_html__('You have to choose "Style Archives/Category Event: Grid or Grid with Sidebar" above', 'ovaem-events-manager') . '</span>';

         print($html);
      }


      public function event_calendar_lang() {
         $event_calendar_lang = OVAEM_Settings::event_calendar_lang();
         $event_calendar_lang = isset($event_calendar_lang) ? $event_calendar_lang : 'en-GB';

         $list_cal = ovaem_get_calendar_language();

         $html = '<select  name="ovaem_options[event_calendar_lang]">';

         foreach ($list_cal as $key => $value) {
            $selected = ( $key == $event_calendar_lang ) ? 'selected' : '';
            $html .= '<option ' . $selected . ' value="'.$key.'">' . $value . '</option>';
         }

         $html .= '</select>';

         print($html);
      }

      public function first_day_of_week() {
         $first_day_of_week = OVAEM_Settings::first_day_of_week();
         $first_day_of_week = isset($first_day_of_week) ? $first_day_of_week : '0';

         $list_week = array(
            '1' => esc_html__('Monday', 'ovaem-events-manager'),
            '2' => esc_html__('Tuesday', 'ovaem-events-manager'),
            '3' => esc_html__('Wednesday', 'ovaem-events-manager'),
            '4' => esc_html__('Thursday', 'ovaem-events-manager'),
            '5' => esc_html__('Friday', 'ovaem-events-manager'),
            '6' => esc_html__('Saturday', 'ovaem-events-manager'),
            '0' => esc_html__('Sunday', 'ovaem-events-manager'),
         );

         $html = '<select  name="ovaem_options[first_day_of_week]">';

         foreach ($list_week as $key => $value) {
            $selected = ( $key == $first_day_of_week ) ? 'selected' : '';
            $html .= '<option ' . $selected . ' value="'.$key.'">' . $value . '</option>';
         }

         $html .= '</select>';

         print($html);
      }


      public function archives_event_show_past() {
         $archives_event_show_past = OVAEM_Settings::archives_event_show_past();
         $archives_event_show_past = isset($archives_event_show_past) ? $archives_event_show_past : 'true';

         $true = ('true' == $archives_event_show_past) ? 'selected' : '';
         $false = ('false' == $archives_event_show_past) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archives_event_show_past]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function archives_event_show_desc_cat() {
         $archives_event_show_desc_cat = OVAEM_Settings::archives_event_show_desc_cat();
         $archives_event_show_desc_cat = isset($archives_event_show_desc_cat) ? $archives_event_show_desc_cat : 'true';

         $true = ('true' == $archives_event_show_desc_cat) ? 'selected' : '';
         $false = ('false' == $archives_event_show_desc_cat) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archives_event_show_desc_cat]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      

      public function archives_event_show_status() {
         $archives_event_show_status = OVAEM_Settings::archives_event_show_status();
         $archives_event_show_status = isset($archives_event_show_status) ? $archives_event_show_status : 'false';

         $true = ('true' == $archives_event_show_status) ? 'selected' : '';
         $false = ('false' == $archives_event_show_status) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archives_event_show_status]">';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);
      }

      public function archives_event_show_get_ticket() {
         $archives_event_show_get_ticket = OVAEM_Settings::archives_event_show_get_ticket();
         $archives_event_show_get_ticket = isset($archives_event_show_get_ticket) ? $archives_event_show_get_ticket : 'true';

         $true = ('true' == $archives_event_show_get_ticket) ? 'selected' : '';
         $false = ('false' == $archives_event_show_get_ticket) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archives_event_show_get_ticket]">';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         $html .= '&nbsp;&nbsp;<span>' . esc_html__('Show the "Get ticket" button when the event has expired.', 'ovaem-events-manager') . '</span>';

         print($html);
      }

      

      public function archives_event_orderby() {
         $archives_event_orderby = OVAEM_Settings::archives_event_orderby();
         $archives_event_orderby = isset($archives_event_orderby) ? $archives_event_orderby : OVAEM_Settings::$prefix . '_date_start_time';

         $prefix = OVAEM_Settings::$prefix;

         $date_start_time = $prefix . '_date_start_time';
         $date_end_time = $prefix . '_date_end_time';
         $date_order = $prefix . '_order';
         $date_created = 'date';

         $date_start_time_selected = ($date_start_time == $archives_event_orderby) ? 'selected' : '';
         $date_end_time_selected = ($date_end_time == $archives_event_orderby) ? 'selected' : '';
         $date_order_selected = ($date_order == $archives_event_orderby) ? 'selected' : '';
         $date_created_selected = ($date_created == $archives_event_orderby) ? 'selected' : '';


         $title_selected = ('title' == $archives_event_orderby) ? 'selected' : '';
         $id_selected = ( 'ID' == $archives_event_orderby) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archives_event_orderby]">';
         $html .= '<option ' . $date_start_time_selected . ' value="' . $date_start_time . '">' . esc_html__('Start Time', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_end_time_selected . ' value="' . $date_end_time . '">' . esc_html__('End Time', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_order_selected . ' value="' . $date_order . '">' . esc_html__('Order Field in event attribute', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_created_selected . ' value="' . $date_created . '">' . esc_html__('Created Date', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $title_selected . ' value="title">' . esc_html__('Title', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $id_selected . ' value="ID">' . esc_html__('ID', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);
      }

      public function archives_event_order() {
         $archives_event_order = OVAEM_Settings::archives_event_order();
         $archives_event_order = isset($archives_event_order) ? $archives_event_order : 'ASC';

         $asc_selected = ('ASC' == $archives_event_order) ? 'selected' : '';
         $desc_selected = ('DESC' == $archives_event_order) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archives_event_order]">';
         $html .= '<option ' . $asc_selected . ' value="ASC">' . esc_html__('Increase', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $desc_selected . ' value="DESC">' . esc_html__('Decrease', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function ovaem_day_format() {
         $ovaem_day_format = esc_attr(OVAEM_Settings::ovaem_day_format());
         printf(
            '<input type="text" id="ovaem_day_format" placeholder="' . esc_html__('Insert param', 'ovaem-events-manager') . '" name="ovaem_options[ovaem_day_format]" value="%s" />',
            isset($ovaem_day_format) ? $ovaem_day_format : 'j'
         );
         esc_html_e(' You can find here: https://codex.wordpress.org/Formatting_Date_and_Time', 'ovaem-events-manager');
      }

      public function ovaem_month_format() {
         $ovaem_month_format = esc_attr(OVAEM_Settings::ovaem_month_format());
         printf(
            '<input type="text" id="ovaem_month_format" placeholder="' . esc_html__('Insert param', 'ovaem-events-manager') . '" name="ovaem_options[ovaem_month_format]" value="%s" />',
            isset($ovaem_month_format) ? $ovaem_month_format : 'M'
         );
         esc_html_e(' You can find here: https://codex.wordpress.org/Formatting_Date_and_Time', 'ovaem-events-manager');
      }

      public function ovaem_year_format() {
         $ovaem_year_format = esc_attr(OVAEM_Settings::ovaem_year_format());
         printf(
            '<input type="text" id="ovaem_year_format" placeholder="' . esc_html__('Insert param', 'ovaem-events-manager') . '" name="ovaem_options[ovaem_year_format]" value="%s" />',
            isset($ovaem_year_format) ? $ovaem_year_format : 'Y'
         );
         esc_html_e(' You can find here: https://codex.wordpress.org/Formatting_Date_and_Time', 'ovaem-events-manager');
      }

      public function ovaem_list_post_per_page() {
         $ovaem_list_post_per_page = esc_attr(OVAEM_Settings::ovaem_list_post_per_page());
         printf(
            '<input type="number" id="ovaem_list_post_per_page" placeholder="9" name="ovaem_options[ovaem_list_post_per_page]" value="%d" />',
            isset($ovaem_list_post_per_page) ? $ovaem_list_post_per_page : 9
         );
      }

      public function ovaem_number_character_title_event() {
         $ovaem_number_character_title_event = esc_attr(OVAEM_Settings::ovaem_number_character_title_event());
         printf(
            '<input type="number" id="ovaem_number_character_title_event" placeholder="9" name="ovaem_options[ovaem_number_character_title_event]" value="%d" />',
            isset($ovaem_number_character_title_event) ? $ovaem_number_character_title_event : 30
         );
      }

      public function ovaem_number_character_excerpt() {
         $ovaem_number_character_excerpt = esc_attr(OVAEM_Settings::ovaem_number_character_excerpt());
         printf(
            '<input type="number" id="ovaem_number_character_excerpt" placeholder="9" name="ovaem_options[ovaem_number_character_excerpt]" value="%d" />',
            isset($ovaem_number_character_excerpt) ? $ovaem_number_character_excerpt : 60
         );
      }

      public function ovaem_number_character_venue() {
         $ovaem_number_character_venue = esc_attr(OVAEM_Settings::ovaem_number_character_venue());
         printf(
            '<input type="number" id="ovaem_number_character_venue" placeholder="9" name="ovaem_options[ovaem_number_character_venue]" value="%d" />',
            isset($ovaem_number_character_venue) ? $ovaem_number_character_venue : 20
         );
      }

      public function search_event_show_past() {
         $search_event_show_past = OVAEM_Settings::search_event_show_past();
         $search_event_show_past = isset($search_event_show_past) ? $search_event_show_past : 'true';

         $true = ('true' == $search_event_show_past) ? 'selected' : '';
         $false = ('false' == $search_event_show_past) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_event_show_past]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function search_event_show_states() {
         $search_event_show_states = OVAEM_Settings::search_event_show_states();
         $search_event_show_states = isset($search_event_show_states) ? $search_event_show_states : 'true';

         $true = ('true' == $search_event_show_states) ? 'selected' : '';
         $false = ('false' == $search_event_show_states) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_event_show_states]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }
      public function search_event_show_cities() {
         $search_event_show_cities = OVAEM_Settings::search_event_show_cities();
         $search_event_show_cities = isset($search_event_show_cities) ? $search_event_show_cities : 'true';

         $true = ('true' == $search_event_show_cities) ? 'selected' : '';
         $false = ('false' == $search_event_show_cities) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_event_show_cities]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function search_event_orderby() {
         $search_event_orderby = OVAEM_Settings::search_event_orderby();
         $search_event_orderby = isset($search_event_orderby) ? $search_event_orderby : OVAEM_Settings::$prefix . '_date_start_time';

         $prefix = OVAEM_Settings::$prefix;

         $date_start_time = $prefix . '_date_start_time';
         $date_end_time = $prefix . '_date_end_time';
         $date_order = $prefix . '_order';
         $date_created = 'date';

         $date_start_time_selected = ($date_start_time == $search_event_orderby) ? 'selected' : '';
         $date_end_time_selected = ($date_end_time == $search_event_orderby) ? 'selected' : '';
         $date_order_selected = ($date_order == $search_event_orderby) ? 'selected' : '';
         $date_created_selected = ($date_created == $search_event_orderby) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_event_orderby]">';
         $html .= '<option ' . $date_start_time_selected . ' value="' . $date_start_time . '">' . esc_html__('Start Time', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_end_time_selected . ' value="' . $date_end_time . '">' . esc_html__('End Time', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_order_selected . ' value="' . $date_order . '">' . esc_html__('Order Field in event attribute', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_created_selected . ' value="' . $date_created . '">' . esc_html__('Created Date', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function search_event_order() {
         $search_event_order = OVAEM_Settings::search_event_order();
         $search_event_order = isset($search_event_order) ? $search_event_order : 'ASC';

         $asc_selected = ('ASC' == $search_event_order) ? 'selected' : '';
         $desc_selected = ('DESC' == $search_event_order) ? 'selected' : '';

         $html = '<select  name="ovaem_options[search_event_order]">';
         $html .= '<option ' . $asc_selected . ' value="ASC">' . esc_html__('Increase', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $desc_selected . ' value="DESC">' . esc_html__('Decrease', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function list_speakers_orderby() {

         $prefix = OVAEM_Settings::$prefix;

         $list_speakers_orderby = OVAEM_Settings::list_speakers_orderby();
         $list_speakers_orderby = isset($list_speakers_orderby) ? $list_speakers_orderby : $prefix . '_speaker_order';

         $date_order = $prefix . '_speaker_order';
         $date_created = 'date';

         $date_order_selected = ($date_order == $list_speakers_orderby) ? 'selected' : '';
         $date_created_selected = ($date_created == $list_speakers_orderby) ? 'selected' : '';
         $title_selected = $list_speakers_orderby == 'title' ? 'selected' : '';
         $id_selected = $list_speakers_orderby == 'ID' ? 'selected' : '';

         $html = '<select  name="ovaem_options[list_speakers_orderby]">';
         $html .= '<option ' . $date_order_selected . ' value="' . $date_order . '">' . esc_html__('Order Field in event attribute', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_created_selected . ' value="' . $date_created . '">' . esc_html__('Created Date', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $title_selected . ' value="title">' . esc_html__('Title', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $id_selected . ' value="ID">' . esc_html__('ID', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);
      }

      public function list_speakers_order() {
         $list_speakers_order = OVAEM_Settings::list_speakers_order();
         $list_speakers_order = isset($list_speakers_order) ? $list_speakers_order : 'ASC';

         $asc_selected = ('ASC' == $list_speakers_order) ? 'selected' : '';
         $desc_selected = ('DESC' == $list_speakers_order) ? 'selected' : '';

         $html = '<select  name="ovaem_options[list_speakers_order]">';
         $html .= '<option ' . $asc_selected . ' value="ASC">' . esc_html__('Increase', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $desc_selected . ' value="DESC">' . esc_html__('Decrease', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function speaker_joined_event_show() {
         $speaker_joined_event_show = OVAEM_Settings::speaker_joined_event_show();
         $speaker_joined_event_show = isset($speaker_joined_event_show) ? $speaker_joined_event_show : 'true';

         $true = ('true' == $speaker_joined_event_show) ? 'selected' : '';
         $false = ('false' == $speaker_joined_event_show) ? 'selected' : '';

         $html = '<select  name="ovaem_options[speaker_joined_event_show]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function speaker_joined_event_show_past() {
         $speaker_joined_event_show_past = OVAEM_Settings::speaker_joined_event_show_past();
         $speaker_joined_event_show_past = isset($speaker_joined_event_show_past) ? $speaker_joined_event_show_past : 'true';

         $true = ('true' == $speaker_joined_event_show_past) ? 'selected' : '';
         $false = ('false' == $speaker_joined_event_show_past) ? 'selected' : '';

         $html = '<select  name="ovaem_options[speaker_joined_event_show_past]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function speaker_joined_event_show_current() {
         $speaker_joined_event_show_current = OVAEM_Settings::speaker_joined_event_show_current();
         $speaker_joined_event_show_current = isset($speaker_joined_event_show_current) ? $speaker_joined_event_show_current : 'true';

         $true = ('true' == $speaker_joined_event_show_current) ? 'selected' : '';
         $false = ('false' == $speaker_joined_event_show_current) ? 'selected' : '';

         $html = '<select  name="ovaem_options[speaker_joined_event_show_current]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function speaker_joined_event_orderby() {
         $speaker_joined_event_orderby = OVAEM_Settings::speaker_joined_event_orderby();
         $speaker_joined_event_orderby = isset($speaker_joined_event_orderby) ? $speaker_joined_event_orderby : OVAEM_Settings::$prefix . '_date_start_time';

         $prefix = OVAEM_Settings::$prefix;

         $date_start_time = $prefix . '_date_start_time';
         $date_end_time = $prefix . '_date_end_time';
         $date_order = $prefix . '_order';
         $date_created = 'date';

         $date_start_time_selected = ($date_start_time == $speaker_joined_event_orderby) ? 'selected' : '';
         $date_end_time_selected = ($date_end_time == $speaker_joined_event_orderby) ? 'selected' : '';
         $date_order_selected = ($date_order == $speaker_joined_event_orderby) ? 'selected' : '';
         $date_created_selected = ($date_created == $speaker_joined_event_orderby) ? 'selected' : '';

         $html = '<select  name="ovaem_options[speaker_joined_event_orderby]">';
         $html .= '<option ' . $date_start_time_selected . ' value="' . $date_start_time . '">' . esc_html__('Start Time', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_end_time_selected . ' value="' . $date_end_time . '">' . esc_html__('End Time', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_order_selected . ' value="' . $date_order . '">' . esc_html__('Order Field in event attribute', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_created_selected . ' value="' . $date_created . '">' . esc_html__('Created Date', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function speaker_joined_event_order() {
         $speaker_joined_event_order = OVAEM_Settings::speaker_joined_event_order();
         $speaker_joined_event_order = isset($speaker_joined_event_order) ? $speaker_joined_event_order : 'ASC';

         $asc_selected = ('ASC' == $speaker_joined_event_order) ? 'selected' : '';
         $desc_selected = ('DESC' == $speaker_joined_event_order) ? 'selected' : '';

         $html = '<select  name="ovaem_options[speaker_joined_event_order]">';
         $html .= '<option ' . $asc_selected . ' value="ASC">' . esc_html__('Increase', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $desc_selected . ' value="DESC">' . esc_html__('Decrease', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function speaker_joined_event_count() {
         $speaker_joined_event_count = esc_attr(OVAEM_Settings::speaker_joined_event_count());
         printf(
            '<input type="text" id="speaker_joined_event_count" placeholder="' . esc_html__('Insert Number', 'ovaem-events-manager') . '" name="ovaem_options[speaker_joined_event_count]" value="%s" />',
            isset($speaker_joined_event_count) ? $speaker_joined_event_count : '100'
         );
         esc_html_e('Insert -1 to display all', 'ovaem-events-manager');
      }

       public function login_before_booking() {
         $login_before_booking = OVAEM_Settings::login_before_booking();
         $login_before_booking = isset($login_before_booking) ? $login_before_booking : 'no';

         $no_selected = ('no' == $login_before_booking) ? 'selected' : '';
         $yes_selected = ('yes' == $login_before_booking) ? 'selected' : '';

         $html = '<select  name="ovaem_options[login_before_booking]">';
         $html .= '<option ' . $no_selected . ' value="no">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $yes_selected . ' value="yes">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function ticket_free_max_number() {
         $ticket_free_max_number = esc_attr(OVAEM_Settings::ticket_free_max_number());
         printf(
            '<input type="text" id="ticket_free_max_number" placeholder="' . esc_html__('Insert Number', 'ovaem-events-manager') . '" name="ovaem_options[ticket_free_max_number]" value="%s" />',
            isset($ticket_free_max_number) ? $ticket_free_max_number : '10'
         );
      }

      public function thanks_page() {
         $thanks_page = esc_attr(OVAEM_Settings::thanks_page());

         $list_pages = get_pages();

         $thanks_page = isset($thanks_page) ? $thanks_page : '';

         $html = '<select name="ovaem_options[thanks_page]">';
         $html .= '<option value="">' . esc_html('- - - - - - - - -', 'ovaem-events-manager') . '</option>';
         foreach ($list_pages as $key => $value) {
            $selected = ($thanks_page == home_url('/?page_id=' . $value->ID)) ? 'selected' : '';
            $html .= '<option value="' . home_url('/?page_id=' . $value->ID) . '" ' . $selected . '>' . $value->post_title . '</option>';
         }

         $html .= '</select>';

         print($html);

      }

      public function woo_make_ticket_verify() {

         $woo_make_ticket_verify = OVAEM_Settings::woo_make_ticket_verify();
         $woo_make_ticket_verify = isset($woo_make_ticket_verify) ? $woo_make_ticket_verify : array(0 => array('wc-completed', 'wc-on-hold'));
         $selected_completed = in_array('wc-completed', $woo_make_ticket_verify[0]) ? 'selected' : '';
         $selected_hold = in_array('wc-on-hold', $woo_make_ticket_verify[0]) ? 'selected' : '';
         $selected_pending = in_array('wc-pending', $woo_make_ticket_verify[0]) ? 'selected' : '';
         $selected_processing = in_array('wc-processing', $woo_make_ticket_verify[0]) ? 'selected' : '';

         $html = '<select class="multiple-select" multiple name="ovaem_options[woo_make_ticket_verify][]">';

         $html .= '<option value="">' . esc_html__('- - - - - - -', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_completed . ' value="wc-completed">' . esc_html__('Completed', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_hold . ' value="wc-on-hold">' . esc_html__('On hold', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_pending . ' value="wc-pending">' . esc_html__('Pending', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_processing . ' value="wc-processing">' . esc_html__('Processing', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         $html .= '<span>' . esc_html__('If ticket isn\'t verify, the client can\'t receive PDF ticket in mail but the ticket still save in database', 'ovaem-events-manager') . '</span>';

         print($html);

      }

      public function mail_to() {

         $mail_to = OVAEM_Settings::mail_to();
         $mail_to = isset($mail_to) ? $mail_to : array(0 => array('admin', 'client'));
         $selected_admin = in_array('admin', $mail_to[0]) ? 'selected' : '';
         $selected_client = in_array('client', $mail_to[0]) ? 'selected' : '';
         $selected_organizer = in_array('organizer', $mail_to[0]) ? 'selected' : '';

         $html = '<select multiple name="ovaem_options[mail_to][]">';

         $html .= '<option value="">' . esc_html__('- - - - - - -', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_admin . ' value="admin">' . esc_html__('Admin', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_client . ' value="client">' . esc_html__('Attendees', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_organizer . ' value="organizer">' . esc_html__('Organizer', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function paid_ticket_mail_to() {

         $paid_ticket_mail_to = OVAEM_Settings::paid_ticket_mail_to();
         $paid_ticket_mail_to = isset($paid_ticket_mail_to) ? $paid_ticket_mail_to : array(0 => array('admin', 'client'));
         $selected_admin = in_array('admin', $paid_ticket_mail_to[0]) ? 'selected' : '';
         $selected_client = in_array('client', $paid_ticket_mail_to[0]) ? 'selected' : '';
         $selected_organizer = in_array('organizer', $paid_ticket_mail_to[0]) ? 'selected' : '';

         $html = '<select multiple name="ovaem_options[paid_ticket_mail_to][]">';

         $html .= '<option value="">' . esc_html__('- - - - - - -', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_admin . ' value="admin">' . esc_html__('Admin', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_client . ' value="client">' . esc_html__('Attendees', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $selected_organizer . ' value="organizer">' . esc_html__('Organizer', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function mail_template() {
         $mail_template = esc_attr(OVAEM_Settings::mail_template());
         printf(
            '<textarea id="mail_template" cols="90" rows="10" name="ovaem_options[mail_template]">%s</textarea>',
            isset($mail_template) ? $mail_template : '
				Event: [event]
				Order ID: [orderid]
				Name: [name]
				Phone: [phone]
				Email: [email]
				Address: [address]
				Company: [company]
				Additional Info: [addition]
				'
         );
         echo '<br/>You can use some format: [event], [name], [orderid], [phone], [email], [address], [company], [number], [addition]<br/> Example: <br/>Event Name: [event] &#x3C;br/&#x3E; <br/>
			Order ID: [orderid]  &#x3C;br/&#x3E;<br/>
			Name: [name]  &#x3C;br/&#x3E;<br/>
			Phone: [phone] &#x3C;br/&#x3E;<br/>
			Email: [email] &#x3C;br/&#x3E; <br/>
			Address: [address] &#x3C;br/&#x3E;<br/>
			Company: [company] &#x3C;br/&#x3E;<br/>
			Number: [number] &#x3C;br/&#x3E;<br/>
			Addition: [addition] &#x3C;br/&#x3E;<br/>
			';
      }

      public function paid_ticket_mail_template() {
         $paid_ticket_mail_template = esc_attr(OVAEM_Settings::paid_ticket_mail_template());
         printf(
            '<textarea id="paid_ticket_mail_template" cols="90" rows="10" name="ovaem_options[paid_ticket_mail_template]">%s</textarea>',
            isset($paid_ticket_mail_template) ? $paid_ticket_mail_template : '
				Order ID: [orderid]
				Name: [name]
				Phone: [phone]
				Email: [email]
				Address: [address]
				Company: [company]
				Additional Info: [addition]
				Transaction ID: [transaction_id]
				Cart: [cart]
				'
         );
         echo '<br/>You can use some format: [name], [orderid], [phone], [email], [address], [company], [addition], [transaction_id], [cart]<br/> Example: <br/>
			Order ID: [orderid]  &#x3C;br/&#x3E;<br/>
			Name: [name]  &#x3C;br/&#x3E;<br/>
			Phone: [phone] &#x3C;br/&#x3E;<br/>
			Email: [email] &#x3C;br/&#x3E; <br/>
			Address: [address] &#x3C;br/&#x3E;<br/>
			Company: [company] &#x3C;br/&#x3E;<br/>
			Addition: [addition] &#x3C;br/&#x3E;<br/>
			Transaction ID: [transaction_id] &#x3C;br/&#x3E;<br/>
			Cart: [cart] &#x3C;br/&#x3E;<br/>
			';
      }

      public function cart_page() {
         $cart_page = esc_attr(OVAEM_Settings::cart_page());

         $list_pages = get_pages();

         $cart_page = isset($cart_page) ? $cart_page : '';

         $html = '<select name="ovaem_options[cart_page]">';
         $html .= '<option value="">' . esc_html('- - - - - - - - -', 'ovaem-events-manager') . '</option>';
         foreach ($list_pages as $key => $value) {
            $selected = ($cart_page == home_url('/?page_id=' . $value->ID)) ? 'selected' : '';
            $html .= '<option value="' . home_url('/?page_id=' . $value->ID) . '" ' . $selected . '>' . $value->post_title . '</option>';
         }

         $html .= '</select>';

         print($html);

      }

      public function checkout_page() {
         $checkout_page = esc_attr(OVAEM_Settings::checkout_page());

         $list_pages = get_pages();

         $checkout_page = isset($checkout_page) ? $checkout_page : '';

         $html = '<select name="ovaem_options[checkout_page]">';
         $html .= '<option value="">' . esc_html('- - - - - - - - -', 'ovaem-events-manager') . '</option>';
         foreach ($list_pages as $key => $value) {
            $selected = ($checkout_page == home_url('/?page_id=' . $value->ID)) ? 'selected' : '';
            $html .= '<option value="' . home_url('/?page_id=' . $value->ID) . '" ' . $selected . '>' . $value->post_title . '</option>';
         }

         $html .= '</select>';

         print($html);

      }

      public function checkout_cancel_page() {
         $checkout_cancel_page = esc_attr(OVAEM_Settings::checkout_cancel_page());

         $list_pages = get_pages();

         $checkout_cancel_page = isset($checkout_cancel_page) ? $checkout_cancel_page : '';

         $html = '<select name="ovaem_options[checkout_cancel_page]">';
         $html .= '<option value="">' . esc_html('- - - - - - - - -', 'ovaem-events-manager') . '</option>';
         foreach ($list_pages as $key => $value) {
            $selected = ($checkout_cancel_page == home_url('/?page_id=' . $value->ID)) ? 'selected' : '';
            $html .= '<option value="' . home_url('/?page_id=' . $value->ID) . '" ' . $selected . '>' . $value->post_title . '</option>';
         }

         $html .= '</select>';

         print($html);

      }

      public function terms_conditions_page() {
         $terms_conditions_page = esc_attr(OVAEM_Settings::terms_conditions_page());

         $list_pages = get_pages();

         $terms_conditions_page = isset($terms_conditions_page) ? $terms_conditions_page : '';

         $html = '<select name="ovaem_options[terms_conditions_page]">';
         $html .= '<option value="">' . esc_html('- - - - - - - - -', 'ovaem-events-manager') . '</option>';
         foreach ($list_pages as $key => $value) {
            $selected = ($terms_conditions_page == home_url('/?page_id=' . $value->ID)) ? 'selected' : '';
            $html .= '<option value="' . home_url('/?page_id=' . $value->ID) . '" ' . $selected . '>' . $value->post_title . '</option>';
         }

         $html .= '</select>';

         print($html);

      }

      public function checkout_payment_default() {
         $checkout_payment_default = esc_attr(OVAEM_Settings::checkout_payment_default());

         $html = '<select name="ovaem_options[checkout_payment_default]">';

         $selected_offline = ($checkout_payment_default == 'offline') ? 'selected' : '';
         $selected_paypal = ($checkout_payment_default == 'paypal') ? 'selected' : '';
         $selected_stripe = ($checkout_payment_default == 'stripe') ? 'selected' : '';

         $html .= '<option value="offline" ' . $selected_offline . '>' . esc_html__('Offline Payment', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="paypal" ' . $selected_paypal . '>' . esc_html__('Paypal', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="stripe" ' . $selected_stripe . '>' . esc_html__('Stripe', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function paypal_envi() {
         $paypal_envi = esc_attr(OVAEM_Settings::paypal_envi());

         $html = '<select name="ovaem_options[paypal_envi]">';

         $selected_live = ($paypal_envi == 'live') ? 'selected' : '';
         $selected_sandbox = ($paypal_envi == 'sandbox') ? 'selected' : '';

         $html .= '<option value="live" ' . $selected_live . '>' . esc_html__('Live', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="sandbox" ' . $selected_sandbox . '>' . esc_html__('Sandbox', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }
      public function paypal_save_log() {
         $paypal_save_log = esc_attr(OVAEM_Settings::paypal_save_log());

         $html = '<select name="ovaem_options[paypal_save_log]">';

         $selected_false = ($paypal_save_log == 'false') ? 'selected' : '';
         $selected_true = ($paypal_save_log == 'true') ? 'selected' : '';

         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function offline_payment_use() {
         $offline_payment_use = esc_attr(OVAEM_Settings::offline_payment_use());

         $html = '<select name="ovaem_options[offline_payment_use]">';

         $selected_true = ($offline_payment_use == 'true') ? 'selected' : '';
         $selected_false = ($offline_payment_use == 'false') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }
      public function offline_payment_verify_ticket() {
         $offline_payment_verify_ticket = esc_attr(OVAEM_Settings::offline_payment_verify_ticket());

         $html = '<select name="ovaem_options[offline_payment_verify_ticket]">';

         $selected_true = ($offline_payment_verify_ticket == 'true') ? 'selected' : '';
         $selected_false = ($offline_payment_verify_ticket == 'false') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function pdf_ticket_logo() {

         // Set variables
         $pdf_ticket_logo_id = OVAEM_Settings::pdf_ticket_logo();

         $value = '';
         if ($pdf_ticket_logo_id) {
            $image_attributes = wp_get_attachment_image_src($pdf_ticket_logo_id, 'medium');
            $src = $image_attributes[0];
            $value = $pdf_ticket_logo_id;
         }

         $text = __('Upload', 'ovaem-events-manager');

         $html = '<div class="upload">';

         if ($pdf_ticket_logo_id) {
            $html .= '<img data-src="' . $src . '" src="' . $src . '" width="100px"/>';
         }

         $html .= '<span>' . esc_html__('You can override this logo by upload logo per event', 'ovaem-events-manager') . '</span>
			<div>
			<input type="hidden" name="ovaem_options[pdf_ticket_logo]" id="pdf_ticket_logo" value="' . $value . '" />
			<button type="submit" class="upload_image_button button">' . $text . '</button>
			<button type="submit" class="remove_image_button button">&times;</button>
			</div>
			</div>
			';
         print($html);
      }

      public function pdf_ticket_template() {

         $pdf_ticket_template = esc_attr(OVAEM_Settings::pdf_ticket_template());
         $version1 = ($pdf_ticket_template == 'version1') ? 'checked' : '';
         $version2 = ($pdf_ticket_template == 'version2') ? 'checked' : '';

         $html = '<input type="radio" name="ovaem_options[pdf_ticket_template]" value="version1" ' . $version1 . ' />' . esc_html__('Version 1', 'ovaem-events-manager') . '<br/><img style="border: 1px solid #ccc" width="350" src="' . OVAEM_PLUGIN_URI . '/assets/img/Version1.jpg" />';

         $html .= '<br/><br/><br/><input type="radio" name="ovaem_options[pdf_ticket_template]" value="version2" ' . $version2 . ' />' . esc_html__('Version 2', 'ovaem-events-manager') . '<br/><img width="350" src="' . OVAEM_PLUGIN_URI . '/assets/img/Version2.jpg" />';

         print($html);

      }

      public function pdf_ticket_show_logo() {
         $pdf_ticket_show_logo = esc_attr(OVAEM_Settings::pdf_ticket_show_logo());

         $html = '<select name="ovaem_options[pdf_ticket_show_logo]">';

         $selected_false = ($pdf_ticket_show_logo == 'false') ? 'selected' : '';
         $selected_true = ($pdf_ticket_show_logo == 'true') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function pdf_ticket_show_time() {
         $pdf_ticket_show_time = esc_attr(OVAEM_Settings::pdf_ticket_show_time());

         $html = '<select name="ovaem_options[pdf_ticket_show_time]">';

         $selected_false = ($pdf_ticket_show_time == 'false') ? 'selected' : '';
         $selected_true = ($pdf_ticket_show_time == 'true') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function event_mail_attachment() {
         $event_mail_attachment = esc_attr(OVAEM_Settings::event_mail_attachment());

         $html = '<select name="ovaem_options[event_mail_attachment]">';

         $event_mail_attachment_qr = ($event_mail_attachment == 'qr') ? 'selected' : '';
         $event_mail_attachment_pdf = ($event_mail_attachment == 'pdf') ? 'selected' : '';
         $event_mail_attachment_both = ($event_mail_attachment == 'both') ? 'selected' : '';
         $event_mail_attachment_none = ($event_mail_attachment == 'none') ? 'selected' : '';

         $html .= '<option value="qr" ' . $event_mail_attachment_qr . '>' . esc_html__('QR Code File', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="pdf" ' . $event_mail_attachment_pdf . '>' . esc_html__('PDF Ticket File', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="both" ' . $event_mail_attachment_both . '>' . esc_html__('Both: QR Code & PDF Ticket', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="none" ' . $event_mail_attachment_none . '>' . esc_html__('None', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function event_file_cer_attachment() {
         $event_file_cer_attachment = esc_attr(OVAEM_Settings::event_file_cer_attachment());

         $html = '<select name="ovaem_options[event_file_cer_attachment]">';

         $yes = ($event_file_cer_attachment == 'yes') ? 'selected' : '';
         $no = ($event_file_cer_attachment == 'no') ? 'selected' : '';

         $html .= '<option value="yes" ' . $yes . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="no" ' . $no . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

     

     

      public function pdf_ticket_show_order_id() {
         $pdf_ticket_show_order_id = esc_attr(OVAEM_Settings::pdf_ticket_show_order_id());

         $html = '<select name="ovaem_options[pdf_ticket_show_order_id]">';

         $selected_true = ($pdf_ticket_show_order_id == 'true') ? 'selected' : '';
         $selected_false = ($pdf_ticket_show_order_id == 'false') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function pdf_ticket_show_order_time() {
         $pdf_ticket_show_order_time = esc_attr(OVAEM_Settings::pdf_ticket_show_order_time());

         $html = '<select name="ovaem_options[pdf_ticket_show_order_time]">';

         $selected_true = ($pdf_ticket_show_order_time == 'true') ? 'selected' : '';
         $selected_false = ($pdf_ticket_show_order_time == 'false') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function pdf_ticket_show_venue() {
         $pdf_ticket_show_venue = esc_attr(OVAEM_Settings::pdf_ticket_show_venue());

         $html = '<select name="ovaem_options[pdf_ticket_show_venue]">';

         $selected_false = ($pdf_ticket_show_venue == 'false') ? 'selected' : '';
         $selected_true = ($pdf_ticket_show_venue == 'true') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }
      public function pdf_ticket_show_adress() {
         $pdf_ticket_show_adress = esc_attr(OVAEM_Settings::pdf_ticket_show_adress());

         $html = '<select name="ovaem_options[pdf_ticket_show_adress]">';

         $selected_false = ($pdf_ticket_show_adress == 'false') ? 'selected' : '';
         $selected_true = ($pdf_ticket_show_adress == 'true') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }
      public function pdf_ticket_show_code() {
         $pdf_ticket_show_code = esc_attr(OVAEM_Settings::pdf_ticket_show_code());

         $html = '<select name="ovaem_options[pdf_ticket_show_code]">';

         $selected_false = ($pdf_ticket_show_code == 'false') ? 'selected' : '';
         $selected_true = ($pdf_ticket_show_code == 'true') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }
      public function pdf_ticket_show_holder_ticket() {
         $pdf_ticket_show_holder_ticket = esc_attr(OVAEM_Settings::pdf_ticket_show_holder_ticket());

         $html = '<select name="ovaem_options[pdf_ticket_show_holder_ticket]">';

         $selected_false = ($pdf_ticket_show_holder_ticket == 'false') ? 'selected' : '';
         $selected_true = ($pdf_ticket_show_holder_ticket == 'true') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }
      public function pdf_ticket_show_qrcode() {
         $pdf_ticket_show_qrcode = esc_attr(OVAEM_Settings::pdf_ticket_show_qrcode());

         $html = '<select name="ovaem_options[pdf_ticket_show_qrcode]">';

         $selected_false = ($pdf_ticket_show_qrcode == 'false') ? 'selected' : '';
         $selected_true = ($pdf_ticket_show_qrcode == 'true') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function pdf_ticket_format_qr() {
         $pdf_ticket_format_qr = esc_attr(OVAEM_Settings::pdf_ticket_format_qr());

         $html = '<select name="ovaem_options[pdf_ticket_format_qr]">';

         $selected_code = ($pdf_ticket_format_qr == 'code') ? 'selected' : '';
         $selected_url = ($pdf_ticket_format_qr == 'url') ? 'selected' : '';

         $html .= '<option value="url" ' . $selected_url . '>' . esc_html__('Url', 'ovaem-events-manager') . '</option>';

         $html .= '<option value="code" ' . $selected_code . '>' . esc_html__('Code', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function pdf_ticket_show_package() {
         $pdf_ticket_show_package = esc_attr(OVAEM_Settings::pdf_ticket_show_package());

         $html = '<select name="ovaem_options[pdf_ticket_show_package]">';

         $selected_false = ($pdf_ticket_show_package == 'false') ? 'selected' : '';
         $selected_true = ($pdf_ticket_show_package == 'true') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function pdf_ticket_event_fontsize() {
         $pdf_ticket_event_fontsize = esc_attr(OVAEM_Settings::pdf_ticket_event_fontsize());
         printf(
            '<input type="text" id="pdf_ticket_event_fontsize" name="ovaem_options[pdf_ticket_event_fontsize]" value="%s" />',
            isset($pdf_ticket_event_fontsize) ? $pdf_ticket_event_fontsize : '18'
         );
         echo '&nbsp;&nbsp;<span>' . esc_html__('Default: 18') . '</span>';
      }



      public function pdf_ticket_label_fontsize() {
         $pdf_ticket_label_fontsize = esc_attr(OVAEM_Settings::pdf_ticket_label_fontsize());
         printf(
            '<input type="text" id="pdf_ticket_label_fontsize" name="ovaem_options[pdf_ticket_label_fontsize]" value="%s" />',
            isset($pdf_ticket_label_fontsize) ? $pdf_ticket_label_fontsize : '12'
         );
         echo '&nbsp;&nbsp;<span>' . esc_html__('Default: 12. Min 11') . '</span>';
      }

      public function pdf_ticket_label_color() {
         $pdf_ticket_label_color = esc_attr(OVAEM_Settings::pdf_ticket_label_color());
         printf(
            '<input type="text" id="pdf_ticket_label_color" name="ovaem_options[pdf_ticket_label_color]" value="%s" />',
            isset($pdf_ticket_label_color) ? $pdf_ticket_label_color : '#333333'
         );
         echo '&nbsp;&nbsp;<span>' . esc_html__('Example: #333333', 'ovaem-events-manager') . '</span>';
      }

      public function pdf_ticket_text_color() {
         $pdf_ticket_text_color = esc_attr(OVAEM_Settings::pdf_ticket_text_color());
         printf(
            '<input type="text" id="pdf_ticket_text_color" name="ovaem_options[pdf_ticket_text_color]" value="%s" />',
            isset($pdf_ticket_text_color) ? $pdf_ticket_text_color : '#555555'
         );
         echo '&nbsp;&nbsp;<span>' . esc_html__('Example: #333333', 'ovaem-events-manager') . '</span>';
      }

      public function pdf_ticket_text_fontsize() {
         $pdf_ticket_text_fontsize = esc_attr(OVAEM_Settings::pdf_ticket_text_fontsize());
         printf(
            '<input type="text" id="pdf_ticket_text_fontsize" name="ovaem_options[pdf_ticket_text_fontsize]" value="%s" />',
            isset($pdf_ticket_text_fontsize) ? $pdf_ticket_text_fontsize : '12'
         );
         echo '&nbsp;&nbsp;<span>' . esc_html__('Default: 12') . '</span>';
      }

      public function user_submit_admin_review() {
         $user_submit_admin_review = esc_attr(OVAEM_Settings::user_submit_admin_review());

         $html = '<select name="ovaem_options[user_submit_admin_review]">';

         $selected_true = ($user_submit_admin_review == 'true') ? 'selected' : '';
         $selected_false = ($user_submit_admin_review == 'false') ? 'selected' : '';

         $html .= '<option value="true" ' . $selected_true . '>' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option value="false" ' . $selected_false . '>' . esc_html__('No', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function captcha_type() {
         $captcha_type = esc_attr(OVAEM_Settings::captcha_type());
         ?>
         <label for="recapcha_v2"><input name="ovaem_options[captcha_type]" <?php checked( $captcha_type, 'v2'); ?> type="radio" id="recapcha_v2" value="v2">V2</label>
         <label for="recapcha_v3"><input name="ovaem_options[captcha_type]" <?php checked( $captcha_type, 'v3'); ?> type="radio" id="recapcha_v3" value="v3">V3</label>
         <?php
      }

      public function captcha_sitekey() {
         $captcha_sitekey = esc_attr(OVAEM_Settings::captcha_sitekey());
         printf(
            '<input type="text" id="captcha_sitekey" name="ovaem_options[captcha_sitekey]" value="%s" />',
            isset($captcha_sitekey) ? $captcha_sitekey : ''
         );
         echo '&nbsp;&nbsp;<span>' . esc_html__('Go to https://www.google.com/recaptcha/admin to make captcha') . '</span>';
      }

      public function captcha_serectkey() {
         $captcha_serectkey = esc_attr(OVAEM_Settings::captcha_serectkey());
         printf(
            '<input type="text" id="captcha_serectkey" name="ovaem_options[captcha_serectkey]" value="%s" />',
            isset($captcha_serectkey) ? $captcha_serectkey : ''
         );
         echo '&nbsp;&nbsp;<span>' . esc_html__('Go to https://www.google.com/recaptcha/admin to make captcha') . '</span>';
      }

      public function enable_for_login() {
         $enable_for_login = esc_attr(OVAEM_Settings::enable_for_login());
         ?>
         <label for="enable_for_login"><input name="ovaem_options[enable_for_login]" <?php checked( $enable_for_login, '1'); ?> type="checkbox" id="enable_for_login" value="1"></label>
         <?php
      }

      public function enable_for_register() {
         $enable_for_register = esc_attr(OVAEM_Settings::enable_for_register());
         ?>
         <label for="enable_for_register"><input name="ovaem_options[enable_for_register]" <?php checked( $enable_for_register, '1'); ?> type="checkbox" id="enable_for_register" value="1"></label>
         <?php
      }

      public function enable_for_lost_password() {
         $enable_for_lost_password = esc_attr(OVAEM_Settings::enable_for_lost_password());
         ?>
         <label for="enable_for_lost_password"><input name="ovaem_options[enable_for_lost_password]" <?php checked( $enable_for_lost_password, '1'); ?> type="checkbox" id="enable_for_lost_password" value="1"></label>
         <?php
      }

      public function enable_for_comment() {
         $enable_for_comment = esc_attr(OVAEM_Settings::enable_for_comment());
         ?>
         <label for="enable_for_comment"><input name="ovaem_options[enable_for_comment]" <?php checked( $enable_for_comment, '1'); ?> type="checkbox" id="enable_for_comment" value="1"></label>
         <?php
      }

      public function enable_register_event() {
         $enable_register_event = esc_attr(OVAEM_Settings::enable_register_event());
         ?>
         <label for="enable_register_event"><input name="ovaem_options[enable_register_event]" <?php checked( $enable_register_event, '1'); ?> type="checkbox" id="enable_register_event" value="1"></label>
         <?php
      }

      public function enable_woo_checkout() {
         $enable_woo_checkout = esc_attr(OVAEM_Settings::enable_woo_checkout());
         ?>
         <label for="enable_woo_checkout"><input name="ovaem_options[enable_woo_checkout]" <?php checked( $enable_woo_checkout, '1'); ?> type="checkbox" id="enable_woo_checkout" value="1"></label>
         <?php
      }
      
      public function enable_event_checkout() {
         $enable_event_checkout = esc_attr(OVAEM_Settings::enable_event_checkout());
         ?>
         <label for="enable_event_checkout"><input name="ovaem_options[enable_event_checkout]" <?php checked( $enable_event_checkout, '1'); ?> type="checkbox" id="enable_event_checkout" value="1"></label>
         <?php
      }
      
      public function enable_event_free() {
         $enable_event_free = esc_attr(OVAEM_Settings::enable_event_free());
         ?>
         <label for="enable_event_free"><input name="ovaem_options[enable_event_free]" <?php checked( $enable_event_free, '1'); ?> type="checkbox" id="enable_event_free" value="1"></label>
         <?php
      }
      
      public function enable_event_cfc_checkout() {
         $enable_event_cfc_checkout = esc_attr(OVAEM_Settings::enable_event_cfc_checkout());
         ?>
         <label for="enable_event_cfc_checkout"><input name="ovaem_options[enable_event_cfc_checkout]" <?php checked( $enable_event_cfc_checkout, '1'); ?> type="checkbox" id="enable_event_cfc_checkout" value="1"></label>
         <?php
      }
      
      public function enable_event_cfc_woo_checkout() {
         $enable_event_cfc_woo_checkout = esc_attr(OVAEM_Settings::enable_event_cfc_woo_checkout());
         ?>
         <label for="enable_event_cfc_woo_checkout"><input name="ovaem_options[enable_event_cfc_woo_checkout]" <?php checked( $enable_event_cfc_woo_checkout, '1'); ?> type="checkbox" id="enable_event_cfc_woo_checkout" value="1"></label>
         <?php
      }

      public function paypal_busi_email() {
         $paypal_busi_email = esc_attr(OVAEM_Settings::paypal_busi_email());

         printf(
            '<input type="text" id="paypal_busi_email" placeholder="' . esc_html__('your_email@mail.com', 'ovaem-events-manager') . '" name="ovaem_options[paypal_busi_email]" value="%s" />',
            isset($paypal_busi_email) ? $paypal_busi_email : ''
         );

      }

      public function paypal_info() {
         $paypal_info = esc_attr(OVAEM_Settings::paypal_info());

         printf(
            '<input type="text" size="50" id="paypal_info" placeholder="' . esc_html__('Pay via PayPal: you can pay with your credit card if you don’t have a PayPal account.', 'ovaem-events-manager') . '" name="ovaem_options[paypal_info]" value="%s" />',
            isset($paypal_info) ? $paypal_info : ''
         );

      }

      public function paypal_cur() {
         $paypal_cur = esc_attr(OVAEM_Settings::paypal_cur());

         printf(
            '<input type="text" size="50" id="paypal_cur" placeholder="USD" name="ovaem_options[paypal_cur]" value="%s" />',
            isset($paypal_cur) ? $paypal_cur : ''
         );

      }

      public function stripe_info() {
         $stripe_info = esc_attr(OVAEM_Settings::stripe_info());

         printf(
            '<input type="text" size="50" id="stripe_info" placeholder="' . esc_html__('You can pay with your credit card', 'ovaem-events-manager') . '" name="ovaem_options[stripe_info]" value="%s" />',
            isset($stripe_info) ? $stripe_info : ''
         );

      }

      public function offline_payment_info() {
         $offline_payment_info = esc_attr(OVAEM_Settings::offline_payment_info());

         printf(
            '<input type="text" size="50" id="offline_payment_info" placeholder="' . esc_html__('In Admin: You can config allow to send ticket after checkout successfully.', 'ovaem-events-manager') . '" name="ovaem_options[offline_payment_info]" value="%s" />',
            isset($offline_payment_info) ? $offline_payment_info : ''
         );

      }

      public function stripe_payment_public_key() {
         $stripe_payment_public_key = esc_attr(OVAEM_Settings::stripe_payment_public_key());

         printf(
            '<input type="text" size="50" id="stripe_payment_public_key" placeholder="' . esc_html__('Public Key', 'ovaem-events-manager') . '" name="ovaem_options[stripe_payment_public_key]" value="%s" />',
            isset($stripe_payment_public_key) ? $stripe_payment_public_key : ''
         );

      }

      public function stripe_payment_serect_key() {
         $stripe_payment_serect_key = esc_attr(OVAEM_Settings::stripe_payment_serect_key());

         printf(
            '<input type="text" size="50" id="stripe_payment_serect_key" placeholder="' . esc_html__('Serect Key', 'ovaem-events-manager') . '" name="ovaem_options[stripe_payment_serect_key]" value="%s" />',
            isset($stripe_payment_serect_key) ? $stripe_payment_serect_key : ''
         );

      }

      public function stripe_payment_currency() {
         $stripe_payment_currency = esc_attr(OVAEM_Settings::stripe_payment_currency());

         printf(
            '<input type="text" size="50" id="stripe_payment_currency" placeholder="' . esc_html__('Insert Currency', 'ovaem-events-manager') . '" name="ovaem_options[stripe_payment_currency]" value="%s" />',
            isset($stripe_payment_currency) ? $stripe_payment_currency : ''
         );
         esc_html_e('Like USD', 'ovaem-events-manager');

      }

      public function user_manage_event_page() {
         $user_manage_event_page = esc_attr(OVAEM_Settings::user_manage_event_page());

         $list_pages = get_pages();

         $user_manage_event_page = isset($user_manage_event_page) ? $user_manage_event_page : '';

         $html = '<select name="ovaem_options[user_manage_event_page]">';
         $html .= '<option value="">' . esc_html('- - - - - - - - -', 'ovaem-events-manager') . '</option>';
         foreach ($list_pages as $key => $value) {
            $selected = ($user_manage_event_page == home_url('/?page_id=' . $value->ID)) ? 'selected' : '';
            $html .= '<option value="' . home_url('/?page_id=' . $value->ID) . '" ' . $selected . '>' . $value->post_title . '</option>';
         }

         $html .= '</select>';

         print($html);

      }

      public function frontend_submit_limit_gallery() {
         $frontend_submit_limit_gallery = esc_attr(OVAEM_Settings::frontend_submit_limit_gallery());
         printf(
            '<input type="text" id="frontend_submit_limit_gallery" placeholder="4" name="ovaem_options[frontend_submit_limit_gallery]"  value="%s" />',
            isset($frontend_submit_limit_gallery) ? $frontend_submit_limit_gallery : '4'
         );
      }

      public function frontend_submit_limit_tags() {
         $frontend_submit_limit_tags = esc_attr(OVAEM_Settings::frontend_submit_limit_tags());
         printf(
            '<input type="text" id="frontend_submit_limit_tags" placeholder="10" name="ovaem_options[frontend_submit_limit_tags]"  value="%s" />',
            isset($frontend_submit_limit_tags) ? $frontend_submit_limit_tags : '10'
         );
      }

      public function frontend_submit_show_editor() {

         $frontend_submit_show_editor = OVAEM_Settings::frontend_submit_show_editor();
         $frontend_submit_show_editor = isset($frontend_submit_show_editor) ? $frontend_submit_show_editor : 'yes';

         $yes = ('yes' == $frontend_submit_show_editor) ? 'selected' : '';
         $no = ('no' == $frontend_submit_show_editor) ? 'selected' : '';

         $html = '<select  name="ovaem_options[frontend_submit_show_editor]">';
         $html .= '<option ' . $yes . ' value="yes">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $no . ' value="no">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function list_speakers_style() {

         $list_speakers_style = OVAEM_Settings::list_speakers_style();
         $list_speakers_style = isset($list_speakers_style) ? $list_speakers_style : 'style1';

         $style1 = ('style1' == $list_speakers_style) ? 'selected' : '';
         $style2 = ('style2' == $list_speakers_style) ? 'selected' : '';
         $style3 = ('style3' == $list_speakers_style) ? 'selected' : '';
         $style4 = ('style4' == $list_speakers_style) ? 'selected' : '';

         $html = '<select  name="ovaem_options[list_speakers_style]">';
         $html .= '<option ' . $style1 . ' value="style1">' . esc_html__('Style 1', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $style2 . ' value="style2">' . esc_html__('Style 2', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $style3 . ' value="style2 style3">' . esc_html__('Style 3', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $style4 . ' value="style4">' . esc_html__('Style 4', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function list_speakers_link_title() {

         $list_speakers_link_title = OVAEM_Settings::list_speakers_link_title();
         $list_speakers_link_title = isset($list_speakers_link_title) ? $list_speakers_link_title : 'true';

         $true = ('true' == $list_speakers_link_title) ? 'selected' : '';
         $false = ('false' == $list_speakers_link_title) ? 'selected' : '';

         $html = '<select  name="ovaem_options[list_speakers_link_title]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('True', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('False', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function list_speakers_show_job() {

         $list_speakers_show_job = OVAEM_Settings::list_speakers_show_job();
         $list_speakers_show_job = isset($list_speakers_show_job) ? $list_speakers_show_job : 'true';

         $true = ('true' == $list_speakers_show_job) ? 'selected' : '';
         $false = ('false' == $list_speakers_show_job) ? 'selected' : '';

         $html = '<select  name="ovaem_options[list_speakers_show_job]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('True', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('False', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }
      public function list_speakers_show_social() {

         $list_speakers_show_social = OVAEM_Settings::list_speakers_show_social();
         $list_speakers_show_social = isset($list_speakers_show_social) ? $list_speakers_show_social : 'true';

         $true = ('true' == $list_speakers_show_social) ? 'selected' : '';
         $false = ('false' == $list_speakers_show_social) ? 'selected' : '';

         $html = '<select  name="ovaem_options[list_speakers_show_social]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('True', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('False', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);

      }

      public function list_speakers_post_per_page() {

         $list_speakers_post_per_page = OVAEM_Settings::list_speakers_post_per_page();
         $list_speakers_post_per_page = isset($list_speakers_post_per_page) ? $list_speakers_post_per_page : 12;

         
         printf(
            '<input type="text" id="list_speakers_post_per_page" placeholder="' . esc_html__('Insert Number', 'ovaem-events-manager') . '" name="ovaem_options[list_speakers_post_per_page]" value="%s" />',
            isset($list_speakers_post_per_page) ? $list_speakers_post_per_page : '12'
         );
         esc_html_e('Insert -1 to display all', 'ovaem-events-manager');

      }

      public function archive_venue_posts_per_page() {

         $archive_venue_posts_per_page = OVAEM_Settings::archive_venue_posts_per_page();
         $archive_venue_posts_per_page = isset($archive_venue_posts_per_page) ? $archive_venue_posts_per_page : 12;

         
         printf(
            '<input type="text" id="archive_venue_posts_per_page" placeholder="' . esc_html__('Insert Number', 'ovaem-events-manager') . '" name="ovaem_options[archive_venue_posts_per_page]" value="%s" />',
            isset($archive_venue_posts_per_page) ? $archive_venue_posts_per_page : '12'
         );
         esc_html_e('Insert -1 to display all', 'ovaem-events-manager');

      }

      

      

      public function archive_venue_style() {

         $archive_venue_style = OVAEM_Settings::archive_venue_style();
         $archive_venue_style = isset($archive_venue_style) ? $archive_venue_style : 'style1';

         $style1 = ('style1' == $archive_venue_style) ? 'selected' : '';
         $style2 = ('style2' == $archive_venue_style) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archive_venue_style]">';
         $html .= '<option ' . $style1 . ' value="style1">' . esc_html__('Grid', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $style2 . ' value="style2">' . esc_html__('Grid with sidebar', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);

      }

      public function archive_venue_orderby() {
         $archive_venue_orderby = OVAEM_Settings::archive_venue_orderby();
         $archive_venue_orderby = isset($archive_venue_orderby) ? $archive_venue_orderby : OVAEM_Settings::$prefix . '_venue_order';

         $prefix = OVAEM_Settings::$prefix;

         $date_order = $prefix . '_venue_order';
         $date_created = 'date';

         $date_order_selected = ($date_order == $archive_venue_orderby) ? 'selected' : '';
         $date_created_selected = ($date_created == $archive_venue_orderby) ? 'selected' : '';

         $title_selected = ('title' == $archive_venue_orderby) ? 'selected' : '';
         $id_selected = ('ID' == $archive_venue_orderby) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archive_venue_orderby]">';
         $html .= '<option ' . $date_order_selected . ' value="' . $date_order . '">' . esc_html__('Order Field in event attribute', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_created_selected . ' value="' . $date_created . '">' . esc_html__('Created Date', 'ovaem-events-manager') . '</option>';

         $html .= '<option ' . $title_selected . ' value="title">' . esc_html__('Title', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $id_selected . ' value="ID">' . esc_html__('ID', 'ovaem-events-manager') . '</option>';

         $html .= '</select>';

         print($html);
      }

      public function archive_venue_order() {
         $archive_venue_order = OVAEM_Settings::archive_venue_order();
         $archive_venue_order = isset($archive_venue_order) ? $archive_venue_order : 'ASC';

         $asc_selected = ('ASC' == $archive_venue_order) ? 'selected' : '';
         $desc_selected = ('DESC' == $archive_venue_order) ? 'selected' : '';

         $html = '<select  name="ovaem_options[archive_venue_order]">';
         $html .= '<option ' . $asc_selected . ' value="ASC">' . esc_html__('Increase', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $desc_selected . ' value="DESC">' . esc_html__('Decrease', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function detail_venue_event_show() {
         $detail_venue_event_show = OVAEM_Settings::detail_venue_event_show();
         $detail_venue_event_show = isset($detail_venue_event_show) ? $detail_venue_event_show : 'true';

         $true = ('true' == $detail_venue_event_show) ? 'selected' : '';
         $false = ('false' == $detail_venue_event_show) ? 'selected' : '';

         $html = '<select  name="ovaem_options[detail_venue_event_show]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function detail_venue_event_show_past() {
         $detail_venue_event_show_past = OVAEM_Settings::detail_venue_event_show_past();
         $detail_venue_event_show_past = isset($detail_venue_event_show_past) ? $detail_venue_event_show_past : 'true';

         $true = ('true' == $detail_venue_event_show_past) ? 'selected' : '';
         $false = ('false' == $detail_venue_event_show_past) ? 'selected' : '';

         $html = '<select  name="ovaem_options[detail_venue_event_show_past]">';
         $html .= '<option ' . $true . ' value="true">' . esc_html__('Yes', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $false . ' value="false">' . esc_html__('No', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function detail_venue_event_map_zoom() {
         $detail_venue_event_map_zoom = OVAEM_Settings::detail_venue_event_map_zoom();
         $detail_venue_event_map_zoom = isset($detail_venue_event_map_zoom) ? $detail_venue_event_map_zoom : '20';

         printf(
            '<input type="text" id="detail_venue_event_map_zoom" name="ovaem_options[detail_venue_event_map_zoom]" value="%s" />',
            isset($detail_venue_event_map_zoom) ? $detail_venue_event_map_zoom : '20'
         );

      }

      public function detail_venue_event_orderby() {
         $detail_venue_event_orderby = OVAEM_Settings::detail_venue_event_orderby();
         $detail_venue_event_orderby = isset($detail_venue_event_orderby) ? $detail_venue_event_orderby : OVAEM_Settings::$prefix . '_date_start_time';

         $prefix = OVAEM_Settings::$prefix;

         $date_start_time = $prefix . '_date_start_time';
         $date_end_time = $prefix . '_date_end_time';
         $date_order = $prefix . '_order';
         $date_created = 'date';

         $date_start_time_selected = ($date_start_time == $detail_venue_event_orderby) ? 'selected' : '';
         $date_end_time_selected = ($date_end_time == $detail_venue_event_orderby) ? 'selected' : '';
         $date_order_selected = ($date_order == $detail_venue_event_orderby) ? 'selected' : '';
         $date_created_selected = ($date_created == $detail_venue_event_orderby) ? 'selected' : '';

         $html = '<select  name="ovaem_options[detail_venue_event_orderby]">';
         $html .= '<option ' . $date_start_time_selected . ' value="' . $date_start_time . '">' . esc_html__('Start Time', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_end_time_selected . ' value="' . $date_end_time . '">' . esc_html__('End Time', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_order_selected . ' value="' . $date_order . '">' . esc_html__('Order Field in event attribute', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $date_created_selected . ' value="' . $date_created . '">' . esc_html__('Created Date', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function detail_venue_event_order() {
         $detail_venue_event_order = OVAEM_Settings::detail_venue_event_order();
         $detail_venue_event_order = isset($detail_venue_event_order) ? $detail_venue_event_order : 'ASC';

         $asc_selected = ('ASC' == $detail_venue_event_order) ? 'selected' : '';
         $desc_selected = ('DESC' == $detail_venue_event_order) ? 'selected' : '';

         $html = '<select  name="ovaem_options[detail_venue_event_order]">';
         $html .= '<option ' . $asc_selected . ' value="ASC">' . esc_html__('Increase', 'ovaem-events-manager') . '</option>';
         $html .= '<option ' . $desc_selected . ' value="DESC">' . esc_html__('Decrease', 'ovaem-events-manager') . '</option>';
         $html .= '</select>';

         print($html);
      }

      public function detail_venue_event_count() {
         $detail_venue_event_count = esc_attr(OVAEM_Settings::detail_venue_event_count());
         printf(
            '<input type="text" id="detail_venue_event_count" placeholder="' . esc_html__('Insert Number', 'ovaem-events-manager') . '" name="ovaem_options[detail_venue_event_count]" value="%s" />',
            isset($detail_venue_event_count) ? $detail_venue_event_count : '100'
         );
         esc_html_e('Insert -1 to display all', 'ovaem-events-manager');
      }

       public function send_mail_from() {
         $send_mail_from = esc_attr(OVAEM_Settings::send_mail_from());
         printf(
            '<input type="text" id="send_mail_from" placeholder="' . esc_html__('Insert email address', 'ovaem-events-manager') . '" name="ovaem_options[send_mail_from]" value="%s" />',
            isset($send_mail_from) ? $send_mail_from : get_option( 'admin_email' )
         );
         
      }

   }

   if (is_admin()) {
      new OVAEM_Admin_Settings();
   }

}