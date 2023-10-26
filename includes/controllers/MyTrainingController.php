<?php

require_once plugin_dir_path(__FILE__) . '../services/MyTrainingService.php';

class MyTrainingController
{
    private $myTrainingService;

    public function __construct()
    {
        $this->myTrainingService = new MyTrainingService();
    }

    public function show()
    {
        if (!is_user_logged_in()) {
            wp_redirect('/academiadaneurociencia/404/');
            exit;
        }
        $trainings = $this->getMyTrainings();
        $progress = $this->getProgressTraining();
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/training/MyTrainingView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function getMyTrainings()
    {
        $current_user_id = get_current_user_id();
        $myTraining = $this->myTrainingService->getResultsTraining($current_user_id);
        $myTrainings = $this->myTrainingService->getCategoriesTrainings($myTraining);
        return $myTrainings;

    }
    public function getTrainingProgress($request)
    {
        $DH_enter = $request->get_param('DH_enter');
        $DH_exit = $request->get_param('DH_exit');
        $neuralResonance = $request->get_param('neuralResonance');
        $cognitiveStimulation = $request->get_param('cognitiveStimulation');
        $neuralBreathing = $request->get_param('neuralBreathing');
        $updateProgress = $request->get_param('updateProgress');
        $current_user_id = $request->get_param('user_id');
        $post_id = $request->get_param('post_id');

        $result = $this->myTrainingService->insertTrainingProgress($current_user_id, $post_id, $DH_enter, $DH_exit, $neuralResonance, $cognitiveStimulation, $neuralBreathing, $updateProgress);

        if ($result) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Treinamento salvo com sucesso',
                'current_user_id' => $current_user_id,
                'post_id' => $post_id,
                'DH_Enter' => $DH_enter,
                'DH_Exit' => $DH_exit,
                'neuralResonance' => $neuralResonance,
                'cognitiveStimulation' => $cognitiveStimulation,
                'neuralBreathing' => $neuralBreathing,
                'updateProgress' => $updateProgress,

            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível salvar o treinamento',
        );
        return new WP_REST_Response($response, 500);

    }

    public function getProgressTraining()
    {
        $current_user_id = get_current_user_id();

        $trainings = $this->getMyTrainings();
        $progress = [];

        if (!empty($trainings)) {
            foreach ($trainings as $categoryName => $postList) {
                if (!empty($postList)) {
                    foreach ($postList as $post) {
                        $progress[$post->ID] = $this->myTrainingService->progressTraining($current_user_id, $post->ID);
                    }
                }
            }
        }

        return $progress;
    }

}
