<?php
/**
 * Created by PhpStorm.
 * User: Madila
 * Date: 18/04/2019
 * Time: 13:24
 */

class GateKeeperRegistration {

    var $email = null;
    var $first_name = null;
    var $last_name = null;
    var $password = null;
    var $confirm_password = null;

    public function __construct($email, $first_name, $last_name, $password = null, $confirm_password = null, $user_meta = array())
    {
        if(!empty(trim($password))) {
            $this->password = sanitize_text_field($password);
            $this->confirm_password = sanitize_text_field($confirm_password);
        } else {
            $this->password = wp_generate_password(12, false);
            $this->confirm_password = $this->password;
        }

        $this->email = sanitize_text_field($email);
        $this->first_name = sanitize_text_field($first_name);
        $this->last_name = sanitize_text_field($last_name);
    }

    public function new_user() {
        $errors = new WP_Error();

        if($this->password !== $this->confirm_password) {
            $errors->add('password', GateKeeper::get_error_message('password_reset_mismatch'));
            return $errors;
        }

        // Email address is used as both username and email. It is also the only
        // parameter we need to validate
        if (!is_email($this->email)) {
            $errors->add('email', GateKeeper::get_error_message('email'));
            return $errors;
        }

        if (username_exists($this->email) || email_exists($this->email)) {
            $errors->add('email_exists', GateKeeper::get_error_message('email_exists'));
            return $errors;
        }

        $user_data = array(
            'user_login' => $this->email,
            'user_email' => $this->email,
            'user_pass' => $this->password,
            'first_name' =>$this->first_name,
            'last_name' => $this->last_name,
            'nickname' => $this->first_name,
        );

        $user_id = wp_insert_user($user_data);
        wp_new_user_notification($user_id, null, 'user');
        return $user_id;
    }

}
