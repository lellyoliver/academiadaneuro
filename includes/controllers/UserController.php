<?php
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function create($request)
    {
        $name = $request->get_param('name');
        $email = $request->get_param('email');
        $password = $request->get_param('password');
        $cnpj = $request->get_param('cnpj');
        $phone = $request->get_param('phone');
        $cep = $request->get_param('cep');
        $address = $request->get_param('address');
        $number_house = $request->get_param('number_house');
        $neighborhood = $request->get_param('neighborhood');
        $city = $request->get_param('city');
        $state = $request->get_param('state');

        $fields = [
            'cnpj' => $cnpj,
            'phone' => $phone,
            'cep' => $cep,
            'address' => $address,
            'number_house' => $number_house,
            'neighborhood' => $neighborhood,
            'city' => $city,
            'state' => $state,
        ];

        $user_id = $this->userService->createUser($name, $email, $password);

        if ($user_id) {
            $meta_fields = $this->userService->updateMetaUser($fields, $user_id);
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Usuário criado com sucesso',
                'user_id' => $user_id,
                'meta' => $meta_fields,
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível criar o usuário',
        );
        return new WP_REST_Response($response, 500);
    }

    public function show()
    {
        if (is_user_logged_in()) {
            ob_start();
            require_once plugin_dir_path(__FILE__) . '../views/users/UserView.php';
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        } else {
            status_header(404);
            nocache_headers();
            include get_404_template();
            exit;
        }
    }
}
