<?php

require_once plugin_dir_path(__FILE__) . '../services/TrainingService.php';
require_once plugin_dir_path(__FILE__) . '../models/TrainingModel.php';
require_once ABSPATH . '/wp-admin/includes/file.php';

class MyTrainingController
{
    private $trainingService;
    private $trainingModel;

    public function __construct()
    {
        $this->trainingService = new TrainingService();
    }

    // public function create($request)
    // {

    //     $result = $this->trainingService->insertTrainingReplies($user_id, $fields);

    //     if ($result) {
    //         $response = array(
    //             'status' => 'sucesso',
    //             'mensagem' => 'Treinamento criado com sucesso',
    //             'user_id' => $user_id,
    //             'replies' => $fields,
    //         );
    //         return new WP_REST_Response($response, 200);
    //     }

    //     $response = array(
    //         'status' => 'erro',
    //         'mensagem' => 'Não foi possível criar um treinamento',
    //     );
    //     return new WP_REST_Response($response, 500);

    // }

    public function show()
    {
        if (!is_user_logged_in()) {
            wp_redirect('/academiadaneurociencia/404/');
            exit;
        }

        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/training/MyTrainingView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}