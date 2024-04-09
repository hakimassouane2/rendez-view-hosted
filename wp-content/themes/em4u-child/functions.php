<?php
/**
 * Setup ova em4u Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function em4u_child_theme_setup() {
	load_child_theme_textdomain( 'em4u-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'em4u_child_theme_setup' );


// Add Code is here.

// Add Parent Style
add_action( 'wp_enqueue_scripts', 'em4u_child_scripts' );
function em4u_child_scripts() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri(). '/style.css' );
}


