<?php
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class UserController
{
    private $userService;
    private $textProcessor;

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
        $cpf = $request->get_param('cpf');


        if (!empty($avatar_file)) {
            $avatar_id = $this->userService->handleAvatarUpload($avatar_file, $post_id);
        }

        $meta_fields = [
            'billing_first_name' => $name,
            'billing_phone' => $phone,
            'billing_cpf' => $cpf,
        ];

        if ($role == 'coach' || $role == 'health-pro' || $role == 'administrator' || $role == 'training') {
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
     * Display user details and related information.
     *
     * @return string HTML output for displaying user details.
     */
    public function show()
    {
        $user_id = get_current_user_id();

        if (!is_user_logged_in()) {
            wp_redirect(site_url('/login', 'https'));
            exit;
        }
        $openPix = $this->openPixShow();
        $orders = $this->getOrderId($user_id);
        $expireds = $this->userExpiredData();
        $userExpireds = $this->getUserExpired();
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/user/UserView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * Display the user sign-in form.
     *
     * @return string HTML output for the user sign-in form.
     */
    public function signinUserShow()
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

    /**
     * Get the latest orders for a user.
     *
     * @param int $id The ID of the user.
     * @return mixed The latest orders for the user.
     */
    public function getOrderId($id)
    {
        return $this->userService->getLatestOrders($id);
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


    public function orderRefunded($request){

        $order_id = $request->get_param('order_id');

        $result = $this->userService->orderRefunded($order_id);


        if ($result) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Pedido de reembolso foi enviado.',
            );

            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível fazer o reembolso.',
        );
        return new WP_REST_Response($response, 500);
    }

    function userReembolsoWooShow() {
        ob_start();
        $user_id = get_current_user_id();
        $orders = $this->getOrderId($user_id);
        require_once plugin_dir_path(__FILE__) . '../views/user/UserReembolsoView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }    
    
    public function openPixShow(){
        return $this->userService->openPixShow();
    }

    public function urlCheckout()
    {
        WC()->cart->empty_cart();
        
        $product_id = get_the_ID();

        $checkout_url = wc_get_checkout_url();

        $checkout_link = esc_url(add_query_arg(
            array(
                'add-to-cart' => $product_id,
                'quantity' => 1,
            ),
            $checkout_url
        ));

        return $checkout_link;
    }

}