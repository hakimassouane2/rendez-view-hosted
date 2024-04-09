<?php

// Get all file name in header
if( !function_exists( 'em4u_load_header' )):
function em4u_load_header(){
	$files = array(
        'default' => esc_html__("default","em4u"), 
        'version1' => esc_html__("version1","em4u"),
        'version2' => esc_html__("version2","em4u"),
        'version3' => esc_html__("version3","em4u"),
        'version4' => esc_html__("version4","em4u"),
        'version5' => esc_html__("version5","em4u")
    );
	return $files;
}
endif;

// Set header in metabox default
if( !function_exists( 'em4u_load_header_metabox' )):
function em4u_load_header_metabox(){
    $files = array(
        'global' => esc_html__("Global in Customizer","em4u") ,
        'default' => esc_html__("default","em4u" ),
        'version1' => esc_html__("version1","em4u"),
        'version2' => esc_html__("version2","em4u"),
        'version3' => esc_html__("version3","em4u"),
        'version4' => esc_html__("version4","em4u"),
        'version5' => esc_html__("version5","em4u")

    );
    return $files;
}
endif;




// Get all file name in footer
if( !function_exists( 'em4u_load_footer' )):
function em4u_load_footer(){
	$files = array(
        'default' => esc_html__("default","em4u"),
        'version1' => esc_html__("version1", "em4u"),
        'version2' => esc_html__("version2", "em4u"),
        'version3' => esc_html__("version3", "em4u"),
        'version4' => esc_html__("version4", "em4u")
    );
	return $files;
}
endif;

// Set footer in metabox default
if( !function_exists( 'em4u_load_footer_metabox' )):
function em4u_load_footer_metabox(){
    $files = array(
        'global' => esc_html__("Global in Customizer","em4u"),
        'default' => esc_html__("default","em4u"),
        'version1' => esc_html__("version1","em4u"),
        'version2' => esc_html__("version2","em4u"),
        'version3' => esc_html__("version3","em4u"),
        'version4' => esc_html__("version4","em4u")
    );
    return $files;
}
endif;



/********************************************************************/
/********************************************************************/
// Get current header
if( !function_exists( 'em4u_get_current_header' )):
function em4u_get_current_header(){

    // Get header from Post / Page setting
    $current_id = em4u_get_current_id();

	// Get header default from customizer
	$customizer_header = get_theme_mod('header_version','version1');
    $meta_header = get_post_meta($current_id,'em4u_met_header_version', 'true');

    // Blog Archive
    $post_type = get_post_type();
    if ( ! is_single() ) {
        switch ( $post_type ) {
            case 'post':
                $customizer_header = get_theme_mod('header_version_blog_archive','version1');
                return $customizer_header;
                break;
            case 'event':
                $customizer_header = get_theme_mod('header_version_event_archive','version1');
                return $customizer_header;
                break;
            
            default:
                break;
        }
    }

  	$header = ( $current_id != '' && $meta_header != 'global' && $meta_header != '' ) ? $meta_header : $customizer_header;
	return $header;
}
endif;

// Get current footer
if( !function_exists( 'em4u_get_current_footer' )):
function em4u_get_current_footer(){

    // Get footer from Post / Page setting
    $current_id = em4u_get_current_id();

	// Get header default from customizer
	$customizer_footer = get_theme_mod('footer_version','default');
    $meta_footer =  get_post_meta($current_id,'em4u_met_footer_version', 'true');
	
  	$footer = ( $current_id != '' && $meta_footer != 'global'  && $meta_footer != '' ) ? $meta_footer : $customizer_footer;
	
    return $footer;
}
endif;


// Get current main layout
if( !function_exists( 'em4u_get_current_main_layout' )):
function em4u_get_current_main_layout(){

    // Get mainlayout from Post / Page setting
    $current_id = em4u_get_current_id();

    // Get header default from customizer
    $customizer_main_layout = get_theme_mod('main_layout','right_sidebar');
    $meta_main_layout = get_post_meta($current_id,'em4u_met_main_layout', 'true');
    
    $mainlayout = ( $current_id != '' && $meta_main_layout != 'global' && $meta_main_layout != '' ) ? $meta_main_layout : $customizer_main_layout;

    return $mainlayout;
}
endif;

// Get current width site
if( !function_exists( 'em4u_get_current_width_site' )):
function em4u_get_current_width_site(){

    // Get mainlayout from Post / Page setting
    $current_id = em4u_get_current_id();

    // Get header default from customizer
    $customizer_width_site = get_theme_mod('width_site','wide');
    $meta_width_site = get_post_meta($current_id,'em4u_met_width_site', 'true');
    
    $width_site = ( $current_id != '' && $meta_width_site != 'global' && $meta_width_site != '' ) ? $meta_width_site : $customizer_width_site;
    return $width_site;
}
endif;

// Get current ID of post/page, etc
if( !function_exists( 'em4u_get_current_id' )):
function em4u_get_current_id(){
	
    $current_page_id = '';
    // Get The Page ID You Need
    //wp_reset_postdata();
    if(class_exists("woocommerce")) {
        if( is_shop() ){ ///|| is_product_category() || is_product_tag()) {
            $current_page_id  =  get_option ( 'woocommerce_shop_page_id' );
        }elseif(is_cart()) {
            $current_page_id  =  get_option ( 'woocommerce_cart_page_id' );
        }elseif(is_checkout()){
            $current_page_id  =  get_option ( 'woocommerce_checkout_page_id' );
        }elseif(is_account_page()){
            $current_page_id  =  get_option ( 'woocommerce_myaccount_page_id' );
        }elseif(is_view_order_page()){
            $current_page_id  = get_option ( 'woocommerce_view_order_page_id' );
        }
    }
    if($current_page_id=='') {
        if ( is_home () && is_front_page () ) {
            $current_page_id = '';
        } elseif ( is_home () ) {
            $current_page_id = get_option ( 'page_for_posts' );
        } elseif ( is_search () || is_category () || is_tag () || is_tax () || is_archive() ) {
            $current_page_id = '';
        } elseif ( !is_404 () ) {
           $current_page_id = get_the_id();
        } 
    }

    return $current_page_id;
}
endif;




// Get width sidebar
if( !function_exists( 'em4u_width_sidebar' )):
function em4u_width_sidebar($special_layout){
    $main_layout = $special_layout ? $special_layout : em4u_get_current_main_layout();
    $sidebar_column = get_theme_mod('sidebar_column','4');
    
    $col_width_sidebar = '';

    if($main_layout == 'left_sidebar'){
        switch ($sidebar_column) {

            case 1:
                $col_width_sidebar = 'col-md-1 col-md-pull-11';
                break;
            case 2:
                $col_width_sidebar = 'col-md-2 col-md-pull-10';
                break;
            case 3:
                $col_width_sidebar = 'col-md-3 col-md-pull-9';
                break;
            case 4:
                $col_width_sidebar = 'col-md-4 col-md-pull-8';
                break;
            case 5:
                $col_width_sidebar = 'col-md-5 col-md-pull-7';
                break;
            case 6:
                $col_width_sidebar = 'col-md-6 col-md-pull-6';
                break;
            default:
                $col_width_sidebar = 'col-md-4 col-md-pull-8';
                break;
        }


    }else if($main_layout == 'right_sidebar'){

        switch ($sidebar_column) {
            case 1:
                $col_width_sidebar = 'col-md-1';
                break;
            case 2:
                $col_width_sidebar = 'col-md-2';
                break;
            case 3:
                $col_width_sidebar = 'col-md-3';
                break;
            case 4:
                $col_width_sidebar = 'col-md-4';
                break;
            case 5:
                $col_width_sidebar = 'col-md-5';
                break;
            case 6:
                $col_width_sidebar = 'col-md-6';
                break;
            default:
                $col_width_sidebar = 'col-md-4';
                break;
        }

    }else if($main_layout == 'no_sidebar' || $main_layout == 'fullwidth'){

        $col_width_sidebar = '';

    }
    
    return $col_width_sidebar;
}
endif;

// Get main sidebar
if( !function_exists( 'em4u_width_main_content' )):
function em4u_width_main_content($special_layout){
    $main_layout = $special_layout != '' ? $special_layout : em4u_get_current_main_layout();
    $main_column = get_theme_mod('main_column','8');

    $col_width_main = '';

    if($main_layout == 'left_sidebar'){

        switch ($main_column) {
            case 6:
                $col_width_main = 'col-md-6 col-md-push-6';
                break;
            case 7:
                $col_width_main = 'col-md-7 col-md-push-5';
                break;
            case 8:
                $col_width_main = 'col-md-8 col-md-push-4';
                break;
            case 9:
                $col_width_main = 'col-md-9 col-md-push-3';
                break;
            case 10:
                $col_width_main = 'col-md-10 col-md-push-2';
                break;
            case 11:
                $col_width_main = 'col-md-11 col-md-push-1';    
                break;
            default:
                $col_width_main = 'col-md-8 col-md-push-4';
                break;
        }

    }else if($main_layout == 'right_sidebar'){

        switch ($main_column) {
            case 6:
                $col_width_main = 'col-md-6';
                break;
            case 7:
                $col_width_main = 'col-md-7';
                break;
            case 8:
                $col_width_main = 'col-md-8';
                break;
            case 9:
                $col_width_main = 'col-md-9';
                break;
            case 10:
                $col_width_main = 'col-md-10';
                break;
            case 11:
                $col_width_main = 'col-md-11';    
                break;
            default:
                $col_width_main = 'col-md-8';
                break;
        }

    }else if($main_layout == 'no_sidebar'){

        $col_width_main = 'col-md-12';

    }else if($main_layout == 'fullwidth'){

        $col_width_main = '';

    }

    return $col_width_main;

}
endif;



// Get Woo width sidebar
if( !function_exists( 'em4u_woo_width_sidebar' )):
function em4u_woo_width_sidebar(){
    $main_layout = isset( $_GET["woo_layout"] ) ? $_GET["woo_layout"] : get_theme_mod('woo_layout','right_sidebar');
    $sidebar_column =  get_theme_mod('woo_sidebar_column','4');
    
    $col_width_sidebar = '';

    if($main_layout == 'left_sidebar'){
        switch ($sidebar_column) {

            case 1:
                $col_width_sidebar = 'col-md-1 col-md-pull-11';
                break;
            case 2:
                $col_width_sidebar = 'col-md-2 col-md-pull-10';
                break;
            case 3:
                $col_width_sidebar = 'col-md-3 col-md-pull-9';
                break;
            case 4:
                $col_width_sidebar = 'col-md-4 col-md-pull-8';
                break;
            case 5:
                $col_width_sidebar = 'col-md-5 col-md-pull-7';
                break;
            case 6:
                $col_width_sidebar = 'col-md-6 col-md-pull-6';
                break;
            default:
                $col_width_sidebar = 'col-md-4 col-md-pull-8';
                break;
        }


    }else if($main_layout == 'right_sidebar'){

        switch ($sidebar_column) {
            case 1:
                $col_width_sidebar = 'col-md-1';
                break;
            case 2:
                $col_width_sidebar = 'col-md-2';
                break;
            case 3:
                $col_width_sidebar = 'col-md-3';
                break;
            case 4:
                $col_width_sidebar = 'col-md-4';
                break;
            case 5:
                $col_width_sidebar = 'col-md-5';
                break;
            case 6:
                $col_width_sidebar = 'col-md-6';
                break;
            default:
                $col_width_sidebar = 'col-md-4';
                break;
        }

    }else if($main_layout == 'no_sidebar' || $main_layout == 'fullwidth'){

        $col_width_sidebar = '';

    }
    
    return $col_width_sidebar;
}
endif;

// Get woo main sidebar
if( !function_exists( 'em4u_woo_width_main_content' )):
function em4u_woo_width_main_content(){
    
    $main_layout = isset( $_GET["woo_layout"] ) ? $_GET["woo_layout"] : get_theme_mod('woo_layout','right_sidebar');
    $main_column = get_theme_mod('woo_main_column','8');

    $col_width_main = '';

    if($main_layout == 'left_sidebar'){

        switch ($main_column) {
            case 6:
                $col_width_main = 'col-md-6 col-md-push-6';
                break;
            case 7:
                $col_width_main = 'col-md-7 col-md-push-5';
                break;
            case 8:
                $col_width_main = 'col-md-8 col-md-push-4';
                break;
            case 9:
                $col_width_main = 'col-md-9 col-md-push-3';
                break;
            case 10:
                $col_width_main = 'col-md-10 col-md-push-2';
                break;
            case 11:
                $col_width_main = 'col-md-11 col-md-push-1';    
                break;
            default:
                $col_width_main = 'col-md-8 col-md-push-4';
                break;
        }

    }else if($main_layout == 'right_sidebar'){

        switch ($main_column) {
            case 6:
                $col_width_main = 'col-md-6';
                break;
            case 7:
                $col_width_main = 'col-md-7';
                break;
            case 8:
                $col_width_main = 'col-md-8';
                break;
            case 9:
                $col_width_main = 'col-md-9';
                break;
            case 10:
                $col_width_main = 'col-md-10';
                break;
            case 11:
                $col_width_main = 'col-md-11';    
                break;
            default:
                $col_width_main = 'col-md-8';
                break;
        }

    }else if($main_layout == 'no_sidebar'){

        $col_width_main = 'col-md-12';

    }else if($main_layout == 'fullwidth'){

        $col_width_main = '';

    }

    return $col_width_main;

}
endif;

if( !function_exists( 'em4u_pagination_theme' )):
function em4u_pagination_theme() {
           
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
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
 
    echo wp_kses( __( '<div class="blog_pagination"><ul class="pagination">','em4u' ), true ) . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="prev page-numbers">%s</li>' . "\n", get_previous_posts_link('<i class="arrow_carrot-left"></i>') );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo wp_kses( __('<li><span class="pagi_dots">...</span></li>', 'em4u' ) , true);
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
            echo wp_kses( __('<li><span class="pagi_dots">...</span></li>', 'em4u' ) , true) . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="next page-numbers">%s</li>' . "\n", get_next_posts_link('<i class="arrow_carrot-right"></i>') );
 
    echo wp_kses( __( '</ul></div>', 'em4u' ), true ) . "\n";
 
}
endif;



/* Setup Theme */
/* Add theme support */
add_action('after_setup_theme', 'em4u_theme_support', 10);
add_filter('oembed_result', 'em4u_framework_fix_oembeb', 10 );
add_filter('paginate_links', 'em4u_fix_pagination_error',10);
add_action( 'admin_enqueue_scripts', 'em4u_wpadminjs' ); 

function em4u_theme_support(){

    if ( ! isset( $content_width ) ) $content_width = 900;

    add_theme_support('title-tag');

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // Switches default core markup for search form, comment form, and comments    
    // to output valid HTML5.
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

    /* See http://codex.wordpress.org/Post_Formats */
    add_theme_support( 'post-formats', array( 'image', 'gallery', 'audio', 'video') );

    add_theme_support( 'post-thumbnails' );
    
    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background');

    add_theme_support( 'woocommerce' );

    add_filter('gutenberg_use_widgets_block_editor', '__return_false');
    add_filter('use_widgets_block_editor', '__return_false');
    
}



function em4u_framework_fix_oembeb( $url ){
    $array = array (
        'webkitallowfullscreen'     => '',
        'mozallowfullscreen'        => '',
        'frameborder="0"'           => '',
        '</iframe>)'        => '</iframe>'
    );
    $url = strtr( $url, $array );

    if ( strpos( $url, "<embed src=" ) !== false ){
        return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $url);
    }
    elseif ( strpos ( $url, 'feature=oembed' ) !== false ){
        return str_replace( 'feature=oembed', 'feature=oembed&amp;wmode=opaque', $url );
    }
    else{
        return $url;
    }
}


// Fix pagination
function em4u_fix_pagination_error($link) {
    return str_replace('#038;', '&', $link);
}

function em4u_wpadminjs() {
    wp_enqueue_style('em4u_fixcssadmin', EM4U_URI.'/extend/cssadmin.css',  false, '1.0');
}


add_action('init', 'em4u_vc_add_param', 10);
function em4u_vc_add_param(){
    /* Visual Composer */
    if(function_exists('vc_add_param')){

      /* Customize Row element */   
      $vc_row_attributes = array(
        
         array("type" => "dropdown",
            "heading" => esc_html__('Display Container', 'em4u'),
            "param_name" => 'display_container',
            'value' => array( "false", "true"),
            
        ),
        array("type" => "colorpicker",
            "heading" => esc_html__('Background pattern color ', 'em4u'),
            "param_name" => 'ova_bg_pattern',
            "default"   => ''
        )

       
        

      );
      vc_add_params( 'vc_row', $vc_row_attributes );
      /* /Customize Row element */  

     
      
    }
}

// Get title in header
function em4u_the_title(){

    $event_single = 'false';
    $speaker_single = 'false';
    $venue_single = 'false';
    $event_search = $regis_free_event = '';
    if( class_exists('OVAEM') ){
        $event_posttype = OVAEM_Settings::event_post_type_slug();
        $speker_posttype = OVAEM_Settings::speaker_post_type_slug();
        $venue_posttype = OVAEM_Settings::venue_post_type_slug();

        $event_single = is_singular( $event_posttype ) ? 'true' : 'false';
        $speaker_single = is_singular( $speker_posttype ) ? 'true' : 'false';
        $venue_single = is_singular( $venue_posttype ) ? 'true' : 'false';
        $event_search = isset( $_GET["search"] ) ? $_GET["search"] : '';
        $regis_free_event = isset( $_GET["regis_free_event"] ) ? $_GET["regis_free_event"] : '';
    }

    
    if ( is_front_page() && is_home() ) {
      // Default homepage
    } elseif ( is_front_page() ) {
      // static homepage
    } elseif ( is_home() ) {
      // blog page
    } else {
      //everything else
    }

  
    if ( is_home () && is_front_page () ) {
        
        return esc_html__('Home','em4u');

    } elseif ( is_front_page() ) {
        
        return esc_html__('Home','em4u');

    }elseif ( is_home () ) {

        return esc_html__('Blog Page','em4u');

    } elseif ( is_search () ) {

        return esc_html__('Search','em4u');

    } else if(is_category () ){

        return single_cat_title('');

    }else if (is_tag ()){

        return esc_html__('Tags','em4u');

    }else if( class_exists('OVAEM') && $event_single == 'true' ){
        
        return get_the_title();

    }else if( class_exists('OVAEM') && $speaker_single == 'true' ){

        return get_the_title();

    }else if( class_exists('OVAEM') && $venue_single == 'true' ){

        return get_the_title();

    }else if( class_exists('OVAEM') && $event_search == 'search-event' ){

        return esc_html__( 'Search Event', 'em4u' );

    }else if( class_exists('OVAEM') && $regis_free_event != '' ){
        
        return esc_html__( 'Register Event', 'em4u' );

    }else if( is_tax () || is_archive() ){

        return get_the_archive_title();

    }else if( is_singular( 'post' ) ){
        return get_the_title();
    }else if( is_singular( 'product' ) ){
        return get_the_title();
    }elseif ( !is_404 () ) {

       return get_the_title();

    }

}

function em4u_wp_body_classes( $classes ) {
    $scroll_top = get_theme_mod( 'scroll_top', 'totop' );
    $classes[] = $scroll_top;
      
    return $classes;
}
add_filter( 'body_class','em4u_wp_body_classes' );



add_filter( 'get_the_archive_title','em4u_get_the_archive_title' );
function em4u_get_the_archive_title( $title ){
    if ( is_category() ) {
        /* translators: Category archive title. 1: Category name */
        $title = esc_html__( 'Category', 'em4u' ).' '.single_cat_title( '', false );
    } elseif ( is_tag() ) {
        /* translators: Tag archive title. 1: Tag name */
        $title = esc_html__( 'Tag', 'em4u' ).' '.single_tag_title( '', false );
    } elseif ( is_author() ) {
        /* translators: Author archive title. 1: Author name */
        $title = esc_html__( 'Author', 'em4u' ).' <span class="vcard">'.get_the_author(). '</span>' ;
    } elseif ( is_year() ) {
        /* translators: Yearly archive title. 1: Year */
        $title = esc_html__( 'Year:', 'em4u' ).' '.get_the_date( _x( 'Y', 'yearly archives date format' ) );
    } elseif ( is_month() ) {
        /* translators: Monthly archive title. 1: Month name and year */
        $title = esc_html__( 'Month:', 'em4u' ).' '.get_the_date( _x( 'F Y', 'monthly archives date format' ) );
    } elseif ( is_day() ) {
        /* translators: Daily archive title. 1: Date */
        $title = esc_html__( 'Day:', 'em4u' ).' '.get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
    } elseif ( is_tax( 'post_format' ) ) {
        if ( is_tax( 'post_format', 'post-format-aside' ) ) {
            $title = _x( 'Asides', 'em4u' );
        } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
            $title = _x( 'Galleries', 'em4u' );
        } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
            $title = _x( 'Images', 'em4u' );
        } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
            $title = _x( 'Videos', 'em4u' );
        } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
            $title = _x( 'Quotes', 'em4u' );
        } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
            $title = _x( 'Links', 'em4u' );
        } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
            $title = _x( 'Statuses', 'em4u' );
        } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
            $title = _x( 'Audio', 'em4u' );
        } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
            $title = _x( 'Chats', 'em4u' );
        }
    } elseif ( is_post_type_archive() ) {
        /* translators: Post type archive title. 1: Post type name */
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $tax = get_taxonomy( get_queried_object()->taxonomy );
        /* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
        $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
    } else {
        $title = esc_html__( 'Archives:', 'em4u' );
    }
    return $title;
}




function em4u_wpdocs_theme_add_editor_styles() {
    add_editor_style( EM4U_URI.'/assets/css/custom-editor-style.css' );
}
add_action( 'admin_init', 'em4u_wpdocs_theme_add_editor_styles' );