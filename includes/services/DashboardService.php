<?php
require_once plugin_dir_path(__FILE__) . '../models/DashboardModel.php';

class DashboardService
{
    private $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    public function getListRelated()
    {
        return $this->dashboardModel->getListRelated();
    }

    public function getProgressTraining()
    {
        return $this->dashboardModel->getProgressTraining();
    }

    public function getListProgress()
    {
        return $this->dashboardModel->getListProgress();
    }

    public function getTotalProgress()
    {
        return $this->dashboardModel->getTotalProgress();
    }

    public function getReplies($user_id){
        return $this->dashboardModel->getReplies($user_id);
    }

}
