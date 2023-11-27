<?php
require_once plugin_dir_path(__FILE__) . '../services/DashboardService.php';
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';


class DashboardController
{
    private $dashboardService;
    private $userService;


    public function __construct()
    {
        $this->dashboardService = new DashboardService();
        $this->userService = new UserService();
    }

    /**
     * Display the dashboard.
     *
     * @return string The HTML/PHP content of the dashboard.
     */
    public function show()
    {
        if (!is_user_logged_in()) {
            wp_redirect(site_url('/login', 'https'));
            exit;
        }

        $userExpired = $this->userExpired();
        
        if(!$userExpired[0]["status"]){
            wp_redirect(site_url('/meu-perfil', 'https'));
            exit;
        }

        $list_progress_unify = $this->dashboardService->getListProgress();
        // $list_progress_total = $this->dashboardService->getTotalProgress();
        $patients = $this->dashboardService->getListRelated();
        $progress = $this->dashboardService->getTotalProgress();

        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/dashboard/DashboardView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function userExpired()
    {
        return $this->userService->userExpiredData();
    }
}
