<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 16/04/2019
 * Time: 14:06
 */

?>
<div class="card-container">
    <div class="card">
        <h2 class="card-title">My Account</h2>
        <small class="alert">Welcome back, <?php $current_user = wp_get_current_user(); echo $current_user->display_name; ?>.<br> You are already logged in.</small>
        <p><a href="<?php echo wp_logout_url(); ?>" class="btn btn-primary btn-outline"><span>Sign Out</span></a>
            <a href="<?php echo home_url(); ?>" class="btn btn-primary">Back Home</a></p>
    </div>
</div>
