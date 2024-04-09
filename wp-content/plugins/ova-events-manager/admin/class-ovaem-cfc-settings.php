<?php
if (!defined('ABSPATH')) {
   exit();
}

if ( ! class_exists('OVAEM_CFC_Settings') ) {

   class OVAEM_CFC_Settings {

      public function __construct(){
         add_action( 'admin_menu', array( $this, 'add_custom_field_checkout_page' ) );
      }

      public function add_custom_field_checkout_page(){
         add_submenu_page(
         'ova-events-menu',
         __( 'Custom Field Checkout', 'ovaem-events-manager' ),
         __( 'Custom Field Checkout', 'ovaem-events-manager' ),
         'manage_options',
         'ovaem-custom-field-checkout',
         array( $this, 'custom_field_checkout_page_callback' ),
         10
         );
      }

      public function custom_field_checkout_page_callback(){
         ob_start();
         ovaem_get_template( 'admin/custom-field-checkout.php' );
         echo ob_get_clean();
      }
   }

   new OVAEM_CFC_Settings();
}