<?php

class DB
{
    private $charset_collate;
    private $wpdb;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->charset_collate = $wpdb->get_charset_collate();
    }

    public function create_table_adn_replies()
    {
        $table_name = $this->wpdb->prefix . 'adn_replies';

        $sql = "CREATE TABLE $table_name (
            reply_id INT NOT NULL AUTO_INCREMENT,
            user_id BIGINT UNSIGNED,
            post_id BIGINT,
            replies JSON,
            treinamentos JSON,
            PRIMARY KEY (reply_id)
        ) $this->charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public function create_table_adn_progress()
    {
        $table_name = $this->wpdb->prefix . 'adn_progress';

        $sql = "CREATE TABLE $table_name (
        progress_id INT NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED,
        post_id BIGINT UNSIGNED,
        activity_started BIGINT,
        activity_completed BIGINT,
        activity_status BIGINT,
        neural_breathing BIGINT,
        neural_resonance BIGINT,
        cognitive_stimulation BIGINT,
        activity_updated BIGINT,
        PRIMARY KEY (progress_id)

    ) $this->charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

}