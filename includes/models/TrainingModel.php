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

        // Verifique se algum valor em $fields é igual a zero
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

        // Verifique se já existe um registro para o usuário especificado
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
        }
    }

    public function getTrainings($categories)
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
            $posts = get_posts($args);

            $postslist[$category] = $posts;
        }

        return $postslist;
    }

}
