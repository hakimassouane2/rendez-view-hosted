<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */



add_action( 'cmb2_init', 'em4u_metaboxes_default' );
function em4u_metaboxes_default() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = 'em4u_met_';

    

    
    /* Page Settings ***************************************************************************/
    /* ************************************************************************************/
    $page_settings = new_cmb2_box( array(
        'id'            => 'page_heading_settings',
        'title'         => esc_html__( 'Show Page Heading', 'em4u' ),
        'object_types'  => array( 'page'), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true,
        
    ) );

        // Display title of page
        $page_settings->add_field( array(
            'name'       => esc_html__( 'Show title of page', 'em4u' ),
            'desc'       => esc_html__( 'Allow display title of page', 'em4u' ),
            'id'         => $prefix . 'page_heading',
            'type'             => 'select',
            'show_option_none' => false,
            'options'          => array(
                'yes' => esc_html__( 'Yes', 'em4u' ),
                'no'   => esc_html__('No', 'em4u' )
            ),
            'default' => 'yes',
            
        ) );


 
   

    
    /* Post Settings *********************************************************************************/
    /* *******************************************************************************/
    $post_settings = new_cmb2_box( array(
        'id'            => 'post_video',
        'title'         => esc_html__( 'Post Settings', 'em4u' ),
        'object_types'  => array( 'post'), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

        // Video or Audio
        $post_settings->add_field( array(
            'name'       => esc_html__( 'Link audio or video', 'em4u' ),
            'desc'       => esc_html__( 'Insert link audio or video use for video/audio post-format', 'em4u' ),
            'id'         => $prefix . 'embed_media',
            'type'             => 'oembed',
        ) );


        // Gallery image
        $post_settings->add_field( array(
            'name'       => esc_html__( 'Gallery image', 'em4u' ),
            'desc'       => esc_html__( 'image in gallery post format', 'em4u' ),
            'id'         => $prefix . 'file_list',
            'type'             => 'file_list',
        ) );




    /* General Settings ***************************************************************/
    /* ********************************************************************************/
    if( class_exists('OVAEM_Settings') ){
        $event = OVAEM_Settings::event_post_type_slug();
        $speaker = OVAEM_Settings::speaker_post_type_slug();
        $venue = OVAEM_Settings::venue_post_type_slug();
    }else{
        $event = $speaker = $venue = '';
    }
    
    $general_settings = new_cmb2_box( array(
        'id'            => 'layout_settings',
        'title'         => esc_html__( 'General Settings', 'em4u' ),
        'object_types'  => array( 'page', 'post', $event, $speaker, $venue ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ));

        $general_settings->add_field( array(
            'name'              => esc_html__( 'Choose menu type to display menu', 'em4u' ),
            'id'                => $prefix . 'location_theme',
            'type'              => 'select',
            'show_option_none'  => false,
            'options'           => array(
                'primary'       => esc_html__( 'Primary', 'em4u' ),
                'landing'       => esc_html__('Landing page', 'em4u')
            ),
            'default' => 'primary',
            
        ) );

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Header Version', 'em4u' ),
            'id'         => $prefix . 'header_version',
            'description' => esc_html__( 'This value will override value in customizer. if you use Header Default, some field will doesn\'t work: Logo, Background Header, Background Heading', 'em4u' ),
            'type'             => 'select',
            'show_option_none' => false,
            'options'          => em4u_load_header_metabox(),
            'default' => 'global'
            
        ));

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Desktop Logo', 'em4u' ),
            'id'         => $prefix . 'desk_logo',
            'description' => esc_html__( 'This value will override value in customizer', 'em4u' ),
            'type'             => 'file',
            'show_option_none' => false,
            'default' => ''
            
        ));

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Desktop Logo Width', 'em4u' ),
            'id'         => $prefix . 'desk_logo_width',
            'description' => esc_html__( 'Example: 120px; This value will override value in customizer', 'em4u' ),
            'type'             => 'text',
            'show_option_none' => false,
            'default' => ''
            
        ));

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Desktop Logo Height', 'em4u' ),
            'id'         => $prefix . 'desk_logo_height',
            'description' => esc_html__( 'Example: 70px; This value will override value in customizer', 'em4u' ),
            'type'             => 'text',
            'show_option_none' => false,
            'default' => ''
            
        ));

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Desktop Logo Scroll', 'em4u' ),
            'id'         => $prefix . 'desk_logo_scroll',
            'description' => esc_html__( 'This value will override value in customizer', 'em4u' ),
            'type'             => 'file',
            'show_option_none' => false,
            'default' => ''
            
        ));

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Desktop Logo Scroll Width', 'em4u' ),
            'id'         => $prefix . 'desk_logo_scroll_width',
            'description' => esc_html__( 'Example: 120px; This value will override value in customizer', 'em4u' ),
            'type'             => 'text',
            'show_option_none' => false,
            'default' => ''
            
        ));

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Desktop Logo Scroll Height', 'em4u' ),
            'id'         => $prefix . 'desk_logo_scroll_height',
            'description' => esc_html__( 'Example: 70px; This value will override value in customizer', 'em4u' ),
            'type'             => 'text',
            'show_option_none' => false,
            'default' => ''
            
        ));

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Mobile Logo', 'em4u' ),
            'id'         => $prefix . 'mobile_logo',
            'description' => esc_html__( 'This value will override value in customizer', 'em4u' ),
            'type'             => 'file',
            'show_option_none' => false,
            'default' => ''
            
        ));

         $general_settings->add_field( array(
            'name'       => esc_html__( 'Mobile Logo Width', 'em4u' ),
            'id'         => $prefix . 'mobile_logo_width',
            'description' => esc_html__( 'Example: 120px; This value will override value in customizer', 'em4u' ),
            'type'             => 'text',
            'show_option_none' => false,
            'default' => ''
            
        ));

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Mobile Logo Height', 'em4u' ),
            'id'         => $prefix . 'mobile_logo_height',
            'description' => esc_html__( 'Example: 70px; This value will override value in customizer', 'em4u' ),
            'type'             => 'text',
            'show_option_none' => false,
            'default' => ''
            
        ));





        $general_settings->add_field( array(
            'name'       => esc_html__( 'Background Header Color', 'em4u' ),
            'id'         => $prefix . 'bg_color_header',
            'description' => esc_html__( 'This value will override value in customizer', 'em4u' ),
            'type'             => 'colorpicker',
            'show_option_none' => false,
            'default' => ''
            
        ));

        $general_settings->add_field( array(
            'name'              => esc_html__( 'Opacity Background Header Color', 'em4u' ),
            'id'                => $prefix . 'bg_color_header_opacity',
            'type'              => 'select',
            'show_option_none'  => false,
            'options'           => array(
                ''       => '',
                '0'       => '0',
                '0.1'       => '0.1',
                '0.2'       => '0.2',
                '0.3'       => '0.3',
                '0.4'       => '0.4',
                '0.5'       => '0.5',
                '0.6'       => '0.6',
                '0.7'       => '0.7',
                '0.8'       => '0.8',
                '0.9'       => '0.9',
                '1'         => '1',

            ),
            'default' => '',
            
        ) );

        

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Show Heading', 'em4u' ),
            'desc'       => esc_html__( 'You will see background, title, breadcrumbs bellow menu', 'em4u' ),
            'id'         => $prefix.'show_heading',
            'type'             => 'select',
            'show_option_none' => false,
            'options'          => array(
                'yes'   => esc_html__('Yes', 'em4u' ),
                'no' => esc_html__( 'No', 'em4u' )
                ),
            'default' => 'yes',
            
        ) );

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Background Heading', 'em4u' ),
            'id'         => $prefix . 'bg_header',
            'type'             => 'file',
            'show_option_none' => false
            
        ));


        $general_settings->add_field( array(
            'name'       => esc_html__( 'Background Page/Post', 'em4u' ),
            'id'         => $prefix.'bg_page',
            'type'             => 'select',
            'show_option_none' => false,
            'options'          => array(
                'bg_white'   => esc_html__('White', 'em4u' ),
                'bg_grey' => esc_html__( 'Grey', 'em4u' )
                ),
            'default' => 'bg_white',
            
        ) );


        $general_settings->add_field( array(
            'name'       => esc_html__( 'Footer Version', 'em4u' ),
            'id'         => $prefix . 'footer_version',
            'description' => esc_html__( 'This value will override value in customizer', 'em4u'  ),
            'type'             => 'select',
            'show_option_none' => false,
            'options'          => em4u_load_footer_metabox(),
            'default' => 'global'

        ) );

        $general_settings->add_field( array(
            'name'       => esc_html__( 'Main Layout', 'em4u' ),
            'desc'       => esc_html__( 'This value will override value in theme customizer', 'em4u' ),
            'id'         => $prefix.'main_layout',
            'type'             => 'select',
            'show_option_none' => false,
            'options'          => array(
                'global'   => esc_html__('Global in customizer', 'em4u' ),
                'right_sidebar' => esc_html__( 'Right Sidebar', 'em4u' ),
                'left_sidebar'   => esc_html__('Left Sidebar', 'em4u' ),
                'no_sidebar'   => esc_html__('No Sidebar', 'em4u' ),
                'fullwidth'     => esc_html__( 'Full Width', 'em4u' )
                ),
            'default' => 'global',
            
        ) );


        $general_settings->add_field( array(
            'name'       => esc_html__( 'Width of site', 'em4u' ),
            'desc'       => esc_html__( 'This value will override value in theme customizer', 'em4u' ),
            'id'         => $prefix . 'width_site',
            'type'             => 'select',
            'show_option_none' => false,
            'options'          => array(
                'global'    => esc_html__('Global in customizer', 'em4u'),
                'wide' => esc_html__( 'Wide', 'em4u' ),
                'boxed'   => esc_html__('Boxed', 'em4u' ),
            ),
            'default' => 'global',
            
        ) );

        

   
}