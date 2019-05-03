<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 17/04/2019
 * Time: 13:55
 */

?>

<div class="card-container">
    <div class="card">
        <h2 class="card-title">My Account</h2>
        <small class="alert">You are already logged in.</small>
        <div class="btn-group"><a href="<?php echo wp_logout_url(); ?>" class="btn btn-primary btn-outline"><span>Sign Out</span></a>
            <a href="<?php echo get_permalink(2); ?>" class="btn btn-primary"><span>Add dares</span></a>
        </div>
    </div>
</div>