<?php
/**
 * Plugin Name:       Ova Login
 * Description:       A plugin that replaces the WordPress login flow with a custom page.
 * Version:           1.1.8
 * Author:            Ovatheme
 * License:           GPL-2.0+
 * Text Domain:       ova-login
 */
 
class Ova_Login_Plugin {
 
    /**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
    public function __construct() {

    	load_plugin_textdomain( 'ova-login', false, basename( dirname( __FILE__ ) ) .'/languages' ); 


    	// Add css
		add_action( 'wp_enqueue_scripts', array( $this, 'login_enqueue_scripts' ), 10 ,0 );

    	// Make Form
     	add_shortcode( 'custom-login-form', array( $this, 'render_login_form' ) );
     	if( get_option('permalink_structure') ){
	     	$member_login = new WP_Query( 'pagename=member-login' );
	     	if ( $member_login->have_posts() ) {
	     		add_action( 'login_form_login', array( $this, 'redirect_to_custom_login' ) );	
	     		// Check Login user     	
				add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );
				// Check logout user
				add_action( 'wp_logout', array( $this, 'redirect_after_logout' ) );
	     	}
     	}
		

		// Redirect to page when logged in
		if( get_option('permalink_structure') ){
			$member_account = new WP_Query( 'pagename=member-account' );
	     	if ( $member_account->have_posts() ) {
				add_filter( 'login_redirect', array( $this, 'redirect_after_login' ), 10, 3 );
			}
		}




		/*   Register User */
		add_shortcode( 'custom-register-form', array( $this, 'render_register_form' ) );
		if( get_option('permalink_structure') ){
			$member_register = new WP_Query( 'pagename=member-register' );
	     	if ( $member_register->have_posts() ) {
				add_action( 'login_form_register', array( $this, 'redirect_to_custom_register' ) );
				add_action( 'login_form_register', array( $this, 'do_register_user' ) );
			}
		}


		// My account
		add_shortcode( 'account-info', array( $this, 'account_info' ) );


    }

    /**
     * Add css
     */
    public function login_enqueue_scripts(){
    	wp_enqueue_style('ova_login', plugin_dir_url( __FILE__ ).'assets/css/login.css' );
    }

    /**
	 * Plugin activation hook.
	 *
	 * Creates all WordPress pages needed by the plugin.
	 */
	public static function plugin_activated() {
	    // Information needed for creating the plugin's pages
	    $page_definitions = array(
	        'member-login' => array(
	            'title' => __( 'Sign In', 'ova-login' ),
	            'content' => '[custom-login-form]'
	        ),
	        'member-account' => array(
	            'title' => __( 'Your Account', 'ova-login' ),
	            'content' => '[account-info]'
	        ),
	        'member-register' => array(
		        'title' => __( 'Register', 'ova-login' ),
		        'content' => '[custom-register-form]'
		    ),
	    );
	 
	    foreach ( $page_definitions as $slug => $page ) {
	        // Check that the page doesn't exist already
	        $query = new WP_Query( 'pagename=' . $slug );
	        if ( ! $query->have_posts() ) {
	            // Add the page using the data from the array above
	            wp_insert_post(
	                array(
	                    'post_content'   => $page['content'],
	                    'post_name'      => $slug,
	                    'post_title'     => $page['title'],
	                    'post_status'    => 'publish',
	                    'post_type'      => 'page',
	                    'ping_status'    => 'closed',
	                    'comment_status' => 'closed',
	                )
	            );
	        }
	    }
	}

	/**
	 * A shortcode for rendering the login form.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	

	public function render_login_form( $attributes, $content = null ) {

	    // Parse shortcode attributes
	    $default_attributes = array( 'show_title' => false );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	    $show_title = $attributes['show_title'];
	 
	    if ( is_user_logged_in() ) {
	        return __( 'You are already signed in.', 'ova-login' );
	    }
	     
	    // Pass the redirect parameter to the WordPress login functionality: by default,
	    // don't specify a redirect, but if a valid redirect URL has been passed as
	    // request parameter, use it.
	    $attributes['redirect'] = '';
	    if ( isset( $_REQUEST['redirect_to'] ) ) {
	        $attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
	    }


	    $errors = array();
	    if ( isset( $_REQUEST['login'] ) ) {
	        $error_codes = explode( ',', $_REQUEST['login'] );
	     
	        foreach ( $error_codes as $code ) {
	            $errors []= $this->get_error_message( $code );
	        }
	    }

	    // Check if user just logged out
	    $attributes['logged_out'] = isset( $_REQUEST['logged_out'] ) && $_REQUEST['logged_out'] == true;
	    $attributes['errors'] = $errors;

	    // Check if the user just registered
		$attributes['registered'] = isset( $_REQUEST['registered'] );


	     
	    // Render the login form using an external template
	    return $this->get_template_html( 'login_form', $attributes );
	}


	/**
	 * Renders the contents of the given template to a string and returns it.
	 *
	 * @param string $template_name The name of the template to render (without .php)
	 * @param array  $attributes    The PHP variables for the template
	 *
	 * @return string               The contents of the template.
	 */
	private function get_template_html( $template_name, $attributes = null ) {
	    if ( ! $attributes ) {
	        $attributes = array();
	    }
	 
	    ob_start();
	 
	    do_action( 'ova_login_before_' . $template_name );
	 
	    require( 'templates/' . $template_name . '.php');
	 
	    do_action( 'ova_login_after_' . $template_name );
	 
	    $html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}



	
	/**
	 * Redirect the user to the custom login page instead of wp-login.php.
	 */
	function redirect_to_custom_login() {
	    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	        $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;
	     
	        if ( is_user_logged_in() ) {
	            $this->redirect_logged_in_user( $redirect_to );
	            exit;
	        }
	 
					// @TODO: redirect here to the custom login page with locale

					$locale = isset($_GET['locale']) ? $_GET['locale'] : get_locale();
	        // The rest are redirected to the login page

					if ($locale === 'fr_FR') {
						$login_url = site_url( '/fr/member-login' );
					} else {
	        	$login_url = site_url( 'member-login' );
					}
	        if ( ! empty( $redirect_to ) ) {
	            $login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
	        }
	 
	        wp_redirect( $login_url );
	        exit;
	    }
	}


	/**
	 * Redirects the user to the correct page depending on whether he / she
	 * is an admin or not.
	 *
	 * @param string $redirect_to   An optional redirect_to URL for admin users
	 */
	private function redirect_logged_in_user( $redirect_to = null ) {
	    $user = wp_get_current_user();
	    if ( user_can( $user, 'manage_options' ) ) {
	        if ( $redirect_to ) {
	            wp_safe_redirect( $redirect_to );
	        } else {
	            wp_redirect( admin_url() );
	        }
	    } else if ( $redirect_to ) {
	    	wp_safe_redirect( $redirect_to );
	    }else {
	        wp_redirect( site_url( 'member-account' ) );
	    }
	}



	/**
	 * Redirect the user after authentication if there were any errors.
	 *
	 * @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
	 * @param string            $username   The user name used to log in.
	 * @param string            $password   The password used to log in.
	 *
	 * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
	 */
	function maybe_redirect_at_authenticate( $user, $username, $password ) {
	    // Check if the earlier authenticate filter (most likely, 
	    // the default WordPress authentication) functions have found errors
	    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

	    	// recapcha
	    	if ( isset( $_REQUEST['g-recaptcha-response'] ) ) {
	    		$response 	= $_REQUEST['g-recaptcha-response'];
	    		$secret 	= OVAEM_Settings::captcha_serectkey();
	    		$check_recapcha = $this->ovalg_recapcha_verify( $response, $secret );
	    		if ( is_wp_error( $check_recapcha ) ) {
	    			$error_codes 	= implode( ',', $check_recapcha->get_error_codes() );
	    			$login_url 		= site_url( 'member-login' );
	    			$login_url 		= add_query_arg( 'login', $error_codes, $login_url );

	    			wp_redirect( $login_url );
	            	exit;
	    		}
	    	}

	        if ( is_wp_error( $user ) ) {
	            $error_codes = join( ',', $user->get_error_codes() );
	 
	            $login_url = site_url( 'member-login' );
	            $login_url = add_query_arg( 'login', $error_codes, $login_url );
	 
	            wp_redirect( $login_url );
	            exit;
	        }
	    }
	 
	    return $user;
	}

	public function ovalg_recapcha_verify( $response, $secret ){
		#
		# Verify captcha
		$post_data = http_build_query(
		    array(
		        'secret' => $secret,
		        'response' => $response,
		        'remoteip' => $_SERVER['REMOTE_ADDR']
		    )
		);
		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $post_data
		    )
		);
		$context  = stream_context_create($opts);
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
		$result = json_decode($response);
		if ( ! $result->success ) {
		    $errors = new WP_Error();
		    $errors->add( 'recapcha', $this->get_error_message( 'recapcha' ) );
		    return $errors;
		}
		return true;
	}

	/**
	 * Finds and returns a matching error message for the given error code.
	 *
	 * @param string $error_code    The error code to look up.
	 *
	 * @return string               An error message.
	 */
	private function get_error_message( $error_code ) {
	    switch ( $error_code ) {
	        case 'empty_username':
	            return __( 'You do have an email address, right?', 'ova-login' );
	 
	        case 'empty_password':
	            return __( 'You need to enter a password to login.', 'ova-login' );
	 
	        case 'invalid_username':
	            return __(
	                "We don't have any users with that email address. Maybe you used a different one when signing up?",
	                'ova-login'
	            );
	 
	        case 'incorrect_password':
	            $err = __(
	                "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
	                'ova-login'
	            );
	            return sprintf( $err, site_url('/wp-login.php?action=lostpassword') );

	        // Registration errors
 
			case 'email':
			    return __( 'The email address you entered is not valid.', 'ova-login' );
			 
			case 'email_exists':
			    return __( 'An account exists with this email address.', 'ova-login' );
			case 'invalid_email':
				return __( 'The email address you entered is not valid.', 'ova-login' );
			case 'closed':
			    return __( 'Registering new users is currently not allowed.', 'ova-login' );

			case 'recapcha':
				return __( 'CAPTCHA verification failed.', 'ova-login' );
    
	 
	        default:
	            break;
	    }
	     
	    return __( 'An unknown error occurred. Please try again later.', 'ova-login' );
	}


	/**
	 * Redirect to custom login page after the user has been logged out.
	 */
	public function redirect_after_logout() {
	    $redirect_url = site_url( 'member-login?logged_out=true' );
	    wp_safe_redirect( $redirect_url );
	    exit;
	}


	/**
	 * Returns the URL to which the user should be redirected after the (successful) login.
	 *
	 * @param string           $redirect_to           The redirect destination URL.
	 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
	 *
	 * @return string Redirect URL
	 */
	public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {
	    
	    $redirect_url = site_url();
	 
	    if ( ! isset( $user->ID ) ) {
	        return $redirect_url;
	    }
	 
	    if ( user_can( $user, 'manage_options' ) ) {
	        // Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
	        if ( $requested_redirect_to == '' ) {
	            $redirect_url = admin_url();
	        } else {
	            $redirect_url = $requested_redirect_to;
	        }
	    } else if ( $redirect_to ) {
	    	$redirect_url = $redirect_to;
	    }else {
	        // Non-admin users always go to their account page after login
	        $redirect_url = site_url( 'member-account' );
	    }
	 
	    return wp_validate_redirect( $redirect_url, site_url() );
	}







	/**
	 * A shortcode for rendering the new user registration form.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function render_register_form( $attributes, $content = null ) {
	    // Parse shortcode attributes
	    $default_attributes = array( 'show_title' => false );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 
	    if ( is_user_logged_in() ) {
	        return __( 'You are already signed in.', 'ova-login' );
	    } elseif ( ! get_option( 'users_can_register' ) ) {
	        return __( 'Registering new users is currently not allowed.', 'ova-login' );
	    } else {

	     // Retrieve possible errors from request parameters
	    $attributes['errors'] = array();
	    if ( isset( $_REQUEST['register-errors'] ) ) {
	        $error_codes = explode( ',', $_REQUEST['register-errors'] );
	     
	        foreach ( $error_codes as $error_code ) {
	            $attributes['errors'] []= $this->get_error_message( $error_code );
	        }
	    }	


	        return $this->get_template_html( 'register_form', $attributes );
	    }
	}

	/**
	 * Redirects the user to the custom registration page instead
	 * of wp-login.php?action=register.
	 */
	/**
	 * Redirects the user to the custom registration page instead
	 * of wp-login.php?action=register.
	 */
	public function redirect_to_custom_register() {
			session_start();
			// Fetch the locale parameter from the URL
			$locale = isset($_GET['locale']) ? $_GET['locale'] : get_locale();
			if ('GET' == $_SERVER['REQUEST_METHOD']) {
					if (is_user_logged_in()) {
							$this->redirect_logged_in_user();
					} else {
							$redirect_url = '';
							if ($locale == 'fr_FR') {
									$redirect_url = home_url('/fr/member-register');
							} else {
									$redirect_url = home_url('/member-register');
							}
							wp_redirect($redirect_url);
							exit;
					}
			}
	}

	/**
	 * Validates and then completes the new user signup process if all went well.
	 *
	 * @param string $email         The new user's email address
	 * @param string $first_name    The new user's first name
	 * @param string $last_name     The new user's last name
	 *
	 * @return int|WP_Error         The id of the user that was created, or error if failed.
	 */
	private function register_user( $email, $first_name, $last_name, $phone, $locale ) {
	    $errors = new WP_Error();
	 
	    // Email address is used as both username and email. It is also the only
	    // parameter we need to validate
	    if ( ! is_email( $email ) ) {
	        $errors->add( 'email', $this->get_error_message( 'email' ) );
	        return $errors;
	    }
	 
	    if ( username_exists( $email ) || email_exists( $email ) ) {
	        $errors->add( 'email_exists', $this->get_error_message( 'email_exists') );
	        return $errors;
	    }
	 
	    // Generate the password so that the subscriber will have to check email...
	    $password = wp_generate_password( 12, false );
	 
	    $user_data = array(
	        'user_login'    => $email,
	        'user_email'    => $email,
	        'user_pass'     => $password,
	        'first_name'    => $first_name,
	        'last_name'     => $last_name,
	        'nickname'      => $first_name,
					'phone'					=> $phone,
					'locale'				=> $locale,
	    );
	 
	    $user_id = wp_insert_user( $user_data );
	    wp_new_user_notification( $user_id, $password );
	 
	    return $user_id;
	}


	/**
	 * Handles the registration of a new user.
	 *
	 * Used through the action hook "login_form_register" activated on wp-login.php
	 * when accessed through the registration action.
	 */
	public function do_register_user() {
	    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
	        $redirect_url = site_url( 'member-register' );
					$locale = isset($_GET['locale']) ? $_GET['locale'] : get_locale();
	 
	        if ( ! get_option( 'users_can_register' ) ) {
	            // Registration closed, display error
	            $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
	        } else {
	            $email = $_POST['email'];
	            $first_name = sanitize_text_field( $_POST['first_name'] );
	            $last_name = sanitize_text_field( $_POST['last_name'] );
							$phone = sanitize_text_field( $_POST['phone'] );

	            // recapcha
		    	if ( isset( $_REQUEST['g-recaptcha-response'] ) ) {
		    		$response 	= $_REQUEST['g-recaptcha-response'];
		    		$secret 	= OVAEM_Settings::captcha_serectkey();
		    		$check_recapcha = $this->ovalg_recapcha_verify( $response, $secret );
		    		if ( is_wp_error( $check_recapcha ) ) {
		    			$error_codes 		= implode( ',', $check_recapcha->get_error_codes() );
		    			$redirect_url 		= add_query_arg( 'register-errors', $error_codes, $redirect_url );

		    			wp_redirect( $redirect_url );
		            	exit;
		    		}
		    	}
	 
	            $result = $this->register_user( $email, $first_name, $last_name, $phone, $locale );
	 
	            if ( is_wp_error( $result ) ) {
	                // Parse errors into a string and append as parameter to redirect
	                $errors = join( ',', $result->get_error_codes() );
	                $redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );
	            } else {
	                // Success, redirect to login page.
	                $member_account = new WP_Query( 'pagename=member-login' );
     				if ( $member_account->have_posts() && get_option('permalink_structure' ) ) {
										if ($locale === 'fr_FR') {
											$redirect_url = site_url( '/fr/member-login' );
										} else {
											$redirect_url = site_url( 'member-login' );
										}
	                	$redirect_url = add_query_arg( 'registered', $email, $redirect_url );	
	                }else{
	                	$redirect_url = site_url( '' );
	                }
	                
	            }
	        }
	 
	        wp_redirect( $redirect_url );
	        exit;
	    }
	}

	/**
	 * Account Info
	 */
	public function account_info( $attributes = [], $content = null ) {
		if ( ! empty( $attributes ) || ! is_array( $attributes ) ) $attributes = [];

	    if ( ! is_user_logged_in() ) {
	    	// Pass the redirect parameter to the WordPress login functionality: by default,
		    // don't specify a redirect, but if a valid redirect URL has been passed as
		    // request parameter, use it.
		    $attributes['redirect'] = '';

		    if ( isset( $_REQUEST['redirect_to'] ) ) {
		        $attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
		    }
	        
	        return $this->get_template_html( 'login_form', $attributes);
	    }
	     
	    // Render the login form using an external template
	    return $this->get_template_html( 'account_info', $attributes );
	}
}
 
// Initialize the plugin
add_action('init', 'em4u_login');
function em4u_login(){
	$personalize_login_pages_plugin = new Ova_Login_Plugin();
}

// Create the custom pages at plugin activation
register_activation_hook( __FILE__, array( 'Ova_Login_Plugin', 'plugin_activated' ) );
