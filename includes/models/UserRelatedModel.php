<?php
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class UserRelatedModel
{
    private $textProcessor;

    public function __construct()
    {
        $this->textProcessor = new TextProcessor();
    }

    /**
     * Create a new user in WordPress database.
     *
     * @return int|WP_Error The user ID if successful, or WP_Error object on failure.
     */
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

        // Delete user meta
        $wpdb->delete($wpdb->usermeta, array('user_id' => $id));

        // Delete user
        $wpdb->delete($wpdb->users, array('ID' => $id));

        // Check if the user and usermeta were successfully deleted
        $deleted_user = get_user_by('ID', $id);
        if (!$deleted_user) {
            return true; // Successfully deleted
        } else {
            return false; // Deletion failed
        }
    }

    /**
     * Update user meta fields in WordPress database.
     *
     * @param array $meta_fields An array of user meta fields to be updated.
     * @param int $user_id The ID of the user whose meta data will be updated.
     * @return array An array containing the updated user meta data.
     */
    public function updateMeta($meta_fields, $user_id)
    {
        foreach ($meta_fields as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }

        return get_user_meta($user_id);
    }

    /**
     * Create a related user entry.
     *
     * @param int $user_id The ID of the user to be related.
     * @param int $current_user_id The ID of the current user.
     * @return int The ID of the related user entry.
     */
    public function createRelated($user_id, $current_user_id)
    {
        add_user_meta($user_id, 'connected_user', $current_user_id);

        return $user_id;
    }

    /**
     * Get a list of users related to the given user.
     *
     * @param int $current_user_id The ID of the current user.
     * @param int|string $user_id The ID of the user (optional).
     * @return array An array containing user data.
     */
    public function getListUserRelated($current_user_id, $user_id = "0")
    {
        $metadata = array(
            'meta_key' => 'connected_user', // Substitua pelo nome da sua meta
            'meta_value' => $current_user_id,
            'fields' => 'all_with_meta',
        );

        $users_data = get_users($metadata);

        return $users_data;
    }

    /**
     * Get user details by ID.
     *
     * @param int $id The ID of the user.
     * @return array|WP_Error The user details or an error response.
     */
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
            'billing_postcode' => $user->billing_postcode,
            'billing_address_1' => $user->billing_address_1,
            'billing_state' => $user->billing_state,
            'billing_city' => $user->billing_city,
        );

        return $user_data;
    }

}
