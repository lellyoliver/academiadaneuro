<?php
require_once plugin_dir_path(__FILE__) . '../models/MyTrainingModel.php';

class MyTrainingService
{
    private $myTrainingModel;

    public function __construct()
    {
        $this->myTrainingModel = new MyTrainingModel();
    }

    public function getPrepareReplies($user_id)
    {
        return $this->myTrainingModel->getPrepareReplies($user_id);
    }

    public function getPrepareProgress($user_id)
    {
        return $this->myTrainingModel->getPrepareProgress($user_id);
    }

    public function progress($data)
    {
        return $this->myTrainingModel->progress($data);
    }

    public function getProgress($user_id)
    {
        return $this->myTrainingModel->getProgress($user_id);
    }

    public function getUpdatedProgress($user_id, $post_id)
    {
        return $this->myTrainingModel->getUpdatedProgress($user_id, $post_id);
    }

    public function getTotalProgress($user_id)
    {
        return $this->myTrainingModel->getTotalProgress($user_id);
    }

    public function getlearnMore($post_id)
    {
        return $this->myTrainingModel->getlearnMore($post_id);
    }

    // public function getMetaTrainings($post_id)
    // {
    //     return $this->myTrainingModel->getMetaTrainings($post_id);
    // }
}
