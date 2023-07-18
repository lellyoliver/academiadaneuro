<?php

require_once plugin_dir_path(__FILE__) . 'controllers/UserController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/AuthController.php';


$userController = new UserController();
$authController = new AuthController();


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

add_action('rest_api_init', function () use ($authController) {
    register_rest_route('adn-plugin/v1', '/login', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($authController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $authController->processLogin($request);
        },
    ));
});

// add_action('init', function () use ($authController) {
//     if (isset($_POST['login-submit'])) {
//         $authController->processLogin($_POST);
//     }
// });


add_shortcode('register-user', array($userController, 'show'));
add_shortcode('login-user', array($authController, 'show'));

