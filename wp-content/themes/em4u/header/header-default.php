<?php
$header_fixed = get_theme_mod( 'header_fixed', 'no_fixed' );
// Archive
$post_type = get_post_type();
if ( ! is_singular() ) {
	switch ( $post_type ) {
		case 'post':
			$header_fixed = get_theme_mod( 'header_fixed_blog_archive', 'no_fixed' );
			break;
		case 'event':
			$header_fixed = get_theme_mod( 'header_fixed_event_archive', 'no_fixed' );
			break;
		default:
			break;
	}
}
?>
<!-- Heading Default -->
<header class="ovatheme_header_default <?php echo esc_attr($header_fixed); ?> bg">
	<div class="container">
		<div class="row">
			<nav class="navbar">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">

			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#ovatheme_header_default" aria-expanded="false">
			        <span class="sr-only"><?php esc_html_e('Toggle navigation', 'em4u'); ?></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>

			      
			      <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand">
	                	<?php if( get_theme_mod( 'logo', '' ) != '' ) { ?>
	                		<img src="<?php  echo esc_url( get_theme_mod('logo', '') ); ?>" alt="<?php bloginfo('name');  ?>">
	                	<?php }else { ?> <span class="blogname"><?php bloginfo('name');  ?></span><?php } ?>
	                </a>

			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="ovatheme_header_default">
			      
			      <?php 

			      if ( class_exists('ova_megamenu_Walker_Nav_Menu') ) {
			      	$fallback_cb = 'ova_megamenu_Walker_Nav_Menu::fallback';
			      	$walker = 'ova_megamenu_Walker_Nav_Menu';
			      }else{
			      	$fallback_cb = 'em4u_wp_bootstrap_navwalker::fallback';
			      	$walker = 'em4u_wp_bootstrap_navwalker';
			      }

			      	$themelocation =  get_post_meta( em4u_get_current_id(), "em4u_met_location_theme", true) ? get_post_meta( em4u_get_current_id(), "em4u_met_location_theme", true):'primary';

	                wp_nav_menu( array(
	                    'menu'              => '',
	                    'theme_location'    => $themelocation,
	                    'depth'             => 4,
	                    'container'         => '',
	                    'container_class'   => '',
	                    'container_id'      => '',
	                    'menu_class'        => 'nav navbar-nav navbar-right',
	                    'fallback_cb'       => $fallback_cb,
	                    'walker'            => new $walker
	                )); ?>
			      
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</div>
	</div>
</header>