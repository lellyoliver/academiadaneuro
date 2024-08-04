<?php
require_once plugin_dir_path(__FILE__) . '../models/CustomerSupportModel.php';

class CustomerSupportService
{
    private $customerSupportModel;

    public function __construct()
    {
        $this->customerSupportModel = new CustomerSupportModel();
    }

    public function createSupport($comment_data)
    {
        return $this->customerSupportModel->createSupport($comment_data);
    }

    public function getSupportID($user_id){
        return $this->customerSupportModel->getSupportID($user_id);
    }
    
}