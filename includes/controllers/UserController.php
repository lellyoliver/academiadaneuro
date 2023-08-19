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
     * Display the user registration form.
     *
     * @return string The HTML/PHP content of the user registration form.
     */

    public function show()
    {
        if (is_page(18)) {
            if (!is_user_logged_in()) {
                wp_redirect('/academiadaneurociencia/404/');
                exit;
            }
        }
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/users/UserView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
