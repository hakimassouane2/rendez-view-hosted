<?php
defined('ABSPATH') || exit();

if (!class_exists('OVAEM_Make_PDF')) {

   class OVAEM_Make_PDF {

      public function __construct(){

         require_once OVAEM_PLUGIN_PATH . 'pdf/mpdf/vendor/autoload.php';
         
      }

      function make_pdf_ticket($ticket_id = '', $count = 1) {

         return $this->em4u_template_version($ticket_id, $count);

      }

      function em4u_template_version($ticket_id, $count) {

         $ticket = array();
         
         $start_time = get_post_meta($ticket_id, 'ovaem_ticket_event_start_time', true);
         $end_time = get_post_meta($ticket_id, 'ovaem_ticket_event_end_time', true);
         $venue = get_post_meta($ticket_id, 'ovaem_ticket_event_venue', true);
         $address = get_post_meta($ticket_id, 'ovaem_ticket_event_address', true);
         $code = get_post_meta($ticket_id, 'ovaem_ticket_code', true);
         // $qrcode = (OVAEM_Settings::pdf_ticket_format_qr() == 'code') ? $code : home_url('/') . '?qrcode=' . $code;
         $local = get_locale();

         if ($local == 'fr_FR') {
            // $qrcode .= 'fr/?qrcode=' . $code;
            $qrcode = (OVAEM_Settings::pdf_ticket_format_qr() == 'code') ? $code : home_url('/') . 'fr/?qrcode=' . $code;
         } else {
            $qrcode = (OVAEM_Settings::pdf_ticket_format_qr() == 'code') ? $code : home_url('/') . '?qrcode=' . $code;
         }

         $holder_ticket = get_post_meta($ticket_id, 'ovaem_ticket_buyer_name', true) . " - Client " . $count;
         $package = get_post_meta($ticket_id, 'ovaem_ticket_event_package', true);

         $ticket['ticket_id'] = $ticket_id;
         
         $ticket['ovaem_ticket_from_order_id'] = '';
         if( OVAEM_Settings::pdf_ticket_show_order_id() == 'true' ){
            $ticket['ovaem_ticket_from_order_id'] = get_post_meta($ticket_id, 'ovaem_ticket_from_order_id', true);
         }

         // Global
         
         $ticket['color_border_ticket'] = '#eeeeee';
         
         $ticket['event_name_font_size'] = OVAEM_Settings::pdf_ticket_event_fontsize();

         $ticket['label_color'] = OVAEM_Settings::pdf_ticket_label_color();
         $ticket['label_size'] =  OVAEM_Settings::pdf_ticket_label_fontsize();

         $ticket['text_color'] = OVAEM_Settings::pdf_ticket_text_color();
         $ticket['text_size'] = OVAEM_Settings::pdf_ticket_text_fontsize();

         
         // Event Name
         $ticket['event_name'] = get_post_meta($ticket_id, 'ovaem_ticket_event_name', true);

         // Time
          $ticket['time'] = '';
         if (OVAEM_Settings::pdf_ticket_show_time() == 'true') {
            $ticket['time'] =  $start_time . ' - ' . $end_time;
         }
        

         // Location
         $ticket['venue'] = $ticket['address'] = '';
         if (OVAEM_Settings::pdf_ticket_show_venue() == 'true' || OVAEM_Settings::pdf_ticket_show_adress() == 'true') {

            if (OVAEM_Settings::pdf_ticket_show_venue() == 'true') {

               $ticket['venue'] =  $venue;

            }else{

            }

            if (OVAEM_Settings::pdf_ticket_show_adress() == 'true') {

               $ticket['address'] =  $address;

            }

         }

         // QR Image
         $ticket['qrcode_str'] = '';
         if (OVAEM_Settings::pdf_ticket_show_qrcode() == 'true') {

            $ticket['qrcode_str'] = $qrcode;

         }
         

         // holder ticket
         $ticket['holder_ticket'] = '';
         if (OVAEM_Settings::pdf_ticket_show_holder_ticket() == 'true') {

            $ticket['holder_ticket'] = $holder_ticket;

         }



         // // Package
         $ticket['package'] = '';
         if (OVAEM_Settings::pdf_ticket_show_package() == 'true') {

            $ticket['package'] = $package;
            
         }

         

         // Logo
         $logo_event = get_post_meta($ticket_id, 'ovaem_pdf_ticket_logo', true);
         $logo_general = OVAEM_Settings::pdf_ticket_logo();
         if ($logo_event != '' || $logo_general != '') {
            $logo_id = $logo_event != '' ? $logo_event : $logo_general;
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');

            // Custom
            $logo_path = get_post_meta( $logo_id, '_wp_attached_file', true );
            $upload_dir   = wp_upload_dir();
            $logo_url = $upload_dir['baseurl'] . '/' . $logo_path;

            // $ticket['logo_url'] = $logo_url ? $logo_url : '';
            $ticket['logo_url'] = $logo_path ? $logo_url : '';
         }

         $upload_dir   = wp_upload_dir();

         // Add Font
         $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
         $fontDirs = $defaultConfig['fontDir'];

         $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
         $fontData = $defaultFontConfig['fontdata'];


         $config_mpdf = array(
            'tempDir' => $upload_dir['basedir'] . '/pdf_ticket/',
            'default_font_size' => apply_filters( 'oavem_pdf_font_size_'.apply_filters( 'wpml_current_language', NULL ), 12 ),
            'default_font' => apply_filters( 'ovaem_pdf_font_'.apply_filters( 'wpml_current_language', NULL ), 'DejaVuSans' ),
            'fontDir' => array_merge( $fontDirs, array( get_stylesheet_directory() . '/font' ) ),
         );

         $attach_file = '';

         ob_start();
         $template = OVAEM_Settings::pdf_ticket_template();
         if ($template == 'version1') {
            ovaem_get_template( 'pdf/template1.php', array( 'ticket' => $ticket ) );
         } else if ($template == 'version2') {
            ovaem_get_template( 'pdf/template2.php', array( 'ticket' => $ticket ) );
         }
         $html = ob_get_contents();
         ob_get_clean();

         try {
            $mpdf = new \Mpdf\Mpdf( apply_filters( 'ovaem_config_mpdf', $config_mpdf ) );
            $mpdf->WriteHTML( $html );
            $attach_file = WP_CONTENT_DIR.'/uploads/event__ticket'.$ticket_id.'.pdf';
            $mpdf->Output( $attach_file, 'F' );
            
         } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
             // Process the exception, log, print etc.
             echo $e->getMessage();
         }
         
         return $attach_file;


      }

      

   }

}
