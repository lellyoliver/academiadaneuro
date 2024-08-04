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

    public function create($request)
    {
        $user_id = $request->get_param('user_id');
        $post_id = $request->get_param('post_id');
        $neural_breathing = $request->get_param('neural_breathing');
        $neural_resonance = $request->get_param('neural_resonance');
        $cognitive_stimulation = $request->get_param('cognitive_stimulation');

        if (isset($user_id) && !empty($user_id)) {
            $data = [
                'user_id' => $user_id,
                'post_id' => $post_id,
                'activity_type' => [
                    'neural_breathing' => $neural_breathing,
                    'neural_resonance' => $neural_resonance,
                    'cognitive_stimulation' => $cognitive_stimulation,
                ],
            ];

            $result = $this->myTrainingService->progress($data);

            if ($result) {
                $response = array(
                    'status' => 'erro',
                    'mensagem' => 'Não foi possível salvar um treinamento',
                );
                return new WP_REST_Response($response, 200);
            }
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível salvar um treinamento',
        );

        return new WP_REST_Response($response, 500);
    }

    public function show()
    {
        if (!is_user_logged_in()) {
            wp_redirect(site_url('/login', 'https'));
            exit;
        }
        $userExpired = $this->userExpired();

        if ($this->roleRegistered()) {
            if (!$userExpired[0]["status"]) {
                wp_redirect(site_url('/meu-perfil', 'https'));
                exit;
            }
        }
        $user_id = get_current_user_id();
        $trainings = $this->myTrainingService->getPrepareReplies($user_id);
        if (empty($trainings)) {
            wp_redirect(site_url('/gerar-treinamento', 'https'));
            exit;
        }
        $progress = $this->myTrainingService->getPrepareProgress($user_id);
        $porcent = $this->myTrainingService->getProgress($user_id);

        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/training/MyTrainingView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function showRessonanceNeural()
    {
        ob_start();
        $user_id = get_current_user_id();
        $post_id = get_the_ID();
        $resonance_neural = get_post_meta($post_id, 'neuralResonance', true);
        require_once plugin_dir_path(__FILE__) . '../views/training/RessonanceNeuralView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function showRessonanceBreathing()
    {
        ob_start();
        $post_id = get_the_ID();
        $ressonance_breathing = get_post_meta($post_id, 'neuralBreathing', true);
        require_once plugin_dir_path(__FILE__) . '../views/training/RessonanceBreathingView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function showCognitiveStimulationGame()
    {
        ob_start();
        $post_id = get_the_ID();
        $cognitive_stimulation = get_post_meta($post_id, 'cognitiveStimulation', true);
        require_once plugin_dir_path(__FILE__) . '../views/training/CognitiveStimulationGameView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function showCognitiveStimulationHidden()
    {
        ob_start();
        $user_id = get_current_user_id();
        $post_id = get_the_ID();
        $cognitive_stimulation = get_post_meta($post_id, 'cognitiveStimulation', true);
        require_once plugin_dir_path(__FILE__) . '../views/training/CognitiveStimulationHiddenView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function showUpdated()
    {
        ob_start();
        $user_id = get_current_user_id();
        $post_id = get_the_ID();
        $updated = $this->myTrainingService->getUpdatedProgress($user_id, $post_id);
        $infos = $this->myTrainingService->getlearnMore($post_id);
        require_once plugin_dir_path(__FILE__) . '../views/training/MyTrainingUpdatedView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function showTotalProgress($atts)
    {
        $atts = shortcode_atts(
            array(
                'category' => 'default_category',
            ),
            $atts,
            'user-total-progress'
        );

        $user_id = get_current_user_id();
        $progress_data = $this->myTrainingService->getTotalProgress($user_id);

        if (isset($progress_data[$atts['category']])) {
            return $progress_data[$atts['category']];
        } else {
            return 'Categoria inválida';
        }
    }

    public function userExpired()
    {
        return $this->userService->userExpiredData();
    }

    public function roleRegistered()
    {
        $current_user = wp_get_current_user();
        $allowed_roles_2 = ['training', 'coachingRelation'];
        if (array_intersect($allowed_roles_2, $current_user->roles)) {
            return true;
        }
        return false;
    }
}
