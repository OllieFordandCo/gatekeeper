<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 17/04/2019
 * Time: 14:50
 */

class GateKeeperMaintenance
{

    public function __construct()
    {
        add_action('template_redirect', array($this, 'maintenance_redirect'));
        add_filter('template_include', array($this, 'template_redirect'), 99);
    }

    function user_can_access()
    {
        $access = false;
        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            if (in_array('subscriber', (array)$user->roles) || current_user_can('manage_options')) {
                $access = true;
            }
        }
        return $access;
    }

    function maintenance_redirect() {
            define('WP_MAINTENANCE', true);
            if(is_front_page() || is_page(2) || (defined('DOING_AJAX') && DOING_AJAX) || $this->user_can_access()) {
                return NULL;
            }
            $front_page = get_option('page_on_front');
            $redirect_url = $front_page !== "0" ? get_permalink($front_page) : home_url('/');
            wp_redirect($redirect_url);
            exit;
    }

    function template_redirect($template) {
        if(!$this->user_can_access()) {
            return plugin_dir_path( __FILE__ )."/../routes/holding.php";
        }
        return $template;
    }
}