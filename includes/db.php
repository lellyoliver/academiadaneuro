<?php

class DBCustom
{
    private $table_name;
    private $charset_collate;

    public function __construct()
    {
        global $wpdb;
        $this->charset_collate = $wpdb->get_charset_collate();
    }

    public function createTableTrainingReplies()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'training_replies';

        $sql = "CREATE TABLE $table_name (
            reply_id INT NOT NULL AUTO_INCREMENT,
            user_id BIGINT UNSIGNED NOT NULL,
            replies LONGTEXT NOT NULL,
            PRIMARY KEY (reply_id)
        ) $this->charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public function createTableTrainingProgress()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'training_progress';

        $sql = "CREATE TABLE $table_name (
        progress_id INT NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NOT NULL,
        post_id BIGINT UNSIGNED NOT NULL,
        dh_enter DATETIME NOT NULL,
        dh_exit TIME NOT NULL,
        neuralResonance TIME NOT NULL,
        cognitiveStimulation TIME NOT NULL,
        neuralBreathing TIME NOT NULL,
        updateProgress DATE NOT NULL,
        PRIMARY KEY (progress_id)

    ) $this->charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

}

new DBCustom();