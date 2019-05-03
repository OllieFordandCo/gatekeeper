<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 17/04/2019
 * Time: 14:53
 */

include_once __DIR__ .'/../templates/parts/header.php';
?>
    <div class="card-container">
        <div class="card">
            <small class="alert">{{ message }}</small>
            <p><?php if(!is_user_logged_in()) : ?>
                    <a href="<?php echo GateKeeper::get_url('login'); ?>" class="btn btn-primary"><span>Sign In</span></a>
            <?php else : ?>
                    <a href="<?php echo wp_logout_url(); ?>" class="btn btn-primary btn-outline"><span>Sign Out</span></a>
                    <?php if(current_user_can('manage_options')) : ?>
                        <a href="<?php echo admin_url(); ?>" class="btn btn-primary"><span>Dashboard</span></a>
                    <?php endif; ?>
            <?php endif; ?>
            </p>
        </div>
    </div>

<?php
include_once __DIR__ .'/../templates/parts/footer.php';