<?php
class MyTrainingModel
{
    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name_replies = $wpdb->prefix . 'training_replies';
        $this->table_name_progress = $wpdb->prefix . 'training_progress';

    }

    /**
     * Get the training results for a specific user.
     *
     * @param int $current_user_id The ID of the current user.
     * @return array An array of training results for the user.
     */
    public function getResultsTraining($current_user_id)
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT replies FROM $this->table_name_replies WHERE user_id = %d",
            $current_user_id
        );

        $results = $wpdb->get_var($query);

        if ($results) {
            $replies = json_decode($results, true);
            if ($replies !== null) {
                return $replies;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
/**
 * Categorize the user's trainings based on specific criteria.
 *
 * @param array $myTraining An array of user's training data.
 * @return array An array of categorized trainings.
 */
    public function getCategoriesTrainings($myTraining)
    {
        $categories = [
            'categoria-1' => ['sleepQuality', 'mentalFatigue', 'controlofAnxiety'],
            'categoria-2' => ['stress', 'bodyPain', 'headache'],
            'categoria-3' => ['stimuliAnxiety', 'thoughtsInvasive', 'perceptionMindBody'],
            'categoria-4' => ['mentalActivity', 'creativity', 'learningAndMemory'],
            'categoria-5' => ['focusAndAttention', 'concentration'],
        ];

        $categoryTerms = [];

        foreach ($categories as $categoryKey => $category) {
            $totalSum = 0;
            foreach ($myTraining as $trainingCategory => $values) {
                if (is_array($values) && in_array($trainingCategory, $category)) {
                    foreach ($values as $value) {
                        $intValue = intval($value);
                        $totalSum += $intValue;
                    }
                }
            }
            $categoryTerms[$categoryKey] = $totalSum;
        }

        arsort($categoryTerms);

        return $this->getCompareTrainings(array_keys($categoryTerms));
    }
/**
 * Retrieve and compare trainings based on specified categories.
 *
 * @param array $categories An array of training categories to compare.
 * @return array An array of compared trainings.
 */
    public function getCompareTrainings($categories)
    {

        $postslist = [];

        foreach ($categories as $category) {
            $args = array(
                'post_type' => 'training',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'brainGroup',
                        'field' => 'slug',
                        'terms' => $category,
                    ),
                ),
            );
            $postslist[] = get_posts($args);
        }

        return $postslist;

    }

    /**
     * Retrieve and compare trainings based on specified post IDs.
     *
     * @param array $post_ids An array of post IDs to retrieve and compare trainings.
     * @return array An array of compared trainings.
     */
    public function getCompareTrainingsPostID($postIDs)
    {
        if (!is_array($postIDs) || !isset($postIDs['post_id'])) {
            return array();
        }

        $postIDsArray = $postIDs['post_id'];

        $postslist = [];

        foreach ($postIDsArray as $postID) {
            $args = array(
                'post_type' => 'training',
                'post__in' => array($postID),
            );

            $postslist[] = get_posts($args);
        }

        return $postslist;
    }

    public function insertTrainingProgress($data)
    {
        global $wpdb;
        $current_user_id = $data['user_id'];
        $post_id = $data['post_id'];

        $existing_user = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $this->table_name_progress WHERE user_id = %d AND post_id = %d", $current_user_id, $post_id)
        );

        if ($existing_user) {
            // Calcular os novos valores aqui
            $new_dh_exit = strtotime($existing_user->dh_exit) + strtotime($data['DH_exit']);
            $new_neuralResonance = strtotime($existing_user->neuralResonance) + strtotime($data['neuralResonance']);
            $new_cognitiveStimulation = strtotime($existing_user->cognitiveStimulation) + strtotime($data['cognitiveStimulation']);
            $new_neuralBreathing = strtotime($existing_user->neuralBreathing) + strtotime($data['neuralBreathing']);

            $progress_data = array(
                'dh_exit' => gmdate("H:i:s", $new_dh_exit),
                'neuralResonance' => gmdate("H:i:s", $new_neuralResonance),
                'cognitiveStimulation' => gmdate("H:i:s", $new_cognitiveStimulation),
                'neuralBreathing' => gmdate("H:i:s", $new_neuralBreathing),
                'updateProgress' => $data['updateProgress'],
            );

            $where = array(
                'user_id' => $current_user_id,
                'post_id' => $post_id,
            );

            return $wpdb->update($this->table_name_progress, $progress_data, $where);
        } else {
            $progress_data = array(
                'user_id' => $current_user_id,
                'post_id' => $post_id,
                'dh_enter' => $data['DH_enter'],
                'dh_exit' => $data['DH_exit'],
                'neuralResonance' => $data['neuralResonance'],
                'cognitiveStimulation' => $data['cognitiveStimulation'],
                'neuralBreathing' => $data['neuralBreathing'],
                'updateProgress' => $data['updateProgress'],
            );

            return $wpdb->insert($this->table_name_progress, $progress_data);
        }
    }

    public function progressTraining($current_user_id, $post_id)
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT dh_enter, dh_exit
        FROM $this->table_name_progress
        WHERE user_id = %d AND post_id = %d",
            $current_user_id,
            $post_id
        );

        $results = $wpdb->get_results($query);
        $dh_enter = '01:00:00';
        $status = 0;
        $dh_enter_seconds = strtotime($dh_enter) - strtotime('00:00:00');
        foreach ($results as $result) {
            $result_seconds = strtotime($result->dh_exit) - strtotime('00:00:00');
            if ($result_seconds > $dh_enter_seconds) {
                $status = "100%";
            } else {
                $remaining_seconds = $dh_enter_seconds - $result_seconds;
                $percentage = (($dh_enter_seconds - $remaining_seconds) / $dh_enter_seconds) * 100;
                $status = $percentage . "%";
            }
        }

        $progress_bar = sprintf(
            '<span class="progress" style="width:500px;">
                <span class="progress-bar" role="progressbar" style="width:%s;" aria-valuenow="%s" aria-valuemin="0" aria-valuemax="100">%s%%</span>
             </span>',
            $status,
            $status,
            round($status, 0)
        );

        return $progress_bar;
    }

    public function getMetaTrainings($post_id)
    {
        $neuralResonance = get_post_meta($post_id, 'neuralResonance', true);
        $videoTraining = get_post_meta($post_id, 'videoTraining', true);
        $neuralBreathing = get_post_meta($post_id, 'neuralBreathing', true);
        $cognitiveStimulation = get_post_meta($post_id, 'cognitiveStimulation', true);

        $response_data = array(
            'neuralResonance' => $neuralResonance,
            'videoTraining' => $videoTraining,
            'neuralBreathing' => $neuralBreathing,
            'cognitiveStimulation' => $cognitiveStimulation,
        );

        return $response_data;

    }

}
