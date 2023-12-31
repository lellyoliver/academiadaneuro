<?php
class CustomerSupportController
{

    public function show()
    {
        if (!is_user_logged_in()) {
            wp_redirect(site_url('/login', 'https'));
            exit;
        }
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/customerSupport/CustomerSupportView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
