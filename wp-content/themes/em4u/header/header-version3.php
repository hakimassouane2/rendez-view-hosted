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
<!-- Heading Version 3 -->
<header class="ova_header ovatheme_header_v3 bg_heading <?php echo esc_attr($show_heading).'_bg'; ?> <?php echo esc_attr($header_fixed); ?> <?php echo esc_attr($has_logo_scroll); ?> <?php echo esc_attr($has_logo_mobile); ?> ">

	<?php if( is_active_sidebar('header_v3') || get_theme_mod( 'show_menu_account', 'yes' ) == 'yes' ){ ?>
		<div class="container-fluid ova-top">
			<div class="container">

				<?php if( is_active_sidebar('header_v3') ){ ?>
					<div class="wrap_left pull-left">
						<?php dynamic_sidebar('header_v3'); ?>
					</div>
				<?php } ?>

				<?php if( get_theme_mod( 'show_menu_account', 'no' ) == 'yes' ){ ?>
					<div class="wrap_right pull-right">
						<div class="item_top">
							<div class="ova-login">

								

								<?php if ( !is_user_logged_in() ) {
									$account_register = get_theme_mod( 'account_register', '' );
									$account_login = get_theme_mod( 'account_login', '' );
								?>
									<i class="icon_lock-open_alt"></i>
									<a href="<?php echo esc_url($account_login); ?>" class="ova_icon_open">
										<?php esc_html_e( 'Login / ', 'em4u' ); ?>&nbsp; 
									</a> 
						            <a href="<?php echo esc_url($account_register); ?>" class="ova_icon_key">
						            	<?php esc_html_e( 'Register', 'em4u' ); ?>
						            </a>

					            <?php } else{ $account_info = get_theme_mod( 'account_info', '' ); ?>
					            
					            	<i class="icon_profile"></i>
					        		<a href="<?php echo esc_url($account_info); ?>" class="ova_icon_open">
					        			<?php esc_html_e( 'My Account', 'em4u' ); ?>
					        		</a>

					            <?php } ?>


							</div>
						</div>
					</div>	
				<?php } ?>
			</div>
		</div>
	<?php } ?>

	<div class="scroll_fixed">
		<div class="container">

			<div class="row">

				<div class="ova-menu">
					<nav class="navbar">
					  <div class="container-fluid">
					    <!-- Brand and toggle get grouped for better mobile display -->
					    <div class="ova-logo navbar-header">

							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#ovatheme_header_v3" aria-expanded="false">
							<span class="sr-only"><?php esc_html_e('Toggle navigation', 'em4u'); ?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>

							<?php 
								$desk_logo = get_post_meta( $current_id, 'em4u_met_desk_logo', true ); 
								$desk_logo_scroll = get_post_meta( $current_id, 'em4u_met_desk_logo_scroll', true ); 
								$mobile_logo = get_post_meta( $current_id, 'em4u_met_mobile_logo', true );
							?>

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

					    <!-- Collect the nav links, forms, and other content for toggling -->
					    <div class="collapse navbar-collapse" id="ovatheme_header_v3">
					      
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
			                    'menu_class'        => 'nav navbar-nav navbar-right',
			                    'fallback_cb'       => $fallback_cb,
			                    'walker'            => new $walker
			                )); ?>
					      
					    </div><!-- /.navbar-collapse -->

					    

					  </div> <!-- /.container-fluid -->
					</nav>
				</div>

			</div>	 

		</div>
	</div>

	<!-- Background Heading -->
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