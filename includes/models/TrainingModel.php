<?php

class TrainingModel
{
    private $table_name;
    private $charset_collate;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'training_replies';
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
            "SELECT * FROM {$this->table_name} WHERE user_id = %d",
            $user_id
        ));

        $replies_data = array(
            'user_id' => $user_id,
            'replies' => json_encode($fields),
        );

        if (!$existing_entry) {
            return $wpdb->insert($this->table_name, $replies_data);
        } else {
            return $wpdb->update($this->table_name, $replies_data, array('user_id' => $user_id));
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
