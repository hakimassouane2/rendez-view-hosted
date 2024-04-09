<?php
if (!defined('ABSPATH')) {
   exit();
}

if (!class_exists('OVAEM_Custom_Post_Type')) {

   class OVAEM_Custom_Post_Type {

      private static $event_post_type_slug = null;
      private static $event_post_type_name = null;
      private static $event_post_type_singular_name = null;
      private static $slug_taxonomy_name = null;
      private static $speaker_post_type_slug = null;

      private static $venue_post_type_name = null;
      private static $venue_post_type_singular_name = null;
      private static $venue_post_type_slug = null;

      /**
       * Construct class
       */
      public function __construct() {

         self::$event_post_type_slug = OVAEM_Settings::event_post_type_slug();
         self::$event_post_type_name = OVAEM_Settings::event_post_type_name();
         self::$event_post_type_singular_name = OVAEM_Settings::event_post_type_singular_name();
         self::$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
         self::$speaker_post_type_slug = OVAEM_Settings::speaker_post_type_slug();

         self::$venue_post_type_slug = OVAEM_Settings::venue_post_type_slug();

         // Register Events Post Types
         add_action('init', array($this, 'ovaem_register_event_post_types'));

         // Register Speaker Post Types
         add_action('init', array($this, 'ovaem_register_speaker_post_types'));

         // Register Event Venue
         add_action('init', array($this, 'ovaem_register_venue_post_types'));

         // Register Event Taxonomy
         add_action('init', array($this, 'ovaem_register_event_taxonomy'));

         add_action('init', array($this, 'ovaen_news_tag_taxonomies'));

         // Register Event coupon Post Type
         add_action('init', array($this, 'ovaem_register_event_coupon_post_types'));

         // Register Event Order Post Type
         add_action('init', array($this, 'ovaem_register_event_order_post_types'));

         // Register Event Ticket Post Type
         add_action('init', array($this, 'ovaem_register_event_ticket_post_types'));

         add_action('init', array($this, 'ova_loc_tax'));

         add_action( 'init', array( $this, 'ovaem_register_speaker_taxonomy') );

         add_action( 'init', array( $this, 'ovaem_register_venue_taxonomy') );

         
      }

      /**
       * Register Events Post TYpe
       */
      public function ovaem_register_event_post_types() {

         $slug = self::$event_post_type_slug ? self::$event_post_type_slug : '';
         $slug_taxonomy_name = self::$slug_taxonomy_name ? self::$slug_taxonomy_name : '';

         $label = array(
            'name' => _x('Events', 'post type general name', 'ovaem-events-manager'),
            'singular_name' => _x('Event', 'post type singular name', 'ovaem-events-manager'),
            'menu_name' => _x('Events', 'admin menu', 'ovaem-events-manager'),
            'name_admin_bar' => _x('Event', 'ovaem-events-manager'),
            'add_new' => _x('Add New Event', 'event', 'ovaem-events-manager'),
            'add_new_item' => __('Add New Event', 'ovaem-events-manager'),
            'edit_item' => __('Edit Event', 'ovaem-events-manager'),
            'new_item' => __('New Event', 'ovaem-events-manager'),
            'view_item' => __('View Event', 'ovaem-events-manager'),
            'view_items' => __('View Events', 'ovaem-events-manager'),
            'search_items' => __('Search Events', 'ovaem-events-manager'),
            'not_found' => __('No items found', 'ovaem-events-manager'),
            'not_found_in_trash' => __('No items found in trash', 'ovaem-events-manager'),
            'parent_item_colon' => __('Parent : Events', 'ovaem-events-manager'),
            'all_items' => __('All Events', 'ovaem-events-manager'),
            'archives' => __(' Event Archives', 'ovaem-events-manager'),
            'attributes' => __(' Event Attributes', 'ovaem-events-manager'),
         );

         $args = array(
            'labels' => $label,
            'description' => __(' Event Post Type', 'ovaem-events-manager'),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'show_ui' => true,
            'show_in_menu' => 'ova-events-menu',
            'taxonomies' => array($slug_taxonomy_name, 'event_tags'),
            'rewrite' => array('slug' => $slug),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),

         );
         register_post_type('event', $args);

      }

      /**
       * Register Event Taxonomy
       */
      public function ovaem_register_event_taxonomy() {

         $slug = self::$event_post_type_slug ? self::$event_post_type_slug : '';
         $singular_name = self::$event_post_type_singular_name ? self::$event_post_type_singular_name : '';
         $slug_taxonomy_name = self::$slug_taxonomy_name ? self::$slug_taxonomy_name : '';

         $labels = array(
            'singular_name' => _x('Event ', 'taxonomy singular name', 'ovaem-events-manager') . $slug_taxonomy_name,
            'search_items' => __('Search ', 'ovaem-events-manager') . $slug_taxonomy_name,
            'all_items' => __($slug_taxonomy_name, 'ovaem-events-manager'),
            'parent_item' => __('Parent ', 'ovaem-events-manager') . $slug_taxonomy_name,
            'parent_item_colon' => __('Parent :', 'ovaem-events-manager') . $slug_taxonomy_name,
            'edit_item' => __('Edit ', 'ovaem-events-manager') . $slug_taxonomy_name,
            'update_item' => __('Update ', 'ovaem-events-manager') . $slug_taxonomy_name,
            'add_new_item' => __('Add New ', 'ovaem-events-manager') . $slug_taxonomy_name,
            'new_item_name' => __('New Category Name', 'ovaem-events-manager'),
            'menu_name' => $slug_taxonomy_name . __(' new', 'ovaem-events-manager'),
         );

         $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var' => true,
            'rewrite' => array('slug' => $slug_taxonomy_name),

         );

         if (isset($slug) && $slug != '') {
            register_taxonomy($slug_taxonomy_name, array($slug), $args);
         }
      }

      /* Register Speaker Post Type */
      public function ovaem_register_speaker_post_types() {

         if (isset(self::$speaker_post_type_slug) && self::$speaker_post_type_slug != '') {

            $slug = self::$speaker_post_type_slug ? self::$speaker_post_type_slug : '';

            $label = array(
               'name' => _x('Speakers', 'post type general name', 'ovaem-events-manager'),
               'singular_name' => _x('Speaker', 'post type singular name', 'ovaem-events-manager'),
               'menu_name' => _x('Speakers', 'admin menu', 'ovaem-events-manager'),
               'name_admin_bar' => _x('Speaker', 'ovaem-events-manager'),
               'add_new' => _x('Add New Speaker', 'event', 'ovaem-events-manager'),
               'add_new_item' => __('Add New Speaker', 'ovaem-events-manager'),
               'edit_item' => __('Edit Speaker', 'ovaem-events-manager'),
               'new_item' => __('New Speaker', 'ovaem-events-manager'),
               'view_item' => __('View Speaker', 'ovaem-events-manager'),
               'view_items' => __('View Speakers', 'ovaem-events-manager'),
               'search_items' => __('Search Speakers', 'ovaem-events-manager'),
               'not_found' => __('No items found', 'ovaem-events-manager'),
               'not_found_in_trash' => __('No items found in trash', 'ovaem-events-manager'),
               'parent_item_colon' => __('Parent : Speakers', 'ovaem-events-manager'),
               'all_items' => __('Speakers', 'ovaem-events-manager'),
               'archives' => __('Speaker Archives', 'ovaem-events-manager'),
               'attributes' => __('Speaker Attributes', 'ovaem-events-manager'),
            );

            $args = array(
               'labels' => $label,
               'description' => __('Speaker Post Type', 'ovaem-events-manager'),
               'public' => true,
               'publicly_queryable' => true,
               'exclude_from_search' => true,
               'show_ui' => true,
               'show_in_menu' => 'ova-events-menu',
               'query_var' => true,
               'rewrite' => array('slug' => $slug),
               'taxonomies' => array( 'cat_speaker' ),
               'capability_type' => 'post',
               'has_archive' => true,
               'hierarchical' => false,
               'menu_position' => null,
               'supports' => array('title', 'editor', 'thumbnail', 'author'),

            );
            register_post_type($slug, $args);
         }
      }

      // Register speaker taxonomy
      public function ovaem_register_speaker_taxonomy() {

         $speaker_slug = self::$speaker_post_type_slug ? self::$speaker_post_type_slug : '';

         $labels = array(
            'singular_name' => _x('Speaker Category', 'taxonomy singular name', 'ovaem-events-manager'),
            'search_items' => __('Search Speaker Category', 'ovaem-events-manager'),
            'all_items' => __('Speaker Category', 'ovaem-events-manager'),
            'parent_item' => __('Parent ', 'ovaem-events-manager'),
            'parent_item_colon' => __('Parent :', 'ovaem-events-manager') ,
            'edit_item' => __('Edit ', 'ovaem-events-manager'),
            'update_item' => __('Update ', 'ovaem-events-manager'),
            'add_new_item' => __('Add New ', 'ovaem-events-manager'),
            'new_item_name' => __('New Category Name', 'ovaem-events-manager'),
            'menu_name' => __('Speaker Category New', 'ovaem-events-manager'),
         );

         $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var' => true,
             'rewrite'    => array(
               'slug'       => _x('cat_speaker','Speaeker Category', 'ovaem-events-manager'),
               'with_front' => false,
               'feeds'      => true,
            )

         );

         if (isset($speaker_slug) && $speaker_slug != '') {
            register_taxonomy( 'cat_speaker' , array($speaker_slug), $args);
         }
      }
      


      // Regsiter Venue Event
      public function ovaem_register_venue_post_types() {

         $slug = self::$venue_post_type_slug ? self::$venue_post_type_slug : '';
         $name = self::$venue_post_type_name ? self::$venue_post_type_name : '';
         $singular_name = self::$venue_post_type_singular_name ? self::$venue_post_type_singular_name : '';

         $label = array(
            'name' => _x('Venues', 'Venues post type general name', 'ovaem-events-manager'),
            'singular_name' => _x('Venue', 'post type singular name', 'ovaem-events-manager'),
            'menu_name' => _x('Venues', 'admin menu', 'ovaem-events-manager'),
            'name_admin_bar' => _x('Venue', 'ovaem-events-manager'),
            'add_new' => _x('Add New Venue', 'event', 'ovaem-events-manager'),
            'add_new_item' => __('Add New Venue', 'ovaem-events-manager'),
            'edit_item' => __('Edit Venue', 'ovaem-events-manager'),
            'new_item' => __('New Venue', 'ovaem-events-manager'),
            'view_item' => __('View Venue', 'ovaem-events-manager'),
            'view_items' => __('View Venues', 'ovaem-events-manager'),
            'search_items' => __('Search Venues', 'ovaem-events-manager'),
            'not_found' => __('No items found', 'ovaem-events-manager'),
            'not_found_in_trash' => __('No items found in trash', 'ovaem-events-manager'),
            'parent_item_colon' => __('Parent : Venue', 'ovaem-events-manager'),
            'all_items' => __('Venue', 'ovaem-events-manager'),
            'archives' => __('Venue Archives', 'ovaem-events-manager'),
            'attributes' => __('Venue Attributes', 'ovaem-events-manager'),
         );

         $args = array(
            'labels' => $label,
            'description' => __('Venues Post Type', 'ovaem-events-manager'),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'show_ui' => true,
            'show_in_menu' => 'ova-events-menu',
            'rewrite' => array('slug' => $slug),
            'taxonomies' => array( 'cat_venue' ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),

         );

         register_post_type($slug, $args);

      }

      // Register speaker taxonomy
      public function ovaem_register_venue_taxonomy() {

        $venue_slug = self::$venue_post_type_slug ? self::$venue_post_type_slug : '';

         $labels = array(
            'singular_name' => _x('Venue Category', 'taxonomy singular name', 'ovaem-events-manager'),
            'search_items' => __('Search Venue Category', 'ovaem-events-manager'),
            'all_items' => __('Venue Category', 'ovaem-events-manager'),
            'parent_item' => __('Parent ', 'ovaem-events-manager'),
            'parent_item_colon' => __('Parent :', 'ovaem-events-manager') ,
            'edit_item' => __('Edit ', 'ovaem-events-manager'),
            'update_item' => __('Update ', 'ovaem-events-manager'),
            'add_new_item' => __('Add New ', 'ovaem-events-manager'),
            'new_item_name' => __('New Category Name', 'ovaem-events-manager'),
            'menu_name' => __('Venue Category New', 'ovaem-events-manager'),
         );

         $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var' => true,
            'rewrite'    => array(
               'slug'       => _x('cat_venue','Venue Category', 'ovaem-events-manager'),
               'with_front' => false,
               'feeds'      => true,
            )


         );

         if (isset($venue_slug) && $venue_slug != '') {
            register_taxonomy( 'cat_venue' , array($venue_slug), $args);
         }
      }


      //create two taxonomies, genres and tags for the post type "tag"
      function ovaen_news_tag_taxonomies() {
         $slug = self::$event_post_type_slug ? self::$event_post_type_slug : '';

         $labels = array(
            'name' => __('Event Tag', "ovaem-events-manager"),
            'singular_name' => __('Event Tag', "ovaem-events-manager"),
            'menu_name' => __('Event Tags', "ovaem-events-manager"),
            'all_items' => __('All Event Tags', "ovaem-events-manager"),
            'parent_item' => __('Parent Event Tag', "ovaem-events-manager"),
            'parent_item_colon' => __('Parent Event Tag:', 'ovaem-events-manager'),
            'new_item_name' => __('New Event Tag', 'ovaem-events-manager'),
            'add_new_item' => __('Add New Event Tag', 'ovaem-events-manager'),
            'edit_item' => __('Edit Event Tag', 'ovaem-events-manager'),
            'update_item' => __('Update Event Tag', 'ovaem-events-manager'),
            'separate_items_with_commas' => __('Separate Event Tags with commas', 'ovaem-events-manager'),
            'search_items' => __('Search Event Tags', 'ovaem-events-manager'),
            'add_or_remove_items' => __('Add or remove Event Tags', 'ovaem-events-manager'),
            'choose_from_most_used' => __('Choose from the most used Event Tags', 'ovaem-events-manager'),
            'not_found' => __('Not Found', 'ovaem-events-manager'),
         );

         $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => 'ova-events-menu',
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'event_tags'),
         );

         register_taxonomy('event_tags', array($slug), $args);

      }

      /**
       * Order Post TYpe
       */
      public function ovaem_register_event_order_post_types() {

         $slug = 'event_order';
         $name = 'Orders';
         $singular_name = 'Order';

         $label = array(
            'name' => _x('Orders', 'post type general name', 'ovaem-events-manager'),
            'singular_name' => _x('Order', 'post type singular name', 'ovaem-events-manager'),
            'menu_name' => _x('Orders', 'admin menu', 'ovaem-events-manager'),
            'name_admin_bar' => _x('Order', 'ovaem-events-manager'),
            'add_new' => _x('Add New Order', 'event', 'ovaem-events-manager'),
            'add_new_item' => __('Add New Order', 'ovaem-events-manager'),
            'edit_item' => __('Edit Order', 'ovaem-events-manager'),
            'new_item' => __('New Order', 'ovaem-events-manager'),
            'view_item' => __('View Order', 'ovaem-events-manager'),
            'view_items' => __('View Orders', 'ovaem-events-manager'),
            'search_items' => __('Search Orders', 'ovaem-events-manager'),
            'not_found' => __('No items found', 'ovaem-events-manager'),
            'not_found_in_trash' => __('No items found in trash', 'ovaem-events-manager'),
            'parent_item_colon' => __('Parent Orders', 'ovaem-events-manager'),
            'all_items' => __('All Orders', 'ovaem-events-manager'),
            'archives' => __('Order Archives', 'ovaem-events-manager'),
            'attributes' => __('Order Attributes', 'ovaem-events-manager'),
         );

         $args = array(
            'labels' => $label,
            'description' => __('Order Post Type', 'ovaem-events-manager'),
            'public' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => 'ova-events-menu',
            'query_var' => true,
            'rewrite' => array('slug' => 'event_order'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'author'),

         );

         register_post_type($slug, $args);

      }

      /**
       * Ticket Post TYpe
       */
      public function ovaem_register_event_ticket_post_types() {

         $slug = 'event_ticket';
         $name = 'Tickets';
         $singular_name = 'Ticket';

         $label = array(
            'name' => _x('Tickets', 'post type general name', 'ovaem-events-manager'),
            'singular_name' => _x('Ticket', 'post type singular name', 'ovaem-events-manager'),
            'menu_name' => _x('Tickets', 'admin menu', 'ovaem-events-manager'),
            'name_admin_bar' => _x('Ticket', 'ovaem-events-manager'),
            'add_new' => _x('Add New Ticket', 'event', 'ovaem-events-manager'),
            'add_new_item' => __('Add New Ticket', 'ovaem-events-manager'),
            'edit_item' => __('Edit Ticket', 'ovaem-events-manager'),
            'new_item' => __('New Ticket', 'ovaem-events-manager'),
            'view_item' => __('View Ticket', 'ovaem-events-manager'),
            'view_items' => __('View Tickets', 'ovaem-events-manager'),
            'search_items' => __('Search Tickets', 'ovaem-events-manager'),
            'not_found' => __('No items found', 'ovaem-events-manager'),
            'not_found_in_trash' => __('No items found in trash', 'ovaem-events-manager'),
            'parent_item_colon' => __('Parent Tickets', 'ovaem-events-manager'),
            'all_items' => __('All Tickets', 'ovaem-events-manager'),
            'archives' => __('Ticket Archives', 'ovaem-events-manager'),
            'attributes' => __('Ticket Attributes', 'ovaem-events-manager'),
         );

         $args = array(
            'labels' => $label,
            'description' => __('Ticket Post Type', 'ovaem-events-manager'),
            'public' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => 'ova-events-menu',
            'query_var' => true,
            'rewrite' => array('slug' => 'event_ticket'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('author'),

         );
         register_post_type($slug, $args);

      }

      /**
       * coupon Post TYpe
       */
      public function ovaem_register_event_coupon_post_types() {

         $slug = 'coupon';
         $name = 'coupons';
         $singular_name = 'coupon';

         $label = array(
            'name' => _x('Coupons', 'post type general name', 'ovaem-events-manager'),
            'singular_name' => _x('Coupon', 'post type singular name', 'ovaem-events-manager'),
            'menu_name' => _x('Coupons', 'admin menu', 'ovaem-events-manager'),
            'name_admin_bar' => _x('Coupon', 'ovaem-events-manager'),
            'add_new' => _x('Add New Coupon', 'event', 'ovaem-events-manager'),
            'add_new_item' => __('Add New Coupon', 'ovaem-events-manager'),
            'edit_item' => __('Edit Coupon', 'ovaem-events-manager'),
            'new_item' => __('New Coupon', 'ovaem-events-manager'),
            'view_item' => __('View Coupon', 'ovaem-events-manager'),
            'view_items' => __('View Coupons', 'ovaem-events-manager'),
            'search_items' => __('Search Coupons', 'ovaem-events-manager'),
            'not_found' => __('No items found', 'ovaem-events-manager'),
            'not_found_in_trash' => __('No items found in trash', 'ovaem-events-manager'),
            'parent_item_colon' => __('Parent Coupons', 'ovaem-events-manager'),
            'all_items' => __('All Coupons', 'ovaem-events-manager'),
            'archives' => __('Coupon Archives', 'ovaem-events-manager'),
            'attributes' => __('Coupon Attributes', 'ovaem-events-manager'),
         );

         $args = array(
            'labels' => $label,
            'description' => __('Coupon Post Type', 'ovaem-events-manager'),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => 'ova-events-menu',
            'query_var' => true,
            'rewrite' => array('slug' => 'coupon'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title'),

         );
         register_post_type($slug, $args);

      }

      public function ova_loc_tax() {

         $slug = self::$event_post_type_slug ? self::$event_post_type_slug : '';

         $labels = array(
            'name' => __('Location', "ovaem-events-manager"),
            'singular_name' => __('Location', "ovaem-events-manager"),
            'menu_name' => __('Location', "ovaem-events-manager"),
            'all_items' => __('All Event Locations', "ovaem-events-manager"),
            'parent_item' => __('Parent Event Location', "ovaem-events-manager"),
            'parent_item_colon' => __('Parent Event Location:', 'ovaem-events-manager'),
            'new_item_name' => __('New Event Location', 'ovaem-events-manager'),
            'add_new_item' => __('Add New Event Location', 'ovaem-events-manager'),
            'edit_item' => __('Edit Event Location', 'ovaem-events-manager'),
            'update_item' => __('Update Event Location', 'ovaem-events-manager'),
            'separate_items_with_commas' => __('Separate Event Locations with commas', 'ovaem-events-manager'),
            'search_items' => __('Search Event Locations', 'ovaem-events-manager'),
            'add_or_remove_items' => __('Add or remove Event Locations', 'ovaem-events-manager'),
            'choose_from_most_used' => __('Choose from the most used Event Locations', 'ovaem-events-manager'),
            'not_found' => __('Not Found', 'ovaem-events-manager'),
         );

         $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'location'),

         );

         if (isset($slug) && $slug != '') {
            register_taxonomy('location', array($slug), $args);
         }
      }

   }

   new OVAEM_Custom_Post_Type();

}
