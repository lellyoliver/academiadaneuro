<?php

require_once plugin_dir_path(__FILE__) . '../services/AuthService.php';

class AuthController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $userlogin = sanitize_user($_POST['user_name']);
            $password = sanitize_text_field($_POST['user_password']);

            $user = $this->authenticateUser($userlogin, $password);

            if ($user) {
                wp_redirect('/');
                exit;
            } else {
                echo '<script>
                const div = document.getElementById("alert")
                div.innerHTML = `<div class="alert alert-danger" role="alert">
                                        Login falhou! Verifique suas credenciais.
                                    </div>`;
                </script>';
            }
        }
    }

    /**
     * Authenticate user using WordPress authentication functions.
     *
     * @param string $userlogin The username or email of the user.
     * @param string $password The user's password.
     * @return mixed The authenticated user or false on failure.
     */
    public function authenticateUser($userlogin, $password)
    {
        $user = wp_authenticate($userlogin, $password);

        if (!is_wp_error($user)) {
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);
            return $user;
        }

        return false;
    }

    /**
     * Display the login view.
     *
     * @return string HTML output for the login view.
     */
    public function show()
    {
        $process = $this->processLogin();
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/auth/LoginAuthView.php';
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * Process email confirmation.
     *
     * @param WP_REST_Request $request The REST request containing user_id and token parameters.
     * @return WP_REST_Response The REST response with the result of the operation.
     */
    public function processEmail($request)
    {
        $user_id = $request->get_param('user_id');
        $token = $request->get_param('token');

        $result = $this->authService->processEmail($user_id, $token);

        if ($result) {
            $response = array(
                'status' => 'sucesso',
                'message' => 'Token Confirmado',
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'message' => 'Erro com token de acesso',
        );
        return new WP_REST_Response($response, 500);
    }

    /**
     * Display the email confirmation view.
     *
     * @return string HTML output for the email confirmation view.
     */
    public function emailShow()
    {
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/auth/EmailAuthView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * Process forgot password request.
     *
     * @param WP_REST_Request $request The REST request containing data_register parameter.
     * @return WP_REST_Response The REST response with the result of the operation.
     */
    public function processForgotPassword($request)
    {
        $data_register = $request->get_param('data_register');

        $result = $this->authService->processForgotPassword($data_register);

        if ($result[0]) {
            $response = array(
                'status' => 'sucesso',
                'message' => 'Redefinição de senha feita com sucesso.',
                'dataMessage' => $result[1],
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'message' => 'Erro, nenhum CPF/CNPJ encontrado.',
        );
        return new WP_REST_Response($response, 500);
    }

    /**
     * Display the forgot password view.
     *
     * @return string HTML output for the forgot password view.
     */
    public function forgotPasswordShow()
    {
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/auth/ForgotPasswordAuthView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}
