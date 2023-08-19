<?php

require_once plugin_dir_path(__FILE__) . 'controllers/UserController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/UserRelatedController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/DashboardController.php';


$userController = new UserController();
$userRelatedController = new UserRelatedController();
$dashboardController = new DashboardController();

add_action('rest_api_init', function () use ($userController) {
    register_rest_route('adn-plugin/v1', '/users', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userController->create($request);
        },
        'permission_callback' => '__return_true'
    ));
});

add_action('rest_api_init', function () use ($userRelatedController) {
    register_rest_route('adn-plugin/v1', '/users-related', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userRelatedController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userRelatedController->create($request);
        },
        'permission_callback' => '__return_true'
    ));
});

add_action('rest_api_init', function () use ($userRelatedController) {
    register_rest_route('adn-plugin/v1', '/users-related/update', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userRelatedController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userRelatedController->update($request);
        },
    ));
});

add_action('rest_api_init', function () use ($userRelatedController) {
    register_rest_route('adn-plugin/v1', '/users-related/view/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) use ($userRelatedController) {
            $id = $request->get_param('id');
            $user = $userRelatedController->getUserId($id);
            return new WP_REST_Response($user, 200);
        },
        'permission_callback' => '__return_true'
    ));
});

add_action('rest_api_init', function () use ($userRelatedController) {
    register_rest_route('adn-plugin/v1', '/users-related/delete/userDelete=(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) use ($userRelatedController) {
            $id = $request->get_param('id');
            $delete = $userRelatedController->delete($id);
            return new WP_REST_Response($delete, 200);
        },
        'permission_callback' => '__return_true'
    ));
});

add_action('rest_api_init', function () use ($dashboardController) {
    register_rest_route('adn-plugin/v1', '/dashboard', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($dashboardController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $dashboardController->create($request);
        },
        'permission_callback' => '__return_true'
    ));
});

add_shortcode('register-user', array($userController, 'show')); //Register user shortcode
add_shortcode('register-user-related', array($userRelatedController, 'show')); //Register user shortcode
add_shortcode('dashboard', array($dashboardController, 'show')); // Register user dashboard



