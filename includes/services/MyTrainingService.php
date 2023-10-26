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

    public function insertTrainingProgress($current_user_id, $post_id, $DH_enter, $DH_exit, $neuralResonance, $cognitiveStimulation, $neuralBreathing, $updateProgress)
    {
        return $this->myTrainingModel->insertTrainingProgress($current_user_id, $post_id, $DH_enter, $DH_exit, $neuralResonance, $cognitiveStimulation, $neuralBreathing, $updateProgress);
    }

    public function progressTraining($current_user_id, $post_id)
    {
        return $this->myTrainingModel->progressTraining($current_user_id, $post_id);
    }
}
