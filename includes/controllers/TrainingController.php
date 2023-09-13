<?php

require_once plugin_dir_path(__FILE__) . '../services/TrainingService.php';
require_once plugin_dir_path(__FILE__) . '../models/TrainingModel.php';
require_once ABSPATH . '/wp-admin/includes/file.php';

class TrainingController
{
    private $trainingService;
    private $trainingModel;

    public function __construct()
    {
        $this->trainingService = new TrainingService();
        $this->trainingModel = new TrainingModel();

    }

    public function show()
    {

        if (!is_user_logged_in()) {
            wp_redirect('/academiadaneurociencia/404/');
            exit;
        }

        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/training/TrainingView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function getTrainingReplies($response)
    {
        return $this->trainingService->insertTrainingReplies($response);
    }

}
