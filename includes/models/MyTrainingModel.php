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
            // Nenhum resultado encontrado para o usuário ou usuário não ativo.
            return array();
        }
    }

    public function getCategoriesTrainings($myTraining)
    {
        $categories = [
            'categoria-1' => ['sleepQuality', 'mentalFatigue', 'controlofAnxiety', 'emotionalControl'],
            'categoria-2' => ['stress', 'bodyPain', 'headache'],
            'categoria-3' => ['stimuliAnxiety', 'thoughtsInvasive', 'perceptionMindBody'],
        ];

        $categoryTerms = [];

        foreach ($categories as $categoryKey => $category) {
            $totalSum = 0;
            foreach ($myTraining["Bem-estar Cerebral"] as $categoryName => $values) {
                if (in_array($categoryName, $category)) {
                    foreach ($values as $value) {
                        $intValue = intval($value);
                        $totalSum += $intValue;
                    }
                }
            }
            $categoryTerms[$categoryKey] = $totalSum;
        }

        arsort($categoryTerms); // Classifica o array de soma do maior para o menor

        return $this->getCompareTrainings(array_keys($categoryTerms)); // Envia as chaves (nomes das categorias) em vez dos valores.

    }

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
                        'terms' => $category, // Use a categoria atual como termo de pesquisa.
                    ),
                ),
            );
            $postslist[] = get_posts($args);
        }

        return $postslist;

    }

    public function insertTrainingProgress($current_user_id, $post_id, $DH_enter, $DH_exit, $neuralResonance, $cognitiveStimulation, $neuralBreathing, $updateProgress)
    {
        global $wpdb;

        // Verificar se o usuário já existe na tabela
        $existing_user = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $this->table_name_progress WHERE user_id = %d AND post_id = %d", $current_user_id, $post_id)
        );

        if ($existing_user) {
            $time_exit = strtotime($existing_user->dh_exit) + strtotime($DH_exit);
            $time_neuralResonance = strtotime($existing_user->neuralResonance) + strtotime($neuralResonance);
            $time_cognitiveStimulation = strtotime($existing_user->cognitiveStimulation) + strtotime($cognitiveStimulation);
            $time_neuralBreathing = strtotime($existing_user->neuralBreathing) + strtotime($neuralBreathing);

            $DH_exit_time = gmdate("H:i:s", $time_exit);
            $DH_exit_time_neuralResonance = gmdate("H:i:s", $time_neuralResonance);
            $DH_exit_time_cognitiveStimulation = gmdate("H:i:s", $time_cognitiveStimulation);
            $DH_exit_time_neuralBreathing = gmdate("H:i:s", $time_neuralBreathing);

            $progress_data = array(
                'dh_exit' => $DH_exit_time,
                'neuralResonance' => $DH_exit_time_neuralResonance,
                'cognitiveStimulation' => $DH_exit_time_cognitiveStimulation,
                'neuralBreathing' => $DH_exit_time_neuralBreathing,
                'updateProgress' => $updateProgress,
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
                'dh_enter' => $DH_enter,
                'dh_exit' => $DH_exit,
                'neuralResonance' => $neuralResonance,
                'cognitiveStimulation' => $cognitiveStimulation,
                'neuralBreathing' => $neuralBreathing,
                'updateProgress' => $updateProgress,
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

        // Cria a barra de progresso
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

}
