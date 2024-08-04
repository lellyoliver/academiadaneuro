<?php
require_once plugin_dir_path(__FILE__) . '../models/TrainingModel.php';

class TrainingService
{
    private $trainingModel;

    public function __construct()
    {
        $this->trainingModel = new TrainingModel();
    }

    public function replies($data)
    {
        return $this->trainingModel->replies($data);
    }

    public function getQuestionsCombine()
    {
        return $this->trainingModel->getQuestionsCombine();
    }

    public function getPostsCategory($categoria)
    {
        return $this->trainingModel->getPostsCategory($categoria);
    }

}
