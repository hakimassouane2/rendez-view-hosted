<?php
/* Register Menu */
add_action( 'init', 'em4u_register_menus' );
function em4u_register_menus() {
  register_nav_menus( array(
    'primary'   => esc_html__( 'Primary Menu', 'em4u' ),
    'landing'   => esc_html__( 'Landing Page Menu', 'em4u' )

  ) );
}





/* Register Widget */
add_action( 'widgets_init', 'em4u_second_widgets_init' );
function em4u_second_widgets_init() {
  
  $args_blog = array(
    'name' => esc_html__( 'Main Sidebar', 'em4u'),
    'id' => "main-sidebar",
    'description' => esc_html__( 'Main Sidebar', 'em4u' ),
    'class' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h3 class="title">',
    'after_title' => "<span class=\"one\"></span><span class=\"two\"></span><span class=\"three\"></span><span class=\"four\"></span><span class=\"five\"></span></h3>",
  );
  register_sidebar( $args_blog );
  

}

add_filter( 'wp_nav_menu_items', 'em4u_add_custom_li', 10, 2 );
function em4u_add_custom_li ( $items, $args ) {

    if ( get_theme_mod( 'show_menu_account', 'no' ) == 'yes'  && ( $args->theme_location == 'primary' || $args->theme_location == 'landing' ) ) {

      $items .= '<li class="li_account"><div class="ova-account">';

        if ( !is_user_logged_in() ) {
          $account_register = get_theme_mod( 'account_register', '' );
          $account_login = get_theme_mod( 'account_login', '' );
          $items .= '<a href="'.esc_url($account_login).'" class="ova_icon_open"><i class=" icon_lock-open_alt"></i></a>
                      <a href="'.esc_url($account_register).'" class="ova_icon_key"><i class="icon_key_alt"></i></a>';

        }else{
          $account_info = get_theme_mod( 'account_info', '' );
          $items .= '<a href="'.esc_url($account_info).'" class="ova_icon_open"><i class="icon_profile"></i></a>';
        }

      $items .= '</div></li>';

        
    }
    return $items;
}