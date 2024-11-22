<?php
class MyTrainingModel
{
    private $table_replies;
    private $table_progress;
    private $wpdb;

    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
        $this->table_replies = $this->wpdb->prefix . 'adn_replies';
        $this->table_progress = $this->wpdb->prefix . 'adn_progress';
    }

    /**
     * Get the training results for a specific user or post.
     *
     * @param int|bool $user_id The ID of the user.
     * @return array|bool An array of training results for the user or post, or false on failure.
     */
    public function getPrepareReplies($user_id)
    {
        if ($user_id) {
            $query = $this->wpdb->prepare(
                "SELECT treinamentos FROM $this->table_replies WHERE user_id = %d",
                $user_id
            );
        } else {
            return false;
        }

        $results = $this->wpdb->get_results($query);

        if (!empty($results)) {
            return json_decode($results[0]->treinamentos, true);
        }

        return false;
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

    public function getUpdatedProgress($user_id, $post_id)
    {
        if (!$user_id || !$post_id) {
            return false;
        }

        $query = $this->wpdb->prepare(
            "SELECT activity_updated FROM $this->table_progress WHERE user_id = %d AND post_id = %d",
            $user_id, $post_id
        );

        $results = $this->wpdb->get_results($query);

        $response = [];
        if (!empty($results)) {
            foreach ($results as $result) {
                if (!empty($result->activity_updated)) {

                    $timestamp = intval($result->activity_updated);
                    if ($timestamp > 0) {
                        $response[] = date_i18n('j \d\e F \d\e Y', $timestamp);
                    }
                }
            }
            return $response[0];
        }

        return false;
    }

    /**
     * Calculate progress percentages for each activity type based on specific minimum times.
     *
     * @param int $user_id The user ID to get progress for.
     * @return array The progress percentages for each post ID.
     */
    public function getProgress($user_id)
    {
        $timestampsArray = $this->getPrepareProgress($user_id);
        $progress = [];

        $minTimeNeuralResonance = 8400; // 7 dias * 1200 segundos/dia
        $minTimeNeuralBreathing = 4200; // 7 dias * 600 segundos/dia
        $minTimeCognitiveStimulation = 4200; // 7 dias * 600 segundos/dia

        $weights = [
            'neural_breathing' => 17.5,
            'neural_resonance' => 70,
            'cognitive_stimulation' => 17.5,
        ];

        if (!empty($timestampsArray)) {
            foreach ($timestampsArray as $timestampObject) {
                $categoryProgress = [];
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
                    'porcentagem' => $totalProgress,
                ];
            }
        }

        return $progress;
    }

    public function getTotalProgress($user_id)
    {
        $timestampsArray = $this->getPrepareProgress($user_id);
        $categoryProgress = [
            'neural_breathing' => 0,
            'neural_resonance' => 0,
            'cognitive_stimulation' => 0,
        ];
        $categoryCounts = [
            'neural_breathing' => 0,
            'neural_resonance' => 0,
            'cognitive_stimulation' => 0,
        ];

        $minTimeNeuralResonance = 8400; // 7 dias * 1200 segundos/dia
        $minTimeNeuralBreathing = 4200; // 7 dias * 600 segundos/dia
        $minTimeCognitiveStimulation = 4200; // 7 dias * 600 segundos/dia

        $weights = [
            'neural_breathing' => 17.5,
            'neural_resonance' => 70,
            'cognitive_stimulation' => 17.5,
        ];

        foreach ($timestampsArray as $timestampObject) {
            $categories = [
                'neural_breathing' => $minTimeNeuralBreathing,
                'neural_resonance' => $minTimeNeuralResonance,
                'cognitive_stimulation' => $minTimeCognitiveStimulation,
            ];

            foreach ($categories as $category => $minTimeSeconds) {
                if (isset($timestampObject->{$category})) {
                    $start = $timestampObject->activity_started;
                    $end = $timestampObject->{$category};
                    $differenceSeconds = max($end - $start, 0);
                    $percentage = min(($differenceSeconds / $minTimeSeconds) * $weights[$category], 100);
                    $categoryProgress[$category] += $percentage;
                    $categoryCounts[$category]++;
                }
            }
        }

        $finalProgress = [];
        foreach ($categoryCounts as $category => $count) {
            $finalProgress[$category] = $count > 0 ? ceil($categoryProgress[$category] / $count) : 0;
        }

        return $finalProgress;
    }

    public function progress($data)
    {
        $user_id = $data['user_id'];
        $post_id = $data['post_id'];
        $neural_breathing_seconds = $data['activity_type']['neural_breathing'];
        $cognitive_stimulation_seconds = $data['activity_type']['cognitive_stimulation'];
        $neural_resonance_seconds = $data['activity_type']['neural_resonance'];

        $current_time = current_time('timestamp');

        $progress = $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM $this->table_progress WHERE user_id = %d AND post_id = %d ORDER BY activity_started ASC LIMIT 1",
            $user_id, $post_id
        ));

        if (!$progress) {
            $this->wpdb->insert(
                $this->table_progress,
                array(
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    'activity_started' => $current_time,
                    'activity_completed' => null,
                    'activity_status' => 0,
                    'neural_breathing' => isset($neural_breathing_seconds) && $neural_breathing_seconds !== '' ? $current_time + $neural_breathing_seconds : $current_time,
                    'neural_resonance' => isset($neural_resonance_seconds) && $neural_resonance_seconds !== '' ? $current_time + $neural_resonance_seconds : $current_time,
                    'cognitive_stimulation' => isset($cognitive_stimulation_seconds) && $cognitive_stimulation_seconds !== '' ? $current_time + $cognitive_stimulation_seconds : $current_time,
                    'activity_updated' => $current_time,
                ),
                array(
                    '%d', '%d', '%d', '%s', '%d', '%d', '%d', '%d', '%d',
                )
            );
        } else {
            if ($current_time == $progress->activity_updated) {
                return;
            }

            $this->wpdb->update(
                $this->table_progress,
                array(
                    'neural_breathing' => $progress->neural_breathing + (isset($neural_breathing_seconds) && $neural_breathing_seconds !== '' ? $neural_breathing_seconds : 0),
                    'neural_resonance' => $progress->neural_resonance + (isset($neural_resonance_seconds) && $neural_resonance_seconds !== '' ? $neural_resonance_seconds : 0),
                    'cognitive_stimulation' => $progress->cognitive_stimulation + (isset($cognitive_stimulation_seconds) && $cognitive_stimulation_seconds !== '' ? $cognitive_stimulation_seconds : 0),
                    'activity_updated' => $current_time,
                ),
                array('user_id' => $user_id, 'post_id' => $post_id),
                array('%d', '%d', '%d', '%d'),
                array('%d', '%d')
            );
        }
    }

    public function getlearnMore($post_id)
    {

        $textTraining = get_post_meta($post_id, 'textTraining', true);
        $usageTips = get_post_meta($post_id, 'usageTips', true);
        $recommendations = get_post_meta($post_id, 'recommendations', true);

        $learn_more = [
            'textTraining' => $textTraining,
            'usageTips' => $usageTips,
            'recommendations' => $recommendations,
        ];

        return $learn_more;
    }

}
