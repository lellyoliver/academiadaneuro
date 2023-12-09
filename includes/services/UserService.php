<?php
require_once plugin_dir_path(__FILE__) . '../models/UserModel.php';

class UserService
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function createUser($user_data)
    {
        $email = $user_data['email'];
        $billing_data = $user_data['billing_data'];

        if (email_exists($email)) {
            return new WP_Error('email_exists', 'O e-mail fornecido já está em uso por outro usuário.', array('status' => 400));
        }

        if (username_exists($billing_data)) {
            return new WP_Error('username_exists', 'O nome de usuário fornecido já está em uso por outro usuário.', array('status' => 400));
        }

        return $this->userModel->createUser($user_data);
    }

    /**
     * Update an existing user in the WordPress database.
     *
     * @param int $user_id The ID of the user to be updated.
     * @return bool Whether the update was successful.
     */
    public function updateUser($name, $email, $password, $user_id)
    {
        return $this->userModel->updateUser($name, $email, $password, $user_id);
    }

    // public function updateUserNewOrder($name, $billing_data, $email, $password, $user_id)
    // {
    //     return $this->userModel->updateUserNewOrder($name, $billing_data, $email, $password, $user_id);
    // }

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

    /**
     * Get user details by ID.
     *
     * @param int $id The ID of the user.
     * @return array|WP_Error The user details or an error response.
     */
    public function getUserById($id)
    {
        return $this->userModel->getUserById($id);
    }

    public function getLatestOrders($id)
    {
        return $this->userModel->getLatestOrders($id);
    }

    public function handleAvatarUpload($file, $post_id)
    {
        return $this->userModel->handleAvatarUpload($file, $post_id);
    }

    public function userExpiredData()
    {
        return $this->userModel->userExpiredData();
    }
    public function getUserExpired()
    {
        return $this->userModel->getUserExpired();
    }
    // public function deleteUserMetaEntries($user_id)
    // {
    //     return $this->userModel->deleteUserMetaEntries($user_id);
    // }
}
