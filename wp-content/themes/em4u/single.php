<?php get_header();
do_action('em4u_open_layout');

// Get content
if ( have_posts() ) : while ( have_posts() ) : the_post();

	get_template_part( 'content/content', 'single' );

    if ( comments_open() || get_comments_number() ) {
    	comments_template();
    }
	
endwhile; else :
    get_template_part( 'content/content', 'none' );
endif;

do_action('em4u_close_layout');
get_footer(); ?>