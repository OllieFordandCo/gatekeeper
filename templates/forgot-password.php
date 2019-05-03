<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 16/04/2019
 * Time: 14:06
 */

?>
<div class="card-container">
    <form method="post" class="card card-xs" action="<?php echo wp_lostpassword_url(); ?>">
        <header>
            <h1 class="card-title">Reset Password</h1>
        </header>
        <aside>
            <!-- Show errors if there are any -->
            <?php if ( array_key_exists('errors', $attributes) &&  count( $attributes['errors'] ) > 0 ) : ?>
                <div class="alert color-danger">
                    <?php foreach ( $attributes['errors'] as $error ) : ?>
                        <span class="alert-message"><?php echo $error; ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="card-block">
                <p>
                    <?php
                    _e(
                        "Enter your email address and we'll send you a link you can use to pick a new password.",
                        'gatekeeper'
                    );
                    ?>
                </p>
            </div>
        </aside>
        <div class="form-field">
            <label for="user_login" class="sr-only"><small><?php _e( 'Email', 'gatekeeper' ); ?></small></label>
            <input type="text" name="user_login" id="user_login" placeholder="Email">
        </div>
        <div class="form-field btn-group">
            <button type="submit" name="wp-submit" id="wp-submit" class="btn btn-main btn-primary"><span><?php _e( 'Get Link', 'gatekeeper' ); ?></span></button>
            <a href="<?php echo GateKeeper::get_url('login'); ?>" class="btn btn-outline btn-primary"><span><?php _e( 'Back', 'gatekeeper' ); ?></span></a>
        </div>
    </form>
</div>