<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 18/04/2019
 * Time: 12:32
 */

?>
<div class="card-container">
    <div class="card">
        <!-- Show errors if there are any -->
        <?php if ( array_key_exists('errors', $attributes) &&  count( $attributes['errors'] ) > 0 ) : ?>
            <p class="alert text-danger">
                <?php foreach ( $attributes['errors'] as $error ) : ?>
                    <span class="alert-message"><?php echo $error; ?></span>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>
        <small>If you are seeing this page, the provider failed to authorised you...</small>
        <a href="<?php echo GateKeeper::get_url('login'); ?>" class="btn btn-primary">Back to Login</a>
    </div>
</div>