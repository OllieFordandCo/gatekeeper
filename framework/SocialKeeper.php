<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 18/04/2019
 * Time: 11:56
 */


class SocialKeeper {

    var $facebook = false;
    var $facebook_settings = [
        'app_id' => '632855303452563', // Replace {app-id} with your app id
        'app_secret' => '9b633f3d97fa6bd30a15dd45f8aba01b',
        'default_graph_version' => 'v3.2',
    ];

    public function _constructor() {
        add_action('init', array($this, 'socialkeeper_actions'));
    }

    private function init_facebook() {
        $this->facebook = new Facebook\Facebook($this->facebook_settings);
    }

    private function get_facebook() {
        if(!$this->facebook) $this->init_facebook();
        return $this->facebook;
    }

    public function get_facebook_login_link() {
        $loginUrl = false;
        $fb = $this->get_facebook();
        if ($fb) {
            $helper = $fb->getRedirectLoginHelper();

            $permissions = ['email']; // Optional permissions
            $loginUrl = $helper->getLoginUrl(GateKeeper::get_url('authorise'), $permissions);
        }
        return htmlspecialchars($loginUrl);
    }

    public function render_facebook_button($label = 'Log in ') {
        echo '<a class="btn btn-block btn-blue btn-xs" href="' . $this->get_facebook_login_link() . '"><span><i class="fab fa-facebook-f"></i> '.$label.' with Facebook</span></a>';
    }

    public function authorise_facebook() {
        $redirect_url = GateKeeper::get_url('login');
        $response = null;

        $fb = $this->get_facebook();
        $helper = $fb->getRedirectLoginHelper();

        $attributes = array();

        if(isset($_GET['state'])) {
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            $attributes['errors'][] = 'Graph returned an error: ' . $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            $attributes['errors'][] = 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        if(!isset($accessToken)) {
            if($helper->getError()) {
                $attributes['errors'][] = "Error: " . $helper->getError() . "\n";
                $attributes['errors'][] = "Error Code: " . $helper->getErrorCode() . "\n";
                $attributes['errors'][] = "Error Reason: " . $helper->getErrorReason() . "\n";
                $attributes['errors'][] = "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                $attributes['errors'][] = 'Unknown error. Try again later.';
            }
        } else {

            $attributes['fb'] = array();

            // Logged in
            $attributes['fb']['token'] = $accessToken->getValue();

            // The OAuth 2.0 client handler helps us manage access tokens
            $oAuth2Client = $fb->getOAuth2Client();

            // Get the access token metadata from /debug_token
            $tokenMetadata = $oAuth2Client->debugToken($accessToken);
            $attributes['fb']['tokenMetadata'] = $tokenMetadata;

            // Validation (these will throw FacebookSDKException's when they fail)
            $tokenMetadata->validateAppId($this->facebook_settings['app_id']); // Replace {app-id} with your app id
            // If you know the user ID this access token belongs to, you can validate it here
            //$tokenMetadata->validateUserId('123');
            $tokenMetadata->validateExpiration();

            if (!$accessToken->isLongLived()) {
                // Exchanges a short-lived access token for a long-lived one
                try {
                    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    $attributes['errors'][] = "Error getting long-lived access token: " . $e->getMessage() . "\n\n";
                }
            }

            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get(
                    '/me?fields=id,email,first_name,last_name',
                    $accessToken
                );
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                $attributes['errors'][] = 'Graph returned an error: ' . $e->getMessage();
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                $attributes['errors'][] = 'Facebook SDK returned an error: ' . $e->getMessage();
            }
            $graphNode = $response->getGraphNode();

            if(!is_user_logged_in()) {
                if(!username_exists($graphNode->getField('email'))) {
                    $user_id = GateKeeper::register_user([
                        'email' => $graphNode->getField('email'),
                        'first_name' => $graphNode->getField('first_name'),
                        'last_name' => $graphNode->getField('last_name')
                    ]);
                    $redirect_url = add_query_arg('registered', 'true', $redirect_url);
                } else {
                    $user = get_user_by('email', $graphNode->getField('email'));
                    $user_id = $user->ID;
                }

                if(!is_wp_error($user_id)) {
                    //login
                    wp_set_current_user($user_id, $graphNode->getField('email'));
                    wp_set_auth_cookie($user_id);
                    do_action('wp_login', $graphNode->getField('email'));
                }
                wp_redirect($redirect_url);
            }

            $_SESSION['fb_access_token'] = (string)$accessToken;
        }
        return $attributes;
    }

}