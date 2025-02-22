<?php
require_once plugin_dir_path(__FILE__) . '../services/DashboardService.php';
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';
require_once plugin_dir_path(__FILE__) . '../services/MyTrainingService.php';

class DashboardController
{
    private $dashboardService;
    private $userService;
    private $myTrainingService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
        $this->userService = new UserService();
        $this->myTrainingService = new MyTrainingService();
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
        if ($this->roleRegistered()) {
            if (!$userExpired[0]["status"]) {
                wp_redirect(site_url('/meu-perfil', 'https'));
                exit;
            }
        }

        $user_id = get_current_user_id();
        $progresses = $this->dashboardService->getProgressUser($user_id);
        $teste = $this->dashboardService->getPrepareReplies($user_id);


        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/dashboard/DashboardView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function getReplies($id){
        $replies = $this->dashboardService->getPrepareReplies($id);

        return $replies;
    }

    /**
     * Retrieve user expiration data.
     *
     * @return mixed User expiration data.
     */

    public function userExpired()
    {
        return $this->userService->userExpiredData();
    }

    /**
     * Check if the current user has specific roles.
     *
     * @return bool True if the user has specific roles, false otherwise.
     */
    public function roleRegistered()
    {
        $current_user = wp_get_current_user();
        $allowed_roles_2 = ['training', 'coachingRelation'];
        if (array_intersect($allowed_roles_2, $current_user->roles)) {
            return true;
        }
        return false;
    }
}
