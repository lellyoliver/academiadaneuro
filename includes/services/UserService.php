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
     * Create a new user in the WordPress database.
     *
     * @param array $user_data An array containing user data, including email and billing information.
     * @return mixed WP_Error if email or username already exists, otherwise, result from userModel->createUser().
     */
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

    /**
     * Get the latest orders for a user.
     *
     * @param int $id The ID of the user.
     * @return mixed The latest orders for the user.
     */
    public function getLatestOrders($id)
    {
        return $this->userModel->getLatestOrders($id);
    }

    /**
     * Handle avatar upload for a user.
     *
     * @param array $file The uploaded avatar file.
     * @param int $post_id The ID of the post associated with the user.
     * @return mixed Result from userModel->handleAvatarUpload().
     */

    public function handleAvatarUpload($file, $post_id)
    {
        return $this->userModel->handleAvatarUpload($file, $post_id);
    }

    /**
     * Retrieve expired user data.
     *
     * @return mixed Expired user data.
     */
    public function userExpiredData()
    {
        return $this->userModel->userExpiredData();
    }

    /**
     * Get users with expired data.
     *
     * @return mixed Users with expired data.
     */
    public function getUserExpired()
    {
        return $this->userModel->getUserExpired();
    }

    /**
     * Handle refunded user for a specific order.
     *
     * @param int $order_id The ID of the refunded order.
     * @return mixed Result from userModel->orderRefunded($order_id).
     */
    public function orderRefunded($order_id)
    {
        return $this->userModel->orderRefunded($order_id);
    }


    public function openPixShow(){
        return $this->userModel->openPixShow();
    }

}
