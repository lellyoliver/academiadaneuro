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
        $terms_and_services = $request->get_param('termsAndServices');

        $user_data = array(
            'name' => $name,
            'billing_data' => $billing_data,
            'email' => $email,
            'city' => $city,
            'phone' => $phone,
            'role' => $user_role,
            'password' => $password,
            'termsAndServices' => $terms_and_services,
        );

        $user_id = $this->userService->createUser($user_data);

        if ($user_id) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Usuário criado com sucesso',
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
        $password = $request->get_param('user_pass');
        $avatar_file = $request->get_file_params('avatar_file');
        $post_id = $request->get_param('post_id');
        $role = $request->get_param('role');

        if (!empty($avatar_file)) {
            $avatar_id = $this->userService->handleAvatarUpload($avatar_file, $post_id);
        }

        $meta_fields = [
            'billing_first_name' => $name,
            'billing_phone' => $phone,
        ];

        if ($role == 'coach' || $role == 'health-pro' || $role == 'administrator') {
            $meta_fields['billing_postcode'] = $cep;
            $meta_fields['billing_address_1'] = $address;
            $meta_fields['billing_state'] = $states;
            $meta_fields['billing_city'] = $city;
        }

        if ($avatar_id) {
            $meta_fields['billing_avatar'] = $avatar_id;
        }

        $updated = $this->userService->updateUser($name, $email, $password, $user_id);

        $meta = $this->userService->updateMetaUser($meta_fields, $user_id);

        if ($updated && $meta) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Usuário atualizado com sucesso',
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível atualizar o usuário',
        );
        return new WP_REST_Response($response, 500);
    }

    /**
     * Update user data based on the provided data.
     *
     * @param WP_REST_Request $request The REST request containing updated user data.
     * @return WP_REST_Response The REST response with the result of the operation.
     */
    // public function updateNewOrder($request)
    // {
    //     $name = $request->get_param('name');
    //     $phone = $request->get_param('phone');
    //     $city = $request->get_param('city');
    //     $email = $request->get_param('email');
    //     $password = $request->get_param('user_pass');
    //     $billing_data = $request->get_param('billing_data');
    //     $user_id = $request->get_param('user_id');
        
    //     $meta_fields = [
    //         'billing_first_name' => $name,
    //         'billing_phone' => $phone,
    //         'billing_city' => $city,
    //     ];

    //     $meta_delete = $this->userService->deleteUserMetaEntries($user_id);

    //     $updated = $this->userService->updateUserNewOrder($name, $billing_data, $email, $password, $user_id);

    //     $meta = $this->userService->updateMetaUser($meta_fields, $user_id);

    //     if ($updated && $meta) {
    //         $response = array(
    //             'status' => 'sucesso',
    //             'mensagem' => 'Usuário atualizado com sucesso',
    //             'metas' => $meta,
    //             'updated' => $updated,
    //         );
    //         return new WP_REST_Response($response, 200);
    //     }

    //     $response = array(
    //         'status' => 'erro',
    //         'mensagem' => 'Não foi possível atualizar o usuário',
    //     );
    //     return new WP_REST_Response($response, 500);
    // }


    public function show()
    {
        $user_id = get_current_user_id();

        if (!is_user_logged_in()) {
            wp_redirect(site_url('/login', 'https'));
            exit;
        }

        $orders = $this->getOrderId($user_id);
        $expireds = $this->userExpiredData();
        $userExpireds = $this->getUserExpired();
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/user/UserView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function signinUserShow()
    {
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/user/UserCreateView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;

    }

    public function newOrderUserShow()
    {
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/user/UserNewOrderView.php';
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

    public function userExpiredData()
    {
        return $this->userService->userExpiredData();
    }

    public function getUserExpired(){
        return $this->userService->getUserExpired();
    }
}
