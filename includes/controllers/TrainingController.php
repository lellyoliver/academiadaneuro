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

    private function fields()
    {
        return [
            'sleep-quality',
            'mental-fatigue',
            'perception-mind-body',
            'control-of-anxiety',
            'emotional-control',
            'stress',
            'body-pain',
            'headache',
            'external-stimulus-anxiety',
            'thoughts-invasive',
            'mental-activity',
            'concentration',
            'creativity',
            'focus-and-attention',
            'learning-and-memory',
        ];
    }

    /**
     * Create a new user based on the provided data.
     *
     * @param WP_REST_Request $request The REST request containing user data.
     * @return WP_REST_Response The REST response with the result of the operation.
     */
    public function create($request)
    {
        $replies = [];
        foreach ($this->fields() as $field) {
            $index = 0;
            while ($request->get_param($field . '-' . $index) !== null) {
                $key = $field . '-' . $index++;
                $replies[$field][] = $request->get_param($key);
            }
        }

        $user_id = $request->get_param('user_id');

        $data = [
            'replies' => $replies,
            'user_id' => $user_id,
        ];

        $result = $this->trainingService->replies($data);

        if ($result) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Treinamento criado com sucesso',
                'data' => $data,
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
        $replies = [];
        foreach ($this->fields() as $field) {
                $replies[$field] = ["1", "1", "1", "1", "1"];
        }

        $user_id = $request->get_param('user_id');
        $post_id = $request->get_param('post_id');


        $data = [
            'replies' => $replies,
            'user_id' => $user_id,
            'post_id' => $post_id,
        ];

        $result = $this->trainingService->replies($data);

        if ($result) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Treinamento criado com sucesso',
                'data' => $data,
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível criar um treinamento',
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
        ob_start();
        $questions = $this->trainingService->getQuestionsCombine();
        require_once plugin_dir_path(__FILE__) . '../views/training/TrainingView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function showProgress()
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
        $questions = $this->trainingService->getQuestionsCombine();
        require_once plugin_dir_path(__FILE__) . '../views/training/TrainingProgressView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function showChoice(){
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
        $trainings = $this->getListTraining();

        require_once plugin_dir_path(__FILE__) . '../views/training/TrainingChoiceView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function getListRelated()
    {
        $current_user_id = get_current_user_id();
        $list = $this->userRelatedService->listUserRelated($current_user_id);
        return $list;
    }

    public function getListTraining(){
        $trainings = [];
        $categorias = [
            'categoria-1',
            'categoria-2',
            'categoria-3',
            'categoria-4',
            'categoria-5',
        ];
        foreach ($categorias as $categoria) {
            $trainings[] = $this->trainingService->getPostsCategory($categoria);
        }
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
