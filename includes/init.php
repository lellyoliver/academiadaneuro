<?php

require_once plugin_dir_path(__FILE__) . 'controllers/UserController.php';



$userController = new UserController();


add_action('rest_api_init', function () use ($userController) {
    register_rest_route('adn-plugin/v1', '/users', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userController->create($request);
        },
    ));
});




add_shortcode('register-user', array($userController, 'show'));


