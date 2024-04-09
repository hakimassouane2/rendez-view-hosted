<?php 

	$current_id = get_the_id();

	$desk_logo = get_post_meta( $current_id, 'em4u_met_desk_logo', true ); 
	$desk_logo_scroll = get_post_meta( $current_id, 'em4u_met_desk_logo_scroll', true ); 
	$mobile_logo = get_post_meta( $current_id, 'em4u_met_mobile_logo', true );

	$header_fixed = get_theme_mod( 'header_fixed', 'fixed' );
	// Archive
	$post_type = get_post_type();
	if ( ! is_singular() ) {
		switch ( $post_type ) {
			case 'post':
				$header_fixed = get_theme_mod( 'header_fixed_blog_archive', 'fixed' );
				break;
			case 'event':
				$header_fixed = get_theme_mod( 'header_fixed_event_archive', 'fixed' );
				break;
			default:
				break;
		}
	}
	$has_logo_scroll = ( get_theme_mod( 'logo_scroll', '' ) || $desk_logo_scroll ) ? 'has_logo_scroll' : '';
	$has_logo_mobile = ( get_theme_mod( 'logo_mobile', '' ) || $mobile_logo ) ? 'has_logo_mobile' : '';
	

	if( is_singular() ){
		$show_heading = get_post_meta( $current_id, 'em4u_met_show_heading', true ) ? get_post_meta( $current_id, 'em4u_met_show_heading', true ) : 'yes';
		$bg_header = get_post_meta( $current_id, 'em4u_met_bg_header', true ) ? get_post_meta( $current_id, 'em4u_met_bg_header', true ) : get_theme_mod('bg_default_header', EM4U_URI.'/assets/img/bg_heading-compressor.jpg');
	}else{
		$show_heading = 'yes';
		$bg_header = get_theme_mod('bg_default_header', EM4U_URI.'/assets/img/bg_heading-compressor.jpg');
		// Archive
		switch ( $post_type ) {
			case 'post':
				$bg_header = get_theme_mod( 'bg_header_blog_archive', EM4U_URI.'/assets/img/bg_heading-compressor.jpg' );
				break;
			case 'event':
				$bg_header = get_theme_mod( 'bg_header_event_archive', EM4U_URI.'/assets/img/bg_heading-compressor.jpg' );
				break;
			default:
				break;
		}
	}

	//  Desktop Logo Width
	$desk_logo_width = get_theme_mod( 'desk_logo_width' ) != '' ? 'width:'.esc_attr( get_theme_mod( 'desk_logo_width' ) ).';' : '';
	$desk_logo_height = get_theme_mod( 'desk_logo_height' ) != '' ? 'height: '.esc_attr( get_theme_mod( 'desk_logo_height' ) ).';' : '';
	
	if( get_post_meta( $current_id, 'em4u_met_desk_logo_width', true ) != '' ){
		$desk_logo_width = 'width:'.esc_attr( get_post_meta( $current_id, 'em4u_met_desk_logo_width', true ) ).';';
	}
	if( get_post_meta( $current_id, 'em4u_met_desk_logo_height', true ) != '' ){
		$desk_logo_height = 'height:'.esc_attr( get_post_meta( $current_id, 'em4u_met_desk_logo_height', true ) ).';';
	}

	//  Desktop Logo Scroll Width
	$desk_logo_scroll_width = get_theme_mod( 'desk_logo_scroll_width' ) != '' ? 'width:'.esc_attr( get_theme_mod( 'desk_logo_scroll_width' ) ).';' : '';
	$desk_logo_scroll_height = get_theme_mod( 'desk_logo_scroll_height' ) != '' ? 'height: '.esc_attr( get_theme_mod( 'desk_logo_scroll_height' ) ).';' : '';
	
	if( get_post_meta( $current_id, 'em4u_met_desk_logo_scroll_width', true ) != '' ){
		$desk_logo_scroll_width = 'width:'.esc_attr( get_post_meta( $current_id, 'em4u_met_desk_logo_scroll_width', true ) ).';';
	}
	if( get_post_meta( $current_id, 'em4u_met_desk_logo_scroll_height', true ) != '' ){
		$desk_logo_scroll_height = 'height:'.esc_attr( get_post_meta( $current_id, 'em4u_met_desk_logo_scroll_height', true ) ).';';
	}

	// Mobile Logo Width
	$logo_mobile_width = get_theme_mod( 'logo_mobile_width' ) != '' ? 'width:'.esc_attr( get_theme_mod( 'logo_mobile_width' ) ).';' : '';
	$logo_mobile_height = get_theme_mod( 'logo_mobile_height' ) != '' ? 'height: '.esc_attr( get_theme_mod( 'logo_mobile_height' ) ).';' : '';
	
	if( get_post_meta( $current_id, 'em4u_met_mobile_logo_width', true ) != '' ){
		$logo_mobile_width = 'width:'.esc_attr( get_post_meta( $current_id, 'em4u_met_mobile_logo_width', true ) ).';';
	}
	if( get_post_meta( $current_id, 'em4u_met_mobile_logo_height', true ) != '' ){
		$logo_mobile_height = 'height:'.esc_attr( get_post_meta( $current_id, 'em4u_met_mobile_logo_height', true ) ).';';
	}
	
	
?>

<!-- Heading Version 1 -->
<header class="ova_header ovatheme_header_v1  bg_heading <?php echo esc_attr($header_fixed); ?> <?php echo esc_attr($has_logo_scroll); ?> <?php echo esc_attr($has_logo_mobile); ?>">

	<div class="wrap_menu_logo ova-menu">

		<div class="ova-logo navbar-header">

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#ovatheme_header_v1" aria-expanded="true">
				<span class="sr-only"><?php esc_html_e('Toggle navigation', 'em4u'); ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

	      	<a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand logo">
	      		<?php if( $desk_logo ){ ?>
	      			<img src="<?php  echo esc_url( $desk_logo ); ?>" alt="<?php bloginfo('name');  ?>" style="<?php echo $desk_logo_width.' '.$desk_logo_height; ?>">
	      		<?php }else if( get_theme_mod( 'logo', '' ) != '' ) { ?>
            		<img src="<?php  echo esc_url( get_theme_mod('logo', '') ); ?>" alt="<?php bloginfo('name');  ?>" style="<?php echo $desk_logo_width.' '.$desk_logo_height; ?>" >
            	<?php }else { ?> <span class="blogname"><?php bloginfo('name');  ?></span><?php } ?>
            </a>

            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand logo_scroll">
            	<?php if( $desk_logo_scroll ){ ?>
            		<img src="<?php  echo esc_url( $desk_logo_scroll ); ?>" alt="<?php bloginfo('name');  ?>" style="<?php echo $desk_logo_scroll_width.' '.$desk_logo_scroll_height; ?>">
            	<?php }else if( get_theme_mod( 'logo_scroll', '' ) != '' ) { ?>
            		<img src="<?php  echo esc_url( get_theme_mod('logo_scroll', '') ); ?>" alt="<?php bloginfo('name');  ?>" style="<?php echo $desk_logo_scroll_width.' '.$desk_logo_scroll_height; ?>">
            	<?php }else { ?> <span class="blogname"><?php bloginfo('name');  ?></span><?php } ?>
            </a>

            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand logo_mobile">
            	<?php if( $mobile_logo ){ ?>
            		<img src="<?php  echo esc_url( $mobile_logo ); ?>" alt="<?php bloginfo('name');  ?>" style="<?php echo $logo_mobile_width.' '.$logo_mobile_height; ?>">
            	<?php }else if ( get_theme_mod( 'logo_mobile', '' ) != '' ) { ?>
            		<img src="<?php  echo esc_url( get_theme_mod('logo_mobile', '') ); ?>" alt="<?php bloginfo('name');  ?>" style="<?php echo $logo_mobile_width.' '.$logo_mobile_height; ?>">
            	<?php }else { ?> <span class="blogname"><?php bloginfo('name');  ?></span><?php } ?>
            </a>

	    </div>

	      

		<div class="container  collapse navbar-collapse" id="ovatheme_header_v1" >
			<nav class="navbar">
			  <div class="container-fluid">
			    <div class="row" >
			      
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
	                    'depth'             => 3,
	                    'container'         => '',
	                    'container_class'   => '',
	                    'container_id'      => '',
	                    'menu_class'        => 'nav navbar-nav',
	                    'fallback_cb'       => $fallback_cb,
	                    'walker'            => new $walker
	                )); ?>
			      
			    </div>
			  </div> 
			</nav>
		</div>


		<?php if( get_theme_mod( 'show_menu_account', 'no' ) == 'yes' ){ ?>
			<div class="ova-account">
				<?php if ( !is_user_logged_in() ) {
					$account_register = get_theme_mod( 'account_register', '' );
					$account_login = get_theme_mod( 'account_login', '' );
				?>

					<a href="<?php echo esc_url($account_login); ?>" class="ova_icon_open"><i class=" icon_lock-open_alt"></i></a>
		            <a href="<?php echo esc_url($account_register); ?>" class="ova_icon_key"><i class="icon_key_alt"></i></a>

	            <?php } else{ $account_info = get_theme_mod( 'account_info', '' ); ?>

	        		<a href="<?php echo esc_url($account_info); ?>" class="ova_icon_open"><i class="icon_profile"></i></a>

	            <?php } ?>
			</div>
		<?php } ?>

	</div>

	
	<?php if( $show_heading == 'yes' ){ ?>

		<div class="ova-bg-heading" style="background-image: url( <?php echo esc_url($bg_header); ?> ); ">
			<div class="bg_cover"></div>

			<div class="container ova-breadcrumbs">
				<h1 class="ova_title">
					<?php echo em4u_the_title(); ?>
				</h1>
				<?php if( class_exists( 'woocommerce' ) && is_woocommerce() ){
					do_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20 );
				}else{
					em4u_breadcrumbs();
				} ?>
				
			</div>
			
		</div>

	<?php } ?>

</header>