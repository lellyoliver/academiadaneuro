<?php
require_once plugin_dir_path(__FILE__) . '../models/MyTrainingModel.php';

class MyTrainingService
{
    private $myTrainingModel;

    public function __construct()
    {
        $this->myTrainingModel = new MyTrainingModel();
    }

    public function getResultsTraining($current_user_id)
    {
        return $this->myTrainingModel->getResultsTraining($current_user_id);
    }

    public function getCategoriesTrainings($myTraining)
    {
        return $this->myTrainingModel->getCategoriesTrainings($myTraining);
    }

    public function insertTrainingProgress($data)
    {
        return $this->myTrainingModel->insertTrainingProgress($data);
    }

    public function progressTraining($current_user_id, $post_id)
    {
        return $this->myTrainingModel->progressTraining($current_user_id, $post_id);
    }

    public function getCompareTrainingsPostID($post_id)
    {
        return $this->myTrainingModel->getCompareTrainingsPostID($post_id);
    }

    public function getMetaTrainings($post_id)
    {
        return $this->myTrainingModel->getMetaTrainings($post_id);
    }
}
