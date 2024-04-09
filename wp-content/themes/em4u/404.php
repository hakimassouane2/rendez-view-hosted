<?php get_header(); 
do_action('em4u_open_layout');
?>

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