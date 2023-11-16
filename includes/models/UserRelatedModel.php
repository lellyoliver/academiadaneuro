<?php
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class UserRelatedModel
{
    private $textProcessor;

    public function __construct()
    {
        $this->textProcessor = new TextProcessor();
    }

    public function createUser($name, $email, $billing_data, $user_role, $password, $description)
    {

        $user_name = $this->textProcessor->sanitizeText($billing_data);

        $userdata = array(
            'user_login' => $user_name,
            'user_pass' => $password,
            'user_email' => $email,
            'display_name' => $name,
            'nickname' => $name,
            'first_name' => $name,
            'role' => $user_role,
            'description' => $description,
            'show_admin_bar_front' => false,
        );

        $user_id = wp_insert_user($userdata);

        return $user_id;
    }

    public function updateUser($name, $email, $user_id, $password, $description)
    {

        $userdata = array(
            'ID' => $user_id,
            'user_login' => $name,
            'user_pass' => $password,
            'user_email' => $email,
            'display_name' => $name,
            'nickname' => $name,
            'first_name' => $name,
            'description' => $description,
        );

        $user_updated = wp_update_user($userdata);

        return $user_updated;
    }

    public function deleteUser($id)
    {
        global $wpdb;

        $wpdb->delete($wpdb->usermeta, array('user_id' => $id));
        $wpdb->delete($wpdb->users, array('ID' => $id));

        $deleted_user = get_user_by('ID', $id);

        if (!$deleted_user) {
            return true;
        } else {
            return false;
        }
    }

    public function updateMeta($meta_fields, $user_id)
    {
        foreach ($meta_fields as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }

        return get_user_meta($user_id);
    }

    public function createRelated($user_id, $current_user_id)
    {
        add_user_meta($user_id, 'connected_user', $current_user_id);

        return $user_id;
    }

    public function getListUserRelated($current_user_id)
    {
        $metadata = array(
            'meta_key' => 'connected_user', // Substitua pelo nome da sua meta
            'meta_value' => $current_user_id,
            'fields' => 'all_with_meta',
        );

        $users_data = get_users($metadata);

        return $users_data;
    }

    public function getUserById($id)
    {
        $user = get_userdata($id);

        if (!$user) {
            return new WP_Error('user_not_found', 'User not found', array('status' => 404));
        }

        // Customize the user data that you want to return
        $user_data = array(
            'ID' => $user->ID,
            'user_pass' => $user->user_pass,
            'user_email' => $user->user_email,
            'description' => $user->description,
            'billing_first_name' => $user->billing_first_name,
            'billing_phone' => $user->billing_phone,
        );

        return $user_data;
    }

}