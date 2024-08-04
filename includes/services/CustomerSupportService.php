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

    /**
     * Handle Support upload for a user.
     *
     * @param array $file The uploaded Support file.
     * @param int $post_id The ID of the post associated with the user.
     * @return mixed Result from customerSupportModel->handleSupportUpload().
     */

     public function handleSupportUpload($files, $post_id, $comment_data)
     {
         return $this->customerSupportModel->handleSupportUpload($files, $post_id, $comment_data);
     }
    
}