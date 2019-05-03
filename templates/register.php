<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 16/04/2019
 * Time: 14:06
 */

?>
<div class="card-container">
    <form method="post" class="card card-xs" action="<?php echo wp_registration_url(); ?>">
        <header>
            <h1 class="card-title">Register</h1>
        </header>
        <aside>
            <!-- Show errors if there are any -->
            <?php if ( array_key_exists('errors', $attributes) &&  count( $attributes['errors'] ) > 0 ) : ?>
                <?php foreach ( $attributes['errors'] as $error ) : ?>
                    <p class="alert color-danger">
                        <?php echo $error; ?>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ( array_key_exists('registered', $attributes) ) : ?>
                <p class="alert color-success">
                    <?php
                    printf(
                        __( 'You have successfully registered to <strong>%s</strong>. Use your login information to log in.', 'gatekeeper' ),
                        get_bloginfo( 'name' )
                    );
                    ?>
                </p>
            <?php endif; ?>
        </aside>
        <div class="form-field">
            <label for="email" class="sr-only"><small><?php _e( 'Email', 'gatekeeper' ); ?></small></label>
            <input type="text" name="email" id="email" placeholder="Email">
        </div>
        <div class="form-field">
            <label for="first_name" class="sr-only"><small><?php _e( 'First name', 'gatekeeper' ); ?></small></label>
            <input type="text" name="first_name" id="first-name" placeholder="First Name">
        </div>

        <div class="form-field">
            <label for="last_name" class="sr-only"><small><?php _e( 'Last name', 'gatekeeper' ); ?></small></label>
            <input type="text" name="last_name" id="last-name" placeholder="Last Name">
        </div>
        <div class="form-field">
            <label for="user_pass" class="sr-only"><small><?php _e( 'Password', 'gatekeeper' ); ?></small></label>
            <input type="password" name="pwd" id="user_pass" placeholder="Password">
        </div>
        <div class="form-field">
            <label for="user_confirm_pass" class="sr-only"><small><?php _e( 'Confirm Password', 'gatekeeper' ); ?></small></label>
            <input type="password" name="user_confirm_pass" id="user_confirm_pass" placeholder="Confirm Password">
        </div>
        <div class="form-field btn-group">
            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-main" value="<?php _e( 'Register', 'gatekeeper' ); ?>">
            <a href="<?php echo GateKeeper::get_url('login'); ?>" class="btn btn-outline btn-primary"><span><?php _e( 'Sign In', 'gatekeeper' ); ?></span></a>
        </div>
        <?php do_action('gatekeeper_render_social_login_buttons', 'Register'); ?>
    </form>
</div>

