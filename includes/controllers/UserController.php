<?php
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->textProcessor = new TextProcessor();
    }

    /**
     * Create a new user based on the provided data.
     *
     * @param WP_REST_Request $request The REST request containing user data.
     * @return WP_REST_Response The REST response with the result of the operation.
     */
    public function create($request)
    {

        $name = $request->get_param('name');
        $billing_data = $request->get_param('billing_data');
        $email = $request->get_param('email');
        $city = $request->get_param('city');
        $phone = $request->get_param('phone');
        $user_role = $request->get_param('role');
        $password = $request->get_param('password');
        // $termsAndServices = $request->get_param('termsAndServices');

        $fields = [
            'billing_first_name' => $name,
            'billing_phone' => $phone,
            'billing_address_1' => $address,
            'billing_city' => $city,
        ];

        $user_name = $this->textProcessor->sanitizeText($billing_data);

        $user_id = $this->userService->createUser($name, $email, $billing_data, $user_role, $password);

        if ($user_id) {
            $meta_fields = $this->userService->updateMetaUser($fields, $user_id);
            $sign = singnonUser($user_name, $password);
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Usuário criado com sucesso',
                'user_id' => $user_id,
                'fields' => $meta_fields,
                'Auth' => $sign,
            );

            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível criar o usuário',
        );
        return new WP_REST_Response($response, 500);
    }

    /**
     * Update user data based on the provided data.
     *
     * @param WP_REST_Request $request The REST request containing updated user data.
     * @return WP_REST_Response The REST response with the result of the operation.
     */
    public function update($request)
    {
        $user_id = $request->get_param('user_id');
        $name = $request->get_param('name');
        $phone = $request->get_param('phone');
        $cep = $request->get_param('cep');
        $address = $request->get_param('address');
        $states = $request->get_param('states');
        $city = $request->get_param('city');
        $email = $request->get_param('email');
        $avatar_file = $request->get_file_params('avatar_file');
        $post_id = $request->get_param('post_id');

        if (!empty($avatar_file)) {
            $avatar_id = $this->userService->handleAvatarUpload($avatar_file, $post_id, $user_id);
        }

        $user = get_userdata($user_id);

        // Verificar as funções do usuário e decidir se enviar campos de metadados
        if (in_array('health-pro', $user->roles) && in_array('Coach', $user->roles) && in_array('administrator', $user->roles)) {
            $meta_fields = [
                'billing_first_name' => $name,
                'billing_phone' => $phone,
                'billing_postcode' => $cep,
                'billing_address_1' => $address,
                'billing_state' => $states,
                'billing_city' => $city,
                'billing_avatar' => $avatar_id,
            ];
        } else {
            $meta_fields = [
                'billing_first_name' => $name,
                'billing_phone' => $phone,
                'billing_avatar' => $avatar_id,
            ];
        }

        $updated = $this->userService->updateUser($name, $email, $user_id);

        $meta = $this->userService->updateMetaUser($meta_fields, $user_id);

        if ($updated) {
            // Logando o conteúdo de $avatar_file
            if (is_array($avatar_file) && !empty($avatar_file)) {
                error_log('Avatar File: ' . print_r($avatar_file, true));
            } else {
                error_log('Avatar File is empty or not an array');
            }

            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Usuário atualizado com sucesso',
                'user_id' => $user_id,
                'fields' => $meta_fields,
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível atualizar o usuário',
        );
        return new WP_REST_Response($response, 500);
    }

    public function show()
    {
        $user_id = get_current_user_id();

        if (!is_user_logged_in()) {
            wp_redirect('/academiadaneurociencia/404/');
            exit;
        }

        $orders = $this->getOrderId($user_id);
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/user/UserView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function signinUser()
    {
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/user/UserCreateView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;

    }

    /**
     * Get user details by ID.
     *
     * @param int $id The ID of the user.
     * @return array|WP_Error The user details or an error response.
     */
    public function getUserId($id)
    {
        return $user = $this->userService->getUserById($id);
    }

    public function getOrderId($id)
    {
        return $user = $this->userService->getLatestOrders($id);
    }

    public function singnonUser($user_name, $password)
    {
        // Autenticar o usuário recém-criado
        $user = array(
            'user_login' => $user_name,
            'user_password' => $password,
            'remember' => true,
        );

        $user = wp_signon($user, false);
    }

}
