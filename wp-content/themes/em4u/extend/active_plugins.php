<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme em4u for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 */
require_once (EM4U_URL.'/framework/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'em4u_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function em4u_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'                     => esc_html__('Contact Form 7','em4u'),
            'slug'                     => 'contact-form-7',
            'required'                 => true,
        ),
        array(
            'name'                     => esc_html__('Widget importer exporter','em4u'),
            'slug'                     => 'widget-importer-exporter',
            'required'                 => true,
        ),
        array(
            'name'                     => esc_html__('Metabox','em4u'),
            'slug'                     => 'cmb2',
            'required'                 => true,
        ),
        array(
            'name'                     => esc_html__('Mailchimp for wp','em4u'),
            'slug'                     => 'mailchimp-for-wp',
            'required'                 => true,
        ),
        array(
            'name'                     => esc_html__('Woocommerce','em4u'),
            'slug'                     => 'woocommerce',
            'required'                 => true,
            'version'                  => '8.3.0',
        ),
        array(
            'name'                     => esc_html__('One click demo import','em4u'),
            'slug'                     => 'one-click-demo-import',
            'required'                 => true,
        ),
        array(
            'name'                     => esc_html__('Recent Posts Widget','em4u'),
            'slug'                     => 'recent-posts-widget-with-thumbnails',
            'required'                 => true,
        ),
        
        array(
            'name'                     => esc_html__('OvaTheme adventpro','em4u'),
            'slug'                     => 'ova-advent',
            'required'                 => true,
            'source'                   => get_template_directory() . '/plugins/ova-advent.zip',
            'version'                   => '1.1.7'
        ),
        array(
            'name'                     => esc_html__('OvaTheme MegaMenu','em4u'),
            'slug'                     => 'ova-megamenu',
            'required'                 => true,
            'source'                   => get_template_directory() . '/plugins/ova-megamenu.zip',
            'version'                   => '1.2.1'
        ),
        array(
            'name'                     => esc_html__('OvaTheme Events Manager','em4u'),
            'slug'                     => 'ova-events-manager',
            'required'                 => true,
            'source'                   => get_template_directory() . '/plugins/ova-events-manager.zip',
            'version'                   => '1.6.6'
        ),

        array(
            'name'                     => esc_html__('OVA Events Manager PayPal Standards Payment Gateway','em4u'),
            'slug'                     => 'ova-events-manager-paypal',
            'required'                 => true,
            'source'                   => get_template_directory() . '/plugins/ova-events-manager-paypal.zip',
            'version'                   => '1.0.2'
        ),
        array(
            'name'                     => esc_html__('OVA Events Manager Stripe Payment Gateway','em4u'),
            'slug'                     => 'ova-events-manager-stripe',
            'required'                 => true,
            'source'                   => get_template_directory() . '/plugins/ova-events-manager-stripe.zip',
            'version'                   => '1.1.4'
        ),
        array(
            'name'                     => esc_html__('OvaTheme Login Register','em4u'),
            'slug'                     => 'ova-login',
            'required'                 => true,
            'source'                   => get_template_directory() . '/plugins/ova-login.zip',
            'version'                   => '1.1.8'
        ),
        array(
            'name'                     => esc_html__('WPBakery Page Builder(Visual Composer)','em4u'),
            'slug'                     => 'js_composer',
            'required'                 => true,
            'source'                   => get_template_directory() . '/plugins/js_composer.zip',

        ),
        array(
            'name'                     => esc_html__('Cube Portfolio','em4u'),
            'slug'                     => 'cubeportfolio',
            'required'                 => true,
            'source'                   => get_template_directory() . '/plugins/cubeportfolio.zip',
        )
        

    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'em4u',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

        
    );

    em4u_tgmpa( $plugins, $config );
}





function em4u_after_import_setup() {

    // After import replace URLs
    em4u_after_import_replace_urls();
    


    // Assign menus to their locations.
    $primary = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
    $landing = get_term_by( 'name', 'Landing Menu', 'nav_menu' );
    

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $primary->term_id,
            'landing' => $landing->term_id
        )
    );

    

    // Assign front page and posts page (blog page).
    $front_page_id = em4u_get_page_by_title( 'Home Default' );
    $blog_page_id  = em4u_get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    

}
add_action( 'ocdi/after_import', 'em4u_after_import_setup' );


function em4u_import_files() {
    return array(
        array(
            'import_file_name'             => 'Demo Import',
            'categories'                   => array( 'Category 1', 'Category 2' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo_import/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo_import/widgets.wie'
        )
    );
}
add_filter( 'ocdi/import_files', 'em4u_import_files' );


function em4u_after_import( $selected_import ) {

    // Fix count Categories
    $update_taxonomy = 'categories';
    $get_terms_args = array(
            'taxonomy' => $update_taxonomy,
            'fields' => 'ids',
            'hide_empty' => false,
            );

    $update_terms = get_terms($get_terms_args);
    wp_update_term_count_now($update_terms, $update_taxonomy);

    // Fix count Categories
    $update_taxonomy_tag = 'event_tags';
    $get_terms_args_tags = array(
            'taxonomy' => $update_taxonomy_tag,
            'fields' => 'ids',
            'hide_empty' => false,
            );

    $update_terms_tags = get_terms($get_terms_args_tags);
    wp_update_term_count_now($update_terms_tags, $update_taxonomy_tag);

}
add_action( 'ocdi/after_import', 'em4u_after_import' );

// Get page by title
if ( ! function_exists( 'em4u_get_page_by_title' ) ) {
    function em4u_get_page_by_title( $page_title, $output = OBJECT, $post_type = 'page' ) {
        global $wpdb;

        if ( is_array( $post_type ) ) {
            $post_type           = esc_sql( $post_type );
            $post_type_in_string = "'" . implode( "','", $post_type ) . "'";
            $sql                 = $wpdb->prepare(
                "
                SELECT ID
                FROM $wpdb->posts
                WHERE post_title = %s
                AND post_type IN ($post_type_in_string)
            ",
                $page_title
            );
        } else {
            $sql = $wpdb->prepare(
                "
                SELECT ID
                FROM $wpdb->posts
                WHERE post_title = %s
                AND post_type = %s
            ",
                $page_title,
                $post_type
            );
        }

        $page = $wpdb->get_var( $sql );

        if ( $page ) {
            return get_post( $page, $output );
        }

        return null;
    }
}



// After import replace URLs
if ( ! function_exists( 'em4u_after_import_replace_urls' ) ) {
    function em4u_after_import_replace_urls() {
        global $wpdb;

        $site_url = get_site_url();
        $demo_url = apply_filters( 'em4u_demo_url', 'https://demo.ovathemewp.com/em4u' );

        // options table
        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->options} " .
                "SET `option_value` = REPLACE(`option_value`, %s, %s);",
                $demo_url,
                $site_url
            )
        );

        // posts table
        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->posts} " .
                "SET `post_content` = REPLACE(`post_content`, %s, %s), `guid` = REPLACE(`guid`, %s, %s);",
                $demo_url,
                $site_url,
                $demo_url,
                $site_url
            )
        );

        // postmeta table
        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->postmeta} " .
                "SET `meta_value` = REPLACE(`meta_value`, %s, %s) " .
                "WHERE `meta_key` <> '_elementor_data';",
                $demo_url,
                $site_url
            )
        );

        // Elementor Data
        $escaped_from       = str_replace( '/', '\\/', $demo_url );
        $escaped_to         = str_replace( '/', '\\/', $site_url );
        $meta_value_like    = '[%'; // meta_value LIKE '[%' are json formatted

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->postmeta} " .
                'SET `meta_value` = REPLACE(`meta_value`, %s, %s) ' .
                "WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE %s;",
                $escaped_from,
                $escaped_to,
                $meta_value_like
            )
        );
    }
}