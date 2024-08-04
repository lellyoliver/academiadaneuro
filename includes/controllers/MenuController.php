<?php
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';

class MenuController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Display user details and related information.
     *
     * @return string HTML output for displaying user details.
     */
    public function show()
    {
        ob_start();
        $role = $this->typeRole();
        require_once plugin_dir_path(__FILE__) . '../views/menu/menuView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function typeRole()
    {
        $current_user = wp_get_current_user();
        $allowed_roles_1 = ['coachingRelation', 'training', 'administrator'];
        $allowed_roles_2 = ['coach', 'health-pro', 'administrator'];
        $allowed_roles_3 = ['training', 'administrator']; 
        
        $role = [
            'current_user' => $current_user,
            'nivel_1' => $allowed_roles_1,
            'nivel_2' => $allowed_roles_2,
        ];

        return $role;

    }

    /**
     * Retrieve expired user data.
     *
     * @return mixed Expired user data.
     */
    public function userExpiredData()
    {
        return $this->userService->userExpiredData();
    }

    /**
     * Get users with expired data.
     *
     * @return mixed Users with expired data.
     */
    public function getUserExpired()
    {
        return $this->userService->getUserExpired();
    }
}
