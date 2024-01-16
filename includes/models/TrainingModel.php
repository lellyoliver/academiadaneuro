<?php

class TrainingModel
{
    private $table_name_replies;
    private $table_name_progress;
    private $charset_collate;

    public function __construct()
    {
        global $wpdb;
        $this->table_name_replies = $wpdb->prefix . 'training_replies';
        $this->table_name_progress = $wpdb->prefix . 'training_progress';
        $this->charset_collate = $wpdb->get_charset_collate();

    }

    public function insertTrainingReplies($user_id, $fields)
    {
        global $wpdb;

        foreach ($fields as $category => $values) {
            foreach ($values as $value) {
                if ($value == "0") {
                    return [
                        'success' => false,
                        'message' => 'Nenhum valor em "fields" pode ser igual a zero.',
                    ];
                }
            }
        }

        $existing_entry = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_name_replies} WHERE user_id = %d",
            $user_id
        ));

        $replies_data = array(
            'user_id' => $user_id,
            'replies' => json_encode($fields),
        );

        if (!$existing_entry) {
            return $wpdb->insert($this->table_name_replies, $replies_data);
        } else {
            return $wpdb->update($this->table_name_replies, $replies_data, array('user_id' => $user_id));
        }
    }

    public function insertTrainingProgress($user_id)
    {
        global $wpdb;

        $post_id = 0;

        $existing_entry = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table_name_progress} WHERE user_id = %d AND post_id = %d",
            $user_id, $post_id
        ));

        $timezone = new DateTimeZone('America/Sao_Paulo');
        $date = new DateTime('now', $timezone);

        $progress_data = array(
            'user_id' => $user_id,
            'post_id' => $post_id,
            'dh_enter' => $date->format('Y-m-d H:i:s'),
            'dh_exit' => '00:00:00',
            'neuralResonance' => '00:00:00',
            'cognitiveStimulation' => '00:00:00',
            'neuralBreathing' => '00:00:00',
            'updateProgress' => $date->format('Y-m-d'),
        );

        if (!$existing_entry) {
            return $wpdb->insert($this->table_name_progress, $progress_data);
        } else {
            return $wpdb->update($this->table_name_progress, $progress_data, array('user_id' => $user_id));
        }
    }

    public function getTrainings($categories)
    {
        $postslist = [];

        foreach ($categories as $category) {
            $args = array(
                'post_type' => 'training',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'brainGroup',
                        'field' => 'slug',
                        'terms' => $category,
                    ),
                ),
            );
            $posts = get_posts($args);

            $postslist[$category] = $posts;
        }

        return $postslist;
    }

}