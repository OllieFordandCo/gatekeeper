<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 16/04/2019
 * Time: 14:06
 */
if(!array_key_exists('key', $attributes)) { ?>
    <div class="card-container">
        <div class="card card-xs">
            <small class="alert">You might have accessed this page by mistake. You need to access this page through our reset your password email.</small>
            <p><a href="<?php echo GateKeeper::get_url('forgot-password'); ?>" class="btn btn-primary">Get Reset Link</a></p>
            <p><a href="<?php echo home_url(); ?>" class="btn btn-primary btn-outline"><span>Back Home</span></a></p>
        </div>
    </div>
<?php } else {
?>
<div class="card-container">
    <form name="resetpassform" id="resetpassform" class="card card-xs" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
        <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $attributes['login'] ); ?>" autocomplete="off" />
        <input type="hidden" name="rp_key" value="<?php echo esc_attr( $attributes['key'] ); ?>" />
        <header>
            <h1 class="card-title">Reset Your Password</h1>
        </header>
        <aside>
            <!-- Show errors if there are any -->
            <?php if ( array_key_exists('errors', $attributes) &&  count( $attributes['errors'] ) > 0 ) : ?>
                <p class="alert color-danger">
                    <?php foreach ( $attributes['errors'] as $error ) : ?>
                        <span class="alert-message"><?php echo $error; ?></span>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>
        </aside>
        <div class="form-field">
            <label for="pass1" class="sr-only"><small><?php _e( 'Password', 'gatekeeper' ); ?></small></label>
            <input type="password" name="pass1" id="pass1" size="20" value="" autocomplete="off" placeholder="Password">
        </div>
        <div class="form-field">
            <label for="pass2" class="sr-only"><small><?php _e( 'Confirm Password', 'gatekeeper' ); ?></small></label>
            <input type="password" name="pass2" id="pass2" size="20" value="" placeholder="Confirm Password" autocomplete="off">
        </div>
        <div class="form-field btn-group">
            <button type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-main"><?php _e( 'Reset Password', 'gatekeeper' ); ?></button>
            <a href="<?php echo GateKeeper::get_url('login'); ?>" class="btn btn-outline btn-primary"><span><?php _e( 'Back', 'gatekeeper' ); ?></span></a>
        </div>
    </form>
</div>
<?php } ?>