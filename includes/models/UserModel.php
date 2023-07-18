<?php
class UserModel
{
    public function createUser($name, $email, $password)
    {
        $userdata = array(
            'user_login' => $name,
            'user_pass' => $password,
            'user_email' => $email,
            'display_name' => $name,
            'nickname' => $name,
        );

        $user_id = wp_insert_user($userdata);

        return $user_id;
    }
    public function updateMeta($meta_fields, $user_id)
    {
        foreach ($meta_fields as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }
        return get_user_meta($user_id);
    }

}
