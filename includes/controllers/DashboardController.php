<?php
// require_once plugin_dir_path(__FILE__) . '../services/DashboardService.php';

class DashboardController
{
    private $dashboardService;

    public function __construct()
    {
        // $this->dashboardService = new DashboardService();
    }

    /**
     * Display the dashboard.
     *
     * @return string The HTML/PHP content of the dashboard.
     */
    public function show()
    {
        if (is_page(30)) {
            if (!is_user_logged_in()) {
                wp_redirect('/academiadaneurociencia/404/');
                exit;
            }
        }
        ob_start();

        // Display menu links based on user's roles
        require_once plugin_dir_path(__FILE__) . '../views/dashboard/DashboardView.php';

        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
