<?php


	if(defined('EM4U_URL') 	== false) 	define('EM4U_URL', get_template_directory());
	if(defined('EM4U_URI') 	== false) 	define('EM4U_URI', get_template_directory_uri());


	
	load_theme_textdomain( 'em4u', get_template_directory() . '/languages' );
	
	
	// Add js, css
	require( EM4U_URL.'/extend/add_js_css.php' );


	// require libraries, function
	require( EM4U_URL.'/framework/init.php' );

	

	// register menu, widget
	require( EM4U_URL.'/extend/register_menu_widget.php' );

	require( EM4U_URL.'/templates/open_layout.php' );
	require( EM4U_URL.'/templates/close_layout.php' );

	require( EM4U_URL.'/templates/woo_open_layout.php' );
	require( EM4U_URL.'/templates/woo_close_layout.php' );
	

	// require menu
	require_once (EM4U_URL.'/extend/ova_walker_nav_menu.php');

	// require content
	require_once (EM4U_URL.'/content/define_blocks_content.php');
	
	// require breadcrumbs
	require( EM4U_URL.'/extend/breadcrumbs.php' );


	
	
	// Require customize
	if( is_user_logged_in() ){
		require( EM4U_URL.'/framework/customize_google_font/customizer_google_font.php' );
		require( EM4U_URL.'/extend/customizer.php' );
	}

	// Require metabox
	if( is_admin() ){
		require( EM4U_URL.'/extend/metabox.php' );
		// Require TGM
		require_once ( EM4U_URL.'/extend/active_plugins.php' );		
	}

	