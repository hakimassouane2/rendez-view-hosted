<?php get_header();
do_action('em4u_open_layout');
?>

<!-- Get content -->

<h2 class="page-title">
	<?php esc_html_e('Search Results for: ','em4u'); printf( '<span>%s</span>', get_search_query() ); ?>
</h2>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content/content', 'search' ); ?>
<?php endwhile; ?>
    <div class="pagination-wrapper">
        <?php em4u_pagination_theme(); ?>
	</div>
<?php else : ?>
        <?php get_template_part( 'content/content', 'none' ); ?>
<?php endif; ?>


<?php 
do_action('em4u_close_layout'); 
get_footer();
?>