<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// dump die
if ( ! function_exists( 'dd' ) ) {
	function dd( ...$args ) {
		echo '<pre>';
		var_dump(...$args);
		echo '</pre>';
		die;
	}
}

add_action( 'after_setup_theme', 'ovaem_theme_setup' );
function ovaem_theme_setup() {
	add_image_size( 'd_img', 370, 222, true );
	add_image_size( 'm_img', 640, 384, true );
}



if( !function_exists( 'ovaem_locate_template' ) ){
	function ovaem_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		
		// Set variable to search in ovaem-templates folder of theme.
		if ( ! $template_path ) :
			$template_path = 'ovaem-templates/';
		endif;

		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = OVAEM_PLUGIN_PATH . 'templates/'; // Path to the template folder
		endif;

		// Search template file in theme folder.
		$template = locate_template( array(
			$template_path . $template_name
			
		) );

		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;

		return apply_filters( 'ovaem_locate_template', $template, $template_name, $template_path, $default_path );
	}

}


function ovaem_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
	
	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
endif;

$template_file = ovaem_locate_template( $template_name, $tempate_path, $default_path );

if ( ! file_exists( $template_file ) ) :
	_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
	return;
endif;

include $template_file;

}


function ovaem_pagination_theme($ovaem_query = null) {

	global $wp_query;
	/** Stop execution if there's only 1 page */
	if($ovaem_query != null){
		if( $ovaem_query->max_num_pages <= 1 )
			return;	
	}else if( $wp_query->max_num_pages <= 1 )
	return;


	if( is_front_page() ){
		$paged = get_query_var( 'page' ) ? absint( get_query_var( 'page' ) ) : 1;	
	}else{
		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	}
	


	

	if($ovaem_query!=null){
		$max   = intval( $ovaem_query->max_num_pages );
	}else{
		$max   = intval( $wp_query->max_num_pages );	
	}
	

	/** Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/** Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}


	echo '<div class="ovaem_pagination"><ul class="pagination">' . "\n";

	/** Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li class="prev page-numbers">%s</li>' . "\n", get_previous_posts_link('<i class="arrow_carrot-left"></i>') );

	/** Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>...</li>';
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/** Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>...</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/** Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li class="next page-numbers">%s</li>' . "\n", get_next_posts_link('<i class="arrow_carrot-right"></i>') );

	echo '</ul></div>' . "\n";

}








add_action( 'widgets_init', 'ovaem_register_widget', 11 );
function ovaem_register_widget() {
	$ovaem_sidebar = array(
		'name' => esc_html__( 'Event Sidebar', 'ovaem-events-manager'),
		'id' => "ovaem-sidebar",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="event_widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="title">',
		'after_title' => "<span class=\"one\"></span><span class=\"two\"></span><span class=\"three\"></span><span class=\"four\"></span><span class=\"five\"></span></h3>",
	);
	register_sidebar( $ovaem_sidebar );
}


function shorten_string($string, $wordsreturned)
{
	$retval = $string;
	$string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
	$string = str_replace("\n", " ", $string);
	$array = explode(" ", $string);
	if (count($array)<=$wordsreturned)
	{
		$retval = $string;
	}
	else
	{
		array_splice($array, $wordsreturned);
		$retval = implode(" ", $array)." . . .";
	}
	return $retval;
}


/* Display Format of Price */
function ovaem_format_price($price, $cur){
	$currency_position = OVAEM_Settings::currency_position();
	switch ($currency_position) {
		case 'left':
		$price_format = '<span class="cur">'.$cur.'</span><span class="amount">'.$price.'</span>';
		break;
		case 'right':
		$price_format = '<span class="amount">'.$price.'</span><span class="cur">'.$cur.'</span>';
		break;	
		case 'left_space':
		$price_format = '<span class="cur">'.$cur.'</span>&nbsp;<span class="amount">'.$price.'</span>';
		break;

		default:
		$price_format = '<span class="amount">'.$price.'</span>&nbsp;<span class="cur">'.$cur.'</span>';
		break;
	}
	return $price_format;
}


function ova_wp_mail_from(){
	return OVAEM_Settings::send_mail_from() ? OVAEM_Settings::send_mail_from() : get_option('admin_email');
}

function ova_wp_mail_from_name(){
	return mb_convert_encoding( esc_html__("Rendew-view", 'ovaem-events-manager'), 'UTF-8', 'HTML-ENTITIES' );
}




// Breadcrumbs
add_action( 'ovaem_event_breadcrumbs', 'ovaem_event_breadcrumbs' );
function ovaem_event_breadcrumbs(){
	
}


// Title
add_action( 'ovaem_event_title', 'ovaem_event_title' );
function ovaem_event_title(){
	ovaem_get_template( 'loop/title.php' );
}



// Thumbnail
add_action( 'ovaem_event_thumbnail', 'ovaem_event_thumbnail' );
function ovaem_event_thumbnail(){
	ovaem_get_template( 'loop/thumbnail.php' );
}




// Schedule
add_action( 'ovaem_event_schedule', 'ovaem_event_schedule' );
function ovaem_event_schedule(){
	ovaem_get_template( 'loop/schedule.php' );
}

// Add to cart
add_action( 'ovaem_add_to_cart', 'ovaem_add_to_cart' );
function ovaem_add_to_cart(){
	ovaem_get_template( 'cart/add-to-cart.php' );
}

// Gallery
add_action( 'ovaem_event_gallery', 'ovaem_event_gallery' );
function ovaem_event_gallery(){
	ovaem_get_template( 'loop/gallery.php' );
}

add_action( 'ovaem_event_gallery_modern', 'ovaem_event_gallery_modern' );
function ovaem_event_gallery_modern(){
	ovaem_get_template( 'loop/gallery_modern.php' );
}

// Map
add_action( 'ovaem_event_map', 'ovaem_event_map' );
function ovaem_event_map(){
	ovaem_get_template( 'loop/map.php' );
}

// Ticket
add_action( 'ovaem_event_ticket', 'ovaem_event_ticket' );
function ovaem_event_ticket(){
	ovaem_get_template( 'loop/ticket.php' );
}

// organizer
add_action( 'ovaem_event_organizer', 'ovaem_event_organizer' );
function ovaem_event_organizer(){
	ovaem_get_template( 'loop/organizer.php' );
}

// Speakers
add_action( 'ovaem_event_speaker', 'ovaem_event_speaker' );
function ovaem_event_speaker(){
	ovaem_get_template( 'loop/speaker.php' );
}

//Sponsor
add_action( 'ovaem_event_sponsor', 'ovaem_event_sponsor' );
function ovaem_event_sponsor(){
	ovaem_get_template( 'loop/sponsor.php' );
}

// Tag
add_action( 'ovaem_event_tag', 'ovaem_event_tag' );
function ovaem_event_tag(){
	ovaem_get_template( 'loop/tag.php' );
}

// Related
add_action( 'ovaem_event_related', 'ovaem_event_related' );
function ovaem_event_related(){
	ovaem_get_template( 'loop/related.php' );
}

// Social Share
add_action( 'ovaem_event_social', 'ovaem_event_social' );
function ovaem_event_social(){
	ovaem_get_template( 'loop/social.php' );
}

// Frontend Submit
add_action( 'ovaem_frontend_submit', 'ovaem_frontend_submit' );
function ovaem_frontend_submit(){
	ovaem_get_template( 'frontend-submit.php' );
}

// Schema
add_action( 'ovaem_single_event_schema', 'ovaem_single_event_schema' );
function ovaem_single_event_schema(){
	ovaem_get_template( 'single-event-schema.php' );
}

// FAQ
add_action( 'ovaem_event_faq', 'ovaem_event_faq' );
function ovaem_event_faq(){
	ovaem_get_template( 'loop/faq.php' );
}




// Get Plugin Version
function ovaem_plugin_data(){
	$plugin_file = OVAEM_PLUGIN_PATH.'/ova-events-manager.php';
	return get_plugin_data( $plugin_file, $markup = true, $translate = true );
}

// Get cer attach mail by package_id, event_id
function get_cer_attach( $event_id, $package_id ){

	$package_id = isset($package_id) ? str_replace( "ovaminus", "_", urldecode($package_id) ) : '';

	$cer_file_attach = '';

	$prefix = OVAEM_Settings::$prefix;
	$ticket_field = $prefix.'_ticket';
	$tickets = get_post_meta( $event_id , $ticket_field, true );
	if( $tickets ){
		foreach ($tickets as $key => $ticket) {
			
			$ticket_package_id = isset($ticket["package_id"]) ? str_replace( "ovaminus", "_", urldecode($ticket["package_id"]) ) : '';

			if( $ticket_package_id == $package_id ){
				$pdf_attach = $ticket['pdf_attach'];

				if( $pdf_attach ){
					$cer_file_attach =  get_attached_file( $pdf_attach );
					break;
				}
			}
		}
	}
	return $cer_file_attach;
}


/***** Posts Per Page Archive *****/
add_action( 'pre_get_posts', 'em4u_archive_posts_per_page' );
function em4u_archive_posts_per_page ( $query ) {

	$event_post_type_slug = OVAEM_Settings::event_post_type_slug();
	$slug_taxonomy_name = OVAEM_Settings::slug_taxonomy_name();
	$search = isset( $_REQUEST['search'] ) ? esc_html( $_REQUEST['search'] ) : '';
	$post_type = isset($_REQUEST['post_type'] ) ? esc_html( $_REQUEST['post_type'] ) : get_post_type();


	if ( ! is_admin() ) {
		
		if( is_post_type_archive( OVAEM_Settings::speaker_post_type_slug() )  ){
			
			$list_speakers_post_per_page = OVAEM_Settings::list_speakers_post_per_page();
			$list_speakers_post_per_page = isset($list_speakers_post_per_page) && $list_speakers_post_per_page ? $list_speakers_post_per_page : 5;

			$query->set('posts_per_page', $list_speakers_post_per_page );

			$orderby = OVAEM_Settings::list_speakers_orderby();
			$order = OVAEM_Settings::list_speakers_order();

			if($orderby == 'date'){
				$query->set('orderby', 'date' );
			}else if( $orderby == 'ovaem_speaker_order' ){
				$query->set('orderby', 'meta_value_num' );
				$query->set('meta_key', $orderby );
			}else if($orderby == 'title'){
				$query->set('orderby', 'title' );
			}else if($orderby == 'ID'){
				$query->set('orderby', 'ID' );
			}
			
			$query->set('order', $order );

			remove_action( 'pre_get_posts', 'em4u_archive_posts_per_page' );

		}else if(  is_post_type_archive( OVAEM_Settings::venue_post_type_slug() )  ){
			
			$archive_venue_posts_per_page = OVAEM_Settings::archive_venue_posts_per_page();
			$archive_venue_posts_per_page = isset($archive_venue_posts_per_page) && $archive_venue_posts_per_page ? $archive_venue_posts_per_page : 5;

			$query->set('posts_per_page', $archive_venue_posts_per_page );

			$orderby = OVAEM_Settings::archive_venue_orderby();
			$order = OVAEM_Settings::archive_venue_order();

			if($orderby == 'date'){
				$query->set('orderby', 'date' );
			}else if( $orderby == 'ovaem_venue_order' ){
				$query->set('orderby', 'meta_value_num' );
				$query->set('meta_key', $orderby );
			}else if($orderby == 'title'){
				$query->set('orderby', 'title' );
			}else if($orderby == 'ID'){
				$query->set('orderby', 'ID' );
			}
			
			$query->set('order', $order );
			
			remove_action( 'pre_get_posts', 'em4u_archive_posts_per_page' );


		} else if( ( is_tax( $slug_taxonomy_name ) ||  ( isset( $_REQUEST[$slug_taxonomy_name] ) && get_query_var( $slug_taxonomy_name, '' ) != '' ) ) 
			|| $query->is_post_type_archive( $event_post_type_slug )
			|| $query->is_post_type_archive( 'location' )
			|| $query->is_tax( 'location' )
			|| ( $query->is_tax( 'event_tags' ) ||  ( isset( $_REQUEST['event_tags'] ) && get_query_var( 'event_tags', '' ) != '' ) )
			|| ( $post_type == $event_post_type_slug && ( $search != '' || $query->is_post_type_archive( $event_post_type_slug ) || $query->is_tax( $slug_taxonomy_name ) ) )
			|| is_page_template( 'templates/upcoming-event.php' )
			|| is_page_template( 'templates/past-event.php' )
			|| is_page_template( 'templates/featured-event.php' )

		){
			if ( is_post_type_archive( $event_post_type_slug ) || is_tax( $slug_taxonomy_name ) || is_tax( 'event_tags' ) || is_tax( 'location' ) ) {
				if ( $query->is_post_type_archive( $event_post_type_slug ) || $query->is_tax( $slug_taxonomy_name ) || $query->is_tax( 'event_tags' ) || $query->is_tax( 'location' ) ) {
					$query->set('posts_per_page', OVAEM_Settings::ovaem_list_post_per_page() );
				}
			}	
		}

	}
	

};



//function sub string in word
function sub_string_word ($content = "", $number = 0) {
	
	$content = sanitize_text_field($content);
	
	$number = (int)$number;
	
	if (empty($content) || empty($number)) return $content;
	
	$sub_string = mb_substr($content, 0, $number );
	
	if( $sub_string == $content ) return $content;
	
	return $sub_string.'...';
}


if ( !function_exists('ovaem_pagination_ajax') ) {
	function ovaem_pagination_ajax( $total, $limit, $current  ) {

		$pages = ceil($total / $limit);

		if ($pages > 1) {
			?>
			<ul class="pagination">

				<?php if( $current > 1 ) { ?>
					<li><a href="#" data-paged="<?php echo esc_attr($current - 1); ?>" class="prev page-numbers" ><?php esc_html_e( 'Previous', 'ovaem-events-manager' ); ?></a></li>
				<?php } ?>

				<?php for ($i = 1; $i < $pages+1; $i++) { ?>
					<li class="<?php echo esc_attr( ($current == $i) ? 'active' : '' ); ?>"><a href="#" data-paged="<?php echo esc_attr($i); ?>" class="page-numbers"><?php echo esc_html($i); ?></a></li>
				<?php } ?>

				<?php if( $current < $pages ) { ?>
					<li><a href="#" data-paged="<?php echo esc_attr($current + 1); ?>" class="next page-numbers" ><?php esc_html_e( 'Next', 'ovaem-events-manager' ); ?></a></li>
				<?php } ?>

			</ul>
			<?php
		}
	}
}


if ( !function_exists('ovaem_show_captcha') ) {
	function ovaem_show_captcha() {
		if( apply_filters( 'ovaem_show_captcha', true ) && OVAEM_Settings::captcha_sitekey() && OVAEM_Settings::captcha_serectkey() ){
			return true;
		}
		return false;
	}
}


// Get full list languge calendar
if (! function_exists( 'ovaem_get_calendar_language' )) {
	function ovaem_get_calendar_language() {

		$symbols = array(
			'en-GB' => 'English/UK',
			'ar' => 'Arabic',
			'az' => 'Azerbaijani',
			'bg' => 'Bulgarian',
			'bs' => 'Bosnian',
			'ca' => 'Inicialització',
			'ch' => 'Simplified Chinese',
			'cs' => 'Czech',
			'da' => 'Danish',
			'de' => 'German',
			'el' => 'Greek',
			'en' => 'English',
			'es' => 'Spanish',
			'et' => 'Eesti',
			'eu' => 'Euskara',
			'fa'	=> 'Persian',
			'fi' => 'Finnish',
			'fr' => 'French',
			'gl' => 'Galician',
			'he' => 'Hebrew',
			'hr' => 'Croatian',
			'hu' => 'Hungarian',
			'id' => 'Indonesian',
			'it' => 'Italian',
			'ja' => 'Japanese',
			'ko' => 'Korean',
			'kr' => 'Korean',
			'lt' => 'Lithuanian',
			'lv' => 'Latvian',
			'mk' => 'Macedonian',
			'mn' => 'Mongolian',
			'nl' => 'Dutch',
			'no' => 'Norwegian',
			'pl' => 'Polish',
			'pt' => 'Portuguese',
			'pt-BR' => 'Brazilian',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'se' => 'Swedish',
			'sk' => 'Slovak',
			'sl' => 'Slovenian',
			'sq' => 'Albanian',
			'sr' => 'Serbian',
			'sr-YU' => 'Serbian (Srpski)',
			'sv' => 'Swedish',
			'th' => 'Thai',
			'tr' => 'Turkish',
			'uk' => 'Ukrainian',
			'vi' => 'Vietnamese',
			'zh' => 'Chinese',
			'zh-TW' => 'Chinese (Taiwan)',
		);

		return apply_filters( 'ovaem_get_calendar_language', $symbols );
	}
}

if ( ! function_exists('ovaem_recapcha_verify') ) {
	function ovaem_recapcha_verify( $response, $secret ) {
			#
			# Verify captcha
		$post_data = http_build_query(
			array(
				'secret' => $secret,
				'response' => $response,
				'remoteip' => $_SERVER['REMOTE_ADDR']
			)
		);
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $post_data
			)
		);
		$context  = stream_context_create($opts);
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
		$result = json_decode($response);
		if ( ! $result->success ) {
			return false;
		} else {
			return true;
		}
	}
}

if ( ! function_exists('ovaem_get_product_ids') ) {
	function ovaem_get_product_ids(){
		$args = array(
			'fields' => 'ids',
			'meta_query' => array(
			    array(
		           'key'       => '_price',
		           'compare'   => '>',
		           'value'      => 0,
		           'type' => 'NUMERIC',
	           )
			),
			'tax_query' => array(
			    array(
			        'taxonomy' => 'product_visibility',
			        'field'    => 'name',
			        'terms'    => 'exclude-from-catalog',
			        'operator' => 'IN',
			    ),
			),
			'post_type' => 'product',
			'order' => 'ASC',
			'orderby' => 'name',
		);
		$product_ids = get_posts( $args );
		return $product_ids;
	}
}

/**
* Recursive array replace \\
*/
if( !function_exists('ovaem_recursive_array_replace') ){
	function ovaem_recursive_array_replace( $find, $replace, $array ) {
		if ( ! is_array( $array ) ) {
			return str_replace( $find, $replace, $array );
		}

		foreach ( $array as $key => $value ) {
			$array[$key] = ovaem_recursive_array_replace( $find, $replace, $value );
		}

		return $array;
	}
}

if ( ! function_exists("ovaem_get_list_fields") ) {
	function ovaem_get_list_fields( $list_fields ){
		if ( ! empty( $list_fields ) ):
			foreach ( $list_fields as $key => $field ):
				$name           = $key;
				$type           = array_key_exists( 'type', $field ) ? $field['type'] : '';
				$label          = array_key_exists( 'label', $field ) ? $field['label'] : '';
				$description    = array_key_exists( 'description', $field ) ? $field['description'] : '';
				$placeholder    = array_key_exists( 'placeholder', $field ) ? $field['placeholder'] : '';
				$default        = array_key_exists( 'default', $field ) ? $field['default'] : '';
				$class          = array_key_exists( 'class', $field ) ? $field['class'] : '';
				$position       = array_key_exists( 'position', $field ) ? $field['position'] : '';
				$required       = array_key_exists( 'required', $field ) ? $field['required'] : '';
				$enabled        = array_key_exists( 'enabled', $field ) ? $field['enabled'] : '';
				$max_file_size  = array_key_exists( 'max_file_size', $field ) ? $field['max_file_size'] : 10;

                            // Select
				$ova_options_key    = array_key_exists( 'ova_options_key', $field ) ? $field['ova_options_key'] : [];
				$ova_options_text   = array_key_exists( 'ova_options_text', $field ) ? $field['ova_options_text'] : [];

                            // Radio
				$ova_radio_key      = array_key_exists( 'ova_radio_key', $field ) ? $field['ova_radio_key'] : [];
				$ova_radio_text     = array_key_exists( 'ova_radio_text', $field ) ? $field['ova_radio_text'] : [];

                            // Checkbox
				$ova_checkbox_key      = array_key_exists( 'ova_checkbox_key', $field ) ? $field['ova_checkbox_key'] : [];
				$ova_checkbox_text     = array_key_exists( 'ova_checkbox_text', $field ) ? $field['ova_checkbox_text'] : [];

				$required_status    = $required ? '<span class="dashicons dashicons-yes tips" data-tip="Yes"></span>' : '-';
				$enabled_status     = $enabled ? '<span class="dashicons dashicons-yes tips" data-tip="Yes"></span>' : '-';

				$class_disable  = ! $enabled ? 'class="ova-disable"' : '';
				$disable_button = ! $enabled ? 'disabled' : '';
				$value_enabled  = ( $enabled == 'on' ) ? $name : '';

				$data_edit = [
					'required'          => $required,
					'name'              => $name,
					'type'              => $type,
					'label'             => $label,
					'description'       => $description,
					'placeholder'       => $placeholder,
					'default'           => $default,
					'class'             => $class,
					'position'          => $position,
					'ova_options_key'   => $ova_options_key,
					'ova_options_text'  => $ova_options_text,
					'ova_radio_key'     => $ova_radio_key,
					'ova_radio_text'    => $ova_radio_text,
					'ova_checkbox_key'  => $ova_checkbox_key,
					'ova_checkbox_text' => $ova_checkbox_text,
					'max_file_size'     => $max_file_size,
				];

				$data_edit = json_encode( $data_edit );
				?>
				<tr <?php echo $class_disable; ?>>
					<input type="hidden" name="remove_field[]" value="">
					<input type="hidden" name="enable_field[]" value="<?php echo esc_attr( $value_enabled ); ?>">
					<input type="hidden" class="ova_pos_name" data-name="<?php echo esc_attr( $name ); ?>" />
					<td class="ova-checkbox">
						<input type="checkbox" name="select_field[]" value="<?php echo esc_attr( $name ); ?>" />
					</td>
					<td class="ova-name"><?php echo esc_html( $key ); ?></td>
					<td class="ova-type"><?php echo esc_html( $type ); ?></td>
					<td class="ova-label"><?php echo esc_html( $label ); ?></td>
					<td class="ova-placeholder"><?php echo esc_html( $placeholder ); ?></td>
					<td class="ova-require status"><?php echo $required_status; ?></td>
					<td class="ova-enable status"><?php echo $enabled_status; ?></td>
					<td class="ova-edit edit">
						<button type="button" <?php echo esc_attr( $disable_button ); ?> class="button ova-button ovalg_edit_field_form" data-data_edit="<?php echo esc_attr( $data_edit ); ?>">
							<?php esc_html_e( 'Edit', 'ovaem-events-manager' ) ?>
						</button>
					</td>
				</tr>
			<?php endforeach;
		endif;
	}
}

if ( ! function_exists("ovaem_sortby_position") ) {
	function ovaem_sortby_position( $list_fields ){
		$arr_sorted = array();
		$arr_name_pos = array();

		if ( $list_fields ) {
		// Add position => name to arr_name_pos
			foreach ( $list_fields as $key => $item ) {
				$position =  isset( $item['position'] ) ? $item['position'] : 0;
				if ( $position == '' ) {
					return $list_fields;
				}
				$arr_name_pos[$position] = $key;
			}

			ksort($arr_name_pos, SORT_NUMERIC);

			foreach ($arr_name_pos as $name) {
				$arr_sorted[$name] = $list_fields[$name];
			}
		}
		return $arr_sorted;
	}
}

if ( ! function_exists( 'ovaem_cfc_get_name_type' ) ) {
	function ovaem_cfc_get_name_type(){
		$custom_field_checkout = get_option( 'ova_checkout_form' );
		$result = array();
		if ( $custom_field_checkout ) {
			foreach ($custom_field_checkout as $name => $field) {
				$result[$name] = $field['type'];
			}
		}
		return $result;
	}
}

if ( ! function_exists('ovaem_get_booking_by_order_woo_id') ) {
	function ovaem_get_booking_by_order_woo_id( $woo_order_id ){
		$args = array(
			'post_type' => 'event_order',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_key' => 'ovaem_order_woo_id',
			'meta_value' => $woo_order_id,
			'fields' => 'ids',
		);
		$order_ids = get_posts( $args );
		return $order_ids;
	}
}

if ( ! function_exists('ovaem_get_ticket_by_order_woo_id') ) {
	function ovaem_get_ticket_by_order_woo_id( $woo_order_id ){
		$args = array(
			'post_type' => 'event_ticket',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_key' => 'ovaem_ticket_from_woo_order_id',
			'meta_value' => $woo_order_id,
			'fields' => 'ids',
		);
		$ticket_ids = get_posts( $args );
		return $ticket_ids;
	}
}
