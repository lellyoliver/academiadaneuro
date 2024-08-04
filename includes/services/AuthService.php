<?php
require_once plugin_dir_path(__FILE__) . '../models/AuthModel.php';

class AuthService
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function processEmail($user_id, $token)
    {
        return $this->authModel->sendEmail($user_id, $token);
    }

    public function processForgotPassword($data_register){
        return $this->authModel->processForgotPassword($data_register);
    }

}