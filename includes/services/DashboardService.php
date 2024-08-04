<?php
require_once plugin_dir_path(__FILE__) . '../models/DashboardModel.php';

class DashboardService
{
    private $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    public function getListRelated($user_id)
    {
        return $this->dashboardModel->getListRelated($user_id);
    }

    public function getProgressUser($user_id)
    {
        return $this->dashboardModel->getProgressUser($user_id);
    }

    public function getPrepareProgress($user_id)
    {
        return $this->dashboardModel->getPrepareProgress($user_id);
    }

    public function getPrepareReplies($user_id)
    {
        return $this->dashboardModel->getPrepareReplies($user_id);
    }
}
