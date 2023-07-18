<?php

class AuthService
{
    public function login($email, $password)
    {
        $credentials = array(
            'user_login'    => $email,
            'user_password' => $password,
            'remember'      => true, // Defina como true se quiser lembrar do usuário em sessões futuras
        );

        $user = wp_signon($credentials, false);

        if (!is_wp_error($user)) {
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);
            exit;
        }
    }
}

