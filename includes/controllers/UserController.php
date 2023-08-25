<?php
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
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
        $email = $request->get_param('email');
        $password = $request->get_param('password');
        $billing_data = $request->get_param('billing_data');
        $phone = $request->get_param('phone');
        $cep = $request->get_param('cep');
        $address = $request->get_param('address');
        $states = $request->get_param('states');
        $city = $request->get_param('city');
        $user_role = $request->get_param('role');
        $fields = [
            'billing_first_name' => $name,
            'billing_phone' => $phone,
            'billing_postcode' => $cep,
            'billing_address_1' => $address,
            'billing_state' => $states,
            'billing_city' => $city,
        ];

        $user_id = $this->userService->createUser($name, $email, $billing_data, $user_role, $password);

        if ($user_id) {
            $meta_fields = $this->userService->updateMetaUser($fields, $user_id);
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Usuário criado com sucesso',
                'user_id' => $user_id,
                'fields' => $meta_fields,
                'connected_user' => $user_related,
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

        $meta_fields = [
            'billing_first_name' => $name,
            'billing_phone' => $phone,
            'billing_postcode' => $cep,
            'billing_address_1' => $address,
            'billing_state' => $states,
            'billing_city' => $city,
        ];

        $updated = $this->userService->updateUser($name, $email, $user_id);

        $meta = $this->userService->updateMetaUser($meta_fields, $user_id);

        if ($updated) {

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

    /**
     * Display the user registration form.
     *
     * @return string The HTML/PHP content of the user registration form.
     */

    public function show()
    {
        $user_id = get_current_user_id();

        if (is_page(18)) {
            if (!is_user_logged_in()) {
                wp_redirect('/academiadaneurociencia/404/');
                exit;
            }
        }
        
        $orders = $this->getOrderId($user_id);
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/users/UserView.php';
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
}
