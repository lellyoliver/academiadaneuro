<?php

require_once plugin_dir_path(__FILE__) . '../services/TrainingService.php';
require_once plugin_dir_path(__FILE__) . '../services/UserRelatedService.php';
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';

class TrainingController
{
    private $trainingService;
    private $userRelatedService;
    private $userService;

    public function __construct()
    {
        $this->trainingService = new TrainingService();
        $this->userRelatedService = new UserRelatedService();
        $this->userService = new UserService();

    }

    /**
     * Create a new user based on the provided data.
     *
     * @param WP_REST_Request $request The REST request containing user data.
     * @return WP_REST_Response The REST response with the result of the operation.
     */

    public function create($request)
    {
        $sleepQuality = $request->get_param('sleepQuality');
        $mentalFatigue = $request->get_param('mentalFatigue');
        $perceptionMindBody = $request->get_param('perceptionMindBody');
        $controlofAnxiety = $request->get_param('controlofAnxiety');
        $stress = $request->get_param('stress');
        $bodyPain = $request->get_param('bodyPain');
        $headache = $request->get_param('headache');
        $stimuliAnxiety = $request->get_param('stimuliAnxiety');
        $thoughtsInvasive = $request->get_param('thoughtsInvasive');
        $mentalActivity = $request->get_param('mentalActivity');
        $creativity = $request->get_param('creativity');
        $learningAndMemory = $request->get_param('learningAndMemory');
        $focusAndAttention = $request->get_param('focusAndAttention');
        $concentration = $request->get_param('concentration');
        $user_id = $request->get_param('user_id');

        $fields = [
            'Bem-estar Cerebral' => [
                'sleepQuality' => $sleepQuality,
                'mentalFatigue' => $mentalFatigue,
                'perceptionMindBody' => $perceptionMindBody,
                'controlofAnxiety' => $controlofAnxiety,
                'stress' => $stress,
                'bodyPain' => $bodyPain,
                'headache' => $headache,
                'stimuliAnxiety' => $stimuliAnxiety,
                'thoughtsInvasive' => $thoughtsInvasive,
            ],
            'Desempenho Cognitivo' => [
                'mentalActivity' => $mentalActivity,
                'creativity' => $creativity,
                'learningAndMemory' => $learningAndMemory,
                'focusAndAttention' => $focusAndAttention,
                'concentration' => $concentration,
            ],
        ];

        $result = $this->trainingService->insertTrainingReplies($user_id, $fields);

        if ($result) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Treinamento criado com sucesso',
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível criar um treinamento',
        );
        return new WP_REST_Response($response, 500);

    }

    public function createChoice($request)
    {
        $post_ids = $request->get_param('post_id');
        $user_id = $request->get_param('user_id');

        $fields = [
            'post_id' => $post_ids,
        ];
        if (!empty($user_id) && !empty($post_ids)) {
            $replies = $this->trainingService->insertTrainingReplies($user_id, $fields);
            $progress = $this->trainingService->insertTrainingProgress($user_id);
        }

        if ($replies || $progress) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Treinamento criado com sucesso',
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Esse treinamento já foi criado para esse paciente!',
        );
        return new WP_REST_Response($response, 500);
    }

    /**
     * Display the user registration form.
     *
     * @return string The HTML/PHP content of the user registration form.
     */

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
        ob_start();
        $users = $this->getListRelated();
        require_once plugin_dir_path(__FILE__) . '../views/training/TrainingView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function choiceShow()
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

        ob_start();
        $users = $this->getListRelated();
        $training = $this->getListTraining();
        require_once plugin_dir_path(__FILE__) . '../views/training/TrainingChoiceView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * Retrieves a list of users related to the current logged-in user.
     *
     * This function first obtains the ID of the currently logged-in user using the WordPress function
     * get_current_user_id().
     *
     * @return array An array of users related to the current user.
     */
    public function getListRelated()
    {
        $current_user_id = get_current_user_id();
        $list = $this->userRelatedService->listUserRelated($current_user_id);
        return $list;
    }

    public function getListTraining()
    {
        $categories = [
            'categoria-1',
            'categoria-2',
            'categoria-3',
            'categoria-4',
            'categoria-5',
        ];
        $trainings = $this->trainingService->getTrainings($categories);
        return $trainings;
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
