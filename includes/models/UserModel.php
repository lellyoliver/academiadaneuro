<?php
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class UserModel
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

    public function createUser($name, $email, $billing_data, $user_role, $password)
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
        );

        $user_id = wp_insert_user($userdata);

        return $user_id;
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

    public function createRelated($user_id, $current_user_id)
    {
        add_user_meta($user_id, 'connected_user', $current_user_id); // Adiciona a relação com o usuário atual

        return $user_id;
    }

}
