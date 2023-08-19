<?php
require_once plugin_dir_path(__FILE__) . '../services/UserRelatedService.php';

class UserRelatedController
{
    private $userRelatedService;

    public function __construct()
    {
        $this->userRelatedService = new UserRelatedService();
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
        $connected_user = $request->get_param('connected_user');
        $description = $request->get_param('description');

        $meta_fields = [
            'billing_first_name' => $name,
            'billing_phone' => $phone,
            'billing_postcode' => $cep,
            'billing_address_1' => $address,
            'billing_state' => $states,
            'billing_city' => $city,
        ];

        $user_id = $this->userRelatedService->createUser($name, $email, $billing_data, $user_role, $password, $description);

        if ($user_id) {
            $meta = $this->userRelatedService->updateMetaUser($meta_fields, $user_id);
            $user_related = $this->userRelatedService->createRelatedUser($user_id, $connected_user); // Passa o ID do usuário atual);
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
        $password = $request->get_param('password');
        $phone = $request->get_param('phone');
        $cep = $request->get_param('cep');
        $address = $request->get_param('address');
        $states = $request->get_param('states');
        $city = $request->get_param('city');
        $description = $request->get_param('description');
        $email = $request->get_param('email');


        $meta_fields = [
            'billing_first_name' => $name,
            'user_pass' => $password,
            'billing_phone' => $phone,
            'billing_postcode' => $cep,
            'billing_address_1' => $address,
            'billing_state' => $states,
            'billing_city' => $city,
            'description' => $description,
        ];

        $updated = $this->userRelatedService->updateUser($name, $email, $user_id, $password, $description);
        
        $meta = $this->userRelatedService->updateMetaUser($meta_fields, $user_id);

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
     * Update user data based on the provided data.
     *
     * @param WP_REST_Request $request The REST request containing updated user data.
     * @return WP_REST_Response The REST response with the result of the operation.
     */
    public function delete($id)
    {
        $deleted = $this->userRelatedService->deleteUser($id);

        if ($deleted) {

            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Usuário excluído com sucesso',
                'user_id' => $id,
            );
            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível excluir o usuário',
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
        if (!is_user_logged_in()) {
            wp_redirect('/academiadaneurociencia/404/');
            exit;
        }

        $listUser = $this->getListRelated();

        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/users/UserRelatedView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * Get the list of related users for the current user.
     *
     * @return array The list of related users.
     */
    public function getListRelated()
    {
        $current_user_id = get_current_user_id();

        $list = $this->userRelatedService->listUserRelated($current_user_id);

        return $list;
    }

    /**
     * Get user details by ID.
     *
     * @param int $id The ID of the user.
     * @return array|WP_Error The user details or an error response.
     */
    public function getUserId($id)
    {
        return $user = $this->userRelatedService->getUserById($id);
    }
}