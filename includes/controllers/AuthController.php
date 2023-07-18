<?php

require_once plugin_dir_path(__FILE__) . '../services/AuthService.php';

class AuthController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function processLogin($request)
    {
        $email = $request->get_param('email');
        $password = $request->get_param('password');

        $result = $this->authService->login($email, $password);

        if ($result) {
            $response = array(
                'status' => 'sucesso',
                'message' => 'Login válido',
            );
            return new WP_REST_Response($response, 200);
        } else {
            $response = array(
                'status' => 'erro',
                'message' => 'Login inválido',
            );
            return new WP_REST_Response($response, 500);
        }
    }

    public function show()
    {
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/auth/AuthView.php';
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
