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

    public function createTableTrainingReplies()
    {
        $sql = "CREATE TABLE $this->table_name (
            id INT NOT NULL AUTO_INCREMENT,
            id_user BIGINT UNSIGNED NOT NULL,
            replies LONGTEXT NOT NULL,
            PRIMARY KEY (id)
        ) $this->charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public function insertTrainingReplies($response)
    {
        $data_replies = array(
            'user_id' => $user_id,
            'post_id' => $post_id,
            'replies' => json_encode($response),
        );

        $wpdb->insert($this->table_name, $data_replies);

    }

}