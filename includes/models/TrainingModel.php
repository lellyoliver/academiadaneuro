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

    public function insertTrainingReplies($user_id, $fields)
    {
        global $wpdb;

        $replies_data = array(
            'user_id' => $user_id,
            'replies' => json_encode($fields),
        );

        return $wpdb->insert($this->table_name, $replies_data);
    }

    public function getListUserRelated($current_user_id)
    {
        $metadata = array(
            'meta_key' => 'connected_user', // Substitua pelo nome da sua meta
            'meta_value' => $current_user_id,
            'fields' => 'all_with_meta',
        );

        $users_data = get_users($metadata);

        return $users_data;
    }

}