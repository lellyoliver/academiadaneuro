<?php

require_once plugin_dir_path(__FILE__) . '../services/MyTrainingService.php';
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';


class MyTrainingController
{
    private $myTrainingService;
    private $userService;


    public function __construct()
    {
        $this->myTrainingService = new MyTrainingService();
        $this->userService = new UserService();
    }

    public function show()
    {
        if (!is_user_logged_in()) {
            wp_redirect(site_url('/login', 'https'));
            exit;
        }
        $userExpired = $this->userExpired();

        if($this->roleRegistered()){
            if(!$userExpired[0]["status"]){
                wp_redirect(site_url('/meu-perfil', 'https'));
                exit;
            }
        }
        
        $trainings = $this->getMyTrainings();
        if (empty($trainings)) {
            wp_redirect(site_url('/novo-treinamento', 'https'));
            exit;
        }
        $progress = $this->getProgressTraining();
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/training/MyTrainingView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * Get the user's training data.
     *
     * @return array An array of user's training data.
     */
    public function getMyTrainings()
    {
        $current_user_id = get_current_user_id();
        $myTraining = $this->myTrainingService->getResultsTraining($current_user_id);

        if (empty($myTraining)) {
            return array();
        }

        if (is_array($myTraining) && isset($myTraining['Bem-estar Cerebral'])) {

            $myTrainings = $this->myTrainingService->getCategoriesTrainings($myTraining);

        } elseif (is_array($myTraining) && isset($myTraining['post_id'])) {
            $myTrainings = $this->myTrainingService->getCompareTrainingsPostID($myTraining);
        }

        return $myTrainings;
    }

    /**
     * Save the training progress for a specific training.
     *
     * @param object $request The request object containing training progress data.
     * @return WP_REST_Response The response containing training progress information.
     */

    public function saveTrainingProgress($request)
    {
        $data = array(
            'DH_enter' => $request->get_param('DH_enter'),
            'DH_exit' => $request->get_param('DH_exit'),
            'neuralResonance' => $request->get_param('neuralResonance'),
            'cognitiveStimulation' => $request->get_param('cognitiveStimulation'),
            'neuralBreathing' => $request->get_param('neuralBreathing'),
            'updateProgress' => $request->get_param('updateProgress'),
            'user_id' => $request->get_param('user_id'),
            'post_id' => $request->get_param('post_id'),
        );

        $result = $this->myTrainingService->insertTrainingProgress($data);

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

    /**
     * Get the progress of all user's trainings.
     *
     * @return array An array of training progress data for all user's trainings.
     */
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

    public function getMetaTrainings($id)
    {
        return $this->myTrainingService->getMetaTrainings($id);
    }
    
    public function userExpired()
    {
        return $this->userService->userExpiredData();
    }

    public function roleRegistered(){
        $current_user = wp_get_current_user();
        $allowed_roles_2 = ['training', 'coachingRelation'];
        if (array_intersect($allowed_roles_2, $current_user->roles)) {
            return true;
        }
        return false;
    }
}
