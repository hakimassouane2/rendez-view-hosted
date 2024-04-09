<div class="ova-login-form-container">

    <?php if($attributes){ ?>
        
        <?php if ( isset( $attributes['registered'] ) && $attributes['registered'] ) : ?>
            <p class="login-info">
                <?php
                    printf(
                        __( 'You have successfully registered to <strong>%s</strong>. We have emailed your password to the email address you entered.', 'ova-login' ),
                        get_bloginfo( 'name' )
                    );
                ?>
            </p>
        <?php endif; ?>


        <!-- Show logged out message if user just logged out -->
        <?php if ( isset($attributes['logged_out'] ) && $attributes['logged_out'] ) : ?>
            <p class="login-info">
                <?php _e( 'You have signed out. Would you like to sign in again?', 'ova-login' ); ?>
            </p>
        <?php endif; ?>

        <!-- Show errors if there are any -->
        <?php if ( isset($attributes['errors']) && count( $attributes['errors'] ) > 0 ) : ?>
            <?php foreach ( $attributes['errors'] as $error ) : ?>
                <p class="login-error">
                    <?php echo $error; ?>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php } ?>
    
    <h3 class="title"><?php _e( 'Sign In', 'ova-login' ); ?></h3>
     
    <div class="login-form-container">

    <?php
        wp_login_form(
            array(
                'remember'       => true,
                'label_username' => __( 'Email', 'ova-login' ),
                'label_log_in' => __( 'Sign In', 'ova-login' ),
                'label_password' => __( 'Password', 'ova-login' ),
                'label_remember' => __( 'Remember Me', 'ova-login' ),
                'label_log_in'   => __( 'Log In','ova-login' ),
                'redirect' => $attributes['redirect'],
            )
        );
    ?>

    </div>

   <a class="forgot-password" href="<?php echo wp_lostpassword_url( ); ?>">
        <?php  _e( 'Forgot your password?', 'ova-login' ); ?>
    </a> 

    <br />
    
    <a class="register-form" href="<?php echo wp_registration_url(); ?>">
         <?php  _e( 'No Account ? Register', 'ova-login' ); ?>
     </a> 
</div>