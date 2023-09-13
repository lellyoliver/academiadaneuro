<?php
require_once plugin_dir_path(__FILE__) . '../models/TrainingModel.php';

class TrainingService
{
    private $trainingModel;

    public function __construct()
    {
        $this->trainingModel = new TrainingModel();
    }

    public function insertTrainingReplies($response)
    {
        return $this->trainingService->insertTrainingReplies($response);
    }
}
