<?php 
function em4u_breadcrumbs() {
ob_start();

?>
<!-- <div id="breadcrumbs" >
        <?php
      
        if(in_array("search-no-results",get_body_class())){ ?>
           <div class="breadcrumbs" class="col-sm-12">
	           <a href="<?php get_template_directory_uri().'/'; ?>"><?php esc_html__('Home', 'em4u'); ?></a>
	           <span class="separator">/</span>
	           <span class="current"><?php esc_html__('Search results for', 'em4u'); ?> "<?php echo get_search_query(); ?>"</span>
	        </div>
        <?php
            }else{
            	$separator = '';
		        $home = esc_html__('Home', 'em4u');
		        $before = '<li>';
		        $after = '</li>'; 
		?>


		            <div class="breadcrumbs">
						<div class="breadcrumbs-pattern">
							<div class="container">
								<div class="row">
									<ul class="breadcrumb"><?php
		        global $post;
		        global $wp_query;
		        
		        $homeLink = home_url('/');
		        $type=get_post_type();

		        if(! is_home()){
		        	echo '<li><a href="' . $homeLink . '">' . $home . '</a></li> ' . $separator . ' ';	
		        }
		        if( class_exists('OVAEM_Settings') && is_tax( $tax_name = OVAEM_Settings::slug_taxonomy_name() ) ){
		        	print $before .'&nbsp;'. single_cat_title('', false) . '&nbsp;' . $after;
		        }else if( get_query_var('event_tags') != ''  ){
		        	print $before .'&nbsp;'. single_cat_title('', false) .'&nbsp;' . $after;	
		        }else if ( is_category() ) {
			        $cat_obj = $wp_query->get_queried_object();
			        $thisCat = $cat_obj->term_id;
			        $thisCat = get_category($thisCat);
			        $parentCat = get_category($thisCat->parent);
			        if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' '));
			        print $before . '' . single_cat_title('', false) . '' . $after;
		        } elseif ( is_day() ) {
			        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $separator . ' ';
			        echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> </li>' . $separator . ' ';
			        print $before . esc_html__('Archive by date', 'em4u').' ' . get_the_time('d') . '' . $after;
		        } elseif ( is_month() ) {
			        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> </li>' . $separator . ' ';
			        print $before . esc_html__('Archive by month', 'em4u').' ' . get_the_time('F') . '' . $after;
		        } elseif ( is_year() ) {
		        	print $before . esc_html__('Archive by year', 'em4u').'' . get_the_time('Y') . '' . $after;
		        } elseif ( is_single() && !is_attachment() ) {
			        if ( get_post_type() != 'post' ) {
				        $post_type = get_post_type_object(get_post_type());
				        $slug = $post_type->rewrite;
				        echo '<li><a href="' . $homeLink .  $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>' . $separator . ' ';
				        print $before . get_the_title() . $after;
			        } else {
				        $cat = get_the_category(); $cat = $cat[0];
				        echo '<li> ' . get_category_parents($cat, TRUE, ' ' . $separator . ' ') . '</li> ';
				        print $before . '' . get_the_title() . '' . $after;
			        }
		        } else if( is_tax( 'location' ) ){
		        	$term = get_term_by( 'slug', get_query_var( 'location' ), 'location' ); 
		        	print $before . $term->name . $after;

		        }elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			        $post_type = get_post_type_object(get_post_type());
			        print $before . $post_type->labels->singular_name . $after;
		        } elseif ( is_attachment() ) {
			        $parent_id  = $post->post_parent;
			        $breadcrumbs = array();
			        while ($parent_id) {
				        $page = get_page($parent_id);
				        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
				        $parent_id    = $page->post_parent;
			        }
			        $breadcrumbs = array_reverse($breadcrumbs);
			        foreach ($breadcrumbs as $crumb) echo ' ' . $crumb . ' ' . $separator . ' ';
			        print $before . '' . get_the_title() . '' . $after;
		        } elseif ( is_page() && !$post->post_parent ) {
		        	print $before . '' . get_the_title() . '' . $after;
		        } elseif ( is_page() && $post->post_parent ) {
			        $parent_id  = $post->post_parent;
			        $breadcrumbs = array();
			        while ($parent_id) {
				        $page = get_page($parent_id);
				        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
				        $parent_id = $page->post_parent;
			        }
			        $breadcrumbs = array_reverse($breadcrumbs);
			        foreach ($breadcrumbs as $crumb) echo ' ' . $crumb . ' ' . $separator . ' ';
		        	print $before . '' . get_the_title() . '' . $after;
		        } elseif ( is_search()) {
		            print $before . esc_html__('Search results for', 'em4u').' ' . get_search_query() . '' . $after;
		        } elseif ( is_tag() ) {
		        	print $before . esc_html__('Archive by tag', 'em4u').' ' . single_tag_title('', false) . '' . $after;
		        } elseif ( is_author() ) {
		        global $author;
		        $userdata = get_userdata($author);
		        	print $before . esc_html__('Articles posted by', 'em4u').' ' . $userdata->display_name . '' . $after;
		        } elseif ( is_404() ) {
		        	print $before . esc_html__('You got it Error 404 not Found', 'em4u').'&nbsp;' . $after;
		        }
		        
		        if ( get_query_var('paged') ) {
			        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' ';
			        
			        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '';
		        }
		        
								        echo '</ul>
										</div>
									</div>
								</div>
							</div>';
            }
        ?>
</div> -->
<?php 

$list_post2 = ob_get_contents();ob_end_clean();?>
 <?php print  $list_post2; 
} ?>