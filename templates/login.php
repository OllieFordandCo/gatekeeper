<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 16/04/2019
 * Time: 14:06
 */

?>
<div class="card-container">
    <form method="post" class="card card-xs" action="<?php echo wp_login_url(); ?>">
        <header>
            <h1 class="card-title">Sign In</h1>
        </header>

        <!-- Show errors if there are any -->
        <?php if ( array_key_exists('errors', $attributes) &&  count( $attributes['errors'] ) > 0 ) : ?>
            <div class="alert color-danger">
                <?php foreach ( $attributes['errors'] as $error ) : ?>
                        <span class="alert-message"><?php echo $error; ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ( array_key_exists('registered', $attributes) && $attributes['registered'] ) : ?>
            <div class="alert color-success">
                <?php
                printf(
                    __( 'You have successfully registered to <strong>%s</strong>. Use your login information to log in.', 'gatekeeper' ),
                    get_bloginfo( 'name' )
                );
                ?>
            </div>
        <?php endif; ?>
        <?php if ( array_key_exists('lost_password_sent', $attributes) &&  $attributes['lost_password_sent']) : ?>
            <div class="alert color-info">
                <?php _e( 'Check your email for your password reset link. <br>Please check your spam folder and if you have not received the email please contact us.', 'gatekeeper' ); ?>
            </>
        <?php endif; ?>
        <!-- Show logged out message if user just logged out -->
        <?php if (  array_key_exists('logged_out', $attributes) && $attributes['logged_out']) : ?>
            <div class="alert color-info">
                <?php _e( 'You have signed out. Would you like to sign in again?', 'gatekeeper' ); ?>
            </div>
        <?php endif; ?>

        <div class="form-field">
            <label for="user_login" class="sr-only"><small><?php _e( 'Email', 'gatekeeper' ); ?></small></label>
            <input type="text" name="log" id="user_login" placeholder="Email">
        </div>
        <div class="form-field">
            <label for="user_pass" class="sr-only"><small><?php _e( 'Password', 'gatekeeper' ); ?></small></label>
            <input type="password" name="pwd" id="user_pass" placeholder="Password">
        </div>
        <div class="form-field btn-group">
            <button type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-main"><span><?php _e( 'Sign In', 'gatekeeper' ); ?></span></button>
            <a href="<?php echo GateKeeper::get_url('register'); ?>" class="btn btn-outline btn-primary btn-disabled"><span><?php _e( 'Register', 'gatekeeper' ); ?></span></a>
        </div>
        <?php do_action('gatekeeper_render_social_login_buttons', 'Sign In with'); ?>
        <hr>
        <div><a href="<?php echo GateKeeper::get_url('forgot-password'); ?>" class="btn btn-outline btn-xs btn-link btn-block"><span><?php _e( 'Forgot your Password?', 'gatekeeper' ); ?></span></a></div>
    </form>
</div>

