<?php
require_once plugin_dir_path(__FILE__) . '../models/UserModel.php';

class UserService
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Create a new user in WordPress database.
     *
     * @param string $name The name of the user.
     * @param string $email The email address of the user.
     * @param string $billing_data The username (billing data) of the user.
     * @param string $password The password of the user.
     * @return int|WP_Error The user ID if successful, or WP_Error object on failure.
     */
    public function createUser($name, $email, $billing_data, $user_role, $password)
    {

        if (email_exists($email)) {
            return new WP_Error('email_exists', 'O e-mail fornecido já está em uso por outro usuário.', array('status' => 400));
        }

        if (username_exists($billing_data)) {
            return new WP_Error('username_exists', 'O nome de usuário fornecido já está em uso por outro usuário.', array('status' => 400));
        }

        return $this->userModel->createUser($name, $email, $billing_data, $user_role, $password);
    }

    /**
     * Update user meta fields in WordPress database.
     *
     * @param array $meta_fields An array of user meta fields to be updated.
     * @param int $user_id The ID of the user whose meta data will be updated.
     * @return array An array containing the updated user meta data.
     */
    public function updateMetaUser($meta_fields, $user_id)
    {
        return $this->userModel->updateMeta($meta_fields, $user_id);
    }
    
    public function createRelatedUser($user_id, $current_user_id)
    {
        if (!is_wp_error($user_id)) {
            return $this->userModel->createRelated($user_id, $current_user_id);
        }

        return null;
    }

}
