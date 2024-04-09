<?php


function em4u_customize_register( $wp_customize ) {

	/* Remove Colors &  Header Image Customize */
	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('header_image');


	// Typography setting ////////////////////////////////////////////////////////////////////////////////////////////////////////
	$wp_customize->add_section( 'typography_section' , array(
	    'title'      => esc_html__( 'Typography setting', 'em4u' ),
	    'priority'   => 29,
	) );


	$wp_customize->add_setting( 'body_font', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => 'Poppins',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control( 
		new Google_Font_Dropdown_Custom_Control( 
		$wp_customize, 
		'body_font', 
		array(
			'label'          => esc_html__('Body font','em4u'),
            'section'        => 'typography_section',
            'settings'       => 'body_font',
		) ) 
	);



	

	$wp_customize->add_setting( 'main_color', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '#f53f7b',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'main_color', 
		array(
			'label'          => esc_html__("Main color",'em4u'),
            'section'        => 'typography_section',
            'settings'       => 'main_color',
		) ) 
	);


	$wp_customize->add_setting( 'second_color', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '#4862c4',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'second_color', 
		array(
			'label'          => esc_html__("Second color",'em4u'),
            'section'        => 'typography_section',
            'settings'       => 'second_color',
		) ) 
	);


	$wp_customize->add_setting( 'em4u_custom_font', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('em4u_custom_font', array(
		'label' => esc_html__('Custom Font','em4u'),
		'description' => esc_html__('Step 1: Insert font-face in style.css file: Refer https://css-tricks.com/snippets/css/using-font-face/.  Step 2: Insert name-font here. For example: name-font1, name-font2. Step 3: Refresh customize page to display new font in dropdown font field.','em4u'),
		'section' => 'typography_section',
		'settings' => 'em4u_custom_font',
		'type' =>'textarea'
	));	

	
	// /Typography setting ////////////////////////////////////////////////////////////////////////////////////////////////////////


	// Header setting ////////////////////////////////////////////////////////////////////////////////////////////////////////

	$wp_customize->add_panel( 'header_panel', array(
	    'title'      => esc_html__( 'Header', 'em4u' ),
	    'priority' => 30,
	) );


		$wp_customize->add_section( 'header_global_section' , array(
		    'title'      => esc_html( 'Header Global', 'em4u' ),
		    'priority'   => 30,
		    'panel' => 'header_panel',
		) );

			// Choose menu version 
			$wp_customize->add_setting( 'header_version', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => 'version1',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('header_version', array(
				'label' => esc_html('Header version','em4u'),
				'description' => esc_html('Select Global Header. You can override Header in config of Post/Page','em4u'),
				'section' => 'header_global_section',
				'settings' => 'header_version',
				'type' =>'select',
				'choices' => em4u_load_header()

			));

			// Background Default Header 
			$wp_customize->add_setting( 'bg_default_header', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => EM4U_URI.'/assets/img/bg_heading-compressor.jpg',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bg_default_header', array(
			    'label'    => esc_html__( 'Background Default Header ', 'em4u' ),
			    'section'  => 'header_global_section',
			    'settings' => 'bg_default_header'
			)));


			/* Menu Fixed when scroll page */
			$wp_customize->add_setting( 'header_fixed', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => 'fixed',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('header_fixed', array(
				'label' => esc_html('Header Fixed','em4u'),
				'description' => esc_html('Fixed header when scroll page','em4u'),
				'section' => 'header_global_section',
				'settings' => 'header_fixed',
				'type' =>'select',
				'choices' => array(
					'fixed' => esc_html__('True', 'em4u'),
					'no_fixed' => esc_html__('False', 'em4u'),
				)

			));

		$wp_customize->add_section( 'header_blog_archive_section' , array(
		    'title'      => esc_html( 'Header Blog Archive', 'em4u' ),
		    'priority'   => 30,
		    'panel' => 'header_panel',
		) );

			// Choose menu version 
			$wp_customize->add_setting( 'header_version_blog_archive', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => 'version1',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('header_version_blog_archive', array(
				'label' => esc_html('Header version','em4u'),
				'description' => '',
				'section' => 'header_blog_archive_section',
				'settings' => 'header_version_blog_archive',
				'type' =>'select',
				'choices' => em4u_load_header()
			));

			// Background Default Header 
			$wp_customize->add_setting( 'bg_header_blog_archive', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => EM4U_URI.'/assets/img/bg_heading-compressor.jpg',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bg_header_blog_archive', array(
			    'label'    => esc_html__( 'Background Header ', 'em4u' ),
			    'section'  => 'header_blog_archive_section',
			    'settings' => 'bg_header_blog_archive'
			)));


			/* Menu Fixed when scroll page */
			$wp_customize->add_setting( 'header_fixed_blog_archive', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => 'fixed',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('header_fixed_blog_archive', array(
				'label' => esc_html('Header Fixed','em4u'),
				'description' => esc_html('Fixed header when scroll page','em4u'),
				'section' => 'header_blog_archive_section',
				'settings' => 'header_fixed_blog_archive',
				'type' =>'select',
				'choices' => array(
					'fixed' => esc_html__('True', 'em4u'),
					'no_fixed' => esc_html__('False', 'em4u'),
				)

			));
		// End --------
		// Event -------
		$wp_customize->add_section( 'header_event_archive_section' , array(
		    'title'      => esc_html( 'Header Event Archive', 'em4u' ),
		    'priority'   => 30,
		    'panel' => 'header_panel',
		) );

			// Choose menu version 
			$wp_customize->add_setting( 'header_version_event_archive', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => 'version1',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('header_version_event_archive', array(
				'label' => esc_html('Header version','em4u'),
				'description' => '',
				'section' => 'header_event_archive_section',
				'settings' => 'header_version_event_archive',
				'type' =>'select',
				'choices' => em4u_load_header()
			));

			// Background Default Header 
			$wp_customize->add_setting( 'bg_header_event_archive', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => EM4U_URI.'/assets/img/bg_heading-compressor.jpg',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bg_header_event_archive', array(
			    'label'    => esc_html__( 'Background Header ', 'em4u' ),
			    'section'  => 'header_event_archive_section',
			    'settings' => 'bg_header_event_archive'
			)));


			/* Menu Fixed when scroll page */
			$wp_customize->add_setting( 'header_fixed_event_archive', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => 'fixed',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('header_fixed_event_archive', array(
				'label' => esc_html('Header Fixed','em4u'),
				'description' => esc_html('Fixed header when scroll page','em4u'),
				'section' => 'header_event_archive_section',
				'settings' => 'header_fixed_event_archive',
				'type' =>'select',
				'choices' => array(
					'fixed' => esc_html__('True', 'em4u'),
					'no_fixed' => esc_html__('False', 'em4u'),
				)

			));
		// End --------

		$wp_customize->add_section( 'header_desktop_section' , array(
		    'title'      => esc_html( 'Header Desktop', 'em4u' ),
		    'priority'   => 30,
		    'panel' => 'header_panel',
		) );

			/* Logo */
			$wp_customize->add_setting( 'logo', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
			    'label'    => esc_html__( 'Logo', 'em4u' ),
			    'section'  => 'header_desktop_section',
			    'settings' => 'logo'
			)));

			/* Width Logo */
			$wp_customize->add_setting( 'desk_logo_width', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('desk_logo_width', array(
				'label' => esc_html('Logo Width','em4u'),
				'description' => esc_html('Example: 120px','em4u'),
				'section' => 'header_desktop_section',
				'settings' => 'desk_logo_width',
				'type' =>'text'
			));

			

			/* Height Logo */
			$wp_customize->add_setting( 'desk_logo_height', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('desk_logo_height', array(
				'label' => esc_html('Logo Height','em4u'),
				'description' => esc_html('Example: 70px','em4u'),
				'section' => 'header_desktop_section',
				'settings' => 'desk_logo_height',
				'type' =>'text'
			));

			/* Background Color Header */
			$wp_customize->add_setting( 'bg_color_header', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#000',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'bg_color_header', 
				array(
					'label'          => esc_html__("Background color",'em4u'),
		            'section'        => 'header_desktop_section',
		            'settings'       => 'bg_color_header',
				) ) 
			);

			// Opacity Background Color Header
			$wp_customize->add_setting( 'bg_color_header_opacity', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '0.6',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('bg_color_header_opacity', array(
				'label' => esc_html('Background Transparent','em4u'),
				'section' => 'header_desktop_section',
				'settings' => 'bg_color_header_opacity',
				'type' =>'select',
				'choices' => array(
					'0'   => esc_html__('0', 'em4u'),
					'0.1' => esc_html__('0.1', 'em4u'),
					'0.2' => esc_html__('0.2', 'em4u'),
					'0.3' => esc_html__('0.3', 'em4u'),
					'0.4' => esc_html__('0.4', 'em4u'),
					'0.5' => esc_html__('0.5', 'em4u'),
					'0.6' => esc_html__('0.6', 'em4u'),
					'0.7' => esc_html__('0.7', 'em4u'),
					'0.8' => esc_html__('0.8', 'em4u'),
					'0.9' => esc_html__('0.9', 'em4u'),
					'1' => esc_html__('1', 'em4u'),
				)

			));

			/* Menu color */
			$wp_customize->add_setting( 'header_menu_color', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_menu_color', 
				array(
					'label'          => esc_html__("Menu color",'em4u'),
		            'section'        => 'header_desktop_section',
		            'settings'       => 'header_menu_color',
				) ) 
			);

			/* Login Color */
			$wp_customize->add_setting( 'header_login_color', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_login_color', 
				array(
					'label'          => esc_html__("Login Button Color",'em4u'),
		            'section'        => 'header_desktop_section',
		            'settings'       => 'header_login_color',
				) ) 
			);

			/* Login Border Color */
			$wp_customize->add_setting( 'header_login_b_color', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#f53f7b',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_login_b_color', 
				array(
					'label'          => esc_html__("Login Button Border Color",'em4u'),
		            'section'        => 'header_desktop_section',
		            'settings'       => 'header_login_b_color',
				) ) 
			);


			/* Register Color */
			$wp_customize->add_setting( 'header_register_color', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_register_color', 
				array(
					'label'          => esc_html__("Register Button Color",'em4u'),
		            'section'        => 'header_desktop_section',
		            'settings'       => 'header_register_color',
				) ) 
			);

			/* Register Border Color */
			$wp_customize->add_setting( 'header_register_b_color', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_register_b_color', 
				array(
					'label'          => esc_html__("Register Button Border Color",'em4u'),
		            'section'        => 'header_desktop_section',
		            'settings'       => 'header_register_b_color',
				) ) 
			);

			



			


		$wp_customize->add_section( 'header_scroll_section' , array(
		    'title'      => esc_html( 'Header Desktop Scroll', 'em4u' ),
		    'priority'   => 30,
		    'panel' => 'header_panel',
		) );

			// Logo scroll
			$wp_customize->add_setting( 'logo_scroll', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_scroll', array(
			    'label'    => esc_html__( 'Logo Scroll', 'em4u' ),
			    'section'  => 'header_scroll_section',
			    'settings' => 'logo_scroll'
			)));


			/* Width Logo */
			$wp_customize->add_setting( 'desk_logo_scroll_width', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('desk_logo_scroll_width', array(
				'label' => esc_html('Logo Width','em4u'),
				'description' => esc_html('Example: 120px','em4u'),
				'section' => 'header_scroll_section',
				'settings' => 'desk_logo_scroll_width',
				'type' =>'text'
			));

			

			/* Height Logo */
			$wp_customize->add_setting( 'desk_logo_scroll_height', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('desk_logo_scroll_height', array(
				'label' => esc_html('Logo Height','em4u'),
				'description' => esc_html('Example: 70px','em4u'),
				'section' => 'header_scroll_section',
				'settings' => 'desk_logo_scroll_height',
				'type' =>'text'
			));





			/* Background Color Header when scroll */
			$wp_customize->add_setting( 'bg_color_header_scroll', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#000',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'bg_color_header_scroll', 
				array(
					'label'          => esc_html__("Background color",'em4u'),
		            'section'        => 'header_scroll_section',
		            'settings'       => 'bg_color_header_scroll',
				) ) 
			);

			// Opacity Background Color Header
			$wp_customize->add_setting( 'bg_color_header_scroll_opacity', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '1',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('bg_color_header_scroll_opacity', array(
				'label' => esc_html('Make transparent background when scroll page','em4u'),
				'section' => 'header_scroll_section',
				'settings' => 'bg_color_header_scroll_opacity',
				'type' =>'select',
				'choices' => array(
					'0' => esc_html__('0', 'em4u'),
					'0.1' => esc_html__('0.1', 'em4u'),
					'0.2' => esc_html__('0.2', 'em4u'),
					'0.3' => esc_html__('0.3', 'em4u'),
					'0.4' => esc_html__('0.4', 'em4u'),
					'0.5' => esc_html__('0.5', 'em4u'),
					'0.6' => esc_html__('0.6', 'em4u'),
					'0.7' => esc_html__('0.7', 'em4u'),
					'0.8' => esc_html__('0.8', 'em4u'),
					'0.9' => esc_html__('0.9', 'em4u'),
					'1' => esc_html__('1', 'em4u'),
				)

			));

			/* Menu color when scroll */
			$wp_customize->add_setting( 'header_menu_color_scroll', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_menu_color_scroll', 
				array(
					'label'          => esc_html__("Header menu color when scroll",'em4u'),
		            'section'        => 'header_scroll_section',
		            'settings'       => 'header_menu_color_scroll',
				) ) 
			);



			/* Login Color */
			$wp_customize->add_setting( 'header_login_color_s', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_login_color_s', 
				array(
					'label'          => esc_html__("Login Button Color",'em4u'),
		            'section'        => 'header_scroll_section',
		            'settings'       => 'header_login_color_s',
				) ) 
			);

			/* Login Border Color */
			$wp_customize->add_setting( 'header_login_b_color_s', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#f53f7b',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_login_b_color_s', 
				array(
					'label'          => esc_html__("Login Button Border Color",'em4u'),
		            'section'        => 'header_scroll_section',
		            'settings'       => 'header_login_b_color_s',
				) ) 
			);


			/* Register Color */
			$wp_customize->add_setting( 'header_register_color_s', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_register_color_s', 
				array(
					'label'          => esc_html__("Register Button Color",'em4u'),
		            'section'        => 'header_scroll_section',
		            'settings'       => 'header_register_color_s',
				) ) 
			);

			/* Register Border Color */
			$wp_customize->add_setting( 'header_register_b_color_s', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_register_b_color_s', 
				array(
					'label'          => esc_html__("Register Button Border Color",'em4u'),
		            'section'        => 'header_scroll_section',
		            'settings'       => 'header_register_b_color_s',
				) ) 
			);


	

	
		$wp_customize->add_section( 'header_mobile_section' , array(
		    'title'      => esc_html( 'Header Mobile', 'em4u' ),
		    'priority'   => 30,
		    'panel' => 'header_panel',
		) );	
	
			// Logo mobile
			$wp_customize->add_setting( 'logo_mobile', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_mobile', array(
			    'label'    => esc_html__( 'Logo Mobile', 'em4u' ),
			    'section'  => 'header_mobile_section',
			    'settings' => 'logo_mobile'
			)));

			/* Width Logo */
			$wp_customize->add_setting( 'logo_mobile_width', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('logo_mobile_width', array(
				'label' => esc_html('Logo Width','em4u'),
				'description' => esc_html('Example: 120px','em4u'),
				'section' => 'header_mobile_section',
				'settings' => 'logo_mobile_width',
				'type' =>'text'
			));

			

			/* Height Logo */
			$wp_customize->add_setting( 'logo_mobile_height', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );

			$wp_customize->add_control('logo_mobile_height', array(
				'label' => esc_html('Logo Height','em4u'),
				'description' => esc_html('Example: 70px','em4u'),
				'section' => 'header_mobile_section',
				'settings' => 'logo_mobile_height',
				'type' =>'text'
			));


			/* Login Color */
			$wp_customize->add_setting( 'header_login_color_m', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_login_color_m', 
				array(
					'label'          => esc_html__("Login Button Color",'em4u'),
		            'section'        => 'header_mobile_section',
		            'settings'       => 'header_login_color_m',
				) ) 
			);

			/* Login Border Color */
			$wp_customize->add_setting( 'header_login_b_color_m', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#f53f7b',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_login_b_color_m', 
				array(
					'label'          => esc_html__("Login Button Border Color",'em4u'),
		            'section'        => 'header_mobile_section',
		            'settings'       => 'header_login_b_color_m',
				) ) 
			);


			/* Register Color */
			$wp_customize->add_setting( 'header_register_color_m', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_register_color_m', 
				array(
					'label'          => esc_html__("Register Button Color",'em4u'),
		            'section'        => 'header_mobile_section',
		            'settings'       => 'header_register_color_m',
				) ) 
			);

			/* Register Border Color */
			$wp_customize->add_setting( 'header_register_b_color_m', array(
			  'type' => 'theme_mod', // or 'option'
			  'capability' => 'edit_theme_options',
			  'theme_supports' => '', // Rarely needed.
			  'default' => '#fff',
			  'transport' => 'refresh', // or postMessage
			  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
			  
			) );
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
				$wp_customize, 
				'header_register_b_color_m', 
				array(
					'label'          => esc_html__("Register Button Border Color",'em4u'),
		            'section'        => 'header_mobile_section',
		            'settings'       => 'header_register_b_color_m',
				) ) 
			);




	// Footer setting ////////////////////////////////////////////////////////////////////////////////////////////////////////

	$wp_customize->add_section( 'footer_section' , array(
	    'title'      => esc_html( 'Footer Global', 'em4u' ),
	    'priority'   => 30,
	) );

	$wp_customize->add_setting( 'footer_version', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => 'default',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('footer_version', array(
		'label' => esc_html('Footer version','em4u'),
		'description' => esc_html('Select Global Footer. You can override Footer in config of Post/Page','em4u'),
		'section' => 'footer_section',
		'settings' => 'footer_version',
		'type' =>'select',
		'choices' => em4u_load_footer()

	));

	$wp_customize->add_setting( 'scroll_top', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => 'totop',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('scroll_top', array(
		'label' => esc_html('Show Scroll to top at footer','em4u'),
		'section' => 'footer_section',
		'settings' => 'scroll_top',
		'type' =>'select',
		'choices' => array(
			"totop" => "yes",
			"hide_totop"	=> "no"
		)

	));
	
	// /Footer setting ////////////////////////////////////////////////////////////////////////////////////////////////////////


	// Blog setting ////////////////////////////////////////////////////////////////////////////////////////////////////////

	$wp_customize->add_section( 'blog_section' , array(
	    'title'      => esc_html( 'Blog settings', 'em4u' ),
	    'priority'   => 30,
	) );
		$wp_customize->add_setting( 'blog_type', array(
		  'type' => 'theme_mod', // or 'option'
		  'capability' => 'edit_theme_options',
		  'theme_supports' => '', // Rarely needed.
		  'default' => 'list',
		  'transport' => 'refresh', // or postMessage
		  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
		  
		) );

		$wp_customize->add_control('blog_type', array(
			'label' => esc_html__('Blog Type','em4u'),
			'section' => 'blog_section',
			'settings' => 'blog_type',
			'type' =>'select',
			'choices' => array(
				'list' => esc_html__('List V1', 'em4u'),
				'list_two' => esc_html__('List V2', 'em4u'),
				'grid' => esc_html__('Grid', 'em4u'),
				'grid_sidebar' => esc_html__('Grid Sidebar', 'em4u'),
				
			)

		));



	// Countdown setting ////////////////////////////////////////////////////////////////////////////////////////////////////////
	$wp_customize->add_section( 'countdown_section' , array(
	    'title'      => esc_html( 'Countdown Settings', 'em4u' ),
	    'priority'   => 30,
	) );

	$wp_customize->add_setting( 'countdown_lang', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => 'default',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	
	$files = array();
	$files['lang'] = esc_html__( 'Default', 'em4u' );
	foreach (glob( EM4U_URL."/assets/plugins/countdown/*.js") as $file) {
		$file_name = basename($file);
		if( $file_name != 'jquery.plugin.js' && $file_name != 'jquery.plugin.min.js' && $file_name  != 'jquery.countdown.js' && $file_name  != 'jquery.countdown.min.js' ){
			$files[$file_name] = str_replace( 'jquery.countdown-', '', basename($file_name, '.js') );		
		}
	}
	

	$wp_customize->add_control('countdown_lang', array(
		'label' => esc_html('countdown language','em4u'),
		'section' => 'countdown_section',
		'settings' => 'countdown_lang',
		'type' =>'select',
		'choices' => $files,
		'default' => ''
	));	
	

	// My account setting ////////////////////////////////////////////////////////////////////////////////////////////////////////

	

	$wp_customize->add_section( 'account_section' , array(
	    'title'      => esc_html( 'Login/Register Menu settings', 'em4u' ),
	    'priority'   => 30,
	) );

	/* Hide Login Register */
	$wp_customize->add_setting( 'show_menu_account', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => 'no',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('show_menu_account', array(
		'label' => esc_html('Show Login/Register in Menu','em4u'),
		'section' => 'account_section',
		'settings' => 'show_menu_account',
		'type' =>'select',
		'choices' => array(
			'no' => esc_html__('No', 'em4u'),
			'yes' => esc_html__('Yes', 'em4u'),
		)

	));


	$wp_customize->add_setting( 'account_login', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('account_login', array(
		'label' => esc_html__('Account Login URL','em4u'),
		'description' => esc_html__('Choose page has slug is member-login. Example name page: Sign In','em4u'),
		'section' => 'account_section',
		'settings' => 'account_login',
		'type' =>'text',
		'value' => ''

	));

	$wp_customize->add_setting( 'account_register', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('account_register', array(
		'label' => esc_html__('Account Register URL','em4u'),
		'description' => esc_html__('Choose page has slug is member-register. Example name page: Register','em4u'),
		'section' => 'account_section',
		'settings' => 'account_register',
		'type' =>'text',
		'value' => ''

	));


	$wp_customize->add_setting( 'account_info', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('account_info', array(
		'label' => esc_html__('Account Info URL','em4u'),
		'description' => esc_html__('Choose page has slug is member-account. Example name page: Your Account','em4u'),
		'section' => 'account_section',
		'settings' => 'account_info',
		'type' =>'text',
		'value' => ''

	));




	// Layout setting ////////////////////////////////////////////////////////////////////////////////////////////////////////

	$wp_customize->add_section( 'layout_section' , array(
	    'title'      => esc_html( 'Layout Global', 'em4u' ),
	    'priority'   => 30,
	) );

	$wp_customize->add_setting( 'main_layout', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => 'right_sidebar',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('main_layout', array(
		'label' => esc_html__('Global Layout for site','em4u'),
		'section' => 'layout_section',
		'settings' => 'main_layout',
		'description' => esc_html__('You can override Layout in config of Post/Page', 'em4u'),
		'type' =>'select',
		'choices' => array(
			'right_sidebar' => esc_html__('Right Sidebar', 'em4u'),
			'left_sidebar' => esc_html__('Left Sidebar', 'em4u'),
			'no_sidebar' => esc_html__('No Sidebar','em4u'),
			'fullwidth' => esc_html__('Full Width','em4u'),
			)

	));


	$wp_customize->add_setting( 'width_site', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => 'wide',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('width_site', array(
		'label' => esc_html__('Width of site','em4u'),
		'section' => 'layout_section',
		'settings' => 'width_site',
		'type' =>'select',
		'choices' => array(
			'wide' => esc_html__( 'Wide', 'em4u' ),
            'boxed'   => esc_html__('Boxed', 'em4u')
			)

	));

	// Sidebar column setting
	$wp_customize->add_setting( 'sidebar_column', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '4',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('sidebar_column', array(
		'label' => esc_html__('Sidebar column','em4u'),
		'description' => esc_html__('main column + sidebar column = 12 columns','em4u'),
		'section' => 'layout_section',
		'settings' => 'sidebar_column',
		'type' =>'select',
		'choices' => array(
			'1' => esc_html__('1 column', 'em4u'),
			'2' => esc_html__('2 columns', 'em4u'),
			'3' => esc_html__('3 columns', 'em4u'),
			'4' => esc_html__('4 columns', 'em4u'),
			'5' => esc_html__('5 columns', 'em4u'),
			'6' => esc_html__('6 columns', 'em4u')
			)
	));

	// Main column settings
	$wp_customize->add_setting( 'main_column', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '8',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('main_column', array(
		'label' => esc_html__('Main column','em4u'),
		'description' => esc_html__('main column + sidebar column = 12 columns','em4u'),
		'section' => 'layout_section',
		'settings' => 'main_column',
		'type' =>'select',
		'choices' => array(
			'11' => esc_html__('11 columns', 'em4u'),
			'10' => esc_html__('10 columns', 'em4u'),
			'9' => esc_html__('9 columns', 'em4u'),
			'8' => esc_html__('8 columns', 'em4u'),
			'7' => esc_html__('7 columns', 'em4u'),
			'6' => esc_html__('6 columns', 'em4u'),
			)
	));
	
	// /Layout setting ////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	// Woo setting ////////////////////////////////////////////////////////////////////////////////////////////////////////
	$wp_customize->add_section( 'woo_section' , array(
	    'title'      => esc_html( 'Woocommerce setting', 'em4u' ),
	    'priority'   => 30,
	) );

	// Woo layout
	$wp_customize->add_setting( 'woo_layout', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => 'right_sidebar',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback'// Get function name 
	  
	) );
	$wp_customize->add_control('woo_layout', array(
		'label' => esc_html__('Layout','em4u'),
		'section' => 'woo_section',
		'settings' => 'woo_layout',
		'type' =>'select',
		'choices' => array(
			'right_sidebar' => esc_html__('Right Sidebar','em4u'),
			'no_sidebar' => esc_html__('No Sidebar','em4u'),
			'left_sidebar' => esc_html__('Left Sidebar','em4u'),
			'fullwidth' => esc_html__('Full Width','em4u')
			)
	));


	// Woo Sidebar column
	$wp_customize->add_setting( 'woo_sidebar_column', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '4',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('woo_sidebar_column', array(
		'label' => esc_html__('Woo Sidebar column','em4u'),
		'description' => esc_html__('main column + sidebar column = 12 columns','em4u'),
		'section' => 'woo_section',
		'settings' => 'woo_sidebar_column',
		'type' =>'select',
		'choices' => array(
			'1' => esc_html__('1 column', 'em4u'),
			'2' => esc_html__('2 columns', 'em4u'),
			'3' => esc_html__('3 columns', 'em4u'),
			'4' => esc_html__('4 columns', 'em4u'),
			'5' => esc_html__('5 columns', 'em4u'),
			'6' => esc_html__('6 columns', 'em4u')
			)
	));

	// Woo Main column
	$wp_customize->add_setting( 'woo_main_column', array(
	  'type' => 'theme_mod', // or 'option'
	  'capability' => 'edit_theme_options',
	  'theme_supports' => '', // Rarely needed.
	  'default' => '8',
	  'transport' => 'refresh', // or postMessage
	  'sanitize_callback' => 'em4u_fun_sanitize_callback' // Get function name 
	  
	) );

	$wp_customize->add_control('woo_main_column', array(
		'label' => esc_html__('Woo Main column','em4u'),
		'description' => esc_html__('main column + sidebar column = 12 columns','em4u'),
		'section' => 'woo_section',
		'settings' => 'woo_main_column',
		'type' =>'select',
		'choices' => array(
			'11' => esc_html__('11 columns', 'em4u'),
			'10' => esc_html__('10 columns', 'em4u'),
			'9' => esc_html__('9 columns', 'em4u'),
			'8' => esc_html__('8 columns', 'em4u'),
			'7' => esc_html__('7 columns', 'em4u'),
			'6' => esc_html__('6 columns', 'em4u'),
			)
	));



}

function em4u_fun_sanitize_callback($value){
    return $value;
}


add_action( 'customize_register', 'em4u_customize_register' );