<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'OVAEM_CFC' ) ) {
	
	class OVAEM_CFC {

		public function __construct(){
			$enable_for_event_free 			= OVAEM_Settings::enable_event_free();
			$enable_event_cfc_checkout 		= OVAEM_Settings::enable_event_cfc_checkout();
			$enable_event_cfc_woo_checkout 	= OVAEM_Settings::enable_event_cfc_woo_checkout();

			if ( $enable_for_event_free ) {
				add_action( 'ovaem_before_register_event_button', [ $this, 'ovaem_cfc_event_free' ], 10, 0 );
				add_action( 'ovaem_after_save_order_event_free', [ $this, 'ovaem_cfc_event_save' ], 10, 2 );
			}
			if ( $enable_event_cfc_checkout ) {
				add_action( 'ovaem_after_checkout_your_info', [ $this, 'ovaem_cfc_event_offline' ], 10, 0 );
				add_action( 'ovaem_after_save_order_event_offline', [ $this, 'ovaem_cfc_event_save' ], 10, 2 );
			}
			if ( $enable_event_cfc_woo_checkout ) {
				add_action( 'woocommerce_after_checkout_billing_form', [ $this, 'ovaem_cfc_event_woocommerce' ], 10, 1 );
				add_action('woocommerce_checkout_process', [ $this, 'ovaem_woocommerce_checkout_process' ], 10, 0 );
				add_action( 'ovaem_woomodern_checkout_event_order_created', [$this,'ovaem_cfc_event_save'], 10, 2 );
			}
			
			add_action( 'ovaem_metabox_order_detail_end', [ $this, 'ovaem_cfc_metabox_order_detail_end' ], 10, 1 );
		}

		public function ovaem_cfc_event_free(){
			ob_start();
			ovaem_get_template('checkout/cfc-event-free.php');
			echo ob_get_clean();
		}

		public function ovaem_cfc_event_save( $order_id_new, $post_data ){
			$ovaem_cfc 	= get_option( 'ova_checkout_form' );
			$prefix 	= 'ovaemcf_';
			if ( ! $ovaem_cfc ) {
				return;
			}
			// save custom field checkout to order
			foreach ( $ovaem_cfc as $name => $field ) {
				$post_name = $prefix.$name;
				
				if ( $field['type'] === 'file' ) {
					continue;
				}
				// checkout woo checkbox
				if ( isset( $post_data['ovaemcf_woo_hidden'] ) && $field['type'] === 'checkbox' ) {
					$ova_checkbox_key 	= $field['ova_checkbox_key'] ? $field['ova_checkbox_key'] : '';
					$ova_checkbox_text 	= $field['ova_checkbox_text'] ? $field['ova_checkbox_text'] : '';
					if ( $ova_checkbox_key ) {
						foreach ($ova_checkbox_key as $key => $value) {
							$checkbox_name = $prefix.$value;
							if ( array_key_exists( $checkbox_name, $post_data ) ) {
								update_post_meta( $order_id_new, $checkbox_name, sanitize_text_field( $post_data[$checkbox_name] ) );
							}
						}
					}
					update_post_meta( $order_id_new, 'ovaemcf_woo_hidden', '1' );
					continue;
				}
				if ( array_key_exists( $post_name, $post_data ) ) {
					update_post_meta( $order_id_new, $post_name, sanitize_text_field( $post_data[$post_name] ) );
				}
			}
			// handle upload file
			if ( ! empty( $_FILES ) ) {
				foreach ( $_FILES as $key => $value ) {
					$file_name 			= $_FILES[$key]["name"];
					$file_name 			= preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);
					$ext 				= pathinfo($_FILES[$key]["name"], PATHINFO_EXTENSION);
					$image_name 		= $file_name . time() . "." . $ext;
					$upload_dir 		= wp_upload_dir()['path'];
					$upload_file 		= $upload_dir . '/'. basename( $image_name );
					$check_upload_file  = move_uploaded_file( $_FILES[$key]['tmp_name'], $upload_file );
					if ( $check_upload_file ) {
						// Check the type of file. We'll use this as the 'post_mime_type'.
						$filetype = wp_check_filetype( $upload_file, null );
						$attachment = array(
							'guid'           => wp_upload_dir()['url'] . '/' . basename($upload_file), 
							'post_mime_type' => $filetype['type'],
							'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload_file ) ),
							'post_content'   => '',
							'post_status'    => 'inherit'
						);
						// Insert the attachment.
						$attach_id = wp_insert_attachment( $attachment, $upload_file );
						// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
						require_once( ABSPATH . 'wp-admin/includes/image.php' );
						$attach_data = wp_generate_attachment_metadata( $attach_id, $upload_file );
						wp_update_attachment_metadata( $attach_id, $attach_data );
						update_post_meta( $order_id_new, $key, $attach_id );
					}
				}
			}
		}

		public function ovaem_cfc_metabox_order_detail_end( $order_id ){
			$ovaem_cfc 	= get_option( 'ova_checkout_form' );
			$prefix 	= 'ovaemcf_';
			if ( ! $ovaem_cfc ) {
				return;
			}
			foreach ( $ovaem_cfc as $name => $field ) {
				$post_name 		= $prefix.$name;
				$cfc_meta_val 	= get_post_meta( $order_id, $post_name, true );
				$checkbox_woo = get_post_meta( $order_id, 'ovaemcf_woo_hidden', true );
				if ( $cfc_meta_val || $checkbox_woo ) {
					switch ( $field['type'] ) {
						
						case 'file':
						if ( ! $checkbox_woo ) {
						?>
						<div class="ovaem_row">
							<label>
								<strong><?php echo esc_html( $field['label'] ); ?>: </strong>
								<?php echo wp_get_attachment_image( $cfc_meta_val ); ?>
							</label>
							<br><br>
						</div>
						<?php
						}
						break;

						case 'checkbox':
						if ( $checkbox_woo ) {
							$ova_checkbox_key 	= $field['ova_checkbox_key'] ? $field['ova_checkbox_key'] : '';
							$ova_checkbox_text 	= $field['ova_checkbox_text'] ? $field['ova_checkbox_text'] : '';
							if ( $ova_checkbox_key ) {
								?>
								<div class="ovaem_row">
									<label>
										<strong><?php echo esc_html( $field['label'] ); ?>: </strong>
								<?php
								$data_display = array();
								foreach ($ova_checkbox_key as $key => $value) {
									$checkbox_name = $prefix.$value;
									$checkbox_val = get_post_meta( $order_id, $checkbox_name, true );
									if ( $checkbox_val ) {
										array_push( $data_display, $ova_checkbox_text[$key] );
									}
								}
								echo esc_html( implode(",", $data_display) );
								?>
								</label>
									<br><br>
								</div>
								<?php
							}
						} else {
							?>
							<div class="ovaem_row">
								<label>
									<strong><?php echo esc_html( $field['label'] ); ?>: </strong>
									<?php echo esc_html( $cfc_meta_val ); ?>
								</label>
								<br><br>
							</div>
							<?php
						}
						
						break;
						
						default:
						?>
						<div class="ovaem_row">
							<label>
								<strong><?php echo esc_html( $field['label'] ); ?>: </strong>
								<?php echo esc_html( $cfc_meta_val ); ?>
							</label>
							<br><br>
						</div>
						<?php
						break;
					}
				}
			}
		}

		public function ovaem_cfc_event_offline(){
			ob_start();
			ovaem_get_template('checkout/cfc-event-offline.php');
			echo ob_get_clean();
		}

		public function ovaem_cfc_event_woocommerce( $checkout ){
			$ovaem_cfc 	= get_option( 'ova_checkout_form' );
			$prefix 	= 'ovaemcf_';

			?>
			<input type="hidden" name="ovaemcf_woo_hidden" value="1">
			<?php

			foreach ( $ovaem_cfc as $name => $field ) {
				$field_name = $prefix.$name;

				if ( $field['enabled'] == "on" ) {
					$required 	= $field['required'] == "on" ? true : false;
					$class 		= $field['class'];
					switch ( $field['type'] ) {
						case 'text':
						woocommerce_form_field($field_name, array('type' => 'text','class' => array($class) ,'label' => $field['label'] ,'placeholder' => $field['placeholder'] ,'required' => $required) , $checkout->get_value($field_name));
						break;

						case 'password':
						woocommerce_form_field($field_name, array('type' => 'password','class' => array($class) ,'label' => $field['label'] ,'placeholder' => $field['placeholder'] ,'required' => $required) , $checkout->get_value($field_name));
						break;

						case 'email':
						woocommerce_form_field($field_name, array('type' => 'email','class' => array($class) ,'label' => $field['label'] ,'placeholder' => $field['placeholder'] ,'required' => $required) , $checkout->get_value($field_name));
						break;

						case 'tel':
						woocommerce_form_field($field_name, array('type' => 'tel','class' => array($class) ,'label' => $field['label'] ,'placeholder' => $field['placeholder'] ,'required' => $required) , $checkout->get_value($field_name));
						break;

						case 'textarea':
						woocommerce_form_field($field_name, array('type' => 'textarea','class' => array($class) ,'label' => $field['label'] ,'placeholder' => $field['placeholder'] ,'required' => $required) , $checkout->get_value($field_name));
						break;

						case 'select':
						$ova_options_key 	= $field['ova_options_key'] ? $field['ova_options_key'] : '';
						$ova_options_text 	= $field['ova_options_text'] ? $field['ova_options_text'] : '';
						$options = array();
						foreach ( $ova_options_key as $key => $value ) {
							$options[$ova_options_text[$key]] = $ova_options_text[$key];
						}
						woocommerce_form_field($field_name, array('type' => 'select','class' => array($class.' ova-select2') ,'label' => $field['label'] ,'placeholder' => $field['placeholder'] ,'required' => $required, 'options' => $options ) , $checkout->get_value($field_name));
						break;

						case 'radio':
						$ova_radio_key 	= $field['ova_radio_key'] ? $field['ova_radio_key'] : '';
						$ova_radio_text = $field['ova_radio_text'] ? $field['ova_radio_text'] : '';
						$options = array();
						if ( $ova_radio_key ) {
							foreach ( $ova_radio_key as $key => $value ) {
								$options[$ova_radio_text[$key]] = $ova_radio_text[$key];
							}
						}
						woocommerce_form_field($field_name, array('type' => 'radio','class' => array($class.' ova-radio') ,'label' => $field['label'] ,'placeholder' => $field['placeholder'] ,'required' => $required, 'options' => $options ) , $checkout->get_value($field_name));
						break;

						case 'checkbox':
						$ova_checkbox_key 	= $field['ova_checkbox_key'] ? $field['ova_checkbox_key'] : '';
						$ova_checkbox_text 	= $field['ova_checkbox_text'] ? $field['ova_checkbox_text'] : '';

						if ( $ova_checkbox_key ) {
							foreach ( $ova_checkbox_key as $key => $value ) {
								$checkbox_name = $prefix.$value;
								woocommerce_form_field($checkbox_name, array('type' => 'checkbox','class' => array($class) ,'label' => $ova_checkbox_text[$key] ,'placeholder' => $field['placeholder'] ,'required' => $required) , $checkout->get_value($checkbox_name));
							}
						}
						
						break;

						case 'file':
						break;

						default:
						break;
					}
				}
			}
		}

		public function ovaem_woocommerce_checkout_process(){
			$ovaem_cfc 	= get_option( 'ova_checkout_form' );
			$prefix 	= 'ovaemcf_';
			// save custom field checkout to order
			foreach ( $ovaem_cfc as $name => $field ) {
				$post_name = $prefix.$name;
				
				if ( $field['enabled'] == "on" && $field['required'] == "on" ) {
					if ( $field['type'] === 'file' ) {
						continue;
					}
					if ( $field['type'] === 'checkbox' ) {
						$ova_checkbox_key 	= $field['ova_checkbox_key'] ? $field['ova_checkbox_key'] : '';
						$ova_checkbox_text 	= $field['ova_checkbox_text'] ? $field['ova_checkbox_text'] : '';
						if ( $ova_checkbox_key ) {
							foreach ( $ova_checkbox_key as $key => $value ) {
								$checkbox_name = $prefix.$value;
								if ( ! $_POST[$checkbox_name] ) {
									wc_add_notice( sprintf( __( '<strong>%s</strong> is a required field.', 'ovaem-events-manager' ), $ova_checkbox_text[$key] ) , 'error');
								}
							}
						}
						continue;
					}
					if ( ! $_POST[$post_name] ) {
						wc_add_notice( sprintf( __( '<strong>%s</strong> is a required field.', 'ovaem-events-manager' ), $field['label'] ) , 'error');
					}
				}
			}
		}
	}

	new OVAEM_CFC();
}