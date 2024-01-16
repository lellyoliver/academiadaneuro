<?php
require_once plugin_dir_path(__FILE__) . '../services/UserRelatedService.php';

class DashboardModel
{

    private $table_name_progress;
    private $table_name_replies;

    private $userRelatedService;

    public function __construct()
    {
        global $wpdb;
        $this->table_name_progress = $wpdb->prefix . 'training_progress';
        $this->table_name_replies = $wpdb->prefix . 'training_replies';
        $this->userRelatedService = new UserRelatedService();
    }

    public function getListRelated()
    {
        $current_user_id = get_current_user_id();
        $list = $this->userRelatedService->listUserRelated($current_user_id);
        return $list;
    }

    public function getProgress($user_id)
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT neuralResonance, cognitiveStimulation, neuralBreathing, updateProgress, user_id FROM $this->table_name_progress WHERE user_id = %d",
            $user_id
        );

        $results = $wpdb->get_results($query);

        return $results;
    }

    public function getProgressTraining()
    {
        $list_related = $this->getListRelated();
        $progressResults = [];

        foreach ($list_related as $user) {
            $user_id = $user->ID;
            $progressResults[] = $this->getProgress($user_id);
        }
        return $progressResults;
    }

    public function getListProgress()
    {
        $results = $this->getProgressTraining();
        $dh_enter_seconds = strtotime('01:00:00') - strtotime('00:00:00');
        $status = array();

        foreach ($results as $userProgress) {
            // Default value for user_id
            $user_id = isset($userProgress[0]->user_id) ? $userProgress[0]->user_id : '';
            $updateProgress = isset($userProgress[0]->updateProgress) ? $userProgress[0]->updateProgress : '';
            $user_status = array();

            foreach ($userProgress as $result) {
                $result_seconds = array();
                foreach (get_object_vars($result) as $category => $time) {
                    $result_seconds[$category] = strtotime($time) - strtotime('00:00:00');
                }

                $category_status = array();
                foreach ($result_seconds as $category => $seconds) {
                    if ($seconds >= $dh_enter_seconds) {
                        $category_status[$category] = "100";
                    } else {
                        $percentage = $seconds > 0 ? round(($seconds / $dh_enter_seconds) * 100, 0) : "0";
                        $category_status[$category] = $percentage;
                    }
                }

                // Set user_id and updateProgress in the category_status
                $category_status['user_id'] = $user_id;
                $category_status['updateProgress'] = $updateProgress;

                $user_status[] = $category_status;
            }

            $status[$user_id] = $user_status;
        }

        return $status;
    }

    public function getTotalProgress()
    {
        $progressArray = $this->getListProgress();

        $categorySums = [];

        foreach ($progressArray as $userId => $userProgress) {
            $updateProgress = isset($userProgress[0]['updateProgress']) ? $userProgress[0]['updateProgress'] : '';
            $categoryCounts = [
                'neuralResonance' => 0,
                'cognitiveStimulation' => 0,
                'neuralBreathing' => 0,
            ];

            foreach ($userProgress as $entry) {
                foreach ($entry as $category => $value) {
                    if ($category !== 'user_id' && $category !== 'updateProgress') {
                        if (is_numeric($value)) {
                            $categorySums[$userId][$category] = isset($categorySums[$userId][$category]) ?
                            $categorySums[$userId][$category] + $value :
                            $value;
                            $categoryCounts[$category]++;
                        }
                    }
                }
            }

            foreach ($categoryCounts as $category => $count) {
                $categorySums[$userId][$category] = $count > 0 ?
                round($categorySums[$userId][$category] / $count, 0) :
                0;
            }

            $categorySums[$userId]['user_id'] = $userId;
            $categorySums[$userId]['updateProgress'] = $updateProgress;
            error_reporting(error_reporting() & ~E_NOTICE);
            $total = array_sum($categorySums[$userId]) - $categorySums[$userId]['user_id'] - $categorySums[$userId]['updateProgress'];
            $categorySums[$userId]['totalProgress'] = round($total / (count($categorySums[$userId]) - 2), 0); // Subtrai 1 para não contar o 'user_id'
        }

        return $categorySums;
    }

    public function getReplies($user_id)
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT replies FROM $this->table_name_replies WHERE user_id = %d",
            $user_id
        );

        $results = $wpdb->get_results($query);
        $postTitles = array();

        foreach ($results as $result) {
            $replies = json_decode($result->replies);

            if ($replies && isset($replies->post_id)) {
                foreach ($replies->post_id as $post_id) {
                    $post = get_post($post_id);

                    if ($post) {
                        $postTitles[] = $post->post_title;
                    }
                }
            }
        }

        return $postTitles;
    }

}
