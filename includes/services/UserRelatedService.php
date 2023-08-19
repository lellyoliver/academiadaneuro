<?php
require_once plugin_dir_path(__FILE__) . '../models/UserRelatedModel.php';

class UserRelatedService
{
    private $userRelatedModel;

    public function __construct()
    {
        $this->userRelatedModel = new UserRelatedModel();
    }

    /**
     * Create a new user in the WordPress database.
     *
     * @return int|WP_Error The user ID if successful, or WP_Error object on failure.
     */
    public function createUser($name, $email, $billing_data, $user_role, $password, $description)
    {
        if (email_exists($email)) {
            return new WP_Error('email_exists', 'O e-mail fornecido já está em uso por outro usuário.', array('status' => 400));
        }

        if (username_exists($billing_data)) {
            return new WP_Error('username_exists', 'O nome de usuário fornecido já está em uso por outro usuário.', array('status' => 400));
        }

        return $this->userRelatedModel->createUser($name, $email, $billing_data, $user_role, $password, $description);
    }

    /**
     * Update an existing user in the WordPress database.
     *
     * @param int $user_id The ID of the user to be updated.
     * @param array $meta_fields An array of fields to update.
     * @return bool Whether the update was successful.
     */
    public function updateUser($name, $email, $user_id, $password, $description)
    {
        return $this->userRelatedModel->updateUser($name, $email, $user_id, $password, $description);
    }

    public function deleteUser($id)
    {
        return $this->userRelatedModel->deleteUser($id);
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
        return $this->userRelatedModel->updateMeta($meta_fields, $user_id);
    }

    /**
     * Create a related user entry.
     *
     * @param int $user_id The ID of the user to be related.
     * @param int $current_user_id The ID of the current user.
     * @return int|null The ID of the related user entry, or null if there's an error.
     */
    public function createRelatedUser($user_id, $current_user_id)
    {
        if (!is_wp_error($user_id)) {
            return $this->userRelatedModel->createRelated($user_id, $current_user_id);
        }

        return null;
    }

    /**
     * List related users for a given user.
     *
     * @param int $current_user_id The ID of the current user.
     * @return array An array containing the list of related users.
     */
    public function listUserRelated($current_user_id)
    {
        return $this->userRelatedModel->getListUserRelated($current_user_id);
    }

    /**
     * Get user details by ID.
     *
     * @param int $id The ID of the user.
     * @return array|WP_Error The user details or an error response.
     */
    public function getUserById($id)
    {
        return $this->userRelatedModel->getUserById($id);
    }
}