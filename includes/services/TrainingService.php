<?php
require_once plugin_dir_path(__FILE__) . '../models/TrainingModel.php';

class TrainingService
{
    private $trainingModel;

    public function __construct()
    {
        $this->trainingModel = new TrainingModel();
    }

    public function insertTrainingReplies($user_id, $fields)
    {
        return $this->trainingModel->insertTrainingReplies($user_id, $fields);
    }

    public function getTrainings($categories)
    {
        return $this->trainingModel->getTrainings($categories);
    }
}
