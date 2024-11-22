<?php
require_once plugin_dir_path(__FILE__) . '../services/UserRelatedService.php';
require_once plugin_dir_path(__FILE__) . '../services/TrainingService.php';
require_once plugin_dir_path(__FILE__) . '../services/MyTrainingService.php';

class DashboardModel
{

    private $table_progress;
    private $table_replies;
    private $wpdb;
    private $userRelatedService;
    private $trainingService;
    private $myTrainingService;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_progress = $this->wpdb->prefix . 'adn_progress';
        $this->table_replies = $this->wpdb->prefix . 'adn_replies';
        $this->userRelatedService = new UserRelatedService();
        $this->trainingService = new TrainingService();
        $this->myTrainingService = new MyTrainingService();

    }

    public function getListRelated($user_id)
    {
        $list = $this->userRelatedService->listUserRelated($user_id);
        return $list;
    }

    public function getPrepareProgress($user_id)
    {
        if (!$user_id) {
            return false;
        }

        $query = $this->wpdb->prepare(
            "SELECT activity_started, activity_updated, neural_breathing, neural_resonance, cognitive_stimulation, post_id FROM $this->table_progress WHERE user_id = %d",
            $user_id
        );

        $results = $this->wpdb->get_results($query);

        if (!empty($results)) {
            return $results;
        }

        return false;
    }

    public function getPrepareReplies($user_id)
    {
        if (!$user_id) {
            return false;
        }

        $query = $this->wpdb->prepare(
            "SELECT treinamentos FROM $this->table_replies WHERE user_id = %d",
            $user_id
        );

        $results = $this->wpdb->get_results($query);
        $postTitles = array();

        foreach ($results as $result) {
            $replies = json_decode($result->treinamentos);

            if ($replies && isset($replies)) {
                foreach ($replies as $post_id) {
                    $post = get_post($post_id);
                    $porcentagem = $this->getProgress($user_id);

                    if ($post) {
                        $postTitles[] = [
                            "training" => $post->post_title,
                            "porcentagem" => isset($porcentagem[$post->ID]->porcentagem) ? $porcentagem[$post->ID]->porcentagem : "0",
                        ];
                    }
                }
            }
        }

        return (!empty($postTitles)) ? $postTitles : false;
    }

    public function getProgressUser($user_id)
    {
        $users = $this->getListRelated($user_id);
        $result = [];
    
        foreach ($users as $user) {
            $trainings = $this->myTrainingService->getProgress($user->ID);
            $general = $this->myTrainingService->getTotalProgress($user->ID);
    
            $total = 0; // Inicializando corretamente como 0
            $averageProgress = 0; // Inicializando a variável como 0
    
            if (!empty($trainings)) {
                $count = count($trainings);
    
                if ($count > 0) {
                    foreach ($trainings as $training) {
                        if (isset($training->porcentagem) && is_numeric($training->porcentagem)) {
                            $total += $training->porcentagem;
                        }
                    }
                    $averageProgress = min(round($total / $count), 100);
                }
            }
    
            $preparesUpdateds = $this->getPrepareProgress($user->ID);
            $activity_updated = "";
    
            if (!empty($preparesUpdateds)) {
                foreach ($preparesUpdateds as $preparesUpdated) {
                    $activity_updated = date_i18n('d M', $preparesUpdated->activity_updated);
                }
            }
    
            $result[] = [
                "ID" => $user->ID,
                "name" => $user->display_name,
                "porcentagem" => $averageProgress,
                "updated" => $activity_updated,
                "neural_breathing" => min(round($general['neural_breathing']), 100),
                "neural_resonance" => min(round($general['neural_resonance']), 100),
                "cognitive_stimulation" => min(round($general['cognitive_stimulation']), 100),
            ];
        }
    
        return $result;
    }


    public function getProgress($user_id)
    {
        $timestampsArray = $this->getPrepareProgress($user_id);
        $progress = [];

        // Tempos mínimos semanais em segundos
        $minTimeNeuralResonance = 8400; // 7 dias * 1200 segundos/dia
        $minTimeNeuralBreathing = 4200; // 7 dias * 600 segundos/dia
        $minTimeCognitiveStimulation = 4200; // 7 dias * 600 segundos/dia

        // Pesos das categorias
        $weights = [
            'neural_breathing' => 17.5,
            'neural_resonance' => 70,
            'cognitive_stimulation' => 17.5,
        ];

        if (!empty($timestampsArray)) {
            foreach ($timestampsArray as $timestampObject) {
                $categoryProgress = [];

                // Associando categorias com seus tempos mínimos
                $categories = [
                    'neural_breathing' => $minTimeNeuralBreathing,
                    'neural_resonance' => $minTimeNeuralResonance,
                    'cognitive_stimulation' => $minTimeCognitiveStimulation,
                ];

                foreach ($categories as $category => $minTimeSeconds) {
                    $start = $timestampObject->activity_started;
                    $end = $timestampObject->{$category};
                    $differenceSeconds = max($end - $start, 0);
                    $percentage = min(($differenceSeconds / $minTimeSeconds) * $weights[$category], 100);
                    $categoryProgress[$category] = $percentage;
                }

                // Calculando a soma ponderada das porcentagens
                $totalProgress = array_sum($categoryProgress);

                // Limitando o progresso a no máximo 100%
                $totalProgress = min(round($totalProgress), 100);
                

                $progress[$timestampObject->post_id] = (object) [
                    'porcentagem' => ceil($totalProgress),
                ];
            }
        }

        return $progress;
    }

}
