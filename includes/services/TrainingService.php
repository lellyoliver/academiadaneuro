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

    /**
     * List related users for a given user.
     *
     * @param int $current_user_id The ID of the current user.
     * @return array An array containing the list of related users.
     */
    public function listUserRelated($current_user_id)
    {
        return $this->trainingModel->getListUserRelated($current_user_id);
    }
}