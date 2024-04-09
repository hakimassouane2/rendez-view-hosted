<?php 
defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEM_Send_Mail' ) ){
	class OVAEM_Send_Mail{

		public static function ovaem_sendmail( $mail_to, $subject, $body, $attachments = array() ){
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

			add_filter( 'wp_mail_from', 'ova_wp_mail_from' );
			add_filter( 'wp_mail_from_name', 'ova_wp_mail_from_name' );

			if (wp_mail($mail_to, $subject, $body, $headers, $attachments)) {
				$result = true;
			} else {
				$result = false;
			}

		  remove_filter( 'wp_mail_from', 'ova_wp_mail_from');
		  remove_filter( 'wp_mail_from_name', 'ova_wp_mail_from_name' );

			return $result;
		}
	}
	new OVAEM_Send_Mail();
}
