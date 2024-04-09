<?php



add_action('wp_enqueue_scripts', 'em4u_theme_scripts_styles');
add_action('wp_enqueue_scripts', 'em4u_primary_color' );



function em4u_theme_scripts_styles() {


    /* Google Font */
    wp_enqueue_style( 'em4u-fonts', em4u_customize_google_fonts(), array(), null );

    // enqueue the javascript that performs in-link comment reply fanciness
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' ); 
    }

    
    /* Add Javascript  */
    wp_enqueue_script('bootstrap', EM4U_URI.'/assets/plugins/bootstrap/js/bootstrap.min.js', array('jquery'),null,true);
    wp_enqueue_script('owlcarousel', EM4U_URI.'/assets/plugins/owlcarousel2/owl.carousel.min.js', array('jquery'),null,true);
    wp_enqueue_script('bootstrap-select', EM4U_URI.'/assets/plugins/bootstrap-select/js/bootstrap-select.min.js', array('jquery'),null,true);
    
    
    

    wp_enqueue_script('nav', EM4U_URI.'/assets/plugins/jquery.nav.js', array('jquery'),null,true);    
    wp_enqueue_script('scrollto', EM4U_URI.'/assets/plugins/scrollto.js', array('jquery'),null,true);    
    wp_enqueue_script('placeholders', EM4U_URI.'/assets/plugins/placeholders.jquery.min.js', array('jquery'),null,true);
    
    
    wp_enqueue_script('em4u-theme-js', EM4U_URI.'/assets/js/theme.js', array('jquery'),null,true);
   


    /* Add Css  */
    wp_enqueue_style('bootstrap', EM4U_URI.'/assets/plugins/bootstrap/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('owlcarousel', EM4U_URI.'/assets/plugins/owlcarousel2/assets/owl.carousel.min.css', array(),null);
    wp_enqueue_style('fontawesome', EM4U_URI.'/assets/plugins/fontawesome/css/all.min.css', array(), null);
    wp_enqueue_style('v4-shims', EM4U_URI.'/assets/plugins/fontawesome/css/v4-shims.min.css', array(), null);
    wp_enqueue_style('eleganticons', EM4U_URI.'/assets/plugins/eleganticons/style.css', array(), null);
    wp_enqueue_style('flaticon', EM4U_URI.'/assets/plugins/flaticon/flaticon.css', array(), null);
    
    wp_enqueue_style('bootstrap-select', EM4U_URI.'/assets/plugins/bootstrap-select/css/bootstrap-select.min.css', array(), null);

    wp_enqueue_style('default_theme', EM4U_URI.'/assets/css/default_theme.css', array(), null);
    
    if ( is_child_theme() ) {
      wp_enqueue_style( 'parent-style', trailingslashit( get_template_directory_uri() ) . 'style.css', array(), null );
    }

    wp_enqueue_style( 'em4u-style', get_stylesheet_uri(), array(), null );

}

/**
 * Add Respond.js for IE
 */
if( !function_exists('em4u_script_ie')) {
    function em4u_script_ie() {
        echo '<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->';
        echo ' <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->';
        echo ' <!--[if lt IE 9]>';
        echo ' <script src="'.EM4U_URI.'/assets/plugins/iesupport/html5shiv.min.js"></script>';
        echo ' <script src="'.EM4U_URI.'/assets/plugins/iesupport/respond.min.js"></script>';
        echo ' <![endif]-->';
    }
    add_action('wp_head', 'em4u_script_ie');
} // end if


    
    
      
      
    



function em4u_primary_color(){

  $main_color = get_theme_mod('main_color', '#f53f7b' );
  $second_color = get_theme_mod('second_color', '#4862c4' );

  $body_font = str_replace( 'ovatheme_','',get_theme_mod('body_font', 'Poppins') );

  $bg_cover = em4u_hex2rgb( $second_color );
  $bg_main = em4u_hex2rgb( $main_color );

  $header_menu_color = get_theme_mod( 'header_menu_color', '#fff' );
  $header_menu_color_scroll = get_theme_mod( 'header_menu_color_scroll', '#fff' );

  $em4u_met_bg_color_header =  get_post_meta( get_the_id(), 'em4u_met_bg_color_header' );
  $em4u_met_bg_color_header_opacity =  get_post_meta( get_the_id(), 'em4u_met_bg_color_header_opacity' );

  $bg_color_header = em4u_hex2rgb( get_theme_mod( 'bg_color_header', '#000' ) );

  if( !empty( $em4u_met_bg_color_header ) ){
    $bg_color_header = em4u_hex2rgb( $em4u_met_bg_color_header[0]) ;
  }

  $bg_color_header_scroll = em4u_hex2rgb( get_theme_mod( 'bg_color_header_scroll', '#000' ) );


  $bg_color_header_opacity = get_theme_mod( 'bg_color_header_opacity', '0.6' );

  if( !empty( $em4u_met_bg_color_header_opacity )  ){
    $bg_color_header_opacity = $em4u_met_bg_color_header_opacity[0];
  }

  $bg_color_header_scroll_opacity = get_theme_mod( 'bg_color_header_scroll_opacity', '1' );

  $header_login_color = get_theme_mod( 'header_login_color', '#fff' );
  $header_login_b_color = get_theme_mod( 'header_login_b_color', '#f53f7b' );

  $header_register_color = get_theme_mod( 'header_register_color', '#fff' );
  $header_register_b_color = get_theme_mod( 'header_register_b_color', '#4862c4' );



    $header_login_color_s = get_theme_mod( 'header_login_color_s', '#fff' );
    $header_login_b_color_s = get_theme_mod( 'header_login_b_color_s', '#f53f7b' );

    $header_register_color_s = get_theme_mod( 'header_register_color_s', '#fff' );
    $header_register_b_color_s = get_theme_mod( 'header_register_b_color_s', '#4862c4' );


    $header_login_color_m = get_theme_mod( 'header_login_color_m', '#fff' );
    $header_login_b_color_m = get_theme_mod( 'header_login_b_color_m', '#f53f7b' );

    $header_register_color_m = get_theme_mod( 'header_register_color_m', '#fff' );
    $header_register_b_color_m = get_theme_mod( 'header_register_b_color_m', '#4862c4' );

  $custom_css = "

    body{
      font-family: {$body_font}, sans-serif;
    }

    /* Account Color */
    .ova-account a.ova_icon_open i{
        color: $header_login_color;
    }
    .ova-account a.ova_icon_open{
        border-color: $header_login_b_color;
    }
    .ova-account a.ova_icon_open:hover i{
        background-color: $header_login_b_color;
        color: #fff;
    }

    .ova-account a.ova_icon_key i{
        color: $header_register_color;
    }
    .ova-account a.ova_icon_key{
        border-color: $header_register_b_color;
    }
    .ova-account a.ova_icon_key:hover i{
        background-color: $header_register_b_color;
        color: #fff;
    }


    /* Account Color Scroll */
    header.shrink .ova-account a.ova_icon_open i{
        color: $header_login_color_s;
    }
    header.shrink .ova-account a.ova_icon_open{
        border-color: $header_login_b_color_s;
    }
    header.shrink .ova-account a.ova_icon_open:hover i{
        background-color: $header_login_b_color_s;
        color: #fff;
    }

    header.shrink .ova-account a.ova_icon_key i{
        color: $header_register_color_s;
    }
    header.shrink .ova-account a.ova_icon_key{
        border-color: $header_register_b_color_s;
    }
    header.shrink .ova-account a.ova_icon_key:hover i{
        background-color: $header_register_b_color_s;
        color: #fff;
    }

    @media( max-width: 993px ){
        header.shrink .ova-account a.ova_icon_open i,
        .ova-account a.ova_icon_open i{
            color: $header_login_color_m;
        }
        header.shrink .ova-account a.ova_icon_open,
        .ova-account a.ova_icon_open{
            border-color: $header_login_b_color_m;
        }
        header.shrink .ova-account a.ova_icon_open:hover i,
        .ova-account a.ova_icon_open:hover i{
            background-color: $header_login_b_color_m;
            color: #fff;
        }

        header.shrink .ova-account a.ova_icon_key i,
        .ova-account a.ova_icon_key i{
            color: $header_register_color_m;
        }
        header.shrink .ova-account a.ova_icon_key,
        .ova-account a.ova_icon_key{
            border-color: $header_register_b_color_m;
        }

        header.shrink .ova-account a.ova_icon_key:hover i,
        .ova-account a.ova_icon_key:hover i{
            background-color: $header_register_b_color_m;
            color: #fff;
        }
    }

    

    /* Header Version */
    
    
    .ova_header.ovatheme_header_v3 .scroll_fixed,
    .ova_header.ovatheme_header_v2 .scroll_fixed,
    .ovatheme_header_v1 .wrap_menu_logo{
        background-color: rgba( $bg_color_header[0],$bg_color_header[1],$bg_color_header[2], $bg_color_header_opacity );
    }

    .ova_header.ovatheme_header_v4.fixed.shrink .scroll_fixed,
    .ova_header.ovatheme_header_v3.fixed.shrink .scroll_fixed,
    .ova_header.ovatheme_header_v2.fixed.shrink .scroll_fixed,
    .ovatheme_header_v1.ova_header.fixed.shrink .wrap_menu_logo{
        background-color: rgba( $bg_color_header_scroll[0],$bg_color_header_scroll[1],$bg_color_header_scroll[2], $bg_color_header_scroll_opacity );
    }


    header.ova_header ul.navbar-nav>li>a{
        color: $header_menu_color;
    }
    header.ova_header.fixed.shrink ul.navbar-nav>li>a{
        color: $header_menu_color_scroll;
    }

    .ovatheme_header_v4 .ova-menu #ovatheme_header_v4 ul.nav>li>a,
    .ovatheme_header_v3.bg_heading .ova-menu nav.navbar>ul>li>a,
    .ovatheme_header_v2.bg_heading .ova-menu ul.navbar-nav>li>a,
    .ovatheme_header_v1.bg_heading .ova-menu ul.navbar-nav>li>a{
        color: $header_menu_color;   
    }

    .ovatheme_header_v4.bg_heading.fixed.shrink .ova-menu #ovatheme_header_v4 ul.nav>li>a,
    .ovatheme_header_v3.bg_heading.fixed.shrink .ova-menu nav.navbar>ul>li > a,
    .ovatheme_header_v2.bg_heading.fixed.shrink .ova-menu ul.navbar-nav>li>a,
    .ovatheme_header_v1.bg_heading.fixed.shrink .ova-menu ul.navbar-nav>li>a{
        color: $header_menu_color_scroll;   
    }

    .ovatheme_header_v4 .ova-menu #ovatheme_header_v4 ul.nav > li .dropdown-menu li a:hover,
    .ova_header ul.nav > li > a:hover,
    .map-info-window h2.caption-title a{
        color: $main_color!important;
    }
    

    a,
    .ova_single_venue .tab_content .tab-content .ovaem_schedule .wrap_content .content_side .speaker_info .speaker_job, 
    .ova_single_event .tab_content .tab-content .ovaem_schedule .wrap_content .content_side .speaker_info .speaker_job,
    .ova-btn i
    {
     color: $second_color;    
    }



    nav.navbar li.active>a{
      color: $main_color!important;
    }
    .event-calendar-sync a,
    a:hover


    {
     color: $main_color; 
    }

    
    .ovaem_search_event form input.ovame_submit:hover,
    .ova_search_v1.ovaem_search_event .ovaem_submit input:hover,
    .ovaem_search_event .ovaem_submit input:hover,
    .ovaem_events_filter .ovaem_events_filter_nav li.current a,
    .ovaem_events_filter .ovaem_events_filter_nav li a:hover,
    .ovaem_events_filter .ovaem_events_filter_content .ova-item:hover .wrap_content .more_detail .btn_link,
    .ovaem_events_filter .ovaem_events_filter_nav.style4 li.current a,
    footer.footer_v3 .wrap_top .subcribe .ova_mailchimp input.submit,
    .ovame_tickets .wrap_tickets .wrap_content .ovaem_register .ova-btn:hover,
    .ovaem_archives_event.list .ovaem_search .ovaem_search_event input, 
    .ovaem_archives_event.list .ovaem_search .ovaem_search_event select, 
    .ovaem_archives_event.list .ovaem_search .ovaem_search_event .btn.dropdown-toggle,
    .pagination-wrapper .pagination>li.active a, .pagination-wrapper .pagination>li>a:focus, 
    .pagination-wrapper .pagination>li>a:hover, .pagination-wrapper .pagination>li>span,
    .ova-btn.ova-btn-main-color:hover,
    .ovaem_events_pagination.clearfix ul.pagination li.active a,
    .ova-btn.ova-btn-second-color,
    .woocommerce form.login button[type='submit']:hover
    { 
      border-color: $second_color; 
    }
    
    
    
    .ovaem_events_filter .ovaem_events_filter_content .ova-item.style2 .wrap_content .venue i,
    .venues_slider .item .address span.icon i,
    .ova_service .icon,
    .ova_speaker_list_wrap .ova_speaker_list .content .job,
    .ova_speaker_list_wrap.style2 .ova_speaker_list:hover .content .job,
    .ova_speaker_list_wrap.style4 .ova_speaker_list:hover .content .wrap_info .job,
    .ova_map1 .content .info i,
    .ovaem_schedule .wrap_content .content_side .speaker_info .speaker_job,
    ul.ovaem_list_categories_widget li a:hover,
    .ovaem_list_events_widget ul li h3.widget_title a:hover,
    .ovaem_single_speaker .content .job,
    .ovaem_general_sidebar .widget.widget_categories ul li a:hover,
    .ova_venue_item .content .address i,
    .event_gallery_v1 .item .info .date,
    .woocommerce .ovaem_general_sidebar .widget.widget_product_categories ul li a:hover,
    .event_info .icon,
    .ovaem_schedule_single_event .ovaem_schedule .wrap_content .content_side .speaker_info .speaker_job,
    .ovaem_events_list .info .venue span i,
    .ovaem_general_sidebar .widget ul li a:hover,
    .ovaem_events_filter .ovaem_events_filter_content .ova-item .wrap_content .status,
    .ovaem_events_list .ova_thumbnail .event_status
    { 
      color: $second_color;
    }
    
    .ovaem_events_filter .ovaem_events_filter_content .ova-item.style3 .ova_thumbnail .venue span i,
    .ova_box .num,
    .ovaem_events_filter .ovaem_events_filter_content .ova-item:hover .time,
    .ova_service:hover,
    .ovaem_events_filter .ovaem_events_filter_nav li.current a,
    .ovaem_events_filter .ovaem_events_filter_nav li a:hover,
    .ovaem_search_event form input.ovame_submit:hover,
    .ova_search_v1.ovaem_search_event .ovaem_submit input:hover,
    .ovaem_search_event .ovaem_submit input:hover,
    .ova_blog .content:hover .ova_media a,
    footer.footer_v2 .subcribe .ova_mailchimp input.submit,
    .ovame_tickets .wrap_tickets .wrap_content .ovaem_register .ova-btn:hover,
    .event_single_related,
    .events_sidebar .event_widget.widget_ovaem_search_event_widget,
    .ovaem_archives_event.grid_sidebar .events_sidebar .event_widget.widget_ovaem_search_event_widget,
    .pagination-wrapper .pagination>li.active a, .pagination-wrapper .pagination>li>a:focus,
    .pagination-wrapper .pagination>li>a:hover, .pagination-wrapper .pagination>li>span,
    .ova-woo-shop .shop_archives .woocommerce-pagination li span,
    .woocommerce .coupon input.button,
    #scrollUp:hover,
    .ovaem-slider-events .item .read_more,
    .ova-btn.ova-btn-main-color:hover,
    .ovaem_events_pagination.clearfix ul.pagination li.active a,
    .ova-btn.ova-btn-second-color,
    .woocommerce form.login button[type='submit']:hover
    {
      background-color: $second_color;
    }
    .ova-login-form-container p.login-submit #wp-submit:hover{
        background-color: $second_color!important;   
    }

    
    


    
    .main_slider_v1 .item .caption h3.sub_title,
    .ovaem_search_event form input.ovame_submit,
    .ova_search_v1.ovaem_search_event .ovaem_submit input,
    .ovaem_search_event .ovaem_submit input,
    .ovaem-slider-events .slick-next,
    .ovaem-slider-events .slick-prev,
    .ova_speaker_list_wrap.style2 .ova_speaker_list .content ul.social li a:hover,
    .ova_speaker_list_wrap.style2 .ova_speaker_list .wrap_img ul.social li a:hover,
    footer.footer_v2 .social ul li a:hover,
    .ovaem_archives_event.list .ovaem_search .ovaem_search_event .ovaem_submit input:hover,
    .events_sidebar .event_widget.widget_ovaem_search_event_widget input.ovame_submit,
    .ovaem_event_tags_widget a:hover,
    .ovaem_archives_event.grid_sidebar .events_sidebar .event_widget .ovaem_event_tags_widget a:hover,
    .ovaem_regsiter_event form .ova_register_event:hover,
    .ovaem_blog_page .post-wrap .post-meta .right_side .post-footer a:hover,
    .widget.widget_tag_cloud .tagcloud a:hover,
    .ovaem_blog_page.list_two .post-wrap .read_more .post-readmore a:hover,
    #commentform #submit.submit,
    .widget.widget_product_tag_cloud .tagcloud a:hover,
    .ova-btn.ova-btn-main-color,
    .ova-btn.ova-btn-white:hover,
    .ova-btn:hover,
    .event_contact .submit .wpcf7-submit,
    .wrap_btn_book,
    .wrap-ovaem-slider-events .ova-slick-prev,
    .wrap-ovaem-slider-events .ova-slick-next,
    .ova-btn.ova-btn-second-color:hover,
    .ovame_tickets .wrap_tickets.featured .wrap_content .ovaem_register a,
    .woocommerce form.login button[type='submit']
    { 
      border-color: $main_color; 
    }
    
    

    .ova_search_v1.ovaem_search_event .ovaem_submit input,
    .ovaem_search_event .ovaem_submit input,
    .ovaem_search_event form input.ovame_submit,
    .ovatheme_header_v3.bg_heading .ova-top .item_top .ova-login,
    .ova_heading .sub_title:after,
    .ovaem_events_filter .ovaem_events_filter_content .time,
    .ovaem_events_filter .ovaem_events_filter_content .ova-item.style2:hover .ova_thumbnail .time,
    .ova_box.style2 .wrap_content .desc:after,
    .venues_slider .owl-controls .owl-dot.active,
    .ova_speaker_list_wrap .ova_speaker_list .content .trig,
    .ova_speaker_list_wrap.style2 .ova_speaker_list .content ul.social li a:hover,
    .ova_speaker_list_wrap.style2 .ova_speaker_list .wrap_img ul.social li a:hover,
    .ova_blog .content .ova_media a,
    .owl-controls .owl-dot.active,
    footer.footer_v2 .ova_mailchimp .info:after,
    footer.footer_v2 .subcribe .ova_mailchimp .info:after,
    .ova_single_event .tab_content .wrap_nav ul.nav li.active a span,
    .ova_single_event .event_widget h3.title span,
    .event_single_related .ova_heading_v2.white .sub_title span,
    .ovaem_archives_event.list .ovaem_search .ovaem_search_event .ovaem_submit input:hover,
    .ovaem_events_list .ova_thumbnail .price,
    .ovaem_events_list.sidebar .info .more_detail a span,
    .events_sidebar .event_widget.widget_ovaem_search_event_widget input.ovame_submit,
    .ovaem_regsiter_event form .ova_register_event:hover,
    .ovaem_blog_page .post-wrap .post-meta .right_side .post-footer a:hover,
    .widget.widget_tag_cloud .tagcloud a:hover,
    .ovaem_blog_page.list_two .post-wrap .read_more .post-readmore a:hover,
    #commentform #submit.submit,
    .ovaem_schedule_single_event .ovaem_schedule ul li.active a,
    li.ova-megamenu ul.ova-mega-menu li h5.title:after,
    .ova-menu li.ova-megamenu ul.ova-mega-menu .ovaem_slider_events_two a.ova-btn,
    .widget.widget_product_tag_cloud .tagcloud a:hover,
    .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
    .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
    .woocommerce span.onsale,
    .woocommerce.single-product .cart .button,
    .woocommerce.single-product .woocommerce-tabs ul.tabs li.active a:after,
    #scrollUp,
    .ovaem_events_filter .ovaem_events_filter_content .ova-item .time,
    ul li.ova-megamenu ul.ova-mega-menu li h5.title:after,
    footer.footer_v1 .wrap_widget h4.widget-title:after,
    .ova_heading_v3 span,
    .ova-btn.ova-btn-main-color,
    footer.footer_v3 h4.widget-title:after,
    .ova-btn.ova-btn-white:hover,
    .ova-btn:hover,
    .events_sidebar .event_widget h3.title span,
    .event_contact .submit .wpcf7-submit,
    .contact_info .icon,
    .ovaem_general_sidebar .widget h3.title span,
    #comments h4.block-title span,
    .main_slider_v1.main_slider_two .item .caption .ova_countdown_slideshow .countdown-section:nth-child(2),
    .main_slider_v1.main_slider_two .item .caption .ova_countdown_slideshow .countdown-section:nth-child(4),
    .ova_event_countdown .ova_countdown_slideshow .countdown-section:nth-child(2),
    .ova_event_countdown .ova_countdown_slideshow .countdown-section:nth-child(4),
    .ovaem_search_banner form .ovaem_submit input,
    .cat_info:hover,
    .ova_heading_v4 .sub_title:after,
    .ova-btn.ova-btn-second-color:hover,
    .woocommerce form.login button[type='submit']
    
    {
      background-color: $main_color;
      
    }
    .ova-login-form-container p.login-submit #wp-submit{
        background-color: $main_color!important;  
    }
    


    
    .ovaem_events_filter .ovaem_events_filter_content .ova-item.style2 .wrap_content .bottom .price,
    .ovaem_events_filter .ovaem_events_filter_content .ova-item .wrap_content h2 a:hover,
    .ova_service:hover .icon,
    .ovaem_events_filter .ovaem_events_filter_content .ova-item .wrap_content .more_detail .btn_link:hover,
    .ovaem_events_filter .read_more a i,
    .ova_box .wrap_content h3 a:hover,
    .ovaem-slider-events .item h2 a:hover,
    .venues_slider .item .wrap_content h2 a:hover,
    .venues_slider .item .wrap_img .read_more a:hover,
    .ova_speaker_list_wrap .ova_speaker_list .content ul.social li a:hover,
    .ova_speaker_list_wrap .ova_speaker_list .content .title a:hover,
    .ova-btn.ova-btn-arrow:hover i,
    .ova-btn.ova-btn-arrow i,
    .ova_speaker_list_wrap.style4 .ova_speaker_list .content .wrap_info .title a:hover,
    .ova_blog .post-meta .post-date i,
    .ova_blog .post-meta .post-comment i,
    .ova_blog .content h2.title a:hover,
    footer.footer_default .social ul.social_theme li a:hover,
    footer.footer_default .copyright a:hover,
    footer.footer_v1 .wrap_bellow .social ul li a:hover,
    footer.footer_v1 .wrap_bellow .copyright a:hover,
    footer.footer_v2 .copyright a:hover,
    .ova_single_event .content .ovaem_tags span i,
    .ova_single_event .content .ovaem_tags ul li a:hover,
    .ova_single_event .content .social ul li a:hover,
    .ova_single_event .content .social span i,
    .ova_single_event .tab_content .tab-content .ovaem_schedule .wrap_content .content_side .speaker_info .speaker_title a:hover,
    .ovaem_events_filter .ovaem_events_filter_content .ova-item.style2 .wrap_content .bottom .more_detail .btn_link:hover,
    .ovaem_events_list .info .title a:hover,
    .ovaem_events_list.sidebar .info .more_detail a:hover,
    .ovaem_event_tags_widget a:hover,
    .ovaem_special_event_widget h3.widget_title a:hover,
    .ovaem_single_speaker .content .speaker_info label i,
    .ovaem_single_speaker .content .speaker_info a:hover,
    .ovaem_single_speaker .content .speaker_info.social_speaker a:hover,
    ul.breadcrumb a:hover,
    .ovaem_blog_page .post-wrap .post-media .post-categories a:hover,
    .ovaem_blog_grid_page .post-wrap .content .post-title h2 a:hover,
    .ovaem_blog_grid_page .post-wrap .content .read_more a:hover,
    .ovaem_detail_post .tags_share .tag .ovaem_tags a:hover,
    .ovaem_detail_post .tags_share .share ul.share-social-icons li a:hover,
    .ova_venue_item .content h3.title a:hover,
    li.ova-megamenu ul.ova-mega-menu li a:hover,
    .ovatheme_header_v1 .ova-menu ul.navbar-nav li .dropdown-menu li a:hover,
    .ovatheme_header_v2 .ova-menu ul.navbar-nav li .dropdown-menu li a:hover,
    .ovatheme_header_v3 .ova-menu ul.navbar-nav li .dropdown-menu li a:hover,
    .ovatheme_header_v4 .ova-menu #ovatheme_header_v4 ul.nav > li .dropdown-menu li a:hover,
    .ova-menu li.ova-megamenu ul.ova-mega-menu .ovaem_slider_events_two .event_content h2.title a:hover,
    .ovaem_slider_events_two .event_content .wrap_date_venue i,
    .ovaem_slider_events_two .owl-controls .owl-next:hover, 
    .ovaem_slider_events_two .owl-controls .owl-prev:hover,
    .ova-woo-shop .shop_archives a h2.woocommerce-loop-product__title:hover,
    .woocommerce.single-product .woocommerce-tabs .woocommerce-Tabs-panel #review_form_wrapper #review_form .comment-form-rating p.stars a,
    .woocommerce.single-product .woocommerce-tabs .woocommerce-Tabs-panel .woocommerce-Reviews ol.commentlist .star-rating span,
    .banner_one .event_icon i,
    .ovaem_blog_page .post-wrap .post-title h2 a:hover,
    .ovaem_blog_page .post-wrap .post-meta .left_side .post-date i,
    .ovaem_blog_page .post-wrap .post-meta .left_side .comment i,
    .ovaem_detail_post .post-meta .post-meta-content .comment .left i,
    .ovaem_detail_post .post-meta .post-meta-content .post-date .left i,
    .ovaem_detail_post .tags_share .tag .ovaem_tags i,
    .woocommerce .related.products .product .ova_rating .star-rating,
    .woocommerce .woocommerce-product-rating .star-rating,
    .main_slider_v1 .item .caption .slider_date .box i,
    .cat_info i,
    .ova_heading_v4 h3 span,
    .em4u_call_action .wpb_wrapper a
    { 
      color: $main_color; 
    }
    
    
    .ova_speaker_list_wrap .ova_speaker_list:hover .content
    {
      background-color: rgba( $bg_cover[0],$bg_cover[1],$bg_cover[2], 0.9 );
    }
    .ova_speaker_list_wrap .ova_speaker_list:hover .content:before{
      border-bottom-color: rgba( $bg_cover[0],$bg_cover[1],$bg_cover[2], 0.9 );
    }

    .dropdown-menu>li>a:hover{ color: $main_color!important; }
    .ovatheme_header_v3 .ova-bg-heading .bg_cover{
      background-color: rgba( $bg_cover[0],$bg_cover[1],$bg_cover[2], 0.9 )!important;
    }
    .ovatheme_header_v3.bg_heading .ova-menu{ border-bottom: 1px solid rgba(255, 255, 255, 0.15); }
    .main_slider_v1 .item .caption h3.sub_title::after{
      border-bottom-color: $main_color;
    }
    .ovaem_events_filter .ovaem_events_filter_content .ova-item.style3 .ova_thumbnail .venue span{
      background-color: rgba( $bg_cover[0],$bg_cover[1],$bg_cover[2], 0.5 );
    }
    .ovaem_events_filter .ovaem_events_filter_nav.style3 li a:hover,
    .ovaem_events_filter .ovaem_events_filter_nav.style3 li.current a{
      border-bottom-color: $main_color;
    }
    .ovaem-slider-events .item .read_more{ background-color: rgba( $bg_cover[0],$bg_cover[1],$bg_cover[2], 0.9 ); }
    .ovaem-slider-events .item .read_more:hover{ background-color: rgba( $bg_main[0],$bg_main[1],$bg_main[2], 0.9 ); }

    .ovaem_schedule_single_event .ovaem_schedule ul li.active a::after{
        border-top-color: $main_color;
    }

    ul.ova-mega-menu li a.active,
    ul.nav li.ova_current>a{
        color: $main_color!important; 
    }
    .ovaem_simple_event .more_detail{
        background-color: $main_color;    
    }
    
    .ovaem_simple_event .more_detail:after{
        border-bottom-color: $main_color;
    }
    .join_event .title span,
    .wrap_btn_book{
        background-color: $main_color;
    }
    .woocommerce.single-product .woocommerce-tabs .woocommerce-Tabs-panel .form-submit input.submit,
    .woocommerce input.button.alt, .woocommerce input.button,
    .woocommerce .ova_cart .cart-collaterals .wc-proceed-to-checkout a,
    .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt{
        background-color: $main_color!important;   

    }
    .woocommerce .coupon input.button.alt:hover, .woocommerce .coupon input.button:hover,
    .woocommerce .ova_cart .cart-collaterals .wc-proceed-to-checkout a:hover,
    .woocommerce .actions input.button:hover,
    .woocommerce .actions input.button:disabled[disabled]:hover{
        color: #fff;
    }
    .woocommerce div.product .stock{
        color: $main_color;
    }

    .fc-event{
        background-color: $second_color;
        border-color: $second_color;
    }

    
    @media( max-width: 767px ){
        .vc_row.search_top{
            background-color: $second_color!important;
        }
        .ova-btn.ova-btn-second-color{
            border-color: $main_color;
            background-color: $main_color;
            color: #fff;
        }

        .ova-btn.ova-btn-second-color:hover{
            border-color: $second_color;
            background-color: $second_color;
        }

        .ovaem_events_filter .ovaem_events_filter_content .ova-item.style1 .ova_thumbnail .time{
            background-color: $main_color;
        }
        .ovaem_events_filter .ovaem_events_filter_content .ova-item.style1 .wrap_content .more_detail .btn_link{
            border-color: $main_color;
        }
        .ova_service.style1 .read_more a{
            color: $main_color;   
        }
        
        .select_cat_mobile_btn ul.ovaem_events_filter_nav li:hover a, 
        .select_cat_mobile_btn ul.ovaem_events_filter_nav li.current a{
            color: $second_color;
        }
        .ovaem_events_filter .ovaem_events_filter_content .ova-item.style3 .wrap_content .venue_mobile span i{
            color: $main_color;
        }
    }
    

  ";
  wp_add_inline_style( 'em4u-style', $custom_css );
    
}




/* Google Font */
function em4u_customize_google_fonts() {
    $fonts_url = '';

    $body_font = get_theme_mod('body_font', 'Poppins');
    
    
    $body_font_c = _x( 'on', $body_font.': on or off', 'em4u');
    

 
    if ( 'off' !== $body_font_c || 'off' !== $heading_font_c ) {
        $font_families = array();
 
        if ( 'off' !== $body_font_c && strpos($body_font,'ovatheme_') === false ) {
            $font_families[] = $body_font.':100,200,300,400,500,600,700,800,900"';
        }
        

        if($font_families != null){
          $query_args = array(
              'family' => urlencode( implode( '|', $font_families ) ),
              'subset' => urlencode( 'latin,latin-ext' ),
          );  
          $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
        }
        
 
        
    }
 
    return esc_url_raw( $fonts_url );
}






/************************************************************************************************/
/************************************************************************************************/

function em4u_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb; // returns an array with the rgb values
}


