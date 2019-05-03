<?php
/**
 * Plugin Name:     GateKeeper
 * Plugin URI:      https://www.ollieford.co.uk
 * Description:     A bespoke login workflow for Wordpress CMS
 * Author:          Ruben Madila
 * Author URI:      https://www.ollieford.co.uk
 * Text Domain:     gatekeeper
 * Domain Path:     /languages
 * Version:         2.1.0
 *
 * @package         Gatekeeper
 */

require_once 'vendor/autoload.php';
require_once 'framework/Maintenance.php';
require_once 'framework/Registration.php';
require_once 'framework/SocialKeeper.php';

// Your code starts here.
class GateKeeper
{

    var $default_endpoints = array();
    var $endpoints = array();
    var $settings = array();
    var $social_keeper = array();
    var $assets_version = '0.1';

    /**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
    public function __construct()
    {
        $this->set_settings();

        $this->maintenance = new GateKeeperMaintenance();
        $this->social_keeper = new SocialKeeper();
        $this->endpoints = $this->get_endpoints();
        $this->add_actions();
        $this->add_filters();
    }

    public function set_settings() {
        // Set default endpoints
        $default_settings = array(
            'enable_social' => true,
        );
        $this->settings = $default_settings;
    }

    public function get_setting($name) {
        return (array_key_exists($name, $this->settings)) ? $this->settings[$name] : false;
    }

    function add_filters() {
        add_filter('authenticate', array($this, 'maybe_redirect_at_authenticate'), 101, 3);
        add_filter('login_redirect', array($this, 'redirect_after_login'), 10, 3);
        add_filter('template_include', array($this, 'gatekeeper_include_template'), 1000, 1);
    }


    function add_actions() {
        add_action('gatekeeper_render_social_login_buttons', array($this->social_keeper, 'render_facebook_button'), 999, 1);
        add_action('gatekeeper_render_login_route', array($this, 'render_login_route'));
        add_action('gatekeeper_render_authorise_route', array($this, 'redirect_after_social_sign_in'));
        add_action('gatekeeper_render_register_route', array($this, 'render_register_route'));
        add_action('query_vars', array($this, 'add_gatekeeper_query_var'));
        add_action('show_admin_bar', array($this, 'manage_admin_bar'));
        add_action('init', array($this, 'add_gatekeeper_rewrites'));
        //add_action('wp_enqueue_scripts', array($this, 'gatekeeper_enqueue_fonts'), 1 );
        add_action('wp_enqueue_scripts', array($this, 'gatekeeper_enqueue_assets'), 999 );
        add_action('wp_logout', array($this, 'redirect_after_logout'));
        add_action('login_form_login', array($this, 'redirect_to_login'));
        add_action('login_form_register', array($this, 'redirect_to_register'));
        add_action('login_form_register', array($this, 'do_register_user'));
        add_action('login_form_rp', array($this, 'redirect_to_custom_password_reset'));
        add_action('login_form_resetpass', array($this, 'redirect_to_custom_password_reset'));
        add_action('login_form_lostpassword', array($this, 'redirect_to_custom_lostpassword'));
        add_action('login_form_lostpassword', array($this, 'do_password_lost'));
    }

    static function activation() {
        // do not generate any output here
        flush_rewrite_rules();
    }

    function manage_admin_bar() {
        if ( ! current_user_can( 'manage_options' ) )
            add_filter('show_admin_bar', '__return_false');
    }

    function gatekeeper_enqueue_fonts() {
        wp_enqueue_style('gatekeeper-fonts', plugin_dir_url(__FILE__) . 'assets/css/gatekeeper-fonts.css', array(), $this->assets_version);
    }

    function gatekeeper_enqueue_assets() {
        if(get_query_var('is_gatekeeper_page') || defined('WP_MAINTENANCE')) {
            wp_enqueue_style('gatekeeper-styles', plugin_dir_url(__FILE__) . 'assets/css/gatekeeper.css', array(), $this->assets_version);
        }
    }

    static function get_endpoints() {

        // Set default endpoints
        $default_endpoints = array(
            'my-account' => 'my-account',
            'login' => 'login',
            'register' => 'register',
            'forgot-password' => 'forgot-password',
            'reset-your-password' => 'reset-your-password',
            'authorise' => 'authorise'
        );

        // Get the path values after filters and rehydrate any missing ones to avoid errors.
        return array_merge(apply_filters('gatekeeper_get_endpoints', $default_endpoints, $default_endpoints));
    }


    /**
     * Get the path for a given endpoint to be used with the home_url function to return the full url.
     *
     * @param string $to An optional redirect_to URL for admin users
     * @throws Exception if user is trying to access a non-existing endpoint
     * @return string path to the given endpoint
     */
    static function get_endpoint($to) {
        $endpoints = GateKeeper::get_endpoints();
        // If Path doesn't exist throw exception
        if(!array_key_exists($to, $endpoints)) throw new Exception(__('Attempted to find the endpoint for a non-existing page. Check for spelling.', 'gatekeeper'));

        return user_trailingslashit($endpoints[$to]);
    }

    /**
     * Get the full qualified url for a given endpoint.
     *
     * @param string $path An optional redirect_to URL for admin users
     * @param string $query_vars additional url query vars
     * @throws Exception if user is trying a non-existing endpoint
     * @return string url of the given path if exists.
     */
    static function get_url($path, $query_vars = '') {
        return home_url(GateKeeper::get_endpoint($path).$query_vars);
    }

    /**
     * Renders the contents of the given template to a string and returns it.
     *
     * @param string $form_name The name of the template to render (without .php)
     * @param array $attributes The PHP variables for the template
     *
     * @return string               The contents of the template.
     */
    public static function get_plugin_template($template_name)
    {
        $plugin_path = plugin_dir_path( __FILE__ )."/templates/{$template_name}.php";
        if(file_exists($plugin_path)) {
            require_once plugin_dir_path(__FILE__) . "/templates/{$template_name}.php";
        }
    }

    /**
     * Renders the contents of the given template to a string and returns it.
     *
     * @param string $form_name The name of the template to render (without .php)
     * @param array $attributes The PHP variables for the template
     *
     * @return string               The contents of the template.
     */
    public static function get_template($view_name, $attributes = array())
    {

        ob_start();

        GateKeeper::get_plugin_template('parts/header');

        do_action("gatekeeper_render_before_{$view_name}");

        require_once plugin_dir_path( __FILE__ )."templates/{$view_name}.php";

        do_action("gatekeeper_render_after_{$view_name}");

        GateKeeper::get_plugin_template('parts/footer');

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
     * Renders the contents of the given template to a string and returns it.
     *
     * @param string $form_name The name of the template to render (without .php)
     * @param array $attributes The PHP variables for the template
     *
     * @return string               The contents of the template.
     */
    public static function get_template_part($view_name)
    {

        ob_start();

        require_once plugin_dir_path( __FILE__ )."templates/{$view_name}.php";

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }


    public static function render_template($view_name, $attributes = array())
    {
        echo GateKeeper::get_template($view_name, $attributes);
    }

    public function gatekeeper_include_template($template) {
        $page_type = get_query_var('is_gatekeeper_page');
        if($page_type) {
            $new_template = plugin_dir_path( __FILE__ )."routes/{$page_type}.php";
            if(file_exists($new_template)) return $new_template;
        }
        return $template;
    }

    public function add_gatekeeper_rewrites() {
        flush_rewrite_rules();
        foreach($this->get_endpoints() as $key => $path) {
            add_rewrite_rule("^{$path}?$","index.php?is_gatekeeper_page={$key}",'top');
        }
        //Customize this query string - keep is_gatekeeper_page=1 intact
    }

    function add_gatekeeper_query_var($vars) {
        array_push($vars, 'is_gatekeeper_page');
        return $vars;
    }



    /*
     * Login
     *
     * redirect_after_login
     * redirect_to
     * render
     *
     */

    /**
     * Returns the URL to which the user should be redirected after the (successful) login.
     *
     * @param string $redirect_to The redirect destination URL.
     * @param string $requested_redirect_to The requested redirect destination URL passed as a parameter.
     * @param WP_User|WP_Error $user WP_User object if login was successful, WP_Error object otherwise.
     * @throws Exception if my-account route doesn't exist.
     *
     * @return string Redirect URL
     */
    public function redirect_after_login($redirect_to, $requested_redirect_to, $user)
    {
        if(is_wp_error($user) || !isset($user->ID)) return $this->get_url('login', '?no_user=true');

        $redirect = apply_filters('gatekeeper_redirect_after-login', 'login');

        if(strpos($redirect,"http")) {
            return wp_validate_redirect($redirect);
        } else {
            return wp_validate_redirect($this->get_url($redirect), home_url());
        }
    }


    /**
     * Redirect the user to the custom login page instead of wp-login.php.
     */
    function redirect_to_login()
    {
        global $pagenow;
        if($pagenow == 'wp-login.php') {


            if ( isset( $_POST['wp-submit'] ) ||  // is Login
                ( isset($_GET['action']) && $_GET['action']=='logout') || // is LOGOUT
                ( isset($_GET['checkemail']) && $_GET['checkemail']=='confirm') || // in case of LOST PASSWORD
                ( isset($_GET['checkemail']) && $_GET['checkemail']=='registered') ) return;

            // The rest are redirected to the login page
            $login_url = $this->get_url('login');

            wp_redirect($login_url);
            exit;
        }
    }

    /**
     * A shortcode for rendering the login form.
     *
     *
     * @return string  The shortcode output
     */
    public function render_login_route()
    {
        $attributes = array();

        if(is_user_logged_in()) {
            $this->render_template('logged-in');
            return;
        }

        // Pass the redirect parameter to the WordPress login functionality: by default,
        // don't specify a redirect, but if a valid redirect URL has been passed as
        // request parameter, use it.
        $attributes['redirect'] = '';

        if(isset($_REQUEST['redirect_to'])) {
            $attributes['redirect'] = wp_validate_redirect($_REQUEST['redirect_to'], $attributes['redirect']);
        }

        // Error messages
        $errors = array();
        if (isset($_REQUEST['login'])) {
            $error_codes = explode(',', $_REQUEST['login']);
            foreach ($error_codes as $code) {
                $attributes['errors'][] = $this->get_error_message($code);
            }
        }

        if(isset($_REQUEST['register-errors'])) {
            $error_codes = explode(',', $_REQUEST['register-errors']);
            foreach ($error_codes as $error_code) {
                $attributes['errors'][] = $this->get_error_message($error_code);
            }
        }

        // Check if user just logged out
        $attributes['logged_out'] = isset($_REQUEST['logged_out']) && $_REQUEST['logged_out'] == true;

        // Check if user just logged out
        $attributes['registered'] = isset($_REQUEST['registered']) && $_REQUEST['registered'] == true;

        // Check if the user just requested a new password
        $attributes['lost_password_sent'] = isset($_REQUEST['checkemail']) && $_REQUEST['checkemail'] == 'confirm';

        $this->render_template('login', $attributes);
    }


    /*
     * Logout
     */

    /**
     * Redirect to custom login page after the user has been logged out.
     */
    public function redirect_after_logout()
    {
        $redirect_url = $this->get_url('login', '?logged_out=true');
        wp_safe_redirect($redirect_url);
        exit;
    }

    public function redirect_if_registration_closed()
    {
        if (!get_option('users_can_register')) {
            // Registration closed, display error
            $redirect_url = add_query_arg('register-errors', 'closed', $this->get_url('login'));
            wp_safe_redirect($redirect_url);
            exit;
        }
    }

    /*
     * Register
     */

    public function render_register_route() {

        $attributes = array();

        if(is_user_logged_in()) {
            $this->render_template('logged-in');
            return;
        }

        if (!get_option('users_can_register')) {
            $this->redirect_if_registration_closed();
        }

        // Parse shortcode attributes
        $default_attributes = array('show_title' => false);
        $attributes = shortcode_atts($default_attributes, $attributes);

        // Retrieve possible errors from request parameters
        $attributes['errors'] = array();
        if (isset($_REQUEST['register-errors'])) {
            $error_codes = explode(',', $_REQUEST['register-errors']);

            foreach ($error_codes as $error_code) {
                $attributes['errors'] [] = $this->get_error_message($error_code);
            }
        }
        $this->render_template('register', $attributes);

    }

    /**
     * Validates and then completes the new user signup process if all went well.
     *
     * @param array $postdata The $_POST data
     *
     * @return int|WP_Error         The id of the user that was created, or error if failed.
     */
    static public function register_user($postdata = array())
    {
        $registration = new GateKeeperRegistration(
            $postdata['email'],
            $postdata['first_name'],
            $postdata['last_name'],
            isset($postdata['pwd']) ? $postdata['pwd'] : '',
            isset($postdata['user_confirm_pass']) ? $postdata['user_confirm_pass'] : ''
        );
        return $registration->new_user();
    }

    /**
     * Handles the registration of a new user.
     *
     * Used through the action hook "login_form_register" activated on wp-login.php
     * when accessed through the registration action.
     */
    public function do_register_user()
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $redirect_url = $this->get_url('register');

            if (!get_option('users_can_register')) {
                // Registration closed, display error
                $redirect_url = add_query_arg('register-errors', 'closed', $redirect_url);
            } else {

                $email = sanitize_text_field($_POST['email']);
                $result = $this->register_user($_POST);

                if (is_wp_error($result)) {
                    // Parse errors into a string and append as parameter to redirect
                    $errors = join(',', $result->get_error_codes());
                    $redirect_url = add_query_arg('register-errors', $errors, $redirect_url);
                } else {
                    // Success, redirect to login page.
                    $redirect_url = $this->get_url('login');
                    $redirect_url = add_query_arg('registered', 'true', $redirect_url);
                }
            }

            wp_redirect($redirect_url);
            exit;
        }
    }

    /*
     * Social Register
     */

    /**
     * Redirect the user to the custom login page instead of wp-login.php.
     */
    function redirect_after_social_sign_in()
    {
        $attributes = $this->social_keeper->authorise_facebook();
        $this->render_template('authorise', $attributes);
    }

    /*
     * Authentication Flow
     *
     * maybe_redirect_at_authenticate
     * redirect_logged_in_user
     *
     */

    /**
     * Redirect the user after authentication if there were any errors.
     *
     * @param Wp_User|Wp_Error $user The signed in user, or the errors that have occurred during login.
     * @param string $username The user name used to log in.
     * @param string $password The password used to log in.
     * @throws Exception if login route doesn't exist.
     *
     * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
     */
    function maybe_redirect_at_authenticate($user, $username, $password)
    {
        // Check if the earlier authenticate filter (most likely,
        // the default WordPress authentication) functions have found errors
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(is_wp_error($user)) {
                $error_codes = join(',', $user->get_error_codes());

                $login_url = $this->get_url('login');
                $login_url = add_query_arg('login', $error_codes, $login_url);

                wp_redirect($login_url);
                exit;
            }
        }

        return $user;
    }

    /**
     * Redirects the user to the correct page depending on whether they
     * are an admin or not.
     *
     * @param string $redirect_to An optional redirect_to URL for admin users
     * @throws Exception if my account endpoint doesn't exist
     */
    private function redirect_logged_in_user($redirect_to = null)
    {
        $user = wp_get_current_user();
        if(user_can($user, 'manage_options')) {
            if($redirect_to) {
                wp_safe_redirect($redirect_to);
            } else {
                wp_redirect(admin_url());
            }
        } else {
            if(strpos($redirect_to,"http")) {
                return wp_validate_redirect($redirect_to);
            } else {
                return wp_validate_redirect($this->get_url($redirect_to), home_url());
            }
        }
    }

    public function redirect_to_register()
    {
        if ('GET' == $_SERVER['REQUEST_METHOD']) {
            if (is_user_logged_in()) {

                $redirect_to = apply_filters('gatekeeper_redirect_after-login', 'login');

                $this->redirect_logged_in_user($redirect_to);
            } else {
                if (!get_option('users_can_register')) {
                    // Registration closed, display error
                    wp_redirect(add_query_arg('register-errors', 'closed', $this->get_url('register')));
                } else {
                    wp_redirect($this->get_url('register'));
                }
            }
            exit;
        }
    }

    public function redirect_to_custom_password_reset()
    {
        if ('GET' == $_SERVER['REQUEST_METHOD']) {
            // Verify key / login combo
            $user = check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);
            if (!$user || is_wp_error($user)) {
                if ($user && $user->get_error_code() === 'expired_key') {
                    wp_redirect($this->get_url('login', '?login=expiredkey'));
                } else {
                    wp_redirect($this->get_url('login', '?login=invalidkey'));
                }
                exit;
            }

            $redirect_url = $this->get_url('reset-your-password');
            $redirect_url = add_query_arg('login', esc_attr($_REQUEST['login']), $redirect_url);
            $redirect_url = add_query_arg('key', esc_attr($_REQUEST['key']), $redirect_url);

            wp_redirect($redirect_url);
            exit;
        }
    }

    /**
     * Redirects the user to the custom "Forgot your password?" page instead of
     * wp-login.php?action=lostpassword.
     */
    public function redirect_to_custom_lostpassword()
    {
        if ('GET' == $_SERVER['REQUEST_METHOD']) {
            if (is_user_logged_in()) {
                $this->redirect_logged_in_user();
                exit;
            }

            wp_redirect($this->get_url('forgot-password'));
            exit;
        }
    }

    /**
     * Initiates password reset.
     */
    public function do_password_lost()
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $errors = retrieve_password();
            if (is_wp_error($errors)) {
                // Errors found
                $redirect_url = $this->get_url('forgot-password');
                $redirect_url = add_query_arg('errors', join(',', $errors->get_error_codes()), $redirect_url);
            } else {
                // Email sent
                $redirect_url = $this->get_url('login');
                $redirect_url = add_query_arg('checkemail', 'confirm', $redirect_url);
            }

            wp_redirect($redirect_url);
            exit;
        }
    }


    /**
     * Finds and returns a matching error message for the given error code.
     *
     * @param string $error_code The error code to look up.
     *
     * @return string               An error message.
     */
    static public function get_error_message($error_code)
    {
        switch ($error_code) {
            case 'empty_username':
                return __('You do have an email address, right?', 'gatekeeper');

            case 'empty_password':
                return __('You need to enter a password to login.', 'gatekeeper');

            case 'invalid_username':
                return __("We don't have any users with that email address. Maybe you used a different one when signing up?", 'gatekeeper');
            // Registration errors
            case 'email':
                return __('The email address you entered is not valid.', 'gatekeeper');

            case 'email_exists':
                return __('An account exists with this email address.', 'gatekeeper');

            case 'closed':
                return __('Registration for the beta will open soon.', 'gatekeeper');
            case 'incorrect_password':
                $err = __(
                    "The access code entered wasn't quite right. Please use the request access code to issue a new one.",
                    'gatekeeper'
                );
                return sprintf($err, wp_lostpassword_url());
            case 'invalid_email':
            case 'invalidcombo':
                return __('There are no users registered with this email address.', 'gatekeeper');
            // Reset password
            case 'expiredkey':
            case 'invalidkey':
                return __('The password reset link you used is not valid anymore.', 'gatekeeper');

            case 'password_reset_mismatch':
                return __("The two passwords you entered don't match.", 'gatekeeper');

            case 'no_user':
                return __("Sorry, but the user ID provided is no longer logged in.", 'gatekeeper');
            case 'password_reset_empty':
                return __("Sorry, we don't accept empty passwords.", 'gatekeeper');
            default:
                break;
        }

        return __('An unknown error occurred. Please try again later.', 'gatekeeper');
    }

}

register_activation_hook( __FILE__, array( 'GateKeeper', 'activation' ) );

// Initialize the plugin
$GateKeeper = new GateKeeper();
