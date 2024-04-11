

<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
    <?php foreach ( $attributes['errors'] as $error ) : ?>
        <p>
            <?php echo $error; ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>


<div id="register-form" class="widecolumn ova_register_user">

    <h3 class="title"><?php _e( 'Register User', 'ova-login' ); ?></h3>
 
    <form id="signupform" action="<?php echo wp_registration_url(); ?>" method="post">
        <p class="form-row">
            <input placeholder="<?php _e( 'Email *', 'ova-login' ); ?>" type="text" name="email" id="email">
        </p>
 
        <p class="form-row">
            <input placeholder="<?php _e( 'First name', 'ova-login' ); ?>" type="text" name="first_name" id="first-name">
        </p>
 
        <p class="form-row">
            <input placeholder="<?php _e( 'Last name', 'ova-login' ); ?>" type="text" name="last_name" id="last-name">
        </p>

        <p class="form-row">
            <input placeholder="<?php _e( 'Phone', 'ova-login' ); ?>" type="text" name="phone" id="phone">
        </p>
 
        <p class="form-row">
            <?php _e( 'Note: Your password will be generated automatically and sent to your email address.', 'ova-login' ); ?>
        </p>

        <?php echo apply_filters('em4u_register_recapcha', '' ); ?>
 
        <p class="signup-submit">
            <input type="submit" name="submit" class="ova-btn ova-btn-main-color"
                   value="<?php _e( 'Register', 'ova-login' ); ?>"/>
        </p>
    </form>
</div>