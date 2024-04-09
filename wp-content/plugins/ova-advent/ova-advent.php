<?php
/**
 
Plugin Name: Ova Advent
 
Plugin URI: https://themeforest.net/user/ovatheme/portfolio
 
Description: A plugin to create custom post type,  shortcode
 
Version:  1.1.7
 
Author: Ovatheme
 
Author URI: https://themeforest.net/user/ovatheme
 
License:  GPL2
Text Domain: adventpro
Domain Path: /languages/
 
*/



include dirname( __FILE__ ) . '/shortcode/shortcode.php';
include dirname( __FILE__ ) . '/shortcode/vc-shortcode.php';

load_plugin_textdomain( 'adventpro', false, basename( dirname( __FILE__ ) ) .'/languages' ); 


add_filter('widget_text','do_shortcode');
add_filter( 'adventpro_content_social', 'adventpro_content_social', 10 , 0 );


add_action( 'widgets_init', 'ova_adventpro_second_widgets_init', 11 );
function ova_adventpro_second_widgets_init() {
  
	 
	$args_woo = array(
		'name' => esc_html__( 'Woocommerce Sidebar', 'adventpro'),
		'id' => "woo-sidebar",
		'description' => esc_html__( 'Woocommerce Sidebar', 'adventpro' ),
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget  %2$s">',
		'after_widget' => "</div>",
		 'before_title' => '<h3 class="title">',
	    'after_title' => "<span class=\"one\"></span><span class=\"two\"></span><span class=\"three\"></span><span class=\"four\"></span><span class=\"five\"></span></h3>",
	);
	register_sidebar( $args_woo );

	$subcribe = array(
		'name' => esc_html__( 'Subcribe Footer', 'adventpro'),
		'id' => "subcribe",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $subcribe );

	$logo_white = array(
		'name' => esc_html__( 'Logo White Footer', 'adventpro'),
		'id' => "logo_white",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $logo_white );

	$logo_dark = array(
		'name' => esc_html__( 'Logo Dark Footer', 'adventpro'),
		'id' => "logo_dark",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $logo_dark );

	$social = array(
		'name' => esc_html__( 'Social Footer', 'adventpro'),
		'id' => "social",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $social );

	$copyright = array(
		'name' => esc_html__( 'Copyright Footer', 'adventpro'),
		'id' => "copyright",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $copyright );

	$category = array(
		'name' => esc_html__( 'Category Footer', 'adventpro'),
		'id' => "category",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $category );

	$gallery = array(
		'name' => esc_html__( 'Gallery Footer', 'adventpro'),
		'id' => "gallery",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $gallery );

	$info_one = array(
		'name' => esc_html__( 'Info 1 Footer', 'adventpro'),
		'id' => "info_one",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $info_one );

	$info_two = array(
		'name' => esc_html__( 'Info 2 Footer', 'adventpro'),
		'id' => "info_two",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $info_two );

	$info_three = array(
		'name' => esc_html__( 'Info 3 Footer', 'adventpro'),
		'id' => "info_three",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $info_three );

	$info_four = array(
		'name' => esc_html__( 'Info 4 Footer', 'adventpro'),
		'id' => "info_four",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $info_four );


	$cloud = array(
		'name' => esc_html__( 'Tags Footer', 'adventpro'),
		'id' => "tags",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => "</h4>",
	);
	register_sidebar( $cloud );


	$header_v3 = array(
		'name' => esc_html__( 'Header Version 3: Top Info', 'adventpro'),
		'id' => "header_v3",
		'class' => '',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => "</div>",
		'before_title' => '',
		'after_title' => "",
	);
	register_sidebar( $header_v3 );



	if ( ! function_exists( 'adventpro_content_social' ) ) {
	 	function adventpro_content_social( ) { ?>
	 	
	 		<i class="icon_share social_share"></i>
			<span><?php esc_html_e( 'Share: ', 'adventpro' ); ?></span>
	 		<ul class="share-social-icons clearfix">
				<li><a class="share-ico ico-facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo get_the_permalink(); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a class="share-ico ico-twitter" target="_blank" href="https://twitter.com/share?url=<?php echo get_the_permalink(); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
				<li><a class="share-ico ico-vk" target="_blank" href="http://vkontakte.ru/share.php?url=<?php echo get_the_permalink(); ?>"><i class="fa fa-vk" aria-hidden="true"></i></a></li>   
				<li><a class="share-ico ico-tumblr" target="_blank" href="http://www.tumblr.com/share/link?url=<?php echo get_the_permalink(); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>"><i class="fa fa-tumblr" aria-hidden="true"></i></a></li>                                 
				<li><a class="share-ico ico-google-plus" target="_blank" href="https://plus.google.com/share?url=<?php echo get_the_permalink(); ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
			</ul>
	 	<?php }
	 }



  

}


return true;