<?php
require_once plugin_dir_path(__FILE__) . '../services/DashboardService.php';

class DashboardController
{
    private $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    /**
     * Display the dashboard.
     *
     * @return string The HTML/PHP content of the dashboard.
     */
    public function show()
    {
        if (!is_user_logged_in()) {
            wp_redirect('/academiadaneurociencia/404/');
            exit;
        }

        $list_progress_unify = $this->dashboardService->getListProgress();
        // $list_progress_total = $this->dashboardService->getTotalProgress();
        $name_patient = $this->dashboardService->getListRelated();
        $progress = $this->dashboardService->getTotalProgress();

        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/dashboard/DashboardView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}
