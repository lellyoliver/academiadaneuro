<?php
require_once plugin_dir_path(__FILE__) . '../services/UserRelatedService.php';
require_once plugin_dir_path(__FILE__) . '../services/UserService.php';


class UserRelatedController
{
    private $userRelatedService;
    private $userService;


    public function __construct()
    {
        $this->userRelatedService = new UserRelatedService();
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
        $phone = $request->get_param('phone');
        $connected_user = $request->get_param('connected_user');
        $description = $request->get_param('description');

        $user_data = array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'description' => $description,
        );

        $user_id = $this->userRelatedService->createUser($user_data);

        if ($user_id) {
            $user_related = $this->userRelatedService->createRelatedUser($user_id, $connected_user); // Passa o ID do usuário atual);
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
        $name = $request->get_param('nameUpdate');
        $password = $request->get_param('passwordUpdate');
        $phone = $request->get_param('phoneUpdate');
        $description = $request->get_param('descriptionUpdate');
        $email = $request->get_param('emailUpdate');

        $meta_fields = [
            'billing_first_name' => $name,
            'user_pass' => $password,
            'billing_phone' => $phone,
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
            wp_redirect(site_url('/login', 'https'));
            exit;
        }

        $expired = $this->userExpiredData();
        $listUser = $this->getListRelated();
        $getUser = $this->getListedUserRelated();
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/userRelated/UserRelatedView.php';
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

    // public function can_register_new_user()
    // {
    //     $user_can_register = get_user_meta(get_current_user_id(), 'can_register_users', true);

    //     return $user_can_register;
    // }

    public function getListedUserRelated()
    {
        $array = $this->getListRelated();
        $getUser = [];

        foreach ($array as $user) {
            $id = $user->ID;
            $getUser[] = $this->getUserID($id);
        }

        return $getUser;
    }

    public function userExpiredData()
    {
        return $this->userRelatedService->userExpiredData();
    }

}
