<?php
require_once plugin_dir_path(__FILE__) . '../models/UserModel.php';

class UserService
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function createUser($name, $email, $password)
    {
        return $this->userModel->createUser($name, $email, $password);
    }

    public function updateMetaUser($meta_fields, $user_id)
    {
        return $this->userModel->updateMeta($meta_fields, $user_id);
    }
    
}
