<?php if ( !defined( 'ABSPATH' ) ) exit();
$custom_fields = get_option( 'ova_checkout_form' );


if ( $custom_fields ){

		foreach ( $custom_fields as $name => $field ){

			if ( $field['enabled'] == "on" ) {

				$required = $field['required'] == "on" ? "required" : "";
				?>
				<div class="ova_field <?php echo esc_attr( $field['class'] ); ?>">
					<?php if ( isset( $field['label'] ) && $field['label'] ): ?>
						<label><?php echo esc_html( $field['label'] ); ?></label>
					<?php endif; ?>
					<?php
					switch ( $field['type'] ) {
						case 'text':
						?>
						<input type="text" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" name="ovaemcf_<?php echo esc_attr( $name ); ?>" class="form-control" <?php echo esc_attr( $required ); ?>>
						<?php
						break;
						case 'password':
						?>
						<input type="password" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" name="ovaemcf_<?php echo esc_attr( $name ); ?>" class="form-control" <?php echo esc_attr( $required ); ?>>
						<?php
						break;
						case 'email':
						?>
						<input type="email" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" name="ovaemcf_<?php echo esc_attr( $name ); ?>" class="form-control" <?php echo esc_attr( $required ); ?>>
						<?php
						break;
						case 'tel':
						?>
						<input type="tel" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" name="ovaemcf_<?php echo esc_attr( $name ); ?>" class="form-control" <?php echo esc_attr( $required ); ?>>
						<?php
						break;
						case 'textarea':
						?>
						<textarea placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" name="ovaemcf_<?php echo esc_attr( $name ); ?>" class="form-control" cols="10" rows="5" <?php echo esc_attr( $required ); ?>></textarea>
						<?php
						break;
						case 'select':
						$ova_options_key 	= $field['ova_options_key'] 	? $field['ova_options_key'] : '';
						$ova_options_text 	= $field['ova_options_text'] 	? $field['ova_options_text'] : '';
						?>
						<select name="ovaemcf_<?php echo esc_attr( $name ); ?>" class="form-control selectpicker " <?php echo esc_attr( $required ); ?>>
							<option value=""><?php echo esc_html( $field['placeholder'] ) ?></option>
							<?php if ( $ova_options_key ): ?>
								<?php foreach ( $ova_options_key as $key => $item ): ?>
									<option value="<?php echo esc_attr( $ova_options_text[$key] ); ?>"><?php echo esc_html( $ova_options_text[$key] ); ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<?php
						break;
						case 'radio':
						$ova_radio_key 	= $field['ova_radio_key'] ? $field['ova_radio_key'] : '';
						$ova_radio_text = $field['ova_radio_text'] ? $field['ova_radio_text'] : '';
						if ( $ova_radio_key ): ?>
							<?php foreach ( $ova_radio_key as $key => $item ): ?>
								<?php $checked = $required == "required" ? $key : -1; ?>
								<div class="radio">
									<label for="<?php echo esc_attr( $name .'_'.$item ); ?>">
										<input type="radio" name="ovaemcf_<?php echo esc_attr( $name ); ?>" <?php checked( 0, $checked ); ?> value="<?php echo esc_attr( $ova_radio_text[$key] ); ?>" id="<?php echo esc_attr( $name .'_'.$item ) ?>" /><?php echo esc_html( $ova_radio_text[$key] ); ?></label>
									</div>
								<?php endforeach;
							endif;
							break;
							case 'checkbox':
							$ova_checkbox_key 	= $field['ova_checkbox_key'] ? $field['ova_checkbox_key'] : '';
							$ova_checkbox_text 	= $field['ova_checkbox_text'] ? $field['ova_checkbox_text'] : '';
							if ( $ova_checkbox_key ): ?>
								<?php foreach ( $ova_checkbox_key as $key => $item ): ?>
									<div class="checkbox">
										<label for="<?php echo esc_attr( $name .'_'.$item ); ?>"><input id="<?php echo esc_attr( $name .'_'.$item ); ?>" name="ovaemcf_<?php echo esc_attr( $name.'[]' ); ?>" type="checkbox" value="<?php echo esc_attr( $ova_checkbox_text[$key] ); ?>" <?php echo esc_attr( $required ); ?> ><?php echo esc_html( $ova_checkbox_text[$key] ); ?></label>
									</div>
								<?php endforeach; ?>
							<?php endif;
							break;
							case 'file':
							$max_size = (int)$field['max_file_size'] * 1024;
							?>
							<input type="file" class="form-control" name="ovaemcf_<?php echo esc_attr( $name ); ?>" <?php echo esc_attr( $required ); ?> accept="image/*" max-file-size="<?php echo esc_attr( $max_size ); ?>">
							<?php
							break;
							default:
							break;
						}
					?>

				</div>

			<?php }
		}
	}